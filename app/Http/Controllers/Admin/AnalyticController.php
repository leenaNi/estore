<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Models\Bank;
use App\Models\Category;
use App\Models\VswipeSale;
use Hash;
use DB;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;

class AnalyticController extends Controller {

    function convert_to_csv($input_array, $output_file_name, $delimiter) {
        /** open raw memory as file, no need for temp files */
        $temp_memory = fopen('php://memory', 'w');
        /** loop through array  */
        foreach ($input_array as $line) {
            /** default php csv handler * */
            fputcsv($temp_memory, $line, $delimiter);
        }
        /** rewrind the "file" with the csv lines * */
        fseek($temp_memory, 0);
        /** modify header to be downloadable csv file * */
        header('Content-Type: application/csv');
        header('Content-Disposition: attachement; filename="' . $output_file_name . '";');
        /** Send file to browser for download */
        fpassthru($temp_memory);
    }

    public function byCategory(Request $request) {
        $where = [];
        if (!empty($this->getbankid())) {
            $where[] = " b.id = " . $this->getbankid() . " ";
        }
        if (!empty(Input::get('s_cat'))) {
            $where[] = " c.id = " . Input::get('s_cat') . " ";
        }

        if (!empty(Input::get('date_search'))) {
            $dateArr = explode(" - ", Input::get('date_search'));
            $fromdate = date("Y-m-d", strtotime($dateArr[0]));
            $todate = date("Y-m-d", strtotime($dateArr[1]));
            $where[] = "vs.order_date >= '{$fromdate}' and vs.order_date < '{$todate}' ";
        }
        if (!empty($where)) {
            $withWhere = " where " . join(" and ", $where);
        } else {
            $withWhere = "";
        }

        $page = ( $request->page ) ? $request->page :1; // current page for pagination
        // manually slice array of product to display on page
        $perPage = Config('constants.AdminPaginateNo');
        $offset = ($page-1) * $perPage;
        
        $getCatSales = DB::select("select sum(sales) as total_sales,category,id from (SELECT vs.sales,c.category,c.id FROM `vswipe_sales` vs
left join stores s on vs.store_id = s.id 
left join categories c on s.category_id = c.id 
left join  merchants m  on s.merchant_id  = m.id
left join bank_has_merchants bm on bm.merchant_id = m.id 
left join banks b on bm.bank_id = b.id

$withWhere
 group by vs.id) vs1
group by category");

        //$storesales = new Paginator($storesales, Config('constants.AdminPaginateNo'));
        $count = count($getCatSales);
       // $storesales = new Paginator($storesales,count($all_transactions), Config('constants.AdminPaginateNo'));
        $getCatSales = array_slice($getCatSales, $offset, $perPage);
        $allcats = Category::orderBy("category", 'asc')->where("status", 1)->get();
        $getCats = ['' => 'Select Category'];
        foreach ($allcats as $aCats) {
            $getCats[$aCats->id] = $aCats->category;
        }
        // your pagination 
        $getCatSales = new Paginator($getCatSales, $count, $perPage, $page, ['path'  => $request->url(),'query' => $request->query(),]);

        return view(Config('constants.AdminPagesAnalytic') . ".byCategory", compact("getCatSales", 'getCats'));
    }

    public function byStore(Request $request) {
        
        $getBanks = Bank::orderBy('name', "asc")->get();

        $sbanks = ["" => 'Select Bank'];

        foreach ($getBanks as $gBank) {
            $sbanks[$gBank->id] = $gBank->name;
        }

        $sCats = ["" => 'Select Category'];

        $cats = Category::orderBy("category", "asc")->get();
        foreach ($cats as $ct) {
            $sCats[$ct->id] = $ct->category;
        }

        $where = [];

        if (!empty($this->getbankid())) {
            $where[] = "b.id = " . $this->getbankid() . "";
        }

        if (!empty(Input::get('s_cat'))) {
            $where[] = "c.id = " . Input::get('s_cat') . "";
        }

        if (!empty(Input::get('s_mer_name'))) {
            $where1 = "m.firstname like '%" . Input::get('s_mer_name') . "%'";
            $where[] = trim(preg_replace('/\t/ ', '', $where1));
        }


        if (!empty(Input::get('s_store_name'))) {
            $where2 = "s.store_name like '%" . Input::get('s_store_name') . "%'";
            $where[] = trim(preg_replace('/\t/', '', $where2));
        }

        if (Input::get('s_status') != "") {
            $where[] = "s.status = " . Input::get('s_status') . "";
        }

        if (!empty(Input::get('s_bank_name'))) {
            $where[] = "b.id = " . Input::get('s_bank_name') . "";
        }



        if (!empty(Input::get('date_search'))) {
            $dateArr = explode(" - ", Input::get('date_search'));
            $fromdate = date("Y-m-d", strtotime($dateArr[0]));
            $todate = date("Y-m-d", strtotime($dateArr[1]));
            $where[] = "vs.order_date >= '{$fromdate}' and vs.order_date <= '{$todate}'";
        }



        if (!empty(Input::get('s_cat')) ||
                !empty(Input::get('s_mer_name')) ||
                !empty(Input::get('s_store_name')) ||
                Input::get('s_status') != "" ||
                !empty(Input::get('s_bank_name')) ||
                !empty(Input::get('date_search')) ||
                !empty($this->getbankid())
        ) {
            $whereWith = " where " . join(' and ', $where);
        } else {
            $whereWith = "";
        }

        $page = ( $request->page ) ? $request->page :1; // current page for pagination

        // manually slice array of product to display on page
        $perPage = Config('constants.AdminPaginateNo');
        $offset = ($page-1) * $perPage;
        

        $storesales = DB::select("select store_name,total_sales,company_name,logo,group_concat(banknames) as banknames,firstname,category from (SELECT sum(sales) as total_sales,s.store_name,s.logo,m.company_name,group_concat(DISTINCT(b.name)) as banknames,m.firstname,c.category FROM `vswipe_sales` vs 
left join stores s on vs.store_id = s.id 
left join categories c on s.category_id =  c.id
left join merchants m on s.merchant_id = m.id 
left join bank_has_merchants bm on m.id = bm.merchant_id
left join banks b on bm.bank_id = b.id 
$whereWith
 group by vs.store_id,b.id,m.id) s1
 group by store_name order by total_sales desc");

        //$storesales = new Paginator($storesales, Config('constants.AdminPaginateNo'));
        $count = count($storesales);
       // $storesales = new Paginator($storesales,count($all_transactions), Config('constants.AdminPaginateNo'));
        $storesales = array_slice($storesales, $offset, $perPage);
        // your pagination 
        $storesales = new Paginator($storesales, $count, $perPage, $page, ['path'  => $request->url(),'query' => $request->query(),]);
       
        return view(Config('constants.AdminPagesAnalytic') . ".byStore", compact("storesales", "sbanks", "sCats"));
    }

    public function byDate() {

        if (!empty($this->getbankid())) {
            $withwhere = " and b.id = " . $this->getbankid();
        } else {
            $withwhere = "";
        }




        $yearlySales = DB::select("select sum(sales) as value,YEAR(order_date) as year from (SELECT sales,order_date FROM `vswipe_sales` vs 
left join stores s on vs.store_id = s.id 
left join merchants m on s.merchant_id = m.id 
left join bank_has_merchants bm on m.id = bm.merchant_id 
left join banks b on bm.bank_id = b.id 
where vs.order_date >  DATE_SUB(NOW(),INTERVAL 5 YEAR) 
      $withwhere                                             
 group by vs.id) as vs1
group by YEAR(order_date)");

        $fromY = ['' => 'From Year'];
        $toY = ['' => 'To Year'];

        foreach ($yearlySales as $gety) {
            $fromY[$gety->year] = $gety->year;
            $toY[$gety->year] = $gety->year;
        }


        $monthlySales = DB::select("SELECT sum(sales) as total_sales,DATE_FORMAT(order_date,'%M-%Y') as month from (SELECT sales,order_date FROM `vswipe_sales` vs 
left join stores s on vs.store_id = s.id 
left join merchants m on s.merchant_id = m.id 
left join bank_has_merchants bm on m.id = bm.merchant_id 
left join banks b on bm.bank_id = b.id 
where vs.order_date > DATE_FORMAT(DATE_SUB(now(), INTERVAL 12 MONTH),'%Y-%m-%d')
           $withwhere                                         
 group by vs.id) as vs1
group by DATE_FORMAT(order_date,'%M-%Y')");




        $barchartdata = [];
        $barchartdata['labels'] = [];
        $barchartdata['datasets'][0]['data'] = [];

        foreach ($monthlySales as $salesk => $sales) {
            array_push($barchartdata['labels'], $sales->month);
            array_push($barchartdata['datasets'][0]['data'], $sales->total_sales);
        }


        $dailySales = DB::select("SELECT sum(sales) as total_sales,DATE_FORMAT(order_date,'%d-%b')as day  from (SELECT sales,order_date FROM `vswipe_sales` vs 
left join stores s on vs.store_id = s.id 
left join merchants m on s.merchant_id = m.id 
left join bank_has_merchants bm on m.id = bm.merchant_id 
left join banks b on bm.bank_id = b.id 
where DATE(vs.order_date) >= DATE_SUB(DATE(NOW()), INTERVAL 7 DAY)
    $withwhere                                                 
 group by vs.id) as vs1
group by DATE(order_date)");


//        $dailySales = DB::select("SELECT sum(sales) as total_sales,DATE_FORMAT(vs.order_date,'%d-%b')as day FROM `vswipe_sales` vs 
//where DATE(vs.order_date) >= DATE_SUB(DATE(NOW()), INTERVAL 7 DAY)
//group by DATE(vs.order_date)");


        $dailychartdata = [];
        $dailychartdata['labels'] = [];
        $dailychartdata['datasets'][0]['data'] = [];


        foreach ($dailySales as $salesd => $salesv) {
            array_push($dailychartdata['labels'], $salesv->day);
            array_push($dailychartdata['datasets'][0]['data'], $salesv->total_sales);
        }



        return view(Config('constants.AdminPagesAnalytic') . ".byDate", compact('yearlySales', 'fromY', 'toY', 'barchartdata', 'dailychartdata'));
    }

    public function byDateGetYearly() {


        $where = "";
        $withwhere = "";
        if (!empty(Input::get('chkF')) && empty(Input::get('chkT')))
            $withwhere = " where YEAR(order_date) >= " . Input::get('chkF') . "";

        if (empty(Input::get('chkF')) && !empty(Input::get('chkT')))
            $withwhere = " where YEAR(order_date) <= " . Input::get('chkF') . "";

        if (!empty(Input::get('chkF')) && !empty(Input::get('chkT'))) {
            $withwhere = " where YEAR(order_date) >= " . Input::get('chkF') . " and " . "YEAR(order_date) <= " . Input::get('chkT') . "";
        }

        if (!empty($this->getbankid())) {
            $where = $withwhere . " and " . "b.id = " . $this->getbankid() . " ";
        } else {
            $where = $withwhere;
        }



        $yearlySales = DB::select("select sum(sales) as value,YEAR(order_date) as year from (SELECT sales,order_date FROM `vswipe_sales` vs 
left join stores s on vs.store_id = s.id 
left join merchants m on s.merchant_id = m.id 
left join bank_has_merchants bm on m.id = bm.merchant_id 
left join banks b on bm.bank_id = b.id 
$where                                                      
group by vs.id) as vs1
group by YEAR(order_date)");


        return $yearlySales;
    }

    public function byDateGetDaily() {

        $withwhere = "";
        $where = "";
        if (!empty(Input::get('getdaterange'))) {
            $dateArr = explode(" - ", Input::get('getdaterange'));
            $fromdate = $dateArr[0];
            $todate = $dateArr[1];

            $withwhere = " where (DATE_FORMAT(order_date,'%Y-%m-%d') >= '$fromdate') 
and (DATE_FORMAT(order_date,'%Y-%m-%d') <= '$todate')";
        } else {
            $withwhere = "";
        }



        if (!empty($this->getbankid())) {
            $where = $withwhere . " and " . "b.id = " . $this->getbankid() . " ";
        } else {
            $where = $withwhere;
        }



        $dailySales = DB::select("SELECT sum(sales) as total_sales,DATE_FORMAT(order_date,'%d-%b')as day  from (SELECT sales,order_date FROM `vswipe_sales` vs 
left join stores s on vs.store_id = s.id 
left join merchants m on s.merchant_id = m.id 
left join bank_has_merchants bm on m.id = bm.merchant_id 
left join banks b on bm.bank_id = b.id 
    $where                                                 
 group by vs.id) as vs1
group by DATE(order_date)");


        //  dd($dailySales);

        $dailychartdata = [];
        $dailychartdata['labels'] = [];
        $dailychartdata['datasets'][0]['data'] = [];


        foreach ($dailySales as $salesd => $salesv) {
            array_push($dailychartdata['labels'], $salesv->day);
            array_push($dailychartdata['datasets'][0]['data'], $salesv->total_sales);
        }



        return $dailychartdata;
    }

    public function byMerchant() {

        //raw query
//        SELECT sum(sales),m.id FROM `vswipe_sales` vs 
//left join  stores s on vs.store_id = s.id 
//left join  merchants m on s.merchant_id = m.id 
//left join  bank_has_merchants bm on m.id = bm.merchant_id
//left join banks b on bm.bank_id = b.id 
//where s.status=1
//group by m.id,bm.merchant_id

        $getbanks = Bank::orderBy('id', 'desc')->orderBy('name', 'asc')->get();

        $selBank = ['' => 'Select Bank'];

        foreach ($getbanks as $bank) {
            $selBank[$bank->id] = $bank->name;
        }

        $getmsales = VswipeSale::leftJoin("stores", "vswipe_sales.store_id", "stores.id")
                ->leftJoin("merchants", "stores.merchant_id", "merchants.id")
                ->leftJoin("bank_has_merchants", "merchants.id", "bank_has_merchants.merchant_id")
                ->leftJoin("banks", "bank_has_merchants.bank_id", "banks.id")
                ->where("stores.status", 1)
                ->groupBy("merchants.id", "bank_has_merchants.merchant_id")
                ->select("stores.logo", "merchants.company_name", DB::raw('group_concat(DISTINCT(banks.name)) as banknames'), DB::raw('SUM(sales) as total_sales'));


        if (!empty($this->getbankid())) {
            $getmsales = $getmsales->where("banks.id", $this->getbankid());
        }

        if (!empty(Input::get('s_bank_name'))) {
            $getmsales = $getmsales->where("banks.id", "=", Input::get('s_bank_name'));
        }



        if (!empty(Input::get('s_mer_name'))) {
            $getmsales = $getmsales->where("merchants.company_name", "like", "%" . Input::get('s_mer_name') . "%");
        }

        if (Input::get('s_status') != "") {
            $getmsales = $getmsales->where("stores.status", "=", Input::get('s_status'));
        }

        if (!empty(Input::get('date_search'))) {
            $dateArr = explode(" - ", Input::get('date_search'));
            $fromdate = date("Y-m-d", strtotime($dateArr[0]));
            $todate = date("Y-m-d", strtotime($dateArr[1]));
            $getmsales = $getmsales->where("vswipe_sales.order_date", ">=", "{$fromdate}")->where('vswipe_sales.order_date', "<", "{$todate}");
        }



        $getmsales = $getmsales->paginate(Config('constants.AdminPaginateNo'));

        return view(Config('constants.AdminPagesAnalytic') . ".byMerchant", compact("getmsales", "selBank"));
    }

    public function byBank() {

//        raw query
//        SELECT sum(sales),b.name FROM `vswipe_sales` vs 
//left join  stores s on vs.store_id = s.id 
//left join  merchants m on s.merchant_id = m.id 
//left join  bank_has_merchants bm on m.id = bm.merchant_id
//left join banks b on bm.bank_id = b.id 
//                where s.status= 1
//group by b.id,bm.bank_id  

        $getbanks = Bank::orderBy('id', 'desc')->orderBy('name', 'asc')->get();

        $selBank = ['' => 'Select Bank'];

        foreach ($getbanks as $bank) {
            $selBank[$bank->id] = $bank->name;
        }

        $getBankSales = VswipeSale::leftJoin('stores', 'vswipe_sales.store_id', "=", "stores.id")
                ->leftJoin('merchants', 'stores.merchant_id', "=", 'merchants.id')
                ->leftJoin('bank_has_merchants', 'merchants.id', "=", 'bank_has_merchants.merchant_id')
                ->leftJoin('banks', 'bank_has_merchants.bank_id', "=", 'banks.id')
                ->groupBy('banks.id', 'bank_has_merchants.bank_id')
                ->where("stores.status", 1)
                ->select('banks.id', 'banks.name as bank_name', DB::raw('SUM(sales) as total_sales'));


        if (!empty(Input::get('s_bank_name'))) {
            $getBankSales = $getBankSales->where('banks.id', "=", Input::get('s_bank_name'));
        }

        if (!empty(Input::get('date_search'))) {
            $dateArr = explode(" - ", Input::get('date_search'));
            $fromdate = date("Y-m-d", strtotime($dateArr[0]));
            $todate = date("Y-m-d", strtotime($dateArr[1]));
            $getBankSales = $getBankSales->where("vswipe_sales.order_date", ">=", "{$fromdate}")->where('vswipe_sales.order_date', "<", "{$todate}");
        }
        $getBankSales = $getBankSales->paginate(Config('constants.AdminPaginateNo'));



        return view(Config('constants.AdminPagesAnalytic') . ".byBank", compact('selBank', 'getBankSales'));
    }

    public function byDateGetMonthly() {
        $withwhere = "";

        $where = "";

        if (!empty(Input::get('getdaterange'))) {
            $dateArr = explode(" - ", Input::get('getdaterange'));
            $fromdate = $dateArr[0];
            $todate = $dateArr[1];

            $withwhere = " where (DATE_FORMAT(order_date,'%Y-%m-%d') >= '$fromdate') 
and (DATE_FORMAT(order_date,'%Y-%m-%d') <= '$todate')";
        } else {
            $withwhere = "";
        }

        if (!empty($this->getbankid())) {
            $where = $withwhere . " and " . "b.id = " . $this->getbankid() . " ";
        } else {
            $where = $withwhere;
        }




        $monthlySales = DB::select("SELECT sum(sales) as total_sales,DATE_FORMAT(order_date,'%M-%Y') as month from (SELECT sales,order_date FROM `vswipe_sales` vs 
left join stores s on vs.store_id = s.id 
left join merchants m on s.merchant_id = m.id 
left join bank_has_merchants bm on m.id = bm.merchant_id 
left join banks b on bm.bank_id = b.id 
$where
 group by vs.id) as vs1
group by DATE_FORMAT(order_date,'%M-%Y')");


        $barchartdata = [];
        $barchartdata['labels'] = [];
        $barchartdata['datasets'][0]['data'] = [];

        foreach ($monthlySales as $salesk => $sales) {
            array_push($barchartdata['labels'], $sales->month);
            array_push($barchartdata['datasets'][0]['data'], $sales->total_sales);
        }

        return $barchartdata;
    }

    public function byBankExport() {

        $bankid = Input::get('bankid');

        $getResult = DB::select("select store_name,total_sales,company_name,logo,group_concat(banknames) as banknames from (SELECT sum(sales) as total_sales,s.store_name,s.logo,m.company_name,group_concat(DISTINCT(b.name)) as banknames FROM `vswipe_sales` vs 
left join stores s on vs.store_id = s.id 
left join categories c on s.category_id =  c.id
left join merchants m on s.merchant_id = m.id 
left join bank_has_merchants bm on m.id = bm.merchant_id
left join banks b on bm.bank_id = b.id 
where b.id=$bankid
 group by vs.store_id,b.id,m.id) s1
 group by store_name order by total_sales desc");

        $filename = Bank::find($bankid)->name;

        $bankData = [];
        $details = ['Sr No', 'Store Name', 'Merchant Name', "Sales"];
        array_push($bankData, $details);
        $sr = 1;
        foreach ($getResult as $res) {
            $details = [$sr,
                $res->store_name,
                $res->company_name,
                $res->total_sales
            ];
            $sr++;
            array_push($bankData, $details);
        }

        return $this->convert_to_csv($bankData, $filename . '_bank.csv', ',');
    }

    public function byMerchantExport() {

        $getmsales = VswipeSale::leftJoin("stores", "vswipe_sales.store_id", "stores.id")
                ->leftJoin("merchants", "stores.merchant_id", "merchants.id")
                ->leftJoin("bank_has_merchants", "merchants.id", "bank_has_merchants.merchant_id")
                ->leftJoin("banks", "bank_has_merchants.bank_id", "banks.id")
                ->where("stores.status", 1)
                ->groupBy("merchants.id", "bank_has_merchants.merchant_id")
                ->select("stores.store_name", "merchants.company_name", DB::raw('group_concat(DISTINCT(banks.name)) as banknames'), DB::raw('SUM(sales) as total_sales'));


        if (!empty($this->getbankid())) {
            $getmsales = $getmsales->where("banks.id", $this->getbankid());
        }

        $getmsales = $getmsales->get();



        $data = [];
        $details = ['Sr No', 'Store Name', 'Merchant Name', "Bank Name", "Sales"];
        array_push($data, $details);
        $sr = 1;
        foreach ($getmsales as $res) {
            $details = [$sr,
                $res->store_name,
                $res->company_name,
                $res->banknames,
                $res->total_sales
            ];
            $sr++;
            array_push($data, $details);
        }

        return $this->convert_to_csv($data, 'by_merchants.csv', ',');
    }

    public function byStoreExport() {
        $whereWith = '';
        $where = [];
//        if (!empty($this->getbankid())) {
//            $where[] = "b.id = " . $this->getbankid() . "";
//        }
//
//        if (!empty($this->getbankid())
//        ) {
//            $whereWith = " where " . join(' and ', $where);
//        } else {
//            $whereWith = "";
//        }
        
        if (!empty(Input::get('s_cat'))) {
            $where[] = " c.id = ".Input::get('s_cat');
        }

        if (!empty(Input::get('date_search'))) {
            $dateArr = explode(" - ", Input::get('date_search'));
            $fromdate = date("Y-m-d", strtotime($dateArr[0]));
            $todate = date("Y-m-d", strtotime($dateArr[1]));
            $where[] = " (vswipe_sales.order_date >= ".$fromdate." and vswipe_sales.order_date <= ".$todate.")";
         }
         
         if(!empty($where))
         {
             $whereWith = " where " . join(' and ', $where);
         }

         dd($whereWith);
        $storesales = DB::select("select store_name,total_sales,firstname,logo,group_concat(banknames) as banknames from (SELECT sum(sales) as total_sales,s.store_name,s.logo,m.company_name,group_concat(DISTINCT(b.name)) as banknames,c.category FROM `vswipe_sales` vs 
left join stores s on vs.store_id = s.id 
left join categories c on s.category_id =  c.id
left join merchants m on s.merchant_id = m.id 
left join bank_has_merchants bm on m.id = bm.merchant_id
left join banks b on bm.bank_id = b.id 
$whereWith
 group by vs.store_id,b.id,m.id) s1
 group by store_name order by total_sales desc");

        $data = [];
        $details = ['Sr No', 'Store Name', 'Merchant Name',"Category", "Sales"];
        array_push($data, $details);
        $sr = 1;
        foreach ($storesales as $res) {
            $details = [$sr,
                $res->store_name,
                $res->firstname,
                $res->category,
                $res->total_sales
            ];
            $sr++;
            array_push($data, $details);
        }

        return $this->convert_to_csv($data, 'stores.csv', ',');
    }

    public function byCategoryExport() {
        $where = [];
        if (!empty($this->getbankid())) {
            $where[] = " b.id = " . $this->getbankid() . " ";
        }
        if (!empty(Input::get('catid'))) {
            $where[] = " c.id = " . Input::get('catid') . " ";
        }

        if (!empty($where)) {
            $withWhere = " where " . join(" and ", $where);
        } else {
            $withWhere = "";
        }

        $filename  = Category::find(Input::get('catid'))->category;
        $getCatSales =  DB::select("select category,store_name,total_sales,company_name,logo,group_concat(banknames) as banknames from (SELECT sum(sales) as total_sales,s.store_name,s.logo,m.company_name,c.category,group_concat(DISTINCT(b.name)) as banknames FROM `vswipe_sales` vs 
left join stores s on vs.store_id = s.id 
left join categories c on s.category_id =  c.id
left join merchants m on s.merchant_id = m.id 
left join bank_has_merchants bm on m.id = bm.merchant_id
left join banks b on bm.bank_id = b.id 
$withWhere
 group by vs.store_id,b.id,m.id) s1
 group by store_name order by total_sales desc");

        $data = [];
        $details = ['Sr No','Category', 'Store Name', 'Merchant Name', "Bank Name", "Sales"];
        array_push($data, $details);
        $sr = 1;
        foreach ($getCatSales as $res) {
            $details = [$sr,
                $res->category,
                $res->store_name,
                $res->company_name,
                $res->banknames,
                $res->total_sales
            ];
            $sr++;
            array_push($data, $details);
        }

        return $this->convert_to_csv($data, $filename.'_category.csv', ',');
    }

}
