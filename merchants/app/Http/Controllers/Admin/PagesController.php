<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Session;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\HasProducts;
use DB;
use Route;

class PagesController extends Controller {

    public function index() {
        $current_week_start = Date('Y-m-d', strtotime('previous monday'));
        $current_week_end = Date('Y-m-d', strtotime('next sunday'));
        $current_month['start'] = Date('Y-m-01');
        $current_month['end'] = Date('Y-m-t');
        $current_year['start'] = Date('Y-01-01');
        $current_year['end'] = Date('Y-m-d');
        $userCount = User::where("user_type", "=", 2)->count();
        $userThisWeekCount = User::where("user_type", "=", 2)->where('created_at', '>=', $current_week_start)->where('created_at', '<=', $current_week_end)->count();
        $userThisMonthCount = User::where("user_type", "=", 2)->where('created_at', '>=', $current_month['start'])->where('created_at', '<=', $current_month['end'])->count();
        $userThisYearCount = User::where("user_type", "=", 2)->where('created_at', '>=', $current_year['start'])->where('created_at', '<=', $current_year['end'])->count();

        $todaysSales = Order::whereRaw("DATE(created_at) = '" . date('Y-m-d') . "'")
                ->whereNotIn("order_status", [0, 4, 6, 10])->where('prefix', $this->jsonString['prefix'])
                ->sum('pay_amt');

        $weeklySales = HasProducts::whereRaw("WEEKOFYEAR(created_at) = '" . date('W') . "'")
                ->whereNotIn("order_status", [0, 4, 6, 10])->where('prefix', $this->jsonString['prefix'])
                ->sum('pay_amt');

        $monthlySales = HasProducts::whereRaw("MONTH(created_at) = '" . date('m') . "'")
                ->whereNotIn("order_status", [0, 4, 6, 10])->where('prefix', $this->jsonString['prefix'])
                ->sum('pay_amt');

        $yearlySales = HasProducts::whereRaw("YEAR(created_at) = '" . date('Y') . "'")
                ->whereNotIn("order_status", [0, 4, 6, 10])->where('prefix', $this->jsonString['prefix'])
                ->sum('pay_amt');

        $totalSales = HasProducts::whereNotIn("order_status", [0, 4, 6, 10])->where('prefix', $this->jsonString['prefix'])->sum('pay_amt');

        $todaysOrders = HasProducts::whereRaw("DATE(created_at) = '" . date('Y-m-d') . "'")
                ->whereNotIn("order_status", [0, 4, 6, 10])->where('prefix', $this->jsonString['prefix'])
                ->count();

        $weeklyOrders = HasProducts::whereRaw("WEEKOFYEAR(created_at) = '" . date('W') . "'")
                ->whereNotIn("order_status", [0, 4, 6, 10])->where('prefix', $this->jsonString['prefix'])
                ->count();

        $monthlyOrders = HasProducts::whereRaw("MONTH(created_at) = '" . date('m') . "'")
                ->whereNotIn("order_status", [0, 4, 6, 10])->where('prefix', $this->jsonString['prefix'])
                ->count();

        $yearlyOrders = HasProducts::whereRaw("YEAR(created_at) = '" . date('Y') . "'")
                ->whereNotIn("order_status", [0, 4, 6, 10])->where('prefix', $this->jsonString['prefix'])
                ->count();

        $totalOrders = HasProducts::whereNotIn("order_status", [0, 4, 6, 10])->where('prefix', $this->jsonString['prefix'])->count();
        $topProducts = HasProducts::where('prefix', $this->jsonString['prefix'])->limit(5)->groupBy('prod_id')->orderBy('quantity', 'desc')->get(['prod_id', DB::raw('count(prod_id) as top'), DB::raw('sum(qty) as quantity')]);
        foreach ($topProducts as $prd) {
            $prod = DB::table('products')->where('id', $prd->prod_id)->first();
            $prd->product = $prod;
            if (!empty($prod)) {
                $catImg = DB::table('catalog_images')->where('catalog_id', $prod->id)->where("image_mode", 1)->first();
                if ($catImg) {
                    $prd->product->prodImage = (Config('constants.productImgPath') . '/' . $catImg->filename);
                } else {
                    $prd->product->prodImage = Config('constants.defaultImgPath') . '/default-product.jpg';
                }
            }
        }
        dd($topProducts);

//        $topUsers = Orders::whereNotIn("order_status", [0, 4, 6, 10])->where('prefix', $this->jsonString['prefix'])->with('users')
//                        ->limit(10)->groupBy('orders.user_id')->orderBy('total_amount', 'desc')->get(['orders.user_id', DB::raw('count(orders.user_id) as top'), DB::raw('sum(pay_amt) as total_amount')]);

        $topUsers = DB::connection('mysql2')->table('has_products')->join('orders', 'has_products.order_id', '=', 'orders.id')
                        ->join('users', 'orders.user_id', '=', 'users.id')
                        ->whereNotIn("has_products.order_status", [0, 4, 6, 10])->where('has_products.prefix', $this->jsonString['prefix'])
                        ->limit(10)->groupBy('orders.user_id')
                        ->orderBy('total_amount', 'desc')->get(['orders.user_id', 'users.firstname', 'users.lastname', 'users.email', DB::raw('count(orders.user_id) as top'), DB::raw('sum(has_products.pay_amt) as total_amount')]);

        $latestOrders = HasProducts::whereNotIn('order_status', [3, 4, 5, 6, 10])->where('prefix', $this->jsonString['prefix'])->with(['orderDetails' => function($q) { return $q->with(['users', 'orderstatus', 'paymentstatus']); } ])->limit(10)->orderBy('created_at', 'desc')->get();
//        dd($latestOrders);
        $latestUsers = User::where('user_type', 2)->limit(10)->orderBy('created_at', 'desc')->get();
        $latestProducts = Product::where('is_individual', '1')->limit(5)->orderBy('created_at', 'desc')->get();
        foreach ($latestProducts as $prd) {
            $catImg = $prd->catalogimgs()->where("image_mode", 1)->first();
            if ($catImg) {
                $prd->prodImage = (Config('constants.productImgPath') . '/' . $catImg->filename);
            } else {
                $prd->prodImage = Config('constants.defaultImgPath') . '/default-product.jpg';
            }
        }
        $salesGraph0 = HasProducts::whereNotIn("order_status", [0, 4, 6, 10])->where('prefix', $this->jsonString['prefix'])->orderBy('created_at', 'asc')->where('created_at', '>=', date('Y-m-d', strtotime("-7 day")))->groupBy(DB::raw("DATE(created_at)"))->get(['created_at', DB::raw('sum(pay_amt) as total_amount')])->toArray();
        $orderGraph0 = HasProducts::whereNotIn("order_status", [0, 4, 6, 10])->where('prefix', $this->jsonString['prefix'])->orderBy('created_at', 'asc')->where('created_at', '>=', date('Y-m-d', strtotime("-7 day")))->groupBy(DB::raw("DATE(created_at)"))->get(['created_at', DB::raw('count(distinct(order_id)) as total_order')])->toArray();
        $weekDate = date('Y-m-d', strtotime("-7 day"));
        $salesGraph = array();
        $orderGraph = array();
        for ($i = 8; $i > 0; $i--) {
            array_push($salesGraph, array('created_at' => $weekDate, 'total_amount' => 0));
            array_push($orderGraph, array('created_at' => $weekDate, 'total_order' => 0));
            $weekDate = date('Y-m-d', strtotime('+1 day', strtotime($weekDate)));
        }
        foreach ($salesGraph as $key => $sale) {
            foreach ($salesGraph0 as $s0) {
                if (date('Y-m-d', strtotime($s0['created_at'])) == $sale['created_at']) {
                    $salesGraph[$key]['created_at'] = $s0['created_at'];
                    $salesGraph[$key]['total_amount'] = round($s0['total_amount'] * Session::get('currency_val'));
                }
            }
        }
        foreach ($orderGraph as $key => $order) {
            foreach ($orderGraph0 as $ord) {
                if (date('Y-m-d', strtotime($ord['created_at'])) == $order['created_at']) {
                    $orderGraph[$key]['created_at'] = $ord['created_at'];
                    $orderGraph[$key]['total_order'] = $ord['total_order'];
                }
            }
        }
        return view(Config('constants.adminView') . '.dashboard', compact('userCount', 'userThisWeekCount', 'userThisMonthCount', 'userThisYearCount', 'todaysSales', 'weeklySales', 'monthlySales', 'yearlySales', 'totalSales', 'todaysOrders', 'weeklyOrders', 'monthlyOrders', 'yearlyOrders', 'totalOrders', 'topProducts', 'topUsers', 'latestOrders', 'latestUsers', 'latestProducts', 'salesGraph', 'orderGraph'));
    }

    public function pages() {
        $routes = Route::getRoutes();
        return view(Config('constants.adminView') . '.pages', compact('routes'));
    }

}
