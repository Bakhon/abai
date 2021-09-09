<?php

Route::group(
    ['prefix' => App\Http\Middleware\LocaleMiddleware::getLocale()],
    function () {
        Route::group(
            ['middleware' => 'auth'],
            function () {
                Route::get('/pf', 'PlastFluids\PlastFluidsController@pf')->name('pf');
                Route::get('/pf-upload-monitoring', 'PlastFluids\PlastFluidsController@pfUploadMonitoring')->name('pf-upload-monitoring');
                Route::get('/pf-download-monitoring', 'PlastFluids\PlastFluidsController@pfDownloadMonitoring')->name('pf-download-monitoring');
                Route::get('/pf-data-analysis', function () {
                    return view('plastfluids.pf-data-analysis');
                })->name('pf-data-analysis');
            }
        );
    }
);
