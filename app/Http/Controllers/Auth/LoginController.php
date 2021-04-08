<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\ContentController;
use App\Http\Requests\UserLoginRequest;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;


class LoginController extends ContentController
{

    use AuthenticatesUsers;


    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return $this->renderOutput('auth.login');
    }


    public function authenticate(UserLoginRequest $request)
    {
        $data = $request->validated();
        if ($this->attemptLogin($data)) {
            return $this->sendLoginResponse($request);
        }

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param $data
     * @return bool
     */
    protected function attemptLogin($data)
    {
        return $this->guard()->attempt(
            $data, isset($data['remember'])
        );
    }

    protected function authenticated(Request $request, $user)
    {
        return redirect('/');
    }
}


