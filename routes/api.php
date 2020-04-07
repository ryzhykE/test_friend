<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1', 'namespace' => 'Api'], function(){

    Route::group(['namespace' => 'Auth'], function () {
        Route::post('register', 'RegisterController@register');
        Route::post('login', 'LoginController@login');
        Route::post('logout', 'LoginController@logout')->middleware('auth:api');
    });

    Route::group(['middleware' => 'auth:api'], function(){
        Route::apiResources([
            '/user' => 'UserController',
            '/friend-request'  => 'FriendRequestController',
            '/friend-response'  => 'FriendResponseController',
        ]);
    });
});


