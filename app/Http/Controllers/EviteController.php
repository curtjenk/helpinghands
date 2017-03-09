<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Evite;
use Auth;
use App;
use DB;

class EviteController extends Controller
{
    static public function send_evites($ticket_id)
    {
        //$user = Auth::user();
        $ticket = App\Ticket::findOrFail($ticket_id);

        $helpers = App\User::select('users.*')
            ->leftJoin('responses', function($join) use($ticket){
                $join->on('responses.user_id', '=', 'users.id')
                ->where('responses.ticket_id', '=', $ticket->id);
            })
            ->whereNull('responses.user_id')
            ->where('users.role_id', '!=', 1)
            ->get();
        foreach($helpers as $helper)
        {
            Mail::to($helper)->queue(new Evite($ticket, $helper));
            echo "\n".$helper->name;
        }
        //dump($helpers);
    }
}
