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

    public function verifyCode($code): bool
    {
        $this->setUser($code);
        if($this->user and $this->checkExpired()){
            return true;
        }else{
            return false;
        }
    }

    public function user()
    {
        return $this->user;
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
        } while ((new $this->user)->where($this->user->getVerifyCode(), '=',  $code)->exists());
        return $code;
    }

    protected function generatePhoneCode(): string
    {
        $prefix = 'P-';
        do {
            $code = $this->generateCode($prefix);
        } while ((new $this->user)->where($this->user->getVerifyCode(), '=',  $code)->exists());
        return $code;
    }

    protected function generateCode(string $prefix): string
    {
        return $prefix . random_int(10000, 99999);
    }

    protected function checkExpired(): bool
    {
        $expired = Carbon::now()->diffInMinutes($this->user->getVerifyExpired()) > 10;
        $this->user->delVerifyExpired();
        $this->user->delVerifyCode();

        if($expired){
            return false;
        }
        return true;
    }

    protected function setUser($code)
    {
        if (User::where('verify_code', $code)->count() == 1) {
            $this->user =  User::where('verify_code', $code)->first();
        }
    }
}
