<?php

Route::group(
    ['prefix' => App\Http\Middleware\LocaleMiddleware::getLocale()],
    function () {
        Route::group(
            [
              'prefix'      => 'prod-planning',
              'middleware'  => 'auth'
            ],
            function () {
                Route::get('/mon-plan-fact', 'ProdPlanning\ProdPlanningController@index')->name('prod_planning_index');
                Route::get('/base-prod-forecast', 'ProdPlanning\BaseProductionForecastController@index')->name('base_production_forecast_index');
                Route::get('/bus-plan', 'ProdPlanning\BusinessPlanningController@index')->name('bus_plan_index');
                Route::get('/long-term-program', 'ProdPlanning\LongTermProgramController@index')->name('long_term_program_index');
            }
        );
    }
);