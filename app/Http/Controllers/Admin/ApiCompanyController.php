<?php

namespace App\Http\Controllers\Admin;

use Route;
use Input;
use App\Http\Controllers\Controller;
use DB;
use Request;
use Response;
use App\Models\User;
use Session;
use App\Library\Helper;
use App\Classes\UploadHandler;
use Vsmoraes\Pdf\Pdf;
use Config;

class ApiCompanyController extends Controller
{
    public function getAllCompany()
    {
        $companyResult = DB::table('company')->where('is_delete',0)->get(['id','name','logo']);
        if(count($companyResult) > 0)
        {
            return response()->json(["status" => 1, 'result' => $companyResult]);
        }
        else
        {
            return response()->json(["status" => 1, 'msg' => "Record not found."]);
        }
    } // End getAllCompany

    public function getCompanyDetail()
    {
        $finalArray = [];
        if(!empty(Input::get("companyId")))
        {
            $companyId = Input::get("companyId");
            $companyResult = DB::table('company')->where('id',$companyId)->get(['id','name','logo','address','contact_person_name','contact_person_number']);
            
            if(count($companyResult) > 0)
            {
                $brandResult = DB::table('brand')->where('company_id',$companyId)->where('is_delete',0)->get(['id','name','logo']);
                if(count($companyResult) > 0)
                {
                    $companyResult['brand'] = $brandResult;
                }
                return response()->json(["status" => 1, 'result' => $companyResult]);
            }
            else
            {
                return response()->json(["status" => 1, 'msg' => "Record not found."]);
            }
        }
        else
        {
            return response()->json(["status" => 0, 'msg' => 'Mendatory fields are missing.']);
        } 
    } // End getAllCompanyDetail

    public function getAllBrand()
    {
        $brandResult = DB::table('brand')->where('is_delete',0)->get(['id','name','logo']);
        if(count($brandResult) > 0)
        {
            return response()->json(["status" => 1, 'result' => $brandResult]);
        }
        else
        {
            return response()->json(["status" => 1, 'msg' => "Record not found."]);
        }
    } // End getAllBrand

    public function getBrandDetail()
    {
        if(!empty(Input::get("brandId")))
        {
            $brandId = Input::get("brandId");
            
            $brandResult = DB::table('brand')
            ->join('company', 'company.id', '=', 'brand.company_id')
            ->join('industries', 'industries.id', '=', 'brand.industry_id')
            ->where('brand.id',$brandId)
            ->get(['brand.id','brand.name','brand.logo','company.name AS company_name','industries.category as industry_name']);
            if(count($brandResult) > 0)
            {
                return response()->json(["status" => 1, 'result' => $brandResult]);
            }
            else
            {
                return response()->json(["status" => 1, 'msg' => "Record not found."]);
            }
        }
        else
        {
            return response()->json(["status" => 0, 'msg' => 'Mendatory fields are missing.']);
        } 
    } // End getAllCompanyDetail

    public function getMerchantCompanyList()
    {
        //DB::enableQueryLog();
        $isError = '';
        //dd(Input::all());
        if(!empty(Input::get("merchantId")))
        {
            $merchantId = Input::get("merchantId");
            
            // get distributor id from has_distributor table
            $distributorIdResult = DB::table('has_distributors')->where('merchant_id',$merchantId)->get(['distributor_id']);
            
            if(count($distributorIdResult) > 0)
            {
                $distributorIds = [];
                foreach($distributorIdResult as $distributorIdData)
                {
                    $distributorIds[] = $distributorIdData->distributor_id;
                }

                 // get brand id
                $brandIdsResult = DB::table('stores')
                ->join('products', 'products.store_id', '=', 'stores.id')
                ->whereIn('stores.merchant_id',$distributorIds)
                ->where('stores.store_type','distributor')->get(['products.brand_id']);

                if(count($brandIdsResult) > 0)
                {
                    $brandIds = [];
                    foreach($brandIdsResult as $brandIdsData)
                    {
                        $brandIds[] = $brandIdsData->brand_id;
                    }

                    // Get compnay ids
                    $companyIdsResult = DB::table('company')->join('brand', 'company.id', '=', 'brand.company_id')
                    ->whereIn('brand.id',$brandIds)
                    ->groupBy('company.id')
                    ->get(['company.id','company.name','company.logo']);

                    if(count($companyIdsResult) > 0)
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
                return response()->json(["status" => 1, 'result' => $companyIdsResult]);
            }
            else
            {
                return response()->json(["status" => 1, 'msg' => "There is somthing wrong."]);
            }
        }
        else
        {
            return response()->json(["status" => 0, 'msg' => 'Mendatory fields are missing.']);
        }   
    } // End getCompanyList()

}