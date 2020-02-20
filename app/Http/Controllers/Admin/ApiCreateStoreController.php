<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Library\CustomValidator;
use App\Library\Helper;
use App\Models\Category;
use App\Models\Country;
use App\Models\Currency;
use App\Models\HasCurrency;
use App\Models\Merchant;
use App\Models\MerchantOrder;
use App\Models\Settings;
use App\Models\Store;
use App\Models\StoreTheme;
use App\Models\Vendor;
use DB;
use File;
use Hash;
use Illuminate\Support\Facades\Input;
use JWTAuth;
use Session;
use Validator;
use ZipArchive;

class ApiCreateStoreController extends Controller
{

    public function fbSignUpCheck()
    {
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

    public function signUpDropDown()
    {
        $cat = Category::where("status", 1)->pluck('category', 'id')->prepend('Industry *', '');

        $curr = HasCurrency::where('status', 1)->orderBy("iso_code", "asc")->get(['status', 'id', 'name', 'iso_code', 'currency_code']);
        // $themes = StoreTheme::where("cat_id", 1)->where("status", 1)->get(["id", "name", "image"]);
        //            foreach($themes as $them){
        //               $them->themImage=  asset('public/admin/themes/'.$them->image);
        //               $them->themLink=  asset('themes/'.strtolower($them->name).'_home.php?link=trsdadasd');
        //            }

        return $data = ['category' => $cat, 'currency' => $curr];
    }

    public function checkDomain()
    {
        $getvalue = Input::get('domain_name');
        $checkhttps = (isset($_SERVER['HTTPS']) === false) ? 'http' : 'https';
        $checkdomain = $checkhttps . "://" . $getvalue . "." . str_replace("www", "", $_SERVER['HTTP_HOST']);
        // dd($checkdomain);
        $storedomain = Store::pluck('store_domain')->toArray();

        if (in_array($checkdomain, $storedomain)) {
            return $data = ["status" => 1, "msg" => "This domain not available"];
        } else {
            return $data = ["status" => 1, "msg" => "Domain name available"];
        }
    }
    public function checkMobile()
    {
        $phone = Input::get('phone');
        if (!empty($phone) && CustomValidator::validatePhone($phone)) {
            $users = DB::table("users")->where('user_type', 1)->where('telephone', $phone)->first();
            if ($users != null) {
                return ["status" => 1, "msg" => "Already registered!"];
            } else {
                return ["status" => 1, "msg" => "Available"];
            }
        } else {
            $data = ["status" => 0, "msg" => "Invalid mobile number"];
        }
    }
    public function saveSignUp()
    {
        $allinput = Input::all();
        $storeName = Input::get('store_name');
        $phone = Input::get('phone');
        $roleType = Input::get('roleType');
        if ((!empty($roleType) && in_array($roleType, ['1', '2'])) && !empty($storeName) && !empty($phone)) {
            if (CustomValidator::validatePhone($phone)) {
                $verifyOTP = $this->verifyOTP();
                if ($verifyOTP) {
                    $checkStore = $this->checkStore();
                    if ($checkStore['status']) {
                        $storeType = ($allinput['roleType'] == '1') ? 'merchant' : ($allinput['roleType'] == '2')? 'distributor': '';
                        $settings = Settings::where('bank_id', 0)->first();
                        $country = Country::where("id", $settings->country_id)->get()->first();
                        $currency = Currency::where("id", $settings->currency_id)->get()->first();
                        $settings['country_code'] = $country['country_code'];
                        $settings['country_name'] = $country['name'];
                        $settings['currency_code'] = $currency['id'];
                        $allinput['currency'] = $currency['id'];
                        $allinput['country_code'] = $country['country_code'];
                        $domainname = str_replace(" ", '-', trim(strtolower(Input::get("store_name")), " "));
                        $checkhttps = (isset($_SERVER['HTTPS']) === false) ? 'http' : 'https';
                        $actualDomain = $checkhttps . "://" . $domainname . "." . str_replace("www", "", $_SERVER['HTTP_HOST']);
                        $actualDomain = str_replace("..", ".", $actualDomain);
                        $allinput['domain_name'] = $domainname;
                        $newMerchant = '';
                        if ($storeType == 'merchant') {
                            // Validate Merchant Data
                            $validation = new Merchant();
                            $allinput['company_name'] = $storeName;
                            $validator = Validator::make($allinput, Merchant::rules(), $validation->messages);
                            if ($validator->fails()) {
                                $errMsg = [];
                                $err = $validator->messages()->toArray();
                                foreach ($err as $ek => $ev) {
                                    $errMsg[$ek] = implode(",", $ev);
                                }
                                $data = ["status" => 0, "msg" => $errMsg];
                                return $data;
                            }
                            $getMerchat = new Merchant;
                            $getMerchat->phone = $phone;
                            // $getMerchat->password = Hash::make(Input::get('password'));
                            // $getMerchat->email = Input::get("email");
                            // $getMerchat->firstname = Input::get("firstname");
                            $getMerchat->company_name = $storeName;
                            $getMerchat->country_code = $country['country_code'];
                            $getMerchat->register_details = json_encode($allinput);
                            $getMerchat->save();
                            $lastInsteredId = $getMerchat->id;
                            if ($lastInsteredId > 0) {
                                $merchantObj1 = Merchant::find($lastInsteredId);
                                $identityCode = Helper::createUniqueIdentityCode($allinput, $lastInsteredId);
                                $merchantObj1->identity_code = $identityCode;
                                $decoded = json_decode($merchantObj1->register_details, true);
                                $decoded['business_type'] = ["17"];
                                $json = json_encode($decoded);
                                $merchantObj1->register_details = $json;
                                $merchantObj1->save();

                            }
                            $newMerchant = $getMerchat;
                        } else if ($storeType == 'distributor') {
                            // Validate Merchant Data
                            $validation = new Vendor();
                            $allinput['business_name'] = $storeName;
                            $validator = Validator::make($allinput, Vendor::rules(), $validation->messages);
                            if ($validator->fails()) {
                                $errMsg = [];
                                $err = $validator->messages()->toArray();
                                foreach ($err as $ek => $ev) {
                                    $errMsg[$ek] = implode(",", $ev);
                                }
                                $data = ["status" => 0, "msg" => $errMsg];
                                return $data;
                            }
                            $distributorObj = new Vendor();
                            $distributorObj->business_name = $storeName;
                            $distributorObj->phone_no = $phone;
                            $distributorObj->country = $country['country_code'];
                            $distributorObj->currency_code = $country['currency_code'];
                            $distributorObj->register_details = json_encode($allinput);
                            $distributorObj->save();
                            $lastInsteredId = $distributorObj->id;
                            if ($lastInsteredId > 0) {
                                $distributorObj1 = Vendor::find($lastInsteredId);
                                $identityCode = Helper::createUniqueIdentityCode($allinput, $lastInsteredId);
                                $distributorObj1->identity_code = $identityCode;
                                $decoded = json_decode($distributorObj1->register_details, true);
                                $decoded['business_type'] = ["17"];
                                $json = json_encode($decoded);
                                $distributorObj1->register_details = $json;
                                $distributorObj1->save();
                            }                            
                            $newMerchant = $distributorObj;
                            // return response()->json(["status" => $lastInsteredId, 'data' => Input::all()]);
                        }

                        $store = new Store();
                        $store->store_name = Input::get("store_name"); // $registerDetails->store_name;
                        $store->url_key = $domainname;
                        $store->store_type = $storeType; // merchant/distributor
                        $store->merchant_id = $lastInsteredId;
                        $store->store_domain = $actualDomain;
                        $store->percent_to_charge = 1.00;
                        $store->expiry_date = date('Y-m-d', strtotime(date("Y-m-d") . " + 365 day"));
                        $store->status = 1;
                        $store->category_id = 17;
                        $merchantPay = MerchantOrder::where("merchant_id", Session::get('merchantid'))->where("order_status", 1)->where("payment_status", 4)->first();
                        if (isset($merchantPay) && count($merchantPay) > 0) {
                            $store->store_version = 2;
                        } else {
                            $store->store_version = 1;
                        }
                        $store->prefix = $this->getPrefix($domainname);
                        if ($store->save()) {
                            $storeVersion = $store->store_version;
                            $result = $this->createInstance($storeType, $store->id, $store->prefix, $store->url_key, $store->store_name, $settings['currency_code'], $getMerchat->phone, $domainname, $storeVersion, $store->expiry_date, $identityCode, $settings['country_code']);
                            if ($result['status']) {
                                $regUser = DB::table('users')->where('store_id', $store->id)->where('user_type', 1)->first(['id', 'telephone', 'store_id', 'prefix', 'country_code']);
                                $token = JWTAuth::fromUser($regUser);
                                $user = JWTAuth::toUser($token);
                                $store = $store; // $getMerchat->getstores;
                                $data = ['storeCount' => count($store)]; //'result' => $result,
                                return response()->json(["status" => 1, 'msg' => 'Store created successfully!', 'data' => ['user' => $user, 'store' => $store, 'merchant' => $newMerchant, 'setupStatus' => $data]])->header('token', $token);
                            } else {
                                return response()->json($result);
                            }
                        } else {
                            return response()->json(["status" => 0, 'msg' => 'Something went wrong!']);
                        }
                    } else {
                        return response()->json(["status" => 0, 'msg' => 'Store name is already taken!']);
                    }
                } else {
                    return response()->json(["status" => 0, 'msg' => 'Invalid OTP/Mobile number']);
                }
            } else {
                $data = ["status" => 0, "msg" => "Invalid mobile number"];
            }
        } else {
            return response()->json(["status" => 0, 'msg' => 'Some data is missing!']);
        }

    }

    public function getTheme()
    {
        $themId = Input::get('business_type');
        if (!empty($themId)) {
            $themes = StoreTheme::where("cat_id", $themId)->where("status", 1)->orderBy('sort_orders', 'asc')->get(["id", "name", "image", "theme_type"]);
            foreach ($themes as $them) {
                $them->themImage = asset('public/admin/themes/' . $them->image);
                $them->themLink = asset('themes/' . strtolower($them->name) . '_home.php?link=trsdadasd');
            }
            $data = ["status" => 1, "theme" => $themes];
        } else {
            $data = ["status" => 0, "msg" => "Opps Somethings went wrong"];
        }
        return $data;
    }

    public function applyStoreTheme()
    {
        $merchantId = Input::get("merchantId");
        $getMerchat = Merchant::find($merchantId);
        $merchantPay = MerchantOrder::where("merchant_id", $merchantId)->where("order_status", 1)->where("payment_status", 4)->first();

        $themeId = Input::get('theme_id');
        $registerDetails = json_decode($getMerchat->register_details);
        $domainname = str_replace(" ", '-', trim(strtolower($registerDetails->domain_name), " "));
        $checkhttps = (isset($_SERVER['HTTPS']) === false) ? 'http' : 'https';
        $actualDomain = $checkhttps . "://" . $domainname . "." . str_replace("www", "", $_SERVER['HTTP_HOST']);
        $store = Store::findOrNew(Session::get('stid'));
        $store->store_name = str_replace(" ", "-", (strtolower($registerDetails->storename)));
        $store->url_key = $domainname;
        $store->merchant_id = $getMerchat->id;
        $store->category_id = Input::get('business_type');
        $store->template_id = $themeId;
        $store->store_domain = $actualDomain;
        $store->category_id = 17;
        $store->expiry_date = date('Y-m-d', strtotime(date("Y-m-d") . " + 365 day"));
        $store->status = 1;
        if (empty(Input::get("id"))) {
            if (!empty(Input::get("url_key"))) {
                $chkUrlKey = Store::where("url_key", Input::get("url_key"))->count();
                if ($chkUrlKey == 0) {
                    $store->url_key = Input::get("url_key");
                }

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
            Session::put('stid', $store->id);

            if (empty($themeInput->id)) {
                $password = @$registerDetails->password;
                $appId = @$registerDetails->appId;
                $this->createInstance($store->id, $store->prefix, $store->url_key, $registerDetails, $password, $themeId, $firstname, $domainname, $store->expiry_date, $appId);
            }
        }
        $getMerchat->register_details = json_encode($registerDetails);
        $getMerchat->save();

        Session::forget("stid");
        $userData = app('App\Http\Controllers\Admin\ApiMerchantController')->fbMerchantLogin($getMerchat->email);
        // App/Http/Controller/Admin/ApiMerchantController->fbMerchantLogin($getMerchat->email);
        //  App\Http\Controllers\Admin\ApiMerchantController->fbMerchantLogin($getMerchat->email);
        return $userData;
        // $data['userdata'] = $userData;
        //  return $data;
        return "Success";

    }

    public function createInstance($storeType, $storeId, $prefix, $urlKey, $storeName, $currency, $phone, $domainname, $storeVersion, $expirydate, $identityCode, $country_code)
    {
        $appId = null;
        $catid = 17;
        ini_set('max_execution_time', 600);

        $messagearray = '[{"type": "A","name": "' . $domainname . '","data": "13.234.230.182","ttl": 3600}]';
        $fields = array(
            'data' => $messagearray,
        );
        //building headers for the request
        $headers = array(
            'Authorization: sso-key dKYQNqECqY1B_KeALbMxBuuwsR54jgwibDA:KeANr8XdSMqcwF9y5CjCZe',
            'Content-Type: application/json',
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
        if ($result === false) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
        //stop Curl

        $contents = File::get(public_path() . "/public/skeleton.sql");
        $sql = str_replace('tblprfx_', $storeId, $contents);
        $test = DB::unprepared($sql);
        if ($test) {
            $path = base_path() . "/merchants/" . "$domainname";
            $mk = File::makeDirectory($path, 0777, true, true);
            if (chmod($path, 0777)) {
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
                    $this->replaceFileString($path . "/.env", "%DB_TABLE_PREFIX%", "");
                    $this->replaceFileString($path . "/.env", "%STORE_NAME%", "$domainname");
                    $this->replaceFileString($path . "/.env", "%STORE_ID%", "$storeId");

                    $insertArr = ["user_type" => 1, "status" => 1, "telephone" => "$phone", "store_id" => "$storeId", "prefix" => "$prefix"];

                    if ($appId) {
                        $insertArr["provider_id"] = $appId;
                    }
                    if ($country_code) {
                        $insertArr["country_code"] = "$country_code";
                    }
                    $newuserid = DB::table("users")->insertGetId($insertArr);

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

                    $newJsonString = json_encode($decodeVal);
                    $fp = fopen(base_path() . "/merchants/" . $domainname . '/storeSetting.json', 'w+');
                    fwrite($fp, $newJsonString);
                    fclose($fp);
                    if (!empty($catid)) {
                        Helper::saveDefaultSet($catid, $prefix, $storeId, 'merchant');
                    }
                    if (!empty($currency)) {

                        $decodeVal['currency'] = $currency;
                        $decodeVal['currency_code'] = @HasCurrency::find($currency)->iso_code;
                        $currVal = @HasCurrency::find($currency);
                        if (!empty($currVal)) {
                            $currJson = json_encode(['name' => $currVal->name, 'iso_code' => $currVal->iso_code]);
                            DB::table("general_setting")->insert(['name' => 'Default Currency', 'status' => 0, 'details' => $currJson, 'url_key' => 'default-currency', 'type' => 1, 'sort_order' => 10000, 'is_active' => 0, 'is_question' => 0, 'store_id' => $storeId]);
                        }
                    }
                    //Update Email Setting for mandrill and SMTP
                    $emailSett = array("mandrill", "smtp");
                    foreach ($emailSett as $email) {
                        $emaildetails = json_decode(DB::table("general_setting")->where('url_key', $email)->first()->details);
                        $emaildetails->name = $storeName;
                        DB::table("general_setting")->where('store_id', $storeId)->where('url_key', $email)->update(["details" => json_encode($emaildetails)]);
                    }
                    //End Email Setting Update

                    $adminRoleId = DB::table('roles')->where('store_id', $storeId)->where('name', 'LIKE', 'admin')->first(['id']);
                    DB::table("role_user")->insert(["user_id" => @$newuserid, "role_id" => $adminRoleId->id]);
                    //Check acl setting from general settings
                    $chkAcl = DB::table("general_setting")->where('store_id', $storeId)->where('url_key', 'acl')->select("status")->first();

                    if ($chkAcl->status == '1') {
                        $allPermissions = DB::table("permissions")->select("id")->get();
                        $permissions = [];
                        foreach ($allPermissions as $key => $ap) {
                            $permissions[$key]['permission_id'] = $ap->id;
                            $permissions[$key]['role_id'] = $adminRoleId->id;
                        }
                        $insertPermission = DB::table("permission_role")->insert($permissions);
                    }

                    if ($phone) {
                        $msgOrderSucc = "Congrats! Your new Online Store is ready. Download eStorifi Merchant Android app to manage your Online Store. Download Now https://goo.gl/kUSKro";
                        Helper::sendsms($phone, $msgOrderSucc, $country_code);
                        $idcodeMsg = "Your unique identification code is " . $identityCode;
                        Helper::sendsms($phone, $idcodeMsg, $country_code);
                    }
                    // permission_role
                    $baseurl = str_replace("\\", "/", base_path());
                    $domain = 'eStorifi.com'; //$_SERVER['HTTP_HOST'];
                    $sub = "eStorifi Links for Online Store - " . $storeName;
                    $mailcontent = "<b>Congratulations  " . $storeName . " has been created successfully!</b>" . "\n\n";
                    $mailcontent .= "Kindly find the links to view your store:" . "\n";

                    $mailcontent .= "Store Admin Link: http://" . $domainname . '.' . $domain . "/admin" . "\n";
                    $mailcontent .= "Online Store Link: http://" . $domainname . '.' . $domain . "\n";
                    $mailcontent .= "For any further assistance/support, contact http://eStorifi.com/contact" . "\n\n";

                    return ['status' => 1, 'msg' => "Extracted Successfully to $path"];
                } else {
                    return ['status' => 0, 'msg' => "Error Encountered while extracting the Zip"];
                }
            } else {
                return ['status' => 0, 'msg' => "Access Denied"];
            }
        } else {
            return ['status' => 0, 'msg' => "Error Encountered while processing the SQL"];
        }
    }

    public function createInstanceOld($storeId, $prefix, $urlKey, $registerDetails, $merchantPassword, $themeid, $firstname, $domainname, $expirydate, $appId = null)
    {
        $merchantEamil = $registerDetails->email;
        $storeName = $registerDetails->storename;
        $catid = $registerDetails->business_type;
        $currency = $registerDetails->currency;
        $phone = $registerDetails->phone;
        $storeVersion = $registerDetails->store_version;
        ini_set('max_execution_time', 600);

        $messagearray = '[{"type": "A","name": "' . $domainname . '","data": "13.234.230.182","ttl": 3600}]';
        $fields = array(
            'data' => $messagearray,
        );
        //building headers for the request
        $headers = array(
            'Authorization: sso-key dKYQNqECqY1B_KeALbMxBuuwsR54jgwibDA:KeANr8XdSMqcwF9y5CjCZe',
            'Content-Type: application/json',
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
        if ($result === false) {
            die('Curl failed: ' . curl_error($ch));
        }
        curl_close($ch);
        //stop Curl

        $contents = File::get(public_path() . "/public/skeleton.sql");
        $sql = str_replace("tblprfx", $prefix, $contents);
        $test = DB::unprepared($sql);
        if (DB::unprepared($sql)) {
            $path = base_path() . "/merchants/" . "$domainname";

            $mk = File::makeDirectory($path, 0777, true, true);
            if (chmod($path, 0777)) {
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
                        $insertArr["password"] = $password;
                    }
                    if ($appId) {
                        $insertArr["provider_id"] = $appId;
                    }
                    $country_code = $registerDetails->country_code;
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
                        $newJsonString = json_encode($decodeVal);
                    }

                    //Update Email Setting for mandrill and SMTP
                    $emailSett = array("mandrill", "smtp");
                    foreach ($emailSett as $email) {
                        $emaildetails = json_decode(DB::table($prefix . "_general_setting")->where('url_key', $email)->first()->details);
                        $emaildetails->name = $storeName;
                        DB::table("general_setting")->where('url_key', $email)->update(["details" => json_encode($emaildetails)]);
                    }
                    //End Email Setting Update
                    $fp = fopen(base_path() . "/merchants/" . $domainname . '/storeSetting.json', 'w+');
                    fwrite($fp, $newJsonString);
                    fclose($fp);

                    DB::table("role_user")->insert([
                        ["user_id" => @$newuserid, "role_id" => "1"],
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
                            $homePageSlider = [];
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
                            $homePageSlider = [];
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
                    $mailcontent = "<b>Congratulations  " . $storeName . " has been created successfully!</b>" . "\n\n";
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

    public function getPrefix($storeName)
    {
        $newPrefix = substr($storeName, 0, 4) . mt_rand(100000, 999999);
        $chkPrfix = Store::where("prefix", "=", $newPrefix)->count();
        if ($chkPrfix > 0) {
            $this->getPrefix($storeName);
        } else {
            return $newPrefix;
        }

    }

    public function checkStore()
    {
        $storename = filter_var(Input::get('store_name'), FILTER_SANITIZE_STRING);
        $storename = strtolower(str_replace(' ', '', $storename));
        $chekcStoreName = DB::select("SELECT lower(REPLACE(`store_name`,' ','')) FROM `stores` where `store_name` ='{$storename}'");
        if (!empty($chekcStoreName)) {
            return ["status" => 0, "msg" => "Not Available"];
        } else {
            return ["status" => 1, "msg" => "Available"];
        }
    }
    public function replaceFileString($FilePath, $OldText, $NewText)
    {
        $Result = array('status' => 'error', 'message' => '');
        if (file_exists($FilePath) === true) {
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

    public function sendOtp()
    {
        $country = Input::get("country_code");
        $mobile = Input::get("phone");
        if (Input::get("phone") && !empty(Input::get("phone"))) {
            if (CustomValidator::validatePhone($mobile) && CustomValidator::validateNumber($country)) {
                $otp = rand(1000, 9999);
                $msgOrderSucc = "[#] Your one time password is " . $otp . ". lRaDZ0eOjMz"; // "Contact 1800 3000 2020 for real time support.! Team eStorifi";
                $smsOutput = Helper::sendsms($mobile, $msgOrderSucc, $country);
                $smsOutput = explode(' | ', $smsOutput);
                if ($smsOutput[0] === 'success') {
                    DB::table('user_otp')->insert(['phone' => $mobile, 'otp' => $otp, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')]);
                    $data = ["status" => 1, "msg" => "OTP Successfully send on your phone Number", "otp" => $otp]; //, "otp"=> $otp, 'smsOutput' => $smsOutput
                    return $data;
                } else {
                    $data = ["status" => 0, "msg" => "Invalid phone number"];
                    return $data;
                }
            } else {
                $data = ["status" => 0, "msg" => "Invalid mobile number/country code"];
            }
        } else {
            $data = ["status" => 0, "msg" => "Mobile Number is missing"];
        }

    }

    public function verifyOTP()
    {
        $phone = Input::get("phone");
        $otp = Input::get("otp");
        $userdata = DB::table('user_otp')->where(['phone' => $phone, 'otp' => $otp])->first();
        if (!empty($userdata)) {
            if (!$token = JWTAuth::fromUser($userdata)) {
                return response()->json(["status" => 0, 'msg' => "Invalid Mobile Number"]);
            }
            $result = response()->json(compact('token'));
            $getData = $result->getdata();
            DB::table('user_otp')->where(['phone' => $phone, 'otp' => $otp])->delete();
            return 1;
        } else {
            return 0;
        }
    }
}
