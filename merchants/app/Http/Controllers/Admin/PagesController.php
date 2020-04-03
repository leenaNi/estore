<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Library\Helper;
use App\Models\HasProducts;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Charts;
use DB;
use Input;
use Route;
use Session;

class PagesController extends Controller
{

    public function index()
    {

        $jsonString = Helper::getSettings();
        //dd($jsonString);
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


        //$weeklyAvgbillchart = Order::whereRaw("WEEKOFYEAR(created_at) = '" . date('W') . "'")->whereNotIn("order_status", [0, 4, 6, 10])->where('store_id', $this->jsonString['store_id'])->get();

        //dd($weeklyAvgbillchart);
        //lost customer
        $monday = strtotime("last monday");
        $monday = date('W', $monday)==date('W') ? $monday-7*86400 : $monday;
         
        $sunday = strtotime(date("Y-m-d",$monday)." +6 days");
        $this_week_sd = date("Y-m-d",$monday);
        $this_week_ed = date("Y-m-d",$sunday); 



        $ordercurrentweek = Order::whereRaw("WEEKOFYEAR(created_at) = '" . date('W') . "'")->whereNotIn("order_status", [0, 4, 6, 10])->where('store_id', $this->jsonString['store_id'])->groupBy('user_id')->pluck('user_id')->toArray();

       
       $orderlastweek = Order::whereBetween('created_at', [$this_week_sd, $this_week_ed])->whereNotIn("order_status", [0, 4, 6, 10])->where('store_id', $this->jsonString['store_id'])->pluck('user_id')->toArray();

       $date = strtotime("-8 day");
       $finaldate = date('Y-m-d', $date);

       $orderlasttolastweek = Order::whereDate('created_at', '<=', $finaldate)->whereNotIn("order_status", [0, 4, 6, 10])->where('store_id', $this->jsonString['store_id'])->groupBy('user_id')->pluck('user_id')->toArray();

       $returningcustomer = Order::join('users', 'orders.user_id', '=', 'users.id')->whereRaw("WEEKOFYEAR(orders.created_at) = '" . date('W') . "'")->whereNotIn("orders.user_id", $orderlastweek)->whereIn("orders.user_id", $orderlasttolastweek)->whereIn("orders.user_id", $ordercurrentweek)->where('orders.store_id', $this->jsonString['store_id'])->get(['orders.user_id','orders.created_at','orders.pay_amt', 'users.firstname', 'users.lastname', 'users.email']);

        //dd($returningcustomer);
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

            if ($prd->prod_id == $prd->sub_prod_id || $prd->sub_prod_id == '') {
                $prod = Product::find($prd->prod_id);
            } else {
                $prod = Product::find($prd->sub_prod_id);
            }
            $parentprod = Product::find($prd->prod_id);
            $prd->product = $prod;
            if (!empty($prod) && $parentprod != null) {
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
        $latestOrders = Order::where("orders.store_id", $jsonString['store_id'])->orderBy("orders.created_at", "desc")->join("payment_method as pm", "pm.id", '=', 'orders.payment_method')->join("order_status as os", "os.id", '=', 'orders.order_status')->join("payment_status as ps", "ps.id", '=', 'orders.payment_status')->select(["orders.id as order_id", "orders.created_at as order_date", "orders.first_name", "orders.last_name", "os.order_status", "pm.name as payment_method", "ps.payment_status", "orders.pay_amt as total_amount", "orders.order_amt as amount", "orders.email", "orders.gifting_charges", "orders.discount_amt", "orders.shipping_amt", "orders.referal_code_amt", "orders.phone_no", "orders.coupon_amt_used"])->limit(10)->orderBy('orders.created_at', 'desc')->get();

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
        foreach ($topUsers as $key => $user) {
            $items[$key]["total"] = $user->total_amount;
            $items[$key]['customer_name'] = $user->firstname . " " . $user->lastname;
            $items[$key]['color'] = '#' . $this->random_color_part() . $this->random_color_part() . $this->random_color_part();
        }

        //returning customer
        $returncust = [];
        foreach ($returningcustomer as $key => $user) {
            $returncust[$key]["total"] = $user->pay_amt;
            $returncust[$key]['customer_name'] = $user->firstname . " " . $user->lastname;
            $returncust[$key]['color'] = '#' . $this->random_color_part() . $this->random_color_part() . $this->random_color_part();
        }



        $bill = Order::whereRaw("WEEKOFYEAR(created_at) = '" . date('W') . "'")->whereNotIn("order_status", [0, 4, 6, 10])->where('store_id', $this->jsonString['store_id'])->select(DB::raw('round(AVG(pay_amt),0) as avgamt'))->get();

        $billamount = [];
        foreach ($bill as $key => $value) {
            $billamount[$key]["total"] = $value->avgamt;
            $billamount[$key]['customer_name'] = 'Average Bill';
            $billamount[$key]['color'] = '#' . $this->random_color_part() . $this->random_color_part() . $this->random_color_part();
        }



        $chart_prodname = array();
        foreach ($topProducts as $key => $product) {
            // if ($product->prod_id == $product->sub_prod_id || $prd->sub_prod_id == '') {
                if ($product->prod_id == $product->sub_prod_id || $product->sub_prod_id == '') {
                    $parentprod = Product::find($prd->prod_id);
                } else if($product->sub_prod_id != '') {
                    $parentprod = Product::find($prd->sub_prod_id);
                }
                // dd($product->product);
                if ($parentprod != null) {
                    // $product->product->price = $product->product->price + @$parentprod->selling_price;
                    $product->product->actualPrice = $product->product->price + $parentprod->selling_price;
                }
            // }
            $products[$key]["product_name"] = $product->product;
            $products[$key]["quantity"] = $product->quantity;
            $products[$key]['color'] = '#' . $this->random_color_part() . $this->random_color_part() . $this->random_color_part();
            $chart_prodname[] = $product->quantity;
        }
        //charts
        $today = date('Y-m-d');
        $ts = strtotime($today);
        $start = (date('w', $ts) == 0) ? $ts : strtotime('last sunday', $ts);
        $start_date = date('Y-m-d', $start);
        $end_date = date('Y-m-d', strtotime('next saturday', $start));
        
        $Date_range = $this->getDatesFromRange($start_date,$end_date);
        foreach($Date_range as $date){
            //order statistics
            $ordersData = DB::table('orders')->whereDate('created_at',$date)->where('store_id', $this->jsonString['store_id'])->get();
            //online vs walkin 
            $onlineOrders = DB::table('orders')->whereDate('created_at',$date)->where('store_id', $this->jsonString['store_id'])->where('created_by',0)->get();
            $walkinOrders = DB::table('orders')->whereDate('created_at',$date)->where('store_id', $this->jsonString['store_id'])->where('created_by','!=',0)->get();
            // sales statistics
            $orderedProds = DB::table('has_products')->whereDate('created_at',$date)->where('store_id', $this->jsonString['store_id'])->groupBy('prod_id')->get([DB::raw('sum(qty) as quantity')]);
            //new custommer
            $Customers = DB::table("users")->whereDate('created_at',$date)
            ->where('user_type', 2)->where('store_id', $this->jsonString['store_id'])->get();
            //customer visited query
            $userid = Order::where('store_id', $this->jsonString['store_id'])->whereDate('created_at',$date)->pluck('user_id')->toArray();
            $weeklyvCustchart = DB::table('users')->where('store_id', $this->jsonString['store_id'])->whereIn('id', $userid)->where('user_type', 2)->get();
            //customer not visited
            $weeklynvCust = DB::table('users')->where('store_id', $this->jsonString['store_id'])->whereNotIn('id', $userid)->where('user_type', 2)->get();

            $monday = strtotime("last monday");
            $monday = date('W', $monday)==date('W') ? $monday-7*86400 : $monday;
             
            $sunday = strtotime(date("Y-m-d",$monday)." +6 days");
            $this_week_sd = date("Y-m-d",$monday);
            $this_week_ed = date("Y-m-d",$sunday); 
            $ordercurrentweek = Order::whereRaw("WEEKOFYEAR(created_at) = '" . date('W') . "'")->whereNotIn("order_status", [0, 4, 6, 10])->where('store_id', $this->jsonString['store_id'])->groupBy('user_id')->pluck('user_id')->toArray();
            //dd($ordercurrentweek);
            $lostcustomer = Order::whereBetween('created_at', [$this_week_sd, $this_week_ed])->whereNotIn("user_id", $ordercurrentweek)->where('store_id', $this->jsonString['store_id'])->groupBy('user_id')->get();







            $prod_qty = 0;
            if(count($orderedProds)>0){
                $prod_qty = $orderedProds[0]->quantity;
            }
            
            $orderCount[] = count($ordersData);
            $prodCount[] = $prod_qty;
            $onlineOrdersCount[] = count($onlineOrders);
            $walkinOrdersCount[] = count($walkinOrders);
            $newCustomersCount[] = count($Customers);
            $visitedCustomersCount[] = count($weeklyvCustchart);
            $nvCustomersCount[] = count($weeklynvCust);
            $lostcustomerCount[] = count($lostcustomer);
        }
        //orders statistics chart
        $orders_chart  = Charts::create('bar', 'highcharts')
                    ->title('Weekly Orders : '.array_sum($orderCount))
                    ->elementLabel("Orders")
                    ->labels($Date_range)
				    ->values($orderCount)
				    ->dimensions(460,500)
                    ->responsive(false);

        //Sales statistics chart
        $Sales_chart = Charts::create('line', 'highcharts')
            ->title("Weekly Sales : " . array_sum($prodCount))
            ->elementLabel("Sales")
            ->labels($Date_range)
            ->values($prodCount)
            ->dimensions(460, 500)
            ->responsive(false);
            //->groupByDay();
        
        //Top Sales Product
        $topProducts = HasProducts::where('prefix', 'LIKE', "{$this->jsonString['prefix']}")->limit(1)->groupBy('prefix', 'prod_id')->orderBy('quantity', 'desc')->get(['prod_id', 'sub_prod_id', DB::raw('count(prod_id) as top'), DB::raw('sum(qty) as quantity')]);
        if(count($topProducts) > 0){
            if($topProducts[0]->sub_prod_id != ''){
                $prodId = $topProducts[0]->sub_prod_id;
            }else{
                $prodId = $topProducts[0]->prod_id;
            }
        }
        $weeklyProdSaleschart = HasProducts::whereRaw("WEEKOFYEAR(created_at) = '" . date('W') . "'")
            ->where("prod_id", $prodId)->where('store_id', $this->jsonString['store_id'])->get();
            $qty = 0;$pay_amt=0;
        foreach($weeklyProdSaleschart as $prod){
            $qty += $prod->qty;
            $pay_amt += $prod->pay_amt;
        }
        $prodData = DB::table("products")->where('id',$prodId)->first();
        //Product Sales chart
        $product_sales_chart = Charts::database($weeklyProdSaleschart, 'bar','highcharts')
            ->title('Weekly Product Sales Rs.'.$pay_amt)
            ->elementLabel("Product Sales")
            ->dimensions(460, 500)
            ->responsive(false)
            //->groupByDay();
            ->groupByMonth(date('Y'), true);

        //Purchase vs sales
        //$purchase_inward = DB::table("productwise_inward_transaction")->
        $purchase_sales_chart = Charts::multi('areaspline', 'highcharts')
            ->title('Total Purchases : 10')
            ->colors(['#ff0000', '#ffffff'])
            ->labels($Date_range)
            ->dataset('Purchase', [3, 4, 3, 5, 4, 10, 12])
            ->dataset('Sales',  [1, 3, 4, 3, 3, 5, 4]);

        //Online VS Walk-in
        $online_walkin_chart = Charts::multi('bar', 'highcharts')
            ->title('Online : '.array_sum($onlineOrdersCount).' &  Walk-in : '.array_sum($walkinOrdersCount))
            ->elementLabel("Orders")
            ->colors(['#0873f9', '#e81362'])
            ->labels($Date_range)
            ->dataset('Online', $onlineOrdersCount)
            ->dataset('Walk-in', $walkinOrdersCount);

        $Newcustomer_chart = Charts::create('line', 'highcharts')
            ->title("Weekly New Customers : " . array_sum($newCustomersCount))
            ->elementLabel("New Customers")
            ->labels($Date_range)
            ->values($newCustomersCount)
            ->dimensions(460, 500)
            ->responsive(false);
            
        $Customernotvisited_chart = Charts::create('area', 'highcharts')
            ->title("Weekly Not Visited Customers : " . array_sum($nvCustomersCount))
            ->elementLabel("Not Visited Customers")
            ->dimensions(460, 500)
            ->labels($Date_range)
            ->values($nvCustomersCount)
            ->responsive(false);


        $Customervisited_chart = Charts::create('donut', 'highcharts')
            ->title("Weekly Visited Customers : " . array_sum($visitedCustomersCount))
            ->elementLabel("Visited Customers")
            ->labels($Date_range)
            ->values($visitedCustomersCount)
            ->dimensions(460, 500)
            ->responsive(false); 


        $Customerlost_chart = Charts::create('bar', 'highcharts')
            ->title("Weekly Customers Lost : " . array_sum($lostcustomerCount))
            ->elementLabel("Customers Lost")
            ->labels($Date_range)
            ->values($lostcustomerCount)
            ->dimensions(460, 500)
            ->responsive(false);
            
        // $Avgbill_chart = Charts::database($weeklyAvgbillchart, 'pie', 'highcharts')
        //     ->title("Weekly Average Order/Bill Size : " . count($weeklyAvgbillchart))
        //     ->elementLabel("Total Average Order/Bill Size")
        //     ->dimensions(460, 500)
        //     ->responsive(false)
        //     ->groupByDay();


       

      


        return view(Config('constants.adminView') . '.dashboard', compact('userCount', 'userThisWeekCount', 'userThisMonthCount', 'userThisYearCount', 'todaysSales', 'weeklySales', 'monthlySales', 'yearlySales', 'totalSales', 'todaysOrders', 'weeklyOrders', 'monthlyOrders', 'yearlyOrders', 'totalOrders', 'topProducts', 'topUsers', 'latestOrders', 'latestUsers', 'latestProducts', 'salesGraph', 'orderGraph', 'items', 'products', 'orders_chart', 'Sales_chart' ,'Newcustomer_chart','Customernotvisited_chart','Customervisited_chart','billamount','Customerlost_chart','product_sales_chart','returningcustomer','returncust','purchase_sales_chart','online_walkin_chart'));
        
    }

    function getDatesFromRange($start_date, $end_date, $format = 'Y-m-d') { 
      
       // Declare an empty array 
       $DateArray = array(); 
            
       // Use strtotime function 
       $Variable1 = strtotime($start_date); 
       $Variable2 = strtotime($end_date); 
       
       // Use for loop to store dates into array 
       // 86400 sec = 24 hrs = 60*60*24 = 1 day 
       for ($currentDate = $Variable1; $currentDate <= $Variable2;$currentDate += (86400)) { 
                                           
            $Store = date('Y-m-d', $currentDate); 
            $DateArray[] = $Store; 
        }
        // Return the array elements 
        return $DateArray; 
    } 

    public function orderStat()
    {
        $jsonString = Helper::getSettings();
        $startdate = Input::get('startdate');
        $enddate = Input::get('enddate');
        $Date_range = $this->getDatesFromRange($startdate,$enddate);

        foreach($Date_range as $date){
            $ordersData = DB::table('orders')->whereDate('created_at',$date)->where('store_id', $this->jsonString['store_id'])->get();
            $orderCount[] = count($ordersData);
        }
        $orders_chart  = Charts::create('bar', 'highcharts')
                    ->title('Weekly Orders : '.array_sum($orderCount))
                    ->elementLabel("Orders")
				    ->labels($Date_range)
				    ->values($orderCount)
				    ->dimensions(460,500)
                    ->responsive(false);

        $html = '';
        $html .= '<div id="ordersChart">';
        echo $orders_chart->html();
        echo $orders_chart->script();
        $html .= '</div>';
        return $html;
      
    }
    public function salesStat()
    {
        $jsonString = Helper::getSettings();
        $startdate = Input::get('startdate');
        $enddate = Input::get('enddate');
        $Date_range = $this->getDatesFromRange($startdate,$enddate);
        foreach($Date_range as $date){
            $orderedProds = DB::table('has_products')->whereDate('created_at',$date)->where('store_id', $this->jsonString['store_id'])->groupBy('prod_id')->get([DB::raw('sum(qty) as quantity')]);
            $prod_qty = 0;
            if(count($orderedProds)>0){
                $prod_qty = $orderedProds[0]->quantity;
            }
            
            $prodCount[] = $prod_qty;
        }
        
        $Sales_chart = Charts::create('line', 'highcharts')
            ->title("Total Sales : " .array_sum($prodCount))
            ->elementLabel("Sales")
            ->labels($Date_range)
			->values($prodCount)
            ->dimensions(460, 500)
            ->responsive(false);
            // ->groupByMonth(date('Y'), true);
        $html = '';
        $html .= '<div id="SalesChart">';
        echo $Sales_chart->html();
        echo $Sales_chart->script();
        $html .= '</div>';
        return $html;
        
    }

    public function prodSalesStat()
    {
        $jsonString = Helper::getSettings();
        $startdate = Input::get('startdate');
        $enddate = Input::get('enddate');
        $prod_id = Input::get('prod_id');
        $Date_range = $this->getDatesFromRange($startdate,$enddate);
        if($prod_id == 0){
            $topProducts = HasProducts::where('prefix', 'LIKE', "{$this->jsonString['prefix']}")->limit(1)->groupBy('prefix', 'prod_id')->orderBy('quantity', 'desc')->get(['prod_id', 'sub_prod_id', DB::raw('count(prod_id) as top'), DB::raw('sum(qty) as quantity')]);
            if(count($topProducts) > 0){
                if($topProducts[0]->sub_prod_id != ''){
                    $prodId = $topProducts[0]->sub_prod_id;
                }else{
                    $prodId = $topProducts[0]->prod_id;
                }
            }
        }else{
            $prodId = $prod_id;
        }$pay_amt = [];$qty= [];
        foreach($Date_range as $date){
            $ProdSales = DB::table("has_products")->whereDate('created_at',"'$date'")
                ->where("prod_id", $prodId)->where('store_id', $this->jsonString['store_id'])->get([DB::raw('sum(qty) as quantity'),DB::raw('sum(pay_amt) as amount')]);
                if(count($ProdSales) > 0){
                   
                    if(($ProdSales[0]->quantity) && ($ProdSales[0]->quantity != '')){
                        $qty[] = $ProdSales[0]->quantity;
                        $pay_amt[] = $ProdSales[0]->amount;
                    }else{
                        $qty[] = 0;
                        $pay_amt[] = 0; 
                    }
                }
                
        }
        
        $product_sales_chart = Charts::create('bar','highcharts')
            ->title('Product Sales Rs.'.array_sum($pay_amt))
            ->elementLabel("Product Sales")
            ->labels($Date_range)
			->values($qty)
            ->dimensions(460, 500)
            ->responsive(false);
           
        $html = '';
        $html .= '<div id="ProdSalesChart">';
        echo $product_sales_chart->html();
        echo $product_sales_chart->script();
        $html .= '</div>';
        return $html;

    }

    public function onlineVsWalkinStat()
    {
        $jsonString = Helper::getSettings();
        $startdate = Input::get('startdate');
        $enddate = Input::get('enddate');
        $Date_range = $this->getDatesFromRange($startdate,$enddate);

        foreach($Date_range as $date){
            $onlineOrders = DB::table('orders')->whereDate('created_at',$date)->where('store_id', $this->jsonString['store_id'])->where('created_by',0)->get();
            $walkinOrders = DB::table('orders')->whereDate('created_at',$date)->where('store_id', $this->jsonString['store_id'])->where('created_by','!=',0)->get();
            $onlineOrdersCount[] = count($onlineOrders);
            $walkinOrdersCount[] = count($walkinOrders);
        }
        $online_walkin_chart = Charts::multi('bar', 'highcharts')
            ->title('Online : '.array_sum($onlineOrdersCount).' &  Walk-in : '.array_sum($walkinOrdersCount))
            ->elementLabel("Orders")
            ->colors(['#0873f9', '#e81362'])
            ->labels($Date_range)
            ->dataset('Online', $onlineOrdersCount)
            ->dataset('Walk-in', $walkinOrdersCount);
        
        $html = '';
        $html .= '<div id="OnlinevsWalkinChart">';
        echo $online_walkin_chart->html();
        echo $online_walkin_chart->script();
        $html .= '</div>';
        return $html;
      
    }

    //new customer 
    public function customersStat()
    {
        $jsonString = Helper::getSettings();
        $startdate = Input::get('startdate');
        $enddate = Input::get('enddate');

        $Date_range = $this->getDatesFromRange($startdate,$enddate);

        foreach($Date_range as $date){
            $Customers = DB::table("users")->whereDate('created_at',$date)
            ->where('user_type', 2)->where('store_id', $this->jsonString['store_id'])->get();
            $CustomersCount[] = count($Customers);
        }
        $Newcustomer_chart  = Charts::create('line', 'highcharts')
                    ->title('Total New Customers : '.array_sum($CustomersCount))
                    ->elementLabel("New Customers")
				    ->labels($Date_range)
				    ->values($CustomersCount)
				    ->dimensions(460,500)
                    ->responsive(false);

        $html = '';
        $html .= '<div id="NewCustomerChart">';
        echo $Newcustomer_chart->html();
        echo $Newcustomer_chart->script();
        $html .= '</div>';
        return $html;

    }  

    //lost customer 
    public function customerslostStat()
    {
        $jsonString = Helper::getSettings();
        $startdate = Input::get('startdate');
        $enddate = Input::get('enddate');

        $Date_range = $this->getDatesFromRange($startdate,$enddate);

        // if ($startdate == $enddate) {
        //     dd(123);

        // } else {

        //     $ordercurrentweek = Order::whereRaw("WEEKOFYEAR(created_at) = '" . date('W') . "'")->whereNotIn("order_status", [0, 4, 6, 10])->where('store_id', $this->jsonString['store_id'])->pluck('user_id')->toArray();


        //      $lostcustomer = Order::whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate)->whereNotIn("user_id", $ordercurrentweek)->where('store_id', $this->jsonString['store_id'])->groupBy('user_id')->get();

        // }

        foreach($Date_range as $date){
           $ordercurrentweek = Order::whereRaw("WEEKOFYEAR(created_at) = '" . date('W') . "'")->whereNotIn("order_status", [0, 4, 6, 10])->where('store_id', $this->jsonString['store_id'])->pluck('user_id')->toArray();


            $lostcustomer = Order::whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate)->whereNotIn("user_id", $ordercurrentweek)->where('store_id', $this->jsonString['store_id'])->groupBy('user_id')->get();
            $CustomerslostCount[] = count($lostcustomer);
        }

         $Customerlost_chart  = Charts::create('line', 'highcharts')
                    ->title('Total Customers Lost : '.array_sum($CustomerslostCount))
                    ->elementLabel("Customers Lost")
                    ->labels($Date_range)
                    ->values($CustomerslostCount)
                    ->dimensions(460,500)
                    ->responsive(false);


        $html = '';
        $html .= '<div id="CustomerLostChart">';
        echo $Customerlost_chart->html();
        echo $Customerlost_chart->script();
        $html .= '</div>';
        return $html;

    }



    //new avgbill 
    public function avgBillStat()
    {
        $jsonString = Helper::getSettings();
        $startdate = Input::get('startdate');
        $enddate = Input::get('enddate');




        if ($startdate == $enddate) {

            $bill = Order::whereDate('created_at', '=', $startdate)->whereNotIn("order_status", [0, 4, 6, 10])->where('store_id', $this->jsonString['store_id'])->select(DB::raw('round(AVG(pay_amt),0) as avgamt'))->get();

        } else {

             $bill = Order::whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate)->whereNotIn("order_status", [0, 4, 6, 10])->where('store_id', $this->jsonString['store_id'])->select(DB::raw('round(AVG(pay_amt),0) as avgamt'))->get();
        }

        $billamount = [];
            foreach ($bill as $key => $value) {
                $billamount[$key]["total"] = $value->avgamt;
                $billamount[$key]['customer_name'] = 'Average Bill';
                $billamount[$key]['color'] = '#' . $this->random_color_part() . $this->random_color_part() . $this->random_color_part();
            }


        //$html = $billamount;
         //$html = ['billamount' => $billamount];

        $Values ='';
       foreach($billamount as $billamounts)
       {
        {
            $Values.='value:'.$billamounts["total"].',';
            $Values.='color:'.$billamounts["color"].',';
            $Values.='label:'.$billamounts["customer_name"].',';
        }
           
        }

         $html='var ctx2 = $("#mybill").get(0).getContext("2d")';
            $dataBill= '['.$Values.']';
        $html.='var piechartBills = new Chart(ctx2).Pie('.$dataBill.')';

         $data = ['value' => $billamounts["total"], 'color' => $billamounts["color"] , 'label' =>$billamounts["customer_name"] ];
        return $data;
    }

    //customer not visited   
    public function nvcustomersStat()
    {
        $jsonString = Helper::getSettings();
        $startdate = Input::get('startdate');
        $enddate = Input::get('enddate');


        if ($startdate == $enddate) {


            $userid = Order::where('store_id', $this->jsonString['store_id'])->whereDate('created_at', '=', $startdate)->pluck('user_id')->toArray();

            $Customers = DB::table('users')->where('store_id', $this->jsonString['store_id'])->whereNotIn('id', $userid)->where('user_type', 2)->get();

        } else {

            $userid = Order::where('store_id', $this->jsonString['store_id'])->whereDate('created_at', '>=', $startdate)->whereDate('created_at', '<=', $enddate)->pluck('user_id')->toArray();

            $Customers = DB::table('users')
            ->whereNotIn('id', $userid)
            ->where('user_type', 2)
            ->get();
        }

        $Customernotvisited_chart = Charts::database($Customers, 'line', 'highcharts')
            ->title("Total Not Visited Customers : " . count($Customers))
            ->elementLabel("Not Visite Customers")
            ->dimensions(460, 500)
            ->responsive(false)
            ->groupByDay();
        // ->groupByMonth(date('Y'), true);
        $html = '';
        $html .= '<div id="CustomernotVisitedChart">';
        echo $Customernotvisited_chart->html();
        echo $Customernotvisited_chart->script();
        $html .= '</div>';
        return $html;

    }

     //customer  visited   
    public function vcustomersStat()
    {
        $jsonString = Helper::getSettings();
        $startdate = Input::get('startdate');
        $enddate = Input::get('enddate');

        $Date_range = $this->getDatesFromRange($startdate,$enddate);

        foreach($Date_range as $date){
            $userid = Order::where('store_id', $this->jsonString['store_id'])->whereDate('created_at',$date)->pluck('user_id')->toArray();

            $visitedCust = DB::table('users')->where('store_id', $this->jsonString['store_id'])->whereIn('id', $userid)->where('user_type', 2)->get();
            $visitedCustomersCount[] = count($visitedCust);
        }

        $Customervisited_chart = Charts::create('donut', 'highcharts')
            ->title("Total Visited Customers : " . array_sum($visitedCustomersCount))
            ->elementLabel("Visited Customers")
            ->labels($Date_range)
            ->values($visitedCustomersCount)
            ->dimensions(460, 500)
            ->responsive(false);

        $html = '';
        $html .= '<div id="CustomerVisitedChart">';
        echo $Customervisited_chart->html();
        echo $Customervisited_chart->script();
        $html .= '</div>';
        return $html;

    }



    public function random_color_part()
    {
        return str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
    }

    public function pages()
    {
        $routes = Route::getRoutes();
        return view(Config('constants.adminView') . '.pages', compact('routes'));
    }

}
