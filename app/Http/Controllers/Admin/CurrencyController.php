<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\Helper;
use App\Models\Currency;
use Illuminate\Support\Facades\Input;
use Validator;
use Hash;;

class CurrencyController extends Controller
{
    public function index() 
    {
        $currency = Currency::orderBy("id", "desc");
        
        //echo "total >> ".count($countries);
        $search = Input::get('search');

        if (!empty($search)) {

            if (!empty(Input::get('s_currency'))) {
                $currency = $currency->where("name", "like", "%" . Input::get('s_currency') . "%");
            }
        } 
        
        $currency = $currency->paginate(Config('constants.AdminPaginateNo'));
        $data = [];
        $data['currency'] = $currency;
        $viewname = Config('constants.AdminPagesMastersCurrency') . ".index";
        return Helper::returnView($viewname, $data);
    } // Edn index()

    public function addEditCountry()
    {
        $Currency = Currency::findOrNew(Input::get('id'));
        $viewname = Config('constants.AdminPagesMastersCurrency') . ".addEdit";
        $data['currency'] = $Currency;
        return Helper::returnView($viewname, $data);
    } // End addEditCountry();

    public function saveUpdate()
    {
        $allinput = Input::all();
        //dd($allinput);
        $validator = Validator::make($allinput, Currency::rules(null));
        if ($validator->fails()) 
        {
            return $validator->messages()->toJson();
        } 
        else 
        {
            if(empty(Input::get('id')))
            {
                $currencyObj = new Currency();
            }
            else
            {
                $currencyObj = Currency::find(Input::get('id'));
            }
            
            $currencyObj->name = $allinput['name'];
            $currencyObj->currency_code = $allinput['currency_code'];
            $currencyObj->iso_code = $allinput['iso_code'];
            $currencyObj->currency_val = $allinput['currency_val'];
            $currencyObj->css_code = $allinput['css_code'];
            $currencyObj->status = $allinput['status'];
            $currencyObj->save();
            return redirect()->route('admin.masters.currency.view');
        }
    } // End saveUpdate()

    public function changeStatus() {
        //dd("aasdad");
        $currencyId = Input::get('id');
        $status = Input::get('status');

        $currencyObj = Currency::find($currencyId);
        $currencyObj->status = ($status == 0) ? 1 : 0;
        $currencyObj->update();
        return redirect()->route('admin.masters.currency.view');
    }
}
