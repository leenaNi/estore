<?php

namespace App\Http\Controllers\Admin;

use Route;
use Input;
use App\Models\Category;
use App\Library\Helper;
use App\Classes\UploadHandler;
use App\Http\Controllers\Controller;
use App\Models\CatalogImage;
use App\Models\Tax;
use App\Models\Product;
use App\Models\HasTaxes;
use App\Models\HasCurrency;
use App\Models\Vendor;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\User;
use App\Models\GeneralSetting;
use App\Models\ProductType;
use App\Models\AttributeSet;
use App\Models\UnitMeasure;
use DB;
use Session;

class RawMaterialController extends Controller {
	
	public function index() {

	  $barcode = GeneralSetting::where('url_key', 'barcode')->get()->toArray()[0]['status'];
        $products = Product::where('prod_type',6);
        $categoryA = Category::get(['id', 'category'])->toArray();
         $rootsS = Category::roots()->get();
        $category = [];
        foreach ($categoryA as $val) {
            $category[$val['id']] = $val['category'];
        }
        $userA = User::get(['id', 'firstname', 'lastname'])->toArray();
        $user = [];
        foreach ($userA as $val) {
            $user[$val['id']] = $val['firstname'] . ' ' . $val['lastname'];
        }
        if (!empty(Input::get('product_name'))) {
            $products = $products->where('product', 'like', "%" . Input::get('product_name') . "%");
        }

        if (Input::get('status') == '0' || Input::get('status') == '1') {
            $products = $products->where('status', Input::get('status'));
        }

        if (!empty(Input::get('updated_by'))) {
            $products = $products->where('updated_by', Input::get('updated_by'));
        }
        if (!empty(Input::get('datefrom'))) {
            $date = date("Y-m-d", strtotime(Input::get('datefrom')));
            $products = $products->where('created_at', '>=', $date);
        }
        if (!empty(Input::get('dateto'))) {
            $date = date("Y-m-d", strtotime(Input::get('dateto')));
            $products = $products->where('created_at', '<=', $date);
        }

        if (!empty(Input::get('prdSearch'))) {
            $products = $products->sortable()->get();
            $productCount=$products->count();
           
        } else {

            $products = $products->sortable()->paginate(Config('constants.paginateNo'));
            $productCount=$products->total();
        }

        foreach ($products as $prd) {
            $getPrdImg = ($prd->catalogimgs()->where("image_mode", 1)->count() > 0)?$prd->catalogimgs()->where("image_mode", 1)->first()->filename:'default_product.png';
            $prd->prodImage = asset(Config('constants.productImgPath').@$getPrdImg);
        }

        return Helper::returnView(Config('constants.adminMaterialView') . '.index', compact('products', 'category', 'user', 'barcode','rootsS' ,'productCount'));
        
    }


    public function add(){
    	$barcode = GeneralSetting::where('url_key', 'barcode')->get()->toArray()[0]['status'];
        $prod = new Product;

        $unit_measure = [''=>'Select Unit'] + UnitMeasure::where('status',1)->pluck('unit','id')->toArray();

        $action = route("admin.raw-material.save");
       
        return view(Config('constants.adminMaterialView') . '.addEdit', compact('prod', 'action', 'barcode','unit_measure'));
    
    }

    public function save(){
    	Product::create(Input::all());
    	Session::flash("msg", "Raw material added successfully.");
    	return redirect()->route('admin.raw-material.view');
    }


    public function edit(){
        $barcode = GeneralSetting::where('url_key', 'barcode')->get()->toArray()[0]['status'];
    	$prod = Product::findOrFail(Input::get('id'));

    	$action = route("admin.raw-material.update");

    	$unit_measure = [''=>'Select Unit'] + UnitMeasure::where('status',1)->pluck('unit','id')->toArray();

        return view(Config('constants.adminMaterialView') . '.addEdit', compact('prod', 'action', 'barcode','unit_measure'));
    }

    public function update(){
    	$prod = Product::find(Input::get('id'));
    	$prod->update(Input::all());
    	Session::flash("msg", "Raw material updated successfully.");
    	return redirect()->route('admin.raw-material.view');
    }

    public function delete(){
    	$prod = Product::find(Input::get('id'));
    	$prod->delete();
    	Session::flash("message", "Raw material deleted successfully.");
    	return redirect()->back();
    }

    public function checkStatus() {
     
          $prod = Product::find(Input::get('id'));
        //dd($prod);
       if ($prod->status == 1) {
            $prodStatus = 0;
            $msg = "Raw material disabled successfully.";
            $prod->status = $prodStatus;
            $prod->update();
            Session::flash("message", $msg);
            return redirect()->back()->with('message', $msg);
            // $data = ['status' => '1', 'msg' => $msg];
            // $viewname = Config('constants.adminProductView') . '.index';
            // return Helper::returnView($viewname, $data, $url = 'admin.products.view');
        } else if ($prod->status == 0) {
            $prodStatus = 1;
            $msg = "Raw material  enabled successfully.";
            $prod->status = $prodStatus;
            $prod->update();
             Session::flash("msg", $msg);
            return redirect()->back()->with('msg', $msg);
            // Session::flash("msg", $msg);
            // $data = ['status' => '1', 'msg' => $msg];
            // $viewname = Config('constants.adminProductView') . '.index';
            // return Helper::returnView($viewname, $data, $url = 'admin.products.view');
        }
    }
}