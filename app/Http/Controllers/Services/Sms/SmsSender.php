<?php


namespace App\Http\Controllers\Services\Sms;


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
            (new SmsSender(config('services.sms-sender.reserve')))->send($number,$text);
        }
    }

    public function status()
    {

    }

    public function balance()
    {

    }

    protected function logError(array $err)
    {
//        Monolog library
    }
}
