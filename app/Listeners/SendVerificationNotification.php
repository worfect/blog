<?php


namespace App\Listeners;

use App\Contracts\HasEmail;
use App\Contracts\HasPhone;
use App\Contracts\MustVerify;
use App\Mail\Auth\VerifyMail;
use App\Events\Registered;


class SendVerificationNotification
{
    /**
     * Handle the event.
     *
     * @param \App\Events\Registered $event
     * @return void
     */
    public function handle(Registered $event)
    {
        if($event->user instanceof MustVerify and !$event->user->isVerified()){
            if($event->user instanceof HasEmail and $event->user->hasEmail()){
                $event->user->setEmailVerifyCode();
                $event->user->sendToEmail(new VerifyMail($event->user->login, $event->user->getVerifyCode()));
            }elseif($event->user instanceof HasPhone and $event->user->hasPhone()){
                $event->user->setPhoneVerifyCode();
                $event->user->sendToPhone($event->user->getVerifyCode());
            }
        }
    }
}
