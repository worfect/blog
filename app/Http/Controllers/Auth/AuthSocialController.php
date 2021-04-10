<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\ProcessingAuthRequests;
use App\Models\SocialAccount;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;


class AuthSocialController extends Controller
{

    public $prepareRequest;
    public $socialAccount;
    public $user;

    public function __construct(ProcessingAuthRequests $prepareRequest, User $user, SocialAccount $socialAccount)
    {
        $this->middleware('guest');
        $this->socialAccount = $socialAccount;
        $this->prepareRequest = $prepareRequest;
        $this->user = $user;
    }

    /**
     * Redirect the user to the authentication page.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information.
     *
     * @param $provider
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function handleProviderCallback($provider)
    {
        $socialiteUser = Socialite::driver($provider)->stateless()->user();
        $socialData = $this->prepareRequest->socialRequestProcessing($socialiteUser, $provider);
        $user = $this->findOrCreateUser($socialData);

        auth()->login($user);

        return redirect()->back();
    }


    public function findOrCreateUser(array $socialData)
    {
        if ($user = $this->findUserBySocialId($socialData)) {
            return $user;
        }

        if ($user = $this->findUserByEmail($socialData)) {
            $this->socialAccount->addSocialAccount($socialData, $user);
            return $user;
        }

        $user = $this->user->socialRegisterUser($socialData);

        $this->socialAccount->addSocialAccount($socialData, $user);

        return $user;
    }

    public function findUserBySocialId($socialData)
    {
        $socialAccount = $this->socialAccount->where('provider', $socialData['provider'])
            ->where('provider_id', $socialData['provider_id'])
            ->first();

        return $socialAccount ? $socialAccount->user : false;
    }

    public function findUserByEmail($socialData)
    {
        return !$socialData['email'] ? null : $this->user->where('email', $socialData['email'])->first();
    }
}
