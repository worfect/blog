<?php

namespace Tests\functional\Auth;

use App\Models\User;
use Codeception\Example;
use FunctionalTester;

class SocialCest
{
    /**
     * @example ["google"]
     * @example ["github"]
     * @example ["facebook"]
     * @example ["vkontakte"]
     */
    public function testSocialAuth(FunctionalTester $I, Example $example)
    {
        $this->createTestUser();

        $I->amOnPage('/login');

        $I->click(['id' => 'auth-' . $example[0]]);
        $I->seeInCurrentUrl($example[0]);

//      а черт его знает как

//        sleep(5);
//
//        $I->seeAuthentication();
//
//        if($example[0] == "google"){
//            $this->testLogin($I);
//        }else{
//            $this->testRegister($I);
//        }
    }
//
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
//
//    protected function testRegister(FunctionalTester $I)
//    {
//        $I->seeNumRecords(2, 'users');
//        $I->seeRecord('App\Models\User', [
//            'role' => User::ROLE_USER,
//            'status' => User::STATUS_ACTIVE,
//            'id' => 2,
//            'login' => 'id_2',
//        ]);
//    }
//
//    protected function  testLogin(FunctionalTester $I)
//    {
//        $I->seeNumRecords(1, 'users');
//        $I->seeRecord('App\Models\User', [
//            'id' => 1,
//            'login' => env('USER_LOGIN'),
//        ]);
//    }
}
