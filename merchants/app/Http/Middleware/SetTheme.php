<?php

namespace App\Http\Middleware;

use Closure;
use App;
use Config;
use Session;
use App\Library\Helper;
use Illuminate\Http\Response;
use Route;
use DateTime;

class SetTheme {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
       
//        $expiry = date_create(App\Library\Helper::getSettings()['expiry_date']);
//        $date2 = date_create(date("Y-m-d"));
//       
//        $expiryd = date_diff($date2, $expiry);
//
//        $expirydate = $expiryd->format("%a");
//
//        if ($expiryd <= 0) {
//                return new Response(view('Frontend.pages.store_expire'));
//            }
          
//        return new Response(view('Frontend.pages.store_expire'));
//        $data = (array) Helper::getSettings();
//        if (array_key_exists('expiry_date', $data)) {
//            $today = date("Y-m-d");
//            
//            $expdate= new DateTime($data['expiry_date']);
//            $today = new DateTime();
//            
//            
//            $dateDiff = date_diff($today, $expdate);
//            $getDiff = $dateDiff->format("%d");
//            if ($expiryd <= 0) {
//                return new Response(view('Frontend.pages.store_expire'));
//            }
//        }

            $theme = Helper::getSettings()['theme'];
            // $theme = "fs2";
            if (!empty($theme)) {
                $theme = $theme . "_";
            }
            $this->setEnvironmentValueApp('ACTIVE_THEME', 'app.active_theme', $theme);
            return $next($request);
        }

        private

        function setEnvironmentValueApp($environmentName, $configKey, $newValue) {

//    file_put_contents(App::environmentFilePath(), str_replace(
//        $environmentName . '=' .env($environmentName),
//        $environmentName . '=' . $newValue,
//        file_get_contents(App::environmentFilePath())
//    ));

            Config::set($configKey, $newValue);

            // Reload the cached config       
//    if (file_exists(App::getCachedConfigPath())) {
//        Artisan::call("config:cache");
//    }
        }

    }
    