<?php

namespace App\Http\Controllers\Admin;

use Route;
use Input;
use Session;
use App\Models\Attribute;
use App\Models\AttributeSet;
use App\Models\AttributeType;
use App\Models\AttributeValue;
use App\Http\Controllers\Controller;
use App\Library\Helper;
use DB;

class AttributesController extends Controller {

    public function index() {
        $attrs = Attribute::whereIn('status',[0,1])->orderBy("id", "asc");      
        if (!empty(Input::get("attr_name"))) {
            $attrs = $attrs->where("attr", "like", Input::get("attr_name") . "%")->get();
            $attrsCount=$attrs->count();
        }else{
              $attrs = $attrs->paginate(Config('constants.paginateNo'));
              $attrsCount=$attrs->total();
        }

        $startIndex = 1;
        $getPerPageRecord = Config('constants.paginateNo');
        $allinput = Input::all();
        if(!empty($allinput) && !empty(Input::get('page')))
        {
            $getPageNumber = $allinput['page'];
            $startIndex = ( (($getPageNumber) * ($getPerPageRecord)) - $getPerPageRecord) + 1;
            $endIndex = (($startIndex+$getPerPageRecord) - 1);

            if($endIndex > $attrsCount)
            {
                $endIndex = ($attrsCount);
            }
        }
        else
        {
            $startIndex = 1;
            $endIndex = $getPerPageRecord;
            if($endIndex > $attrsCount)
            {
                $endIndex = ($attrsCount);
            }
        }
        return view(Config('constants.adminAttrView') . '.index', compact('attrs','attrsCount','startIndex','endIndex'));
    }

    public function add() {
        $attrs = Attribute::where('status', 1)->orderBy("id", "asc");
        $attrSets = array();
        $attrS = AttributeSet::get(['id', 'attr_set'])->toArray();
        foreach ($attrS as $val) {
            $attrSets[$val['id']] = $val['attr_set'];
        }
        $attrSetsSelected = [];
        $attr_types = array(0 => 'Select Attribute Type');
        $attr_t = AttributeType::all()->toArray();

        foreach ($attr_t as $val) {
            $attr_types[$val['id']] = $val['attr_type'];
        }
        $action = route("admin.attributes.save");
        return view(Config('constants.adminAttrView') . '.addEdit', compact('attrs', 'attrSets', 'action', 'attr_types', 'attrSetsSelected'));
    }

    public function edit() {
        $attrs = Attribute::find(Input::get('id'));
        $attrSets = array();
        $attrS = AttributeSet::get(['id', 'attr_set'])->toArray();
        foreach ($attrS as $val) {
            $attrSets[$val['id']] = $val['attr_set'];
        }
        $attrSetsSelected = [];
        $attss = $attrs->attributesets->toArray();
        foreach ($attss as $val) {
            array_push($attrSetsSelected, $val['id']);
        }
        $attr_types = array("" => 'Select Attribute Type');
        $attr_t = AttributeType::all()->toArray();
        foreach ($attr_t as $val) {
            $attr_types[$val['id']] = $val['attr_type'];
        }
        $action = route("admin.attributes.save");
        return view(Config('constants.adminAttrView') . '.addEdit', compact('attrs', 'attrSets', 'action', 'attr_types', 'attrSetsSelected'));
    }

    public function save() {
        $attr = Attribute::findOrNew(Input::get('id'));
        $attr->attr = Input::get('attr');
        $attr->attr_type = Input::get('attr_type');
        $attr->is_filterable = Input::get('is_filterable');
        $attr->placeholder = Input::get('placeholder');
        $attr->att_sort_order = Input::get('att_sort_order');
        $attr->is_required = Input::get('is_required');
        $attr->status = Input::get('status');
        $attr->save();
        $attr->attributesets()->sync(Input::get('attr_set'));
       // dd(Input::all());
        if (Input::get('option_name')) {
            foreach (Input::get('option_name') as $key => $val) {
                $attrval = AttributeValue::findOrNew(Input::get('idd')[$key]);
                $attrval->option_name = Input::get('option_name')[$key];
                $attrval->option_value = Input::get('option_value')[$key];
                $attrval->is_active = Input::get('is_active')[$key];
                $attrval->sort_order = Input::get('sort_order')[$key];
                $attrval->attr_id = $attr->id;
                $attrval->save();
            }
        }
         if(empty(Input::get('id'))){
          Session::flash("msg", "Attribute added successfully.");  
         }else{
             Session::flash("msg", "Attribute updated successfully.");   
        }
    
    $etxradetail = Input::get('etxradetail') ;
    if(isset($etxradetail) && $etxradetail == 1){
        return redirect()->route('admin.products.attribute',['id' => Input::get('prod_id')]);
    }
        return redirect()->route('admin.attributes.view');
    
    }

    public function delete() {
        $attr = Attribute::find(Input::get('id'));
        $productAttrs = DB::table('has_options')->where("attr_id", Input::get("id"))->get();
        if (count($productAttrs) > 0) {
            // Attribute::find(Input::get('id'))->attributesets()->detach();
            // Attribute::find(Input::get('id'))->attributeoptions()->delete();
            // $attr->delete();

            $attrSets = Attribute::find(Input::get('id'));
            $attrSets->attributesets()->detach();
            $attrSets->attributeoptions()->detach();
            //$attrSets->status = 2;
            $attrSets->delete();
            return redirect()->back()->with("message", "Attribute deleted successfully.");
        } else {

            return redirect()->back()->with("message", "Sorry, This Attribute is the part of a product. Delete the product first.");
        }
    }

    public function checkExistingAttr() {
        $attr = Input::get('attr');
        $attr = Attribute::where('attr', $attr)->whereIn('status', [0, 1])->get();
        if (count($attr) > 0) {
            return $data['msg'] = ['status' => 'success', 'msg' => 'Attribute name is already exist'];
        } else {
            return 0;
        }
    }

    public function changeStatus() {
        $attr = Attribute::find(Input::get('id'));
        if ($attr->status == 1) {
            $attrStatus = 0;
            $msg = "Attribute disabled successfully.";
            $attr->status = $attrStatus;
            $attr->update();
            return redirect()->back()->with('message', $msg);
        } else if ($attr->status == 0) {
            $attrStatus = 1;
            $msg = "Attribute enabled successfully.";
            $attr->status = $attrStatus;
            $attr->update();
            return redirect()->back()->with('msg', $msg);
        }
    }

}
