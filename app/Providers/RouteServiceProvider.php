<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
        $this->mapAdminRoutes();
        $this->mapRoutesByModules();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapAdminRoutes()
    {
        Route::prefix('admin')
            ->middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/admin.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapRoutesByModules()
    {
        $modules = [
            'db_prototype',
            'visual_center',
            'gno',
            'monitoring',
            'economy_kenzhe',
            'tr',
            'DigitalMonitoringWellInterventionAndWorkover',
            'monitoring',
            'paegtm',
            'ndo',
            'economy_kenzhe',
            'digital_drilling',
            'plast_fluids',
            'geology',
            'digital_rating',
            'map_constructor',
            'waterflooding_management',
            'economic',
            'prod_planning'
//             'prod_planning',

        ];

        foreach ($modules as $module) {
            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path("routes/modules/{$module}.php"));
        }
    }
}
