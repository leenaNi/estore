<?php

namespace App\Http\Controllers\Admin\API\Sales;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Product;
use App\Models\Merchant;
use Config;
use Cart;
use DB;
use Input;
use Session;

class ApiProductController extends Controller
{
    public function getProductByBarcode(){
        $barcode = Input::get('barcode');
       
        if($barcode != ''){
            $marchantId = Session::get("merchantId");
            $merchant = Merchant::find($marchantId)->getstores()->first();
            $prifix = $merchant->prefix;
            $store = DB::table('stores')->where('merchant_id',$marchantId)->first();
            $varient = DB::table('general_setting')->where('store_id',$store->id)->where('url_key', 'products-with-variants')->first()->status;
            $product = DB::table('products')->where('store_id',$store->id)->where('barcode', $barcode)->first();
      
        if($product != null){
            if($product->parent_prod_id == ''){
                $prod_id = $product->id;
            }else{
                $prod_id = $product->parent_prod_id;
            }
            if ($varient == 0) {
                $products = $product->where("prod_type", 1);
            }

            $category = DB::table('store_categories')
            ->join('categories as c','c.id','=','store_categories.category_id')
            ->where("c.status", '1')
            ->where("store_categories.store_id",$store->id)
            ->orderBy("c.id", "asc")
            ->select('store_categories.id','c.category')
            ->get();

            $textAmt = app('App\Http\Controllers\Admin\ApiProductsController')->calTax($product, $prifix);
            $product->taxAmt = $textAmt['tax_amt'] ? $textAmt['tax_amt'] : 0;
            $product->taxRate = $textAmt['rate'] ? $textAmt['rate'] : 0;
            if ($product->is_tax == 2) {
                $product->subtotal = $product->taxAmt + $product->selling_price;
            } else {
                $product->subtotal = $product->selling_price;
            }
            $product->categories = DB::table('has_categories')->where("prod_id", $prod_id)->select("cat_id")->get()->toArray();
            $product->prodImage = "http://" . $merchant->url_key . '.' . $_SERVER['HTTP_HOST'] . '/uploads/catalog/products/' . @DB::table('catalog_images')->where("image_mode", 1)->where('catalog_id', $prod_id)->first()->filename;
           
            if ($product) {
                return response()->json(["status" => 1, 'data' => $product]);
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

    public function getSubProducts(){
        $prod_id = Input::get('prod_id');
        if($prod_id != ''){
            $marchantId = Session::get("merchantId");
            $merchant = Merchant::find($marchantId)->getstores()->first();
            $prifix = $merchant->prefix;
            $store = DB::table('stores')->where('merchant_id',$marchantId)->first();
            $varient = DB::table('general_setting')->where('store_id',$store->id)->where('url_key', 'products-with-variants')->first()->status;
            $products = DB::table('products')->where('store_id',$store->id)->where('parent_prod_id', $prod_id)->get();
      
            if($products != null){
                foreach ($products as $prd) {
                    if($prd->parent_prod_id == ''){
                        $prod_id = $prd->id;
                    }else{
                        $prod_id = $prd->parent_prod_id;
                    }
                    if ($varient == 0) {
                        $prd = $prd->where("prod_type", 1);
                    }

                    $textAmt = app('App\Http\Controllers\Admin\ApiProductsController')->calTax($prd, $prifix);
                    $prd->taxAmt = $textAmt['tax_amt'] ? $textAmt['tax_amt'] : 0;
                    $prd->taxRate = $textAmt['rate'] ? $textAmt['rate'] : 0;
                    if ($prd->is_tax == 2) {
                        $prd->subtotal = $prd->taxAmt + $prd->selling_price;
                    } else {
                        $prd->subtotal = $prd->selling_price;
                    }
                    //  $prd->AppliedTaxId = DB::table($prifix.'_product_has_taxes')->where('product_id',$prd->id)->pluck("tax_id");
                    $prd->categories = DB::table('has_categories')->where("prod_id", $prod_id)->select("cat_id")->get()->toArray();
                    $prd->prodImage = "http://" . $merchant->url_key . '.' . $_SERVER['HTTP_HOST'] . '/uploads/catalog/products/' . @DB::table('catalog_images')->where("image_mode", 1)->where('catalog_id', $prod_id)->first()->filename;
                }
                
                return response()->json(["status" => 1, 'data' => $products]);
                
            }else {
                return response()->json(["status" => 0, 'msg' => 'No Sub-Product Found.']);
            }  
        } else {
            return response()->json(["status" => 0, 'msg' => 'Mandatory fields are missing.']);
        }
    }
}
