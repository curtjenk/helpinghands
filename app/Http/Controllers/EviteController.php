<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Mail\Evite;
use Auth;
use App;
use DB;

class EviteController extends Controller
{
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
        $helpers = App\User::select('users.*')
            ->leftJoin('responses', function($join) use($ticket){
                $join->on('responses.user_id', '=', 'users.id')
                ->where('responses.ticket_id', '=', $ticket->id);
            })
            ->whereNull('responses.user_id')
            ->where('users.role_id', '!=', 1)
            ->where('users.organization_id', $ticket->organization_id)
            ->get();

        $cnt=0;
        foreach($helpers as $helper)
        {
            ++$cnt;
            Mail::to($helper)->queue(new Evite($ticket, $helper));
        }
        if ($helpers->count() > 0) {
            $ticket->evite_sent = Carbon::now();
            $ticket->save();
        }

        return view('ticket.show', [
            'ticket'=>$ticket,
            'num_evites'=>$cnt,
        ]);

    }
}
