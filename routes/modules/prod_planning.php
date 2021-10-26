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
                Route::get('/', 'ProdPlanning\ProdPlanningController@index')->name('prod_planning_index');
            }
        );
    }
);