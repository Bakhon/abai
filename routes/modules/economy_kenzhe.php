<?php
Route::group(
    ['prefix' => App\Http\Middleware\LocaleMiddleware::getLocale()],
    function () {
        Route::group(
            ['middleware' => 'auth','prefix' => 'module_economy'],
            function () {
                Route::get('/', 'EconomyKenzhe\MainController@index');
                Route::get('/company', 'EconomyKenzhe\MainController@company')->name('company');
                Route::get('/companies', 'EconomyKenzhe\MainController@companies');
                Route::get('/field-calculation', 'EconomyKenzhe\FieldCalcController@index');
                Route::match(['GET', 'POST'], '/import_rep', 'EconomyKenzhe\ImportController@importRepTtValues')->name('import_rep');
                Route::match(['GET', 'POST'], '/import_reptt_titles', 'EconomyKenzhe\ImportController@importRepTtTitlesTree')->name('import_reptt_titles');
                Route::get('/proactive-factors', 'EconomyKenzhe\proactiveFactorsController@proactiveFactors')->name('proactiveFactors');
                Route::get('/budget-execution', 'EconomyKenzhe\BudgetExecutionController@budgetExecution')->name('budgetExecution');
                Route::get('/company-valuation', 'EconomyKenzhe\CompanyValuationController@companyValuation')->name('companyValuation');
                
                //  reference book links                
                Route::resource('ecorefsscfa', 'Refs\EcoRefsScFaController');
                Route::get('eco_refs_sc_fas', 'Refs\EcoRefsScFaController@getData');
                Route::resource('ecorefsbranchid', 'EcoRefsBrachIdController');
                Route::resource('ecorefscompaniesids', 'EcoRefsCompaniesIdsController');
                Route::resource('ecorefsequipid', 'EcoRefsEquipIdController');
                Route::resource('ecorefsrouteid', 'EcoRefsRouteIdController');
                Route::resource('ecorefsroutetnid', 'EcoRefsRouteTnIdController');
                Route::resource('ecorefsdirection', 'EcoRefsDirectionController');
                Route::resource('ecorefsannualprodvolume', 'EcoRefsAnnualProdVolumeController');
                Route::resource('ecorefsavgmarketprice', 'EcoRefsAvgMarketPriceController');
                Route::resource('ecorefselectprsbrigcost', 'EcoRefsPrepElectPrsBrigCostController');
                Route::resource('ecorefsndorates', 'EcoRefsNdoRatesController');
                Route::resource('ecorefsrentequipelectservcost', 'EcoRefsRentEquipElectServCostController');
                Route::resource('ecorefsservicetime', 'EcoRefsServiceTimeController');
                Route::resource('ecorefsrenttax', 'EcoRefsRentTaxController');
                Route::resource('ecorefsexc', 'EcoRefsExcController');
                Route::resource('ecorefsprocdob', 'EcoRefsProcDobController');
                Route::resource('ecorefsavgprs', 'EcoRefsAvgPrsController');                                 
                
                Route::resource('eco_refs_cost', 'EcoRefsCostController');
                Route::get('eco_refs_costs', 'EcoRefsCostController@getData');                
                Route::resource('eco_refs_scenario', 'Refs\EcoRefsScenarioController');
                Route::get('eco_refs_scenarios', 'Refs\EcoRefsScenarioController@getData');   
                Route::get('economic_data/upload_excel', 'EcoRefsCostController@uploadExcel')->name('economic_data_upload');
                Route::post('economic_data/import_excel', 'EcoRefsCostController@importExcel')->name('economic_data_import');             
                Route::resource('economic_data_log', 'Refs\EconomicDataLogController');
                Route::resource('ecorefsmacro', 'EcoRefsMacroController');
                Route::get('eco_refs_macros', 'EcoRefsMacroController@list') ->name('ecorefsmacro.list');
                Route::get('economic_data/upload_excel_macro', 'EcoRefsMacroController@uploadExcel')->name('macro_data_upload');
                Route::post('economic_data/import_excel_macro', 'EcoRefsMacroController@importExcel')->name('macro_data_import');                
                Route::resource('ecorefsempper', 'EcoRefsEmpPerController');
                Route::get('eco_refs_emp_pers', 'EcoRefsEmpPerController@list') ->name('ecorefsempper.list');
                Route::get('economic_data/upload_excel_empper', 'EcoRefsEmpPerController@uploadExcel')->name('empper_data_upload');
                Route::post('economic_data/import_excel_empper', 'EcoRefsEmpPerController@importExcel')->name('empper_data_import');
                Route::resource('ecorefsdiscontcoefbar', 'EcoRefsDiscontCoefBarController');
                Route::get('eco_refs_discont_coef_bars', 'EcoRefsDiscontCoefBarController@list') ->name('ecorefsdiscontcoefbar.list');
                Route::get('economic_data/upload_excel_discontcoefbar', 'EcoRefsDiscontCoefBarController@uploadExcel')->name('discontcoefbar_data_upload');
                Route::post('economic_data/import_excel_discontcoefbar', 'EcoRefsDiscontCoefBarController@importExcel')->name('discontcoefbar_data_import');
                Route::resource('ecorefstarifytn', 'EcoRefsTarifyTnController');
                Route::get('eco_refs_tarify_tns', 'EcoRefsTarifyTnController@list') ->name('ecorefstarifytn.list');
                Route::get('economic_data/upload_excel_tarifytn', 'EcoRefsTarifyTnController@uploadExcel')->name('tarifytn_data_upload');
                Route::post('economic_data/import_excel_tarifytn', 'EcoRefsTarifyTnController@importExcel')->name('tarifytn_data_import');            });
    }
);
