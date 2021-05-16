<?php


namespace App\Http\Controllers\Auth\Verifier;


use App\Contracts\HasEmail;
use App\Contracts\HasPhone;
use App\Contracts\HasVerifySource;
use App\Http\Controllers\Controller;
use App\Mail\Auth\VerifyMail;

class Verifier extends Controller
{
    protected $user;
    protected $source;

    public function __construct(HasVerifySource $user, string $source)
    {
        $this->user = $user;
        $this->source = $source;
    }

    public function sendVerifyCode()
    {
        if($this->source === "email" and $this->user instanceof HasEmail and $this->user->hasEmail()){
            $this->setEmailVerifyCode();
            $this->user->sendToEmail(new VerifyMail($this->user->getVerifyCode()));
        }elseif($this->source === "phone" and $this->user instanceof HasPhone and $this->user->hasPhone()){
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
}
