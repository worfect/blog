<?php


namespace Tests\Functional\Auth;

use App\Models\User;
use Tests\Support\FunctionalTester;


class VerifyCest
{
    // Хз как куки, сгенереные в тестах, передать в пхп скрипт, поэтому методы по тематикам раскидал

    protected function createTestUser($code, $expired)
    {
        User::factory()->create([
            'login' => env('USER_LOGIN'),
            'screen_name' => env('USER_LOGIN'),
            'password' =>  env('USER_PASS_CRYPT'),
            'email' => env('USER_EMAIL'),
            'phone' =>  env('USER_PHONE'),
            'role' => User::ROLE_USER,
            'phone_confirmed' => 0,
            'email_confirmed' => 0,
            'verify_code' => $code,
            'expired_token' => $expired,
        ]);
    }

    public function testDenialAccess(FunctionalTester $I)
    {
        $this->createTestUser(null, null);
        $I->amLoggedAs(['login' => env('USER_LOGIN'), 'password' => env('USER_PASS')]);

        $I->amOnPage('/verify');
        $I->seeInCurrentUrl('/');
    }
}
