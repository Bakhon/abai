<?php

Route::group(['namespace' => 'Admin'], function () {

    Route::get('login', 'AuthController@showLoginForm');
    Route::post('login', 'AuthController@login')->name('admin.login');
    Route::get('logout', 'AuthController@logout')->name('admin.logout');

    Route::group(['middleware' => 'auth:admin'], function () {

        Route::get('/', 'HomeController@index');

        Route::get('users/list', 'UsersController@list')->name('admin.users.list');
        Route::resource('users','UsersController', ['as' => 'admin'])
            ->only(['index', 'show', 'edit', 'update']);

        Route::get('roles/list', 'RolesController@list')->name('admin.roles.list');
        Route::resource('roles','RolesController', ['as' => 'admin']);

    });

});



