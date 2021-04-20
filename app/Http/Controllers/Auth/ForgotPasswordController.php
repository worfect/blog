<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordRecoveryRequest;
use App\Models\User;

class ForgotPasswordController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLinkRequestForm()
    {
        return view('auth.passwords.forgot')->render();
    }


    public function selectSendMethod(PasswordRecoveryRequest $request)
    {
        $validData = $request->validated();

        $method = array_key_first($validData);
        $value = $validData[$method];

        if($method == 'login'){
            if($user = $this->checkUserExists($method, $value)){
                if($dispatchMethod = $request->get('dispatchMethod')){
                    if($dispatchMethod == 'email'){
                        $user->sendVerifyCodeToEmail();
                    }
                    if($dispatchMethod == 'phone'){
                        $user->sendVerifyCodeToPhone();
                    }
                }else{
                    return $this->choiceAvailableResetMethod($user);
                }
            }else{
                return $this->sendResetCodeFailedResponse('auth.no_data');
            }
        }
        if($method == 'phone'){
            if($user = $this->checkUserExists($method, $value)){
                $user->sendVerifyCodeToPhone();
            }else{
                return $this->sendResetLinkFailedResponse('auth.no_data');
            }
        }
        if($method == 'email'){
            if($user = $this->checkUserExists($method, $value)){
                $user->sendVerifyCodeToEmail();
            }else{
                return $this->sendResetLinkFailedResponse('auth.no_data');
            }
        }
        return redirect(route('password.verify'));
    }

    protected function choiceAvailableResetMethod(User $user)
    {
        if($user->getEmail() and $user->getPhone()){
            return $this->showSwitchMethods($user->getEmail(), $user->getPhone());
        }
        if(($user->getPhone() and empty($user->getEmail()))){
            $user->sendVerifyCodeToPhone();
            return redirect(route('password.verify'));
        }
        if(($user->getEmail() and empty($user->getPhone()))){
            $user->sendVerifyCodeToEmail();
            return redirect(route('password.verify'));
        }else{
            return $this->sendResetLinkFailedResponse('auth.no_data');
        }
    }

    public function showSwitchMethods($email, $phone){
        $additionalData = [
            'switchResetMethod' => true,
            'email' => $this->prepareDisplayPrivateData($email),
            'phone' => $this->prepareDisplayPrivateData($phone)
        ];
        return redirect(route('password.request'))->with($additionalData)->withInput();
    }

    public function checkUserExists($name, $value)
    {
        $user = User::where($name, $value)->first();
        if ($user != null) {
            return $user;
        }
        return false;
    }

    protected function sendResetCodeFailedResponse($message)
    {
        return redirect(route('password.request'))
            ->withErrors(['uniqueness' => [trans($message)]]);
    }

    public function prepareDisplayPrivateData($data){
        return substr($data, 0, 4) . '***' . substr($data, -4, 4);
    }

}
