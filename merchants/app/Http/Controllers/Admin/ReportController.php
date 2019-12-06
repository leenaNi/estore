<?php

namespace App\Http\Controllers\Admin;

use Route;
use App\Models\MallProducts;
use Input;
use App\Http\Controllers\Controller;

use App\Models\Order;
use App\Models\HasProducts;
use App\Library\Helper;
use DB;


class ReportController extends Controller {

    public function ordersIndex() {
       $jsonString = Helper::getSettings();
       $orders = Order::where("orders.store_id", $jsonString['store_id'])->join("payment_method as pm", "pm.id", '=', 'orders.payment_method')->join("order_status as os", "os.id", '=', 'orders.order_status')->join("payment_status as ps", "ps.id", '=', 'orders.payment_status')->get(["orders.id as order_id","orders.created_at as order_date","orders.first_name","orders.last_name","os.order_status","pm.name as payment_method","ps.payment_status","orders.pay_amt as total_amount","orders.order_amt as amount","orders.cod_charges","orders.gifting_charges","orders.discount_amt","orders.shipping_amt","orders.referal_code_amt","orders.voucher_amt_used","orders.coupon_amt_used"]);

        $data = ['orders' => $orders];

       $viewname = Config('constants.adminReports') . '.category';
       return Helper::returnView($viewname, $data);
    }

    public function productIndex() {
       $parsed_data = [];
       $jsonString = Helper::getSettings();

       $products = HasProducts::where("has_products.store_id", $jsonString['store_id'])->get(["product_details"]);

        $i = 0;
        foreach ($products as $document){ 
            $temp_data = json_decode($document["product_details"], true);
            $parsed_data[$i] = $temp_data;
            $i++;
        }
        return $parsed_data;
        }

}

   