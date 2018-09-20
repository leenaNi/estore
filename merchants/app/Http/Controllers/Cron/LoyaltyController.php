<?php

namespace App\Http\Controllers\Cron;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Loyalty;
use App\Models\Order;
use App\Models\HasCashbackLoyalty;
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
                        ->where('order_status', 3)->where("store_id", $this->jsonString['store_id'])
                        ->select('id', 'pay_amt', 'user_id', 'updated_at', 'order_status')
                        ->get()->toArray();
       
        if (count($order) > 0) {
            foreach ($order as $ordVal) {
                $orderId = Order::find($ordVal['id']);
                $orderId->loyalty_cron_status = 1;
                $orderId->update();
                $overall_pay_amt = DB::connection('mysql2')->table('orders')
                                ->select('id', 'cashback_earned', 'currency_value', 'pay_amt')
                                ->where('user_id', $ordVal['user_id'])
                                ->where('loyalty_cron_status', 1)->where("store_id", $this->jsonString['store_id'])->get();
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

                $user = User::with("userCashback")->find($ordVal['user_id']);
                  if ($user->userCashback) {
                            $user->userCashback->loyalty_group = $loyaltyId;
                            $user->userCashback->cashback = ($orderId->cashback_earned * $orderId->currency_value) + $user->userCashback->cashback; 
                            $user->userCashback->total_purchase_till_now = number_format($total_pay_amt, 2, '.', '');
                            $user->userCashback->save();
                        } else {
                            $usercashback = new HasCashbackLoyalty;
                            $usercashback->user_id = $user->id;
                            $usercashback->store_id = $this->jsonString['store_id'];
                            $usercashback->cashback =$orderId->cashback_earned * $orderId->currency_value;
                            $usercashback->total_purchase_till_now = number_format($total_pay_amt, 2, '.', '');
                            $usercashback->save();
                        }
           
//                echo "<pre>";
//                print_r($user);
//                 echo "</pre>";
                echo "Ord Id " . $ordVal['id'] . " -- User ID" . $ordVal['user_id'] . " --- User Cashback" . $user->cashback . " Total purchase till now" . $user->total_purchase_till_now;
                $orderIdC = Order::find($ordVal['id']);
                $orderIdC->loyalty_cron_status = 0;
                $orderIdC->save();
            }
         $this->checkReferal();
        } else {
           $this->checkReferal();
            exit();
        }
        
       
    }

    public function checkReferal() {
        $checkReferral = GeneralSetting::where('url_key', 'referral')->first();
        if ($checkReferral->status == 1) {
            $detailsR = json_decode($checkReferral->details);
            foreach ($detailsR as $detRk => $detRv) {
                if ($detRk == "activate_duration_in_days")
                    $activate_duration = $detRv;
                if ($detRk == "bonous_to_referee")
                    $bonousToReferee = $detRv;
                if ($detRk == "discount_on_order")
                    $discountOnOrder = $detRv;
            }
            $users = User::with("userCashback")->whereIn("user_type", [2, 1])->where("status", 1)->get();
           print_r($users);
            foreach ($users as $user) {
                if (!empty($user->referal_code)) {
                    $refUsedOrders = Order::where('referal_code_used', "=", $user->referal_code)
                                    ->where('created_at', '<=', date('Y-m-d', strtotime("now -$activate_duration days")))
                                    ->whereIn('order_status', [2, 3])
                                    ->where('ref_flag', '=', 0)->where("store_id", $this->jsonString['store_id'])->get();
                    dd($refUsedOrders);

                    $refToAdd = 0;
                   
                    if (count($refUsedOrders) > 0) {
                        foreach ($refUsedOrders as $refOds) {
                            $refToAdd += $refOds->user_ref_points;
                            $refOrders = Order::find($refOds->id);
                            $refOrders->ref_flag = 1;
                            $refOrders->update();
                        }
                        if ($user->userCashback) {
                            $user->userCashback->cashback = $user->userCashback->cashback + $refToAdd;
                            $user->userCashback->save();
                        } else {
                            $usercashback = new HasCashbackLoyalty;
                            $usercashback->user_id = $user->id;
                            $usercashback->store_id = $this->jsonString['store_id'];
                            $usercashback->cashback = round($refToAdd);
                            $usercashback->save();
                        }
                    }
                }
            }
        }
    }

}
