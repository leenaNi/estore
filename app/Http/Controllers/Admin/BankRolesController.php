<?php

namespace App\Http\Controllers\Admin;

use Route;
use Input;
use App\Models\BankRole;
use App\Models\BankPermission;
use App\Library\Helper;
use App\Http\Controllers\Controller;
use Config;

class BankRolesController extends Controller {

    public function index() {
        
        //dd(BankRole::with('bankusers')->get());
//        $roles = BankRole::whereHas('bankusers',function($qr){
//            $qr->where("bank_id",1);
//        });
//dd($roles);
        
        $roles = BankRole::where("bank_id",$this->getbankid());
        $search = Input::get('search');

        if (!empty($search)) {

            if (!empty(Input::get('s_role_name'))) {
                $roles = $roles->where("name", "like", "%" . Input::get('s_role_name') . "%");
            }
            if (!empty(Input::get('date_search'))) {
                $dateArr = explode(" - ", Input::get('date_search'));
                $fromdate = date("Y-m-d", strtotime($dateArr[0])) . " 00:00:00";
                $todate = date("Y-m-d", strtotime($dateArr[1])) . " 23:59:59";

                $roles = $roles->where("created_at", ">=", "$fromdate")->where("created_at", "<", "$todate");
            }
        }
        $roles = $roles->paginate(Config('constants.AdminPaginateNo'));
        return view(Config('constants.AdminPagesBankUsersRoles') . '.index', compact('roles'));
    }

    public function addEdit() {
        //dd(Route::getRoutes());
        foreach (Route::getRoutes() as $value) {
            if (strpos($value->getPrefix(), "bank/admin") !== false) {

                try {
                    $displayName = ucwords(strtolower(str_replace(".", " ", str_replace("admin.", "", $value->getName()))));
                    $permissions = new BankPermission();
                    $permissions->name = $value->getName();
                    $permissions->display_name = $displayName;
                    $permissions->save();
                } catch (\Illuminate\Database\QueryException $e) {
                    
                }
            }
        }
        $permissions = BankPermission::all();

        $role = BankRole::findOrNew(Input::get('id'));

        return view(Config('constants.AdminPagesBankUsersRoles') . '.addEdit', compact('permissions', 'role', 'action'));
    }

    public function saveUpdate() {

        $validation = new BankRole();
        $checkValidation = Helper::getValidation($validation, Input::all());

        if ($checkValidation == 1) {

            $role = BankRole::findOrNew(Input::get('id'));
            $role->name = Input::get('name');
            $role->display_name = Input::get('display_name');
            $role->description = Input::get('description');
            $role->bank_id = @$this->getbankid();
            $role->save();

            if (!empty(Input::get('chk'))) {
                $role->perms()->sync(Input::get('chk'));
            }
        } else {
            return $checkValidation;
        }


        return redirect()->route('admin.bankusers.roles.view');
    }

    public function delete() {
        $roles = BankRole::find(Input::get('id'));
        $getUsers = $roles->users()->get()->toArray();
        if (empty($getUsers)) {
            $roles->delete();
            return redirect()->back()->with("message", "Role deleted sucessfully");
        } else {
            return redirect()->back()->with("message", "Sorry,You can not delete role!");
        }
    }

}
