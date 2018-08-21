<?php

namespace App\Http\Controllers\Admin;

use Route;
use Input;
use App\Models\VswipeRole;
use App\Models\VswipePermission;
use App\Http\Controllers\Controller;
use Config;
use App\Library\Helper;

class VswipeRolesController extends Controller {

    public function index() {
        $roles = VswipeRole::orderBy("id", "desc");

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

        return view(Config('constants.AdminPagesSystemUsersRoles') . '.index', compact('roles'));
    }

    public function addEdit() {
        $per = $permissions = VswipePermission::pluck('display_name')->toArray();

        $newRoutes = [];


        $i = 0;
        foreach (Route::getRoutes() as $value) {

            if (strpos($value->getPrefix(), "admin") !== false) {

                $displayName = ucwords(strtolower(str_replace(".", " ", str_replace("admin.", "", $value->getName()))));
              //  echo $displayName . "<br/>";
                if (!in_array($displayName, $per)) {
                    if (!empty($displayName)) {
                        $newRoutes[$i]['dispname'] = $displayName;
                        $newRoutes[$i]['name'] = $value->getName();
                    }
                }
                $i++;
            }
        }
        if (count($newRoutes) > 0) {
            foreach ($newRoutes as $value) {
                $permissions = new VswipePermission();
                $permissions->name = $value['name'];
                $permissions->display_name = $value['dispname'];
                $permissions->save();
            }
        }

        $permissions = VswipePermission::all();
        $role = VswipeRole::findOrNew(Input::get('id'));
        //dd($role);
        return view(Config('constants.AdminPagesSystemUsersRoles') . '.addEdit', compact('permissions', 'role', 'action'));
    }

    public function saveUpdate() {
     
        
        $validation = new VswipeRole();
        $checkValidation = Helper::getValidation($validation, Input::all());

        if ($checkValidation == 1) {

            $role = VswipeRole::findOrNew(Input::get('id'));
            
            $role->name = Input::get('name');
            $role->display_name = Input::get('display_name');
            $role->description = Input::get('description');
            $role->save();
            if (!empty(Input::get('chk'))) {
                $role->perms()->sync(Input::get('chk'));
            }
            return redirect()->route('admin.systemusers.roles.view');
        } else {
            return $checkValidation;
        }
    }

    public function delete() {
        $roles = VswipeRole::find(Input::get('id'));
        $getUsers = $roles->users()->get()->toArray();
        if (empty($getUsers)) {
            $roles->delete();
            return redirect()->back()->with("message", "Role deleted sucessfully");
        } else {
            return redirect()->back()->with("message", "Sorry,You can not delete role!");
        }
    }

}
