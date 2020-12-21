<?php

Route::group(['namespace' => 'Admin'], function () {

    Route::get('login', 'AuthController@showLoginForm');
    Route::post('login', 'AuthController@login')->name('admin.login');
    Route::get('logout', 'AuthController@logout')->name('admin.logout');

    Route::group(['middleware' => 'auth:admin'], function () {

        Route::get('/', 'HomeController@index');

    });

});



