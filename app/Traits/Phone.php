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
        return $this->phone;
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

    public function confirmPhone()
    {
        $this->phone_confirmed = true;
        return $this->save();
    }
}
