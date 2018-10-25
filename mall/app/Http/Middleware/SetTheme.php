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


        $theme = Helper::getSettings()['theme'];
       // $theme = "fs2";
        if (!empty($theme)) {
            $theme = $theme . "_";
        }
        $this->setEnvironmentValueApp('ACTIVE_THEME', 'app.active_theme', $theme);
        return $next($request);
    }

    private function setEnvironmentValueApp($environmentName, $configKey, $newValue) {

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
