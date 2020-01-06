<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DynamicLayout;
use Input;
use Session;

class DynamicLayoutController extends Controller
{

    public function index()
    {
        $layout = DynamicLayout::orderBy("id", "desc")->paginate(Config('constants.paginateNo'));
        return view(Config('constants.adminDynamicLayoutView') . '.index', compact('layout'));
    }

    public function addEdit()
    {
        $layout = DynamicLayout::findOrNew(Input::get('id'));
        $action = route("admin.dynamicLayout.save");
        return view(Config('constants.adminDynamicLayoutView') . '.addEdit', compact('layout', 'action'));
    }

    public function save()
    {
        $layout = DynamicLayout::findOrNew(Input::get('id'));
        $layout->name = Input::get('name');
        $layout->description = Input::get('description');
        $layout->url = Input::get('url');
        $layout->sort_order = Input::get('sort_order');
        $layout->status = Input::get('status');
        $layout->store_id = Session::get('store_id');
        if (Input::hasFile('image')) {
            $destinationPath = Config('constants.layoutUploadPath');
            $fileName = date("YmdHis") . "." . Input::file('image')->getClientOriginalExtension();
            $upload_success = Input::file('image')->move($destinationPath, $fileName);
            if (!empty($upload_success)) {
                $layout->image = $fileName;
            } else {

            }
        }
        $layout->save();
        //dd($layout);
        if (empty(Input::get("id"))) {
            Session::flash("msg", "Dynamic Layout added successfully.");
        } else {

            Session::flash("msg", "Dynamic Layout updated successfully.");
        }

        return redirect()->route('admin.dynamicLayout.view');
    }

    public function changeStatus()
    {

        $id = Input::get('id');

        $updateDyn = DynamicLayout::find($id);
        if ($updateDyn->status == 1) {
            $attrStatus = 0;
            $updateDyn->status = $attrStatus;
            $msg = "Dynamic Layout disabled successfully.";
            Session::flash("message", $msg);
            $updateDyn->update();
            return redirect()->back()->with('message', $msg);
        } else if ($updateDyn->status == 0) {
            $attrStatus = 1;
            $updateDyn->status = $attrStatus;
            $msg = "Dynamic Layout enabled successfully.";
            Session::flash("msg", $msg);
            $updateDyn->update();
            return redirect()->back()->with('msg', $msg);
        }

    }

    public function Delete()
    {
        $updateDyn = DynamicLayout::find(Input::get("id"));
        $msg = "Dynamic Layout deleted successfully.";
        //   Session::flash("message",$msg);
        // $updateDyn->delete();
        return redirect()->back()->with('message', $msg);
    }

}
