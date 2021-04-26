<?php

use Illuminate\Support\Facades\Route;

Route::group([
    'prefix'     => 'register',
    'as'         => '.register',
], function () {
    Route::post('/', 'RegisterController@register')->name('.register-account');
    Route::get('/confirm-email/{email}/token/{token}', 'RegisterController@confirmEmail')->name('.confirm-email');
});

Route::post('login', 'LoginController@login')->name('.login');
Route::post('logout', 'LoginController@logout')->name('.logout')->middleware(['auth:api','jwt.verify']);
Route::post('refresh-token', 'LoginController@refreshToken')->name('.refresh-token'); //->middleware('jwt.refresh');
