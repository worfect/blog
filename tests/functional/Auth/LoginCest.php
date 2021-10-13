<?php


namespace Tests\functional\Auth;

use App\Models\User;
use Codeception\Example;
use FunctionalTester;

class LoginCest
{
    /**
     * @return array
     */
    protected function testDataProvider(): array
    {
        return [
            [env('USER_LOGIN'), 0],
            [env('USER_PHONE'), 0],
            [env('USER_EMAIL'), 1]
        ];
    }

    protected function createTestUser()
    {
        factory(User::class)->create([
            'login' => env('USER_LOGIN'),
            'screen_name' => env('USER_LOGIN'),
            'password' =>  env('USER_PASS_CRYPT'),
            'email' => env('USER_EMAIL'),
            'phone' =>  env('USER_PHONE'),
        ]);
    }

    /**
     * @dataProvider testDataProvider
     */
    public function testLogin(FunctionalTester $I, Example $example)
    {
        $this->createTestUser();

        $I->amOnPage('/login');

        $formData = [
            'uniqueness' => $example[0],
            'password' => env('USER_PASS'),
            'remember' => $example[1]
        ];
        $I->submitForm('#login-form', $formData, 'loginSubmitButton');

        $I->seeAuthentication();

        $this->testRemember($I, $example[1]);
        $this->testRedirect($I);
        $this->testLogout($I);
    }

    public function testLoginErrors(FunctionalTester $I)
    {
        $I->amOnPage('/login');

        $I->fillField('uniqueness', 'fake');
        $I->fillField('password', 'fake');
        $I->click('loginSubmitButton', '#login-form');

        $I->seeFormErrorMessage('login', trans('auth.login.failed'));
        $I->seeFormErrorMessage('password', trans('auth.login.failed'));

        $I->fillField('uniqueness', '');
        $I->fillField('password', '');
        $I->click('loginSubmitButton', '#login-form');

        $I->seeFormErrorMessage('login', trans('auth.login.no_input'));
        $I->seeFormErrorMessage('password', trans('auth.login.no_input'));
    }

    public function testMultifactor(FunctionalTester $I)
    {
        $this->createTestUser();
        $user = User::where('login', env('USER_LOGIN'))->first();
        $user->confirmPhone();
        $user->enableMultiFactor();

        $I->amOnPage('/login');
        $formData = [
            'uniqueness' => env('USER_LOGIN'),
            'password' => env('USER_PASS')
        ];
        $I->submitForm('#login-form', $formData, 'loginSubmitButton');

        $I->seeInCurrentUrl('/verify');
        $I->dontSeeAuthentication();

        $user = User::where('login', env('USER_LOGIN'))->first();
        $I->submitForm('#verify-form', ['code' => $user->verify_code], 'verifySubmitButton');

        $I->seeInCurrentUrl('');
        $I->see(trans('verify.success'));
        $I->SeeAuthentication();
    }


    public function testLoginLockout(FunctionalTester $I)
    {
        $this->createTestUser();

        $I->amOnPage('/login');

        for ($i = 1; $i <= 11; $i++) {
            $I->fillField('uniqueness', 'fake');
            $I->fillField('password', 'fake');
            $I->click('loginSubmitButton', '#login-form');
        }
            $I->fillField('uniqueness', 'fake');
            $I->fillField('password', 'fake');
            $I->click('loginSubmitButton', '#login-form');
            $I->seeFormErrorMessage('login','Too many login attempts.');
    }

    protected function testRemember(FunctionalTester $I, bool $val)
    {
        if($val){
            $I->dontSeeRecord('users', ['remember_token' => null]);
        }else{
            $I->seeRecord('users', ['remember_token' => null]);
        }
    }

    protected function testLogout(FunctionalTester $I)
    {
        $I->submitForm('#logout-form', [], 'logoutSubmitButton');
        $I->dontSeeAuthentication();
    }

    protected function testRedirect(FunctionalTester $I)
    {
        $I->amOnPage('/login');
        $I->seeCurrentUrlEquals('/');
    }
}
