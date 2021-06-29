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
    /**
     * Show the verification page.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show(Request $request)
    {
        return $request->user()->getVerifyCode()
            ? view('auth.verify')
            : redirect($this->redirectPath());
    }

    /**
     * User verification
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verification(Request $request)
    {
        $verifier = new Verifier();
        if($verifier->verifyUser($request->get('code'))){
            notice(trans('verify.success'), 'success');
            return redirect($this->redirectPath());
        }

        notice(trans('verify.error'), 'danger');
        return redirect()->back();
    }


    /**
     * Resending the verification code.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function resend(Request $request)
    {
        $user = $request->user();
        if($user instanceof HasVerifySource){
            $verifier = new Verifier();
            $verifier->resendVerifyCode($user);
            notice(trans('verify.resend'), 'info');
        }

        return back();
    }

    public function redirectTo()
    {
        return RouteServiceProvider::PROFILE . '/' . \request()->user()->id;
    }
}



