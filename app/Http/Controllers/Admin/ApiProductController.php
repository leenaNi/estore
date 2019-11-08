<?php

namespace App\Http\Controllers\Admin;

use Route;
use Input;
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
use App\Http\Controllers\Controller;
use DB;
use Request;
use Response;
use App\Models\User;
use Session;
use App\Library\Helper;
use App\Classes\UploadHandler;
use Vsmoraes\Pdf\Pdf;
use Config;

class ApiProductController extends Controller {

    public function index() {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;

        $varient = DB::table($prifix . '_general_setting')->where('url_key', 'products-with-variants')->first()->status;
        //$products= DB::table($merchant->prefix.'_products')->where('is_individual', '=', '1')->where('status', '=', '1')->get();
        //$storePath=base_path().'/'.$merchant->url_key;  
        $products = DB::table($prifix . '_products')->where('is_individual', '=', '1')->where($prifix . '_products.status', '=', '1')->select("*");
        if ($varient == 0) {
            $products = $products->where("prod_type", 1);
        }
        //            ->join($prifix.'_catalog_images',$prifix.'_products.id', '=', $prifix.'__catalog_images.catalog_id')
//                ->join($prifix.'_categories',$prifix.'_categories.id', '=', $prifix.'_has_categories.cat_id')
//                ->select($prifix.'_products.*',$prifix.'_categories.id as cat_id',$prifix.'_categories.category');
        $category = DB::table($merchant->prefix . '_categories')->where("status", 1)->get();

        foreach ($category as $val) {
            $val->catImage = "http://" . $merchant->url_key . '.' . $_SERVER['HTTP_HOST'] . '/uploads/catalog/category/' . @DB::table($merchant->prefix . '_catalog_images')->where("image_type", 2)->where('catalog_id', $val->id)->latest()->first()->filename;
            $val->productCout = DB::table($merchant->prefix . '_has_categories')->where("cat_id", $val->id)->count();
        }

        $userA = DB::table('users')->select('id', 'firstname', 'lastname')->get();
        $user = [];
        foreach ($userA as $val) {
            $user[$val->id] = $val->firstname . ' ' . $val->lastname;
        }
        if (!empty(Input::get('product_name'))) {
            $products = $products->where('product', 'like', "%" . Input::get('product_name') . "%");
        }
        if (!empty(Input::get('pricemin'))) {
            $products = $products->where('price', '>=', Input::get('pricemin'));
        }
        if (!empty(Input::get('pricemax'))) {
            $products = $products->where('price', '<=', Input::get('pricemax'));
        }
//        if (!empty(Input::get('category'))) {
//            $products = $products->whereHas('categories', function($q) {
//                $q->where('categories.id', Input::get('category'));
//            });
//        }
        if (Input::get('status') == '0' || Input::get('status') == '1') {
            $products = $products->where('status', Input::get('status'));
        }
        if (Input::get('availability') == '0' || Input::get('availability') == '1') {
            $products = $products->where('is_avail', Input::get('availability'));
        }
        if (!empty(Input::get('updated_by'))) {
            $products = $products->where('updated_by', Input::get('updated_by'));
        }
        if (!empty(Input::get('datefrom'))) {
            $date = date("Y-m-d", strtotime(Input::get('datefrom')));
            $products = $products->where('created_at', '>=', $date);
        }
        if (!empty(Input::get('dateto'))) {
            $date = date("Y-m-d", strtotime(Input::get('dateto')));
            $products = $products->where('created_at', '<=', $date);
        }
        $products = $products->paginate(10);
        $productscount = $products->total();
        // dd($products);
        // $products = $products->paginate(Config('constants.paginateNo'));
        $tax = DB::table($prifix . '_tax')->where('status', '=', '1')->get();
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
            $prd->categories = DB::table($merchant->prefix . '_has_categories')->where("prod_id", $prd->id)->select("cat_id")->get()->toArray();
            $prd->prodImage = "http://" . $merchant->url_key . '.' . $_SERVER['HTTP_HOST'] . '/uploads/catalog/products/' . @DB::table($merchant->prefix . '_catalog_images')->where("image_mode", 1)->where('catalog_id', $prd->id)->first()->filename;
        }
//      
//dd($products);
        return Helper::returnView(Config('constants.adminApiProductView') . '.index', compact('products', 'category', 'user', 'barcode', 'productscount', 'tax'));
    }

    public function calTax($product, $prifix) {
        $type = $product->is_tax;
        if ($type != 0) {
            $sum = 0;
            $taxeId = DB::table($prifix . '_product_has_taxes')->where('product_id', $product->id)->pluck("tax_id");
            $taxes = DB::table($prifix . '_tax')->where('status', '=', '1')->whereIn("id", $taxeId)->get();

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

    public function calculateTaxWithDis() {

        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $taxStatus = DB::table($merchant->prefix . '_general_setting')->where("url_key", 'tax')->first()->status;
        $cartContent = json_decode(Input::get('cart_content'));

        $cart = Helper::calAmtWithTax($cartContent, $taxStatus);
        return $cart;
    }

    public function add() {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();

        $categories = DB::table($merchant->prefix . '_categories')->where("status", '1')->orderBy("id", "asc")->get();

//        $categories = Category::where("status", '1')->where('id', 1)->with('children')->orderBy("id", "asc")->get();
        $action = route("admin.apiprod.save");
        // return view(Config('constants.adminApiProductView') . '.add', compact('prod', '+prod_types', 'attr_sets', 'categories', 'action'));
        $data = ["action" => $action, 'categories' => $categories];
        $viewname = Config('constants.adminApiProductView') . '.add';
        return Helper::returnView($viewname, $data);
    }

    public function save() {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $attibuteSet = DB::table($prifix . '_attribute_sets')->get();
        $prodId = Input::get('id');
        $prod = [];
        $prod['is_individual'] = 1;
        $prod['is_avail'] = 1;
        $prod['product'] = Input::get('product');
        //$prod['purchase_price'] = Input::get('purchase_price');
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
        // $prod->updated_by = Input::get('added_by'); //Session::get('loggedinAdminId');
        if ($prodId) {
            DB::table($prifix . '_products')->where("id", $prodId)->update($prod);
            $products = DB::table($prifix . '_products')->where("id", $prodId)->first();
        } else {
            $url_key = strtolower(str_replace(" ", "-", Input::get("product")));
            $url_key = $this->checkUrlKey($url_key, $merchant->prefix);

            $prod['url_key'] = $url_key;
            DB::table($prifix . '_products')->insert($prod);
            $products = DB::table($prifix . '_products')->orderBy("id", "DESC")->first();
        }

        $applicable_taxes = json_decode(Input::get('applicable_tax'));

        $i = 0;
        if (($applicable_taxes)) {
            DB::table($prifix . '_product_has_taxes')->where("product_id", $prodId)->delete();
            foreach ($applicable_taxes as $key => $taxs) {
                //  print_r($taxs);
                $taxes[$i]["product_id"] = $products->id;
                $taxes[$i]["tax_id"] = $taxs;
                $i++;
            }

            DB::table($prifix . '_product_has_taxes')->insert($taxes);
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
                DB::table($merchant->prefix . '_catalog_images')->where("id", Input::get("ImageId"))->update($catlog);
            } else {
                DB::table($merchant->prefix . '_catalog_images')->insert($catlog);
            }
        }
        if (empty($prodId)) {
            if ($products->prod_type != 3) {
                //  $attributeSet=DB::table($prifix.'_attribute_sets')->where($prifix."_attribute_sets.id",Input::get("attr_set"))->first();            
                //  $attributes = DB::table($prifix.'_attributes')->where('id',$attributeSet->attr_id)->where('is_filterable', "=", "1")->first();
//            if (!empty($attributeSet))
//                   DB::table($prifix.'_has_options')->insert(["prod_id"=>$products->id,'attr_id'=>$attributes->id]);
////                $prod->attributes()->sync($attributes);
//            else
//                  DB::table($prifix.'_has_options')->where(["prod_id"=>$products->id,'attr_id'=>$attributes->id])->delete();
            } else {
                $attributeSet = DB::table($prifix . '_attribute_sets')->join($prifix . '_has_attributes', $prifix . '_has_attributes.attr_set', '=', $prifix . '_attribute_sets.id')->where($prifix . "_attribute_sets.id", Input::get("attr_set"))->first();


                $attributes = DB::table($prifix . '_attributes')->where('id', $attributeSet->attr_id)->where('is_filterable', "=", "1")->first();
                // dd($attributes);
                //$attributes =DB::table($prifix.'_has_options')->where("prod_id",$products->id)->where('attr_id',$attribute->id)->get(["id", "attr_val", "attr_type_id"]);
                // $attributes = AttributeSet::find($prod->attributeset['id'])->attributes()->where('is_filterable', "=", "1")->get();
                if (!empty($attributes))
                    DB::table($prifix . '_has_options')->insert(["prod_id" => $products->id, 'attr_id' => $attributes->id]);
                //  $prod->attributes()->sync($attributes);
            }
        }
        //ADD CATEGORIES
        if (!empty(Input::get('category_id'))) {
            $selectdC = DB::table($merchant->prefix . '_has_categories')->where("prod_id", $products->id)->delete();
            $i = 0;
            foreach (json_decode(Input::get('category_id')) as $cat) {
                $update[$i]["prod_id"] = $products->id;
                $update[$i]["cat_id"] = $cat->id;
                $i++;
            }
            $selectdC = DB::table($merchant->prefix . '_has_categories')->insert($update);
        } else {
            $selectdC = DB::table($merchant->prefix . '_has_categories')->where("prod_id", $products->id)->delete();
        }// $product = DB::table($merchant->prefix.'_products')->where('id', $prod->id)->first();
        $categoryA = DB::table($merchant->prefix . '_categories')->where("status", 1)->select('id', 'category')->get();

        $category = [];
        foreach ($categoryA as $val) {
            $category[$val->id] = $val->category;
        }

        $selectdCat = DB::table($merchant->prefix . '_has_categories')->where("prod_id", $products->id)->get();
        $products->categories = $selectdCat;
        if ($products->prod_type == 1) {
            $data = ["status" => 1, "msg" => "Product Added successfully.", 'prod' => $products];
            $url = "admin.apiprod.view";
        } else {
            $return_url = Input::get("return_url");
            if ($return_url == 1) {
                $data = $this->configProdAttrs($products->id, $prifix);
                $url = "admin.apiprod.view";
            } else {
                $data = ["status" => 1, "msg" => "Product Updated successfully.", 'prod' => $products];
                $url = "admin.apiprod.view";
            }
        }

        //return redirect()->route('admin.products.general.info', ['id' => $prod->id]);
        $viewname = Config('constants.adminApiProductView') . '.index';
        return Helper::returnView($viewname, $data, $url);
    }

    public function configProdAttrs($prodId, $prifix) {
        //$barcode = DB::table($prifix.'_general_setting')->where('url_key', 'barcode')->get()->toArray()[0]['status'];
        $prod = DB::table($prifix . '_products')->find($prodId);
        $attributeSet = DB::table($prifix . '_attribute_sets')->join($prifix . '_has_attributes', $prifix . '_has_attributes.attr_set', '=', $prifix . '_attribute_sets.id')->where($prifix . "_attribute_sets.id", $prod->attr_set)->pluck('attr_id');
        $attributes = DB::table($prifix . '_attributes')->whereIn("id", $attributeSet)->where("is_filterable", 1)->get();
        $attrs = [];
        foreach ($attributes as $attr) {
            $attrs[$attr->id]['name'] = $attr->attr;
            $attrValues = DB::table($prifix . '_attribute_values')->where("attr_id", $attr->id)->where('is_active', 1)->get(['id', 'option_name']);

            foreach ($attrValues as $val) {
                $attrs[$attr->id]['options'][$val->id] = $val->option_name;
            }
        }
        return $data = ["prod" => $prod, 'attrs' => $attrs];
    }

    public function saveConfigProd() {
        //dd(Input::all());
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $prod = DB::table($prifix . '_products')->find(Input::get("prod_id"));
        $attributeSet = DB::table($prifix . '_attribute_sets')->join($prifix . '_has_attributes', $prifix . '_has_attributes.attr_set', '=', $prifix . '_attribute_sets.id')->where($prifix . "_attribute_sets.id", $prod->attr_set)->pluck('attr_id');
        $attributes = DB::table($prifix . '_attributes')->whereIn("id", $attributeSet)->where("is_filterable", 1)->get()->toArray();
        // $attributes = AttributeSet::find($prod->attributeset['id'])->attributes()->where("is_filterable", "=", "1")->get()->toArray();

        $attrval = [];
        $prods = [];
        $prodsAttr = [];
        foreach ($attributes as $value) {
            $attrval = json_decode(Input::get($value->id), true);

            foreach ($attrval as $key => $val) {
                // dd($val);
                !isset($prods[$key]) ? $prods[$key] = [] : '';
                $prods[$key]["options"][$value->id] = $val;
                array_push($prodsAttr, $val);
            }
        }


        $prdAttrCnt = count($prodsAttr);
        $subProds = DB::table($prifix . '_products')->join($prifix . '_has_options', $prifix . '_has_options.prod_id', '=', $prifix . '_products.id')->where('parent_prod_id', Input::get('prod_id'))->whereIn($prifix . '_has_options.attr_val', $prodsAttr)->get();


        $isExists = 0;
        foreach ($subProds as $sprod) {
            $prodAttr = DB::table($prifix . '_has_options')->where("prod_id", $sprod->id)->get();
            if (count($prodAttr) == $prdAttrCnt) {
                $isExists = 1;
            }
        }
        //Check if same varient already exists
        if ($isExists) {
            return redirect()->back()->with('msg', "Product variant already exists.");
        } else {
            // $prod->updated_by = Input::get('updated_by');
            DB::table($prifix . '_products')->where("id", Input::get("prod_id"))->update(["updated_by" => Input::get('updated_by')]);
            // $prod->update();
            $price = json_decode(Input::get("price"), true);
            if (!empty($price)):
                foreach ($price as $key => $val) {
                    !isset($prods[$key]) ? $prods[$key] = [] : '';
                    $prods[$key]["price"] = $val;
                }
            endif;
            $ConfStock = json_decode(Input::get("stock"), true);
            if (!empty($ConfStock)):
                foreach (@$ConfStock as $key => $val) {
                    !isset($prods[$key]) ? $prods[$key] = [] : '';
                    $prods[$key]['stock'] = $val;
                }
            endif;
            $is_alive = json_decode(Input::get("is_avail"), true);
            if (!empty($is_alive)):
                foreach (@$is_alive as $key => $val) {
                    !isset($prods[$key]) ? $prods[$key] = [] : '';
                    $prods[$key]['is_avail'] = $val;
                }
            endif;

            foreach ($prods as $key => $prd) {
                //print_r($prd["options"]);
                $configProd = ['product' => $prod->product . ' - Variant - ' . ($key + 1), 'is_avail' => 1, 'is_stock' => $prod->is_stock, 'parent_prod_id' => $prod->id, 'is_individual' => 0, 'prod_type' => 1, 'attr_set' => $prod->attr_set, 'price' => $prods[$key]['price'], 'stock' => $prods[$key]['stock'], 'is_avail' => $prods[$key]['is_avail']];
                $newConfigProductId = DB::table($prifix . '_products')->insertGetId($configProd);

                $attributeSet = DB::table($prifix . '_attribute_sets')->join($prifix . '_has_attributes', $prifix . '_has_attributes.attr_set', '=', $prifix . '_attribute_sets.id')->where($prifix . "_attribute_sets.id", $prod->attr_set)->first();
                $attributes = DB::table($prifix . '_attributes')->where('id', $attributeSet->attr_id)->first();

//                $prod->attributes()->sync($attributes);
                //  $attributes = AttributeSet::find($newConfigProduct->attributeset['id'])->attributes;
                //  $newConfigProduct->attributes()->sync($attributes);
                //
                $name = $prod->product . ' - Variant (';
                foreach ($prd["options"] as $op => $opt) {
                    // echo $op;
                    if (!empty($attributes))
                        DB::table($prifix . '_has_options')->insert(["prod_id" => $newConfigProductId, 'attr_id' => $op]);
                    $opt = trim($opt);
                    $optionName = DB::table($prifix . '_attribute_values')->find($opt)->option_name;
                    $name .= "$optionName, ";
                    $valuetoUpdate['attr_val'] = $opt;
                    $wherec['prod_id'] = $newConfigProductId;
                    $wherec['attr_id'] = $op;
                    DB::table($prifix . '_has_options')->where($wherec)->update(['attr_val' => $opt]);
//                    DB::update(DB::raw("update " . $prifix . "_has_options set attr_val = '$opt' where attr_id = $op and prod_id = " . $newConfigProduct->id));
                }
                $name = rtrim($name, ", ");
                $name .= ")";
                //$newConfigProduct->product = $name;
                DB::table($prifix . '_products')->where("id", $newConfigProductId)->update(["product" => $name]);
                $newConfigProduct = DB::table($prifix . '_products')->find($newConfigProductId);
            }
//dd($newConfigProduct);
        }
        return $data = ["prod" => $newConfigProduct];
//        $view = !empty(Input::get('return_url')) ? redirect()->to(Input::get('return_url')) : redirect()->route("admin.product.vendors", ['id' => $prod->id]);
//        Session::flash("msg", "Product updated succesfully.");
//        return $view;
    }

    public function editProduct() {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $prod = DB::table($prifix . '_products')->find(Input::get("prodId"));
        $selectedTax = DB::table($prifix . '_product_has_taxes')->where("product_id", Input::get("prodId"))->pluck("tax_id");
        $selectedCat = DB::table($prifix . '_has_categories')->where("prod_id", Input::get("prodId"))->pluck("cat_id");
        if ($prod->prod_type == 3) {
            $subproducts = DB::table($prifix . '_products')->where("parent_prod_id", $prod->id)->get(["id", "product", "is_avail", "price", "stock", "status"]);
            foreach ($subproducts as $subproduct) {
                $subproduct->attr = DB::table($prifix . '_has_options')->where("prod_id", $subproduct->id)->join($prifix . '_attribute_values', $prifix . '_attribute_values.id', '=', $prifix . '_has_options.attr_val')
                                ->join($prifix . '_attributes', $prifix . '_attributes.id', '=', $prifix . '_has_options.attr_id')->get([$prifix . '_attributes.attr', $prifix . '_attribute_values.id', $prifix . '_attribute_values.option_name']);
            }
            $prod->subproduct = $subproducts;
        }
        $catlog = DB::table($merchant->prefix . '_catalog_images')->where("image_mode", 1)->where('catalog_id', $prod->id)->first();
        $prod->prodImage = "http://" . $merchant->url_key . '.' . $_SERVER['HTTP_HOST'] . '/uploads/catalog/products/' . @$catlog->filename;
        $prod->ImageId = @$catlog->id;
        $prod->selectedTax = $selectedTax;
        $prod->selectedCat = $selectedCat;
        $tax = DB::table($prifix . '_tax')->where('status', '=', '1')->get();
        //   $categories = DB::table($prifix . '_categories')->where("status", '1')->orderBy("id", "asc")->get(["id","category","url_key"]);
//        foreach ($has_attr as $ah) {
//            $attr_has[] = $ah->attr_set;
//        }
//
//        $attr_sets = [];
//        $attrS = AttributeSet::get(['id', 'attr_set'])->toArray();
//        // dd($attrS);
//        foreach ($attrS as $attr) {
//            if (in_array($attr['id'], $attr_has)) {
//                $attr_sets[$attr['id']] = $attr['attr_set'];
//            }
//        }
//        $categories = Category::where("status", '1')->where('id', 1)->with('children')->orderBy("id", "asc")->get();
//        $prod = Product::find(Input::get('id'));
//        $prod->category = Product::find(Input::get('id'))->categories()->get();
//
//        $action = route("admin.apiprod.save");
        $data = ['prod' => $prod, 'tax' => $tax];
        //  return view(Config('constants.adminApiProductView') . '.add', compact('prod', 'prod_types', 'attr_sets', 'categories', 'action'));
        $viewname = Config('constants.adminApiProductView') . '.add';
        return Helper::returnView($viewname, $data);
    }

    public function saveEditVariant() {
        $marchantId = Input::get("merchantId");
        $marchantId = Input::get("prodId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();

        $update["price"] = Input::get("price");
        if (Input::get("stock")) {
            $update["stock"] = Input::get("stock");
        }
        if (Input::get("is_avail")) {
            $update["is_avail"] = Input::get("is_avail");
        }
        $update["status"] = Input::get("status");
        DB::table($merchant->prefix . '_products')->where("id", Input::get('prodId'))->update($update);
        $product = DB::table($merchant->prefix . '_products')->find(Input::get('prodId'));
        $data = ["status" => 1, "msg" => "Variant ppdated successfully!.", 'prod' => $product];
        return $data;
    }

    public function deleteVariant() {
        $marchantId = Input::get("merchantId");
        $marchantId = Input::get("prodId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $count = DB::table('has_products')->where("sub_prod_id", Input::get('prodId'))->where("store_id", $merchant->id)->count();
        if ($count <= 0) {
            $hasOpt = DB::table($merchant->prefix . '_has_options')->where("prod_id", Input::get('prodId'))->get();
            if (count($hasOpt) > 0) {
                DB::table($merchant->prefix . '_has_options')->where("prod_id", Input::get('prodId'))->delete();
            }
            DB::table($merchant->prefix . '_products')->where("id", Input::get('prodId'))->delete();
            return $data = ['status' => 1, 'msg' => 'Product variant deleted successfully.'];
        } else {
            return $data = ['status' => 0, 'msg' => 'Sorry, this product variant is part of  orders. Delete the order first.'];
        }
    }

    public function delete() {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $productCount = DB::table('has_products')->where("prod_id", Input::get('id'))->where("store_id", $merchant->id)->count();
        //  $count = HasProducts::where("prod_id", Input::get('id'))->count();
        if ($productCount <= 0) {
            $prod = DB::table($merchant->prefix . '_products')->find(Input::get('id'));
            $hasCat = DB::table($merchant->prefix . '_has_categories')->where("prod_id", Input::get('id'))->count();

            if (count($hasCat) >= 1) {
                DB::table($merchant->prefix . '_has_categories')->where("prod_id", Input::get('id'))->delete();
            }
//            if ($prod->attributes()->count() >= 1) {
//                @$prod->attributes()->detach();
//            }
//            if ($prod->relatedproducts()->count() >= 1) {
//                @$prod->relatedproducts()->detach();
//            }
//            if ($prod->upsellproducts()->count() >= 1) {
//                @$prod->upsellproducts()->detach();
//            }
//            if ($prod->comboproducts()->count() >= 1) {
//                @$prod->comboproducts()->detach();
//            }
//            if ($prod->catalogimgs()->count() >= 2) {
//                $prod->catalogimgs()->delete();
//            }
//            if ($prod->savedlist()->count() >= 1) {
//                @$prod->savedlist()->detach();
//            }
            DB::table($merchant->prefix . '_products')->where("id", Input::get('id'))->delete();
            $data = ["status" => 1, 'message' => 'Product deleted successfully.'];
        } else {
            $data = ["status" => 0, 'message' => 'Sorry, This Product is Part of a Project. Delete the Project First.'];
        }
        Session::flash('message', $data['message']);
        $url = "admin.apiprod.view";
        //return redirect()->route('admin.products.general.info', ['id' => $prod->id]);
        $viewname = Config('constants.adminApiProductView') . '.index';
        return Helper::returnView($viewname, $data, $url);
    }

    public function changeStatus() {
        $prod = Product::find(Input::get('id'));
        if ($prod->status == 1) {
            $prodStatus = 0;
            $msg = "Product disabled successfully.";
        } else if ($prod->status == 0) {
            $prodStatus = 1;
            $msg = "Product enabled successfully.";
        }
        $prod->status = $prodStatus;
        $prod->update();
        Session::flash('message', $msg);
        $data = ['status' => 1, 'message' => $msg];
        $url = "admin.apiprod.view";
        $viewname = Config('constants.adminApiProductView') . '.index';
        return Helper::returnView($viewname, $data, $url);
    }

    public function checkUrlKey($urk_key, $prifix) {
        $sluG = strtolower(str_replace(" ", "-", $urk_key));
        $products = DB::table($prifix . '_products')->where('url_key', $sluG)->get();

        if (count($products) > 0) {
            return $sluG . mt_rand(1000, 9999);
        } else {
            return $sluG;
        }
    }

    public function categoryListing() {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $categories = DB::table($merchant->prefix . '_categories')->where("status", '1')->orderBy("id", "asc")->paginate(10);
        $prod_type = DB::table($merchant->prefix . '_product_types')->where("status", '1')->orderBy("id", "asc")->get(["id", "type"]);
        $attrS = DB::table($merchant->prefix . '_attribute_sets')->where('id', '!=', 1)->where('status', 1)->get(['id', 'attr_set']);
        $stockStatus = DB::table($merchant->prefix . '_general_setting')->where("url_key", 'stock')->first()->status;
        foreach ($categories as $category) {
            $category->catImage = "http://" . $merchant->url_key . '.' . $_SERVER['HTTP_HOST'] . '/uploads/catalog/category/' . @DB::table($merchant->prefix . '_catalog_images')->where("image_type", 2)->where('catalog_id', $category->id)->latest()->first()->filename;
        }
        $data = ['categories' => $categories, 'prod_type' => $prod_type, 'stockStatus' => $stockStatus, 'attribute' => $attrS];
        $viewname = "";
        return Helper::returnView($viewname, $data);
    }

    public function getAllOrder() {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $orders = DB::table('orders')->where("order_status", "!=", 0)->where('store_id', $merchant->id)->orderBy("id", "asc")->get();
    }

    public function getConfigProduct() {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $prodid = Input::get("prodId");
        $product = DB::table($prifix . '_products')->find($prodid);


        $producctAttrSetId = $product->attr_set;
        $selAttrs = [];
        $subprods = DB::table($prifix . '_products')->where("parent_prod_id", $prodid)->get();
        // $product->subproducts()->get();
        foreach ($subprods as $subP) {
            // $hasOpt = $subP->attributes()->withPivot('attr_id', 'prod_id', 'attr_val')->orderBy("att_sort_order", "asc")->get();
            $hasOpt = DB::table($prifix . '_has_options')->where("prod_id", $subP->id)->get();

            foreach ($hasOpt as $prdOpt) {
                $selAttrs[$prdOpt->attr_id]['placeholder'] = DB::table($prifix . '_attributes')->find($prdOpt->attr_id)->placeholder;
                $selAttrs[$prdOpt->attr_id][DB::table($prifix . '_attributes')->find($prdOpt->attr_id)->slug] = DB::table($prifix . '_attributes')->find($prdOpt->attr_id)->attr;
                $selAttrs[$prdOpt->attr_id]['options'][DB::table($prifix . '_attribute_values')->find($prdOpt->attr_val)->id] = DB::table($prifix . '_attribute_values')->find($prdOpt->attr_val)->option_name;
                $selAttrs[$prdOpt->attr_id]['attrs'][DB::table($prifix . '_attribute_values')->find($prdOpt->attr_val)->id]['prods'][] = $prdOpt->prod_id;
            }
        }

        $data['selAttrs'] = $selAttrs;
        $data['product'] = $product;
        $data['subprods'] = $subprods;
        $viewname = "";
        return Helper::returnView($viewname, $data);
    }

    public function prodSeo(){
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $prodid = Input::get("prodId");
        $product = DB::table($prifix . '_products')->find($prodid);

        $data['seoProdList']['meta_title'] = $product->meta_title;
        $data['seoProdList']['meta_keys'] = $product->meta_keys;
        $data['seoProdList']['meta_desc'] = $product->meta_desc;
        $data['seoProdList']['meta_robot'] = $product->meta_robot;
        $data['seoProdList']['canonical'] = $product->canonical;
        $data['seoProdList']['social_shared_title'] = $product->og_title;
        $data['seoProdList']['social_shared_desc'] = $product->og_desc;
        $data['seoProdList']['social_shared_image'] = $product->og_image;
        $data['seoProdList']['social_shared_url'] = $product->og_url;
        $data['seoProdList']['google_analytics'] = $product->other_meta;
        
        $viewname = "";
        return Helper::returnView($viewname, $data);
    }

    public function prodSaveSeo(){

        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $prodid = Input::get("prodId");

        $update["meta_title"] = Input::get("meta_title");
        $update["meta_keys"] = Input::get("meta_keys");
        $update["meta_desc"] = Input::get("meta_desc");
        $update["meta_robot"] = Input::get("meta_robot");
        $update["canonical"] = Input::get("canonical");
        $update["og_title"] = Input::get("og_title");
        $update["og_desc"] = Input::get("og_desc");
        $update["og_image"] = Input::get("og_image");
        $update["og_url"] = Input::get("og_url");
        $update["twitter_url"] = Input::get("twitter_url");
        $update["twitter_title"] = Input::get("twitter_title");
        $update["twitter_desc"] = Input::get("twitter_desc");
        $update["twitter_image"] = Input::get("twitter_image");
        $update["other_meta"] = Input::get("other_meta");
        
        DB::table($merchant->prefix . '_products')->where("id", Input::get('prodId'))->update($update);

        $product = DB::table($merchant->prefix . '_products')->find(Input::get('prodId'));

        $data = ["status" => 'Success', "msg" => "Products Seo updated Successfully!.", 'prod' => $product];

        return $data;
    }

    public function catSeo(){
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $catid = Input::get("catId");
        $categories = DB::table($merchant->prefix . '_categories')->find($catid);
        
        $data['seoCatList']['meta_title'] = $categories->meta_title;
        $data['seoCatList']['meta_keys'] = $categories->meta_keys;
        $data['seoCatList']['meta_desc'] = $categories->meta_desc;
        $data['seoCatList']['meta_robot'] = $categories->meta_robot;
        $data['seoCatList']['canonical'] = $categories->canonical;
        $data['seoCatList']['social_shared_title'] = $categories->title;
        $data['seoCatList']['social_shared_desc'] = $categories->desc;
        $data['seoCatList']['social_shared_image'] = $categories->image;
        $data['seoCatList']['social_shared_url'] = $categories->url;
        $data['seoCatList']['google_analytics'] = $categories->other_meta;

        $viewname = "";
        return Helper::returnView($viewname, $data);
    }

    public function catSeoSave(){

        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $catid = Input::get("catId");
        $categories = DB::table($prifix . '_categories')->find($catid);

        $update["meta_title"] = Input::get("meta_title");
        $update["meta_keys"] = Input::get("meta_keys");
        $update["meta_desc"] = Input::get("meta_desc");
        $update["meta_robot"] = Input::get("meta_robot");
        $update["canonical"] = Input::get("canonical");
        $update["title"] = Input::get("title");
        $update["desc"] = Input::get("desc");
        $update["image"] = Input::get("image");
        $update["url"] = Input::get("url");
        $update["other_meta"] = Input::get("other_meta");
        
        DB::table($merchant->prefix . '_categories')->where("id", Input::get('catId'))->update($update);

        $categories = DB::table($merchant->prefix . '_categories')->find(Input::get('catId'));

        $data = ["status" => 'Success', "msg" => "Categories Seo updated Successfully!.", 'cat' => $categories];

        return $data;

    }

}

?>