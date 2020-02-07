<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Library\Helper;
use App\Models\Document;
use Validator;
use Illuminate\Support\Facades\Input;
use Hash;
use Session;
use Auth;
use JWTAuth;
use Config;
use DB;
use Route;
use Crypt;
use Mail;
use Illuminate\Http\Response;
use App\Models\Merchant;
use App\Models\User;
use Tymon\JWTAuth\Exceptions\JWTException;

class ApiMerchantController extends Controller {

    public function sendOtp(){
        $country = Input::get("country");
        $phone = Input::get("phone");
        $otp = rand(1000, 9999);
        $userdata = User::where('telephone',$phone)->first();
        if (!empty($userdata)) {
            $userdata->otp = $otp;
            $userdata->save();
            $msgSucc = "Your one time password is. " . $otp;
            Helper::sendsms($phone, $msgSucc, $country);
            $data = ["status" => "success", "msg" => "OTP Successfully send on your mobileNumber", "otp" => $otp];
        }
        else{
            $data = ["status" => "fail", "msg" => "Mobile Number is not Registered"];
        }
        return response()->json($data);
    }

    public function verifyOTP(){
        $phone = Input::get("phone");
        $otp = Input::get("otp");
        $userdata = User::where(['telephone'=>$phone,'otp'=>$otp])->first();
        //dd($userdata);
        if (!empty($userdata)) {
      
            if (!$token = JWTAuth::fromUser($userdata)) {

                return response()->json(["status" => 0, 'msg' => "Invalid Mobile Number"]);
            }
            $result = response()->json(compact('token'));
            $getData = $result->getdata();
            $user = JWTAuth::toUser($getData->token);
            $merchant = Merchant::where(['phone'=>$phone])->first();
            
            return response()->json(["status" => 1, 'msg' => "Successfully Loggedin", 'merchant' => $merchant])->header('token', $getData->token);
        }
        else{
            $data = ["status" => "fail", "msg" => "Please Enter Valid OTP"];
        }
    }

    public function merchantLogin() {


        Config::set('auth.providers.users.model', Merchant::Class);
        $credentials = [];
        $inputEmailPhone = Input::get('email');
        $inputEmailPhone = Input::get('phone');
        $login_type = filter_var($inputEmailPhone, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        $credentials[$login_type] = $inputEmailPhone;
        $credentials['password'] = Input::get('password');
        if (!$token = JWTAuth::attempt($credentials)) {

            return response()->json(["status" => 0, 'msg' => "Invalid Mobile / Email or Password"]);
        }
        $result = response()->json(compact('token'));
        //dd($result);
        $getData = $result->getdata();
        $user = JWTAuth::toUser($getData->token);
        if (Auth::guard('merchant-users-web-guard')->attempt($credentials)) {
            Helper::postLogin();
        }
        $merchant = Merchant::find(Session::get('authUserId'))->getstores()->first();
        $store = Merchant::find(Session::get('authUserId'))->getstores()->count();
        if ($store > 0) {
            $popupStatus = DB::table('general_setting')->where('name', 'set_popup')->first()->status;
            $storeUrl = $merchant->store_domain;
            ;
            $data = ['storeCount' => $store, 'popup_status' => $popupStatus, 'storeUrl' => $storeUrl];
        } else {
            $data = ['storeCount' => $store];
        }


        return response()->json(["status" => 1, 'msg' => "Successfully Loggedin", 'result' => $user, 'setupStatus' => $data])->header('token', $getData->token);
    }

    public function getProfile() {
        $merchant = Merchant::select("id", "email", "firstname", "lastname", "phone")->find(Input::get('merchantId'));
        return $merchant;
    }

    public function updateProfile() {
        $merchant = Merchant::find(Input::get('merchantId'));
        $store = $merchant->getstores()->first();
       
        $user=[];
        $user["firstname"]=Input::get("firstname");
        $user["lastname"]=Input::get("lastname");
        $merchant->firstname = Input::get("firstname");
        $merchant->lastname = Input::get("lastname");
        $oldPassword = Input::get("oldPassword");
        $password=Input::get("password");
        $check = (Hash::check($oldPassword, $merchant->password));
        $users = DB::table('users')->where('email',$merchant->email)->first();
        if(!empty($oldPassword) && !empty($password)){
        if ($check == true) {
            $merchant->password = Hash::make(Input::get("password"));
            $user["password"]=Hash::make(Input::get("password"));
        } else {
            return $data = ["status" =>"0", "msg" => "Give old password is incorrect"];
        }
        }
         $user = DB::table('users')->where('email',$merchant->email)->update($user);
        //  $merchant->email = Input::get("email");
        //  $merchant->phone = Input::get("phone");
        $merchant->save();

        $data = ['status' => '1', 'msg' => 'profile updated successfully!', 'merchant' => $merchant];
        return $data;
    }

    public function fbMerchantLogin($merchant = null) {
        if (!empty($merchant)) {
            $userDetails = Merchant::where("email", "=", $merchant)->first();
        } else {
            $email = Input::get('email');
            $appId = Input::get('appId');
            $userDetails = Merchant::where("email", "=", $email)->where("provider_id", $appId)->first();
        }

        if (empty($userDetails)) {
            $result = ['status' => '0', 'msg' => 'Invalid User'];
            return $result;
        } else {
            $token = JWTAuth::fromUser($userDetails);
            if (!$token) {

                return response()->json(false, Response::HTTP_UNAUTHORIZED);
            }

            $result = response()->json(compact('token'));

            $getData = $result->getdata();
            $user = JWTAuth::toUser($getData->token);
            Auth::guard('merchant-users-web-guard')->login($userDetails);
            if (Auth::guard('merchant-users-web-guard')->check()) {
                Helper::postLogin();
            }

            $merchant = Merchant::find($userDetails->id)->getstores()->first();
            $store = Merchant::find($userDetails->id)->getstores()->count();
            if ($store > 0) {
                $popupStatus = DB::table('general_setting')->where('name', 'set_popup')->first()->status;

                $storeUrl = $merchant->store_domain;
                $data = ['storeCount' => $store, 'popup_status' => $popupStatus, 'storeUrl' => $storeUrl];
            } else {
                $data = ['storeCount' => $store];
            }
            return response()->json(["status" => 1, 'msg' => "Successfully Loggedin", 'result' => $user, 'setupStatus' => $data])->header('token', $getData->token);
        }
    }

    public function forgotPassword() {

        $inputEmailPhone = Input::get('email');
        $login_type = filter_var($inputEmailPhone, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
        $userDetails = Merchant::where($login_type, "=", $inputEmailPhone)->first();
        if (count($userDetails) > 0) {
            if ($userDetails->email) {
                $linktosend = $_SERVER['HTTP_HOST'] . "/reset-new-pwd/" . Crypt::encrypt($userDetails->email);

                $email = $userDetails->email;
                $firstname = $userDetails->firstname;
                $emailData = ['name' => $firstname, 'newlink' => $linktosend];
                Mail::send('Frontend.emails.forgotPassEmail', $emailData, function ($m) use ($email, $firstname) {
                    $m->to($email, $firstname)->subject('Forgot password');
                    //$m->cc('madhuri@infiniteit.biz');
                });
                return $data = ["status" => 1, "msg" => "A Link to reset your password has been sent. Please check your Email."];
            }
        } else {
            return $data = ["status" => 0, "msg" => "Invalid Email/phone"];
        }
    }

    public function getBankDetails() {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $bankDetails = DB::table('general_setting')->where('url_key', 'bank_acc_details')->first();
        if(!empty($bankDetails))
        {
            return $data = ["status" => 1, "bankDetails" => $bankDetails->details];
        }
        else
        {
            return $data = ["status" => 0, "msg" => "Bank details not found!"];
        }
    }

    public function updateBankDetails() {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        if(!empty($merchant))
        {
            $bankDetails = DB::table('general_setting')->where('url_key', 'bank_acc_details')->first();
            $postedData = $data = [];
            $postedData['bank_name'] = Input::get("bank_name");
            $postedData['branch_name'] = Input::get("branch_name");
            $postedData['ifsc'] = Input::get("ifsc");
            $postedData['bank_address'] = Input::get("bank_address");
            $postedData['city'] = Input::get("city");
            $postedData['state'] = Input::get("state");
            $postedData['country'] = Input::get("country");
            $postedData['acc_type'] = Input::get("acc_type");
            $postedData['acc_no'] = Input::get("acc_no");

            $data['details'] = json_encode($postedData);

            DB::table('general_setting')->where('url_key', 'bank_acc_details')->update($data);
           

            return $data = ["status" => 1, "msg" => "Bank details updated successfully!"];
        }
        else
        {
             return $data = ["status" => 0, "msg" => "Merchant details not found!"]; 
        }
        
    }

}
