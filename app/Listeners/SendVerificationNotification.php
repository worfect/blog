<?php


namespace App\Listeners;


use App\Contracts\MustVerify;
use Illuminate\Auth\Events\Registered;


class SendVerificationNotification
{
//    /**
//     * Handle the event.
//     *
//     * @param  \Illuminate\Auth\Events\Registered  $event
//     * @return void
//     */
//    public function handle(Registered $event)
//    {
//        if($event->user instanceof MustVerifyEmail and $event->user->getEmailForVerification()){
//            $event->user->sendEmailVerifyCode();
//        }
//        if($event->user instanceof MustVerifyPhone and $event->user->getPhoneForVerification()){
//            $event->user->sendPhoneVerifyCode();
//        }
//    }

    /**
     * Handle the event.
     *
     * @param  \Illuminate\Auth\Events\Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        if($event->user instanceof MustVerify and !$event->user->isVerified()){
            if($event->user->hasEmail()){
                $event->user->sendVerifyCodeToEmail();
            }elseif($event->user->hasPhone()){
                $event->user->sendVerifyCodeToPhone();
            }
        }
    }

}
