<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use App\Models\Order;

use App\Models\Category;
use App\Models\Currency;
use App\Library\Helper;


use Validator;
use Illuminate\Support\Facades\Input;
use Hash;
use Session;
use Auth;
use DB;

class PaymentSettlementController extends Controller {

    public function index() {


      $orders=DB::table("has_products")->orderBy("has_products.id","desc")->join("stores","stores.id",'=',"has_products.store_id")->
              leftjoin("payment_settlement","payment_settlement.id",'=',"has_products.id")
              ->select('has_products.*', 'stores.store_name','payment_settlement.settled_amt','payment_settlement.settled_date')
              ->paginate(Config('constants.AdminPaginateNo'));

        //$merchants = $merchants->paginate(Config('constants.AdminPaginateNo'));
        $data = ['orders'=>$orders];
        $viewname = Config('constants.AdminPagesPaymentettlement') . ".index";
        return Helper::returnView($viewname, $data);
    }


}
