<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Session;
use DB;
use Route;
use Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Order;
use App\Models\HasCurrency;

class InternationalController extends Controller {

    function __construct() {
        parent::__construct();
    }

    function country_list() {
        $countryall = Country::get();
        //dd($countryall);
        $country = Country::orderBy('id', 'asc');
        if (!empty(Input::get('country'))) {
            $country = $country->where('name', '=', Input::get('country'));
        }

        if (Input::get('status')!='') {
          //  dd(Input::get('status'));
            $country = $country->where('status', '=', Input::get('status'));
        }
        $country = $country->paginate(Config('constants.paginateNo'));

        return view(Config('constants.adminInternationalView') . '.country_list', compact('country', 'countryall'));
    }

    public function add() {
        $miscellaneous = new Country();
        $action = route("admin.country.save");
        return view(Config('constants.adminInternationalView') . '.addEdit', compact('miscellaneous', 'action'));
    }

    public function edit() {
        $country = Country::find(Input::get('id'));
        // print_r($country);
        $action = route("admin.country.save");
        return view(Config('constants.adminInternationalView') . '.addEdit', compact('country', 'action'));
    }

    public function save() {
        $saveCountry = Country::findOrNew(Input::get('id'));
        $saveCountry->name = Input::get('name');
        // $saveCountry->shipping_cost = Input::get('value');
        $saveCountry->status = Input::get('status');
        Session::flash('message', "Country updated successfully.");
        $saveCountry->save();
        return redirect()->route('admin.country.view');
    }

    public function delete() {
        $id = Input::get('id');
        $order = Order::where('country_id', $id)->count();
        //dd($order);
        if ($order == 0) {
            $settings = Country::find($id);
            $settings->delete();
            Session::flash('msg', "Country deleted successfully.");
        } else {
            Session::flash('msg', "Sorry, You can not delete this country as its part of order.");
        }
        return redirect()->back();
    }

    public function currencyListing() {
        $currencyall = HasCurrency::get();
        $currency = HasCurrency::orderBy('id', 'asc');
        if (!empty(Input::get('currency'))) {
            $currency = $currency->where('currency_code', '=', Input::get('currency'));
        }
        if (!empty(Input::get('status'))) {
            $currency = $currency->where('currency_status', '=', Input::get('status'));
        }
        $currency = $currency->paginate(Config('constants.paginateNo'));
        // dd($currency);
        return view(Config('constants.adminInternationalView') . '.currency_listing', compact('currency', 'currencyall'));
    }

    public function currencyStatus() {
        $id = Input::get('currencyId');
        $status = Input::get('currencyStatus');
        $saveCurrency = HasCurrency::find(Input::get('currencyId'));
        if ($status == '0') {
            $saveCurrency->currency_status = '1';
            Session::flash('msg', "Currency enabled successfully.");
        } else {

            $saveCurrency->currency_status = '0';
            Session::flash('message', "Currency disabled successfully.");
        }
        $saveCurrency->update();
    }

    public function countryStatus() {
        $id = Input::get('id');
        // dd($id);
        $saveCountry = Country::find(Input::get('id'));
        if ($saveCountry->status == '0') {
            $saveCountry->status = '1';
            Session::flash('message', "Country enabled successfully.");
        } else {
            $saveCountry->status = '0';
            Session::flash('msg', "Country disabled successfully.");
        }
        $saveCountry->update();
        return redirect()->back();
    }

    public function editCurrencyListing($id) {
        $currency = HasCurrency::find($id);
        // print_r($country);
        $action = route("admin.currency.save");
        return view(Config('constants.adminInternationalView') . '.addEditCurrency', compact('currency', 'action'));
    }

    public function saveCurrencyListing() {

        $saveCountry = HasCurrency::findOrNew(Input::get('id'));
        $saveCountry->currency_code = Input::get('currency_code');
        $saveCountry->currency_val = Input::get('currency_val');
        $saveCountry->save();
        Session::flash('msg', "Currency updated successfully.");
        return redirect()->route('admin.currency.view');
    }

}
