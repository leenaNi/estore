<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Library\Helper;
use App\Models\Role;
use App\Models\User;
use DB;
use Hash;
use Input;
use Session;

class SuppliersController extends Controller
{

    public function index()
    {
        //dd(base64_decode("YXNkZjEyMzQ="));
        
        $search = !empty(Input::get("empSearch")) ? Input::get("empSearch") : '';
        $suppliers = User::with('roles')->where('user_type', 5)->where("store_id", Session::get('store_id'))->whereIn('status', [1, 0]);

        $roles = Role::get(['id', 'name'])->toArray();
        $search_fields = ['firstname', 'lastname', 'email', 'telephone'];
        if (!empty(Input::get('empSearch'))) {
            $suppliers = $suppliers->where(function ($query) use ($search_fields, $search) {
                foreach ($search_fields as $field) {
                    $query->orWhere($field, "like", "%$search%");
                }
            });
        }

        if (!empty(Input::get('empSearch'))) {
            $suppliers = $suppliers->get();
            $userCount = $suppliers->count();
        } else {
            $suppliers = $suppliers->paginate(Config('constants.paginateNo'));
            $userCount = $suppliers->total();
        }

        $startIndex = 1;
        $getPerPageRecord = Config('constants.paginateNo');
        $allinput = Input::all();
        if(!empty($allinput) && !empty(Input::get('page')))
        {
            $getPageNumber = $allinput['page'];
            $startIndex = ( (($getPageNumber) * ($getPerPageRecord)) - $getPerPageRecord) + 1;
            $endIndex = (($startIndex+$getPerPageRecord) - 1);

            if($endIndex > $userCount)
            {
                $endIndex = ($userCount);
            }
        }
        else
        {
            $startIndex = 1;
            $endIndex = $getPerPageRecord;
            if($endIndex > $userCount)
            {
                $endIndex = ($userCount);
            }
        }


        $viewname = Config('constants.adminSuppliersView') . '.index';
        $data = ['suppliers' => $suppliers, 'roles' => $roles, 'userCount' => $userCount, 'startIndex' => $startIndex, 'endIndex' => $endIndex];
        return Helper::returnView($viewname, $data);
    }

    public function add()
    {
        $user = new User();
        $action = "admin.suppliers.save";
        $roles = Role::where('name', 'LIKE', '%supplier%')->get(['id', 'display_name'])->toArray();
        $roles_name = ["" => "Please Select"];
        foreach ($roles as $role) {
            $roles_name[$role['id']] = $role['display_name'];
        }
        $viewname = Config('constants.adminSuppliersView') . '.addEdit';
        $data = ['user' => $user, 'action' => $action, 'roles_name' => $roles_name];
        return Helper::returnView($viewname, $data);
    }

    public function save()
    {   

     
        

        $chk = User::where("email", "=", Input::get('email'))->where("telephone", "=", Input::get('telephone'))->where('user_type', 1)->first();
        if (Input::get('password')) {
            $password = Input::get('password');
        } else {
            $password = rand(10000, 99999);
        }
        if (empty($chk)) {
            $user = new User();
            $user->firstname = Input::get('firstname');
            $user->lastname = Input::get('lastname');
            $user->email = Input::get('email');
            $user->telephone = Input::get('telephone');
            $user->country_code = Input::get('country_code');
            $user->password = Hash::make($password);
            $user->password_crpt = base64_encode($password);
            //$user->user_type = 1;
            $user->user_type = 5;
            $user->store_id = Helper::getSettings()['store_id'];
            $user->save();

            if (!empty(Input::get('roles'))) {
                $user->roles()->sync([Input::get('roles')]);
            }

            Session::flash("usenameSuccess", "Supplier added sucessfully.");
            Session::flash("msg", "Supplier added sucessfully.");
            $dataEmail = ['password' => $password, 'firstname' => Input::get('firstname')];
            Helper::sendMyEmail(Config('constants.adminEmails') . '/supplier_creation', $dataEmail, 'Supplier created -' . Input::get('firstname'), 'support@infiniteit.biz', 'JaldiBolo', Input::get('email'), Input::get('firstname'));
            $viewname = Config('constants.adminSuppliersView') . '.index';
            $data = ['status' => '1', 'user' => $user, 'msg' => 'Supplier added sucessfully.'];
            return Helper::returnView($viewname, $data, $url = 'admin.suppliers.view');
        } else {
            Session::flash("usenameError", "Supplier already exist.");
            Session::flash("message", "Supplier already exist.");
            $viewname = Config('constants.adminSuppliersView') . '.index';
            $data = ['status' => '0', 'msg' => 'Supplier already exist.'];
            return Helper::returnView($viewname, $data, $url = 'admin.suppliers.view');
        }
    }

    public function edit()
    {
        $user = User::find(Input::get('id'));
        $roles = Role::where('name', 'LIKE', '%supplier%')->get(['id', 'display_name'])->toArray();
        // dd($user);
        $roles_name = ["" => "Please Select"];
        foreach ($roles as $role) {
            $roles_name[$role['id']] = $role['display_name'];
        }
        $user->password_crpt = base64_decode($user->password_crpt);
        $action = "admin.suppliers.update";
        $viewname = Config('constants.adminSuppliersView') . '.addEdit';
        $data = ['user' => $user, 'action' => $action, 'roles_name' => $roles_name];
        return Helper::returnView($viewname, $data);
    }

     public function update()
    {
        $user = User::find(Input::get('id'));

        $user->firstname = Input::get('firstname');
        if (Input::get('password_crpt')) {
            
            $password = Hash::make(Input::get('password_crpt'));
            if ($password != $user->password) {
                $user->password = $password;
                $user->password_crpt = base64_encode(Input::get('password_crpt'));
            }

        }
        $user->lastname = Input::get('lastname');
        $user->telephone = Input::get('telephone');
        $user->email = Input::get('email');
        $user->status = Input::get('status');
        $user->country_code = Input::get('country_code');
        $user->store_id = Helper::getSettings()['store_id'];
        $user->user_type = 5;
        $user->save();

        if (!empty(Input::get('roles'))) {
            $user->roles()->sync([Input::get('roles')]);
        }
        Session::flash("msg", "Supplier updated sucessfully.");
        $viewname = Config('constants.adminSuppliersView') . '.index';
        $data = ['status' => '1', 'msg' => 'Successfully updated'];
        return Helper::returnView($viewname, $data, $url = 'admin.suppliers.view');
    }

    public function chk_existing_username()
    {
        $getname = Input::get('username');
        // dd($getname);
        $chk = User::where("user_name", "=", $getname)->first();

        if (!empty($chk)) {
            $data = ['status' => '0', 'msg' => 'invalid'];
        } else {

            $data = ['status' => '1', 'msg' => 'valid'];
        }
    }

    public function delete()
    {
        // echo Input::get('id')."===".Session::get('loggedinAdminId'); die;
        if (Input::get('id') != Session::get('loggedinAdminId')) {
            $user = User::find(Input::get('id'));
            $user->roles();
            $role = DB::table('role_user')->where("user_id", $user->id)->get();
            if (count($role) > 0) {
                $user->delete();
                Session::flash("message", "Supplier deleted sucessfully.");
                $data = ['status' => '1', 'msg' => 'Supplier deleted sucessfully.'];
            } else {
                Session::flash("message", "Sorry, You can not deleted this user .");
                $data = ['status' => '0', 'msg' => 'Sorry, You can not deleted this user.'];
            }

        } else {
            Session::flash("message", "Sorry, You can not deleted this user.");
            $data = ['status' => '0', 'msg' => 'Sorry, You can not deleted this user.'];
        }

        //return redirect()->back()->with("message", "User deleted successfully.");
        $viewname = Config('constants.adminSuppliersView') . '.index';

        return Helper::returnView($viewname, $data, $url = 'admin.suppliers.view');
    }

    public function changeStatus()
    {
        $getstatus = User::find(Input::get('id'));
        $viewname = '';
        if ($getstatus->status == 1) {
            $status = 0;
            $msg = "Supplier disabled successfully.";
            $getstatus->status = $status;
            $getstatus->update();
            Session::flash("message", "Supplier disabled successfully.");
            // return redirect()->back()->with('message', $msg);
            $data = ['status' => '0', 'msg' => 'Supplier disabled successfully.'];
        } else if ($getstatus->status == 0) {
            $status = 1;
            $msg = "Supplier enabled successfully.";
            $getstatus->status = $status;
            $getstatus->update();
            Session::flash("msg", "Supplier enabled successfully.");
            // return redirect()->back()->with('msg', $msg);
            $data = ['status' => '1', 'msg' => 'Supplier enabled successfully.'];
        }
        return Helper::returnView($viewname, $data, $url = 'admin.suppliers.view');

    }
    public function export()
    {
        $user = User::where('user_type', 5)->where('status', 1)->get();
        $user_data = [];
        array_push($user_data, ['First Name', 'Last Name', 'Mobile', 'Email']);
        foreach ($user as $u) {
            $details = [$u->firstname, $u->lastname, $u->telephone, $u->email];
            array_push($user_data, $details);
        }
        return Helper::getCsv($user_data, 'supplier.csv', ',');
    }

}
