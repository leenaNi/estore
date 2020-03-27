<?php

namespace App\Http\Controllers\Admin;

use Route;
use Input;
use Session;
use App\Models\AttributeSet;
use App\Models\Product;
use App\Http\Controllers\Controller;

class AttributeSetsController extends Controller {

    public function index() {
        $attrSets = AttributeSet::whereIn('status', [0, 1])->orderBy("id", "asc");

        if (!empty(Input::get("attr_set_name"))) {
            $attrSets = $attrSets->where("attr_set", "like","%". Input::get("attr_set_name") . "%")->get();
            $attrCount=$attrSets->count();
        }else{
           $attrSets = $attrSets->paginate(Config('constants.paginateNo'));  
           $attrCount=$attrSets->total();
        }

        
      //  $attrSets = $attrSets->paginate(Config('constants.paginateNo'));
      //  dd($attrSets);

        $startIndex = 1;
        $getPerPageRecord = Config('constants.paginateNo');
        $allinput = Input::all();
        if(!empty($allinput) && !empty(Input::get('page')))
        {
            $getPageNumber = $allinput['page'];
            $startIndex = ( (($getPageNumber) * ($getPerPageRecord)) - $getPerPageRecord) + 1;
            $endIndex = (($startIndex+$getPerPageRecord) - 1);

            if($endIndex > $attrCount)
            {
                $endIndex = ($attrCount);
            }
        }
        else
        {
            $startIndex = 1;
            $endIndex = $getPerPageRecord;
            if($endIndex > $attrCount)
            {
                $endIndex = ($attrCount);
            }
        }


        return view(Config('constants.adminAttrSetView') . '.index', compact('attrSets','attrCount','startIndex','endIndex'));
    }

    public function add() {
        $attrSets = new AttributeSet();
        $action = route("admin.attribute.set.save");
        return view(Config('constants.adminAttrSetView') . '.addEdit', compact('attrSets', 'action'));
    }

    public function edit() {
        $attrSets = AttributeSet::find(Input::get('id'));
        $action = route("admin.attribute.set.save");
        return view(Config('constants.adminAttrSetView') . '.addEdit', compact('attrSets', 'action'));
    }

    public function save() {
        $attrSets = AttributeSet::findOrNew(Input::get('id'));
        $attrSets->status = 1;
        $attrSets->attr_set = Input::get('attr_set');
        $attrSets->store_id = Session::get('store_id');
        $attrSets->save();
        if(empty(Input::get('id'))){
          Session::flash("msg", "Variant set added successfully.");  
         }else{
             Session::flash("msg", "Variant set updated successfully.");   
        }
        return redirect()->route('admin.attribute.set.view');
    }

    public function delete() {
        $id = Input::get('id');
        $getcount = Product::where("attr_set", "=", $id)->count();
        if ($getcount <= 0) {
            $attrSets = AttributeSet::find($id);
            $attrSets->attributes()->detach();
            //$attrSets->status = 2;
            $attrSets->delete();
            Session::flash("message", "Variant set deleted successfully."); 
            // AttributeSet::find($id)->delete();
            return redirect()->back()->with('message', 'Variant set deleted successfully.');
        } else {
            return redirect()->back()->with('message', 'Sorry, This Variant set is the part of a product. Delete the product first.');
        }
    }

    public function checkExistingAttrSet() {
        $attrset = Input::get('attrset');
        $attrSets = AttributeSet::where('attr_set', $attrset)->whereIn('status', [0, 1])->get();
        if (count($attrSets) > 0) {
            return $data['msg'] = ['status' => 'success', 'msg' => 'Variant set name is already exist'];
        } else {
            return 0;
        }
    }

    public function changeStatus() {
        $attr = AttributeSet::find(Input::get('id'));
        if ($attr->status == 1) {
            $attrStatus = 0;
            $msg = "Variant set disabled successfully.";
            $attr->status = $attrStatus;
            $attr->update();
            return redirect()->back()->with('message', $msg);
        } else if ($attr->status == 0) {
            $attrStatus = 1;
            $msg = "Variant set enabled successfully.";
            $attr->status = $attrStatus;
            $attr->update();
            return redirect()->back()->with('msg', $msg);
        }
    }

}
