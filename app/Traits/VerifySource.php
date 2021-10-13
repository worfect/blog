<?php


namespace App\Traits;

use Carbon\Carbon;

trait VerifySource
{
    public function setVerifyCode(string $code)
    {
        $this->verify_code = $code;
        return $this->save();
    }

    public function getVerifyCode()
    {
        return $this->verify_code;
    }

    public function delVerifyCode()
    {
        $this->verify_code = null;
        return $this->save();
    }

    public function setVerifyExpired()
    {
        $this->expired_token = Carbon::now();
        $this->save();
    }

    public function checkVerifyExpired(): bool
    {
        return $this->expired_token && (Carbon::now()->diffInMinutes($this->getVerifyExpired()) < 10);
    }

    public function getVerifyExpired()
    {
        return $this->expired_token;
    }

    public function delVerifyExpired()
    {
        $this->expired_token = null;
        $this->save();
    }

//    public function verify()
//    {
//        $this->status = self::STATUS_ACTIVE;
//    }
//
//    public function isVerified()
//    {
//        return $this->status == self::STATUS_ACTIVE;
//    }
//
//    public function unverified()
//    {
//        $this->status = self::STATUS_WAIT;
//    }
}
