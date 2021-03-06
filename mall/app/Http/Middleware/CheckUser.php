<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Miscellaneous;
use App\Models\GeneralSetting;
use Illuminate\Http\Response;
use App\Library\Helper;
use Config;

use Session;

class CheckUser {

//    public function handle($request, Closure $next) {
//        if ($this->auth->guest()) {
//            if ($request->ajax()) {
//                return response('Unauthorized.', 401);
//            } else {
//
//                $user = User::find(Session::get('loggedinUserId'))->first()->toArray();
//
//                dd($user);
//
//                //return redirect()->guest('auth/login');
//            }
//        }
//
//        return $next($request);
//    }

    public function handle($request, Closure $next) {
   $industry= array_key_exists('industry_id',Helper::getSettings())?Helper::getSettings()['industry_id']:1;
        Config::set('app.industry', $industry);
        //dd("sdf");
        
     //  $curRoute = $request->route()->getName();
        //        dd($curRoute);
        //print_r($next);
        //dd($request);
        if (!empty(Session::get('loggedinAdminId'))) {            
            $chk = GeneralSetting::where('url_key','acl')->first()->status;
            //print($chk);
//            if ($chk == 1) {
//                echo "dasdsad";
//            }else{
//                //die;
//            }
            if ($chk == 1) {
                 //dd($chk);
                $user = User::with('roles')->find(Session::get('loggedinAdminId'));
                $roles = $user->roles;
                $roles_data = $roles->toArray();
                $r = Role::find($roles_data[0]['id']);
               // dd($r);
                $per = $r->perms()->get(['name'])->toArray();
                $curRoute = $request->route()->getName();
               // dd(json_encode($per));
                if (!in_array($curRoute, array_flatten($per))) {
                    abort(403);
                   // return redirect()->route('unauthorized'); //view('Admin.pages.unauthorized');
                // return new  Response(view('Admin.pages.unauthorized'));
                }
                return $next($request);
            } else {
                return $next($request);
            }
        } else {
            return redirect()->route('adminLogin');
        }
    }

}
