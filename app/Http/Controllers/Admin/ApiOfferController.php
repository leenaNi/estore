<?php

namespace App\Http\Controllers\Admin;

use Route;
use Input;
use App\Http\Controllers\Controller;
use DB;
use Request;
use Response;
use Session;
use App\Library\Helper;
use Config;

class ApiOfferController extends Controller
{
    public function getDistributorOffer()
    {
        if(!empty(Input::get("merchantId")))
        {
            $merchantId = Input::get("merchantId");
            $storeIdsResult = DB::table('has_distributors as hd')
                ->join('stores as s', 's.merchant_id', '=', 'hd.distributor_id')
                ->where('hd.merchant_id',$merchantId)
                ->where('s.store_type','distributor')->get(['s.id']);
            //echo "<pre>";print_r($storeIdsResult);exit;
            $storeIdArray = [];
            foreach($storeIdsResult as $storeIdsData)
            {
                $storeIdArray[] = $storeIdsData->id;
            }
            $offerResult = DB::table('offers as o')->whereIn('store_id',$storeIdArray)->where('status',1)->get(['id','store_id','offer_name','offer_discount_value','min_order_qty','min_free_qty','min_order_amt','max_discount_amt','max_usage','actual_usage','start_date','end_date']);
            if(count($offerResult) > 0)
            {
                return response()->json(["status" => 1, 'result' => $offerResult]);
            }
            else
            {
                return response()->json(["status" => 0, 'msg' => 'Record not found']);
            }
        }   
        else
        {
            return response()->json(["status" => 0, 'msg' => 'Mendatory fields are missing.']);
        }  
    }
}
