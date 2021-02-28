<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Site\BasePage;
use App\Http\Requests\UserLoginRequest;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;


class LoginController extends BasePage
{

    use AuthenticatesUsers;


    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->template = 'auth.login';

        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return $this->renderOutput();
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


