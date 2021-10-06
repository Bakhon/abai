<?php
Route::group(
    ['prefix' => App\Http\Middleware\LocaleMiddleware::getLocale()],
    function () {
        Route::group(['middleware' => 'auth', 'prefix' => '/digital-drilling'], function () {

            Route::group(['prefix' => '/'], function () {
                Route::get('/',                 'DigitalDrilling\BDController@index')->name('digital-drilling');
            });


            Route::group(['prefix' => '/daily-report'], function () {
                Route::get('/', 'DigitalDrilling\DailyReportController@index')->name('digital-drilling-daily-report');
            });
            Route::group(['prefix' => '/daily-report-import'], function () {
                Route::get('/', 'DigitalDrilling\DailyReportController@raport')->name('digital-drilling-import-daily-report');
            });
        });
    });