<?php


namespace App\Contracts;


interface MustVerify
{
    public function isVerified();

    public function hasVerifyToken();

    public function getVerifyToken();

    public function sendVerifyCodeToPhone();

    public function sendVerifyCodeToEmail();

    public function markAsVerified();
}
