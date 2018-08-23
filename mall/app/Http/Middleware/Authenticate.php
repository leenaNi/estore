<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Session;

class Authenticate {

    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth) {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
     
        $activeEmailOpt = $this->getActiveEmail();

        if (!empty(Session::get('loggedin_user_id'))) {
            if ($this->auth->guest()) {
                if ($request->ajax()) {
                    return response('Unauthorized.', 401);
                } else {
                    return redirect()->guest('login-user');
                }
            }

            return $next($request);
        } else {
            return redirect()->guest('login-user');
        }
    }
    
    public function setEnvironmentValue($envKey, $envValue)
{
    $envFile = app()->environmentFilePath();
    $str = file_get_contents($envFile);

    $oldValue= env($envKey);

    $str = str_replace("{$envKey}={$oldValue}", "{$envKey}={$envValue}\n", $str);
    $fp = fopen($envFile, 'w');
    fwrite($fp, $str);
    fclose($fp);
   //$command = 'php artisan config:cache'; exec($command);
    
}

    public function changeEnvironmentVariable($key,$value){
    $path = base_path('.env');
   
    if(!empty(env($key)))
    {
        $old = env($key)? 'true' : 'false';
    }
   
    if (file_exists($path)) {
       
        file_put_contents($path, str_replace(
            "$key=".$old, "$key=".$value, file_get_contents($path)
        ));
    }
}

}
