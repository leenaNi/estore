<?php

namespace App\Http\Controllers\Admin\API\Sales;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\CustomValidator;
use App\Library\Helper;
use Config;
use Cart;
use DB;
use Input;
use Session;

class ApiOrderController extends Controller
{
    public function getAllCustomers(){
        $customers = DB::table('users')->where(['user_type'=>2])->get();
        dd($customers);
    }
}
