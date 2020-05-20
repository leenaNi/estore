<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bank;
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
use Tymon\JWTAuth\Exceptions\JWTException;

class ApiCouponController extends Controller {

    public function index() {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $search = !empty(Input::get("couponSearch")) ? Input::get("couponSearch") : '';
        $search_fields = ['coupon_name', 'coupon_code', 'min_order_amt', 'coupon_value', 'coupon_desc'];
        $coupons = DB::table('coupons')->whereIn('status', [0, 1])->orderBy("id", "desc");
        if (!empty(Input::get('couponSearch'))) {
            $coupons = $coupons->where(function($query) use($search_fields, $search) {
                foreach ($search_fields as $field) {
                    $query->orWhere($field, "like", "%$search%");
                }
            });
        }
        $coupons = $coupons->get();
        $couponCount = $coupons->count();
        $data = ['coupons' => $coupons, 'couponCount' => $couponCount];
        $viewname = '';
        return Helper::returnView($viewname, $data);
    }

    public function editCoupon() {
        $marchantId = Input::get("merchantId");
        $id = Input::get("id");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $coupons = DB::table('coupons')->where("id", $id)->first();
        $data = ['coupon' => $coupons];
        $viewname = '';
        return Helper::returnView($viewname, $data);
    }

    public function saveCoupon() {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $coupons = DB::table('coupons')->get();
        $coupon['coupon_name'] = Input::get('coupon_name');
        $coupon['coupon_code'] = Input::get('coupon_code');
        $coupon['discount_type'] = Input::get('discount_type');
        $coupon['coupon_value'] = Input::get('coupon_value');
        $coupon['min_order_amt'] = Input::get('min_order_amt');
        $coupon['no_times_allowed'] = Input::get('no_times_allowed');
        $coupon['allowed_per_user'] = Input::get('allowed_per_user');

        $coupon['start_date'] = Input::get('start_date');
        $coupon['end_date'] = Input::get('end_date').' 23:59:59';
        $coupon['user_specific'] = Input::get('user_specific');
        $coupon['coupon_type'] = Input::get('coupon_type');
        if (Input::get("id")) {
            $coupons = DB::table($prifix . '_coupons')->where("id", Input::get("id"))->update($coupon);
            $data = ["status" => "1", "msg" => "coupon updated successfully"];
        } else {
            $couponcheck = DB::table($prifix . '_coupons')->where('coupon_code', Input::get('coupon_code'))->first();
            if (count($couponcheck) > 0) {
                $data = ["status" => "0", "msg" => "coupon code Already Exits"];
            } else {
                $coupons = DB::table($prifix . '_coupons')->insert($coupon);
                $data = ["status" => "1", "msg" => "coupon added successfully"];
            }
        }
        return $data;
    }

    public function getLoyalty() {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $search = !empty(Input::get("search")) ? Input::get("search") : '';
        $search_fields = ['group'];
        $loyalty = DB::table('loyalty')->orderBy("id", "asc");
        $loyalty = $loyalty->where(function($query) use($search_fields, $search) {
            foreach ($search_fields as $field) {
                $query->orWhere($field, "like", "%$search%");
            }
        });
        $loyalty = $loyalty->get();
        $data = ['loyalty' => $loyalty];
        $viewname = '';
        return Helper::returnView($viewname, $data);
    }

    public function saveLoyalty() {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;

        $loyalty['group'] = Input::get('group');
        $loyalty['min_order_amt'] = Input::get('min_order_amt');
        $loyalty['max_order_amt'] = Input::get('max_order_amt');
        $loyalty['percent'] = Input::get('percent');
        if (Input::get("id")) {
            $coupons = DB::table('loyalty')->where("id", Input::get("id"))->update($loyalty);
            $data = ["status" => "1", "msg" => "Loyalty updated successfully"];
        } else {
            $loyalttRange = DB::table($prifix . '_loyalty')->where('min_order_amt', '>=', Input::get('min_order_amt'))->Orwhere('max_order_amt', '>=', Input::get('max_order_amt'))->get();
            if (count($loyalttRange) > 0) {
                $data = ["status" => "0", "msg" => "Loyalty Range already Exits."];
            } else {
                $coupons = DB::table($prifix . '_loyalty')->insert($loyalty);
                $data = ["status" => "1", "msg" => "Loyalty added successfully"];
            }
        }
        return $data;
    }

    public function editLoyalty() {
        $marchantId = Input::get("merchantId");
        $id = Input::get("id");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $loyalty = DB::table('loyalty')->where("id", $id)->first();
        $data = ['loyalty' => $loyalty];
        $viewname = '';
        return Helper::returnView($viewname, $data);
    }

    public function check_coupon() {
        //Get User
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        if (!empty(Input::get('mobile'))) {
            $user = DB::table('users')->where('telephone', Input::get('mobile'))->first();
            if ($user)
                $userId = $user->id;
            else
                $userId = '';
        }
        $data = [];
        $couponCode = Input::get('coupon_code');
        $orderAmount = Input::get('order_amount'); // After every discount applied on current cart
        $currencyVal = 1; //Input::get('currency_val');
        $cartContent = json_decode(Input::get('cart_content'), true);
        //Cart::instance('shopping')->content()->toArray();
        //$orderAmount = Helper::getAmt("coupon") * Session::get('currency_val');
        $couponID = DB::table($prifix . '_coupons')->where("coupon_code", "=", $couponCode)->where("status",1)->first();
        @$usedCouponCountOrders = DB::table('orders')->where('coupon_used', '=', $couponID->id)->where("order_status", "=", 1)->count();
        if (isset($couponID)) {
            if ($couponID->user_specific == 1) {
                if ($userId != '') {
                    $chkUserSp = DB::table($prifix . '_coupons_users')->where($couponID->id)->where("user_id", $userId)->get(['user_id']);
                    $cuserids = [];
                    foreach ($chkUserSp as $chkuserid) {
                        array_push($cuserids, $chkuserid->user_id);
                    }
                    $validuser = in_array($userId, $cuserids);
                    if ($validuser) {
                        $validCoupon = DB::select(DB::raw("Select * from " . $prifix . "_coupons where status=1 and coupon_code = '$couponCode'  and no_times_allowed > $usedCouponCountOrders and min_order_amt <= " . $orderAmount . " and (now() between start_date and end_date)"));
                    }
                }
            } else {
                $validCoupon = DB::select(DB::raw("Select * from " . $prifix . "_coupons where  status=1 and coupon_code = '$couponCode'  and no_times_allowed > $usedCouponCountOrders and min_order_amt <= " . $orderAmount . " and (now() between start_date and end_date)"));
            }
        }
        //dd($validCoupon);
        if (isset($validCoupon) && !empty($validCoupon)) {
            $disc = 0;
            if ($validCoupon[0]->coupon_type == 1) {

                $orderAmt = 0;
                $discountCartProds = [];
                $individualSubtotal = [];
//                echo "<pre>";
//                print_r($cartContent);
//                echo "</pre>";
                foreach ($cartContent as $prdAllC) {
                    $validCoupon[0]->discount_type;
//                    echo $prdAllC['subtotal'];
//                     echo "<pre>";
//                    print_r($prdAllC);
//                    echo "</pre>";
//                    die;
                    $indvDisc = 0;
                    if ($validCoupon[0]->discount_type == 1) {
                        // echo "sgfhgs"; 
                        $indvDisc = (($validCoupon[0]->coupon_value * $prdAllC['subtotal']) / 100);
                        $disc += $indvDisc;
                        $individualSubtotal[$prdAllC['rowid']] = $indvDisc; //die;
                    } else {

                        if ($validCoupon[0]->discount_type == 2) {
                            $orderAmt += $prdAllC['subtotal'];
                            if ($validCoupon[0]->min_order_amt <= $orderAmt) {
                                $disc = $validCoupon[0]->coupon_value;
                                $individualSubtotal[$prdAllC['rowid']] = ($prdAllC['qty'] * $prdAllC['price']);
                            }
                        }
                    }
                }
                $discountCartProds = $this->calculateFixedDiscount($individualSubtotal, $disc);
            }
        } else {
            $data['coupon_is_valid'] = '0';
        }
        //dd($disc);
        //@$disc = number_format(@$disc, 2);
        if (!empty($validCoupon) && $disc > 0) {
            $newAmnt = ($orderAmount - $disc);
            $data['new_amt'] = $newAmnt;
            $data['coupon_type'] = $validCoupon[0]->coupon_type;
            $data['disc'] = $disc;
            $data['individual_disc_amt'] = $discountCartProds;
            $data['subtotal'] = $orderAmount;
            $data['orderAmount'] = $orderAmount;
            $data['coupon_is_valid'] = '1';
            //  echo "Coupon Applied :-" . $newAmnt . ":-" . $validCoupon[0]->coupon_type . ":-" . $disc;

            return $data;
        } else {
            foreach ($cartContent as $prdcoup) {
                $subtotal = 0;
                $subtotal += $prdcoup['subtotal'];
            }
            $data['remove'] = 1;
            //$data['orderFinalAmount']= $orderAmount;
            $data['orderAmount'] = $orderAmount;
            $data['subtotal'] = $subtotal;
            $data['cartCnt'] = $orderAmount;
            $data['coupon_is_valid'] = '0';
            return $data;
        }
    }

    public function calculateFixedDiscount($individualSubtotal, $disc) {
        $arraySumPercent = array_sum($individualSubtotal) / 100;
        $individualDiscountPercent = [];
        foreach ($individualSubtotal as $key => $subtotal) {
            $calPerdiscount = $subtotal / 100;
            $individualDiscountPercent[$key] = round(($disc * $calPerdiscount / $arraySumPercent),2);
        }
        Session::put('individualDiscountPercent', json_encode($individualDiscountPercent));
        return $individualDiscountPercent;
    }

    public function delete() {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $id = Input::get("id");
        $coupon = DB::table('coupons')->find($id);

        $getcount = DB::table('orders')->where("coupon_used", "=", $id)->count();
        //dd($getcount);
        if ($getcount == 0) {
            DB::table($prifix . '_coupons_categories')->where("c_id", "=", $id)->delete();
            DB::table($prifix . '_coupons_products')->where("c_id", "=", $id)->delete();
            DB::table($prifix . '_coupons_users')->where("c_id", "=", $id)->delete();
            $coup = DB::table($prifix . '_coupons')->where("id", "=", $id)->delete();


            $data = ['status' => '1', "message" => "Coupon deleted successfully."];
        } else {

            $data = ['status' => '0', "msg" => "Sorry, This coupon is part of a order. Delete the order first."];
        }

        return $data;
    }

    public function LoyaltyCashback() {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $userId = Input::get("userId");
        $cart = json_decode(Input::get("cart_content"));
        if (isset($userId)) {
            $cashback = DB::table('users')->find($userId)->cashback;
        }
        $cartAmount = Helper::getMrpTotal($cart);
        if ($cartAmount < $cashback) {
            $checkbackUsedAmt = $cartAmount;
            //Session::put('checkbackUsedAmt', $cartAmount);
            $remainingCashback = $cashback - $cartAmount;
            // Session::put('remainingCashback', $cashback - $cartAmount);
        } else {
            $remainingCashback = 0;
            $checkbackUsedAmt = $cashback;
        }

        $orderAmt = Helper::getOrderTotal($cart);
        foreach ($cart as $k => $c) {
            $productP = (($c->subtotal - ($c->options->disc +$c->options->user_disc)) / 100);
            $orderAmtP = ($orderAmt / 100);
            $amt = Helper::discForProduct($productP, $orderAmtP, $checkbackUsedAmt);
            $c->options->wallet_disc = $amt;
        }
        $taxStatus = DB::table('general_setting')->where("url_key", 'tax')->first()->status;
        $cartdata = Helper::calAmtWithTax($cart, $taxStatus);
        return $cartdata;
    }

    public function revertLoyalty() {

        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $userId = Input::get("userId");
        $cart = json_decode(Input::get("cart_content"));
       // $finalamt = Session::get('pay_amt') + Session::get('checkbackUsedAmt');
        foreach ($cart as $k => $c) {
            $c->options->wallet_disc = 0;
        }
        $option='wallet_disc';
        $taxStatus = DB::table('general_setting')->where("url_key", 'tax')->first()->status;
       // $cart1= Helper::revertTax($cart,$taxStatus);
        $cartData = Helper::calAmtWithTax($cart, $taxStatus);
        return $cartData;
    }

    public function checkUserdiscount() {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $cart = json_decode(Input::get("cart_content"));
        $taxStatus = DB::table('general_setting')->where("url_key", 'tax')->first()->status;
        $discType = Input::get('discType');
        $discVal = Input::get('discValue');
        //  $cartAmount = Helper::getAmt();
        $cartAmount = Helper::getMrpTotal($cart);
        if ($discType == 1) {

            $discountAmt = (($cartAmount * $discVal)/ 100);
            $discAmt = $discountAmt;
            $discType = $discType;
            // $cartAmount = Helper::getAmt('discAmt');
            $orderAmt = Helper::getMrpTotal($cart);

            foreach ($cart as $k => $c) {
                $productP = (($c->subtotal - $c->options->disc - $c->options->wallet_disc - $c->options->referral_disc) / 100);
                $orderAmtP = ($orderAmt / 100);
                $amt = Helper::discForProduct($productP, $orderAmtP, $discountAmt);
                $c->options->user_disc = $amt;
            }

            $cartdata = Helper::calAmtWithTax($cart, $taxStatus);
            return $cartdata;
        } else if ($discType == 2) {
            // $amountAfrDisc = $cartAmount - $discVal;
            $discountAmt = $discVal;
            $orderAmt = Helper::getMrpTotal($cart);

            foreach ($cart as $k => $c) {
                $productP = (($c->subtotal - $c->options->disc - $c->options->wallet_disc - $c->options->referral_disc) / 100);
                $orderAmtP = ($orderAmt / 100);
                $amt = Helper::discForProduct($productP, $orderAmtP, $discountAmt);
                $c->options->user_disc = $amt;
            }

            $cartdata = Helper::calAmtWithTax($cart, $taxStatus);
            return $cartdata;

            //  return $data = ['status' => 'success', 'msg' => "<span style='color:green;'>Discount Code Applied!</span> <a href='javascript:void(0);' style='border-bottom: 1px dashed;' class='clearDiscount' id='discAmt'>Remove!</a>", 'discountedAmt' => $amountAfrDisc, 'discVal' => $discountAmt];
        } else {
            foreach ($cart as $k => $c) {
                $c->options->user_disc = 0;
            }
            $cartdata = Helper::calAmtWithTax($cart, $taxStatus);
            return $cartdata;
        }
    }

    public function revertUserdiscount() {

        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $cart = json_decode(Input::get("cart_content"));
        //  $cart = Cart::instance('shopping')->content();
        foreach ($cart as $k => $c) {
            $c->options->user_disc = 0;
        }
        $taxStatus = DB::table('general_setting')->where("url_key", 'tax')->first()->status;    
        $cartdata = Helper::calAmtWithTax($cart, $taxStatus);
        return $cartdata;
    }

   public function taxReCalculate(){
        $newPrice = Input::get("newPrice");
        $taxRate = Input::get("taxRate");
        $taxType = Input::get("taxType");
        $rate=$taxRate*0.01;
        if($taxType==1){
           $taxAmt=($newPrice/($rate+1))*$rate;
        }else{
            $taxAmt=$newPrice*$rate;
        }
        return $data=["taxAmt"=>$taxAmt];
   }
}

?>