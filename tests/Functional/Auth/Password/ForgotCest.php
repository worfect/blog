<?php


namespace Tests\Functional\Auth\Password;

use App\Models\Status;
use App\Models\User;
use Codeception\Example;
use Tests\Support\FunctionalTester;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

class ForgotCest
{
    /**
     * @return array
     */
    protected function loginDataProvider(): array
    {
        return [
            ['login' => env('USER_LOGIN'), 'email' =>  env('USER_EMAIL'), 'phone' => null],
            ['login' => env('USER_LOGIN'), 'email' =>  null,                   'phone' => env('USER_PHONE')],
            ['login' => env('USER_LOGIN'), 'email' =>  env('USER_EMAIL'), 'phone' => env('USER_PHONE')],
        ];
    }

    protected function createTestUser($login, $email, $phone)
    {
        User::factory()->create([
            'login' => $login,
            'screen_name' => env('USER_LOGIN'),
            'password' =>  'fake',
            'email' => $email,
            'phone' =>  $phone,
            'role' => User::ROLE_USER,
            'phone_confirmed' => 0,
            'email_confirmed' => 0,
            'verify_code' => null,
            'expired_token' => null,
        ]);
    }

    /**
     * @dataProvider loginDataProvider
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
            $this->checkRedirectToReset($I, "/^E-[0-9]{5}$/");
        }elseif(!is_null($example['phone'])){
            $this->checkRedirectToReset($I, "/^P-[0-9]{5}$/");
        }
    }

    public function testForgotByEmail(FunctionalTester $I)
    {
        $this->createTestUser(env('USER_LOGIN'), env('USER_EMAIL'), null);

        $I->amOnPage('/password/forgot');
        $I->seeInCurrentUrl('/password/forgot');

        $I->submitForm('#forgot-password-form', ['uniqueness' => env('USER_EMAIL')]);

        $this->checkRedirectToReset($I, "/^E-[0-9]{5}$/");
        $this->checkReset($I, 'email_confirmed');
    }

    public function testForgotByPhone(FunctionalTester $I)
    {
        $this->createTestUser(env('USER_LOGIN'), null, env('USER_PHONE'));

        $I->amOnPage('/password/forgot');
        $I->seeInCurrentUrl('/password/forgot');

        $I->submitForm('#forgot-password-form', ['uniqueness' =>  env('USER_PHONE')]);

        $this->checkRedirectToReset($I, "/^P-[0-9]{5}$/");
        $this->checkReset($I, 'phone_confirmed');
    }

    protected function switch(FunctionalTester $I, Example $example)
    {
        $I->seeInCurrentUrl('/password/forgot');
        $I->seeElement('input', ['name' => 'dispatchMethod', 'type' => 'radio', 'value' => 'email']);
        $I->seeElement('input', ['name' => 'dispatchMethod', 'type' => 'radio', 'value' => 'phone']);

        $I->submitForm('#forgot-password-form', ['uniqueness' => $example['login'], 'dispatchMethod' => 'email']);
        $this->checkRedirectToReset($I, "/^E-[0-9]{5}$/");

        $I->moveBack();

        $I->submitForm('#forgot-password-form', ['uniqueness' => $example['login'], 'dispatchMethod' => 'phone']);
        $this->checkRedirectToReset($I, "/^P-[0-9]{5}$/");
    }

    protected function checkRedirectToReset(FunctionalTester $I, $codePattern)
    {
        $user = User::where('login', env('USER_LOGIN'))->first();

        $I->assertTrue((bool) preg_match($codePattern, $user->verify_code));
        $I->assertTrue(isset($user->expired_token));
        $I->assertNotTrue($user->phone_confirmed);
        $I->dontSeeRecord('status_user', ['status_id' => Status::ACTIVE, 'user_id' => $user->id]);

        $I->seeInCurrentUrl('/password/reset');
        $I->assertStringContainsString($user->id, Crypt::decryptString($I->grabCookie('id')));
    }

    protected function checkReset(FunctionalTester $I, $confirmed)
    {
        $user = User::where('login', env('USER_LOGIN'))->first();
        $I->submitForm('#reset-form', ['code' => $user->verify_code, 'password' => env('USER_PASS'), 'password_confirmation' => env('USER_PASS')]);

        $user = User::where('login', env('USER_LOGIN'))->first();
        $I->assertTrue(Hash::check(env('USER_PASS'), $user->password));
        $I->assertTrue((bool)$user->$confirmed);
        $I->assertNull($user->verify_code);
        $I->assertNull($user->expired_token);
        $I->seeRecord('status_user', ['status_id' => Status::ACTIVE, 'user_id' => $user->id]);

        $I->seeInCurrentUrl('login');
        $I->see(trans('passwords.reset'));
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

    public function testResetError(FunctionalTester $I)
    {
        $this->createTestUser(env('USER_LOGIN'), env('USER_EMAIL'), env('USER_PHONE'));

        $user = User::where('login', env('USER_LOGIN'))->first();
        $user->setVerifyCode(env('EMAIL_CODE'));
        $user->setVerifyExpired();


        $I->amOnPage('/password/reset');
        $I->seeInCurrentUrl('/password/reset');

        $I->submitForm('#reset-form', ['code' => '', 'password' => '', 'password_confirmation' => '']);

        $I->seeFormErrorMessage('code', trans('passwords.code'));
        $I->seeFormErrorMessage('password', trans('passwords.password'));

        $I->submitForm('#reset-form', ['code' =>  env('EMAIL_CODE'), 'password' => 'qwe', 'password_confirmation' => 'qwe']);
        $I->seeFormErrorMessage('password', trans('passwords.min'));

        $I->submitForm('#reset-form', ['code' => '12345', 'password' => 'qwerty', 'password_confirmation' => 'qwerty']);
        $I->seeInCurrentUrl('/password/reset');
        $I->see(trans('passwords.reset_error'));
    }
}
