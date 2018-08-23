<?php

namespace App\Http\Controllers\Frontend;

use Socialite;
use Route;
use Input;
use App\Models\User;
use App\Models\Category;
use App\Models\GeneralSetting;
use App\Library\Helper;
use App\Models\Slider;
use App\Models\SocialMediaLink;
use Auth;
use DB;
use App\Models\Notification;
use App\Models\Contact;
use App\Models\StaticPage;
use App\Models\Layout;
use App\Models\HasLayout;
use App\Models\EmailTemplate;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Session;
use App\Models\DynamicLayout;
use App\Models\Product;
use App\Models\Testimonials;
use App\Models\Pincode;
use Config;
class HomeEditController extends Controller {
    
    public function updateStoreSettings() {
       $previousdata = Helper::getSettings();
        $store_configuration =[];
        foreach($previousdata as $key=>$val){
            if($key == 'logo'){
                 $store_configuration[$key] = (Input::get('logo_img_url'))?Input::get('logo_img_url'):$val;
            }else{
            $store_configuration[$key] = $val;
            }
        }
        if (!empty(Input::get('currency'))) {
            $currency = Input::get('currency');            
            $currencyData = HasCurrency::where('iso_code',$currency)->first();
            Session::put('currency_id', $currencyData->id);
            Session::put('currency_code', $currencyData->currency);
            Session::put('currency_name', $currencyData->currency_name);
            Session::put('currency_val', $currencyData->currency_val);
            Session::put('currency_symbol', $currencyData->css_code);
        }

      $productconfig = json_encode($store_configuration);
 
            Helper::saveSettings($productconfig);
       
          Session::put('storeName', $store_configuration['storeName']);
        return redirect()->route('home');
    }
    
    public function addHomeBanner()
    {
        $fileName = '';
        if (!empty(Input::get('slider_img_url'))) {
            $destinationPath = Config('constants.layoutUploadPath');
            
            $data = Input::get('slider_img_url');
            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);
            $fileName = date("YmdHis") . "." . Input::get('sliderImg');
            file_put_contents($destinationPath.$fileName, $data);

            //$fileName = date("YmdHis") . "." . Input::get('slider_img_url')->getClientOriginalExtension();
            //$upload_success = @Input::file('slider_img_url')->move(@$destinationPath, @$fileName);
            
            $sortOrder = DB::table("has_layouts")->where('sort_order', DB::raw("(select max(`sort_order`) from ".DB::getTablePrefix()."has_layouts where layout_id =1)"))->first();
            DB::table('has_layouts')->insert(
                    array(
                      'layout_id' => 1,
                      'is_active' => 1,
                      'sort_order' => $sortOrder->sort_order + 1,
                      'image' => $fileName)
                );
                return 1;
            }
            else
            {
                return 0;
            }
    }
    
    public function updateHomeBanner()
    {
        if(!empty(Input::get('slider')))
        {
            foreach(Input::get('slider') as $key=>$values)
            {
                $sliderData = HasLayout::find($key);
                $sliderData->is_active = (!empty($values['status'])) ? $values['status'] : 0;
                $sliderData->sort_order = $values['sort_order'];                        
                $sliderData->update();
            }
            return 1;
        }
        else
        {
            return 0;
        }
    }

}//end class