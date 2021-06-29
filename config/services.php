<?php

return [

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],
    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],
    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],



    'github' => [
        'client_id' => env('GITHUB_ID'),
        'client_secret' => env('GITHUB_SECRET'),
        'redirect' => env('APP_URL') . '/auth/github/callback',
    ],
    'google' => [
        'client_id' => env('GOOGLE_ID'),
        'client_secret' => env('GOOGLE_SECRET'),
        'redirect' => env('APP_URL') . '/auth/google/callback',
    ],
    'facebook' => [
        'client_id' => env('FACEBOOK_ID'),
        'client_secret' => env('FACEBOOK_SECRET'),
        'redirect' => env('APP_URL') . '/auth/facebook/callback',
    ],
    'vkontakte' => [
        'client_id' => env('VK_ID'),
        'client_secret' => env('VK_SECRET'),
        'redirect' => env('APP_URL') . '/auth/vkontakte/callback',
    ],

    'sms' => [
        'main' => App\Http\Controllers\Services\Sms\SmsRu::class,
        'reserve' => App\Http\Controllers\Services\Sms\SmsC::class,
    ],

    'sms.ru' => [
        'client_id' => env('VK_ID'),
        'client_secret' => env('VK_SECRET'),
        'redirect' => env('APP_URL') . '/auth/vkontakte/callback',
    ],
];
