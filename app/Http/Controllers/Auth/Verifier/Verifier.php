<?php

namespace App\Http\Controllers\Auth\Verifier;

use App\Contracts\HasEmail;
use App\Contracts\HasPhone;
use App\Contracts\HasVerifySource;
use App\Http\Controllers\Controller;
use App\Mail\Auth\VerifyMail;
use App\Models\User;
use Carbon\Carbon;

class Verifier extends Controller
{
    protected $user = null;

    public function getVerifiedUser(): HasVerifySource
    {
        if($this->user instanceof HasVerifySource and $this->user->isVerified()){
            return $this->user;
        }
    }

    public function sendVerifyCode(HasVerifySource $user, string $source)
    {
        $this->user = $user;

        if($source === "email" and $this->user instanceof HasEmail and $this->user->hasEmail()){
            $this->setEmailVerifyCode();
            $this->user->sendToEmail(new VerifyMail($this->user->getVerifyCode()));
        }elseif($source === "phone" and $this->user instanceof HasPhone and $this->user->hasPhone()){
            $this->setPhoneVerifyCode();
            $this->user->sendToPhone($this->user->getVerifyCode());
        }
    }

    public function resendVerifyCode(HasVerifySource $user)
    {
        $this->sendVerifyCode($user, $this->determineSource($user->getVerifyCode()));
    }

    public function verifyUser($code): bool
    {
        $this->setUser($code);
        if($this->user){
            if($this->checkExpired())
            {
                $source = $this->determineSource($code);
                $this->markUserAsVerify($source);
                return true;
            }
            $this->user->delVerifyExpired();
            $this->user->delVerifyCode();
        }
        return false;
    }

    protected function determineSource($code): string
    {

        if(strpos($code, 'P-') == '0'){
            return 'phone';
        }
        if(strpos($code, 'E-') == '0'){
            return 'email';
        }
    }

    protected function markUserAsVerify(string $source)
    {
        if($this->user instanceof HasVerifySource){
            $this->user->verify();
        }
        if($source === 'phone' and $this->user instanceof HasPhone){
            $this->user->confirmPhone();
        }
        if($source === 'email' and $this->user instanceof HasEmail){
            $this->user->confirmEmail();
        }
    }

    protected function setEmailVerifyCode()
    {
        $this->user->setVerifyCode($this->generateEmailCode());
        $this->user->setVerifyExpired();
    }

    protected function setPhoneVerifyCode()
    {
        $this->user->setVerifyCode($this->generatePhoneCode());
        $this->user->setVerifyExpired();
    }

    protected function generateEmailCode(): string
    {
        $prefix = 'E-';
        do {
            $code = $this->generateCode($prefix);
        } while ((new $this->user)->where('verify_code', $code)->exists());
        return $code;
    }

    protected function generatePhoneCode(): string
    {
        $prefix = 'P-';
        do {
            $code = $this->generateCode($prefix);
        } while ((new $this->user)->where('verify_code', $code)->exists());
        return $code;
    }

    protected function generateCode(string $prefix): string
    {
        return $prefix . random_int(10000, 99999);
    }

    protected function checkExpired(): bool
    {
        return Carbon::now()->diffInSeconds($this->user->getVerifyExpired()) < 10;
    }

    protected function setUser($code)
    {
        if (User::where('verify_code', $code)->count() == 1) {
            $user =  User::where('verify_code', $code)->first();
            if($user instanceof HasVerifySource){
                $this->user = $user;
            }
        }
    }
}
