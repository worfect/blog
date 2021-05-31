<?php

namespace App\Http\Controllers\Auth;

use App\Events\RequestVerification;
use App\Http\Controllers\PageController;
use App\Http\Requests\UserRegistrationRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends PageController
{
    use RegistersUsers;

    public $redirectTo = RouteServiceProvider::VERIFY;

    public $user;

    public function __construct(User $user)
    {
        $this->middleware('guest');
        $this->user = $user;
    }

    public function showRegistrationForm()
    {
        return $this->renderOutput('auth.register');
    }

    public function register(UserRegistrationRequest $request)
    {
        $data = $request->validated();
        $user = $this->user->registerUser($data);

        $this->guard()->login($user);

        if($user->hasEmail()){
            event(new RequestVerification($user, 'email'));
        }elseif($user->hasPhone()){
            event(new RequestVerification($user, 'phone'));
        }

        return redirect($this->redirectPath());
    }

}
