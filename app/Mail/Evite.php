<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App;

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
        echo "\n email subject=".$this->ticket->subject;
        return $this->subject($this->ticket->subject)
            ->view('emails.evite.invite')
            ->with([
                'ticket'=>$this->ticket,
                'user'=>$this->user
            ]);
    }
}
