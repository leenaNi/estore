<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use App\Models\Order;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Store;
use App\Library\Helper;
use Validator;
use Illuminate\Support\Facades\Input;
use Hash;
use Session;
use Auth;
use DB;

class PaymentSettlementController extends Controller {

    public function index() {
//     $orders = DB::table("has_products")->orderBy("has_products.id", "desc")->join("stores", "stores.id", '=', "has_products.store_id")->
//                leftjoin("payment_settlement", "payment_settlement.order_id", '=', "has_products.id")
//                ->select(DB::raw('sum(has_products.pay_amt) as totalOrder' ), 'stores.store_name', DB::raw('sum(payment_settlement.settled_amt) as totalPaid'),  DB::raw('sum(payment_settlement.order_amt) as orderAmt'))->groupBy("has_products.store_id")->get();
//         dd($orders);courier
        $stores = Store::where("status", 1)->pluck("store_name", "id");
        $settle = Input::get('settlement') ? Input::get('settlement') : 0;
        $storeId = Input::get('storeId');
        if ($settle == 1) {
            $orders = DB::table("has_products")->orderBy("has_products.id", "desc")->join("stores", "stores.id", '=', "has_products.store_id")->
                    leftjoin("payment_settlement", "payment_settlement.order_id", '=', "has_products.id")
                    ->select('has_products.*', 'stores.store_name', 'stores.percent_to_charge', 'payment_settlement.settled_amt', 'payment_settlement.settled_date', 'payment_settlement.commision');

            $orders->where('settled_status', 1);
        } else {
            $orders = DB::table("has_products")->orderBy("has_products.id", "desc")->join("stores", "stores.id", "=", "has_products.store_id")
                    ->join("orders", "orders.id", "=", "has_products.order_id")
                    ->select('has_products.*', 'stores.store_name', 'stores.percent_to_charge');
            $orders->where('settled_status', 0)->where('orders.order_status', 3)
                    ->where('orders.payment_status', 4)->whereIn('orders.courier', [1]);
        }
        if ($storeId) {
            $orders->where('has_products.store_id', $storeId);
        }

        $orders = $orders->paginate(Config('constants.AdminPaginateNo'));
        if ($settle == 1) {
            
        } else {
            foreach ($orders as $order) {
                $commision = $order->pay_amt * $order->percent_to_charge * 0.01;
                $order->settled_amt = ($order->pay_amt - $commision);
                $order->commision = $commision;
            }
        }
        $data = ['orders' => $orders, 'stores' => $stores];
        $viewname = Config('constants.AdminPagesPaymentettlement') . ".index";
        return Helper::returnView($viewname, $data);
    }

    public function settledPayment() {
        $id = Input::get('id');
        if (is_array($id)) {
            $orders = DB::table("has_products")->whereIn("has_products.id", $id)->where("settled_status", 0)->join("stores", "stores.id", '=', "has_products.store_id")
                            ->select('has_products.*', 'stores.percent_to_charge')->get();

            if (count($orders) > 0) {
                foreach ($orders as $order) {
                    $this->saveSettlementHistory($order);
                    Session::flash("message", "Orders settled successfully");
                }
            } else {
                Session::flash("msg", "Selected Orders alreay settled");
            }
        } else {
            $order = DB::table("has_products")->where("id", $id)->where("settled_status", 0)
                            ->join("stores", "stores.id", '=', "has_products.store_id")->select('has_products.*', 'stores.percent_to_charge')->first();
            if (count($order) > 0) {
                $this->saveSettlementHistory($order);
                Session::flash("msg", "Order settled successfully");
            } else {
                Session::flash("message", "Selected Order alreay settled");
            }
        }
    }

    public function saveSettlementHistory($order) {

        $commision = $order->pay_amt * $order->percent_to_charge * 0.01;
        $settleAmt = ($order->pay_amt - $commision);
        $history = [];
        $history['order_id'] = $order->id;
        $history['store_id'] = $order->store_id;
        $history['order_amt'] = $order->pay_amt;
        $history['settled_amt'] = round($settleAmt, 2);
        $history['percent'] = $order->percent_to_charge;
        $history['commision'] = $commision;
        $history['settled_date'] = date('Y-m-d h:i');
        DB::table("payment_settlement")->insert($history);
        DB::table("has_products")->where("id", $order->id)->update(['settled_status' => 1]);
    }

    public function settlementSummary() {
        $orders = DB::table("has_products")->orderBy("has_products.id", "desc")->join("stores", "stores.id", '=', "has_products.store_id")->
                leftjoin("payment_settlement", "payment_settlement.order_id", '=', "has_products.id")
                ->join("orders", "orders.id", '=', "has_products.order_id")
//              
                ->select(DB::raw('sum(has_products.pay_amt) as totalOrder, (select sum(has_products.pay_amt) where orders.courier = 0) as c3, (select sum(has_products.pay_amt) where orders.courier = 1) as c4, stores.store_name, sum(payment_settlement.settled_amt) as totalPaid, sum(payment_settlement.order_amt) as orderAmt'))
                ->groupBy("has_products.store_id");
        $orders = $orders->paginate(Config('constants.AdminPaginateNo'));
        dd($orders);
        $data = ['orders' => $orders];
        $viewname = Config('constants.AdminPagesPaymentettlement') . ".settlementSummary";
        return Helper::returnView($viewname, $data);
    }

}
