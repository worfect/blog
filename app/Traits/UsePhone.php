<?php

namespace App\Traits;

use App\Http\Controllers\Services\Sms\SmsSender;

trait UsePhone
{
    public function hasPhone(): bool
    {
        return isset($this->phone);
    }

    public function setPhone($phone): bool
    {
        $this->phone = $phone;
        return $this->save();
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function phoneIsVerify()
    {
        return $this->phone_verified;
    }

    public function verifyPhone()
    {
        $this->phone_verified = true;
        $this->verify_code = null;
        return $this->save();
    }

    public function sendToPhone($text)
    {
        $service = config('services.sms.main');
        (new SmsSender(new $service))->send($this->phone, $text);
    }

    public function setPhoneVerifyCode(){
        $this->verify_code = 'P-' . random_int(10000, 99999);
        return $this->save();
    }

    public function hasPhoneVerifyCode(): bool
    {
        return str_contains ($this->verify_code, 'P-');
    }

    public function sendVerifyCodeToPhone()
    {
        $this->setPhoneVerifyCode();
        $this->sendToPhone($this->getVerifyCode());
    }
}
