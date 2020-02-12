<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Library\Helper;
use App\Models\Merchant;
use App\Models\User;
use App\Models\Store;
use Auth;
use Crypt;
use DB;
use Hash;
use Illuminate\Http\Response;
use Input;
use JWTAuth;
use Request;

class ApiMerchantController extends Controller
{

    public function sendOtp()
    {
        $country = Input::get("country_code");
        $phone = Input::get("phone");
        if (Input::get("phone") && !empty(Input::get("phone"))) {
            $otp = rand(1000, 9999);
            $userdata = User::where('telephone', $phone)->where('user_type', 1)->first();
            if (!empty($userdata)) {
                $userdata->otp = $otp;
                $userdata->save();
                $msgSucc = "[#] Your one time password is " . $otp . ". lRaDZ0eOjMz";
                Helper::sendsms($phone, $msgSucc, $country);
                $data = ["status" => 1, "msg" => "OTP Successfully send on your mobile number", "otp" => $otp];
            } else {
                $data = ["status" => 0, "msg" => "Mobile Number is not Registered"];
            }
        } else {
            $data = ["status" => 0, "msg" => "Mobile Number is missing"];
        }
        return response()->json($data);
    }

    public function verifyOTP()
    {
        $phone = Input::get("phone");
        $otp = Input::get("otp");
        $userdata = User::where(['telephone' => $phone, 'otp' => $otp])->first();
        //dd($userdata);
        if (!empty($userdata)) {
            if (!$token = JWTAuth::fromUser($userdata)) {
                return response()->json(["status" => 0, 'msg' => "Invalid Mobile Number"]);
            }
            $result = response()->json(compact('token'));
            $getData = $result->getdata();
            $user = JWTAuth::toUser($getData->token);
            $merchant = Merchant::where(['phone' => $phone])->first(['id', 'company_name', 'phone']);
            $store = Store::where('merchant_id', $merchant->id)->where('store_type', 'merchant')->first();
            return response()->json(["status" => 1, 'msg' => "Successfully Loggedin", 'data' => ['merchant' => $merchant, 'store' => $store]])->header('token', $getData->token);
        } else {
            $data = ["status" => "0", "msg" => "Please Enter Valid OTP"];
            return response()->json($data);
        }
    }

    public function merchantLogin()
    {

        // Config::set('auth.providers.users.model', Merchant::Class);
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

        $userMerchant = User::where('id', Session::get('authUserId'))->first()->store()->first();
        $merchant = Merchant::find($userMerchant->merchant_id)->getstores()->first();
        $store = Merchant::find($userMerchant->merchant_id)->getstores()->count();
        $user->merchant_id = $userMerchant->merchant_id;
        if ($store > 0) {
            $popupStatus = DB::table('general_setting')->where('name', 'set_popup')->first()->status;
            $storeUrl = $merchant->store_domain;

            $data = ['storeCount' => $store, 'popup_status' => $popupStatus, 'storeUrl' => $storeUrl];
        } else {
            $data = ['storeCount' => $store];
        }

        return response()->json(["status" => 1, 'msg' => "Successfully Loggedin", 'result' => $user, 'setupStatus' => $data])->header('token', $getData->token);
    }

    public function getProfile()
    {
        $merchant = Merchant::select("id", "email", "firstname", "lastname", "phone")->find(Input::get('merchantId'));
        return $merchant;
    }

    public function updateProfile()
    {
        $merchant = Merchant::find(Input::get('merchantId'));
        $store = $merchant->getstores()->first();

        $user = [];
        $user["firstname"] = Input::get("firstname");
        $user["lastname"] = Input::get("lastname");
        $merchant->firstname = Input::get("firstname");
        $merchant->lastname = Input::get("lastname");
        $oldPassword = Input::get("oldPassword");
        $password = Input::get("password");
        $check = (Hash::check($oldPassword, $merchant->password));
        $users = DB::table('users')->where('email', $merchant->email)->first();
        if (!empty($oldPassword) && !empty($password)) {
            if ($check == true) {
                $merchant->password = Hash::make(Input::get("password"));
                $user["password"] = Hash::make(Input::get("password"));
            } else {
                return $data = ["status" => "0", "msg" => "Give old password is incorrect"];
            }
        }
        $user = DB::table('users')->where('email', $merchant->email)->update($user);
        //  $merchant->email = Input::get("email");
        //  $merchant->phone = Input::get("phone");
        $merchant->save();

        $data = ['status' => '1', 'msg' => 'profile updated successfully!', 'merchant' => $merchant];
        return $data;
    }

    public function fbMerchantLogin($merchant = null)
    {
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

    public function forgotPassword()
    {

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

    public function getBankDetails()
    {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $bankDetails = DB::table('general_setting')->where('url_key', 'bank_acc_details')->first();
        if (!empty($bankDetails)) {
            return $data = ["status" => 1, "bankDetails" => $bankDetails->details];
        } else {
            return $data = ["status" => 0, "msg" => "Bank details not found!"];
        }
    }

    public function updateBankDetails()
    {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        if (!empty($merchant)) {
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
        } else {
            return $data = ["status" => 0, "msg" => "Merchant details not found!"];
        }

    }

    public function searchDistributor()
    {
        $distributorIdentityCode = Input::get("distributorCode");
        $merchantId = Input::get("merchantId");

        // Get merchant industry id
        $merchantsResult = DB::table('merchants')->where("id", $merchantId)->get(['register_details']);

        $decodedDistributorDetail = json_decode($merchantsResult[0]->register_details, true);
        // $merchantbusinessId = $decodedDistributorDetail['business_type'][0];

        if (!empty($distributorIdentityCode)) {
            $distributorResult = DB::table('distributor')->where("identity_code", $distributorIdentityCode)->get(['id', 'business_name', 'email', 'firstname', 'lastname', 'country', 'phone_no', 'register_details']);

            if (count($distributorResult) > 0) {
                // Check already connected with distributor or not
                $hasDistributor = DB::table('has_distributors')
                    ->where("distributor_id", $distributorResult[0]->id)
                    ->where('merchant_id', $merchantId)->get();
                    return ['distributor' => $hasDistributor, 'cnt' => count($hasDistributor) ];
                if (count($hasDistributor) > 0) {
                    $decodedDistributorDetail = json_decode($distributorResult[0]->register_details);
                    // $distributorbussinessArray = $decodedDistributorDetail->business_type;  
                    // if (in_array($merchantbusinessId, $distributorbussinessArray)) {
                    //     $data = ['status' => 1, 'distributorData' => $distributorResult[0]];
                    // } else {
                    //     $data = ['status' => 0, 'error' => "Industry not matched"];
                    // }
                                      
                    $data = ['status' => 1, 'distributorData' => $distributorResult[0]];
                } else {
                    $data = ['status' => 0, 'error' => "You are already connected with this distributor. You can place order for this distributor."];
                }
            } else {
                $data = ['status' => 0, 'error' => "Invalid distributor code"];
            }
        } else {
            $data = ['status' => 0, 'error' => "Enter distributor code"];
        }

        return $data;
    } // End searchDistributor()

    public function addDistributor()
    {
        $distributorId = Input::get("distributorId");
        $merchantId = Input::get("merchantId");

        // Get distributor detail
        $distributorResult = DB::table('distributor')->where("id", $distributorId)->get(['id', 'business_name', 'email', 'country', 'phone_no']);
        $merchantResult = DB::table('merchants')->where("id", $merchantId)->get(['id', 'register_details']);
        // echo "<pre>";print_r($merchantResult);exit;

        $distributorEmail = $distributorResult[0]->email;
        $distributorPhone = $distributorResult[0]->phone_no;
        $countryCode = $distributorResult[0]->country;

        $merchantId = $merchantResult[0]->id;
        $merchantRegisterDetail = json_decode($merchantResult[0]->register_details);
        $merchantStoreName = $merchantRegisterDetail->store_name;

        $insertData = ["merchant_id" => $merchantId, "distributor_id" => $distributorId, 'is_approved' => 1, 'raised_by' => 'merchant'];
        $isInserted = DB::table('has_distributors')->insert($insertData);

        if ($isInserted) {
            $storeName = $merchantStoreName;
            $baseurl = str_replace("\\", "/", base_path());
            //$linkToConnect = route('admin.vendors.accept',['id' => Crypt::encrypt($isInserted)]);
            //SMS
            $msgOrderSucc = $storeName . " is connected with you for business"; // Click on below link, if you want to connect with distributor<a onclick='#'>Conenct</a>";
            Helper::sendsms($distributorPhone, $msgOrderSucc, $countryCode);

            //Email
            $domain = 'eStorifi.com'; //$_SERVER['HTTP_HOST'];
            $sub = "Merchant Connect with you";

            $mailcontent = $storeName . " is connected with you for business. ";
            //$mailcontent .= "Click on below link, if you want to connect with distributor ".$linkToConnect;

            if (!empty($distributorEmail)) {
                Helper::withoutViewSendMail($distributorEmail, $sub, $mailcontent);
            }
            $data = ['status' => 1, 'error' => "Your request successfully sent to the distributor."];

        } // End if
        else {
            $data = ['status' => 0, 'error' => "There is somthing wrong."];
        }

        return $data;

    } // End sendNotificationToDistributor();

    public function getDistributors()
    {
        if (!empty(Input::get("merchantId"))) {
            $merchantId = Input::get("merchantId");
            $hasDistributorsResult = DB::table('has_distributors as hd')
                ->join("distributor as d", "d.id", "=", "hd.distributor_id")
                ->join('stores as s', 's.merchant_id', '=', 'd.id')
                ->where('s.store_type', 'distributor')
                ->where("hd.merchant_id", $merchantId)
                ->get(['d.id', 'd.phone_no', 's.id as storeId', 's.store_name']);
            if (count($hasDistributorsResult) > 0) {
                return response()->json(["status" => 1, 'msg' => '', 'data' => $hasDistributorsResult]);
            } else {
                return response()->json(["status" => 0, 'msg' => 'Record not found']);
            }
        } else {
            return response()->json(["status" => 0, 'msg' => 'Mandatory fields are missing.']);
        }

    } // End getDistributors()
}
