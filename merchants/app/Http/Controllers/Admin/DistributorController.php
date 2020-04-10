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

        //echo "login user id::".$loggedInUserId."user type::". $loginUserType;
        // get store id
        $userResult = DB::table('users')->where("id", $loggedInUserId)->first();
        $storeId = $userResult->store_id;
        //echo "store id::".$storeId;
        // Get merchant id from store table
        $storeResult = DB::table('stores')->where("id", $storeId)->first();
        $merchantId = $storeResult->merchant_id;
        
        $distributorListingResult = DB::table('has_distributors as hd')
        ->select(['hd.merchant_id', 'hd.is_approved', 'd.register_details','hd.updated_at'])
        ->join('distributor as d', 'hd.distributor_id', '=', 'd.id')
        //->where([["hd.distributor_id", $distributorId],['is_approved', '1']])
        ->where([["hd.merchant_id", $merchantId]])
        ->orderBy('hd.id','desc')->get();
        //dd(DB::getQueryLog()); // Show results of log
        //echo "<pre>";print_r($distributorListingResult);exit;
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

    public function isApprovedDistributor()
    {
        $allinput = Input::all();
        $merchantId = $allinput['merchantId'];
        //$merchantId = 10;
        //echo "merchant id::".$merchantId;
        //exit;
        //update is_approved=1 in has_distributor table
        $hasDistributorRs = DB::table('has_distributors')
        ->where('merchant_id', $merchantId)
        ->update(['is_approved' => 1]);
        /*$hasDistributorRs = hasDistributor::find($merchantId);
                $hasDistributorRs->is_approved = 1;
                $hasDistributorRs->update();*/

        if(!empty($hasDistributorRs))
        {
            $data = ['status' => 1, 'error' => "Records updated Successfully"];
        }
        else
        {
            $data = ['status' => 0, 'error' => "Not updated"];
        }
        return $data;

    }

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
        if(!empty($decodedDistributorDetail['business_type'][0])){
            $merchantbusinessId = $decodedDistributorDetail['business_type'][0];
        }
        //echo "id >> ".$merchantbusinessId;
        if (!empty($distributorIdentityCode)) {
            $distributorResult = DB::table('distributor')->where("identity_code", $distributorIdentityCode)->first();
            if(!empty($distributorResult))
            {
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
                            $data = ['status' => 1, 'distributorData' => $distributorResult, 'distributorId' => $distributorResult->id];
                            //$data = ['status' => 0, 'error' => "Industry not matched"];
                        }
                    } else {
                        $data = ['status' => 0, 'error' => "Invalid distributor code"];
                    }
                }
                else
                {
                    $data = ['status' => 0, 'error' => "You are already connected with this distributor. You can place order for this distributor."];
                }
            } else {
                $data = ['status' => 0, 'error' => "Enter valid distributor code"];
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
        
        //Get distributor store url key
        $storeUrlKeyResult = DB::table('stores')
                            ->where("store_type", 'distributor')
                            ->where("merchant_id", $hdnDistributorId)->first();
        $distributorStoreUrlKey = $storeUrlKeyResult->url_key;
        //echo "store url key::".$distributorStoreUrlKey;
        //exit;

        // Get merchant id from store table
        $storeResult = DB::table('stores')->where("id", $storeId)->first();
        $merchantId = $storeResult->merchant_id;
        $merchantStoreName = $storeResult->store_name;

        //$insertData = ["merchant_id" => $merchantId, "distributor_id" => $hdnDistributorId,'is_approved'=>1,'raised_by'=>'merchant'];
        $insertData = ["merchant_id" => $merchantId, "distributor_id" => $hdnDistributorId,'raised_by'=>'merchant'];
        $isInserted = DB::table('has_distributors')->insertGetId($insertData);
        //echo "last inserted id::".$isInserted;
        if ($isInserted) {
            $storeName = $merchantStoreName;

            //$linkToConnect = route('admin.vendors.accept',['id' => Crypt::encrypt($isInserted)]);
            //echo "link connect ::".$linkToConnect;
            //exit;
            //$ApprovalUrl = "http://" . $distributorStoreUrlKey . '.' . $_SERVER['HTTP_HOST'] .'/admin/purchases/vendors/accept/'.Crypt::encrypt($isInserted); 
            $ApprovalUrl = "http://" . $distributorStoreUrlKey . '.' . $_SERVER['HTTP_HOST'] .'/admin/purchases/vendors/accept/'.Crypt::encrypt($isInserted); 
            //echo "url::".$ApprovalUrl;
            //exit;
            //$baseurl = str_replace("\\", "/", base_path());
            //$linkToConnect = route('admin.vendors.accept',['id' => Crypt::encrypt($isInserted)]);
            //echo "link connect::".$linkToConnect;
            //exit;
            //SMS
            //$msgOrderSucc = $storeName . " is connected with you for business";// Click on below link, if you want to connect with distributor<a onclick='#'>Conenct</a>";
            $msgOrderSucc = $storeName . ' is connected with you for business Click on below link, <a href="'.$ApprovalUrl .'">'.$ApprovalUrl.'</a>';
            //echo "succ msg::".$msgOrderSucc;
            Helper::sendsms($hdnDistributorPhone, $msgOrderSucc, $countryCode);

            //Email
            $domain = 'eStorifi.com'; //$_SERVER['HTTP_HOST'];
            $sub = "Merchant Connect with you";
        
            //$mailcontent = $storeName." is connected with you for business. ";
            //$mailcontent .= "Click on below link, if you want to connect with distributor ".$linkToConnect;
        
            /*if (!empty($hdnDistributorEmail)) {
                Helper::withoutViewSendMail($hdnDistributorEmail, $sub, $mailcontent);
            }*/
            Session::flash('sendRequestMsg', 'Your request successfully sent to the distributor.');
            
        } // End if
        else
        {
            Session::flash('sendRequestMsg', 'There is somthing wrong.');
        }
       
        return redirect()->route('admin.distributor.addDistributor');
       
    } // End sendNotificationToDistributor();


    //for mail purpose
    public function approveRequest($id)
    {
        if(isset($id) && !empty($id))
        {   
            $decryptedId = Crypt::decrypt($id);
            //echo "id::".$decryptedId;
            //exit;
            $isUpdated = DB::table('has_distributors')
            ->where('id', $decryptedId)
            ->update(array('is_approved' => 1));  // update the record in the DB. 
            
            if($isUpdated)
            {
                // Get distributor id from has_distributor
                $hasDistributorResult = DB::table('has_distributors')->where("id", $decryptedId)->first();
                $distributorId = $hasDistributorResult->distributor_id;

                // Distributor data
                $merchantResult = DB::table('merchants')->where("id", $distributorId)->first();
                $merchantPhoneNo = $merchantResult->phone;
                $countryCode = $merchantResult->country_code;

                //SMS
                if(!empty($merchantPhoneNo))
                {
                    $massage = "Request accepted by distributor";
                    Helper::sendsms($merchantPhoneNo, $massage, $countryCode);
                }
                
            } // End isUpdated if
           $viewname = Config('constants.adminDistributorView') . '.thank_you';
           //$viewname = "Frontend.pages.thank_you";
            return Helper::returnView($viewname, '');
            //return view($viewname);
        } // End if here
    } // ENd approveRequest() 
}