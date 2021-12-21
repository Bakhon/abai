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

            Route::get('/factor-analysis', function() {
                return view('digital_rating.factor');
            })->name('factor-analysis');

            Route::get('/get_environment', 'DigitalRating\DigitalRatingContoller@get_environment')->name('get_environment');   
            Route::get('/get_injection_wells', 'DigitalRating\DigitalRatingContoller@get_injection_wells')->name('get_injection_wells');
            
            Route::get('/api/getCompaerData', 'DigitalRating\DigitalRatingCompareDrilling@getCompaerData')->name('getCompaerData');
            Route::get('/api/getActualProjectPoints', 'DigitalRating\DigitalRatingCompareDrilling@getActualProjectPoints')->name('getActualProjectPoints');
            Route::get('/api/getMapCoordinates', 'DigitalRating\DigitalRatingCompareDrilling@getMapCoordinates')->name('getMapCoordinates');
            Route::get('/api/getHorizon', 'DigitalRating\DigitalRatingCompareDrilling@getHorizon')->name('getHorizon');
        });
    });
