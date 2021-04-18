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
        $this->verify_token = null;
        return $this->save();
    }

    public function sendToPhone($text)
    {
        $service = config('services.sms.main');
        (new SmsSender(new $service))->send($this->phone, $text);
    }
}
