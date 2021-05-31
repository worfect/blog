<?php
namespace Tests\functional\Auth;

use App\Models\User;
use Codeception\Example;
use FunctionalTester;

class RegisterCest
{
    /**
     * @return array
     */
    protected function userDataProvider(): array
    {
        return [
            ["phone", env('USER_PHONE')],
            ["email", env('USER_EMAIL')]
        ];
    }

    protected function createTestUser()
    {
        factory(User::class)->create([
            'login' => env('USER_LOGIN'),
            'screen_name' => env('USER_LOGIN'),
            'password' =>  crypt(env('USER_PASS'), 'crypt'),
            'email' => env('USER_EMAIL'),
            'phone' =>  env('USER_PHONE'),
        ]);
    }

    /**
     * @dataProvider userDataProvider
     */
    public function testRegister(FunctionalTester $I, Example $example)
    {
        $I->amOnPage('/register');

        $this->register($I, $example);

        $I->seeAuthentication();

        $this->seeRecord($I, $example);

        $I->seeCurrentUrlEquals('/verify');

        $this->testRedirect($I);
    }

    public function testRegisterError(FunctionalTester $I)
    {
        $this->createTestUser();

        $I->amOnPage('/register');

        $errorData = [
            ['uniqueness', env('USER_EMAIL'), 'email',      trans('auth.register.email.unique')],
            ['uniqueness', env('USER_PHONE'), 'phone',      trans('auth.register.phone.unique')],
            ['uniqueness', 'qwerty',               'uniqueness', trans('auth.register.accepted')],

            ['login',      '',                     'login',      trans('auth.register.login.required')],
            ['login',      'qw',                   'login',      trans('auth.register.login.between')],
            ['login',      env('USER_LOGIN'),  'login',      trans('auth.register.login.unique')],
            ['login',      '!@#$%^',               'login',      trans('auth.register.login.alpha_dash')],

            ['password',   '',                     'password',   trans('auth.register.password.required')],
            ['password',   'qwe',                  'password',   trans('auth.register.password.min')],
            ['password',   env('USER_PASS'),   'password',   trans('auth.register.password.confirmed')],
        ];

        foreach ($errorData as $data){
            $this->error($I, $data);
        }
    }



    protected function error(FunctionalTester $I, array $errorData)
    {
        $I->submitForm('#register-form', [$errorData[0] => $errorData[1]], 'registerSubmitButton');
        $I->seeFormErrorMessage($errorData[2], $errorData[3]);
    }

    protected function register(FunctionalTester $I, Example $uniqueness)
    {
        $formData = [
            'login' => 'login',
            'uniqueness' => $uniqueness[1],
            'password' => 'password',
            'password_confirmation' => 'password'
        ];
        $I->submitForm('#register-form', $formData, 'registerSubmitButton');
    }

    protected function seeRecord(FunctionalTester $I, Example $uniqueness)
    {
        $userData = [
            'login' => 'login',
            'screen_name' => 'login',
            $uniqueness[0] => $uniqueness[1],
            'phone_confirmed' => 0,
            'email_confirmed' => 0,
            'status' => User::STATUS_WAIT,
            'role' => User::ROLE_USER
        ];

        $I->seeRecord('App\Models\User', $userData);
    }

    protected function testRedirect(FunctionalTester $I)
    {
        $I->amOnPage('/register');
        $I->seeCurrentUrlEquals('/');
    }
}
