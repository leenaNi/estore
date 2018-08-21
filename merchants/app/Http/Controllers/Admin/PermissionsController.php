<?php

namespace App\Http\Controllers\Admin;

use Input;
use App\Models\Role;
use App\Models\Permission;

class PermissionController extends Controller {

    public function index() {
        return view('permissions');
    }

    public function save_permission() {

        //dd(Input::get('role_name'));
        $permissions = new Permission();
        $permissions->name = Input::get('pname');
        $permissions->display_name = Input::get('display_name');
        $permissions->description = Input::get('description');
        $permissions->save();

        return redirect()->route('permissions');
    }

    public function assign_per_role() {
        $roles = Role::get(['id', 'name']);

        $permissions = Permission::get(['id', 'name']);
        return view('assign_per_role', compact('roles', 'permissions'));
    }

    public function save_per_role() {
        $role = Input::get('role');

        $prmission = Input::get('permission');



        $rolesP = Role::find(Input::get('role'));


        $rolesP->attachPermission(Input::get('permission'));



        //return view('assign_per_role');
        return redirect()->route('assign_per_role');
    }

}
