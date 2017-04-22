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
    public function response_yes($ticket_id, $user_id, $token)
    {
        $user = App\User::findOrFail($user_id);
        $ticket = App\Ticket::findOrFail($ticket_id);
        $resp = $this->getResponseModel($ticket_id, $user_id, $token);
        if(!$resp) {
            abort(400);
        }
        if ($resp->helping != null) {
            //already responded
            return;
        }
        $resp->helping = true;
        $resp->save();
        Log::debug('response_yes: send confirmation email');
        Mail::to($user)->queue(new Evite($ticket, $user, $resp));
        return view('emails.evite.confirm_yes',
            ['ticket'=>$ticket,
             'user'=>$user]);
    }

    public function response_no($ticket_id, $user_id, $token)
    {
        $user = App\User::findOrFail($user_id);
        $ticket = App\Ticket::findOrFail($ticket_id);
        $resp = $this->getResponseModel($ticket_id, $user_id, $token);
        if(!$resp) {
            abort(400);
        }
        if ($resp->helping != null) {
            //already responded
            return;
        }
        $resp->helping = false;
        $resp->save();
        Log::debug('response_no: send confirmation email');
        Mail::to($user)->queue(new Evite($ticket, $user, $resp));
        return view('emails.evite.confirm_no',
            ['ticket'=>$ticket,
             'user'=>$user]);
    }

    private function getResponseModel($ticket_id, $user_id, $token)
    {
        return App\Response::where('token', $token)
            ->where('ticket_id',$ticket_id)
            ->where('user_id',$user_id)
            ->first();
    }

    /**
     * [send_evites description]
     * @param  [type] $ticket_id [description]
     * @return [type]            [description]
     */
    public function send_evites($ticket_id)
    {
        $user = Auth::user();
        $ticket = App\Ticket::findOrFail($ticket_id);
        $this->authorize('send-evites');
        $helpers = App\User::where('users.opt_receive_evite', true)
            ->where('users.role_id', '!=', 1)
            ->where('users.organization_id', $ticket->organization_id)
            ->get();
        $cnt=0;
        foreach($helpers as $helper)
        {
            $evites = $helper->responses()
                ->where('ticket_id', $ticket_id)
                ->get();
            $numEvites = $evites->count();
            $numResponses = $evites->filter(function($el) {
                        return isset($el->helping);
                    })->count();
            if ($numEvites < 8 && $numResponses == 0) {
                ++$cnt;
                Mail::to($helper)->queue(new Evite($ticket, $helper));
            }
        }
        if ($cnt > 0) {
            $ticket->evite_sent = Carbon::now();
            $ticket->save();
        }
        Log::debug("num evites = $cnt");
        return view('event.show', [
            'event'=>$ticket,
            'num_evites'=>$cnt,
        ]);

    }
}
