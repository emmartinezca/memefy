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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/authenticate','AuthenticateController@authenticate');

Route::get('/me/data', 'AuthenticateController@getProfile');

Route::post('/users/validate/email','UserController@validateEmail');

Route::resource('users','UserController');

Route::resource('posts','PostController');

Route::resource('likes','LikeController');
