<?php

namespace App\Http\Controllers\Frontend;

use Route;
use App\Models\MallProdCategory as Category;
use App\Models\MallProducts as Product;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Gift;
use App\Models\AttributeValue;
use App\Models\HasCategories;
use App\Library\Helper;
use App\Models\GeneralSetting;
use App\Models\Loyalty;
use Input;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Cart;
use Session;
use HTML;
use DB;
use Auth;

class CartController extends Controller {

    public function index() {
//        Cart::instance('shopping')->destroy();
        Session::forget("discAmt");
        Session::forget('voucherUsedAmt');
        Session::forget('voucherAmount');
        Session::forget('remainingVoucherAmt');
        Session::forget('checkbackUsedAmt');
        Session::forget('remainingCashback');
        Session::forget("ReferalCode");
        Session::forget("ReferalId");
        Session::forget("referalCodeAmt");
        Session::forget("codCharges");
        Session::forget('shippingCost');
        $cart = Cart::instance('shopping')->content();
        foreach ($cart as $k => $c) {
            Cart::instance('shopping')->update($k, ["options" => ['wallet_disc' => 0, 'voucher_disc' => 0, 'referral_disc' => 0]]);
        }
        $lolyatyDis = 0;
//        dd($cart);
        $cart_amt = Helper::calAmtWithTax();
        // dd($cart_amt['total']);
//        dd($cart);
        if (Cart::instance("shopping")->count() != 0) {
            $chkC = GeneralSetting::where('url_key', 'coupon')->first()->status;
            $cart = Cart::instance('shopping')->content();
            Session::put('pay_amt', $cart_amt['total']);
            $viewname = Config('constants.frontCartView') . '.index';
            $data = ['cart' => $cart, 'chkC' => $chkC, 'cart_amt' => $cart_amt];
            return Helper::returnView($viewname, $data);
        } else {
            $this->forgetCouponSession();
            $viewname = Config('constants.frontCartView') . '.index';
            $data = ['cart' => $cart, 'chkC' => [], 'cart_amt' => 0];
            return Helper::returnView($viewname, $data);
//            return redirect()->route('home');
        }
    }

    public function add() {
        $prod_type = Input::get("prod_type");
        $prod_id = Input::get("prod_id");
        $sub_prod = Input::get("sub_prod");
        $quantity = Input::get("quantity");
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
                ;
                break;
            default :
        }
        Helper::calAmtWithTax();
        //if (preg_match("/Specified/", $msg)) {
        if ($msg == 1) {
            echo $msg;
        } else {
            //return $msg;
            echo $this->cart();
        }
    }

    public function getCartCount() {

        if (Cart::instance("shopping")->count() != 0) {
            $cartCount = 0;
            $cart = Cart::instance('shopping')->content()->toArray();
            foreach ($cart as $cartData) {
                $cartCount += $cartData['qty'];
            }
            return $cartCount;
        }
    }

    public function addCartData($prod_type, $prod_id, $sub_prod, $quantity) {

        switch ($prod_type) {
            case ($prod_type == 1 || $prod_type == 7):
                $msg = $this->simpleProduct($prod_id, $quantity);
                break;
            case 2:
                $msg = $this->comboProduct($prod_id, $quantity, $sub_prod);
                break;
            case ($prod_type == 3 || $prod_type == 4):
                $msg = $this->configProduct($prod_id, $quantity, $sub_prod);
                break;
            case 5:
                $msg = $this->downloadProduct($prod_id, $quantity);
                ;
                break;
            default :
        }
        Helper::calAmtWithTax();
        //if (preg_match("/Specified/", $msg)) {
        // if ($msg == 1) {
        //     echo $msg;
        // } else {
        //     //return $msg;
        //   //  echo $this->cart();
        // }
    }

    public function edit() {

        $cart = Cart::instance('shopping')->update(Input::get("rowid"), ['qty' => Input::get("qty")]);
        $amt = Helper::calAmtWithTax();

        $cartInstance = Cart::instance('shopping')->get(Input::get("rowid"));
        $tax = $cartInstance->options->tax_amt;
        $sub_total = $cartInstance->subtotal;
        $total = Cart::total();
        //  dd($amt['total']);
        if ($cartInstance->options->tax_type == 2) {
            $sub_total = $cartInstance->subtotal + $tax;
            $total = Cart::total() + $tax;
        }
        // $cart = Helper::getnewCart();
        $data['subtotal'] = $sub_total * Session::get('currency_val');
        $data['finaltotal'] = $amt['total'] * Session::get('currency_val');
        $data['total'] = $amt['total'] * Session::get('currency_val');
        $data['tax'] = $cartInstance->options->tax_amt;
        // $data['subtotal'] = Cart::instance('shopping')->get(Input::get("rowid"))->subtotal * Session::get('currency_val') ;
        // $data['finaltotal'] = Cart::total() * Session::get('currency_val');
        // $data['total'] = Cart::total() * Session::get('currency_val');
        $data['cart_count'] = Cart::instance("shopping")->count();
        $data['coupon_amount'] = Session::get('couponUsedAmt');
        $data['cart'] = Cart::instance("shopping")->content();
        Session::put("pay_amt", $amt['total'] * Session::get('currency_val'));
        // Session::put("pay_amt", Cart::total());
        return $data;
    }

    public function delete() {
        Cart::instance('shopping')->remove(Input::get("rowid"));

        $cart = Helper::getnewCart();
        $cart_amt = Helper::calAmtWithTax();
        $cartCnt = Cart::instance('shopping')->count();
        //echo "||||||||||" . Helper::getAmt() . "||||||||||" . $cart . "||||||||||" . $cartCnt . "||||||||||" . Cart::instance('shopping')->total();
        $data = [];

        array_push($data, $cart_amt['total'], $cart, $cartCnt, $cart_amt['total'], (Session::get('couponUsedAmt')));

        //array_push($data, Helper::getAmt(), $cart, $cartCnt, Cart::instance('shopping')->total(), (Session::get('couponUsedAmt')));
        Session::put("pay_amt", $cart_amt['total']);
        // Session::put("pay_amt", Cart::instance('shopping')->total());
        return $data;
    }

    public function simpleProduct($prod_id, $quantity) {
        $product = Product::find($prod_id);
        $quantity = (Input::get('quantity')) ? Input::get('quantity') : $quantity;
        $cats = [];
        foreach ($product->categories as $cat) {
            array_push($cats, $cat->id);
        }
        $price = $product->selling_price; //$product->price;
        $pname = $product->product;
        $prod_type = $product->prod_type;
        $prodImg = DB::table($product->prefix . "_catalog_images")->where("catalog_id", $product->store_prod_id)->where("image_mode", 1)->first();
        $images = $prodImg->filename;
        $imagPath = $prodImg->image_path;
        $type = $product->is_tax;
        $sum = 0;
        $storeProdId = $product->store_prod_id;
        $prodTaxes = DB::table($product->prefix . '_product_has_taxes')->where('product_id', $product->id)
                        ->join($product->prefix . '_tax', $product->prefix . '_product_has_taxes.tax_id', "=", $product->prefix . '_tax.id')->select([$product->prefix . '_tax.rate'])->get();
        foreach ($prodTaxes as $tax) {
            $sum = $sum + $tax->rate;
        }
        $tax_amt = 0;
        if ($type == 1 || $type == 2) {
            $tax = $product->selling_price * $quantity * $sum / 100;
            $tax_amt = round($tax, 2);
        }
        //            $is_stockable = GeneralSetting::where('id', 26)->first();
        $storeName = DB::table('stores')->where('id', $product->store_id)->first()->store_name;
        $is_stockable = DB::table($product->prefix . '_general_setting')->where('url_key', 'stock')->first();
        if ($product->is_stock == 1 && $is_stockable->status == 1) {
            if (Helper::checkStock($prod_id, $quantity) == "In Stock") {
                Cart::instance('shopping')->add(["id" => $storeProdId, "name" => $pname, "qty" => $quantity, "price" => $price,
                    "options" => ["image" => $images, "image_with_path" => $imagPath, "sub_prod" => $storeProdId, "is_cod" => $product->is_cod, 'url' => $product->url_key,
                        'cats' => $cats, 'stock' => $product->stock, 'store_id' => $product->store_id, 'prefix' => $product->prefix, 'store_name' => $storeName, 'is_stock' => $product->is_stock,
                        "prod_type" => $prod_type,
                        "discountedAmount" => $price, "disc" => 0, 'wallet_disc' => 0, 'voucher_disc' => 0, 'referral_disc' => 0, 'user_disc' => 0, 'tax_type' => $type, 'taxes' => $sum, 'tax_amt' => $tax_amt]]);
            } else {
                return 1;
            }
        } else {
            Cart::instance('shopping')->add(["id" => $storeProdId, "name" => $pname, "qty" => $quantity, "price" => $price,
                "options" => ["image" => $images, "image_with_path" => $imagPath, "sub_prod" => $storeProdId, "is_cod" => $product->is_cod, 'url' => $product->url_key,
                    'cats' => $cats, 'stock' => $product->stock, 'store_id' => $product->store_id, 'prefix' => $product->prefix, 'store_name' => $storeName, 'is_stock' => $product->is_stock,
                    "prod_type" => $prod_type,
                    "discountedAmount" => $price, "disc" => 0, 'wallet_disc' => 0, 'voucher_disc' => 0, 'referral_disc' => 0, 'user_disc' => 0, 'tax_type' => $type, 'taxes' => $sum, 'tax_amt' => $tax_amt]]);
        }
    }

    public function downloadProduct($prod_id, $quantity) {
        $product = Product::find($prod_id);
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
        $is_stockable = GeneralSetting::where('id', 26)->first();
        if ($is_stockable->status == 1) {
            if (Helper::checkStock($prod_id, $quantity) == "In Stock") {
                Cart::instance('shopping')->add(["id" => $prod_id, "name" => $pname, "qty" => $quantity, "price" => $price, "options" => ["image" => $images, "sub_prod" => $prod_id, 'url' => $product->url_key, "is_cod" => $product->is_cod, 'cats' => $cats, 'stock' => $product->stock, 'is_stock' => $product->is_stock, "eNoOfDaysAllowed" => $eNoOfDaysAllowed, "prod_type" => $prod_type, "discountedAmount" => $price, "disc" => 0, 'wallet_disc' => 0, 'voucher_disc' => 0, 'referral_disc' => 0, 'user_disc' => 0, 'tax_type' => $type, 'taxes' => $sum, 'tax_amt' => $tax_amt]]);
            } else {
                return 1;
            }
        } else {
            Cart::instance('shopping')->add(["id" => $prod_id, "name" => $pname, "qty" => $quantity, "price" => $price, "options" => ["image" => $images, "sub_prod" => $prod_id, 'url' => $product->url_key, "is_cod" => $product->is_cod, 'cats' => $cats, 'stock' => $product->stock, 'is_stock' => $product->is_stock, "eNoOfDaysAllowed" => $eNoOfDaysAllowed, "prod_type" => $prod_type, "discountedAmount" => $price, "disc" => 0, 'wallet_disc' => 0, 'voucher_disc' => 0, 'referral_disc' => 0, 'user_disc' => 0, 'tax_type' => $type, 'taxes' => $sum, 'tax_amt' => $tax_amt]]);
        }
    }

    public function comboProduct($prod_id, $quantity, $sub_prod) {

        $product = Product::find($prod_id);

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
            $prod["img"] = Product::find($cmb->id)->catalogimgs()->first()->filename;
            //$combos[] = $prod;
            $combos[$cmb->id]["name"] = $cmb->product;
            $combos[$cmb->id]["img"] = @$cmb->catalogimgs()->first()->filename;
            $prod = [];


            //print_r($sub_prod[$cmb->id]);
            //$price += $cmb->price;
            if (isset($sub_prod[$cmb->id])) {
                $sub = $cmb->subproducts()->where("id", "=", $sub_prod[$cmb->id])->first();
                $combos[$cmb->id]["sub_prod"] = $sub->id;
                //$price += $sub->price;
                $attributes = $sub->attributes()->where("is_filterable", "=", "1")->get()->toArray();
                foreach ($attributes as $attr) {
                    $combos[$cmb->id]["options"][$attr["attr"]] = $attr["pivot"]["attr_val"];
                }
            }
        }
        $is_stockable = GeneralSetting::where('id', 26)->first();
        $image = (!empty($images)) ? $images : "default.jpg";
        if ($is_stockable->status == 1) {
            if (Helper::checkStock($prod_id, $quantity, $sub_prod) == "In Stock" || $product->is_crowd_funded != 0) {

                Cart::instance('shopping')->add(["id" => $prod_id, "name" => $pname, "qty" => $quantity, "price" => $price, "options" => ["image" => $image, "sub_prod" => $prod_id, "is_crowd_funded" => $product->is_crowd_funded, 'url' => $product->url_key, "combos" => $combos, "is_cod" => $product->is_cod, 'cats' => $cats, "is_shipped_inter" => $isShipped, "is_ref_disc" => $isRefDisc, 'stock' => $product->stock, 'is_stock' => $product->is_stock, "discountedAmount" => $price, "disc" => 0, 'wallet_disc' => 0, 'voucher_disc' => 0, 'referral_disc' => 0, 'user_disc' => 0, "tax_type" => $type, "taxes" => $sum, 'tax_amt' => $tax_amt, 'prod_type' => $prod_type]]);
            } else {
                return 1;
            }
        } else {
            Cart::instance('shopping')->add(["id" => $prod_id, "name" => $pname, "qty" => $quantity, "price" => $price, "options" => ["image" => $image, "sub_prod" => $prod_id, "is_crowd_funded" => $product->is_crowd_funded, 'url' => $product->url_key, "combos" => $combos, "is_cod" => $product->is_cod, 'cats' => $cats, "is_shipped_inter" => $isShipped, "is_ref_disc" => $isRefDisc, 'stock' => $product->stock, 'is_stock' => $product->is_stock, "discountedAmount" => $price, "disc" => 0, 'wallet_disc' => 0, 'voucher_disc' => 0, 'referral_disc' => 0, 'user_disc' => 0, "tax_type" => $type, "taxes" => $sum, 'tax_amt' => $tax_amt, 'prod_type' => $prod_type]]);
        }
    }

    public function configProduct($prod_id, $quantity, $sub_prod) {
        $product = Product::find($prod_id);
//        $is_stockable = GeneralSetting::where('url_key', 'stock')->first();
        $is_stockable = DB::table($product->prefix . '_general_setting')->where('url_key', 'stock')->first();
        $cats = [];
        foreach ($product->categories as $cat) {
            array_push($cats, $cat->id);
        }
        $pname = $product->product;
        $prod_type = $product->prod_type;
        $product->images = DB::table($product->prefix . "_catalog_images")->where("catalog_id", $product->store_prod_id)->where("image_mode", 1)->get();
        $imagPath = $product->images[0]->image_path;
        $subProd = Product::where("id", "=", $sub_prod)->first();
        $price = $subProd->price + $product->selling_price;
        $options = [];
//            $hasOptn = $subProd->attributes()->withPivot('attr_id', 'prod_id', 'attr_val')->orderBy("att_sort_order", "asc")->get();
        $hasOptn = DB::table($product->prefix . '_has_options')->where("prod_id", $subProd->id)->get();
        foreach ($hasOptn as $optn) {
            $options[$optn->attr_id] = $optn->attr_val;
            $option_name[] = DB::table($product->prefix . '_attribute_values')->find($optn->attr_val)->option_name;
        }
        $image = isset($images) ? $images : "default.jpg";
        $option_name = json_encode($option_name);
        $type = $product->is_tax;
        $sum = 0;
        $prodTaxes = DB::table($product->prefix . '_product_has_taxes')->where('product_id', $product->id)
                        ->join($product->prefix . '_tax', $product->prefix . '_product_has_taxes.tax_id', "=", $product->prefix . '_tax.id')->select([$product->prefix . '_tax.rate'])->get();
        foreach ($prodTaxes as $tax) {
            $sum = $sum + $tax->rate;
        }
        $tax_amt = 0;
        if ($type == 1 || $type == 2) {
            $tax = $product->selling_price * $quantity * $sum / 100;
            $tax_amt = round($tax, 2);
        }
        $storeName = DB::table('stores')->where('id', $product->store_id)->first()->store_name;
        if ($product->is_stock == 1 && $is_stockable->status == 1) {
            if (Helper::checkStock($prod_id, $quantity, $sub_prod) == "In Stock") {
                // $product = Product::find($sub_prod);
                Cart::instance('shopping')->add(["id" => $prod_id, "name" => $pname,
                    "qty" => $quantity, "price" => $price,
                    "options" => ["image" => $image, "image_with_path" => $imagPath, "selected_attrs_labels" => $option_name, "sub_prod" => $subProd->id,
                        "options" => $options, "is_cod" => $product->is_cod, "min_order_qty" => $product->min_order_quantity,
                        'cats' => $cats, 'stock' => $subProd->stock, 'store_id' => $product->store_id, 'prefix' => $product->prefix, 'store_name' => $storeName, 'url' => $product->url_key, 'is_stock' => $product->is_stock, "discountedAmount" => $price, "disc" => 0, 'wallet_disc' => 0, 'voucher_disc' => 0, 'referral_disc' => 0, 'user_disc' => 0, "tax_type" => $type, "taxes" => $sum, "tax_amt" => $tax_amt, 'prod_type' => $prod_type]]);
            } else {
                return 1;
            }
        } else {
            Cart::instance('shopping')->add(["id" => $prod_id, "name" => $pname,
                "qty" => $quantity, "price" => $price,
                "options" => ["image" => $image, "image_with_path" => $imagPath, "selected_attrs_labels" => $option_name, "sub_prod" => $subProd->id,
                    "options" => $options, "is_cod" => $product->is_cod, "min_order_qty" => $product->min_order_quantity,
                    'cats' => $cats, 'stock' => $subProd->stock, 'store_id' => $product->store_id, 'prefix' => $product->prefix, 'store_name' => $storeName, 'url' => $product->url_key, 'is_stock' => $product->is_stock, "discountedAmount" => $price, "disc" => 0, 'wallet_disc' => 0, 'voucher_disc' => 0, 'referral_disc' => 0, 'user_disc' => 0, "tax_type" => $type, "taxes" => $sum, "tax_amt" => $tax_amt, 'prod_type' => $prod_type]]);
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

    public function update_pay_amt() {
        if (!empty(Input::get('new_amt')))
            Session::put("pay_amt", Input::get('new_amt'));
        echo Session::get("pay_amt");
    }

    function updatecartramt() {
        $amt_Aftdiscount = Input::get('d');
        foreach ($amt_Aftdiscount as $amt) {
            Cart::update($amt['sid'], ['options' => ['discountedAmount' => $amt['rc']]]);
        }
    }

    public function check_coupon() {
        Session::get('currency_val');
        $couponCode = Input::get('couponCode');
        $cartContent = Cart::instance('shopping')->content()->toArray();
        $orderAmount = Helper::getAmt("coupon"); // * Session::get('currency_val');
        $msg = '';
        $couponID = Coupon::where("coupon_code", "=", $couponCode)->first();
        @$usedCouponCountOrders = @Order::where('coupon_used', '=', $couponID->id)->where("order_status", "=", 1)->count();
        if (isset($couponID)) {
            if ($couponID->user_specific === 1) {

                if (!empty(Session::get('loggedin_user_id'))) {
                    $chkUserSp = Coupon::find($couponID->id)->userspecific()->get(['user_id']);
                    // dd($chkUserSp);
                    $cuserids = [];
                    if (count($chkUserSp) > 0) {
                        foreach ($chkUserSp as $chkuserid) {
                            array_push($cuserids, $chkuserid->user_id);
                        }
                        $validuser = in_array(Session::get('loggedin_user_id'), $cuserids);
                        // echo "here...";
                        // print_r($validuser); die;
                        if ($validuser) {
                            if ($couponID->allowed_per_user > 0) {
                                $checkForUser = Order::where('user_id', Session::get('loggedin_user_id'))->where('coupon_used', '=', $couponID->id)->where("order_status", "=", 1)->count();
                                if ($checkForUser < $couponID->allowed_per_user) {
                                    $validCoupon = DB::select(DB::raw("Select * from coupons where coupon_code = '$couponCode'  and no_times_allowed > $usedCouponCountOrders and min_order_amt <= " . str_replace(',', '', $orderAmount) . " and (now() between start_date and end_date)"));
                                    // print_r($validCoupon); die;
                                } else {
                                    // echo "hrer"; die;
                                    $msg = "You have already used this coupon.";
                                }
                            } else {
                                //$validCoupon = DB::select(DB::raw("Select * from coupons where coupon_code = '$couponCode'  and no_times_allowed > $usedCouponCountOrders and min_order_amt <= " . str_replace(',', '', $orderAmount) . " and (now() between start_date and end_date)"));
                                //print_r($validCoupon); die;
                                $msg = "Oops! Please try later.";
                            }
                        } else {
                            $msg = 'Coupon code is not applicable to current user.';
                        }
                    } else {
                        $msg = 'Coupon code is not applicable to current user.';
                    }
                } else {
                    $msg = 'Coupon code is valid for specific user only. Kindly login and try .';
                }
            } else {
//                 echo "@@@ ".$usedCouponCountOrders;
                $validCoupon = DB::select(DB::raw("Select * from " . DB::getTablePrefix() . "coupons where coupon_code = '$couponCode'  and no_times_allowed > $usedCouponCountOrders and min_order_amt <= " . $orderAmount . " and (now() between start_date and end_date)"));
//                $msg = "Not user specific";
//                 $msg = 'Invalid Coupon Code.';
            }
        } else {
            $msg = 'coupon code is not valid.';
        }
//         echo $msg; 
        // die;
//         print_r($validCoupon); die;
        if (isset($validCoupon) && !empty($validCoupon)) {
            $disc = 0;
            if ($validCoupon[0]->coupon_type == 2) {
                //  echo "gdfg"; die;
                //for specific category
                $orderAmt = 0;
                $allowedCats = [];
                $cats = Coupon::find($validCoupon[0]->id)->categories->toArray();
                // print_r($cats); die;
                foreach ($cats as $cat) {
                    array_push($allowedCats, $cat['id']);
                }
                if (!empty($cartContent)) {
                    $cats = [];
                    $discountCartProds = [];
                    $individualSubtotal = [];
                    foreach ($cartContent as $product) {
                        // print_r($product['options']['cats']);
                        $checkAllowCatsCount = array_intersect($allowedCats, $product['options']['cats']);
                        if (!empty($checkAllowCatsCount)) {
                            $indvDisc = 0;
                            if ($validCoupon[0]->discount_type == 1) {
                                $indvDisc = ($validCoupon[0]->coupon_value * $product['subtotal']) / 100;
                                $disc += $indvDisc;
                                $individualSubtotal[$product['rowid']] = $indvDisc;
                            } else {
                                if ($validCoupon[0]->discount_type == 2) {
                                    $orderAmt += $product['subtotal'];
                                    if ($validCoupon[0]->min_order_amt <= $orderAmt) {
                                        $disc = $validCoupon[0]->coupon_value; //200 rs
                                        $individualSubtotal[$product['rowid']] = $product['qty'] * $product['price']; //number_format($product['qty'] * $product['price'], 2);
                                    }
                                }
                            }
                        } else {
                            //     $msg = "Coupon code is not applicable for curremt cart product.";
                        }
                    } //die;
                    // print_r($individualSubtotal);
                    $discountCartProds = $this->calculateFixedDiscount($individualSubtotal, $disc);
                    // dd($discountCartProds);
                }
            } else if ($validCoupon[0]->coupon_type == 3) {
                //for specific prods
                $orderAmt = 0;
                $allowedProds = [];
                $prods = Coupon::find($validCoupon[0]->id)->products()->get()->toArray();
                foreach ($prods as $prd) {
                    array_push($allowedProds, $prd['id']);
                }

                if (!empty($cartContent)) {
                    // print_r($cartContent);
                    $discountCartProds = [];
                    $individualSubtotal = [];
                    foreach ($cartContent as $product) {
                        $getChkProds = [];
                        array_push($getChkProds, $product['options']['sub_prod']);
                        array_push($getChkProds, $product['id']);
                        $prodids = array_intersect($allowedProds, $getChkProds);
                        if (!empty($prodids)) {
                            $indvDisc = 0;
                            if ($validCoupon[0]->discount_type == 1) {
                                $indvDisc = ($validCoupon[0]->coupon_value * $product['subtotal']) / 100;
                                $disc += $indvDisc;
                                $individualSubtotal[$product['rowid']] = $indvDisc;
                            } else {
                                if ($validCoupon[0]->discount_type == 2) {
                                    $orderAmt += $product['subtotal'];
                                    if ($validCoupon[0]->min_order_amt <= $orderAmt) {
                                        $disc = $validCoupon[0]->coupon_value;
                                        $individualSubtotal[$product['rowid']] = $product['qty'] * $product['price']; // number_format($product['qty'] * $product['price'], 2);
                                    }
                                }
                            }
                        } else {
                            // $msg = "Coupon code is not applicable for curremt cart product.";
                        }
                    }
                    $discountCartProds = $this->calculateFixedDiscount($individualSubtotal, $disc);
                    //   dd($discountCartProds);
                }
            } else if ($validCoupon[0]->coupon_type == 1) {
                //for all prods and categories
                $orderAmt = 0;
                $discountCartProds = [];
                $individualSubtotal = [];
                foreach ($cartContent as $prdAllC) {
                    // dd($prdAllC);
                    $indvDisc = 0;
                    if ($validCoupon[0]->discount_type == 1) {
                        // echo "1234";
//                        echo "total " . $prdAllC['subtotal'] . "<br/>";
//                        echo "Fixed " . $validCoupon[0]->coupon_value . " Disc ";
                        $indvDisc = ($validCoupon[0]->coupon_value * $prdAllC['subtotal']) / 100; //(int) ((int) $validCoupon[0]->coupon_value * (int) $prdAllC['subtotal']) / 100;
                        $disc += $indvDisc;
                        $individualSubtotal[$prdAllC['rowid']] = $indvDisc;
//                        echo "<br/> disc " . $disc . "<br/>";
                    } else {
                        //echo "5678";
//                        echo $validCoupon[0]->discount_type . " eeeeee";
                        if ($validCoupon[0]->discount_type == 2) {
//                            echo "Percentage";
                            $orderAmt += $prdAllC['subtotal'];
                            if ($validCoupon[0]->min_order_amt <= $orderAmt) {
                                $disc = $validCoupon[0]->coupon_value;
                                $individualSubtotal[$prdAllC['rowid']] = $prdAllC['qty'] * $prdAllC['price']; //number_format($prdAllC['qty'] * $prdAllC['price'], 2);
                            }
                        }
                    }
                }
//                echo "@@@@ " . $disc;
                $discountCartProds = $this->calculateFixedDiscount($individualSubtotal, $disc);
//                print_r($discountCartProds);
//                die;
            }
        }
        //@$disc = number_format(@$disc, 2);
        if (!empty($validCoupon) && $disc > 0) {

            Session::put('couponUsedAmt', $disc);
            Session::put('usedCouponCode', $validCoupon[0]->coupon_code);
            Session::put('usedCouponId', $validCoupon[0]->id);
            $data = [];

            $data['coupon_type'] = $validCoupon[0]->coupon_type;
            $data['disc'] = $disc;
            //$data['individual_disc_amt'] = $discountCartProds;
            // coupon amt to added by satendra
            if (Session::get('individualDiscountPercent')) {
                $coupDisc = json_decode(Session::get('individualDiscountPercent'), true);
                foreach ($coupDisc as $discK => $discV) {
                    Cart::instance('shopping')->update($discK, ["options" => ['disc' => @$discV]]);
                }
            }

            $cart_amt = Helper::calAmtWithTax();
            $data['remove'] = 0;
            $data['cart'] = Cart::instance('shopping')->content()->toArray();
            $newAmnt = $cart_amt['total'] * Session::get('currency_val');
            //$data['subtotal'] = $cart_amt['sub_total']* Session::get('currency_val');
            //$data['orderAmount'] = $cart_amt['total'] * Session::get('currency_val');
            $data['individual_disc_amt'] = filter_var($discountCartProds, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $data['subtotal'] = filter_var($cart_amt['sub_total'] * Session::get('currency_val'), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $data['orderAmount'] = filter_var($cart_amt['total'] * Session::get('currency_val'), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            return $data;
        } else {
            $cart_amt = Helper::revertTax();
            $data['remove'] = 1;
            if (empty($msg)) {
                $msg = "Coupon code invalid";
            }

            Session::forget('couponUsedAmt');
            Session::forget('usedCouponId');
            Session::forget('usedCouponCode');
//            if (Session::get('individualDiscountPercent')) {
//                $coupDisc = json_decode(Session::get('individualDiscountPercent'), true);
//                    foreach ($coupDisc as $discK => $discV) {
//                        @Cart::instance('shopping')->update(@$discK, ["options" => ['disc' => 0]]);
//                }
//            }

            $cart_amt = Helper::calAmtWithTax();
            $data['cmsg'] = @$msg;
            $data['cart'] = $cart_amt['cart']; // Cart::instance('shopping')->content()->toArray();
            $data['subtotal'] = $cart_amt['sub_total'] * Session::get('currency_val');
            $data['orderAmount'] = $cart_amt['total'] * Session::get('currency_val');
            $data['cartCnt'] = Cart::instance('shopping')->count();
            return $data;
        }
    }

    public function calculateFixedDiscount($individualSubtotal, $disc) {
        $arraySumPercent = array_sum($individualSubtotal) / 100;
        $individualDiscountPercent = [];
        foreach ($individualSubtotal as $key => $subtotal) {
            $calPerdiscount = $subtotal / 100;
            $individualDiscountPercent[$key] = ($disc * $calPerdiscount / $arraySumPercent);
        }
        Session::put('individualDiscountPercent', json_encode($individualDiscountPercent));
        return $individualDiscountPercent;
    }

    public function forgetCouponSession() {
        Session::forget('pay_amt');
        Session::forget('couponUsedAmt');
        Session::forget('usedCouponId');
        Session::forget('usedCouponCode');
        Session::forget('voucherUsedAmt');
        Session::forget('voucherAmount');
        Session::forget('remainingVoucherAmt');
        Session::forget('checkbackUsedAmt');
        Session::forget('remainingCashback');
        Session::forget("ReferalCode");
        Session::forget("ReferalId");
        Session::forget("referalCodeAmt");
    }

    function coupon_cal($cartContent, $allowedProds, $validCoupon, $type) {
        $orderAmt = $disc = 0;
        if (!empty($cartContent)) {
            $item = count($cartContent);
            foreach ($cartContent as $getprod) {
                $d = $getprod['options']['sub_prod'];
                if ($type == 1) {
                    $d = Auth::user()->id;
                }
                if (in_array($d, $allowedProds) || $type == 4) {
                    if ($validCoupon[0]->discount_type == 1) {
                        $disc += number_format(($validCoupon[0]->coupon_value * $getprod['subtotal']) / 100, 2);
                    } else {
                        $orderAmt += $getprod['subtotal'];
                    }
                    if ($validCoupon[0]->discount_type == 2) {
                        if ($validCoupon[0]->min_order_amt <= $orderAmt) {
                            $disc = $validCoupon[0]->coupon_value;
                        }
                    }
                }
            }
        }
        return $disc;
    }

    // if ($couponID->user_specific == 1) {
    //     //   dd(Auth::user()->id);
    //     if (!empty(Auth::user()->id)) {
    //         $chkUserSp = Coupon::find($couponID->id)->userspecific()->get(['user_id']);
    //         $cuserids = [];
    //         foreach ($chkUserSp as $chkuserid) {
    //             array_push($cuserids, $chkuserid->user_id);
    //         }
    //         echo Auth::user()->id ;
    //         $validuser = in_array(Auth::user()->id, $cuserids);
    //         if ($validuser) {
    //             $validCoupon = DB::select(DB::raw("Select * from coupons where coupon_code = '$couponCode'  and no_times_allowed > $usedCouponCountOrders and min_order_amt <= " . $orderAmount . " and (now() between start_date and end_date)"));
    //         }
    //     }
    // } else {
    //     $validCoupon = DB::select(DB::raw("Select * from coupons where coupon_code = '$couponCode'  and no_times_allowed > $usedCouponCountOrders and min_order_amt <= " . $orderAmount . " and (now() between start_date and end_date)"));
    // }
    // }
    //   dd($validCoupon);
    // if (isset($validCoupon) && !empty($validCoupon)) {
    //     $disc = 0;
    // if ($validCoupon[0]->coupon_type == 2) {
    //     //for specific category
    //     $orderAmt = 0;
    //     $allowedCats = [];
    //     $cats = Coupon::find($validCoupon[0]->id)->categories->toArray();
    //     foreach ($cats as $cat) {
    //         array_push($allowedCats, $cat['id']);
    //     }
    //     if (!empty($cartContent)) {
    //         $cats = [];
    //         foreach ($cartContent as $product) {
    //             $product['options']['cats'];
    //             $b = array_intersect($allowedCats, $product['options']['cats']);
    //             if (!empty($b)) {
    //                 if ($validCoupon[0]->discount_type == 1) {
    //                     $disc += round(($validCoupon[0]->coupon_value * $product['subtotal']) / 100);
    //                 } else {
    //                     $orderAmt += $product['subtotal'];
    //                 }
    //                 if ($validCoupon[0]->discount_type == 2) {
    //                     if ($validCoupon[0]->min_order_amt <= $orderAmt) {
    //                         $disc = $validCoupon[0]->coupon_value;
    //                     }
    //                 }
    //             }
    //         }
    //     }
    // } else if ($validCoupon[0]->coupon_type == 3) {
    //     //for specific prods
    //     $orderAmt = 0;
    //     $allowedProds = [];
    //     $prods = Coupon::find($validCoupon[0]->id)->products()->get()->toArray();
    //     foreach ($prods as $prd) {
    //         array_push($allowedProds, $prd['id']);
    //     }
    //     if (!empty($cartContent)) {
    //         foreach ($cartContent as $getprod) {
    //             $getChkProds = [];
    //             array_push($getChkProds, $getprod['options']['sub_prod']);
    //             array_push($getChkProds, $getprod['id']);
    //             $prodids = array_intersect($allowedProds, $getChkProds);
    //             if (!empty($prodids)) {
    //                 if ($validCoupon[0]->discount_type == 1) {
    //                     $disc += round(($validCoupon[0]->coupon_value * $getprod['subtotal']) / 100);
    //                 } else {
    //                     $orderAmt += $getprod['subtotal'];
    //                 }
    //                 if ($validCoupon[0]->discount_type == 2) {
    //                     if ($validCoupon[0]->min_order_amt <= $orderAmt) {
    //                         $disc = $validCoupon[0]->coupon_value;
    //                     }
    //                 }
    //             }
    //         }
    //     }
    // } else if ($validCoupon[0]->coupon_type == 1) {
    //     //for all prods and categories
    //     $orderAmt = 0;
    //     foreach ($cartContent as $prdAllC) {
    //         if ($validCoupon[0]->discount_type == 1) {
    //             $disc += round(($validCoupon[0]->coupon_value * $prdAllC['subtotal']) / 100);
    //         } else {
    //             $orderAmt += $prdAllC['subtotal'];
    //         }
    //         if ($validCoupon[0]->discount_type == 2) {
    //             if ($validCoupon[0]->min_order_amt <= $orderAmt) {
    //                 $disc = $validCoupon[0]->coupon_value;
    //             }
    //         }
    //     }
    // }
//         }
// }
    // @$disc = round(@$disc);
    // if (!empty($validCoupon) && $disc > 0) {
    //     $newAmnt = ($orderAmount - $disc);
    //     Session::put('pay_amt', $newAmnt);
    //     Session::put('couponUsedAmt', $disc);
    //     Session::put('usedCouponCode', $validCoupon[0]->coupon_code);
    //     Session::put('usedCouponId', $validCoupon[0]->id);
    //     echo "Coupon Applied :-" . $newAmnt . ":-" . $validCoupon[0]->coupon_type . ":-" . $disc;
    // } else {
    //     $orderAmount = Session::get("pay_amt");
    //     $couponValR = $orderAmount + Session::get('couponUsedAmt');
    //     echo "Coupon Not Valid:-" . Session::get('couponUsedAmt') . ":-" . $couponValR;
    //     Session::forget('couponUsedAmt');
    //     Session::forget('usedCouponId');
    //     Session::forget('usedCouponCode');
    // }
    //  }

    public function verifygiftcoupon() {
        $coupon_code = Input::get('couponcode');
        $cost = Input::get('cost');
        //dd(Auth::check());
        if (Auth::user()) {

            $emailid = Auth::user()->email;
            $verify = Gift::where('coupon', $coupon_code)->first();

            $current = Carbon::now();
            if (!empty($verify)) {
                if ($verify->receiver_email == $emailid) {
                    if (($current->toDateString()) < ($verify->valid_upto)) {
                        if (($verify->amount) < $cost) {
                            Session::put('amount', $verify->amount);
                            Session::put('code', $verify->coupon);
                        }
                        $coupon = array($verify->amount, $verify->valid_upto);
                    } else {
                        $coupon = 1;
                    }
                } else {
                    $coupon = 2;
                }
            } else {
                $coupon = 0;
            }
        } else {
            $coupon = 3;
        }

        return $coupon;
    }

    public function erasegiftcoupon() {
        Session::forget('amount');
        Session::forget('code');
        //print_r(Session::get('amount'));
        return 1;
    }

}
