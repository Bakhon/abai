<?php

Route::group(
    ['prefix' => App\Http\Middleware\LocaleMiddleware::getLocale()],
    function () {
        Route::group(
            ['middleware' => 'auth', 'prefix' => 'bigdata'],
            function () {
                Route::get('/', 'bd\DBController@bigdata')->name('bigdata');
                Route::get('form/{form}', 'bd\FormsController@getParams')->name('bigdata.form.params');
                Route::post('form/{form}', 'bd\FormsController@submit')->name('bigdata.form.send');
                Route::resource('wells', 'bd\WellsController', ['as' => 'bigdata']);
                Route::get('dict/{dict}', 'bd\DictionariesController@get')->name('bigdata.dictionary');
            }
        );
    }
);
