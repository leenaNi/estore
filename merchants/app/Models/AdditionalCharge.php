<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\GeneralSetting;

class AdditionalCharge extends Model {

    protected $table = 'additional_charges';

    public static function ApplyAdditionalCharge($price) {
        $addCharge = GeneralSetting::where('url_key', 'additional-charge')->where('status', 1)->first();      

        $data = [];

        if( is_array($addCharge) && count($addCharge) <= 0)
        {
            $data['total_amt'] = 0;
            return json_encode($data);
        }
           

        $amount = 0;
//        $charge_list = [];
        $arr = [];
        $charges = [];
        if ( is_array($addCharge) && $addCharge->status == 1) {
            $charges = AdditionalCharge::where('status', 1)->get();
            foreach ($charges as $key => $charge) {
//                echo "In Add Charge Model -> ".$charge->label. " Price => ". $price;
                $charge_list = [];
                if ($charge['min_order_amt'] > 0) {
                    if ($price >= $charge['min_order_amt']) {
                        if ($charge->type == 1) {
                            $amount += $charge->rate;
                            $charge_list['applied'] = $charge->rate;
                        } else {
                            $amount += $price * ($charge->rate / 100);
                            $charge_list['applied'] = $price * ($charge->rate / 100);
                        }
                        $charge_list['id'] = $charge->id;
                        $charge_list['label'] = $charge->label;
                        $charge_list['type'] = $charge->type;
                        $charge_list['rate'] = $charge->rate;
                        $charge_list['min_order_amt'] = $charge->min_order_amt;
                        array_push($arr, $charge_list);
//                        print_r($charge_list);
                    }
                } else {
                    if ($charge->type == 1) {
                        $amount += $charge->rate;
                        $charge_list['applied'] = $charge->rate;
                    } else {
                        $amount += $price * ($charge->rate / 100);
                        $charge_list['applied'] = $price * ($charge->rate / 100);
                    }
                    $charge_list['id'] = $charge->id;
                    $charge_list['label'] = $charge->label;
                    $charge_list['type'] = $charge->type;
                    $charge_list['rate'] = $charge->rate;
                    $charge_list['min_order_amt'] = $charge->min_order_amt;
                    array_push($arr, $charge_list);
//                    print_r($charge_list);
                }
//                print_r($arr);
            }
//            echo "==================================================<br/>";
//            print_r($arr);
        } else {
            $amount = 0;
        }

        $data['details'] = $arr;
        $data['charges'] = $charges;
        $data['total_amt'] = $amount;
        $total_with_price = $price + $amount;
        $data['total_with_price'] = number_format($total_with_price, 2);
        $data['total'] = $total_with_price;

        return json_encode($data);
    }

    public static function ApplyAdditionalChargeOnOrder($price, $addId) {
        $addCharge = GeneralSetting::where('url_key', 'additional-charge')->first();
        $data = [];
        $amount = 0;
        $charge_list = [];
        $arr = [];
        if ($addCharge->status) {
            $charges = AdditionalCharge::where('status', 1)->get();

            foreach ($charges as $key => $charge) {
                if ($charge['min_order_amt'] > 0 && in_array($charge->id, $addId)) {

                    if ($price >= $charge['min_order_amt']) {
                        if ($charge->type == 1) {
                            $amount += $charge->rate;
                            $charge_list['applied'] = $charge->rate;
                        } else {
                            $amount += $price * ($charge->rate / 100);
                            $charge_list['applied'] = $price * ($charge->rate / 100);
                        }
                        $charge_list['id'] = $charge->id;
                        $charge_list['label'] = $charge->label;
                        $charge_list['type'] = $charge->type;
                        $charge_list['rate'] = $charge->rate;
                        $charge_list['min_order_amt'] = $charge->min_order_amt;
                        array_push($arr, $charge_list);
                    }
                } else if (in_array($charge->id, $addId)) {
                    if ($charge->type == 1) {
                        $amount += $charge->rate;
                        $charge_list['applied'] = $charge->rate;
                    } else {
                        $amount += $price * ($charge->rate / 100);
                        $charge_list['applied'] = $price * ($charge->rate / 100);
                    }
                    $charge_list['id'] = $charge->id;
                    $charge_list['label'] = $charge->label;
                    $charge_list['type'] = $charge->type;
                    $charge_list['rate'] = $charge->rate;
                    $charge_list['min_order_amt'] = $charge->min_order_amt;
                    array_push($arr, $charge_list);
                }
            }
        } else {
            $amount = 0;
        }

        $data['details'] = $arr;
        $data['total_amt'] = number_format($amount, 2);
        $total_with_price = $price + $amount;
        $data['total_with_price'] = number_format($total_with_price, 2);
        $data['total'] = $total_with_price;

        return json_encode($data);
    }

}
