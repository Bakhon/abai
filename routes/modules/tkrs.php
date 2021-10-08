<?php

Route::group(
    ['prefix' => App\Http\Middleware\LocaleMiddleware::getLocale()],
    function () {
        Route::group(
            ['middleware' => 'auth'],
            function () {
                Route::get('/tkrsMain', 'tkrs\TkrsController@tkrs')->name('tkrsMain');
                Route::get('/hookWeightSensor', 'tkrs\TkrsController@tkrs')->name('hookWeightSensor');
                Route::get('/hookWeightSensorAnalyse', 'tkrs\TkrsController@tkrs')->name('hookWeightSensorAnalyse');
            }
        );
    }
);