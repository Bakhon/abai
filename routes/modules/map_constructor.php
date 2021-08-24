<?php

Route::group(
    ['prefix' => App\Http\Middleware\LocaleMiddleware::getLocale()],
    function () {
        Route::group(
            ['middleware' => 'auth'],
            function () {
                Route::get('/map-constructor', 'MapConstructor\MapConstructorController@index')->name('map_constructor_index');
            }
        );
    }
);
