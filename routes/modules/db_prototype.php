<?php

Route::group(
    ['prefix' => App\Http\Middleware\LocaleMiddleware::getLocale()],
    function () {
        Route::group(
            ['middleware' => 'auth', 'prefix' => 'bigdata'],
            function () {
                Route::get('/', 'bd\DBController@bigdata')->name('bigdata');
                Route::get('/las', 'bd\DBController@las')->name('las');
                Route::get('/well_cart', 'bd\DBController@well_cart')->name('well_cart');
                Route::get('/report_constructor', 'bd\DBController@report_constructor')->name('report_constructor');
                Route::get('/user_reports', 'bd\DBController@userReports')->name('userReports');

                Route::get('/geo-data-reference-book', 'bd\DBController@geoDataReferenceBook')->name('bigdata.geoDataReferenceBook');

                Route::get('/reports', 'bd\DBController@reports')->name('bigdata.reports');
                Route::get('/reports/favorite', 'bd\DBController@favoriteReports')->name('bigdata.reports.favorite');
                Route::post('/reports/favorite/{report}', 'bd\DBController@addReportToFavorites')->name(
                    'bigdata.reports.favorite.add'
                );
                Route::delete('/reports/favorite/{report}', 'bd\DBController@removeReportFromFavorites')->name(
                    'bigdata.reports.favorite.remove'
                );

                Route::get('/protoform', 'bd\DBController@form')->name('bigdata.protoform');
                Route::get('/mobileform', 'bd\DBController@mobileForm')->name('bigdata.form.mobile');
                Route::post('/mobileform', 'Api\DB\FormsController@saveMobileForm');
                Route::get('/mobileform/values', 'Api\DB\FormsController@getMobileFormValues');

                Route::resource('wells', 'bd\WellsController', ['as' => 'bigdata']);
            }
        );
    }
);

Route::group(
    ['prefix' => App\Http\Middleware\LocaleMiddleware::getLocale()],
    function () {
        Route::group(
            ['middleware' => 'auth', 'prefix' => 'api/bigdata'],
            function () {
                Route::get('dict/geos/{org}', 'bd\DictionariesController@getGeoByOrg');
                Route::get('dict/{dict}', 'bd\DictionariesController@get')->name('bigdata.dictionary');

                Route::get('forms/{form}', 'Api\DB\FormsController@getParams')->name('bigdata.form.params');
                Route::post('forms/{form}', 'Api\DB\FormsController@submit')->name('bigdata.form.send');
                Route::get('forms/{form}/history', 'Api\DB\FormsController@getHistory');
                Route::get('forms/{form}/rows', 'Api\DB\FormsController@getRows');
                Route::get('forms/{form}/row-history', 'Api\DB\FormsController@getRowHistory');
                Route::get('forms/{form}/row-history-graph', 'Api\DB\FormsController@getRowHistoryGraph');
                Route::get('forms/{form}/copy', 'Api\DB\FormsController@copyFieldValue');
                Route::get('forms/{form}/well-prefix', 'Api\DB\FormsController@getWellPrefix');
                Route::post('forms/{form}/validate/{field}', 'Api\DB\FormsController@validateField')->name(
                    'bigdata.form.validate.field'
                );
                Route::patch('forms/{form}/save/{field}', 'Api\DB\FormsController@saveField')->name(
                    'bigdata.form.save.field'
                );

                Route::get('forms/{form}/results', 'Api\DB\FormsController@getResults');
                Route::delete('forms/{form}/{row}', 'Api\DB\FormsController@delete');

                Route::get('wells/search', 'Api\DB\WellsController@search');
                Route::get('wells/{well}', 'Api\DB\WellsController@get');
                Route::get('wells/{well}/status', 'Api\DB\WellsController@status');
                Route::get('wells/{well}/category', 'Api\DB\WellsController@category');
                Route::get('wells/{well}/category_last', 'Api\DB\WellsController@category_last');
                Route::get('wells/{well}/well_expl', 'Api\DB\WellsController@well_expl');
                Route::get('wells/{well}/well_type', 'Api\DB\WellsController@well_type');
                Route::get('wells/{well}/techs', 'Api\DB\WellsController@techs');
                Route::get('wells/{well}/geo', 'Api\DB\WellsController@geo');
                Route::get('wells/{well}/org', 'Api\DB\WellsController@org');
                Route::get('wells/{well}/tube_nom', 'Api\DB\WellsController@tube_nom');
                Route::get('wells/{well}/spatial_object', 'Api\DB\WellsController@spatial_object');
                Route::get('wells/{well}/spatial_object_bottom', 'Api\DB\WellsController@spatial_object_bottom');
            }
        );
    }
);