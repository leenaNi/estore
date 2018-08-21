<?php

namespace App\Http\Controllers\Cron;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Loyalty;
use App\Models\Order;
use App\Models\GeneralSetting;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class LoyaltyController extends Controller {

    function __construct() {
        parent::__construct();
    }

    public function indexCron() {

        $days = GeneralSetting::where('url_key', 'loyalty')->first();
      
        $order = Order::where('loyalty_cron_status', 1)
                        ->where(DB::raw('DATE(updated_at)'), '>=', date('Y-m-d', strtotime("now -$days->details days")))
                        ->where('order_status', 3)
                        ->select('id', 'pay_amt', 'user_id', 'updated_at', 'order_status')
                        ->get()->toArray();
       //  dd($order);
        if (count($order) > 0) {
            foreach ($order as $ordVal) {
                $orderId = Order::find($ordVal['id']);
                $orderId->loyalty_cron_status = 1;
                $orderId->update();
                $overall_pay_amt = DB::table('orders')
                                ->select('id', 'cashback_earned', 'currency_value', 'pay_amt')
                                ->where('user_id', $ordVal['user_id'])
                                ->where('loyalty_cron_status', 1)->get();
//                echo "<pre>";
//                print_r($overall_pay_amt);
//                echo "</pre>";
                $total_pay_amt = 0;

                foreach ($overall_pay_amt as $add_pay_amt) {
                    $total_pay_amt = $total_pay_amt + ($add_pay_amt->pay_amt * $add_pay_amt->currency_value);
                }
                //echo "total ".$total_pay_amt;
                $loyalty = Loyalty::all()->toArray();
                foreach ($loyalty as $loyal) {
                    $loyaltyId = 1;
                    $minValue = $loyal['min_order_amt'];
                    $maxValue = $loyal['max_order_amt'];
                    if ($total_pay_amt >= $minValue && $total_pay_amt <= $maxValue) {
                        $loyaltyId = $loyal['id'];
                        break;
                    }
                }
                //echo "loyalty id ".$loyaltyId;

                $user = User::find($ordVal['user_id']);
                $user->loyalty_group = $loyaltyId;
                $user->cashback = ($orderId->cashback_earned * $orderId->currency_value) + $user->cashback;
                $user->total_purchase_till_now = number_format($total_pay_amt, 2, '.', '');
                $user->update();
//                echo "<pre>";
//                print_r($user);
//                 echo "</pre>";
                echo "Ord Id " . $ordVal['id'] . " -- User ID" . $ordVal['user_id'] . " --- User Cashback" . $user->cashback . " Total purchase till now" . $user->total_purchase_till_now;
                $orderIdC = Order::find($ordVal['id']);
                $orderIdC->loyalty_cron_status = 0;
                $orderIdC->save();
            }
        } else {
            exit();
        }
    }

}
