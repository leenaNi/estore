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
use App\Models\Courier;
use DB;
use Session;

class CartvalueController extends Controller {

    public function index() {

        $is_mincart = GeneralSetting::where('url_key', 'min-cart-value-rule')->first();
        $details = json_decode($is_mincart->details, true);
        $charges= $details['charges'];
        $id= $is_mincart->id;
        return view(Config('constants.adminCartvalueView') . '.index', compact('charges','id')); 
    }

   
    public function edit() {
        $is_mincart = GeneralSetting::where('url_key', 'min-cart-value-rule')->first();
        $details = json_decode($is_mincart->details, true);
        $charges= $details['charges'];
        $action = route("admin.cartvalue.update");
        return view(Config('constants.adminCartvalueView') . '.addEdit', compact('charges', 'action'));
    }

    public function update() {
       //dd(Input::get('charges'));
        $courier = GeneralSetting::find(Input::get('id'));
       
        $courier->details = json_encode(['charges' => Input::get('charges')]);
        //$courier->details = !is_null(Input::get('details')) ? json_encode(Input::get('details')) : '';
        $courier->update();
        Session::flash("msg", "Minimum cart value updated successfully.");
        return redirect()->route('admin.cartvalue.view');
    }

  
    

}
