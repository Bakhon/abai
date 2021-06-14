<?php

Route::group(['prefix' => App\Http\Middleware\LocaleMiddleware::getLocale()], function () {

        Route::group(['middleware' => 'auth'], function () {
            
                Route::group(['prefix' => 'geology', 'namespace'=>'Geology'], function () {

                    Route::resource('gis', 'GisController');
        ;           Route::resource('core', 'CoreController');
        
                });
            }
        );
    }
);
