<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

class ProcessingAuthRequests extends Controller
{

    /**
     * Defines the login method and preparing the dataset for validation
     *
     * @return array
     * @var string
     */
    public function loginRequestProcessing($dataRequest)
    {
        $uniqueness = $dataRequest['uniqueness'];
        $method = $this->determiningAuthMethod($uniqueness);
        if(!$method){
            $method = 'login';
        }
        if($method == 'phone'){
            $uniqueness = $this->unificationPhoneNumber($uniqueness);
        }

        return [
            'remember' => isset($dataRequest['remember']),
            'password' => $dataRequest['password'],
            $method => $uniqueness,
        ];
    }

    /**
     * Defines the registration method and preparing the dataset for validation
     *
     * @return array
     * @var string
     */
    public function registerRequestProcessing($dataRequest)
    {
        $uniqueness = $dataRequest['uniqueness'];
        $method = $this->determiningAuthMethod($uniqueness);
        if(!$method){
            $method = 'uniqueness';
            $uniqueness = false;
        }
        if($method == 'phone'){
            $uniqueness = $this->unificationPhoneNumber($uniqueness);
        }

        return [
            'login' => $dataRequest['login'],
            'password' => $dataRequest['password'],
            'password_confirmation' => $dataRequest['password_confirmation'],
            $method => $uniqueness,
        ];
    }

    /**
     * Defines the password reset method and preparing the dataset for validation
     *
     * @return array
     * @var string
     */
    public function passwordRecoveryProcessing($dataRequest)
    {
        $uniqueness = $dataRequest['uniqueness'];
        $method = $this->determiningAuthMethod($uniqueness);
        if(!$method){
            $method = 'login';
        }
        if($method == 'phone'){
            $uniqueness = $this->unificationPhoneNumber($uniqueness);
        }

        return [
            $method => $uniqueness,
        ];

    }

    /**
     * Unifies of data from third-party resources
     *
     * @param $socialiteUser
     * @param string $provider
     * @return array
     */
    public function socialRequestProcessing($socialiteUser, string $provider) : array
    {
        return [
            'provider' => $provider,
            'provider_id' => $socialiteUser->getId(),
            'token' => $socialiteUser->token,
            'email' => $socialiteUser->getEmail(),
        ];
    }

    /**
     * Defines the authentication method
     *
     * @param $uniqueness
     * @return false|string
     */
    public function determiningAuthMethod($uniqueness)
    {
        if ($this->verifyEmail($uniqueness)) {
            return 'email';
        }
        if ($this->verifyPhoneNumber($uniqueness)) {
            return 'phone';
        }
        return false;
    }

    /**
     * Verifies the email
     *
     * @param $uniqueness
     * @return false|string
     */
    protected function verifyEmail($uniqueness)
    {
        preg_match('/\A[^@]+@([^@\.]+\.)+[^@\.]+\z/', $uniqueness, $matches);
        return $matches;
    }

    /**
     * Verifies the phone number
     *
     * @param $uniqueness
     * @return false|string
     */
    protected function verifyPhoneNumber($uniqueness)
    {
        preg_match('/^(( ?(\+ ?7)|( ?8)) ?[- (]?[ -)(]?)([ -]?[ -]?[0-9][ -)(]?[ -)(]?){9}[0-9]$/', $uniqueness, $matches);
        return $matches;
    }

    /**
     * Converts a phone number entry to 89991234567
     *
     * @param $number
     * @return false|string
     */
    public function unificationPhoneNumber($number)
    {
        $number = preg_replace('/ |-|\)|\(/', '', $number);
        return $number = preg_replace('/\+7/', '8', $number);
    }

}
