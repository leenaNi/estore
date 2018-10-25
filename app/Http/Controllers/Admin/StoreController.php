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
use App\Models\Templates;
use App\Models\Zone;
use App\Models\StoreTheme;
use Illuminate\Support\Facades\Input;
use Hash;
use File;
use DB;
use ZipArchive;
use App\Library\Helper;
use Mail;
use Validator;
use Auth;
use Session;
use Illuminate\Http\Request;

class StoreController extends Controller {

    public function index(Request $request) {
        $stores = Store::orderBy('id', 'desc');
        $categories = Category::where('status', 1)->get();
        $selCats = ['' => 'Select Category'];
        foreach ($categories as $cat) {
            $selCats[$cat->id] = $cat->category;
        }
        $search = Input::get('search');
        if (!empty(Input::get('s_bank_name'))) {
            $stores = $stores->whereHas("getmerchant.hasMerchants", function($sQuery) {
                $sQuery = $sQuery->where("banks.id", "=", Input::get('s_bank_name'));
            });
        }
        if (!empty($this->getbankid())) {
            $stores = $stores->whereHas("getmerchant.hasMerchants", function($sQuery) {
                $sQuery = $sQuery->where("banks.id", "=", $this->getbankid());
            });
        }
        if (!empty(Input::get('s_name'))) {
            $stores = $stores->where("store_name", "like", "%" . Input::get('s_name') . "%");
        }
        if (!empty(Input::get('date_search'))) {
            $dateArr = explode(" - ", Input::get('date_search'));
            $fromdate = date("Y-m-d", strtotime($dateArr[0])) . " 00:00:00";
            $todate = date("Y-m-d", strtotime($dateArr[1])) . " 23:59:59";
            $stores = $stores->where("created_at", ">=", "$fromdate")->where("created_at", "<", "$todate");
        }

        if (Auth::guard('merchant-users-web-guard')->check() !== false) {
            $stores = $stores->whereHas("getmerchant", function($mQuery) {
                $sQuery = $mQuery->where("merchants.id", "=", Session::get('authUserId'));
            });
        } else if (array_key_exists('token', $request->headers)) {
            $stores = $stores->whereHas("getmerchant", function($mQuery) {
                $sQuery = $mQuery->where("merchants.id", "=", $request->headers['authUserId']);
            });
        }

        if (Input::get('s_status') != '') {
            $stores = $stores->where("stores.status", "=", Input::get('s_status'));
        }

        if (!empty(Input::get('s_cat'))) {
            $stores = $stores->whereHas("getcategory", function($sCatquery) {
                $sCatquery = $sCatquery->where('categories.id', '=', Input::get('s_cat'));
            });
        }

        //$getAllStores = $stores->get();
        //dd($getAllStores);
        $stores = $stores->paginate(Config('constants.AdminPaginateNo'));
        $getBanks = Bank::orderBy("name", "asc")->get();
        $selBanks = ["" => "Select Bank"];
        foreach ($getBanks as $getB) {
            $selBanks[$getB->id] = $getB->name;
        }

        /* foreach ($getAllStores as $st) {
          //   dd($st->getlanguage);
          $st->categoryname = @$st->getcategory()->first()->category;
          $st->language_name = @$st->getlanguage()->first()->name;
          $st->merchant_name = @$st->getmerchant()->first()->company_name;
          } */

        $data = [];
        $viewname = Config('constants.AdminPagesStores') . ".index";
        $data['stores'] = $stores;
        $data['selCats'] = $selCats;
        $data['selBanks'] = $selBanks;
        //$data['storeList'] = $getAllStores;
        return Helper::returnView($viewname, $data);
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

    public function addEdit() {
        $id = Input::get('id');
        $store = Store::findOrNew($id);
        $templa = StoreTheme::where("cat_id",$store->category_id)->orderBy("id", "asc")->get();
        $templates = ['' => 'Select template'];
        foreach ($templa as $val) {
            $templates[$val->id] = $val->name;
        }
        if (Auth::guard('vswipe-users-web-guard')->check() !== false) {
            $merchants = Merchant::orderBy('firstname', 'asc')->get(['id', 'firstname']);
        } else if (Auth::guard('bank-users-web-guard')->check() !== false) {
            $bkid = $this->getbankid();
            $merchants = Merchant::whereHas('hasMarchants', function($q) use($bkid) {
                        $q->where("bank_id", $bkid);
                    })->orderBy('firstname', 'asc')->get(['id', 'firstname']);
            ;
        } else if (Auth::guard('merchant-users-web-guard')->check() !== false) {
            $merchants = Merchant::orderBy('firstname', 'asc')->where("id", Session::get('authUserId'))->get(['id', 'firstname']);
            ;
        } else if (array_key_exists('token', $request->headers)) {
            $merchants = Merchant::orderBy('id', 'desc')->where("id", $request->headers['authUserId'])->get();
        }
        $selMerchatns = ['' => 'Select Merchants'];
        foreach ($merchants as $merch) {
            $selMerchatns[$merch->id] = $merch->firstname;
        }
        $categories = Category::where('status', 1)->get();
        $selCats = ['' => 'Category'];
        foreach ($categories as $cat) {
            $selCats[$cat->id] = $cat->category;
        }
        $countries = Country::where('status', 1)->get();
        $selCountries = ['' => 'Please select'];
        foreach ($countries as $count) {
            $selCountries[$count->id] = $count->name;
        }
        $zones = Zone::where('status', 1)->get();
        $selZones = ['' => 'Please select'];
        foreach ($zones as $zone) {
            $selZones[$zone->id] = $zone->name;
        }
        $languages = Language::where('status', 1)->get();
        $languagesSel = ['' => 'Please select'];
        foreach ($languages as $language) {
            $languagesSel[$language->id] = $language->name;
        }
        $data = [];
        $viewname = Config('constants.AdminPagesStores') . ".addEdit";
        $data['selMerchatns'] = $selMerchatns;
        $data['selCats'] = $selCats;
        $data['selCountries'] = $selCountries;
        $data['store'] = $store;
        $data['selZones'] = $selZones;
        $data['languagesSel'] = $languagesSel;
        $data['templates'] = $templates;
        return Helper::returnView($viewname, $data);
    }

    public function saveUpdateGeneral() {
        $id = Input::get('id');
        $rules = [
            'merchant_id' => 'required',
            'category_id' => 'required',
            'store_name' => 'required|unique:stores' . ($id ? ",store_name,$id" : ''),
            'url_key' => 'required|unique:stores' . ($id ? ",url_key,$id" : ''),
            'status' => 'required',
            // 'language_id' => 'required',
            'template_id' => 'required'
        ];
        $messages = [
            'merchant_id.required' => 'Merchant name is required.',
            'category_id.required' => 'Category is required.',
            'store_name.unique' => 'This store name have been already taken',
            'url_key.unique' => 'This store name have been already taken',
            'url_key.required' => 'Store name is required',
            'url_key.required' => 'Store url key is required',
            'status.required' => 'Status is required',
            //'language_id.required' => 'Language is required',
            'template_id.required' => 'Template is required'
        ];
        $validator = Validator::make(Input::all(), $rules, $messages);
        if ($validator->fails()) {
            return $validator->messages()->toJson();
        } else {
            $store = Store::findOrNew(Input::get('id'));
            $store->store_name = Input::get('store_name');
            $store->merchant_id = Input::get('merchant_id');
            $store->category_id = Input::get('category_id');
            $store->language_id = 1; //Input::get('language_id');
            $store->template_id = Input::get('template_id');
            $store->status = Input::get('status');
        $storePath = base_path() . '/merchants/' . $store->url_key;
        $storedata = Helper::getStoreSettings($storePath);
      
        $storedata['storeName'] = $store->store_name;  
        $storedata['themeid'] = Input::get('template_id');
       
        $newSoter = json_encode($storedata);
        Helper::updateStoreSettings($storePath, $newSoter);
        Helper::getStoreSettings($storePath);
            if (Input::hasFile('logo')) {
                $logo = Input::file('logo');
                $destinationPath = public_path() . '/public/admin/uploads/logos/';
                $fileName = "store-" . date("YmdHis") . "." . $logo->getClientOriginalExtension();
                $upload_success = $logo->move($destinationPath, $fileName);
                $store->logo = @$fileName;
            }
//            if (empty(Input::get('id'))) {
//                if (!empty(Input::get('url_key'))) {
//                    $chkUrlKey = Store::where("url_key", Input::get('url_key'))->count();
//                    if ($chkUrlKey == 0)
//                        $store->url_key = Input::get('url_key');
//                }
//                $store->prefix = $this->getPrefix(Input::get('store_name'));
//            }
//            $getMerchat = Merchant::find($store->merchant_id);
//            $merchantEamil = $getMerchat->email;
//            $merchantPassword = $getMerchat->password;
//            $template = Templates::find($store->template_id);
//            $templateFile = $template->file;
//            $store->save();
//            if ($store->save()) {
//                if (empty(Input::get('id'))) {
//                    $this->createInstance($store->prefix, $store->url_key, $merchantEamil, $merchantPassword, $templateFile, Input::get('category_id'));
//                }
//            }
            $data = [];
            $data['id'] = $store->id;
            $data['storedata'] = $store;
            $data['status'] = "success";

            return $data;
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

    public function saveUpdateContact() {
        $id = Input::get('id');
        $rules = [
            'country_id' => 'required',
            'zone_id' => 'required',
            'pin' => 'required',
            'address' => 'required',
            'contact_firstname' => 'required',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|numeric'
        ];
        $messages = [
            'country_id.required' => 'Country is required.',
            'zone_id.required' => 'State is required.',
            'pin.required' => 'Pin is required',
            'contact_firstname.required' => 'Contact firstname is required',
            'contact_email.required' => 'Contact Email is required',
            'contact_phone.required' => 'Phone is required',
        ];
        $validator = Validator::make(Input::all(), $rules, $messages);
        if ($validator->fails()) {
            return $validator->messages()->toJson();
        } else {
            $store = Store::find(Input::get('id'));
            $store->fill(Input::all())->save();
       $contact=DB::table($store->prefix.'_static_pages')->where("url_key","contact-us")->first()->contact_details;
       $contachDetals=(json_decode($contact));
       $contachDetals->contact_person=$store->contact_firstname;
       $contachDetals->mobile=$store->contact_phone;
       $contachDetals->email=$store->contact_email;
       $contachDetals->address_line1=$store->address;
       $contachDetals->address_line2=$store->address2;
       $contachDetals->thana=$store->thana;
       $contachDetals->city=$store->city; 
       $contachDetals->country=$store->country_id;
       $contachDetals->state=$store->zone_id;
       $contachDetals->pincode=$store->pin;   
       DB::table($store->prefix.'_static_pages')->where("url_key","contact-us")->update(['contact_details'=>json_encode($contachDetals)]);
           
       $data = [];
            $data['id'] = $store->id;
            $data['status'] = 'success';
            $data['storedata'] = $store;
            return $data;
        }
    }

    public function saveUpdateBusiness() {
        $id = Input::get('id');
        $rules = [ "precent_to_charge" => "required"];
        $messages = ["precent_to_charge" => "Percent to charge on order."];
        $validator = Validator::make(Input::all(), $rules, $messages);
        if ($validator->fails()) {
            return $validator->messages()->toJson();
        } else {
            $store = Store::find(Input::get('id'));
            // dd(Input::all());
            $store->fill(Input::all())->save();
            $data = [];
            $data['id'] = $store->id;
            $data['status'] = 'success';
            $data['storedata'] = $store;
            return $data;
        }
    }

    public function saveUpdateBank() {
        $id = Input::get('id');
        $rules = [
            'ac_holder_name' => 'required',
            'bank_name' => 'required',
            'branch_name' => 'required',
            'ac_no' => 'required|numeric',
            'ifsc_code' => 'required',
        ];
        $messages = [
            'ac_holder_name.required' => 'Name as per Bank  is required.',
            'bank_name.required' => 'Bank name is required.',
            'branch_name.required' => 'Branch name is required.',
            'ac_no.required' => 'Account Number is required.',
            'ifsc_code.required' => 'IFSC Code  is required.',
        ];
        $validator = Validator::make(Input::all(), $rules, $messages);
        if ($validator->fails()) {
            return $validator->messages()->toJson();
        } else {
            $store = Store::find(Input::get('id'));
            $store->fill(Input::all())->save();
            $data = [];
            $data['id'] = $store->id;
            $data['status'] = 'success';
            $data['storedata'] = $store;
            return $data;
        }
    }

    public function saveUpdateStoreDoc() {
        // dd(Input::all());
        $validation = new Store();
        $rules = ['des.*' => 'required', 'docs.*' => 'required|mimes:png,gif,jpeg,txt,pdf,doc'];
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return $validator->errors()->all();
        } else {
            foreach (Input::get('des') as $imgK => $imgV) {
                $saveCImh = Document::findOrNew(Input::get('id_doc')[$imgK]);
                $saveCImh->parent_id = Input::get('id');
                if (Input::get('is_doc')[$imgK] == 1) {
                    $file = Input::file('docs')[$imgK];
                    $destinationPath = public_path() . '/public/admin/uploads/storeDocuments/';
                    $fileName = "doc-" . $imgK . date("YmdHis") . "." . $file->getClientOriginalExtension();
                    $upload_success = $file->move($destinationPath, $fileName);
                    $saveCImh->filename = is_null($fileName) ? $saveCImh->filename : $fileName;
                } else {
                    $fileName = null;
                }
                $saveCImh->doc_type = 2;
                $saveCImh->des = Input::get('des')[$imgK];
                $saveCImh->save();
            }
            $data['storelist'] = Store::where("status", 1)->get();
            $redirectTo = 'admin.stores.view';
            return Helper::returnView(null, $data, $redirectTo);
            // return redirect()->route();
        }
    }

    public function deleteStoreDoc() {
        $id = Input::get('docId');
        $del = Document::find($id);
        $del->delete();
        echo "Successfully deleted";
    }

    public function createInstance($prefix, $urlKey, $merchantEamil, $merchantPassword, $templateFile, $catid) {
        // echo $merchantEamil."@@@".$merchantPassword;
        ini_set('max_execution_time', 600);
        $contents = File::get(public_path() . "/public/skeleton.sql");
        $sql = str_replace("tblprfx", $prefix, $contents);
        $test = DB::unprepared($sql);
        //dd($test);
        // $test = 1;
        if (DB::unprepared($sql)) {
            $path = base_path() . "/$urlKey";
            $mk = File::makeDirectory($path, 0777, true, true);
            //dd($mk);
            if ($mk) {
                $file = public_path() . '/public/skeleton.zip';
                $template = public_path() . $templateFile;
                $zip = new ZipArchive;
                $res = $zip->open($file);
                //dd($res);
                if ($res === TRUE) {
                    $zip->extractTo($path);
                    $zip->close();
                    $this->replaceFileString($path . "/.env", "%DB_DATABASE%", env('DB_DATABASE', ''));
                    $this->replaceFileString($path . "/.env", "%DB_USERNAME%", env('DB_USERNAME', ''));
                    $this->replaceFileString($path . "/.env", "%DB_PASSWORD%", env('DB_PASSWORD', ''));
                    $this->replaceFileString($path . "/.env", "%DB_TABLE_PREFIX%", $prefix . "_");
                    $randno = $merchantPassword;
                    $password = Hash::make($randno);
                    $newuserid = DB::table($prefix . "_users")->insertGetId([
                        "email" => "$merchantEamil", "user_type" => 1, "status" => 1, "password" => "$password"
                    ]);
                    $json_url = realpath(getcwd() . "/..") . "/" . $urlKey . "/storage/json/storeSetting.json";
                    $json = file_get_contents($json_url);
                    $decodeVal = json_decode($json, true);
                    $decodeVal['industry_id'] = $catid;
                    $decodeVal['storeName'] = $storeName;
                    if (!empty($themeid)) {
                        $themedata = DB::select("SELECT t.id,c.category,t.name,t.image from themes t left join categories c on t.cat_id=c.id order by c.category");
                        $decodeVal['theme'] = strtolower(StoreTheme::find($themeid)->name);
                        $decodeVal['themeid'] = 1;
                        $decodeVal['themedata'] = $themedata;
                        $decodeVal['currencyId'] = @Currency::find($currency)->iso_code;
                        //$decodeVal['currency_code'] = @Currency::find($currency)->iso_code;
                        $newJsonString = json_encode($decodeVal);
                    }
                    if (!empty($currency)) {
                        $decodeVal['currency'] = $currency;
                        $decodeVal['currency_code'] = @Currency::find($currency)->iso_code;
                        $currVal = Currency::find($currency);
                        if (!empty($currVal)) {
                            $currJson = json_encode(['name' => $currVal->name, 'iso_code' => $currVal->iso_code]);
                            DB::table($prefix . "_general_setting")->insert(['name' => 'Default Currency', 'status' => 0, 'details' => $currJson, 'url_key' => 'default-currency', 'type' => 1, 'sort_order' => 10000, 'is_active' => 0, 'is_question' => 0]);
                        }
                    }

                    $fp = fopen(realpath(getcwd() . "/..") . "/" . $urlKey . '/storage/json/storeSetting.json', 'w+');
                    fwrite($fp, $newJsonString);
                    fclose($fp);
                    DB::table($prefix . "_role_user")->insert([
                        ["user_id" => @$newuserid, "role_id" => "1"]
                    ]);
                    //Check acl setting from general settings
                    $chkAcl = DB::table($prefix . "_general_setting")->where('url_key', 'acl')->select("status")->first();
                    //print_r($chkAcl);
                    //dd($chkAcl->status);
                    //if No then add roles permissions if yes then skip
                    if ($chkAcl->status == '1') {
                        $allPermissions = DB::table($prefix . "_permissions")->select("id")->get();
                        $permissions = [];
                        foreach ($allPermissions as $key => $ap) {
                            $permissions[$key]['permission_id'] = $ap->id;
                            $permissions[$key]['role_id'] = 1;
                        }
                        $insertPermission = DB::table($prefix . "_permission_role")->insert($permissions);
                    }
//                    $this->addCategory($prefix);
//                    $this->addAttributeSet($prefix);
//                    $this->addAttribute($prefix);
                    if (!empty($catid)) {
                        Helper::saveDefaultSet($catid, $prefix);
                    }
                    $banner = json_decode((Category::where("id", $catid)->first()->banner_image), true);
                    foreach ($banner as $image) {
                        $file = $image['banner'];
                        $homePageSlider['layout_id'] = 1;
                        $homePageSlider['is_active'] = $image['banner_status'];
                        $homePageSlider['image'] = $image['banner'];
                        $homePageSlider['sort_order'] = $image['sort_order'];
                        $source = public_path() . '/public/admin/themes/';
                        $destination = base_path() . "/" . $urlKey . "/public/public/Admin/uploads/layout/";
                        copy($source . $file, $destination . $file);
                        DB::table($prefix . "_has_layouts")->insert($homePageSlider);
                    }
                    $threeBoxes = json_decode((StoreTheme::where("id", $themeid)->first()->threebox_image), true);
                    foreach ($threeBoxes as $image) {
                        $file = $image['banner'];
                        $homePageSlider['layout_id'] = 4;
                        $homePageSlider['is_active'] = $image['banner_status'];
                        $homePageSlider['image'] = $image['banner'];
                        $homePageSlider['sort_order'] = $image['sort_order'];
                        $source = public_path() . '/public/admin/themes/';
                        $destination = base_path() . "/" . $urlKey . "/public/public/Admin/uploads/layout/";
                        copy($source . $file, $destination . $file);
                        DB::table($prefix . "_has_layouts")->insert($homePageSlider);
                    }
                    // permission_role
                    $baseurl = str_replace("\\", "/", base_path());
                    $domain = $_SERVER['HTTP_HOST'];
                    $sub = "Use merchant login credentilas for login " . $urlKey;
                    $mailcontent = "";
                    $mailcontent .= "Site URL - " . $domain . "/" . $urlKey . "\n";
                    $mailcontent .= "Admin URL - " . $domain . "/" . $urlKey . "/admin/" . "\n";
                    $mailcontent .= "Code - " . $prefix . "\n";
                    Helper::withoutViewSendMail($merchantEamil, $sub, $mailcontent);
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

    public function getZoneDropdown($id = null) {

        if ($id) {
            $id = $id;
        } else {
            $id = Input::get('country_id');
        }
        $zone = Zone::where("country_id", "=", $id)->get(['id', 'name'])->toArray();
        echo json_encode($zone);
    }

    public function ApiStoreSaveUpdate() {

        $allH = getallheaders();
        $allInput = Input::all();
        $allInput['merchant_id'] = $allH['authUserId'];

        $id = Input::get('id');
        $rules = [
            'merchant_id' => 'required',
            'category_id' => 'required',
            'language_id' => 'required',
            'country_id' => 'required',
            'zone_id' => 'required',
            'address' => 'required',
            'contact_firstname' => 'required',
            'contact_email' => 'required',
            'tin' => 'required',
            'store_name' => 'required|unique:stores' . ($id ? ",store_name,$id" : ''),
            'status' => 'required'
        ];
        $messages = [
            'merchant_id.required' => 'Merchant name is required.',
            'category_id.required' => 'Category is required.',
            'language_id.required' => 'Language is required.',
            'country_id.required' => 'Country is required.',
            'zone_id.required' => 'Zone is required.',
            'address.required' => 'Address is required.',
            'contact_firstname.required' => 'Contact Name is required.',
            'contact_email.required' => 'Contact Eamil Id is required.',
            'tin.required' => 'Tin is required.',
            'store_name.unique' => 'This store name have been already taken',
            'store_name.required' => 'Store name is required',
            'status.required' => 'Status is required'
        ];
        $validator = Validator::make($allInput, $rules, $messages);
        if ($validator->fails()) {
            return $validator->messages()->toJson();
        } else {
            $store = Store::findOrNew(Input::get('id'));
            $store->fill($allInput)->save();

            if (empty(Input::get('id'))) {

                $store->prefix = $this->getPrefix(Input::get('store_name'));
            }
            $store->update();
            $getMerchat = Merchant::find($store->merchant_id);
            $merchantEamil = $getMerchat->email;
            $merchantPassword = $getMerchat->password;
            if ($store->save()) {
                if (empty(Input::get('id'))) {
                    //  $this->createInstance($store->prefix, $store->url_key, $merchantEamil, $merchantPassword);
                }
            }
            $data = [];
            $data['id'] = $store->id;
            $data['storedata'] = $store;
            $data['status'] = "success";

            return $data;
        }
    }

    public function addCategory($prifix) {
        $cat = json_decode($categories->categories, true);
        foreach ($cat as $catdata) {
            $catname[]["category"] = $catdata;
        }
        // dd($catname);
        $prifix = 'gupt280105_';
        DB::table($prifix . 'categories')->insert($catname);
    }

    public function addAttributeSet($prifix) {
        $attrSets = json_decode($categories->attributeset, true);
        foreach ($attrSets as $attrSet) {
            $catname[]["attr_set"] = $attrSets;
            $catname[]["status"] = 1;
        }
        // dd($catname);
        $prifix = 'gupt280105_';
        DB::table($prifix . 'attribute_sets')->insert($catname);
    }

    public function addAttribute($prifix) {
        $cat = json_decode($categories->attribute, true);
        foreach ($cat as $catdata) {
            $catname[]["category"] = $catdata;
        }
        // dd($catname);
        $prifix = 'gupt280105_';
        DB::table($prifix . 'categories')->insert($catname);
    }

}
