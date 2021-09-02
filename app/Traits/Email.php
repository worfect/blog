<?php


namespace App\Traits;

use Illuminate\Contracts\Mail\Mailable as MailableContract;
use Illuminate\Support\Facades\Mail;

trait Email
{
    public function setEmail(string $email)
    {
        $this->email = $email;
        return $this->save();
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function hasEmail(): bool
    {
        return isset($this->email);
    }

    public function sendToEmail(MailableContract $mail)
    {
        Mail::to($this->email)->send($mail);
    }

    public function emailConfirmed(): bool
    {
        return $this->email_confirmed;
    }

    public function confirmEmail()
    {
        $this->email_confirmed = true;
        return $this->save();
    }

    public function updateEmail($email): bool
    {
        if($this->email != $email){
            $this->email = $email;
            $this->email_confirmed = false;
        }
        return $this->save();
    }
}
