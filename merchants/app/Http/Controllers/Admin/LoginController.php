<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Library\Helper;
use App\Models\EmailTemplate;
use App\Models\GeneralSetting;
use App\Models\Merchants;
use App\Models\Role;
use App\Models\Store;
use App\Models\User;
use App\Models\Vendor;
use Auth;
use Config;
use Crypt;
use DB;
use Hash;
use Input;
use Route;
use Session;

class LoginController extends Controller
{

    public function index()
    {
        if (Session::get('loggedinAdminId')) {
            return redirect()->route('admin.dashboard');
        } else {
            return view(Config('constants.adminView') . '.login');
        }

    }

    public function unauthorized()
    {
        return view(Config('constants.adminView') . '.unauthorized');
    }

    public function checkExistingphone()
    {

        $chkEmail = User::where("telephone", Input::get('phone_no'))->first();

        //if (count($chkEmail) > 0){
        if (!empty($chkEmail)) {
            $country = '+' . $chkEmail->country_code;
            $mobile = Input::get("phone_no");
            $otp = rand(1000, 9999);
            Session::put('otp', $otp);
            if ($mobile) {
                $msgOrderSucc = "Your one time password is. " . $otp . " Team eStorifi";
                // Helper::sendsms($mobile, $msgOrderSucc, $country);
            }
            $data = ["otp" => $otp, "status" => "success", "msg" => "OTP Successfully send on your mobileNumber"];
            return $data;
        } else {
            $data = ["status" => "fail", "msg" => "Invalid mobile Number"];
            return $data;
        }
    }

    public function checkOtp()
    {
        $inputOtp = Input::get("otp");
        $otp = Session::get('otp');
        if ($inputOtp == $otp) {
            return 1;
        } else {
            return 2;
        }
    }

    public function chk_admin_user()
    {   
        //echo "inside fun";
        // DB::enableQueryLog(); // Enable query log
        $input = Input::get("phone");
        $login_type = filter_var($input, FILTER_VALIDATE_EMAIL) ? 'email' : 'telephone';
        $userDetails = User::where('telephone', Input::get("phone"))->whereIn('user_type', [1, 3, 5])->where('store_id', Helper::getSettings()['store_id'])->where("status", 1)->first();
        $userData = [$login_type => Input::get('phone'), 'status' => 1, 'store_id' => Helper::getSettings()['store_id']];
        // $userData = [$login_type => Input::get('phone'),
        //     'password' => Input::get('password'), 'status' => 1, 'store_id' => Helper::getSettings()['store_id']];

        //dd(DB::getQueryLog()); // Show results of log
        //echo "store id::".Helper::getSettings()['store_id'];
        //echo "<pre> user details::";
        //print_r($userDetails);
        if (!empty($userDetails)) {
            //if (Auth::login($userData, true)) {
           
            $user = User::with('roles')->find($userDetails->id);
            //echo "<pre> users::";
            //print_r($user);
            $store = Store::find($user->store_id);
            Session::put('loggedinAdminId', $userDetails->id);
            Session::put('profile', $userDetails->profile);
            Session::put('loggedin_user_id', $user->id);
            Session::put('login_user_type', $user->user_type);
            Session::put('merchantid', $store->merchant_id);
            $roles = $user->roles()->first();
            $r = Role::find($roles->id);
            $per = $r->perms()->get()->toArray();
            
            $approvalId = Session::get('approval_id');
            //echo "approval id::".$approvalId;
            if ($approvalId > 0) {
                return redirect()->route('admin.vendors.accept');
            } else {
                // dd($per[0]);
                if ($r->name != 'admin') {
                    $curRoute = @$per[0]['name'];
                    return redirect()->route($curRoute);
                } else {
                    if(env('IS_INDIVIDUAL_STORE')) {
                        return redirect()->route('admin.dashboard');
                    } else {
                        //return redirect()->route('admin.home.view');
                        return redirect()->route('admin.dashboard');
                    }
                    //return redirect()->route('admin.home.view');
                }
            }

            //if (Auth::user()->user_type == 3) {
            //return redirect()->route('admin.home.view');
            //}
            //return redirect()->route('admin.home.view');
            // } else {
            //     Session::flash('invalidUser', 'Invalid Username or Password');
            //     return redirect()->route('adminLogin');
            // }
        } else {
            // dd('2 Unauthorized user');
            Session::flash('invalidUser', 'Invalid Username or Password');
            return redirect()->route('adminLogin');
        }
    }

    public function chk_fb_admin_user()
    {
        $FbUser = Input::get('userData');
        $userEmail = $FbUser['email'];
        $appId = $FbUser['id'];
        // var_dump($userEmail);
        // $userDetails = User::where('email', $userEmail)->first();
        //return $userDetails;
        // $login_type = filter_var($input, FILTER_VALIDATE_EMAIL) ? 'email' : 'telephone';
        $userDetails = User::where('email', $userEmail)->where("provider_id", $appId)->whereIn('user_type', [1, 3])->where("status", 1)->first();
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
                    return $data = ["status" => 1, "route" => route('admin.vendors.dashboard')];
                }
                return $data = ["status" => 1, "route" => route('admin.home.view')];
                // return redirect()->route('admin.home.view');
            } else {
                //  Session::flash('invalidUser', 'Invalid Username or Password');
                //return redirect()->route('adminLogin');
                return $data = ["status" => 0, "route" => route('adminLogin'), "msg" => "Invalid Username or Password asa"];
            }
        } else {
            //Session::flash('invalidUser', 'Invalid Username or Password');
            return $data = ["status" => 0, "route" => route('adminLogin'), "msg" => "Invalid Username or Password"];
            // return redirect()->route('adminLogin');
        }
    }
    public function admin_logout()
    {
        Auth::logout();
        Session::flush();
        return redirect()->route('adminLogin');
    }

    public function admin_edit_profile()
    {
        $userDetailsId = Session::get('loggedinAdminId');
        $userDetailsProfile = Session::get('profile');
        $userId = Session::get('loggedin_user_id');
        $userType = Session::get('login_user_type');
        $merchantId = Session::get('merchantid');

        /*echo "user details::".$userDetailsId;
        echo "<br> user details profile::".$userDetailsProfile;
        echo "<br> user id::".$userId;
        echo "<br> user type::".$userType;
        echo "<br> merchant id::".$merchantId;
        exit;*/
        //dd("admin_edit_profile");
        $id = Input::get("id");
        //echo "id::".$id;
        $user = User::find($id);
        $action = route('adminSaveProfile');
        $distributorIdData = [];
        //dd(Auth::User());
        //if(Auth::User()->user_type == 3)
        if ($userType == 3) {
            $userType = 'distributor';
            $storeId = $user->store_id;
            $distributorIdfromStore = Store::where('id', $storeId)->pluck('merchant_id');
            $distributorId = $distributorIdfromStore[0];
            $distributorIdData = Vendor::find($distributorId);
        } else if ($userType == 1) {
            $userType = 'merchant';
            $storeId = $user->store_id;
            $merchantIdfromStore = Store::where('id', $storeId)->pluck('merchant_id');
            $merchantId = $merchantIdfromStore[0];
            //echo "merchant id::".$merchantId;
            $distributorIdData = Merchants::find($merchantId);
        }

        $public_path = Config('constants.adminImgUploadPath') . "/";
        //echo Config('constants.adminView');exit;
        return view(Config('constants.adminView') . '.adminEditProfile', compact('user', 'action', 'public_path', 'distributorIdData', 'userType'));
    }

    public function admin_save_profile()
    {
        //dd(Input::get());
        $user = User::find(Input::get('id'));
        $user->firstname = Input::get("firstname");
        $user->lastname = Input::get("lastname");
        $user->email = Input::get("email_id");
        if (!empty(Input::get("telephone"))) {
            $user->telephone = Input::get("telephone");
        }

        /*if (!empty(Input::get("password"))) {
        $check = (Hash::check(Input::get('old_password'), $user->password));
        if ($check == true) {
        if (Input::get("password") == Input::get("confirmpwd")) {
        $user->password = Hash::make(Input::get('password'));
        }
        } else {
        Session::flash('invaliOldPass', 'Invalid Username or Password');
        return redirect()->back();
        }
        }
        if (Input::hasFile('profile')) {
        $destinationPath = Config('constants.adminImgUploadPath') . "/";
        $fileName = date("dmYHis") . "." . Input::File('profile')->getClientOriginalExtension();
        $upload_success = Input::File('profile')->move($destinationPath, $fileName);
        $user->profile = $fileName;
        }*/
        $user->save();

        $userDetailsId = Session::get('loggedinAdminId');
        $userDetailsProfile = Session::get('profile');
        $userId = Session::get('loggedin_user_id');
        $userType = Session::get('login_user_type');
        $merchantId = Session::get('merchantid');
        $distributorId = Input::get("hdnDistributorId");

        //if(Auth::User()->user_type == 3)
        if ($userType == 3) //for distributor
        {
            if (!empty($distributorId) && $distributorId > 0) {
                $distributorObj = Vendor::find($distributorId);
                $registerDetails = json_decode($distributorObj->register_details, true);

                $distributorObj->email = Input::get("email_id");
                $distributorObj->firstname = Input::get("firstname");
                $distributorObj->lastname = Input::get("lastname");
                $distributorObj->phone_no = Input::get("telephone");
                $registerDetails['phone'] = Input::get("telephone");
                $distributorObj->register_details = json_encode($registerDetails);
                //$distributorObj->register_details = ['phone' => Input::get("telephone")];
                $distributorObj->save();
            }
        } else if ($userType == 1) //for merchants
        {
            if (!empty($distributorId) && $distributorId > 0) {
                $merchantObj = Merchants::find($distributorId);
                $registerDetails = json_decode($merchantObj->register_details, true);
                $merchantObj->email = Input::get("email_id");
                $merchantObj->firstname = Input::get("firstname");
                $merchantObj->lastname = Input::get("lastname");
                $merchantObj->phone = Input::get("telephone");
                $registerDetails['phone'] = Input::get("telephone");
                $merchantObj->register_details = json_encode($registerDetails);
                //$merchantObj->register_details->phone = Input::get("telephone");
                $merchantObj->save();
            }
        }

        $viewname = '';
        $data = 'Your profile updated successfully.';
        return Helper::returnView($viewname, $data, $url = 'admin.dashboard');
    }

    public function adminCheckCurMobileNumber()
    {
        $userId = Session::get('loggedin_user_id');
        $userType = Session::get('login_user_type');
        //$hdnUserId = Input::get('hdnUserId');
        $loggedInMerchantId = Input::get('hdnLoggedInMerchantId');
        $txtMobileNumber = Input::get('txtMobileNumber');
        //check mobile number already exist in user table or not
        $checkMobileNumber = DB::table('users as u')
            ->where("u.telephone", $txtMobileNumber)
            ->where("u.id", '!=', $userId)
            ->get();
        if (count($checkMobileNumber) > 0) {
            return 1; //Mobile number exist
        } else {
            return 0; //mobile number not exist
        }

    }

    public function adminCheckCurPassowrd()
    {
        $user = User::find(Session::get('loggedinAdminId'));
        $check = (Hash::check(Input::get('thispass'), $user->password));
        if ($check == true) {
            return 0;
        } else {
            return 1;
        }

    }

    public function forgotPassword()
    {
        return view(Config('constants.adminView') . '.forgot_password');
    }

    public function chkForgotPasswordEmail()
    {
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

    public function adminResetNewPassword($link)
    {
        $data = ['link' => $link];
        $viewname = Config('constants.adminView') . '.reset_forgot_pwd';
        return Helper::returnView($viewname, $data);
    }

    public function adminSaveResetPwd()
    {
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
