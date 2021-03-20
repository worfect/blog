<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegistrationRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    use RegistersUsers;

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

        event(new Registered($user));

        $this->guard()->login($user);

        if ($response = $this->registered()) {
            return $response;
        }
    }


    protected function registered()
    {
        return redirect()->to('email/verify');
    }
}
