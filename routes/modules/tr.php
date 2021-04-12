<?php

Route::group(
    ['prefix' => App\Http\Middleware\LocaleMiddleware::getLocale()],
    function () {
        Route::group(
            ['middleware' => 'auth'],
            function () {
                Route::get('/tr', 'tr\TrController@tr')->name('tr');
                Route::get('/export', 'HomeController@export');
                Route::get('/fa', 'tr\TrController@fa')->name('fa');
                Route::get('/trfa', 'tr\TrController@trfa')->name('trfa');
                Route::get('/tr_charts', 'tr\TrController@tr_charts')->name('tr_charts');
                Route::get('/tech_mode', 'tr\TrController@TechMode')->name('TechMode');
                Route::get('/fa_weekly_chart', 'tr\TrController@FaWeeklyChart')->name('FaWeeklyChart');
            }
        );
    }
);
