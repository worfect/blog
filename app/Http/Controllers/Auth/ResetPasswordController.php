<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Auth\Verifier\Verifier;
use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordResetRequest;
use App\Providers\RouteServiceProvider;
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

        $verifier = new Verifier();
        if($verifier->verifyUser($request->get('code'))){
            $this->resetPassword($verifier->getVerifiedUser(), $password);
            return $this->sendResetResponse();
        }
        return $this->sendResetFailedResponse();
    }

    protected function resetPassword($user, $password)
    {
        $this->setUserPassword($user, $password);
        $user->setRememberToken(Str::random(60));
    }

    protected function setUserPassword($user, $password)
    {
        $user->password = Hash::make($password);
        $user->save();
    }

    protected function sendResetResponse()
    {
        notice("Password changed successfully", 'info');
        if($user = Auth::user()){
            return redirect($this->redirectPath() . '/' . $user->id);
        }else{
            return redirect(route('login'));
        }
    }

    protected function sendResetFailedResponse()
    {
        notice("Something wrong. Check if the code is correct or try submitting the code again", 'danger');
        return redirect()->back();
    }
}
