<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return redirect('/'. App\Http\Middleware\LocaleMiddleware::$mainLanguage);
});



Route::group(['prefix' => App\Http\Middleware\LocaleMiddleware::getLocale()], function() {
    Route::group(['middleware' => 'auth'], function () {
        Route::get("/geteconimicdata", "DruidController@getEconomicData");
        Route::get('/', function () {
            return view('welcome');
        });
        Route::get('/druid', 'DruidController@index');
        Route::get('/oilprice', 'DruidController@getOilPrice');
        Route::get('/getnkkmg', 'DruidController@getNkKmg');
        Route::get('/getnkkmgyear', 'DruidController@getNkKmgYear');
        Route::get('/economic', 'DruidController@economic')->name('economic');
        Route::get('/visualcenter', 'DruidController@visualcenter')->name('visualcenter');
        Route::get('/production', 'DruidController@production')->name('production');
        Route::get('/gtmscor', 'DruidController@gtmscor')->name('gtmscor');
        Route::get('/mfond', 'DruidController@mfond')->name('mfond');
        Route::get('/oil', 'DruidController@oil')->name('oil');
        Route::get('/facilities', 'DruidController@facilities')->name('facilities');
        Route::get('/liquid', 'DruidController@liquid')->name('liquid');
        Route::get('/hydraulics', 'DruidController@hydraulics')->name('hydraulics');
        Route::get('/complications', 'DruidController@complications')->name('complications');
        Route::get('/tabs', 'DruidController@tabs')->name('tabs');
        Auth::routes();
        Route::get('/home', 'HomeController@index')->name('home');
        Route::resource('oildaily','OilDailyController');
        Route::get('/maps', 'DruidController@maps')->name('maps');
    });
    Auth::routes([
        'reset' => false,
        'verify' => false,
        'register' => false,
    ]);
});

Route::get('setlocale/{lang}', function ($lang) {
    $referer = Redirect::back()->getTargetUrl();
    $parse_url = parse_url($referer, PHP_URL_PATH);
    $segments = explode('/', $parse_url);

    if (in_array($segments[1], App\Http\Middleware\LocaleMiddleware::$languages)) {
        unset($segments[1]);
    }

    array_splice($segments, 1, 0, $lang);
    $url = Request::root().implode("/", $segments);

    if(parse_url($referer, PHP_URL_QUERY)){
        $url = $url.'?'. parse_url($referer, PHP_URL_QUERY);
    }

    return redirect($url);
})->name('setlocale');


