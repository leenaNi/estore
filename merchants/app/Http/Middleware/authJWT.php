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

class authJWT {

    public function handle($request, Closure $next) {
        try {
           
            $user = JWTAuth::toUser($request->header('token'));
               // dd($user); die('bhavana');
             if (!empty($user->id)) {            
            $chk = GeneralSetting::where('url_key','acl')->first()->status;
            if ($chk == 1) {
                $user = User::with('roles')->find($user->id);
                $roles = $user->roles;
                $roles_data = $roles->toArray();
                $r = Role::find($roles_data[0]['id']);
                $per = $r->perms()->get(['name'])->toArray();
                $curRoute = $request->route()->getName();
                if (!in_array($curRoute, array_flatten($per))) {
                   return response()->json(['error' => 'unauthorized']);
                }
                return $next($request);
            } else {
                return $next($request);
            }
        }
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
