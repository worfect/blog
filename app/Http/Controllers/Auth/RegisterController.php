<?php

namespace App\Http\Controllers\Auth;

use App\Events\RequestVerification;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRegistrationRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    use RegistersUsers;

    public $redirectTo = RouteServiceProvider::VERIFY;

    public $user;

    public function __construct(User $user)
    {
        $this->middleware('guest');
        $this->user = $user;
    }

    /**
     * Show the registration form page.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param UserRegistrationRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
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
