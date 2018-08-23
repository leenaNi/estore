<?php

namespace App\Providers;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;


class RouteServiceProvider extends ServiceProvider {

    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot() {
     
  
   
        parent::boot();
     
      
    }

    public function changeEnvironmentVariable($key, $value) {
        $path = base_path('.env');

        if (!empty(env($key))) {
            $old = env($key);
        }
        if (file_exists($path)) {
            file_put_contents($path, str_replace(
                            "$key=" . $old, "$key=" . $value, file_get_contents($path)
            ));
        }
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map() {
        //dd("sdfsdf");
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes() {
        
        Route::group([
            'middleware' => 'web',
            'namespace' => $this->namespace,
                ], function ($router) {
            require base_path('routes/web.php');
        });
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes() {
        Route::group([
            'middleware' => 'api',
            'namespace' => $this->namespace,
            'prefix' => 'api',
                ], function ($router) {
            require base_path('routes/api.php');
        });
    }

}
