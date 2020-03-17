<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Library\Helper;
use App\Models\Offer;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use DB;
use Input;
use Route;
use Session;

class OffersController extends Controller
{

    public function index()
    {
        //$offerInfo = Offer::orderBy('id', 'DESC')->get();
        $offerInfo = Offer::orderBy('id', 'DESC')->paginate(Config('constants.paginateNo'));
        $offerInfoCount = $offerInfo->total();
        //dd($offerInfo);
        $startIndex = 1;
        $getPerPageRecord = Config('constants.paginateNo');
        $allinput = Input::all();
        if(!empty($allinput) && !empty(Input::get('page')))
        {
            $getPageNumber = $allinput['page'];
            $startIndex = ( (($getPageNumber) * ($getPerPageRecord)) - $getPerPageRecord) + 1;
            $endIndex = (($startIndex+$getPerPageRecord) - 1);

            if($endIndex > $offerInfoCount)
            {
                $endIndex = ($offerInfoCount);
            }
        }
        else
        {
            $startIndex = 1;
            $endIndex = $getPerPageRecord;
            if($endIndex > $offerInfoCount)
            {
                $endIndex = ($offerInfoCount);
            }
        }


        return view(Config('constants.adminOfferView') . '.index', compact('offerInfo', 'offerInfoCount', 'startIndex', 'endIndex'));
    }

    public function add()
    {
        $offer = new Offer();
        $offerUsedcount = 0;
        // $products = Product::all();
        $action = route("admin.offers.save");
        return view(Config('constants.adminOfferView') . '.addEdit', compact('offer', 'products', 'action', 'offerUsedcount'));
    }

    public function edit()
    {
        $offer = Offer::find(Input::get('id'));
        $offerUsedcount = Order::where("offer_used", "=", Input::get('id'))->count();
        // $products = Product::all();
        $action = route("admin.offers.save");
        return view(Config('constants.adminOfferView') . '.addEdit', compact('offer', 'products', 'action', 'offerUsedcount'));
    }

    public function save()
    {  
        $categoryIds = explode(",", Input::get('CategoryIds'));
        $productIds = explode(",", Input::get('ProductIds'));
        // print_r(Input::all());
        $offerNew = Offer::findOrNew(Input::get('id'));
        $offerNew->offer_name = Input::get('offer_name');
        $offerNew->offer_discount_type = Input::get('offer_discount_type');
        $offerNew->offer_type = Input::get('offer_type');
        $offerNew->type = Input::get('type');
        $offerNew->offer_discount_value = Input::get('offer_discount_value');
       
        $offerNew->start_date = Input::get('start_date');
        $offerNew->end_date = Input::get('end_date');
        $offerNew->user_specific = Input::get('user_specific');
        $offerNew->status = Input::get('status');
        $offerNew->preference = Input::get('preference');
        $offerNew->store_id = Session::get('store_id');

        if (Input::hasFile('c_image')) {
            $destinationPath = Config('constants.offerImgUploadPath') . "/";
            $fileName = date("dmYHis") . "." . Input::File('c_image')->getClientOriginalExtension();
            $upload_success = Input::File('c_image')->move($destinationPath, $fileName);
        } else {
            $fileName = (!empty(Input::get('c_image')) ? Input::get('c_image') : '');
        }

        $offerNew->offer_image = $fileName;

        $offerNew->save();

        // if (!empty(Input::get('category_id')))
        //     $offerNew->categories()->sync(Input::get('category_id'));
        // else
        //     $offerNew->categories()->detach();

        // if (!empty(Input::get('product_id')))
        //     $offerNew->products()->sync(Input::get('product_id'));
        // else
        //     $offerNew->products()->detach();

        if (!empty(Input::get('prod_id'))) {
            
            $prod_ids = Input::get('prod_id');
            $prod_qtys = Input::get('prod_qty');
            $products = [];
            foreach ($prod_ids as $prodIdKey => $prodId) {
                $products[$prodIdKey]['offer_id'] = $offerNew->id;
                $products[$prodIdKey]['prod_id'] = $prodId;
                $products[$prodIdKey]['type'] = 1;
                $products[$prodIdKey]['qty'] = $prod_qtys[$prodIdKey];
            }
            // $offerNew->products()->sync(Input::get('product_id'));
            // dd($products);
            DB::table('offers_products')->insert($products);
        }

        if (!empty(Input::get('offer_prod_id'))) {
            $prod_ids = Input::get('offer_prod_id');
            $prod_qtys = Input::get('offer_prod_qty');
            $products = [];
            foreach ($prod_ids as $prodIdKey => $prodId) {
                $products[$prodIdKey]['offer_id'] = $offerNew->id;
                $products[$prodIdKey]['prod_id'] = $prodId;
                $products[$prodIdKey]['type'] = 2;
                $products[$prodIdKey]['qty'] = $prod_qtys[$prodIdKey];
            }
            // $offerNew->products()->sync(Input::get('product_id'));
            // dd($products);
            DB::table('offers_products')->insert($products);
        }

        if (!empty(Input::get('uid'))) {
            $offerNew->userspecific()->sync(Input::get('uid'));
        } else {
            $offerNew->userspecific()->detach();
        }

        if (Input::get('user_specific') == 0) {
            $offerNew->userspecific()->sync([]);
        }

        return redirect()->route('admin.offers.view');

        //        return redirect()->back();
    }

    public function delete()
    {
        $offer = Offer::find(Input::get('id'));
        $getcount = Order::where("offer_used", "=", Input::get('id'))->count();
        //dd($getcount);
        if ($getcount == 0 && $offer != null) {
            $offer->categories()->sync([]);
            $offer->products()->sync([]);
            $offer->delete();
            DB::table("offers_users")->where("offer_id", $offer->id)->delete();
            //  $offer->userspecific()->sync([]);
            $offer->delete();
            Session::flash('message', 'Offer deleted successfully.');
            $data = ['status' => '1', "message" => "Offer deleted successfully."];
        } else {
            Session::flash('message', 'Sorry, This offer is part of a order. Delete the order first.');
            $data = ['status' => '0', "msg" => "Sorry, This offer is part of a order. Delete the order first."];
        }
        $url = 'admin.offers.view';
        $viewname = '';
        return Helper::returnView($viewname, $data, $url);
    }

    public function changeStatus()
    {
        $attr = Offer::find(Input::get('id'));
        if ($attr->status == 1) {
            $attrStatus = 0;
            $msg = "Offer disabled successfully.";
            $attr->status = $attrStatus;
            $attr->update();
            return redirect()->back()->with('message', $msg);
        } else if ($attr->status == 0) {
            $attrStatus = 1;
            $msg = "Offer enabled successfully.";
            $attr->status = $attrStatus;
            $attr->update();
            return redirect()->back()->with('msg', $msg);
        }
    }

    public function searchUser()
    {
        if ($_GET['term'] != "") {
            $data = User::where("email", "like", "%" . $_GET['term'] . "%")
                ->select(DB::raw('id, email'))
                ->get();
        } else {
            $data = "";
        }

        echo json_encode($data);
    }

    public function searchProduct()
    {
        // hidding product which is already added
        $cart_products = [];
        $added_prod = [];
        if (count($cart_products) > 0) {
            foreach ($cart_products as $key => $product) {
                if ($product['id'] == $product['options']['sub_prod']) {
                    $added_prod[] = $product['id'];
                }
            }
        }
        $searchStr = Input::get('term');
        // $products = DistributorProduct::where("is_individual", 1)->where('status', 1)->where('product', "like", "%" . $searchStr . "%")->orWhere('id', "like", "%" . $searchStr . "%")->get(['id', 'product']);
        $products = DB::table('products')->where('store_id', Session::get('store_id'))->where('prod_type', '!=', 2)->where('status', 1)->where('product', "like", "%" . $searchStr . "%")->orWhere('id', "like", "%" . $searchStr . "%")->get(['id', 'product', 'prod_type']);

        $data = [];
        foreach ($products as $k => $prd) {
            if (!in_array($prd->id, $added_prod)) {
                $data[$k]['id'] = $prd->id;
                $data[$k]['value'] = $prd->product;
                $data[$k]['type'] = $prd->prod_type;
                $data[$k]['label'] = "[" . $prd->id . "]" . $prd->product;
            }
        }

        echo json_encode($data);
    }

    public function searchOfferProduct()
    {
        // hidding product which is already added
        $cart_products = [];
        $added_prod = [];
        if (count($cart_products) > 0) {
            foreach ($cart_products as $key => $product) {
                if ($product['id'] == $product['options']['sub_prod']) {
                    $added_prod[] = $product['id'];
                }
            }
        }
        $searchStr = Input::get('term');
        // $products = DistributorProduct::where("is_individual", 1)->where('status', 1)->where('product', "like", "%" . $searchStr . "%")->orWhere('id', "like", "%" . $searchStr . "%")->get(['id', 'product']);
        $products = DB::table('products')->where('store_id', Session::get('store_id'))->where('prod_type', '!=', 2)->where('status', 1)->where('product', "like", "%" . $searchStr . "%")->orWhere('id', "like", "%" . $searchStr . "%")->get(['id', 'product', 'prod_type']);

        $data = [];
        foreach ($products as $k => $prd) {
            if (!in_array($prd->id, $added_prod)) {
                $data[$k]['id'] = $prd->id;
                $data[$k]['value'] = $prd->product;
                $data[$k]['type'] = $prd->prod_type;
                $data[$k]['label'] = "[" . $prd->id . "]" . $prd->product;
            }
        }

        echo json_encode($data);
    }

    public function deleteProduct()
    {
        $id = Input::get('id');
        $offerId = Input::get('offer_id');
        DB::table('offers_products')->where('id', $id)->delete();
        $offerProducts = DB::table('offers_products')->where('offer_id', $offerId)->get();
        if (count($offerProducts) == 0) {
            $offer = Offer::find($offerId);
            $offer->status = 0;
            $offer->update();
        }
        Session::flash('message', 'Product deleted successfully.');
        $data = ['status' => '1', "message" => "Product deleted successfully."];
        return redirect()->back();
    }

}
