<?php

/* Commented Somecode for veestores mall
 * Line 505, 522
 * Line 383-387
 * Line 539
 *
 */

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Library\Helper;
use App\Models\Category;
use App\Models\HasCurrency;
use App\Models\Merchant;
use App\Models\MerchantOrder;
use App\Models\Store;
use App\Models\StoreTheme;
<<<<<<< HEAD
=======
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
use Validator;
>>>>>>> origin/dev-multi
use Auth;
use Crypt;
use DB;
use File;
use Hash;
use Illuminate\Support\Facades\Input;
use Mail;
use Schema;
use Session;
use Validator;
use ZipArchive;

class HomeController extends Controller
{

    public function isJson($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    public function index()
    {
        // dd(Category::limit(1)->offset(0)->get());

        Session::forget('storename');
        //  dd("after sent mIL");
        Session::forget('merchantEmail');
        Session::forget('merchantName');
        Session::forget('fbId');
        $data = [];
        $viewname = Config('constants.frontendView') . ".index";
        return Helper::returnView($viewname, $data);
    }

    public function cleardb()
    {
        $stores = Store::distinct('prefix')->where("id", '!=', 31)->get(['prefix', 'id']);
        //$stores = ['Mina690392','news230032','Nick288366','Pari390829','Prad855708','Pran329195','Pran329195'];

        foreach ($stores as $st) {
            //dd($st->prefix);
            $dropQ = "DROP TABLE Fgy154734_additional_charges,Fgy154734_attribute_sets,Fgy154734_attribute_types,Fgy154734_attribute_values,Fgy154734_attributes,Fgy154734_catalog_images,Fgy154734_categories,Fgy154734_cities,Fgy154734_comments,Fgy154734_contacts,Fgy154734_countries,Fgy154734_coupons,Fgy154734_coupons_categories,Fgy154734_coupons_products,Fgy154734_coupons_users,Fgy154734_couriers,Fgy154734_currencies,Fgy154734_downlodable_prods,Fgy154734_dynamic_layout,Fgy154734_email_template,Fgy154734_flags,Fgy154734_general_setting,Fgy154734_gifts,Fgy154734_has_attribute_values,Fgy154734_has_attributes,Fgy154734_has_categories,Fgy154734_has_combo_prods,Fgy154734_has_currency,Fgy154734_has_industries,Fgy154734_has_layouts,Fgy154734_has_options,Fgy154734_has_related_prods,Fgy154734_has_taxes,Fgy154734_has_upsell_prods,Fgy154734_has_vendors,Fgy154734_kot,Fgy154734,Fgy154734_layout,Fgy154734_loyalty,Fgy154734_newsletter,Fgy154734_notification,Fgy154734_occupancy_status,Fgy154734_offers,Fgy154734_offers_categories,Fgy154734_offers_products,Fgy154734_offers_users,Fgy154734_order_cancelled,Fgy154734_order_flag_history,Fgy154734_order_history,Fgy154734_order_return_action,Fgy154734_order_return_cashback_history,Fgy154734_order_return_open_unopen,Fgy154734_order_return_reason,Fgy154734_order_return_status,Fgy154734_order_status_history,Fgy154734_ordertypes,Fgy154734_password_resets,Fgy154734_payment_method,Fgy154734_permission_role,Fgy154734_permissions,Fgy154734_pincodes,Fgy154734_prod_status,Fgy154734_product_has_taxes,Fgy154734_product_types,Fgy154734_products,Fgy154734_restaurant_tables,Fgy154734_return_order,Fgy154734_role_user,Fgy154734_roles,Fgy154734_saved_list,Fgy154734_sections,Fgy154734_settings,Fgy154734_sizechart,Fgy154734_slider,Fgy154734_slider_master,Fgy154734_sms_subscription,Fgy154734_social_media_links,Fgy154734_states,Fgy154734_static_pages,Fgy154734_stock_update_history,Fgy154734_tagging_tagged,Fgy154734_tagging_tags,Fgy154734_tax,Fgy154734_testimonials,Fgy154734_translation,Fgy154734_unit_measures,Fgy154734_vendors,Fgy154734_wishlist,Fgy154734_language,Fgy154734_question_category,Fgy154734_zones";
            $dropQ = str_replace('Fgy154734', $st->prefix, $dropQ);

            $table = $st->prefix . '_additional_charges';
            DB::statement($dropQ);
            if (!Schema::hasTable($table)) { // No table found, safe to create it.
                echo "...not dfsfsd found===" . $st->prefix . '_additional_charges' . "<br>";
            } else {
                DB::statement($dropQ);
                $deleteStore = "Delete from stores where id=$st";
            }
        }
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

    public function clear_db()
    {
        $stores = Store::distinct('prefix')->where("id", '!=', 31)->get(['prefix']);
        //$stores = ['Mina690392','news230032','Nick288366','Pari390829','Prad855708','Pran329195','Pran329195'];

        foreach ($stores as $st) {
            //dd($st->prefix);
            $dropQ = "DROP TABLE Fgy154734_additional_charges,Fgy154734_attribute_sets,Fgy154734_attribute_types,Fgy154734_attribute_values,Fgy154734_attributes,Fgy154734_catalog_images,Fgy154734_categories,Fgy154734_cities,Fgy154734_comments,Fgy154734_contacts,Fgy154734_countries,Fgy154734_coupons,Fgy154734_coupons_categories,Fgy154734_coupons_products,Fgy154734_coupons_users,Fgy154734_couriers,Fgy154734_currencies,Fgy154734_downlodable_prods,Fgy154734_dynamic_layout,Fgy154734_email_template,Fgy154734_flags,Fgy154734_general_setting,Fgy154734_gifts,Fgy154734_has_addresses,Fgy154734_has_attribute_values,Fgy154734_has_attributes,Fgy154734_has_categories,Fgy154734_has_combo_prods,Fgy154734_has_currency,Fgy154734_has_industries,Fgy154734_has_layouts,Fgy154734_has_options,Fgy154734_has_products,Fgy154734_has_related_prods,Fgy154734_has_taxes,Fgy154734_has_upsell_prods,Fgy154734_has_vendors,Fgy154734_kot,Fgy154734,Fgy154734_layout,Fgy154734_loyalty,Fgy154734_newsletter,Fgy154734_notification,Fgy154734_occupancy_status,Fgy154734_offers,Fgy154734_offers_categories,Fgy154734_offers_products,Fgy154734_offers_users,Fgy154734_order_cancelled,Fgy154734_order_flag_history,Fgy154734_order_history,Fgy154734_order_return_action,Fgy154734_order_return_cashback_history,Fgy154734_order_return_open_unopen,Fgy154734_order_return_reason,Fgy154734_order_return_status,Fgy154734_order_status,Fgy154734_order_status_history,Fgy154734_ordertypes,Fgy154734_password_resets,Fgy154734_payment_method,Fgy154734_payment_status,Fgy154734_permission_role,Fgy154734_permissions,Fgy154734_pincodes,Fgy154734_prod_status,Fgy154734_product_has_taxes,Fgy154734_product_types,Fgy154734_products,Fgy154734_restaurant_tables,Fgy154734_return_order,Fgy154734_role_user,Fgy154734_roles,Fgy154734_saved_list,Fgy154734_sections,Fgy154734_settings,Fgy154734_sizechart,Fgy154734_slider,Fgy154734_slider_master,Fgy154734_sms_subscription,Fgy154734_social_media_links,Fgy154734_states,Fgy154734_static_pages,Fgy154734_stock_update_history,Fgy154734_tagging_tagged,Fgy154734_tagging_tags,Fgy154734_tax,Fgy154734_testimonials,Fgy154734_translation,Fgy154734_unit_measures,Fgy154734_vendors,Fgy154734_wishlist,Fgy154734_zones";
            $dropQ = str_replace('Fgy154734', $st->prefix, $dropQ);
            //dd(Schema::hasTable('magp250888_additional_charges'));
            DB::statement($dropQ);
            if (Schema::hasTable($st->prefix . '_users') != false) {
                // dd('dfdf');
                DB::statement($dropQ);

                echo "DELETED====" . $st->prefix . '_additional_charges' . "<br>";
            } else {
                echo "...not found===" . $st->prefix . '_additional_charges' . "<br>";
            }
        }
    }

    public function newStore()
    {

        if (Session::get('merchantid')) {
            Session::flash('storeadded', 'You can not create more than one store.');
            //return redirect()->back();
            return redirect()->to("/select-themes");
        }

        $domainname = str_replace(" ", '-', trim(strtolower(Session::get('storename')), " "));

        $availability = $this->availDomain(Session::get('storename'));
        //  dd($availability);
        //  dd($checkdomain);
        $cat = Category::where("status", 1)->pluck('category', 'id')->prepend('Industry *', '');
        $curr = HasCurrency::where('status', 1)->orderBy("currency_code", "asc")->get(['status', 'id', 'name', 'iso_code', 'currency_code']);
        $viewname = Config('constants.frontendView') . ".new-store";
        $data = ['cat' => $cat, 'curr' => $curr];
        return Helper::returnView($viewname, $data);
    }

    public function checkDomainAvail()
    {
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

    public function availDomain($availdomain = null)
    {
        if (!empty(Input::get('availdomain'))) {
            $availdomain = Input::get('availdomain');
        }

        $domainname = str_replace(" ", '-', trim(strtolower($availdomain), " "));

        $checkhttps = (isset($_SERVER['HTTPS']) === false) ? 'http' : 'https';

        $checkdomain = $checkhttps . "://" . $domainname . "." . str_replace("www", "", $_SERVER['HTTP_HOST']);
        $storedomain = Store::pluck('store_domain')->toArray();

        if (in_array($checkdomain, $storedomain)) {
            return $availability = "icon-remove red-close";
        } else {
            return $availability = "icon-ok green-ok";
        }
    }

    public function selectThemes()
    {
//        if(empty(Session::get('storename'))){
        //            return redirect()->to("/");
        //        }
        $themeIds = MerchantOrder::where("merchant_id", Session::get('merchantid'))->where("order_status", 1)->where("payment_status", 4)->pluck("merchant_id")->toArray();
        if (empty(Input::get('firstname')) && empty(Session::get('merchantid'))) {
            $cats = Category::where("status", 1)->get();

            $data = ['cats' => $cats, 'themeIds' => $themeIds];
            $viewname = Config('constants.frontendView') . ".select-themes";
            return Helper::returnView($viewname, $data);
        }
        if (empty(Session::get('merchantid'))) {

            $allinput = Input::all();
            $sendmsg = "Registred successfully.";
            // Helper::sendsms($allinput['phone'],$sendmsg);
            // Helper::sendsms(9930619304,$sendmsg);
            $names = explode(" ", $allinput['firstname']);
            $cats = Category::where("status", 1)->where("id", $allinput['business_type'])->get();
            $validator = Validator::make($allinput, Merchant::rules(null));
            if ($validator->fails()) {
                return $validator->messages()->toJson();
            } else {
                $getMerchat = new Merchant();
                $getMerchat->email = $allinput['email'];
                if (!empty($allinput['password'])) {
                    $getMerchat->password = Hash::make($allinput['password']);
                }
                if (!empty($allinput['provider_id'])) {
                    $getMerchat->provider_id = $allinput['provider_id'];
                    Session::put("provider_id", $allinput['provider_id']);
                }
                $getMerchat->firstname = $names[0];
                $getMerchat->company_name = $allinput['company_name'];
                $getMerchat->country_code = $allinput['country_code'];
                $getMerchat->lastname = @$names[1];
                $getMerchat->phone = $allinput['phone'];
                $getMerchat->register_details = json_encode(Input::all());
                $getMerchat->save();
                Session::put('merchantid', $getMerchat->id);
                Session::put('storename', $allinput['store_name']);
                Session::put('merchantstorecount', 0);

            }
        } else {
            $allinput = json_decode(Merchant::find(Session::get('merchantid'))->register_details, true);
            $cats = Category::where("status", 1)->where("id", $allinput['business_type'])->get();
            $checkStote = Merchant::find(Session::get('merchantid'))->getstores()->count();

            Session::put('merchantstorecount', $checkStote);
        }

        $data = ['cats' => $cats, 'allinput' => $allinput, 'themeIds' => $themeIds];
        $viewname = Config('constants.frontendView') . ".select-themes";
        return Helper::returnView($viewname, $data);
    }

    public function checkUser()
    {
        dd(Input::all());
    }

    public function checkFbUserLogin()
    {
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

    public function checkFbUser()
    {
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

    public function confirmMail($alldata)
    {
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
        $themeInput = (object) Input::get('themeInput');
        $domainname = str_replace(" ", '-', trim(strtolower($themeInput->domain_name), " "));
        $checkhttps = (isset($_SERVER['HTTPS']) === false) ? 'http' : 'https';
        $actualDomain = $checkhttps . "://" . $domainname . "." . str_replace("www", "", $_SERVER['HTTP_HOST']);
        $actualDomain = str_replace("..", ".", $actualDomain);
        if (!empty($themeInput->email)) {
            // $this->confirmMail($themeInput);
        }
        $getMerchat = Merchant::find(Session::get('merchantid'));
        $registerDetails = json_decode($getMerchat->register_details);
        $store = new Store();
        $store->store_name = $registerDetails->store_name;
        $store->url_key = $domainname;
        $store->merchant_id = $getMerchat->id;
        $store->category_id = $themeInput->cat_id;
        $store->template_id = $themeInput->theme_id;
        $store->store_domain = $actualDomain;
        $store->percent_to_charge = 1.00;
        $store->expiry_date = date('Y-m-d', strtotime(date("Y-m-d") . " + 365 day"));
        $store->status = 1;
        $merchantPay = MerchantOrder::where("merchant_id", Session::get('merchantid'))->where("order_status", 1)->where("payment_status", 4)->first();
        if (isset($merchantPay) && count($merchantPay) > 0) {
            $themeInput->store_version = 2;
            $store->store_version = 2;
        } else {
            $themeInput->store_version = 1;
            $store->store_version = 1;
        }
        if (empty($themeInput->id)) {
            if (!empty($themeInput->url_key)) {
                $chkUrlKey = Store::where("url_key", $themeInput->url_key)->count();
                if ($chkUrlKey == 0) {
                    $store->url_key = $themeInput->url_key;
                }
            }
            $store->prefix = $this->getPrefix($domainname);
        }
        // $merchantEamil = $getMerchat->email;
        // $merchantPassword = $getMerchat->password;
        $storeVersion = $themeInput->store_version;
        $firstname = $getMerchat->firstname;
        if (!empty($themeInput->password)) {
            $password = $themeInput->password;
        } else {
            $password = '';
        }

        if ($store->save()) {
            if (empty($themeInput->id)) {
                $result = $this->createInstance($store->id, $store->prefix, $store->url_key, $themeInput->email, $password, $themeInput->storename, $themeInput->theme_id, $themeInput->cat_id, $themeInput->currency, $getMerchat->phone, $firstname, $domainname, $storeVersion, $store->expiry_date);
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

        $dataS = [];
        $dataS['id'] = Input::get('id');
        $dataS['storedata'] = Store::find(Input::get('id'));
        $viewname = Config('constants.frontendView') . ".congrats";
        return Helper::returnView($viewname, $dataS);
    }

    public function createInstance($storeId, $prefix, $urlKey, $merchantEamil, $merchantPassword, $storeName, $themeid, $catid, $currency, $phone, $firstname, $domainname, $storeVersion, $expirydate)
    {
        ini_set('max_execution_time', 600);
        $merchantd = Merchant::find(Session::get('merchantid'));
        $messagearray = '[{"type": "A","name": "' . $domainname . '","data": "' . env('GODADDY_IP') . '","ttl": 3600}]';
        $fields = array(
            'data' => $messagearray,
        );
        //building headers for the request
        $headers = array(
            'Authorization: sso-key ' . env('GODADDY_KEY'),
            'Content-Type: application/json',
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, Config('constants.domainURL'));
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
        // stop Curl

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
                    //Last record
                    $lastUser = DB::table('users')->latest('id')->first();
                    $insertArr = ["id" => ($lastUser->id + 1), "email" => "$merchantEamil", "user_type" => 1, "status" => 1, "telephone" => "$phone", "firstname" => "$firstname", "store_id" => "$storeId", "prefix" => "$prefix"];
                    if (!empty($merchantPassword)) {
                        $randno = $merchantPassword;
                        $password = Hash::make($randno);
                        $insertArr["password"] = "$password";
                    }
                    if (Session::get("provider_id")) {
                        $provider_id = Session::get("provider_id");
                        $insertArr["provider_id"] = "$provider_id";
                    }
                    $country_code = $merchantd->country_code;
                    if ($country_code) {
                        $insertArr["country_code"] = "$merchantd->country_code";
                    }
                    //                    $randno = $merchantPassword;
                    //                    $password = Hash::make($randno);
                    $newuserid = DB::table("users")->insertGetId($insertArr);
                    switch ($catid) {
                        case '4':
                            DB::table($prefix.'_products')->where('id', 1)->update(
                            ['product' => 'Lenovo Ideapad D330 81H300AKIN 10.1-inch Detachable Laptop','url_key'=>'laptop-cum-tablet','prod_type'=>1,'stock'=>100,'cur'=>'','max_price'=>0,'min_price'=>0,'purchase_price'=>'0.00','price'=>'46000.00','spl_price'=>'46000.00','selling_price'=>'46000.00',]
                            );
                            DB::table($prefix.'_catalog_images')->delete();
                            DB::table($prefix.'_catalog_images')->insert(['filename'=>'electronics.jpg','alt_text'=>'','image_type'=>1,'image_mode'=>1,'catalog_id'=>1,'sort_order'=>1,'image_path'=>'']);
                            break;
                        case '5':
                            DB::table($prefix.'_products')->where('id', 1)->update(
                            ['product' => 'Vegan Aquafaba Chocolate Ice Cream','url_key'=>'chocolate-ice-cream','prod_type'=>1,'stock'=>100,'cur'=>'','max_price'=>0,'min_price'=>0,'purchase_price'=>'0.00','price'=>'300.00','spl_price'=>'300.00','selling_price'=>'300.00',]
                            );
                            DB::table($prefix.'_catalog_images')->delete();
                            DB::table($prefix.'_catalog_images')->insert(['filename'=>'icecream.jpg','alt_text'=>'','image_type'=>1,'image_mode'=>1,'catalog_id'=>1,'sort_order'=>1,'image_path'=>'']);
                            break;
                        case '7':
                            DB::table($prefix.'_products')->where('id', 1)->update(
                            ['product' => 'Frame All About You','url_key'=>'frame','prod_type'=>1,'stock'=>100,'cur'=>'','max_price'=>0,'min_price'=>0,'purchase_price'=>'0.00','price'=>'1390.00','spl_price'=>'1390.00','selling_price'=>'1390.00',]
                            );
                            DB::table($prefix.'_catalog_images')->delete();
                            DB::table($prefix.'_catalog_images')->insert(['filename'=>'art.jpg','alt_text'=>'','image_type'=>1,'image_mode'=>1,'catalog_id'=>1,'sort_order'=>1,'image_path'=>'']);
                            break;
                        case '8':
                            DB::table($prefix.'_products')->where('id', 1)->update(
                            ['product' => 'Bryan & Candy New York Cocoa Shea Bath Tub Kit for Complete Home Spa Experience','url_key'=>'beauty-wellness','prod_type'=>1,'stock'=>100,'cur'=>'','max_price'=>0,'min_price'=>0,'purchase_price'=>'0.00','price'=>'1200.00','spl_price'=>'1200.00','selling_price'=>'1200.00',]
                            );
                            DB::table($prefix.'_catalog_images')->delete();
                            DB::table($prefix.'_catalog_images')->insert(['filename'=>'beauty.jpg','alt_text'=>'','image_type'=>1,'image_mode'=>1,'catalog_id'=>1,'sort_order'=>1,'image_path'=>'']);
                            break;
                        case '9':
                            DB::table($prefix.'_products')->where('id', 1)->update(
                            ['product' => 'Flber Cotton Macrame Plant Hanger Handmade Rope Wall Hangings Home Decor','url_key'=>'home-decor','prod_type'=>1,'stock'=>100,'cur'=>'','max_price'=>0,'min_price'=>0,'purchase_price'=>'0.00','price'=>'13450.00','spl_price'=>'13450.00','selling_price'=>'13450.00',]
                            );
                            DB::table($prefix.'_catalog_images')->delete();
                            DB::table($prefix.'_catalog_images')->insert(['filename'=>'homedecor.jpg','alt_text'=>'','image_type'=>1,'image_mode'=>1,'catalog_id'=>1,'sort_order'=>1,'image_path'=>'']);
                            break;
                        case '10':
                            DB::table($prefix.'_products')->where('id', 1)->update(
                            ['product' => 'TAJ EXPERIENCES GIFT CARD','url_key'=>'gift-card','prod_type'=>1,'stock'=>100,'cur'=>'','max_price'=>0,'min_price'=>0,'purchase_price'=>'0.00','price'=>'5000.00','spl_price'=>'5000.00','selling_price'=>'5000.00',]
                            );
                            DB::table($prefix.'_catalog_images')->delete();
                            DB::table($prefix.'_catalog_images')->insert(['filename'=>'gifts.jpg','alt_text'=>'','image_type'=>1,'image_mode'=>1,'catalog_id'=>1,'sort_order'=>1,'image_path'=>'']);
                            break;
                        case '11':
                            DB::table($prefix.'_products')->where('id', 1)->update(
                            ['product' => 'Cute Kids Dore moon Nobita generic Cartoon Fun Play Anime','url_key'=>'toy','prod_type'=>1,'stock'=>100,'cur'=>'','max_price'=>0,'min_price'=>0,'purchase_price'=>'0.00','price'=>'575.00','spl_price'=>'575.00','selling_price'=>'575.00',]
                            );
                            DB::table($prefix.'_catalog_images')->delete();
                            DB::table($prefix.'_catalog_images')->insert(['filename'=>'toys.jpg','alt_text'=>'','image_type'=>1,'image_mode'=>1,'catalog_id'=>1,'sort_order'=>1,'image_path'=>'']);
                            break;
                        case '12':
                            DB::table($prefix.'_products')->where('id', 1)->update(
                            ['product' => 'Shining Diva Fashion Latest Design 18k Rose Gold Stylish Bracelet Earrings','url_key'=>'bracelet','prod_type'=>1,'stock'=>100,'cur'=>'','max_price'=>0,'min_price'=>0,'purchase_price'=>'0.00','price'=>'850.00','spl_price'=>'850.00','selling_price'=>'850.00',]
                            );
                            DB::table($prefix.'_catalog_images')->delete();
                            DB::table($prefix.'_catalog_images')->insert(['filename'=>'jewellery.jpg','alt_text'=>'','image_type'=>1,'image_mode'=>1,'catalog_id'=>1,'sort_order'=>1,'image_path'=>'']);
                            break;
                        case '13':
                            DB::table($prefix.'_products')->where('id', 1)->update(
                            ['product' => 'Nutri Blend Mixer and Grinder with Jars with Chopper and Juicer','url_key'=>'blender','prod_type'=>1,'stock'=>100,'cur'=>'','max_price'=>0,'min_price'=>0,'purchase_price'=>'0.00','price'=>'3599.00','spl_price'=>'3599.00','selling_price'=>'3599.00',]
                            );
                            DB::table($prefix.'_catalog_images')->delete();
                            DB::table($prefix.'_catalog_images')->insert(['filename'=>'kitchen.jpg','alt_text'=>'','image_type'=>1,'image_mode'=>1,'catalog_id'=>1,'sort_order'=>1,'image_path'=>'']);
                            break;
                        case '14':
                            DB::table($prefix.'_products')->where('id', 1)->update(
                            ['product' => 'Yonex AERO Comfort Badminton Shoes','url_key'=>'shoes','prod_type'=>1,'stock'=>100,'cur'=>'','max_price'=>0,'min_price'=>0,'purchase_price'=>'0.00','price'=>'2899.00','spl_price'=>'2899.00','selling_price'=>'2899.00',]
                            );
                            DB::table($prefix.'_catalog_images')->delete();
                            DB::table($prefix.'_catalog_images')->insert(['filename'=>'footwear.jpg','alt_text'=>'','image_type'=>1,'image_mode'=>1,'catalog_id'=>1,'sort_order'=>1,'image_path'=>'']);
                            break;
                        case '15':
                            DB::table($prefix.'_products')->where('id', 1)->update(
                            ['product' => 'National Geographic Encyclopedia of Space','url_key'=>'book','prod_type'=>1,'stock'=>100,'cur'=>'','max_price'=>0,'min_price'=>0,'purchase_price'=>'0.00','price'=>'3000.00','spl_price'=>'3000.00','selling_price'=>'3000.00',]
                            );
                            DB::table($prefix.'_catalog_images')->delete();
                            DB::table($prefix.'_catalog_images')->insert(['filename'=>'books.jpg','alt_text'=>'','image_type'=>1,'image_mode'=>1,'catalog_id'=>1,'sort_order'=>1,'image_path'=>'']);
                            break;
                        case '16':
                            DB::table($prefix.'_products')->where('id', 1)->update(
                            ['product' => 'Lenovo Ideapad D330 81H300AKIN 10.1-inch Detachable Laptop','url_key'=>'laptop-cum-tablet','prod_type'=>1,'stock'=>100,'cur'=>'','max_price'=>0,'min_price'=>0,'purchase_price'=>'0.00','price'=>'850.00','spl_price'=>'850.00','selling_price'=>'850.00',]
                            );
                            DB::table($prefix.'_catalog_images')->delete();
                            DB::table($prefix.'_catalog_images')->insert(['filename'=>'electronics.jpg','alt_text'=>'','image_type'=>1,'image_mode'=>1,'catalog_id'=>1,'sort_order'=>1,'image_path'=>'']);
                            break;
                        case '17':
                            DB::table($prefix.'_products')->where('id', 1)->update(
                            ['product' => 'Fresho Capsicum - Green','url_key'=>'capsicum','prod_type'=>1,'stock'=>100,'cur'=>'','max_price'=>0,'min_price'=>0,'purchase_price'=>'0.00','price'=>'55.00','spl_price'=>'55.00','selling_price'=>'55.00',]
                            );
                            DB::table($prefix.'_catalog_images')->delete();
                            DB::table($prefix.'_catalog_images')->insert(['filename'=>'mgrocery.jpg','alt_text'=>'','image_type'=>1,'image_mode'=>1,'catalog_id'=>1,'sort_order'=>1,'image_path'=>'']);
                            break;
                        default:
                            # code...
                            break;
                    }


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

                    if (!empty($currency)) {
                        $decodeVal['currency'] = $currency;
                        $decodeVal['currency_code'] = HasCurrency::find($currency)->iso_code;
                        $currVal = HasCurrency::find($currency);
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

                    $fp = fopen(base_path() . "/merchants/" . $domainname . '/storeSetting.json', 'w+');
                    fwrite($fp, $newJsonString);
                    fclose($fp);

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

                    if (!empty($catid)) {
                        Helper::saveDefaultSet($catid, $prefix, $storeId);
                    }
                    $banner = json_decode((StoreTheme::where("id", $themeid)->first()->banner_image), true);
                    // $banner = json_decode((Category::where("id", $catid)->first()->banner_image), true);
                    if (!empty($banner)) {
                        $homeLayout = DB::table("layout")->where('url_key', 'LIKE', 'home-page-slider')->where('store_id', $storeId)->first();
                        foreach ($banner as $image) {
                            $homePageSlider = [];
                            $file = $image['banner'];
                            $homePageSlider['layout_id'] = $homeLayout->id;
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
                        $boxLayout = DB::table("layout")->where('url_key', 'LIKE', 'home-page-3-boxes')->where('store_id', $storeId)->first();
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
                    if ($phone) {
                        $msgOrderSucc = "Congrats! Your new Online Store is ready. Download eStorifi Merchant Android app to manage your Online Store. Download Now https://goo.gl/kUSKro";
                        Helper::sendsms($phone, $msgOrderSucc, $country_code);
                    }
                    // permission_role
                    $baseurl = str_replace("\\", "/", base_path());
                    $domain = 'eStorifi.com'; //$_SERVER['HTTP_HOST'];
                    $sub = "eStorifi Links for Online Store - " . $storeName;
                    $mailcontent = "Congratulations " . $storeName . " has been created successfully!" . "\n\n";
                    $mailcontent .= "Kindly find the links to view your store:" . "\n";

                    $mailcontent .= "Store Admin Link: https://" . $domainname . '.' . $domain . "/admin" . "\n";
                    $mailcontent .= "Online Store Link: https://" . $domainname . '.' . $domain . "\n\n";
                    $mailcontent .= "For any further assistance/support, contact http://eStorifi.com/contact" . "\n";
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

    public function thankYou()
    {
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
        return Helper::returnView($viewname, $dataW);
    }

    public function pricing()
    {
        $data = [];
        $viewname = Config('constants.frontendView') . ".pricing";
        return Helper::returnView($viewname, $data);
    }

    public function logisticPartners()
    {
        $data = [];
        $viewname = Config('constants.frontendView') . ".logistic-partners";
        return Helper::returnView($viewname, $data);
    }

    public function infiniSys()
    {
        $data = [];
        $viewname = Config('constants.frontendView') . ".infini";
        return Helper::returnView($viewname, $data);
    }

    public function createStore()
    {
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
                    if ($chkUrlKey == 0) {
                        $store->url_key = Input::get('url_key');
                    }

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

    public function read()
    {

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

    public function checkExistingUser()
    {
        //echo Input::get('email');
        //    dd("dsf");
        $chkEmail = Merchant::where("email", Input::get('email'))->first();
        //  dd($chkEmail);

        if (isset($chkEmail) && count($chkEmail) > 0) {
            return 1;
        } else {
            return 0;
        }

    }

    public function checkExistingphone()
    {
        $chkEmail = Merchant::where("phone", Input::get('phone_no'))->first();
        if (isset($chkEmail) && count($chkEmail) > 0) {
            return 1;
        } else {
            return 0;
        }

    }

    public function getthemes()
    {
        $catid = Input::get('catid');
        $themes = Category::find($catid)->themes()->pluck('name', 'id')->toArray();
    }

    public function showThemes()
    {
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

    public function veestoresLogout()
    {
        Session::flush();
        Auth::guard('merchant-users-web-guard')->logout();
        return redirect()->to('/');
    }

    public function veestoreLogin()
    {
        $input = str_replace(" ", "", Input::get('mobile_email'));
        $login_type = filter_var($input, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
        $merchant = Merchant::where($login_type, $input)->first();

        $data = [];
        if (!$merchant && $merchant == null) {
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
//     if(!Session::get('merchantid')){
        //          return redirect()->to('/');
        //         }
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

    public function veestoresChangePassword()
    {
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

    public function veestoresUpdateProfile()
    {

        $merchant = Merchant::find(Session::get('merchantid'));

        $merchant->firstname = Input::get("firstname");
        $merchant->lastname = Input::get("lastname");
        $merchant->email = Input::get("email");
        $merchant->phone = Input::get("phone");
        $merchant->save();

        $data = ['status' => 'success', 'msg' => 'profile updated successfully!', 'merchant' => $merchant];
        return $data;
    }

    public function veestoresUpdateChangePassword()
    {
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

    public function veestoresTutorial()
    {
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

    public function featureList()
    {
        $data = [];
        $viewname = Config('constants.frontendView') . ".features";
        return Helper::returnView($viewname, $data);
    }

    public function termCondition()
    {
        $data = [];
        $viewname = Config('constants.frontendView') . ".terms-condition";
        return Helper::returnView($viewname, $data);
    }

    public function privacyPolicy()
    {
        $data = [];
        $viewname = Config('constants.frontendView') . ".privacy-policy";
        return Helper::returnView($viewname, $data);
    }

    public function aboutUs()
    {
        $data = [];
        $viewname = Config('constants.frontendView') . ".about";
        return Helper::returnView($viewname, $data);
    }

    public function videoTutorials()
    {
        $data = [];
        $viewname = Config('constants.frontendView') . ".video-tutorials";
        return Helper::returnView($viewname, $data);
    }

    public function contactUs()
    {
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
                $m->to("pravin@infiniteit.biz", $firstname)->subject('eStorifi Contact form!');
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

    public function notFound()
    {
        $data = [];
        $viewname = Config('constants.frontendView') . ".not-found";
        return Helper::returnView($viewname, $data);
    }

    public function resetNewPwd($link)
    {
        $data = ['link' => $link];
        $viewname = Config('constants.frontendView') . ".reset_forgot_pwd";
        return Helper::returnView($viewname, $data);
    }

    public function resetNewPwdSave()
    {
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
            //$m->cc('madhuri@infiniteit.biz');
        });
        session()->flash('pwdResetMsg', 'Password reset successfully!');

        return redirect()->route('home');
    }

    public function merchantForgotPassword()
    {
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
                $m->to('madhuri@infiniteit.biz', $firstname)->subject('Forgot password');
                //$m->cc('madhuri@infiniteit.biz');
            });
        } else if ($login_type == 'phone') {
            $msgOrderSucc = "Click on the link to reset your password. " . $linktosend . "Happy Learning! Team eStorifi";
            Helper::sendsms($userDetails->phone, $msgOrderSucc, $userDetails->country_code);
        }
    }

    public function sendOtp()
    {
        $country = Input::get("country");
        $mobile = Input::get("mobile");
        $otp = rand(1000, 9999);
        Session::put('otp', $otp);

        if ($mobile) {
            $msgOrderSucc = "Your one time password is. " . $otp . " Team eStorifi";
            Helper::sendsms($mobile, $msgOrderSucc, $country);
        }
        $data = ["status" => "success", "msg" => "OTP Successfully send on your mobileNumber","otp"=>$otp];
       
        return $data;
    }

    public function checkOtp()
    {
        $inputOtp = Input::get("inputotp");
        $otp = Session::get('otp');
        if ($inputOtp == $otp) {
            return $otp;
        } else {
            return 2;
        }
    }

}
