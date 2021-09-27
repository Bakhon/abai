<?php

Route::group(
    ['prefix' => App\Http\Middleware\LocaleMiddleware::getLocale()],
    function () {
        Route::group(
            ['middleware' => 'auth'],
            function () {
                Route::get('/tkrs', 'tkrs\TkrsController@tkrs')->name('tkrs');
            }
        );
    }
);