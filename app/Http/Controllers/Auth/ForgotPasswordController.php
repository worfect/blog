<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\PageController;
use App\Http\Requests\PasswordRecoveryRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;

class ForgotPasswordController extends PageController
{

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLinkRequestForm()
    {
        return view('auth.passwords.forgot')->render();
    }


    public function  selectSendMethod(PasswordRecoveryRequest $request)
    {
        $validData = $request->validated();

        $method = array_key_first($validData);
        $value = $validData[$method];

        if($method == 'login'){
            if($user = $this->checkUserExists($method, $value)){
                if($dispatchMethod = $request->get('dispatchMethod')){
                    if($dispatchMethod == 'email'){
                        $user->sendEmailResetCode();
                    }
                    if($dispatchMethod == 'email'){
                        $user->sendPhoneResetCode();
                    }
                }
                return $this->choiceAvailableResetMethod($user);
            }else{
                return $this->sendResetCodeFailedResponse('auth.no_data');
            }
        }
        if($method == 'phone'){
            if($user = $this->checkUserExists($method, $value)){
                $user->sendPhoneResetCode();
            }else{
                return $this->sendResetLinkFailedResponse('auth.no_data');
            }
        }
        if($method == 'email'){
            if($user = $this->checkUserExists($method, $value)){
                $user->sendEmailResetCode();
            }else{
                return $this->sendResetLinkFailedResponse('auth.no_data');
            }
        }

        return redirect(RouteServiceProvider::VERIFY);
    }

    public function checkUserExists($name, $value)
    {
        $user = User::where($name, $value)->first();
        if ($user != null) {
            return $user;
        }
        return false;
    }

    protected function choiceAvailableResetMethod(User $user)
    {
        if($user->email and $user->phone){
            return $this->showSwitchMethods($user->email, $user->phone);
        }
        if(($user->phone and empty($user->email))){
            return redirect('password/message')->with([ 'method' => $user->phone ]);
        }
        if(($user->email and empty($user->phone))){
            return redirect('password/message')->with([ 'method' => $user->email ]);
        }else{
            return $this->sendResetLinkFailedResponse('auth.no_data');
        }
    }

    public function showSwitchMethods($email, $phone){
        $this->template = 'auth.passwords.reset';
        $additionalData = [
            'switchResetMethod' => true,
            'email' => $this->prepareDisplayPrivateData($email),
            'phone' => $this->prepareDisplayPrivateData($phone)
        ];
        return redirect('password/reset')->with($additionalData)->withInput();
    }

    protected function sendResetCodeFailedResponse($message)
    {
        return redirect('password/reset')
            ->withErrors(['uniqueness' => [trans($message)]]);
    }

    public function prepareDisplayPrivateData($data){
        return substr($data, 0, 4) . '***' . substr($data, -4, 4);
    }

}
