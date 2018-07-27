<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/config/{name?}', function ($name = 'app') {
    return config($name);
});


// Working dev and production variant:

// if (App::environment('local')) {
//     Route::get('{uri}', function () {
//         $localSource = config('app.client_url') . '/__laravel_nuxt__';
//
//         return file_get_contents($localSource);
//     })->where('uri', '.*');
// } else {
//     Route::get('{uri}', function ($uri = '/') {
//         $sourceByUri = public_path($uri);
//         if (is_file($sourceByUri)) {
//             return file_get_contents($sourceByUri);
//         }
//
//         $indexSpa = public_path('/_nuxt/index.html');
//         $indexGenerated = storage_path('app/nuxt/index.html');
//         $existingSource = file_exists($indexSpa) ? $indexSpa : $indexGenerated;
//
//         return file_get_contents($existingSource);
//     })->where('uri', '.*');
// }


if (config('app.client_mode') === 'spa') {
    // spa serve on dev or production
    // github.com/skyrpex/laravel-nuxt
    Route::get(
        '{uri}',
        '\\'.Pallares\LaravelNuxt\Controllers\NuxtController::class
    )->where('uri', '.*');
}







// Route::get('{uri}', function () {
//     $source = App::environment('local') ? 'http://localhost:8000/__laravel_nuxt__' : storage_path('app/nuxt/index.html');
//
//     return file_get_contents($source);
// })->where('uri', '.*');
//
// Route::get('{path}', function () {
//     return file_get_contents(public_path('_nuxt/index.html'));
// })->where('path', '(.*)');




// Route::get('/c', function ($name = 'app') {
//     return config('services.vkontakte.redirect');
// });
// Route::get('/game', function ($name = 'app') {
//     return response()->download(public_path('game.apk'));
// });
//
// Route::get('/123', function () {
//     return response()->json(config('app.faker_locale')); // Эта тупая хрень env *** *** *** ***... *** просто не используйте ее в коде!!!! env('FACEBOOK_REDIRECT_URI');
// });
//
// Route::get('/mail', function () {
//     return new App\Mail\EmailVerify(123);
//     // return new App\Mail\ForgotPassword(123);
// });











//
// Route::get('{path}', function () {
//     return file_get_contents(public_path('_nuxt/index.html'));
// })->where('path', '(.*)');
//
// Route::get('a/{uri}', function ($uri = '/') {
//     $source = public_path('/22222222222222' . $uri);
//
//     return $uri;
// })->where('uri', '.*');


// Route::get('/', function () use ($index) {
//     return file_get_contents($index);
// })->where('uri', '.*');
