<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Route;
use Input;
use DB;
use Response;
use Session;
use App\Library\Helper;
use Config;

class ApiDistributorController extends Controller
{
    public function searchProductWithDistributor()
    {
        if(!empty(Input::get("merchantId"))) 
        {
            $searchKeyWord = Input::get("searchKey");
            $merchantId = Input::get("merchantId");

            $storeIdsResult = $this->getStoreId($merchantId);

            $storeIdArray = [];
            $storeIdWithDistributorId = array();
            foreach($storeIdsResult as $storeIdsData)
            {
                $storeIdArray[] = $storeIdsData->id;
                $storeIdWithDistributorId[$storeIdsData->id]['merchant_id'] = $storeIdsData->merchant_id;
                $storeIdWithDistributorId[$storeIdsData->id]['store_name'] = $storeIdsData->store_name;
            }
            //echo "<pre>";print_r($storeIdArray);exit;
            $productResult = DB::table('products as p')
                            ->join('brand as b', 'p.brand_id', '=', 'b.id')
                            ->whereIn('p.store_id',$storeIdArray)
                            ->where(['p.status' => 1,'p.is_del' => 0])
                            ->where('p.product','LIKE', '%' . $searchKeyWord . '%')
                            ->orderBy('p.store_id', 'ASC')
                            ->get(['p.id','b.id as brand_id','b.name as brand_name','p.product','p.images','p.product_code','p.is_featured','p.prod_type','p.is_stock','p.is_avail','p.is_listing','p.status','p.stock','p.max_price','p.min_price','p.purchase_price','p.price','p.spl_price','p.selling_price','p.is_cod','p.is_tax','p.is_trending','p.min_order_quantity','p.is_share_on_mall','p.store_id']);
            //echo "<pre>";print_r($productResult);exit;
            
            for($i = 0; $i < count($productResult); $i++)
            {
                $storeId = $productResult[$i]->store_id;
                $merchantId = $storeIdWithDistributorId[$storeId]['merchant_id'];
                $storeName = $storeIdWithDistributorId[$storeId]['store_name'];
                $productResult[$i]->store_name = $storeName;
            } // End foreach
            if(count($productResult) > 0)
            {
                return response()->json(["status" => 1, 'result' => $productResult]);
            }
            else
            {
                return response()->json(["status" => 1, 'msg' => 'Product not found']);
            }
        }
        else
        {
            return response()->json(["status" => 0, 'msg' => 'Mendatory fields are missing.']);
        } 
    } // End searchProductWithDistributor

    public function getDistributorByProduct()
    {
        if(!empty(Input::get("merchantId"))) 
        {
            $searchKeyWord = Input::get("searchKey");
            $merchantId = Input::get("merchantId");

            $storeIdsResult = $this->getStoreId($merchantId);

            $storeIdArray = [];
            foreach($storeIdsResult as $storeIdsData)
            {
                $storeIdArray[] = $storeIdsData->id;
            }
            //echo "<pre>";print_r($storeIdArray);exit;
            $productResult = DB::table('products as p')
                            ->join('stores as s', 'p.store_id', '=', 's.id')
                            ->whereIn('p.store_id',$storeIdArray)
                            ->where(['p.status' => 1,'p.is_del' => 0])
                            ->where('p.product','LIKE', '%' . $searchKeyWord . '%')
                            ->groupBy('p.store_id')
                            ->get(['s.id','p.store_id','s.store_name']);
            if(count($productResult) > 0)
            {
                return response()->json(["status" => 1, 'result' => $productResult]);
            }
            else
            {
                return response()->json(["status" => 1, 'msg' => 'Product not found']);
            }
        }
        else
        {
            return response()->json(["status" => 0, 'msg' => 'Mendatory fields are missing.']);
        } 
    }

    public function getStoreId($merchantId)
    {
        $storeIdsResult = DB::table('has_distributors as hd')
        ->join('stores as s', 's.merchant_id', '=', 'hd.distributor_id')
        ->where('hd.merchant_id',$merchantId)
        ->where('s.store_type','distributor')->get(['s.id','s.merchant_id','s.store_name']);
        return $storeIdsResult;
    }

    public function getProduct() // distributoe product
    {
        if(!empty(Input::get("distributorId")))
        {
            $distributorId = Input::get("distributorId");
            
            // Get store id
            $storeResult = DB::table('stores')
                            ->where('merchant_id',$distributorId)->where('store_type','distributor')
                            ->get(['id']);
           
            if(count($storeResult) > 0)
            {
                $storeId = $storeResult[0]->id;

                // Get product
                $productResult = DB::table('products as p')
                            ->join('brand as b', 'p.brand_id', '=', 'b.id')
                            ->where('p.store_id',$storeId)
                            ->where('p.is_del',0)
                            ->get(['p.id','b.name','p.product','p.images','p.product_code','is_featured','prod_type','is_stock','is_avail','is_listing','status','stock','max_price','min_price','purchase_price','price','spl_price','selling_price','is_cod','is_tax','is_trending','min_order_quantity','is_share_on_mall']);
                if(count($storeResult) > 0)
                {
                    //echo "<pre>";print_r($productResult);exit;
                    return response()->json(["status" => 0, 'result' => $productResult]);
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
        
    } // End getProduct
}
