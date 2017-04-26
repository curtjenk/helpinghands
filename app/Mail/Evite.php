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
    * @var Event
    */
   protected $event;
   protected $user;
   protected $resp;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(App\Event $event, App\User $user, App\Response $resp = null)
    {
        $this->event = $event;
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
                'event_id'=>$this->event->id,
                'token'=>\App\Response::generateToken()
            ]);
            return $this->subject($this->event->subject)
                ->view('emails.evite.invite')
                ->with([
                    'event'=>$this->event,
                    'user'=>$this->user,
                    'token'=>$response->token,
                ]);
        }


        if ($this->resp->helping == true || $this->resp->helping == 1) {
            return $this->subject($this->event->subject)
                ->view('emails.evite.confirm_yes')
                ->with([
                    'event'=>$this->event,
                    'user'=>$this->user,
                ]);
        }

        return $this->subject($this->event->subject)
            ->view('emails.evite.confirm_no')
            ->with([
                'event'=>$this->event,
                'user'=>$this->user,
            ]);
    }
}
