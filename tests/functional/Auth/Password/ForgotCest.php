<?php


namespace Tests\functional\Auth\Password;


use App\Models\User;
use Codeception\Example;
use FunctionalTester;

class ForgotCest
{
    /**
     * @return array
     */
    protected function dataProvider(): array
    {
        return [
            ['login' => env('USER_LOGIN'), 'email' =>  env('USER_EMAIL'), 'phone' => null],
            ['login' => env('USER_LOGIN'), 'email' =>  null,                   'phone' => env('USER_PHONE')],
            ['login' => env('USER_LOGIN'), 'email' =>  env('USER_EMAIL'), 'phone' => env('USER_PHONE')],
        ];
    }

    protected function createTestUser($login, $email, $phone)
    {
        factory(User::class)->create([
            'login' => $login,
            'screen_name' => env('USER_LOGIN'),
            'password' =>  env('USER_PASS_CRYPT'),
            'email' => $email,
            'phone' =>  $phone,
            'status' => User::STATUS_WAIT,
            'role' => User::ROLE_USER,
            'phone_confirmed' => 0,
            'email_confirmed' => 0,
            'verify_code' => null,
            'expired_token' => null,
        ]);
    }

    /**
     * @dataProvider dataProvider
     */
    public function testForgotByLogin(FunctionalTester $I, Example $example)
    {
        $this->createTestUser($example['login'], $example['email'], $example['phone']);

        $I->amOnPage('/password/forgot');
        $I->seeInCurrentUrl('/password/forgot');

        $I->submitForm('#forgot-password-form', ['uniqueness' => $example['login']]);
        if(!is_null($example['email']) and !is_null($example['phone'])){
            $this->switch($I, $example);
        }elseif(!is_null($example['email'])){
            $this->email($I);
        }elseif(!is_null($example['phone'])){
            $this->phone($I);
        }

        $I->seeInCurrentUrl('password/reset');
    }

    public function testForgotByEmail(FunctionalTester $I)
    {
        $this->createTestUser(env('USER_LOGIN'), env('USER_EMAIL'), null);

        $I->amOnPage('/password/forgot');
        $I->seeInCurrentUrl('/password/forgot');

        $I->submitForm('#forgot-password-form', ['uniqueness' => env('USER_EMAIL')]);

        $this->email($I);
    }

    public function testForgotByPhone(FunctionalTester $I)
    {
        $this->createTestUser(env('USER_LOGIN'), null, env('USER_PHONE'));

        $I->amOnPage('/password/forgot');
        $I->seeInCurrentUrl('/password/forgot');

        $I->submitForm('#forgot-password-form', ['uniqueness' =>  env('USER_PHONE')]);
        $this->phone($I);
    }

    protected function switch(FunctionalTester $I, Example $example)
    {
        $I->seeInCurrentUrl('/password/forgot');
        $I->seeElement('input', ['name' => 'dispatchMethod', 'type' => 'radio', 'value' => 'email']);
        $I->seeElement('input', ['name' => 'dispatchMethod', 'type' => 'radio', 'value' => 'phone']);

        $I->submitForm('#forgot-password-form', ['uniqueness' => $example['login'], 'dispatchMethod' => 'email']);
        $this->email($I);

        $I->moveBack();

        $I->submitForm('#forgot-password-form', ['uniqueness' => $example['login'], 'dispatchMethod' => 'phone']);
        $this->phone($I);
    }

    protected function email(FunctionalTester $I)
    {
        $user = User::where('login', env('USER_LOGIN'))->first();
        $I->assertTrue((bool) preg_match("/^E-[0-9]{5}$/", $user->verify_code));
        $I->assertTrue(isset($user->expired_token));
        $I->assertNotTrue($user->email_confirmed);
        $I->assertEquals($user->status, User::STATUS_WAIT);
    }

    protected function phone(FunctionalTester $I)
    {
        $user = User::where('login', env('USER_LOGIN'))->first();
        $I->assertTrue((bool) preg_match("/^P-[0-9]{5}$/", $user->verify_code));
        $I->assertTrue(isset($user->expired_token));
        $I->assertNotTrue($user->phone_confirmed);
        $I->assertEquals($user->status, User::STATUS_WAIT);
    }

    public function testForgotErrors(FunctionalTester $I)
    {
        $this->createTestUser(env('USER_LOGIN'), env('USER_EMAIL'), env('USER_PHONE'));

        $I->amOnPage('/password/forgot');

        $I->submitForm('#forgot-password-form', ['uniqueness' => '']);
        $I->seeFormErrorMessage('login','Enter your login, email or phone');

        $I->submitForm('#forgot-password-form', ['uniqueness' => 'qwerty']);
        $I->seeFormErrorMessage('uniqueness','This user has no data for password recovery');
    }
}
