<?php

Route::group(['prefix' => App\Http\Middleware\LocaleMiddleware::getLocale()], function () {

    Route::group(['middleware' => 'auth'], function () {

        Route::group(['prefix' => 'prod-plan', 'namespace' => 'ProductionPlanning'], function () {
            Route::resource('mon-plan-fact', 'ProductionPlanningMonitoring\ProductionPlanningMonitoringController');
            Route::resource('prod-plan-mon', 'ProductionPlanningMonitoring\LongTermProgramController');
            Route::resource('bus-plan', 'ProductionPlanningMonitoring\BusinessPlanningController');
            Route::resource('base-prod-forecast', 'ProductionPlanningMonitoring\BaseProductionForecastController');
         });
     }
     );
 }
 );
