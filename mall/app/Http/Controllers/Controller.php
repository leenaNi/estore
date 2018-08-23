<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Category;
use App\Models\Product;
use App\Models\Translation;
use App\Models\SocialMediaLink;
use App\Models\StaticPage;
use App\Models\Contact;
use App\Models\Layout;
use App\Models\HasLayout;
use App\Models\GeneralSetting;
use App\Models\HasCurrency;
use App\Library\Helper;
use Cart;
use View;
use Session;
use Route;
use Request;

abstract class Controller extends BaseController {

    use AuthorizesRequests,
        DispatchesJobs,
        ValidatesRequests;

    public $courierService;
    public $getEmailStatus;
    public $getCodStatus;
    public $pincodeStatus;
    public $feature;
    public $storeViesion;

    public function __construct() {  
        
     
        Session::forget('currency_id');
        Session::forget('currency_code');
        Session::forget('currency_name');
        Session::forget('currency_val');

//        $this->setGlobalCurrency();
//        $currencyId ='IND';
//        //$currency = HasCurrency::find($currencyId);
//        $currency = HasCurrency::where('iso_code',$currencyId)->first();
//        Session::put('currency_id', $currency->id);
//        Session::put('currency_code', $currency->currency);
//        Session::put('currency_name', $currency->currency_name);
//        Session::put('currency_val', $currency->currency_val);
//        Session::put('currency_symbol', $currency->css_code);
        View::share('getAllCategories', $this->getAllCategories());


//        View::share('menu', $this->getMenu());
//        View::share('cart', $this->getCart());
//        View::share('langs', $this->getTranslations());
        View::share('industry_id', Helper::getSettings()['industry_id']);
        View::share('store_version_id', Helper::getSettings()['store_version']);
        Session::put("storeName", Helper::getSettings()['storeName']);
        View::share('settingStatus', $this->getSettingStatus());
//        View::share('socialMedia', SocialMediaLink::where('status', 1)->get());
//        View::share('staticPages', StaticPage::where('status', 1)->orderby('sort_order','asc')->get());
      
//        View::share('staticManuPage', StaticPage::where('status', 1)->where('is_menu', 1)->orderby('sort_order','asc')->get());
//        View::share('contactDetails', StaticPage::where('status', 1)->where('url_key', 'contact-us')->first());
//        View::share('footerContent', @StaticPage::where('status', 1)->where('url_key', 'about-us')->first()->description);
//        View::share('dynamicayout', Layout::where('is_active', 1)->get());
//        View::share('footerContent', $this->getFooterContent());
//        View::share('homePageAbout', $this->gethomePageAbout());
//        View::share('layoutPage', HasLayout::where('layout_id', 1)->get());

        $this->courierService = GeneralSetting::where('url_key', 'courier-services')->first()->status;
        view()->share('courierService', $this->courierService);
        $this->getEmailStatus = GeneralSetting::where('url_key', 'email-facility')->first()->status;
        View::share('getEmailStatus', $this->getEmailStatus);
        $this->getCodStatus = GeneralSetting::where('url_key', 'cod')->first()->status;
        View::share('getCodStatus', $this->getCodStatus);
        $this->pincodeStatus = GeneralSetting::where('url_key', 'pincode')->first()->status;
        View::share('pincodeStatus', $this->pincodeStatus);
        $this->feature = $this->getSetting();
        View::share('feature', $this->feature);
        $this->storeViesion=$this->getStoreVersion();      
         View::share('storeViesion', $this->storeViesion);
        //        $data['socialMedia']=SocialMediaLink::where('status',1)->get();
//        $data['contactDetails']=Contact::where('status',1)->get();
//        $data['staticPages']=StaticPage::where('status',1)->get();
    }

    public function getMenu() {
        $menu = Category::roots()->where("is_nav", "=", "1")->where('status', 1)->orderBy('sort_order', "asc")->with('catimgs')->get();

        foreach ($menu as $child)
            $menu->children = $child->descendants()->where("is_nav", "=", "1")->where('status', 1)->orderBy('sort_order', "asc")->with('catimgs')->get();
        return $menu;
    }

    public function getCart() {
        return Cart::instance("shopping")->content();
    }

    public function getAllCategories() {
        return Category::roots()->where("is_nav", "=", "1")->orderBy('sort_order', "asc")->get();
    }

    public function prodDetail($id) {
        return Product::find($id)->with('catalogimgs');
    }

    public function getFeaturedProducts() {
        return Product::where("is_avail", 1)->where('is_featured', 1)->where("status", 1)->with('catalogimgs', 'mainimg', 'attributevalues')->paginate(40);
    }

    public function getTranslations() {
        // $trans = Translation::all();
        // return $trans;
        $routename = Route::currentRouteName();
        $trans = Translation::whereRaw("find_in_set('$routename',page)");

        if (Request::is('admin/*')) {
            $trans->where('translate_for', 'backend');
        } else {
            $trans->where('translate_for', 'frontend');
        }

        $trans = $trans->orWhere('is_specific', 'all')->get();

        return $trans;
    }

    public static function getSetting() {
        $settings = GeneralSetting::get(['url_key', 'status', 'type']);

        foreach ($settings as $key => $value) {
            $general[strtolower($value->url_key)] = $value->status;
        }
        return $general;
    }

    public static function getSettingStatus() {
        $settings = GeneralSetting::all();

        foreach ($settings as $key => $value) {
            $general[strtolower($value->id)] = $value->status;
        }

        return $general;
    }

    public static function getFooterContent() {

$footerContant = [];
        return $footerContant;
    }

    public static function gethomePageAbout() {
     //   $layout = Layout::where('url_key', 'home-page-about-us')->where('is_active', 1)->first();
    //    $homePageAbout = HasLayout::where('layout_id', $layout->id)->where('is_active', 1)->first();
        $homePageAbout=[];
        return $homePageAbout;
    }
public function getStoreVersion(){
         $jsonString =  Helper::getSettings();
        $data = (object)$jsonString;
       return ($data->store_version==2)?"":'hideClass';
    
}
    public static function setGlobalCurrency() {
        //Default Currency
        $currency = GeneralSetting::where('url_key', 'default-currency')->first(['details']);
        $currencySettings = json_decode($currency->details, true);
        //Changable Currency
        $jsonString = Helper::getSettings();
        $data = (object)$jsonString;
//        $this->storeViesion=$data;//($data->store_version==1)?"hideClass":'';
  //   dd($storeVersion);
        $currentCurr = Session::get('currency');

        if ($currencySettings['iso_code'] !== $data->currencyId && empty(Session::get('currency_id'))) { //default currency is changed
            Session::put('currency', $data->currencyId);
            $curr = Helper::getCurrency($data->currencyId);
            return ['currency' => $data->currencyId, 'sym' => trim($curr->css_code), 'curval' => $curr->currency_val, 'store_cur' => $data->currencyId];
        } else if ($currencySettings['iso_code'] === $data->currencyId) { //both currency is same
            if (!empty($currentCurr)) {
                if ($currencySettings['iso_code'] !== $currentCurr) { //current session currency is diff then set it to default
                    Session::put('currency', $currencySettings['iso_code']);
                    $curr = Helper::getCurrency($currencySettings['iso_code']);
                    return ['currency' => $currencySettings['iso_code'], 'sym' => trim($curr->css_code), 'curval' => $curr->currency_val, 'store_cur' => $data->currencyId];
                } else {
                    $curr = Helper::getCurrency($currencySettings['iso_code']);
                    return ['currency' => $currentCurr, 'sym' => trim($curr->css_code), 'curval' => $curr->currency_val, 'store_cur' => $data->currencyId];
                }
            } else if (!empty($currency)) {
                Session::put('currency', $currencySettings['iso_code']);
                $curr = Helper::getCurrency($currencySettings['iso_code']);
                return ['currency' => $currencySettings['iso_code'], 'sym' => trim($curr->css_code), 'curval' => $curr->currency_val, 'store_cur' => $data->currencyId];
            } else {
                $curr = Helper::getCurrency($data->currencyId);
                return ['currency' => $data->currencyId, 'sym' => trim($curr->css_code), 'curval' => $curr->currency_val, 'store_cur' => $data->currencyId];
            }
        } else {
            $curr = Helper::getCurrency($data->currencyId);
            return ['currency' => $data->currencyId, 'sym' => trim($curr->css_code), 'curval' => $curr->currency_val, 'store_cur' => $data->currencyId];
        }
//        if (empty($currentCurr)) {
//            if (!empty($currency)) {
//                Session::put('currency', $currencySettings['iso_code']);
//                $curr = Helper::getCurrency($currencySettings['iso_code']);
//                return ['currency' => $currencySettings['iso_code'], 'sym' => trim($curr->css_code)];
//            } else {
//                $curr = Helper::getCurrency($currencySettings['iso_code']);
//                return ['currency' => 'IND', 'sym' => trim($curr->css_code)];
//            }
//        } else {
//            if ($currencySettings['iso_code'] !== $currentCurr) {
//                Session::put('currency', $currencySettings['iso_code']);
//                $curr = Helper::getCurrency($currencySettings['iso_code']);
//                return ['currency' => $currencySettings['iso_code'], 'sym' => trim($curr->css_code)];
//            } else {
//                $curr = Helper::getCurrency($currencySettings['iso_code']);
//                return ['currency' => $currentCurr, 'sym' => trim($curr->css_code)];
//            }
//        }
    }

}
