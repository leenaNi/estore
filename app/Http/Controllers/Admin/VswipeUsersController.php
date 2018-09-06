<?php

namespace App\Http\Controllers\Admin;

use Input;
use App\Models\VswipeRole;
use App\Models\VswipeUser;
use Hash;
use Auth;
use Session;
use App\Library\Helper;
use App\Http\Controllers\Controller;
use DB;

class VswipeUsersController extends Controller {

    public function index() {
         $orders=DB::table("has_products")->orderBy("has_products.id","desc")->join("stores","stores.id",'=',"has_products.store_id")->select('has_products.*', 'stores.store_name')->paginate(Config('constants.AdminPaginateNo'));
       dd($orders);
         
         $vusers = VswipeUser::orderBy('id', 'desc');

        $search = Input::get('search');

        if (!empty($search)) {

            if (!empty(Input::get('s_name'))) {
                $vusers = $vusers->where("name", "like", "%" . Input::get('s_name') . "%");
            }

            if (!empty(Input::get('s_email'))) {
                $vusers = $vusers->where("email", "like", "%" . Input::get('s_email') . "%");
            }
            if (!empty(Input::get('date_search'))) {
                $dateArr = explode(" - ", Input::get('date_search'));
                $fromdate = date("Y-m-d", strtotime($dateArr[0])) . " 00:00:00";
                $todate = date("Y-m-d", strtotime($dateArr[1])) . " 23:59:59";

                $vusers = $vusers->where("created_at", ">=", "$fromdate")->where("created_at", "<", "$todate");
            }
        }
        $vusers = $vusers->paginate(Config('constants.AdminPaginateNo'));

        $roles = VswipeRole::get(['id', 'name'])->toArray();

        return view(Config('constants.AdminPagesSystemUsersUsers') . '.index', compact('vusers', 'roles'));
    }

    public function addEdit() {

        $vuser = VswipeUser::findOrNew(Input::get('id'));

        $roles = VswipeRole::get(['id', 'display_name'])->toArray();
        $roles_name = ["" => "Please Select"];
        foreach ($roles as $role) {
            $roles_name[$role['id']] = $role['display_name'];
        }
        $action = 'admin.systemusers.users.saveUpdate';
        return view(Config('constants.AdminPagesSystemUsersUsers') . '.addEdit', compact('vuser', 'action', 'roles_name'));
    }

    public function save() {
        $chk = VswipeUser::where("email", "=", Input::get('email'))->first();

        if (empty($chk)) {
            $user = new VswipeUser();

            $user->name = Input::get('name');
            $user->email = Input::get('email');
            $user->password = Hash::make(Input::get('password'));
            $user->user_type = 1;
            $user->save();

            if (!empty(Input::get('roles'))) {
                $user->roles()->sync([Input::get('roles')]);
            }
            return redirect()->route('admin.systemusers.users.view');
        } else {
            Session::flash("usenameError", "Username already exist");
            return redirect()->back();
        }
    }

    public function saveUpdate() {
        $validation = new VswipeUser();
        $checkValidation = Helper::getValidation($validation, Input::all());

        if ($checkValidation == 1) {
            $user = VswipeUser::findOrNew(Input::get('id'));
            $user->name = Input::get('name');
            $user->email = Input::get('email');
            $user->password = (Input::get('password')) ? Hash::make(Input::get('password')) : $user->password;
            $user->save();

            if (!empty(Input::get('roles'))) {
                $user->roles()->sync([Input::get('roles')]);
            }
        } else {
            return $checkValidation;
        }
        return redirect()->route('admin.systemusers.users.view');
    }

    public function chk_existing_username() {
        $getname = Input::get('username');
        // dd($getname);
        $chk = User::where("user_name", "=", $getname)->first();

        if (!empty($chk)) {
            echo "Invalid";
        } else {

            echo "valid";
        }
    }

    public function delete() {
        $user = User::find(Input::get('id'));
        $user->delete();
        return redirect()->back()->with("message", "User deleted successfully!");
    }

}
