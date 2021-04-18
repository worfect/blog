<?php


namespace App\Traits;


use App\Mail\Auth\VerifyMail;
use Illuminate\Support\Str;

trait Verification
{
    protected function setVerifyToken()
    {
        $this->verify_token = Str::random(5);
        return $this->save();
    }

    protected function delVerifyToken()
    {
        $this->verify_token = null;
        return $this->save();
    }

    public function getVerifyToken()
    {
        return $this->verify_token;
    }

    public function hasVerifyToken()
    {
        return isset($this->verify_token);
    }

    public function isVerified()
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    public function markAsVerified()
    {
        $this->status = self::STATUS_ACTIVE;
        $this->delVerifyToken();
        return $this->save();
    }

    public function sendVerifyCodeToEmail()
    {
        $this->setVerifyToken();
        $this->sendToEmail(new VerifyMail($this->login, $this->verify_token));
    }

    public function sendVerifyCodeToPhone()
    {
        $this->setVerifyToken();
        $this->sendToPhone($this->verify_token);
    }
}
