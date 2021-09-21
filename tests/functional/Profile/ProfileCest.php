<?php

namespace Tests\functional\Profile;

use App\Models\User;
use FunctionalTester;

class ProfileCest
{
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

    public function testInfo(FunctionalTester $I)
    {
        $this->createTestUser();
        $user = User::where('login', env('USER_LOGIN'))->first();
        $I->amOnPage("profile/$user->id");

        $I->see($user->screen_name);
        $I->see($user->role);
        $I->see($user->status);
    }

    public function testDontSeeEditBtn(FunctionalTester $I)
    {
        $this->createTestUser();
        $user = User::where('login', env('USER_LOGIN'))->first();

        $I->amOnPage("/profile/$user->id");
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);

        $I->dontSeeLink('Edit', "/profile/$user->id/edit");
    }

    public function testSeeEditBtn(FunctionalTester $I)
    {
        $this->createTestUser();
        $I->amLoggedAs(['login' => env('USER_LOGIN'), 'password' => env('USER_PASS')]);

        $user = User::where('login', env('USER_LOGIN'))->first();
        $I->amOnPage("/profile/$user->id");
        $I->seeResponseCodeIs(\Codeception\Util\HttpCode::OK);

        $I->seeLink('Edit', "/profile/$user->id/edit");
    }
}
