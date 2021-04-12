<?php

Route::group(
    ['prefix' => App\Http\Middleware\LocaleMiddleware::getLocale()],
    function () {
        Route::group(
            ['middleware' => 'auth'],
            function () {
                Route::get('/paegtm', 'GTM\GTMController@index')->name('gtm');
            }
        );
    }
);
