<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Input;
use Cart;

class ApiDistributorOrderController extends Controller
{
    public function placeOrder()
    {
        $UserId = Input::get('UserId');
        if(!empty($UserId)){
            $user = DB::table('users')->where('id', $UserId)->first();
            if ($user->cart != '') {
                $cartData = json_decode($user->cart, true);
                Cart::instance('shopping')->add($cartData);
            }
        $cartData = Cart::instance("shopping")->content();
        }else{
            return response()->json(["status" => 0, 'msg' => 'Mandatory fields are missing.']);
        }
        dd('sdsd');
        $data['cart']['data'] = $cartData;
        $data["ccnt"] = Cart::instance("shopping")->count();

        if (!Session::get('usedCouponId')) {
            Cart::instance("shopping")->destroy();
            $mycarts = Input::get('mycart');
            foreach ($mycarts as $key => $mycart) {
                $getProd = DistributorProduct::find($mycart['prod_id']);
                //dd($getProd);
                $subProdId = (isset($mycart['subprodid'])) ? $mycart['subprodid'] : null;
                $addCart = app('App\Http\Controllers\Admin\DistributorCartController')->addCartData($getProd->prod_type, $getProd->id, $subProdId, $mycart['qty'], Session::get('offerid'));
            }
        }
        $cartInfo = Cart::instance("shopping")->total();
        // $finalamt = Cart::instance("shopping")->total() -  Session::get('couponUsedAmt');
        $cart_amt = Helper::calAmtWithTax();
        $finalamt = $cart_amt['total'];
        $paymentAmt = Input::get('pay_amt');
        $paymentMethod = Input::get('payment_mode'); //"9";
        $paymentStatus = "1";
        $payAmt = $finalamt;
        // apply additional charge to payAmount
        $additional_charge_json = AdditionalCharge::ApplyAdditionalCharge($payAmt);
        $additional_charge = json_decode($additional_charge_json, true);
        $payAmt = $payAmt + $additional_charge['total_amt'];

        $trasactionId = "";
        $transactionStatus = "";
        $userid = Input::get('user_id');
        $addressid = Input::get('address_id');
        $userinfo = User::find($userid);
        Session::put('loggedin_user_id', $userid);
        Session::put("addressSelected", $addressid);
        Session::put('logged_in_user', $userinfo->email);
        Session::put('user_cashback', $userinfo->cashback);
        Session::put('login_user_type', $userinfo->user_type);
        Session::put('login_user_first_name', $userinfo->firstname);
        Session::put('login_user_last_name', $userinfo->lastname);
        Session::put('login_user_telephone', $userinfo->telephone);
        Session::forget('orderId');
        $toPay = app('App\Http\Controllers\Frontend\CheckoutController')->toPayment();
        if (!empty($toPay['orderId'])) {
            $orderS = Order::find($toPay['orderId']);
            $orderS->created_by = Session::get('loggedinAdminId');
            $orderS->additional_charge = $additional_charge_json;
            $orderS->amt_paid = $paymentAmt;
            $orderS->order_type = 1;
            // $orderS->offline_payment_mode = Input::get('payment_mode');
            $orderS->description = Input::get('remark');
            $orderS->order_status = Input::get('remark');
            $orderS->update();
            if ($paymentMethod == '10') {
                // echo $userinfo->credit_amt;
                $userinfo->credit_amt = $userinfo->credit_amt + ($payAmt - $paymentAmt);
                // dd($userinfo->credit_amt);
                $userinfo->update();
                $paymentHistory = PaymentHistory::create();
                $paymentHistory->order_id = $orderS->id;
                $paymentHistory->pay_amount = $paymentAmt;
                $paymentHistory->added_by = Session::get('loggedinAdminId');
                $paymentHistory->save();
            }
            $succ = $this->saveOrderSuccess($paymentMethod, $paymentStatus, $payAmt, $trasactionId, $transactionStatus);
            Cart::instance("shopping")->destroy();
            Session::forget('loggedin_user_id');
            Session::forget("addressSelected");
            Session::forget('orderId');
            Session::forget('usedCouponId');
            Session::forget('logged_in_user');
            Session::forget('user_cashback');
            Session::forget('login_user_type');
            Session::forget('distributor_store_id');
            Session::forget('distributor_store_prefix');
            Session::forget('login_user_first_name');
            Session::forget('login_user_last_name');
            Session::forget('login_user_telephone');
            Session::forget('offerid');
        }

        if ($succ['orderId']) {
            return ['status' => 3, 'msg' => 'Created', 'orderId' => $succ['orderId']]; //success
        } else {
            return ['status' => 3, 'msg' => 'Created', 'orderId' => $succ['orderId']]; //failure
        }
    }
}
