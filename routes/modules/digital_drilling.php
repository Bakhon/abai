<?php
Route::group(
    ['prefix' => App\Http\Middleware\LocaleMiddleware::getLocale()],
    function () {
        Route::group(['prefix' => '/digital-drilling'], function () {
            // BD
            Route::group(['prefix' => '/bd'], function () {
                Route::get('/',                 '\App\Http\Controllers\DigitalDrilling\BDController@index')->name('digital-drilling-home');
                Route::get('/info',             '\App\Http\Controllers\DigitalDrilling\BDController@info')->name('digital-drilling-info');
                Route::get('/passport',         '\App\Http\Controllers\DigitalDrilling\BDController@passport')->name('digital-drilling-passport');
                Route::get('/gis',              '\App\Http\Controllers\DigitalDrilling\BDController@gis')->name('digital-drilling-gis');
                Route::get('/structure',        '\App\Http\Controllers\DigitalDrilling\BDController@structure')->name('digital-drilling-structure');
                Route::get('/structure-graph',  '\App\Http\Controllers\DigitalDrilling\BDController@structureGraph')->name('digital-drilling-structure-graph');
                Route::get('/inclino',          '\App\Http\Controllers\DigitalDrilling\BDController@inclino')->name('digital-drilling-inclino');
                Route::get('/inclino-graph',    '\App\Http\Controllers\DigitalDrilling\BDController@inclinoGraph')->name('digital-drilling-inclino-graph');
                Route::get('/project-data',     '\App\Http\Controllers\DigitalDrilling\BDController@projectData')->name('digital-drilling-project-data');
            });

            // Project
            Route::group(['prefix' => '/project'], function () {
                Route::get('/well-profile',         '\App\Http\Controllers\DigitalDrilling\ProjectController@wellProfile')->name('digital-drilling-well-profile');
                Route::get('/well-profile-graph',   '\App\Http\Controllers\DigitalDrilling\ProjectController@wellProfileGraph')->name('digital-drilling-well-profile-graph');
                Route::get('/calculation',          '\App\Http\Controllers\DigitalDrilling\ProjectController@calculation')->name('digital-drilling-calculation');
                Route::get('/calculation-graph',    '\App\Http\Controllers\DigitalDrilling\ProjectController@calculationGraph')->name('digital-drilling-calculation-graph');
                Route::get('/rasters',              '\App\Http\Controllers\DigitalDrilling\ProjectController@rasters')->name('digital-drilling-rasters');
                Route::get('/rasters-params',       '\App\Http\Controllers\DigitalDrilling\ProjectController@rastersParams')->name('digital-drilling-rasters-params');
                Route::get('/rasters-component',    '\App\Http\Controllers\DigitalDrilling\ProjectController@rastersComponent')->name('digital-drilling-rasters-component');
                Route::get('/deepening',            '\App\Http\Controllers\DigitalDrilling\ProjectController@deepening')->name('digital-drilling-deepening');
                Route::get('/deepening-graph',      '\App\Http\Controllers\DigitalDrilling\ProjectController@deepeningGraph')->name('digital-drilling-deepening-graph');
                Route::get('/deepening-params',     '\App\Http\Controllers\DigitalDrilling\ProjectController@deepeningParams')->name('digital-drilling-deepening-params');
                Route::get('/fastening',            '\App\Http\Controllers\DigitalDrilling\ProjectController@fastening')->name('digital-drilling-fastening');
                Route::get('/fastening-page2',      '\App\Http\Controllers\DigitalDrilling\ProjectController@fasteningPage2')->name('digital-drilling-fastening-page2');
                Route::get('/fastening-page3',      '\App\Http\Controllers\DigitalDrilling\ProjectController@fasteningPage3')->name('digital-drilling-fastening-page3');
                Route::get('/fastening-page4',      '\App\Http\Controllers\DigitalDrilling\ProjectController@fasteningPage4')->name('digital-drilling-fastening-page4');
                Route::get('/fastening-page5',      '\App\Http\Controllers\DigitalDrilling\ProjectController@fasteningPage5')->name('digital-drilling-fastening-page5');
                Route::get('/fastening-page6',      '\App\Http\Controllers\DigitalDrilling\ProjectController@fasteningPage6')->name('digital-drilling-fastening-page6');
                Route::get('/fastening-page7',      '\App\Http\Controllers\DigitalDrilling\ProjectController@fasteningPage7')->name('digital-drilling-fastening-page7');
            });

            // Online
            Route::group(['prefix' => '/online'], function () {
                Route::get('/alarm',        '\App\Http\Controllers\DigitalDrilling\OnlineController@alarm')->name('digital-drilling-alarm');
                Route::get('/geo-first',    '\App\Http\Controllers\DigitalDrilling\OnlineController@geoFirst')->name('digital-drilling-geo-first');
                Route::get('/geo-second',   '\App\Http\Controllers\DigitalDrilling\OnlineController@geoSecond')->name('digital-drilling-geo-second');
                Route::get('/geo-third',    '\App\Http\Controllers\DigitalDrilling\OnlineController@geoThird')->name('digital-drilling-geo-third');
                Route::get('/sector',       '\App\Http\Controllers\DigitalDrilling\OnlineController@sector')->name('digital-drilling-sector');
                Route::get('/visual',       '\App\Http\Controllers\DigitalDrilling\OnlineController@visual')->name('digital-drilling-visual');
                Route::get('/report1',      '\App\Http\Controllers\DigitalDrilling\OnlineController@report1')->name('digital-drilling-report1');
                Route::get('/report2',      '\App\Http\Controllers\DigitalDrilling\OnlineController@report2')->name('digital-drilling-report2');
            });

            // Supervising
            Route::group(['prefix' => '/supervising'], function () {
                Route::get('/alarm',            '\App\Http\Controllers\DigitalDrilling\SupervisingController@alarm')->name('digital-drilling-alarm');
                Route::get('/reports',          '\App\Http\Controllers\DigitalDrilling\SupervisingController@reports')->name('digital-drilling-reports');
                Route::get('/balance',          '\App\Http\Controllers\DigitalDrilling\SupervisingController@balance')->name('digital-drilling-balance');
                Route::get('/balance-second',   '\App\Http\Controllers\DigitalDrilling\SupervisingController@balanceSecond')->name('digital-drilling-balance-second');
                Route::get('/balance-third',    '\App\Http\Controllers\DigitalDrilling\SupervisingController@balanceThird')->name('digital-drilling-balance-third');
                Route::get('/fact',             '\App\Http\Controllers\DigitalDrilling\SupervisingController@fact')->name('digital-drilling-fact');
                Route::get('/npv',              '\App\Http\Controllers\DigitalDrilling\SupervisingController@npv')->name('digital-drilling-npv');
                Route::get('/akc',              '\App\Http\Controllers\DigitalDrilling\SupervisingController@akc')->name('digital-drilling-akc');
            });

            // Analytics
            Route::group(['prefix' => '/analytics'], function () {
                Route::get('/deepening-inclino',    '\App\Http\Controllers\DigitalDrilling\AnalyticsController@deepeningInclino')->name('digital-drilling-analytics-deepening-inclino');
                Route::get('/deepening-visual',     '\App\Http\Controllers\DigitalDrilling\AnalyticsController@deepeningVisual')->name('digital-drilling-analytics-deepening-visual');
                Route::get('/deepening-knbk',       '\App\Http\Controllers\DigitalDrilling\AnalyticsController@deepeningKnbk')->name('digital-drilling-analytics-deepening-knbk');
                Route::get('/deepening-params',     '\App\Http\Controllers\DigitalDrilling\AnalyticsController@deepeningParams')->name('digital-drilling-analytics-deepening-params');
                Route::get('/deepening-bur',        '\App\Http\Controllers\DigitalDrilling\AnalyticsController@deepeningBur')->name('digital-drilling-analytics-deepening-bur');
                Route::get('/deepening-gidro',      '\App\Http\Controllers\DigitalDrilling\AnalyticsController@deepeningGidro')->name('digital-drilling-analytics-deepening-gidro');
                Route::get('/deepening-sorting',    '\App\Http\Controllers\DigitalDrilling\AnalyticsController@deepeningSorting')->name('digital-drilling-analytics-deepening-sorting');
                Route::get('/deepening-selection',  '\App\Http\Controllers\DigitalDrilling\AnalyticsController@deepeningSelection')->name('digital-drilling-analytics-deepening-selection');
                Route::get('/fastening-first',      '\App\Http\Controllers\DigitalDrilling\AnalyticsController@fasteningFirst')->name('digital-drilling-analytics-fastening-first');
                Route::get('/fastening-second',     '\App\Http\Controllers\DigitalDrilling\AnalyticsController@fasteningSecond')->name('digital-drilling-analytics-fastening-second');
                Route::get('/fastening-third',      '\App\Http\Controllers\DigitalDrilling\AnalyticsController@fasteningThird')->name('digital-drilling-analytics-fastening-third');
                Route::get('/complications',        '\App\Http\Controllers\DigitalDrilling\AnalyticsController@complications')->name('digital-drilling-analytics-complications');
                Route::get('/akc',                  '\App\Http\Controllers\DigitalDrilling\AnalyticsController@akc')->name('digital-drilling-analytics-akc');
                Route::get('/balance',              '\App\Http\Controllers\DigitalDrilling\AnalyticsController@balance')->name('digital-drilling-analytics-balance');
            });
        });
    });