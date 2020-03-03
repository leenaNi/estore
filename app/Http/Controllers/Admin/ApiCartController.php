<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Library\Helper;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use Cart;
use DB;
use Input;
use Session;

class ApiCartController extends Controller
{
    //
    public function index()
    {
        $user = User::where('id', Session::get('authUserId'))->first();
        if ($user->cart != '') {
            $cartData = json_decode($user->cart, true);
            if($cartData != '' && !empty($cartData))
                Cart::instance('shopping')->add($cartData);
        }
        $cartData = Cart::instance("shopping")->content();
        $data['cart']['data'] = $cartData;
        $data["ccnt"] = Cart::instance("shopping")->count();
        $data['status'] = "1";
        $data['msg'] = "";
        return $data;
    }
    public function add()
    {
        $data = [];
        $msg = '';
        $prod_id = filter_var(Input::get('prod_id'), FILTER_SANITIZE_STRING); //Input::get("prod_id");
        // $prod_type = filter_var(Input::get('prod_type'), FILTER_SANITIZE_STRING); //Input::get("prod_id");
        $product = DB::table("products")->where("id", $prod_id)->select("id", "prod_type", "store_id")->first();
        if ($product != null) {
            $prod_type = $product->prod_type; //filter_var(Input::get('prod_type'), FILTER_SANITIZE_STRING); //Input::get("prod_type");
            $sub_prod = filter_var(Input::get('sub_prod'), FILTER_SANITIZE_STRING);
            $quantity = filter_var(Input::get('quantity'), FILTER_SANITIZE_STRING);
            $user = User::where('id', Session::get('authUserId'))->first();
            //Check if forcefully add item from other distributor
            if (Input::get('force_add') && Input::get('force_add') == 1) {
                Cart::instance('shopping')->destroy();
            } else {
                if ($user->cart != '') {
                    $cartData = json_decode($user->cart, true);
                    Cart::instance('shopping')->add($cartData);
                }
                $checkStoreExists = Helper::checkStoreExists($product->store_id);
                if ($checkStoreExists['isExist']) {
                    $existingStore = $checkStoreExists['existingStore'];
                    $newStore = Store::where('id', $product->store_id)->first(['id', 'store_name']);
                    $data['status'] = "1";
                    $data['msg'] = 'Your cart contains items from ' . $existingStore->store_name . '. Do you want to discard the selection and add items from ' . $newStore->store_name . '?';
                    return $data;
                }
            }
            
            switch ($prod_type) {
                case 1:
                    if($quantity == 0) {
                        $msg = $this->removeCartItem($prod_id);
                    } else {
                        $msg = $this->simpleProduct($prod_id, $quantity);
                    }
                    break;
                case 2:
                    if($quantity == 0) {
                        $msg = $this->removeCartItem($prod_id);
                    } else {
                        $msg = $this->comboProduct($prod_id, $quantity, $sub_prod);
                    }
                    break;
                case 3:
                    if($quantity == 0) {
                        $msg = $this->removeCartItem($sub_prod);
                    } else {
                        $msg = $this->configProduct($prod_id, $quantity, $sub_prod);
                    }
                    break;
                case 5:
                    if($quantity == 0) {
                        $msg = $this->removeCartItem($prod_id);
                    } else {
                        $msg = $this->downloadProduct($prod_id, $quantity);
                    }
                    break;
                default:
            }
            // Helper::calAmtWithTax();
            //if (preg_match("/Specified/", $msg)) {
            // return ['msg' => $msg];
            if ($msg == 1) {
                $data['data']['cart'] = null;
                $data['status'] = "0";
                $data['msg'] = $msg;
            } else {
                //return $msg;
                $cartData = Cart::instance("shopping")->content();
                if(Cart::instance("shopping")->count() != 0){
                    $user->cart = json_encode($cartData);
                } else {
                    $user->cart = '';
                }
                $user->update();
                $data['data']['cart'] = $cartData;
                $data["data"]['cartCount'] = Cart::instance("shopping")->count();
                $data['status'] = "1";
                $data['msg'] = "";
            }
        } else {
            $data['status'] = "0";
            $data['msg'] = "Invalid product";
        }
        return $data;
    }

    public function simpleProduct($prod_id, $quantity)
    {
        $product = Product::find($prod_id);
        $store = DB::table('stores')->where('id', $product->store_id)->first();
        $store_id = $store->id;
        $prefix = $store->prefix;
        $quantity = (Input::get('quantity')) ? Input::get('quantity') : $quantity;

        $cats = [];
        foreach ($product->categories as $cat) {
            array_push($cats, $cat->id);
        }
        if ((($product->spl_price) > 0) && ($product->spl_price < $product->price)) {
            $price = $product->selling_price;
        } else {
            $price = $product->price; //$product->price;
        }
        //$price = $product->selling_price; //$product->price;
        $pname = $product->product;
        $prod_type = $product->prod_type;
        $images = @$product->catalogimgs()->where("image_type", "=", 1)->first()->filename;
        $imagPath = 'http://' . $store->url_key . '.' . $_SERVER['HTTP_HOST'] . '/uploads/catalog/products/' . $images;
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
        $isOfferProduct = 0;$offer_qty=0;
        $offerId = 0; $offer_disc_amt = $price;
        //Offer product check
        $OfferProd = DB::table("offers_products")->where(['prod_id'=>$prod_id,'type'=>1])->first();
        if ($OfferProd != null) {
            $offerDetails = DB::table("offers")->where(['id' => $OfferProd->offer_id])->first();
            $offerId = $OfferProd->offer_id;
            if (!empty($offerDetails)) {
                $discount = 0;
                if ($offerDetails->type == 1) {
                    $discount = 0;
                    if($offerDetails->offer_discount_type==1){
                        $discount = $price * ($offerDetails->offer_discount_value / 100);
                    }else if($offerDetails->offer_discount_type==2){
                        $discount = $offerDetails->offer_discount_value;
                    }
                    $price = $price - $discount; 
                    $qty = $OfferProd->qty;
                }else if ($offerDetails->type == 2) {
                    return $this->addOfferProd($offerId);
                }
            }
            
        }
        //create cart instance            
        $is_stockable = DB::table('general_setting')->where('store_id', $product->store_id)->where('url_key', 'stock')->first();

        if ($product->is_stock == 1 && $is_stockable->status == 1) {
            if (Helper::checkStock($prod_id, $quantity) == "In Stock") {
                $searchExist = Helper::searchExistingCart($prod_id);

                $optionsData = ["offerId"=>$offerId,"isOfferProduct"=>$isOfferProduct,"offer_qty"=>$offer_qty,"offer_disc_amt"=>$offer_disc_amt,"image" => $images, "image_with_path" => $imagPath, "is_cod" => $product->is_cod, 'url' => $product->url_key, 'store_id' => $store_id, 'prefix' => $prefix,
                'cats' => $cats, 'stock' => $product->stock, 'is_stock' => $product->is_stock,
                "prod_type" => $prod_type,
                "discountedAmount" => $price, "disc" => 0, 'wallet_disc' => 0, 'voucher_disc' => 0, 'referral_disc' => 0, 'user_disc' => 0, 'tax_type' => $type, 'taxes' => $sum, 'tax_amt' => $tax_amt];

                if (!$searchExist["isExist"]) {
                    Cart::instance('shopping')->add(["id" => $prod_id, "name" => $pname, "qty" => $quantity, "price" => $price,
                        "options" => $optionsData]);
                } else {
                    $newOfferedQty = ($searchExist['offer_qty']+$offer_qty);
                    $optionsData['offer_qty'] = $newOfferedQty;
                    $optionsData['offer_disc_amt'] = $offer_disc_amt * $newOfferedQty;
                    Cart::instance('shopping')->update($searchExist["rowId"], ['qty' => ($searchExist["qty"] + $quantity),"options" => $optionsData]);
                }
            } else {
                return 1;
            }
        } else {
            //dd('nostock');
            $searchExist = Helper::searchExistingCart($prod_id);
            
            $optionsData = ["offerId"=>$offerId,"isOfferProduct"=>$isOfferProduct,"offer_qty"=>$offer_qty,"offer_disc_amt"=>$offer_disc_amt,"image" => $images, "image_with_path" => $imagPath, "is_cod" => $product->is_cod, 'url' => $product->url_key, 'store_id' => $store_id, 'prefix' => $prefix,
                'cats' => $cats, 'stock' => $product->stock, 'is_stock' => $product->is_stock,
                "prod_type" => $prod_type,
                "discountedAmount" => $price, "disc" => 0, 'wallet_disc' => 0, 'voucher_disc' => 0, 'referral_disc' => 0, 'user_disc' => 0, 'tax_type' => $type, 'taxes' => $sum, 'tax_amt' => $tax_amt];

                if (!$searchExist["isExist"]) {
                    Cart::instance('shopping')->add(["id" => $prod_id, "name" => $pname, "qty" => $quantity, "price" => $price,
                        "options" => $optionsData]);
                } else {
                    $newOfferedQty = ($searchExist['offer_qty']+$offer_qty);
                    $optionsData['offer_qty'] = $newOfferedQty;
                    $optionsData['offer_disc_amt'] = $offer_disc_amt * $newOfferedQty;
                    Cart::instance('shopping')->update($searchExist["rowId"], ['qty' => ($searchExist["qty"] + $quantity),"options" => $optionsData]);
                }
        }
        
    }

    public function addOfferProd($offerId){
        
        $discProd = DB::table("offers_products")->where(['offer_id'=>$offerId])->get();
        
        foreach($discProd as $prod){
            $product = Product::find($prod->prod_id);
            $store = DB::table('stores')->where('id', $product->store_id)->first();
            $store_id = $store->id;
            $prefix = $store->prefix;
            $quantity = $prod->qty;

            $cats = [];
            foreach ($product->categories as $cat) {
                array_push($cats, $cat->id);
            }
            if ((($product->spl_price) > 0) && ($product->spl_price < $product->price)) {
                $price = $product->selling_price;
            } else {
                $price = $product->price; //$product->price;
            }
            //$price = $product->selling_price; //$product->price;
            $pname = $product->product;
            $prod_type = $product->prod_type;
            $images = @$product->catalogimgs()->where("image_type", "=", 1)->first()->filename;
            $imagPath = 'http://' . $store->url_key . '.' . $_SERVER['HTTP_HOST'] . '/uploads/catalog/products/' . $images;
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
            $isOfferProduct = 0;$offer_qty= 0;
            $offer_disc_amt = 0;
            if($prod->type == 2){
                $isOfferProduct = 1;$offer_qty= $prod->qty;
                $offer_disc_amt = $price;
                //$price = 0;
            }
            //create cart instance            
            $is_stockable = DB::table('general_setting')->where('store_id', $product->store_id)->where('url_key', 'stock')->first();
            
            if ($product->is_stock == 1 && $is_stockable->status == 1) {
                if (Helper::checkStock($prod->prod_id, $quantity) == "In Stock") {
                    $searchExist = Helper::searchExistingCart($prod->id);
                    if (!$searchExist["isExist"]) {
                        Cart::instance('shopping')->add(["id" => $prod->prod_id, "name" => $pname, "qty" => $quantity, "price" => $price,
                            "options" => ["offerId"=>$offerId,"isOfferProduct"=>$isOfferProduct,"offer_qty"=>$offer_qty,"offer_disc_amt"=>$offer_disc_amt,"image" => $images, "image_with_path" => $imagPath, "is_cod" => $product->is_cod, 'url' => $product->url_key, 'store_id' => $store_id, 'prefix' => $prefix,
                                'cats' => $cats, 'stock' => $product->stock, 'is_stock' => $product->is_stock,
                                "prod_type" => $prod_type,
                                "discountedAmount" => $price, "disc" => 0, 'wallet_disc' => 0, 'voucher_disc' => 0, 'referral_disc' => 0, 'user_disc' => 0, 'tax_type' => $type, 'taxes' => $sum, 'tax_amt' => $tax_amt]]);
                    } else {
                        Cart::instance('shopping')->update($searchExist["rowId"], ['qty' => ($searchExist["qty"] + $quantity)],['options'=> ['offer_qty'=> ($searchExist['offer_qty'] + $offer_qty)]]);
                    }
                } else {
                    return 1;
                }
            } else {
                
                $searchExist = Helper::searchExistingCart($prod->prod_id);

                $optionsData = ["offerId"=>$offerId,"isOfferProduct"=>$isOfferProduct,"offer_qty"=>$offer_qty,"offer_disc_amt"=>$offer_disc_amt,"image" => $images, "image_with_path" => $imagPath, "is_cod" => $product->is_cod, 'url' => $product->url_key, 'store_id' => $store_id, 'prefix' => $prefix,
                'cats' => $cats, 'stock' => $product->stock, 'is_stock' => $product->is_stock,
                "prod_type" => $prod_type,
                "discountedAmount" => $price, "disc" => 0, 'wallet_disc' => 0, 'voucher_disc' => 0, 'referral_disc' => 0, 'user_disc' => 0, 'tax_type' => $type, 'taxes' => $sum, 'tax_amt' => $tax_amt];

                if (!$searchExist["isExist"]) {
                    Cart::instance('shopping')->add(["id" => $prod->prod_id, "name" => $pname, "qty" => $quantity, "price" => $price,
                        "options" => $optionsData]);
                } else {
                    $newOfferedQty = ($searchExist['offer_qty']+$offer_qty);
                    $optionsData['offer_qty'] = $newOfferedQty;
                    $optionsData['offer_disc_amt'] = $offer_disc_amt * $newOfferedQty;
                    Cart::instance('shopping')->update($searchExist["rowId"], ['qty' => ($searchExist["qty"] + $quantity), "options" => $optionsData]);
                }
            }
        }
    }

    public function addOfferProductToCart(){
        $offerId = Input::get("offerId");
        $products = Input::get("products");
        
        if(!empty($offerId)){
            $data = [];
            $offerProd = DB::table("offers_products")->where(['offer_id'=>$offerId,'type'=>1])->first();
            $user = User::where('id', Session::get('authUserId'))->first();
            //dd($user);
                    if ($user->cart != '') {
                        $cartData = json_decode($user->cart, true);
                        Cart::instance('shopping')->add($cartData);
                    }
            if(!empty($offerProd)){
                $productId = DB::table("offers_products")->where(['offer_id'=>$offerId,'type'=>1])->get();
                $prodIds = [];
                foreach($productId as $prodId){
                    $product = DB::table("products")->where(['id'=>$prodId->prod_id,'prod_type'=>3])->first();
                    if(!empty($product)){
                        $prodIds[] = $product->id;
                    }
                    
                }
                if(count($prodIds) > 0){
                    if($products == null){
                        return $this->getSubProducts1($prodIds);
                    }else{
                        foreach($products as $prod){
                            $parent_prod_id = $prod['prod_id'];
                            $sub_prod_id = $prod['sub_prod'];
                            $prodqty = DB::table("offers_products")->where(['offer_id'=>$offerId,'prod_id'=>$parent_prod_id])->pluck('qty');

                            $msg = $this->configProduct($parent_prod_id, $prodqty[0],$sub_prod_id);
                            
                            if ($msg == 1) {
                                $data['data']['cart'] = null;
                                $data['status'] = "0";
                                $data['msg'] = $msg;
                            } else {
                                //return $msg;
                                $cartData = Cart::instance("shopping")->content();
                                //dd($cartData);
                                $user->cart = json_encode($cartData);
                                $user->update();
                                $data['data']['cart'] = $cartData;
                                $data["data"]['cartCount'] = Cart::instance("shopping")->count();
                                $data['status'] = "1";
                                $data['msg'] = "";
                            }
                        }
                    }

                }else{
                    
                    $offerDetails = DB::table("offers")->where(['id' => $offerId])->first();
                    if($offerDetails->type == 1){
                        $getOfferProd = DB::table("offers_products")->where(['offer_id'=>$offerId,'type'=>1])->get();
                        $prodIds = [];
                        foreach($getOfferProd as $product){
                            $product = DB::table("products")->where('id',$product->prod_id)->first();
                            if(!empty($product)){
                                if($product->prod_type==1 && $product->parent_prod_id==0){
                                    $msg = $this->simpleProduct($product->id,$offerProd->qty);
                                }
                                else if($product->prod_type==2){
                                    $msg = $this->comboProduct($prod_id, $offerProd->qty, $sub_prod);
                                }
                                else if($product->prod_type==3 || $product->parent_prod_id!=0){
                                    if($product->prod_type==3){ 
                                        return $this->getSubProducts1($product->id);
                                    }else{ 
                                        $msg = $this->configProduct($product->parent_prod_id, $offerProd->qty,$product->id);
                                    }
                                    
                                }
                                
                                if ($msg == 1) {
                                    $data['data']['cart'] = null;
                                    $data['status'] = "0";
                                    $data['msg'] = $msg;
                                } else {
                                    //return $msg;
                                    $cartData = Cart::instance("shopping")->content();
                                    $user->cart = json_encode($cartData);
                                    $user->update();
                                    $data['data']['cart'] = $cartData;
                                    $data["data"]['cartCount'] = Cart::instance("shopping")->count();
                                    $data['status'] = "1";
                                    $data['msg'] = "";
                                }
                            }
                        }
                    }else if($offerDetails->type == 2){
                        $productData = DB::table("products")->where('id',$offerProd->prod_id)->first();
                            if(!empty($productData)){
                                
                                $msg = $this->simpleProduct($productData->id,$offerProd->qty);
                                //dd($msg);
                                if ($msg == 1) {
                                    $data['data']['cart'] = null;
                                    $data['status'] = "0";
                                    $data['msg'] = $msg;
                                } else {
                                    //return $msg;
                                    $cartData = Cart::instance("shopping")->content();
                                    $user->cart = json_encode($cartData);
                                    $user->update();
                                    $data['data']['cart'] = $cartData;
                                    $data["data"]['cartCount'] = Cart::instance("shopping")->count();
                                    $data['status'] = "1";
                                    $data['msg'] = "";
                                }
                            }
                    }
                    
                    return $data;
                }
                
            }else{
                return response()->json(["status" => 0, 'msg' => 'No Product found.']); 
            }
        }else{
            return response()->json(["status" => 0, 'msg' => 'Mandatory fields are missing.']);
        }
    }

    public function downloadProduct($prod_id, $quantity)
    {
        $product = Product::find($prod_id);
        $store = DB::table('stores')->where('id', $product->store_id)->first();
        $store_id = $store->id;
        $prefix = $store->prefix;
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
        $is_stockable = DB::table('general_setting')->where('store_id', $product->store_id)->where('url_key', 'stock')->first();
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

    public function comboProduct($prod_id, $quantity, $sub_prod)
    {
        $product = Product::find($prod_id);
        $store = DB::table('stores')->where('id', $product->store_id)->first();
        $store_id = $store->id;
        $prefix = $store->prefix;
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
            $prod["img"] = ''; //Product::find($cmb->id)->catalogimgs()->first()->filename;
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
        $is_stockable = DB::table('general_setting')->where('store_id', $product->store_id)->where('url_key', 'stock')->first();
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

    public function configProduct1($prod_id, $quantity, $sub_prod)
    {
        $product = Product::find($prod_id);
        $store = DB::table('stores')->where('id', $product->store_id)->first();
        $store_id = $store->id;
        $prefix = $store->prefix;
        $is_stockable = DB::table('general_setting')->where('url_key', 'stock')->where('store_id', $product->store_id)->first();
        $cats = [];

        foreach ($product->categories as $cat) {
            array_push($cats, $cat->id);
        }
        $pname = $product->product;
        $prod_type = $product->prod_type;
        $images = @$product->catalogimgs()->where("image_type", "=", 1)->get()->first()->filename;
        $imagPath = 'http://' . $store->url_key . '.' . $_SERVER['HTTP_HOST'] . '/uploads/catalog/products/' . $images;
        $subProd = Product::where("id", "=", $sub_prod)->first();
        if (($product->spl_price) > 0 && ($product->spl_price < $product->spl_price)) {
            $price = $product->price;
        } else {
            $price = $product->selling_price; //$product->price;
        }
        if ($subProd != 'NULL') {
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
                $searchExist = Helper::searchExistingCart($prod_id);
                if (!$searchExist["isExist"]) {
                    Cart::instance('shopping')->add(["id" => $prod_id, "name" => $pname,
                        "qty" => $quantity, "price" => $price,
                        "options" => ["image" => $image, "image_with_path" => $imagPath, "selected_attrs_labels" => $option_name, "sub_prod" => $subProd->id,
                            "options" => $options, "is_cod" => $product->is_cod, "min_order_qty" => $product->min_order_quantity,
                            'cats' => $cats, 'stock' => $subProd->stock, 'url' => $product->url_key, 'store_id' => $store_id, 'prefix' => $prefix, 'is_stock' => $product->is_stock, "discountedAmount" => $price, "disc" => 0, 'wallet_disc' => 0, 'voucher_disc' => 0, 'referral_disc' => 0, 'user_disc' => 0, "tax_type" => $type, "taxes" => $sum, "tax_amt" => $tax_amt, 'prod_type' => $prod_type]]);
                } else {
                    Cart::instance('shopping')->update($searchExist["rowId"], ['qty' => ($searchExist["qty"] + $quantity)]);
                }
            } else {
                return 1;
            }
        } else {
            $searchExist = Helper::searchExistingCart($prod_id);
            if (!$searchExist["isExist"]) {
                Cart::instance('shopping')->add(["id" => $prod_id, "name" => $pname,
                    "qty" => $quantity, "price" => $price,
                    "options" => ["image" => $image, "image_with_path" => $imagPath, "selected_attrs_labels" => $option_name, "sub_prod" => $subProd->id,
                        "options" => $options, "is_cod" => $product->is_cod, "min_order_qty" => $product->min_order_quantity,
                        'cats' => $cats, 'stock' => $subProd->stock, 'url' => $product->url_key, 'store_id' => $store_id, 'prefix' => $prefix, 'is_stock' => $product->is_stock, "discountedAmount" => $price, "disc" => 0, 'wallet_disc' => 0, 'voucher_disc' => 0, 'referral_disc' => 0, 'user_disc' => 0, "tax_type" => $type, "taxes" => $sum, "tax_amt" => $tax_amt, 'prod_type' => $prod_type]]);
            } else {
                Cart::instance('shopping')->update($searchExist["rowId"], ['qty' => ($searchExist["qty"] + $quantity)]);
            }
        }
    }

    public function configProduct($prod_id, $quantity, $sub_prod)
    {
        $product = Product::find($prod_id);
        $store = DB::table('stores')->where('id', $product->store_id)->first();
        $store_id = $store->id;
        $prefix = $store->prefix;
        $is_stockable = DB::table('general_setting')->where('url_key', 'stock')->where('store_id', $product->store_id)->first();
        $cats = [];

        foreach ($product->categories as $cat) {
            array_push($cats, $cat->id);
        }
        $pname = $product->product;
        $prod_type = $product->prod_type;
        $images = @$product->catalogimgs()->where("image_type", "=", 1)->get()->first()->filename;
        $imagPath = 'http://' . $store->url_key . '.' . $_SERVER['HTTP_HOST'] . '/uploads/catalog/products/' . $images;
        $subProd = Product::where("id", "=", $sub_prod)->first();
        if (($product->spl_price) > 0 && ($product->spl_price < $product->spl_price)) {
            $price = $product->price;
        } else {
            $price = $product->selling_price; //$product->price;
        }
        if ($subProd != 'NULL') {
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
        $isOfferProduct = 0;$offer_qty=0;
        $offerId = 0; $offer_disc_amt = $price;
        //Offer product check
        $OfferProd = DB::table("offers_products")->where(['prod_id'=>$prod_id,'type'=>1])->first();
        if ($OfferProd != null) {
            $offerDetails = DB::table("offers")->where(['id' => $OfferProd->offer_id])->first();
            $offerId = $OfferProd->offer_id;
            if (!empty($offerDetails)) {
                $discount = 0;
                if ($offerDetails->type == 1) {
                    $discount = 0;
                    if($offerDetails->offer_discount_type==1){
                        $discount = $price * ($offerDetails->offer_discount_value / 100);
                    }else if($offerDetails->offer_discount_type==2){
                        $discount = $offerDetails->offer_discount_value;
                    }
                    $price = $price - $discount; 
                    $qty = $OfferProd->qty;
                }else if ($offerDetails->type == 2) {
                    return $this->addOfferProd($offerId);
                }
            }
            
        }
        if ($product->is_stock == 1 && $is_stockable->status == 1) {
            if (Helper::checkStock($prod_id, $quantity, $sub_prod) == "In Stock") {
                // $product = Product::find($sub_prod);
                $searchExist = Helper::searchExistingCart($sub_prod);
                $options = ["image" => $image, "image_with_path" => $imagPath, "selected_attrs_labels" => $option_name, "sub_prod" => $subProd->id,
                "options" => $options, "is_cod" => $product->is_cod, "min_order_qty" => $product->min_order_quantity,
                'cats' => $cats, 'stock' => $subProd->stock, 'url' => $product->url_key, 'store_id' => $store_id, 'prefix' => $prefix, 'is_stock' => $product->is_stock, "discountedAmount" => $price, "disc" => 0, 'wallet_disc' => 0, 'voucher_disc' => 0, 'referral_disc' => 0, 'user_disc' => 0, "tax_type" => $type, "taxes" => $sum, "tax_amt" => $tax_amt, 'prod_type' => $prod_type];
                if (!$searchExist["isExist"]) {
                    Cart::instance('shopping')->add(["id" => $prod_id, "name" => $pname,
                        "qty" => $quantity, "price" => $price,
                        "options" => $options]);
                } else {
                    $newOfferedQty = ($searchExist['offer_qty']+$offer_qty);
                    $optionsData['offer_qty'] = $newOfferedQty;
                    $optionsData['offer_disc_amt'] = $offer_disc_amt * $newOfferedQty;
                    Cart::instance('shopping')->update($searchExist["rowId"], ['qty' => ($searchExist["qty"] + $quantity),"options" => $optionsData]);
                }
            } else {
                return 1;
            }
        } else {
           
            $searchExist = Helper::searchExistingCart($prod_id);
            $options = ["offerId"=>$offerId,"isOfferProduct"=>$isOfferProduct,"offer_qty"=>$offer_qty,"offer_disc_amt"=>$offer_disc_amt,"image" => $image, "image_with_path" => $imagPath, "selected_attrs_labels" => $option_name, "sub_prod" => $subProd->id,
                "options" => $options, "is_cod" => $product->is_cod, "min_order_qty" => $product->min_order_quantity,
                'cats' => $cats, 'stock' => $subProd->stock, 'url' => $product->url_key, 'store_id' => $store_id, 'prefix' => $prefix, 'is_stock' => $product->is_stock, "discountedAmount" => $price, "disc" => 0, 'wallet_disc' => 0, 'voucher_disc' => 0, 'referral_disc' => 0, 'user_disc' => 0, "tax_type" => $type, "taxes" => $sum, "tax_amt" => $tax_amt, 'prod_type' => $prod_type];
                //dd($searchExist);
                if (!$searchExist["isExist"]) { 
                    Cart::instance('shopping')->add(["id" => $prod_id, "name" => $pname,
                        "qty" => $quantity, "price" => $price,
                        "options" => $options]);
                } else {
                    $newOfferedQty = ($searchExist['offer_qty']+$offer_qty);
                    $options['offer_qty'] = $newOfferedQty;
                    $options['offer_disc_amt'] = $offer_disc_amt * $newOfferedQty;
                    Cart::instance('shopping')->update($searchExist["rowId"], ['qty' => ($searchExist["qty"] + $quantity),"options" => $options]);
                }
            // if (!$searchExist["isExist"]) {
            //     Cart::instance('shopping')->add(["id" => $prod_id, "name" => $pname,
            //         "qty" => $quantity, "price" => $price,
            //         "options" => ["image" => $image, "image_with_path" => $imagPath, "selected_attrs_labels" => $option_name, "sub_prod" => $subProd->id,
            //             "options" => $options, "is_cod" => $product->is_cod, "min_order_qty" => $product->min_order_quantity,
            //             'cats' => $cats, 'stock' => $subProd->stock, 'url' => $product->url_key, 'store_id' => $store_id, 'prefix' => $prefix, 'is_stock' => $product->is_stock, "discountedAmount" => $price, "disc" => 0, 'wallet_disc' => 0, 'voucher_disc' => 0, 'referral_disc' => 0, 'user_disc' => 0, "tax_type" => $type, "taxes" => $sum, "tax_amt" => $tax_amt, 'prod_type' => $prod_type]]);
            // } else {
            //     Cart::instance('shopping')->update($searchExist["rowId"], ['qty' => ($searchExist["qty"] + $quantity)]);
            // }
        }
    }

    public function edit()
    {
        $rowId = filter_var(Input::get('rowid'), FILTER_SANITIZE_STRING);
        $quantity = filter_var(Input::get('quantity'), FILTER_SANITIZE_STRING);
        if($quantity == 0) {
            $user = User::where('id', Session::get('authUserId'))->first();
            $cartData = json_decode($user->cart, true);
            Cart::instance('shopping')->add($cartData);
            Cart::instance('shopping')->remove($rowId);
            $cartData = Cart::instance("shopping")->content();
            if(Cart::instance("shopping")->count() != 0){
                $user->cart = json_encode($cartData);
            } else {
                $user->cart = '';
            }
            $user->update();
            $data['data']['cart'] = $cartData;
            $data["data"]['cartCount'] = Cart::instance("shopping")->count();
            $data['status'] = "1";
            $data['msg'] = "Item removed successfully";
            return $data;
        }
        if(!empty($rowId) && !empty($quantity)) {
            $user = User::where('id', Session::get('authUserId'))->first();
            $cartData = json_decode($user->cart, true);
            Cart::instance('shopping')->add($cartData);
            $cart = Cart::instance('shopping')->update($rowId, ['qty' => $quantity]);
            $amt = Helper::calAmtWithTax();
            $cartInstance = Cart::instance('shopping')->get("$rowId");
            $tax = $cartInstance->options->tax_amt;
            $sub_total = $cartInstance->subtotal;
            $total = Cart::total();
            if ($cartInstance->options->tax_type == 2) {
                $sub_total = $cartInstance->subtotal + $tax;
                $total = Cart::total() + $tax;
            }
            // $cart = Helper::getnewCart();
            $cartData = Cart::instance("shopping")->content();
            $user->cart = json_encode($cartData);
            $user->update();
            $data['data']['cart'] = $cartData;
            $data['data']['subtotal'] = $sub_total;
            $data['data']['finaltotal'] = $amt['total'];
            $data['data']['total'] = $amt['total'];
            $data['data']['tax'] = $cartInstance->options->tax_amt;
            $data['data']['cart_count'] = Cart::instance("shopping")->count();
            $data['msg'] = '';
            $data['status'] = 1;
            Session::put("pay_amt", $amt['total']);
        } else {
            $data['msg'] = 'Mandatory fields are missing.';
            $data['status'] = 0;
        }
        return $data;
    }

    public function delete()
    {
        Cart::instance('shopping')->remove(Input::get("rowid"));
        $cart = Helper::getnewCart();
        // $cart_amt = Helper::calAmtWithTax();
        $cartCnt = Cart::instance('shopping')->count();
        //echo "||||||||||" . Helper::getAmt() . "||||||||||" . $cart . "||||||||||" . $cartCnt . "||||||||||" . Cart::instance('shopping')->total();
        $data = [];
        array_push($data, $cart_amt['total'], $cart, $cartCnt, $cart_amt['total'], (Session::get('couponUsedAmt')));
        //array_push($data, Helper::getAmt(), $cart, $cartCnt, Cart::instance('shopping')->total(), (Session::get('couponUsedAmt')));
        Session::put("pay_amt", $cart_amt['total']);
        // Session::put("pay_amt", Cart::instance('shopping')->total());
        return $data;
    }

    public function checkIfOfferExists()
    {

    }

    public function getSubProducts1($prodIds)
    {
        $data = [];
        foreach($prodIds as $prodIdKey => $prod_id){
            if($prod_id){
                $prod = Product::find($prod_id);
                if($prod != null && $prod->prod_type == 3){
                    if($prod->is_stock==1 && $this->feature["stock"]==1) {
                        $subprods = $prod->getsubproducts()->get();
                    } else {
                        $subprods = $prod->subproducts()->get();
                    }        
                    foreach ($subprods as $subP) {
                        $hasOpt = $subP->attributes()->withPivot('attr_id', 'prod_id', 'attr_val')->where("status",1)->orderBy("att_sort_order", "asc")->get();
                        foreach ($hasOpt as $prdOpt) {
                            $selAttrs[$prdOpt->pivot->attr_id]['placeholder'] = Attribute::find($prdOpt->pivot->attr_id)->placeholder;
                            $selAttrs[$prdOpt->pivot->attr_id]['name'] = Attribute::find($prdOpt->pivot->attr_id)->attr;
                            $selAttrs[$prdOpt->pivot->attr_id][Attribute::find($prdOpt->pivot->attr_id)->slug] = Attribute::find($prdOpt->pivot->attr_id)->attr;
                            $selAttrs[$prdOpt->pivot->attr_id]['options'][AttributeValue::find($prdOpt->pivot->attr_val)->option_value] = AttributeValue::find($prdOpt->pivot->attr_val)->option_name;
                            $selAttrs[$prdOpt->pivot->attr_id]['attrs'][AttributeValue::find($prdOpt->pivot->attr_val)->option_value]['prods'][] = $prdOpt->pivot->prod_id;
                            $selAttrs[$prdOpt->pivot->attr_id]['prods'][] = $prdOpt->pivot->prod_id;
                        }
                    }
                    $data[$prodIdKey]['productId'] = $prod_id;
                    $data[$prodIdKey]['variants'] = $selAttrs;
                    $data['status'] = "1";
                    $data['msg'] = "";
                } else {
                    $data['status'] = "0";
                    $data['msg'] = "Invalid product";
                }
            } else {
                $data['status'] = "0";
                $data['msg'] = "Mandatory field is missing.";
            }
        }
        
        return $data;
    }

    public function getSubProducts()
    {
        $prod_id = filter_var(Input::get('prod_id'), FILTER_SANITIZE_STRING);
        if($prod_id){
            $prod = Product::find($prod_id);
            if($prod != null && $prod->prod_type == 3){
                if($prod->is_stock==1 && $this->feature["stock"]==1) {
                    $subprods = $prod->getsubproducts()->get();
                } else {
                    $subprods = $prod->subproducts()->get();
                }        
                foreach ($subprods as $subP) {
                    $hasOpt = $subP->attributes()->withPivot('attr_id', 'prod_id', 'attr_val')->where("status",1)->orderBy("att_sort_order", "asc")->get();
                    foreach ($hasOpt as $prdOpt) {
                        $selAttrs[$prdOpt->pivot->attr_id]['placeholder'] = Attribute::find($prdOpt->pivot->attr_id)->placeholder;
                        $selAttrs[$prdOpt->pivot->attr_id]['name'] = Attribute::find($prdOpt->pivot->attr_id)->attr;
                        $selAttrs[$prdOpt->pivot->attr_id][Attribute::find($prdOpt->pivot->attr_id)->slug] = Attribute::find($prdOpt->pivot->attr_id)->attr;
                        $selAttrs[$prdOpt->pivot->attr_id]['options'][AttributeValue::find($prdOpt->pivot->attr_val)->option_value] = AttributeValue::find($prdOpt->pivot->attr_val)->option_name;
                        $selAttrs[$prdOpt->pivot->attr_id]['attrs'][AttributeValue::find($prdOpt->pivot->attr_val)->option_value]['prods'][] = $prdOpt->pivot->prod_id;
                        $selAttrs[$prdOpt->pivot->attr_id]['prods'][] = $prdOpt->pivot->prod_id;
                    }
                }
                $data['variants'] = $selAttrs;
                $data['status'] = "1";
                $data['msg'] = "";
            }else {
                $data['status'] = "0";
                $data['msg'] = "Invalid product";
            }
        } else {
            $data['status'] = "0";
            $data['msg'] = "Mandatory field is missing.";
        }
        return $data;
    }

    public function removeCartItem($prod_id){
        $searchExist = Helper::searchExistingCart($prod_id);
        if($searchExist["isExist"]) {
            Cart::instance('shopping')->remove($searchExist["rowId"]);
            return 2;
        } else {
            return 0;
        }
    }



}
