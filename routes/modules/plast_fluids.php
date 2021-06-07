<?php

Route::group(
    ['prefix' => App\Http\Middleware\LocaleMiddleware::getLocale()],
    function () {
        Route::group(
            ['middleware' => 'auth'],
            function () {
                Route::get('/pf', 'PlastFluids\PlastFluidsController@pf')->name('pf');
                Route::get('/pf_template_pvt_plast_oil', 'PlastFluids\PlastFluidsController@pf_tmpl_pvt_plast_oil')->name('pf_template_pvt_plast_oil');
                Route::get('/pf_upload_monitoring', 'PlastFluids\PlastFluidsController@pf_upload_monitoring')->name('pf_upload_monitoring');
            }
        );
    }
);