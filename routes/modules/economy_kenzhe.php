<?php
Route::group(
    ['prefix' => App\Http\Middleware\LocaleMiddleware::getLocale()],
    function () {
        Route::get('/module_economy', 'EconomyKenzhe\MainController@index');
        Route::get('/module_economy/company/', 'EconomyKenzhe\MainController@company')->name('company');
        Route::get('/module_economy/companies', 'EconomyKenzhe\MainController@companies');
        Route::get('/module_economy/nnoeco', 'EconomyKenzhe\FieldCalcController@nnoeco');
        Route::match(['GET', 'POST'], '/import_rep', 'EconomyKenzhe\ImportController@importRepTtValues')->name('import_rep');
        Route::match(['GET', 'POST'], '/import_reptt_titles', 'EconomyKenzhe\ImportController@importRepTtTitlesTree')->name('import_reptt_titles');
    }
);