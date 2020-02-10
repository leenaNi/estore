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

    public function getDistributorByMerchant()
    {
        //DB::enableQueryLog(); // Enable query log
        if(!empty(Input::get("merchantId"))) 
        {
            $searchKeyWord = Input::get("searchKey");
            $merchantId = Input::get("merchantId");
            //echo "merchant id::".$merchantId;
            //exit;
            //check merchant id is present in has_distributors table
            $getDitributorIdsResult = $this->getMerchantWiseDistributorId($merchantId);
            /*$getDitributorIdsResult = DB::table('has_distributors')
            ->select(DB::raw('distributor_id'))
            ->where('merchant_id', $merchantId)
            ->get();*/

            if(count($getDitributorIdsResult) > 0)
            {
                $multipleDistributorIds = [];
                foreach ($getDitributorIdsResult as $distributorIdsData) 
                {
                    $multipleDistributorIds[] = $distributorIdsData->distributor_id;
                }
                
                //Get distributor id wise data
                 $distributorResult = DB::table('distributor')
                 ->whereIn('id', $multipleDistributorIds)
                 ->where('business_name','LIKE', '%' . $searchKeyWord . '%')
                 ->get();
                 //dd(DB::getQueryLog()); // Show results of log
                 if(count($distributorResult) > 0)
                 {
                     return response()->json(["status" => 1, 'result' => $distributorResult]);
                 }
                 else
                 {
                     return response()->json(["status" => 0, 'msg' => 'Records not found']);
                 }
            }
            else
            {
                return response()->json(["status" => 0, 'msg' => 'Records not found']);
            }

        }
        else
        {
            return response()->json(["status" => 0, 'msg' => 'Mendatory fields are missing.']);
        }  

    }//function ends here

    public function getDistributorByCompany()
    {
        //DB::enableQueryLog(); // Enable query log
        if(!empty(Input::get("companyId"))) 
        {
            $companyId = Input::get("companyId");

            //check company id is present in brand table
            $getBrandIdsResult = DB::table('brand')
            ->select(DB::raw('id'))
            ->where('company_id', $companyId)
            ->get();

            if(count($getBrandIdsResult) > 0)
            {
                $multipleBrandIds = [];
                foreach ($getBrandIdsResult as $brandIdsData) 
                {
                    $multipleBrandIds[] = $brandIdsData->id;
                }
                //echo "<pre>multiple brand id::";
                //print_r($multipleBrandIds);

                //check brand id in product table and get store_id
                $storeIdsResult = DB::table('products')
                 ->select(DB::raw('store_id'))
                 ->whereIn('brand_id', $multipleBrandIds)
                 ->get();
                 if(count($storeIdsResult) > 0)
                 {
                    //echo "inside if";
                    $multipleStoreIds = [];
                    foreach ($storeIdsResult as $storeIdsData) 
                    {
                        $multipleStoreIds[] = $storeIdsData->store_id;
                    }
                    //echo "<pre> Multiple store id::";
                    //print_r($multipleStoreIds);

                    //get distributor id from the store table
                    $distributorIdsResult = DB::table('stores')
                    ->select(DB::raw('merchant_id'))
                    ->whereIn('id', $multipleStoreIds)
                    ->where('store_type', 'distributor')
                    ->get();
                   
                    if(count($distributorIdsResult) > 0)
                    {
                        $multipleDistributorIds = [];
                        foreach ($distributorIdsResult as $distributorIdsData) 
                        {
                            $multipleDistributorIds[] = $distributorIdsData->merchant_id;
                        }

                        //echo "<pre> Multiple distributor id::";
                        //print_r($multipleDistributorIds);
                        //exit;
                        //Get distributor id wise data
                        $companyWiseDistributorResult = DB::table('distributor')
                        ->whereIn('id', $multipleDistributorIds)
                        ->get();
                        //dd(DB::getQueryLog()); // Show results of log
                        if(count($companyWiseDistributorResult) > 0)
                        {
                            //echo "<pre> company wise distributor::";
                            //print_r($companyWiseDistributorResult);

                            //get merchant wise distributor id
                            /*$merchantId = Input::get("merchantId");
                            $getDistributorIdsResult = $this->getMerchantWiseDistributorId($merchantId);
                            if(count($getDistributorIdsResult) > 0)
                            {
                                $multipleDistributorIds = [];
                                foreach ($getDistributorIdsResult as $distributorIdsData) 
                                {
                                    $multipleDistributorIds[] = $distributorIdsData->distributor_id;
                                }
                                //Get distributor id wise data
                                $merchantWiseDistributorResult = DB::table('distributor')
                                ->whereIn('id', $multipleDistributorIds)
                                ->get();

                                echo "<pre> Merchant wise ditributor::";
                                print_r($merchantWiseDistributorResult);
                                //exit;
                                $resultArray = array_intersect($companyWiseDistributorResult, $merchantWiseDistributorResult);
                                //$resultArray = array_map('getResult', $companyWiseDistributorResult, $merchantWiseDistributorResult);
                                echo "<pre>";
                                print_r($resultArray);
                                exit;

                            }*/

                            return response()->json(["status" => 1, 'result' => $companyWiseDistributorResult]);
                        }
                        else
                        {
                            return response()->json(["status" => 0, 'msg' => 'Records not found']);
                        }
                        
                    }
                    else
                    {
                        return response()->json(["status" => 0, 'msg' => 'Records not found']);
                    }
                    

                 }
                 else
                 {
                     return response()->json(["status" => 0, 'msg' => 'Records not found']);
                 }
                 
            }
            else
            {
                return response()->json(["status" => 0, 'msg' => 'Records not found']);
            }

        }
        else
        {
            return response()->json(["status" => 0, 'msg' => 'Mendatory fields are missing.']);
        }
    }//function ends here

    public function getMerchantWiseDistributorId($merchantId)
    {
         //check merchant id is present in has_distributors table
         $getDitributorIdsResult = DB::table('has_distributors')
         ->select(DB::raw('distributor_id'))
         ->where('merchant_id', $merchantId)
         ->get();

         return $getDitributorIdsResult;
    }
}
