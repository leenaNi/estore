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

class SalesController extends Controller {

    public function order() {
       // dd(DB::getTablePrefix());
        $where = '';
        $order = Order::whereNotIn('orders.order_status',[0,4,6,10])->join("has_products", "has_products.order_id", '=', 'orders.id')->where("has_products.store_id", $this->jsonString['store_id'])
                  ->select( DB::raw('sum(has_products.pay_amt) as hasPayamt'),DB::raw('count(*) as order_count,sum(orders.pay_amt) as sales'),'orders.created_at','orders.id','orders.prefix')
                  ->groupBy(DB::raw('DATE(orders.created_at)'))->orderBy('sales','desc');
       // dd($order->get());
      //     $order=Order::select(DB::raw('count(*) as order_count,sum(pay_amt) as sales'),'created_at','id')->whereNotIn('order_status',[0,4,6,10])->groupBy(DB::raw('DATE(created_at)'))->orderBy('sales','desc');
         // dd($order);
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
      //  $order=Order::where($where)->get();
       // $orderCount=$order->count();
      // dd($orders);
       // $order = DB::select(DB::raw("SELECT count(*) as order_count,sum(pay_amt) as sales, id ,$select from ".DB::getTablePrefix()."orders $where  $groupby order by sales desc"));
       //  $orderCount=count($order);
       
       $startIndex = 1;
        $getPerPageRecord = Config('constants.paginateNo');
        $allinput = Input::all();
        if(!empty($allinput) && !empty(Input::get('page')))
        {
            $getPageNumber = $allinput['page'];
            $startIndex = ( (($getPageNumber) * ($getPerPageRecord)) - $getPerPageRecord) + 1;
            $endIndex = (($startIndex+$getPerPageRecord) - 1);

            if($endIndex > $orderCount)
            {
                $endIndex = ($orderCount);
            }
        }
        else
        {
            $startIndex = 1;
            $endIndex = $getPerPageRecord;
            if($endIndex > $orderCount)
            {
                $endIndex = ($orderCount);
            }
        }

       return view(Config('constants.saleView') . '.by_order', compact('order' ,'orderCount', 'startIndex', 'endIndex'));
    }

    public function products() {
        ini_set("memory_limit", "-1");
        
         
        $search = !empty(Input::get("search")) ? Input::get("search") : '';
        $search_fields = ['product', 'short_desc', 'long_desc'];
        $prods = DB::table('products as p')
                ->where('is_individual', '=', '1')->orderBy("product", "asc")
                ->join("has_products as hp", "hp.prod_id", '=', 'p.id')->whereNotIn('hp.order_status',[0,4,6,10])
                ->join("has_categories as hc", "hc.prod_id", "=", "p.id")
                ->join("categories as c", "c.id", "=", "hc.cat_id")
                ->where("hp.store_id", $this->jsonString['store_id'])
                ->select('p.id','p.product',DB::raw("SUM(hp.qty) tot_qty"),DB::raw("SUM(hp.pay_amt) sales"), 'c.category')
                ->groupBy('p.id');
//        $prods = Product::where('is_individual', '=', '1');
//        $prods = $prods->setConnection('mysql2')
//                ->where("is_crowd_funded", "=", "0")
//                ->orderBy("product", "asc");
//        $prods = $prods->with('sales')->orderBy("price", "desc");
//        $prods = $prods->where(function($query) use($search_fields, $search) {
//            foreach ($search_fields as $field) {
//                $query->orWhere($field, "like", "%$search%");
//            }
//
//            $query->orWhereHas('categories', function($query) use ($search) {
//                return $query->where('category', 'like', "%$search%");
//            });
//        });


        if (!empty(Input::get('from_date')) || !empty(Input::get('search')) || !empty(Input::get('to_date'))) {
            $prods = $prods->where('p.status',1)->get();
            $prodCount=$prods->count();

            // dd($prods);
        } else {

            $prods = $prods->where('p.status',1)->paginate(Config('constants.paginateNo'));
             $prodCount=$prods->total();
        }

        $startIndex = 1;
        $getPerPageRecord = Config('constants.paginateNo');
        $allinput = Input::all();
        if(!empty($allinput) && !empty(Input::get('page')))
        {
            $getPageNumber = $allinput['page'];
            $startIndex = ( (($getPageNumber) * ($getPerPageRecord)) - $getPerPageRecord) + 1;
            $endIndex = (($startIndex+$getPerPageRecord) - 1);

            if($endIndex > $prodCount)
            {
                $endIndex = ($prodCount);
            }
        }
        else
        {
            $startIndex = 1;
            $endIndex = $getPerPageRecord;
            if($endIndex > $prodCount)
            {
                $endIndex = ($prodCount);
            }
        }
        return view(Config('constants.saleView') . '.by_products', compact('prods','prodCount', 'startIndex', 'endIndex'));
    }

    public function categories() {
       $storeId=$this->jsonString['store_id'];
        $search = !empty(Input::get("search")) ? Input::get("search") : '';
        $search_fields = ['short_desc', 'long_desc'];
        // $categories = Category::orderBy('category')->where("status",1);
        $categories = Category::where("status",1);
        $categories = $categories->with(['children', 'categoryName' => function($query) use($search) {
            $query->orderBy('category');
            if($search!=''){
                $query->orWhere('category', "like", "%$search%");
            }
        }])->where('is_nav',1)
        ->where(function($query) use($search_fields, $search) {
         // where("status", '1')->where('id', 1)->with('children.cat_tax')
            foreach ($search_fields as $field) {
                $query->orWhere($field, "like", "%$search%");
            }
        });

        if (!empty(Input::get('dateSearch'))) {
            $categories = $categories->get();
            $categoryCount=$categories->count();
        } else {

            $categories = $categories->paginate(Config('constants.paginateNo'));
            $categoryCount=$categories->total();
        }

        $startIndex = 1;
        $getPerPageRecord = Config('constants.paginateNo');
        $allinput = Input::all();
        if(!empty($allinput) && !empty(Input::get('page')))
        {
            $getPageNumber = $allinput['page'];
            $startIndex = ( (($getPageNumber) * ($getPerPageRecord)) - $getPerPageRecord) + 1;
            $endIndex = (($startIndex+$getPerPageRecord) - 1);

            if($endIndex > $categoryCount)
            {
                $endIndex = ($categoryCount);
            }
        }
        else
        {
            $startIndex = 1;
            $endIndex = $getPerPageRecord;
            if($endIndex > $categoryCount)
            {
                $endIndex = ($categoryCount);
            }
        }

        return view(Config('constants.saleView') . '.by_categories', compact('categories','categoryCount','storeId','startIndex','endIndex'));
    }

    public function attributes() {

        $search = !empty(Input::get("search")) ? Input::get("search") : '';
        $search_fields = ['product', 'short_desc', 'long_desc'];

        $prods = Product::where('is_individual', '=', '1')
              
                ->where("prod_type", "=", "3")
                ->orderBy("product", "asc");
        $prods = $prods->where(function($query) use($search_fields, $search) {
            foreach ($search_fields as $field) {
                $query->orWhere($field, "like", "%$search%");
            }
//            $query->orWhereHas('categories', function($query) use ($search) {
//                return $query->where('categorys', 'like', "%$search%");
//            });
        });

        //dd($prods);
        if (!empty(Input::get('dateSearch'))) {
            $prods = $prods->get();
            $prodCount=$prods->count();
            
        } else {
             $prods = $prods->paginate(Config('constants.paginateNo'));
          //  $prods= $prods->get();
            $prodCount=$prods->total();
            
        }
        foreach($prods as $prod){
           $prod->category= $prod->categories()->first()->category;
            foreach($prod->subproducts as $sub){
              $orderCount=HasProducts::whereNotIn("order_status", [0, 4, 6, 10])->where("sub_prod_id", "=", $sub->id)->where("store_id", $this->jsonString['store_id']);
                   if (!empty(Input::get('from_date')) && !empty(Input::get('to_date'))) {
                        $orderCount = $orderCount->whereBetween('created_at', [Input::get('from_date'), Input::get('to_date'). " 23:59:59"]);
                      }
               $sub->detials = $orderCount->select("created_at", DB::raw("sum(qty) as qty"),DB::raw("sum(price) as price"))->groupBy("sub_prod_id")->get();                           
                                               
                                               
            }
        }

        $startIndex = 1;
        $getPerPageRecord = Config('constants.paginateNo');
        $allinput = Input::all();
        if(!empty($allinput) && !empty(Input::get('page')))
        {
            $getPageNumber = $allinput['page'];
            $startIndex = ( (($getPageNumber) * ($getPerPageRecord)) - $getPerPageRecord) + 1;
            $endIndex = (($startIndex+$getPerPageRecord) - 1);

            if($endIndex > $prodCount)
            {
                $endIndex = ($prodCount);
            }
        }
        else
        {
            $startIndex = 1;
            $endIndex = $getPerPageRecord;
            if($endIndex > $prodCount)
            {
                $endIndex = ($prodCount);
            }
        }

        return view(Config('constants.saleView') . '.by_attributes', compact('prods','prodCount','startIndex','endIndex'));
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

    public function attrExport() {
        $search = !empty(Input::get("search")) ? Input::get("search") : '';
        $search_fields = ['product', 'short_desc', 'long_desc'];
        $prods = Product::where('is_individual', '=', '1')
                ->where("is_crowd_funded", "=", "0")
                ->where("prod_type", "=", "3")
                ->orderBy("product", "asc");
        $prods = $prods->where(function($query) use($search_fields, $search) {
            foreach ($search_fields as $field) {
                $query->orWhere($field, "like", "%$search%");
            }
//            $query->orWhereHas('categories', function($query) use ($search) {
//                return $query->where('category', 'like', "%$search%");
//            });
        });
        $prods = $prods->get();
        $attr_data = [];
        $details = ['Product', 'Category', 'Sub Products', 'Order Count', 'Sales'];
        array_push($attr_data, $details);
        foreach ($prods as $prd) {
            $sr_no = $prd->id;
            $product = $prd->product;
            $category = @$prd->categories()->first()->category;
            $sub_products = [];
            $sub_products_order_count = [];
            $sub_price = [];
            foreach ($prd->subproducts as $sub) {
                array_push($sub_products, $sub->product);
               // dd($sub_products);
                $orderCount =  DB::table("has_products")->leftjoin("orders", "orders.id", "=", "has_products.order_id")
                                                ->whereNotIn("orders.order_status", [0, 4, 6, 10])
                                                ->where("sub_prod_id", "=", $sub->id);
                if (!empty(Input::get('from_date')) && !empty(Input::get('to_date'))) {
                    $orderCount = $orderCount->whereBetween('created_at', [Input::get('from_date'), Input::get('to_date') . " 23:59:59"]);
                }
                $orderCount = $orderCount->sum('qty');
                array_push($sub_products_order_count, $orderCount);
               // dd($sub_products_order_count);
                $sales = DB::table("has_products")->leftjoin("orders", "orders.id", "=", "has_products.order_id")
                                                ->whereNotIn("orders.order_status", [0, 4, 6, 10])
                                                ->where("sub_prod_id", "=", $sub->id);
                if (!empty(Input::get('from_date')) && !empty(Input::get('to_date'))) {
                    $sales = $sales->whereBetween('created_at', [Input::get('from_date'), Input::get('to_date') . " 23:59:59"]);
                }
                $sales =  number_format($sales->sum('price') * Session::get('currency_val'),2);
                array_push($sub_price, $sales);
               // if ($orderCount > 0) {
                    $details = [$product, $category, $sub->product, $orderCount,$sales];
                    array_push($attr_data, $details);
              //  }
            }
        }
        return $this->convert_to_csv($attr_data, 'by_attr.csv', ',');
    }

    public function catExport() {
        $search = !empty(Input::get("search")) ? Input::get("search") : '';
        $search_fields = ['category', 'short_desc', 'long_desc'];
        $categories = Category::orderBy('category');
        $categories = $categories->where(function($query) use($search_fields, $search) {
            foreach ($search_fields as $field) {
                $query->orWhere($field, "like", "%$search%");
            }
        });
        $categories = $categories->get();
        $cat_data = [];
        $details = ['Category', 'Orders', 'Sales'];
        array_push($cat_data, $details);
        foreach ($categories as $cat) {
            $orderCnt = 0;
            $totSales = 0;
            foreach ($cat->products as $prd) {
                $sales = $prd->sales();
                if (!empty(Input::get('from_date')) && !empty(Input::get('to_date'))) {
                    $sales = $sales->whereBetween('has_products.created_at', [ Input::get('from_date'), Input::get('to_date') . " 23:59:59"]);
                }
                $orderCnt += $sales->sum('qty');
                $totSales += $sales->sum('price');
            }
            $details = [$cat->category, $orderCnt, number_format($totSales * Session::get('currency_val'),2)];
            array_push($cat_data, $details);
        }
        return $this->convert_to_csv($cat_data, 'by_cat.csv', ',');
    }

    public function prodExport() {
        ini_set("memory_limit", "-1");
        $search = !empty(Input::get("search")) ? Input::get("search") : '';
        $search_fields = ['product', 'short_desc', 'long_desc'];
        $prods = Product::where('is_individual', '=', '1')
                ->where("is_crowd_funded", "=", "0")
                ->orderBy("product", "asc");
        $prods = $prods->with('sales')->orderBy("price", "desc");
        $prods = $prods->where(function($query) use($search_fields, $search) {
            foreach ($search_fields as $field) {
                $query->orWhere($field, "like", "%$search%");
            }
            $query->orWhereHas('categories', function($query) use ($search) {
                return $query->where('category', 'like', "%$search%");
            });
        });
        $prods = $prods->get();
        $prod_data = [];
        $details = ['Product', 'Category', 'Quantity Sold', 'Sales'];
        array_push($prod_data, $details);
        foreach ($prods as $prd) {
            $sales = $prd->sales();
            if (!empty(Input::get('from_date')) && !empty(Input::get('to_date'))) {
                $sales = $sales->whereBetween('has_products.created_at', [ Input::get('from_date'), Input::get('to_date') . " 23:59:59"]);
            }
            $salesTot = $sales->sum('qty');
            $salesPrice = number_format(($sales->sum('price')* Session::get('currency_val')),2);
            $details = [@$prd->product, @$prd->categories()->first()->category, $salesTot, $salesPrice];
            array_push($prod_data, $details);
        }
        return $this->convert_to_csv($prod_data, 'by_prods.csv', ',');
    }

    function addQuotes($string) {
        return '"' . implode('","', explode(',', $string)) . '"';
    }

    public function orderExport() {
        $where = "";
        if (!empty(Input::get('month'))) {
            $orderdates = explode(",", $orderdates);
            $arr = [];
            foreach ($orderdates as $oDates) {
                array_push($arr, date("M Y", strtotime($oDates)));
            }
            $mDates = implode(',', $arr);
            $ct_dates = $this->addQuotes($mDates);
            $select = "DATE_FORMAT(created_at, '%M %Y') as created_at";
            $groupby = "group by DATE_FORMAT(created_at, '%b %Y')";

            if (!empty(Input::get('month'))) {
                $where = "where DATE_FORMAT(created_at, '%b %Y') in (" . $ct_dates . ") and order_status NOT IN(0,4,6,10)";
            }
        } else if (!empty(Input::get('year'))) {
            $orderdates = explode(",", $orderdates);
            $arr3 = [];
            foreach ($orderdates as $oDates) {
                array_push($arr3, date("Y", strtotime($oDates)));
            }
            $yDates = implode(',', $arr3);
            $ct_dates = $this->addQuotes($yDates);
            $select = "YEAR(created_at) as created_at";
            $groupby = "group by YEAR(created_at)";
            $where = "where YEAR(created_at) in (" . $ct_dates . ") and order_status NOT IN(0,4,6,10)";
        } else if (!empty(Input::get('week'))) {
            $orderdates = explode(",", $orderdates);
            $arr1 = [];
            foreach ($orderdates as $oDates) {
                array_push($arr1, date("M Y", strtotime($oDates)));
            }
            $wDates = implode(',', $orderdates);
            $ct_dates = $this->addQuotes($wDates);
            $select = "CONCAT(WEEK(created_at),' ', YEAR(created_at) ) as created_at";
            $groupby = "group by CONCAT(WEEK(created_at),' ', YEAR(created_at) )";
            $where = "where CONCAT(WEEK(created_at),' ', YEAR(created_at) ) in (" . $ct_dates . ") and order_status NOT IN(0,4,6,10)";
        } else {
            $select = "DATE_FORMAT(created_at, '%d %b %Y') as created_at";
            $where = "where order_status NOT IN(0,4,6,10)";
            $groupby = "group by DATE_FORMAT(created_at, '%d %b %Y')";
        }
        if (!empty(Input::get('from_date'))) {
            $toDate = Input::get('to_date');
            $fromDate = Input::get('from_date');
            $where = "where created_at between '$fromDate' and '$toDate  23:59:59' and order_status NOT IN(0,4,6,10)";
        }
        $order = DB::select(DB::raw("SELECT count(*) as order_count,sum(pay_amt) as sales ,$select,id from ".DB::getTablePrefix()."orders $where  $groupby order by sales desc"));

        $order_data = [];
        array_push($order_data, ['Date', 'Order Count', 'Sales']);
        foreach ($order as $od) {
            $details = [ $od->created_at, $od->order_count, number_format($od->sales * Session::get('currency_val'),2)];
            array_push($order_data, $details);
        }
        return $this->convert_to_csv($order_data, 'by_order.csv', ',');
    }

    public function usersData() {
        $customers = DB::table("users")
                ->select(DB::raw('count(id) as users'), DB::raw('YEAR(created_at) as year'))
                ->groupBy(DB::raw('YEAR(created_at)'))
                ->where(DB::raw('YEAR(created_at)'), "!=", 0)
                ->get();

        return view(Config('constants.saleView') . '.users_data', compact('customers'));
    }

    public function bycustomer() {

        $users=User::with("userCashback")->where('user_type',2)->where('store_id',Session::get('store_id'));
         if (!empty(Input::get('search_name'))) {
             $uname=Input::get('search_name');
             $users=$users->where('firstname',"like","$uname%");
          }
         if (!empty(Input::get('search_email'))) {
              $users=$users->where('email',Input::get('search_email'));
         }
          if (!empty(Input::get('search_number'))) {
             $users=$users->where('telephone',Input::get('search_number'));
        }
        if(!empty(Input::get("dataSearch"))){
            
            $users=$users->get();
            $userCount=$users->count();
        }else{
           $users=$users->paginate(Config("constants.paginateNo"));
           $userCount=$users->total();
        }

        $startIndex = 1;
        $getPerPageRecord = Config('constants.paginateNo');
        $allinput = Input::all();
        if(!empty($allinput) && !empty(Input::get('page')))
        {
            $getPageNumber = $allinput['page'];
            $startIndex = ( (($getPageNumber) * ($getPerPageRecord)) - $getPerPageRecord) + 1;
            $endIndex = (($startIndex+$getPerPageRecord) - 1);

            if($endIndex > $userCount)
            {
                $endIndex = ($userCount);
            }
        }
        else
        {
            $startIndex = 1;
            $endIndex = $getPerPageRecord;
            if($endIndex > $userCount)
            {
                $endIndex = ($userCount);
            }
        }
        return view(Config('constants.saleView') . '.by_customer', compact('users','userCount','startIndex','endIndex'));
    }

//customer chart view 

     public function bycustomerChart() {



      //dd(Input::all());

  
       // $users=User::with("userCashback")->where('user_type',2);
         if (!empty(Input::get('from_date')) && !empty(Input::get('to_date'))) {


           //  $from_date=Input::get('from_date');
     $orders = Order::where("orders.store_id", "=", Session::get('store_id'))->whereNotIn("orders.order_status", [0, 4, 6, 10])->join('users','orders.user_id','=','users.id')->whereDate('orders.created_at', '>=', Input::get('from_date') )->whereDate('orders.created_at', '<=', Input::get('to_date'))->groupby('orders.user_id')->select(DB::raw("SUM(order_amt) as total"),'users.firstname as firstname','users.lastname as lastname','users.id as user_id')->limit(10)->get(); 

     $topProducts = HasProducts::where('prefix', 'LIKE', "{$this->jsonString['prefix']}")->whereDate('created_at', '>=', Input::get('from_date') )->whereDate('created_at', '<=', Input::get('to_date'))->limit(5)->groupBy('prefix', 'prod_id')->orderBy('quantity', 'desc')->get(['prod_id', DB::raw('count(prod_id) as top'), DB::raw('sum(qty) as quantity')]);


          }
       else if (!empty(Input::get('from_date'))) {
         $orders = Order::where("orders.store_id", "=", Session::get('store_id'))->whereNotIn("orders.order_status", [0, 4, 6, 10])->join('users','orders.user_id','=','users.id')->whereDate('orders.created_at', '>=', Input::get('from_date') )->groupby('orders.user_id')->select(DB::raw("SUM(order_amt) as total"),'users.firstname as firstname','users.lastname as lastname','users.id as user_id')->limit(10)->get();

         $topProducts = HasProducts::where('prefix', 'LIKE', "{$this->jsonString['prefix']}")->whereDate('created_at', '>=', Input::get('from_date') )->limit(5)->groupBy('prefix', 'prod_id')->orderBy('quantity', 'desc')->get(['prod_id', DB::raw('count(prod_id) as top'), DB::raw('sum(qty) as quantity')]);


       }
        else if (!empty(Input::get('to_date'))) {
             $orders =Order::where("orders.store_id", "=", Session::get('store_id'))->whereNotIn("orders.order_status", [0, 4, 6, 10])->join('users','orders.user_id','=','users.id')->whereDate('orders.created_at', '<=', Input::get('to_date'))->groupby('orders.user_id')->select(DB::raw("SUM(order_amt) as total"),'users.firstname as firstname','users.lastname as lastname','users.id as user_id')->limit(10)->get();

             $topProducts = HasProducts::where('prefix', 'LIKE', "{$this->jsonString['prefix']}")->whereDate('created_at', '<=', Input::get('to_date'))->limit(5)->groupBy('prefix', 'prod_id')->orderBy('quantity', 'desc')->get(['prod_id', DB::raw('count(prod_id) as top'), DB::raw('sum(qty) as quantity')]);

         }
         else
         {
              $orders = Order::where("orders.store_id", "=", Session::get('store_id'))->whereNotIn("orders.order_status", [0, 4, 6, 10])->join('users','orders.user_id','=','users.id')->groupby('orders.user_id')->select(DB::raw("SUM(order_amt) as total"),'users.firstname as firstname','users.lastname as lastname','users.id as user_id')->limit(10)->get();

              $topProducts = HasProducts::where('prefix', 'LIKE', "{$this->jsonString['prefix']}")->limit(5)->groupBy('prefix', 'prod_id')->orderBy('quantity', 'desc')->get(['prod_id', DB::raw('count(prod_id) as top'), DB::raw('sum(qty) as quantity')]);
         }
       
       $items = [];
       $products = [];
       foreach($orders as $key=> $order)
       {

         $items[$key]["total"] = $order->total;
         $items[$key]['customer_name'] = $order->firstname." ".$order->lastname;
         $items[$key]['color'] = '#'.$this->random_color_part() . $this->random_color_part() . $this->random_color_part();
       }

       foreach($topProducts as $key => $product)
       {
        $products[$key]["product_name"] = $product->product;
        $products[$key]["quantity"] = $product->quantity;
        $products[$key]['color'] = '#'.$this->random_color_part() . $this->random_color_part() . $this->random_color_part();
       }



  return view(Config('constants.saleView') . '.customer_chart',['items'=>$items, 'products' => $products]);

}
 public  function random_color_part() {
    return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
    }
       
    public function order_by_customer_export() {
      $users = User::where('user_type',2)->select('id', 'firstname', 'lastname', 'email', 'telephone', 'total_purchase_till_now','cashback')->get()->toArray();
        $export = [];
        array_push($export, [ 'Firstname', 'Lastname', 'Emailid', 'Mobile', 'Total Purchase','Cashback']);
       // dd($orders);
        foreach ($users as $key => $value) {
//            $export[$key + 1]['id'] = $value['id'];
            $export[$key + 1]['firstname'] = $value['firstname'];
            $export[$key + 1]['lastname'] = $value['lastname'];
            $export[$key + 1]['email'] = $value['email'];
            $export[$key + 1]['telephone'] = $value['telephone'];
            $export[$key + 1]['total_purchase_till_now'] = number_format(($value['total_purchase_till_now'] * Session::get('currency_val')),2);
            $export[$key + 1]['cashback'] = number_format($value['cashback']* Session::get('currency_val'),2);
//            $export[$key + 1]['payment_status'] = $value['paymentstatus']['payment_status'];
//            $export[$key + 1]['order_status'] = $value['orderstatus']['order_status'];
        }
        return $this->convert_to_csv($export, 'by_customer_order.csv', ',');
//$where[] = ['user_id' => $id];
//        if (!empty(Input::get('paymentMethodexport'))) {
//            array_push($where, ['payment_method' => Input::get('paymentMethodexport')]);
//        }
//        if (!empty(Input::get('paymentStatusexport'))) {
//            array_push($where, ['payment_status' => Input::get('paymentStatusexport')]);
//        }
//        if (!empty(Input::get('orderStatusexport'))) {
//            array_push($where, ['order_status' => Input::get('orderStatusexport')]);
//        }
//        $wh = [];
//        foreach ($where as $value) {
//            foreach ($value as $keya => $valuea) {
//                $wh[$keya] = $valuea;
//            }
//        }
//        $user_id = $id;
//        $orderStatus = OrderStatus::all();
//        $paymentMethod = PaymentMethod::all();
//        $paymentStatus = PaymentStatus::all();
//        $orders = Order::where($wh)->select('id', 'order_amt', 'pay_amt', 'cashback_used', 'cashback_earned', 'cashback_credited', 'payment_method', 'payment_status', 'order_status')->with('orderstatus', 'paymentmethod', 'paymentstatus')->get()->toArray();
//        $export = [];
//        array_push($export, ['Order Id', 'Order Amount', 'Pay Amount', 'Cashback Used', 'Cashback Earned', 'Cashback Credited', 'Payment Method', 'Payment Status', 'Order Status']);
//        foreach ($orders as $key => $value) {
//            $export[$key + 1]['id'] = $value['id'];
//            $export[$key + 1]['order_amt'] = $value['order_amt'];
//            $export[$key + 1]['pay_amt'] = $value['pay_amt'];
//            $export[$key + 1]['cashback_used'] = $value['cashback_used'];
//            $export[$key + 1]['cashback_earned'] = $value['cashback_earned'];
//            $export[$key + 1]['cashback_credited'] = $value['cashback_credited'];
//            $export[$key + 1]['payment_method'] = $value['paymentmethod']['name'];
//            $export[$key + 1]['payment_status'] = $value['paymentstatus']['payment_status'];
//            $export[$key + 1]['order_status'] = $value['orderstatus']['order_status'];
//        }
//        return $this->convert_to_csv($export, 'by_customer_order.csv', ',');
    }

    public function order_by_customer($id) {
        $where = ['user_id' => $id];
        if (!empty(Input::get('paymentMethod'))) {
            $where['payment_method'] = Input::get('paymentMethod');
        }
        if (!empty(Input::get('paymentStatus'))) {
            $where['payment_status'] = Input::get('paymentStatus');
        }
        if (!empty(Input::get('orderStatus'))) {
            $where['order_status'] = Input::get('orderStatus');
        }
        $user_id = $id;
        $orderStatus = OrderStatus::all();
        $paymentMethod = PaymentMethod::all();
        $paymentStatus = PaymentStatus::all();
        $orders = Order::where($where)->select('id', 'order_amt', 'pay_amt', 'cashback_used', 'cashback_earned', 'cashback_credited', 'payment_method', 'payment_status', 'order_status')->with('orderstatus', 'paymentmethod', 'paymentstatus')->get();
        return view(Config('constants.saleView') . '.by_customer_order', compact('orders', 'orderStatus', 'paymentMethod', 'paymentStatus', 'user_id'));
    }

}
