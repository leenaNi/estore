<?php

namespace App\Http\Controllers\Admin;

use Route;
use Input;
use App\Models\User;
use App\Models\Role;
use App\Models\Product;
use App\Models\DownlodableProd;
use App\Models\GeneralSetting;
use App\Models\EmailTemplate;
use Auth;
use Hash;
use App\Library\Helper;
use App\Models\Permission;
use App\Http\Controllers\Controller;
use Session;
use Crypt;
use Config;

class LoginController extends Controller {

    public function index() {


        if (Session::get('loggedinAdminId')) {


            return redirect()->route('admin.dashboard');
        } else {
            return view(Config('constants.adminView') . '.login');
        }
    }

    public function unauthorized() {
        return view(Config('constants.adminView') . '.unauthorized');
    }

    public function chk_admin_user() {
        $input = Input::get("email");

        $login_type = filter_var($input, FILTER_VALIDATE_EMAIL) ? 'email' : 'telephone';
        $userDetails = User::where($login_type, "=", Input::get("email"))->whereIn('user_type', [1, 3])->where("status", 1)->first();
        $userData = [$login_type => Input::get('email'),
            'password' => Input::get('password'), 'status' => 1];
        if (!empty($userDetails)) {
            if (Auth::attempt($userData, true)) {
                $user = User::find($userDetails->id);
                Session::put('loggedinAdminId', $userDetails->id);
                Session::put('profile', $userDetails->profile);
                Session::put('loggedin_user_id', $user->id);
                Session::put('login_user_type', $user->user_type);
               // $roles = $user->roles()->first();
               // $r = Role::find($roles->id);
               // $per = $r->perms()->get()->toArray();
                if (Auth::user()->user_type == 3) {
                    return redirect()->route('admin.vendors.dashboard');
                }
                return redirect()->route('admin.home.view');
            } else {
                Session::flash('invalidUser', 'Invalid Username or Password');
                return redirect()->route('adminLogin');
            }
        } else {
            Session::flash('invalidUser', 'Invalid Username or Password');
            return redirect()->route('adminLogin');
        }
    }
    
  public function chk_fb_admin_user() {
          $FbUser=Input::get('userData');
       $userEmail=$FbUser['email'];
         
          $appId=$FbUser['id'];
        // var_dump($userEmail); 
       // $userDetails = User::where('email', $userEmail)->first();
        //return $userDetails;
       // $login_type = filter_var($input, FILTER_VALIDATE_EMAIL) ? 'email' : 'telephone';
        $userDetails = User::where('email', $userEmail)->where("provider_id",$appId)->whereIn('user_type', [1, 3])->where("status", 1)->first();
      //  return $userDetails;
//         $userData = [$login_type => Input::get('email'),
//            'password' => Input::get('password'), 'status' => 1];
        if (!empty($userDetails)) {
            Auth::login($userDetails);
            
            if (Auth::check()) {
                $user = User::with('roles')->find($userDetails->id);
                Session::put('loggedinAdminId', $userDetails->id);
                Session::put('profile', $userDetails->profile);
                Session::put('loggedin_user_id', $user->id);
                Session::put('login_user_type', $user->user_type);
                $roles = $user->roles()->first();
                $r = Role::find($roles->id);
                $per = $r->perms()->get()->toArray();
                if (Auth::user()->user_type == 3) {
                    return $data=["status"=>1,"route"=>route('admin.vendors.dashboard')];
                }
                 return $data=["status"=>1,"route"=>route('admin.home.view')];
               // return redirect()->route('admin.home.view');
            } else {
              //  Session::flash('invalidUser', 'Invalid Username or Password');
                //return redirect()->route('adminLogin');
                 return $data=["status"=>0,"route"=>route('adminLogin'),"msg"=>"Invalid Username or Password asa"];
            }
        } else {
            //Session::flash('invalidUser', 'Invalid Username or Password');
             return $data=["status"=>0,"route"=>route('adminLogin'),"msg"=>"Invalid Username or Password"];
           // return redirect()->route('adminLogin');
        }
    }
    public function admin_logout() {
        Auth::logout();
       
        Session::flush();
        return redirect()->route('adminLogin');
    }

    public function admin_edit_profile() {
        $id = Input::get("id");
        $user = User::find($id);
        $action = route('adminSaveProfile');
        $public_path =Config('constants.adminImgUploadPath')."/"; 
        return view(Config('constants.adminView') . '.adminEditProfile', compact('user', 'action', 'public_path'));
    }

    public function admin_save_profile() {
        // dd(Input::get());
        $user = User::find(Input::get('id'));
        $user->firstname = Input::get("firstname");
        $user->lastname = Input::get("lastname");
        $user->email = Input::get("email_id");
        if (!empty(Input::get("telephone"))) {
            $user->telephone = Input::get("telephone");
        }

        if (!empty(Input::get("password"))) {
            $check = (Hash::check(Input::get('old_password'), $user->password));
            if ($check == true) {
                if (Input::get("password") == Input::get("confirmpwd")) {
                    $user->password = Hash::make(Input::get('password'));
                }
            }else{
                 Session::flash('invaliOldPass', 'Invalid Username or Password');
                return redirect()->back();
            }
        }
        if (Input::hasFile('profile')) {
            $destinationPath =Config('constants.adminImgUploadPath')."/"; 
            $fileName = date("dmYHis") . "." . Input::File('profile')->getClientOriginalExtension();
            $upload_success = Input::File('profile')->move($destinationPath, $fileName);
            $user->profile = $fileName;
        }
        $user->save();
        $viewname = '';
        $data = 'Your profile updated successfully.';
        return Helper::returnView($viewname, $data, $url = 'admin.dashboard');
    }

    public function adminCheckCurPassowrd(){
   $user =      User::find(Session::get('loggedinAdminId'));
     $check = (Hash::check(Input::get('thispass'), $user->password));
     
if ($check == true) {
    return 0;
}else{
     return 1;
}
   
    }
    
    public function forgotPassword() {
        return view(Config('constants.adminView') . '.forgot_password');
    }

    public function chkForgotPasswordEmail() {
        $emailStatus = GeneralSetting::where('url_key', 'email-facility')->first()->status;

        $useremail = Input::get('useremail');

        $login_type = filter_var($useremail, FILTER_VALIDATE_EMAIL) ? 'email' : 'telephone';

        $storeId = Input::get('storeid'); // need to use DB table
        //$request->input("useremail");
        // echo "login type ".$login_type ." " .$useremail;
        $chkemail = User::where($login_type, "=", $useremail)->where('user_type', 1)->first();
        //  return $chkemail;
        if (!empty($chkemail)) {
            $linktosend = route('adminResetPassword') . "/" . Crypt::encrypt($useremail);
            //$user = User::where("email", "=", $useremail)->first();
            if ($emailStatus == 1 && $chkemail->email != '') {
                $email_template = EmailTemplate::where('id', 3)->select('content')->get()->toArray()[0]['content'];

                $name = ucfirst($chkemail->firstname);
                $replace = ["[firstname]", "[newlink]"];
                $data = ['name' => $name, 'newlink' => $linktosend];
                $replacewith = [ucfirst($chkemail->firstname), $linktosend];
                $email_templates = str_replace($replace, $replacewith, $email_template);
                $data1 = ['email_template' => $email_templates];
                Helper::sendMyEmail(Config('constants.frontviewEmailTemplatesPath') . 'resetForgotPwdEmail', $data1, 'Forgot password', Config::get('mail.from.address'), Config::get('mail.from.name'), $chkemail->email, $chkemail->firstname . " " . $chkemail->firstname);
            }
            if ($chkemail->telephone) {
                $msgOrderSucc = "Click on the link to reset your password. " . $linktosend . ". Contact 1800 3000 2020 for real time support. Happy Learning! Team Cartini";
                Helper::sendsms($chkemail->telephone, $msgOrderSucc);
            }
            return $data = ['status' => 'success', 'msg' => 'A Link to reset your password has been sent. Please check your Email/Sms.'];
        } else {
            return $data = ['status' => 'error', 'msg' => 'Sorry, your email is not registered with us!'];
        }
    }

    public function adminResetNewPassword($link) {
        $data = ['link' => $link];
        $viewname = Config('constants.adminView') . '.reset_forgot_pwd';
        return Helper::returnView($viewname, $data);
    }

    public function adminSaveResetPwd() {
        $emailStatus = GeneralSetting::where('url_key', 'email-facility')->first()->status;
        $useremail = Crypt::decrypt(Input::get('link'));
        $user = User::where("email", "=", $useremail)->first();
        $upPassword = User::find($user->id);
        $upPassword->password = Hash::make(Input::get('confirmpwd'));
        $upPassword->update();
        if ($emailStatus == 1) {
            $data = ['name' => $user->firstname . ' ' . $user->laststname, 'email' => $useremail];
            $filepath = Config('constants.frontviewEmailTemplatesPath') . '.forgotPassEmail';
            Helper::sendMyEmail($filepath, $data, 'Your password changed!', Config::get('mail.from.address'), Config::get('mail.from.name'), $useremail, $user->first_name);
            session()->flash('pwdResetMsg', 'Password reset successfully!');
        }
        return redirect()->route('adminLogin');
    }

}
