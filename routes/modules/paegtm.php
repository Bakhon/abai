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

                Route::group(['prefix' => 'refslist'], function () {
                    Route::get('/', 'GTM\EcoRefs\BaseController@index')->name('paegtm-refs-list');
                    Route::get('/gtm-fact-costs-ref/upload-excel', 'GTM\EcoRefs\GtmFactCostsController@uploadExcel')->name('paegtm-gtm-fact-costs-upload-excel');
                    Route::post('/gtm-fact-costs-ref/import-excel', 'GTM\EcoRefs\GtmFactCostsController@importExcel')->name('paegtm-gtm-fact-costs-import-excel');
                });
            }
        );
    }
);
