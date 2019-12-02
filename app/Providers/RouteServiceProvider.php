<?php

namespace App\Providers;

use Illuminate\Routing\Router;
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

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map() {
        //$req_uri = \URL::to('/');
        //$_SERVER['REQUEST_URI']

        $req_uri = $_SERVER['REQUEST_URI'];
       
        $path = explode('/admin', $req_uri);
        
        $getprefix = explode("/",$req_uri);
     
 
        if ($getprefix[1] == 'merchant') {
          
            //echo  "2".$path[0]; die;
            $this->mapMerchantRoutes();
        } elseif ($getprefix[1] == 'bank') {
            //echo  "3".$path[0]; die;
            $this->mapBankRoutes();
        } elseif ($getprefix[1] == 'api-merchant') {
            
            $this->mapApiRoutes();
        } else if($getprefix[1] == 'admin'){
           
            $this->mapVswipeRoutes(); 
        }else{
              $this->mapWebRoutes(); 
        }
     
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

  

//
    protected function mapVswipeRoutes() {
        Route::group(['middleware' => 'web', 'prefix' => 'admin', 'namespace' => $this->namespace], function ($router) {
            require base_path('routes/vswipe.php');
        });
    }

    protected function mapBankRoutes() {
        Route::group(['middleware' => 'web', 'prefix' => 'bank/admin', 'namespace' => $this->namespace], function ($router) {
            require base_path('routes/bank.php');
        });
    }

    protected function mapMerchantRoutes() {
          

        Route::group(['middleware' => 'web', 'prefix' => 'merchant/admin', 'namespace' => $this->namespace], function ($router) {
            require base_path('routes/merchant.php');
        });
    }

//    
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
            'prefix' => 'api-merchant',
                ], function ($router) {
            require base_path('routes/api.php');
        });
    }

}
