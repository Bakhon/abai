<?php

Route::group(
    ['prefix' => App\Http\Middleware\LocaleMiddleware::getLocale()],
    function () {
        Route::group(
            [
              'prefix'      => 'paegtm',
              'middleware'  => 'auth'
            ],
            function () {
                Route::get('/', 'GTM\GTMController@index')->name('gtm_index');
                Route::get('/get-gtms', 'GTM\GTMController@getGtmInfo');
                Route::get('/get-main-table-data', 'GTM\GTMController@getMainTableData');
                Route::get('/get-main-indicator-data', 'GTM\GTMController@getMainIndicatorData');
                Route::get('/get-additional-indicator-data', 'GTM\GTMController@getAdditionalIndicatorData');
                Route::get('/get-chart-data', 'GTM\GTMController@getChartData');
            }
        );
    }
);
