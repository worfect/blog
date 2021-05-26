<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\HasVerifySource;
use App\Http\Controllers\Auth\Verifier\Verifier;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;


class VerificationController extends Controller
{
    use VerifiesEmails;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function show(Request $request)
    {
        return $request->user()->getVerifyCode()
            ? view('auth.verify')->render()
            : redirect($this->redirectPath());
    }

    public function verification(Request $request)
    {
        $verifier = new Verifier();
        if($verifier->verifyUser($request->get('code'))){
            notice('Verification was successful', 'success');
            return redirect($this->redirectPath());
        }

        notice("Something wrong. Check if the code is correct or try submitting the code again", 'danger');
        return redirect()->back();
    }

    public function resend(Request $request)
    {
        $user = $request->user();
        if($user instanceof HasVerifySource){
            $verifier = new Verifier();
            $verifier->resendVerifyCode($user);
            notice('A fresh verification code has been sent to your email/phone.', 'info');
        }

        return back();
    }

    public function redirectTo()
    {
        return RouteServiceProvider::PROFILE . '/' . \request()->user()->id;
    }
}



