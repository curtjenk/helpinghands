<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        Log::debug("Response yes");
        $user = App\User::findOrFail($user_id);
        $event = App\Event::findOrFail($event_id);
        $resp = $this->getResponseModel($event_id, $user_id, $token);
        if(!$resp) {
            abort(400);
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

        Log::debug('response_yes: send confirmation email '.$user->name);
        Mail::to($user)->queue(new Evite($event, $user, $resp, ['confirm'=>1]));
        return view('emails.evite.confirm_yes',
            ['event'=>$event,
             'user'=>$user]);
    }



    public function response_no($event_id, $user_id, $token)
    {
        $user = App\User::findOrFail($user_id);
        $event = App\Event::findOrFail($event_id);
        $resp = $this->getResponseModel($event_id, $user_id, $token);
        if(!$resp) {
            abort(400);
        }
        if ($resp->helping != null ||
            $resp->helping==0 || $resp->helping==false ||
            $resp->helping==1 || $resp->helping==true){
            //already responded
            return;
        }
        $resp->helping = false;
        $resp->save();
        Log::debug('response_no: send confirmation email '.$user->name);
        Mail::to($user)->queue(new Evite($event, $user, $resp, ['confirm'=>0]));
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
            ->where('users.role_id', '!=', 1)
            ->where('users.organization_id', $event->organization_id)
            ->get();
        //check if already reached the limit
        $num_signups = App\Response::where('event_id', $event_id)
            ->where('helping', true)->get()->count();
        if($event->signup_limit > 0 && $num_signups == $event->signup_limit){
            Log::debug('limit reached for '.$event->subject);
            return view('event.show', [
                'event'=>$event,
                'num_evites'=>0,
                'msg'=>'Limit reached'
            ]);
        }
        //--------------------
        $cnt=0;
        foreach($helpers as $helper)
        {
            //check if already responded Yes/no
            $responded = $helper->responses()
                ->where('event_id', $event_id)
                ->first();
            //check for first time (!$responded) or resending because no response (helping ==null)
            if (!$responded || !isset($responded->helping)) {
                ++$cnt;
                Mail::to($helper)->queue(new Evite($event, $helper, $responded));
            }
        }
        if ($cnt > 0) {
            $event->evite_sent = Carbon::now();
            $event->save();
        }
        Log::debug("num evites = $cnt");
        return view('event.show', [
            'event'=>$event,
            'num_evites'=>$cnt,
        ]);

    }
}
