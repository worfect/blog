<?php


namespace App\Http\Controllers\Auth;

use App\Http\Requests\PasswordChangeRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController
{
    /**
     * Display the password reset view.
     *
     * @return \Illuminate\View\View
     */
    public function showPasswordChangeForm()
    {
        return view('auth.passwords.change');
    }

    /**
     * Change the given user's password.
     *
     * @param PasswordChangeRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function change(PasswordChangeRequest $request)
    {
        $user = User::find(Auth::id()); // Auth::user() not  CanResetPassword
        $password = $request->get('new_password');

        if($this->setUserPassword($user, $password))
        {
            Auth::login($user);
            return $this->sendChangeResponse();
        }
        return $this->sendChangeFailedResponse();
    }

    /**
     * Set the user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword  $user
     * @param string $password
     * @return bool
     */
    protected function setUserPassword($user, string $password): bool
    {
        $user->password = Hash::make($password);
        return $user->save();
    }

    /**
     * Get the response for a successful password change.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendChangeResponse()
    {
        notice(trans('passwords.change'), 'success');
        return redirect(route('profile.edit', ['id' => Auth::id()]));
    }

    /**
     * Get the response for a failed password change.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendChangeFailedResponse()
    {
        notice(trans('passwords.change_error'), 'danger');
        return redirect(route('password.change.form'));
    }
}
