<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
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
        return $request->user()->hasVerifyToken()
            ? view('auth.verify')->render()
            : redirect($this->redirectPath());
    }

    /**
     *
     *
     * @param Request $request
     * @return Application|Redirector|RedirectResponse
     */
    public function myVerify(Request $request)
    {
        if (!$request->user()->hasVerifyToken()) {
            return redirect($this->redirectPath());
        }

        if ($request->get('code') != $request->user()->getVerifyToken()) {
            notice('Invalid code', 'error');
            return back();
        }

        if (!$request->user()->isVerified()){
            $request->user()->markAsVerified();
        }

        if($type = $request->get('type')){
            if($type == 'email'){
                $request->user()->markEmailAsVerified();
            }
            if($type == 'phone'){
                $request->user()->markPhoneAsVerified();
            }
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
        if (!$request->user()->hasVerifyToken()) {
            return redirect($this->redirectPath());
        }
        dd($request->get('type'));
        if($type = $request->get('type')){

            if($type == 'email'){
                $request->user()->sendEmailVerifyCode();
            }elseif($type == 'phone'){
                $request->user()->sendPhoneVerifyCode();
            }else{
                event(new Registered($request->user()));
            }
        }

        notice('Resent', 'info');
        return back();
    }

    public function redirectTo()
    {
        return RouteServiceProvider::PROFILE . '/' . \request()->user()->id;
    }
}



