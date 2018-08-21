<?php

namespace App\Http\Controllers\Admin;

use Route;
use Input;
use App\Models\Product;
use App\Models\OrderStatus;
use App\Models\PaymentMethod;
use App\Models\PaymentStatus;
use App\Models\Order;
use App\Models\User;
use App\Models\Country;
use App\Models\State;
use App\Models\Tax;
use App\Models\AdditionalCharge;
use App\Models\Category;
use App\Models\GeneralSetting;
use App\Http\Controllers\Controller;
use App\Library\Helper;
use Session;
use DB;

class AdditionalChargesController extends Controller {

    public function index() {

        $search = !empty(Input::get("search")) ? Input::get("search") : '';
        $search_fields = ['name','rate'];
        
        $additionalCharge = AdditionalCharge::orderBy("id", "asc");
         $additionalCharge = $additionalCharge->where(function($query) use($search_fields, $search) {
            foreach ($search_fields as $field) {
                $query->orWhere($field, "like", "%$search%");
            }
        });
        if (!empty(Input::get("search"))) {
            $additionalCharge = $additionalCharge->get();
            $additionalChargeCount = $additionalCharge->count();
        } else {
            $additionalCharge = $additionalCharge->paginate(Config('constants.paginateNo'));
            $additionalChargeCount = $additionalCharge->total();
        }
        $data = ['additionalCharge' => $additionalCharge,'additionalChargeCount' =>$additionalChargeCount];
        $viewname = Config('constants.adminAdditionalCharge') . '.index';
        return Helper::returnView($viewname, $data);
    }

    public function add() {
        $additional_charge = new AdditionalCharge();
        $action = route("admin.additional-charges.save");
        $data = ['additional_charge' => $additional_charge, 'action' => $action];
        $viewname = Config('constants.adminAdditionalCharge') . '.addEdit';
        return Helper::returnView($viewname, $data);
    }

    public function edit() {
        $additional_charge = AdditionalCharge::find(Input::get('id'));
        $action = route("admin.additional-charges.save");
        $data = ['additional_charge' => $additional_charge, 'action' => $action];
        $viewname = Config('constants.adminAdditionalCharge') . '.addEdit';
        return Helper::returnView($viewname, $data);
    }

    public function save() {
        $additionalCharge = AdditionalCharge::findOrNew(Input::get('id'));
        $additionalCharge->label = Input::get('name');
        $additionalCharge->name = Input::get('name');
        $additionalCharge->rate = Input::get('rate');
        $additionalCharge->type = Input::get('type');
        $charge_applicable = Input::get('minimum_charge');
        if($charge_applicable){           
            $additionalCharge->min_order_amt = Input::get('min_order_amt');
        }else{
            $additionalCharge->min_order_amt = 0;
        }

        $additionalCharge->save();
        if (Input::get('id') != '')
            Session::flash("msg", "Additional charge updated successfully.");
        else
            Session::flash("msg", "Additional charge added successfully.");
        
        return redirect()->route('admin.additional-charges.view');
    }

    public function delete() {
        $additionalCharge = AdditionalCharge::find(Input::get('id'));
        $additionalCharge->delete();
        Session::flash("message", "Additional charge deleted successfully.");
        $data = ['status' => '1', 'msg' => 'Additional Charge deleted successfully.'];
        return redirect()->route('admin.additional-charges.view');
    }

    public function changeStatus() {
        $additionalCharge = AdditionalCharge::find(Input::get('id'));
        if ($additionalCharge->status == 1) {
            $taxStatus = 0;
            $msg = "Additional charges disabled successfully.";
            $additionalCharge->status = $taxStatus;
            $additionalCharge->update();
            Session::flash("message", $msg);

        } else if ($additionalCharge->status == 0) {
            $taxStatus = 1;
            $msg = "Additional charges enabled successfully.";
            $additionalCharge->status = $taxStatus;
            $additionalCharge->update();
            Session::flash("msg", $msg);
        }

        return redirect()->route('admin.additional-charges.view');
    }
    
     public function checkTax() {
        $taxname = Input::get('taxname');
        $getTax = Tax::where('name', $taxname)->whereIn('status', [0, 1])->get();
        if (count($getTax) > 0) {
            return $data['msg'] = ['status' => 'success', 'msg' => 'Tax name already exist'];
        } else {
            return 0;
        }
    }

    public function getAditionalCharge(){
        $addCharge = GeneralSetting::where('url_key','additional-charge')->first();
        $data = [];
        if($addCharge->status){
           $charges = AdditionalCharge::where('status',1)->get();
           // $price = Input::get('price');
           $cart_amt = Helper::calAmtWithTax();
           $price = $cart_amt['total'] ;
           $amount= 0;
           $charge_list = array();
            foreach ($charges as $key => $charge) {
                if($charge['min_order_amt'] > 0){

                    if($price >= $charge['min_order_amt']){
                
                        if($charge->type == 1){
                            $charge_list[$charge->label] = $charge->rate;
                             $amount += $charge->rate;
                        }else{
                         $charge_list[$charge->label] = round($price*$charge->rate/100,2);
                            $amount += $price*$charge->rate/100; 
                            
                        }
                    }
                }else{
                        if($charge->type == 1){
                            $charge_list[$charge->label] = $charge->rate;
                             $amount += $charge->rate;
                        }else{
                         $charge_list[$charge->label] = round($price*$charge->rate/100,2);
                            $amount += $price*$charge->rate/100; 
                            
                        }
                }
            }
            $data['list'] = $charge_list;
            $data['total_amt'] = round($amount,2);
        }
        return json_encode($data);
    }

}

?>