<?php

Route::group(['prefix' => App\Http\Middleware\LocaleMiddleware::getLocale()], function () {

    Route::group(['middleware' => 'auth'], function () {

        Route::group(['prefix' => 'geology', 'namespace' => 'Geology'], function () {

            Route::resource('petrophysics', 'PetrophysicsController');
            Route::resource('core', 'CoreController');
            Route::resource('visualization', 'VisualizationController');
            Route::resource('geophysics', 'GeophysicsController');

        });
    }
    );
}
);
