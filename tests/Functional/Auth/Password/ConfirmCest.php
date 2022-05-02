<?php


namespace Tests\Functional\Auth\Password;


use App\Models\User;
use Tests\Support\FunctionalTester;

class ConfirmCest
{
    protected function createTestUser()
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
            'verify_code' => null,
            'expired_token' => null,
        ]);
    }

    public function testConfirm(FunctionalTester $I)
    {
        $this->createTestUser();
        $I->amLoggedAs(['login' => env('USER_LOGIN'), 'password' => env('USER_PASS')]);

        $I->amOnPage('/password/conform');
        $I->seeInCurrentUrl('/password/conform');

        $I->submitForm('#confirm-password-form', ['password' => env('USER_PASS')], 'ConfirmPasswordSubmitButton');

        $I->dontSeeFormErrors();
    }

    public function testConfirmError(FunctionalTester $I)
    {
        $this->createTestUser();
        $I->amLoggedAs(['login' => env('USER_LOGIN'), 'password' => env('USER_PASS')]);

        $I->amOnPage('/password/conform');
        $I->seeInCurrentUrl('/password/conform');

        $I->submitForm('#confirm-password-form', ['password' => ''], 'ConfirmPasswordSubmitButton');
        $I->seeFormErrorMessage('password','The password field is required');

        $I->submitForm('#confirm-password-form', ['password' => 'qwerty'], 'ConfirmPasswordSubmitButton');
        $I->seeFormErrorMessage('password','The password is incorrect');
    }
}
