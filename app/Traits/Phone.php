<?php

declare(strict_types=1);

namespace App\Traits;

use App\Http\Controllers\Services\Sms\SmsSender;

trait Phone
{
    public function setPhone(int $phone)
    {
        $this->phone = $phone;
        return $this->save();
    }

    public function getPhone()
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
        return (bool)$this->phone_confirmed;
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
            $this->disableMultiFactor();
        }
        return $this->save();
    }

    public function enableMultiFactor(): bool
    {
        if($this->phoneConfirmed()){ // или отдельно? или не надо? или в контроллере?
            $this->multi_factor = true;
            return $this->save();
        }
        return true;
    }

    public function disableMultiFactor(): bool
    {
        $this->multi_factor = false;
        return $this->save();
    }

    public function isMultiFactor(): bool
    {
        return (bool) $this->multi_factor;
    }
}
