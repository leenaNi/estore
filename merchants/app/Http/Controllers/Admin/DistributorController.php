<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Library\Helper;
use App\Models\Category;
use App\Models\Flags;
use App\Models\HasProducts;
use App\Models\Merchant;
use App\Models\Vendor;
use App\Models\hasDistributor;
use App\Models\User;
use Hash;
use Config;
use DB;
use Input;
use Route;
use Session;
use Auth;
use Crypt;

class DistributorController extends Controller
{

    public function index()
    {
        $loggedInUserId = Session::get('loggedin_user_id');
        $loginUserType = Session::get('login_user_type');
        // get store id
        $userResult = DB::table('users')->where("id", $loggedInUserId)->first();
        $storeId = $userResult->store_id;

        // Get merchant id from store table
        $storeResult = DB::table('stores')->where("id", $storeId)->first();
        $distributorId = $storeResult->merchant_id;

        $distributorListingResult = DB::table('has_distributors as hd')
        ->select(['hd.merchant_id', 'd.register_details','hd.updated_at'])
        ->join('distributor as d', 'hd.distributor_id', '=', 'd.id')
        ->where([["hd.distributor_id", $distributorId],['is_approved', '1']])
        ->orderBy('hd.id','desc')->get();
        
        if (isset($distributorListingResult) && !empty($distributorListingResult)) 
        {
            $data = ['merchantListingData' => $distributorListingResult,"storeId"=>$storeId,"sendRequestError" => Session::get('sendRequestMsg')];
        }
        else 
        {
            $data = ['error' => "Invalid merchant code","storeId"=>$storeId,"sendRequestError" => Session::get('sendRequestMsg')];
        }
        $viewname = Config('constants.adminDistributorView') . '.index';
        return Helper::returnView($viewname, $data);
    }     // End index

    public function verifyDistributorCode() // Verify and search
    {
        $allinput = Input::all();
        $distributorIdentityCode = $allinput['distributorIdentityCode'];
        $storeId = $allinput['hdnStoreId'];

        // Get merchant id from store table
        $storeResult = DB::table('stores')->where("id", $storeId)->first();
        $merchantId = $storeResult->merchant_id;
        
        // Get merchant industry id
        $merchantsResult = DB::table('merchants')->where("id", $merchantId)->first();
        //echo "<pre>";print_r($merchantsResult);exit;
        $decodedDistributorDetail = json_decode($merchantsResult->register_details, true);
        $merchantbusinessId = $decodedDistributorDetail['business_type'][0];
        //echo "id >> ".$merchantbusinessId;
        if (!empty($distributorIdentityCode)) {
            $distributorResult = DB::table('distributor')->where("identity_code", $distributorIdentityCode)->first();

            // Check already connected with distributor or not
            $hasDistributor = DB::table('has_distributors')->where("distributor_id", $distributorResult->id)->where('merchant_id',$merchantId)->first();
        
            if(empty($hasDistributor))
            {
                if (isset($distributorResult) && !empty($distributorResult)) {
                    $decodedDistributorDetail = json_decode($distributorResult->register_details);
                    $distributorbussinessArray = $decodedDistributorDetail->business_type;
                    //echo "<pre>";print_r($distributorbussinessArray);exit;
                    if (in_array($merchantbusinessId, $distributorbussinessArray)) {
                        $data = ['status' => 1, 'distributorData' => $distributorResult, 'distributorId' => $distributorResult->id];
                    } else {
                        $data = ['status' => 0, 'error' => "Industry not matched"];
                    }
                } else {
                    $data = ['status' => 0, 'error' => "Invalid distributor code"];
                }
            }
            else
            {
                $data = ['status' => 0, 'error' => "You are already connected with thid distributor. You can place order for this distributor."];
            }
        } else {
            $data = ['status' => 0, 'error' => "Enter distributor code"];
        }
        $viewname = Config('constants.adminDistributorView') . '.index';
        //return Helper::returnView($viewname, $data);
        return $data;

    } // End verifyDistributorCode()

    public function sendNotificationToDistributor()
    {
        $allinput = Input::all();

        $hdnDistributorEmail = $allinput['hdnDistributorEmail'];
        $hdnDistributorPhone = $allinput['hdnDistributorPhone'];
        $hdnDistributorId = $allinput['hdnDistributorId'];
        $storeId = $allinput['hdnStoreIdForNotification'];
        $countryCode = $allinput['hdnCountryCode'];

        // Get distributor id from store table
        $storeResult = DB::table('stores')->where("id", $storeId)->first();
        $merchantId = $storeResult->merchant_id;
        $merchantStoreName = $storeResult->store_name;

        $insertData = ["merchant_id" => $merchantId, "distributor_id" => $hdnDistributorId,'is_approved'=>1];
        $isInserted = DB::table('has_distributors')->insert($insertData);

        if ($isInserted) {
            $storeName = $merchantStoreName;
            $baseurl = str_replace("\\", "/", base_path());
            //$linkToConnect = route('admin.vendors.accept',['id' => Crypt::encrypt($isInserted)]);
            //SMS
            $msgOrderSucc = $storeName . " is connected with you for business";// Click on below link, if you want to connect with distributor<a onclick='#'>Conenct</a>";
            Helper::sendsms($hdnDistributorPhone, $msgOrderSucc, $countryCode);

            //Email
            $domain = 'eStorifi.com'; //$_SERVER['HTTP_HOST'];
            $sub = "Merchant Connect with you";
        
            $mailcontent = $storeName." is connected with you for business. ";
            //$mailcontent .= "Click on below link, if you want to connect with distributor ".$linkToConnect;
        
            if (!empty($hdnDistributorEmail)) {
                Helper::withoutViewSendMail($hdnDistributorEmail, $sub, $mailcontent);
            }
            Session::flash('sendRequestMsg', 'Your request successfully sent to the distributor.');
            
        } // End if
        else
        {
            Session::flash('sendRequestMsg', 'There is somthing wrong.');
        }
       
        return redirect()->route('admin.distributor.addDistributor');
       
    } // End sendNotificationToDistributor();
}
