<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\HasEmail;
use App\Contracts\HasPhone;
use App\Contracts\HasVerifySource;
use App\Events\RequestVerification;
use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordRecoveryRequest;
use App\Models\User;

class ForgotPasswordController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showPasswordForgotForm()
    {
        return view('auth.passwords.forgot');
    }

    /**
     * Handle a verification request in a user-accessible way.
     *
     * @param PasswordRecoveryRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function sendRequestAvailableWay(PasswordRecoveryRequest $request)
    {
        $validData = $request->validated();

        $method = array_key_first($validData);
        $value = $validData[$method];

        if($this->isMethodExists($method) and $user = $this->getUser($method, $value)){
            if($method == 'login'){
                $dispatchMethod = $request->get('dispatchMethod');
                if(isset($dispatchMethod) and $this->isMethodExists($dispatchMethod)) {
                    event(new RequestVerification($user, $dispatchMethod));
                }else{
                    return $this->choiceAvailableResetMethod($user);
                }
            }else{
                event(new RequestVerification($user, $method));
            }
        }else{
            return $this->sendResetCodeFailedResponse(trans('auth.no_data'));
        }

        return redirect(route('password.reset.form'));
    }

    /**
     * Defining an available method to send.
     *
     * @param HasVerifySource $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    protected function choiceAvailableResetMethod(HasVerifySource $user)
    {
        if(is_a($user, HasPhone::class) or is_a($user, HasEmail::class)){
            if($user->hasPhone() and $user->hasEmail()){
                return $this->showSwitchMethods($user->getEmail(), $user->getPhone());
            }
            if($user->hasPhone() and !$user->hasEmail()){
                event(new RequestVerification($user, 'phone'));
                return redirect(route('password.reset.form'));
            }
            if(!$user->hasPhone() and $user->hasEmail()){
                event(new RequestVerification($user, 'email'));
                return redirect(route('password.reset.form'));
            }
        }
        return $this->sendResetCodeFailedResponse(trans('auth.no_data')); // OR EXEPTION AND LOG?
    }

    /**
     * Showing a switch for selecting a verification method
     *
     * @param $email
     * @param $phone
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function showSwitchMethods($email, $phone)
    {
        $additionalData = [
            'switchResetMethod' => true,
            'email' => $this->prepareDisplayPrivateData($email),
            'phone' => $this->prepareDisplayPrivateData($phone)
        ];
        return redirect(route('password.forgot.form'))->with($additionalData)->withInput();
    }

    /**
     * Getting a user instance by field value.
     *
     * @param $name
     * @param $value
     * @return false
     */
    protected function getUser($name, $value)
    {
         return User::where($name, $value)->first();
    }

    /**
     * Check of the possibility of verification.
     *
     * @param string $method
     * @return bool
     */
    protected function isMethodExists(string $method): bool
    {
        if($method == 'login' or $method == 'phone' or $method ==  'email'){
            return true;
        }
        return false; // OR EXEPTION AND LOG?
    }

    /**
     * Sending a verification error message.
     *
     * @param string $message
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    protected function sendResetCodeFailedResponse(string $message)
    {
        return redirect(route('password.forgot.form'))
            ->withErrors(['uniqueness' => $message]);
    }

    /**
     * Preparation for displaying personal data.
     *
     * @param $data
     * @return string
     */
    protected function prepareDisplayPrivateData($data): string
    {
        return substr($data, 0, 4) . '***' . substr($data, -4, 4);
    }
}
