<?php

namespace App\Http\Controllers\Admin;

use Route;
use Input;
use App\Models\Product;
use App\Models\OrderStatus;
use App\Models\PaymentMethod;
use App\Models\PaymentStatus;
use App\Models\Order;
use App\Models\Flags;
use App\Models\OrderFlagHistory;
use App\Http\Controllers\Controller;
use Session;

class FlagController extends Controller {

    public function index() {

        $search = !empty(Input::get("search")) ? Input::get("search") : '';
        $search_fields = ['flag'];

        $flags = Flags::orderBy("id", "asc");
        $flags = $flags->where(function($query) use($search_fields, $search) {
            foreach ($search_fields as $field) {
                $query->orWhere($field, "like", "%$search%");
            }
        });

        $flags = $flags->paginate(Config('constants.paginateNo'));
        return view(Config('constants.adminFlagsView') . '.index', compact('flags'));
    }

    public function add() {
        $flags = new Flags;
        $action = route('admin.miscellaneous.saveFlag');
        return view(Config('constants.adminFlagsView') . '.addEdit', compact('flags', 'action'));
       
    }  

    public function edit() {
        $flags = Flags::find(Input::get('id'));
        $action = route('admin.miscellaneous.updateFlag');
        return view(Config('constants.adminFlagsView') . '.addEdit', compact('flags', 'action'));
    }

    public function save() {
        $flags = Flags::findOrNew(Input::get('id'));
        $flags->flag = Input::get('flag');
        $flags->store_id = Session::get('store_id');
        if (Input::get('value') == '') {
            $flags->value = 0;
        } else {
            $flags->value ='#'.Input::get('value');
        }
        $flags->desc = Input::get('desc');
        $flags->status = Input::get('status');
        $flags->save();
         Session::flash("msg", "Flag added successfully.");
        return redirect()->route("admin.miscellaneous.flags");
    }

    public function update() {
        
        $flags = Flags::find(Input::get('id'));
        $flags->fill(Input::all());
        $flags->value= "#".Input::get('value');
        $flags->store_id = Session::get('store_id');
        $flags->save();
       // dd($flags);
        return redirect()->route("admin.miscellaneous.flags")->with("msg", "Flag updated successfully.");
    }

    public function delete() {
        $flags = Flags::find(Input::get('id'));
        $flags->delete();
        return redirect()->route("admin.miscellaneous.flags")->with("message", "Flag deleted successfully.");
    }



}
