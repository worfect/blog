<?php


namespace Tests\functional\Auth;

use App\Models\User;
use Codeception\Example;
use FunctionalTester;

class LoginCest
{
    protected function createTestUser()
    {
        factory(User::class)->create([
            'login' => 'johndoe',
            'screen_name' => 'johndoe',
            'password' =>  crypt('secret', 'crypt'),
            'email' => 'johndoe@gmail.com',
            'phone' => '89123456789',
        ]);
    }

    /**
     * @example ["johndoe", "secret", 0]
     * @example ["johndoe@gmail.com", "secret", 0]
     * @example ["89123456789", "secret", 1]
     */
    public function testLogin(FunctionalTester $I, Example $example)
    {
        $this->createTestUser();

        $I->amOnPage('/login');

        $formData = [
            'uniqueness' => $example[0],
            'password' => $example[1],
            'remember' => $example[2]
        ];
        $I->submitForm('#login-form', $formData, 'loginSubmitButton');
        $I->dontSeeFormErrors();

        $I->seeAuthentication();

        $this->testRemember($I, $example[2]);
        $this->testRedirect($I);
        $this->testLogout($I);
    }

    public function testLoginErrors(FunctionalTester $I)
    {
        $I->amOnPage('/login');

        $I->fillField('uniqueness', 'fake');
        $I->fillField('password', 'fake');
        $I->click('loginSubmitButton', '#login-form');

        $I->seeFormErrorMessage('login', trans('auth.failed'));
        $I->seeFormErrorMessage('password', trans('auth.failed'));

        $I->fillField('uniqueness', '');
        $I->fillField('password', '');
        $I->click('loginSubmitButton', '#login-form');

        $I->seeFormErrorMessage('login',trans('auth.no_input'));
        $I->seeFormErrorMessage('password', trans('auth.no_input'));
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
            $I->SeeRecord('users', ['remember_token' => null]);
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
        $I->amOnPage('/register');
        $I->seeCurrentUrlEquals('/');
    }

}
