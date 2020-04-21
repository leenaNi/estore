<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Library\CustomValidator;
use App\Models\Vendor;
use App\Models\Bank;
use App\Models\Category;
use App\Models\Currency;
use App\Library\Helper;
use App\Models\Document;
use App\Models\Layout;
use App\Models\Settings;
use App\Models\Country;
use App\Models\Store;
use App\Models\MerchantOrder;
use App\Models\HasCurrency;
use Validator;
use Illuminate\Support\Facades\Input;
use Hash;
use Session;
use Auth;
use DB;
use File;
use JWTAuth;
use ZipArchive;

class DistributorController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $headers = $request->headers->all();

        $allBanks = Bank::all();
        $bank['0'] = "Select Bank";
        foreach ($allBanks as $allB) {
            $bank[$allB->id] = $allB->name;
        }
        
        if (Auth::guard('vswipe-users-web-guard')->check() !== false) 
        {
            $distributors = Vendor::orderBy('id', 'desc')->get();
            
            //dd($distributors);exit;
        } 
        else if (Auth::guard('bank-users-web-guard')->check() !== false) 
        {
            $bkid = $this->getbankid();
            $distributors = Vendor::whereHas('hasMarchants', function($q) use($bkid) 
            {
                $q->where("bank_id", $bkid);
            })->orderBy('id', 'desc');
        } 
        else if (Auth::guard('merchant-users-web-guard')->check() !== false) 
        {
            $distributors = Vendor::orderBy('id', 'desc')->where("id", Session::get('authUserId'));
        } 
        else if (array_key_exists('token', $headers)) 
        {
            $distributors = Vendor::orderBy('id', 'desc')->where("id", Session::get('authUserId'));
        }
       
        $search = Input::get('search');
        if (!empty($search)) {

            if (!empty(Input::get('s_bank_name'))) {
                $distributors = $distributors->whereHas("hasMerchants", function($query) {
                    $query->where("banks.id", Input::get('s_bank_name'));
                });
            }
            //echo "anme >> ".Input::get('s_company_name');
            if (!empty(Input::get('s_company_name'))) {
                $distributors = $distributors->where("firstname", "like", "%" . Input::get('s_company_name') . "%");
            }
            if (!empty(Input::get('s_email'))) {
                $distributors = $distributors->where("email", "like", "%" . Input::get('s_email') . "%");
            }
            if (!empty(Input::get('date_search'))) {
                $dateArr = explode(" - ", Input::get('date_search'));
                $fromdate = date("Y-m-d", strtotime($dateArr[0])) . " 00:00:00";
                $todate = date("Y-m-d", strtotime($dateArr[1])) . " 23:59:59";
                $distributors = $distributors->where("created_at", ">=", "$fromdate")->where("created_at", "<", "$todate");
            }
        }

        //echo "<pre>";print_r($distributors);

       /* if (Auth::guard('vswipe-users-web-guard')->check() !== false) {
			$distributors = Vendor::where('id', 11)->get();
        } */
       // echo count($distributors);
       // echo "<pre>";print_r($distributors);
        $categories = Category::where('status', 1)->get();
       
        $selCats = ['' => 'Select Category'];
        foreach ($categories as $cat) {
            $selCats[$cat->id] = $cat->category;
        }
       
        //$distributor = $distributor->paginate(Config('constants.AdminPaginateNo'));
       
        $data = [];
        $viewname = Config('constants.AdminPagesDistributors') . ".index";
        //echo "<pre>";
        //print_r($distributors);
        //exit;
        $data['distributor'] = $distributors;
        $data['selCats'] = $selCats;
        //$data['selBanks'] = $selBanks;
        //$data['storeList'] = $getAllStores;
        
        return Helper::returnView($viewname,$data);
    } // End index()

    public function addEdit()
    {        
        $fetchedDistributorData = Vendor::findOrNew(Input::get('id'));
        //echo "<pre>";print_r($fetchedDistributorData);
        $data = [];
        $data['already_selling'] = [];
        if ($fetchedDistributorData && Input::get('id')) {
            $resgisterDetails = json_decode($fetchedDistributorData->register_details);
            //echo "<pre>";print_r($resgisterDetails);exit;
            $data['cat_selected'] = $resgisterDetails->business_type;
            //$data['curr_selected'] = $resgisterDetails->currency;
            $data['curr_selected'] = $fetchedDistributorData->currency_code;
            if(isset($resgisterDetails->already_selling) && !empty($resgisterDetails->already_selling))
                $data['already_selling'] = ($resgisterDetails->already_selling);
            //$data['store_version'] = ($resgisterDetails->store_version);
            $data['store_version'] = '';
        }

        $cat = Category::where("status", 1)->pluck('category', 'id')->prepend('Choose your Industry *', '');
        $curr = Currency::where('status', 1)->orderBy("iso_code", "asc")->get(['status', 'id', 'name', 'iso_code']);

        $viewname = Config('constants.AdminPagesDistributors') . ".addEdit";
        $data['distributor'] = $fetchedDistributorData;
        $data['cat'] = $cat;
        $data['curr'] = $curr;
        return Helper::returnView($viewname, $data);
    } // End addEdit();

    public function saveUpdate()
    {
        $allinput = Input::all();
        $storeName = Input::get('company_name');
        $phone = Input::get('phone_no');
        if (CustomValidator::validatePhone($phone)) {
            if (empty(Input::get('id'))) {
            $storeType = 'distributor';
            $settings = Settings::where('bank_id', 0)->first();
            $country = Country::where("id", $settings->country_id)->get()->first();
            $currency = Currency::where("id", $settings->currency_id)->get()->first();
            $settings['country_code'] = $country['country_code'];
            $settings['country_name'] = $country['name'];
            $settings['currency_code'] = $currency['id'];
            $allinput['currency'] = $currency['id'];
            $allinput['currency_code'] = $currency['id'];
            $allinput['country_code'] = $country['country_code'];
            $domainname = str_replace(" ", '-', trim(strtolower($storeName), " "));
            $checkhttps = (isset($_SERVER['HTTPS']) === false) ? 'http' : 'https';
            $actualDomain = $checkhttps . "://" . $domainname . "." . str_replace("www", "", $_SERVER['HTTP_HOST']);
            $actualDomain = str_replace("..", ".", $actualDomain);
            $allinput['domain_name'] = $domainname;
            $allinput['store_name'] = $storeName;
            $newMerchant = '';
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
            $getMerchat = new Vendor;
            $getMerchat->phone_no = $phone;
            $getMerchat->password = Hash::make(Input::get('password'));
            $getMerchat->email = Input::get("email");
            $getMerchat->firstname = Input::get("firstname");
            $getMerchat->business_name = $storeName;
            $getMerchat->country = $country['country_code'];
            // $getMerchat->register_details = json_encode($allinput);
            $getMerchat->register_details = json_encode(collect($allinput)->except('_token', 'id', 'existing_mid', 'company_name'));
            $getMerchat->save();
            $lastInsteredId = $getMerchat->id;
            if ($lastInsteredId > 0) {
                $merchantObj1 = Vendor::find($lastInsteredId);
                $identityCode = Helper::createUniqueIdentityCode($allinput, $lastInsteredId);
                $merchantObj1->identity_code = $identityCode;
                $decoded = json_decode($merchantObj1->register_details, true);
                $decoded['business_type'] = $allinput['business_type'];
                $json = json_encode($decoded);
                $merchantObj1->register_details = $json;
                $merchantObj1->save();
            }
            // print_r($getMerchat);
            $newMerchant = $getMerchat;
            $store = new Store();
            $store->store_name = $storeName; // $registerDetails->store_name;
            $store->url_key = $domainname;
            $store->store_type = $storeType; // merchant/distributor
            $store->merchant_id = $lastInsteredId;
            $store->store_domain = $actualDomain;
            $store->percent_to_charge = 1.00;
            $store->expiry_date = date('Y-m-d', strtotime(date("Y-m-d") . " + 365 day"));
            $store->status = 1;
            $store->category_id = $allinput['business_type'][0];
            $merchantPay = MerchantOrder::where("merchant_id", Session::get('merchantid'))->where("order_status", 1)->where("payment_status", 4)->first();
            if (isset($merchantPay) && count($merchantPay) > 0) {
                $store->store_version = 2;
            } else {
                $store->store_version = 1;
            }
            $store->prefix = app('App\Http\Controllers\Admin\MerchantController')->getPrefix($domainname);
            if ($store->save()) {
                // print_r($store);
                $storeVersion = $store->store_version;
                $result = app('App\Http\Controllers\Admin\MerchantController')->createInstance($storeType, $store->id, $store->prefix, $store->url_key, $store->store_name, $settings['currency_code'], $newMerchant->phone_no, $domainname, $storeVersion, $store->expiry_date, $identityCode, $settings['country_code'], $newMerchant);
                if ($result['status']) {
                    if($allinput['is_individual_store']) {
                        $sub = "Login credentials for " . $storeName . ". You can create one or more store using app";
                        $mailcontent = "Your Username/Login Id - " . $getMerchat->phone . "\n";
                        $mailcontent .= "Password - " . Input::get('password') . "\n";
                        Helper::withoutViewSendMail($getMerchat->email, $sub, $mailcontent);
                    }
                    $regUser = DB::table('users')->where('store_id', $store->id)->where('user_type', 3)->first(['id', 'telephone', 'store_id', 'prefix', 'country_code']);
                    $token = JWTAuth::fromUser($regUser);
                    $user = JWTAuth::toUser($token);
                    $store = $store; // $getMerchat->getstores;
                    return response()->json(["status" => 1, 'msg' => 'Saved successfully', 'data' => ['id' => $getMerchat->id, 'user' => $user, 'store' => $store, 'merchant' => $newMerchant]])->header('token', $token);
                } else {
                    return response()->json($result);
                }
            } else {
                return response()->json(["status" => 0, 'msg' => 'Something went wrong!']);
            }
        } else {
            $updateArr = ["updated_by" => Session::get('authUserId')];
            $distributor = Vendor::findOrNew(Input::get('id'));
            $distributor->fill(Input::all());
            $all_data = Input::all();
            $settings = Settings::where('bank_id', 0)->first();
            $country = Country::where("id", $settings->country_id)->get()->first();
            $currency = Currency::where("id", $settings->currency_id)->get()->first();
            $all_data['currency'] = $currency['id'];
            $all_data['currency_code'] = $currency['id'];
            $all_data['country_code'] = $country['country_code'];
            // $merchant->register_details = json_encode(collect(Input::all())->except('_token', 'id', 'existing_mid'));
            $distributor->register_details = json_encode(collect($all_data)->except('_token', 'id', 'existing_mid'));
            $distributor->save();
            if (!empty($this->getbankid())) {
                $hasmer = $distributor->hasMarchants()->withPivot('id', 'bank_id', 'merchant_id', 'added_by', 'updated_by', 'created_at', 'updated_at')->get();
                if (!empty($hasmer)) {
                    foreach ($hasmer as $hm) {
                        $merchant->hasMarchants()->updateExistingPivot($hm->pivot->bank_id, $updateArr);
                    }
                }
            }
            $result['id'] = $distributor->id;
            $result['distributor'] = $distributor;
            $result['docs'] = @$distributor->documents()->get();
            $data = ['status' => 1, 'msg' => 'Saved successfully', 'data' => $result];
        }
        } else {
            $data = ["status" => 0, "msg" => "Invalid mobile number"];
        }
        return Helper::returnView(null, $data);
    } // Edn saveUpdate()
}