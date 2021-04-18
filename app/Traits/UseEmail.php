<?php


namespace App\Traits;


use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

trait UseEmail
{
    public function hasEmail(): bool
    {
        return isset($this->email);
    }

    public function setEmail($email): bool
    {
        $this->email = $email;
        return $this->save();
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function emailIsVerify()
    {
        return $this->email_verified;
    }

    public function verifyEmail()
    {
        $this->phone_verified = true;
        $this->verify_token = null;
        return $this->save();
    }

    public function sendToEmail(Mailable $mail)
    {
        Mail::to($this->email)->send($mail);
    }
}
