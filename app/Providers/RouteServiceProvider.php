<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = "/home";

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix("api")
                ->middleware("api")
                ->namespace($this->namespace)
                ->group(base_path("routes/api.php"));

            Route::middleware("web")
                ->prefix("admin")
                ->namespace($this->namespace)
                ->group(base_path("routes/admin.php"));

            Route::middleware("web")
                ->namespace($this->namespace)
                ->group(base_path("routes/business.php"));

            Route::middleware("web")
                ->namespace($this->namespace)
                ->group(base_path("routes/web.php"));

            $this->mapApiRoutes(base_path('routes/api'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for("api", function (Request $request) {
            return Limit::perMinute(60)->by(
                optional($request->user())->id ?: $request->ip()
            );
        });
    }

    private function mapApiRoutes($dir)
    {
        if (is_dir($dir)) {
            if ($dh = opendir($dir)) {
                while (($file = readdir($dh)) !== false) {
                    $filename = explode('.',$file);
                    if (end($filename) === 'php'){
                        Route::prefix('api')
                            ->namespace($this->namespace)
                            ->middleware('web')
                            ->group(base_path('routes/api/'.$file));
                    }
                }
                closedir($dh);
            }
        }
    }
}
