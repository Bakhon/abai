<?php

Route::group(
    ['prefix' => App\Http\Middleware\LocaleMiddleware::getLocale()],
    function () {
        Route::group(
            ['middleware' => 'auth'],
            function () {
                Route::get('/pf', 'PlastFluids\PlastFluidsController@pf')->name('pf');
                Route::get('/pf-upload-monitoring', 'PlastFluids\PlastFluidsController@pfUploadMonitoring')->name('pf-upload-monitoring');
                Route::get('/pf-standart-separation-flash', 'PlastFluids\PlastFluidsController@pfStandartSeparationFlash')->name('pf-standart-separation-flash');
                Route::get('/pf-data-analysis', function () {
                    return view('plastfluids.pf-data-analysis');
                })->name('pf-data-analysis');
            }
        );
    }
);
