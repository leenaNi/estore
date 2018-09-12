<?php

namespace App\Http\Controllers\Admin;

use Route;
use Input;
use App\Library\Helper;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\Courier;
use DB;
use Session;

class CourierController extends Controller {

    public function index() {
        $couriers = Courier::orderBy('created_at', 'DESC')->paginate(Config('constants.paginateNo'));
        //  dd($couriers);
        return Helper::returnView(Config('constants.AdminPagesCourier') . '.index', compact('couriers'));
    }

    public function add() {
        $courier = new Courier;
        $action = route("admin.courier.save");

        return view(Config('constants.AdminPagesCourier') . '.addEdit', compact('courier', 'action'));
    }

    public function save() {
         $courier = Courier::findOrNew(Input::get('id'));
         $courier->charges = round(Input::get('charges')*(1/Session::get("currency_val")),2);
         $courier->save();
        Session::flash("msg", "Courier service added successfully.");
        return redirect()->route('admin.courier.view');
    }

    public function edit() {
        $courier = Courier::where("url_key", Input::get('url_key'))->first();
        $action = route("admin.courier.update");
        return view(Config('constants.AdminPagesCourier') . '.addEdit', compact('courier', 'action'));
    }

    public function update() {
        $courier = Courier::find(Input::get('id'));
        $courier->update(Input::except(['details']));
        $courier->charges = round(Input::get('charges')*(1/Session::get("currency_val")),2);
        $courier->details = !is_null(Input::get('details')) ? json_encode(Input::get('details')) : '';
        $courier->update();
        Session::flash("msg", "Courier service updated successfully.");
        return redirect()->route('admin.courier.view');
    }

    public function delete() {
        $courier = Courier::find(Input::get('id'));
        $courier->delete();
        Session::flash("messege", "Courier service deleted successfully.");
        return redirect()->route('admin.courier.view');
    }
    public function changeStatus() {
        $courier = Courier::find(Input::get('id'));
        if ($courier->status == 1) {
            $courierStatus = 0;
            $msg = "Courier service disabled successfully.";
            $courier->status = $courierStatus;
            $courier->update();
            return redirect()->back()->with('message', $msg);
        } else if ($courier->status == 0) {
            $courierStatus = 1;
            $msg = "Courier service enabled successfully.";
            $courier->status = $courierStatus;
            $courier->update();
            return redirect()->back()->with('msg', $msg);
        }
    }
    

}
