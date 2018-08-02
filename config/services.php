<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => env('SES_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],


    'vkontakte' => [
        'client_id' => env('VKONTAKTE_KEY'),
        'client_secret' => env('VKONTAKTE_SECRET'),
        'redirect' => env('APP_CLIENT_URL') . env('VKONTAKTE_REDIRECT_URI'),
    ],
    // ??? почему-то когда удаляю тут именно фейсбук, то он не работает.
    'facebook' => [
        'client_id' => env('FACEBOOK_KEY'),
        'client_secret' => env('FACEBOOK_SECRET'),
        'redirect' => env('APP_CLIENT_URL') . env('FACEBOOK_REDIRECT_URI'),
    ],

    'google' => [
        'client_id' => env('GOOGLE_KEY'),
        'client_secret' => env('GOOGLE_SECRET'),
        'redirect' => env('APP_CLIENT_URL') . env('GOOGLE_REDIRECT_URI'),
    ],

    // 'twitter' => [
    //     'client_id' => env('TWITTER_KEY'),
    //     'client_secret' => env('TWITTER_SECRET'),
    //     'redirect' => env('﻿APP_CLIENT_URL') .env('TWITTER_REDIRECT_URI')
    // ],

    'instagram' => [
        'client_id' => env('INSTAGRAM_KEY'),
        'client_secret' => env('INSTAGRAM_SECRET'),
        'redirect' => env('APP_CLIENT_URL') . env('INSTAGRAM_REDIRECT_URI')
    ],

    'reddit' => [
        'client_id' => env('REDDIT_KEY'),
        'client_secret' => env('REDDIT_SECRET'),
        'redirect' => env('APP_CLIENT_URL') . env('REDDIT_REDIRECT_URI')
    ],
];
