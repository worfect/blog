<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordResetRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    public $redirectTo = RouteServiceProvider::PROFILE;

    public function showPasswordResetForm(Request $request)
    {
        return view('auth.passwords.reset')->render();
    }

    public function reset(PasswordResetRequest $request)
    {
        $password = $request->get('password');
        if ($user = $this->getUser($request->get('code'))) {
            $this->resetPassword($user, $password);
            return $this->sendResetResponse($user);
        }
        return $this->sendResetFailedResponse();
    }

    protected function getUser($code){
        if($user = Auth::user() and $user->getVerifyCode() == $code){
            return $user;
        }elseif(!Auth::user()){
            $user = User::where('verify_code', $code)->count();
            if ($user = 1) {
                return User::where('verify_code', $code)->first();
            }
        }
        return false;
    }

    protected function resetPassword($user, $password)
    {
        $this->

        $this->setUserPassword($user, $password);

        $user->delVerifyCode();

        $user->setRememberToken(Str::random(60));

        event(new PasswordReset($user));

        $this->guard()->login($user);
    }

    /**
     * Set the user's password.
     *
     * @param User $user
     * @param string $password
     * @return void
     */
    protected function setUserPassword($user, $password)
    {
        $user->password = Hash::make($password);
        $user->save();
    }

    protected function sendResetResponse($user)
    {
        notice("Password changed successfully", 'info');
        return redirect($this->redirectPath() . '/' . $user->id);
    }

    protected function sendResetFailedResponse()
    {
        notice("Something wrong", 'danger');
        return redirect()->back();
    }
}
