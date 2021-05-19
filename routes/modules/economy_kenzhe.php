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
                Route::get('/field_calculation', 'EconomyKenzhe\FieldCalcController@index');
                Route::match(['GET', 'POST'], '/import_rep', 'EconomyKenzhe\ImportController@importRepTtValues')->name('import_rep');
                Route::match(['GET', 'POST'], '/import_reptt_titles', 'EconomyKenzhe\ImportController@importRepTtTitlesTree')->name('import_reptt_titles');
                Route::get('/comp', function(){
                    $client = new \GuzzleHttp\Client();
                    $response = $client->request('GET','http://dashboard/kenzhe/api/company/values/181/2020-01-01/2020-04-01', ['headers'=>['api-key'=>'12345']]);
                    return response($response->getBody())->header('Content-Type', 'application/json');
                });
            });
    }
);


Route::middleware('economy_api')->prefix('kenzhe')->group(function () {
    Route::prefix('api')->group(function(){
        Route::get('/companies', 'EconomyKenzhe\ApiController@companies');
        Route::get('/company/values/{id}/{dateFrom}/{dateTo}', 'EconomyKenzhe\ApiController@companyValues');
        Route::get('/company/{id}', 'EconomyKenzhe\ApiController@company');
    });
});
