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
use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Library\Helper;
use Session;
use DB;
use Validator;

class TaxController extends Controller {

    public function index() {
        $search = !empty(Input::get("search")) ? Input::get("search") : '';
        $search_fields = ['name','rate','tax_number'];
        
        $taxInfo = Tax::whereIn('status', [1, 0])->orderBy("id", "asc");
         $taxInfo = $taxInfo->where(function($query) use($search_fields, $search) {
            foreach ($search_fields as $field) {
                $query->orWhere($field, "like", "%$search%");
            }
        });
        if (!empty(Input::get("search"))) {
            $taxInfo = $taxInfo->get();
            $taxCount=$taxInfo->count();
        } else {
            $taxInfo = $taxInfo->paginate(Config('constants.paginateNo'));
            $taxCount=$taxInfo->total();
        }
        $data = ['taxInfo' => $taxInfo,'taxCount' =>$taxCount];
        $viewname = Config('constants.adminTaxView') . '.index';
        return Helper::returnView($viewname, $data);
    }

    public function add() {
        $tax = new Tax();
        $action = route("admin.tax.save");
        $data = ['tax' => $tax, 'action' => $action];
        $viewname = Config('constants.adminTaxView') . '.addEdit';
        return Helper::returnView($viewname, $data);
    }

    public function edit() {
        $tax = Tax::find(Input::get('id'));
        $action = route("admin.tax.save");
        $data = ['tax' => $tax, 'action' => $action];
        $viewname = Config('constants.adminTaxView') . '.addEdit';
        return Helper::returnView($viewname, $data);
    }

    public function save() {
        $categoryIds = explode(",", Input::get('CategoryIds'));
        $productIds = explode(",", Input::get('ProductIds'));
        $taxNew = Tax::findOrNew(Input::get('id'));
        $taxNew->label = Input::get('label');
        $taxNew->name = Input::get('label');  //Input::get('name');
        $taxNew->rate = Input::get('rate');
        $taxNew->tax_number = Input::get('tax_number');
        $taxNew->status = Input::get('status');
        $taxNew->save();
        if (Input::get('id') != '')
            Session::flash("msg", "Tax updated successfully.");
        else
            Session::flash("msg", "Tax added successfully.");
        $viewname = Config('constants.adminTaxView') . '.index';
        $data = ['status' => '1', 'msg' => (Input::get('id') != '') ? 'Tax updated successfully.' : 'Tax added successfully.', 'taxinfo' => $taxNew];
        return Helper::returnView($viewname, $data, $url = 'admin.tax.view');
    }

    public function delete() {
        //  $tax = Tax::find(Input::get('id'));
        $getCount = Category::whereHas('cat_tax', function($q) {
                    $q->where('tax_id', Input::get('id'));
                })->count();
      
        if ($getCount <= 0) {
            $tax = Tax::find(Input::get('id'));
            $tax->delete();
            Session::flash("message", "Tax deleted successfully.");
            $data = ['status' => '1', 'msg' => 'Tax deleted successfully.'];
           // return Helper::returnView($viewname, $data, $url = 'admin.tax.view');
        } else {
             Session::flash("message", "Sorry, This Tax is part of a product category. Delete the category first.");
           $data = ['status' => '0', 'msg' => 'Sorry this Tax is part of a product category. Delete the category first.'];
        }
         $viewname = Config('constants.adminTaxView') . '.index';
         return Helper::returnView($viewname, $data, $url = 'admin.tax.view');
       
    }

    public function changeStatus() {
        $tax = Tax::find(Input::get('id'));
        if ($tax->status == 1) {
            $taxStatus = 0;
            $msg = "Tax disabled successfully.";
            $tax->status = $taxStatus;
            $tax->update();
            Session::flash("message", $msg);
            $data = ['status' => '1', 'msg' => $msg];
            $viewname = Config('constants.adminTaxView') . '.index';
            return Helper::returnView($viewname, $data, $url = 'admin.tax.view');
        } else if ($tax->status == 0) {
            $taxStatus = 1;
            $msg = "Tax enabled successfully.";
            $tax->status = $taxStatus;
            $tax->update();
            Session::flash("msg", $msg);
            $data = ['status' => '1', 'msg' => $msg];
            $viewname = Config('constants.adminTaxView') . '.index';
            return Helper::returnView($viewname, $data, $url = 'admin.tax.view');
        }
    }
    
     public function checkTax() {
         // $taxname = Input::all('name');
      //  dd(Input::all());
        $id = Input::get('id');
         $validator = Validator::make(Input::all(), ['name' => 'required|unique:tax,name,'.$id]);
        if($validator->fails()){
          return $data['msg'] = ['status' => 'success', 'msg' => 'Tax name already exist'];
        }
        return 0;
        // echo 'successfully';
        // exit;
        // $getTax = Tax::where('name', $taxname)->whereIn('status', [0, 1])->get();
        // //dd($getTax);
        // if (count($getTax) > 0) {
        //     return $data['msg'] = ['status' => 'success', 'msg' => 'Tax name already exist'];
        // } else {
        //     return 0;
        // }
    }

}

?>