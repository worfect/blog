<?php

namespace App\Mail\Auth;


use Illuminate\Bus\Queueable;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class VerifyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $login;
    public $token;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($login, $token)
    {
        $this->token = $token;
        $this->login = $login;;
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
