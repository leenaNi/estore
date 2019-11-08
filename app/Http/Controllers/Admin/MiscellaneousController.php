<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Library\Helper;
use App\Models\Document;
use Validator;
use Illuminate\Support\Facades\Input;
use Hash;
use Session;
use Auth;
use JWTAuth;
use Config;
use DB;
use Illuminate\Http\Response;
use App\Models\Merchant;
use App\Models\HasCurrency;
use Tymon\JWTAuth\Exceptions\JWTException;

class MiscellaneousController extends Controller {

    public function contactListing() {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $country = DB::table($prifix . '_countries')->where("status", 1)->get(["id", "name"]);
        $countryId = DB::table($prifix . '_countries')->where("status", 1)->pluck("id");
        $contacts = DB::table($prifix . '_contacts')->orderBy("id", "desc")->get();
        $state = DB::table($prifix . '_zones')->where("status", 1)->whereIn("country_id", $countryId)->get(["id", "name", "country_id"]);

        foreach ($contacts as $contact) {
            $contact->stateName = DB::table($prifix . '_zones')->where("id", $contact->state)->first()->name;
            $contact->countryName = DB::table($prifix . '_countries')->where("id", $contact->country)->first()->name;
        }
        $data = ['contacts' => $contacts, 'state' => $state, 'country' => $country];
        return $data;
    }

    public function saveUpdate() {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $contact = [];
        $contact["customer_name"] = Input::get("contact_name");
        $contact["email"] = Input::get("email");
        $contact["phone_no"] = Input::get("phone_no");
        $contact["address"] = Input::get("address1");
        $contact["address2"] = Input::get("address2");
        $contact["state"] = Input::get("state");
        $contact["country"] = Input::get("country");
        $contact["pincode"] = Input::get("pincode");
        $contact["city"] = Input::get("city");
        $contact["gst"] = Input::get("gst");
        $contact["vat"] = Input::get("vat");
        $contact["status"] = Input::get("status");
        if (!empty(Input::get("id"))) {
            DB::table($prifix . '_contacts')->where("id", Input::get("id"))->update($contact);
        }

        $data = ["status" => 1, "msg" => "Contact details updated successfully!"];
        return $data;
    }

    public function socialMediaLink() {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $filePath = "http://" . $merchant->url_key . '.' . $_SERVER['HTTP_HOST'] . '/uploads/socialmedia/';
        $mediaLink = DB::table($prifix . '_social_media_links')->orderBy("id", "desc")->get();
        foreach ($mediaLink as $links) {
            $links->filePath = $filePath . $links->image;
        }
        $data = ['mediaLink' => $mediaLink, 'filePath' => $filePath];
        return $data;
    }

    public function socialMediaUpdate() {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $socialmedia = [];
        $socialmedia['media'] = Input::get("media");
        $socialmedia['link'] = Input::get("link");
        $socialmedia['status'] = Input::get("status");
        $socialmedia['sort_order'] = Input::get("sort_order");


        $logoimageData = Input::get("socialImage");
        if ($logoimageData) {
            $image_parts = explode(";base64,", $logoimageData);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $imgName = 'social_' . date("YmdHis") . '.' . $image_type;
            $image_base64 = base64_decode($image_parts[1]);
            $filePath = base_path() . '/merchants/' . $merchant->url_key . '/uploads/socialmedia/' . $imgName;
            $images = file_put_contents($filePath, $image_base64);
            $socialmedia['image'] = $imgName;
        }
        if (!empty(Input::get("id"))) {
            $mediaLink = DB::table($prifix . '_social_media_links')->where("id", Input::get("id"))->update($socialmedia);
            $socilaMedia = DB::table($prifix . '_social_media_links')->find(Input::get("id"));
            $socilaMedia->filepath = "http://" . $merchant->url_key . '.' . $_SERVER['HTTP_HOST'] . '/uploads/socialmedia/' . $socilaMedia->image;
            $data = ['status' => 1, "msg" => "Social media link updated successfully!", "socialMedia" => $socilaMedia];
        } else {
            $lastId = DB::table($prifix . '_social_media_links')->insertGetId($socialmedia);
            $socilaMedia = DB::table($prifix . '_social_media_links')->find($lastId);
            $socilaMedia->filepath = "http://" . $merchant->url_key . '.' . $_SERVER['HTTP_HOST'] . '/uploads/socialmedia/' . $socilaMedia->image;
            $data = ['status' => 1, "msg" => "Social media link added successfully!", "socialMedia" => $socilaMedia];
        }

        return $data;
    }

    public function socialMediaDelete() {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $id = Input::get("id");
        if (!empty($id)) {
            DB::table($prifix . '_social_media_links')->where("id", $id)->delete();
            $data = ["status" => 1, "msg" => "Social media link deleted successfully!"];
        } else {
            $data = ["status" => 0, "msg" => "Opps something went wrong!"];
        }
        return $data;
    }

    public function aditionalCharges() {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $additionalC = DB::table($prifix . '_additional_charges')->orderBy("id", "desc")->get();
        return $additionalC;
    }

    public function aditionalChargesSave() {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $addCha = [];
        $addCha["name"] = Input::get("label");
        $addCha["label"] = Input::get("label");
        $addCha["type"] = Input::get("type");
        $addCha["rate"] = Input::get("rate");
        $addCha["status"] = Input::get("status");
        $addCha["min_order_amt"] = Input::get("min_order_amt");
        if (!empty(Input::get("id"))) {
            $additionalC = DB::table($prifix . '_additional_charges')->where("id", Input::get("id"))->update($addCha);
            $data = ['status' => 1, "msg" => "Additional charge updated successfully!"];
        } else {
            $additionalC = DB::table($prifix . '_additional_charges')->insert($addCha);
            $data = ['status' => 1, "msg" => "Additional charge added successfully!"];
        }

        return $data;
    }

    public function aditionalChargesDelete() {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $id = Input::get("id");
        if (!empty($id)) {
            $additionalC = DB::table($prifix . '_additional_charges')->where("id", $id)->delete();
            $data = ['status' => 1, "msg" => "Additional charge deleted successfully!"];
        } else {
            $data = ['status' => 0, "msg" => "Opps somethings went wrong!"];
        }
        return $data;
    }

    public function getCountry() {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $country = DB::table($prifix . '_countries')->where("status", 1)->get(["id", "name"]);
        return $data = ['country' => $country];
    }

    public function getState() {
        $marchantId = Input::get("merchantId");
        $countryId = Input::get("countryId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $state = DB::table($prifix . '_zones')->where("status", 1)->where("country_id", $countryId)->orderBy("name", "asc")->get(["id", "name", "country_id"]);
        return $data = ['state' => $state];
    }

    public function getOnlinePage() {
        $marchantId = Input::get("merchantId");

        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $onlinePage = DB::table($prifix . '_static_pages')->orderBy("sort_order", "asc")->get();
        $filePath = "http://" . $merchant->url_key . '.' . $_SERVER['HTTP_HOST'] . '/uploads/staticpage/';
        foreach ($onlinePage as $page) {
            $page->filePath = $filePath . $page->image;
        }
        return $data = ['onlinePage' => $onlinePage];
    }

    public function updateOnlinePage() {
        $marchantId = Input::get("merchantId");
        $id = Input::get("id");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;

        $page = [];
        $page['page_name'] = Input::get('page_name');
        if (Input::get('link')) {
            $page['link'] = Input::get('link');
        }
        $page['description'] = Input::get('description');
        $page['url_key'] = Input::get('urk_key');
        $page['status'] = Input::get('status');
        $page['sort_order'] = Input::get('sort_order');
        $page['is_menu'] = Input::get('is_menu');
        $page['contact_details'] = Input::get('details');
        $logoimageData = Input::get("pageImage");
        if ($logoimageData) {
            $image_parts = explode(";base64,", $logoimageData);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $imgName = 'online_' . date("YmdHis") . '.' . $image_type;
            $image_base64 = base64_decode($image_parts[1]);
            $filePath = base_path() . '/merchants/' . $merchant->url_key . '/public/uploads/staticpage/' . $imgName;
            $images = file_put_contents($filePath, $image_base64);
            $page['image'] = $imgName;
        }
        if (!empty($id)) {
            DB::table($prifix . '_static_pages')->where("id", $id)->update($page);
            $onlinePage = DB::table($prifix . '_static_pages')->find($id);
          
              $filePath = "http://" . $merchant->url_key . '.' . $_SERVER['HTTP_HOST'] . '/uploads/staticpage/';
             $onlinePage->filePath=$filePath. $onlinePage->image;;
              $data = ["status" => 1, "mes" => "online page updated successfully", "onlinePage" => $onlinePage];
        } else {
            $data = ["status" => 0, "mes" => "Opps some thinngs went wrong!"];
        }
        return $data;
    }
    
    public function getStoreSetting(){
        $marchantId = Input::get("merchantId");      
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
       
        $languages = DB::table($prifix . '_language')->select('id', 'name')->get();
        $currency =HasCurrency::where('status', 1)->get();
        $storePath = base_path() . '/merchants/' . $merchant->url_key;
        $store = Helper::getStoreSettings($storePath);
        $themeData=$store['themedata'];
        
        foreach($themeData as $k=>$them){
                $themeData[$k]['themImage'] = asset('public/admin/themes/' . $themeData[$k]['image']);
               $themeData[$k]['themLink'] = asset('themes/' . strtolower($themeData[$k]['name']) . '_home.php?link=trsdadasd');
        }
      // dd($themeData);
        $store['themedata']=$themeData;
       $data=["store"=>$store,'languages'=>$languages,'currency'=>$currency];
       return $data; 
    }
    
    public function updateStoreSetting(){
        $marchantId = Input::get("merchantId");      
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix; 
        $logoImage = Input::get("logoImage");
        $storePath = base_path() . '/merchants/' . $merchant->url_key;
        $store = Helper::getStoreSettings($storePath);
        if($logoImage){
        $store['logo'] = $logoImage;
        }
        $store['storeName'] = Input::get("storeName");
//        $store['language'] =Input::get("language");
        $store['theme'] =Input::get("themename");
        $store['themeid'] =Input::get("themeId");
        $store['currencyId'] =Input::get("currencyId");
        $newSoter = json_encode($store);
        Helper::updateStoreSettings($storePath, $newSoter);
        $store1 = Helper::getStoreSettings($storePath);
        $currency=HasCurrency::where("iso_code",Input::get("currencyId"))->where('status', 1)->select('currency_val', 'css_code')->first();
       // $languages = DB::table($prifix . '_language')->select('id', 'name')->get();
       $storeName=Input::get("storeName");
       $data = ["status" => 1, "msg" => "Store Setting Updated successfully.","currency"=>$currency,'logo'=>$logoImage,'storeName'=>$storeName];
       return $data;
    }

     public function getContactDetails() {
        $marchantId = Input::get("merchantId");
        $url_key= Input::get("url_key");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $onlinePage = DB::table($prifix . '_static_pages')->where("url_key",$url_key)->first();
        $filePath = "http://" . $merchant->url_key . '.' . $_SERVER['HTTP_HOST'] . '/uploads/staticpage/';
     
        $onlinePage->filePath = $filePath . $onlinePage->image;
        return $data = ['onlinePage' => $onlinePage];
    }

    public function storeSeo(){
        $marchantId = Input::get("merchantId");      
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix; 
        $logoImage = Input::get("logoImage");
        $storePath = base_path() . '/merchants/' . $merchant->url_key;
        $store = Helper::getStoreSettings($storePath);
        
        $data['seoStoreList']['meta_title'] = $store['meta_title'];
        $data['seoStoreList']['meta_keys'] = $store['meta_keys'];
        $data['seoStoreList']['meta_desc'] = $store['meta_desc'];
        $data['seoStoreList']['meta_robot'] = $store['meta_robot'];
        $data['seoStoreList']['canonical'] = $store['canonical'];
        $data['seoStoreList']['social_shared_title'] = $store['title'];
        $data['seoStoreList']['social_shared_desc'] = $store['desc'];
        $data['seoStoreList']['social_shared_image'] = $store['image'];
        $data['seoStoreList']['social_shared_url'] = $store['url'];
        $data['seoStoreList']['google_analytics'] = $store['other_meta'];
        $data['seoStoreList']['country_id'] = $store['countryList'];
        $data['seoStoreList']['pincode_status'] = $store['pincode'];

        $viewname = "";
        return Helper::returnView($viewname, $data);
    }

    public function storeSaveSeo(){

        $marchantId = Input::get("merchantId");      
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix; 
        $logoImage = Input::get("logoImage");
        $storePath = base_path() . '/merchants/' . $merchant->url_key;
        $store = Helper::getStoreSettings($storePath);
        
        $store["meta_title"] = Input::get("meta_title");
        $store["meta_keys"] = Input::get("meta_keys");
        $store["meta_desc"] = Input::get("meta_desc");
        $store["meta_robot"] = Input::get("meta_robot");
        $store["canonical"] = Input::get("canonical");
        $store["title"] = Input::get("title");
        $store["desc"] = Input::get("desc");
        $store["image"] = Input::get("image");
        $store["url"] = Input::get("url");
        $store["other_meta"] = Input::get("other_meta");
        $store["countryList"] = Input::get("countryList");
        $store["pincode"] = Input::get("pincode");
        

        $storeList["meta_title"] = $store["meta_title"];
        $storeList["meta_keys"] = $store["meta_keys"];
        $storeList["meta_desc"] = $store["meta_desc"];
        $storeList["canonical"] = $store["canonical"];
        $storeList["title"] = $store["title"];
        $storeList["desc"] = $store["desc"];
        $storeList["image"] = $store["image"];
        $storeList["url"] = $store["url"];
        $storeList["other_meta"] = $store["other_meta"];
        $storeList["countryID"] = $store["countryList"];
        $storeList["pincodeStatus"] = $store["pincode"];
        
        $newSoter = json_encode($store);
        Helper::updateStoreSettings($storePath, $newSoter);
        
        $data = ["status" => 'Success', "msg" => "Store Seo updated Successfully!.", 'store' => $storeList];

        return $data;

    }
}
