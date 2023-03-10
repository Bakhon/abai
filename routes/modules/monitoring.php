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
                Route::get('/getallgus', 'ComplicationMonitoring\GusController@getAllGu');
                Route::get('/get_all_monitoring_data', 'ComplicationMonitoring\WaterMeasurementController@getAllMonitoringData');
                Route::post('/getzu', 'ComplicationMonitoring\ZusController@getZu');
                Route::post('/get_gu_relations', 'ComplicationMonitoring\GusController@getGuRelations');
                Route::post('/get_zu_relations', 'ComplicationMonitoring\ZusController@getZuRelations');
                Route::post('/get_ngdu_relations', 'ComplicationMonitoring\WaterMeasurementController@getNgduRelations');
                Route::post('/get_cdng_relations', 'ComplicationMonitoring\WaterMeasurementController@getCdngRelations');
                Route::get('/getallzu', 'ComplicationMonitoring\ZusController@getAllZu');
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

                Route::post('omgngdu/get-omgngdu', 'ComplicationMonitoring\OmgNGDUController@getOmgNgdu')->name(
                    'omgngdu.get-omg-ngdu'
                );
                Route::resource('omgngdu', 'ComplicationMonitoring\OmgNGDUController');


                Route::get('omgngdu-well/list', 'ComplicationMonitoring\OmgNGDUWellController@list')->name(
                    'omgngdu-well.list'
                );
                Route::post('omgngdu-well/get-omgngdu', 'ComplicationMonitoring\OmgNGDUWellController@getOmgNgdu')->name(
                    'omgngdu-well.get-omg-ngdu'
                );

                Route::resource('omgngdu-well', 'ComplicationMonitoring\OmgNGDUWellController');


                Route::get('omgngdu-zu/list', 'ComplicationMonitoring\OmgNGDUZuController@list')->name('omgngdu-zu.list');
                Route::post('omgngdu-zu/get-omgngdu', 'ComplicationMonitoring\OmgNGDUZuController@getOmgNgdu')->name(
                    'omgngdu-zu.get-omg-ngdu'
                );
                Route::resource('omgngdu-zu', 'ComplicationMonitoring\OmgNGDUZuController');



                Route::post(
                    '/get-gu-cdng-ngdu-field',
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
                Route::post('get-prev-day-level', 'ComplicationMonitoring\OmgUHEController@getPrevDayLevel');

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

                Route::get('/tech-map', 'ComplicationMonitoring\TechMapController@guMap')->name('tech-map.index');
                Route::get('/tech-map/mapdata', 'ComplicationMonitoring\TechMapController@mapData')->name('tech-map.mapdata');
                Route::get('/tech-map/hydro-calc', 'ComplicationMonitoring\TechMapController@getHydroCalc')->name('tech-map.hydro-calc');
                Route::get('/tech-map/pressure', 'ComplicationMonitoring\TechMapController@getPressure')->name('tech-map.pressure');
                Route::get('/tech-map/temperature', 'ComplicationMonitoring\TechMapController@getTemperature')->name('tech-map.temperature');

                Route::post('/tech-map/calculate', 'ComplicationMonitoring\TechMapController@calculate')->name('tech-map.calculate');

                Route::post('/tech-map/gu', 'ComplicationMonitoring\TechMapController@storeGu')->name('tech-map.store_gu');
                Route::post('/tech-map/zu', 'ComplicationMonitoring\TechMapController@storeZu')->name('tech-map.store_zu');
                Route::post('/tech-map/well', 'ComplicationMonitoring\TechMapController@storeWell')->name('tech-map.store_well');
                Route::post('/tech-map/pipe', 'ComplicationMonitoring\TechMapController@storePipe')->name('tech-map.store_pipe');

                Route::put('/tech-map/gu/{id}', 'ComplicationMonitoring\TechMapController@updateGu')->name('tech-map.update_gu');
                Route::put('/tech-map/zu/{id}', 'ComplicationMonitoring\TechMapController@updateZu')->name('tech-map.update_zu');
                Route::put('/tech-map/well/{id}', 'ComplicationMonitoring\TechMapController@updateWell')->name('tech-map.update_well');
                Route::put('/tech-map/pipe/{id}', 'ComplicationMonitoring\TechMapController@updatePipe')->name('tech-map.update_pipe');

                Route::delete('/tech-map/gu/{id}', 'ComplicationMonitoring\TechMapController@deleteGu')->name('tech-map.delete_gu');
                Route::delete('/tech-map/zu/{id}', 'ComplicationMonitoring\TechMapController@deleteZu')->name('tech-map.delete_zu');
                Route::delete('/tech-map/well/{id}', 'ComplicationMonitoring\TechMapController@deleteWell')->name('tech-map.delete_well');
                Route::delete('/tech-map/pipe/{id}', 'ComplicationMonitoring\TechMapController@deletePipe')->name('tech-map.delete_pipe');

                Route::get('/monitor/reports', 'ReportsController@index')->name('monitor.reports');
                Route::get('/monitor/reports/generate', 'ReportsController@generateReport');

                Route::get('/settings/fields', 'Settings\FieldValidationsController@index')->name('settings.fields');
                Route::post('/settings/fields', 'Settings\FieldValidationsController@update')->name(
                    'settings.fields.update'
                );
                Route::get('/settings/validation-params/{section}', 'Settings\FieldValidationsController@getValidationParams')->name(
                    'settings.validation-params'
                );

                Route::get('gus/list', 'ComplicationMonitoring\GusController@list')->name('gus.list');
                Route::get('gus/history/{gu}', 'ComplicationMonitoring\GusController@history')->name('gus.history');
                Route::resource('gus', 'ComplicationMonitoring\GusController');

                Route::get('zus/list', 'ComplicationMonitoring\ZusController@list')->name('zus.list');
                Route::get('zus/history/{zu}', 'ComplicationMonitoring\ZusController@history')->name('zus.history');
                Route::resource('zus', 'ComplicationMonitoring\ZusController');

                Route::get('/monitor/{gu?}', 'DruidController@monitor')->name('monitor');

                Route::get('/hydro-calc/list', 'ComplicationMonitoring\HydroCalculation@list')->name('hydro_calculation.list');
                Route::get('/hydro-calc/calculate', 'ComplicationMonitoring\HydroCalculation@calculate')->name('hydro_calculation.calculate');

                Route::get('materials/list', 'ComplicationMonitoring\MaterialsController@list')->name('materials.list');
                Route::resource('materials', 'ComplicationMonitoring\MaterialsController');
                Route::resource('hydro-calc', 'ComplicationMonitoring\HydroCalculation', [
                    'names' => [
                        'index' => 'hydro_calculation.index'
                    ]
                ]);

                Route::get('/reverse-calc/list', 'ComplicationMonitoring\ReverseCalculationController@list')->name('reverse_calculation.list');
                Route::get('/reverse-calc', 'ComplicationMonitoring\ReverseCalculationController@index')->name('reverse_calculation.index');
                Route::get('/reverse-calc/calculate', 'ComplicationMonitoring\ReverseCalculationController@calculate')->name('reverse_calculation.calculate');

                Route::get('/manual-hydro-calc/list', 'ComplicationMonitoring\ManualHydroCalc@list')->name('manual_hydro_calculation.list');
                Route::get('/manual-hydro-calc/export', 'ComplicationMonitoring\ManualHydroCalc@export')->name('manual_hydro_calculation.export');
                Route::get('/manual-hydro-calc', 'ComplicationMonitoring\ManualHydroCalc@index')->name('manual_hydro_calculation.index');
                Route::get('/manual-hydro-calc/calculate', 'ComplicationMonitoring\ManualHydroCalc@calculate')->name('manual_hydro_calculation.calculate');
                Route::get('/manual-hydro-calc/test', 'ComplicationMonitoring\ManualHydroCalc@getPrepairedData');

                Route::get('economical-effect/list', 'ComplicationMonitoring\EconomicalEffectController@list')->name(
                    'economical_effect.list'
                );
                Route::resource('economical-effect', 'ComplicationMonitoring\EconomicalEffectController');

                Route::get('lost-profits/list', 'ComplicationMonitoring\LostProfitsController@list')->name(
                    'lost_profits.list'
                );
                Route::resource('lost-profits', 'ComplicationMonitoring\LostProfitsController');
                Route::get('/facilities', 'DruidController@facilities')->name('facilities');

                Route::get('buffer-tank/list', 'ComplicationMonitoring\BufferTankController@list')->name('buffer_tank.list');
                Route::get('buffer-tank/export', 'ComplicationMonitoring\BufferTankController@export')->name('buffer_tank.export');
                Route::get('buffer-tank/history/{buffer_tank}', 'ComplicationMonitoring\BufferTankController@history')->name('buffer_tank.history');
                Route::resource('buffer-tank', 'ComplicationMonitoring\BufferTankController');

                Route::get('pumps/list', 'ComplicationMonitoring\PumpsController@list')->name('pumps.list');
                Route::get('pumps/export', 'ComplicationMonitoring\PumpsController@export')->name('pumps.export');
                Route::get('pumps/history/{pumps}', 'ComplicationMonitoring\PumpsController@history')->name('pumps.history');
                Route::resource('pumps', 'ComplicationMonitoring\PumpsController');

                Route::get('ovens/list', 'ComplicationMonitoring\OvensController@list')->name('ovens.list');
                Route::get('ovens/export', 'ComplicationMonitoring\OvensController@export')->name('ovens.export');
                Route::get('ovens/history/{ovens}', 'ComplicationMonitoring\OvensController@history')->name('ovens.history');
                Route::resource('ovens', 'ComplicationMonitoring\OvensController');

                Route::get('agzu/list', 'ComplicationMonitoring\AgzuController@list')->name('agzu.list');
                Route::get('agzu/export', 'ComplicationMonitoring\AgzuController@export')->name('agzu.export');
                Route::get('agzu/history/{agzu}', 'ComplicationMonitoring\AgzuController@history')->name('agzu.history');
                Route::resource('agzu', 'ComplicationMonitoring\AgzuController');

                Route::get('sib/list', 'ComplicationMonitoring\SibController@list')->name('sib.list');
                Route::get('sib/export', 'ComplicationMonitoring\SibController@export')->name('sib.export');
                Route::get('sib/history/{sib}', 'ComplicationMonitoring\SibController@history')->name('sib.history');
                Route::resource('sib', 'ComplicationMonitoring\SibController');

                Route::get('metering-units/list', 'ComplicationMonitoring\MeteringUnitsController@list')->name('metering_units.list');
                Route::get('metering-units/export', 'ComplicationMonitoring\MeteringUnitsController@export')->name('metering_units.export');
                Route::get('metering-units/history/{metering_units}', 'ComplicationMonitoring\MeteringUnitsController@history')->name('metering_units.history');
                Route::resource('metering-units', 'ComplicationMonitoring\MeteringUnitsController');
                
                Route::get('map-history/list', 'ComplicationMonitoring\MapHistory@list')->name('map-history.list');
                Route::get('map-history/show/{activity}', 'ComplicationMonitoring\MapHistory@show')->name('map-history.show');
                Route::get('map-history/restore/{activity}', 'ComplicationMonitoring\MapHistory@restore')->name('map-history.restore');
                Route::get('map-history', 'ComplicationMonitoring\MapHistory@index')->name('map-history.index');

                Route::get('pipe-passport/list', 'ComplicationMonitoring\PipePassportController@list')->name('pipe-passport.list');
                Route::get('pipe-passport/history/{pipe}', 'ComplicationMonitoring\PipePassportController@history')->name('pipe-passport.history');
                Route::resource('pipe-passport', 'ComplicationMonitoring\PipePassportController');

                Route::get('zu-cleanings/list', 'ComplicationMonitoring\ZusCleaningController@list')->name('zu-cleanings.list');
                Route::get('zu-cleanings/history/{zu_cleaning}', 'ComplicationMonitoring\ZusCleaningController@history')->name('zu-cleanings.history');
                Route::get('zu-cleanings/export', 'ComplicationMonitoring\ZusCleaningController@export')->name('zu-cleanings.export');
                Route::resource('zu-cleanings', 'ComplicationMonitoring\ZusCleaningController');
                
                Route::post('/corrosion-dosage', 'ComplicationMonitoring\CorrosionRateAndDoseCalculationController@calculate');
            }
        );
    }
);