<?php

namespace App\Http\Controllers\Admin;

use Route;
use Input;
use App\Models\Category;
use App\Library\Helper;
use App\Classes\UploadHandler;
use App\Http\Controllers\Controller;
use App\Models\CatalogImage;
use App\Models\Tax;
use App\Models\Product;
use App\Models\HasTaxes;
use App\Models\HasCurrency;
use App\Models\Vendor;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\User;
use App\Models\HasProducts;
use App\Models\OrderStatus;
use App\Models\PaymentMethod;
use App\Models\PaymentStatus;
use App\Models\Flags;
use App\Models\HasVendors;
use App\Models\GeneralSetting;
use App\Models\ProductType;
use App\Models\AttributeSet;
use App\Models\Order;
use Hash;
use DB;
use Session;
use Auth;

class VendorsController extends Controller {

    public function index() {
        $vendors = User::where('user_type', 3)->where('status', 1)->orderBy('created_at', 'DESC');
        if (!empty(Input::get('search'))) {
            $vendors->where('firstname', 'like', '%' . Input::get('search') . '%');
            $vendors->orwhere('email', 'like', '%' . Input::get('search') . '%');
            $vendors->orwhere('telephone', 'like', '%' . Input::get('search') . '%');
        }
        $vendorsCount = $vendors->count();
        $vendors = $vendors->paginate(Config('constants.paginateNo'));

        return view(Config('constants.adminVendorView') . '.index', compact('vendors', 'vendorsCount'));
    }

    public function vendorDashboard(){
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
        //dd(Auth::user()->id);
        $todaysSales = HasProducts::whereRaw("DATE(created_at) = '" . date('Y-m-d') . "'")
                ->whereNotIn("order_status", [0, 4, 6, 10])
                ->where('vendor_id', Auth::user()->id)
                ->sum('price');
                // dd($todaysSales);
        $weeklySales = HasProducts::whereRaw("WEEKOFYEAR(created_at) = '" . date('W') . "'")
                ->whereNotIn("order_status", [0, 4, 6, 10])
                ->where('vendor_id', Auth::user()->id)
                ->sum('price');
        $monthlySales = HasProducts::whereRaw("MONTH(created_at) = '" . date('m') . "'")
                ->whereNotIn("order_status", [0, 4, 6, 10])
                ->where('vendor_id', Auth::user()->id)
                ->sum('price');
        $yearlySales = HasProducts::whereRaw("YEAR(created_at) = '" . date('Y') . "'")
                ->whereNotIn("order_status", [0, 4, 6, 10])
                ->where('vendor_id', Auth::user()->id)
                ->sum('price');
        $totalSales = HasProducts::whereNotIn("order_status", [0, 4, 6, 10])
                    ->where('vendor_id', Auth::user()->id)
                    ->sum('price');
        $todaysOrders = HasProducts::whereRaw("DATE(created_at) = '" . date('Y-m-d') . "'")
                ->whereNotIn("order_status", [0, 4, 6, 10])
                ->where('vendor_id', Auth::user()->id)
                ->count();
        $weeklyOrders = HasProducts::whereRaw("WEEKOFYEAR(created_at) = '" . date('W') . "'")
                ->whereNotIn("order_status", [0, 4, 6, 10])
                ->where('vendor_id', Auth::user()->id)
                ->count();
        $monthlyOrders = HasProducts::whereRaw("MONTH(created_at) = '" . date('m') . "'")
                ->whereNotIn("order_status", [0, 4, 6, 10])
                ->where('vendor_id', Auth::user()->id)
                ->count();
        $yearlyOrders = HasProducts::whereRaw("YEAR(created_at) = '" . date('Y') . "'")
                ->whereNotIn("order_status", [0, 4, 6, 10])
                ->where('vendor_id', Auth::user()->id)
                ->count();
        $totalOrders = HasProducts::with('orderDetails')->whereNotIn("order_status", [0, 4, 6, 10])->where('vendor_id', Auth::user()->id)->count();
        $topProducts = HasProducts::with('product')->where('vendor_id', Auth::user()->id)->limit(5)->groupBy('prod_id')->orderBy('quantity', 'desc')->get(['prod_id', DB::raw('count(prod_id) as top'), DB::raw('sum(qty) as quantity'),'prod_type','id','sub_prod_id',DB::raw('sum(price) as price')]);
        foreach ($topProducts as $prd) {
            if(!empty($prd->product)){
                  $prd->product->prodImage = asset(Config('constants.productImgPath') . @$prd->product->catalogimgs()->where("image_mode", 1)->first()->filename);
            }
       }

        $latestOrders = HasProducts::whereNotIn('order_status', [3, 4, 5, 6, 10])->where('vendor_id', Auth::user()->id)->limit(5)->orderBy('created_at', 'desc')->get();
       
        $salesGraph0 = HasProducts::whereNotIn("order_status", [0, 4, 6, 10])->where('vendor_id', Auth::user()->id)->orderBy('created_at', 'asc')->where('created_at', '>=', date('Y-m-d', strtotime("-7 day")))->groupBy(DB::raw("DATE(created_at)"))->get(['created_at', DB::raw('sum(price) as total_amount')])->toArray();
        $orderGraph0 = HasProducts::whereNotIn("order_status", [0, 4, 6, 10])->where('vendor_id', Auth::user()->id)->orderBy('created_at', 'asc')->where('created_at', '>=', date('Y-m-d', strtotime("-7 day")))->groupBy(DB::raw("DATE(created_at)"))->get(['created_at', DB::raw('count(id) as total_order')])->toArray();
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
                    $salesGraph[$key]['total_amount'] = $s0['total_amount'];
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
        return view(Config('constants.adminVendorView') . '.dashboard', compact('userCount', 'userThisWeekCount', 'userThisMonthCount', 'userThisYearCount', 'todaysSales', 'weeklySales', 'monthlySales', 'yearlySales', 'totalSales', 'todaysOrders', 'weeklyOrders', 'monthlyOrders', 'yearlyOrders', 'totalOrders', 'topProducts', 'latestOrders', 'latestUsers', 'latestProducts', 'salesGraph', 'orderGraph'));
    }

    public function add(){
         $vendor = new User;
         $action = route("admin.vendors.save");
        return view(Config('constants.adminVendorView') . '.addEdit', compact('vendor','action'));
    }

    public function orders() {
        $order_status = OrderStatus::where('status', 1)->orderBy('order_status', 'asc')->get();
        $order_options = '';
        foreach ($order_status as $status) {
            $order_options .= '<option  value="' . $status->id . '">' . $status->order_status . '</option>';
        }
        $product_ids = HasVendors::where('vendor_id', Auth::user()->id)->pluck('prod_id');
        $products = Product::whereIn('id',$product_ids)->pluck('product','id');

        $payment_method = PaymentMethod::all();
        $payment_stuatus = PaymentStatus::all();

        $flags = Flags::all();

        $orders = HasProducts::with('orderDetails')->where('vendor_id',Auth::user()->id);
        if(input::get('order_ids')){
            $ids = explode(",", Input::get('order_ids'));
            $orders->whereIn('id', $ids);
        }

        $customer = input::get('search');
        if($customer){
            $orders->whereHas('orderDetails', function($q) use($customer){
                $q->where('first_name', 'Like', '%'.$customer.'%');
                $q->orwhere('last_name', 'Like', '%'.$customer.'%');
                $q->orwhere('email', 'Like', '%'.$customer.'%');
                $q->orwhere('phone_no', 'Like', '%'.$customer.'%');
            });
        }

        if (!empty(Input::get('date'))) {
            $dates = explode(' - ', Input::get('date'));
            $dates[0] = date("Y-m-d", strtotime($dates[0]));
            $dates[1] = date("Y-m-d", strtotime($dates[1]));
            $orders = $orders->whereBetween('created_at', $dates);
        }

        $prod_id = Input::get('product');
        if($prod_id){
            $orders->where('prod_id',$prod_id);
        }

        $orders = $orders->paginate(Config('constants.paginateNo'));
        $ordersCount = $orders->total();
        $data = ['orders' => $orders, 'flags' => $flags,'payment_method' => $payment_method, 'payment_stuatus' => $payment_stuatus, 'ordersCount' => $ordersCount, 'order_status' => $order_status, 'order_options' => $order_options, 'products' => $products];
        return view(Config('constants.adminVendorView') . '.orders',$data);
    }

    public function save() {
        $user = new User();
        $user->firstname = Input::get('firstname');
        $user->lastname = Input::get('lastname');
        $user->email = Input::get('email');
        $user->telephone = Input::get('telephone');
        $user->password = Hash::make(Input::get('password'));
        $user->user_type = 3;
        $user->save();
        $user->roles()->sync([4]);
        Session::flash("success", "Vendor created successfully.");
        return redirect()->route('admin.vendors.view');
    }

    public function edit() {
        $vendor = User::find(Input::get('id'));
        $action = route("admin.vendors.update");
        return view(Config('constants.adminVendorView') . '.addEdit', compact('vendor', 'action'));
    }

    public function update() {
        $user = User::find(Input::get('id'));
        $user->firstname = Input::get('firstname');
        $user->lastname = Input::get('lastname');
        $user->email = Input::get('email');
        $user->telephone = Input::get('telephone');
        $user->update();
        Session::flash("success", "Vendor updated successfully.");
        return redirect()->route('admin.vendors.view');
    }

    public function delete() {
        $vendor = User::find(Input::get('id'));
        $vendor->delete();
        Session::flash("error", "Vendor deleted successfully.");
        return redirect()->route('admin.vendors.view');
    }

    public function products(){
        
        $categoryA = Category::get(['id', 'category'])->toArray();
        $rootsS = Category::roots()->get();
        $category = [];
        foreach ($categoryA as $val) {
            $category[$val['id']] = $val['category'];
        }
        
        $products = HasVendors::with('product')->where('vendor_id',Auth::user()->id);

        if (!empty(Input::get('product_name'))) {
            $name = Input::get('product_name');
            $products = $products->whereHas('product', function($query) use($name){
                $query->where('product', 'like', "%" .$name. "%");
            });
        }
        if (!empty(Input::get('category'))) {
            $category = Input::get('category');
            $products = $products->whereHas('product',function($q) use ($category){
                $q->whereHas('categories', function($query) use ($category){
                        $query->where('categories.id', $category);
                  });
            });  
        }
        $products = $products->select('has_vendors.id as id','has_vendors.*')->get();
        $productCount = $products->count();
        
        return view(Config('constants.adminVendorView') . '.products',compact('products', 'category','rootsS' ,'productCount'));
    }

    public function rejectOrders(){
        $has_prod_id = Input::get('id'); 
        $has_prod = HasProducts::find($has_prod_id);
        $has_vendor = HasVendors::where('vendor_id',$has_prod->vendor_id)->where('prod_id',$has_prod->prod_id)->first();
        $has_vendor->status = 0;
        $has_vendor->update();
        $prod = Product::find($has_prod->prod_id);
        $prior_vendor = $prod->vendorPriority()->first();
        $has_prod->vendor_id = $prior_vendor->id;
        $has_prod->update();
    }

    public function productStatus($id){
        $vendor = HasVendors::find($id);
        if($vendor->status == 1)
            $vendor->status = 0;
        else
            $vendor->status = 1;

        $vendor->update();
        return redirect()->back();
    }

    public function saleByOrder(){
        $where = '';
           $order=HasProducts::select(DB::raw('count(*) as order_count,sum(price) as sales'),'created_at','id')->where('vendor_id', Auth::user()->id)->whereNotIn('order_status',[0,4,6,10])->groupBy(DB::raw('DATE(created_at)'))->orderBy('sales','desc');

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
        if (!empty(Input::get('dateSearch'))) {
            $toDate = Input::get('to_date');
            $fromDate = Input::get('from_date');
             $order=$order->whereBetween('created_at',array($fromDate,$toDate))->get();
             $orderCount=$order->count();
            $where = "created_at between '$fromDate 00:00:00' and '$toDate  23:59:59' and order_status NOT IN(0,4,6,10)";
        } else {
          //  $where = "order_status NOT IN(0,4,6,10)";
            $order=$order->paginate(Config('constants.paginateNo'));
            $orderCount=$order->total();
        }
     
        return view(Config('constants.adminVendorView').'.sales-by-order', compact('order' ,'orderCount'));
    }

    public function saleByProduct(){

        ini_set("memory_limit", "-1");

        $search = !empty(Input::get("search")) ? Input::get("search") : '';
        $search_fields = ['product', 'short_desc', 'long_desc'];

        $prods = HasProducts::with('product')->where('vendor_id', Auth::user()->id);
        $prods->whereHas('product', function($q) use($search) {
                $q->where('is_individual', '=', '1');
                $q->where("is_crowd_funded", "=", "0");
                $q->orderBy("product", "asc");
              
        });
        
        if($search){
            $prods->whereHas('product', function($q) use($search){
                $q->where('product','LIKE','%'.$search.'%');
            });
            // $prods->WhereHas('subProduct',function($q) use($search){
            //     $q->orwhere('product','LIKE','%'.$search.'%');
            // }); 
        }
        $prods = $prods->orderBy("price", "desc");

        $prods = $prods->paginate(Config('constants.paginateNo'));
        $prodCount=$prods->total();
        
        return view(Config('constants.adminVendorView') . '.sales-by-product', compact('prods','prodCount'));

    }

    public function orderExport(){
     $where = "";

         $vendor_id = Auth::user()->id;
        if (!empty(Input::get('from_date'))) {
            $toDate = Input::get('to_date');
            $fromDate = Input::get('from_date');
            $where = "where created_at between '$fromDate' and '$toDate  23:59:59' and order_status NOT IN(0,4,6,10) and vendor_id=$vendor_id";
            $groupby = "group by DATE_FORMAT(created_at, '%d %b %Y')";
        }
       
        $order = DB::select(DB::raw("SELECT count(*) as order_count,sum(price) as sales ,id,created_at from ".DB::getTablePrefix()."has_products $where"));

        $order_data = [];
        array_push($order_data, ['Sr No', 'Date', 'Order Count', 'Sales']);
        foreach ($order as $od) {
            $details = [$od->id, $od->created_at, $od->order_count, number_format($od->sales)];
            array_push($order_data, $details);
        }
        return $this->convert_to_csv($order_data, 'by_order.csv', ',');

    }

     function convert_to_csv($input_array, $output_file_name, $delimiter) {
        $temp_memory = fopen('php://memory', 'w');
        foreach ($input_array as $line) {
            fputcsv($temp_memory, $line, $delimiter);
        }
        fseek($temp_memory, 0);
        header('Content-Type: application/csv');
        header('Content-Disposition: attachement; filename="' . $output_file_name . '";');
        fpassthru($temp_memory);
    }

    public function productBulkAction(){
        $ids = explode(",", Input::get('ids'));
        HasVendors::whereIn('id',$ids)->update(['status'=> Input::get('val')]);
    }

    public function updateOrderStatus() {
      
        $notify = 0;
        $comment = Input::get('comment');
        $orderIds = explode(",", Input::get('OrderIds'));
        $orderStatus = Input::get("status");
        $remark = Input::get('remark');
        $notify = is_null(Input::get('notify')) ? 0 : Input::get('notify');

        foreach ($orderIds as $id) {
            if ($id > 0) { 
                $orderUser = HasProducts::find($id);
                $orderUser->order_status = $orderStatus;
                $orderUser->update();
                Session::flash("message", "Order Status Updated Sucessfully!");
            }
        }
        return redirect()->route('admin.vendors.orders');
    }

     public function ordersDetails($id){
        // dd($id);
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
        $order = Order::findOrFail($id);
//        $usersA = User::get()->toArray();
//        $users = [];
//        foreach ($usersA as $val) {
//            $users[$val['id']] = $val['firstname'] . $val['lastname'];
//        }
        Cart::instance("shopping")->destroy();
        $coupons = Coupon::whereDate('start_date','<=' ,date("Y-m-d"))->where('end_date','>=' ,date("Y-m-d"))->get();
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
        $products = $order->products;
        $coupon = Coupon::find($order->coupon_used);
        $action = route("admin.orders.save");
        // return view(Config('constants.adminOrderView') . '.addEdit', compact('order', 'action', 'payment_methods', 'payment_status', 'order_status', 'countries', 'zones', 'products', 'coupon')); //'users', 
        $viewname = Config('constants.adminVendorView') . '.order-details';
        $data = ['order' => $order, 'action' => $action, 'payment_methods' => $payment_methods, 'payment_status' => $payment_status, 'order_status' => $order_status, 'countries' => $countries, 'zones' => $zones, 'products' => $products, 'coupon' => $coupon,'coupons' =>$coupons];
        return Helper::returnView($viewname, $data);
    }

}
