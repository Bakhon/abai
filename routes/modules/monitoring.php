<?php

Route::group(
    ['prefix' => App\Http\Middleware\LocaleMiddleware::getLocale()],
    function () {
        Route::group(
            ['middleware' => 'auth'],
            function () {

                Route::get('/monitor', 'DruidController@monitor')->name('monitor');

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
                Route::get('/getcdng', 'ComplicationMonitoring\WaterMeasurementController@getCdng');
                Route::post('/getgu', 'ComplicationMonitoring\WaterMeasurementController@getGu');
                Route::post('/getzu', 'ComplicationMonitoring\WaterMeasurementController@getZu');
                Route::post('/getwell', 'ComplicationMonitoring\WaterMeasurementController@getWell');
                Route::get('/getwbs', 'ComplicationMonitoring\WaterMeasurementController@getWaterBySulin');
                Route::get('/getsrb', 'ComplicationMonitoring\WaterMeasurementController@getSulphateReducingBacteria');
                Route::get(
                    '/gethob',
                    'ComplicationMonitoring\WaterMeasurementController@getHydrocarbonOxidizingBacteria'
                );
                Route::get('/gethb', 'ComplicationMonitoring\WaterMeasurementController@getThionicBacteria');
                Route::post('/getwm', 'ComplicationMonitoring\WaterMeasurementController@getWm');
                Route::get('/getallgus', 'ComplicationMonitoring\WaterMeasurementController@getAllGu');
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

                Route::post('/getgucdngngdufield', 'ComplicationMonitoring\WaterMeasurementController@getGuNgduCdngField');

                Route::get('oilgas/list', 'ComplicationMonitoring\OilGasController@list')->name('oilgas.list');
                Route::get('oilgas/export', 'ComplicationMonitoring\OilGasController@export')->name('oilgas.export');
                Route::get('oilgas/history/{oilgas}', 'ComplicationMonitoring\OilGasController@history')->name('oilgas.history');
                Route::resource('oilgas','ComplicationMonitoring\OilGasController')->parameters(['oilgas' => 'oilgas']);

                Route::get('pipes/list', 'PipeController@list')->name('pipes.list');
                Route::get('pipes/export', 'PipeController@export')->name('pipes.export');
                Route::get('pipes/history/{pipes}', 'PipeController@history')->name('pipes.history');
                Route::resource('pipes','PipeController');

                Route::get('inhibitors/list', 'InhibitorsController@list')->name('inhibitors.list');
                Route::resource('inhibitors','InhibitorsController');

                Route::post('vcoreconomic','ComplicationMonitoring\OilGasController@economic');
                Route::post('vcoreconomiccurrent','ComplicationMonitoring\OilGasController@economicCurrentYear');
                Route::post('checkdublicateomgddng','ComplicationMonitoring\OmgCAController@checkDublicate');
                Route::post('getprevdaylevel','ComplicationMonitoring\OmgUHEController@getPrevDayLevel');

                Route::get('corrosioncrud/list', 'ComplicationMonitoring\CorrosionController@list')->name('corrosioncrud.list');
                Route::get('corrosioncrud/export', 'ComplicationMonitoring\CorrosionController@export')->name('corrosioncrud.export');
                Route::get('corrosioncrud/history/{corrosion}', 'ComplicationMonitoring\CorrosionController@history')->name('corrosioncrud.history');
                Route::resource('corrosioncrud','ComplicationMonitoring\CorrosionController');

                Route::get('/gu-map', 'MapsController@guMap')->name('maps.gu');
                Route::get('/gu-map/pipes', 'MapsController@guPipes')->name('maps.gu_pipes');

                Route::get('/monitor/reports', 'ReportsController@index')->name('monitor.reports');
                Route::get('/monitor/reports/generate', 'ReportsController@generateReport');


                Route::get('/settings/fields', 'Settings\FieldValidationsController@index')->name('settings.fields');
                Route::post('/settings/fields', 'Settings\FieldValidationsController@update')->name('settings.fields.update');
            }
        );
    }
);