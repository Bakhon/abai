<?php

Route::group(['namespace' => 'Admin'], function () {

    Route::get('login', 'AuthController@showLoginForm');
    Route::post('login', 'AuthController@login')->name('admin.login');
    Route::get('logout', 'AuthController@logout')->name('admin.logout');

    Route::group(['middleware' => 'auth:admin'], function () {

        Route::get('/', 'HomeController@index');

        Route::get('users/list', 'UsersController@list')->name('admin.users.list');
        Route::get('users/{user}/logs', 'UsersController@pageViewLogs')->name('admin.users.logs');
        Route::resource('users','UsersController', ['as' => 'admin'])
            ->only(['index', 'show', 'edit', 'update']);

        Route::get('roles/list', 'RolesController@list')->name('admin.roles.list');
        Route::resource('roles','RolesController', ['as' => 'admin']);
        
        Route::get('/accesses-list', 'AccessesController@index')->name('accesses-list');
        Route::get('/accesses-list/{id?}/edit', 'AccessesController@edit');
        Route::post('accesses-update', 'AccessesController@update')->name('accesses-update');

    });

});



