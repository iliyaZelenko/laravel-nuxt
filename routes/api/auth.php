<?php

Route::group(['namespace' => 'Auth', 'prefix' => 'auth'], function () {
    // для входа по id пользователя
    // if (config('app.env') === 'local') {
        Route::post('login-by-id', 'AuthController@devAuthInfoByUser');
    // }

    Route::prefix('soc')->group(function () {
        Route::post('get-redirect-url', 'SocialiteController@getRedirectUrl');
        Route::post('get-soc-user', 'SocialiteController@getUserSocialite');
        Route::middleware(['auth:api'])->group(function () {
            Route::post('save-soc-acc', 'SocialiteController@loggedInUserSaveSocAcc');
            Route::post('delete-soc-acc', 'SocialiteController@loggedInUserDeleteSocAcc');
        });
    });

    Route::middleware(['guest'])->group(function () {
        Route::post('login', 'AuthController@login');
        Route::post('signup', 'AuthController@signup');

        Route::post('reset-password-email', 'ForgotPasswordController@sendResetLinkEmail');
        Route::post('reset-password', 'ResetPasswordController@reset');
    });
    Route::middleware(['auth:api'])->group(function () {
        Route::post('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
        Route::post('verify', 'AuthController@emailVerify');
        // Route::middleware(['throttle:5,1'])->group(function () {
        Route::post('repeat-verification-mail', 'AuthController@repeatVerificationMail');
        // });
    });
});
