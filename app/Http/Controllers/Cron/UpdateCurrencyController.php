<?php

namespace App\Http\Controllers\Cron;

use Illuminate\Http\Request;
use App\Models\HasCurrency;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class UpdateCurrencyController extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function index() {
        $allCurrency = HasCurrency::where("status", 1)->where("iso_code",'!=',"IND")->get();
        $headers[] = 'Content-Type:application/x-www-form-urlencoded';
        $from_Currency = urlencode("INR");
        foreach ($allCurrency as $curency) {
            $curCode = $curency->currency_code;

            $to_Currency = urlencode($curCode);
            $query = "{$from_Currency}_{$to_Currency}";

            $json = file_get_contents("https://free.currencyconverterapi.com/api/v6/convert?q={$query}&compact=ultra");
            $obj = json_decode($json, true);

            $val = floatval($obj["$query"]);
            $curency->currency_val = $val;
            $curency->save();
        }
    }

}
