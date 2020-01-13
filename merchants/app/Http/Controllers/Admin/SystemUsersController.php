<?php

namespace App\Http\Controllers\Admin;

use Input;
use App\Models\Role;
use App\Models\User;
use Hash;
use Auth;
use Session;
use App\Library\Helper;
use App\Http\Controllers\Controller;
use DB;

class SystemUsersController extends Controller {

    public function index() {
//dd(base64_decode("YXNkZjEyMzQ="));
        $search = !empty(Input::get("empSearch")) ? Input::get("empSearch") : '';
        $system_users = User::with('roles')->where('user_type', '1')->where("store_id",Session::get('store_id'))->whereIn('status', [1, 0]);

        $roles = Role::get(['id', 'name'])->toArray();
        $search_fields = ['firstname', 'lastname', 'email', 'telephone'];
        if (!empty(Input::get('empSearch'))) {
            $system_users = $system_users->where(function($query) use($search_fields, $search) {
                foreach ($search_fields as $field) {
                    $query->orWhere($field, "like", "%$search%");
                }
            });
        }

        if (!empty(Input::get('empSearch'))) {
            $system_users = $system_users->get();
            $userCount=$system_users->count();
        } else {
            $system_users = $system_users->paginate(Config('constants.paginateNo'));
            $userCount=$system_users->total();
        }

        $viewname = Config('constants.adminSystemUsersView') . '.index';
        $data = ['system_users' => $system_users, 'roles' => $roles,'userCount'=>$userCount];
        return Helper::returnView($viewname, $data);
    }

    public function add() {
        $user = new User();
        $action = "admin.systemusers.save";
        $roles = Role::get(['id', 'display_name'])->toArray();
        $roles_name = ["" => "Please Select"];
        foreach ($roles as $role) {
            $roles_name[$role['id']] = $role['display_name'];
        }
        // return view(Config('constants.adminSystemUsersView') . '.addEdit', compact('user', 'action', 'roles_name'));
        $viewname = Config('constants.adminSystemUsersView') . '.addEdit';
        $data = ['user' => $user, 'action' => $action, 'roles_name' => $roles_name];
        return Helper::returnView($viewname, $data);
    }

    public function save() {

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
            $user->password_crpt =base64_encode($password);
            $user->user_type = 1;
            $user->store_id = Session::get('store_id');
            $user->save();
            // print_r($user); die;
            if (!empty(Input::get('roles'))) {
                $user->roles()->sync([Input::get('roles')]);
            }
            // return redirect()->route('admin.systemusers.view');
            
            Session::flash("usenameSuccess", "System user added sucessfully.");
            Session::flash("msg", "System user added sucessfully.");
            $dataEmail = ['password' => $password, 'firstname' => Input::get('firstname')];
            Helper::sendMyEmail(Config('constants.adminEmails') . '/employee_creation', $dataEmail, 'Employee created -' . Input::get('firstname'), 'support@infiniteit.biz', 'Cartini', Input::get('email'), Input::get('firstname'));
            $viewname = Config('constants.adminSystemUsersView') . '.index';
            $data = ['status' => '1', 'user' => $user, 'msg' => 'System user added sucessfully.'];
            return Helper::returnView($viewname, $data, $url = 'admin.systemusers.view');
        } else {
            Session::flash("usenameError", "System user already exist.");
              Session::flash("message", "System user already exist.");
            $viewname = Config('constants.adminSystemUsersView') . '.index';
            $data = ['status' => '0', 'msg' => 'System user already exist.'];
            return Helper::returnView($viewname, $data, $url = 'admin.systemusers.view');
        }
    }

    public function update() {
        
        $user = User::find(Input::get('id'));
      
        $user->firstname = Input::get('firstname');
        if (Input::get('password_crpt')) {
        //    dd(Input::get('password'));
            
        $password = Hash::make(Input::get('password_crpt'));
        if($password!=$user->password){
             $user->password =$password;
             $user->password_crpt =base64_encode(Input::get('password_crpt'));
        } 
       
       }
        $user->lastname = Input::get('lastname');
        $user->telephone = Input::get('telephone');
        $user->email = Input::get('email');
        $user->status = Input::get('status');
        $user->country_code = Input::get('country_code');

        $user->user_type = 1;
     
        $user->save();
//dd(Input::all());
        if (!empty(Input::get('roles'))) {
            $user->roles()->sync([Input::get('roles')]);
        }

        //return redirect()->route('admin.systemusers.view');
        Session::flash("msg", "System user updated sucessfully.");
        $viewname = Config('constants.adminSystemUsersView') . '.index';
        $data = ['status' => '1', 'msg' => 'Successfully updated'];
        return Helper::returnView($viewname, $data, $url = 'admin.systemusers.view');
    }

    public function edit() {
        $user = User::find(Input::get('id'));
       
        $user->password_crpt=base64_decode($user->password_crpt);
        $action = "admin.systemusers.update";
        $roles = Role::get(['id', 'display_name'])->toArray();
        // dd($user);
        $roles_name = ["" => "Please Select"];
        foreach ($roles as $role) {
            $roles_name[$role['id']] = $role['display_name'];
        }
        // return view(Config('constants.adminSystemUsersView') . '.addEdit', compact('user', 'action', 'roles_name'));
        $viewname = Config('constants.adminSystemUsersView') . '.addEdit';
        $data = ['user' => $user, 'action' => $action, 'roles_name' => $roles_name];
        return Helper::returnView($viewname, $data);
    }

    public function chk_existing_username() {
        $getname = Input::get('username');
        // dd($getname);
        $chk = User::where("user_name", "=", $getname)->first();

        if (!empty($chk)) {
            $data = ['status' => '0', 'msg' => 'invalid'];
        } else {

            $data = ['status' => '1', 'msg' => 'valid'];
        }
    }

    public function delete() {
       // echo Input::get('id')."===".Session::get('loggedinAdminId'); die;
        if(Input::get('id') != Session::get('loggedinAdminId')){
          $user = User::find(Input::get('id'));
          $user->roles();
               $role=DB::table('role_user')->where("user_id",$user->id)->get();
               if(count($role) >0 ){
                   $user->delete();
                 Session::flash("message", "System user deleted sucessfully.");
                 $data = ['status' => '1', 'msg' => 'System user deleted sucessfully.'];
               }else{
                   Session::flash("message", "Sorry, You can not deleted this user ."); 
                 $data = ['status' => '0', 'msg' => 'Sorry, You can not deleted this user.']; 
               }
               
           
        
        }else{
           Session::flash("message", "Sorry, You can not deleted this user."); 
           $data = ['status' => '0', 'msg' => 'Sorry, You can not deleted this user.'];
        }
        
        //return redirect()->back()->with("message", "User deleted successfully.");
        $viewname = Config('constants.adminSystemUsersView') . '.index';
        
        return Helper::returnView($viewname, $data, $url = 'admin.systemusers.view');
    }

    public function changeStatus() {
        $getstatus = User::find(Input::get('id'));
        $viewname = '';
        if ($getstatus->status == 1) {
            $status = 0;
            $msg = "System user disabled successfully.";
            $getstatus->status = $status;
            $getstatus->update();
            Session::flash("message", "System user disabled successfully.");
            // return redirect()->back()->with('message', $msg);
            $data = ['status' => '0', 'msg' => 'System user disabled successfully.'];
        } else if ($getstatus->status == 0) {
            $status = 1;
            $msg = "System user enabled successfully.";
            $getstatus->status = $status;
            $getstatus->update();
            Session::flash("msg", "System user enabled successfully.");
            // return redirect()->back()->with('msg', $msg);
            $data = ['status' => '1', 'msg' => 'System user  enabled successfully.'];
        }
        return Helper::returnView($viewname, $data, $url = 'admin.systemusers.view');

    }
    public function export() {
        $user = User::where('user_type', 1)->where('status', 1)->get();
        $user_data = [];
        array_push($user_data, ['First Name', 'Last Name', 'Mobile', 'Email']);
        foreach ($user as $u) {
            $details = [$u->firstname, $u->lastname, $u->telephone, $u->email];
            array_push($user_data, $details);
        }
        return Helper::getCsv($user_data, 'systemUser.csv', ',');
    }

}
