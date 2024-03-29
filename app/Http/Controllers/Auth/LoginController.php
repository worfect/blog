<?php

namespace App\Http\Controllers\Auth;

use App\Events\RequestVerification;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;


class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $maxAttempts = 10;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the login form page.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  UserLoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(UserLoginRequest $request)
    {
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {

            $user = User::find(Auth::id());

            if ($user->isMultiFactor()) {
                Auth::logout();
                event(new RequestVerification($user, 'phone'));
                return redirect()->to(RouteServiceProvider::VERIFY)->withCookie('id', $user->id, 10);
            }
            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);
        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param Request $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $request->validated(), $request->get('remember')
        );
    }

    /**
     * Get the failed login response instance.
     *
     * @param  Request  $request
     *
     * @throws ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            'login' => [trans('auth.login.failed')],
            'password' => [trans('auth.login.failed')]
        ]);
    }

    /**
     * Get the login redirect path.
     *
     * @return string
     */
    public function redirectPath()
    {
        return url()->previous();
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'login';
    }
}
