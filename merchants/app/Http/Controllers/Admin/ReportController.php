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
       $orders = Order::where("orders.store_id", $jsonString['store_id'])->orderBy("orders.created_at", "desc")->join("payment_method as pm", "pm.id", '=', 'orders.payment_method')->join("order_status as os", "os.id", '=', 'orders.order_status')->join("payment_status as ps", "ps.id", '=', 'orders.payment_status')->get(["orders.id as order_id","orders.created_at as order_date","orders.first_name","orders.last_name","os.order_status","pm.name as payment_method","ps.payment_status","orders.pay_amt as total_amount","orders.order_amt as amount","orders.cod_charges","orders.gifting_charges","orders.discount_amt","orders.shipping_amt","orders.referal_code_amt","orders.voucher_amt_used","orders.coupon_amt_used"]);

        $data = ['orders' => $orders];

       $viewname = Config('constants.adminReports') . '.category';
       return Helper::returnView($viewname, $data);
    }

    public function productIndex() {
        ini_set("memory_limit", "-1");
        $jsonString = Helper::getSettings();
         
        $search = !empty(Input::get("search")) ? Input::get("search") : '';
        $search_fields = ['product', 'short_desc', 'long_desc'];
        $prods = DB::connection('mysql2')->table($this->jsonString['prefix'].'_products as p')
                ->where('is_individual', '=', '1')
                ->join("has_products as hp", "hp.prod_id", '=', 'p.id')->whereNotIn('hp.order_status',[0,4,6,10])
                ->join($this->jsonString['prefix']."_has_categories as hc", "hc.prod_id", "=", "p.id")
                ->join($this->jsonString['prefix']."_categories as c", "c.id", "=", "hc.cat_id")
                ->where("hp.store_id", $this->jsonString['store_id'])
                ->select('p.id','p.product',DB::raw("SUM(hp.qty) tot_qty"),DB::raw("SUM(hp.pay_amt) sales"), 'c.category')
                ->orderBy("tot_qty", "desc")
                ->groupBy('p.id');

        if (!empty(Input::get('from_date')) || !empty(Input::get('search')) || !empty(Input::get('to_date'))) {
            $prods = $prods->where('p.status',1)->get();
            $prodCount=$prods->count();

        } else {
            $prods = $prods->where('p.status',1)->paginate(Config('constants.paginateNo'));
             $prodCount=$prods->total();
        }
        // $this->categoryWise("Red Tshirt");
        return view(Config('constants.adminReports') . '.product', compact('prods','prodCount'));
        }

    public function categoryWise() {

        $name=Input::get('name');
        // dd($name);
        $jsonString = Helper::getSettings();
        $orders = Order::where("orders.store_id", $jsonString['store_id'])->get(["cart","id","created_at","pay_amt","first_name","last_name"]);
        $temp_data = [];
        $i = 0;
        foreach ($orders as $ord){
            $ot_data = [];
            $parsed_data = [];
            $cart_data = json_decode($ord["cart"], true);
            $j = 0;
            foreach ($cart_data as $cd) {
                if ($name == $cd["name"]) {
                    $parsed_data[$j] = $cd;
                    $j++;
                }
            }
            if($parsed_data){
                $ot_data["order_id"] = $ord["id"];
                $ot_data["order_date"] = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $ord["created_at"])
                ->format('d-M-Y');
                $ot_data["order_amount"] = $ord["pay_amt"];
                $ot_data["last_name"] = $ord["last_name"];
                $ot_data["first_name"] = $ord["first_name"];
                $ot_data["orders"] = $parsed_data;
                $temp_data[$i] = $ot_data; 
            } 
            $i++; 
        }
        return $temp_data;
    }
}



   