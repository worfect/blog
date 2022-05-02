<?php

namespace Tests\Functional\Auth\Password;

use App\Models\User;
use Tests\Support\FunctionalTester;
use Illuminate\Support\Facades\Hash;

class ChangeCest
{
    protected function createTestUser()
    {
        User::factory()->create([
            'login' => env('USER_LOGIN'),
            'screen_name' => env('USER_LOGIN'),
            'password' =>  env('USER_PASS_CRYPT'),
            'email' => env('USER_EMAIL'),
            'phone' =>  env('USER_PHONE'),
        ]);
    }

    public function testDenialAccess(FunctionalTester $I)
    {
        $I->amOnPage('password/change');
        $I->seeInCurrentUrl('/login');
    }

    public function testChange(FunctionalTester $I)
    {
        $this->createTestUser();
        $I->amLoggedAs(['login' => env('USER_LOGIN'), 'password' => env('USER_PASS')]);

        $I->amOnPage('password/change');
        $I->seeInCurrentUrl('password/change');

        $I->submitForm('#change-password-form', ['password' => env('USER_PASS'), 'new_password' => 'new_password', 'new_password_confirmation' => 'new_password']);

        $user = User::where('login', env('USER_LOGIN'))->first();
        $I->assertTrue(Hash::check('new_password', $user->password));

        $I->seeInCurrentUrl('profile');
        $I->see(trans('passwords.change'));
    }

    public function testChangeErrors(FunctionalTester $I)
    {
        $this->createTestUser();
        $I->amLoggedAs(['login' => env('USER_LOGIN'), 'password' => env('USER_PASS')]);

        $I->amOnPage('password/change');
        $I->seeInCurrentUrl('password/change');

        $I->submitForm('#change-password-form', ['password' => 'bad_pass', 'new_password' => 'new_password', 'new_password-confirm' => 'new_password']);
        $I->seeFormHasErrors();

        $I->submitForm('#change-password-form', ['password' => env('USER_PASS'), 'new_password' => '', 'new_password-confirm' => '']);
        $I->seeFormErrorMessage('new_password', trans('passwords.password'));

        $I->submitForm('#change-password-form', ['password' => env('USER_PASS'), 'new_password' => 'qwe', 'new_password-confirm' => 'qwe']);
        $I->seeFormErrorMessage('new_password', trans('passwords.min'));

        $I->submitForm('#change-password-form', ['password' => env('USER_PASS'), 'new_password' => 'qwerty', 'new_password-confirm' => 'ytrewq']);
        $I->seeFormErrorMessage('new_password', trans('passwords.confirmed'));
    }
}
