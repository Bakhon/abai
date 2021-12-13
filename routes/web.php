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
        Route::get('/faq', 'FaqController@index')->name('faq');;
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

                Route::get('ecorefslist', 'Refs\EcoRefsScFaController@refsList')->name('eco_refs_list');
                Route::post('/getkormass', 'ComplicationMonitoring\OmgNGDUController@getKormass');

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
                Route::get('/paegtm/comparison_indicators_data', 'GTM\GTMController@getComparisonIndicators')->name(
                    'gtm'
                );

                Route::post('attachments', 'AttachmentController@upload')->name('attachment.upload');
                Route::get('attachments/file-info/{attachment}', 'AttachmentController@getFileInfo')->name('attachment.get-file-info');
                Route::get('attachments/{attachment}', 'AttachmentController@download')->name('attachment.download');

                Route::post('map-constructor/import', 'MapConstructorController@importFile');
                Route::post('map-constructor/get_data_from_excel', 'MapConstructorController@getDataFromExcel');
                Route::post('map-constructor/get_interpolation_data', 'MapConstructorController@getInterpolationData');
                Route::post('map-constructor/structure', 'MapConstructorController@getStructure');
                Route::post('map-constructor/wells', 'MapConstructorController@getWells');
                Route::post('map-constructor/get_grid_by_base64', 'MapConstructorController@getGridByBase64');
                Route::get('/ceo-module-state', 'ModuleStateController@ceoModuleState');
                Route::get('/get-module-state', 'ModuleStateController@getStates');
                Route::get('/get-module-header', 'ModuleStateController@getHeader');
                Route::get('/ceo-module-state-input', 'ModuleStateController@ceoModuleStateInput');
                Route::post('/store-module-state', 'ModuleStateController@storeStates');
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
