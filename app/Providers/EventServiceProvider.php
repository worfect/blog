<?php

namespace App\Providers;

use App\Events\ContentDeleted;
use App\Events\ContentRestored;
use App\Events\RequestVerification;
use App\Events\UserDeleted;
use App\Events\UserRestored;
use App\Listeners\ContentDeletedListener;
use App\Listeners\ContentRestoredListener;
use App\Listeners\RequestVerificationListener;
use App\Listeners\UserDeletedListener;
use App\Listeners\UserRestoredListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use SocialiteProviders\Manager\SocialiteWasCalled;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        RequestVerification::class => [
            RequestVerificationListener::class,
        ],
        ContentDeleted::class => [
            ContentDeletedListener::class,
        ],
        ContentRestored::class => [
            ContentRestoredListener::class,
        ],
        UserDeleted::class => [
            UserDeletedListener::class,
        ],
        UserRestored::class => [
            UserRestoredListener::class,
        ],
        SocialiteWasCalled::class => [
            // add your listeners (aka providers) here
            'SocialiteProviders\\VKontakte\\VKontakteExtendSocialite@handle',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
