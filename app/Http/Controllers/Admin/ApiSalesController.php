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
use App\Models\Merchant;
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
     $marchantId=Input::get("merchantId");
     $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
     $ordTab='orders';
     $UserTab='users'; 
     
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
        //$toDate = date('Y-m-d', strtotime('2018-10-20'));
        $toDate = date('Y-m-d', strtotime(Input::get('to_date')));
        $fromDate = date('Y-m-d', strtotime(Input::get('from_date')));
      //  $fromDate = date('Y-m-d', strtotime('2018-6-20'));
        $fromD=$fromDate .' 00:00:00';
       $toD= $toDate .' 23:59:59';
        $where = "where ord.created_at between '$fromDate 00:00:00' and '$toDate  23:59:59' and ord.order_status NOT IN(0,4,6,10)";
//        } else {
//            $where = "where ord.order_status NOT IN(0,4,6,10)";
//        }
 $allorder = DB::select(DB::raw("SELECT count(DISTINCT (order_id)) AS ordcount, SUM(pay_amt) AS sales,date(created_at) orddate "
                                . " from has_products where  store_id=$merchant->id and order_status NOT IN(0,4,6,10) group by orddate  order by sales desc"));
 
        $order = DB::select(DB::raw("SELECT ord.id AS orderId, SUM( hp.pay_amt ) AS sales, COUNT( hp.prod_id )  as prdCount"
                                . " from orders as ord inner join has_products as hp on(ord.id = hp.order_id) $where and hp.store_id=$merchant->id group by hp.order_id"));
       //dd($order);
        $salesTotal = 0;
        $ordProdTot = 0;
        foreach ($order as $orderval) {
         
            $salesTotal += $orderval->sales;
           $ordProdTot += $orderval->prdCount;
        }
        $cashRevenue = DB::table("has_products as hp")->join("orders","orders.id","hp.order_id")->select(DB::raw('sum(hp.pay_amt) as cashpayAmt'))->whereNotIn('hp.order_status',[4,0,10])
                ->where('orders.payment_method',1)->where("hp.store_id",$merchant->id)->whereBetween('hp.created_at', [$fromD, $toD])->get();
        $cardRevenue = DB::table("has_products as hp")->join("orders","orders.id","hp.order_id")->select(DB::raw('sum(hp.pay_amt) as cardpayAmt'))->whereNotIn('hp.order_status',[4,0,10])
                ->where('orders.payment_method',"!=",1)->where("hp.store_id",$merchant->id)->whereBetween('hp.created_at', [$fromD, $toD])->get();
        $creditRevenue = DB::table("has_products as hp")->join("orders","orders.id","hp.order_id")->select(DB::raw('sum(hp.pay_amt) as creditpayAmt'))->where('hp.order_status','!=',0)
                ->where('orders.payment_method',8)->where("hp.store_id",$merchant->id)->whereBetween('hp.created_at', [$fromD, $toD])->get();
        return $data = ['order' => count($order),'allorder' => $allorder,'salesTotal'=>$salesTotal,'ordProdTot'=>$ordProdTot,'cashSale'=>$cashRevenue[0]->cashpayAmt,'cardSale'=>$cardRevenue[0]->cardpayAmt,'creditSale'=>$creditRevenue[0]->creditpayAmt];
    }

    public function byCustomer() {
      $marchantId=Input::get("merchantId");
     $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
     $ordTab=$merchant->prefix.'_orders';
     $UserTab=$merchant->prefix.'_users';
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
         $toDate = date('Y-m-d', strtotime(Input::get('to_date')));
        $fromDate = date('Y-m-d', strtotime(Input::get('from_date')));
        $fromD=$fromDate .' 00:00:00';
         $toD= $toDate .' 23:59:59';
        $byUser =User::where($where)->where("status",1)->get();
        $newusers = User::where($where)->whereBetween('created_at', [$fromD, $toD])->select(DB::raw('count(id) as newOrdCount'))->get();
        $oldusers = User::where($where)->select(DB::raw('count(id) as oldOrdCount'))->get();
        $newrevenue =Order::join("users",'users.id', '=','users.id')->where("orders.store_id",$merchant->id)
                       ->whereBetween('users.created_at', [$fromD, $toD])
                        ->select(DB::raw('sum(pay_amt) as newPayAmt'))->get();
        //dd($newrevenue);
        $oldrevenue =  DB::table("has_products")->select(DB::raw('sum(pay_amt) as oldpayAmt'))->whereNotIn('order_status',[4,0,10])->where('store_id',$merchant->id)->get();
       // $cashRevenue = DB::table($ordTab)->select(DB::raw('sum(pay_amt) as cashpayAmt'))->whereNotIn('order_status',[4,0,10])->where($ordTab.'.payment_method',1)->get();
       // $cardRevenue = DB::table($ordTab)->select(DB::raw('sum(pay_amt) as cardpayAmt'))->whereNotIn('order_status',[4,0,10])->where($ordTab.'.payment_method',"!=",1)->get();
       // $creditRevenue = DB::table($ordTab)->select(DB::raw('sum(pay_amt) as creditpayAmt'))->where('order_status','!=',0)->where($ordTab.'.payment_method',8)->get();
        return $data = ['newusers' => $newusers[0]->newOrdCount, 'totalUser' => $oldusers[0]->oldOrdCount, 'newrevenue' => $newrevenue[0]->newPayAmt, 'oldrevenue' => $oldrevenue[0]->oldpayAmt,'user'=>$byUser];
    }
   public function byProduct() {
        ini_set("memory_limit", "-1");
     $marchantId=Input::get("merchantId");
     $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
     $prodTab=$merchant->prefix.'_products';  
//     $hasProdTab=$merchant->prefix.'_has_products';  
     $ordTab=$'orders';  
     $hasCatTab=$merchant->prefix.'_has_categories';  
     $catTab=$merchant->prefix.'_categories'; 
        $search = !empty(Input::get("search")) ? Input::get("search") : '';
        $search_fields = ['product', 'short_desc', 'long_desc'];

        
        $prods = DB::table($prodTab)->where('is_individual', '=', '1')->orderBy("product", "asc")->get();
         foreach($prods as $prod){
           $prod->category=  @DB::table($hasCatTab)->join($catTab,$catTab.".id","=",$hasCatTab.".cat_id")->where($hasCatTab.".prod_id",$prod->id)->first()->category;
           $sales= DB::table('has_products')->join($ordTab,$ordTab.".id","=","has_products.order_id")->where("has_products.prod_id",$prod->id)->where("has_products.store_id",$merchant->id)->get();
            $prod->TotalQty=$sales->sum('qty');
           $prod->TotalSale=$sales->sum('price');
             
         }  
           
          return $prods;  
    }
    
     public function byCategory() {
        $marchantId=Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $catTab=$merchant->prefix.'_categories';  
        $prodTab=$merchant->prefix.'_products'; 
        $ordTab=$merchant->prefix.'_orders';
        
        $hasProdTab=$merchant->prefix.'_has_products';  
         $hasCatTab=$merchant->prefix.'_has_categories'; 
        $search = !empty(Input::get("search")) ? Input::get("search") : '';
        $search_fields = ['category', 'short_desc', 'long_desc'];
         $categories = DB::table($catTab)->where('is_nav','1')->where("status",1)->where(function($query) use($search_fields, $search) {
         // where("status", '1')->where('id', 1)->with('children.cat_tax')
            foreach ($search_fields as $field) {
                $query->orWhere($field, "like", "%$search%");
            }
        })->orderBy("category", "asc")->get();

     foreach($categories as $cat){
         
        $prodIds=  DB::table($hasCatTab)->join($prodTab,$prodTab.".id","=",$hasCatTab.".prod_id")->where($hasCatTab.".cat_id",$cat->id)->pluck($prodTab.".id");   
        if(is_array($prodIds)){
        $sales= DB::table("has_products")->join("orders","orders.id","=","has_products.order_id")->whereIn("has_products.prod_id",$prodIds)->whereIn("has_products.store_id",$merchant->id)->get();
            $cat->TotalQty=$sales->sum('qty');
           $cat->TotalSale=$sales->sum('price');
        }
          $cat->TotalQty=0;
           $cat->TotalSale=0;
        }
         return $categories;
      //  return view(Config('constants.saleView') . '.by_categories', compact('categories','categoryCount'));
    }
    
   public function byAttribute() {
        $marchantId=Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $catTab=$merchant->prefix.'_categories';  
        $prodTab=$merchant->prefix.'_products'; 
      
         $hasCatTab=$merchant->prefix.'_has_categories';
        $search = !empty(Input::get("search")) ? Input::get("search") : '';
        $search_fields = ['product', 'short_desc', 'long_desc'];

        $prods =DB::table($prodTab)->where('is_individual', '=', '1')
                       ->where("prod_type", "=", "3")
                ->orderBy("product", "asc");
        $prods = $prods->where(function($query) use($search_fields, $search) {
            foreach ($search_fields as $field) {
                $query->orWhere($field, "like", "%$search%");
            }
        })->get();

       
        foreach($prods as $prod){
          $prod->category=  DB::table($hasCatTab)->join($catTab,$catTab.".id","=",$hasCatTab.".cat_id")->where($hasCatTab.".prod_id",$prod->id)->first()->category;
          $subProduct=DB::table($prodTab)->where('parent_prod_id', $prod->id)->get(["id","product"]);
        
          foreach($subProduct as $subProd){
              $orderCount = DB::table("has_products")->leftjoin("orders","orders.id", "=","has_products.order_id")
                                  ->whereNotIn("orders.order_status", [0, 4, 6, 10])
                                  ->where("has_products.sub_prod_id", "=", $subProd->id)
                                ->where("has_products.store_id", "=",$merchant->id )
                               ->select("has_products.created_at","has_products.qty");
              $subProd->Qty=$orderCount->sum('qty');
              $subProd->total=$orderCount->sum('price');
          }
          $prod->SubProd=$subProduct;
        }
         return $prods;
//        if (!empty(Input::get('dateSearch'))) {
//            $prods = $prods->get();
//            $prodCount=$prods->count();
//            
//        } else {
//             $prods = $prods->paginate(Config('constants.paginateNo'));
//          //  $prods= $prods->get();
//            $prodCount=$prods->total();
//            
//        }
////dd($prods->get());
//        return view(Config('constants.saleView') . '.by_attributes', compact('prods','prodCount'));
    }  
    
}
