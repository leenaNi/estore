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
            $offerImagePath = $_SERVER['HTTP_HOST'] . '/public/Admin/uploads/offers/';
            $offerResult = DB::table('offers as o')
            ->join('stores as s', 's.id', '=', 'o.store_id')
            ->whereIn('store_id',$storeIdArray)
            ->where('o.status',1)->get(['o.id','store_id','offer_name','offer_discount_value','start_date','end_date', DB::raw('concat("http://", s.url_key, ".' . $offerImagePath . '", offer_image) as offer_image')]);
            if(count($offerResult) > 0)
            {
                return response()->json(["status" => 1, 'msg' => '', 'data' => $offerResult]);
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
                $offerImagePath = $_SERVER['HTTP_HOST'] . '/public/Admin/uploads/offers/';
                //Get offer id wise Offers Data
                $productWiseOffersResult = DB::table('offers as o')
                    ->join('stores as s', 's.id', '=', 'o.store_id')
                    ->whereIn('id', $offerIds)
                    ->get(['o.id','store_id','offer_name','offer_discount_value','start_date','end_date', DB::raw('concat("http://", s.url_key, ".' . $offerImagePath . '", offer_image) as offer_image')]);
                //dd(DB::getQueryLog()); // Show results of log
                if(count($productWiseOffersResult) > 0)
                {
                    return response()->json(["status" => 1, 'data' => $productWiseOffersResult]);
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
    }//getProductWiseOffer function ends here

    public function getAllOffer()
    {
        //DB::enableQueryLog(); // Enable query log
        if(!empty(Session::get("merchantId"))) 
        {
            $merchantId = Session::get("merchantId");
            $getDitributorIdsResult = $this->getMerchantWiseDistributorId($merchantId);
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
                ->where('stores.store_type', 'distributor')
                ->where('stores.expiry_date', '>=', date('Y-m-d'))
                ->where('products.status', 1)
                ->get(['products.brand_id', 'products.store_id']);

               if (count($brandIdsResult) > 0) 
               {
                   $brandIds = [];
                   $storeId = [];
                   foreach ($brandIdsResult as $brandIdsData) {
                       $brandIds[] = $brandIdsData->brand_id;
                       $storeIds[] = $brandIdsData->store_id;
                   }
                   $getProductsResult = DB::table('products')
                    ->join('offers_products', 'products.id', '=', 'offers_products.prod_id')
                    ->select(DB::raw('offer_id'))
                    ->whereIn('products.store_id', $storeIds)
                    ->where('products.status', 1)
                    ->where('offers_products.type', 1) //type = 1 (1 means main_prod type in offers_products tbl)
                    ->groupBy('offers_products.offer_id')
                    ->get();

                    //dd(DB::getQueryLog()); // Show results of log
                    if(count($getProductsResult) > 0)
                    {
                        //echo "<pre>";
                        //print_r($getProductsResult);
                        $multipleOfferId = [];
                        foreach($getProductsResult as $getOfferData)
                        {
                            $multipleOfferId[] = $getOfferData->offer_id;
                        }
                        //echo "<pre> multiple offers id::";
                        //print_r($multipleOfferId);
                        //get All offers
                        
                        $offerImagePath = $_SERVER['HTTP_HOST'] . '/public/Admin/uploads/offers/';
                        if(!empty($pageNumber) && (!empty($limit)))
                        {
                                //echo "inside if";
                            if($pageNumber == 1)
                            {
                                $limit = $pageNumber;
                                $startIndex = 0;
                            }
                            else
                            {
                                $limit = $limit;
                                $startIndex = ( (($pageNumber * $limit) - $limit) ); // -1
                            }
                            //echo "start index".$startIndex;
                            //echo "page limit::".$limit;
                            $getAllOffersResult = DB::table('offers as o')
                            ->join('stores as s', 's.id', '=', 'o.store_id')
                            ->whereIn('o.id', $multipleOfferId)
                            ->where('o.status', 1)
                            ->orderBy('o.id','DESC')
                            ->skip($startIndex)->take($limit)->get(['o.id','store_id','offer_name','offer_discount_value','start_date','end_date', DB::raw('concat("http://", s.url_key, ".' . $offerImagePath . '", offer_image) as offer_image')]);
                                
                        }
                        else
                        {
                            //echo "else";
                            $getAllOffersResult = DB::table('offers as o')
                            ->join('stores as s', 's.id', '=', 'o.store_id')
                            ->whereIn('o.id', $multipleOfferId)
                            ->where('o.status', 1)
                            ->orderBy('o.id','DESC')
                            ->get(['o.id as offer_id','store_id', 'type', 'offer_type', 'offer_discount_type', 'offer_name','offer_discount_value','start_date','end_date', 'offer_image as offer_img', DB::raw('concat("http://", s.url_key, ".' . $offerImagePath . '", offer_image) as offer_image')]); 
                        }    

                        if(count($getAllOffersResult) > 0)
                        {
                            foreach($getAllOffersResult as $getOfferData)
                            {
                                $offerPrice = 0;
                                $actualPrice = 0;
                                $offPrice = 0;
                                $offerProducts = DB::table('offers_products')->where('offer_id', $getOfferData->offer_id)->where('type', 1)->get();
                                foreach($offerProducts as $offerProductKey => $offerProduct){
                                    $offPrice = 0;
                                    $product = DB::table('products')->where('id', $offerProduct->prod_id)->first(['price']);
                                    if($product != null){
                                    $offPrice = ($offerProduct->qty * $product->price);
                                    $actualPrice+=$offPrice;
                                    $offerPrice+=$offPrice;
                                    }
                                }
                                if($getOfferData->type == 1) {
                                    if($getOfferData->offer_discount_type==1) { //For percent off
                                        $offerPrice = $offPrice - ($offPrice * ($getOfferData->offer_discount_value/100));
                                    } else { //For fixed off
                                        $offerPrice = $offPrice - $getOfferData->offer_discount_value;
                                    }
                                } else {}
                                $getOfferData->offerPrice = $offerPrice;
                                $getOfferData->actualPrice = $actualPrice;
                                $getOfferData->offer_image = ($getOfferData->offer_img != '')? $getOfferData->offer_image: 'http://'.$_SERVER['HTTP_HOST'] . '/public/Admin/uploads/company/default-company.jpg';
                            }
                        }

                        //echo "<pre>";
                        //print_r($storeIds);
                        //exit;
                        $getCategoriesResult = DB::table('store_categories')
                        ->join('categories', 'store_categories.category_id', '=', 'categories.id')
                        ->whereIn('store_categories.store_id', $storeIds)
                        ->where('store_categories.status', 1)
                        ->groupBy('store_categories.category_id')
                        ->orderBy('categories.category','asc')
                        ->get(['store_categories.id','store_categories.category_id', 'categories.category', 'categories.short_desc','categories.long_desc','categories.images','categories.is_home','categories.is_nav','categories.url_key']);
                        
                        $categoryArray = [];
                        array_push($categoryArray, ['category_id' => 0, 'category_name' => 'All', 'offers' => $getAllOffersResult]);
                        if(count($getCategoriesResult) > 0)
                        {
                            $i=1;
                            foreach($getCategoriesResult as $getCategoryData)
                            {
                                $categoryId = $getCategoryData->id;
                                $categoryName = $getCategoryData->category;
                                $categoryShortDesc = $getCategoryData->short_desc;
                                $categoryLongDesc = $getCategoryData->long_desc;
                                $categoryImages = $getCategoryData->images;
                                $categoryIsHome = $getCategoryData->is_home;
                                $categoryIsNav = $getCategoryData->is_nav;
                                $categoryUrlKey = $getCategoryData->url_key;

                                $categoryArray[$i]['category_id'] = $categoryId;
                                $categoryArray[$i]['category_name'] = $categoryName;
                                $categoryArray[$i]['short_desc'] = $categoryShortDesc;
                                $categoryArray[$i]['long_desc'] = $categoryLongDesc;
                                $categoryArray[$i]['image'] = $categoryImages;
                                $categoryArray[$i]['is_home'] = $categoryIsHome;
                                $categoryArray[$i]['is_nav'] = $categoryIsNav;
                                $categoryArray[$i]['url_key'] = $categoryUrlKey;

                                //check category id present in has_categories table
                                $getHasCategoryResult = DB::table('has_categories')
                                ->select(DB::raw('prod_id'))
                                ->where('cat_id', $categoryId)
                                ->get();

                                if(count($getHasCategoryResult) > 0)
                                {   //get product id
                                    $prodIds = [];
                                    foreach($getHasCategoryResult as $prodID){
                                        $prodIds[] = $prodID->prod_id;
                                    }
                                    foreach($getHasCategoryResult as $getProdData)
                                    {
                                        $offerImagePath = $_SERVER['HTTP_HOST'] . '/public/Admin/uploads/offers/';
                                        $productId = $getProdData->prod_id;
                                        //get category product wise offers
                                        $getoffersResult = DB::table('offers_products')
                                        ->join('offers', 'offers_products.offer_id', '=', 'offers.id')
                                        ->join('stores', 'stores.id', '=', 'offers.store_id')
                                        ->whereIn('offers_products.prod_id', $prodIds)
                                        ->where('offers_products.type', 1)
                                        ->where('offers.status', 1)
                                        ->get(['offers.id', 'offers.offer_name', 'offers.type', 'offers.store_id', 'offers.offer_discount_type','offers.offer_type','offers.start_date','offers.end_date','offers.offer_discount_value', 'offers.offer_image as offer_img', DB::raw('concat("http://", stores.url_key, ".' . $offerImagePath . '", offers.offer_image) as offer_image')]);
                                        //echo "<pre> offers data::";
                                        // print_r($getoffersResult);                                    
                                        $j=0;
                                        
                                        foreach($getoffersResult as $getOfferData)
                                        {
                                            $categoryArray[$i]['offers'][$j]['offer_id'] = $getOfferData->id;
                                            $categoryArray[$i]['offers'][$j]['start_date'] = $getOfferData->start_date;
                                            $categoryArray[$i]['offers'][$j]['end_date'] = $getOfferData->end_date;
                                            $categoryArray[$i]['offers'][$j]['store_id'] = $getOfferData->store_id;
                                            $categoryArray[$i]['offers'][$j]['offer_name'] = $getOfferData->offer_name;
                                            $categoryArray[$i]['offers'][$j]['offer_image'] = ($getOfferData->offer_img != '')? $getOfferData->offer_image: 'http://'.$_SERVER['HTTP_HOST'] . '/public/Admin/uploads/company/default-company.jpg';
                                            $categoryArray[$i]['offers'][$j]['type'] = $getOfferData->type;
                                            $categoryArray[$i]['offers'][$j]['offer_discount_type'] = $getOfferData->offer_discount_type;
                                            $categoryArray[$i]['offers'][$j]['offer_type'] = $getOfferData->offer_type;
                                            $categoryArray[$i]['offers'][$j]['offer_discount_value'] = $getOfferData->offer_discount_value;
                                            
                                            $offerPrice = 0;
                                            $actualPrice = 0;
                                            $offPrice = 0;
                                            $offerProducts = DB::table('offers_products')->where('offer_id', $getOfferData->id)->where('type', 1)->get();
                                            foreach($offerProducts as $offerProductKey => $offerProduct){
                                                $offPrice = 0;
                                                $product = DB::table('products')->where('id', $offerProduct->prod_id)->first(['price']);
                                                if($product != null){
                                                $offPrice = ($offerProduct->qty * $product->price);
                                                $actualPrice+=$offPrice;
                                                $offerPrice+=$offPrice;
                                                }
                                            }
                                            if($getOfferData->type == 1) {
                                                if($getOfferData->offer_discount_type==1) { //For percent off
                                                    $offerPrice = $offPrice - ($offPrice * ($getOfferData->offer_discount_value/100));
                                                } else { //For fixed off
                                                    $offerPrice = $offPrice - $getOfferData->offer_discount_value;
                                                }
                                            } else {

                                            }
                                            $getOfferData->offerPrice = $offerPrice;
                                            $getOfferData->actualPrice = $actualPrice;                                        
                                            $categoryArray[$i]['offers'][$j]['offerPrice'] = $offerPrice;                                        
                                            $categoryArray[$i]['offers'][$j]['actualPrice'] = $actualPrice;
                                            $j++;
                                        }
                                        
                                    }//foreach ends here                                
                                }                           
                                $i++;
                            }//category foreach ends here
                            
                            //echo "<pre>category wise offers::";
                            //print_r($categoryArray);
                            // return response()->json(["status" => 1, 'msg' => '', 'data' => ['all_offers' => $getAllOffersResult, 'categorywise_offers' =>$categoryArray]]);
                            return response()->json(["status" => 1, 'msg' => '', 'data' => $categoryArray]);
                        } else {
                            // return response()->json(["status" => 1, 'msg' => '', 'data' => ['all_offers' => $getAllOffersResult, 'categorywise_offers' => $categoryArray]]);
                            return response()->json(["status" => 1, 'msg' => '', 'data' => $categoryArray]);
                        }
                    }
                    else
                    {
                        return response()->json(["status" => 0, 'msg' => 'No Offers Found.']);
                    }
                }
                else
                {
                    return response()->json(["status" => 0, 'msg' => 'No Offers Found..']);
                }
            }
            else
            {
                return response()->json(["status" => 0, 'msg' => 'Mandatory fields are missing.']);
            }
        }
        else
        {
            return response()->json(["status" => 0, 'msg' => 'Mandatory fields are missing.']);
        }
    }

    public function getCategoryWiseOffer()
    {
        //DB::enableQueryLog(); // Enable query log
        if(!empty(Input::get("merchantId"))) 
        {
            $merchantId = Input::get("merchantId");
            $getDitributorIdsResult = $this->getMerchantWiseDistributorId($merchantId);
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
                ->where('stores.store_type', 'distributor')
                ->where('stores.expiry_date', '>=', date('Y-m-d'))
                ->where('products.status', 1)
                ->get(['products.brand_id', 'products.store_id']);

               if (count($brandIdsResult) > 0) 
               {
                   $brandIds = [];
                   $storeId = [];
                   foreach ($brandIdsResult as $brandIdsData) {
                       $brandIds[] = $brandIdsData->brand_id;
                       $storeIds[] = $brandIdsData->store_id;
                   }
                   $getProductsResult = DB::table('products')
                    ->join('offers_products', 'products.id', '=', 'offers_products.prod_id')
                    ->select(DB::raw('offer_id'))
                    ->whereIn('products.store_id', $storeIds)
                    ->where('products.status', 1)
                    ->where('offers_products.type', 1) //type = 1 (1 means main_prod type in offers_products tbl)
                    ->groupBy('offers_products.offer_id')
                    ->get();

                    //dd(DB::getQueryLog()); // Show results of log
                    if(count($getProductsResult) > 0)
                    {
                        //echo "<pre>";
                        //print_r($getProductsResult);
                        //echo "<pre>";
                        //print_r($storeIds);
                        //exit;
                        $offerImagePath = $_SERVER['HTTP_HOST'] . '/public/Admin/uploads/offers/';
                        $getCategoriesResult = DB::table('store_categories')
                        ->join('categories', 'store_categories.category_id', '=', 'categories.id')
                        ->whereIn('store_categories.store_id', $storeIds)
                        ->where('store_categories.status', 1)
                        ->get(['store_categories.id', 'categories.category', 'categories.short_desc','categories.long_desc','categories.images','categories.is_home','categories.is_nav','categories.url_key']);
                        //dd(DB::getQueryLog()); // Show results of log
                        //echo "<pre>";
                        //print_r($getCategoriesResult);
                        //exit;
                        $categoryArray = array();
                        if(count($getCategoriesResult) > 0)
                        {
                            $i=0;
                            foreach($getCategoriesResult as $getCategoryData)
                            {
                                $categoryId = $getCategoryData->id;
                                $categoryName = $getCategoryData->category;
                                $categoryShortDesc = $getCategoryData->short_desc;
                                $categoryLongDesc = $getCategoryData->long_desc;
                                $categoryImages = $getCategoryData->images;
                                $categoryIsHome = $getCategoryData->is_home;
                                $categoryIsNav = $getCategoryData->is_nav;
                                $categoryUrlKey = $getCategoryData->url_key;

                                $categoryArray[$i]['category_id'] = $categoryId;
                                $categoryArray[$i]['category_name'] = $categoryName;
                                $categoryArray[$i]['short_desc'] = $categoryShortDesc;
                                $categoryArray[$i]['long_desc'] = $categoryLongDesc;
                                $categoryArray[$i]['image'] = $categoryImages;
                                $categoryArray[$i]['is_home'] = $categoryIsHome;
                                $categoryArray[$i]['is_nav'] = $categoryIsNav;
                                $categoryArray[$i]['url_key'] = $categoryUrlKey;

                                //check category id present in has_categories table
                                $getHasCategoryResult = DB::table('has_categories')
                                ->join('store_categories', 'store_categories.category_id', '=', 'has_categories.cat_id')
                                ->select(DB::raw('prod_id'))
                                ->where('cat_id', $categoryId)
                                ->whereIn('store_id', $storeIds)
                                ->get();
                                //echo "<pre> product id::";
                                // dd($getHasCategoryResult);
                                if(count($getHasCategoryResult) > 0)
                                {   
                                    //All Product ids of this Category
                                    
                                    //get product id                                    
                                    foreach($getHasCategoryResult as $getProdData)
                                    {                                        
                                        $productId = $getProdData->prod_id;
                                        //echo "<br> prod id::".$productId;
                                        //get category product wise offers
                                        $getoffersResult = DB::table('offers_products')
                                        ->join('offers', 'offers_products.offer_id', '=', 'offers.id')
                                        ->join('stores', 'stores.id', '=', 'offers.store_id')
                                        ->where('offers_products.prod_id', $productId)
                                        ->where('offers_products.type', 1)
                                        ->where('offers.status', 1)
                                        ->get(['offers.id', 'offers.offer_name', 'offers.type','offers.offer_discount_type','offers.offer_type','offers.offer_discount_value',DB::raw('concat("http://", stores.url_key, ".' . $offerImagePath . '", offers.offer_image) as offer_image')]);
                                        //echo "<pre> offers data::";
                                        // print_r($getoffersResult);
                                        if(count($getoffersResult) > 0) {                              
                                            $j=0;
                                            foreach($getoffersResult as $getOfferData)
                                            {
                                                $categoryArray[$i]['offers'][$j]['offer_id'] = $getOfferData->id;
                                                $categoryArray[$i]['offers'][$j]['offer_name'] = $getOfferData->offer_name;
                                                $categoryArray[$i]['offers'][$j]['offer_image'] = 'http://'.$getOfferData->offer_image;
                                                $categoryArray[$i]['offers'][$j]['type'] = $getOfferData->type;
                                                $categoryArray[$i]['offers'][$j]['offer_discount_type'] = $getOfferData->offer_discount_type;
                                                $categoryArray[$i]['offers'][$j]['offer_type'] = $getOfferData->offer_type;
                                                $categoryArray[$i]['offers'][$j]['offer_discount_value'] = $getOfferData->offer_discount_value;
                                                
                                                // $categoryArray[$i]['offers'][$j]['min_order_amt'] = $getOfferData->min_order_amt;
                                                // $categoryArray[$i]['offers'][$j]['max_discount_amt'] = $getOfferData->max_discount_amt;
                                                $offerPrice = 0;
                                                $actualPrice = 0;
                                                $offPrice = 0;
                                                $offerProducts = DB::table('offers_products')->where('offer_id', $getOfferData->id)->where('type', 1)->get();
                                                foreach($offerProducts as $offerProductKey => $offerProduct){
                                                    $offPrice = 0;
                                                    $product = DB::table('products')->where('id', $offerProduct->prod_id)->first(['price']);
                                                    if($product != null){
                                                    $offPrice = ($offerProduct->qty * $product->price);
                                                    $actualPrice+=$offPrice;
                                                    $offerPrice+=$offPrice;
                                                    }
                                                }
                                                if($getOfferData->type == 1) {
                                                    if($getOfferData->offer_discount_type==1) { //For percent off
                                                        $offerPrice = $offPrice - ($offPrice * ($getOfferData->offer_discount_value/100));
                                                    } else { //For fixed off
                                                        $offerPrice = $offPrice - $getOfferData->offer_discount_value;
                                                    }
                                                } else {

                                                }
                                                $getOfferData->offerPrice = $offerPrice;
                                                $getOfferData->actualPrice = $actualPrice;                                        
                                                $categoryArray[$i]['offers'][$j]['offerPrice'] = $offerPrice;                                        
                                                $categoryArray[$i]['offers'][$j]['actualPrice'] = $actualPrice;
                                                $j++;
                                            }
                                        } else {
                                            $categoryArray[$i]['offers'] = [];
                                        }
                                        
                                    }//foreach ends here                                
                                }                           
                                $i++;
                            }//category foreach ends here
                            
                            //echo "<pre>category wise offers::";
                        //print_r($categoryArray);
                            return response()->json(["status" => 1, 'msg' => '', 'data' => $categoryArray]);
                        } else {
                            return response()->json(["status" => 1, 'msg' => '', 'data' => $categoryArray]);
                        }
                    }
                    else
                    {
                        return response()->json(["status" => 1, 'msg' => 'Records not found']);
                    }
                }
                else
                {
                    return response()->json(["status" => 0, 'msg' => 'Mandatory fields are missing.']);
                }
            }
            else
            {
                return response()->json(["status" => 1, 'msg' => 'Records not found']);
            }
        }
        else
        {
            return response()->json(["status" => 0, 'msg' => 'Mandatory fields are missing.']);
        }

    }
    public function getMerchantWiseDistributorId($merchantId)
    {
         //check merchant id is present in has_distributors table
         $getDitributorIdsResult = DB::table('has_distributors')
         ->select(DB::raw('distributor_id'))
         ->where('merchant_id', $merchantId)
         ->where('is_deleted', 0)
         ->get();

         return $getDitributorIdsResult;
    }

    
}
