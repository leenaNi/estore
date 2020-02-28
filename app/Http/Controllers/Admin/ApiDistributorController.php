<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Library\CustomValidator;
use App\Models\User;
use Config;
use DB;
use Input;
use Session;

class ApiDistributorController extends Controller
{
    public function searchProductWithDistributor()
    {
        if (!empty(Input::get("merchantId"))) {
            $searchKeyWord = Input::get("searchKey");
            $merchantId = Input::get("merchantId");

            $storeIdsResult = $this->getStoreId($merchantId);
            
            $storeIdArray = [];
            $storeIdWithDistributorId = array();
            $i = 0;
            foreach ($storeIdsResult as $storeIdsData) {
                $storeIdArray[] = $storeIdsData->id;
                //$storeIdWithDistributorId[$storeIdsData->id]['merchant_id'] = $storeIdsData->merchant_id;
                //$storeIdWithDistributorId[$storeIdsData->id]['store_name'] = $storeIdsData->store_name;

                $storeIdWithDistributorId[$i]['store_id'] = $storeIdsData->id;
                $storeIdWithDistributorId[$i]['store_name'] = $storeIdsData->store_name;

                //get store wise products
                $productResult = DB::table('products as p')
                    ->join('brand as b', 'p.brand_id', '=', 'b.id')
                    ->whereIn('p.store_id', $storeIdArray)
                    ->where(['p.status' => 1, 'p.is_del' => 0])
                    ->where('p.product', 'LIKE', '%' . $searchKeyWord . '%')
                    ->orderBy('p.store_id', 'ASC')
                    ->get(['p.id', 'p.store_id', 'b.id as brand_id', 'b.name as brand_name', 'p.product', 'p.images', 'p.product_code', 'p.is_featured', 'p.prod_type', 'p.is_stock', 'p.is_avail', 'p.is_listing', 'p.status', 'p.stock', 'p.max_price', 'p.min_price', 'p.purchase_price', 'p.price', 'p.spl_price', 'p.selling_price', 'p.is_cod', 'p.is_tax', 'p.is_trending', 'p.min_order_quantity', 'p.is_share_on_mall', 'p.store_id']);
                //echo "<pre>";print_r($productResult);exit;
                $j = 0;
                $totalOfferOfAllProduct = 0;

                foreach ($productResult as $getProductData) {
                    $storeId = $getProductData->store_id;
                    $productId = $getProductData->id;

                    //Get Product image
                    $productResult = DB::table('catalog_images')
                        ->select(DB::raw('filename'))
                        ->where(['catalog_id' => $productId])
                        ->get();
                    $productImage = '';
                    //echo "<pre>";
                    //print_r($productResult);
                    //exit;
                    if (count($productResult) > 0) {
                        $productImage = "http://" . $storeIdsData->url_key . "." . $_SERVER['HTTP_HOST'] . "/uploads/catalog/products/" . $productResult[0]->filename;
                    }
                    //echo "product image::http://" .$_SERVER['HTTP_HOST'].'/uploads/catalog/products/'.$productImage;

                    $storeIdWithDistributorId[$i]['products'][$j]['product_id'] = $getProductData->id;
                    $storeIdWithDistributorId[$i]['products'][$j]['brand_id'] = $getProductData->brand_id;
                    $storeIdWithDistributorId[$i]['products'][$j]['brand_name'] = $getProductData->brand_name;
                    $storeIdWithDistributorId[$i]['products'][$j]['product'] = $getProductData->product;
                    $storeIdWithDistributorId[$i]['products'][$j]['images'] = $productImage;
                    $storeIdWithDistributorId[$i]['products'][$j]['product_code'] = $getProductData->product_code;
                    $storeIdWithDistributorId[$i]['products'][$j]['is_featured'] = $getProductData->is_featured;
                    $storeIdWithDistributorId[$i]['products'][$j]['prod_type'] = $getProductData->prod_type;
                    $storeIdWithDistributorId[$i]['products'][$j]['is_stock'] = $getProductData->is_stock;
                    $storeIdWithDistributorId[$i]['products'][$j]['is_avail'] = $getProductData->is_avail;
                    $storeIdWithDistributorId[$i]['products'][$j]['is_listing'] = $getProductData->is_listing;
                    $storeIdWithDistributorId[$i]['products'][$j]['status'] = $getProductData->status;
                    $storeIdWithDistributorId[$i]['products'][$j]['stock'] = $getProductData->stock;
                    $storeIdWithDistributorId[$i]['products'][$j]['max_price'] = $getProductData->max_price;
                    $storeIdWithDistributorId[$i]['products'][$j]['min_price'] = $getProductData->min_price;
                    $storeIdWithDistributorId[$i]['products'][$j]['purchase_price'] = $getProductData->purchase_price;
                    $storeIdWithDistributorId[$i]['products'][$j]['price'] = $getProductData->price;
                    $storeIdWithDistributorId[$i]['products'][$j]['spl_price'] = $getProductData->spl_price;
                    $storeIdWithDistributorId[$i]['products'][$j]['selling_price'] = $getProductData->selling_price;
                    $storeIdWithDistributorId[$i]['products'][$j]['is_cod'] = $getProductData->is_cod;
                    $storeIdWithDistributorId[$i]['products'][$j]['is_tax'] = $getProductData->is_tax;
                    $storeIdWithDistributorId[$i]['products'][$j]['is_trending'] = $getProductData->is_trending;
                    $storeIdWithDistributorId[$i]['products'][$j]['min_order_quantity'] = $getProductData->min_order_quantity;
                    $storeIdWithDistributorId[$i]['products'][$j]['is_share_on_mall'] = $getProductData->is_share_on_mall;

                    //get offers count
                    $offersIdCountResult = DB::table('offers')
                        ->join('offers_products', 'offers.id', '=', 'offers_products.offer_id')
                        ->select(DB::raw('count(offers.id) as offer_count'))
                    //->where('offers.store_id',$storeId)
                    //->where('offers.status',1)
                        ->where('offers_products.prod_id', $productId)
                        ->where('offers_products.type', 1)
                        ->groupBy('offers_products.offer_id')
                        ->get();

                    $offerCount = 0;
                    if (count($offersIdCountResult) > 0) {
                        $offerCount = $offersIdCountResult[0]->offer_count;
                        $totalOfferOfAllProduct = $totalOfferOfAllProduct + $offerCount;
                    }
                    
                    $storeIdWithDistributorId[$i]['products'][$j]['offers_count'] = $offerCount;
                    $j++;
                } //product foreach ends here
                $storeIdWithDistributorId[$i]['offer_count'] = $totalOfferOfAllProduct;
                $i++;
            } //store foreach ends here

          
            if (count($storeIdWithDistributorId) > 0) {
                return response()->json(["status" => 1, 'data' => $storeIdWithDistributorId]);
            } else {
                return response()->json(["status" => 1, 'msg' => 'Product not found']);
            }
        } else {
            return response()->json(["status" => 0, 'msg' => 'Mandatory fields are missing.']);
        }
    } // End searchProductWithDistributor

    public function getDistributorByProduct()
    {
        if (!empty(Input::get("merchantId"))) {
            $searchKeyWord = Input::get("searchKey");
            $merchantId = Input::get("merchantId");

            $storeIdsResult = $this->getStoreId($merchantId);

            $storeIdArray = [];
            foreach ($storeIdsResult as $storeIdsData) {
                $storeIdArray[] = $storeIdsData->id;
            }
            //echo "<pre>";print_r($storeIdArray);exit;
            $productResult = DB::table('products as p')
                ->join('stores as s', 'p.store_id', '=', 's.id')
                ->whereIn('p.store_id', $storeIdArray)
                ->where(['p.status' => 1, 'p.is_del' => 0])
                ->where('p.product', 'LIKE', '%' . $searchKeyWord . '%')
                ->groupBy('p.store_id')
                ->get(['s.id', 'p.store_id', 's.store_name']);

            //echo "<pre>";
            //print_r($productResult);
            if (count($productResult) > 0) {
                $storeArray = [];
                $i = 0;
                foreach ($productResult as $getData) {
                    $companies = DB::table("products as p")->join("brand as b", "b.id", "=", "p.brand_id")->join("company as c", "c.id", "=", "b.company_id")->select("b.id", "b.company_id", "c.name")->where("p.store_id", $getData->store_id)->where("p.brand_id", "<>", 0)->get();
                    $companyArr = [];
                    foreach ($companies as $company) {
                        if (!in_array($company->name, $companyArr)) {
                            array_push($companyArr, $company->name);
                        }

                    }

                    $storeArray[$i]['store_id'] = $getData->store_id;
                    $storeArray[$i]['store_name'] = $getData->store_name;
                    $storeArray[$i]['companies'] = $companyArr;
                    //get offress count
                    $storeId = $getData->store_id;
                    $offersIdCountResult = DB::table('offers')
                        ->select(DB::raw('count(id) as offer_count'))
                        ->where('store_id', $storeId)
                        ->where('status', 1)
                        ->get();
                    $offerCount = 0;
                    if (count($offersIdCountResult) > 0) {
                        $offerCount = $offersIdCountResult[0]->offer_count;
                    }
                    $storeArray[$i]['offers_count'] = $offerCount;
                    $i++;
                }
                return response()->json(["status" => 1, 'data' => $storeArray]);
            } else {
                return response()->json(["status" => 1, 'msg' => 'Product not found']);
            }
        } else {
            return response()->json(["status" => 0, 'msg' => 'Mandatory fields are missing.']);
        }
    }

    public function getStoreId($merchantId)
    {
        $storeIdsResult = DB::table('has_distributors as hd')
            ->join('stores as s', 's.merchant_id', '=', 'hd.distributor_id')
            ->where('hd.merchant_id', $merchantId)
            ->where('s.store_type', 'distributor')->get(['s.id', 's.merchant_id', 's.store_name', 's.url_key']);
        return $storeIdsResult;
    }

    public function getProduct() // distributoe product

    {
        if (!empty(Input::get("distributorId"))) {
            $distributorId = Input::get("distributorId");

            // Get store id
            $storeResult = DB::table('stores')
                ->where('merchant_id', $distributorId)->where('store_type', 'distributor')
                ->get(['id']);
            if (count($storeResult) > 0) {
                $storeId = $storeResult[0]->id;

                // Get product
                $productResult = DB::table('products as p')
                    ->join('brand as b', 'p.brand_id', '=', 'b.id')
                    ->where('p.store_id', $storeId)
                    ->where('p.is_del', 0)
                    ->get(['p.id', 'b.name', 'p.product', 'p.images', 'p.product_code', 'is_featured', 'prod_type', 'is_stock', 'is_avail', 'is_listing', 'status', 'stock', 'max_price', 'min_price', 'purchase_price', 'price', 'spl_price', 'selling_price', 'is_cod', 'is_tax', 'is_trending', 'min_order_quantity', 'is_share_on_mall']);
                if (count($storeResult) > 0) {
                    //echo "<pre>";print_r($productResult);exit;
                    return response()->json(["status" => 1, 'msg' => '', 'data' => $productResult]);
                } else {
                    return response()->json(["status" => 0, 'msg' => 'Record not found']);
                }
            } else {
                return response()->json(["status" => 0, 'msg' => 'Record not found']);
            }
        } else {
            return response()->json(["status" => 0, 'msg' => 'Mandatory fields are missing.']);
        }

    } // End getProduct

    public function getDistributorByMerchant()
    {
        //DB::enableQueryLog(); // Enable query log
        if (!empty(Input::get("merchantId"))) {
            $searchKeyWord = Input::get("searchKey");
            $merchantId = Input::get("merchantId");
            //echo "merchant id::".$merchantId;
            //exit;
            //check merchant id is present in has_distributors table
            $getDitributorIdsResult = $this->getMerchantWiseDistributorId($merchantId);

            if (count($getDitributorIdsResult) > 0) {
                $multipleDistributorIds = [];
                foreach ($getDitributorIdsResult as $distributorIdsData) {
                    $multipleDistributorIds[] = $distributorIdsData->distributor_id;
                }

                //Get distributor id wise data
                $distributorResult = DB::table('distributor')
                    ->whereIn('id', $multipleDistributorIds)
                    ->where('business_name', 'LIKE', '%' . $searchKeyWord . '%')
                    ->get();
                //dd(DB::getQueryLog()); // Show results of log
                if (count($distributorResult) > 0) {
                    return response()->json(["status" => 1, 'data' => $distributorResult]);
                } else {
                    return response()->json(["status" => 0, 'msg' => 'Records not found']);
                }
            } else {
                return response()->json(["status" => 0, 'msg' => 'Records not found']);
            }

        } else {
            return response()->json(["status" => 0, 'msg' => 'Mandatory fields are missing.']);
        }

    } //function ends here

    public function getDistributorByCompany()
    {
        //DB::enableQueryLog(); // Enable query log
        if (!empty(Input::get("companyId"))) {
            $companyId = Input::get("companyId");

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

            //echo "<pre> Merchant wise ditributor::";
            //print_r($multipleDistributorIds);
            //exit;

            }*/

            //check company id is present in brand table
            $getBrandIdsResult = DB::table('brand')
                ->select(DB::raw('id'))
                ->where('company_id', $companyId)
                ->where('is_delete', 0)
                ->get();

            if (count($getBrandIdsResult) > 0) {
                $multipleBrandIds = [];
                foreach ($getBrandIdsResult as $brandIdsData) {
                    $multipleBrandIds[] = $brandIdsData->id;
                }
                //echo "<pre>multiple brand id::";
                //print_r($multipleBrandIds);

                //check brand id in product table and get store_id
                $storeIdsResult = DB::table('products')
                    ->select(DB::raw('store_id'))
                    ->whereIn('brand_id', $multipleBrandIds)
                    ->where('status', 1)
                    ->where('is_del', 0)
                    ->get();
                if (count($storeIdsResult) > 0) {
                    //echo "inside if";
                    $multipleStoreIds = [];
                    foreach ($storeIdsResult as $storeIdsData) {
                        $multipleStoreIds[] = $storeIdsData->store_id;
                    }
                    //echo "<pre> Multiple store id::";
                    //print_r($multipleStoreIds);

                    //get distributor id from the store table
                    $distributorIdsResult = DB::table('stores')
                        ->select('id', DB::raw('merchant_id'))
                        ->whereIn('id', $multipleStoreIds)
                        ->where('store_type', 'distributor')
                        ->where('expiry_date', '>=', date('Y-m-d'))
                        ->get();

                    if (count($distributorIdsResult) > 0) {
                        $multipleDistributorIds = [];
                        $storesIdArray = [];
                        foreach ($distributorIdsResult as $distributorIdsData) {
                            $storesIdArray[$distributorIdsData->merchant_id] = $distributorIdsData->id;
                            $multipleDistributorIds[] = $distributorIdsData->merchant_id;
                        }
                        //echo "<pre> Multiple distributor id::";
                        //print_r($multipleDistributorIds);
                        //exit;
                        //Get distributor id wise data
                        $companyWiseDistributorResult = DB::table('distributor as d')
                            ->join('stores as s', 's.merchant_id', '=', 'd.id')
                            ->where('s.store_type', 'distributor')
                            ->whereIn('d.id', $multipleDistributorIds)
                            ->get(['d.id', 'd.phone_no', 's.id as storeId', 's.store_name']);
                        //dd(DB::getQueryLog()); // Show results of log
                        if (count($companyWiseDistributorResult) > 0) {
                            $finalDistributorArray = array();
                            $i = 0;
                            //echo "<pre> company wise All distributor::";
                            //print_r($companyWiseDistributorResult);
                            foreach ($companyWiseDistributorResult as $getData) {

                                $companyWiseDistributorIds = $getData->id;
                                // $distributorRegisterDetails = $getData->register_details;

                                if (in_array($companyWiseDistributorIds, $multipleDistributorIds)) {
                                    $storeId = $storesIdArray[$companyWiseDistributorIds];
                                    $offersIdCountResult = DB::table('offers')
                                        ->select(DB::raw('count(id) as offer_count'))
                                        ->where('store_id', $storeId)
                                        ->where('status', 1)
                                        ->get();
                                    $offerCount = 0;
                                    if (count($offersIdCountResult) > 0) {
                                        $offerCount = $offersIdCountResult[0]->offer_count;
                                    }

                                    $finalDistributorArray[$i]['distributor_id'] = $companyWiseDistributorIds;
                                    // $finalDistributorArray[$i]['register_details'] = $distributorRegisterDetails;
                                    $finalDistributorArray[$i]['phone_no'] = $getData->phone_no;
                                    $finalDistributorArray[$i]['store_id'] = $getData->storeId;
                                    $finalDistributorArray[$i]['store_name'] = $getData->store_name;
                                    $finalDistributorArray[$i]['offer_count'] = $offerCount;

                                    $i++;
                                }
                            } //foreach ends here
                            //echo "<pre> comapny wise all dist id::";
                            // print_r($finalDistributorArray);
                            return response()->json(["status" => 1, 'data' => $finalDistributorArray]);
                        } else {
                            return response()->json(["status" => 0, 'msg' => 'Records not found']);
                        }

                    } else {
                        return response()->json(["status" => 0, 'msg' => 'Records not found']);
                    }

                } else {
                    return response()->json(["status" => 0, 'msg' => 'Records not found']);
                }

            } else {
                return response()->json(["status" => 0, 'msg' => 'Records not found']);
            }

        } else {
            return response()->json(["status" => 0, 'msg' => 'Mandatory fields are missing.']);
        }
    } //function ends here

    public function getDistributorOfferDetails()
    {
        if (!empty(Input::get("merchantId"))) {
            $merchantId = Input::get("merchantId");
            $distributorId = Input::get("distributorId");
            $companyId = Input::get("companyId");
            $getDitributorIdsResult = $this->getMerchantWiseDistributorId($merchantId);
            // dd($getDitributorIdsResult);
            if (count($getDitributorIdsResult) > 0) {
                // $multipleDistributorIds = [];
                // foreach ($getDitributorIdsResult as $distributorIdsData)
                // {
                //     $multipleDistributorIds[] = $distributorIdsData->distributor_id;
                // }
                $multipleDistributorIds[] = $distributorId;
                $storeIdResult = DB::table('stores')
                    ->whereIn('stores.merchant_id', $multipleDistributorIds)
                    ->where('stores.store_type', 'distributor')
                    ->where('stores.expiry_date', '>=', date('Y-m-d'))
                    ->get(['stores.id']);
                if (count($storeIdResult) > 0) {
                    if($companyId){
                        //Comapnywise Brands
                        $companyBrands = DB::table('brand')->where('company_id', $companyId)->get(['id']);
                        $companyBrandIds = [];
                        foreach ($companyBrands as $companyBrand) {
                            $companyBrandIds[] = $companyBrand->id;
                        }
                    }
                    $storeIdResult = DB::table('stores')
                        ->join('products', 'products.store_id', '=', 'stores.id')
                        ->whereIn('stores.merchant_id', $multipleDistributorIds);
                        if($companyId){
                        $storeIdResult = $storeIdResult->whereIn('products.brand_id', $companyBrandIds);
                        }
                        $storeIdResult  = $storeIdResult->where('stores.store_type', 'distributor')
                        ->get(['stores.id', 'stores.url_key']);
                    if (count($storeIdResult) > 0) {
                        //echo "<pre>";
                        //print_r($storeIdResult);
                        $multipleStoreIds = [];
                        foreach ($storeIdResult as $storeIdsData) {
                            $multipleStoreIds[] = $storeIdsData->id;
                        }
                        $urlKey = $storeIdResult[0]->url_key;
                        $offerImagePath = "http://" . $urlKey . '.' . $_SERVER['HTTP_HOST'] . '/public/Admin/uploads/offers/';

                        $offersResult = DB::table('offers')
                            ->whereIn('store_id', $multipleStoreIds)
                            ->where('status', 1)
                        // ->where('id', 38)
                            ->get(['id', 'offer_name', 'type', 'offer_type', 'offer_discount_type', 'offer_discount_value', 'preference', 'start_date', 'end_date', DB::raw('concat("' . $offerImagePath . '", offer_image) as offer_image')]);

                        if (count($offersResult) > 0) {
                            //echo "<pre>";
                            //print_r($offersResult);
                            foreach ($offersResult as $offerKey => $offerValue) {
                                $offerPrice = 0;
                                $actualPrice = 0;
                                $offPrice = 0;
                                $offerProducts = DB::table('offers_products')->where('offer_id', $offerValue->id)->where('type', 1)->get();
                                foreach ($offerProducts as $offerProductKey => $offerProduct) {
                                    $offPrice = 0;
                                    $product = DB::table('products')->where('id', $offerProduct->prod_id)->first(['price']);
                                    $offPrice = ($offerProduct->qty * $product->price);
                                    $actualPrice += $offPrice;
                                    $offerPrice += $offPrice;
                                }
                                if ($offerValue->type == 1) {
                                    if ($offerValue->offer_discount_type == 1) { //For percent off
                                        $offerPrice = $offPrice - ($offPrice * ($offerValue->offer_discount_value / 100));
                                    } else { //For fixed off
                                        $offerPrice = $offPrice - $offerValue->offer_discount_value;
                                    }
                                } else {

                                }
                                $offerValue->offerPrice = $offerPrice;
                                $offerValue->actualPrice = $actualPrice;
                            }
                            return response()->json(["status" => 1, 'msg' => "", 'data' => $offersResult]);
                        } else {
                            return response()->json(["status" => 1, 'msg' => 'Records not found']);
                        }
                    } else {
                        return response()->json(["status" => 1, 'msg' => 'Records not found']);
                    }
                } else {
                    return response()->json(["status" => 0, 'msg' => 'Mandatory fields are missing.']);
                }
            } else {
                return response()->json(["status" => 0, 'msg' => 'Invalid data']);
            }
        } else {
            return response()->json(["status" => 0, 'msg' => 'Mandatory fields are missing.']);
        }
    }

    public function getDistributorBrandDetails()
    {
        if (!empty(Input::get("merchantId"))) {
            $merchantId = Input::get("merchantId");
            $distributorId = Input::get("distributorId");
            $companyId = Input::get("companyId");
            if (CustomValidator::validateNumber($merchantId) && CustomValidator::validateNumber($distributorId) && CustomValidator::validateNumber($companyId)) {
                $multipleDistributorIds = [];
                if($distributorId){
                    $multipleDistributorIds[] = $distributorId;
                }else{
                    $getDitributorIdsResult = $this->getMerchantWiseDistributorId($merchantId);
                    if (count($getDitributorIdsResult) > 0) {
                        foreach ($getDitributorIdsResult as $distributorIdsData)
                        {
                            $multipleDistributorIds[] = $distributorIdsData->distributor_id;
                        }
                    }
                }
                    // get brand id
                $brandIds = [];
                if($companyId && !$distributorId){
                    //Comapnywise Brands
                    $companyBrands = DB::table('brand')->where('company_id', $companyId)->get(['id']);
                    $companyBrandIds = [];
                    foreach ($companyBrands as $companyBrand) {
                        $brandIds[] = $companyBrand->id;
                    }
                }else{
                    $brandIdsResult = DB::table('stores')
                        ->join('products', 'products.store_id', '=', 'stores.id')
                        ->whereIn('stores.merchant_id', $multipleDistributorIds)
                        ->where('stores.store_type', 'distributor')
                        ->where('stores.expiry_date', '>=', date('Y-m-d'))
                        ->get(['products.brand_id', 'products.store_id']);
                    
                    if (count($brandIdsResult) > 0) {
                        $storeId = [];
                        foreach ($brandIdsResult as $brandIdsData) {
                            $brandIds[] = $brandIdsData->brand_id;
                            $storeIds[] = $brandIdsData->store_id;
                        }
                    }
                }
                if (count($brandIds) > 0) {
                    $brandLogogPath = asset(Config('constants.brandImgPath')). "/";
                    $getBrandResult = DB::table('brand')
                        ->join('products', 'brand.id', '=', 'products.brand_id')
                        ->whereIn('brand.id', $brandIds)->groupBy('brand.id')
                        ->where('is_delete', 0)
                        ->get(['brand.id as brand_id', 'brand.name as brand_name', DB::raw('concat("' . $brandLogogPath . '", brand.logo) as brand_logo'), 'brand.company_id', 'brand.industry_id']);

                    return response()->json(["status" => 1, 'msg' => "", 'result' => $getBrandResult]);
                }else {
                    return response()->json(["status" => 1, 'msg' => 'Records not found']);
                }
            } else {
                return response()->json(["status" => 0, 'msg' => 'Invalid data']);
            }
        } else {
            return response()->json(["status" => 0, 'msg' => 'Mandatory fields are missing.']);
        }
    }

    public function getBrandProducts(){
        $brandId = Input::get('brandId');
        if($brandId){
            if (CustomValidator::validateNumber($brandId)){
                $products = DB::table('products')->where('brand_id',$brandId)->get();
                if(count($products) > 0){
                    return response()->json(['status'=>1,'msg'=>'Product List','data'=>$products]);
                }else{
                    return response()->json(["status" => 1, 'msg' => 'Records not found']);
                }
            }else {
                return response()->json(["status" => 0, 'msg' => 'Invalid data']);
            }
        }else{
            return response()->json(["status" => 0, 'msg' => 'Mandatory fields are missing.']);
        }
    }

    public function getDistributorCategoryDetails()
    {
        if (!empty(Input::get("merchantId"))) {
            $merchantId = Input::get("merchantId");
            $distributorId = Input::get("distributorId");
            $companyId = Input::get("companyId");
            $getDitributorIdsResult = $this->getMerchantWiseDistributorId($merchantId);
            //echo "<pre>";
            //print_r($getDitributorIdsResult);
            //exit;
            if (count($getDitributorIdsResult) > 0) {
                // $multipleDistributorIds = [];
                // foreach ($getDitributorIdsResult as $distributorIdsData) {
                //     $multipleDistributorIds[] = $distributorIdsData->distributor_id;
                // }
                $multipleDistributorIds[] = $distributorId;
                if ($companyId) {
                    //Comapnywise Brands
                    $companyBrands = DB::table('brand')->where('company_id', $companyId)->get(['id']);
                    $companyBrandIds = [];
                    foreach ($companyBrands as $companyBrand) {
                        $companyBrandIds[] = $companyBrand->id;
                    }
                }
                if (count($multipleDistributorIds) > 0) {
                    // get brand id
                    $brandIdsResult = DB::table('stores')
                        ->join('products', 'products.store_id', '=', 'stores.id')
                        ->whereIn('stores.merchant_id', $multipleDistributorIds);
                    if ($companyId) {
                        $brandIdsResult = $brandIdsResult->whereIn('products.brand_id', $companyBrandIds);
                    }
                    $brandIdsResult = $brandIdsResult->where('stores.store_type', 'distributor')
                        ->where('stores.expiry_date', '>=', date('Y-m-d'))
                        ->get(['products.brand_id', 'products.store_id']);

                    if (count($brandIdsResult) > 0) {
                        $brandIds = [];
                        $storeId = [];
                        foreach ($brandIdsResult as $brandIdsData) {
                            $brandIds[] = $brandIdsData->brand_id;
                            $storeIds[] = $brandIdsData->store_id;
                        }
                        $getcategoryResult = DB::table('store_categories as sc')
                            ->join('categories as c', 'c.id', '=', 'sc.category_id')
                            ->join('stores as s', 's.id', '=', 'sc.store_id')
                            ->whereIn('sc.store_id', $storeIds)->where('s.store_type', 'distributor')
                            ->get(['sc.id', 'sc.url_key', 'sc.store_id', 'sc.short_desc', 'c.category', 's.url_key as storeUrl']);
                        //echo "<pre> brand result::";
                        //print_r($getcategoryResult);
                        $categoryArray = array();
                        if (count($getcategoryResult) > 0) {
                            $i = 0;
                            $categoryProductArray = array();
                            foreach ($getcategoryResult as $getCategoryData) {
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
                                if (count($getCategoryWiseProductsResult) > 0) {
                                    $j = 0;
                                    foreach ($getCategoryWiseProductsResult as $getProductData) {
                                
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
                                        $productSellingPrice = $getProductData->selling_price;

                                        $productResult = DB::table('catalog_images')
                                            ->select(DB::raw('filename'))
                                            ->where(['catalog_id' => $productId])
                                            ->where('image_type', 1)
                                            ->get();
                                        $productImage = '';
                                        //echo "<pre>";
                                        //print_r($productResult);
                                        //exit;
                                        if (count($productResult) > 0) {
                                            $productImage = "http://" . $getCategoryData->storeUrl . "." . $_SERVER['HTTP_HOST'] . "/uploads/catalog/products/" . $productResult[0]->filename;
                                        }

                                        $categoryArray[$i]['product'][$j]['product_id'] = $productId;
                                        $categoryArray[$i]['product'][$j]['product_brand_id'] = $productBrandId;
                                        $categoryArray[$i]['product'][$j]['product_name'] = $productName;
                                        $categoryArray[$i]['product'][$j]['product_code'] = $productCode;
                                        $categoryArray[$i]['product'][$j]['short_desc'] = $productShortDesc;
                                        $categoryArray[$i]['product'][$j]['long_desc'] = $productLongDesc;
                                        $categoryArray[$i]['product'][$j]['add_desc'] = $productAddDesc;
                                        $categoryArray[$i]['product'][$j]['is_featured'] = $productIsFeatured;
                                        $categoryArray[$i]['product'][$j]['product_image'] = $productImage;
                                        $categoryArray[$i]['product'][$j]['product_type'] = $productType;
                                        $categoryArray[$i]['product'][$j]['is_stock'] = $productIsStock;
                                        $categoryArray[$i]['product'][$j]['price'] = $productPrice;
                                        $categoryArray[$i]['product'][$j]['selling_price'] = $productSellingPrice;

                                        //get offers count
                                        $getOffersProductResult = DB::table('offers_products')
                                            ->select(DB::raw('count(offer_id) as offer_count'))
                                            ->where('prod_id', $productId)
                                            ->get();
                                        $offerCount = 0;
                                        if (count($getOffersProductResult) > 0) {
                                            foreach ($getOffersProductResult as $getCount) {
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
                        return response()->json(["status" => 1, 'msg' => "", 'data' => $categoryArray]);
                        //echo "<pre> Product array::";
                        //print_r($categoryArray);
                    } else {
                        return response()->json(["status" => 1, 'msg' => 'Records not found']);
                    }
                } else {
                    return response()->json(["status" => 1, 'msg' => 'Records not found']);
                }

            } else {
                return response()->json(["status" => 0, 'msg' => 'Invalid data']);
            }
        } else {
            return response()->json(["status" => 0, 'msg' => 'Mandatory fields are missing.']);
        }
    }

    public function getPastOrderDetails()
    {
        //DB::enableQueryLog(); // Enable query log
        if (!empty(Input::get("merchantId"))) {
            $merchantId = Input::get("merchantId");
            $distributorId = Input::get("distributorId");
            $user = User::where('id', Session::get('authUserId'))->first();
            $getDitributorIdsResult = $this->getMerchantWiseDistributorId($merchantId);
            //echo "<pre>";
            //print_r($getDitributorIdsResult);
            //exit;
            if (count($getDitributorIdsResult) > 0) {
                if (Input::get("distributorId")) {
                    $multipleDistributorIds = [];
                    foreach ($getDitributorIdsResult as $distributorIdsData) {
                        $multipleDistributorIds[] = $distributorIdsData->distributor_id;
                    }
                } else {
                    $multipleDistributorIds[] = $distributorId;
                }
                // get brand id
                $brandIdsResult = DB::table('stores')
                    ->join('products', 'products.store_id', '=', 'stores.id')
                    ->whereIn('stores.merchant_id', $multipleDistributorIds)
                    ->where('stores.store_type', 'distributor')
                    ->where('stores.expiry_date', '>=', date('Y-m-d'))
                    ->get(['products.brand_id', 'products.store_id', 'stores.url_key']);
                $productImgPath = "http://". $brandIdsResult[0]->url_key .'.'. $_SERVER['HTTP_HOST'] . "/uploads/catalog/products/";
                if (count($brandIdsResult) > 0) {
                    $brandIds = [];
                    $storeId = [];
                    foreach ($brandIdsResult as $brandIdsData) {
                        $brandIds[] = $brandIdsData->brand_id;
                        $storeIds[] = $brandIdsData->store_id;
                    }
                    if (count($storeIds) > 0) {
                        //echo "<pre>";
                        //print_r($storeIds);
                        //Get Users Id
                        $storeUsers = DB::table('users')
                            ->where('user_type', 1)
                            ->where('status', 1)
                            ->whereIn('store_id', [$user->store_id])
                            ->get(['id']);
                        $storeUserIds = [];
                        foreach ($storeUsers as $storeUserData) {
                            array_push($storeUserIds, $storeUserData->id);
                        }

                        //echo "<pre> user id::";
                        //print_r($storeUserIds);
                        //exit;
                        if (count($storeUserIds) > 0) {
                            //echo "inside if";
                            //Get Orders details
                            $orders = DB::table('orders')
                                ->where("orders.order_status", "!=", 0)
                                ->whereIn('user_id', $storeUserIds)
                                ->where('order_type', 1)
                                ->join("has_products", "has_products.order_id", '=', 'orders.id')
                                ->join("products", "has_products.prod_id", '=', 'products.id')
                                ->join("catalog_images", "catalog_images.catalog_id", '=', 'products.id')
                                ->where("catalog_images.image_type", 1)
                                ->whereIn("has_products.store_id", $storeIds)
                            //->select('orders.*', 'has_products.order_source', DB::raw('sum(has_products.pay_amt) as hasPayamt'))
                            //->select('orders.*')
                                // ->groupBy('has_products.order_id')
                                ->orderBy('orders.id', 'desc')
                                // ->get(['orders.*', 'has_products.order_source']);
                                ->get(['has_products.id', 'has_products.order_id', 'has_products.prod_id', 'has_products.sub_prod_id', 'has_products.qty', 'has_products.price', 'products.product', DB::raw('concat("' . $productImgPath. '", catalog_images.filename) as productImg')]);
                            //echo "<pre>";print_r($orders);exit;
                            //dd(DB::getQueryLog()); // Show results of log
                            if (count($orders) > 0) {
                                return response()->json(["status" => 1, 'msg' => '', 'data' => ['totalOrders' => count($orders),'orders' => $orders]]);
                            } else {
                                return response()->json(["status" => 0, 'msg' => 'Records not found']);
                            }

                        } else {
                            return response()->json(["status" => 0, 'msg' => 'Records not found']);
                        }

                    } else {
                        return response()->json(["status" => 0, 'msg' => 'Records not found']);
                    }
                } else {
                    return response()->json(["status" => 0, 'msg' => 'Records not found']);
                }

            } else {
                return response()->json(["status" => 0, 'msg' => 'Records not found']);
            }
        } else {
            return response()->json(["status" => 0, 'msg' => 'Mendatory fields are missing.']);
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

    public function getMyOrderDetails()
    {
        //DB::enableQueryLog(); // Enable query log
        if(!empty(Input::get("merchantId"))) 
        {
            $merchantId = Input::get("merchantId");
            //echo "merchant id::".$merchantId;

            //get merchant store id
            //DB::enableQueryLog(); // Enable query log
            $getStoreResult = DB::table('stores')
                    ->select(DB::raw('id'))
                    ->where('merchant_id', $merchantId)
                    ->where('store_type', 'merchant')
                    ->get();
                  //  dd(DB::getQueryLog()); // Show results of log
            if(count($getStoreResult) > 0)
            {
                $multipleMerchantStoreIds = [];
                foreach($getStoreResult as $getData)
                {
                    $multipleMerchantStoreIds[] = $getData->id;
                }
                //echo "<pre>";
                //print_r($multipleMerchantStoreIds);
                $myOrdersArray = array();
                if(count($multipleMerchantStoreIds) > 0)
                {
                    //check merchant store id in users table and get usersid
                    $getUsersResult = DB::table('users')
                    ->whereIn('store_id', $multipleMerchantStoreIds)
                    ->get(['id']);
                   // echo "<pre>";
                    //print_r($getUsersResult);
                    if(!empty($getUsersResult))
                    {
                        $i=0;
                        foreach($getUsersResult as $getUserData)
                        {
                            $userId = $getUserData->id;
                            //echo "user id::".$userId;
                            //get store_id from order table with the use of user_id
                            $getOrderResult = DB::table('orders')
                                        ->join('stores', 'orders.store_id', '=', 'stores.id')
                                        ->join('order_status', 'orders.order_status', '=', 'order_status.id')
                                        ->join('payment_status', 'orders.payment_status', '=', 'payment_status.id')
                                        ->where('orders.user_id', $userId)
                                        ->get(['orders.id', 'orders.user_id', 'orders.pay_amt','orders.store_id','orders.created_at','stores.store_name','order_status.order_status','payment_status.payment_status']);
                            //echo "<pre> orders data::";
                            //print_r($getOrderResult);

                           
                            foreach($getOrderResult as $getOrdersData)
                            {
                                $orderId = $getOrdersData->id;
                                $storeId = $getOrdersData->store_id;
                                $orderPaymentAmt = $getOrdersData->pay_amt;
                                $orderCreatedDate = $getOrdersData->created_at;
                                $orderStoreName = $getOrdersData->store_name;
                                $orderStatus = $getOrdersData->order_status;
                                $paymentStatus = $getOrdersData->payment_status;
                                
                                $myOrdersArray[$i]['store_name'] = $orderStoreName;
                                $myOrdersArray[$i]['order_id'] = $orderId;
                                $myOrdersArray[$i]['payment_status'] = $paymentStatus;
                                $myOrdersArray[$i]['order_status'] = $orderStatus;
                                $myOrdersArray[$i]['total_price'] = $orderPaymentAmt;

                                $date = date_create($orderCreatedDate);
                                $orderCreatedDate = date_format($date, 'd M, Y g:i A');
                                $myOrdersArray[$i]['order_created_date'] = $orderCreatedDate;

                                //getProduct_count
                                $getHasProductsResult = DB::table('has_products')
                                    ->select(DB::raw('count(id) as total_product_count'))
                                    ->where('order_id', $orderId)
                                    ->where('store_id', $storeId)
                                    ->get();
                                
                                if(count($getHasProductsResult) > 0)
                                {
                                    $myOrdersArray[$i]['total_item'] = $getHasProductsResult[0]->total_product_count;    
                                }
                                else
                                {
                                    $myOrdersArray[$i]['total_item'] = 0;    
                                }
                                
                               
                            }
                            $i++;
                           
                        }//foreach ends here
                        
                        if (count($myOrdersArray) > 0) {
                            return response()->json(["status" => 1, 'msg' => '', 'data' => $myOrdersArray]);
                        } else {
                            return response()->json(["status" => 0, 'msg' => 'Records not found']);
                        }
                    }//if ends here
                
                }   
                else
                {
                    return response()->json(["status" => 1, 'msg' => 'Records not found']); 
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

    }//myorderdetails fun ends here


}
