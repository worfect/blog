<?php


namespace Tests\functional\Auth\Password;

use App\Models\User;
use Carbon\Carbon;
use Codeception\Example;
use FunctionalTester;
use Illuminate\Support\Facades\Hash;

class ResetCest
{
    /**
     * @return array
     */
    protected function dataProvider(): array
    {
        return [
            ['code' => env('PHONE_CODE'), 'confirmed' => 'phone_confirmed', 'auth' => true],
            ['code' => env('EMAIL_CODE'), 'confirmed' => 'email_confirmed', 'auth' => false]
        ];
    }

    protected function createTestUser($code, $expired)
    {
        factory(User::class)->create([
            'login' => env('USER_LOGIN'),
            'screen_name' => env('USER_LOGIN'),
            'password' =>  'fake',
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

    /**
     * @dataProvider DataProvider
     */
    public function testReset(FunctionalTester $I, Example $example)
    {
        $this->createTestUser($example['code'], Carbon::now());

        if($example['auth']){
            $I->amLoggedAs(['login' => env('USER_LOGIN'), 'password' => env('USER_PASS')]);
        }

        $I->amOnPage('/password/reset');
        $I->seeInCurrentUrl('/password/reset');

        $I->submitForm('#reset-form', ['code' => $example['code'], 'password' => env('USER_PASS'), 'password_confirmation' => env('USER_PASS')]);

        $user = User::where('login', env('USER_LOGIN'))->first();

        $confirmed = $example['confirmed'];
        $I->assertTrue(Hash::check(env('USER_PASS'), $user->password));
        $I->assertTrue((bool)$user->$confirmed);
        $I->assertNull($user->verify_code);
        $I->assertNull($user->expired_token);
        $I->assertEquals($user->status, User::STATUS_ACTIVE);

        if($example['auth']){
            $I->seeInCurrentUrl('profile/' . $user->id);
        }else{
            $I->seeInCurrentUrl('login');
        }

        $I->seeInCurrentUrl('login');
        $I->see(trans('passwords.reset'));
    }

    public function testResetError(FunctionalTester $I)
    {
        $this->createTestUser(env('EMAIL_CODE'), Carbon::now());

        $I->amOnPage('/password/reset');
        $I->seeInCurrentUrl('/password/reset');

        $I->submitForm('#reset-form', ['code' => '', 'password' => '', 'password_confirmation' => '']);

        $I->seeFormErrorMessage('code', trans('passwords.code'));
        $I->seeFormErrorMessage('password', trans('passwords.password'));

        $I->submitForm('#reset-form', ['code' =>  env('EMAIL_CODE'), 'password' => 'qwe', 'password_confirmation' => 'qwe']);
        $I->seeFormErrorMessage('password', trans('passwords.min'));

        $I->submitForm('#reset-form', ['code' => '12345', 'password' => 'qwerty', 'password_confirmation' => 'qwerty']);
        $I->seeInCurrentUrl('/password/reset');
        $I->see(trans('passwords.error'));
    }
}
