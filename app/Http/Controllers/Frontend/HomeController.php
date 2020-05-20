<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Library\Helper;
use App\Models\Category;
use App\Models\Country;
use App\Models\Currency;
use App\Models\HasCurrency;
use App\Models\Merchant;
use App\Models\MerchantOrder;
use App\Models\Settings;
use App\Models\Store;
use App\Models\User;
use App\Models\Vendor;
use App\Models\StoreTheme;
use App\Models\Templates;
use App\Models\HasCurrency;
use App\Models\Zone;
use Illuminate\Support\Facades\Input;
use GuzzleHttp\Client;
use Hash;
use File;
use DB;
use ZipArchive;
use App\Library\Helper;
use Mail;
use Session;
use Validator;
use Auth;
use Crypt;
use Session;
use stdClass;
use Schema;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function isJson($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    public function index()
    {
        Session::forget('storename');
        //  dd("after sent mIL");
        Session::forget('merchantEmail');
        Session::forget('merchantName');
        Session::forget('fbId');
        $data = [];
        $viewname = Config('constants.frontendView') . ".index";
        return Helper::returnView($viewname, $data);
    }

    public function checkStore()
    {
        $storename = Input::get('storename');
        $storename = strtolower(str_replace(' ', '', $storename));
        $chekcStoreName = DB::select("SELECT lower(REPLACE(`store_name`,' ','')) FROM `stores` where `store_name` ='{$storename}'");

        if (!empty($chekcStoreName)) {
            echo 1;
        } else {
            echo 0;
        }
    }

    public function newStore()
    {
        // if (Session::get('merchantid')) {
        //     Session::flash('storeadded', 'You can not create more than one store.');

        //     return redirect()->to("/select-themes");
        // }
        Session::flush();
        $cat = Category::where("status", 1)->pluck('category', 'id')->prepend('Industry *', '');
        $settings = Settings::where('bank_id', 0)->first();
        $country = Country::where("id", $settings->country_id)->get()->first();
        $currency = Currency::where("id", $settings->currency_id)->get()->first();
        $settings['country_code'] = $country['country_code'];
        $settings['country_name'] = $country['name'];
        $settings['currency_code'] = $currency['currency_code'];
        $curr = HasCurrency::where('status', 1)->orderBy("currency_code", "asc")->get(['status', 'id', 'name', 'iso_code', 'currency_code']);
        $viewname = Config('constants.frontendView') . ".new-store";
        //$data = ['cat' => $cat, 'curr' => $curr,'default_currency'=>$settings['id'],'default_country'=>$country['country_code']];
        $data = ['cat' => $cat, 'curr' => $curr, 'settings' => $settings];
        //echo "<pre>";print_r($data);
        return Helper::returnView($viewname, $data);
    }

    public function checkDomainAvail() {
        $getvalue = Input::get('domain_name');
        $checkhttps = (isset($_SERVER['HTTPS']) === false) ? 'http' : 'https';
        $checkdomain = $checkhttps . "://" . $getvalue . "." . str_replace("www", "", $_SERVER['HTTP_HOST']);
        // dd($checkdomain);
        $storedomain = Store::pluck('store_domain')->toArray();
        if (in_array($checkdomain, $storedomain)) {
            return 1;
        } else {
            return 0;
        }
    }

    public function availDomain($availdomain)
    {
        // if (!empty(Input::get('availdomain'))) {
        //     $availdomain = Input::get('availdomain');
        // }
        $domainname = str_replace(" ", '-', trim(strtolower($availdomain), " "));
        $checkhttps = (isset($_SERVER['HTTPS']) === false) ? 'http' : 'https';
        $checkdomain = $checkhttps . "://" . $domainname . "." . str_replace("www", "", $_SERVER['HTTP_HOST']);
        $storedomain = Store::pluck('store_domain')->toArray();
        if (in_array($checkdomain, $storedomain)) {
            $domainname = $domainname . rand(100, 999);
            $this->availDomain($domainname);
            return $domainname;
            //print_r('name '.$domainname);
            //return $availability = "icon-remove red-close";
        } else {
            return $domainname;
        }
    }

    public function selectThemes()
    {   
        $themeIds = MerchantOrder::where("merchant_id", Session::get('merchantid'))->where("order_status", 1)->where("payment_status", 4)->pluck("merchant_id")->toArray();
       // dd(Session::get('merchantid'));
       if (empty(Input::get('store_name')) && empty(Session::get('merchantid'))) {
            $cats = Category::where("status", 1)->get();
            $data = ['cats' => $cats, 'themeIds' => $themeIds];
            $viewname = Config('constants.frontendView') . ".select-themes";
            return Helper::returnView($viewname, $data);
        }
        if (empty(Session::get('merchantid'))) {
            $allinput = Input::all();
            $cats = Category::where("status", 1)->where('id',$allinput['business_type'])->get();
            $allinput['is_individual_store'] = 0;
            $storeType = $allinput['roleType'];
            $sendmsg = "Registred successfully.";
            $merchantObj = new Merchant();
            $merchantObj->company_name = $allinput['store_name'];
            $merchantObj->phone = $allinput['phone'];
            $merchantObj->country_code = $allinput['country_code'];
            $merchantObj->register_details = json_encode($allinput);
            $merchantObj->save();
            $lastInsteredId = $merchantObj->id;
            if ($lastInsteredId > 0) {
                $merchantObj1 = Merchant::find($lastInsteredId);
                $indentityCode = Helper::createUniqueIdentityCode($allinput, $lastInsteredId);
                $merchantObj1->identity_code = $indentityCode;
                $merchantObj1->save();
            }
            Session::put('merchantid', $lastInsteredId);
            Session::put('storename', $allinput['store_name']);
            Session::put('industry_type', $allinput['business_type']);
            Session::put('merchantstorecount', 0);

        } else {
            $allinput = json_decode(Merchant::find(Session::get('merchantid'))->register_details, true);
            $cats = Category::where("status", 1)->where('id',$allinput['business_type'])->get();
            $checkStote = Merchant::find(Session::get('merchantid'))->getstores()->count();
            Session::put('merchantstorecount', $checkStote);
        }
        $data['themeInput'] = json_encode($allinput);
        $data['cats'] = $cats;
        $data['themeIds'] = $themeIds;
        $data['allinput'] = $allinput;
        $viewname = Config('constants.frontendView') . ".select-themes";
        //$viewname = Config('constants.frontendView') . ".wait-process";
        return Helper::returnView($viewname, $data);
    }

    public function distributorSignup()
    {
        if (empty(Session::get('merchantid'))) {
            $allinput = Input::all();
            $storeType = $allinput['roleType'];
            $allinput['is_individual_store'] = 0;
            $sendmsg = "Registred successfully.";
            $distributorObj = new Vendor();
            $distributorObj->country = $allinput['country_code'];
            $distributorObj->business_name = $allinput['store_name'];
            $distributorObj->phone_no = $allinput['phone'];
            $distributorObj->currency_code = $allinput['currency_code'];
            $distributorObj->register_details = json_encode($allinput);
            $distributorObj->save();
            $lastInsteredId = $distributorObj->id;

            if ($lastInsteredId > 0) {
                $distributorObj1 = Vendor::find($lastInsteredId);
                $indentityCode = Helper::createUniqueIdentityCode($allinput, $lastInsteredId);
                $distributorObj1->identity_code = $indentityCode;
                $distributorObj1->save();
            }

            Session::put('merchantid', $lastInsteredId);
            Session::put('storename', $allinput['store_name']);
            Session::put('merchantstorecount', 0);
            Session::put('industry_type', $allinput['business_type']);

        } else {
            $allinput = json_decode(Vendor::find(Session::get('merchantid'))->register_details, true);
            //$checkStote = Vendor::find(Session::get('merchantid'))->getstores()->count();
            $checkStote = Vendor::find(Session::get('merchantid'))->count();
            Session::put('merchantstorecount', $checkStote);
        }
        $data['themeInput'] = json_encode($allinput);

        // For distributor redirect on intermediat page
        $viewname = Config('constants.frontendView') . ".wait-process";
        return Helper::returnView($viewname, $data);
    } // End distributorSignup()

    public function createUniqueIdentityCode($allinput, $lastInsteredId) // for merchnat and distributor

    {
        $storeName = $allinput['store_name'];
        $storeName = preg_replace("/[^a-zA-Z]/", "", $storeName);
        $phoneNo = $allinput['phone'];
        $randomFourDigit = rand(1000, 9999);
        $indentityCode = substr($storeName, 0, 3) . substr($phoneNo, -3) . $lastInsteredId . $randomFourDigit;
        //dd($indentityCode);
        return $indentityCode;

    } // End createUniqueIdentityCode
    public function checkUser()
    {
        dd(Input::all());
    }

    public function checkFbUserLogin() {
        $FbUser = Input::get('userData');
        Session::put('merchantEmail', $FbUser['email']);
        Session::put('merchantName', $FbUser['first_name']);
        Session::put('fbId', $FbUser['id']);
        $userDetails = Merchant::where("email", "=", $FbUser['email'])->first();
        if (!empty($userDetails)) {
            $store = $userDetails->getstores()->count();
            Session::put('merchantid', $userDetails->id);
            if ($store > 0) {
                Auth::guard('merchant-users-web-guard')->login($userDetails);

                if (Auth::guard('merchant-users-web-guard')->check()) {

                    Session::put('merchantstorecount', $store);
                }
                $result = ['status' => '2', 'route' => route('veestoreMyaccount'), 'user' => $userDetails];
            } else {
                $result = ['status' => '0', 'user' => $userDetails];
            }
        } else {
            $result = ['status' => '1', 'msg' => "You are not registered with us."];
        }
        return $result;
    }

    public function checkFbUser() {
        $FbUser = Input::get('userData');
        Session::put('merchantEmail', $FbUser['email']);
        Session::put('merchantName', $FbUser['first_name']);
        Session::put('fbId', $FbUser['id']);
        $userDetails = Merchant::where("email", "=", $FbUser['email'])->first();
        if (empty($userDetails)) {
            $result = ['status' => '1', 'msg' => 'Merchant not found.'];
        } else {
            $result = ['status' => '2', 'msg' => 'You are already register with us.'];
        }
        return $result;
    }

    public function confirmMail($alldata) {
        $data = $alldata;

        $email = $data->email;
        $firstname = $data->firstname;

        //        Mail::send('Frontend.pages.emails.storeConfirmation', ['firstname' => $firstname], function ($m) use ($email, $firstname) {
        //            $m->to($email, $firstname)->subject('Thank you for registering with VeeStores');
        //            //$m->cc('madhuri@infiniteit.biz');
        //        });
    }

    public function congrats()
    {   
       
       //dd(Input::get('themeInput'));
        $themeInput = (object) Input::get('themeInput');
        $storename = str_replace(" ", '-', trim(strtolower($themeInput->domain_name), " "));
        $domainname = $this->availDomain($storename);
        $checkhttps = (isset($_SERVER['HTTPS']) === false) ? 'http' : 'https';
        $actualDomain = $checkhttps . "://" . $domainname . "." . str_replace("www", "", $_SERVER['HTTP_HOST']);
        $actualDomain = str_replace("..", ".", $actualDomain);

        // if (!empty($themeInput->email)) {
        //     // $this->confirmMail($themeInput);
        // }
        //$storeType = $themeInput->roleType;

        $storeType = $themeInput->roleType;
        //echo "session :: ".Session::get('merchantid');exit;
        if ($storeType == 'merchant') {
            $getMerchat = Merchant::find(Session::get('merchantid'));
        } else {
            $getMerchat = Vendor::find(Session::get('merchantid'));
        }
        $decoded = json_decode($getMerchat->register_details, true);
        //$decoded['business_type'] = ["17"];
        $decoded['business_type'] = $decoded['business_type'];
        $json = json_encode($decoded);
        $getMerchat->register_details = $json;
        $getMerchat->save();
        //get distributor id. Variable name is kept merchantid to avoid any issue in the old code.
        $registerDetails = json_decode($getMerchat->register_details);
        $store = new Store();
        $store->store_name = Session::get('storename'); // $registerDetails->store_name;
        $store->url_key = $domainname;
        $store->store_type = $storeType; // merchant/distributor
        $store->merchant_id = $getMerchat->id;

        if ($storeType == 'merchant') //Theme selection is available only for merchants
        {
            $phoneNo = $getMerchat->phone;
            $store->template_id = $themeInput->theme_id;
            //$store->category_id = 17;
            $store->category_id = $decoded['business_type'];
            $storeName = $themeInput->storename;
        } else {
            $phoneNo = $getMerchat->phone_no;
            //$themeInput->cat_id = $themeInput->business_type;
            //$themeInput->storename = @$themeInput->store_name;
            $storeName = $themeInput->store_name;
            $themeInput->theme_id = 0;
            $store->template_id = 0;
            $store->category_id = $decoded['business_type'];
        }
        $store->store_domain = $actualDomain;
        $store->percent_to_charge = 1.00;
        $store->expiry_date = date('Y-m-d', strtotime(date("Y-m-d") . " + 365 day"));
        $store->status = 1;
        $merchantPay = MerchantOrder::where("merchant_id", Session::get('merchantid'))->where("order_status", 1)->where("payment_status", 4)->first();
        if (count($merchantPay) > 0) {
            $themeInput->store_version = 2;
            $store->store_version = 2;
        } else {
            $themeInput->store_version = 1;
            $store->store_version = 1;
        }
        if (empty($themeInput->id)) {
            // if (!empty($themeInput->url_key)) {
            //     $chkUrlKey = Store::where("url_key", $themeInput->url_key)->count();
            //     if ($chkUrlKey == 0) {
            //         $store->url_key = $themeInput->url_key;
            //     }
            // }
            $store->prefix = $this->getPrefix($domainname);
        }
        // $merchantEamil = $getMerchat->email;
        // $merchantPassword = $getMerchat->password;
        $storeVersion = $themeInput->store_version;
        // $firstname = $getMerchat->firstname;
        $identityCode = $getMerchat->identity_code;
        // if (!empty($themeInput->password)) {
        //     $password = $themeInput->password;
        // } else {
        //     $password = '';
        // }
        $password = '';
        if ($store->save()) {
            //dd("teme id >> ".$themeInput->theme_id);
            if (empty($themeInput->id)) {
                //dd((object) Input::get('themeInput')." :: ".$storeType);
                $result = $this->createInstance($storeType, $store->id, $store->prefix, $store->url_key, $password, $storeName, $themeInput->currency_code, $phoneNo, $domainname, $storeVersion, $store->expiry_date, $identityCode, $themeInput->theme_id);
                // dd($result);
            }
        }


        $data = [];
        $data['id'] = $store->id;

        $data['status'] = "success";
        Session::forget("storeId");

        return $data;
    }

    public function getcongrats()
    {
        // echo "getcongrats  call function";
        // if(Input::get('id')){
        $dataS = [];
        $dataS['id'] = Input::get('id'); // 3; //
        $dataS['storedata'] = Store::find(Input::get('id')); // Store::find(3); // ;
        $viewname = Config('constants.frontendView') . ".success";
        return Helper::returnView($viewname, $dataS);
        // } else {
        //     return redirect()->route('home');
        // }
    }

    public function createInstance($storeType, $storeId, $prefix, $urlKey, $merchantPassword, $storeName, $currency, $phone, $domainname, $storeVersion, $expirydate, $identityCode ,$themeid)
    {
        //echo "createInstance function storeid >> $storeId ";
        //echo "<br> Cat array >> <pre>";print_r($catid);
        //$catid = 17;
        $catid = Session::get('industry_type');
        ini_set('max_execution_time', 600);
        if ($storeType == 'merchant') {
            $merchantd = Merchant::find(Session::get('merchantid'));
            $country_code = $merchantd->country_code;
        } else {
            $distributorData = Vendor::find(Session::get('merchantid')); // distributor
            $country_code = $distributorData->country;
        }
        $messagearray = '[{"type": "A","name": "' . $domainname . '","data": "' . env('GODADDY_IP') . '","ttl": 3600}]';
        $fields = array(
            'data' => $messagearray
        );
        //building headers for the request
        $headers = array(
            'Authorization: sso-key '.env('GODADDY_KEY'),
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, Config('constants.domainURL') . $_SERVER['HTTP_HOST'] . '/records');
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
//        //stop Curl


        // skeleton.sql :: This file contain with all the master table insert query which will run whenever new store created
        $contents = File::get(public_path() . "/public/skeleton.sql");
        $sql = str_replace("tblprfx", $prefix, $contents);
        $test = DB::unprepared($sql);

        if ($test) {
            $path = base_path() . "/merchants/" . "$domainname";

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
                    $this->replaceFileString($path . "/.env", "%IS_INDIVIDUAL_STORE%", "0");
                    
                    //Last record
                    $lastUser = DB::table('users')->latest('id')->first();
                    if (isset($lastUser) && !empty($lastUser)) {
                        $lastRecordUserId = $lastUser->id + 1;
                    } else {
                        $lastRecordUserId = 1;
                    }

                    if ($storeType == 'merchant') {
                        $userType = 1;
                    } else {
                        $userType = 3; // distributor
                    }
                    $insertArr = ["id" => ($lastRecordUserId), "user_type" => $userType, "status" => 1, "telephone" => "$phone", "store_id" => "$storeId", "prefix" => "$prefix"];
                    if (!empty($merchantPassword)) {
                        $randno = $merchantPassword;
                        $password = Hash::make($randno);

                        $insertArr["password"] = "$password";
                    }
                    if ($country_code) {
                        $insertArr["country_code"] = "$country_code";
                    }
                    $newuserid = DB::table("users")->insertGetId($insertArr);

                    // This json(product_category_json) file contain category id wise product and category data(static)
                    $insertedProductIdArray = array();
                    $productsData = DB::table('products')->select(DB::raw("GROUP_CONCAT(id) as product_id"))->where('store_id', $storeId)->get();
                    $insertedProductId = $productsData[0]->product_id;
                    $insertedProductIdArray = explode(",", $insertedProductId);

                    $jsonDataFromFile = File::get(public_path() . "/public/product_category_json.json");
                    $decodedJsonData = json_decode(trim($jsonDataFromFile), true);

                    for ($j = 0; $j < count($insertedProductIdArray); $j++) {
                        $categoryId = $catid;
                        if ($categoryId != 1) {
                            $productId = $insertedProductIdArray[$j];
                            //echo "\ncat >> ".$categoryId." :: product >> ".$productId;
                            $categoryJsonData = $decodedJsonData[$categoryId];
                            $productName = $categoryJsonData['product_name'];
                            //echo "\np name >> ".$productName;
                            $urlKey = $categoryJsonData['url_key'];
                            $prodType = $categoryJsonData['prod_type'];
                            $stock = $categoryJsonData['stock'];
                            $cur = $categoryJsonData['cur'];
                            $maxPrice = $categoryJsonData['max_price'];
                            $minPrice = $categoryJsonData['min_price'];
                            $purchasePrice = $categoryJsonData['purchase_price'];
                            $price = $categoryJsonData['price'];
                            $splPrice = $categoryJsonData['spl_price'];
                            $sellingPrice = $categoryJsonData['selling_price'];
                            $categoryFilename = $categoryJsonData['category_filename'];
                            $altText = $categoryJsonData['alt_text'];
                            $imageType = $categoryJsonData['image_type'];
                            $imageMode = $categoryJsonData['image_mode'];
                            $sortOrder = $categoryJsonData['sort_order'];
                            $imagePath = $categoryJsonData['image_path'];

                            DB::table('products')->where([['store_id', $storeId], ['id', $productId]])->update(
                                ['product' => $productName, 'url_key' => $urlKey, 'prod_type' => $prodType, 'stock' => $stock, 'cur' => $cur, 'max_price' => $maxPrice, 'min_price' => $minPrice, 'purchase_price' => $purchasePrice, 'price' => $price, 'spl_price' => $splPrice, 'selling_price' => $sellingPrice]
                            );
                            DB::table('catalog_images')->where('catalog_id', $productId)->delete();
                            DB::table('catalog_images')->insert(['filename' => $categoryFilename, 'alt_text' => $altText, 'image_type' => $imageType, 'image_mode' => $imageMode, 'catalog_id' => $productId, 'sort_order' => $sortOrder, 'image_path' => $imagePath]);
                        } // End check if
                    } // End j loop


                    $json_url = base_path() . "/merchants/" . $domainname . "/storeSetting.json";
                    $json = file_get_contents($json_url);
                    $decodeVal = json_decode($json, true);
                    $decodeVal['industry_id'] = $catid;
                    $decodeVal['storeName'] = $storeName;
                    $decodeVal['expiry_date'] = $expirydate;
                    $decodeVal['store_id'] = $storeId;
                    $decodeVal['prefix'] = $prefix;
                    $decodeVal['country_code'] = $country_code;


                    if (!empty($themeid)) {
                        $themedata = DB::select("SELECT t.id,c.category,t.theme_category as name,t.image from themes t left join categories c on t.cat_id=c.id where t.cat_id = " . $catid . " order by c.category");
                        $decodeVal['theme'] = strtolower(StoreTheme::find($themeid)->theme_category);
                        $decodeVal['themeid'] = $themeid;
                        $decodeVal['themedata'] = $themedata;
                        $decodeVal['currencyId'] = @HasCurrency::find($currency)->iso_code;
                        $decodeVal['store_version'] = @$storeVersion;
                    }

                    $newJsonString = json_encode($decodeVal);

                    $fp = fopen(base_path() . "/merchants/" . $domainname . '/storeSetting.json', 'w+');
                    fwrite($fp, $newJsonString);
                    fclose($fp);

                    if (!empty($catid)) {
                        Helper::saveDefaultSet($catid, $prefix, $storeId, $storeType);
                    }
                    if((!empty($themeid)) && ($themeid!=0)){
                        $this->selectThemesdata($storeId,$themeid,$catid, $domainname);
                    }


                    if (!empty($currency)) {

                        $decodeVal['currency'] = $currency;
                       $decodeVal['currency_code'] = HasCurrency::find($currency)->iso_code;

                        $currVal = HasCurrency::find($currency);
                        if (!empty($currVal)) {
                            $currJson = json_encode(['name' => $currVal->name, 'iso_code' => $currVal->iso_code]);
                            DB::table($prefix . "_general_setting")->insert(['name' => 'Default Currency', 'status' => 0, 'details' => $currJson, 'url_key' => 'default-currency', 'type' => 1, 'sort_order' => 10000, 'is_active' => 0, 'is_question' => 0]);
                        }
                    }
                    
                    //Update Email Setting for mandrill and SMTP
                    $emailSett = array("mandrill", "smtp");
                    foreach ($emailSett as $email) {
                        $emaildetails = json_decode(DB::table($prefix . "_general_setting")->where('url_key', $email)->first()->details);
                        $emaildetails->name = $storeName;
                        DB::table($prefix . "_general_setting")->where('url_key', $email)->update(["details" => json_encode($emaildetails)]);
                    }
                    //End Email Setting Update

                    $adminRoleId = DB::table('roles')->where('store_id', $storeId)->where('name', 'LIKE', 'admin')->first(['id']);
                    DB::table("role_user")->insert(["user_id" => @$newuserid, "role_id" => $adminRoleId->id]);
                    //Check acl setting from general settings
                    $chkAcl = DB::table($prefix . "_general_setting")->where('url_key', 'acl')->select("status")->first();

                    if ($chkAcl->status == '1') {
                        $allPermissions = DB::table($prefix . "_permissions")->select("id")->get();
                        $permissions = [];
                        foreach ($allPermissions as $key => $ap) {
                            $permissions[$key]['permission_id'] = $ap->id;
                            $permissions[$key]['role_id'] = 1;
                        }
                        $insertPermission = DB::table($prefix . "_permission_role")->insert($permissions);
                    }

                    // permission_role
                    $baseurl = str_replace("\\", "/", base_path());
                    $domain = 'eStorifi.com'; //$_SERVER['HTTP_HOST'];
                    $sub = "eStorifi Links for Online Store - " . $storeName;
                    $mailcontent = "Congratulations " . $storeName. " has been created successfully!" . "\n\n";
                    $mailcontent .= "Kindly find the links to view your store:" . "\n";
                   
                    $mailcontent .= "Store Admin Link: https://" . $domainname . '.' . $domain . "/admin" . "\n";
                    if ($storeType == 'merchant') {
                        $mailcontent .= "Online Store Link: https://" . $domainname . '.' . $domain . "\n\n";
                    }
                    $mailcontent .= "Unique Code is: " . $identityCode . " " . "\n";
                    $mailcontent .= "For any further assistance/support, contact http://eStorifi.com/contact" . "\n";

                    if ($phone) {
                        $msgOrderSucc = "Congrats! Your new Online Store is ready. Store Admin Link: https://" . $domainname . "." . $domain . "/admin Download eStorifi Merchant Android app to manage your Online Store. Download Now https://goo.gl/kUSKro";
                        Helper::sendsms($phone, $msgOrderSucc, $country_code);
                        $idcodeMsg = "Your unique identification code is " . $identityCode;
                        Helper::sendsms($phone, $idcodeMsg, $country_code);
                    }
                    if (!empty($merchantEamil)) {
                        Helper::withoutViewSendMail($merchantEamil, $sub, $mailcontent);
                    }
                    Session::flush();
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

    public function thankYou() {
        $data = [];
        $viewname = Config('constants.frontendView') . ".thankyou";
        return Helper::returnView($viewname, $data);
    }

    public function waitProcess()
    {   

        $dataW = [];
        $themeInput = Input::all();
        $dataW['themeInput'] = json_encode($themeInput);

        $viewname = Config('constants.frontendView') . ".wait-process";
        //echo $viewname;
        return Helper::returnView($viewname, $dataW);
    }

    public function pricing() {
        $data = [];
        $viewname = Config('constants.frontendView') . ".pricing";
        return Helper::returnView($viewname, $data);
    }

    public function logisticPartners() {
        $data = [];
        $viewname = Config('constants.frontendView') . ".logistic-partners";
        return Helper::returnView($viewname, $data);
    }

    public function infiniSys() {
        $data = [];
        $viewname = Config('constants.frontendView') . ".infini";
        return Helper::returnView($viewname, $data);
    }

    public function createStore() {
        $id = Input::get('id');
        $rules = [
            //'merchant_id' => 'required',
            // 'category_id' => 'required',
            'store_name' => 'required|unique:stores' . ($id ? ",store_name,$id" : ''),
                //'url_key' => 'required|unique:stores' . ($id ? ",url_key,$id" : ''),
                // 'status' => 'required',
                // 'language_id' => 'required',
                // 'template_id' => 'required'
        ];
        $messages = [
            //'merchant_id.required' => 'Merchant name is required.',
            // 'category_id.required' => 'Category is required.',
            'store_name.unique' => 'This store name have been already taken',
            //'url_key.unique' => 'This store name have been already taken',
            'url_key.required' => 'Store name is required',
            'url_key.required' => 'Store url key is required',
                // 'status.required' => 'Status is required',
                // 'language_id.required' => 'Language is required',
                //'template_id.required' => 'Template is required'
        ];
        $validator = Validator::make(Input::all(), $rules, $messages);
        if ($validator->fails()) {
            return $validator->messages()->toJson();
        } else {
            $getMerchat = new Merchant();
            $getMerchat->email = Input::get('email');
            $getMerchat->password = Hash::make(Input::get('password'));
            $getMerchat->firstname = Input::get('first_name');
            //$getMerchat->lastname = Input::get('last_name');
            $getMerchat->phone = Input::get('telephone');
            $getMerchat->save();

            if (!empty(Session::get("storeId"))) {
                $store = Store::find(Session::get("storeId"));
            } else {
                $store = Store::findOrNew(Input::get('id'));
            }
            $store->store_name = Input::get('store_name');
            $store->url_key = str_replace(" ", "-", Input::get('store_name'));
            $store->merchant_id = $getMerchat->id;
            // $store->language_id = $getMerchat->id;
            // $store->template_id = Input::get('template_id');
            $store->status = 1;
            if (Input::hasFile('logo')) {
                $logo = Input::file('logo');
                $destinationPath = public_path() . '/public/public/admin/uploads/logos/';
                $fileName = "store-" . date("YmdHis") . "." . $logo->getClientOriginalExtension();
                $upload_success = $logo->move($destinationPath, $fileName);
                $store->logo = @$fileName;
            }
            if (empty(Input::get('id'))) {
                if (!empty(Input::get('url_key'))) {
                    $chkUrlKey = Store::where("url_key", Input::get('url_key'))->count();
                    if ($chkUrlKey == 0)
                        $store->url_key = Input::get('url_key');
                }
                $store->prefix = $this->getPrefix(Input::get('store_name'));
            }
            $getMerchat1 = Merchant::find($store->merchant_id);
            $merchantEamil = $getMerchat1->email;
            $firstname = $getMerchat->firstname;
            $merchantPassword = $getMerchat1->password;
            if ($store->save()) {
                Session::put("storeId", $store->id);
                // if (empty(Input::get('id'))) {
                //     $this->createInstance($store->prefix, $store->url_key, $merchantEamil, $merchantPassword, Input::get('store_name'), $firstname);
                // }
                // commented coz of mail not going to send 
            }
            $data = [];
            $data['id'] = $store->id;
            $data['storedata'] = $store;
            $data['status'] = "success";

            return $data;
        }
    }

    public function read() {

        $storeName = 'webStore';
        $json_url = realpath(getcwd() . "/..") . "/" . $storeName . "/storage/json/storeSetting.json";
        $json = file_get_contents($json_url);
        $decodeVal = json_decode($json, true);
        $decodeVal['storeName'] = $storeName;
        $newJsonString = json_encode($decodeVal);
        $fp = fopen(realpath(getcwd() . "/..") . "/" . $storeName . '/storage/json/storeSetting.json', 'w+');
        fwrite($fp, $newJsonString);
        fclose($fp);
    }

    public function checkExistingUser() {
        //echo Input::get('email');
        //dd("dsf >> ".Input::get('storeType'));
        $storeType = Input::get('storeType'); // merchant/ distributor

        if ($storeType == 'merchant') {
            $chkEmail = Merchant::where("email", Input::get('email'))->first();
        } // End if
        else {
            $chkEmail = Vendor::where("email", Input::get('email'))->first();
        } // End else

        if (isset($chkEmail) && !empty($chkEmail)) {
            return 1;
        else
            return 0;
        }
    }

    public function checkExistingphone()
    {
        $storeType = Input::get('storeType'); // merchant/ distributor
        if ($storeType == 'merchant') {
            $chkPhoneNo = Merchant::where("phone", Input::get('phone'))->first();
        } // End if
        else {
            $chkPhoneNo = Vendor::where("phone_no", Input::get('phone_no'))->first();
        } // End else

        if (isset($chkPhoneNo) && !empty($chkPhoneNo)) {
            return 1;
        else
            return 0;
    }

    public function getthemes() {
        $catid = Input::get('catid');
        $themes = Category::find($catid)->themes()->pluck('name', 'id')->toArray();
    }

    public function showThemes() {
        if (Session::get('merchantid')) {

            $allinput = json_decode(Merchant::find(Session::get('merchantid'))->register_details, true);
            $cats = Category::where("status", 1)->where("id", $allinput['business_type'])->get();
        } else {
            $cats = Category::where("status", 1)->get();
        }
        $data = ['cats' => $cats];
        $viewname = Config('constants.frontendView') . ".show-themes";
        return Helper::returnView($viewname, $data);
    }

    public function veestoresLogout() {
        Session::flush();
        Auth::guard('merchant-users-web-guard')->logout();
        return redirect()->to('/');
    }

    public function veestoreLogin() {
        $input = str_replace(" ", "", Input::get('mobile_email'));
        $login_type = filter_var($input, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
        $merchant = Merchant::where($login_type, $input)->first();

        $data = [];
        if (count($merchant) == 0) {
            $data['status'] = 3;
            return $data;
        }

        $inputArr = [$login_type => $input, 'password' => Input::get('password')];

        if (Auth::guard('merchant-users-web-guard')->attempt($inputArr)) {

            Session::put('merchantid', $merchant->id);

            $checkStote = Merchant::find(Session::get('merchantid'))->getstores()->count();

            Session::put('merchantstorecount', $checkStote);


            $data['status'] = 1;
            if ($checkStote > 0) {
                $returl = route('veestoreMyaccount');
                //  echo "having store";
                //   die;
            } else {

                $returl = route('selectThemes');
                // echo "no store";
                //  die;
            }
            $data['returl'] = $returl;
        } else {
            $data['status'] = 0;
        }
        return $data;
    }

    public function veestoresMyaccount()
    {
        $checkStote = Merchant::find(Session::get('merchantid'))->getstores()->count();

        $merchant = Merchant::find(Session::get('merchantid'));

        if ($checkStote > 0) {
            $checkStote = Store::where('merchant_id', Session::get('merchantid'))->first();
            $merchant->my_Store = $checkStote->url_key . '.' . str_replace("www", "", $_SERVER['HTTP_HOST']);
            $merchant->my_Store_admin = $checkStote->url_key . '.' . str_replace("www", "", $_SERVER['HTTP_HOST']) . '/admin';
        } else {
            return redirect()->to('/');
        }
        $data = ['merchant' => $merchant];

        $viewname = Config('constants.frontendView') . ".my_account";
        return Helper::returnView($viewname, $data);
    }

    public function veestoresChangePassword() {
        if (!Session::get('merchantid')) {
            return redirect()->to('/');
        }
        $merchant = Merchant::find(Session::get('merchantid'));
        if (Session::get('merchantid') != '' && Session::get('merchantstorecount') > 0) {
            $checkStote = Store::where('merchant_id', Session::get('merchantid'))->first();
            $merchant->my_Store = $checkStote->url_key . '.' . str_replace("www", "", $_SERVER['HTTP_HOST']);
            $merchant->my_Store_admin = $checkStote->url_key . '.' . str_replace("www", "", $_SERVER['HTTP_HOST']) . '/admin';
        }
        $data = ['merchant' => $merchant];

        $viewname = Config('constants.frontendView') . ".change-password";
        return Helper::returnView($viewname, $data);
    }

    public function veestoresUpdateProfile() {

        $merchant = Merchant::find(Session::get('merchantid'));

        $merchant->firstname = Input::get("firstname");
        $merchant->lastname = Input::get("lastname");
        $merchant->email = Input::get("email");
        $merchant->phone = Input::get("phone");
        $merchant->save();

        $data = ['status' => 'success', 'msg' => 'profile updated successfully!', 'merchant' => $merchant];
        return $data;
    }

    public function veestoresUpdateChangePassword() {
        $phone = Input::get('phone');
        // $user = User::where('email', '=', $email)->first();
        $password = Input::get('password');
        $conf_password = Input::get('conf_password');
        $old_password = Input::get('old_password');

        $user_details = Merchant::where("phone", "=", $phone)->first();
        $check = (Hash::check(Input::get('old_password'), $user_details->password));
        if ($check == true) {
            if ((Input::get('password')) == Input::get('conf_password')) {
                $user = Merchant::find($user_details->id);
                $user->password = Hash::make(Input::get('password'));
                $user->Update();

                // Session::flash('updateProfileSuccess', 'Password updated successfully');
                return $result = ['status' => 'success', 'msg' => 'Password updated successfully'];
            } else {

                // Session::flash('PasswordError', 'Password and Confirm Password does not match');
                return $result = ['status' => 'nomatch', 'msg' => 'Password and Confirm Password does not match'];
            }
        } else {


            // Session::flash('PasswordError', 'Incorrect Old Password');
            return $result = ['status' => 'error', 'msg' => 'Incorrect Old Password'];
        }
    }

    public function veestoresTutorial() {
        if (!Session::get('merchantid')) {
            return redirect()->to('/');
        }
        $merchant = Merchant::find(Session::get('merchantid'));
        if (Session::get('merchantid') != '' && Session::get('merchantstorecount') > 0) {
            $checkStote = Store::where('merchant_id', Session::get('merchantid'))->first();
            $merchant->my_Store = $checkStote->url_key . '.' . str_replace("www", "", $_SERVER['HTTP_HOST']);
            $merchant->my_Store_admin = $checkStote->url_key . '.' . str_replace("www", "", $_SERVER['HTTP_HOST']) . '/admin';
        }
        $data = ['merchant' => $merchant];

        $viewname = Config('constants.frontendView') . ".tutorial";
        return Helper::returnView($viewname, $data);
    }

    public function featureList() {
        $data = [];
        $viewname = Config('constants.frontendView') . ".features";
        return Helper::returnView($viewname, $data);
    }

    public function termCondition() {
        $data = [];
        $viewname = Config('constants.frontendView') . ".terms-condition";
        return Helper::returnView($viewname, $data);
    }

    public function privacyPolicy() {
        $data = [];
        $viewname = Config('constants.frontendView') . ".privacy-policy";
        return Helper::returnView($viewname, $data);
    }

    public function aboutUs() {
        $data = [];
        $viewname = Config('constants.frontendView') . ".about";
        return Helper::returnView($viewname, $data);
    }

    public function videoTutorials() {
        $data = [];
        $viewname = Config('constants.frontendView') . ".video-tutorials";
        return Helper::returnView($viewname, $data);
    }

    public function contactUs() {
        $data = [];
        $viewname = Config('constants.frontendView') . ".contact";
        return Helper::returnView($viewname, $data);
    }

    public function contactSend() {
        $verifyCaptcha = $this->verifyRecaptcha(Input::get('recaptcha_response'));
        if ($verifyCaptcha->success == true) {
            $data = [];
            $firstname = Input::get("firstname");
            $useremail = Input::get("useremail");
            $telephone = Input::get("telephone");
            $message = Input::get("message");

            $emailData = ['name' => $firstname, 'email' => $useremail, 'telephone' => $telephone, 'messages' => $message];
            Mail::send('Frontend.emails.contactEmail', $emailData, function ($m) use ($useremail, $firstname) {
                $m->to("leena@infiniteit.biz", $firstname)->subject('eStorifi Contact form!');
            });
            return 1;
        } else {
                $result = ['status' => 'error', 'msg' => 'Something went wrong..'];
                return 0;
        }
    }


    public function verifyRecaptcha($recaptcha_response)
    {
        $client = new Client;
        $response = $client->post(
            'https://www.google.com/recaptcha/api/siteverify',
            [
                'form_params' =>
                [
                    'secret' => env('GOOGLE_RECAPTCHA_SECRET'),
                    'response' => Input::get('recaptcha_response'),
                ],
            ]
        );

        return json_decode((string) $response->getBody());
    }



    public function faqS() {
        $data = [];
        $viewname = Config('constants.frontendView') . ".faqs";
        return Helper::returnView($viewname, $data);
    }

    public function notFound() {
        $data = [];
        $viewname = Config('constants.frontendView') . ".not-found";
        return Helper::returnView($viewname, $data);
    }

    public function resetNewPwd($link) {
        $data = ['link' => $link];
        $viewname = Config('constants.frontendView') . ".reset_forgot_pwd";
        return Helper::returnView($viewname, $data);
    }

    public function resetNewPwdSave() {
        $useremail = Crypt::decrypt(Input::get('link'));
        $user = Merchant::where("email", "=", $useremail)->first();
        $upPassword = Merchant::find($user->id);
        $password = Hash::make(Input::get('confirmpwd'));
        $upPassword->password = Hash::make(Input::get('confirmpwd'));
        $upPassword->update();
        //  dd($upPassword);
        $merchant = $upPassword->getstores()->first();
        //  dd($merchant->prefix .'_users');
        $firstname = $user->firstname;
        DB::table($merchant->prefix . '_users')->where("email", $useremail)->update(["password" => $password]);
        $emailData = ['name' => $firstname, 'email' => $useremail];
        Mail::send('Frontend.emails.resetForgotPwdEmail', $emailData, function ($m) use ($useremail, $firstname) {
            $m->to($useremail, $firstname)->subject('Your password changed!');
            $m->cc('leena@infiniteit.biz');
        });
        session()->flash('pwdResetMsg', 'Password reset successfully!');

        return redirect()->route('home');
    }

    public function merchantForgotPassword() {
        //  dd(Input::all());
        $inputEmailPhone = Input::get('phone_email');
        $login_type = filter_var($inputEmailPhone, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
        $userDetails = Merchant::where($login_type, "=", $inputEmailPhone)->first();

        if (count($userDetails) <= 0) {
            Session::flash('message', "Email/Mobile not registered with us.");
            return redirect()->back();
            exit();
        }
        $linktosend = $_SERVER['HTTP_HOST'] . "/reset-new-pwd/" . Crypt::encrypt($userDetails->email);
        if ($login_type == 'email') {
            $email = $userDetails->email;
            $firstname = $userDetails->firstname;
            $emailData = ['name' => $firstname, 'newlink' => $linktosend];
            Mail::send('Frontend.emails.forgotPassEmail', $emailData, function ($m) use ($email, $firstname) {
                $m->to('leena@infiniteit.biz', $firstname)->subject('Forgot password');
                $m->cc('leena@infiniteit.biz');
            });
        } else if ($login_type == 'phone') {
            $msgOrderSucc = "Click on the link to reset your password. " . $linktosend . "Happy Learning! Team eStorifi";
            Helper::sendsms($userDetails->phone, $msgOrderSucc, $userDetails->country_code);
        }
    }

    public function sendOtp() {
        $country = Input::get("country");
        $mobile = Input::get("mobile");
        $otp = rand(1000, 9999);
        Session::put('otp', $otp);
        if ($mobile) {
            $msgOrderSucc = "Your one time password is. " . $otp . " Team eStorifi";
            Helper::sendsms($mobile, $msgOrderSucc, $country);
        }
        $data = ["status" => "success", "msg" => "OTP Successfully send on given number", "otp" => $otp];
        return $data;
    }

    public function checkOtp() {
        $inputOtp = Input::get("inputotp");
        $otp = Session::get('otp');
        if ($inputOtp == $otp) {
            return $otp;
        } else {
            return 2;
        }
    }

    public function checkStorename()
    {
        $storename = strtolower(Input::get("storename"));
        $storedata = Store::where(strtolower("store_name"), $storename)->first();
        if (empty($storedata) && $storename != '') {
            return $data = ["status" => "success", "msg" => "Correct Business Name"];
        } else if ($storename == '') {
            return $data = ["status" => "fail", "msg" => "Business name can not be blank"];
        } else {
            return $data = ["status" => "fail", "msg" => "Business Name Already Exists"];
        }
    }

    public function checkPhone()
    {
        $mobile = Input::get("mobile");
        $user = User::where("telephone", $mobile)->first();
        if (empty($user) && $mobile != '') {
            return $data = ["status" => "success", "msg" => "Correct"];
        } else if ($mobile == '') {
            return $data = ["status" => "fail", "msg" => "Mobile No. can not be blank"];
        } else {
            return $data = ["status" => "fail", "msg" => "Mobile No. Already Exists"];
        }
    }

    public function selectThemesdata($storeId,$themeid,$catid, $domainname){

        $banner = json_decode((StoreTheme::where("id", $themeid)->first()->banner_image), true);
        // $banner = json_decode((Category::where("id", $catid)->first()->banner_image), true);
        if (!empty($banner)) {
                $homeLayout = DB::table("layout")
                ->where('url_key', 'LIKE', 'home-page-slider')
                ->where('store_id', $storeId)
                ->where('is_del', 0)
                ->first();
            foreach ($banner as $image) {
                $homePageSlider = [];
                $file = $image['banner'];
                //$homePageSlider['layout_id'] = 1;
                $homePageSlider['layout_id'] =  $homeLayout->id;
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

                $boxLayout = DB::table("layout")
                ->where('url_key', 'LIKE', 'home-page-3-boxes')
                ->where('store_id', $storeId)
                ->where('is_del', 0)
                ->first();

            foreach ($threeBoxes as $image) {
                $homePageSlider = [];
                $file = $image['banner'];
                $homePageSlider['layout_id'] = $boxLayout->id;
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
    }
}
