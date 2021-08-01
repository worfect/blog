<?php

namespace App\Traits;

use App\Http\Controllers\Services\Sms\SmsSender;

trait Phone
{
    public function setPhone(int $phone)
    {
        $this->phone = $phone;
        return $this->save();
    }

    public function getPhone(): int
    {
        return (int)$this->phone;
    }

    public function hasPhone(): bool
    {
        return isset($this->phone);
    }

    public function sendToPhone(string $text)
    {
        $service = config('services.sms.main');
        (new SmsSender(new $service))->send($this->phone, $text);
    }

    public function phoneConfirmed(): bool
    {
        return $this->phone_confirmed;
    }

    public function confirmPhone(): bool
    {
        $this->phone_confirmed = true;
        return $this->save();
    }

    public function updatePhone($phone): bool
    {
        if( $this->phone != $phone){
            $this->phone = $phone;
            $this->phone_confirmed = false;
        }
        return $this->save();
    }
}
