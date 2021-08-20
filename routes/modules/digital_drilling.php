<?php
Route::group(
    ['prefix' => App\Http\Middleware\LocaleMiddleware::getLocale()],
    function () {
        Route::group(['prefix' => '/digital-drilling'], function () {

            Route::group(['prefix' => '/'], function () {
                Route::get('/',                 'DigitalDrilling\BDController@home')->name('digital-drilling');
            });


            // Daily report
            Route::group(['prefix' => '/daily-report'], function () {
                Route::get('/', 'DigitalDrilling\DailyReportController@index')->name('digital-drilling-daily-report');
            });
        });
    });