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

            Route::get('/compare-drilling', function() {
                return view('digital_rating.compare');
            })->name('digital-rating-compare');
            Route::get('/get_environment', 'DigitalRating\DigitalRatingContoller@get_environment')->name('get_environment');   
            Route::get('/get_injection_wells', 'DigitalRating\DigitalRatingContoller@get_injection_wells')->name('get_injection_wells');
        });
    });
