<?php


namespace Tests\functional\Profile;

use App\Models\User;
use FunctionalTester;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class EditCest
{
    protected $phone = 89123456789;
    protected $email = 'test@mail.com';
    protected $name = 'test_name';

    protected function createTestUser()
    {
        factory(User::class)->create([
            'login' => env('USER_LOGIN'),
            'screen_name' => env('USER_LOGIN'),
            'password' =>  env('USER_PASS_CRYPT'),
            'email' => env('USER_EMAIL'),
            'phone' =>  null,
            'status' => User::STATUS_WAIT,
            'role' => User::ROLE_USER,
            'phone_confirmed' => 0,
            'email_confirmed' => 0,
            'multi_factor' => 0,
        ]);
    }

    public function testDenialAccess(FunctionalTester $I)
    {
        $this->createTestUser();
        $user = User::where('login', env('USER_LOGIN'))->first();

        $I->amOnPage("/profile/$user->id/edit");
        $I->seeResponseCodeIsClientError();
    }

    public function testShowData(FunctionalTester $I)
    {
        $this->createTestUser();
        $I->amLoggedAs(['login' => env('USER_LOGIN'), 'password' => env('USER_PASS')]);
        $user = User::where('login', env('USER_LOGIN'))->first();

        $I->amOnPage("/profile/$user->id/edit");
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);

        $I->seeInFormFields('#change-user-data-form', [
            'screen_name' => $user->screen_name,
            'phone' => $user->phone,
            'email' => $user->email,
        ]);
    }

    public function  testUpdateData(FunctionalTester $I)
    {
        $this->createTestUser();
        $I->amLoggedAs(['login' => env('USER_LOGIN'), 'password' => env('USER_PASS')]);
        $user = User::where('login', env('USER_LOGIN'))->first();

        $I->amOnPage("/profile/$user->id/edit");

        $I->dontSee('Confirm Password');
        $I->dontSee('Please confirm your password before continuing.');

        $I->submitForm('#change-user-data-form', [
            'screen_name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
        ]);
        $I->dontSeeFormErrors();

//        Как-то не так работает с JS или модалками или че ли
//        dd($I->grabPageSource());
        $I->See('Confirm Password');
        $I->See('Please confirm your password before continuing.');
        $I->fillField('password', env('USER_PASS'));
        $I->click('Confirm Password');

        $I->dontSeeFormErrors();
        $I->dontSee('Confirm Password');
        $I->click('Change User Data');

        $I->see('User data update');

        $I->submitForm('#change-user-data-form', [
            'screen_name' => $this->name,
            'phone' => $this->phone,
            'email' => $this->email,
        ]);
        $I->dontSeeFormErrors();
        $I->dontSee('Confirm Password');
        $I->see('User data update');

        $user = User::where('login', env('USER_LOGIN'))->first();
        $I->assertEquals($this->name, $user->screen_name);
        $I->assertEquals($this->phone, $user->phone);
        $I->assertEquals($this->email, $user->email);

        $I->assertFalse((bool) $user->email_confirmed);
        $I->assertFalse((bool) $user->phone_confirmed);
    }

    public function  testChangePass(FunctionalTester $I)
    {
        $this->createTestUser();
        $I->amLoggedAs(['login' => env('USER_LOGIN'), 'password' => env('USER_PASS')]);
        $user = User::where('login', env('USER_LOGIN'))->first();

        $I->amOnPage("/profile/$user->id/edit");
        $I->click('Change Password');

        $I->seeInCurrentUrl('/password/change');
    }

    public function  testMultifactorSwitch(FunctionalTester $I)
    {
        $this->createTestUser();
        $I->amLoggedAs(['login' => env('USER_LOGIN'), 'password' => env('USER_PASS')]);
        $user = User::where('login', env('USER_LOGIN'))->first();

        $I->amOnPage("/profile/$user->id/edit");
        $I->see('Multi-factor authentication: confirm phone to start');

        $user->setPhone(env('USER_PHONE'));
        $user->confirmPhone();
        $I->amOnPage("/profile/$user->id/edit");
        $I->see('Multi-factor authentication: disabled');

        $I->click('Multi-factor authentication: disabled');

        $I->See('Confirm Password');
        $I->See('Please confirm your password before continuing.');
        $I->fillField('password', env('USER_PASS'));
        $I->click('Confirm Password');

        $I->dontSeeFormErrors();
        $I->dontSee('Confirm Password');
        $I->see('Multi-factor authentication: enabled');
        $user = User::where('login', env('USER_LOGIN'))->first();
        $I->assertTrue((bool) $user->multi_factor);

        $I->click('Multi-factor authentication: enabled');
        $I->see('Multi-factor authentication: disabled');
        $user = User::where('login', env('USER_LOGIN'))->first();
        $I->assertFalse((bool) $user->multi_factor);
    }

    public function testVerifyBtn(FunctionalTester $I)
    {
        $this->createTestUser();
        $I->amLoggedAs(['login' => env('USER_LOGIN'), 'password' => env('USER_PASS')]);
        $user = User::where('login', env('USER_LOGIN'))->first();

        $I->amOnPage("/profile/$user->id/edit");
        $I->See('No phone');
        $I->See('Verify Email');

        $user->setPhone(env('USER_PHONE'));
        $I->amOnPage("/profile/$user->id/edit");
        $I->See('Verify phone');
        $I->See('Verify email');

        $user->confirmPhone();
        $user->confirmEmail();
        $I->amOnPage("/profile/$user->id/edit");
        $I->See('Phone verified');
        $I->See('Email verified');
    }

    public function testVerify(FunctionalTester $I)
    {
        $this->createTestUser();
        $I->amLoggedAs(['login' => env('USER_LOGIN'), 'password' => env('USER_PASS')]);
        $user = User::where('login', env('USER_LOGIN'))->first();
        $user->setPhone($this->phone);

        $I->amOnPage("/profile/$user->id/edit");
        $I->click('Verify phone');

        $I->seeInCurrentUrl('/verify');
        $I->seeCookie('id');

        $user = User::where('login', env('USER_LOGIN'))->first();
        $I->assertTrue((bool) preg_match("/^P-[0-9]{5}$/", $user->getVerifyCode()));

        $I->amOnPage("/profile/$user->id/edit");
        $I->click('Verify email');

        $I->seeInCurrentUrl('/verify');
        $I->seeCookie('id');

        $user = User::where('login', env('USER_LOGIN'))->first();
        $I->assertTrue((bool) preg_match("/^E-[0-9]{5}$/", $user->getVerifyCode()));
    }

    public function testBack(FunctionalTester $I)
    {
        $this->createTestUser();
        $I->amLoggedAs(['login' => env('USER_LOGIN'), 'password' => env('USER_PASS')]);
        $user = User::where('login', env('USER_LOGIN'))->first();

        $I->amOnPage("/profile/$user->id/edit");
        $I->click('Back');
        $I->assertEquals("/profile/$user->id", $I->grabFromCurrentUrl());
    }
}

