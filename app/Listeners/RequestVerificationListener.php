<?php


namespace App\Listeners;

use App\Events\RequestVerification;
use App\Http\Controllers\Auth\Verifier\Verifier;

class RequestVerificationListener
{
    /**
     * Handle the event.
     *
     * @param RequestVerification $event
     * @return void
     */
    public function handle(RequestVerification $event)
    {
        $verifier = new Verifier($event->user);
        $verifier->sendVerifyCode($event->source);
    }
}
