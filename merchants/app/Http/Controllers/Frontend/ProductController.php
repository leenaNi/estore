<?php

namespace App\Http\Controllers\frontend;

use Route;
use Input;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\AttributeValue;
use App\Models\AttributeSet;
use App\Models\Attribute;
use App\Models\Stocknotify;
use App\Models\GeneralSetting;
use App\Models\CustomerReview;
use Auth;
use App\Http\Controllers\Controller;
use Session;
use App\Library\Helper;
use DB;
use Cart;

class ProductController extends Controller { 

    public function index($slug) {
        $setting = GeneralSetting::where('url_key', 'debug-option')->first();
        $prod = Product::where('url_key', $slug)->first();

        if ($setting->status == 0 && is_array($prod) && count($prod) == 0) {
            abort(404);
        }
        // dd($prod);
        if ($prod->prod_type == 1 || $prod->prod_type == 5) {

            $view = $this->simpleProduct($prod->id);
        } else if ($prod->prod_type == 2) {
            $view = $this->comboProduct($prod->id);
        } else if ($prod->prod_type == 3 || $prod->type == 4) {
            $view = $this->configProduct($prod->id);
        }
        return $view;
    }

    public function getAllReviews($pid)
    {
        $publishedReviews = CustomerReview::where(['product_id'=>$pid,'publish'=>1])->orderBy('id','desc')->get();
        $product = Product::find($pid);
        $totalRatings = CustomerReview::where(['product_id'=>$pid,'publish'=>1])->sum('rating');
        $data = ['publishedReviews'=>$publishedReviews,'product'=>$product,'totalRatings'=>$totalRatings];
        $viewname = Config('constants.frontendCatlogProducts') . '.productReview';
        return Helper::returnView($viewname, $data, null, 1);
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
        //   return "productdffsf";
        $is_desc = GeneralSetting::where('url_key', 'des')->first();
        $is_rel_prod = GeneralSetting::where('url_key', 'related-products')->first();
        $is_like_prod = GeneralSetting::where('url_key', 'like-product')->first();
        $product = Product::find($pId);
        $CustomerReviews = CustomerReview::where(['product_id'=>$pId,'publish'=>1])->orderBy('id','desc')->take(2)->get();
        $totalRatings = CustomerReview::where(['product_id'=>$pId,'publish'=>1])->sum('rating');
        // return $product;
        $product->prodImage = @Config('constants.productImgPath') .'/'. @$product->catalogimgs()->first()->filename;
        if (User::find(Session::get('loggedin_user_id')) && User::find(Session::get('loggedin_user_id'))->wishlist->contains($product->id)) {
            $product->wishlist = 1;
        } else {
            $product->wishlist = 0;
        }
        $product->images = $product->catalogimgs()->get();
        foreach ($product->images as $prdimgs) {
            $prdimgs->img = @Config('constants.productImgPath') .'/'. $prdimgs->filename;
        }
        
        $nattrs = AttributeSet::find($product->attributeset['id'])->attributes()->where("is_filterable", "=", 0)->get();

        $product->related = $product->relatedproducts()->where("status", 1)->get();
        $product->upsellproduct = $product->upsellproducts()->where("status", 1)->get();
        $product->metaTitle = @$product->meta_title == "" ? @$product->product . " | eStorifi " : @$product->meta_title;
        $product->metaDesc = @$product->meta_desc == "" ? @$product->product : @$product->meta_desc;
        $product->metaKeys = @$product->meta_keys == "" ? @$product->product : @$product->meta_keys;
        $currencySetting = new \App\Http\Controllers\Frontend\HomeController();
        $data['curData'] = $currencySetting->setCurrency();
        $data = ['product' => $product, 'nattrs' => $nattrs, 'is_desc' => $is_desc, 'is_rel_prod' => $is_rel_prod, 'is_like_prod' => $is_like_prod,'CustomerReviews'=>$CustomerReviews,'totalRatings'=>$totalRatings];
        $viewname = Config('constants.frontendCatlogProducts') . '.simpleProduct';
        return Helper::returnView($viewname, $data, null, 1);
    }

    public function configProduct($prodid) {
        $is_desc = GeneralSetting::where('url_key', 'des')->first();
        $is_rel_prod = GeneralSetting::where('url_key', 'related-products')->first();
        $is_like_prod = GeneralSetting::where('url_key', 'like-product')->first();
        $product = Product::find($prodid);
        $product->metaTitle = @$product->meta_title == "" ? @$product->product . " | eStorifi " : @$product->meta_title;
        $product->metaDesc = @$product->meta_desc == "" ? @$product->product : @$product->meta_desc;
        $product->metaKeys = @$product->meta_keys == "" ? @$product->product : @$product->meta_keys;

        $producctAttrSetId = $product->attr_set;
        $product->prodImage = Config('constants.productImgPath') .'/'. $product->catalogimgs()->first()->filename;
        if (User::find(Session::get('loggedin_user_id')) && User::find(Session::get('loggedin_user_id'))->wishlist->contains($product->id)) {
            $product->wishlist = 1;
        } else {
            $product->wishlist = 0;
        }
        
        $nattrs = AttributeSet::find($product->attributeset['id'])->attributes()->where("is_filterable", "=", 1)->get()->toArray();
        $data = ['product' => $product, 'nattrs' => $nattrs, 'is_desc' => $is_desc, 'is_rel_prod' => $is_rel_prod, 'is_like_prod' => $is_like_prod];

        $selAttrs = [];
        $subprods = $product->subproducts()->get();
        foreach ($subprods as $subP) {
            $hasOpt = $subP->attributes()->withPivot('attr_id', 'prod_id', 'attr_val')->orderBy("att_sort_order", "asc")->get();

            foreach ($hasOpt as $prdOpt) {
                $selAttrs[$prdOpt->pivot->attr_id][Attribute::find($prdOpt->pivot->attr_id)->slug] = Attribute::find($prdOpt->pivot->attr_id)->attr;
                $selAttrs[$prdOpt->pivot->attr_id]['options'][AttributeValue::find($prdOpt->pivot->attr_val)->option_name] = AttributeValue::find($prdOpt->pivot->attr_val)->option_value;

                $selAttrs[$prdOpt->pivot->attr_id]['prods'][] = $prdOpt->pivot->prod_id;
            }
        }
        $CustomerReviews = CustomerReview::where(['product_id'=>$prodid,'publish'=>1])->orderBy('id','desc')->take(2)->get();
        $totalRatings = CustomerReview::where(['product_id'=>$prodid,'publish'=>1])->sum('rating');
        $data['CustomerReviews'] = $CustomerReviews;
        $data['totalRatings'] = $totalRatings;
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
            $product = Product::where('id', $prod->id)
                            ->with([
                                'subproducts' => function ($query) {
                                    $query->with(['attributes' => function($q) {
                                            $q->where("is_filterable", 1)->with('attributevalues')->with('attributeoptions');
                                        }])->with('attributevalues');
                                }, 'catalogimgs' => function ($query) {
                                    $query->where("image_mode", 1);
                                }, 'attributeset' => function($qa) {
                                    $qa->with(["attributes" => function($qattr) {
                                            $qattr->where("is_filterable", 1)->with('attributevalues')->with('attributeoptions');
                                        }]);
                                }
                                    ])->first();
                    $product->prodImage = Config('constants.productImgPath') .'/'. $product->catalogimgs()->first()->filename;
                    $product->shortDesc = html_entity_decode($product->short_desc);
                    $product->longDesc = html_entity_decode($product->long_desc);
                    if (User::find(Session::get('loggedin_user_id')) && User::find(Session::get('loggedin_user_id'))->wishlist->contains($product->id)) {
                        $product->wishlist = 1;
                    } else {
                        $product->wishlist = 0;
                    }
                    $totstock = Product::where('parent_prod_id',$product->id)->sum('stock');  
                    if($totstock > 0)
                    {
                        $startprice = Product::where('parent_prod_id',$product->id)->orderBy('price','asc')->pluck('price');
                        $endprice = Product::where('parent_prod_id',$product->id)->orderBy('price','desc')->pluck('price');
                        $product->price = $startprice[0].' - '.$endprice[0];
                    }
                    $selAttrs = [];

                    $product->images = $product->catalogimgs()->get();
                    foreach ($product->images as $img) {
                        $img->img =Config('constants.productImgPath') .'/'. @$img->filename;
                    }
                    $product->related = $product->relatedproducts()->where("status", 1)->get();

                    foreach ($product->related as $prodrel) {
                        $related_img = @$prodrel->catalogimgs()->first();
                        if (!empty($related_img)) {
                            $prodrel->img =Config('constants.productImgPath') .'/'. @$related_img->filename;
                        } else {
                            $prodrel->img =Config('constants.defaultImgPath') . '/default-product.jpg';
                        }
                    }

                    $product->upsellproduct = $product->upsellproducts()->where("status", 1)->get();
                    foreach ($product->upsellproduct as $produpsell) {
                        $upsell_img = @$produpsell->catalogimgs()->first();
                        if (!empty($upsell_img)) {
                            $produpsell->img = Config('constants.productImgPath') .'/'. @$upsell_img->filename;
                        } else {
                            $produpsell->img = (Config('constants.defaultImgPath') . '/default-product.jpg');
                        }
                    }
                    if($prod->is_stock==1 && $this->feature["stock"]==1) {
                        $subprods = $prod->getsubproducts()->get();
                    }else{
                       $subprods = $prod->subproducts()->get();
                    }
                   
                    foreach ($subprods as $subP) {
                        $hasOpt = $subP->attributes()->withPivot('attr_id', 'prod_id', 'attr_val')->where("status",1)->orderBy("att_sort_order", "asc")->get();
                       //print_r($hasOpt);
                        foreach ($hasOpt as $prdOpt) {
                            $selAttrs[$prdOpt->pivot->attr_id]['placeholder'] = Attribute::find($prdOpt->pivot->attr_id)->placeholder;
                            $selAttrs[$prdOpt->pivot->attr_id]['name'] = Attribute::find($prdOpt->pivot->attr_id)->attr;
                            $selAttrs[$prdOpt->pivot->attr_id][Attribute::find($prdOpt->pivot->attr_id)->slug] = Attribute::find($prdOpt->pivot->attr_id)->attr;
                            $selAttrs[$prdOpt->pivot->attr_id]['options'][AttributeValue::find($prdOpt->pivot->attr_val)->option_value] = AttributeValue::find($prdOpt->pivot->attr_val)->option_name;
                            $selAttrs[$prdOpt->pivot->attr_id]['attrs'][AttributeValue::find($prdOpt->pivot->attr_val)->option_value]['prods'][] = $prdOpt->pivot->prod_id;
                            $selAttrs[$prdOpt->pivot->attr_id]['prods'][] = $prdOpt->pivot->prod_id;
                        }
                    }
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
                                    if (AttributeValue::find($prdOpt->pivot->attr_val)->is_active == 1) {
//                                $selAttrs[$prdOpt->pivot->attr_id]['placeholder'] = Attribute::find($prdOpt->pivot->attr_id)->placeholder;
//                                $selAttrs[$prdOpt->pivot->attr_id][Attribute::find($prdOpt->pivot->attr_id)->slug] = Attribute::find($prdOpt->pivot->attr_id)->attr;
//                                $selAttrs[$prdOpt->pivot->attr_id]['options'][strtolower(AttributeValue::find($prdOpt->pivot->attr_val)->option_name)] = AttributeValue::find($prdOpt->pivot->attr_val)->option_name;
//                                $selAttrs[$prdOpt->pivot->attr_id]['attrs'][AttributeValue::find($prdOpt->pivot->attr_val)->option_value]['prods'][] = $prdOpt->pivot->prod_id;
//                                $selAttrs[$prdOpt->pivot->attr_id]['prods'][] = $prdOpt->pivot->prod_id;
//                           
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
//                    foreach ($prod->comboproducts as $cprod) {
//                        if ($cprod->prod_type == 3) {
//                            $chaptersCount += $cprod->chapterscount();
//                            $topicsCount += $cprod->topicscount();
//                            $testsCount += $cprod->testscount();
//
//                            if ($cprod->is_unit == 1) {
//                                $chapProd = $cprod->chapters()->with('topics', 'tests')->get();
//                                foreach ($chapProd as $k => $cProdC) {
//                                    $chaptersp[$cProdC->unit_id]['unit_title'] = $cProdC->unit['title'];
//                                    $chaptersp[$cProdC->unit_id]["chapters"][$k] = $cProdC;
//                                }
//                                $cprod->chaptersdata = $chaptersp;
//                            } else {
//                                $cprod->chaptersdata = $cprod->chapters()->with('topics', 'tests')->get();
//                            }
//                        }
//                    }
//                    $prod->chaptersCount = $chaptersCount;
//                    $prod->topicsCount = $topicsCount;
                    //  dd($selAttrs);
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

//        if ($prod->is_unit == 1) {
//            $chapProd = $prod->chapters()->with('topics', 'tests')->get();
//            foreach ($chapProd as $k => $cProd) {
//                $chaptersp[$cProd->unit_id]['unit_title'] = $cProd->unit['title'];
//                $chaptersp[$cProd->unit_id]["chapters"][$k] = $cProd;
//            }
//            $prod->prodchapters = $chaptersp;
//        } else {
//            $prod->prodchapters = $prod->chapters()->with('topics', 'tests')->get();
//        }
//
//        // $prod->prodchapters = @$prod->chapters()->with('topics','tests')->get();
//
//
//        $prod->prodtopics = @$prod->topics()->get();
//        $prod->prodtests = @$prod->coursetests()->get();
//        $prod->testonlytests = @$prod->testsOnlyTests()->get();
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
        