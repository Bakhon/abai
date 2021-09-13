<?php

Route::group(['prefix' => App\Http\Middleware\LocaleMiddleware::getLocale()], function () {
    Route::group(['middleware' => 'auth', 'prefix' => 'economic', 'namespace' => 'Economic'], function () {

        Route::group(['prefix' => 'nrs'], function () {
            Route::get('', 'EconomicNrsController@index')->name('economic.nrs');
            Route::get('get-data', "EconomicNrsController@getData");
            Route::post('export-data', "EconomicNrsController@exportData");
            Route::get('wells', 'EconomicNrsController@indexWells');
            Route::get('get-wells', "EconomicNrsController@getWells");
        });

        Route::group(['prefix' => 'optimization'], function () {
            Route::get('', 'EconomicOptimizationController@index')->name('economic.optimization');
            Route::get('get-data', 'EconomicOptimizationController@getData');
        });

        Route::group([], function () {
            Route::group(['prefix' => 'gtm'], function () {
                Route::get('get-data', 'EconomicGtmController@getData');
                Route::get('upload-excel', 'EconomicGtmController@uploadExcel');
                Route::post('import-excel', 'EconomicGtmController@importExcel')->name('economic.gtm.import');
            });

            Route::resource('gtm', 'EconomicGtmController')
                ->only(['index', 'destroy'])
                ->names([
                    'index' => 'economic.gtm.index',
                    'destroy' => 'economic.gtm.destroy'
                ]);
        });

        Route::group([], function () {
            Route::group(['prefix' => 'gtm_value'], function () {
                Route::get('get-data', 'EconomicGtmValueController@getData');
                Route::post('import-excel', 'EconomicGtmValueController@importExcel')->name('economic.gtm_value.import');
            });

            Route::resource('gtm_value', 'EconomicGtmValueController')
                ->only(['destroy'])
                ->names([
                    'destroy' => 'economic.gtm_value.destroy'
                ]);
        });

        Route::group([], function () {
            Route::get('scenario/get-data', 'EconomicScenarioController@getData');

            Route::resource('scenario', 'EconomicScenarioController')
                ->only(['index', 'store', 'destroy'])
                ->names([
                    'index' => 'economic.scenario.index',
                    'store' => 'economic.scenario.store',
                    'destroy' => 'economic.scenario.destroy',
                ]);
        });

        Route::group([], function () {
            Route::group(['prefix' => 'cost'], function () {
                Route::get('get-data', 'EconomicCostController@getData');
                Route::get('upload-excel', 'EconomicCostController@uploadExcel')->name('economic.cost.upload');
                Route::post('import-excel', 'EconomicCostController@importExcel')->name('economic.cost.import');
                Route::resource('log', 'EconomicCostLogController')
                    ->only(['index', 'destroy'])
                    ->names([
                        'index' => 'economic.cost.log.index',
                        'destroy' => 'economic.cost.log.destroy',
                    ]);
            });

            Route::resource('cost', 'EconomicCostController')
                ->only(['index', 'edit', 'store', 'update', 'destroy'])
                ->names([
                    'index' => 'economic.cost.index',
                    'edit' => 'economic.cost.edit',
                    'store' => 'economic.cost.store',
                    'update' => 'economic.cost.update',
                    'destroy' => 'economic.cost.destroy',
                ]);
        });

        Route::group(['prefix' => 'technical', 'namespace' => 'Technical'], function () {
            Route::get('list', 'TechnicalDataController@list')->name('economic.technical.list');
//            Route::resource('tech_struct_source', 'Refs\TechnicalStructureSourceController');
//            Route::get('tech_struct_sources', 'Refs\TechnicalStructureSourceController@getSources');
//            Route::resource('tech_struct_company', 'Refs\TechnicalStructureCompanyController');
//            Route::resource('tech_struct_field', 'Refs\TechnicalStructureFieldController');
//            Route::resource('tech_struct_ngdu', 'Refs\TechnicalStructureNgduController');
//            Route::resource('tech_struct_cdng', 'Refs\TechnicalStructureCdngController');
//            Route::resource('tech_struct_gu', 'Refs\TechnicalStructureGuController');
//            Route::resource('tech_struct_bkns', 'Refs\TechnicalStructureBknsController');
//            Route::get('tech-data-forecast/get-data', 'Refs\TechnicalDataForecastController@getData');
//            Route::resource('tech-data-forecast', 'Refs\TechnicalDataForecastController');
//            Route::resource('tech_data_log', 'Refs\TechnicalDataLogController');
//            Route::get('technical_forecast/upload_excel', 'Refs\TechnicalDataController@uploadExcel')->name('tech_refs_upload');
//            Route::post('technical_forecast/import_excel', 'Refs\TechnicalDataController@importExcel')->name('tech_refs_import');
//            Route::get('tech-struct-field/get-data', 'Refs\TechnicalStructureFieldController@getData');
//            Route::get('tech-struct-ngdu/get-data', 'Refs\TechnicalStructureNgduController@getData');
//            Route::get('tech-struct-cdng/get-data', 'Refs\TechnicalStructureCdngController@getData');
//            Route::get('tech-struct-gu/get-data', 'Refs\TechnicalStructureGuController@getData');
        });
    });
});
