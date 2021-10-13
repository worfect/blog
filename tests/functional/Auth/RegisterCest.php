<?php
namespace Tests\functional\Auth;

use App\Models\Status;
use App\Models\User;
use Carbon\Carbon;
use Codeception\Example;
use FunctionalTester;
use Illuminate\Support\Facades\Auth;

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
            'password' =>  env('USER_PASS_CRYPT'),
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

        $this->verify($I, $example);

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
            'role' => User::ROLE_USER
        ];
        $I->seeRecord('App\Models\User', $userData);

        $user = User::where('login', $userData['login'])->first();

        $I->seeRecord('status_user', ['status_id' => Status::WAIT, 'user_id' => $user->id]);

        if(isset($user->phone)){
            $I->assertTrue((bool) preg_match("/^P-[0-9]{5}$/", $user->verify_code));
        }
        if(isset($user->email)){
            $I->assertTrue((bool) preg_match("/^E-[0-9]{5}$/", $user->verify_code));
        }
        $I->assertTrue(isset($user->expired_token));

    }

    protected function testRedirect(FunctionalTester $I)
    {
        $I->amOnPage('/register');
        $I->seeCurrentUrlEquals('/');
    }

    protected function verify(FunctionalTester $I, Example $example)
    {
        $I->seeInCurrentUrl('/verify');

        $this->verifyResend($I, $example);
        $this->verifyErrors($I);

        $user = Auth::user();

        $I->submitForm('#verify-form', ['code' => $user->verify_code], 'verifySubmitButton');

        $I->seeInCurrentUrl('');
        $I->see(trans('verify.success'));
        $I->seeAuthentication();

        $user = Auth::user();

        $I->assertNull($user->verify_code);
        $I->assertNull($user->expired_token);
        $I->dontSeeRecord('status_user', ['status_id' => Status::WAIT, 'user_id' => $user->id]);
        $I->seeRecord('status_user', ['status_id' => Status::ACTIVE, 'user_id' => $user->id]);

        if($example[0] == 'email'){
            $I->assertTrue((bool) $user->email_confirmed);
        }
        if($example[0] == 'phone'){
            $I->assertTrue((bool) $user->phone_confirmed);
        }
    }

    protected function verifyResend(FunctionalTester $I, Example $example)
    {
        $user = Auth::user();
        $oldExp = $user->expired_token;
        $oldCode = $user->verify_code;

        $I->submitForm('#resend-form', [], 'resendSubmitButton');

        $user = Auth::user();

        if($example[0] == 'phone'){
            $I->assertTrue((bool) preg_match("/^P-[0-9]{5}$/", $user->verify_code));
        }
        if($example[0] == 'email'){
            $I->assertTrue((bool) preg_match("/^E-[0-9]{5}$/", $user->verify_code));
        }
        $I->assertNotEquals($oldCode, $user->verify_code);

        $I->assertNotEquals($user->expired_token, $oldExp);
    }

    protected function verifyErrors(FunctionalTester $I)
    {
        $I->submitForm('#verify-form', ['code' => 'G-111111'], 'verifySubmitButton');

        $I->seeInCurrentUrl('/verify');
        $I->see(trans('verify.error'));
    }
}
