<?php


namespace App\Http\Controllers\Services\Sms;


interface SmsService
{
    public function send(string $number, string $text);

    public function check(string $response);
}
