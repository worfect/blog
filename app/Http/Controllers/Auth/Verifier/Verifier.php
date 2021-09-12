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
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Return instance of the verified user from the verifier field, if present
     *
     * @return HasVerifySource|null
     */
    public function getVerifiedUser()
    {
        return $this->user->isVerified()
                ? $this->user
                : null;
    }

    /**
     * Generates and sends the code in the chosen way
     *
     * @param string $source
     *
     * @return void
     */
    public function sendVerifyCode(string $source)
    {
        if($source === "email" and $this->user instanceof HasEmail and $this->user->hasEmail()){
            $this->setEmailVerifyCode();
            $this->user->sendToEmail(new VerifyMail($this->user->getVerifyCode()));
        }elseif($source === "phone" and $this->user instanceof HasPhone and $this->user->hasPhone()){
            $this->setPhoneVerifyCode();
            $this->user->sendToPhone($this->user->getVerifyCode());
        }
    }

    /**
     * Replaces the code with a new code of the same type
     *
     * @return void
     */
    public function resendVerifyCode()
    {
        $this->sendVerifyCode($this->determineSource());
    }

    /**
     * User verification
     *
     * @param string $code
     * @return bool
     */
    public function verifyUser(string $code): bool
    {
        if($this->user->checkVerifyExpired() and $this->checkCodeMatch($code)){
            $source = $this->determineSource();
            $this->markUserAsVerify($source);
            $this->user->delVerifyExpired();
            $this->user->delVerifyCode();
            return true;
        }
        return false;
    }

    /**
     * Defines the verification method by code
     *
     * @return string
     */
    protected function determineSource(): string
    {
        if(stristr($this->user->getVerifyCode(), 'P-')){
            return 'phone';
        }
        if(stristr($this->user->getVerifyCode(), 'E-')){
            return 'email';
        }
        return '';
    }

    /**
     * Marks the user as verified
     *
     * @param string $source
     * @return void
     */
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
        return  $this->generateCode($prefix);
    }

    protected function generatePhoneCode(): string
    {
        $prefix = 'P-';
        return  $this->generateCode($prefix);
    }

    protected function generateCode(string $prefix): string
    {
        return $prefix . random_int(10000, 99999);
    }

    protected function checkCodeMatch($code): bool
    {
        return $this->user->getVerifyCode() == $code;
    }
}
