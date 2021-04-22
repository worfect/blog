<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\Auth\VerifyMail;
use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;


class VerificationController extends Controller
{
    use VerifiesEmails;

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }


    /**
     * Show the email verification notice.
     *
     * @param Request $request
     * @return array|Application|RedirectResponse|Redirector|string
     */
    public function show(Request $request)
    {
        return $request->user()->hasVerifyCode()
            ? view('auth.verify')->render()
            : redirect($this->redirectPath());
    }

    /**
     *
     * @param Request $request
     * @return Application|Redirector|RedirectResponse
     */
    public function myVerify(Request $request)
    {
        $code = $request->get('code');
        $user = $request->user();

        if (!$user->hasVerifyCode()) {
            return redirect($this->redirectPath());
        }

        if ($code != $user->getVerifyCode()) {
            notice('Invalid code', 'danger');
            return back();
        }

        if($user->hasPhoneVerifyCode()){
            $user->verifyPhone();
        }elseif($user->hasEmailVerifyCode()){
            $user->verifyEmail();
        }

        if (!$user->isVerified()){
            $user->markAsVerified();
        }

        notice('Verification was successful', 'success');
        return redirect($this->redirectPath());
    }

    /**
     * Resend the email verification notification.
     *
     * @param Request $request
     * @return Application|Redirector|RedirectResponse
     */
    public function resend(Request $request)
    {
        $user = $request->user();

        if (!$user->hasVerifyCode()) {
            return redirect($this->redirectPath());
        }

        if($user->hasPhoneVerifyCode()){
            $user->setPhoneVerifyCode();
            $user->sendToPhone($user->getVerifyCode());
        }elseif($user->hasEmailVerifyCode()){
            $user->setEmailVerifyCode();
            $user->sendToEmail(new VerifyMail($user->login, $user->getVerifyCode()));
        }

        notice('A fresh verification code has been sent to your email/phone.', 'info');
        return back();
    }

    public function redirectTo()
    {
        return RouteServiceProvider::PROFILE . '/' . \request()->user()->id;
    }
}



