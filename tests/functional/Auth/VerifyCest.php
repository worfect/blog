<?php


namespace Tests\functional\Auth;

use App\Models\User;
use Carbon\Carbon;
use Codeception\Example;
use FunctionalTester;
use Illuminate\Support\Facades\Auth;

class VerifyCest
{
    protected function createTestUser($code, $expired)
    {
        factory(User::class)->create([
            'login' => env('USER_LOGIN'),
            'screen_name' => env('USER_LOGIN'),
            'password' =>  env('USER_PASS_CRYPT'),
            'email' => env('USER_EMAIL'),
            'phone' =>  env('USER_PHONE'),
            'status' => User::STATUS_WAIT,
            'role' => User::ROLE_USER,
            'phone_confirmed' => 0,
            'email_confirmed' => 0,
            'verify_code' => $code,
            'expired_token' => $expired,
        ]);
    }

    public function testDenialAccess(FunctionalTester $I)
    {
        $this->createTestUser(null,null);
        $I->amLoggedAs(['login' => env('USER_LOGIN'), 'password' => env('USER_PASS')]);

        $I->amOnPage('/verify');
        $I->seeInCurrentUrl('/profile');
    }

    /**
     * @example { "source": "email", "code": "E-11111" }
     * @example { "source": "phone", "code": "P-11111" }
     */
    public function testVerify(FunctionalTester $I, Example $example)
    {
        $this->createTestUser($example['code'], Carbon::now());

        $I->amLoggedAs(['login' => env('USER_LOGIN'), 'password' => env('USER_PASS')]);

        $I->amOnPage('/verify');
        $I->seeInCurrentUrl('/verify');

        $I->submitForm('#verify-form', ['code' => $example['code']], 'verifySubmitButton');

        $I->seeInCurrentUrl('/profile');
        $I->see(trans('verify.success'));
        $I->seeAuthentication();

        $user = Auth::user();

        $I->assertNull($user->verify_code);
        $I->assertNull($user->expired_token);
        $I->assertEquals($user->status, User::STATUS_ACTIVE);


        if($example['source'] == 'email'){
            $I->assertTrue((bool) $user->email_confirmed);
        }
        if($example['source'] == 'phone'){
            $I->assertTrue((bool) $user->phone_confirmed);
        }
    }

    /**
     * @example { "code": "E-11111" }
     * @example { "code": "P-11111" }
     */
    public function testResend(FunctionalTester $I, Example $example)
    {
        $this->createTestUser($example['code'], Carbon::now()->subMinutes(1));

        $I->amLoggedAs(['login' => env('USER_LOGIN'), 'password' => env('USER_PASS')]);


        $I->amOnPage('/verify');
        $I->seeInCurrentUrl('/verify');

        $oldExp = Auth::user()->expired_token;

        $I->submitForm('#resend-form', [], 'resendSubmitButton');



        if(preg_match("/^P/", $example['code'])){
            $I->assertTrue((bool) preg_match("/^P-[0-9]{5}$/", Auth::user()->verify_code));
        }
        if(preg_match("/^E/", $example['code'])){
            $I->assertTrue((bool) preg_match("/^E-[0-9]{5}$/", Auth::user()->verify_code));
        }
        $I->assertNotEquals($example['code'], Auth::user()->verify_code);

        $I->assertNotEquals(Auth::user()->expired_token, $oldExp);
    }

    public function testVerifyCodeError(FunctionalTester $I)
    {
        $this->createTestUser("E-11111", Carbon::now());

        $I->amLoggedAs(['login' => env('USER_LOGIN'), 'password' => env('USER_PASS')]);

        $I->amOnPage('/verify');
        $I->seeInCurrentUrl('/verify');

        $I->submitForm('#verify-form', ['code' => "E-22222"], 'verifySubmitButton');

        $I->seeInCurrentUrl('/verify');
        $I->see(trans('verify.error'));
    }

    public function testVerifyExpiredError(FunctionalTester $I)
    {
        $this->createTestUser("E-11111", Carbon::now()->subMinutes(11));

        $I->amLoggedAs(['login' => env('USER_LOGIN'), 'password' => env('USER_PASS')]);

        $I->amOnPage('/verify');
        $I->seeInCurrentUrl('/verify');

        $I->submitForm('#verify-form', ['code' => "E-11111"], 'verifySubmitButton');

        $I->seeInCurrentUrl('/verify');
        $I->see(trans('verify.error'));
    }
}
