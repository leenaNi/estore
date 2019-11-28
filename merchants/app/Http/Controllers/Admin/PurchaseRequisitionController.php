<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Library\Helper;
use App\Models\Address;
use App\Models\Category;
use App\Models\Country;
use App\Models\Coupon;
use App\Models\Flags;
use App\Models\HasProducts;
use App\Models\Order;
use App\Models\OrderFlagHistory;
use App\Models\OrderReturnCashbackHistory;
use App\Models\EmailTemplate;
use App\Models\OrderReturnStatus;
use App\Models\OrderStatus;
use App\Models\OrderStatusHistory;
use App\Models\PaymentMethod;
use App\Models\PaymentStatus;
use App\Models\Product;
use App\Models\ReturnOrder;
use App\Models\User;
use App\Models\CurierHistory;
use App\Models\StaticPage;
use App\Models\HasCurrency;
use App\Models\Zone;
use App\Models\Courier;
use App\Models\HasCourier;
use App\Models\AdditionalCharge;
use App\Models\GeneralSetting;
use Cart;
use Config;
use DB;
use Input;
use Mail;
use Session;
use Hash;
use Crypt;
use App\Traits\Admin\OrdersTrait;
use Form;
use Request;
use DateTime;
use App\Models\MallProducts;
use http\Client;

class PurchaseRequisitionController extends Controller
{
    use OrdersTrait;

    public function index() {
        $jsonString = Helper::getSettings();

//      $data=  DB::table('has_industries')->join("general_setting as g",'g.id','=','has_industries.general_setting_id')
//             ->join("categories",'has_industries1.industry_id','=','categories.id')
//              ->select('g.id','g.name','g.is_active','g.is_question','g.question_category_id','categories.category')->get();
        $order_status = OrderStatus::where('status', 1)->orderBy('order_status', 'asc')->get();
        $order_options = '';
        foreach ($order_status as $status) {
            $order_options .= '<option  value="' . $status->id . '">' . $status->order_status . '</option>';
        }
        $orders = Order::sortable()->where("orders.order_status", "!=", 0)->join("has_products", "has_products.order_id", '=', 'orders.id')->where("has_products.store_id", $jsonString['store_id'])->select('orders.*', 'has_products.order_source', DB::raw('sum(has_products.pay_amt) as hasPayamt'))->groupBy('has_products.order_id')->orderBy('orders.id', 'desc');
        //   dd($orders);
        //  $orders = Order::sortable()->where("orders.order_status", "!=", 0)->where('prefix', $jsonString['prefix'])->where('store_id', $jsonString['store_id'])->with(['orderFlag'])->orderBy("id", "desc");
        $payment_method = PaymentMethod::all();
        $payment_stuatus = PaymentStatus::all();
        if (!empty(Input::get('order_ids'))) {
            $mulIds = explode(",", Input::get('order_ids'));
            $orders = $orders->whereIn("orders.id", $mulIds);
        }
        if (!empty(Input::get('order_number_from'))) {
            $orders = $orders->where('orders.id', '>=', Input::get('order_number_from'));
        }
        if (!empty(Input::get('order_number_to'))) {
            $orders = $orders->where('orders.id', '<=', Input::get('order_number_to'));
        }
        if (!empty(Input::get('pricemin'))) {
            $orders = $orders->where('pay_amt', '>=', Input::get('pricemin'));
        }
        if (!empty(Input::get('pricemax'))) {
            $orders = $orders->where('pay_amt', '<=', Input::get('pricemax'));
        }
        if (!empty(Input::get('search'))) {
            //get user id
            $users = User::whereRaw("(CONCAT(firstname,' ',lastname) like ?)", ['%' . Input::get('search') . '%'])->orwhere('email', "like", "%" . Input::get('search') . "%")->orwhere('telephone', "like", "%" . Input::get('search') . "%")->select('id')->get()->toArray();

            if (!empty($users)) {
                $orders = $orders->whereIn('user_id', $users);
            }
        }
        if (!empty(Input::get('date'))) {
            $dates = explode(' - ', Input::get('date'));
            $dates[0] = date("Y-m-d", strtotime($dates[0]));
            $dates[1] = date("Y-m-d 23:59:00", strtotime($dates[1]));
            $orders = $orders->whereBetween('created_at', $dates);
        }
        /* if (!empty(Input::get('dateto'))) {
          $date = date("Y-m-d", strtotime(Input::get('dateto')));
          $orders = $orders->where('created_at', '<=', $date);
          } */
        if (!empty(Input::get('searchFlag'))) {
            $chk = Flags::find(Input::get('searchFlag'))->flag;
            if (strpos($chk, 'No Flag') !== false) {
                $orders = $orders->where('flag_id', 0);
            } else {
                $orders = $orders->WhereHas('orderFlag', function($q) {
                    $q->where('flag_id', '=', Input::get('searchFlag'));
                });
            }
        }
        if (Input::get('searchStatus') !== null) {
            if (!empty(Input::get('searchStatus'))) {
                $order_options = '';
                foreach ($order_status as $status) {
                    $order_options .= '<option  value="' . $status->id . '" ' . (in_array($status->id, Input::get('searchStatus')) ? 'selected' : '') . '>' . $status->order_status . '</option>';
                }
                $orders = $orders->whereIn('order_status', Input::get('searchStatus'));
            }
        }

        $orders = $orders->paginate(Config('constants.paginateNo'));
        $ordersCount = $orders->total();
        $flags = Flags::all();

        $viewname = Config('constants.adminPurcRequisitionView') . '.index';
        $data = ['orders' => $orders, 'flags' => $flags, 'payment_method' => $payment_method, 'payment_stuatus' => $payment_stuatus, 'ordersCount' => $ordersCount, 'order_status' => $order_status, 'order_options' => $order_options];
        return Helper::returnView($viewname, $data);
    }

    public function createOrder() {
        Session::forget("discAmt");
        Session::forget('voucherUsedAmt');
        Session::forget('voucherAmount');
        Session::forget('remainingVoucherAmt');
        Session::forget('checkbackUsedAmt');
        Session::forget('remainingCashback');
        Session::forget("ReferalCode");
        Session::forget("ReferalId");
        Session::forget("referalCodeAmt");
        Session::forget("codCharges");
        Session::forget('shippingCost');
        // $validCoupon = DB::select(DB::raw("Select * from " . DB::getTablePrefix() . "coupons where coupon_code = '$couponCode'  and no_times_allowed > $usedCouponCountOrders and min_order_amt <= " . $orderAmount . " and (now() between start_date and end_date)"));
        Cart::instance("shopping")->destroy();
        $coupons = Coupon::whereDate('start_date', '<=', date("Y-m-d"))->where('end_date', '>=', date("Y-m-d"))->get();
        // dd($coupon);

        $viewname = Config('constants.adminPurcRequisitionView') . '.create-purc-requisition';
        $ordcountries = Country::where("status", 1)->pluck("name", "id")->prepend("Country", "");
        $ordstates = Zone::where("status", 1)->pluck("name", "id")->prepend("State", "");
        $roots = Category::roots()->where('status', 1)->get();
        $data = ['ordstates' => $ordstates, 'ordcountries' => $ordcountries, 'roots' => $roots, 'coupons' => $coupons];
        return Helper::returnView($viewname, $data);
    }
    
    public function view() {
        Session::forget("discAmt");
        Session::forget('voucherUsedAmt');
        Session::forget('voucherAmount');
        Session::forget('remainingVoucherAmt');
        Session::forget('checkbackUsedAmt');
        Session::forget('remainingCashback');
        Session::forget("ReferalCode");
        Session::forget("ReferalId");
        Session::forget("referalCodeAmt");
        Session::forget("codCharges");
        Session::forget('shippingCost');
        $jsonString = Helper::getSettings();
        $prodTab = $jsonString['prefix'] . '_products';
        $order = Order::findOrFail(Input::get('id'));
        $payment_method = PaymentMethod::get()->toArray();
        $payment_methods = [];
        foreach ($payment_method as $val) {
            $payment_methods[$val['id']] = $val['name'];
        }
        $payment_stuatusA = PaymentStatus::get()->toArray();
        $payment_status = [];
        foreach ($payment_stuatusA as $val) {
            $payment_status[$val['id']] = $val['payment_status'];
        }
        $order_stuatusA = OrderStatus::get()->toArray();
        $order_status = [];
        foreach ($order_stuatusA as $val) {
            $order_status[$val['id']] = $val['order_status'];
        }
        $countryA = Country::get()->toArray();
        $countries = [];
        foreach ($countryA as $val) {
            $countries[$val['id']] = $val['name'];
        }
        $zoneA = Zone::get()->toArray();
        $zones = [];
        foreach ($zoneA as $val) {
            $zones[$val['id']] = $val['name'];
        }
        $flags = Flags::where('status', 1)->get()->toArray();
        $flag_status[0] = "Select Flag";
        foreach ($flags as $val) {
            $flag_status[$val['id']] = $val['flag'];
        }
        $courierId = HasCourier::where('status', 1)->where('store_id', $this->jsonString['store_id'])->pluck("courier_id");

        $courier = Courier::where('status', 1)->whereIn('id', $courierId)->get()->toArray();

        $courier_status = [];
        $courier_status[0] = "Select Courier";
        foreach ($courier as $val) {
            $courier_status[$val['id']] = $val['name'];
        }
        if ($order->prefix == Helper::getSettings()['prefix']) {
            Cart::instance("shopping")->destroy();
            $coupons = Coupon::whereDate('start_date', '<=', date("Y-m-d"))->where('end_date', '>=', date("Y-m-d"))->get();
            $additional = json_decode($order->additional_charge, true);
            $prodTab = $jsonString['prefix'] . '_products';
            $prods = HasProducts::where('order_id', Input::get("id"))->join($prodTab, $prodTab . '.id', '=', 'has_products.prod_id')->where("prefix", $this->jsonString['prefix'])
                            ->select($prodTab . ".*", 'has_products.order_id', 'has_products.disc', 'has_products.prod_id', 'has_products.qty', 'has_products.price as hasPrice', 'has_products.product_details', 'has_products.sub_prod_id')->get();

            // $prod_id = HasProducts::where('order_id', Input::get("id"))->join($prodTab,$prodTab.'id','=','has_prodducts.prod_id')->where("prefix",$this->jsonString['prefix']);
            $products = $prods;
            $coupon = Coupon::find($order->coupon_used);
            $action = route("admin.orders.save");
            // return view(Config('constants.adminOrderView') . '.addEdit', compact('order', 'action', 'payment_methods', 'payment_status', 'order_status', 'countries', 'zones', 'products', 'coupon')); //'users', 
            $viewname = Config('constants.adminPurcRequisitionView') . '.view-purc-order';
            $data = ['order' => $order, 'action' => $action, 'payment_methods' => $payment_methods, 'payment_status' => $payment_status, 'order_status' => $order_status, 'countries' => $countries, 'zones' => $zones, 'products' => $products, 'coupon' => $coupon, 'coupons' => $coupons, 'flags' => $flag_status, 'courier' => $courier_status, 'additional' => $additional];
            return Helper::returnView($viewname, $data);
        } else {
            $products = HasProducts::where("order_status", "!=", 0)->where("order_id", Input::get('id'))->where('prefix', $jsonString['prefix'])->where('store_id', $jsonString['store_id'])->first();
            $action = route("admin.orders.mallOrderSave");
            $viewname = Config('constants.adminPurcRequisitionView') . '.view-purc-order';
            // dd($orders);
            $data = ['order' => $order, 'action' => $action, 'order_status' => $order_status, 'countries' => $countries, 'zones' => $zones,
                'products' => $products, 'courier' => $courier_status];
            return Helper::returnView($viewname, $data);
        }
    }

    public function edit() {
        Session::forget("discAmt");
        Session::forget('voucherUsedAmt');
        Session::forget('voucherAmount');
        Session::forget('remainingVoucherAmt');
        Session::forget('checkbackUsedAmt');
        Session::forget('remainingCashback');
        Session::forget("ReferalCode");
        Session::forget("ReferalId");
        Session::forget("referalCodeAmt");
        Session::forget("codCharges");
        Session::forget('shippingCost');
        $jsonString = Helper::getSettings();
        $prodTab = $jsonString['prefix'] . '_products';
        $order = Order::findOrFail(Input::get('id'));
        $payment_method = PaymentMethod::get()->toArray();
        $payment_methods = [];
        foreach ($payment_method as $val) {
            $payment_methods[$val['id']] = $val['name'];
        }
        $payment_stuatusA = PaymentStatus::get()->toArray();
        $payment_status = [];
        foreach ($payment_stuatusA as $val) {
            $payment_status[$val['id']] = $val['payment_status'];
        }
        $order_stuatusA = OrderStatus::get()->toArray();
        $order_status = [];
        foreach ($order_stuatusA as $val) {
            $order_status[$val['id']] = $val['order_status'];
        }
        $countryA = Country::get()->toArray();
        $countries = [];
        foreach ($countryA as $val) {
            $countries[$val['id']] = $val['name'];
        }
        $zoneA = Zone::get()->toArray();
        $zones = [];
        foreach ($zoneA as $val) {
            $zones[$val['id']] = $val['name'];
        }
        $flags = Flags::where('status', 1)->get()->toArray();
        $flag_status[0] = "Select Flag";
        foreach ($flags as $val) {
            $flag_status[$val['id']] = $val['flag'];
        }
        $courierId = HasCourier::where('status', 1)->where('store_id', $this->jsonString['store_id'])->pluck("courier_id");

        $courier = Courier::where('status', 1)->whereIn('id', $courierId)->get()->toArray();

        $courier_status = [];
        $courier_status[0] = "Select Courier";
        foreach ($courier as $val) {
            $courier_status[$val['id']] = $val['name'];
        }
        if ($order->prefix == Helper::getSettings()['prefix']) {
            Cart::instance("shopping")->destroy();
            $coupons = Coupon::whereDate('start_date', '<=', date("Y-m-d"))->where('end_date', '>=', date("Y-m-d"))->get();
            $additional = json_decode($order->additional_charge, true);
            $prodTab = $jsonString['prefix'] . '_products';
            $prods = HasProducts::where('order_id', Input::get("id"))->join($prodTab, $prodTab . '.id', '=', 'has_products.prod_id')->where("prefix", $this->jsonString['prefix'])
                            ->select($prodTab . ".*", 'has_products.order_id', 'has_products.disc', 'has_products.prod_id', 'has_products.qty', 'has_products.price as hasPrice', 'has_products.product_details', 'has_products.sub_prod_id')->get();

            // $prod_id = HasProducts::where('order_id', Input::get("id"))->join($prodTab,$prodTab.'id','=','has_prodducts.prod_id')->where("prefix",$this->jsonString['prefix']);
            $products = $prods;
            $coupon = Coupon::find($order->coupon_used);
            $action = route("admin.orders.save");
            // return view(Config('constants.adminOrderView') . '.addEdit', compact('order', 'action', 'payment_methods', 'payment_status', 'order_status', 'countries', 'zones', 'products', 'coupon')); //'users', 
            $viewname = Config('constants.adminPurcRequisitionView') . '.edit-purc-requisition';
            $data = ['order' => $order, 'action' => $action, 'payment_methods' => $payment_methods, 'payment_status' => $payment_status, 'order_status' => $order_status, 'countries' => $countries, 'zones' => $zones, 'products' => $products, 'coupon' => $coupon, 'coupons' => $coupons, 'flags' => $flag_status, 'courier' => $courier_status, 'additional' => $additional];
            return Helper::returnView($viewname, $data);
        } else {
            $products = HasProducts::where("order_status", "!=", 0)->where("order_id", Input::get('id'))->where('prefix', $jsonString['prefix'])->where('store_id', $jsonString['store_id'])->first();
            $action = route("admin.orders.mallOrderSave");
            $viewname = Config('constants.adminPurcRequisitionView') . '.edit-purc-requisition';
            // dd($orders);
            $data = ['order' => $order, 'action' => $action, 'order_status' => $order_status, 'countries' => $countries, 'zones' => $zones,
                'products' => $products, 'courier' => $courier_status];
            return Helper::returnView($viewname, $data);
        }
    }
}
