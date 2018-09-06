<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use App\Models\Order;
use App\Models\Category;
use App\Models\Currency;
use App\Library\Helper;
use Validator;
use Illuminate\Support\Facades\Input;
use Hash;
use Session;
use Auth;
use DB;

class PaymentSettlementController extends Controller {

    public function index() {


        $orders = DB::table("has_products")->orderBy("has_products.id", "desc")->join("stores", "stores.id", '=', "has_products.store_id")->
                leftjoin("payment_settlement", "payment_settlement.id", '=', "has_products.id")
                ->select('has_products.*', 'stores.store_name', 'payment_settlement.settled_amt', 'payment_settlement.settled_date')
                ->paginate(Config('constants.AdminPaginateNo'));

        //$merchants = $merchants->paginate(Config('constants.AdminPaginateNo'));
        $data = ['orders' => $orders];
        $viewname = Config('constants.AdminPagesPaymentettlement') . ".index";
        return Helper::returnView($viewname, $data);
    }

    public function settledPayment() {
        $id = Input::get('id');
        if (is_array($id)) {
            $orders = DB::table("has_products")->where("has_products.id", $id)->where("settled_status", 0)->join("stores", "stores.id", '=', "has_products.store_id")
                            ->select('has_products.*', 'stores.percent_to_charge')->get();

            if (count($orders) > 0) {
                foreach ($orders as $order) {
                    $this->saveSettlementHistory($order);
                }
            }
        } else {
            $order = DB::table("has_products")->where("id", $id)->where("settled_status", 0)
                            ->join("stores", "stores.id", '=', "has_products.store_id")->select('has_products.*', 'stores.percent_to_charge')->first();
            if (count($order) > 0) {
                $this->saveSettlementHistory($order);
            }
        }
    }

    public function saveSettlementHistory($order) {
        $settleAmt = $order->pay_amt - ($order->pay_amt * $order->percent_to_charge * 0.01);
        $history = [];
        $history['order_id'] = $order->id;
        $history['store_id'] = $order->store_id;
        $history['order_amt'] = $order->pay_amt;
        $history['settled_amt'] = $settleAmt;
        $history['percent'] = $order->percent_to_charge;
        $history['settled_date'] = date('Y-m-d h:i');
        DB::table("payment_settlement")->insert($history);
        DB::table("has_products")->where("id", $order->id)->update(['settled_status' => 1]);
    }

}
