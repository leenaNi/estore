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
        $customers = DB::table('users')->where(['user_type'=>2,'store_id'=>$store_id[0]])->get(['id','firstname','lastname','email']);
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
            'country_code' => $userData->country_code
        ];
        if($id != null){
            DB::table('users')->where('id',$id)->update($data);
            $custdata = DB::table('users')->latest('id')->first();
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


}
