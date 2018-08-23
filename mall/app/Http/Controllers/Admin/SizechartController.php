<?php

namespace App\Http\Controllers\Admin;

use Input;
use App\Models\Role;
use Hash;
use Auth;
use Session;
use App\Http\Controllers\Controller;
use App\Models\Sizechart;
use Mail;

class SizechartController extends Controller {

    public function index() {
        $sizechart = Sizechart::orderBy("id", "desc")->paginate(Config('constants.paginateNo'));
        return view(Config('constants.adminSizeChartView') . '.index', compact('sizechart'));
    }

    public function edit() {
        $sizechart = Sizechart::findOrNew(Input::get('id'));
        $action = route("admin.sizechart.save");
        return view(Config('constants.adminSizeChartView') . '.addEdit', compact('sizechart', 'action'));
    }

    public function save() {
       //print_r(Input::hasFile('image'));
       //dd(Input::all());
        $size = Sizechart::findOrNew(Input::get('id'));
        $size->name = Input::get('name');
        $size->status = Input::get('status');
        if(Input::hasFile('image')) {
           // dd('FGDFg');
            $destinationPath = Config('constants.sizeChartUploadPath');
            $fileName = date("YmdHis") . "." . Input::file('image')->getClientOriginalExtension();
            $upload_success = Input::file('image')->move($destinationPath, $fileName);
            if (!empty($upload_success)) {
                $size->image = $fileName;
            } else {
                
            }
        }
        $size->save();
        return redirect()->route('admin.sizechart.view');
    }

    public function changeStatus() {

        $id = Input::get('id');
        $status = Input::get('status');

        $updateDyn = Sizechart::find($id);
        $updateDyn->status = ($status == 1) ? 0 : 1;
        $updateDyn->update();
        
       return $updateDyn->status;
    }

}
