<?php

namespace App\Http\Controllers\Admin;

use Input;
use App\Models\BankRole;
use App\Models\BankUser;
use Hash;
use Auth;
use Session;
use App\Http\Controllers\Controller;
use App\Library\Helper;

class BankUsersController extends Controller {

    public function index() {


        $vusers = BankUser::where("bank_id", $this->getbankid())->orderBy("id", "desc");


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
        $roles = BankRole::get(['id', 'name'])->toArray();

        return view(Config('constants.AdminPagesBankUsersUsers') . '.index', compact('vusers', 'roles'));
    }

    public function addEdit() {
        $vuser = BankUser::findOrNew(Input::get('id'));

        $bankUsers = BankUser::where("bank_id", $this->getbankid())->with('roles')->get();
//        $bRoles = [];
//        foreach ($bankUsers as $bu) {
//            array_push($bRoles, $bu->roles()->first(['id', 'display_name']));
//        }
        $bRoles = BankRole::where("bank_id",$this->getbankid(['id', 'display_name']))->get();
        
        $roles_name = ["" => "Please Select"];
        if (!empty($bRoles)) {  
            foreach ($bRoles as $role) {
                $roles_name[$role->id] = $role->display_name;
            }
        }
        $action = 'admin.bankusers.users.saveUpdate';
        return view(Config('constants.AdminPagesBankUsersUsers') . '.addEdit', compact('vuser', 'action', 'roles_name'));
    }

    public function save() {
        $chk = BankUser::where("email", "=", Input::get('email'))->first();

        if (empty($chk)) {
            $user = new BankUser();

            $user->name = Input::get('name');
            $user->email = Input::get('email');
            $user->password = Hash::make(Input::get('password'));
            $user->user_type = 1;
            $user->added_by = Session::get('authUserId');
            $user->bank_id = $this->getbankid();
         
            $user->save();

            if (!empty(Input::get('roles'))) {
                $user->roles()->sync([Input::get('roles')]);
            }
            return redirect()->route('admin.bankusers.users.view');
        } else {
            Session::flash("usenameError", "Username already exist");
            return redirect()->back();
        }
    }

    public function saveUpdate() {

        $validation = new BankUser();
        $checkValidation = Helper::getValidation($validation, Input::all());

        if ($checkValidation == 1) {

            $user = BankUser::findOrNew(Input::get('id'));
            $user->name = Input::get('name');
            $user->email = Input::get('email');
            $user->password = (Input::get('password')) ? Hash::make(Input::get('password')) : $user->password;
            $user->updated_by = Session::get('authUserId');
            $user->bank_id = $this->getbankid();
            $user->save();
            if (!empty(Input::get('roles'))) {
                $user->roles()->sync([Input::get('roles')]);
            }
        } else {
            return $checkValidation;
        }


        return redirect()->route('admin.bankusers.users.view');
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
