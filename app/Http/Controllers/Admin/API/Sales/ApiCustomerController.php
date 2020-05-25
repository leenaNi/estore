<?php

namespace App\Http\Controllers\Admin\API\Sales;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\CustomValidator;
use App\Library\Helper;
use Config;
use Cart;
use DB;
use Input;
use Session;

class ApiCustomerController extends Controller
{
    public function index(){
        $store_id = DB::table('users')->where('id',Session::get('authUserId'))->pluck('store_id');
        $customers = DB::table('users')->where(['user_type'=>2,'store_id'=>$store_id[0]])->orderBy('id','desc')->get(['id','firstname','lastname','email']);
        if(count($customers) > 0){
            foreach($customers as $cust){
                $custAddress = DB::table('has_addresses')->where('user_id',$cust->id)->get();
                $addressArr = [];
                if(count($custAddress) > 0){
                    foreach($custAddress as $address){
                        $addressArr[] = $address;
                    }
                }
                $cust->address = $addressArr;
            }
            return response()->json(["data"=>$customers,"status" => 1, 'msg' => "All Customers"]);
        }else{
            return response()->json(["status" => 0, 'msg' => "No Customers found"]);
        }
    }

    public function addEdit(){
        $userData = DB::table('users')->where('id',Session::get('authUserId'))->first();
        $id = Input::get('id');
        $fisrtname = Input::get('firstname');
        $lastname = Input::get('lastname');
        $mobile = Input::get('mobile');
        $email = Input::get('email');
        $data = [
            'firstname' => $fisrtname,
            'lastname' => $lastname,
            'telephone' => $mobile,
            'email' => $email,
            'status' => 1,
            'prefix' => $userData->prefix,
            'store_id' => $userData->store_id,
            'country_code' => $userData->country_code,
            'user_type' => 2
        ];
        if($id != null){
            DB::table('users')->where('id',$id)->update($data);
            $custdata = DB::table('users')->where('id',$id)->first();
                return response()->json(["data"=>$custdata,"status" => 1, 'msg' => 'Customer updated successfully']);
        }else{
            if($mobile != null || $firstname != null){
                $custexist = DB::table('users')->where('telephone',$mobile)->first();
                if($custexist == null){
                    DB::table('users')->insert($data);
                    $custdata = DB::table('users')->latest('id')->first();
                    return response()->json(["data"=>$custdata,"status" => 1, 'msg' => 'New Customer added successfully']);
                }else{
                    return response()->json(["status" => 0, 'msg' => 'Mobile number already exist']);
                }
            }else{
                return response()->json(["status" => 0, 'msg' => 'Mandatory fields are missing.']);
            }
        }
        
    }

    public function addEditShippingAddress(){
        
        $id = Input::get('id');
        $customerId = Input::get('customerId');
        $firstname = Input::get('firstname');
        $lastname = Input::get('lastname');
        $address1 = Input::get('address1');
        $address2 = Input::get('address2');
        $phoneNo = Input::get('phone_no');
        $cityName = Input::get('city');
        $pincode = Input::get('pincode');
        $stateId = Input::get('state_id');
        $thana = Input::get('thana');

        $marchantId = Session::get("merchantId");
        $merchant = DB::table("merchants")->where('id',$marchantId)->first();
        $country_code = $merchant->country_code;
        $country = DB::table("countries")->where('country_code',$country_code)->first();
        $custData = DB::table('users')->where('id',$customerId)->first();
        $data = [
            'user_id' => $customerId,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'phone_no' => $phoneNo,
            'address1' => $address1,
            'address2' => $address2,
            'thana' => $thana,
            'city' => $cityName,
            'postcode' => $pincode,
            'zone_id' => $stateId,
            'country_id' => $country->id,
            'is_shipping' => 1
        ];
        if($id != null){
            DB::table('has_addresses')->where('id',$id)->update($data);
            $custAddress = DB::table('has_addresses')->where('id',$id)->first();
                return response()->json(["data"=>$custAddress,"status" => 1, 'msg' => 'Shipping address updated successfully']);
        }else{
            if($customerId != null || $address1 != null){
                $dataExist = DB::table('has_addresses')->where('address1',$address1)->first();
                if($dataExist == null){
                    DB::table('has_addresses')->insert($data);
                    $custAddress = DB::table('has_addresses')->latest('id')->first();
                    return response()->json(["data"=>$custAddress,"status" => 1, 'msg' => 'Shipping address added successfully']);
                }else{
                    return response()->json(["status" => 0, 'msg' => 'Address  already exist']);
                }
            }else{
                return response()->json(["status" => 0, 'msg' => 'Mandatory fields are missing.']);
            }
        }
        
    }
}
