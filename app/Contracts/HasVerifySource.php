<?php


namespace App\Contracts;

interface HasVerifySource
{
    public function setVerifyCode(string $code);

    public function getVerifyCode();

    public function setVerifyExpired();

    public function getVerifyExpired();

    public function expectVerify();

    public function isVerified();

    public function verify();

    public function checkCode();
}
