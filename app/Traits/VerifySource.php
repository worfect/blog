<?php


namespace App\Traits;

use Carbon\Carbon;

trait VerifySource
{
    public function setVerifyExpired()
    {
        $this->expired_token = Carbon::now();
        $this->save();
    }

    public function setVerifyCode(string $type)
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

    public function expectVerify()
    {
        // TODO: Implement expectVerify() method.
    }

    public function verify()
    {
        // TODO: Implement verify() method.
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

    public function delExpiredToken()
    {
        $this->expired_token = null;
        $this->save();
    }

    public function checkCode()
    {
        if(Carbon::now()->diffInMinutes($this->expired_token) > 15){
            return false;
        }
        return true;
    }
}
