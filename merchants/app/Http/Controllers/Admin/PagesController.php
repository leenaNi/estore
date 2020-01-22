<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Session;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\HasProducts;
use App\Library\Helper;
use DB;
use Route;
use Input;
use Charts;
use Illuminate\Http\Request;

class PagesController extends Controller {

    public function index() {

        $jsonString = Helper::getSettings();

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

        $weeklySales = Order::whereRaw("WEEKOFYEAR(created_at) = '" . date('W') . "'")
        ->whereNotIn("order_status", [0, 4, 6, 10])->where('prefix', $this->jsonString['prefix'])
        ->sum('pay_amt');

        $weeklyOrderschart = Order::whereRaw("WEEKOFYEAR(created_at) = '" . date('W') . "'")->whereNotIn("order_status", [0, 4, 6, 10])->where('store_id',$this->jsonString['store_id'])->get();

        $weeklySaleschart = HasProducts::whereRaw("WEEKOFYEAR(created_at) = '" . date('W') . "'")
        ->whereNotIn("order_status", [0, 4, 6, 10])->where('store_id',$this->jsonString['store_id'])->get();
        //dd($weeklySaleschart);
        $monthlySales = Order::whereRaw("MONTH(created_at) = '" . date('m') . "'")
        ->whereNotIn("order_status", [0, 4, 6, 10])->where('prefix', $this->jsonString['prefix'])
        ->sum('pay_amt');

        $yearlySales = Order::whereRaw("YEAR(created_at) = '" . date('Y') . "'")
        ->whereNotIn("order_status", [0, 4, 6, 10])->where('prefix', $this->jsonString['prefix'])
        ->sum('pay_amt');

        $totalSales = HasProducts::whereNotIn("order_status", [0, 4, 6, 10])->where('prefix', $this->jsonString['prefix'])->sum('pay_amt');

        // $todaysOrders = HasProducts::whereRaw("DATE(created_at) = '" . date('Y-m-d') . "'")
        // ->whereNotIn("order_status", [0, 4, 6, 10])->where('prefix', $this->jsonString['prefix'])
        // ->count();

        $todaysOrders = Order::whereRaw("DATE(created_at) = '" . date('Y-m-d') . "'")->where("orders.store_id", $jsonString['store_id'])->count();

        // $weeklyOrders = HasProducts::whereRaw("WEEKOFYEAR(created_at) = '" . date('W') . "'")
        // ->whereNotIn("order_status", [0, 4, 6, 10])->where('prefix', $this->jsonString['prefix'])
        // ->count();

        $weeklyOrders = Order::whereRaw("WEEKOFYEAR(created_at) = '" . date('W') . "'")->where("orders.store_id", $jsonString['store_id'])->count();


        $monthlyOrders = Order::whereRaw("MONTH(created_at) = '" . date('m') . "'")->where("orders.store_id", $jsonString['store_id'])->count();


        $yearlyOrders = Order::whereRaw("YEAR(created_at) = '" . date('Y') . "'")->where("orders.store_id", $jsonString['store_id'])->count();

        // $totalOrders = HasProducts::whereNotIn("order_status", [0, 4, 6, 10])->where('prefix', $this->jsonString['prefix'])->count();

        $totalOrders = Order::where("orders.store_id", $jsonString['store_id'])->count();

        $topProducts = HasProducts::where('prefix', 'LIKE', "{$this->jsonString['prefix']}")->limit(5)->groupBy('prefix', 'prod_id')->orderBy('quantity', 'desc')->get(['prod_id', 'sub_prod_id', DB::raw('count(prod_id) as top'), DB::raw('sum(qty) as quantity')]);
        foreach ($topProducts as $prd) {
//            $mallProd = DB::connection('mysql2')->table('mall_products')->where('id', $prd->prod_id)->first();
            
            if($prd->prod_id == $prd->sub_prod_id || $prd->sub_prod_id=='')
            {
                $prod = Product::find($prd->prod_id);
            }else{
                $prod = Product::find($prd->sub_prod_id);
            }
            $parentprod = Product::find($prd->prod_id);
            $prd->product = $prod;
            if (!empty($prod)) {
                $prd->product->selling_price = $parentprod->selling_price + $prod->price;
                $catImg = $parentprod->catalogimgs()->where("image_mode", 1)->first();
                if ($catImg) {
                    $prd->product->prodImage = (Config('constants.productImgPath') . '/' . $catImg->filename);
                } else {
                    $prd->product->prodImage = Config('constants.defaultImgPath') . '/default-product.jpg';
                }
            }
        }

        $topUsers = DB::connection('mysql2')->table('has_products')->join('orders', 'has_products.order_id', '=', 'orders.id')
        ->join('users', 'orders.user_id', '=', 'users.id')
        ->whereNotIn("has_products.order_status", [0, 4, 6, 10])->where('has_products.prefix', $this->jsonString['prefix'])
        ->limit(10)->groupBy('orders.user_id')
        ->orderBy('total_amount', 'desc')->get(['orders.user_id', 'users.firstname', 'users.lastname', 'users.email', DB::raw('count(orders.user_id) as top'), DB::raw('sum(orders.pay_amt) as total_amount')]);

        // dd($jsonString["store_id"]);
       $latestOrders = Order::where("orders.store_id", $jsonString['store_id'])->orderBy("orders.created_at", "desc")->join("payment_method as pm", "pm.id", '=', 'orders.payment_method')->join("order_status as os", "os.id", '=', 'orders.order_status')->join("payment_status as ps", "ps.id", '=', 'orders.payment_status')->select(["orders.id as order_id","orders.created_at as order_date","orders.first_name","orders.last_name","os.order_status","pm.name as payment_method","ps.payment_status","orders.pay_amt as total_amount","orders.order_amt as amount","orders.email","orders.gifting_charges","orders.discount_amt","orders.shipping_amt","orders.referal_code_amt","orders.phone_no","orders.coupon_amt_used"])->limit(10)->orderBy('orders.created_at', 'desc')->get();

        $latestUsers = User::where('user_type', 2)->limit(5)->orderBy('created_at', 'desc')->get();
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

      $items = [];
      $products = [];
        foreach($topUsers as $key=> $user)
          {
           $items[$key]["total"] = $user->total_amount;
           $items[$key]['customer_name'] = $user->firstname." ".$user->lastname;
           $items[$key]['color'] = '#'.$this->random_color_part() . $this->random_color_part() . $this->random_color_part();
           }
        $chart_prodname = array();   
       foreach($topProducts as $key => $product)
       {
            if($product->prod_id == $product->sub_prod_id || $prd->sub_prod_id=='')
            {
                $parentprod = Product::find($product->prod_id);
                $product->product->price += $parentprod->selling_price;
            }
            $products[$key]["product_name"] = $product->product;
            $products[$key]["quantity"] = $product->quantity;
            $products[$key]['color'] = '#'.$this->random_color_part() . $this->random_color_part() . $this->random_color_part();
            $chart_prodname[] = $product->quantity;
         }
        
        $orders_chart = Charts::database($weeklyOrderschart, 'line', 'highcharts')
                  ->title("Weekly Orders : ".count($weeklyOrderschart))
                  ->elementLabel("Orders")
                  ->dimensions(460, 500)
                  ->responsive(false)
                  //->groupByMonth(date('Y'), true);
                  ->groupByDay();

        $Sales_chart = Charts::database($weeklySaleschart, 'line', 'highcharts')
                  ->title("Weekly Sales : ".count($weeklySaleschart))
                  ->elementLabel("Total Sales")
                  ->dimensions(460, 500)
                  ->responsive(false)
                  ->groupByDay();
                  //->groupByMonth(date('Y'), true);
        

    return view(Config('constants.adminView') . '.dashboard', compact('userCount', 'userThisWeekCount', 'userThisMonthCount', 'userThisYearCount', 'todaysSales', 'weeklySales', 'monthlySales', 'yearlySales', 'totalSales', 'todaysOrders', 'weeklyOrders', 'monthlyOrders', 'yearlyOrders', 'totalOrders', 'topProducts', 'topUsers', 'latestOrders', 'latestUsers', 'latestProducts', 'salesGraph', 'orderGraph','items','products','orders_chart','Sales_chart'));
}

public function orderStat()
{
    $jsonString = Helper::getSettings();
    $startdate = Input::get('startdate');
    $enddate = Input::get('enddate');
    $date = date('Y-m-d');
    if($startdate == $enddate){
        $Orders = Order::whereDate('created_at','=',$startdate)->whereNotIn("order_status", [0, 4, 6, 10])->where('store_id',$this->jsonString['store_id'])->get();
    }else{
        $Orders = Order::whereDate('created_at','>=',$startdate)->whereDate('created_at','<=',$enddate)->whereNotIn("order_status", [0, 4, 6, 10])->where('store_id',$this->jsonString['store_id'])->get();
    }
    
    $orders_chart = Charts::database($Orders, 'line', 'highcharts')
                  ->title("Total Orders : ".count($Orders))
                  ->elementLabel("Orders")
                  ->dimensions(460, 500)
                  ->responsive(false)
                  ->groupByDay();
      $html = '';
      $html .= '<div id="ordersChart">';
                    echo $orders_chart->html();
                    echo $orders_chart->script();
    $html .=    '</div>';
    return $html;
    // $orderDates = explode(' - ',Input::get('orderDate'));
    // $weekDate = date('Y-m-d', strtotime('-7 days', strtotime($orderDates[1])));
    // $orderGraph = array();
    // $orderGraph0 = HasProducts::whereNotIn("order_status", [0, 4, 6, 10])->where('prefix', $this->jsonString['prefix'])->orderBy('created_at', 'asc')->where('created_at', '>=', date('Y-m-d', strtotime($orderDates[0])))->where('created_at', '<=', date('Y-m-d', strtotime($orderDates[1])))->groupBy(DB::raw("DATE(created_at)"))->get(['created_at', DB::raw('count(distinct(order_id)) as total_order')])->toArray();
    //     for ($i = 8; $i > 0; $i--) {
    //         array_push($orderGraph, array('created_at' => $weekDate, 'total_order' => 0));
    //         $weekDate = date('Y-m-d', strtotime('+1 day', strtotime($weekDate)));
           
    //     } 
    //     foreach ($orderGraph as $key => $order) {
    //         foreach ($orderGraph0 as $ord) {
    //             if (date('Y-m-d', strtotime($ord['created_at'])) == $order['created_at']) {
    //                 $orderGraph[$key]['created_at'] = $ord['created_at'];
    //                 $orderGraph[$key]['total_order'] = $ord['total_order'];
    //             }
    //         }
    //     }
 
    //     $orderdata = '[';
    // foreach ($orderGraph as $order) {
    //     $orderdata .= '["' . date('d M', strtotime($order['created_at'])) . '",' . $order['total_order'] . '],';
    // }
    // $orderdata .= ']';

    //     return $orderdata;
   
}
public function salesStat()
{
    $jsonString = Helper::getSettings();
    $startdate = Input::get('startdate');
    $enddate = Input::get('enddate');
    if($startdate == $enddate){
        $Sales = HasProducts::whereDate('created_at','=',$startdate)->whereNotIn("order_status", [0, 4, 6, 10])->where('store_id',$this->jsonString['store_id'])->get();
    }else{
        $Sales = HasProducts::whereDate('created_at','>=',$startdate)->whereDate('created_at','<=',$enddate)->whereNotIn("order_status", [0, 4, 6, 10])->where('store_id',$this->jsonString['store_id'])->get();
    }

    $Sales_chart = Charts::database($Sales, 'line', 'highcharts')
                  ->title("Total Sales : ".count($Sales))
                  ->elementLabel("Sales")
                  ->dimensions(460, 500)
                  ->responsive(false)
                  ->groupByDay();
                  // ->groupByMonth(date('Y'), true);
      $html = '';
      $html .= '<div id="SalesChart">';
                    echo $Sales_chart->html();
                    echo $Sales_chart->script();
    $html .=    '</div>';
    return $html;
    // $saleDates = explode(' - ',Input::get('saleDate'));
    // $weekDate = date('Y-m-d', strtotime('-7 days', strtotime($saleDates[1])));
    // $saleGraph = array();
    // $saleDates = explode(' - ', Input::get('saleDate'));
    // $salesGraph0 = HasProducts::whereNotIn("order_status", [0, 4, 6, 10])->where('prefix', $this->jsonString['prefix'])->orderBy('created_at', 'asc')->where('created_at', '>=', date('Y-m-d', strtotime($saleDates[0])))->where('created_at', '<=', date('Y-m-d', strtotime($saleDates[1])))->groupBy(DB::raw("DATE(created_at)"))->get(['created_at', DB::raw('sum(pay_amt) as total_amount')])->toArray();   
    //     for ($i = 8; $i > 0; $i--) {
    //          array_push($salesGraph, array('created_at' => $weekDate, 'total_amount' => 0));
    //         $weekDate = date('Y-m-d', strtotime('+1 day', strtotime($weekDate)));
           
    //     } 
    //     foreach ($saleGraph as $key => $order) {
    //         foreach ($saleGraph0 as $ord) {
    //             if (date('Y-m-d', strtotime($ord['created_at'])) == $order['created_at']) {
    //                 $saleGraph[$key]['created_at'] = $ord['created_at'];
    //                 $saleGraph[$key]['total_order'] = $ord['total_order'];
    //             }
    //         }
    //     }
 
    //     $saleGraph = '[';
    // foreach ($saleGraph as $order) {
    //     $saleGraph .= '["' . date('d M', strtotime($order['created_at'])) . '",' . $order['total_order'] . '],';
    // }
    // $saledata .= ']';

    //     return $saledata;

}
 public  function random_color_part() {
    return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
    }

public function pages() {
    $routes = Route::getRoutes();
    return view(Config('constants.adminView') . '.pages', compact('routes'));
}

}
