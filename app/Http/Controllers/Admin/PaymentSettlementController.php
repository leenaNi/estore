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


      $orders=DB::table("has_products")->orderBy("has_products.id","desc")->join("stores","stores.id",'=',"has_products.store_id")->select('has_products.*', 'stores.store_name')->paginate(Config('constants.AdminPaginateNo'));

        //$merchants = $merchants->paginate(Config('constants.AdminPaginateNo'));
        $data = ['orders'=>$orders];
        $viewname = Config('constants.AdminPagesPaymentettlement') . ".index";
        return Helper::returnView($viewname, $data);
    }


}
