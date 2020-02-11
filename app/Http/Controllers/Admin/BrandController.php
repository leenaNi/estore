<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\Helper;
use App\Models\Brand;
use App\Models\Company;
use App\Models\Category;
use Illuminate\Support\Facades\Input;
use Validator;
use Hash;
use DB;
use Session;

class BrandController extends Controller
{
    public function index()
    {
        $brandResult = Brand::join('company as c', 'c.id', '=', 'brand.company_id')
                ->join('industries as i', 'i.id', '=', 'brand.industry_id');

        // get company
        $companyResult = Company::orderBy("id", "desc")->pluck('name', 'id')->prepend('Select Company', '');

        // Industry data
        $industryResult = Category::where("status", 1)->pluck('category', 'id')->prepend('Select Industry', ''); 

        $search = Input::get('search');
        if (!empty($search))
        {
            if (!empty(Input::get('s_brand'))) 
            {
                $brandResult = $brandResult->where("brand.name", "like", "%" . Input::get('s_brand') . "%");
            }
            if (!empty(Input::get('company_id'))) 
            {
                $brandResult = $brandResult->where("brand.company_id", "=", Input::get('company_id'));
            }
            if (!empty(Input::get('industry_id'))) 
            {
                $brandResult = $brandResult->where("brand.industry_id", "=", Input::get('industry_id'));
            }
        } // End if 

       $brandResult = $brandResult->select(['brand.id','brand.name','c.name AS compnay_name','i.category as industry_name']);
        //echo "<pre>";print_r($brandResult);exit;
        if(!empty($brandResult))
            $brandResult = $brandResult->paginate(Config('constants.AdminPaginateNo'));

        $data['brandResult'] = $brandResult;
        $data['companyList'] = $companyResult;
        $data['industryList'] = $industryResult;

        //echo "<pre>";print_r($data);
        $viewname = Config('constants.AdminPagesMastersBrand') . ".index";
        return Helper::returnView($viewname, $data);
    } // End index

    public function addEditBrand()
    {
        $brandResult = Brand::findOrNew(Input::get('id'));

        // get company
        $companyResult = Company::orderBy("id", "desc")->pluck('name', 'id')->prepend('Select Company', '');

        // Industry data
        $industryResult = Category::where("status", 1)->pluck('category', 'id')->prepend('Select Industry', ''); 

        $viewname = Config('constants.AdminPagesMastersBrand') . ".addEdit";
        $data['brandResult'] = $brandResult;
        $data['companyList'] = $companyResult;
        $data['industryList'] = $industryResult;
       
        return Helper::returnView($viewname, $data);
    } // End addEditCompany

    public function saveBrand()
    {
        //dd(Input::all());
        $validation = new Brand();
        $allinput = Input::all();
        
        $checkValidation = Validator::make($allinput, Brand::rules(Input::all()));
        
        if($checkValidation)
        {
            $brandObj = Brand::findOrNew(Input::get('id'));
            $brandObj->name = Input::get('name');
            $brandObj->company_id = Input::get('company_id');
            $brandObj->industry_id = Input::get('industry_id');
            if(empty(Input::get('id')))
            {
                $brandObj->created_by = Session::get('authUserId');
                $brandObj->created_at = date('Y-m-d H:i:s');;
            }
            $brandObj->updated_at = date('Y-m-d H:i:s');
            $brandObj->updated_by = Session::get('authUserId');
            $brandObj->save();
            $fileName = '';
            
            if (Input::hasFile('logo'))
            {
                if(Input::get('isValidImage') == 1)
                {
                    $brandLogo = Input::file('logo');
                    $destinationPath = Config('constants.brandImgPath') . "/";
                    $fileName = date("YmdHis") . "." . $brandLogo->getClientOriginalExtension();
                    $uploadSuccess = $brandLogo->move($destinationPath, $fileName);
                    if(!empty(Input::get('hdnLogo')))
                    {
                        unlink($destinationPath.Input::get('hdnLogo'));
                    }
                }
                
            }
            else
            {
                if(!empty(Input::get('hdnLogo')))
                {
                    $fileName = Input::get('hdnLogo');
                }
            }

            $brandObj->logo = $fileName;
            $brandObj->update();
         
            return redirect()->route('admin.masters.brand.view');
        } 
        else 
        {
            return $checkValidation;
        }
    } // End saveCompany

    public function deleteBrand()
    {
        $brandId = Input::get('id');
        $brandObj1 = Brand::where('id', '=', $brandId)->delete();
        //$brandObj1->delete();
        return redirect()->route('admin.masters.brand.view');
    }
}
