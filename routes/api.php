<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


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

Route::get('/healthcheck', function () {
    return response()->json(['status' => 'ok']);
});


Route::post('/user/authenticate', 'App\Http\Controllers\AuthenitcationsController@authenticate');

Route::middleware('auth:sanctum', 'last.activity')->group(function () {
    Route::get('/user', 'App\Http\Controllers\UsersController@userinfo');
    Route::post('/user/logout', 'App\Http\Controllers\AuthenitcationsController@logout');
});