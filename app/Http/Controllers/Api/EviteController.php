<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Common\Inputs;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Mail\Evite;
use Auth;
use App;
use DB;
use Log;

class EviteController extends Controller
{
    /**
     * [save_response description]
     * @param  [type]  $token [description]
     * @return {[type]        [description]
     */
    public function response_yes($event_id, $user_id, $token)
    {
        $user = App\User::findOrFail($user_id);
        $event = App\Event::findOrFail($event_id);
        Log::debug("1-Response yes: event= ".$event_id." user=".$user_id." token=".$token);
        Log::debug("2-Response yes: event subject= ".$event->subject);
        Log::debug("3-Response yes: user name= ".$user->name);
        $resp = $this->getResponseModel($event_id, $user_id, $token);
        if(empty($resp->id)) {
            $resp = $this->getResponseModel($event_id, $user_id, null);
        }
        if(!isset($resp)) {
            Log::debug('0-Response yes: failed: No evite sent to'.$user->name);
            abort(400, "No evite sent for $user->email");
        }

        $num_signups = App\Response::where('event_id', $event_id)
            ->where('helping', true)->get()->count();
        Log::debug("Num signups already = $num_signups");
        if($event->signup_limit > 0 && $num_signups == $event->signup_limit){
            Log::debug('limit reached '.$user->name.' '.$event->subject);
            Mail::to($user)->queue(new Evite($event, $user, $resp, ['confirm'=>'limit_reached']));
            return view('emails.evite.limit_reached',
                ['event'=>$event,
                 'user'=>$user]);
        }

        $resp->helping = true;
        $resp->save();

        Log::debug('X-Response yes: send confirmation email '.$user->name);
        $invitee = ['user' => $user,
                     'firstTime' => false,
                     'resp' => $resp];
        Mail::to($user)->queue(new Evite($event, $invitee, ['confirm'=>1]));
        return view('emails.evite.confirm_yes',
            ['event'=>$event,
             'user'=>$user]);
    }


    public function response_no($event_id, $user_id, $token)
    {
        $user = App\User::findOrFail($user_id);
        $event = App\Event::findOrFail($event_id);
        Log::debug("1-Response NO: event= ".$event_id." user=".$user_id." token=".$token);
        Log::debug("2-Response NO: event subject= ".$event->subject);
        Log::debug("3-Response NO: user name= ".$user->name);
        $resp = $this->getResponseModel($event_id, $user_id, $token);
        if(empty($resp->id)) {
            $resp = $this->getResponseModel($event_id, $user_id, null);
        }
        if(empty($resp->id)) {
            Log::debug('0-Response NO: failed: No evite sent '.$user->name . ' eventid='.$event_id . ' userid='.$user_id. ' token='.$token);
            abort(400, "No evite sent for $user->email");
        }
        if ($resp->helping != null ||
            $resp->helping==0 || $resp->helping==false ||
            $resp->helping==1 || $resp->helping==true){
            //already responded
            Log::debug('?-Response NO: already responded! '.$user->name);
            return view('emails.evite.confirm_no',
                ['event'=>$event,
                 'user'=>$user]);
        }
        $resp->helping = false;
        $resp->save();
        Log::debug('X-Response NO: send confirmation email '.$user->name);
        $invitee = ['user' => $user,
                    'firstTime' => false,
                    'resp' => $resp];
        Mail::to($user)->queue(new Evite($event, $invitee, ['confirm'=>0]));
        return view('emails.evite.confirm_no',
            ['event'=>$event,
             'user'=>$user]);
    }

    private function getResponseModel($event_id, $user_id, $token=null)
    {
        if (isset($token)) {
            return App\Response::where('token', $token)
                ->where('event_id',$event_id)
                ->where('user_id',$user_id)
                ->first();
        } else {
            return App\Response::
                  where('event_id',$event_id)
                ->where('user_id',$user_id)
                ->first();
        }
    }

    /**
     * [send_evites description]
     * @param  [type] $event_id [description]
     * @return [type]            [description]
     */
    public function send_evites($event_id)
    {
        $user = Auth::user();
        $event = App\Event::findOrFail($event_id);
        $this->authorize('send-evites');
        $helpers = App\User::where('users.opt_receive_evite', true)
            ->where('users.active', true)
            ->join('organization_user', 'organization_user.user_id', '=', 'users.id')
            ->where('organization_user.organization_id', $event->organization_id)
            ->when(isset($event->team_id), function($q) use($event){
                $q->join('team_user', 'team_user.user_id', '=', 'users.id' )
                  ->where('team_user.team_id', $event->team_id);
            })
            ->get();
        //check if already reached the limit
        $num_signups = App\Response::where('event_id', $event_id)
            ->where('helping', true)->get()->count();
        if($event->signup_limit > 0 && $num_signups == $event->signup_limit){
            Log::debug('limit reached for '.$event->subject);
            return response()->json(['event'=>$event, 'num_evites'=>$cnt, 'msg'=>'Limit reached']);
        }
        //--------------------
        $cnt=0;
        $invitees = [];
        foreach($helpers as $helper)
        {
            // Log::debug("checking " . $helper->email);
            //check if already responded Yes/no
            $responded = $helper->responses()
                ->where('event_id', $event_id)
                ->first();
            //check for first time (!$responded) or resending because no response (helping ==null)
            if (!isset($responded)) {
                // Log::debug([print_r($helper->name, true), 'First evite']);
                $invitees[] = ['user' => $helper,
                               'firstTime' => true,
                               'resp' => null];
                ++$cnt;
            } else if (empty($responded->helping)) {
                // Already sent an evite, but no response .. ie, helping=null
                // Resend the evite
                // Log::debug([print_r($helper->name, true), $responded->helping, 'Resending evite']);
                $invitees[] = ['user' => $helper,
                               'firstTime' => false,
                               'resp' => $responded];
                ++$cnt;
            } else {
                // Log::debug("skip ".$helper->email);
            }
        }

        if ($cnt > 0) {
            $event->evite_sent = Carbon::now();
            $event->save();
            //Create an Evite
            App\Evite::create([
                'event_id' => $event->id,
                'organization_id' => $event->organization_id,
                'team_id' => $event->team_id,
                'user_id' => $user->id,
                'num_invitations' => $cnt,
            ]);
            foreach($invitees as $invitee) {
                Mail::to($invitee['user'])
                ->queue(new Evite($event, $invitee));
            }
        }
        Log::debug("num evites = $cnt");

        return response()->json(['event'=>$event, 'num_evites'=>$cnt]);

    }
}
