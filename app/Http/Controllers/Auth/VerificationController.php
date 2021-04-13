<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\PageController;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;


class VerificationController extends PageController
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
        return $request->user()->isVerified()
            ? redirect($this->redirectPath())
            : $this->renderOutput('auth.verify');
    }

    /**
     * Mark the authenticated user's email address as verified.
     *
     *
     * @param Request $request
     * @return Application|Redirector|RedirectResponse
     *
     * @throws AuthorizationException
     */
    public function myVerify(Request $request)
    {
        if ($request->user()->isVerified()) {
            return redirect($this->redirectPath());
        }

        if (!hash_equals((string)$request->route('token'), $request->user()->verify_token)) {
            throw new AuthorizationException;
        }


        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
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
        if ($request->user()->isVerified()) {
            return redirect($this->redirectPath());
        }

        $request->user()->sendEmailVerificationNotification();

        notice('email resent', 'info');
        return back();
    }

    public function redirectTo()
    {
        return RouteServiceProvider::PROFILE . '/' . \request()->user()->id;
    }
}



