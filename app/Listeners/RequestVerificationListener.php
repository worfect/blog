<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Events\RequestVerification;
use App\Http\Controllers\Auth\Verifier\Verifier;

final class RequestVerificationListener
{
    public function handle(RequestVerification $event): void
    {
        $verifier = new Verifier($event->user);
        $verifier->sendVerifyCode($event->source);
    }
}
