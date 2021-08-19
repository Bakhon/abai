<?php

Route::group(
    ['prefix' => App\Http\Middleware\LocaleMiddleware::getLocale()],
    function () {
        Route::group(
            ['middleware' => 'auth', 'prefix' => 'bigdata'],
            function () {
                Route::get('/', 'bd\DBController@bigdata')->name('bigdata');
                Route::get('/las', 'bd\DBController@las')->name('las');
                Route::get('/well-cart', 'bd\DBController@well_cart')->name('bigdata.well_cart');
                Route::get('/report-constructor', 'bd\DBController@report_constructor')->name('report_constructor');
                Route::get('/user_reports', 'bd\DBController@userReports')->name('userReports');
                Route::get('/field-list', 'bd\DBController@field_list')->name('field_list');

                Route::get('file-status/list', 'Refs\bigdata\las\FileStatusController@list')->name('file-status.list');
                Route::resource('/file-status', 'Refs\bigdata\las\FileStatusController');

                Route::get('file-type/list', 'Refs\bigdata\las\FileTypeController@list')->name('file-type.list');
                Route::resource('/file-type', 'Refs\bigdata\las\FileTypeController');

                Route::get('recording-method/list', 'Refs\bigdata\las\RecordingMethodController@list')->name('recording-method.list');
                Route::resource('/recording-method', 'Refs\bigdata\las\RecordingMethodController');

                Route::get('recording-state/list', 'Refs\bigdata\las\RecordingStateController@list')->name('recording-state.list');
                Route::resource('/recording-state', 'Refs\bigdata\las\RecordingStateController');

                Route::get('stem-section/list', 'Refs\bigdata\las\StemSectionController@list')->name('stem-section.list');
                Route::resource('/stem-section', 'Refs\bigdata\las\StemSectionController');

                Route::get('/stem-type/list', 'Refs\bigdata\las\StemTypeController@list')->name('stem-type.list');
                Route::resource('/stem-type', 'Refs\bigdata\las\StemTypeController');

                Route::get('/geo-mapping/list', 'Refs\bigdata\mapping\GeoMappingController@list')->name('geo-mapping.list');
                Route::resource('/geo-mapping', 'Refs\bigdata\mapping\GeoMappingController');

                Route::get('/well-mapping/list', 'Refs\bigdata\mapping\WellMappingController@list')->name('well-mapping.list');
                Route::resource('/well-mapping', 'Refs\bigdata\mapping\WellMappingController');

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
                Route::post('/mobileform', 'Api\DB\MobileFormsController@saveMobileForm');
                Route::get('/mobileform/values', 'Api\DB\MobileFormsController@getMobileFormValues');

                Route::resource('wells', 'bd\WellsController', ['as' => 'bigdata']);

                Route::post('/report-constructor/save-template', 'bd\DBController@saveTemplate')->name(
                    'reports.constructor.save.template'
                );
                Route::get('/report-constructor/get-templates', 'bd\DBController@getTemplates')->name(
                    'reports.constructor.get.templates'
                );
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

                Route::get('dzo', 'Api\DB\StructureController@getDzo')->name('bigdata.dzo');

                Route::get('forms', 'Api\DB\FormsController@getForms')->name('bigdata.form.list');
                Route::get('forms/tree', 'Api\DB\FormsController@getFormsStructure')->name('bigdata.form.list');
                Route::get('forms/{form}', 'Api\DB\FormsController@getParams')->name('bigdata.form.params');
                Route::post('forms/{form}', 'Api\DB\FormsController@submit')->name('bigdata.form.send');
                Route::get('forms/{form}/history', 'Api\DB\FormsController@getHistory');
                Route::get('forms/{form}/rows', 'Api\DB\FormsController@getRows');
                Route::get('forms/{form}/row-history', 'Api\DB\FormsController@getRowHistory');
                Route::get('forms/{form}/row-history-graph', 'Api\DB\FormsController@getRowHistoryGraph');
                Route::get('forms/{form}/copy', 'Api\DB\FormsController@copyFieldValue');
                Route::get('forms/{form}/well-prefix', 'Api\DB\FormsController@getWellPrefix');
                Route::get('forms/{form}/form-by-row', 'Api\DB\FormsController@getFormByRow');
                Route::post('forms/{form}/validate/{field}', 'Api\DB\FormsController@validateField')->name(
                    'bigdata.form.validate.field'
                );
                Route::patch('forms/{form}/save/{field}', 'Api\DB\FormsController@saveField')->name(
                    'bigdata.form.save.field'
                );

                Route::post('forms/{form}/calc-fields', 'Api\DB\FormsController@calcFields');
                Route::post('forms/{form}/update-fields', 'Api\DB\FormsController@updateFields');

                Route::get('forms/{form}/results', 'Api\DB\FormsController@getResults');
                Route::delete('forms/{form}/{row}', 'Api\DB\FormsController@delete');

                Route::get('wells/search', 'Api\DB\WellsController@search');
                Route::get('wells/tree', 'Api\DB\WellsController@getStructureTree');
                Route::get('wells/{well}', 'Api\DB\WellsController@get');
                Route::get('wells/{well}/wellInfo', 'Api\DB\WellsController@wellInfo');


                Route::get('tech/wells', 'Api\DB\TechController@getWellsById');
            }
        );
    }
);