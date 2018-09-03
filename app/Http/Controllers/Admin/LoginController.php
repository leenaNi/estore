<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Input;
use Illuminate\Contracts\Auth\Guard;
use Session;
use Route;
use App\Models\User;
use App\Models\Currency;
use App\Models\Bank;
use App\Models\Store;
use App\Models\BankUser;
use App\Models\VswipeSale;
use App\Models\VswipeUser;
use App\Models\Merchant;
use Illuminate\Http\Request;
use Validator;
use DB;
use Hash;
use Crypt;
use View;
use Carbon\Carbon;
use App\Library\Helper;

class LoginController extends Controller {

    public function dashboard(Request $request) {
        
//        $stores = DB::select("SELECT s.id,s.prefix FROM `stores` s 
//            left join merchants m on  s.merchant_id = m.id
//            left join bank_has_merchants bm on m.id = bm.merchant_id
//            left join banks b on bm.bank_id = b.id
//            where s.status=1 and s.merchant_id != 3            
//            group by s.id");
//        //  dd($stores);
//        $allStoreOperatores = 0;
//        foreach ($stores as $sA) {
//            $topStoreSales = DB::statement("DROP TABLE ".$sA->prefix."_additional_charges,".$sA->prefix."_attribute_sets,".$sA->prefix."_attribute_types,".$sA->prefix."_attribute_values,".$sA->prefix."_attributes,".$sA->prefix."_catalog_images,".$sA->prefix."_categories,".$sA->prefix."_cities,".$sA->prefix."_comments,".$sA->prefix."_contacts,".$sA->prefix."_countries,".$sA->prefix."_coupons,".$sA->prefix."_coupons_categories,".$sA->prefix."_coupons_products,".$sA->prefix."_coupons_users,".$sA->prefix."_couriers,".$sA->prefix."_currencies,".$sA->prefix."_downlodable_prods,".$sA->prefix."_dynamic_layout,".$sA->prefix."_email_template,".$sA->prefix."_flags,".$sA->prefix."_general_setting,".$sA->prefix."_gifts,".$sA->prefix."_has_addresses,".$sA->prefix."_has_attribute_values,".$sA->prefix."_has_attributes,".$sA->prefix."_has_categories,".$sA->prefix."_has_combo_prods,".$sA->prefix."_has_currency,".$sA->prefix."_has_industries,".$sA->prefix."_has_layouts,".$sA->prefix."_has_options,".$sA->prefix."_has_products,".$sA->prefix."_has_related_prods,".$sA->prefix."_has_taxes,".$sA->prefix."_has_upsell_prods,".$sA->prefix."_has_vendors,".$sA->prefix."_kot,".$sA->prefix."_language,".$sA->prefix."_layout,".$sA->prefix."_loyalty,".$sA->prefix."_newsletter,".$sA->prefix."_notification,".$sA->prefix."_occupancy_status,".$sA->prefix."_offers,".$sA->prefix."_offers_categories,".$sA->prefix."_offers_products,".$sA->prefix."_offers_users,".$sA->prefix."_order_cancelled,".$sA->prefix."_order_flag_history,".$sA->prefix."_order_history,".$sA->prefix."_order_return_action,".$sA->prefix."_order_return_cashback_history,".$sA->prefix."_order_return_open_unopen,".$sA->prefix."_order_return_reason,".$sA->prefix."_order_return_status,".$sA->prefix."_order_status,".$sA->prefix."_order_status_history,".$sA->prefix."_orders,".$sA->prefix."_ordertypes,".$sA->prefix."_password_resets,".$sA->prefix."_payment_method,".$sA->prefix."_payment_status,".$sA->prefix."_permission_role,".$sA->prefix."_permissions,".$sA->prefix."_pincodes,".$sA->prefix."_prod_status,".$sA->prefix."_product_has_taxes,".$sA->prefix."_product_types,".$sA->prefix."_products,".$sA->prefix."_restaurant_tables,".$sA->prefix."_return_order,".$sA->prefix."_role_user,".$sA->prefix."_roles,".$sA->prefix."_saved_list,".$sA->prefix."_sections,".$sA->prefix."_settings,".$sA->prefix."_sizechart,".$sA->prefix."_slider,".$sA->prefix."_slider_master,".$sA->prefix."_sms_subscription,".$sA->prefix."_social_media_links,".$sA->prefix."_states,".$sA->prefix."_static_pages,".$sA->prefix."_stock_update_history,".$sA->prefix."_tagging_tagged,".$sA->prefix."_tagging_tags,".$sA->prefix."_tax,".$sA->prefix."_testimonials,".$sA->prefix."_translation,".$sA->prefix."_unit_measures,".$sA->prefix."_users,".$sA->prefix."_vendors,".$sA->prefix."_wishlist,".$sA->prefix."_zones");
//        }
//        
//        dd("----");
        
        // dd("kdjfskdf");
        $headers = $request->headers->all();

        $banks = Bank::get(['id']);
        $data = [];
//        dd(Auth::guard('merchant-users-web-guard')->check());
//          $withWhere = "";
//            $and = "";
        //dd(Auth::guard('vswipe-users-web-guard')->check());
        if (Auth::guard('vswipe-users-web-guard')->check() !== false) {
            $withWhere = "";
            $and = "";
        } else if (Auth::guard('bank-users-web-guard')->check() !== false) {
            $withWhere = "where b.id=" . $this->getbankid() . " ";
            $and = " and b.id=" . $this->getbankid() . " ";
        } else if (Auth::guard('merchant-users-web-guard')->check() !== false) {
            $withWhere = "where m.id=" . Session::get('authUserId') . " ";
            $and = " and m.id=" . Session::get('authUserId') . " ";
        }


        $merchants = DB::select("SELECT m.id FROM `merchants` m
            left join bank_has_merchants bm on m.id = bm.merchant_id
            left join banks b on bm.bank_id = b.id
            $withWhere
            group by m.id");

        $stores = DB::select("SELECT s.id,s.prefix FROM `stores` s 
            left join merchants m on  s.merchant_id = m.id
            left join bank_has_merchants bm on m.id = bm.merchant_id
            left join banks b on bm.bank_id = b.id
            where s.status=1
            $and
            group by s.id");
        //  dd($stores);
      
      
           
            $allStoreOperatores = DB::table("users")->where("user_type", 1)->count();
  
      
      
      
            $happyCustomers = DB::table("users")->where("user_type", 2)->count();
    

        $totalOrders = 0;
        foreach ($stores as $sA) {
            $totalOrders += DB::table("orders")->where("prefix",$sA->prefix)->count();
        }


        $totalSales = 0;
        foreach ($stores as $sA) {
            $totalSales += DB::table("orders")->where("prefix",$sA->prefix)->where('order_status', 3)->sum('pay_amt');
        }

        $topStoreSales = DB::select("select store_id,store_name,company_name,total_sales,group_concat(banknames) as banknames,logo,firstname FROM(SELECT vs.store_id,m.company_name,sum(sales)as total_sales,s.store_name,group_concat(DISTINCT(b.name)) as banknames,s.logo,m.firstname FROM `vswipe_sales` vs
left join stores s on vs.store_id = s.id
left join merchants m on s.merchant_id = m.id
left join bank_has_merchants bm on m.id = bm.merchant_id
left join banks b on bm.bank_id = b.id
where s.status=1
$and
group by vs.store_id,b.id,m.id
) vs1
group by store_id
order by total_sales desc
limit 10");

        $latestStores = DB::select("select *,group_concat(sbank) as banknames from (SELECT s.id,s.store_name,group_concat(DISTINCT(b.name)) as sbank,s.logo,group_concat(m.company_name) as company_name,s.created_at,m.firstname FROM  stores s
left join merchants m on s.merchant_id = m.id 
left join bank_has_merchants bm on m.id = bm.merchant_id 
left join banks b on bm.bank_id = b.id
where s.status = 1
$and
group by s.id,b.id,m.id
order by created_at desc 
limit 10) st1
group by id
order by created_at desc  
limit 10");

        $allStoreSales = DB::select("select DISTINCT(DATE_FORMAT(order_date,'%D-%b')) as y,total_sales as item1 from (SELECT vs.order_date,sum(vs.sales) as total_sales FROM `vswipe_sales` vs 
left join stores s on vs.store_id = s.id
left join merchants m on s.merchant_id = m.id
left join bank_has_merchants bm on m.id = bm.merchant_id
left join banks b on bm.bank_id = b.id
where  vs.order_date >= DATE_FORMAT(DATE_SUB(NOW(), INTERVAL 10 DAY),'%Y-%m-%d')
and s.status=1 
$and
group by vs.order_date,b.id,m.id) t1");

//dd($allStoreSales);

        $data["merchants"] = $merchants;
        $data["stores"] = $stores;
        $data["totalOrders"] = $totalOrders;
        $data["totalSales"] = $totalSales;
        $data["allStoreOperatores"] = $allStoreOperatores;
        $data["happyCustomers"] = $happyCustomers;
        $data["latestStores"] = $latestStores;
        $data["topStoreSales"] = $topStoreSales;
        $data["allStoreSales"] = $allStoreSales;
        $data['data'] = $data;
        $viewname = Config('constants.AdminPages') . ".dashboard";
        return Helper::returnView($viewname, $data);

        //return view(Config('constants.AdminPages') . ".dashboard", compact('data'));
    }

    public function login() {
        //dd(Hash::make('123456'));
        $getPref = Helper::getPrefix();

        if ($getPref === "admin") {
            $action = 'admin.login.checkVeeswipeLogin';
        } elseif ($getPref === "bank/admin") {
            $action = 'admin.login.checkBankLogin';
        } elseif ($getPref === "merchant/admin") {
            $action = 'admin.login.checkMerchantLogin';
        }

        return view(Config('constants.AdminPages') . ".login", compact('action'));
    }

    public function checkVeeswipeLogin() {
        $rules = array(
            'email' => 'required|email',
            'password' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->with('erMsg', 'Invalid Email Id or Password');
            //   return Redirect::back()
            //            ->withErrors($validator) // send back all errors to the login form
            //            ->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
        } else {
            Helper::makeLogout();
            $email = Input::get('email');
            $password = Input::get('password');
            $credentials = ['email' => $email, 'password' => $password];
            if (Auth::guard('vswipe-users-web-guard')->attempt($credentials)) {
                Helper::postLogin();
                $sSettings = Helper::getSettings();
                // Session::flash("loginErr","Invalid Email id or Password");
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->back()->with('erMsg', 'Invalid Email Id or Password');
            }
        }
    }

    public function checkBankLogin() {
        $rules = array(
            'email' => 'required|email',
            'password' => 'required'
        );
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->with('erMsg', 'Invalid Email Id or Password');
//return redirect()->back()->withErrors($validator->messages());
        } else {
            Helper::makeLogout();
            $email = Input::get('email');
            $password = Input::get('password');
            $credentials = ['email' => $email, 'password' => $password];
            if (Auth::guard('bank-users-web-guard')->attempt($credentials)) {
                Helper::postLogin();
                $sSettings = Helper::getSettings();
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->back()->with('erMsg', 'Invalid Email Id or Password');
            }
        }
    }

    public function vswipeLogout() {
        Helper::makeLogout();
        return redirect()->route('admin.login');
    }

    public function bankLogout() {
        Helper::makeLogout();
        return redirect()->route('admin.login');
    }

    public function checkMerchantLogin() {
        //  dd($getPref = Helper::getPrefix()); 
        $input = Input::get('email');
        $login_type = filter_var($input, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
        $validaten = filter_var($input, FILTER_VALIDATE_EMAIL) ? 'required|email' : 'required|regex:/(01)[0-9]{9}/';
//        $rules = array(
//            $login_type => $validaten,
//            'password' => 'required'
//        );
//     // dd($rules);
//        $validator = Validator::make(Input::all(), $rules);
//      //  dd($validator);
//        
//        if ($validator->fails()) {
//            return redirect()->back()->with('erMsg', 'Invalid Email Id or sddasd Password');
////
//        } else {
        Helper::makeLogout();
        $email = Input::get('email');
        $password = Input::get('password');
        $credentials = [$login_type => $input, 'password' => $password];
        if (Auth::guard('merchant-users-web-guard')->attempt($credentials)) {
            Helper::postLogin();
            $sSettings = Helper::getSettings();

            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->back()->with('erMsg', 'Invalid Email Id rtrtrtr or Password');
        }
        //  }
    }

    public function merchantLogout() {
        Helper::makeLogout();
        return redirect()->route('admin.login');
    }

    public function deviceRegister() {
        $id = Input::get("merchantId");
        $deviceId = Input::get("deviceId");

        $merchant = Merchant::find($id);
        $merchant->device_id = $deviceId;
        $prifix =$merchant->getstores()->first();


        $user = DB::table($prifix->prefix . '_users')->where("telephone",$merchant->phone )->first();
        DB::table($prifix->prefix . '_users')->where("id",$user->id)->update(['device_id'=>$deviceId]);
        if ($merchant->update())
            $data = ["status" => 1, "msg" => "Device register successfully!"];
        else
            $data = ["status" => 0, "msg" => "Opps some error occures!"];
        return $data;
    }

    public function logout() {
        $id = Input::get("merchantId");
        $user = Merchant::find($id);
        $user->device_id = '';
        if ($user->update())
            $data = ["status" => 1, "msg" => "Logout successfully!"];
        else
            $data = ["status" => 0, "msg" => "Opps some error occures!"];
        return $data;
    }

    public function forgotPassword() {
        return view(Config('constants.AdminPages') . '.forgot_password');
    }

    public function chkForgotPasswordEmail() {
        $useremail = Input::get('useremail');

        $login_type = filter_var($useremail, FILTER_VALIDATE_EMAIL) ? 'email' : 'telephone';

        $chkemail = DB::table("vswipe_users")->where($login_type, "=", $useremail)->first();
        //  return $chkemail;
        if (!empty($chkemail)) {
            $linktosend = route('adminResetPassword') . "/" . Crypt::encrypt($useremail);
            //$user = User::where("email", "=", $useremail)->first();
            if ($chkemail->email != '') {
                $name = ucfirst($chkemail->name);
                $data = ['name' => $name, 'newlink' => $linktosend];
                
                Helper::sendMyEmail(Config('constants.frontviewEmailTemplatesPath') . 'forgotPassEmail', $data, 'Forgot password', "support@infiniteit.biz", "Veestores", $chkemail->email, $chkemail->name . " " . $chkemail->name);
            }
            // if ($chkemail->telephone) {
            //     $msgOrderSucc = "Click on the link to reset your password. " . $linktosend . ". Contact 1800 3000 2020 for real time support. Happy Learning! Team Cartini";
            //     Helper::sendsms($chkemail->telephone, $msgOrderSucc);
            // }
            return $data = ['status' => 'success', 'msg' => 'A Link to reset your password has been sent. Please check your Email.'];
        } else {
            return $data = ['status' => 'error', 'msg' => 'Sorry, your email is not registered with us!'];
        }
    }

    public function adminResetNewPassword($link) {
        $data = ['link' => $link];
        $viewname = Config('constants.AdminPages') . '.reset_forgot_pwd';
        return Helper::returnView($viewname, $data);
    }

    public function adminSaveResetPwd() {
        $useremail = Crypt::decrypt(Input::get('link'));
        $user = DB::table("vswipe_users")->where("email", "=", $useremail)->update(['password'=>Hash::make(Input::get('confirmpwd'))]);

        $upPassword = DB::table("vswipe_users")->where("email", "=", $useremail)->first();
       
        $data = ['name' => $upPassword->name , 'email' => $useremail];
        $filepath = Config('constants.frontviewEmailTemplatesPath') . '.resetForgotPwdEmail';
        Helper::sendMyEmail($filepath, $data, 'Your password changed!', "support@infiniteit.biz", "Veestores", $useremail, $upPassword->name);
        session()->flash('pwdResetMsg', 'Password reset successfully!');
        
        return redirect()->route('admin.login');
    }

}
