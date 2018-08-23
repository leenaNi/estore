<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Socialite;
use Route;
use Input;
use App\Models\User;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\Loyalty;
use App\Models\Product;
use App\Models\Tax;
use App\Models\EmailTemplate;
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

class ApiController extends Controller {

    public function savelogin() {
        $userDetails = User::where("email", "=", Input::get("email"))->where('user_type', '1')->first();
        if ($userDetails) {
            $credentials = Input::only('email', 'password');
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(false, Response::HTTP_UNAUTHORIZED);
            }
            $result = response()->json(compact('token'));
            $getData = $result->getdata();
            // dd($getData->token);
            $user = JWTAuth::toUser($getData->token);
            return response()->json(['result' => $user])->header('token', $getData->token);
        } else {
            return $result = ['status' => 'nomatch', 'msg' => 'Sorry, no match found'];
        }
    }


    
    public function unauthorized(){
        return $result= ['status'=>'0','msg'=>'unauthorized'];
    }

    public function checkout() {
        $phone_no = Input::get('mobile');
        $user = Helper::getUserCashBack($phone_no);
        $tax = Tax::where('type', 1)->get();
        $data = ['status' => '1', 'user' => $user, 'tax' => $tax];
        $viewname = '';
        return Helper::returnView($viewname, $data);
    }

    public function createNormalOrder() {
//        echo Input::get("firstname");
//        echo "<pre>";
//        print_r(Input::all());
//         echo "</pre>";
        $orderAmt = Input::get("order_amount");
        $payAmt = Input::get("pay_amt");
        $couponCode = Input::get('coupon_code');
        $order = new Order();
        $order->phone_no = Input::get("mobile");
        $order->user_id = Input::get("user_id");
        $order->created_by = Input::get("added_by");
        //$order->order_comment = Input::get("note");
        $order->order_amt = Input::get("order_amount");
        $order->first_name = Input::get("fname");
        $order->last_name = Input::get("lname");
        $order->email = Input::get("email");
        $order->cart = (Input::get("cart_content")) ? Input::get("cart_content") : '';
        $order->address1 = Input::get("address");
        $order->shipping_amt = Input::get("delivery_charges");
        $order->discount_type = (Input::get('disc_type')) ? 0 : Input::get('disc_type');
        $order->discount_amt = (Input::get('disc_amt')) ? 0 : Input::get('disc_amt');
        $order->cashback_used = (Input::get('cashback_used')) ? 0 : Input::get('cashback_used');
        if (Input::get('coupon_code') != '') {
            $coupon = Coupon::where("coupon_code", "=", $couponCode)->first();
            $order->coupon_used = $coupon->id;
            $order->coupon_amt_used = Input::get('coupon_amt');
//            $couponadd = new Coupon();
//            $couponadd->no_times_used = $couponadd->no_times_used + 1;
//            $couponadd->save();
        }
        if (Input::get('apply-loyalty') == '1') {
            $userCashback = Helper::getUserCashBack(Input::get('mobile'));
            //echo $userCashback['cashback'];
            if ($userCashback['status'] == 1 && $userCashback['cashback'] > 0) {
                $user = User::where('telephone', Input::get('mobile'))->first(); //GET USER
                if ($userCashback['cashback'] >= $payAmt) {
                    $order->pay_amt = 0;
                    $order->cashback_used = $payAmt;
                    $cashbackRemained = $userCashback['cashback'] - $payAmt;
                } else if ($userCashback['cashback'] < $payAmt) {
                    $order->pay_amt = $payAmt - $userCashback['cashback'];
                    $order->cashback_used = $userCashback['cashback'];
                    $cashbackRemained = 0;
                }
                $user->cashback = $cashbackRemained;
                $user->update();
            } else {
                $order->cashback_used = 0;
            }
            //echo "Applied";
        } else {
            $order->pay_amt = $payAmt;
            //echo "Not Applied";
        }
        if (Input::get('payment_method')) {
            $order->payment_method = 1;
            $order->payment_status = 1;
            $order->transaction_id = "";
            $order->transaction_status = "";
        }

        //dd(Input::all());
        $date = date("Y-m-d H:i:s");
        $order->created_at = $date;
         $order->order_status = 1;
//        $date = date("Y-m-d H:i:s");
//        $order->created_at = $date;
        // dd($order);
        if ($order->save()) {
            if (Input::get('coupon_code') != '') {
                $this->coupon_count($coupon->id);
            }
            $this->updateStock($order->id);
            return $data_email = ['status' => '1', 'msg' => "Order placed successfully!", 'first_name' => Input::get("fname"), 'orderId' => $order->id, 'emial' => Input::get("email")];
        } else {
            return $data = ['status' => '0', 'msg' => "Oops, something went wrong. Please try again later!"];
        }
    }

    function coupon_count($couponId) {
        /* by tej -> Code add for coupon counter -> start */
        // $addCoupon = Coupon::where("id", "=", session::get('usedCouponId'))->select("no_times_used")->get()->toArray();
        $couponadd = Coupon::find($couponId);
        if (isset($couponadd->no_times_used)) {
            $couponadd->no_times_used = $couponadd->no_times_used + 1;
            $couponadd->save();
        }
        /* by tej -> Code add for coupon counter -> end */
    }

    // For order Update stock
    public function updateStock($orderId) {
        $order = Order::find($orderId);
        $cartContent = json_decode($order->cart, true);
        $cart_ids = [];
        $order->products()->detach();
//        echo "<pre>";
//        print_r($cartContent);
//        echo "</pre>";
        foreach ($cartContent as $cKey => $cart) {
           // dd($cart);
            
            $cart_ids[$cart['id']] = ["qty" => $cart['qty'], "price" => $cart['subtotal'] * 1, "created_at" => date('Y-m-d H:i:s'), "amt_after_discount" => ($cart['options']['discountedAmount'])?$cart['subtotal']:'0.00', "disc" => ($cart['options']['disc']) ? $cart['options']['disc'] :'0.00'];
            
                
                $proddetailsp = [];
                $prddataSp = Product::find($cart['id']);
                $proddetailsp['id'] = $prddataSp->id;
                $proddetailsp['name'] = $prddataSp->product;
                $proddetailsp['image'] = $cart['options']['image'];
                $proddetailsp['sub_prod_id'] = $cart['options']['sub_prod'];
                $proddetailsp['price'] = $cart['price'] * Session::get("currency_val");
                $proddetailsp['qty'] = $cart['qty'];
                $proddetailsp['subtotal'] = $cart['subtotal'] * Session::get("currency_val");
                $proddetailsp['is_cod'] = $prddataSp->is_cod;
                $cart_ids[$cart['id']]["product_details"] = json_encode($proddetailsp);
                $prd = Product::find($cart['id']);
                $prd->stock = $prd->stock - $cart['qty'];
                $prd->update();
          
            $order->products()->attach($cart['id'], $cart_ids[$cart['id']]);
        }
    }

    public function createExpressOrder() {
        $order = new Order();
        $order->created_by = Input::get("added_by");
        $order->phone_no = Input::get("mobile");
        $order->description = Input::get("description");
        $order->cart = (Input::get("cart_content")) ? Input::get("cart_content") : '';
        $order->order_amt = is_null(Input::get("order_amount")) ? '' : Input::get("order_amount");
        $order->pay_amt = is_null(Input::get("order_amount")) ? '' : Input::get("order_amount");
        if (Input::get('payment_method')) {
            $order->payment_method = 1;
            $order->payment_status = 1;
            $order->transaction_id = "";
            $order->transaction_status = "";
        }
        //dd(Input::all());
        $date = date("Y-m-d H:i:s");
        $order->created_at = $date;
         $order->order_status = 1;
        if ($order->save()) {
            if (Input::get('coupon_code') != '') {
                $this->coupon_count($coupon->id);
            }
           // $this->updateStock($order->id);
            return $data_email = ['status' => '1', 'msg' => "Order placed successfully!", 'first_name' => Input::get("fname"), 'orderId' => $order->id, 'emial' => Input::get("email")];
        } else {
            return $data = ['status' => '0', 'msg' => "Oops, something went wrong. Please try again later!"];
        }
    }

    public function createGuestOrder() {
        $couponCode = Input::get('coupon_code');
        $payAmt = Input::get("pay_amt");
        $order = new Order();
        $order->created_by = Input::get("added_by");
        $order->cart = (Input::get("cart_content")) ? Input::get("cart_content") : '';
        $order->phone_no = is_null(Input::get("mobile")) ? '' : Input::get("mobile");
        $order->order_comment = is_null(Input::get("note")) ? '' : Input::get("note");
        $order->order_amt = is_null(Input::get("order_amount")) ? '' : Input::get("order_amount");
        $order->pay_amt = $payAmt;
        $order->shipping_amt = Input::get("delivery_charges");
        $order->discount_type = (Input::get('disc_type')) ? 0 : Input::get('disc_type');
        $order->discount_amt = (Input::get('disc_amt')) ? 0 : Input::get('disc_amt');
        if (Input::get('coupon_code') != '') {
            $coupon = Coupon::where("coupon_code", "=", $couponCode)->first();
            $order->coupon_used = $coupon->id;
            $order->coupon_amt_used = Input::get('coupon_amt');
        }
        if (Input::get('payment_method')) {
            $order->payment_method = 1;
            $order->payment_status = 1;
            $order->transaction_id = "";
            $order->transaction_status = "";
        }
        $date = date("Y-m-d H:i:s");
        $order->created_at = $date;
         $order->order_status = 1;
       if ($order->save()) {
            if (Input::get('coupon_code') != '') {
                $this->coupon_count($coupon->id);
            }
            $this->updateStock($order->id);
            return $data_email = ['status' => '1', 'msg' => "Order placed successfully!", 'first_name' => Input::get("fname"), 'orderId' => $order->id, 'emial' => Input::get("email")];
        } else {
            return $data = ['status' => '0', 'msg' => "Oops, something went wrong. Please try again later!"];
        }
    }

    public function check_user_level_discount() {
        $discType = Input::get('discType');
        $discVal = Input::get('discVal');
        $cartAmount = Input::get("order_amount"); //Helper::getAmt();
        if ($discType == 1) {
            $amountAfrDisc = $cartAmount - ($cartAmount * $discVal / 100);
            $discountAmt = ($cartAmount * $discVal / 100);
            return $data = ['status' => 'success', 'msg' => "<span style='color:green;'>Discount Code Applied!</span> <a href='javascript:void(0);' style='border-bottom: 1px dashed;' class='clearDiscount' id='discAmt'>Remove!</a>", 'discountedAmt' => $amountAfrDisc, 'discVal' => $discountAmt];
        } else if ($discType == 2) {
            $amountAfrDisc = $cartAmount - $discVal;
            $discountAmt = ($discVal);
            return $data = ['status' => 'success', 'msg' => "<span style='color:green;'>Discount Code Applied!</span> <a href='javascript:void(0);' style='border-bottom: 1px dashed;' class='clearDiscount' id='discAmt'>Remove!</a>", 'discountedAmt' => $amountAfrDisc, 'discVal' => $discountAmt];
        } else {
            return $data = ['status' => 'error', 'msg' => "<span style='color:red;'>Invalid Code</span>", 'cartAmt' => $cartAmount, 'discVal' => 0.00];
        }
    }

    public function check_coupon() {
        //Get User
        if (!empty(Input::get('mobile'))) {
            $user = User::where('telephone', Input::get('mobile'))->first();
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
        $couponID = Coupon::where("coupon_code", "=", $couponCode)->first();
        @$usedCouponCountOrders = @Order::where('coupon_used', '=', $couponID->id)->where("order_status", "=", 1)->count();
        if (isset($couponID)) {
            if ($couponID->user_specific == 1) {
                if ($userId != '') {
                    $chkUserSp = Coupon::find($couponID->id)->userspecific()->get(['user_id']);
                    $cuserids = [];
                    foreach ($chkUserSp as $chkuserid) {
                        array_push($cuserids, $chkuserid->user_id);
                    }
                    $validuser = in_array($userId, $cuserids);
                    if ($validuser) {
                        $validCoupon = DB::select(DB::raw("Select * from " . DB::getTablePrefix() . "coupons where coupon_code = '$couponCode'  and no_times_allowed > $usedCouponCountOrders and min_order_amt <= " . $orderAmount . " and (now() between start_date and end_date)"));
                    }
                }
            } else {
                $validCoupon = DB::select(DB::raw("Select * from " . DB::getTablePrefix() . "coupons where coupon_code = '$couponCode'  and no_times_allowed > $usedCouponCountOrders and min_order_amt <= " . $orderAmount . " and (now() between start_date and end_date)"));
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
                        $indvDisc = number_format(($validCoupon[0]->coupon_value * $prdAllC['subtotal']) / 100, 2);
                        $disc += $indvDisc;
                        $individualSubtotal[$prdAllC['rowid']] = $indvDisc; //die;
                    } else {

                        if ($validCoupon[0]->discount_type == 2) {
                            $orderAmt += $prdAllC['subtotal'];
                            if ($validCoupon[0]->min_order_amt <= $orderAmt) {
                                $disc = $validCoupon[0]->coupon_value;
                                $individualSubtotal[$prdAllC['rowid']] = number_format($prdAllC['qty'] * $prdAllC['price'], 2);
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
            $newAmnt = (($orderAmount * $currencyVal) - $disc);
            $data['new_amt'] = $newAmnt * $currencyVal;
            $data['coupon_type'] = $validCoupon[0]->coupon_type * $currencyVal;
            $data['disc'] = $disc * $currencyVal;
            $data['individual_disc_amt'] = $discountCartProds;
            $data['subtotal'] = $orderAmount;
            $data['orderAmount'] = $orderAmount * $currencyVal;
            $data['coupon_is_valid'] = '1';
            //  echo "Coupon Applied :-" . $newAmnt . ":-" . $validCoupon[0]->coupon_type . ":-" . $disc;

            return $data;
        } else {
            $couponValR = $orderAmount + Session::get('couponUsedAmt');
            $data['remove'] = 1;
            //$data['orderFinalAmount']= $orderAmount;
            $data['orderAmount'] = $orderAmount * $currencyVal;
            $data['subtotal'] = Helper::getAmt();
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
            $individualDiscountPercent[$key] = number_format($disc * $calPerdiscount / $arraySumPercent, 2);
        }
        Session::put('individualDiscountPercent', json_encode($individualDiscountPercent));
        return $individualDiscountPercent;
    }

    public function checkLoyalty() {
        return Helper::getUserCashBack(Input::get('phone'));
    }

    public function getLoyaltyGroup() {
        return Loyalty::all();
    }

}
