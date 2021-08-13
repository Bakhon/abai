<?php
Route::group(
    ['prefix' => App\Http\Middleware\LocaleMiddleware::getLocale()],
    function () {
        Route::group(['prefix' => '/digital-drilling'], function () {
            Route::group(['prefix' => '/'], function () {
                Route::get('/bd', function () {
                    return view('digital_drilling.index');
                })->name('digital-drilling');
            });


            // Daily report
            Route::group(['prefix' => '/daily-report'], function () {
                Route::get('/', function () {
                    return view('digital_drilling.daily_report.index');
                })->name('digital-drilling-daily-report');
            });
        });
    });