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

    public function getVerifyExpired()
    {
        return $this->expired_token;
    }

    public function delVerifyExpired()
    {
        $this->expired_token = null;
        $this->save();
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
}
