<?php

Route::group(['namespace' => 'Admin'], function () {

    Route::get('login', 'AuthController@showLoginForm');
    Route::post('login', 'AuthController@login')->name('admin.login');
    Route::get('logout', 'AuthController@logout')->name('admin.logout');

    Route::group(['middleware' => 'auth:admin'], function () {

        Route::get('/', 'HomeController@index');

        Route::get('users/list', 'UsersController@list')->name('admin.users.list');
        Route::resource('users','UsersController')
            ->only(['index', 'show', 'edit', 'update'])
            ->names([
                'index' => 'admin.users.index',
                'show' => 'admin.users.show',
                'edit' => 'admin.users.edit',
                'update' => 'admin.users.update',
            ]);

    });

});



