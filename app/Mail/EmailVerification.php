<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;

class EmailVerification extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $opts; //array of kv


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $opts)
    {
        $this->user = $user;
        $this->opts = $opts;
        // Log::debug(print_r($opts,true));
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.verify_email')
        ->with(['verify_email_token' => $this->user->verify_email_token,
                'from'=>$this->opts['from']]);
    }
}
