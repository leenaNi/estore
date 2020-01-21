<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Merchant;
use App\Models\Category;
use App\Models\Store;
use App\Models\Bank;
use App\Models\Country;
use App\Models\Document;
use App\Models\Language;
use App\Models\StoreTheme;
use App\Models\Templates;
use App\Models\HasCurrency;
use App\Models\MerchantOrder;
use App\Models\Zone;
use Illuminate\Support\Facades\Input;
use Hash;
use File;
use DB;
use JWTAuth;
use ZipArchive;
use App\Library\Helper;
use Mail;
use Validator;
use Auth;
use Crypt;
use Session;
use stdClass;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;

class ApiCreateStoreController extends Controller {

    public function fbSignUpCheck() {
        $email = Input::get('email');
        $appId = Input::get('appId');


        $userDetails = Merchant::where("email", "=", $email)->first();
        if (empty($userDetails)) {
            $result = ['status' => '1', 'msg' => 'no match found'];
            return $result;
        } else {
            $token = JWTAuth::fromUser($userDetails);
            $user = JWTAuth::toUser($token);
            return response()->json(['status' => '0', 'msg' => 'User already register with us', 'result' => $user])->header('token', $token);
        }

//        if (count($userDetails) <= 0) {
//            $userData = new Merchant;
//            $userData->email = $userDataInput->email;
//            $userData->firstname = $userDataInput->first_name;
//            $userData->lastname = $userDataInput->last_name;
//            $userData->provider_id = $userDataInput->id;
//            $userData->save();
//            $getuser = $userData;
//        } else {
//            $getuser = $userDetails;
//        }
//
//
//        $token = JWTAuth::fromUser($getuser);
//        $user = JWTAuth::toUser($token);
//        return response()->json(['result' => $user])->header('token', $token);
    }

    public function signUpDropDown() {
        $cat = Category::where("status", 1)->pluck('category', 'id')->prepend('Industry *', '');
       
        $curr = HasCurrency::where('status', 1)->orderBy("iso_code", "asc")->get(['status', 'id', 'name', 'iso_code','currency_code']);
        // $themes = StoreTheme::where("cat_id", 1)->where("status", 1)->get(["id", "name", "image"]);
//            foreach($themes as $them){
//               $them->themImage=  asset('public/admin/themes/'.$them->image);
//               $them->themLink=  asset('themes/'.strtolower($them->name).'_home.php?link=trsdadasd');
//            }

        return $data = ['category' => $cat, 'currency' => $curr];
    }

    public function checkDomain() {
        $getvalue = Input::get('domain_name');
        $checkhttps = (isset($_SERVER['HTTPS']) === false) ? 'http' : 'https';
        $checkdomain = $checkhttps . "://" . $getvalue . "." . str_replace("www", "", $_SERVER['HTTP_HOST']);
        // dd($checkdomain);
        $storedomain = Store::pluck('store_domain')->toArray();

        if (in_array($checkdomain, $storedomain)) {
            return $data = ["status" => 0, "msg" => "This domain not available"];
        } else {
            return $data = ["status" => 1, "msg" => "Domain name available"];
        }
    }
  public function checkMobile() {
       $validation = new Merchant();
        $validator = Validator::make(Input::all(), Merchant::rules(), $validation->messages);
        if ($validator->fails()) {
            $errMsg = [];
            $err = $validator->messages()->toArray();

            foreach ($err as $ek => $ev) {
                $errMsg[$ek] = implode(",", $ev);
            }
                $data=["status"=>0,"msg"=>$errMsg];
            return $data;
        }else{
             return $data = ["status" => 1, "msg" => " available"];  
        }
//        $getvalue = Input::get('mobile');
//         $getMerchat = Merchant::where("phone",$getvalue)->first();
//        if (count($getMerchat) > 0) {
//            return $data = ["status" => 0, "msg" => "Your mobile is alreay register with us"];
//        } else {
//            return $data = ["status" => 1, "msg" => "mobile available"];
//        }
    }
    public function saveSignUp() {
        //$userDataInput = Json_decode(Input::get('userData'));
        $getMerchat = new Merchant;
        $appId = Input::get("appId");
        $allinput = Input::all();

        if (!empty($appId)) {

            $getMerchat->provider_id = $appId;
        } else {

            $getMerchat->password = Hash::make(Input::get('password'));
        }
        // $getMerchatCount = Merchant::where("email", '=', $email)->orWhere("phone", Input::get("phone"))->first();
//        if (count($getMerchatCount) > 0) {
//           $store=$getMerchatCount->getstores;
//            return $data = ["status" => 0,"storeCount"=>count($store) ,"msg" => "Email And phone are already used!"];
//        } else {
        $validation = new Merchant();
        $validator = Validator::make(Input::all(), Merchant::rules(), $validation->messages);
        if ($validator->fails()) {
            $errMsg = [];
            $err = $validator->messages()->toArray();

            foreach ($err as $ek => $ev) {
                $errMsg[$ek] = implode(",", $ev);
            }
                $data=["status"=>0,"msg"=>$errMsg];
            return $data;
        }
//            $validator = Validator::make($allinput, Merchant::rules());
//            if ($validator->fails()) {
//               $msg= $validator->messages()->toJson();
//             
//                $data=["status"=>0,"msg"=>$msg];
//                response()->json(["status" => 0,"msg"=>$msg]);
//                return $data;
//            }
        else {
            $getMerchat->email = Input::get("email");
            $getMerchat->firstname = Input::get("firstname");
            $getMerchat->company_name = Input::get("company_name");
            //$getMerchat->lastname = @$names[1];
            $getMerchat->phone = Input::get("phone");
            if(Input::get("country_code")){
            $getMerchat->country_code = Input::get("country_code");
            }
            $getMerchat->register_details = json_encode(Input::all());
            $getMerchat->save();
            $token = JWTAuth::fromUser($getMerchat);
            $user = JWTAuth::toUser($token);

            $store = $getMerchat->getstores;
            $data = ['storeCount'=>count($store)]; 
//            $themes = StoreTheme::where("cat_id", Input::get('business_type'))->where("status", 1)->get(["id", "name", "image"]);
//            foreach ($themes as $them) {
//                $them->themImage = asset('public/admin/themes/' . $them->image);
//                $them->themLink = asset('themes/' . strtolower($them->name) . 'home.php?link=trsdadasd');
//            }

            return response()->json(["status" => 1, 'result' => $user, 'setupStatus' =>$data])->header('token', $token);
        }
    }

    public function getTheme() {
        $themId = Input::get('business_type');
        if (!empty($themId)) {
            $themes = StoreTheme::where("cat_id", $themId)->where("status", 1)->orderBy('sort_orders','asc')->get(["id", "name", "image","theme_type"]);
            foreach ($themes as $them) {
                $them->themImage = asset('public/admin/themes/' . $them->image);
                $them->themLink = asset('themes/' . strtolower($them->name) . '_home.php?link=trsdadasd');
            }
            $data=["status"=>1,"theme"=>$themes];
        }else{
           $data=["status"=>0,"msg"=>"Opps Somethings went wrong"];  
        }
        return $data;
    }

    public function applyStoreTheme() {
        $merchantId = Input::get("merchantId");
        $getMerchat = Merchant::find($merchantId);
         $merchantPay = MerchantOrder::where("merchant_id", $merchantId)->where("order_status", 1)->where("payment_status", 4)->first();
        
        $themeId=Input::get('theme_id');
        $registerDetails = json_decode($getMerchat->register_details);
        $domainname = str_replace(" ", '-', trim(strtolower($registerDetails->domain_name), " "));
        $checkhttps = (isset($_SERVER['HTTPS']) === false) ? 'http' : 'https';
        $actualDomain = $checkhttps . "://" . $domainname . "." . str_replace("www", "", $_SERVER['HTTP_HOST']);
        $store =  Store::findOrNew(Session::get('stid'));
        $store->store_name = str_replace(" ", "-", (strtolower($registerDetails->storename)));
        $store->url_key = $domainname;
        $store->merchant_id = $getMerchat->id;
        $store->category_id = Input::get('business_type');
        $store->template_id = $themeId;
        $store->store_domain = $actualDomain;
        $store->expiry_date = date('Y-m-d', strtotime(date("Y-m-d") . " + 365 day"));
        $store->status = 1;
        if (empty(Input::get("id"))) {
            if (!empty(Input::get("url_key"))) {
                $chkUrlKey = Store::where("url_key", Input::get("url_key"))->count();
                if ($chkUrlKey == 0)
                    $store->url_key = Input::get("url_key");
            }
            $store->prefix = $this->getPrefix($domainname);
        }
        $merchantEamil = $getMerchat->email;
        $merchantPassword = $getMerchat->password;
        $firstname = $getMerchat->firstname;
        if (count($merchantPay) > 0) {
            $registerDetails->store_version = 2;
        } else {
            $registerDetails->store_version = 1;
        }
        if ($store->save()) {
            Session::put('stid',$store->id);
            
            if (empty($themeInput->id)) {
                $password = @$registerDetails->password;
                $appId = @$registerDetails->appId;
                $this->createInstance($store->id,$store->prefix, $store->url_key,$registerDetails, $password,  $themeId, $firstname, $domainname, $store->expiry_date, $appId);
            }
        }
        $getMerchat->register_details=json_encode($registerDetails);
        $getMerchat->save();
//        $data = [];
//        $data['id'] = $store->id;
//        
//        $data['storedata'] = $store;
//        $data['status'] = "1";
        Session::forget("stid");
        $userData=app('App\Http\Controllers\Admin\ApiMerchantController')->fbMerchantLogin($getMerchat->email);
       // App/Http/Controller/Admin/ApiMerchantController->fbMerchantLogin($getMerchat->email);
      //  App\Http\Controllers\Admin\ApiMerchantController->fbMerchantLogin($getMerchat->email);
        return $userData;
        // $data['userdata'] = $userData;
      //  return $data;
        return "Success";
        
    }

    public function createInstance($storeId,$prefix, $urlKey,$registerDetails,$merchantPassword,$themeid,  $firstname, $domainname,$expirydate,$appId=null) {
        $merchantEamil=$registerDetails->email;
        $storeName=$registerDetails->storename;
       $catid= $registerDetails->business_type;
        $currency=$registerDetails->currency;
       $phone= $registerDetails->phone;
       $storeVersion=$registerDetails->store_version;
        ini_set('max_execution_time', 600);


        $messagearray = '[{"type": "A","name": "' . $domainname . '","data": "13.234.230.182","ttl": 3600}]';
        $fields = array(
            'data' => $messagearray
        );
        //building headers for the request
        $headers = array(
            'Authorization: sso-key dKYQNqECqY1B_KeALbMxBuuwsR54jgwibDA:KeANr8XdSMqcwF9y5CjCZe',
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.godaddy.com/v1/domains/' . $_SERVER['HTTP_HOST'] . '/records');
        //setting the method as post
        // curl_setopt($ch, CURLOPT_POST, true);
        //adding headers
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
        //disabling ssl support
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        //adding the fields in json format
        curl_setopt($ch, CURLOPT_POSTFIELDS, $messagearray);

        //finally executing the curl request
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
        //stop Curl


        $contents = File::get(public_path() . "/public/skeleton.sql");
        $sql = str_replace("tblprfx", $prefix, $contents);
        $test = DB::unprepared($sql);
        if (DB::unprepared($sql)) {
            $path = base_path() . "/merchants/"."$domainname";

            $mk = File::makeDirectory($path, 0777, true, true);
            if(chmod($path, 0777)){
                chmod($path, 0777);
            }
            if ($mk) {
                $file = public_path() . '/public/skeleton.zip';
                $zip = new ZipArchive;
                $res = $zip->open($file);

                if ($res == true) {
                    $zip->extractTo($path);
                    $zip->close();
                    $this->replaceFileString($path . "/.env", "%DB_HOST%", env('DB_HOST', ''));
                    $this->replaceFileString($path . "/.env", "%DB_DATABASE%", env('DB_DATABASE', ''));
                    $this->replaceFileString($path . "/.env", "%DB_USERNAME%", env('DB_USERNAME', ''));
                    $this->replaceFileString($path . "/.env", "%DB_PASSWORD%", env('DB_PASSWORD', ''));
                    $this->replaceFileString($path . "/.env", "%DB_TABLE_PREFIX%", $prefix . "_");
                    $this->replaceFileString($path . "/.env", "%STORE_NAME%", "$domainname");
                    $this->replaceFileString($path . "/.env", "%STORE_ID%", "$storeId");

                    $insertArr = [
                        "email" => "$merchantEamil", "user_type" => 1, "status" => 1, "telephone" => "$phone", "firstname" => "$firstname", "store_id" => "$storeId", "prefix" => "$prefix"];
                    if (!empty($merchantPassword)) {
                        $randno = $merchantPassword;
                        $password = Hash::make($randno);
                        $insertArr["password"] =$password;
                    }
                    if($appId){
                         $insertArr["provider_id"] =$appId;
                    }
                     $country_code=$registerDetails->country_code;
                     if ($country_code) {
                        $insertArr["country_code"] = "$country_code";
                    }
                    $newuserid = DB::table("users")->insertGetId($insertArr);

                    $json_url = base_path() . "/merchants/" . $domainname . "/storeSetting.json";
                    $json = file_get_contents($json_url);
                    $decodeVal = json_decode($json, true);
                    $decodeVal['industry_id'] = $catid;
                    $decodeVal['storeName'] = $storeName;
                    $decodeVal['expiry_date'] = $expirydate;
                    $decodeVal['store_id'] =$storeId;
                    $decodeVal['prefix'] = $prefix;
                    $decodeVal['country_code'] = $country_code;

                    if (!empty($themeid)) {
                        $themedata = DB::select("SELECT t.id,c.category,t.theme_category as name,t.image from themes t left join categories c on t.cat_id=c.id where t.cat_id = " . $catid . " order by c.category");
                        $decodeVal['theme'] = strtolower(StoreTheme::find($themeid)->theme_category);
                        $decodeVal['themeid'] =$themeid;
                        $decodeVal['themedata'] = $themedata;
                        $decodeVal['currencyId'] = @HasCurrency::find($currency)->iso_code;
                        $decodeVal['store_version'] =@$storeVersion;
                        $newJsonString = json_encode($decodeVal);
                    }


                    if (!empty($currency)) {

                        $decodeVal['currency'] = $currency;
                        $decodeVal['currency_code'] = @HasCurrency::find($currency)->iso_code;
                        $currVal = @HasCurrency::find($currency);
                        if (!empty($currVal)) {
                            $currJson = json_encode(['name' => $currVal->name, 'iso_code' => $currVal->iso_code]);
                            DB::table("general_setting")->insert(['name' => 'Default Currency', 'status' => 0, 'details' => $currJson, 'url_key' => 'default-currency', 'type' => 1, 'sort_order' => 10000, 'is_active' => 0, 'is_question' => 0]);
                        }
                    }
    //Update Email Setting for mandrill and SMTP
                    $emailSett = array("mandrill", "smtp");
                    foreach ($emailSett as $email) {
                        $emaildetails = json_decode(DB::table($prefix . "_general_setting")->where('url_key', $email)->first()->details);
                        $emaildetails->name = $storeName;
                        DB::table("general_setting")->where('url_key', $email)->update(["details" => json_encode($emaildetails)]);
                    }
                    //End Email Setting Update
                    $fp = fopen( base_path() . "/merchants/" . $domainname . '/storeSetting.json', 'w+');
                    fwrite($fp, $newJsonString);
                    fclose($fp);


                    DB::table("role_user")->insert([
                        ["user_id" => @$newuserid, "role_id" => "1"]
                    ]);
                    //Check acl setting from general settings
                    $chkAcl = DB::table("general_setting")->where('url_key', 'acl')->select("status")->first();

                    if ($chkAcl->status == '1') {
                        $allPermissions = DB::table("permissions")->select("id")->get();
                        $permissions = [];
                        foreach ($allPermissions as $key => $ap) {
                            $permissions[$key]['permission_id'] = $ap->id;
                            $permissions[$key]['role_id'] = 1;
                        }
                        $insertPermission = DB::table("permission_role")->insert($permissions);
                    }

                    if (!empty($catid)) {
                        Helper::saveDefaultSet($catid, $prefix);
                    }
                   // $banner = json_decode((Category::where("id", $catid)->first()->banner_image), true);
                     $banner = json_decode((StoreTheme::where("id", $themeid)->first()->banner_image), true);
                    if (!empty($banner)) {
                     foreach ($banner as $image) {
                        $homePageSlider=[];
                        $file = $image['banner'];
                        $homePageSlider['layout_id'] = 1;
                        $homePageSlider['name'] = $image['banner_text'];
                        $homePageSlider['is_active'] = $image['banner_status'];
                        $homePageSlider['image'] = $image['banner'];
                        $homePageSlider['sort_order'] = $image['sort_order'];
                        $source = public_path() . '/public/admin/themes/';
                        $destination = base_path() . "/merchants/" . $domainname . "/public/uploads/layout/";
                        copy($source . $file, $destination . $file);
                        DB::table("has_layouts")->insert($homePageSlider);
                    }
                    }
                    $threeBoxes = json_decode((Category::where("id", $catid)->first()->threebox_image), true);
                    
                    // $threeBoxes = json_decode((StoreTheme::where("id", $themeid)->first()->threebox_image), true);
                    if (!empty($threeBoxes)) {
                    foreach ($threeBoxes as $image) {
                        $homePageSlider=[];
                        $file = $image['banner'];
                        $homePageSlider['layout_id'] = 4;
                        $homePageSlider['name'] = $image['banner_text'];
                        $homePageSlider['is_active'] = $image['banner_status'];
                        $homePageSlider['image'] = $image['banner'];
                        $homePageSlider['sort_order'] = $image['sort_order'];
                        $source = public_path() . '/public/admin/themes/';
                        $destination = base_path() . "/merchants/" . $domainname . "/public/uploads/layout/";
                        copy($source . $file, $destination . $file);
                        DB::table("has_layouts")->insert($homePageSlider);
                    }
                    }
                  if ($phone) {
                        $msgOrderSucc = "Congrats! Your new Online Store is ready. Download eStorifi Merchant Android app to manage your Online Store. Download Now https://goo.gl/kUSKro";
                        Helper::sendsms($phone, $msgOrderSucc, $country_code);
                    }
                    // permission_role
                    $baseurl = str_replace("\\", "/", base_path());
                    $domain = 'eStorifi.com'; //$_SERVER['HTTP_HOST'];
                    $sub = "eStorifi Links for Online Store - " . $storeName;
                    $mailcontent = "<b>Congratulations  " . $storeName ." has been created successfully!</b>" . "\n\n";
                    $mailcontent .= "Kindly find the links to view your store:" . "\n";
                    
                    $mailcontent .= "Store Admin Link: http://" . $domainname . '.' . $domain . "/admin" . "\n";
                    $mailcontent .= "Online Store Link: http://" . $domainname . '.' . $domain . "\n";
                    $mailcontent .= "For any further assistance/support, contact http://eStorifi.com/contact" . "\n\n";
                    if (!empty($merchantEamil)) {
                        Helper::withoutViewSendMail($merchantEamil, $sub, $mailcontent);
                    }
                    return "Extracted Successfully to $path";
                } else {
                    return "Error Encountered while extracting the Zip";
                }
            } else {
                return "Access Denied";
            }
        } else {
            return "Error Encountered while processing the SQL";
        }
    }

    public function getPrefix($storeName) {
        $newPrefix = substr($storeName, 0, 4) . mt_rand(100000, 999999);
        $chkPrfix = Store::where("prefix", "=", $newPrefix)->count();
        if ($chkPrfix > 0)
            $this->getPrefix($storeName);
        else
            return $newPrefix;
    }

    public function checkStore() {
        $storename = Input::get('storename');
        $storename = strtolower(str_replace(' ', '', $storename));
        $chekcStoreName = DB::select("SELECT lower(REPLACE(`store_name`,' ','')) FROM `stores` where `store_name` ='{$storename}'");

        if (!empty($chekcStoreName)) {
            echo 1;
        } else {
            echo 0;
        }
    }
   public function replaceFileString($FilePath, $OldText, $NewText) {
        $Result = array('status' => 'error', 'message' => '');
        if (file_exists($FilePath) === TRUE) {
            if (is_writeable($FilePath)) {
                try {
                    $FileContent = file_get_contents($FilePath);
                    $FileContent = str_replace($OldText, $NewText, $FileContent);
                    if (file_put_contents($FilePath, $FileContent) > 0) {
                        $Result["status"] = 'success';
                    } else {
                        $Result["message"] = 'Error while writing file';
                    }
                } catch (Exception $e) {
                    $Result["message"] = 'Error : ' . $e;
                }
            } else {
                $Result["message"] = 'File ' . $FilePath . ' is not writable !';
            }
        } else {
            $Result["message"] = 'File ' . $FilePath . ' does not exist !';
        }
        return $Result;
    }
    
      public function sendOtp() {
        $country = Input::get("country_code");
        $mobile = Input::get("mobile");
        $otp = rand(1000, 9999);
        Session::put('otp', $otp);

        if ($mobile) {
            $msgOrderSucc = "Your one time password is. " . $otp . ". Contact 1800 3000 2020 for real time support.! Team eStorifi";
            Helper::sendsms($mobile, $msgOrderSucc, $country);
        }
        $data = ["status" => "success", "msg" => "OTP Successfully send on your mobileNumber", "otp"=>$otp];
        return $data;
    } 
}
