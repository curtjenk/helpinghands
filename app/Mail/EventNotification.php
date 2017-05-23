<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App;
use DB;
use Log;

class EventNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
    * The order instance.
    *
    * @var Event
    */
   public $event;
   public $notify_user;
   public $content;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($event, $notify_user, $content)
    {
        $this->event = $event;
        $this->notify_user = $notify_user;
        $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'Note regarding '.$this->event->subject;
        Log::debug('notify '.$this->notify_user->email);

        return $this->subject($subject)
            ->view('emails.event.notification');
    }
}
