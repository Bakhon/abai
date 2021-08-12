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

use Illuminate\Support\Facades\Cache;

Route::get(
    '/',
    function () {
        return redirect('/' . App\Http\Middleware\LocaleMiddleware::$mainLanguage);
    }
);

Route::get("/ecoeco", "ComplicationMonitoring\OilGasController@ecoData");

Route::group(
    ['prefix' => App\Http\Middleware\LocaleMiddleware::getLocale()],
    function () {
        Route::group(
            ['middleware' => 'auth'],
            function () {
                Route::post("/corrosion", "DruidController@corrosion");
                Route::get(
                    '/',
                    function () {
                        return view('welcome');
                    }
                )->name('mainpage');

                Route::get('/economic/nrs', 'Economic\EconomicNrsController@index')->name('economic_nrs');
                Route::get('/economic/nrs/get-data', "Economic\EconomicNrsController@getData");
                Route::post('/economic/nrs/export-data', "Economic\EconomicNrsController@exportData");
                Route::get('/economic/optimization', 'Economic\EconomicOptimizationController@index')->name('economic_optimization');
                Route::get('/economic/optimization/get-data', 'Economic\EconomicOptimizationController@getData');

                Route::get('/podborgno', 'gno\GNOController@index')->name('gno');
                Route::get('/gtmscor', 'DruidController@gtmscor')->name('gtmscor');
                Route::get('/calcgtm', 'DruidController@calcGtm')->name('calcgtm');
                Route::get('/mfond', 'DruidController@mfond')->name('mfond');
                Route::get('/map', 'DruidController@map')->name('map');
                Auth::routes();
                Route::get('/home', 'HomeController@index')->name('home');
                Route::get('/gtm', 'DruidController@gtm')->name('gtm');
                Route::get('/dob', 'DruidController@dob')->name('dob');
                Route::get('/constructor', 'DruidController@constructor')->name('constructor');

                //gno economic               
                Route::get('ecorefslist', 'Refs\EcoRefsScFaController@refsList')->name('eco_refs_list');
                Route::post('/getkormass', 'ComplicationMonitoring\OmgNGDUController@getKormass');

                // economic tech data
                Route::get('tech_data_list', 'Refs\TechnicalDataController@refsList')->name('tech_data_list');
                Route::resource('tech_struct_source', 'Refs\TechnicalStructureSourceController');
                Route::get('tech_struct_sources', 'Refs\TechnicalStructureSourceController@getSources');
                Route::resource('tech_struct_company', 'Refs\TechnicalStructureCompanyController');
                Route::resource('tech_struct_field', 'Refs\TechnicalStructureFieldController');
                Route::resource('tech_struct_ngdu', 'Refs\TechnicalStructureNgduController');
                Route::resource('tech_struct_cdng', 'Refs\TechnicalStructureCdngController');
                Route::resource('tech_struct_gu', 'Refs\TechnicalStructureGuController');
                Route::resource('tech_struct_bkns', 'Refs\TechnicalStructureBknsController');
                Route::resource('tech_data_forecast', 'Refs\TechnicalDataForecastController');
                Route::resource('tech_data_log', 'Refs\TechnicalDataLogController');
                Route::get('tech_data_json', 'Refs\TechnicalDataForecastController@techDataJson');
                Route::get('technical_forecast/upload_excel', 'Refs\TechnicalDataController@uploadExcel')->name('tech_refs_upload');
                Route::post('technical_forecast/import_excel', 'Refs\TechnicalDataController@importExcel')->name('tech_refs_import');

                Route::get('nnoeco', 'Refs\EcoRefsScFaController@nnoeco');
                Route::resource('antiecoone', 'AntiCrisis\AntiEcoOneController');
                Route::resource('antiecotwo', 'AntiCrisis\AntiEcoTwoController');

                Route::get('jobs/status', 'JobsController@getStatus')->name('jobs.status');
                Route::get('organizations', 'OrganizationsController@index')->name('organizations');
                Route::get('user_organizations', 'OrganizationsController@getUserOrganizations')->name('user_organizations');
                Route::get('fields', 'FieldController@index')->name('fields');

                Route::get('profile', 'UserController@profile')->name('profile');
                Route::post('modulerequest', 'ModuleController@moduleRequest')->name('modulerequest');
                Route::post('/update_avatar', 'UserController@update_avatar')->name('update_avatar');
                Route::post('/delete_avatar', 'UserController@delete_avatar')->name('delete_avatar');

                Route::get('anticrisis', 'AntiCrisisController@index')->name('anticrisis');

                Route::get('/paegtm', 'GTM\GTMController@index')->name('gtm');
                Route::get('/paegtm/accum_oil_prod_data', 'GTM\GTMController@getAccumOilProd')->name('gtm');
                Route::get('/paegtm/comparison_indicators_data', 'GTM\GTMController@getComparisonIndicators')->name('gtm');                  
            }
        );
        Auth::routes(
            [
                'reset' => false,
                'verify' => true,
                'register' => false,
            ]
        );

        Route::get(
            '/js/lang.js',
            function () {
                $lang = App\Http\Middleware\LocaleMiddleware::getLocale();
                $strings = Cache::rememberForever(
                    'lang_' . $lang . '.js',
                    function () use ($lang) {
                        $files = glob(resource_path('lang/' . $lang . '/*.php'));
                        $strings = [];

                        foreach ($files as $file) {
                            $name = basename($file, '.php');
                            $strings[$name] = require $file;
                        }

                        return $strings;
                    }
                );

                header('Content-Type: text/javascript');
                echo('window.current_lang = "' . $lang . '";');
                echo('window.i18n = ' . json_encode($strings) . ';');
                exit();
            }
        )->name('assets.lang');
    }
);

Route::get(
    'setlocale/{lang}',
    function ($lang) {
        $referer = Redirect::back()->getTargetUrl();
        $parse_url = parse_url($referer, PHP_URL_PATH);
        $segments = explode('/', $parse_url);

        if (in_array($segments[1], App\Http\Middleware\LocaleMiddleware::$languages)) {
            unset($segments[1]);
        }

        array_splice($segments, 1, 0, $lang);
        $url = Request::root() . implode("/", $segments);

        if (parse_url($referer, PHP_URL_QUERY)) {
            $url = $url . '?' . parse_url($referer, PHP_URL_QUERY);
        }

        return redirect($url);
    }
)->name('setlocale');
