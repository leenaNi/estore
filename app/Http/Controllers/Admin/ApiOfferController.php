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
    } // End getDistributorOffer
    
    
    public function getProductWiseOffer()
    {
        //DB::enableQueryLog(); // Enable query log
        if(!empty(Input::get("productId")))
        {
            $productId = Input::get("productId");
            $productWiseOfferIdsResult = DB::table('offers_products as op')
            ->select(DB::raw('offer_id'))
            ->where('prod_id', $productId)
            ->get();
            if(count($productWiseOfferIdsResult) > 0)
            {
                $offerIds = [];
                foreach ($productWiseOfferIdsResult as $offerIdsData) 
                {
                    $offerIds[] = $offerIdsData->offer_id;
                }
                //Get offer id wise Offers Data
                $productWiseOffersResult = DB::table('offers')
                    ->whereIn('id', $offerIds)
                    ->get();
                //dd(DB::getQueryLog()); // Show results of log
                if(count($productWiseOffersResult) > 0)
                {
                    return response()->json(["status" => 1, 'result' => $productWiseOffersResult]);
                }
                else
                {
                    return response()->json(["status" => 0, 'msg' => 'Record not found']);
                }
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
    }//getProductWiseOffer function ends here
}
