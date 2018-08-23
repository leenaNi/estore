<?php

namespace App\Http\Controllers\Frontend;

use Route;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use App\Models\GeneralSetting;
use App\Library\Helper;
use App\Models\AttributeValue;
use App\Models\AttributeSet;
use App\Models\Attribute;
use Input;
use App\Http\Controllers\Controller;
use DB;
use Auth;
use Cart;
use Session;

class CategoriesController extends Controller {

    public function index($slug = null) {

//echo "slug" . $slug;
        $data['cat_name'] = "";
        if ($slug != null) {
            $cat = Category::where('url_key', $slug)->first();
            $data['metaTitle'] = @$cat->meta_title == "" ? @$cat->category . " | Cartini " : @$cat->meta_title;
            $data['metaDesc'] = @$cat->meta_desc == "" ? @$cat->category : @$cat->meta_desc;
            $data['metaKeys'] = @$cat->meta_keys == "" ? @$cat->category : @$cat->meta_keys;

            // dd($cat->category);
            $data['cat_name'] = @$cat->category;
            $data['minp'] = 0;
            // $data['maxp'] = @Helper::getMaxPriceByCat(@$cat->id);
            if (!empty($cat)) {
//                echo "Not empty";
                $data['maxp'] = @Helper::maxPriceByCat(@$cat->id);
            } else {
//                echo "Empty";
                $data['maxp'] = 0;
            }
        }
        if (!empty(Input::get('searchTerm'))) {
            $data['cat_name'] = "Search results for " . Input::get('searchTerm');
            $data['metaTitle'] = "";
            $data['metaDesc'] = "";
            $data['metaKeys'] = "";
            if (!empty(Input::get('searchTerm'))) {
                $search = Input::get('searchTerm');
                //  $url_key= str_replace(" ","-",$search);
                // $cat = Category::where('url_key','like',"%$url_key%")->first();
                $data['category'] = array();
                // dd($cat);
//            if($cat->catbanner()->count() > 0){
//               $data['category']=@$cat->catbanner()->get();  
//            }else{
//                $parentcat=Category::where('id',$cat->parent_id)->first(); 
//                              //  dd($parentcat);
//                 $data['category']= @$parentcat->catbanner()->get();
//
//            }
                $prods = Product::where('is_individual', '=', 1)
                                ->where('is_avail', '=', 1)->where('status', '=', 1);
                $prods = $prods->where(function($query) use ($search) {
                    return $query
                                    ->where('product', 'like', "%$search%")
                                    ->orWhere('short_desc', 'like', "%$search%")
                                    ->orWhere('long_desc', 'like', "%$search%")
                                    ->orWhere('meta_title', 'like', "%$search%")
                                    ->orWhere('meta_desc', 'like', "%$search%")
                                    ->orWhere('meta_keys', 'like', "%$search%")
                                    ->orWhereHas('categories', function($query) use ($search) {
                                        return $query->where('category', 'like', "%$search%");
                                    })
                                    ->orWhere(function($query) use ($search) {
                                        return $query->withAnyTag("$search");
                                    });
                });
                $prods = $prods->select(DB::raw('MAX(selling_price) AS max_price'))->first();
                $data['maxp'] = $prods->max_price;
                //  dd($data);
            }
        }
        $currencySetting = new \App\Http\Controllers\Frontend\HomeController();
        $data['curData'] = $currencySetting->setCurrency();

        $viewname = Config('constants.frontendCatlogCategory') . '.index';
        //dd($viewname);
        return Helper::returnView($viewname, $data, null, 1);
        //return view($viewname, $data);
    }

    public function getProductListing() {

        $catzz = json_decode(Input::get('filters'), true);
        $slug = Input::get('slug');
        $maxP = 0;
        $checkVarient = GeneralSetting::where('url_key', 'products-with-variants')->first()->status;
        $cat = @Category::where('url_key', $slug)->first();
        if (!empty($cat)) {
            $breadcrumbs = Helper::getbreadcrumbs($cat->id, $cat->url_key);
        } else {
            $breadcrumbs = "";
        }

        //tej code

        $catChild = [];


        $catChild = @Category::where('parent_id', $cat->id)->where('status', 1)->where('is_nav', 1)->select('id', 'category', 'url_key')->get();
        //tej code
        //  dd($catChild);
        if (!empty($cat)) {
            $metaTitle = @$cat->meta_title == "" ? @$cat->category . " | Cartini " : @$cat->meta_title;
            $metaDesc = @$cat->meta_desc == "" ? @$cat->category : @$cat->meta_desc;
            $metaKeys = @$cat->meta_keys == "" ? @$cat->category : @$cat->meta_keys;
            $allCats = @$cat->getDescendantsAndSelf();
            $cats = [];
            foreach ($allCats as $catz) {
                array_push($cats, $catz->id);
            }
        } else {
            $cats = [];
        }

        $prods = Product::where('is_individual', '=', 1)
                        ->where('is_avail', '=', 1)->where('status', '=', 1)->with(['mainimg', 'catalogimgs', 'categories']);


        if ($checkVarient == 0) {
            $prods = $prods->where("products.prod_type", 1);
        }

        if (!empty($cat)) {
            $prods = $prods->whereHas('categories', function($query) use ($cats) {
                return $query->whereIn('cat_id', $cats);
            });
        }
        $prods = $prods->where(function($query) {
            if (!empty(Input::get('tags'))) {
                $query->withAnyTag(Input::get('tags'));
            }
        });

        if (!empty(Input::get('searchTerm'))) {
            $search = Input::get('searchTerm');

            $prods = $prods->where(function($query) use ($search) {
                return $query
                                ->where('product', 'like', "%$search%")
                                ->orWhere('short_desc', 'like', "%$search%")
                                ->orWhere('long_desc', 'like', "%$search%")
                                ->orWhere('meta_title', 'like', "%$search%")
                                ->orWhere('meta_desc', 'like', "%$search%")
                                ->orWhere('meta_keys', 'like', "%$search%")
                                ->orWhereHas('categories', function($query) use ($search) {
                                    return $query->where('category', 'like', "%$search%");
                                })
                                ->orWhere(function($query) use ($search) {

                                    return $query->withAnyTag("$search");
                                });
            });
        }

     
        
        if (!empty(Input::get('sort'))) {

            if (Input::get('sort') == 1) {
                $prods = $prods->leftjoin('has_products', 'products.id', '=', 'has_products.prod_id')
                        ->orderBy(DB::raw('sum(\'has_products.qty\')'))
                        ->select('has_products.prod_id', 'products.*')
                        ->groupBy('products.id');
            }
            if (Input::get('sort') == 2) {
                $prods = $prods->orderBy("products.id", "desc");
            }

            // if (Input::get('sort') == 3) {
            //     $prods = $prods->whereRaw("products.spl_price < products.price")->orderBy('products.spl_price', 'asc');
            //     }
            if (Input::get('sort') == 3) {
                $prods = $prods->orderBy('products.selling_price', 'asc');
            }
            if (Input::get('sort') == 4) {
                $prods = $prods->orderBy('products.selling_price', 'desc');
            }
            if (Input::get('sort') == 5) {
                $prods = $prods->orderBy('products.product', 'asc');
            }
            if (Input::get('sort') == 6) {
                $prods = $prods->orderBy('products.product', 'desc');
            }
        } else {
            //  dd($prods->get());
            $prods = $prods->leftjoin('has_products', 'products.id', '=', 'has_products.prod_id')
//                     if($checkVarient==0){
//                     $prods=$prods->whereRaw(("products.prod_type","1"));
//                         }
                    ->orderBy(DB::raw('sum("has_products.qty")'))
                    ->select('has_products.prod_id', 'products.*')
                    ->groupBy('products.id');

            // $prods = $prods->orderBy("products.id", "asc");
        }

        if (!empty(Input::get('filtercatid'))) {
            $prods = $prods->WhereHas('categories', function($q) {
                $q->whereIn('categories.id', Input::get('filtercatid'));
            });
        }

        if (Input::get('minp')) {
//            echo Input::get('minp');
            $minp = round((Input::get('minp') / Session::get('currency_val')), 2);
            $prods = $prods->where('selling_price', '>=', $minp);
//            dd($minp);
        }
        if (Input::get('maxp')) {
            $maxp = round((Input::get('maxp') / Session::get('currency_val')), 2);
            $prods = $prods->where('selling_price', '<=', $maxp);
        }
        if (!empty($catzz)) {
            $i = 1;
            foreach ($catzz as $cat) {
                $cats = [];
                foreach ($cat as $cc) {
                    $c = Category::find($cc)->getDescendantsAndSelf();
                    foreach ($c as $ccc) {
                        array_push($cats, $ccc->id);
                    }
                }
                $cnt = count($cats);
                $cats = implode(",", $cats);
                $products = $prods->join(DB::raw("
(SELECT c.prod_id FROM " . DB::getTablePrefix() . "has_categories c
INNER JOIN products p ON p.id = c.prod_id
WHERE c.cat_id IN ($cats)
) " . DB::getTablePrefix() . "aa$i"), function($join) use ($i) {
                    $join->on('products.id', '=', "aa$i.prod_id");
                });
                $i++;
            }
        }
        $prdCnt = $prods->count();

        $prods = $prods->distinct('products.id')->paginate(9);
        
        foreach ($prods as $prd) {
            $prd->is_stock_status=1;
            if($this->feature['stock']==1){
            if($prd->prod_type==1 && $prd->is_stock==1){
                 $prd->is_stock_status=($prd->stock >0)?1:0;
            }
            if($prd->prod_type==3 && $prd->is_stock==1){
                 $cnfigStock=$prd->getsubproducts()->count();
                 $prd->is_stock_status=($cnfigStock > 0)?1:0;
            }
            }
            $checkCartPrd = Cart::instance("shopping")->search(array('id' => "$prd->id"));
            $prd->checkExists = $checkCartPrd;
            $prd->mainImage = Config('constants.productImgPath').'/' . @$prd->mainimg()->first()->filename;
            $prd->alt_text = @$prd->mainimg()->first()->alt_text;
            $prd->getPrice = ($prd->spl_price > 0 && $prd->spl_price < $prd->price) ? $prd->spl_price : $prd->price;
            $prd->actualPF = ($prd->spl_price > 0 && $prd->spl_price < $prd->price) ? "spl_price" : "price";
            $prd->delPrice = ($prd->spl_price > 0 && $prd->spl_price < $prd->price) ? 1 : 0;
            if (User::find(Session::get('loggedin_user_id')) && User::find(Session::get('loggedin_user_id'))->wishlist->contains($prd->id)) {
                $prd->chkwishlist = 1;
            } else {
                $prd->chkwishlist = 0;
            }
        }

        $filters = [];
        if (Category::where('url_key', 'is-filter')->count() > 0) {
            $getfilters = Category::where('url_key', 'is-filter')->first()->getImmediateDescendants();
            foreach ($getfilters as $getk => $getF) {
                $filters[$getk]['filterby'] = $getF->category;
                $filters[$getk]['childs'] = [];
                foreach ($getF->getDescendants() as $getc => $getD) {
                    $filters[$getk]['childs'][$getD->id] = $getD->category;
                }
            }
        } else
            $getfilters = [];



//dd($cat);
        //  $maxP = @Helper::getMaxPriceByCat(@$Cat->id);
        // $maxP = Helper::getmaxPrice();
        //  $maxP = @Helper::maxPriceByCat(@$cat->id);

        if (!empty(Input::get('searchTerm'))) {
            if ($prdCnt > 0) {
                $maxP = Helper::getmaxPrice();
            } else {
                $maxP = 0;
            }
        } else {
            
        }
        $currencySetting = new \App\Http\Controllers\Frontend\HomeController();
        $data = ['prods' => @$prods,
            'prdCnt' => @$prdCnt,
            'getslug' => @$slug,
            'cat' => @$cat,
            'tags' => @$tags,
            'getfilters' => $filters,
            'metaTitle' => @$metaTitle,
            'metaDesc' => @$metaDesc,
            'metaKeys' => @$metaKeys,
            'maxp' => $maxP,
            'catChild' => $catChild, //tej code
            'currency_val' => Session::get('currency_val'),
            'breadcrumbs' => $breadcrumbs,
            'curData' => $currencySetting->setCurrency()
        ];
        return $data;
    }

    public function getListingFilter() {
        $slug = Input::get('slug');
        $cat = Category::where('url_key', $slug)->first();
        $metaTitle = $cat->meta_title == "" ? $cat->category . " | Cartini " : $cat->meta_title;
        $metaDesc = $cat->meta_desc == "" ? $cat->category : $cat->meta_desc;
        $metaKeys = $cat->meta_keys == "" ? $cat->category : $cat->meta_keys;
        $allCats = $cat->getDescendantsAndSelf();
        $cats = [];
        foreach ($allCats as $catz) {
            array_push($cats, $catz->id);
        }
        $prods = Product::where('is_individual', '=', 1)
                ->where('is_avail', '=', 1)
                ->orderBy('sort_order', 'desc')
                ->whereHas('categories', function($query) use ($cats) {
                    return $query->whereIn('cat_id', $cats);
                })
                ->where(function($query) {
            if (!empty(Input::get('tags'))) {
                $query->withAnyTag(Input::get('tags'));
            }
        });
        $tags = [];
        foreach (Product::where('is_individual', '=', 1)
                ->where('is_avail', '=', 1)
                ->orderBy('sort_order', 'desc')
                ->whereHas('categories', function($query) use ($cats) {
                    return $query->whereIn('cat_id', $cats);
                })->get() as $prd) {
            foreach ($prd->tagNames() as $tg) {
                if (!in_array($tg, $tags) && !empty($tg)) {
                    array_push($tags, $tg);
                }
            }
        }
        if (!empty(Input::get('sort'))) {
            if (Input::get('sort') == 1) {
                $prods = $prods->leftjoin('has_products', 'products.id', '=', 'has_products.prod_id')
                        ->orderBy(DB::raw('sum(\'has_products.qty\')'))
                        ->groupBy('products.id');
            }
            if (Input::get('sort') == 2) {
                $prods = $prods->orderBy('created_at', 'desc');
            }
            if (Input::get('sort') == 5) {
                $prods = $prods->orderBy('product', 'asc');
            }
        }

        $prdCnt = $prods->count();
        $prods = $prods->with(['mainimg', 'catalogimgs', 'categories']);
        if (!empty(Input::get('filtercatid'))) {
            $prods = $prods->WhereHas('categories', function($q) {
                $q->whereIn('categories.id', Input::get('filtercatid'));
            });
            //dd($prods->get()->toArray());
        }
        $prods = $prods->paginate(9);
        foreach ($prods as $prd) {
            $prd->prodImage = Config('constants.productImgPath').'/' . @$prd->catalogimgs()->where("image_mode", 1)->first()->filename;
        }

        $getfilters = Category::where('url_key', 'is-filter')->first()->getImmediateDescendants();

        $viewname = Config('constants.frontendCatlogCategory') . '.filter';

        $data = ['prods' => $prods,
            'prdCnt' => $prdCnt,
            'getslug' => $slug,
            'cat' => $cat,
            'tags' => $tags,
            'getfilters' => $getfilters,
            'metaTitle' => $metaTitle,
            'metaDesc' => $metaDesc,
            'metaKeys' => $metaKeys,
        ];

        return Helper::returnView($viewname, $data);
    }

    public function getProductQuickView() {
        $prod_id = Input::get('prod_id');
        $product = Product::find($prod_id);
        $producctAttrSetId = $product->attr_set;
        $product->prodImage = Config('constants.productImgPath') .'/'. $product->catalogimgs()->first()->filename;
        if (User::find(Session::get('loggedin_user_id')) && User::find(Session::get('loggedin_user_id'))->wishlist->contains($product->id)) {
            $product->wishlist = 1;
        } else {
            $product->wishlist = 0;
        }
        $nattrs = AttributeSet::find($product->attributeset['id'])->attributes()->where("is_filterable", "=", 1)->get()->toArray();
        $data = ['product' => $product, 'nattrs' => $nattrs];

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

        $data['selAttrs'] = $selAttrs;
        $data['product'] = $product;
        $currencySetting = new \App\Http\Controllers\Frontend\HomeController();
        $data['curData'] = $currencySetting->setCurrency();
        //  $viewname = Config('constants.frontendCatlogProducts') . '.quickView';
        //dd($viewname);
        //  return Helper::returnView($viewname, $data,null,1);
        return $data;
    }

}
