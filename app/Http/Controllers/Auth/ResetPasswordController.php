<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\Verifier\Verifier;
use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordResetRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    public $redirectTo = RouteServiceProvider::PROFILE;

    /**
     * Display the password reset view.
     *
     * @return \Illuminate\View\View
     */
    public function showPasswordResetForm()
    {
        return view('auth.passwords.reset');
    }

    /**
     * Reset the given user's password.
     *
     * @param PasswordResetRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reset(PasswordResetRequest $request)
    {
        $password = $request->get('password');

        $verifier = new Verifier();
        if($verifier->verifyUser($request->get('code'))){
            $this->resetPassword($verifier->getVerifiedUser(), $password);
            return $this->sendResetResponse();
        }
        return $this->sendResetFailedResponse();
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param  string  $password
     * @return void
     */
    protected function resetPassword($user, $password)
    {
        $this->setUserPassword($user, $password);
        $user->setRememberToken(Str::random(60));
    }

    /**
     * Set the user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param  string  $password
     * @return void
     */
    protected function setUserPassword($user, $password)
    {
        dd($password);
        $user->password = Hash::make($password);
        $user->save();
    }

    /**
     * Get the response for a successful password reset.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendResetResponse()
    {
        notice(trans('passwords.reset'), 'info');
        if($user = Auth::user()){
            return redirect($this->redirectPath() . '/' . $user->id);
        }else{
            return redirect(route('login'));
        }
    }

    /**
     * Get the response for a failed password reset.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendResetFailedResponse()
    {
        notice(trans('passwords.reset_error'), 'danger');
        return redirect(route('password.reset'));
    }
}
