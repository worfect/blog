<?php


namespace App\Http\Controllers\Services\Sms;

interface SmsService
{
    public function send(string $number, string $text): string;

    public function balance(): string;

    public function check(string $response);
}
