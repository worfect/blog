<?php


namespace App\Traits;


use App\Mail\Auth\VerifyMail;
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
        $this->email_verified = true;
        $this->verify_code = null;
        return $this->save();
    }

    public function sendToEmail(Mailable $mail)
    {
        Mail::to($this->email)->send($mail);
    }

    public function setEmailVerifyCode()
    {
        do {
            $this->verify_code = 'E-' . random_int(10000, 99999);
        } while ((new $this)->where('verify_code', '=',  $this->verify_code)->exists());
        return $this->save();
    }


    public function hasEmailVerifyCode(): bool
    {
        return str_contains ($this->verify_code, 'E-');
    }

    public function sendVerifyCodeToEmail()
    {
        $this->setEmailVerifyCode();
        $this->sendToEmail(new VerifyMail($this->login, $this->verify_code));
    }

}
