<?php


namespace App\Listeners;

use App\Events\RequestVerification;
use App\Http\Controllers\Auth\Verifier\Verifier;

class SendVerificationNotification
{
    /**
     * Handle the event.
     *
     * @param RequestVerification $event
     * @return void
     */
    public function handle(RequestVerification $event)
    {
        $verifier = new Verifier();
        $verifier->sendVerifyCode($event->user, $event->source);
    }
}
