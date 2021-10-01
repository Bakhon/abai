<?php

Route::group(
    ['prefix' => App\Http\Middleware\LocaleMiddleware::getLocale()],
    function () {
        Route::group(
            ['middleware' => 'auth'],
            function () {
                Route::get('/pf', 'PlastFluids\PlastFluidsController@pf')->name('pf');
                Route::get('/pf-upload-monitoring', 'PlastFluids\PlastFluidsController@pfUploadMonitoring')->name('pf-upload-monitoring');
                Route::get('/pf-download-monitoring', 'PlastFluids\PlastFluidsController@pfDownloadMonitoring')->name('pf-download-monitoring');
                Route::get('/pf-data-analysis/pressure-and-temperature', 'PlastFluids\PlastFluidsController@pfDataAnalysis')->name('pf-data-analysis-pressure-and-temperature');
                Route::get('/pf-data-analysis/reservoir-oil-samples-analysis/oil/graphs-and-tables', 'PlastFluids\PlastFluidsController@pfDataAnalysis')->name('pf-data-analysis-oil-graphs-and-tables');
                Route::get('/pf-data-analysis/reservoir-oil-samples-analysis/oil/study', 'PlastFluids\PlastFluidsController@pfDataAnalysis')->name('pf-data-analysis-oil-study');
                Route::get('/pf-data-analysis/reservoir-oil-samples-analysis/oil/maps-and-tables', 'PlastFluids\PlastFluidsController@pfDataAnalysis')->name('pf-data-analysis-oil-maps-and-tables');
                Route::get('/pf-data-analysis/reservoir-oil-samples-analysis/oil/property-map', 'PlastFluids\PlastFluidsController@pfDataAnalysis')->name('pf-data-analysis-oil-property-map');
                Route::get('/pf-data-analysis/reservoir-oil-samples-analysis/oil/fluid-composition', 'PlastFluids\PlastFluidsController@pfDataAnalysis')->name('pf-data-analysis-oil-fluid-composition');
                Route::get('/pf-data-analysis/reservoir-oil-samples-analysis/oil/gas-condensate-studies', 'PlastFluids\PlastFluidsController@pfDataAnalysis')->name('pf-data-analysis-oil-gas-condensate-studies');
                Route::get('/pf-data-analysis/reservoir-oil-samples-analysis/gascondensate/fluid-composition', 'PlastFluids\PlastFluidsController@pfDataAnalysis')->name('pf-data-analysis-gascondensate-fluid-composition');
                Route::get('/pf-data-analysis/reservoir-oil-samples-analysis/gascondensate/gas-condensate-studies', 'PlastFluids\PlastFluidsController@pfDataAnalysis')->name('pf-data-analysis-oil-gas-condensate-studies');
                Route::get('/pf-data-analysis/reservoir-oil-samples-analysis/gascondensate/study', 'PlastFluids\PlastFluidsController@pfDataAnalysis')->name('pf-data-analysis-gascondensate-study');
                Route::get('/pf-data-analysis/reservoir-oil-samples-analysis/gascondensate/maps-and-tables', 'PlastFluids\PlastFluidsController@pfDataAnalysis')->name('pf-data-analysis-gascondensate-maps-and-tables');
                Route::get('/pf-data-analysis/approved-parameters', 'PlastFluids\PlastFluidsController@pfDataAnalysis')->name('pf-data-analysis-approved-parameters');
            }
        );
    }
);
