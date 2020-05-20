<?php

namespace App\Http\Controllers\Admin\API\Sales;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\CustomValidator;
use App\Library\Helper;
use App\Models\User;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Product;
use Config;
use Cart;
use DB;
use Input;
use Session;

class ApiCartController extends Controller
{
    public function getProductByBarcode()
    {
        $barcode = Input::get('barcode');
        if($barcode != ''){
        $productResult = DB::table('products as p')
                    ->leftJoin('brand as b', 'p.brand_id', '=', 'b.id')
                    ->where(['p.barcode' => $barcode])
                    ->select(['p.id', 'p.store_id', 'b.id as brand_id', 'b.name as brand_name', 'p.product', 'p.images', 'p.product_code', 'p.is_featured', 'p.prod_type', 'p.is_stock', 'p.is_avail', 'p.is_listing', 'p.status', 'p.stock', 'p.max_price', 'p.min_price', 'p.purchase_price', 'p.price', 'p.spl_price', 'p.selling_price', 'p.is_cod', 'p.is_tax', 'p.is_trending', 'p.min_order_quantity', 'p.is_share_on_mall', 'p.store_id','p.barcode','p.parent_prod_id'])->first();
        if($productResult != null){
            if($productResult->parent_prod_id == ''){
                $prod_id = $productResult->id;
            }else{
                $prod_id = $productResult->parent_prod_id;
            }
            $store = DB::table('stores')->where('id',$productResult->store_id)->first();
            //Get Product image
            $productImages = DB::table('catalog_images')
            ->select(DB::raw('filename'))
            ->where(['catalog_id' => $prod_id])
            ->get();
            $productImage = '';
        
            if (count($productImages) > 0) {
                $productImage = "http://" . $store->url_key . "." . $_SERVER['HTTP_HOST'] . "/uploads/catalog/products/" . $productImages[0]->filename;
            }
            $data = [];
            $storeId = $store->id;
            $data['store_id'] = $store->id;
            $data['store_name'] = $store->store_name;
            $data['product_id'] = $productResult->id;
            $data['brand_id'] = $productResult->brand_id;
            $data['brand_name'] = $productResult->brand_name;
            $data['product'] = $productResult->product;
            $data['images'] = $productImage;
            $data['product_code'] = $productResult->product_code;
            $data['is_featured'] = $productResult->is_featured;
            $data['prod_type'] = $productResult->prod_type;
            $data['is_stock'] = $productResult->is_stock;
            $data['is_avail'] = $productResult->is_avail;
            $data['is_listing'] = $productResult->is_listing;
            $data['status'] = $productResult->status;
            $data['stock'] = $productResult->stock;
            $data['max_price'] = $productResult->max_price;
            $data['min_price'] = $productResult->min_price;
            $data['purchase_price'] = $productResult->purchase_price;
            $data['price'] = $productResult->price;
            $data['spl_price'] = $productResult->spl_price;
            $data['selling_price'] = $productResult->selling_price;
            $data['is_cod'] = $productResult->is_cod;
            $data['is_tax'] = $productResult->is_tax;
            $data['is_trending'] = $productResult->is_trending;
            $data['barcode'] = $productResult->barcode;
            $data['min_order_quantity'] = $productResult->min_order_quantity;
            $data['is_share_on_mall'] = $productResult->is_share_on_mall;

            if ($data) {
                return response()->json(["status" => 1, 'data' => $data]);
            } else {
                return response()->json(["status" => 2, 'msg' => 'Product not found']);
            }
        }else {
            return response()->json(["status" => 0, 'msg' => 'Invalid Barcode.']);
        }  
        } else {
            return response()->json(["status" => 0, 'msg' => 'Mandatory fields are missing.']);
        }
    }

    public function index()
    {
        $user = User::where('id', Session::get('authUserId'))->first();
        if ($user->sales_cart != '') {
            Cart::instance('sales_shopping')->destroy();
            $cartData = json_decode($user->sales_cart, true);
            if($cartData != '' && !empty($cartData))
                Cart::instance('sales_shopping')->add($cartData);
        }
        $cartData = Cart::instance("sales_shopping")->content();
        $data['data']['cart'] = $cartData;
        $data['data']['total'] = Helper::getOrderTotal($cartData);
        $data['data']["cartCount"] = Cart::instance("sales_shopping")->count();
        $data['status'] = 1;
        $data['msg'] = "";
        return $data;
    }

    public function add()
    {
        $data = [];
        $msg = '';
        $prod_id = filter_var(Input::get('prod_id'), FILTER_SANITIZE_STRING);
        $product = DB::table("products")->where("id", $prod_id)->select("id", "prod_type", "store_id")->first();
        if ($product != null) {
            $prod_type = $product->prod_type; //filter_var(Input::get('prod_type'), FILTER_SANITIZE_STRING); //Input::get("prod_type");
            $sub_prod = filter_var(Input::get('sub_prod'), FILTER_SANITIZE_STRING);
            $quantity = filter_var(Input::get('quantity'), FILTER_SANITIZE_STRING);
            $user = User::where('id', Session::get('authUserId'))->first();
            if ($user->sales_cart != '') {
                $cartData = json_decode($user->sales_cart, true);
                Cart::instance('sales_shopping')->add($cartData);
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
            
            if ($msg == 1) {
                $data['data']['cart'] = null;
                $data['status'] = 0;
                $data['msg'] = $msg;
            } else {
                //return $msg;
                $cartData = Cart::instance("sales_shopping")->content();
                //dd(Session::get('authUserId'));
                if(Cart::instance("sales_shopping")->count() != 0){
                    $user->sales_cart = json_encode($cartData);
                } else {
                    $user->sales_cart = '';
                }
                $user->update();
                $data['data']['cart'] = $cartData;
                $data['data']['total'] = Helper::getOrderTotal($cartData);
                $data["data"]['cartCount'] = Cart::instance("sales_shopping")->count();
                $data['status'] = 1;
                $data['msg'] = "Item added successfully";
            }
        } else {
            $data['status'] = 0;
            $data['msg'] = "Invalid product";
        }
        return $data;
    }

    public function edit()
    {
        $quantity = filter_var(Input::get('quantity'), FILTER_SANITIZE_STRING);
        $prod_id = filter_var(Input::get('prod_id'), FILTER_SANITIZE_STRING);
        $sub_prod = filter_var(Input::get('sub_prod'), FILTER_SANITIZE_STRING);
        
        if($quantity == 0) {
            $user = User::where('id', Session::get('authUserId'))->first();
            $cartData = json_decode($user->sales_cart, true);
            Cart::instance('sales_shopping')->add($cartData);
            $cartData = Cart::instance("sales_shopping")->content();
            foreach($cartData as $cItem){
                if($cItem->id == $prod_id){
                    if($cItem->options->sub_prod && ($cItem->options->sub_prod == $sub_prod)){
                        $rowId = $cItem->rowid;
                        if($rowId==null){
                            $rowId = $cItem->rowId;
                        }
                    }else{
                        $rowId = $cItem->rowid;
                        if($rowId==null){
                            $rowId = $cItem->rowId;
                        }
                    }
                    Cart::instance('sales_shopping')->remove($rowId);
                }
            }
            if(Cart::instance("sales_shopping")->count() != 0){
                $user->sales_cart = json_encode($cartData);
            } else {
                $user->sales_cart = '';
            }
            $user->update();
            $data['data']['cart'] = $cartData;
            $data['data']['total'] = Helper::getOrderTotal($cartData);
            $data["data"]['cartCount'] = Cart::instance("sales_shopping")->count();
            $data['status'] = 1;
            $data['msg'] = "Item removed successfully";
            return $data;
        }
        if(!empty($prod_id) && !empty($quantity)) {
            $user = User::where('id', Session::get('authUserId'))->first();
            $cartData = json_decode($user->sales_cart, true);
            
            Cart::instance('sales_shopping')->add($cartData);
            $cartData = Cart::instance("sales_shopping")->content();
          
            foreach($cartData as $cItem){
                if($cItem->id == $prod_id){
                    if($cItem->options->sub_prod && ($cItem->options->sub_prod == $sub_prod)){
                        $rowId = $cItem->rowid;
                        if($rowId==null){
                            $rowId = $cItem->rowId;
                        }
                    }else{
                        $rowId = $cItem->rowid;
                        if($rowId==null){
                            $rowId = $cItem->rowId;
                        }
                    }
                }
            }
            $cart = Cart::instance('sales_shopping')->update($rowId, ['qty' => $quantity]);
            
            $amt = Helper::calAmtWithTax();
            $cartInstance = Cart::instance('sales_shopping')->get("$rowId");          
            $tax = $cartInstance->options->tax_amt;
            $sub_total = $cartInstance->subtotal;
            $total = Cart::total();
            if ($cartInstance->options->tax_type == 2) {
                $sub_total = $cartInstance->subtotal + $tax;
                $total = Cart::total() + $tax;
            }
            $cartData = Cart::instance("sales_shopping")->content();
            $user->sales_cart = json_encode($cartData);
            $user->update();
            $data['data']['cart'] = $cartData;
            $data['data']['total'] = Helper::getOrderTotal($cartData);
            // $data['data']['subtotal'] = $sub_total;
            // $data['data']['finaltotal'] = $amt['total'];
            // $data['data']['total'] = $amt['total'];
            // $data['data']['tax'] = $cartInstance->options->tax_amt;
            $data['data']['cartCount'] = Cart::instance("sales_shopping")->count();
            $data['status'] = 1;
            $data['msg'] = 'Item quantity updated successfully';
            Session::put("pay_amt", $amt['total']);
        } else {
            $data['msg'] = 'Mandatory fields are missing.';
            $data['status'] = 0;
        }
        return $data;
    }

    public function simpleProduct($prod_id, $quantity)
    {
        $product = Product::find($prod_id);
        $store = DB::table('stores')->where('id', $product->store_id)->first();
        $store_id = $store->id;
        $store_name = $store->store_name;
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
     
        //create cart instance            
        $is_stockable = DB::table('general_setting')->where('store_id', $product->store_id)->where('url_key', 'stock')->first();

        if ($product->is_stock == 1 && $is_stockable->status == 1) {
            if (Helper::checkStock($prod_id, $quantity) == "In Stock") {
                $searchExist = Helper::searchExistingSalesCart($prod_id);

                $optionsData = ["image" => $images, "image_with_path" => $imagPath, "is_cod" => $product->is_cod, 'url' => $product->url_key, 'store_id' => $store_id, 'store_name'=>$store_name, 'prefix' => $prefix,
                'cats' => $cats, 'stock' => $product->stock, 'is_stock' => $product->is_stock,
                "prod_type" => $prod_type,
                "discountedAmount" => $price, "disc" => 0, 'wallet_disc' => 0, 'voucher_disc' => 0, 'referral_disc' => 0, 'user_disc' => 0, 'tax_type' => $type, 'taxes' => $sum, 'tax_amt' => $tax_amt];

                if (!$searchExist["isExist"]) {
                    Cart::instance('sales_shopping')->add(["id" => $prod_id, "name" => $pname, "qty" => $quantity, "price" => $price,
                        "options" => $optionsData]);
                } else {
                    Cart::instance('sales_shopping')->update($searchExist["rowId"], ['qty' => $quantity,"options" => $optionsData]);
                }
            } else {
                return 1;
            }
        } else {
            $searchExist = Helper::searchExistingSalesCart($prod_id);
            
            $optionsData = ["image" => $images, "image_with_path" => $imagPath, "is_cod" => $product->is_cod, 'url' => $product->url_key, 'store_id' => $store_id, 'store_name'=>$store_name, 'prefix' => $prefix,
                'cats' => $cats, 'stock' => $product->stock, 'is_stock' => $product->is_stock,
                "prod_type" => $prod_type,
                "discountedAmount" => $price, "disc" => 0, 'wallet_disc' => 0, 'voucher_disc' => 0, 'referral_disc' => 0, 'user_disc' => 0, 'tax_type' => $type, 'taxes' => $sum, 'tax_amt' => $tax_amt];

                if (!$searchExist["isExist"]) {
                    Cart::instance('sales_shopping')->add(["id" => $prod_id, "name" => $pname, "qty" => $quantity, "price" => $price,
                        "options" => $optionsData]);
                } else {
                   
                    Cart::instance('sales_shopping')->update($searchExist["rowId"], ['qty' => $quantity,"options" => $optionsData]);
                }
        }
        
    }
}