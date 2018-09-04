<?php

namespace App\Http\Controllers\Admin;

use Route;
use Input;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CancelOrder;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use App\Library\Helper;
use Session;

class CancelOrderController extends Controller {

//
    public function index() {
        //dd($this->jsonString);
      //  $jsonString = Helper::getSettings();
        $getData = CancelOrder::with('getorders', 'getorders.users')->where("prefix",$this->jsonString['prefix'])->get();
        return Helper::returnView(Config('constants.adminOrderView') . '.cancel-order.index', ["data" => $getData]);
    }

    public function edit($id) {
        //$jsonString = Helper::getSettings();
        $getData = CancelOrder::with('getorders', 'getorders.users', "reason")->where("prefix",$this->jsonString['prefix'])->where("id", $id)->first();
        return Helper::returnView(Config('constants.adminOrderView') . '.cancel-order.edit', ["data" => $getData]);
    }

    public function update() {
        if (Input::get("status") == 1):
            $getData = CancelOrder::find(Input::get("id"));
            $this->saveCashback($getData);
            $getData->status = Input::get("status");
            $getData->save();

            $this->saveStock();
            $this->updateUserCashback($getData);
        endif;
        Session::flash('message', "Status changed successfully.");
        $cancelOrderData = CancelOrder::with('getorders', 'getorders.users')->get();
        return Helper::returnView(Config('constants.adminOrderView') . '.cancel-order.index', ["data" => $cancelOrderData]);
    }

    public function saveStock() {
        if (Input::get('prdId')):
            $prod = @Input::get('prdId');
            if (isset($prod) && count($prod) > 0):
                foreach ($prod as $key => $getProd):
                    if (isset($key)) :
                        $prodStock = Product::find($key);
                        if ($prodStock->is_stock == 1):
                            $prodStock->stock = $prodStock->stock + @$getProd['qty'];
                        endif;
                        $prodStock->save();
                    endif;
                endforeach;
            endif;
        endif;
    }

    public function saveCashback($data) {

        if (isset($data->order_id)):
            $order = Order::find($data->order_id);
            $order->order_status = 4;
            $order->cashback_credited = $order->cashback_credited + @$data->return_amount;
            $order->save();
        endif;
    }

    public function updateUserCashback($data) {
        if (isset($data->uid)):
            $user = User::find($data->uid);
            $user->cashback = $user->cashback + $data->return_amount;
            $user->save();
        endif;
    }

}
