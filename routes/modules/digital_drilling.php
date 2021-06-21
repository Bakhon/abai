<?php
Route::group(
    ['prefix' => App\Http\Middleware\LocaleMiddleware::getLocale()],
    function () {
        Route::group(['prefix' => '/digital-drilling'], function () {
            // BD
            Route::group(['prefix' => '/bd'], function () {
                Route::get('/', function () {
                    return view('digital_drilling.bd.home');
                })->name('digital-drilling-home');
                Route::get('/info', function () {
                    return view('digital_drilling.bd.info');
                })->name('digital-drilling-info');
                Route::get('/passport', function () {
                    return view('digital_drilling.bd.passport');
                })->name('digital-drilling-passport');
                Route::get('/gis', function () {
                    return view('digital_drilling.bd.gis');
                })->name('digital-drilling-gis');
                Route::get('/structure', function () {
                    return view('digital_drilling.bd.structure');
                })->name('digital-drilling-structure');
                Route::get('/structure-graph', function () {
                    return view('digital_drilling.bd.structure-graph');
                })->name('digital-drilling-structure-graph');
                Route::get('/inclino', function () {
                    return view('digital_drilling.bd.inclino');
                })->name('digital-drilling-inclino');
                Route::get('/inclino-graph', function () {
                    return view('digital_drilling.bd.inclino-graph');
                })->name('digital-drilling-inclino-graph');
                Route::get('/project-data', function () {
                    return view('digital_drilling.bd.project-data');
                })->name('digital-drilling-project-data');
            });
            // Project
            Route::group(['prefix' => '/project'], function () {
                Route::get('/well-profile', function () {
                    return view('digital_drilling.project.well-profile');
                })->name('digital-drilling-well-profile');
                Route::get('/well-profile-graph', function () {
                    return view('digital_drilling.project.well-profile-graph');
                })->name('digital-drilling-well-profile-graph');
                Route::get('/calculation', function () {
                    return view('digital_drilling.project.calculation');
                })->name('digital-drilling-calculation');
                Route::get('/calculation-graph', function () {
                    return view('digital_drilling.project.calculation-graph');
                })->name('digital-drilling-calculation-graph');
                Route::get('/rasters', function () {
                    return view('digital_drilling.project.rasters');
                })->name('digital-drilling-rasters');
                Route::get('/rasters-params', function () {
                    return view('digital_drilling.project.rasters-params');
                })->name('digital-drilling-rasters-params');
                Route::get('/rasters-component', function () {
                    return view('digital_drilling.project.rasters-component');
                })->name('digital-drilling-rasters-component');
                Route::get('/deepening', function () {
                    return view('digital_drilling.project.deepening');
                })->name('digital-drilling-deepening');
                Route::get('/deepening-graph', function () {
                    return view('digital_drilling.project.deepening-graph');
                })->name('digital-drilling-deepening-graph');
                Route::get('/deepening-params', function () {
                    return view('digital_drilling.project.deepening-params');
                })->name('digital-drilling-deepening-params');

                Route::get('/fastening', function () {
                    return view('digital_drilling.project.fastening');
                })->name('digital-drilling-fastening');
                Route::get('/fastening-page2', function () {
                    return view('digital_drilling.project.fastening-page2');
                })->name('digital-drilling-fastening-page2');
                Route::get('/fastening-page3', function () {
                    return view('digital_drilling.project.fastening-page3');
                })->name('digital-drilling-fastening-page3');
                Route::get('/fastening-page4', function () {
                    return view('digital_drilling.project.fastening-page4');
                })->name('digital-drilling-fastening-page4');
                Route::get('/fastening-page5', function () {
                    return view('digital_drilling.project.fastening-page5');
                })->name('digital-drilling-fastening-page5');
                Route::get('/fastening-page6', function () {
                    return view('digital_drilling.project.fastening-page6');
                })->name('digital-drilling-fastening-page6');
                Route::get('/fastening-page7', function () {
                    return view('digital_drilling.project.fastening-page7');
                })->name('digital-drilling-fastening-page7');
            });
            // Online
            Route::group(['prefix' => '/online'], function () {
                Route::get('/alarm', function () {
                    return view('digital_drilling.online.alarm');
                })->name('digital-drilling-alarm');
                Route::get('/geo-first', function () {
                    return view('digital_drilling.online.geo-first');
                })->name('digital-drilling-geo-first');
                Route::get('/geo-second', function () {
                    return view('digital_drilling.online.geo-second');
                })->name('digital-drilling-geo-second');
                Route::get('/geo-third', function () {
                    return view('digital_drilling.online.geo-third');
                })->name('digital-drilling-geo-third');
                Route::get('/sector', function () {
                    return view('digital_drilling.online.sector');
                })->name('digital-drilling-sector');
                Route::get('/visual', function () {
                    return view('digital_drilling.online.visual');
                })->name('digital-drilling-visual');
                Route::get('/report1', function () {
                    return view('digital_drilling.online.report1');
                })->name('digital-drilling-report1');
                Route::get('/report2', function () {
                    return view('digital_drilling.online.report2');
                })->name('digital-drilling-report2');
            });
            // Online
            Route::group(['prefix' => '/supervising'], function () {
                Route::get('/reports', function () {
                    return view('digital_drilling.supervising.reports');
                })->name('digital-drilling-reports');
                Route::get('/balance', function () {
                    return view('digital_drilling.supervising.balance');
                })->name('digital-drilling-balance');
                Route::get('/balance', function () {
                    return view('digital_drilling.supervising.balance');
                })->name('digital-drilling-balance');
                Route::get('/balance-second', function () {
                    return view('digital_drilling.supervising.balance-graph-first');
                })->name('digital-drilling-balance-second');
                Route::get('/balance-third', function () {
                    return view('digital_drilling.supervising.balance-graph-second');
                })->name('digital-drilling-balance-third');
                Route::get('/fact', function () {
                    return view('digital_drilling.supervising.fact');
                })->name('digital-drilling-fact');
                Route::get('/npv', function () {
                    return view('digital_drilling.supervising.npv');
                })->name('digital-drilling-npv');
                Route::get('/akc', function () {
                    return view('digital_drilling.supervising.akc');
                })->name('digital-drilling-akc');
            });
            // Online
            Route::group(['prefix' => '/analytics'], function () {
                Route::get('/deepening-inclino', function () {
                    return view('digital_drilling.analytics.deepening');
                })->name('digital-drilling-analytics-deepening-inclino');
                Route::get('/deepening-visual', function () {
                    return view('digital_drilling.analytics.deepening-visual');
                })->name('digital-drilling-analytics-deepening-visual');
                Route::get('/deepening-knbk', function () {
                    return view('digital_drilling.analytics.deepening-knbk');
                })->name('digital-drilling-analytics-deepening-knbk');
                Route::get('/deepening-params', function () {
                    return view('digital_drilling.analytics.deepening-params');
                })->name('digital-drilling-analytics-deepening-params');
                Route::get('/deepening-bur', function () {
                    return view('digital_drilling.analytics.deepening-bur');
                })->name('digital-drilling-analytics-deepening-bur');
                Route::get('/deepening-gidro', function () {
                    return view('digital_drilling.analytics.deepening-gidro');
                })->name('digital-drilling-analytics-deepening-gidro');
                Route::get('/deepening-sorting', function () {
                    return view('digital_drilling.analytics.deepening-sorting');
                })->name('digital-drilling-analytics-deepening-sorting');
                Route::get('/deepening-selection', function () {
                    return view('digital_drilling.analytics.deepening-selection');
                })->name('digital-drilling-analytics-deepening-selection');

                Route::get('/fastening-first', function () {
                    return view('digital_drilling.analytics.fastening-first');
                })->name('digital-drilling-analytics-fastening-first');
                Route::get('/fastening-second', function () {
                    return view('digital_drilling.analytics.fastening-second');
                })->name('digital-drilling-analytics-fastening-second');
                Route::get('/fastening-third', function () {
                    return view('digital_drilling.analytics.fastening-third');
                })->name('digital-drilling-analytics-fastening-third');

                Route::get('/complications', function () {
                    return view('digital_drilling.analytics.complications');
                })->name('digital-drilling-analytics-complications');
                Route::get('/akc', function () {
                    return view('digital_drilling.analytics.akc');
                })->name('digital-drilling-analytics-akc');
                Route::get('/balance', function () {
                    return view('digital_drilling.analytics.balance');
                })->name('digital-drilling-analytics-balance');
            });
        });
    });