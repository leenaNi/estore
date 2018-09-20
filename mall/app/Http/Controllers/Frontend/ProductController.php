<?php

namespace App\Http\Controllers\frontend;

use Route;
use Input;
use App\Models\User;
use App\Models\MallProdCategory as Category;
use App\Models\MallProducts as Product;
use App\Models\AttributeValue;
use App\Models\AttributeSet;
use App\Models\Attribute;
use App\Models\Stocknotify;
use App\Models\GeneralSetting;
use Auth;
use App\Http\Controllers\Controller;
use Session;
use App\Library\Helper;
use DB;
use Cart;

class ProductController extends Controller {

    public function index($prefix, $slug) {
        $setting = GeneralSetting::where('url_key', 'debug-option')->first();
        $prod = Product::where('url_key', $slug)->where('prefix', $prefix)->first();

        if ($setting->status == 0 && count($prod) == 0) {
            abort(404);
        }
//         dd($prod);
        if ($prod->prod_type == 1 || $prod->prod_type == 5) {
            $view = $this->simpleProduct($prod->id);
        } else if ($prod->prod_type == 2) {
            $view = $this->comboProduct($prod->id);
        } else if ($prod->prod_type == 3 || $prod->type == 4) {
            $view = $this->configProduct($prod->id);
        }
        return $view;
    }

    public function getSubProd() {
        $prodids = Product::find(Input::get('parentPRod'))->subproducts()->get(['id'])->toArray();
        $attrid = [];
        $attrvalue = [];
        foreach (Input::get('attrval') as $attrs) {
            $attrs = explode("-", $attrs);
            array_push($attrid, @$attrs[0]);
            array_push($attrvalue, @$attrs[1]);
        }
        $getprods = DB::table('has_options')
                ->whereIn('prod_id', $prodids)
                ->whereIn('attr_id', $attrid)
                ->whereIn('attr_val', $attrvalue)
                ->select('id', DB::raw('group_concat(has_options.attr_id  order by has_options.attr_id asc) As attIds'), DB::raw('group_concat(has_options.attr_val  order by has_options.attr_val asc) AS attrVals'), DB::raw('group_concat(has_options.prod_id) As prodIds'))
                ->groupBy('prod_id');
        asort($attrid);
        $attridNew = implode(",", $attrid);
        asort($attrvalue);
        $attrvalueNew = implode(",", $attrvalue);
        $subprod = [];
        // if($getprods->attr_id)
        foreach ($getprods->get() as $gprod) {
            if ($gprod->attIds == $attridNew && $gprod->attrVals == $attrvalueNew) {
                array_push($subprod, $gprod->prodIds);
            };
        }
        $subprod = array_unique($subprod);
        if (!empty($subprod[0])) {
            $uniqueDep = implode(',', array_unique(explode(',', $subprod[0])));

            $getSubProdDetails = Product::where("id", $uniqueDep)->first()->toArray();

            return $getSubProdDetails;
        } else {
            return "invalid";
        }
    }

    public function simpleProduct($pId) {
        $is_desc = GeneralSetting::where('url_key', 'des')->first();
        $product = Product::find($pId);
        if (User::find(Session::get('loggedin_user_id')) && User::find(Session::get('loggedin_user_id'))->wishlist->contains($product->id)) {
            $product->wishlist = 1;
        } else {
            $product->wishlist = 0;
        }
        $product->images = DB::table($product->prefix . "_catalog_images")->where("catalog_id", $product->store_prod_id)->where("image_mode", 1)->orderBy('sort_order')->get(); // $product->catalogimgs()->get();
        foreach ($product->images as $prdimgs) {
            $prdimgs->img = $prdimgs->image_path . '/' . $prdimgs->filename;
        }
        $prodCats = $product->categories()->get(['has_categories.cat_id'])->toArray();
        $prodsByCategories = Product::where('is_individual', 1)->where('status', 1)->where('is_avail', '=', 1)->where('store_id', $product->store_id)->where('id', '!=', $pId)->with(['categories' => function($q)use($prodCats) {
                        $q->whereIn('has_categories.cat_id', $prodCats);
                    }])->get();
//        dd($prodsByCategories);
        $product->prodImage = $product->images[0]->image_path . '/' . $product->images[0]->filename;
        $nattrs = []; //AttributeSet::find($product->attr_set)->attributes()->where("is_filterable", "=", 0)->get();
        $product->store_name = DB::table('stores')->where('id', $product->store_id)->first()->store_name;
        $product->related = $prodsByCategories; //$product->relatedproducts()->where("status", 1)->get();
        $product->upsellproduct = []; //$product->upsellproducts()->where("status", 1)->get();
        $product->metaTitle = @$product->meta_title == "" ? @$product->product . " | Cartini " : @$product->meta_title;
        $product->metaDesc = @$product->meta_desc == "" ? @$product->product : @$product->meta_desc;
        $product->metaKeys = @$product->meta_keys == "" ? @$product->product : @$product->meta_keys;
        $currencySetting = new \App\Http\Controllers\Frontend\HomeController();
        $data['curData'] = $currencySetting->setCurrency();
        $data = ['product' => $product, 'nattrs' => $nattrs, 'is_desc' => $is_desc];
        $viewname = Config('constants.frontendCatlogProducts') . '.simpleProduct';
        return Helper::returnView($viewname, $data, null, 1);
    }

    public function configProduct($prodid) {
        $is_desc = GeneralSetting::where('url_key', 'des')->first();
        $product = Product::find($prodid);
        $product->metaTitle = @$product->meta_title == "" ? @$product->product . " | VeestoresMall " : @$product->meta_title;
        $product->metaDesc = @$product->meta_desc == "" ? @$product->product : @$product->meta_desc;
        $product->metaKeys = @$product->meta_keys == "" ? @$product->product : @$product->meta_keys;
        $product->images = DB::table($product->prefix . "_catalog_images")->where("catalog_id", $product->store_prod_id)->where("image_mode", 1)->orderBy('sort_order')->get();
        $product->prodImage = $product->images[0]->image_path . '/' . $product->images[0]->filename;
        $product->store_name = DB::table('stores')->where('id', $product->store_id)->first()->store_name;
        if (User::find(Session::get('loggedin_user_id')) && User::find(Session::get('loggedin_user_id'))->wishlist->contains($product->id)) {
            $product->wishlist = 1;
        } else {
            $product->wishlist = 0;
        }
//        $nattrs = AttributeSet::find($product->attr_set)->attributes()->where("is_filterable", "=", 1)->get()->toArray();
        $nattrs = DB::select(DB::raw("SELECT attrs.* FROM `" . $product->prefix . "_attribute_sets` as attrs JOIN " . $product->prefix . "_has_attributes ha ON attrs.id = ha.attr_set JOIN " . $product->prefix . "_attributes attr ON ha.attr_id = attr.id WHERE attrs.id=" . $product->attr_set . " AND attr.is_filterable = 1 "));
        $data = ['nattrs' => $nattrs, 'is_desc' => $is_desc];

        $selAttrs = [];
        $subprods = DB::table('mall_products')->where('parent_prod_id', $product->store_prod_id)->where('status', 1)->get(); //$product->subproducts()->get();
        foreach ($subprods as $subP) {
//            $hasOpt = $subP->attributes()->withPivot('attr_id', 'prod_id', 'attr_val')->orderBy("att_sort_order", "asc")->get();
//            $hasOpt = DB::select(DB::raw("SELECT ha.attr_id, ha.prod_id, ha.attr_val, attr.placeholder, attr.attr, attr.slug, attrval.option_name, attrval.option_value FROM ".$product->prefix."_has_options ha JOIN ".$product->prefix."_attributes attr ON ha.attr_id = attr.id JOIN ".$product->prefix."_attribute_values attrval ON ha.attr_val = attrval.id WHERE ha.prod_id = $subP->id AND attr.status = 1 ORDER BY attr.att_sort_order asc"));
            $hasOpt = DB::table($product->prefix . '_has_options')->where("prod_id", $subP->id)->get();
            foreach ($hasOpt as $prdOpt) {
                $selAttrs[$prdOpt->attr_id]['placeholder'] = DB::table($product->prefix . '_attributes')->find($prdOpt->attr_id)->placeholder;
                $selAttrs[$prdOpt->attr_id][DB::table($product->prefix . '_attributes')->find($prdOpt->attr_id)->slug] = DB::table($product->prefix . '_attributes')->find($prdOpt->attr_id)->attr;
                $selAttrs[$prdOpt->attr_id]['options'][DB::table($product->prefix . '_attribute_values')->find($prdOpt->attr_val)->id] = DB::table($product->prefix . '_attribute_values')->find($prdOpt->attr_val)->option_name;
                $selAttrs[$prdOpt->attr_id]['attrs'][DB::table($product->prefix . '_attribute_values')->find($prdOpt->attr_val)->id]['prods'][] = $prdOpt->prod_id;
            }
        }
        $prodCats = $product->categories()->get(['has_categories.cat_id'])->toArray();
        $prodsByCategories = Product::where('is_individual', 1)->where('status', 1)->where('is_avail', '=', 1)->where('store_id', $product->store_id)->where('id', '!=', $prodid)->with(['categories' => function($q)use($prodCats) {
                        $q->whereIn('has_categories.cat_id', $prodCats);
                    }])->get();
//        dd($prodsByCategories);
        $product->related = $prodsByCategories;
        $data['selAttrs'] = $selAttrs;
        $data['product'] = $product;
        $currencySetting = new \App\Http\Controllers\Frontend\HomeController();
        $data['curData'] = $currencySetting->setCurrency();
        $viewname = Config('constants.frontendCatlogProducts') . '.configProduct';
        return Helper::returnView($viewname, $data, null, 1);
    }

    public function getConfigProd() {
        $stockLimit = json_decode(GeneralSetting::where('url_key', 'stock')->first()->details);
        $prod = Product::where('url_key', Input::get('slug'))->first();
        if (!empty($prod)) {
//            $product = Product::where('id', $prod->id)
//                            ->with([
//                                'subproducts' => function ($query) {
//                                    $query->with(['attributes' => function($q) {
//                                            $q->where("is_filterable", 1)->with('attributevalues')->with('attributeoptions');
//                                        }])->with('attributevalues');
//                                }, 'catalogimgs' => function ($query) {
//                                    $query->where("image_mode", 1);
//                                }, 'attributeset' => function($qa) {
//                                    $qa->with(["attributes" => function($qattr) {
//                                            $qattr->where("is_filterable", 1)->with('attributevalues')->with('attributeoptions');
//                                        }]);
//                                }
//                                    ])->first();

            $product = Product::where('id', $prod->id)
//                            ->leftjoin($prod->prefix.'products subprod', "p.id", "=", "subprod.parent_prod_id")
                    ->first();
            $product->store_name = DB::table('stores')->where('id', $product->store_id)->first()->store_name;
            $product->shortDesc = html_entity_decode($product->short_desc);
            $product->longDesc = html_entity_decode($product->long_desc);
            if (User::find(Session::get('loggedin_user_id')) && User::find(Session::get('loggedin_user_id'))->wishlist->contains($product->id)) {
                $product->wishlist = 1;
            } else {
                $product->wishlist = 0;
            }
            $selAttrs = [];
//                    $product->images = $product->catalogimgs()->get();
            $product->images = DB::table($product->prefix . "_catalog_images")->where("catalog_id", $product->store_prod_id)->where("image_mode", 1)->orderBy('sort_order')->get();
            foreach ($product->images as $img) {
                $img->img = $img->image_path . '/' . @$img->filename;
            }
            $product->prodImage = $product->images[0]->image_path . '/' . $product->images[0]->filename;
            if ($prod->is_stock == 1 && $this->feature["stock"] == 1) { //->where("stock",">",0)
                $subprods = DB::table('mall_products')->where('parent_prod_id', $product->store_prod_id)->where('status', 1)->where("stock", ">", 0)->get();
            } else {
                $subprods = DB::table('mall_products')->where('parent_prod_id', $product->store_prod_id)->where('status', 1)->get();
            }

            foreach ($subprods as $subP) {
//                        $hasOpt = $subP->attributes()->withPivot('attr_id', 'prod_id', 'attr_val')->where("status", 1)->orderBy("att_sort_order", "asc")->get();
                $hasOpt = DB::table($product->prefix . '_has_options')->where("prod_id", $subP->store_prod_id)->get();
//                dd($hasOpt);
                foreach ($hasOpt as $prdOpt) {
                    $attributes = DB::table($product->prefix . '_attributes')->find($prdOpt->attr_id);
                    $attrvals = DB::table($product->prefix . '_attribute_values')->find($prdOpt->attr_val);
                    $selAttrs[$prdOpt->attr_id]['placeholder'] = $attributes->placeholder;
                    $selAttrs[$prdOpt->attr_id]['name'] = $attributes->attr;
                    $selAttrs[$prdOpt->attr_id][$attributes->slug] = $attributes->attr;
                    $selAttrs[$prdOpt->attr_id]['options'][$attrvals->id] = $attrvals->option_name;
                    $selAttrs[$prdOpt->attr_id]['attrs'][$attrvals->id]['prods'][] = $prdOpt->prod_id;
                    $selAttrs[$prdOpt->attr_id]['prods'][] = $prdOpt->prod_id;
                }
            }
            $prodCats = $product->categories()->get(['has_categories.cat_id'])->toArray();
            $prodsByCategories = Product::where('is_individual', 1)->where('status', 1)->where('is_avail', '=', 1)->where('store_id', $product->store_id)->where('id', '!=', $product->id)->with(['categories' => function($q)use($prodCats) {
                            $q->whereIn('has_categories.cat_id', $prodCats);
                        }])->get();
//        dd($prodsByCategories);
            $product->related = $prodsByCategories;
            $data['selAttrs'] = $selAttrs;
            $data['product'] = $product;
            $data['currencyVal'] = Session::get('currency_val');
            $data['stocklimit'] = $stockLimit->stocklimit;
            $currencySetting = new \App\Http\Controllers\Frontend\HomeController();
            $data['curData'] = $currencySetting->setCurrency();
            return $data;
        } else {
            abort(404, "File not found");
        }
    }

    public function comboProduct($pId) {
        $data = [];
        $viewname = Config('constants.frontendCatlogProducts') . '.comboProduct';
        return Helper::returnView($viewname, $data);
    }

    public function getComboProd() {
        $prod = Product::where('url_key', Input::get('slug'))->first();
        if (!empty($prod)) {
            $prod->prodImage = !empty(@$prod->catalogimgs()->first()->filename) ? asset(Config('constants.productImgPath') . @$prod->catalogimgs()->first()->filename) : asset('public/Admin/images/default_product.png');
            // $prod->prodImage = !empty($prod->images) ? asset(Config('constants.productImgPath') . $prod->images) : asset('public/Admin/images/default_product.png');
//                    $prod->coverPic = !empty($prod->cover_pic) ? asset(Config('constants.productImgPath') . $prod->cover_pic) : asset('public/Frontend/images/detailsbanner.jpg');
            $prod->shortDesc = html_entity_decode($prod->short_desc);
//                    $prod->breadcrumbs = Helper::getbreadcrumbs($prod->categories()->first()->id);
//                    $prod->token = Helper::generateWebToken();
//                    $prod->tokenApi = Helper::generateWebTokenApi();
            $selAttrs = [];
            //   dd($prod);
            $comboprod = $prod->comboproducts()->get();
            foreach ($comboprod as $cprod) {
                if ($cprod->prod_type == 3) {
                    $subprods = $cprod->subproducts()->get();
                    foreach ($subprods as $subP) {
                        $hasOpt = $subP->attributes()->where("is_filterable", 1)->withPivot('attr_id', 'prod_id', 'attr_val')->orderBy("att_sort_order", "asc")->get();
                        foreach ($hasOpt as $prdOpt) {
                            if (AttributeValue::find($prdOpt->pivot->attr_val)->is_active == 1) {//                           
                                $selAttrs[$cprod->id][$prdOpt->pivot->attr_id]['placeholder'] = Attribute::find($prdOpt->pivot->attr_id)->placeholder;
                                $selAttrs[$cprod->id][$prdOpt->pivot->attr_id]['name'] = Attribute::find($prdOpt->pivot->attr_id)->attr;
                                $selAttrs[$cprod->id][$prdOpt->pivot->attr_id][Attribute::find($prdOpt->pivot->attr_id)->slug] = Attribute::find($prdOpt->pivot->attr_id)->attr;
                                $selAttrs[$cprod->id][$prdOpt->pivot->attr_id]['options'][strtolower(AttributeValue::find($prdOpt->pivot->attr_val)->option_name)] = AttributeValue::find($prdOpt->pivot->attr_val)->option_name;
                                $selAttrs[$cprod->id][$prdOpt->pivot->attr_id]['attrs'][AttributeValue::find($prdOpt->pivot->attr_val)->option_value]['prods'][] = $prdOpt->pivot->prod_id;
                                $selAttrs[$cprod->id][$prdOpt->pivot->attr_id]['prods'][] = $prdOpt->pivot->prod_id;
                            }
                        }
                    }
                }
            }
//dd($selAttrs);
            $chaptersCount = 0;
            $topicsCount = 0;
            $testsCount = 0;
            $prod->comboproducts = $prod->comboproducts()->get();
            foreach ($prod->comboproducts as $cobSub) {
                $cobSub->prodImage = !empty(@$cobSub->catalogimgs()->first()->filename) ? asset(Config('constants.productImgPath') . @$cobSub->catalogimgs()->first()->filename) : asset('public/Admin/images/default_product.png');
            }
            $prod->catid = @$prod->categories()->first()->id;
            $getChildProds = $prod->subproducts()->get()->toArray();
            $prod->testsCount = $testsCount;
            $data['getChildProds'] = $getChildProds;
            $data['selAttrs'] = $selAttrs;
            $data['product'] = $prod;
            $data['generalSetting'] = DB::table('general_setting')->where('url_key', 'wowza')->where('status', 1)->first();
            $data['attrVarients'] = AttributeValue::where('attr_id', 1)->where("is_active", 1)->get()->toArray();
            $currencySetting = new \App\Http\Controllers\Frontend\HomeController();
            $data['curData'] = $currencySetting->setCurrency();
            return $data;
        } else {
            abort(404, "File not found");
        }
    }

    public function getComboProdInfo() {
        $prod = Product::find(Input::get('prodid'));
        return $prod;
    }

    public function getAvailProd() {
        $parentProdId = Input::get('parentprodid');
        $attributeid = Input::get('attributeid');
        $nextattrid = Input::get('nextattrid');
        $prod = Product::find($parentProdId);
        $arrprod = [];
        $nextAttrOptions = [];
        foreach ($prod->subproducts()->get() as $prd) {
            $arrprod[$prd->id] = [];
            foreach ($prd->attributevalues()->get() as $prdAttrOPt) {
                array_push($arrprod[$prd->id], $prdAttrOPt->attr_id . "-" . $prdAttrOPt->option_value);
            }
            foreach ($prd->attributevalues()->where("has_options.attr_id", $nextattrid)->get() as $prdOpt) {
                $nextAttrOptions[$prd->id]['id'] = $prdOpt->id;
                $nextAttrOptions[$prd->id]['option_value'] = $prdOpt->option_value;
            }
        }
        //dd($arrprod);
        $unique = array_map("unserialize", array_unique(array_map("serialize", $nextAttrOptions)));
        return $unique;
    }

    public function getProdVarient() {
        echo $attrValId = Input::get('attrValId');
        echo $productId = Input::get('productId');
        die;
        $prod = Product::find($productId);
        $producctAttrSetId = $prod->attr_set;
        //print_r($producctAttrSetId);
        $attrOpt = AttributeSet::find($producctAttrSetId)->attributes()->where("is_filterable", "=", 1)->get()->toArray();
        // print_r($attrOpt);

        $attrVal = DB::table("products")->where("parent_prod_id", "=", $productId)->where("has_options.attr_val", "=", $attrValId)
                ->leftJoin('has_options', "has_options.prod_id", "=", "products.id")
                ->leftJoin('attribute_values', "has_options.attr_val", "=", "attribute_values.id")
                ->select('products.product', 'products.parent_prod_id', 'has_options.attr_id', 'attribute_values.option_name', DB::raw("group_concat(has_options.prod_id) as productId"), DB::raw("group_concat(has_options.attr_val) as attrVal"))
                ->groupBy("has_options.attr_val")
                ->get();
        return $attrVal;
    }

    public function checkStock() {
        $isStock = GeneralSetting::where('url_key', 'stock')->first()->status;
        $prodId = Input::get('prodId');

        // $product = Product::find($prodId[0]);
        $product = Product::find($prodId[0]);
        $stockLimit = json_decode(GeneralSetting::where('url_key', 'stock')->first()->details);
        if ($isStock == 1) {
            $data['stock'] = $product->stock;
        } else {
            $data['stock'] = '1000000';
        }
        if ($stockLimit->stocklimit >= $product->stock) {
            $data['product'] = $product;
            $data['stockLimit'] = $stockLimit->stocklimit;
            return $data;
        } else if ($stockLimit->stocklimit < $product->stock) {
            $data['product'] = $data['product'] = $product;
            $data['stockLimit'] = $stockLimit->stocklimit;
            return $data;
        } else {

            $data['product'] = $product;
            $data['stockLimit'] = $stockLimit->stocklimit;
            return $data;
        }
    }

    function notify_mail() {
        if (!empty(Input::get('email')) && !empty(Input::get('prod'))) {
            $stocknotify = new Stocknotify();
            $stocknotify->email_id = Input::get('email');
            $stocknotify->prod_id = Input::get('prod');
            $stocknotify->save();
            echo json_encode(["msg" => "Notification added successfully"]);
        } else {
            echo json_encode([",msg" => "Please type email id"]);
        }
    }

    public function getProductQuickView() {

        $prods = Product::where('is_trending', 1)->where('status', 1);
        if ($this->feature['products-with-variants'] == 0) {
            $prods = $prods->where('prod_type', 1)->where('stock' > 0)->get();
        } else {
            $prods = $prods->get();
        }
        return Helper::quickAddtoCart($prods);
        // dd($prods);
    }

}
