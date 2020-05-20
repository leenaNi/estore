<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\Helper;
use App\Models\Country;
use Illuminate\Support\Facades\Input;
use Validator;
use Hash;

class CountryController extends Controller
{
    public function index() 
    {
        $countries = Country::orderBy("id", "desc");
        
        //echo "total >> ".count($countries);
        $search = Input::get('search');

        if (!empty($search)) {

            if (!empty(Input::get('s_country'))) {
                $countries = $countries->where("name", "like", "%" . Input::get('s_country') . "%");
            }
        } 
        
        $countries = $countries->paginate(Config('constants.AdminPaginateNo'));
        $data = [];
        $data['countries'] = $countries;
        $viewname = Config('constants.AdminPagesMastersCountry') . ".index";
        return Helper::returnView($viewname, $data);
    } // Edn index()

    public function addEditCountry()
    {
        $country = Country::findOrNew(Input::get('id'));
        $viewname = Config('constants.AdminPagesMastersCountry') . ".addEdit";
        $data['country'] = $country;
        return Helper::returnView($viewname, $data);
    } // End addEditCountry();

    public function saveUpdate()
    {
        $allinput = Input::all();
        //dd($allinput);
        $validator = Validator::make($allinput, Country::rules(null));
        if ($validator->fails()) 
        {
            return $validator->messages()->toJson();
        } 
        else 
        {
            if(empty(Input::get('id')))
            {
                $countryObj = new Country();
            }
            else
            {
                $countryObj = Country::find(Input::get('id'));
            }
            
            $countryObj->name = $allinput['name'];
            $countryObj->country_code = $allinput['country_code'];
            $countryObj->iso_code_2 = $allinput['iso_code_2'];
            $countryObj->iso_code_3 = $allinput['iso_code_3'];
            $countryObj->address_format = $allinput['address_format'];
            $countryObj->postcode_required = $allinput['postcode_required'];
            $countryObj->status = $allinput['status'];
            $countryObj->save();
            return redirect()->route('admin.masters.country.view');
        }
    } // End saveUpdate()

    public function changeStatus() {
        //dd("changeStatus");
        
        $countryId = Input::get('id');
        $status = Input::get('status');
        
        $countryObj = Country::find($countryId);
        $countryObj->status = ($status == 0) ? 1 : 0;
        $countryObj->update();
        //return $countryObj->status;
        return redirect()->route('admin.masters.country.view');
    }
    
}
