<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App;
use DB;
use Log;

class Evite extends Mailable
{
    use Queueable, SerializesModels;

    /**
    * The order instance.
    *
    * @var Ticket
    */
   protected $ticket;
   protected $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(App\Ticket $ticket, App\User $user)
    {
        $this->ticket = $ticket;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        Log::debug("ticket:".$this->ticket->id." to: ". $this->user->name. " email: " . $this->user->email);
        $response = \App\Response::create([
            'user_id'=>$this->user->id,
            'ticket_id'=>$this->ticket->id,
            'token'=>\App\Response::generateToken()
        ]);
        return $this->subject($this->ticket->subject)
            ->view('emails.evite.invite')
            ->with([
                'ticket'=>$this->ticket,
                'user'=>$this->user,
                'token'=>$response->token,
            ]);
    }
}
