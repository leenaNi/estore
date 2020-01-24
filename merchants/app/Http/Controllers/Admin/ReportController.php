<?php

namespace App\Http\Controllers\Admin;

use Route;
use App\Models\MallProducts;
use Input;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\HasProducts;
use App\Library\Helper;
use DB;


class ReportController extends Controller {

    public function ordersIndex() {
       $jsonString = Helper::getSettings();

        if (!empty(Input::get("order_number"))) {
            $orders = Order::where("orders.store_id", $jsonString['store_id'])->where("orders.id", "like","%". Input::get("order_number") . "%")->orderBy("orders.created_at", "desc")->join("payment_method as pm", "pm.id", '=', 'orders.payment_method')->join("order_status as os", "os.id", '=', 'orders.order_status')->join("payment_status as ps", "ps.id", '=', 'orders.payment_status')->select(["orders.id as order_id","orders.created_at as order_date","orders.first_name","orders.last_name","os.order_status","pm.name as payment_method","ps.payment_status","orders.pay_amt as total_amount","orders.order_amt as amount","orders.cod_charges","orders.gifting_charges","orders.discount_amt","orders.shipping_amt","orders.referal_code_amt","orders.voucher_amt_used","orders.coupon_amt_used"])->paginate(Config('constants.paginateNo'));
        }else if(!empty(Input::get('customer_name'))){
            $orders = Order::where("orders.store_id", $jsonString['store_id'])->where("orders.first_name", "like","%". Input::get("customer_name") . "%")->orderBy("orders.created_at", "desc")->join("payment_method as pm", "pm.id", '=', 'orders.payment_method')->join("order_status as os", "os.id", '=', 'orders.order_status')->join("payment_status as ps", "ps.id", '=', 'orders.payment_status')->select(["orders.id as order_id","orders.created_at as order_date","orders.first_name","orders.last_name","os.order_status","pm.name as payment_method","ps.payment_status","orders.pay_amt as total_amount","orders.order_amt as amount","orders.cod_charges","orders.gifting_charges","orders.discount_amt","orders.shipping_amt","orders.referal_code_amt","orders.voucher_amt_used","orders.coupon_amt_used"])->paginate(Config('constants.paginateNo'));
        }else if(!empty(Input::get('datefrom'))){
            $date = date("Y-m-d", strtotime(Input::get('datefrom')));
            $orders = Order::where("orders.store_id", $jsonString['store_id'])->where('orders.created_at', '>=', $date)->orderBy("orders.created_at", "desc")->join("payment_method as pm", "pm.id", '=', 'orders.payment_method')->join("order_status as os", "os.id", '=', 'orders.order_status')->join("payment_status as ps", "ps.id", '=', 'orders.payment_status')->select(["orders.id as order_id","orders.created_at as order_date","orders.first_name","orders.last_name","os.order_status","pm.name as payment_method","ps.payment_status","orders.pay_amt as total_amount","orders.order_amt as amount","orders.cod_charges","orders.gifting_charges","orders.discount_amt","orders.shipping_amt","orders.referal_code_amt","orders.voucher_amt_used","orders.coupon_amt_used"])->paginate(Config('constants.paginateNo'));
        }else if(!empty(Input::get('dateto'))){
            $date = date("Y-m-d", strtotime(Input::get('dateto')));
            $orders = Order::where("orders.store_id", $jsonString['store_id'])->where('orders.created_at', '<=', $date)->orderBy("orders.created_at", "desc")->join("payment_method as pm", "pm.id", '=', 'orders.payment_method')->join("order_status as os", "os.id", '=', 'orders.order_status')->join("payment_status as ps", "ps.id", '=', 'orders.payment_status')->select(["orders.id as order_id","orders.created_at as order_date","orders.first_name","orders.last_name","os.order_status","pm.name as payment_method","ps.payment_status","orders.pay_amt as total_amount","orders.order_amt as amount","orders.cod_charges","orders.gifting_charges","orders.discount_amt","orders.shipping_amt","orders.referal_code_amt","orders.voucher_amt_used","orders.coupon_amt_used"])->paginate(Config('constants.paginateNo'));
        }else if(!empty(Input::get('datefrom')) && !empty(Input::get('dateto'))){
            $date1 = date("Y-m-d", strtotime(Input::get('datefrom')));
            $date2 = date("Y-m-d", strtotime(Input::get('dateto')));
            $orders = Order::where("orders.store_id", $jsonString['store_id'])->where('orders.created_at', '<=', $date2)->where('orders.created_at', '>=', $date1)->orderBy("orders.created_at", "desc")->join("payment_method as pm", "pm.id", '=', 'orders.payment_method')->join("order_status as os", "os.id", '=', 'orders.order_status')->join("payment_status as ps", "ps.id", '=', 'orders.payment_status')->select(["orders.id as order_id","orders.created_at as order_date","orders.first_name","orders.last_name","os.order_status","pm.name as payment_method","ps.payment_status","orders.pay_amt as total_amount","orders.order_amt as amount","orders.cod_charges","orders.gifting_charges","orders.discount_amt","orders.shipping_amt","orders.referal_code_amt","orders.voucher_amt_used","orders.coupon_amt_used"])->paginate(Config('constants.paginateNo'));
        }else if(!empty(Input::get('order_status')) && Input::get('order_status') != '0'){
            $orders = Order::where("orders.store_id", $jsonString['store_id'])->where('orders.order_status', (int)Input::get('order_status'))->orderBy("orders.created_at", "desc")->join("payment_method as pm", "pm.id", '=', 'orders.payment_method')->join("order_status as os", "os.id", '=', 'orders.order_status')->join("payment_status as ps", "ps.id", '=', 'orders.payment_status')->select(["orders.id as order_id","orders.created_at as order_date","orders.first_name","orders.last_name","os.order_status","pm.name as payment_method","ps.payment_status","orders.pay_amt as total_amount","orders.order_amt as amount","orders.cod_charges","orders.gifting_charges","orders.discount_amt","orders.shipping_amt","orders.referal_code_amt","orders.voucher_amt_used","orders.coupon_amt_used"])->paginate(Config('constants.paginateNo'));
        }else{
            $orders = Order::where("orders.store_id", $jsonString['store_id'])->orderBy("orders.created_at", "desc")->join("payment_method as pm", "pm.id", '=', 'orders.payment_method')->join("order_status as os", "os.id", '=', 'orders.order_status')->join("payment_status as ps", "ps.id", '=', 'orders.payment_status')->select(["orders.id as order_id","orders.created_at as order_date","orders.first_name","orders.last_name","os.order_status","pm.name as payment_method","ps.payment_status","orders.pay_amt as total_amount","orders.order_amt as amount","orders.cod_charges","orders.gifting_charges","orders.discount_amt","orders.shipping_amt","orders.referal_code_amt","orders.voucher_amt_used","orders.coupon_amt_used"])->paginate(Config('constants.paginateNo'));
        }
        $order_status = OrderStatus::select("id","order_status")->get()->toArray();
        $o_status = [];
        $o_status["0"] = "All" ;
        foreach ($order_status as $val) {
            $o_status[$val['id']] = $val['order_status'] ;
        }
        $data = ['orders' => $orders,"o_status" => $o_status];

       $viewname = Config('constants.adminReports') . '.category';
       return Helper::returnView($viewname, $data);
    }

    public function productIndex() {
        ini_set("memory_limit", "-1");
        $jsonString = Helper::getSettings();
         
        $search = !empty(Input::get("search")) ? Input::get("search") : '';
        $search_fields = ['product', 'short_desc', 'long_desc'];
        $prods = DB::table('products as p')
                //->where('is_individual', '=', '1')
                ->join("has_products as hp", "hp.prod_id", '=', 'p.id','left')->whereNotIn('hp.order_status',[0,4,6,10])
                ->join("has_categories as hc", "hc.prod_id", "=", "p.id",'left')
                ->join("store_categories as sc", "sc.id", "=", "hc.cat_id",'left')
                ->join("categories as c", "c.id", "=", "sc.category_id",'left')
                ->where("hp.store_id", $this->jsonString['store_id'])
                ->select('p.id','p.product','hp.sub_prod_id',DB::raw("SUM(hp.qty) tot_qty"),DB::raw("SUM(hp.pay_amt) sales"), 'c.category')
                ->orderBy("tot_qty", "desc")
                ->groupBy('p.id');
        if (!empty(Input::get('product_name'))) {
            $prods = $prods->where("p.product", "like","%". Input::get("product_name") . "%")->paginate(Config('constants.paginateNo'));
            $prodCount=$prods->count();
        } else if(!empty(Input::get('category')) && Input::get('category') != '0' ){
            $prods = $prods->where("c.id", (int)Input::get("category"))->paginate(Config('constants.paginateNo'));
            $prodCount=$prods->count();
        } else {
            $prods = $prods->where('p.status',1)->paginate(Config('constants.paginateNo'));
            $prodCount=$prods->total();
        }
         
        $cat = DB::table("categories")->select("category","id")->get()->toArray();
        foreach($prods as $prd){
            if($prd->id != $prd->sub_prod_id){
                $prodname = Product::find($prd->sub_prod_id);
                $prd->product = $prodname->product;
            }
        }
        $categrs = [];
        $categrs["0"] = "All" ;
        foreach ($cat as $val) {
            $categrs[$val->id] = $val->category ;
        }
        $data = ['prods' => $prods,'prodCount' => $prodCount,'categrs' => $categrs];       

        $viewname = Config('constants.adminReports') . '.product';
        return Helper::returnView($viewname, $data);
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

    public function ordersIndexExport() {
        $jsonString = Helper::getSettings();
        $orders = Order::where("orders.store_id", $jsonString['store_id'])->orderBy("orders.created_at", "desc")->join("payment_method as pm", "pm.id", '=', 'orders.payment_method')->join("order_status as os", "os.id", '=', 'orders.order_status')->join("payment_status as ps", "ps.id", '=', 'orders.payment_status')->select(["orders.id as order_id","orders.created_at as order_date","orders.first_name","orders.last_name","os.order_status","pm.name as payment_method","ps.payment_status","orders.pay_amt as total_amount","orders.order_amt as amount","orders.cod_charges","orders.gifting_charges","orders.discount_amt","orders.shipping_amt","orders.referal_code_amt","orders.voucher_amt_used","orders.coupon_amt_used"])->get()->toArray();

        $user_data = [];
        array_push($user_data, ['Order Id','Order Date','Name','Order Status', 'Payment Method','Amount','COD Charges','Gifting Charges','Discount Amount','Shipping Amount','Referal Code Amount','Voucher Amount Used','Coupon Amount Used','Total Amount',]);

        foreach ($orders as $vl) {
            $details = [];
            // dd($vl);
            $c_date = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $vl["order_date"])->format('d-M-Y');
            $name = $vl["first_name"]." ".$vl["last_name"] ;
            $details = [$vl["order_id"],$c_date,$name,$vl["order_status"],$vl["payment_method"],$vl["amount"],$vl["cod_charges"],$vl["gifting_charges"],$vl["discount_amt"],$vl["shipping_amt"],$vl["referal_code_amt"],$vl["voucher_amt_used"],$vl["coupon_amt_used"],$vl["total_amount"]];
            array_push($user_data, $details);
        }
        
        return Helper::getCsv($user_data, 'ordersIndex.csv', ',');
    }

    public function productIndexExport() {
        $jsonString = Helper::getSettings();
        $prods = DB::connection('mysql2')->table(DB::getTablePrefix().'products as p')
                ->where('is_individual', '=', '1')
                ->join("has_products as hp", "hp.prod_id", '=', 'p.id')->whereNotIn('hp.order_status',[0,4,6,10])
                ->join(DB::getTablePrefix()."has_categories as hc", "hc.prod_id", "=", "p.id")
                ->join(DB::getTablePrefix()."categories as c", "c.id", "=", "hc.cat_id")
                ->where("hp.store_id", $this->jsonString['store_id'])
                ->select('p.id','p.product',DB::raw("SUM(hp.qty) tot_qty"),DB::raw("SUM(hp.pay_amt) sales"), 'c.category')
                ->orderBy("tot_qty", "desc")
                ->groupBy('p.id')
                ->where('p.status',1)
                ->get()->toArray();
        
        $user_data = [];
        array_push($user_data, ['Product Name','Category Name','Quantity','Total Amount']);

        foreach ($prods as $vl) {
            $details = [];
            // dd($vl);
            $details = [$vl->product,$vl->category,$vl->tot_qty,$vl->sales];
            array_push($user_data, $details);
        }
        
        return Helper::getCsv($user_data, 'productsIndex.csv', ',');
    }
}



   