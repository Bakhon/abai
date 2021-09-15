<?php

Route::group(
    ['prefix' => App\Http\Middleware\LocaleMiddleware::getLocale()],
    function () {
        Route::group(
            ['middleware' => 'auth'],
            function () {
                Route::get('/water-flooding-management', 'WaterFloodingManagement\WaterFloodingManagementController@index')->name('waterflooding_management');
            }
        );
    }
);