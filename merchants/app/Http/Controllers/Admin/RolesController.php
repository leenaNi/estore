<?php

namespace App\Http\Controllers\Admin;

use Route;
use Input;
use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use App\Http\Controllers\Controller;
use App\Library\Helper;
use App\Models\Section;
use Session;
use DB;

class RolesController extends Controller {

    public function index() {
        $roles = Role::paginate(Config('constants.paginateNo'));
        // return view(Config('constants.adminRoleView').'.index', compact('roles'));
        $viewname = Config('constants.adminRoleView') . '.index';
        $data = ['roles' => $roles];
        return Helper::returnView($viewname, $data);
    }

    public function add() {
        $per = $permissions = Permission::pluck('display_name')->toArray();
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
                $permissions = new Permission();
                $permissions->name = $value['name'];

                $permissions->display_name = $value['dispname'];
                $secID = Section::where("name", "like", "%" . $value['name'] . "%")->first();

                $permissions->section_id = (!empty($value['section_id'])) ? $secID->id : 57;
                $permissions->save();
            }
        }
        $permissions = Permission::all();
        $sections = Section::where('status', 1)->get();
        $role = new Role();
        $action = "admin.roles.save";
        return view(Config('constants.adminRoleView') . '.addEdit', compact('permissions', 'role', 'action', 'sections'));
    }

    public function edit() {

        ini_set('max_execution_time', -1);
        $per = $permissions = Permission::pluck('display_name')->toArray();
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
                $permissions = new Permission();
                $permissions->name = $value['name'];
                $permissions->display_name = $value['dispname'];
                $secID = Section::where("name", "like", "%" . $value['name'] . "%")->first();
                $permissions->section_id = (!empty($value['section_id'])) ? $secID->id : 57;
                $permissions->save();
            }
        }
        $sections = Section::where('status', 1)->get();
        $permissions = Permission::all();
        $role = Role::find(Input::get('id'));
        $action = "admin.roles.save";
        return view(Config('constants.adminRoleView') . '.addEdit', compact('permissions', 'role', 'action', 'sections'));
    }

    public function save() {
        $role = Role::findOrNew(Input::get('id'));
        $role->name = Input::get('name');
        $role->display_name = Input::get('display_name');
        $role->description = Input::get('description');
        $role->store_id = Helper::getSettings()['store_id'];
        $role->save();
        $check_permissions = Input::get('chk');
        if (!empty(Input::get('chk'))) {
            foreach ($check_permissions as $key => $perm_id) {
                $permission = Permission::find($perm_id);
                if (!$permission->childPermissions->isEmpty()) {
                    $child_prems = $permission->childPermissions->pluck('id')->toArray();
                    foreach ($child_prems as $val) {
                        $ids[] = $val;
                    }
                }
                $ids[] = (int) $perm_id;
            }
        }

        if (!empty(Input::get('chk'))) {
            $role->perms()->sync($ids);
        }
        if (Input::get('id') != '')
            Session::flash("message", "Role updated successfully.");
        else
            Session::flash("message", "Role added successfully.");
        return redirect()->route('admin.roles.view');
        // echo "<script>window.close();</script>";
    }

    public function delete() {
        $chekusers = User::whereHas('roles', function ($query) {
                    $query->where('id', '=', Input::get('id'));
                })->count();
        if ($chekusers > 0) {
            return redirect()->back()->with("message", "Sorry, You can not delete this role. This role assigned to one or more users. If you required to delete this role, First delete users associated to this role. ");
        } else {
            $getRole = Role::find(Input::get('id'));
            $getRole->perms()->sync([]);
             Role::whereId(Input::get('id'))->delete();
            return redirect()->back()->with("msg", "Role deleted sucessfully.");
        }

    }

}
