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
        });
    });