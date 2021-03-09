<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Site\BasePage;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;


class VerificationController extends BasePage
{

    use VerifiesEmails;


    public $redirectTo = RouteServiceProvider::PROFILE;

    /**
     * Create a new controller instance.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);

        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }


    /**
     * Show the email verification notice.
     *
     * @param Request $request
     * @return Application|RedirectResponse|Response|Redirector
     */
    public function show(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
            ? redirect($this->redirectTo . '/' . $request->user()->id)
            : $this->renderOutput('auth.verify');
    }

    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param Request $request
     * @return Response
     *
     * @throws AuthorizationException
     */
    public function myVerify(Request $request)
    {

        if (!hash_equals((string)$request->route('token'), $request->user()->verify_token)) {
            throw new AuthorizationException;
        }

        if ($request->user()->hasVerifiedEmail()) {
            return $request->wantsJson()
                ? new Response('', 204)
                : redirect($this->redirectPath());
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        if ($response = $this->verified($request)) {
            return $response;
        }
    }

    /**
     * The user has been verified.
     *
     * @param Request $request
     * @return mixed
     */
    protected function verified(Request $request)
    {
        return redirect($this->redirectTo . '/' . $request->user()->id);
    }

    /**
     * Resend the email verification notification.
     *
     * @param Request $request
     * @return Response
     */
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $request->wantsJson()
                ? new Response('', 204)
                : redirect($this->redirectPath());
        }

        $request->user()->sendEmailVerificationNotification();

        return $request->wantsJson()
            ? new Response('', 202)
            : back()->with('resent', true);
    }
}



