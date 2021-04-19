<?php


namespace App\Traits;


use App\Mail\Auth\VerifyMail;

trait Verification
{
    public function delVerifyCode()
    {
        $this->verify_code = null;
        return $this->save();
    }

    public function getVerifyCode()
    {
        return $this->verify_code;
    }

    public function hasVerifyCode()
    {
        return isset($this->verify_code);
    }

    public function isVerified()
    {
        return $this->status == self::STATUS_ACTIVE;
    }

    public function markAsVerified()
    {
        $this->status = self::STATUS_ACTIVE;
        $this->delVerifyCode();
        return $this->save();
    }
}
