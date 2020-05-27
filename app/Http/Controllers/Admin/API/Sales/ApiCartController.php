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
use App\Models\Merchant;
use Config;
use Cart;
use DB;
use Input;
use Session;

class ApiCartController extends Controller
{
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
