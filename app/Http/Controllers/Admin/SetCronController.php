<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use App\Models\Bank;
use App\Models\Store;
use App\Library\Helper;
use App\Models\Document;
use App\Models\VswipeUser;
use App\Models\VswipeSale;
use DB;
use App\Models\Currency;
use Validator;
use Illuminate\Support\Facades\Input;
use Hash;
use Session;
use Auth;

class SetCronController extends Controller {

    public function updateSales(){
        $getStores = Store::get();
        $yesterdayDate = date('Y-m-d',strtotime("-1 days"));;
        
        foreach($getStores as $getk => $getS){
            //dd($getS->getmerchant()->first()->register_details);
           $merchant_details =  json_decode($getS->getmerchant()->first()->register_details,true);
           $currency = Currency::find($merchant_details['currency'])->currency_val;
           $vsUpdate =  new VswipeSale();
           $vsUpdate->sales = DB::table("orders")->where("prefix",$getS->prefix)
                   ->where("order_status","!=",0)
                   //->where(DB::raw("DATE(created_at)"),"=",$yesterdayDate)
                  
                   ->sum("pay_amt");
           $vsUpdate->user_count = DB::table("users")
               
                   ->count();
                
           $vsUpdate->store_id = $getS->id;
           $vsUpdate->order_date= $yesterdayDate;
           $vsUpdate->currency_val = $currency;
           $vsUpdate->save();
        }
    
    }

}
