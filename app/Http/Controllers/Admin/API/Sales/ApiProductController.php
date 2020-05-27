<?php

namespace App\Http\Controllers\Admin\API\Sales;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Route;
use App\Models\Product;
use App\Models\HasProducts;
use App\Models\Finish;
use App\Models\Merchant;
use App\Models\Category;
use App\Models\ProductType;
use App\Models\AttributeSet;
use App\Models\CatalogImage;
use App\Models\Attribute;
use App\Models\Conversion;
use App\Models\AttributeValue;
use App\Models\DownlodableProd;
use App\Models\GeneralSetting;
use App\Models\StockUpdateHistory;
use Response;
use App\Models\User;
use App\Library\Helper;
use App\Classes\UploadHandler;
use Vsmoraes\Pdf\Pdf;
use Config;
use Cart;
use DB;
use Input;
use Session;

class ApiProductController extends Controller
{
    public function index() {
        // dd(123);
         $marchantId = Session::get("merchantId");
         $merchant = Merchant::find($marchantId)->getstores()->first();
          $prifix = $merchant->prefix;
         $store = DB::table('stores')->where('merchant_id',$marchantId)->first();
 
         $varient = DB::table('general_setting')->where('store_id',$store->id)->where('url_key', 'products-with-variants')->first()->status;
         $products = DB::table('products')->where('is_individual', '=', '1')->where('store_id',$store->id)->where('products.status', '=', '1')->select("*");
         
         if ($varient == 0) {
             $products = $products->where("prod_type", 1);
         }
         
         if (!empty(Input::get('product_name'))) {
             $products = $products->where('product', 'like', "%" . Input::get('product_name') . "%");
         }
        
 
          if (!empty(Input::get('searchTerm'))) {
 
             $data['cat_name'] = "Search results for " . Input::get('searchTerm');
             $data['metaTitle'] = "";
             $data['metaDesc'] = "";
             $data['metaKeys'] = "";
             if (!empty(Input::get('searchTerm'))) {
               
                 $search = Input::get('searchTerm');
 
                  $products = $products->where('product', 'like', $search)
                     ->orWhere('short_desc', 'like', $search)
                     ->orWhere('long_desc', 'like', $search)
                     ->orWhere('meta_title', 'like', $search)
                     ->orWhere('meta_desc', 'like', $search)
                     ->orWhere('meta_keys', 'like', $search);
 
             }
         }
 
         $products = $products->paginate(10);
         $productscount = $products->total();
         // dd($products);
         // $products = $products->paginate(Config('constants.paginateNo'));
         $tax = DB::table('tax')->where('status', '=', '1')->get();
         foreach ($products as $prd) {
 
             $textAmt = $this->calTax($prd, $prifix);
             $prd->taxAmt = $textAmt['tax_amt'] ? $textAmt['tax_amt'] : 0;
             $prd->taxRate = $textAmt['rate'] ? $textAmt['rate'] : 0;
             if ($prd->is_tax == 2) {
                 $prd->subtotal = $prd->taxAmt + $prd->selling_price;
             } else {
                 $prd->subtotal = $prd->selling_price;
             }
             //  $prd->AppliedTaxId = DB::table($prifix.'_product_has_taxes')->where('product_id',$prd->id)->pluck("tax_id");
             $prd->categories = DB::table('has_categories')->where("prod_id", $prd->id)->select("cat_id")->get()->toArray();
             $prd->prodImage = "http://" . $merchant->url_key . '.' . $_SERVER['HTTP_HOST'] . '/uploads/catalog/products/' . @DB::table('catalog_images')->where("image_mode", 1)->where('catalog_id', $prd->id)->first()->filename;
         }
 
         return response()->json(['status'=>1, 'products'=>$products,'productscount'=>$productscount,'tax'=>$tax]);
     }
 
     public function calTax($product) {
         $type = $product->is_tax;
         if ($type != 0) {
             $sum = 0;
             $taxeId = DB::table('product_has_taxes')->where('product_id', $product->id)->pluck("tax_id");
             $taxes = DB::table('tax')->where('status', '=', '1')->whereIn("id", $taxeId)->get();
 
             foreach ($taxes as $tax) {
                 $sum = $sum + $tax->rate;
             }
             $tax_amt = 0;
             if ($type == 1 || $type == 2) {
                 if ($product->spl_price > 0 && $product->price > $product->spl_price) {
                     $taxs = $product->spl_price * $sum / 100;
                     $tax_amt = round($taxs, 2);
                 } else {
                     $taxs = $product->price * $sum / 100;
                     $tax_amt = round($taxs, 2);
                 }
             }
             return $tax_amt = ['tax_amt' => $tax_amt, "rate" => $sum];
         } else {
             return 0;
         }
     }
 
     public function addProduct() {
         $marchantId = Session::get("merchantId");
         $merchant = Merchant::find($marchantId)->getstores()->first();
         $store = DB::table('stores')->where('merchant_id',$marchantId)->first();
         $prifix = $merchant->prefix;
         $attibuteSet = DB::table('attribute_sets')->get();
         $prodId = Input::get('prod_id');
         $prod = [];
         $prod['store_id'] = $store->id;
         $prod['is_individual'] = 1;
         $prod['is_avail'] = 1;
         $prod['product'] = Input::get('product');
         $prod['price'] = Input::get('price');
         $prod['selling_price'] = Input::get('selling_price');
         $prod['spl_price'] = Input::get('selling_price');
         $prod['status'] = Input::get('status');
         $prod['short_desc'] = Input::get('short_desc');
         if (trim(Input::get('is_tax')) != '') {
             $prod['is_tax'] = Input::get('is_tax');
         }
         if (Input::get('trending')) {
             $prod['is_trending'] = Input::get('trending');
         }
 
         if (Input::get('is_stock') == 1) {
             $prod['is_stock'] = Input::get('is_stock');
             $prod['stock'] = Input::get('stock');
         }
 
         $prod['prod_type'] = Input::get('prod_type');
 
         $prod['attr_set'] = Input::get("attr_set");
         if ($prodId) {
             DB::table('products')->where("id", $prodId)->update($prod);
             $products = DB::table('products')->where("id", $prodId)->first();
         } else {
             $url_key = strtolower(str_replace(" ", "-", Input::get("product")));
             $url_key = $this->checkUrlKey($url_key);
 
             $prod['url_key'] = $url_key;
             DB::table('products')->insert($prod);
             $products = DB::table('products')->orderBy("id", "DESC")->first();
         }
 
         $applicable_taxes = json_decode(Input::get('applicable_tax'));
 
         $i = 0;
         if (($applicable_taxes)) {
             DB::table('product_has_taxes')->where("product_id", $prodId)->delete();
             foreach ($applicable_taxes as $key => $taxs) {
                 $taxes[$i]["product_id"] = $products->id;
                 $taxes[$i]["tax_id"] = $taxs;
                 $i++;
             }
 
             DB::table('product_has_taxes')->insert($taxes);
         }
 
         if (Input::get('prod_img')) {
             $datetime = "";
             $logoImage = Input::get('prod_img');
             $image_parts = explode(";base64,", $logoImage);
             $image_type_aux = explode("image/", $image_parts[0]);
 
             $image_type = $image_type_aux[1];
             $imgName = "prod_" . date("YmdHis") . '.' . $image_type;
             $image_base64 = base64_decode($image_parts[1]);
             $filePath = base_path() . '/merchants/' . $merchant->url_key . '/public/uploads/catalog/products/' . $imgName;
             $images = file_put_contents($filePath, $image_base64);
             $catlog = [];
             $catlog['filename'] = $imgName;
             $catlog['alt_text'] = "product_image";
             $catlog['image_type'] = 1;
             $catlog['image_mode'] = 1;
             $catlog['catalog_id'] = $products->id;
             if (Input::get("ImageId")) {
                 DB::table('catalog_images')->where("id", Input::get("ImageId"))->update($catlog);
             } else {
                 DB::table('catalog_images')->insert($catlog);
             }
         }
         if (empty($prodId)) {
             if ($products->prod_type != 3) {
               
             } else {
                 $attributeSet = DB::table('attribute_sets')->join('has_attributes', 'has_attributes.attr_set', '=', 'attribute_sets.id')->where( "attribute_sets.id", Input::get("attr_set"))->first();
                 $attributes = DB::table('attributes')->where('id', $attributeSet->attr_id)->where('is_filterable', "=", "1")->first();
                 if (!empty($attributes))
                     DB::table('has_options')->insert(["prod_id" => $products->id, 'attr_id' => $attributes->id]);
             }
         }
         //ADD CATEGORIES
         if (!empty(Input::get('category_id'))) {
             $selectdC = DB::table('has_categories')->where("prod_id", $products->id)->delete();
             $i = 0;
             //foreach (json_decode(Input::get('category_id')) as $cat) {
                 // $update[$i]["prod_id"] = $products->id;
                 // $update[$i]["cat_id"] = $cat->id;
                 // $i++;
                 $update["prod_id"] = $products->id;
                 $update["cat_id"] = Input::get('category_id');
             //}
             $selectdC = DB::table('has_categories')->insert($update);
         } else {
             $selectdC = DB::table('has_categories')->where("prod_id", $products->id)->delete();
         }
         $categoryA = DB::table('categories')->where("status", 1)->select('id', 'category')->get();
 
         $category = [];
         foreach ($categoryA as $val) {
             $category[$val->id] = $val->category;
         }
 
         $selectdCat = DB::table('has_categories')->where("prod_id", $products->id)->get();
         $products->categories = $selectdCat;
         if ($products->prod_type == 1) {
             $data = ["status" => 1, "msg" => "Product Added successfully.", 'data' => $products];
             //$url = "admin.apiprod.view";
         } else {
             $return_url = Input::get("return_url");
             if ($return_url == 1) {
                 $data = $this->configProdAttrs($products->id);
                 //$url = "admin.apiprod.view";
             } else {
                 $data = ["status" => 1, "msg" => "Product Updated successfully.", 'prod' => $products];
                 //$url = "admin.apiprod.view";
             }
         }
 
         return response()->json($data);
         // $viewname = Config('constants.adminApiProductView') . '.index';
         // return Helper::returnView($viewname, $data, $url);
     }
 
     public function configProdAttrs($prodId) {
         $prod = DB::table('products')->find($prodId);
         $attributeSet = DB::table('attribute_sets')->join('has_attributes', 'has_attributes.attr_set', '=', 'attribute_sets.id')->where("attribute_sets.id", $prod->attr_set)->pluck('attr_id');
         $attributes = DB::table('attributes')->whereIn("id", $attributeSet)->where("is_filterable", 1)->get();
         $attrs = [];
         foreach ($attributes as $attr) {
             $attrs[$attr->id]['name'] = $attr->attr;
             $attrValues = DB::table('attribute_values')->where("attr_id", $attr->id)->where('is_active', 1)->get(['id', 'option_name']);
 
             foreach ($attrValues as $val) {
                 $attrs[$attr->id]['options'][$val->id] = $val->option_name;
             }
         }
         return $data = ["prod" => $prod, 'attrs' => $attrs];
     }
 
     public function checkUrlKey($urk_key) {
         $sluG = strtolower(str_replace(" ", "-", $urk_key));
         $products = DB::table('products')->where('url_key', $sluG)->get();
 
         if (count($products) > 0) {
             return $sluG . mt_rand(1000, 9999);
         } else {
             return $sluG;
         }
     }

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