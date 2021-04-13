<?php


namespace App\Listeners;


use App\Contracts\MustVerifyPhone;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class SendVerificationNotification
{
    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        if ( ! $event->user->isVerified()) {
            if($event->user instanceof MustVerifyEmail and $event->user->getEmailForVerification()){
                $event->user->sendEmailVerificationNotification();
            }
            if($event->user instanceof MustVerifyPhone and $event->user->getPhoneForVerification()){
                $event->user->sendPhoneVerificationNotification();
            }
        }
    }
}
