<?php

namespace App\Http\Controllers\Admin;

use Route;
use Input;
use App\Models\Product;
use App\Models\Order;
use App\Models\HasProducts;
use App\Models\Finish;
use App\Models\Fabric;
use App\Models\Category;
use App\Models\ProductType;
use App\Models\AttributeSet;
use App\Models\CatalogImage;
use App\Models\Attribute;
use App\Models\Conversion;
use App\Models\AttributeValue;
use App\Http\Controllers\Controller;
use DB;
use App\Models\User;
use Session;
use App\Library\Helper;
use App\Models\OrderStatus;
use App\Models\PaymentMethod;
use App\Models\PaymentStatus;

class ApiSalesController extends Controller {

    public function order() {
        // dd(DB::getTablePrefix());
        $where = '';
        if (!empty(Input::get('month'))) {
            $select = "DATE_FORMAT(created_at, '%M %Y') as created_at";
            $groupby = "group by MONTH(created_at)";
        } else if (!empty(Input::get('year'))) {
            $select = "YEAR(created_at) as created_at";
            $groupby = "group by YEAR(created_at)";
        } else if (!empty(Input::get('week'))) {
            $select = "CONCAT(WEEK(created_at),' ', YEAR(created_at) ) as created_at";
            $groupby = "group by CONCAT(WEEK(created_at),' ', YEAR(created_at) )";
        } else {
            $select = "DATE_FORMAT(created_at, '%d %b %Y') as created_at";
            $groupby = "group by DATE(created_at)";
        }
        // if (!empty(Input::get('dateSearch'))) {
        $toDate = date('Y-m-d', strtotime(Input::get('to_date')));
        $fromDate = date('Y-m-d', strtotime(Input::get('from_date')));
        $where = "where ord.created_at between '$fromDate 00:00:00' and '$toDate  23:59:59' and ord.order_status NOT IN(0,4,6,10)";
//        } else {
//            $where = "where ord.order_status NOT IN(0,4,6,10)";
//        }

        $order = DB::select(DB::raw("SELECT ord.id AS orderId, SUM( ord.pay_amt ) AS sales, COUNT( hp.prod_id )  as prdCount"
                                . " from " . DB::getTablePrefix() . "orders as ord inner join " . DB::getTablePrefix() . "has_products as hp on(ord.id = hp.order_id) $where group by hp.order_id"));
        //   dd(count($order));
        $salesTotal = 0;
        $ordProdTot = 0;
        foreach ($order as $orderval) {
            $salesTotal += $orderval->sales;
            $ordProdTot += $orderval->prdCount;
        }

        return $data = ['order' => count($order),'salesTotal'=>$salesTotal,'ordProdTot'=>$ordProdTot];
    }

    public function bycustomer() {
        $where = ['user_type' => '2'];
        if (!empty(Input::get('search_name'))) {
            $where['users.firstname'] = Input::get('search_name');
        }
        if (!empty(Input::get('search_email'))) {
            $where['users.email'] = Input::get('search_email');
        }
        if (!empty(Input::get('search_number'))) {
            $where['users.telephone'] = Input::get('search_number');
        }

        $newusers = User::where($where)->where(DB::raw('DATE(created_at)'), '>=', date('Y-m-d', strtotime("now -10 days")))->select(DB::raw('count(id) as newOrdCount'))->get();
        $oldusers = User::where($where)->select(DB::raw('count(id) as oldOrdCount'))->get();
        $newrevenue = DB::table('orders')->join('users', 'orders.user_id', '=', 'users.id')
                        ->where(DB::raw('DATE(users.created_at)'), '>=', date('Y-m-d', strtotime("now -10 days")))
                        ->select(DB::raw('sum(pay_amt) as newPayAmt'))->get();
        //dd($newrevenue);
        $oldrevenue = DB::table('orders')->select(DB::raw('sum(pay_amt) as oldpayAmt'))->whereNotIn('order_status',[4,0,10])->get();
        $cashRevenue = DB::table('orders')->select(DB::raw('sum(pay_amt) as cashpayAmt'))->whereNotIn('order_status',[4,0,10])->where('orders.payment_method',1)->get();
        $cardRevenue = DB::table('orders')->select(DB::raw('sum(pay_amt) as cardpayAmt'))->whereNotIn('order_status',[4,0,10])->where('orders.payment_method',"!=",1)->get();
        $creditRevenue = DB::table('orders')->select(DB::raw('sum(pay_amt) as creditpayAmt'))->where('order_status','!=',0)->where('orders.payment_method',8)->get();
        return $data = ['cashRevenue' => $cashRevenue,'cardRevenue' => $cardRevenue,'creditRevenue' => $creditRevenue,'newusers' => $newusers, 'oldusers' => $oldusers, 'newrevenue' => $newrevenue, 'oldrevenue' => $oldrevenue];
    }

}
