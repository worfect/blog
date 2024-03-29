<?php

declare(strict_types=1);

namespace App\Contracts;

interface HasVerifySource
{
    public function setVerifyCode(string $code);

    public function getVerifyCode();

    public function delVerifyCode();

    public function setVerifyExpired();

    public function checkVerifyExpired();

    public function getVerifyExpired();

    public function delVerifyExpired();
}
