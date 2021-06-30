<?php
Route::group(
    ['prefix' => App\Http\Middleware\LocaleMiddleware::getLocale()],
    function () {
        Route::group(['prefix' => '/digital-rating'], function () {
            Route::get('/', function () {
                return view('digital_rating.home');
            })->name('digital-rating-home');
        });
    });
