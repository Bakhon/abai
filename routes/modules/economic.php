<?php

Route::group(['prefix' => App\Http\Middleware\LocaleMiddleware::getLocale()], function () {
    Route::group(['middleware' => 'auth', 'prefix' => 'economic', 'namespace' => 'Economic'], function () {

        Route::group(['prefix' => 'nrs'], function () {
            Route::get('', 'EconomicNrsController@index')
                ->name('economic.nrs');
            Route::get('get-data', "EconomicNrsController@getData");
            Route::post('export-data', "EconomicNrsController@exportData");
            Route::get('wells', 'EconomicNrsController@indexWells');
            Route::get('wells/{org_id}/{well_id}', 'EconomicNrsController@indexWell');
            Route::get('get-wells', "EconomicNrsController@getWells");
            Route::get('get-wells-map', "EconomicNrsController@getWellsMap");
        });

        Route::group(['prefix' => 'optimization'], function () {
            Route::get('', 'EconomicOptimizationController@index')
                ->name('economic.optimization');
            Route::get('get-data', 'EconomicOptimizationController@getData');
        });

        Route::group([], function () {
            Route::group(['prefix' => 'gtm'], function () {
                Route::get('get-data', 'EconomicGtmController@getData');
                Route::get('get-authors', 'EconomicGtmController@getAuthors');
                Route::get('upload-excel', 'EconomicGtmController@uploadExcel');
                Route::post('import-excel', 'EconomicGtmController@importExcel')
                    ->name('economic.gtm.import');
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
                Route::get('get-authors', 'EconomicGtmValueController@getAuthors');
                Route::post('import-excel', 'EconomicGtmValueController@importExcel')
                    ->name('economic.gtm_value.import');
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

                Route::get('upload-excel', 'EconomicCostController@uploadExcel')
                    ->name('economic.cost.upload');

                Route::post('import-excel', 'EconomicCostController@importExcel')
                    ->name('economic.cost.import');
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

        Route::group([], function () {
            Route::get('log/get-data', 'EconomicDataLogController@getData');

            Route::resource('log', 'EconomicDataLogController')
                ->only(['index', 'destroy'])
                ->names([
                    'index' => 'economic.log.index',
                    'destroy' => 'economic.log.destroy',
                ]);
        });

        Route::group(['prefix' => 'technical', 'namespace' => 'Technical'], function () {
            Route::get('list', 'TechnicalListController')
                ->name('economic.technical.list');

            Route::group([], function () {
                Route::group(['prefix' => 'forecast'], function () {
                    Route::get('get-data', 'TechnicalDataForecastController@getData');

                    Route::get('upload-excel', 'TechnicalDataForecastController@uploadExcel')
                        ->name('economic.technical.forecast.upload');

                    Route::post('import-excel', 'TechnicalDataForecastController@importExcel')
                        ->name('economic.technical.forecast.import');

                    Route::resource('log', 'TechnicalDataForecastLogController')
                        ->only(['index', 'destroy'])
                        ->names([
                            'index' => 'economic.technical.forecast.log.index',
                            'destroy' => 'economic.technical.forecast.log.destroy',
                        ]);
                });

                Route::resource('forecast', 'TechnicalDataForecastController')
                    ->only(['index', 'edit', 'update', 'destroy'])
                    ->names([
                        'index' => 'economic.technical.forecast.index',
                        'edit' => 'economic.technical.forecast.edit',
                        'update' => 'economic.technical.forecast.update',
                        'destroy' => 'economic.technical.forecast.destroy',
                    ]);
            });

            Route::group(['prefix' => 'structure', 'namespace' => 'Structure'], function () {
                Route::get('source/get-data', 'TechnicalStructureSourceController@getData');

                Route::resource('source', 'TechnicalStructureSourceController')
                    ->names([
                        'index' => 'economic.technical.source.index',
                        'create' => 'economic.technical.source.create',
                        'store' => 'economic.technical.source.store',
                        'edit' => 'economic.technical.source.edit',
                        'update' => 'economic.technical.source.update',
                        'destroy' => 'economic.technical.source.destroy',
                    ]);

                Route::get('company/get-data', 'TechnicalStructureCompanyController@getData');

                Route::resource('company', 'TechnicalStructureCompanyController')
                    ->names([
                        'index' => 'economic.technical.company.index',
                        'create' => 'economic.technical.company.create',
                        'store' => 'economic.technical.company.store',
                        'edit' => 'economic.technical.company.edit',
                        'update' => 'economic.technical.company.update',
                        'destroy' => 'economic.technical.company.destroy',
                    ]);

                Route::get('bkns/get-data', 'TechnicalStructureBknsController@getData');

                Route::resource('bkns', 'TechnicalStructureBknsController')
                    ->names([
                        'index' => 'economic.technical.bkns.index',
                        'create' => 'economic.technical.bkns.create',
                        'store' => 'economic.technical.bkns.store',
                        'edit' => 'economic.technical.bkns.edit',
                        'update' => 'economic.technical.bkns.update',
                        'destroy' => 'economic.technical.bkns.destroy',
                    ]);

                Route::get('cdng/get-data', 'TechnicalStructureCdngController@getData');

                Route::resource('cdng', 'TechnicalStructureCdngController')
                    ->names([
                        'index' => 'economic.technical.cdng.index',
                        'create' => 'economic.technical.cdng.create',
                        'store' => 'economic.technical.cdng.store',
                        'edit' => 'economic.technical.cdng.edit',
                        'update' => 'economic.technical.cdng.update',
                        'destroy' => 'economic.technical.cdng.destroy',
                    ]);

                Route::get('ngdu/get-data', 'TechnicalStructureNgduController@getData');

                Route::resource('ngdu', 'TechnicalStructureNgduController')
                    ->names([
                        'index' => 'economic.technical.ngdu.index',
                        'create' => 'economic.technical.ngdu.create',
                        'store' => 'economic.technical.ngdu.store',
                        'edit' => 'economic.technical.ngdu.edit',
                        'update' => 'economic.technical.ngdu.update',
                        'destroy' => 'economic.technical.ngdu.destroy',
                    ]);

                Route::get('gu/get-data', 'TechnicalStructureGuController@getData');

                Route::resource('gu', 'TechnicalStructureGuController')
                    ->names([
                        'index' => 'economic.technical.gu.index',
                        'create' => 'economic.technical.gu.create',
                        'store' => 'economic.technical.gu.store',
                        'edit' => 'economic.technical.gu.edit',
                        'update' => 'economic.technical.gu.update',
                        'destroy' => 'economic.technical.gu.destroy',
                    ]);

                Route::get('field/get-data', 'TechnicalStructureFieldController@getData');

                Route::resource('field', 'TechnicalStructureFieldController')
                    ->names([
                        'index' => 'economic.technical.field.index',
                        'create' => 'economic.technical.field.create',
                        'store' => 'economic.technical.field.store',
                        'edit' => 'economic.technical.field.edit',
                        'update' => 'economic.technical.field.update',
                        'destroy' => 'economic.technical.field.destroy',
                    ]);
            });
        });

        Route::group([], function () {
            Route::group(['prefix' => 'well_forecast'], function () {
                Route::get('get-data', 'EconomicWellForecastController@getData');
                Route::get('upload-excel', 'EconomicWellForecastController@uploadExcel')
                    ->name('economic.well_forecast.upload');
                Route::post('import-excel', 'EconomicWellForecastController@importExcel')
                    ->name('economic.well_forecast.import');
            });

            Route::resource('well_forecast', 'EconomicWellForecastController')
                ->only(['index'])
                ->names(['index' => 'economic.well_forecast.index']);
        });
    });
});
