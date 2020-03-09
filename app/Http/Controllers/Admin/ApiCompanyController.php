<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use DB;
use Input;
use Session;

class ApiCompanyController extends Controller
{
    public function getAllCompany()
    {
        $companyResult = DB::table('company')->where('is_delete', 0)->get(['id', 'name', 'logo']);
        if (count($companyResult) > 0) {
            return response()->json(["status" => 1, 'msg' => "", 'data' => $companyResult]);
        } else {
            return response()->json(["status" => 1, 'msg' => "Record not found."]);
        }
    } // End getAllCompany

    public function getCompanyDetail()
    {
        $finalArray = [];
        if (!empty(Input::get("companyId"))) {
            $companyId = Input::get("companyId");
            $companyResult = DB::table('company')->where('id', $companyId)->get(['id', 'name', 'logo', 'address', 'contact_person_name', 'contact_person_number']);

            if (count($companyResult) > 0) {
                $brandResult = DB::table('brand')->where('company_id', $companyId)->where('is_delete', 0)->get(['id', 'name', 'logo']);
                if (count($companyResult) > 0) {
                    $companyResult['brand'] = $brandResult;
                }
                return response()->json(["status" => 1, 'data' => $companyResult]);
            } else {
                return response()->json(["status" => 1, 'msg' => "Record not found."]);
            }
        } else {
            return response()->json(["status" => 0, 'msg' => 'Mandatory fields are missing.']);
        }
    } // End getAllCompanyDetail

    public function getAllBrand()
    {
        $brandResult = DB::table('brand')->where('is_delete', 0)->get(['id', 'name', 'logo']);
        if (count($brandResult) > 0) {
            return response()->json(["status" => 1, 'msg' => "", 'data' => $brandResult]);
        } else {
            return response()->json(["status" => 1, 'msg' => "Record not found."]);
        }
    } // End getAllBrand

    public function getBrandDetail()
    {
        if (!empty(Input::get("brandId"))) {
            $brandId = Input::get("brandId");

            $brandResult = DB::table('brand')
                ->join('company', 'company.id', '=', 'brand.company_id')
                ->join('industries', 'industries.id', '=', 'brand.industry_id')
                ->where('brand.id', $brandId)
                ->get(['brand.id', 'brand.name', 'brand.logo', 'company.name AS company_name', 'industries.category as industry_name']);
            if (count($brandResult) > 0) {
                return response()->json(["status" => 1, 'msg' => "", 'data' => $brandResult]);
            } else {
                return response()->json(["status" => 1, 'msg' => "Record not found."]);
            }
        } else {
            return response()->json(["status" => 0, 'msg' => 'Mandatory fields are missing.']);
        }
    } // End getAllCompanyDetail

    public function getMerchantCompanyList()
    {
        DB::enableQueryLog();
        $isError = '';
        //dd(Input::all());
        if (!empty(Session::get("merchantId"))) {
            $merchantId = Session::get("merchantId");
            // get distributor id from has_distributor table
            $distributorIdResult = DB::table('has_distributors')->where('merchant_id', $merchantId)->get(['distributor_id']);

            if (count($distributorIdResult) > 0) {
                $distributorIds = [];
                foreach ($distributorIdResult as $distributorIdData) {
                    $distributorIds[] = $distributorIdData->distributor_id;
                }
                // get brand id
                $brandIdsResult = DB::table('stores')
                    ->join('products', 'products.store_id', '=', 'stores.id')
                    ->whereIn('stores.merchant_id', $distributorIds)
                    ->where('stores.store_type', 'distributor')->get(['products.brand_id', 'products.store_id']);
                if (count($brandIdsResult) > 0) {
                    $brandIds = [];
                    $storeId = [];
                    foreach ($brandIdsResult as $brandIdsData) {
                        $brandIds[] = $brandIdsData->brand_id;
                    }
                    // Get company ids
                    $companyResult = DB::table('company')
                        ->join('brand', 'company.id', '=', 'brand.company_id')
                        ->whereIn('brand.id', $brandIds)
                        ->get(['company.id as company_id', 'company.name as company_name', 'company.logo as company_logo', 'brand.id as brand_id', 'brand.name as brand_name', 'brand.logo as brand_logo']);
                    if (count($companyResult) > 0) {
                        $tempId = 0;
                        $i = 0;
                        $j = 0;
                        $companyArray = array();
                        $brandArray = array();
                        foreach ($companyResult as $companyData) {
                            $companyId = $companyData->company_id;
                            $companyName = $companyData->company_name;
                            $companyLogo = ($companyData->company_logo != '') ? $companyData->company_logo : 'default-company.jpg';
                            // $brandId = $companyData->brand_id;
                            // $brandName = $companyData->brand_name;
                            // $brandLogo = $companyData->brand_logo;

                            if ($tempId > 0 && $companyId != $tempId) {
                                $companyArray[$i]['brand'] = $brandArray;
                                $brandArray = array();
                                $i++;
                                $j = 0;
                                $companyArray[$i]['compnay_id'] = $companyId;
                                $companyArray[$i]['company_name'] = $companyName;
                                $companyArray[$i]['company_logo'] = asset(Config('constants.companyImgPath') . $companyLogo);
                            } else {
                                if ($tempId == 0) {
                                    $companyArray[$i]['compnay_id'] = $companyId;
                                    $companyArray[$i]['company_name'] = $companyName;
                                    $companyArray[$i]['company_logo'] = asset(Config('constants.companyImgPath') . $companyLogo);
                                }
                            }
                            // $brandArray[$j]['brand_id'] = $brandId;
                            // $brandArray[$j]['brand_name'] = $brandName;
                            // $brandArray[$j]['brand_logo'] = asset(Config('constants.brandImgPath').$brandLogo);
                            $j++;
                            $tempId = $companyId;

                        } // End foreach
                        $isError = 0;
                        if (!empty($brandArray)) {
                            $companyArray[$i]['brand'] = $brandArray;
                        }
                    } else {
                        $isError = 1;
                    }
                } else {
                    $isError = 1;
                }
            } else {
                $isError = 1;
            }

            if ($isError == 1) {
                return response()->json(["status" => 1, 'msg' => "Record not found."]);
            } else if ($isError == 0) {
                return response()->json(["status" => 1, 'msg' => "", 'data' => $companyArray]);
            } else {
                return response()->json(["status" => 1, 'msg' => "There is somthing wrong."]);
            }
        } else {
            return response()->json(["status" => 0, 'msg' => 'Mandatory fields are missing.']);
        }
    } // End getCompanyList()

}
