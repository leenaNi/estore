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
                return response()->json(["status" => 1, 'data' => $productResult]);
            }
            else
            {
                return response()->json(["status" => 1, 'msg' => 'Product not found']);
            }
        }
        else
        {
            return response()->json(["status" => 0, 'msg' => 'Mandatory fields are missing.']);
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
                return response()->json(["status" => 1, 'data' => $productResult]);
            }
            else
            {
                return response()->json(["status" => 1, 'msg' => 'Product not found']);
            }
        }
        else
        {
            return response()->json(["status" => 0, 'msg' => 'Mandatory fields are missing.']);
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
                    return response()->json(["status" => 1, 'msg' => '', 'data' => $productResult]);
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
            return response()->json(["status" => 0, 'msg' => 'Mandatory fields are missing.']);
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
                     return response()->json(["status" => 1, 'data' => $distributorResult]);
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
            return response()->json(["status" => 0, 'msg' => 'Mandatory fields are missing.']);
        }  

    }//function ends here

    public function getDistributorByCompany()
    {
        //DB::enableQueryLog(); // Enable query log
        if(!empty(Input::get("companyId"))) 
        {
            $companyId = Input::get("companyId");

            //get merchant wise distributor id
            $merchantId = Input::get("merchantId");
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

                //echo "<pre> Merchant wise ditributor::";
                //print_r($multipleDistributorIds);
                //exit;
               
            }


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
                    ->select('id',DB::raw('merchant_id'))
                    ->whereIn('id', $multipleStoreIds)
                    ->where('store_type', 'distributor')
                    ->get();
                   
                    if(count($distributorIdsResult) > 0)
                    {
                        $multipleDistributorIds = [];
                        $storesIdArray = [];
                        foreach ($distributorIdsResult as $distributorIdsData) 
                        {
                            $storesIdArray[$distributorIdsData->merchant_id] = $distributorIdsData->id;
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
                            $finalDistributorArray = array();
                            $i= 0;
                            //echo "<pre> company wise All distributor::";
                            //print_r($companyWiseDistributorResult);
                           foreach($companyWiseDistributorResult as $getData)
                            {

                                $companyWiseDistributorIds = $getData->id;
                                $distributorRegisterDetails = $getData->register_details;

                                if(in_array($companyWiseDistributorIds, $multipleDistributorIds))
                                {
                                    $storeId = $storesIdArray[$companyWiseDistributorIds];
                                    $offersIdCountResult = DB::table('offers')
                                    ->select(DB::raw('count(id) as offer_count'))     
                                    ->where('store_id', $storeId)
                                    ->get();
                                    $offerCount = 0;
                                    if(count($offersIdCountResult) > 0)
                                    {
                                        $offerCount = $offersIdCountResult[0]->offer_count;
                                    }

                                    $finalDistributorArray[$i]['distributor_id'] = $companyWiseDistributorIds;
                                    $finalDistributorArray[$i]['register_details'] = $distributorRegisterDetails;
                                    $finalDistributorArray[$i]['offer_count'] = $offerCount;
                                    
                                    $i++;
                                }
                            }//foreach ends here
                            //echo "<pre> comapny wise all dist id::";
                           // print_r($finalDistributorArray);
                            return response()->json(["status" => 1, 'data' => $finalDistributorArray]);
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
            return response()->json(["status" => 0, 'msg' => 'Mandatory fields are missing.']);
        }
    }//function ends here
  
    public function getDistributorOfferDetails()
    {
        if(!empty(Input::get("merchantId"))) 
        {
            $merchantId = Input::get("merchantId");
            $distributorId = Input::get("distributorId");
            $getDitributorIdsResult = $this->getMerchantWiseDistributorId($merchantId);
            if(count($getDitributorIdsResult) > 0)
            {
                $multipleDistributorIds = [];
                foreach ($getDitributorIdsResult as $distributorIdsData) 
                {
                    $multipleDistributorIds[] = $distributorIdsData->distributor_id;
                }

                $storeIdResult = DB::table('stores')
                ->whereIn('stores.merchant_id', $multipleDistributorIds)
                ->where('stores.store_type', 'distributor')
                ->get(['stores.id']);
                if(count($storeIdResult) > 0)
                {
                    //echo "<pre>";
                    //print_r($storeIdResult);
                    $multipleStoreIds = [];
                    foreach ($storeIdResult as $storeIdsData) 
                    {
                        $multipleStoreIds[] = $storeIdsData->id;
                    }

                    $offersResult = DB::table('offers')
                        ->whereIn('store_id', $multipleStoreIds)
                        ->where('status', 1)
                        ->get();

                    if(count($offersResult) > 0)
                    {
                        //echo "<pre>";
                        //print_r($offersResult);
                        return response()->json(["status" => 1, 'msg' => "", 'data' => $offersResult]);
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
        }
        else
        {
            return response()->json(["status" => 0, 'msg' => 'Mendatory fields are missing.']);
        }
    }

    public function getDistributorBrandDetails()
    {
        if(!empty(Input::get("merchantId"))) 
        {
            $merchantId = Input::get("merchantId");
            $getDitributorIdsResult = $this->getMerchantWiseDistributorId($merchantId);
            //echo "<pre>";
            //print_r($getDitributorIdsResult);
            //exit;
            if(count($getDitributorIdsResult) > 0)
            {
                $multipleDistributorIds = [];
                foreach ($getDitributorIdsResult as $distributorIdsData) 
                {
                    $multipleDistributorIds[] = $distributorIdsData->distributor_id;
                }

                // get brand id
                $brandIdsResult = DB::table('stores')
                    ->join('products', 'products.store_id', '=', 'stores.id')
                    ->whereIn('stores.merchant_id', $multipleDistributorIds)
                    ->where('stores.store_type', 'distributor')->get(['products.brand_id', 'products.store_id']);

                if (count($brandIdsResult) > 0) 
                {
                    $brandIds = [];
                    $storeId = [];
                    foreach ($brandIdsResult as $brandIdsData) {
                        $brandIds[] = $brandIdsData->brand_id;
                        $storeIds[] = $brandIdsData->store_id;
                    }

                    //echo "<pre>";
                    //print_r($brandIds);
                    if(count($brandIds) > 0)
                    {
                        $brandLogogPath = asset(Config('constants.brandImgPath') . "/");
                       $getBrandResult = DB::table('brand')
                        ->join('products', 'brand.id', '=', 'products.brand_id')
                        ->whereIn('brand.id', $brandIds)
                        ->where('is_delete', 0)
                        ->get(['brand.id as brand_id', 'brand.name as brand_name', 'concat("$brandLogogPath", brand.logo) as brand_logo', 'brand.company_id', 'brand.industry_id']);
                        
                        /*echo "<pre>";
                        print_r($getBrandResult);
                        exit;*/
                        return response()->json(["status" => 1, 'msg' => "", 'result' => $getBrandResult]);
                    }
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
    }

    public function getDistributorCategoryDetails()
    {
        if(!empty(Input::get("merchantId"))) 
        {
            $merchantId = Input::get("merchantId");
            $getDitributorIdsResult = $this->getMerchantWiseDistributorId($merchantId);
            //echo "<pre>";
            //print_r($getDitributorIdsResult);
            //exit;
            if(count($getDitributorIdsResult) > 0)
            {
                $multipleDistributorIds = [];
                foreach ($getDitributorIdsResult as $distributorIdsData) 
                {
                    $multipleDistributorIds[] = $distributorIdsData->distributor_id;
                }

                // get brand id
                $brandIdsResult = DB::table('stores')
                    ->join('products', 'products.store_id', '=', 'stores.id')
                    ->whereIn('stores.merchant_id', $multipleDistributorIds)
                    ->where('stores.store_type', 'distributor')->get(['products.brand_id', 'products.store_id']);

                if (count($brandIdsResult) > 0) 
                {
                    $brandIds = [];
                    $storeId = [];
                    foreach ($brandIdsResult as $brandIdsData) {
                        $brandIds[] = $brandIdsData->brand_id;
                        $storeIds[] = $brandIdsData->store_id;
                    }

                    //echo "<pre>";
                    //print_r($brandIds);
                    if(count($storeIds) > 0)
                    {
                        $getcategoryResult = DB::table('store_categories')
                        ->whereIn('store_id', $storeIds)
                        ->get();
                        //echo "<pre> brand result::";
                        //print_r($getcategoryResult);                        
                        $categoryArray = array();
                        if(count($getcategoryResult) > 0)
                        {
                            $i = 0;
                            $categoryProductArray = array();
                            foreach($getcategoryResult as $getCategoryData)
                            {
                                $categoryId = $getCategoryData->id;
                                $categoryName = $getCategoryData->category;
                                $categoryShortDesc = $getCategoryData->short_desc;
                                $categoryUrlKey = $getCategoryData->url_key;
                                $cateGoryStoreId = $getCategoryData->store_id;

                                $categoryArray[$i]['category_id'] = $categoryId;
                                $categoryArray[$i]['category_name'] = $categoryName;
                                $categoryArray[$i]['category_short_desc'] = $categoryShortDesc;
                                $categoryArray[$i]['category_url_key'] = $categoryUrlKey;
                                

                                $getCategoryWiseProductsResult = DB::table('products')
                                ->where('store_id', $cateGoryStoreId)
                                ->where('status', 1)
                                ->get();
                                if(count($getCategoryWiseProductsResult) > 0)
                                {
                                    $j=0;
                                    foreach($getCategoryWiseProductsResult as $getProductData)
                                    {
                                        $productId = $getProductData->id;
                                        $productBrandId = $getProductData->brand_id;
                                        $productName = $getProductData->product;
                                        $productCode = $getProductData->product_code;
                                        $productShortDesc = $getProductData->short_desc;
                                        $productLongDesc = $getProductData->long_desc;
                                        $productAddDesc = $getProductData->add_desc;
                                        $productIsFeatured = $getProductData->is_featured;
                                        $productImages = $getProductData->images;
                                        $productType = $getProductData->prod_type;
                                        $productIsStock = $getProductData->is_stock;
                                        $productAttrSet = $getProductData->attr_set;
                                        $productUrlKey = $getProductData->url_key;
                                        $productStock = $getProductData->stock;
                                        $productMaxPrice = $getProductData->max_price;
                                        $productMinPrice = $getProductData->min_price;
                                        $productPurchasePrice = $getProductData->purchase_price;
                                        $productPrice = $getProductData->price;

                                        $categoryArray[$i]['product'][$j]['product_id'] = $productId;
                                        $categoryArray[$i]['product'][$j]['product_brand_id'] = $productBrandId;
                                        $categoryArray[$i]['product'][$j]['product_name'] = $productName;
                                        $categoryArray[$i]['product'][$j]['product_code'] = $productCode;
                                        $categoryArray[$i]['product'][$j]['short_desc'] = $productShortDesc;
                                        $categoryArray[$i]['product'][$j]['long_desc'] = $productLongDesc;
                                        $categoryArray[$i]['product'][$j]['add_desc'] = $productAddDesc;
                                        $categoryArray[$i]['product'][$j]['is_featured'] = $productIsFeatured;
                                        $categoryArray[$i]['product'][$j]['product_image'] = $productImages;
                                        $categoryArray[$i]['product'][$j]['product_type'] = $productType;
                                        $categoryArray[$i]['product'][$j]['is_stock'] = $productIsStock;

                                        //get offers count
                                        $getOffersProductResult = DB::table('offers_products')
                                            ->select(DB::raw('count(offer_id) as offer_count'))         
                                            ->where('prod_id', $productId)
                                            ->get();
                                            $offerCount = 0;
                                        if(count($getOffersProductResult) > 0)
                                        {

                                            foreach($getOffersProductResult as $getCount)
                                            {
                                                $offerCount = $getCount->offer_count;
                                            }

                                        }
                                        $categoryArray[$i]['product'][$j]['offers_count'] = $offerCount;
                                        $j++;
                                    }
                                   //$categoryArray[$i]['product'] = $getCategoryWiseProductsResult;
                                }
                               
                                $i++;
                            }   

                            //echo "<pre> Product array::";
                            //print_r($categoryArray);
                        }
                        return response()->json(["status" => 1, 'msg' => "", 'result' => $categoryArray]);
                    }
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
    }


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
