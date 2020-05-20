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
use App\Library\Helper;
use Closure;
use JWTAuth;
use Exception;
use Auth;

class authJWT {

    public function handle($request, Closure $next) {
     
        
        try {
           // print_r($request->header('token'));
          // dd($request->headers->all());
            $user = JWTAuth::toUser($request->header('token'));
            Auth::guard('merchant-users-web-guard')->login($user, true);
                   Helper::postLogin($user);

        } catch (Exception $e) {
           
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json(['error' => 'Token is Invalid']);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json(['error' => 'Token is Expired']);
            } else {
                return response()->json(['error' => 'Something is wrong']);
            }
        }
       // dd('fkjgdkjh');
       // header('token',$request->input('token'));
        //->header('token',$request->input('token'))
        return $next($request);
    }

}
