<?php

namespace App\Http\Controllers\Admin;

use Route;
use Input;
use App\Models\User;
use App\Library\Helper;
use App\Models\Loyalty;
use Auth;
use App\Models\Permission;
use App\Http\Controllers\Controller;
use Session;
use DB;

class LoyaltyController extends Controller {

    public function index() {
        $search = !empty(Input::get("search")) ? Input::get("search") : '';
        $search_fields = ['group'];
        $loyalty = Loyalty::orderBy("id", "asc");
        $loyalty = $loyalty->where(function($query) use($search_fields, $search) {
            foreach ($search_fields as $field) {
                $query->orWhere($field, "like", "%$search%");
            }
        });
        if (!empty(Input::get("search"))) {
            $loyalty = $loyalty->get();
            $loyaltyCount=$loyalty->count();
        } else {
            $loyalty = $loyalty->paginate(Config('constants.paginateNo'));
            $loyaltyCount=$loyalty->total();
        }

        $startIndex = 1;
        $getPerPageRecord = Config('constants.paginateNo');
        $allinput = Input::all();
        if(!empty($allinput) && !empty(Input::get('page')))
        {
            $getPageNumber = $allinput['page'];
            $startIndex = ( (($getPageNumber) * ($getPerPageRecord)) - $getPerPageRecord) + 1;
            $endIndex = (($startIndex+$getPerPageRecord) - 1);

            if($endIndex > $loyaltyCount)
            {
                $endIndex = ($loyaltyCount);
            }
        }
        else
        {
            $startIndex = 1;
            $endIndex = $getPerPageRecord;
            if($endIndex > $loyaltyCount)
            {
                $endIndex = ($loyaltyCount);
            }
        }

        //return view(Config('constants.loyaltyView') . '.index', compact('loyalty'));
        $viewname = Config('constants.loyaltyView') . '.index';
        $data = ['loyalty' => $loyalty ,'loyaltyCount' =>$loyaltyCount, 'startIndex' => $startIndex,'endIndex' => $endIndex];
        return Helper::returnView($viewname, $data);
    }

    public function add() {
        $loyalty = new Loyalty;
        $action = route('admin.loyalty.save');
        // return view(Config('constants.loyaltyView') . '.addEdit', compact('loyalty', 'action'));
        $viewname = Config('constants.loyaltyView') . '.addEdit';
        $data = ['loyalty' => $loyalty, 'action' => $action];
        return Helper::returnView($viewname, $data);
    }

    public function edit() {

        $loyalty = Loyalty::find(Input::get('id'));
        $action = route('admin.loyalty.update');

        // return view(Config('constants.loyaltyView') . '.addEdit', compact('loyalty', 'action'));

        $viewname = Config('constants.loyaltyView') . '.addEdit';
        $data = ['loyalty' => $loyalty, 'action' => $action];
        return Helper::returnView($viewname, $data);
    }

    public function save() {
        //dd(Input::all());
        $loyalty = Loyalty::create();
        $loyalty->group = Input::get('group');
        $loyalty->min_order_amt = Input::get('min_order_amt');
        $loyalty->max_order_amt = Input::get('max_order_amt');
        $loyalty->percent = Input::get('percent');
        $loyalty->store_id = Session::get('store_id');
        $loyalty->save();
        Session::flash('msg', 'Loyalty program added successfully.');
        //return redirect()->route("admin.loyalty.view");
        $viewname = '';
        $url = 'admin.loyalty.view';
        $data = ['status' => '1', 'msg' => 'Loyalty group added successfully'];
        return Helper::returnView($viewname, $data, $url);
    }

    public function update() {
        //dd(Input::all());
        $loyalty = Loyalty::find(Input::get('id'));
        $loyalty->group = Input::get('group');
        $loyalty->min_order_amt = Input::get('min_order_amt');
        $loyalty->max_order_amt = Input::get('max_order_amt');
        $loyalty->percent = Input::get('percent');
        $loyalty->store_id = Session::get('store_id');
        $loyalty->update();
        if ($loyalty->update()) {
            Session::flash('msg', 'Loyalty program updated successfully.');
        }
        // return redirect()->route("admin.loyalty.view");

        $viewname = '';
        $url = 'admin.loyalty.view';
        $data = ['status' => '1', 'msg' => 'Loyalty group updated successfully'];
        return Helper::returnView($viewname, $data, $url);
    }

    public function delete() {
        $id =Input::get('id');
      
        $getCount = User::where('loyalty_group',$id)->count();
         
        if ($getCount <= 0) {
            $attrSets = Loyalty::find($id);
           
            $attrSets->delete();
            Session::flash("message", "Loyalty group deleted successfully.");
            $data = ['status' => '1', 'message' => 'Loyalty Group deleted successfully.'];
           // return redirect()->back()->with('message', 'Loyalty Group deleted successfully.');
        } else {
             Session::flash("message", "Sorry, This Loyalty group is part of a customer group. Delete the customer first.");
           $data = ['status' => '0', 'msg' => 'Sorry, This Loyalty group is part of a customer group. Delete the customer first.'];
            //return redirect()->back()->with('message', 'Sorry This Loyalty Group is part of a customer group! Delete the customer first!');
        }
       // return redirect()->route("admin.loyalty.view");
         Session::flash("message", "Loyalty group deleted successfully.");
        $viewname = Config('constants.loyaltyView') . '.index';
        return Helper::returnView($viewname, $data, $url = 'admin.loyalty.view');
    }

    public function changeStatus() {
         $viewname = Config('constants.loyaltyView') . '.index';
          $url = 'admin.loyalty.view';
        $lty = Loyalty::find(Input::get('id'));
        if ($lty->status == 1) {
            $ltyStatus = 0;
            $msg = "Loyalty disabled successfully.";
            $lty->status = $ltyStatus;
            $lty->update();
             Session::flash("message", $msg);
         
            $data = ['status' => '1', 'msg' => 'Loyalty disabled successfully.'];
            return Helper::returnView($viewname, $data,$url);
        } else if ($lty->status == 0) {
            $ltyStatus = 1;
            $msg = "Loyalty enabled successfully.";
            $lty->status = $ltyStatus;
            $lty->update();
             Session::flash("msg", $msg);
           
            $data = ['status' => '1', 'msg' => 'Loyalty disabled successfully.'];
            return Helper::returnView($viewname, $data,$url);
        }
    }
    
    public function checkName(){
        $loyalty=Input::get("loyaltyName");
        $loyaltyes=Loyalty::where(DB::raw("LOWER(`group`)"),strtolower($loyalty))->get();
        return $loyaltyes;
    }
    
    public function checkRange(){
        $minimumAmt=Input::get("minimum");
        $maximumAmt=Input::get("maximum");
        $loyaltyes=Loyalty::where('min_order_amt','>=',$minimumAmt)->Orwhere('max_order_amt','>=',$maximumAmt)->get(); 
        return $loyaltyes;
    }
}

?>