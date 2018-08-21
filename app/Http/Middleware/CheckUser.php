<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;
use App\Models\VswipeUser;
use App\Models\BankUser;
use App\Models\VswipeRole;
use App\Models\VswipePermission;
use App\Models\BankRole;
use App\Models\BankPermission;
use App\Models\Miscellaneous;
use App\Models\GeneralSetting;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Response;
use Session;
use view;

class CheckUser {

    public function handle($request, Closure $next) {
    
        if (Auth::guard('vswipe-users-web-guard')->check() !== false) {
            $user = VswipeUser::with('roles')->find(Session::get('authUserId'));
            $per = VswipeRole::find($user->roles()->first()->id)->perms()->get(['name'])->toArray();
        } else if (Auth::guard('bank-users-web-guard')->check() !== false) {
            $user = BankUser::with('roles')->find(Session::get('authUserId'));
            $per = BankRole::find($user->roles()->first()->id)->perms()->get(['name'])->toArray();
        }
        if (!empty($per)) {
            $curRoute = $request->route()->getName();
            if (!in_array($curRoute, array_flatten($per))) {
                return new Response(view('Admin.Pages.unauthorized'));
            }
            return $next($request);
        }
    }

}
