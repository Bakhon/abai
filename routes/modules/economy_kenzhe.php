<?php
Route::group(
    ['prefix' => App\Http\Middleware\LocaleMiddleware::getLocale()],
    function () {
        Route::group(
            ['prefix' => 'module_economy'],
            function () {
                Route::get('/', 'EconomyKenzhe\MainController@index');
                Route::get('/company/', 'EconomyKenzhe\MainController@company')->name('company');
                Route::get('/companies', 'EconomyKenzhe\MainController@companies');
<<<<<<< HEAD
                Route::get('/field_calculation', 'EconomyKenzhe\FieldCalcController@index');
                Route::match(['GET', 'POST'], '/import_rep', 'EconomyKenzhe\ImportController@importRepTtValues')->name('import_rep');
                Route::match(['GET', 'POST'], '/import_reptt_titles', 'EconomyKenzhe\ImportController@importRepTtTitlesTree')->name('import_reptt_titles');
            });
    }
);

=======
                Route::get('/field-calculation', 'EconomyKenzhe\FieldCalcController@index');
                Route::match(['GET', 'POST'], '/import_rep', 'EconomyKenzhe\ImportController@importRepTtValues')->name('import_rep');
                Route::match(['GET', 'POST'], '/import_reptt_titles', 'EconomyKenzhe\ImportController@importRepTtTitlesTree')->name('import_reptt_titles');
                Route::get('/proactive-factors', 'EconomyKenzhe\proactiveFactorsController@proactiveFactors')->name('proactiveFactors');    
            });
    }
);
>>>>>>> configuration/KE-47/change_paths_web
