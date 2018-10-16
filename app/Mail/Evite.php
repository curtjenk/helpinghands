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
   protected $firstTime;
   protected $resp;
   protected $confirm; //

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(App\Event $event, Array $userData, Array $confirm = null)
    {
        $this->event = $event;
        $this->user = $userData['user'];
        $this->firstTime = $userData['firstTime'];
        $this->resp = isset($userData['resp']) ? $userData['resp'] : null;
        if (isset($confirm)) {
            $this->confirm = $confirm['confirm'];
        } else {
            $this->confirm = null;
        }
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if (isset($this->confirm)) {
            Log::debug("Send confirmation to ".$this->user->name.' '.$this->user->email.' ('.$this->confirm.')');
            if ($this->confirm == 1) {
                return $this->subject($this->event->subject)
                    ->view('emails.evite.confirm_yes')
                    ->with([
                        'event'=>$this->event,
                        'user'=>$this->user,
                    ]);
            } else if ($this->confirm == 0){
                return $this->subject($this->event->subject)
                    ->view('emails.evite.confirm_no')
                    ->with([
                        'event'=>$this->event,
                        'user'=>$this->user,
                    ]);
            } else {
                Log::debug("Limit reached: $this->confirm");
                return $this->subject($this->event->subject)
                    ->view('emails.evite.limit_reached')
                    ->with([
                        'event'=>$this->event,
                        'user'=>$this->user,
                    ]);
            }
        }
        //check for first time (!$responded) or resending because no response (helping ==null)
        $token = '';
        if ($this->firstTime) {
            Log::debug("Send evite to ".$this->user->name.' '.$this->user->email);
            $newresp = \App\Response::create([
                'user_id'=>$this->user->id,
                'event_id'=>$this->event->id,
                'token'=>\App\Response::generateToken()
            ]);
            $token = $newresp->token;

        } else {
            Log::debug("Re-Send evite to ".$this->user->name.' '.$this->user->email);
            $token = $this->resp->token;
        }

        $type = $this->event->event_type->name;

        return $this->subject($this->event->subject)
            ->view('emails.evite.'.$type)
            ->with([
                'event'=>$this->event,
                'user'=>$this->user,
                'token'=>$token,
            ]);


    }
}
