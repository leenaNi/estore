<?php

namespace App\Http\Controllers\Admin;

use Route;
use Input;
use App\Models\Product;
use App\Models\OrderStatus;
use App\Models\PaymentMethod;
use App\Models\PaymentStatus;
use App\Models\Order;
use App\Models\User;
use App\Models\Country;
use App\Models\State;
use App\Models\ProductType;
use App\Models\AttributeSet;
use App\Models\CatalogImage;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Offer;
use App\Models\Category;
use App\Http\Controllers\Controller;
use DB;

class OffersController extends Controller {

    public function index() {
        $offerInfo = Offer::all();

        return view(Config('constants.adminOfferView') . '.index', compact('offerInfo'));
    }

    public function add() {
        $offer = new Offer();
        $products = Product::all();
        $action = route("admin.offers.save");
        return view(Config('constants.adminOfferView') . '.addEdit', compact('offer', 'products', 'action'));
    }

    public function edit() {
        $offer = Offer::find(Input::get('id'));
        $products = Product::all();

        $action = route("admin.offers.save");

        return view(Config('constants.adminOfferView') . '.addEdit', compact('offer', 'products', 'action'));
    }

    public function save() {
        $categoryIds = explode(",", Input::get('CategoryIds'));
        $productIds = explode(",", Input::get('ProductIds'));

        $offerNew = Offer::findOrNew(Input::get('id'));

        $offerNew->offer_name = Input::get('offer_name');
        $offerNew->offer_discount_type = Input::get('offer_discount_type');
        $offerNew->offer_type = Input::get('offer_type');
        $offerNew->offer_discount_value = Input::get('offer_discount_value');
        $offerNew->min_order_qty = Input::get('min_order_qty');
        $offerNew->min_free_qty = Input::get('min_free_qty');
        $offerNew->min_order_amt = Input::get('min_order_amt');
        $offerNew->max_discount_amt = Input::get('max_discount_amt');
        $offerNew->full_incremental_order = Input::get('full_incremental_order');
        $offerNew->start_date = Input::get('start_date');
        $offerNew->end_date = Input::get('end_date');
        $offerNew->user_specific = Input::get('user_specific');
        $offerNew->status = Input::get('status');
        $offerNew->store_id = Session::get('store_id');

        $offerNew->save();

        if (!empty(Input::get('category_id')))
            $offerNew->categories()->sync(Input::get('category_id'));
        else
            $offerNew->categories()->detach();

        if (!empty(Input::get('product_id')))
            $offerNew->products()->sync(Input::get('product_id'));
        else
            $offerNew->products()->detach();
        
        if (!empty(Input::get('uid')))
            $offerNew->userspecific()->sync(Input::get('uid'));
        else
            $offerNew->userspecific()->detach();
        
        if ( Input::get('user_specific') == 0 ) {
            $offerNew->userspecific()->sync([]);
        }

        return redirect()->route('admin.offers.view');

//        return redirect()->back();
    }

    public function delete() {
        $offer = Offer::find(Input::get('id'));
        
        $offer->categories()->sync([]);
        $offer->products()->sync([]);
        $offer->userspecific()->sync([]);

        $offer->delete();

        return redirect()->route('admin.offers.view');
    }

    public function searchUser() {
        if ( $_GET['term'] != "" ) {
            $data = User::where("email", "like", "%" . $_GET['term'] . "%")
                    ->select(DB::raw('id, email'))
                    ->get();
        } else
            $data = "";

        echo json_encode($data);
    }

}

?>