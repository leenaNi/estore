<?php

namespace App\Http\Controllers\Admin;

use Route;
use Input;
use App\Models\OrderStatus;
use App\Http\Controllers\Controller;
use App\Library\Helper;
use Session;
use Illuminate\Http\Request;
use DB;
use Validator;

class OrderStatusController extends Controller {

    public function index() {
        $search = !empty(Input::get("order_status")) ? Input::get("order_status") : '';
        $search_fields = ['order_status'];
        
        if($search != ""){
            $orderstatusInfo = OrderStatus::where(function($query) use($search_fields, $search) {
                foreach ($search_fields as $field) {
                    $query->orWhere($field, "like", "%$search%");
                }
            })->get();
            $orderstatusCount=$orderstatusInfo->count();
        } else {
            $orderstatusInfo = OrderStatus::paginate(Config('constants.paginateNo'));
              $orderstatusCount=$orderstatusInfo->total();
        }
        $data = ['orderstatusInfo' => $orderstatusInfo,'orderstatusCount' =>$orderstatusCount];
        $viewname = Config('constants.adminOrderStatusView') . '.index';
        return Helper::returnView($viewname, $data);
    }

    public function add() {
        $status = new OrderStatus();
        $action = route("admin.order_status.save");
        $data = ['status' => $status, 'action' => $action, 'new' => '1'];
        $viewname = Config('constants.adminOrderStatusView') . '.addEdit';
        return Helper::returnView($viewname, $data);
    }

    public function edit() {
        $status = OrderStatus::find(Input::get('id'));
        $action = route("admin.order_status.update");
        $data = ['status' => $status, 'action' => $action, 'new' => '0'];
        $viewname = Config('constants.adminOrderStatusView') . '.addEdit';
        return Helper::returnView($viewname, $data);
    }

    public function save(Request $request) {
        Validator::make($request->all(), [
            'order_status' => 'required',
            ],[
            'page_name.required' => 'The order status field is required.',
        ])->validate();

        $formData = $request->all();
        
        OrderStatus::create($formData);
        Session::flash("msg", "Order status added successfully.");
        $viewname = Config('constants.adminOrderStatusView') . '.index';
        $data = ['status' => '1'];
        return Helper::returnView($viewname, $data, $url = 'admin.order_status.view');
    }

    public function update(Request $request){
        Validator::make($request->all(), [
            'order_status' => 'required',
            ],[
            'order_status.required' => 'The order status field is required.',
        ])->validate();

        $status = OrderStatus::find($request->id);
        $formData = $request->all();
        $status->update($formData);
        Session::flash("msg", "Order status updated successfully.");
        $viewname = Config('constants.adminOrderStatusView') . '.index';
        $data = ['status' => '1', 'msg' => (Input::get('id') != '') ? 'Contact updated successfully' : 'Contact added successfully'];
        return Helper::returnView($viewname, $data, $url = 'admin.order_status.view');
    }

    public function delete(Request $request) {
        $status = OrderStatus::find($request->id);
        $status->delete();
        Session::flash("message", "Order status deleted successfully.");
        $data = ['status' => '1', 'msg' => 'Contact deleted successfully.'];
        $viewname = Config('constants.adminOrderStatusView') . '.index';
        return Helper::returnView($viewname, $data, $url = 'admin.order_status.view');
    }

    public function changeStatus(Request $request) {
        $status = OrderStatus::find($request->id);
        if($status->status == 1) {
            $status->status = 0;
            $msg = "Order status disabled successfully.";
            Session::flash("message", $msg);
        }else{
            $status->status = 1;
            $msg = "Order status enabled successfully.";
              Session::flash("msg", $msg);
        }
        $status->update();
       
        $data = ['status' => '1', 'msg' => $msg];
        $viewname = Config('constants.adminOrderStatusView') . '.index';
        return Helper::returnView($viewname, $data, $url = 'admin.order_status.view');
    }

    public function getDescription(Request $request){
        $page = StaticPage::find($request->page_id);
        return response()->json(['description' => $page->description]);
    }
}
