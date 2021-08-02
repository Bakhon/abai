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
                Route::get('/get-gtms', 'GTM\GTMController@getAllGtmByDzo');
                Route::get('/get-main-table-data', 'GTM\GTMController@getMainTableData');
            }
        );
    }
);
