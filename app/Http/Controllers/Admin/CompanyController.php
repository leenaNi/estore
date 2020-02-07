<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\Helper;
use App\Models\Company;
use Illuminate\Support\Facades\Input;
use Validator;
use Hash;
use DB;
use Session;


class CompanyController extends Controller
{
    public function index()
    {
        $companyResult = Company::orderBy("id", "desc");
        $search = Input::get('search');

        if (!empty($search)) {

            if (!empty(Input::get('s_company'))) {
                $companyResult = $companyResult->where("name", "like", "%" . Input::get('s_company') . "%");
            }
        } // End if 
       
        if(!empty($companyResult))
            $companyResult = $companyResult->paginate(Config('constants.AdminPaginateNo'));
        
        $data = [];
        $data['companyResult'] = $companyResult;
        $viewname = Config('constants.AdminPagesMastersCompany') . ".index";
        return Helper::returnView($viewname, $data);
    } // End index

    public function addEditCompany()
    {
        $companyResult = Company::findOrNew(Input::get('id'));
        $viewname = Config('constants.AdminPagesMastersCompany') . ".addEdit";
        $data['companyResult'] = $companyResult;
        return Helper::returnView($viewname, $data);
    } // End addEditCompany

    public function saveCompany()
    {
        //dd(Input::all());
        $validation = new Company();
        $allinput = Input::all();
        
        $checkValidation = Validator::make($allinput, Company::rules($allinput));
        
        if($checkValidation)
        {
            $companyObj = Company::findOrNew(Input::get('id'));
            $companyObj->name = Input::get('name');
            $companyObj->address = Input::get('address');
            $companyObj->contact_person_name = Input::get('contact_person_name');
            $companyObj->contact_person_number = Input::get('contact_person_number');
            if(empty(Input::get('id')))
            {
                $companyObj->created_by = Session::get('authUserId');
                $companyObj->created_at = date('Y-m-d H:i:s');;
            }
            $companyObj->updated_at = date('Y-m-d H:i:s');;
            $companyObj->updated_by = Session::get('authUserId');
            $companyObj->save();
            $fileName = '';
            if (Input::hasFile('logo'))
            {
                if(Input::get('isValidImage') == 1)
                {
                    $companyLogo = Input::file('logo');
                    $destinationPath = Config('constants.companyImgPath') . "/";
                    $fileName = date("YmdHis") . "." . $companyLogo->getClientOriginalExtension();
                    $uploadSuccess = $companyLogo->move($destinationPath, $fileName);
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
            $companyObj->logo = $fileName;
            $companyObj->update();
         
            return redirect()->route('admin.masters.company.view');
        } 
        else 
        {
            return $checkValidation;
        }
    } // End saveCompany
}
