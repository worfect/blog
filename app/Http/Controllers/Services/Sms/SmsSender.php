<?php

namespace App\Http\Controllers\Services\Sms;

use Illuminate\Support\Facades\Log;

class SmsSender
{
    protected $service;

    public function __construct(SmsService $service)
    {
        $this->service = $service;
    }

    public function send($number, $text)
    {
        $response = $this->service->send($number, $text);
        $err = $this->service->check($response);
        if(is_array($err)){
            $this->logError($err);
            if(get_class($this->service) == config('services.sms.main')){
                $service = config('services.sms.reserve');
                (new SmsSender(new $service))->send($number,$text);
            }
        }
    }

    public function balance()
    {
        $response = $this->service->balance();
        $err = $this->service->check($response);
        if(is_array($err)){
            $this->logError($err);
        }
    }

    protected function logError(array $errorData)
    {
        Log::error('Error sending SMS registration message', $errorData);
    }
}
