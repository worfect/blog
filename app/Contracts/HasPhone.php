<?php


namespace App\Contracts;


interface HasPhone
{
    public function hasPhone();

    public function setPhone($phone);

    public function getPhone();

    public function sendToPhone($text);

    public function phoneIsVerify();

    public function verifyPhone();

    public function setPhoneVerifyCode();

    public function hasPhoneVerifyCode();

    public function sendVerifyCodeToEmail();
}
