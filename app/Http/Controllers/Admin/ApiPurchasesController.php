<?php

namespace App\Http\Controllers\Admin;

use Route;
use Input;
use App\Http\Controllers\Controller;
use DB;
use Request;
use Response;
use Session;
use Config;

class ApiPurchasesController extends Controller
{
    public function getDistributorOffers()
    {
        // dd(Input::get('merchantId'));
        //DB::enableQueryLog();
        $isError = '';
        //dd(Input::all());
        if(!empty(Input::get("merchantId")) && !empty(Input::get("distributorId")))
        {
            $merchantId = Input::get("merchantId");
            $distributorId = Input::get("distributorId");

            //Get Store IDs of distributors
            $storeId = DB::table('stores')->where('merchant_id', $distributorId)->where('store_type', 'distributor')->first(['id']);
            if($storeId && $storeId != null)
            {
                $offers = DB::table('offers')->where('status', 1)->where('store_id', $storeId->id)->get();
                if(count($offers) > 0)
                    {
                        $isError = 0;
                    }
                    else
                    {
                        $isError = 1;
                    }
            }
            else
            {
                $isError = 1;
            }
            
            if($isError == 1)
            {
                return response()->json(["status" => 1, 'msg' => "Record not found."]);
            }
            else if($isError == 0)
            {
                return response()->json(["status" => 1, 'result' => $offers]);
            }
            else
            {
                return response()->json(["status" => 1, 'msg' => "There is something wrong."]);
            }
        }
        else
        {
            return response()->json(["status" => 0, 'msg' => 'Mandatory fields are missing.']);
        }   
    } // End getDistributorOffers
    
    public function getAllOffers()
    {
        $isError = '';
        //dd(Input::all());
        if(!empty(Input::get("merchantId")))
        {
            $merchantId = Input::get("merchantId");
            
            // get distributor id from has_distributor table
            $distributorIdResult = DB::table('has_distributors')->where('merchant_id',$merchantId)->get()->pluck(['distributor_id']);

            //Get Store IDs of distributors
            $storeIds = DB::table('stores')->whereIn('merchant_id', $distributorIdResult)->where('store_type', 'distributor')->get()->pluck(['id']);
            if(count($storeIds) > 0)
            {
                $offers = DB::table('offers')->where('status', 1)->whereIn('store_id', $storeIds)->get();
                if(count($offers) > 0)
                    {
                        $isError = 0;
                    }
                    else
                    {
                        $isError = 1;
                    }
            }
            else
            {
                $isError = 1;
            }
            
            if($isError == 1)
            {
                return response()->json(["status" => 1, 'msg' => "Record not found."]);
            }
            else if($isError == 0)
            {
                return response()->json(["status" => 1, 'result' => $offers]);
            }
            else
            {
                return response()->json(["status" => 1, 'msg' => "There is something wrong."]);
            }
        }
        else
        {
            return response()->json(["status" => 0, 'msg' => 'Mandatory fields are missing.']);
        }  
    } // End getAllOffers


}