<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::group([
//     'prefix' => 'auth',
//     'namespace' => 'API'
// ], function () {

Route::namespace('API')->group(function () {
    // app_path('Http/routes/api/auth.php');
    // app_path('Http/routes/api/profile.php');
    // app_path('Http/routes/api/other.php');
    require base_path('routes/api/auth.php');
    require base_path('routes/api/profile.php');
    require base_path('routes/api/other.php');
    // require __DIR__ . './api/auth.php';
    // require __DIR__ . './api/profile.php';
    // require __DIR__ . './api/other.php';
});

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
