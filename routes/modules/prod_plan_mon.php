<?php

Route::group(['prefix' => App\Http\Middleware\LocaleMiddleware::getLocale()], function () {

    Route::group(['middleware' => 'auth'], function () {

        Route::group(['prefix' => 'prod_plan_mon', 'namespace' => 'ProductionPlanningMonitoring'], function () {
            Route::resource('mon_plan_fact', 'ProductionPlanningMonitoringController');
            Route::resource('long_term_program', 'LongTermProgramController');
            Route::resource('bus_plan', 'BusinessPlanningController');
            Route::resource('base_prod_forecast', 'BaseProductionForecastController');
         });
     }
     );
 }
 );
