<?php

namespace App\Http\Controllers\Frontend;

use Socialite;
use Route;
use Input;
use App\Models\User;
use App\Models\EmailTemplate;
use App\Models\GeneralSetting;
use Auth;
use App\Http\Controllers\Controller;
use Session;
use App\Library\Helper;
use Cart;
use Hash;
use Mail;
use Config;
use Crypt;

class LoginController extends Controller {

    public function checkUser() {
        $result = [];

        $input = Input::get('username');
        $login_type = filter_var($input, FILTER_VALIDATE_EMAIL) ? 'email' : 'telephone';
        $userdata = array(
            $login_type => Input::get('username'),
            'password' => Input::get('password')
        );
        $user = User::where($login_type, '=', Input::get('username'))->where("status", "!=", 0)->first();

        $data = ['users' => $user];
        if (isset($user)) {

            if (Auth::attempt($userdata, true)) {
                Helper::postLogin($user->id);

                if (Session::get('returnURL')) {
                    // return redirect()->to(Session::get('returnURL'));
                } else {
                    // return "myaccount";
                    //redirect()->route('myProfile');
                    $result = ['status' => 'success', 'msg' => 'Successfully logged in', 'data' => $user, 'url' => 'home'];
                }
            } else {
                // Session::flash('loginError', 'Invalid Email id or Password');
                // redirect()->back();
                $result = ['status' => 'error', 'msg' => 'Invalid Email id or Password'];
                // return 1;
            }
        } else {
            //  Session::flash('loginError', 'Sorry, no match found');
            // redirect()->back();
            $result = ['status' => 'nomatch', 'msg' => 'Sorry, no match found'];
            // return 0; 
        //
        }
        //print_r($result);
        return $result;
    }

    public function checkFbUser() {
        $result = [];

        $FbUser = Input::get('userData');
        $email = $FbUser['email'];
        $firstname = $FbUser['first_name'];
        $lastname = $FbUser['last_name'];
        $appId = $FbUser['id'];
        $login_type = filter_var($email, FILTER_VALIDATE_EMAIL) ? 'email' : 'telephone';
        $user = User::where($login_type, '=', $email)->where("status", "!=", 0)->where('provider_id', $appId)->first();

        $data = ['users' => $user];
        if (isset($user)) {
            Auth::login($user, true);
            if (Auth::check() > 0) {
                Helper::postLogin($user->id);
            $url=route("myProfile");
                $result = ['status' => '1', 'msg' => 'Successfully logged in', 'data' => $user,'url'=>$url];
            } else {

                $result = ['status' => '0', 'msg' => 'Invalid Email id or Password'];
            }
        } else {
             $url=route("myProfile");
            $users = new User();
            $users->firstname = $firstname;
            $users->lastname = $lastname;
            $users->email = $email;
            $users->provider_id = $appId;
            $users->save();
            Auth::login($users, true);
            if (Auth::check() > 0) {
                Helper::postLogin($users->id);
                $result = ['status' => '1', 'msg' => 'Successfully logged in', 'data' => $users,'url'=>$url];
            }
        }
        //print_r($result);
        return $result;
    }

    public function dashboard() {
        $data = [];
        $viewname = Config('constants.frontendView') . '.dashboard';
        return view($viewname, $data);
    }

    public function login() {

        $data = [];
        if (Session::get('loggedin_user_id')) {
            return redirect()->route('home');
        } else {
            $viewname = Config('constants.frontendView') . '.login-register';
            return view($viewname, $data);
        }
    }

    public function logout() {
        Auth::logout();
        Session::flush();
        Cart::instance("shopping")->destroy();
        return redirect()->route('home');
    }

    public function userRegister() {
        $data = [];
        if (Session::get('loggedin_user_id')) {
            return redirect()->route('home');
        } else {
            $viewname = Config('constants.frontendView') . '.login-register';
            return view($viewname, $data);
        }
    }

    public function checkExistingUser() {
        $chkEmail = User:: where("email", "=", Input::get("email"))->get()->first();
        if (empty($chkEmail)) {
            return $data = ['status' => 'success', 'msg' => ''];
        } else {
            return $data = ['status' => 'fail', 'msg' => 'Email id already exist'];
        }
    }

    public function checkExistingMobileNo() {
        $chkEmail = User:: where("telephone", "=", Input::get("telephone"))->get()->first();
        if (empty($chkEmail)) {
            return $data = ['status' => 'success', 'msg' => ''];
        } else {
            return $data = ['status' => 'fail', 'msg' => 'Mobile no already exist'];
        }
    }

    public function saveRegister() {
        $emailStatus = GeneralSetting::where('url_key', 'email-facility')->first()->status;
        $referralStatus = GeneralSetting::where('url_key', 'referral')->first()->status;
        $chkEmail = User:: where("telephone", "=", Input::get("telephone"))->get()->first();
        if (empty($chkEmail)) {
            if (Input::get('password') == Input::get('cpassword')) {
                $user = new User();
                $user->email = Input::get('email');
                $user->password = Hash::make(Input::get('password'));
                $user->firstname = ucfirst(Input::get('firstname'));
                $user->lastname = ucfirst(Input::get('lastname'));
                $user->country_code =Input::get('country_code');
                $user->telephone = Input::get('telephone');
                $user->status = 1;
                if ($user->save()) {
                    Helper::newUserInfo($user->id);
                    $getUserInfo = User::find($user->id);
                    $referralCode = '';
                    if ($referralStatus == 1) {
                        $referralCode = "Your referral code is " . $getUserInfo->referal_code;
                    }
                    if ($emailStatus == 1 && $getUserInfo->email != '') {
                        
                        $logoPath = @asset(Config("constants.logoUploadImgPath"). 'logo.png');                   
                        $settings =Helper::getSettings();                      
                        //dd($settings);
                        $webUrl = $_SERVER['SERVER_NAME'];
                        $emailContent = EmailTemplate::where('id', 1)->select('content','subject')->get()->toArray();                        
                        $email_template = $emailContent[0]['content'];
                        $subject = $emailContent[0]['subject'];
                        
                    $replace = array("[firstName]", "[logoPath]","[web_url]","[primary_color]","[secondary_color]","[storeName]", "[referralCode]");
                    $replacewith = array($user->firstname, $logoPath,$webUrl,$settings['primary_color'],$settings['secondary_color'],$settings['storeName'], $referralCode);

                        $email_templates = str_replace($replace, $replacewith, $email_template);
                        $data1 = ['email_template' => $email_templates];
                        Helper::sendMyEmail(Config('constants.frontviewEmailTemplatesPath') . 'registerEmail', $data1, $subject, Config::get('mail.from.address'), Config::get('mail.from.name'), Input::get('email'), Input::get('firstname') . " " . Input::get('lastname'));
                    }
                    if ($getUserInfo->telephone) {
                        $msgOrderSucc = "Welcome to the " .Session::put('storeName'). " You are successfully registered with us. Happy Shopping!";
                        Helper::sendsms($getUserInfo->telephone, $msgOrderSucc,$getUserInfo->country_code);
                    }

                    // return redirect()->route('myProfile');
                    $viewname = Config('constants.frontendMyAccView') . '.my_orders'; //page name
                    $data = ['status' => 'success', 'msg' => 'Successfully registered', 'data' => $user];
                    return Helper::returnView($viewname, $data, $url = 'myProfile');
                }
            } else {
                Session::flash('error', 'Password and Confirm password does not match');
                $data = ['status' => 'error', 'msg' => 'Password and Confirm password does not match'];
                // return redirect()->back();
                $viewname = Config('constants.frontendMyAccView') . '.register'; //page name
                return Helper::returnView($viewname, $data, $url = 'userRegister');
            }
        } else {
            Session::flash('error', 'Account already exists.');
            $data = ['status' => 'error', 'msg' => 'Account already exists.'];
            $viewname = Config('constants.frontendMyAccView') . '.register'; //page name
            return Helper::returnView($viewname, $data, $url = 'userRegister');
        }
    }

    public function chkForgotPasswordEmail() {
        $emailStatus = GeneralSetting::where('url_key', 'email-facility')->first()->status;

        $useremail = Input::get('useremail');

        $login_type = filter_var($useremail, FILTER_VALIDATE_EMAIL) ? 'email' :'telephone';
      
       // $storeId = Input::get('storeid'); // need to use DB table
        //$request->input("useremail");
        // echo "login type ".$login_type ." " .$useremail;
        $chkemail = User::where($login_type, "=",$useremail)->first();
       // print($chkemail);
       //  return $chkemail;
        if (!empty($chkemail)) {
            $linktosend = route('resetNewPwd') . "/" . Crypt::encrypt($useremail);
            //$user = User::where("email", "=", $useremail)->first();
            if ($emailStatus == 1 && $chkemail->email != '') {
                $emailContent = EmailTemplate::where('id', 3)->select('content','subject')->get()->toArray();
                $email_template = $emailContent[0]['content'];
                $subject = $emailContent[0]['subject'];
//                $path = Config("constants.adminStorePath"). "/storeSetting.json";
//                $str = file_get_contents($path);
                $logoPath = @asset(Config("constants.logoUploadImgPath"). 'logo.png');
//                $settings = json_decode($str, true);
                $settings =Helper::getSettings(); 
                $webUrl = $_SERVER['SERVER_NAME'];

                
                
                $replace = array("[firstName]","[newlink]","[logoPath]","[web_url]","[primary_color]","[secondary_color]","[storeName]");
                $replacewith = array(ucfirst($chkemail->firstname), $linktosend,$logoPath,$webUrl,$settings['primary_color'],$settings['secondary_color'],$settings['storeName']);

                $email_templates = str_replace($replace, $replacewith, $email_template);
                
                $data1 = ['email_template' => $email_templates];
                Helper::sendMyEmail(Config('constants.frontviewEmailTemplatesPath') . 'resetForgotPwdEmail', $data1, $subject, Config::get('mail.from.address'), Config::get('mail.from.name'), $chkemail->email, $chkemail->firstname . " " . $chkemail->firstname);           
            }
            if ($chkemail->telephone) {
                $msgOrderSucc = "Click on the link to reset your password. " . $linktosend . ". Contact 1800 3000 2020 for real time support. Happy Learning! Team Cartini";
                Helper::sendsms($chkemail->telephone, $msgOrderSucc,$chkemail->country_code);
            }
            return $data = ['status' => 'success', 'msg' => 'A Link to reset your password has been sent. Please check your Email/Sms.'];
        } else {
            return $data = ['status' => 'error', 'msg' => 'Sorry, your email is not registered with us!'];
        }
    }

    public function changePassword() {
        
    }

    public function updateMyaccPassword() {
        $email = Input::get('email');
        // $user = User::where('email', '=', $email)->first();
        $password = Input::get('password');
        $conf_password = Input::get('conf_password');
        $old_password = Input::get('old_password');
        $user_details = User::where("email", "=", $email)->first();
        $check = (Hash::check(Input::get('old_password'), $user_details->password));
        if ($check == true) {
            if ((Input::get('password')) == Input::get('conf_password')) {
                $user = User::find($user_details->id);
                $user->password = Hash::make(Input::get('password'));
                $user->Update();

                // Session::flash('updateProfileSuccess', 'Password updated successfully');
                return $result = ['status' => 'success', 'msg' => 'Password updated successfully'];
            } else {

                // Session::flash('PasswordError', 'Password and Confirm Password does not match');
                return $result = ['status' => 'nomatch', 'msg' => 'Password and Confirm Password does not match'];
            }
        } else {


            // Session::flash('PasswordError', 'Incorrect Old Password');
            return $result = ['status' => 'error', 'msg' => 'Incorrect Old Password'];
        }
    }

    public function saveResetPwd() {
        $emailStatus = GeneralSetting::where('url_key', 'email-facility')->first()->status;
        $useremail = Crypt::decrypt(Input::get('link'));
        $login_type = filter_var($useremail, FILTER_VALIDATE_EMAIL) ? 'email' : 'telephone';
        $user = User::where($login_type, "=", $useremail)->first();
        $upPassword = User::find($user->id);
        $upPassword->password = Hash::make(Input::get('confirmpwd'));
        $upPassword->update();

        if ($emailStatus == 1 && $upPassword->email != '') {
                $emailContent = EmailTemplate::where('id', 14)->select('content','subject')->get()->toArray();
                $email_template = $emailContent[0]['content'];
                $subject = $emailContent[0]['subject'];
               // $path = Config("constants.adminStorePath"). "/storeSetting.json";
              //  $str = file_get_contents($path);
                $logoPath = @asset(Config("constants.logoUploadImgPath"). 'logo.png');
                 $settings =Helper::getSettings(); 
                $webUrl = $_SERVER['SERVER_NAME'];
               
                $replace = array("[firstName]","[logoPath]","[web_url]","[primary_color]","[secondary_color]","[storeName]","[email]");
            $replacewith = array(ucfirst($user->firstname),$logoPath,$webUrl,$settings['primary_color'],$settings['secondary_color'],$settings['storeName'],$useremail);

                $email_templates = str_replace($replace, $replacewith, $email_template);
                $data1 = ['email_template' => $email_templates];
                Helper::sendMyEmail(Config('constants.frontviewEmailTemplatesPath') . 'forgotPassEmail', $data1, $subject, Config::get('mail.from.address'), Config::get('mail.from.name'), $user->email, $user->firstname . " " . $user->firstname); 
                session()->flash('pwdResetMsg', 'Password reset successfully!');          
            }   
           if ($upPassword->telephone) {
                $msgOrderSucc = "Your password is Successfully changed.  Contact 1800 3000 2020 for real time support. Happy Learning! Team Cartini";
                Helper::sendsms($upPassword->telephone, $msgOrderSucc,$upPassword->country_code);
            }
        return redirect()->route('home');
    }

}
