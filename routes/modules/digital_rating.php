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
            Route::get('/get_environment', 'DigitalRating\DigitalRatingContoller@get_environment')->name('search_wells');   
            Route::get('/get_injection_wells', 'DigitalRating\DigitalRatingContoller@get_injection_wells')->name('get_injection_wells');   
        });
    });
