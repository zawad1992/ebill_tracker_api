<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/healthcheck', function () {
    return response()->json(['status' => 'ok']);
});

Route::post('/user/register', 'App\Http\Controllers\AuthenitcationsController@register');
Route::post('/user/authenticate', 'App\Http\Controllers\AuthenitcationsController@authenticate');

Route::middleware('auth:sanctum', 'last.activity')->group(function () {
    Route::post('/user/logout', 'App\Http\Controllers\AuthenitcationsController@logout');
    Route::get('/user', 'App\Http\Controllers\UsersController@userinfo');

    Route::get('/billlogs/types', 'App\Http\Controllers\BillLogsController@getBillLogType');
    Route::get('/billlogs', 'App\Http\Controllers\BillLogsController@index');
    Route::get('/billlogs/{id}', 'App\Http\Controllers\BillLogsController@show');
    Route::post('/billlogs/add', 'App\Http\Controllers\BillLogsController@store');
    Route::put('/billlogs/edit/{id}', 'App\Http\Controllers\BillLogsController@update');
    Route::delete('/billlogs/delete/{id}', 'App\Http\Controllers\BillLogsController@destroy');

});