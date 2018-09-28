<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Socialite;
use Route;
use Input;
use App\Models\User;
use App\Models\Merchant;
use App\Models\HasCashbackLoyalty;
use Auth;
use App\Http\Controllers\Controller;
use Session;
use App\Library\Helper;
use Cart;
use Hash;
use Mail;
use Config;
use Crypt;
use JWTAuth;
use DB;
use Illuminate\Http\Response;

class ApiUserController extends Controller {

    public function index() {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $search = !empty(Input::get("empSearch")) ? Input::get("empSearch") : '';
        $search_fields = ['firstname', 'lastname', 'email', 'telephone'];
        $users = User::where("user_type", 1)->orderBy("id", "desc");
        $roles = DB::table($prifix . '_roles')->get();
        if (!empty(Input::get('empSearch'))) {
            $users = $users->where(function($query) use($search_fields, $search) {
                foreach ($search_fields as $field) {
                    $query->orWhere($field, "like", "%$search%");
                }
            });
        }
        if (!empty(Input::get("empSearch"))) {
            $users = $users->get();
            $userCount = $users->count();
        } else {
            $users = $users->paginate(10);
            $userCount = $users->total();
        }

        foreach ($users as $user) {
            $userrole = DB::table($prifix . '_role_user')->where("user_id", $user->id)->pluck("role_id");
            $user->roles = $userrole;
        }

        $data = ['systemUsers' => $users, 'usesRoles' => $roles, 'userCount' => $userCount];
        $viewname = '';

        return Helper::returnView($viewname, $data);
    }

    public function addEdit() {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $roles = DB::table($prifix . '_roles')->get();

        $data = ['roles' => $roles];
        $viewname = '';

        return Helper::returnView($viewname, $data);
    }

    public function saveAddEdit() {
        $marchantId = Input::get("merchantId");

        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $user = User::findOrNew(Input::get("id"));
        $prifix = $merchant->prefix;
        $user->firstname = Input::get("firstName");
        $user->lastname = Input::get("lastName");
        $user->email = Input::get("email");
        $user->country_code = Input::get("country_code");
        $user->telephone = Input::get("mobile");
        $user->status = Input::get("status");
        if (Input::get("password")) {
            $user->password = Hash::make(Input::get("password"));
        }

        if (Input::get("id")) {
            $user->save();
            $role["role_id"] = Input::get("roleId");
            DB::table($prifix . '_role_user')->where("user_id", Input::get("id"))->update($role);
            $data = ['status' => "1", 'msg' => 'user Updated Successfully', 'systemUser' => $user];
        } else {
            $checkUser = User::where("telephone", Input::get("mobile"))->orderBy("id", "desc")->first();
            $checkUser1 = User::where("email", Input::get("email"))->orderBy("id", "desc")->first();
            if (count($checkUser) > 0 || count($checkUser1) > 0) {
                $data = ['status' => "0", 'msg' => "User already Exist"];
            } else {
                $user->status = 1;
                $user->save();
                $role["user_id"] = $user->id;
                $role["role_id"] = Input::get("roleId");
                DB::table($prifix . '_role_user')->insert($role);
                $data = ['status' => "1", 'msg' => "User added successfully", 'systemUser' => $user];
            }
        }

        $viewname = '';

        return Helper::returnView($viewname, $data);
    }

    public function deleteSystemUser() {
        $marchantId = Input::get("merchantId");
        $userId = Input::get("userId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $user = User::where("id", $userId)->first();

        $systemUsers = Merchant::where("email", $user->email)->first();

        if (count($systemUsers) > 0) {
            $data = ['status' => '0', 'msg' => 'Sorry, You can not deleted this user.'];
        } else {
            $role = DB::table($prifix . '_role_user')->where("user_id", $userId)->count();
            if ($role) {
                DB::table($prifix . '_role_user')->where("user_id", $userId)->delete();
            }
            $user->delete();
            $data = ['status' => '1', 'msg' => 'System user delated successfull!'];
        }
        return $data;
    }

    public function getCustomer() {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $storeId = $merchant->id;
        $search = !empty(Input::get("custSearch")) ? Input::get("custSearch") : '';
        $search_fields = ['firstname', 'lastname', 'email', 'telephone'];
        $users = User::with("addresses")->where("user_type", 2)->orderBy("id", "desc");
        if (!empty(Input::get('custSearch'))) {
            $users = $users->where(function($query) use($search_fields, $search) {
                foreach ($search_fields as $field) {
                    $query->orWhere($field, "like", "%$search%");
                }
            });
        }
           $users = $users->with(['userCashback'=>function($q) use($storeId) {
                    $q->where('store_id', '=', $storeId);
                }]);
        $users = $users->get();
        $userCount = $users->count();
//        foreach ($users as $user) {
//            $user->address = DB::table('has_addresses')->where("user_id", $user->id)->first();
//        }
//      
        $loyalty = DB::table($prifix . '_loyalty')->where("status", 1)->get();

        $data = ['customer' => $users, 'loyalty' => $loyalty, 'userCount' => $userCount];
        $viewname = '';

        return Helper::returnView($viewname, $data);
    }

    public function getLoyalty() {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $loyalty = DB::table($prifix . '_loyalty')->where("status", 1)->get();

        $data = ['loyalty' => $loyalty];
        $viewname = '';

        return Helper::returnView($viewname, $data);
    }

    public function customerAddEdit() {
        $marchantId = Input::get("merchantId");

        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $user=User::findOrNew(Input::get("id"));
        $prifix = $merchant->prefix;
        $storeId = $merchant->id;
        $user->firstname= Input::get("firstName");
        $user->lastname = Input::get("lastName");
        $user->email = Input::get("email");
        $user->country_code= Input::get("country_code");
        $user->telephone = Input::get("mobile");
        $loyalty= Input::get("loyalty_group");
        $cashback = Input::get("cashback");
          $usercashback = new HasCashbackLoyalty;
                $usercashback->user_id = 10;
                $usercashback->store_id =$storeId;
                $usercashback->cashback =10;
                $usercashback->loyalty_group = 1;
                $usercashback->timestamps = false;
                $usercashback->save();
                dd($usercashback);
        if (Input::get("id")) {
            $user->save();
            $this->updateReferalLoyalty($storeId,$user->id,$loyalty,$cashback);
            $data = ['status' => "1", 'msg' => 'user Updated Successfully', 'customer' => $user];
        } else {
            $checkUser =User::where("telephone", Input::get("mobile"))->orderBy("id", "desc")->first();
            $checkUser1 = User::where("email", Input::get("email"))->orderBy("id", "desc")->first();
            if (count($checkUser) > 0 || count($checkUser1) > 0) {
                $data = ['status' => "0", 'error' => "User already Exist"];
            } else {
                $refCode = rand(11111, 99999);
                $user->referal_code = substr(strtoupper(Input::get("firstName")), 0, 3) . $refCode;
                $user->user_type= 2;
                $user->prefix= $prifix;
                $user->store_id= $storeId;
                $user->save();
                $this->updateReferalLoyalty($storeId,$user->id,$loyalty,$cashback);
                $data = ['status' => "1", 'msg' => "User added successfully", 'systemUser' => $users];
            }
        }

        $viewname = '';

        return Helper::returnView($viewname, $data);
    }
  public function updateReferalLoyalty($storeId,$userId,$loyalty,$cashback){
      $cashbackCount=HasCashbackLoyalty::where("store_id",$storeId)->where("user_id",$userId)->count();
      if($cashbackCount > 0){
           $cashback=HasCashbackLoyalty::where("store_id",$storeId)->where("user_id",$userId)->first();
           $cashback->cashback=$cashback?$cashback:'0';
           $cashback->loyalty_group=$loyalty;
           $cashback->save();
      }else{
           $cashback= new HasCashbackLoyalty;
           $cashback->cashback=$cashback?$cashback:'0';
           $cashback->loyalty_group=$loyalty;
           $cashback->store_id=$storeId;
           $cashback->user_id=$userId;
           $cashback->save();
      }
      
  }
    public function deleteCustomer() {
        $marchantId = Input::get("merchantId");

        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $user = User::find(Input::get("id"));
        $getcount = DB::table('orders')->where("user_id", "=", Input::get('id'))->count();
        // dd($getcount);
        if ($getcount == 0) {
            $user = User::where("id", Input::get("id"))->delete();
            Session::flash('message', 'Customer deleted successfully.');
            $data = ['status' => '1', "msg" => "Customer deleted successfully."];
        } else {
            Session::flash('message', 'Sorry, This customer is part of a order. Delete the order first.');
            $data = ['status' => '0', "msg" => "Sorry, This customer is the part of a order. Delete the order first."];
        }
//        
//        $url = 'admin.customers.view';
        $viewname = '';
        return Helper::returnView($viewname, $data);
    }

    public function getReferral() {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $getcount = DB::table($prifix . '_general_setting')->where("url_key", "=", 'referral')->first();
        $data = ['referal' => $getcount];
        return $data;
    }

    public function updateReferral() {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $referral = [];
        $referral['details'] = Input::get("details");
        $referral['status'] = Input::get("status");
        DB::table($prifix . '_general_setting')->where("url_key", "=", 'referral')->update($referral);
        $getcount = DB::table($prifix . '_general_setting')->where("url_key", "=", 'referral')->first();

        $data = ['status' => "1", 'msg' => "Referral updated successfully", 'referal' => $getcount];
        return $data;
    }

    public function getTax() {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $taxInfo = DB::table($prifix . '_tax')->whereIn('status', [1, 0])->orderBy("id", "asc");
        $taxInfo = $taxInfo->paginate(10);
        $taxCount = $taxInfo->total();

        $data = ['taxInfo' => $taxInfo, 'taxCount' => $taxCount];
        return $data;
    }

    public function saveTax() {
        // $categoryIds = explode(",", Input::get('CategoryIds'));
        //  $productIds = explode(",", Input::get('ProductIds'));
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $taxNew = [];
        $taxNew['label'] = Input::get('label');
        $taxNew['name'] = Input::get('label');
        $taxNew['rate'] = Input::get('rate');
        $taxNew['tax_number'] = Input::get('tax_number');
        $taxNew['status'] = Input::get('status');

        if (Input::get('id')) {
            DB::table($prifix . '_tax')->where("id", Input::get("id"))->update($taxNew);
        } else {
            DB::table($prifix . '_tax')->insert($taxNew);
        }

        $viewname = "";
        $data = ['status' => '1', 'msg' => (Input::get('id')) ? 'Tax updated successfully.' : 'Tax added successfully.', 'taxinfo' => $taxNew];
        return Helper::returnView($viewname, $data, $url = 'admin.tax.view');
    }

    public function deleteTax() {
        //  $tax = Tax::find(Input::get('id'));
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $id = Input::get('id');
        $getCount = DB::table($prifix . '_product_has_taxes')->where('tax_id', $id)->count();
        if ($getCount <= 0) {
            $tax = DB::table($prifix . '_tax')->where('id', $id)->delete();
            $data = ['status' => '1', 'msg' => 'Tax deleted successfully.'];
            // return Helper::returnView($viewname, $data, $url = 'admin.tax.view');
        } else {

            $data = ['status' => '0', 'msg' => 'Sorry this Tax is part of a product . Delete the product first.'];
        }
        $viewname = '';
        return Helper::returnView($viewname, $data);
    }

}

?>