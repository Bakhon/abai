<?php
Route::group(
    ['prefix' => App\Http\Middleware\LocaleMiddleware::getLocale()],
    function () {
        Route::group(
            ['middleware' => 'auth', 'prefix' => '/digital-rating'], function () {

            Route::get('/', function () {
                return view('digital_rating.home');
            })->name('digital-rating-home');

            Route::get('/reports', function () {
                return view('digital_rating.reports');
            })->name('digital-rating-report');
            Route::get('/serach_wells', 'DigitalRatingContoller@serach_wells')->name('serach_wells');   
        });
    });
