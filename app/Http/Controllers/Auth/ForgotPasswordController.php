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
        return view('auth.passwords.forgot')->render();
    }

    public function selectSendMethod(PasswordRecoveryRequest $request)
    {
        $validData = $request->validated();

        $method = array_key_first($validData);
        $value = $validData[$method];

        if($this->isMethodExists($method) and $user = $this->getUser($method, $value)){
            if($method == 'login'){
                if($dispatchMethod = $this->isMethodExists($request->get('dispatchMethod'))){
                    event(new RequestVerification($user, $dispatchMethod));
                }else{
                    return $this->choiceAvailableResetMethod($user);
                }
            }else{
                event(new RequestVerification($user, $method));
            }
        }else{
            return $this->sendResetCodeFailedResponse('auth.no_data');
        }

        return redirect(route('password.reset.form'));
//
//
//        if($method == 'login'){
//            if($user = $this->checkUserExists($method, $value)){
//                if($dispatchMethod = $request->get('dispatchMethod')){
//                    if($dispatchMethod == 'email'){
//                        event(new RequestVerification($user, 'email'));
//                    }
//                    if($dispatchMethod == 'phone'){
//                        event(new RequestVerification($user, 'phone'));
//                    }
//                }else{
//                    return $this->choiceAvailableResetMethod($user);
//                }
//            }else{
//                return $this->sendResetCodeFailedResponse('auth.no_data');
//            }
//        }
//        if($method == 'phone'){
//            if($user = $this->checkUserExists($method, $value)){
//                event(new RequestVerification($user, 'phone'));
//            }else{
//                return $this->sendResetCodeFailedResponse('auth.no_data');
//            }
//        }
//        if($method == 'email'){
//            if($user = $this->checkUserExists($method, $value)){
//                event(new RequestVerification($user, 'email'));
//            }else{
//                return $this->sendResetCodeFailedResponse('auth.no_data');
//            }
//        }
//        return redirect(route('password.reset.form'));
    }

    protected function choiceAvailableResetMethod(HasVerifySource $user)
    {
        $hasPhone = $user instanceof HasPhone and $user->hasPhone();
        $hasEmail = $user instanceof HasEmail and $user->hasEmail();

        if($hasPhone and $hasEmail){
            return $this->showSwitchMethods($user->getEmail(), $user->getPhone());
        }
        if($hasPhone and !$hasEmail){
            event(new RequestVerification($user, 'phone'));
            return redirect(route('password.reset.form'));
        }
        if(!$hasPhone and $hasEmail){
            event(new RequestVerification($user, 'email'));
            return redirect(route('password.reset.form'));
        }

        return $this->sendResetCodeFailedResponse('auth.no_data');
    }

    public function showSwitchMethods($email, $phone)
    {
        $additionalData = [
            'switchResetMethod' => true,
            'email' => $this->prepareDisplayPrivateData($email),
            'phone' => $this->prepareDisplayPrivateData($phone)
        ];
        return redirect(route('password.forgot.form'))->with($additionalData)->withInput();
    }

    protected function getUser($name, $value)
    {
        if ($user = User::where($name, $value)->first()) {
            return $user;
        }
        return false;
    }

    protected function isMethodExists(string $method): bool
    {
        if($method == 'login' or $method == 'phone' or $method ==  'email'){
            return true;
        }
        return false;
    }

    protected function sendResetCodeFailedResponse($message)
    {
        return redirect(route('password.forgot.form'))
            ->withErrors(['uniqueness' => [trans($message)]]);
    }

    protected function prepareDisplayPrivateData($data): string
    {
        return substr($data, 0, 4) . '***' . substr($data, -4, 4);
    }
}
