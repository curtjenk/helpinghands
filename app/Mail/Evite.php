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
   protected $resp;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(App\Ticket $ticket, App\User $user, App\Response $resp = null)
    {
        $this->ticket = $ticket;
        $this->user = $user;
        $this->resp = $resp;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->resp == null) {
            Log::debug("Send evite to ".$this->user->name);
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


        if ($this->resp->helping == true || $this->resp->helping == 1) {
            return $this->subject($this->ticket->subject)
                ->view('emails.evite.confirm_yes')
                ->with([
                    'ticket'=>$this->ticket,
                    'user'=>$this->user,
                ]);
        }

        return $this->subject($this->ticket->subject)
            ->view('emails.evite.confirm_no')
            ->with([
                'ticket'=>$this->ticket,
                'user'=>$this->user,
            ]);
    }
}
