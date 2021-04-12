<?php

Route::group(
    ['prefix' => App\Http\Middleware\LocaleMiddleware::getLocale()],
    function () {
        Route::group(
            ['middleware' => 'auth'],
            function () {
                Route::get('watermeasurement/list', 'ComplicationMonitoring\WaterMeasurementController@list')->name(
                    'watermeasurement.list'
                );
                Route::get('watermeasurement/export', 'ComplicationMonitoring\WaterMeasurementController@export')->name(
                    'watermeasurement.export'
                );
                Route::get(
                    'watermeasurement/history/{watermeasurement}',
                    'ComplicationMonitoring\WaterMeasurementController@history'
                )->name('watermeasurement.history');
                Route::resource('watermeasurement', 'ComplicationMonitoring\WaterMeasurementController');

                Route::get('/getfields', 'ComplicationMonitoring\WaterMeasurementController@getFields');
                Route::get('/getotherobjects', 'ComplicationMonitoring\WaterMeasurementController@getOtherObjects');
                Route::get('/getngdu', 'ComplicationMonitoring\WaterMeasurementController@getNgdu');
                Route::get('/getallngdu', 'ComplicationMonitoring\WaterMeasurementController@getAllNgdu');
                Route::get('/getcdng', 'ComplicationMonitoring\WaterMeasurementController@getCdng');
                Route::get('/getallcdng', 'ComplicationMonitoring\WaterMeasurementController@getAllCdng');
                Route::post('/getgu', 'ComplicationMonitoring\WaterMeasurementController@getGu');
                Route::get('/getallgus', 'ComplicationMonitoring\WaterMeasurementController@getAllGu');
                Route::get('/get_all_monitoring_data', 'ComplicationMonitoring\WaterMeasurementController@getAllMonitoringData');
                Route::post('/getzu', 'ComplicationMonitoring\WaterMeasurementController@getZu');
                Route::post('/get_gu_relations', 'ComplicationMonitoring\WaterMeasurementController@getGuRelations');
                Route::post('/get_zu_relations', 'ComplicationMonitoring\WaterMeasurementController@getZuRelations');
                Route::post('/get_ngdu_relations', 'ComplicationMonitoring\WaterMeasurementController@getNgduRelations');
                Route::post('/get_cdng_relations', 'ComplicationMonitoring\WaterMeasurementController@getCdngRelations');
                Route::get('/getallzu', 'ComplicationMonitoring\WaterMeasurementController@getAllZu');
                Route::post('/getwell', 'ComplicationMonitoring\WaterMeasurementController@getWell');
                Route::get('/getallwell', 'ComplicationMonitoring\WaterMeasurementController@getAllWell');
                Route::post('/getallwell', 'ComplicationMonitoring\WaterMeasurementController@getAllWell');
                Route::get('/getwbs', 'ComplicationMonitoring\WaterMeasurementController@getWaterBySulin');
                Route::get('/getsrb', 'ComplicationMonitoring\WaterMeasurementController@getSulphateReducingBacteria');
                Route::get(
                    '/gethob',
                    'ComplicationMonitoring\OmgNGDUController@getHydrocarbonOxidizingBacteria'
                );

                Route::get('/gethb', 'ComplicationMonitoring\WaterMeasurementController@getThionicBacteria');
                Route::post('/getwm', 'ComplicationMonitoring\WaterMeasurementController@getWm');
                Route::get('/getallkormasses', 'ComplicationMonitoring\WaterMeasurementController@getAllKormasses');
                Route::post('/getgudata', 'ComplicationMonitoring\WaterMeasurementController@getGuData');
                Route::post('/getgudatabyday', 'ComplicationMonitoring\OmgNGDUController@getGuDataByDay');
                Route::get('/getguproblems', 'ComplicationMonitoring\OmgNGDUController@getProblemGuToday');

                Route::get('/getmaterials', 'RefsController@getMaterials');
                Route::get('/getinhibitors', 'RefsController@getInhibitors');


                Route::post('/updatewm', 'ComplicationMonitoring\WaterMeasurementController@update')->name('updatewm');

                Route::get('omgca/list', 'ComplicationMonitoring\OmgCAController@list')->name('omgca.list');
                Route::get('omgca/export', 'ComplicationMonitoring\OmgCAController@export')->name('omgca.export');
                Route::get('omgca/history/{omgca}', 'ComplicationMonitoring\OmgCAController@history')->name(
                    'omgca.history'
                );
                Route::resource('omgca', 'ComplicationMonitoring\OmgCAController');

                Route::get('omguhe/list', 'ComplicationMonitoring\OmgUHEController@list')->name('omguhe.list');
                Route::get('omguhe/export', 'ComplicationMonitoring\OmgUHEController@export')->name('omguhe.export');
                Route::get('omguhe/history/{omguhe}', 'ComplicationMonitoring\OmgUHEController@history')->name(
                    'omguhe.history'
                );
                Route::resource('omguhe', 'ComplicationMonitoring\OmgUHEController');

                Route::get('omgngdu/list', 'ComplicationMonitoring\OmgNGDUController@list')->name('omgngdu.list');
                Route::get('omgngdu/export', 'ComplicationMonitoring\OmgNGDUController@export')->name('omgngdu.export');
                Route::get('omgngdu/history/{omgngdu}', 'ComplicationMonitoring\OmgNGDUController@history')->name(
                    'omgngdu.history'
                );
                Route::resource('omgngdu', 'ComplicationMonitoring\OmgNGDUController');


                Route::get('omgngdu_well/list', 'ComplicationMonitoring\OmgNGDUWellController@list')->name(
                    'omgngdu_well.list'
                );
                Route::resource('omgngdu_well', 'ComplicationMonitoring\OmgNGDUWellController');


                Route::post(
                    '/getgucdngngdufield',
                    'ComplicationMonitoring\WaterMeasurementController@getGuNgduCdngField'
                );

                Route::get('oilgas/list', 'ComplicationMonitoring\OilGasController@list')->name('oilgas.list');
                Route::get('oilgas/export', 'ComplicationMonitoring\OilGasController@export')->name('oilgas.export');
                Route::get('oilgas/history/{oilgas}', 'ComplicationMonitoring\OilGasController@history')->name(
                    'oilgas.history'
                );
                Route::resource('oilgas', 'ComplicationMonitoring\OilGasController')->parameters(
                    ['oilgas' => 'oilgas']
                );

                Route::get('pipes/list', 'PipeController@list')->name('pipes.list');
                Route::get('pipes/export', 'PipeController@export')->name('pipes.export');
                Route::get('pipes/history/{pipe}', 'PipeController@history')->name('pipes.history');
                Route::resource('pipes', 'PipeController');

                Route::get('pipe_types/list', 'ComplicationMonitoring\PipeTypesController@list')->name(
                    'pipe_types.list'
                );
                Route::resource('pipe_types', 'ComplicationMonitoring\PipeTypesController');

                Route::get('inhibitors/list', 'InhibitorsController@list')->name('inhibitors.list');
                Route::resource('inhibitors', 'InhibitorsController');

                Route::post('vcoreconomic', 'ComplicationMonitoring\OilGasController@economic');
                Route::post('vcoreconomiccurrent', 'ComplicationMonitoring\OilGasController@economicCurrentYear');
                Route::post('checkdublicateomgddng', 'ComplicationMonitoring\OmgCAController@checkDublicate');
                Route::post('getprevdaylevel', 'ComplicationMonitoring\OmgUHEController@getPrevDayLevel');

                Route::get('corrosioncrud/list', 'ComplicationMonitoring\CorrosionController@list')->name(
                    'corrosioncrud.list'
                );
                Route::get('corrosioncrud/export', 'ComplicationMonitoring\CorrosionController@export')->name(
                    'corrosioncrud.export'
                );
                Route::get(
                    'corrosioncrud/history/{corrosion}',
                    'ComplicationMonitoring\CorrosionController@history'
                )->name('corrosioncrud.history');
                Route::resource('corrosioncrud', 'ComplicationMonitoring\CorrosionController');

                Route::get('/gu-map', 'MapsController@guMap')->name('maps.gu');
                Route::get('/gu-map/mapdata', 'MapsController@mapData')->name('maps.gu_pipes');

                Route::post('/gu-map/gu', 'MapsController@storeGu')->name('maps.store_gu');
                Route::post('/gu-map/zu', 'MapsController@storeZu')->name('maps.store_zu');
                Route::post('/gu-map/well', 'MapsController@storeWell')->name('maps.store_well');
                Route::post('/gu-map/pipe', 'MapsController@storePipe')->name('maps.store_pipe');

                Route::put('/gu-map/gu/{gu}', 'MapsController@updateGu')->name('maps.update_gu');
                Route::put('/gu-map/zu/{zu}', 'MapsController@updateZu')->name('maps.update_zu');
                Route::put('/gu-map/well/{well}', 'MapsController@updateWell')->name('maps.update_well');
                Route::put('/gu-map/pipe/{pipe}', 'MapsController@updatePipe')->name('maps.update_pipe');

                Route::delete('/gu-map/gu/{gu}', 'MapsController@deleteGu')->name('maps.delete_gu');
                Route::delete('/gu-map/zu/{zu}', 'MapsController@deleteZu')->name('maps.delete_zu');
                Route::delete('/gu-map/well/{well}', 'MapsController@deleteWell')->name('maps.delete_well');
                Route::delete('/gu-map/pipe/{pipe}', 'MapsController@deletePipe')->name('maps.delete_pipe');

                Route::get('/gu-map/test', 'MapsController@test');

                Route::get('/monitor/reports', 'ReportsController@index')->name('monitor.reports');
                Route::get('/monitor/reports/generate', 'ReportsController@generateReport');

                Route::get('/settings/fields', 'Settings\FieldValidationsController@index')->name('settings.fields');
                Route::post('/settings/fields', 'Settings\FieldValidationsController@update')->name(
                    'settings.fields.update'
                );

                Route::get('gus/list', 'ComplicationMonitoring\GusController@list')->name('gus.list');
                Route::get('gus/history/{gu}', 'ComplicationMonitoring\GusController@history')->name('gus.history');
                Route::resource('gus', 'ComplicationMonitoring\GusController');

                Route::get('zus/list', 'ComplicationMonitoring\ZusController@list')->name('zus.list');
                Route::get('zus/history/{zu}', 'ComplicationMonitoring\ZusController@history')->name('zus.history');
                Route::resource('zus', 'ComplicationMonitoring\ZusController');

                Route::get('/monitor/{gu?}', 'DruidController@monitor')->name('monitor');
            }
        );
    }
);