<?php

namespace App\Mail\Auth;


use Illuminate\Bus\Queueable;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class VerifyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $code;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($code)
    {
        $this->code = $code;;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.auth.verify')
            ->subject('Email Confirmation');
    }
}
