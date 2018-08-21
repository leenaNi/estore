<?php

//namespace App\Http\Middleware;
//
//use Closure;
//
//class authJWT
//{
//    /**
//     * Handle an incoming request.
//     *
//     * @param  \Illuminate\Http\Request  $request
//     * @param  \Closure  $next
//     * @return mixed
//     */
//    public function handle($request, Closure $next)
//    {
//        return $next($request);
//    }
//}

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use App\Models\GeneralSetting;
use App\Models\User;
use App\Models\Role;
use App\Library\Helper;

class authJWTFrantend {

    public function handle($request, Closure $next) {
        try {
           
            $user = JWTAuth::toUser($request->header('token'));
           // dd($user); die('bhavana');
           
        } catch (Exception $e) {
           
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['error' => 'Token is Invalid']);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['error' => 'Token is Expired']);
            } else {
                return response()->json(['error' => 'Something is wrong']);
            }
        }
        return $next($request);
    }

}
