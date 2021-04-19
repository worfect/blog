<?php


namespace App\Contracts;


interface MustVerify
{
    public function delVerifyCode();

    public function getVerifyCode();

    public function hasVerifyCode();

    public function isVerified();

    public function markAsVerified();
}
