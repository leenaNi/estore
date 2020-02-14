<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ApiCartController extends Controller
{
    //


    public function add() {
        $data = [];
        $msg = '';
        $prod_id = filter_var(Input::get('prod_id'), FILTER_SANITIZE_STRING); //Input::get("prod_id");
        $prod_type = filter_var(Input::get('prod_type'), FILTER_SANITIZE_STRING); //Input::get("prod_id");
        // $product = DB::table("products")->where("id", $prod_id)->select("id", "prod_type")->first();
        // $prod_type = $product->prod_type; //filter_var(Input::get('prod_type'), FILTER_SANITIZE_STRING); //Input::get("prod_type");
        $sub_prod = filter_var(Input::get('sub_prod'), FILTER_SANITIZE_STRING);
        $quantity = filter_var(Input::get('quantity'), FILTER_SANITIZE_STRING);
        switch ($prod_type) {
            case 1:
                $msg = $this->simpleProduct($prod_id, $quantity);
                break;
            case 2:
                $msg = $this->comboProduct($prod_id, $quantity, $sub_prod);
                break;
            case 3:
                $msg = $this->configProduct($prod_id, $quantity, $sub_prod);
                break;
            case 5:
                $msg = $this->downloadProduct($prod_id, $quantity);
                break;
            default :
        }
        Helper::calAmtWithTax();
        //if (preg_match("/Specified/", $msg)) {
        if ($msg == 1) {
            $data['cart']['data'] = NULL;
            $data['status'] = "error";
            $data['msg'] = $msg;
        } else {
            //return $msg;
            $data['cart']['data'] = Cart::instance("shopping")->content();
            $data["ccnt"] = Cart::instance("shopping")->count();
            $data['status'] = "success";
            $data['msg'] = "";
        }
    }

    public function simpleProduct($prod_id, $quantity) {
        $jsonString = Helper::getSettings();
        if(Session::get('distributor_store_id')){
            $product = DistributorProduct::find($prod_id);
            $store_id = Session::get('distributor_store_id');
            $prefix = Session::get('distributor_store_prefix');
        } else {
            $product = Product::find($prod_id);
            $store_id = $jsonString['store_id'];
            $prefix = $jsonString['prefix'];
        }
        $quantity = (Input::get('quantity')) ? Input::get('quantity') : $quantity;

        $cats = [];
        foreach ($product->categories as $cat) {
            array_push($cats, $cat->id);
        }
        if((($product->spl_price) > 0) && ($product->spl_price < $product->price)){
             $price = $product->selling_price;
        }else{
            $price = $product->price; //$product->price;
        }
        //$price = $product->selling_price; //$product->price;
        $pname = $product->product;
        $prod_type = $product->prod_type;
        $images = @$product->catalogimgs()->where("image_type", "=", 1)->first()->filename;
        $imagPath = Config("constants.productImgPath") . '/' . $images;
        $type = $product->is_tax;
        $sum = 0;

        foreach ($product->texes as $tax) {
            $sum = $sum + $tax->rate;
        }
        $tax_amt = 0;
        if ($type == 1 || $type == 2) {
            $tax = $product->selling_price * $quantity * $sum / 100;
            $tax_amt = round($tax, 2);
        }
        if(Session::get('distributor_store_id')){
            $is_stockable = DB::table('general_setting')->where('store_id', Session::get('distributor_store_id'))->where('url_key', 'stock')->first();
        } else {
            $is_stockable = GeneralSetting::where('url_key', 'stock')->first();
        }
        if ($product->is_stock == 1 && $is_stockable->status == 1) {
            if (Helper::checkStock($prod_id, $quantity) == "In Stock") {
                Cart::instance('shopping')->add(["id" => $prod_id, "name" => $pname, "qty" => $quantity, "price" => $price,
                    "options" => ["image" => $images, "image_with_path" => $imagPath, "is_cod" => $product->is_cod, 'url' => $product->url_key, 'store_id' => $store_id, 'prefix' => $prefix,
                        'cats' => $cats, 'stock' => $product->stock, 'is_stock' => $product->is_stock,
                        "prod_type" => $prod_type,
                        "discountedAmount" => $price, "disc" => 0, 'wallet_disc' => 0, 'voucher_disc' => 0, 'referral_disc' => 0, 'user_disc' => 0, 'tax_type' => $type, 'taxes' => $sum, 'tax_amt' => $tax_amt]]);
            } else {
                return 1;
            }
        } else {
            Cart::instance('shopping')->add(["id" => $prod_id, "name" => $pname, "qty" => $quantity, "price" => $price,
                "options" => ["image" => $images, "image_with_path" => $imagPath, "is_cod" => $product->is_cod, 'url' => $product->url_key, 'store_id' => $store_id, 'prefix' => $prefix,
                    'cats' => $cats, 'stock' => $product->stock, 'is_stock' => $product->is_stock,
                    "prod_type" => $prod_type,
                    "discountedAmount" => $price, "disc" => 0, 'wallet_disc' => 0, 'voucher_disc' => 0, 'referral_disc' => 0, 'user_disc' => 0, 'tax_type' => $type, 'taxes' => $sum, 'tax_amt' => $tax_amt]]);
        }
    }

    public function downloadProduct($prod_id, $quantity) {
        $jsonString = Helper::getSettings();
        if(Session::get('distributor_store_id')){
            $product = DistributorProduct::find($prod_id);
            $store_id = Session::get('distributor_store_id');
            $prefix = Session::get('distributor_store_prefix');
        } else {
            $product = Product::find($prod_id);
            $store_id = $jsonString['store_id'];
            $prefix = $jsonString['prefix'];
        }
        $quantity = (Input::get('quantity')) ? Input::get('quantity') : $quantity;
        $cats = [];
        foreach ($product->categories as $cat) {
            array_push($cats, $cat->id);
        }

        $eNoOfDaysAllowed = $product->eNoOfDaysAllowed;
        $price = $product->selling_price; //$product->price;
        $pname = $product->product;
        $prod_type = $product->prod_type;
        $images = $product->catalogimgs()->where("image_type", "=", 1)->first()->filename;
        $type = $product->is_tax;
        $sum = 0;
        foreach ($product->texes as $tax) {
            $sum = $sum + $tax->rate;
        }
        $tax_amt = 0;
        if ($type == 1 || $type == 2) {
            $tax = $product->selling_price * $quantity * $sum / 100;
            $tax_amt = round($tax, 2);
        }
        if(Session::get('distributor_store_id')){
            $is_stockable = DB::table('general_setting')->where('store_id', Session::get('distributor_store_id'))->where('url_key', 'stock')->first();
        } else {
            $is_stockable = GeneralSetting::where('url_key', 'stock')->first();
        }
        if ($is_stockable->status == 1) {
            if (Helper::checkStock($prod_id, $quantity) == "In Stock") {
                Cart::instance('shopping')->add(["id" => $prod_id, "name" => $pname, "qty" => $quantity, "price" => $price, "options" => ["image" => $images, "sub_prod" => $prod_id, 'url' => $product->url_key, 'store_id' => $store_id, 'prefix' => $prefix, "is_cod" => $product->is_cod, 'cats' => $cats, 'stock' => $product->stock, 'is_stock' => $product->is_stock, "eNoOfDaysAllowed" => $eNoOfDaysAllowed, "prod_type" => $prod_type, "discountedAmount" => $price, "disc" => 0, 'wallet_disc' => 0, 'voucher_disc' => 0, 'referral_disc' => 0, 'user_disc' => 0, 'tax_type' => $type, 'taxes' => $sum, 'tax_amt' => $tax_amt]]);
            } else {
                return 1;
            }
        } else {
            Cart::instance('shopping')->add(["id" => $prod_id, "name" => $pname, "qty" => $quantity, "price" => $price, "options" => ["image" => $images, "sub_prod" => $prod_id, 'url' => $product->url_key, 'store_id' => $store_id, 'prefix' => $prefix, "is_cod" => $product->is_cod, 'cats' => $cats, 'stock' => $product->stock, 'is_stock' => $product->is_stock, "eNoOfDaysAllowed" => $eNoOfDaysAllowed, "prod_type" => $prod_type, "discountedAmount" => $price, "disc" => 0, 'wallet_disc' => 0, 'voucher_disc' => 0, 'referral_disc' => 0, 'user_disc' => 0, 'tax_type' => $type, 'taxes' => $sum, 'tax_amt' => $tax_amt]]);
        }
    }

    public function comboProduct($prod_id, $quantity, $sub_prod) {
        $jsonString = Helper::getSettings();
        // echo $prod_id.'======='.Session::get('distributor_store_id');
        if(Session::get('distributor_store_id')){
            $product = DistributorProduct::find($prod_id);
            $store_id = Session::get('distributor_store_id');
            $prefix = Session::get('distributor_store_prefix');
        } else {
            $product = Product::find($prod_id);
            $store_id = $jsonString['store_id'];
            $prefix = $jsonString['prefix'];
        } 
        $cats = [];
        foreach ($product->categories as $cat) {
            array_push($cats, $cat->id);
        }
        $pname = $product->product;
        $type = $product->is_tax;
        $sum = 0;
        foreach ($product->texes as $tax) {
            $sum = $sum + $tax->rate;
        }
        $tax_amt = 0;
        if ($type == 1 || $type == 2) {
            $tax = $product->selling_price * $quantity * $sum / 100;
            $tax_amt = round($tax, 2);
        }
        //$images = json_decode($product->images, true);
        $images = @$product->catalogimgs()->first()->filename;
        $isShipped = $product->is_shipped_international;
        $isRefDisc = $product->is_referal_discount;
        // $price = $product->selling_price; //($product->spl_price > 0 ? $product->spl_price : $product->price);
        $price = $product->selling_price;
        $prod_type = $product->prod_type;
        $prod = [];
        $combos = [];
        foreach ($product->comboproducts as $cmb) {
            //print_r($cmb);
            $prod["name"] = $cmb->product;
            if(Session::get('distributor_store_id')){
                $prod["img"] = DistributorProduct::find($cmb->id)->catalogimgs()->first()->filename;
            } else {
                $prod["img"] = Product::find($cmb->id)->catalogimgs()->first()->filename;
            }
            //$combos[] = $prod;
            $combos[$cmb->id]["name"] = $cmb->product;
            $combos[$cmb->id]["img"] = @$cmb->catalogimgs()->first()->filename;
            $prod = [];
            //print_r($sub_prod[$cmb->id]);
            //$price += $cmb->price;
            // Old code
            // if (isset($sub_prod[$cmb->id])) {
            //     $sub = $cmb->subproducts()->where("id", "=", $sub_prod[$cmb->id])->first();
            //     $combos[$cmb->id]["sub_prod"] = $sub->id;
            //     //$price += $sub->price;
            //     $attributes = $sub->attributes()->where("is_filterable", "=", "1")->get()->toArray();
            //     foreach ($attributes as $attr) {
            //         $combos[$cmb->id]["options"][$attr["attr"]] = $attr["pivot"]["attr_val"];
            //     }
            // }
            $combos[$cmb->id]["sub_prod"] = $sub_prod;
        }
        if(Session::get('distributor_store_id')){
            $is_stockable = DB::table('general_setting')->where('store_id', Session::get('distributor_store_id'))->where('url_key', 'stock')->first();
        } else {
            $is_stockable = GeneralSetting::where('url_key', 'stock')->first();
        }
        $image = (!empty($images)) ? $images : "default.jpg";
        if ($is_stockable->status == 1) {
            if (Helper::checkStock($prod_id, $quantity, $sub_prod) == "In Stock" || $product->is_crowd_funded != 0) {
                Cart::instance('shopping')->add(["id" => $prod_id, "name" => $pname, "qty" => $quantity, "price" => $price, "options" => ["image" => $image, "sub_prod" => $sub_prod, "is_crowd_funded" => $product->is_crowd_funded, 'url' => $product->url_key, 'store_id' => $store_id, 'prefix' => $prefix, "combos" => $combos, "is_cod" => $product->is_cod, 'cats' => $cats, "is_shipped_inter" => $isShipped, "is_ref_disc" => $isRefDisc, 'stock' => $product->stock, 'is_stock' => $product->is_stock, "discountedAmount" => $price, "disc" => 0, 'wallet_disc' => 0, 'voucher_disc' => 0, 'referral_disc' => 0, 'user_disc' => 0, "tax_type" => $type, "taxes" => $sum, 'tax_amt' => $tax_amt, 'prod_type' => $prod_type]]);
            } else {
                return 1;
            }
        } else {
            Cart::instance('shopping')->add(["id" => $prod_id, "name" => $pname, "qty" => $quantity, "price" => $price, "options" => ["image" => $image, "sub_prod" => $sub_prod, "is_crowd_funded" => $product->is_crowd_funded, 'url' => $product->url_key, 'store_id' => $store_id, 'prefix' => $prefix, "combos" => $combos, "is_cod" => $product->is_cod, 'cats' => $cats, "is_shipped_inter" => $isShipped, "is_ref_disc" => $isRefDisc, 'stock' => $product->stock, 'is_stock' => $product->is_stock, "discountedAmount" => $price, "disc" => 0, 'wallet_disc' => 0, 'voucher_disc' => 0, 'referral_disc' => 0, 'user_disc' => 0, "tax_type" => $type, "taxes" => $sum, 'tax_amt' => $tax_amt, 'prod_type' => $prod_type]]);
        }
    }

    public function configProduct($prod_id, $quantity, $sub_prod) {
        $jsonString = Helper::getSettings();
        // $is_stockable = GeneralSetting::where('url_key', 'stock')->first();
        if(Session::get('distributor_store_id')){
            $product = DistributorProduct::find($prod_id);
            $store_id = Session::get('distributor_store_id');
            $prefix = Session::get('distributor_store_prefix');
            $is_stockable = DB::table('general_setting')->where('store_id', Session::get('distributor_store_id'))->where('url_key', 'stock')->first();
        } else {
            $product = Product::find($prod_id);
            $store_id = $jsonString['store_id'];
            $prefix = $jsonString['prefix'];
            $is_stockable = GeneralSetting::where('url_key', 'stock')->first();
        }
        $cats = [];

        foreach ($product->categories as $cat) {
            array_push($cats, $cat->id);
        }
        $pname = $product->product;
        $prod_type = $product->prod_type;
        $images = @$product->catalogimgs()->where("image_type", "=", 1)->get()->first()->filename;
        $imagPath = Config("constants.productImgPath") . '/' . $images;
        if(Session::get('distributor_store_id')){
            $subProd = DistributorProduct::where("id", "=", $sub_prod)->first();
        } else {
            $subProd = Product::where("id", "=", $sub_prod)->first();
        }
          if(($product->spl_price) > 0 && ($product->spl_price < $product->spl_price)){
             $price = $product->price;
        }else{
            $price = $product->selling_price; //$product->price;
        }
        if($subProd != 'NULL')
        {
            $price = $subProd->price + $price;
        }
        
        $options = [];
        $hasOptn = $subProd->attributes()->withPivot('attr_id', 'prod_id', 'attr_val')->orderBy("att_sort_order", "asc")->get();
        $option_name = [];
        foreach ($hasOptn as $optn) {
            $options[$optn->pivot->attr_id] = $optn->pivot->attr_val;
            $option_name[] = AttributeValue::find($optn->pivot->attr_id)->option_name;
        }
        $image = isset($images) ? $images : "default.jpg";
        $option_name = json_encode($option_name);
        $type = $product->is_tax;
        $sum = 0;
        foreach ($product->texes as $tax) {
            $sum = $sum + $tax->rate;
        }
        $tax_amt = 0;
        if ($type == 1 || $type == 2) {
            $tax = $product->selling_price * $quantity * $sum / 100;
            $tax_amt = round($tax, 2);
        }
        if ($product->is_stock == 1 && $is_stockable->status == 1) {

            if (Helper::checkStock($prod_id, $quantity, $sub_prod) == "In Stock") {
                // $product = Product::find($sub_prod);
                Cart::instance('shopping')->add(["id" => $prod_id, "name" => $pname,
                    "qty" => $quantity, "price" => $price,
                    "options" => ["image" => $image, "image_with_path" => $imagPath, "selected_attrs_labels" => $option_name, "sub_prod" => $subProd->id,
                        "options" => $options, "is_cod" => $product->is_cod, "min_order_qty" => $product->min_order_quantity,
                        'cats' => $cats, 'stock' => $subProd->stock, 'url' => $product->url_key, 'store_id' => $store_id, 'prefix' => $prefix, 'is_stock' => $product->is_stock, "discountedAmount" => $price, "disc" => 0, 'wallet_disc' => 0, 'voucher_disc' => 0, 'referral_disc' => 0, 'user_disc' => 0, "tax_type" => $type, "taxes" => $sum, "tax_amt" => $tax_amt, 'prod_type' => $prod_type]]);
            } else {
                return 1;
            }
        } else {
            Cart::instance('shopping')->add(["id" => $prod_id, "name" => $pname,
                "qty" => $quantity, "price" => $price,
                "options" => ["image" => $image, "image_with_path" => $imagPath, "selected_attrs_labels" => $option_name, "sub_prod" => $subProd->id,
                    "options" => $options, "is_cod" => $product->is_cod, "min_order_qty" => $product->min_order_quantity,
                    'cats' => $cats, 'stock' => $subProd->stock, 'url' => $product->url_key, 'store_id' => $store_id, 'prefix' => $prefix, 'is_stock' => $product->is_stock, "discountedAmount" => $price, "disc" => 0, 'wallet_disc' => 0, 'voucher_disc' => 0, 'referral_disc' => 0, 'user_disc' => 0, "tax_type" => $type, "taxes" => $sum, "tax_amt" => $tax_amt, 'prod_type' => $prod_type]]);
        }
    }

    public function cart() {
        Session::put("pay_amt", Cart::instance("shopping")->total());
        $cart = '';
        $cart .= '<div class="shop-cart">';
        $cart .= '<a href="#" class="cart-control"><img src="' . asset(Config("constants.frontendPublicImgPath") . "assets/icons/cart-black.png") . '" alt="">';
        $cart .= '<span class="cart-number number">' . Cart::instance("shopping")->count() . '</span>';
        $cart .='</a>';
        if (Cart::instance("shopping")->count() != 0) {
            $cart .='<div class="shop-item">';
            $cart .='<div class="widget_shopping_cart_content">';
            $cart .='<ul class="cart_list">';
            foreach (Cart::instance("shopping")->content() as $c) {
                $cart .='<li class="clearfix">';
                $cart .='<a class="p-thumb" href="#" style="height: 50px;width: 50px;">';
                $cart .='<img src="' . asset(Config("constants.productImgPath") . $c->options->image) . '" alt="" >';
                $cart .='</a>';
                $cart .='<div class="p-info">';
                $cart .='<a class="p-title" href="#">' . $c->name . ' </a>';
                $cart .='<span class="price">';
                if ($c->options->tax_type == 2) {
                    $taxeble_amt = $c->subtotal - $c->options->disc;
                    $tax_amt = round($taxeble_amt * $c->options->taxes / 100, 2);
                    $selling_price = $c->subtotal * Session::get('currency_val') + $tax_amt;
                } else {
                    $selling_price = $c->subtotal * Session::get('currency_val');
                }
                $cart .='<ins><span class="amount"><i class="fa fa-' . strtolower(Session::get('currency_code')) . '"></i> ' . number_format($selling_price, 2) . ' </span></ins>';
                $cart .='</span>';
                $cart .='<span class="p-qty">QTY: ' . $c->qty . ' </span>';
                $cart .='<a data-rowid="' . $c->rowid . '" class="removeShoppingCartProd remove" href="#"><i class="fa fa-times-circle"></i></a>';
                $cart .='</div>';
                $cart .='</li>';
            }
            $cart_data = Helper::calAmtWithTax();
            $cart_total = $cart_data['total'] * Session::get("currency_val");
            //  $cart_total = Cart::instance("shopping")->total() * Session::get('currency_val');
            $cart .='</ul>';
            $cart .='<p class="total"><strong>Subtotal:</strong> <span class="amount"><i class="fa fa-' . strtolower(Session::get('currency_code')) . '"></i> ' . number_format($cart_total, 2) . ' </span></p>';
            $cart .='<p class="buttons">';
            $cart .='<a class="button cart-button" href="' . route("cart") . ' ">View Cart</a>';
            $cart .='<a class="button yellow wc-forward" href="' . route("checkout") . '">Checkout</a>';
            $cart .='</p></div> </div></div>';
        } else {
            $cart .= '<li><h6>Cart is Empty</h6>  </li>';
        }
        $cart .='</ul></li></ul></div>';
        return ($cart . "||||||" . Cart::instance("shopping")->count() . "|||||| <i class='fa fa-" . strtolower(Session::get('currency_code')) . " '></i> " . ($cart_total));
    }
}