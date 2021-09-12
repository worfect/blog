<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\HasVerifySource;
use App\Http\Controllers\Auth\Verifier\Verifier;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class VerificationController extends Controller
{
    use RedirectsUsers;

    public function __construct()
    {
        $this->middleware('throttle:6,1')->only('verification', 'resend');
    }
    /**
     * Show the verification page.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function show(Request $request)
    {
        $user = User::findOrFail($request->cookie('id'));

        if($user->checkVerifyExpired()){
            return view('auth.verify');
        }

        notice(trans('verify.error'), 'danger');
        return redirect($this->redirectPath());
    }

    /**
     * User verification
     *
     * @param  Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verification(Request $request)
    {
        $user = User::findOrFail($request->cookie('id'));
        $verifier = new Verifier($user);

        if($verifier->verifyUser($request->get('code'))){

            if(!Auth::check()){
                Auth::login($user);
            }

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
        $user = User::findOrFail($request->cookie('id'));

        if($user instanceof HasVerifySource){
            (new Verifier($user))->resendVerifyCode();
            notice(trans('verify.resend'), 'info');
        }

        return back()->withCookie('id', $user->id, 10);
    }

    public function redirectTo()
    {
        return RouteServiceProvider::HOME;
    }
}



