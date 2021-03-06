<?php

namespace App\Http\Controllers\Admin;

use Input;
use App\Models\Role;
use App\Models\Miscellaneous;
use App\Models\GeneralSetting;
use App\Models\HasCurrency;
use Hash;
use Auth;
use Session;
use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use App\Models\Language;
use App\Models\Zone;
use App\Models\Country;
use App\Library\Helper;
use Mail;
use DB;
use Config;

class MiscellaneousController extends Controller {
    
    public function generalSetting() {
       // dd(config('app.industry'));
        $name = Input::get('name');
        $status = Input::get('status');
        $industry_id=config('app.industry');
      $questionCategory=DB::table('question_category')->get();
        if (!empty(config('app.industry'))) {
            $settings = GeneralSetting::where('name', '<>', 'set_popup')->orderBy('question_category_id','desc')->whereHas('industry', function($que) use($industry_id) {
                        $que->where("industry_id", $industry_id);
                    });
        
        } else {
            $settings = GeneralSetting::where('is_active', 1)->where('name', '<>', 'set_popup')->orderBy('question_category_id', 'DESC');
        }

        if ($name) {
            $settings = $settings->where('name', 'LIKE', '%' . $name . '%');
        }
        if ($status != null) {
            $settings = $settings->where('status', $status);
        }
        $settings = $settings->get();
        $settingData=[];
        foreach($questionCategory as $cat){
           foreach($settings as $setting) {
               if($cat->id==$setting->question_category_id){
                   $settingData[$cat->category][]=$setting;
               }
           }
            
      }
      //dd($data);
      //  dd($settingData);
        return view(Config('constants.adminMiscellaneousGeneralSettingView') . '.index', compact('settingData'));
    }

    public function generalSettingAdd() {
        $settings = new GeneralSetting();
        $action = route("admin.generalSetting.save");
        return view(Config('constants.adminMiscellaneousGeneralSettingView') . '.addEdit', compact('settings', 'action'));
    }

    public function generalSettingEdit() {
        $settings = GeneralSetting::find(Input::get('id'));
        $action = route("admin.generalSetting.save");
        return view(Config('constants.adminMiscellaneousGeneralSettingView') . '.addEdit', compact('settings', 'action'));
    }

    public function generalSettingSave() {
        $save = GeneralSetting::findOrNew(Input::get('id'));
        $save->name = Input::get('name');
        $save->status = Input::get('status');
        $save->save();


        return redirect()->route('admin.generalSetting.view');
    }

    public function generalSettingSaveDelete() {
        $id = Input::get('id');
        $settings = GeneralSetting::find($id);
        $settings->delete();

        return redirect()->back()->with("message", "Deleted Successfully.");
    }

    public function paymentSetting() {
        $settings = GeneralSetting::where("type", 2)->paginate(Config('constants.paginateNo'));

        return view(Config('constants.adminMiscellaneousPaymentSettingView') . '.index', compact('settings'));
    }

    public function paymentSettingEdit() {
        $settings = GeneralSetting::where('url_key', Input::get('url_key'))->first();
        $action = route("admin.paymentSetting.save");
        return view(Config('constants.adminMiscellaneousPaymentSettingView') . '.addEdit', compact('settings', 'action'));
    }

    public function paymentSettingSave() {
        $save = GeneralSetting::where('url_key', Input::get('url_key'))->first();
        $save->status = Input::get('status');
        $save->details = !is_null(Input::get('details')) ? json_encode(Input::get('details')) : '';
        $save->save();

        if (Input::get('type') == 2) {
            Session::flash("msg", "Payment gateway updated successfully.");
            return redirect()->route('admin.paymentSetting.view');
        }
        if (Input::get('type') == 3) {
            Session::flash("aletC", '1');
            Session::flash("message", "Refrral program updated successfully.");
            return redirect()->route('admin.advanceSetting.view');
        }
    }

    public function paymentSettingStatus() {
        $prod = GeneralSetting::where('url_key', Input::get('url_key'))->first();

        if ($prod->status == 1) {
            $prod->status = 0;
            Session::flash("message", "Payment setting disabled successfully.");
        } else {
            $prod->status = 1;
            Session::flash("msg", "Payment setting enabled successfully.");
            //  echo "Disable";
        }
        $prod->save();
        return redirect()->route('admin.paymentSetting.view');
    }

    public function advanceSetting() {
        $settings = GeneralSetting::where("type", 3)->paginate(Config('constants.paginateNo'));

        return view(Config('constants.adminMiscellaneousAdvanceSettingView') . '.index', compact('settings'));
    }

    public function domain_success(){
                return view(Config('constants.adminMiscellaneousDomains').'.success');

    }
    public function emailSetting() {
        $settings = GeneralSetting::where("type", 4)->paginate(Config('constants.paginateNo'));

        return view(Config('constants.adminMiscellaneousEmailSettingView') . '.index', compact('settings'));
    }

    public function domains() {
        

        return view(Config('constants.adminMiscellaneousDomains').'.index');
    }
    public function emailSettingEdit() {
        $settings = GeneralSetting::where('url_key', Input::get('url_key'))->first();
        $action = route("admin.emailSetting.save");
        return view(Config('constants.adminMiscellaneousEmailSettingView') . '.addEdit', compact('settings', 'action'));
    }

    public function emailSettingSave() {
        $save = GeneralSetting::where('url_key', Input::get('url_key'))->first();
        $save->status = Input::get('status');
        $save->details = !is_null(Input::get('details')) ? json_encode(Input::get('details')) : '';

        $save->save();

        if (Input::get('type') == 2)
            return redirect()->route('admin.paymentSetting.view');

        if (Input::get('type') == 3)
            return redirect()->route('admin.advanceSetting.view');

        if (Input::get('type') == 4)
            Session::flash("msg", "Email setting updated successfully.");
        return redirect()->route('admin.emailSetting.view');
    }

    public function emailSettingEmailStatus() {
        //dd(Input::get('url_key'));
        $prod = GeneralSetting::where('url_key', Input::get('url_key'))->first();
        //dd($prod);
        if ($prod->status == 1) {
            // dd($prod);
            $prod->status = 0;
            Session::flash("message", "Email setting disabled successfully.");
        } else {
            $prod->status = 1;
            Session::flash("msg", "Email setting enabled successfully.");
            //  echo "Disable";
        }
        $prod->save();
        return redirect()->route('admin.emailSetting.view');
    }

    public function TemplateEmailStatus() {
        // dd(Input::get('id'));
        $prod = EmailTemplate::where('id', Input::get('id'))->first();

        if ($prod->status == 1) {
            $prod->status = 0;
            Session::flash("message", "Email template disabled successfully.");
        } else {
            $prod->status = 1;
            Session::flash("msg", "Email template enabled successfully.");
            //  echo "Disable";
        }
        $prod->save();
        return redirect()->route('admin.templateSetting.view');
    }

    public function templateSetting() {
        $templates = EmailTemplate::paginate(Config('constants.paginateNo'));

        return view(Config('constants.adminMiscellaneousTemplateSettingView') . '.index', compact('templates'));
    }

    public function templateSettingEdit() {
        $id = Input::get('id');
        $templates = EmailTemplate::find($id);
        $action = route("admin.templateSetting.save");
        return view(Config('constants.adminMiscellaneousTemplateSettingView') . '.addEdit', compact('templates', 'action'));
    }

    public function templateSettingSave() {
        // dd(Input::all());
        $template = EmailTemplate::findOrNew(Input::get('id'));
        $template->status = Input::get('status');
        $template->subject = Input::get('subject');
        $template->content = Input::get('content');
        $template->save();
        if (Input::get('id') == "") {
            Session::flash("msg", "Email template added successfully.");
        } else {
            Session::flash("msg", "Email template updated successfully.");
        }
        return redirect()->route('admin.templateSetting.view');
    }

    public function emailSend() {
        $mail = EmailTemplate::where('name', 'Register template')->first();
        $title = $mail->subject;
        $content = $mail->content;
        // dd($content);
        Mail::send('Admin.pages.miscellaneous.template_setting.register', ['title' => $title, 'content' => $content], function ($message) {

            $message->from('satendramaurya1991@gmail.com', 'Satendra M');

            $message->to('satendra@infiniteit.biz');
        });

        return response()->json(['message' => 'Request completed']);
    }

    public function storeSetting() {
        // $settings = GeneralSetting::where("type", 6)->get()->toArray();

        $languages = Language::select('id', 'name')->get();
        $currency = HasCurrency::where('currency_status', 1)->get();
        
        $themedata = Helper::getSettings()['themedata'];
        $themes = [];
        foreach ($themedata as $k => $thed) {
            //  $themes[$thed['category']]=[];  
            $themes[$thed['category']][$k]['id'] = $thed['id'];
            $themes[$thed['category']][$k]['name'] = $thed['name'];
        }
        //dd($themes);

        $d = Helper::getSettings()['language'];
        // dd($d);
        return view(Config('constants.adminMiscellaneousStoreSettingView') . '.index', compact('currency', 'languages', 'themes'));
    }

    function generalStoreAdd() {
        $themes = [];

        $themedata1 = Helper::getSettings()['themedata'];
        foreach ($themedata1 as $td) {
            $themes[$td['id']] = strtolower($td['name']);
        }
        $logo = $storeName = "Your store";
        $pcolor = "#3c8dbc";
        $scolor = "#222d32";
        $delivary_days = '3';
        $cod_option = '1';
        $language = "";
        $currency = "IND";
        $industry_id = Helper::getSettings()['industry_id'];

        $themeSel = Helper::getSettings()['theme'];
        $themeid = Helper::getSettings()['themeid'];
//        if (!empty(Input::hasFile('logo_img'))) {
//
//            //$logo =base64_encode(Input::file('logo_img'));
//            $file_tmp = Input::file('logo_img')->getPathName();
//
//
//            $type = pathinfo($file_tmp, PATHINFO_EXTENSION);
//            $data = file_get_contents($file_tmp);
//            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
//            //echo "Base64 is ".$base64;
//
//
//            $logo = $base64;
//        } else {
//            $logo = Helper::getSettings()['logo'];
//        }

        if (!empty(Input::get('logo_img_url'))) {
            $logo = Input::get('logo_img_url');
        }else
        {
            $logo = Helper::getSettings()['logo'];
        }

        $imagePath = Helper::getLogoFromURL($logo);
        
        if (!empty(Input::get('store_name'))) {
            $storeName = Input::get('store_name');
        }

        if (!empty(Input::get('primary_color'))) {
            $pcolor = Input::get('primary_color');
        }

        if (!empty(Input::get('secondary_color'))) {
            $scolor = Input::get('secondary_color');
        }

        if (!empty(Input::get('btn_color'))) {
            $btncolor = Input::get('btn_color');
        }

        if (!empty(Input::get('sbtn_color'))) {
            $sbtncolor = Input::get('sbtn_color');
        }

        if (!empty(Input::get('standard_delivary_days'))) {
            $delivary_days = Input::get('standard_delivary_days');
        }

        if ((Input::get('cod_option') != null)) {
            $cod_option = Input::get('cod_option');
        }

        if (!empty(Input::get('language'))) {
            $language = Input::get('language');
        }

        if (!empty(Input::get('store_version'))) {
            $store_version = Input::get('store_version');            
           
        }
        
         if (!empty(Input::get('currency'))) {
            $currency = Input::get('currency');            
            Helper::getCurrency($currency);
        }

        if (!empty(Input::get('theme'))) {

            $index = (int) Input::get('theme');
            $themeSel = $themes[$index];
            $themeid = Input::get('theme');
        }
        $store_configuration = array(
            "logo" => $logo,
            "primary_color" => $pcolor,
            "secondary_color" => $scolor,
            "btn_color" => $btncolor,
            "sbtn_color" => $sbtncolor,
            "storeName" => $storeName,
            "standard_delivary_days" => $delivary_days,
            "cod_option" => $cod_option,
            "language" => $language,
            "currencyId" => $currency,
            "theme" => $themeSel,
            "themeid" => $themeid,
            "themedata" => $themedata1,
            "industry_id"=>$industry_id,
            "store_version"=>$store_version
        );
        
        $productconfig = json_encode($store_configuration);
//dd($productconfig);
            // $productconfig = json_encode($store_configuration);
            Helper::saveSettings($productconfig);
       // $path = storage_path() . "/json/storeSetting.json";
          Session::put('storeName', $storeName);
    }

    function returnPolicy() {
        $return = GeneralSetting::where("type", 6)->get();

        return view(Config('constants.adminMiscellaneousReturnPolicyView') . '.index', compact('return'));
    }

    public function returnPolicyEdit() {
        $id = Input::get('id');
        $return = GeneralSetting::find($id);
        // print_r(json_decode($return));
        $action = route("admin.returnPolicy.save");
        return view(Config('constants.adminMiscellaneousReturnPolicyView') . '.edit', compact('return', 'action'));
    }

    function returnPolicySave() {
        $save = GeneralSetting::find(Input::get('id'));
        $save->details = !is_null(Input::get('details')) ? Input::get('details') : 1;
        $save->save();
        Session::flash("msg", "Return policy updated successfully.");
        Session::flash("aletC", '1');
        return redirect()->route('admin.returnPolicy.view');
    }

    public function stockSetting() {
        $getStockLimit = GeneralSetting::where('type', '7')->first();

        return view(Config('constants.adminMiscellaneousStockSettingView') . '.index', compact('getStockLimit'));
    }

    public function saveStockLimit() {
        $details = '{"stock_limit":"' . Input::get('stock') . '"}';
        $getStockLimit = GeneralSetting::where('type', '7')->first();
        $getStockLimit->details = $details;
        $getStockLimit->update();
        return view(Config('constants.adminMiscellaneousStockSettingView') . '.index', compact('getStockLimit'));
    }

    public function changeStatus() {

        $general_setting = GeneralSetting::find(Input::get('id'));
        if ($general_setting->url_key == "product-return-days") {
            $disabled = ($general_setting->status == 1) ? "disabled" : "enabled";
            $msg = "Return policy " . $disabled . " successfully.";
            $general_setting->status = ($general_setting->status == 1) ? 0 : 1;
            $general_setting->update();
            Session::flash("msg", $msg);
            Session::flash("aletC", $general_setting->status);
            return redirect()->route('admin.returnPolicy.view');
        } else if ($general_setting->url_key == "referral") {
            $disabled = ($general_setting->status == 1) ? "disabled" : "enabled";
            $msg = "Referral program " . $disabled . " successfully.";
            $general_setting->status = ($general_setting->status == 1) ? 0 : 1;
            $general_setting->update();
            Session::flash("msg", $msg);
            Session::flash("aletC", $general_setting->status);
            return redirect()->route('admin.advanceSetting.view');
        } else {
            if (Input::get('stocklimit')) {
                $general_setting->details = json_encode(['stocklimit' => Input::get('stocklimit')]);
            }
            if (Input::get('codCharge')) {
                $general_setting->details = json_encode(['charges' => Input::get('codCharge')]);
            }
            if (Input::get('loyaltyDay')) {
                $general_setting->details = Input::get('loyaltyDay');
            }




//            if ($general_setting->url_key == 'tax') {
//                if ($general_setting->status == 1) {
//                   // DB::table('products')->update('is_tax', 0);
//                   // DB::table('product_has_taxes')->truncate();
//                }
//            }
            $general_setting->status = ($general_setting->status == 1) ? 0 : 1;

            $general_setting->update();
        }
    }
    
    public function referralProgram(){
         $settings = GeneralSetting::where('url_key','referral')->get();
        return view(Config('constants.adminMiscellaneousReferalView') . '.index', compact('settings'));
    }
    public function editReferral(){
         $id=Input::get("id");
         $settings = GeneralSetting::find($id);
         //dd($settings);
          $action = route("admin.referralProgram.saveReferral");
        return view(Config('constants.adminMiscellaneousReferalView') . '.addEdit', compact('settings', 'action'));
    }
      public function saveReferral(){
        $save = GeneralSetting::where('url_key', Input::get('url_key'))->first();
        $save->status = Input::get('status');
        $save->details = !is_null(Input::get('details')) ? json_encode(Input::get('details')) : '';
        $save->save();
        Session::flash("aletC", '1');
       Session::flash("message", "Refrral program updated successfully.");
       return redirect()->route('admin.referralProgram.view');
       
}

public function bankDetails(){
    $bankDetail= GeneralSetting::where('url_key','bank_acc_details')->get();
     return view(Config('constants.adminMiscellaneousBankView') . '.index', compact('bankDetail'));
}
 public function addEditBankDetails(){
         $id=Input::get("id");
         $bankDetail = GeneralSetting::find($id); 
         $accountType[1]="Saving";
         $accountType[2]="Current";
        $countryId=Country::where("status",1)->pluck("id");
         $country=Country::where("status",1)->pluck("name","id");
          $state=Zone::where("status",1)->whereIn("country_id",$countryId)->pluck("name","id");
          $action = route("admin.bankDetails.update");
        return view(Config('constants.adminMiscellaneousBankView') . '.addEdit', compact('bankDetail', 'action','accountType','state','country'));
    }
       public function updateBankDetails(){
        $save = GeneralSetting::where('url_key', Input::get('url_key'))->first();
        $save->status = Input::get('status');
        $save->details = !is_null(Input::get('details')) ? json_encode(Input::get('details')) : '';
        $save->save();
        Session::flash("aletC", '1');
       Session::flash("message", "Bank Details updated successfully.");
       return redirect()->route('admin.bankDetails.view');
       
}
}
