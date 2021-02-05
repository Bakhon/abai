<?php

Route::group(
    ['prefix' => App\Http\Middleware\LocaleMiddleware::getLocale()],
    function () {
        Route::group(
            ['middleware' => 'auth', 'prefix' => 'bigdata'],
            function () {

                Route::get('/', 'bd\DBController@bigdata')->name('bigdata');
                Route::resource('wells', 'bd\WellsController', ['as' => 'bigdata']);
                Route::get('dict/{dict}', 'bd\DictionariesController@get')->name('bigdata.dictionary');

            }
        );
    }
);
