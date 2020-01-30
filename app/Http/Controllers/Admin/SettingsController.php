<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use App\Models\Document;
use App\Models\Currency;
use App\Models\Country;
use App\Models\Language;
use App\Models\Settings;
use App\Library\Helper;
use Illuminate\Support\Facades\Input;
use Hash;
use Validator;
use Session;

class SettingsController extends Controller {

    public function index() {
        $curr = Currency::where('status', 1)->get();
        $selCurr = [];
        foreach ($curr as $sCur) {
            $selCurr[$sCur->id] = $sCur->iso_code;
        }

        $countryResult = Country::where('status', 1)->get();
        //echo "<pre>";print_r($countryResult);exit;
        $selCountry = [];
        foreach ($countryResult as $countryData) {
            $selCountry[$countryData->id] = $countryData->name.' ('.$countryData->country_code.')';
        }
        $selLang = [];
        $langs = Language::all();
        foreach ($langs as $sLang) {
            $selLang[$sLang->id] = $sLang->name;
        }
        $settings = Helper::getsettings();

        $action = route('admin.settings.update');
        return view(Config('constants.AdminPagesSettings') . ".index", compact('settings', 'selCurr','selCountry', 'selLang', 'action'));
    }

    public function update() {
        $rules = [

            'primary_color' => 'required',
            'secondary_color' => 'required',
            'language_id' => 'required',
            'currency_id' => 'required',
            'country_id' => 'required'
        ];
        $messages = [

            'primary color.required' => 'Primary Color is required.',
            'secondary color.required' => 'Secondary Color is required.',
            'language_id.required' => 'Language is required.',
            'currency_id.required' => 'Currency is required.',
            'country_id.required' => 'Country is required.'
        ];
        $validator = Validator::make(Input::all(), $rules, $messages);
        if ($validator->fails()) {
            return $validator->messages()->toJson();
        } else {
            $settings = Settings::find(Input::get('id'));
            $pcolor = $settings->primary_color;
            $scolor = $settings->secondary_color;
            if (Input::hasFile('logo_img')) {
                $file = Input::file('logo_img');
                $destinationPath = public_path() . '/public/admin/uploads/settings/';
                $fileName = "logo-" . date("YmdHis") . "." . $file->getClientOriginalExtension();
                $upload_success = $file->move($destinationPath, $fileName);
                $settings->logo = is_null($fileName) ? $settings->filename : $fileName;
            }
            if (!empty(Input::get('primary_color'))) {
                $pcolor = Input::get('primary_color');
            }
            if (!empty(Input::get('secondary_color'))) {
                $scolor = Input::get('secondary_color');
            }
            $settings->primary_color = $pcolor;
            $settings->secondary_color = $scolor;
            $settings->language_id = Input::get('language_id');
            $settings->currency_id = Input::get('currency_id');
            $settings->country_id = Input::get('country_id');
            $settings->update();

            $symb = Currency::find(Input::get('currency_id'))->css_code;
            $currency_val = Currency::find(Input::get('currency_id'))->currency_val;
            Session::put("cur", $symb);
            Session::put("currency_val", $currency_val);

            return redirect()->back()->with('msg', "Settings updated Successfully!");
        }
    }

}
