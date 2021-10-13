<?php

Route::group(
    ['prefix' => App\Http\Middleware\LocaleMiddleware::getLocale()],
    function () {
        Route::group(
            ['middleware' => 'auth'],
            function () {
                Route::get('/tkrsMain', 'tkrs\TkrsController@tkrsMain')->name('tkrsMain');
                Route::get('/hookWeightSensor', 'tkrs\TkrsController@hookWeightSensor')->name('hookWeightSensor');
                Route::get('/hookWeightSensorAnalyse', 'tkrs\TkrsController@hookWeightSensorAnalyse')->name('hookWeightSensorAnalyse');
                Route::get('/gps', 'tkrs\TkrsController@gps')->name('gps');
                Route::get('/video', 'tkrs\TkrsController@gps')->name('video');
            }
        );
    }
);