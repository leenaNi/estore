<?php

namespace App\Http\Controllers\Admin;

use Route;
use Input;
use App\Models\Product;
use App\Models\HasProducts;
use App\Models\Finish;
use App\Models\Fabric;
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
use App\Models\UnitMeasure;
use App\Models\Tax;
use App\Models\ProductHasTaxes;
use App\Models\AttributeType;
use App\Models\HasVendors;
use App\Models\MallProdCategory;
use App\Models\MallProducts;
use DB;
use Request;
use Response;
use App\Models\User;
use Session;
use App\Library\Helper;
use App\Classes\UploadHandler;
use Vsmoraes\Pdf\Pdf;
use DNS1D;
use DNS2D;
use Excel;
use Schema;
use DOMDocument;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Artisan;

class ProductsController extends Controller {

    private $pdf;

    function __construct(Pdf $pdf) {
        parent::__construct();
        $this->pdf = $pdf;
    }

    public function index() {

        //\Artisan::call("cache:clear");
        //dd(Config('constants.productImgPath'));
//        $products = Product::find(3);
//          $products->is_share_on_mall=1;
//          $products->save();
//dd($products);
        $barcode = GeneralSetting::where('url_key', 'barcode')->get()->toArray()[0]['status'];
        $products = Product::where('is_individual', '=', '1')->where('prod_type', '<>', 6)->orderBy("id", "desc");

        $categoryA = Category::get(['id', 'category'])->toArray();
        $rootsS = Category::roots()->where("status", 1)->get();
        $category = [];
        foreach ($categoryA as $val) {
            $category[$val['id']] = $val['category'];
        }
        $userA = User::get(['id', 'firstname', 'lastname'])->toArray();
        $user = [];
        foreach ($userA as $val) {
            $user[$val['id']] = $val['firstname'] . ' ' . $val['lastname'];
        }
        if (!empty(Input::get('product_name'))) {
            $products = $products->where('product', 'like', "%" . Input::get('product_name') . "%");
        }
        if (!empty(Input::get('pricemin'))) {
            $min_prize = Input::get('pricemin') / Session::get('currency_val');
            $products = $products->where('selling_price', '>=', $min_prize);
        }
        if (!empty(Input::get('pricemax'))) {
            $max_prize = Input::get('pricemax') / Session::get('currency_val');
            $products = $products->where('selling_price', '<=', $max_prize);
        }
        if (!empty(Input::get('category'))) {
            $products = $products->whereHas('categories', function($q) {
                $q->where('categories.id', Input::get('category'));
            });
        }
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
        if (!empty(Input::get('prdSearch'))) {
            $products = $products->sortable()->get();
            $productCount = $products->count();
        } else {
            $products = $products->sortable()->paginate(Config('constants.paginateNo'));
            $productCount = $products->total();
        }

        $prod_types = [];
        $prodTy = ProductType::where('status', 1)->get(['id', 'type']);
        $setting = GeneralSetting::where('id', 30)->first();
        $is_stockable = GeneralSetting::where('id', 26)->first();
        //  echo $setting->status; die;
        if ($setting->status == 0) {
            $prodTy = $prodTy->whereIn('id', array(1, 2, 5))->toArray();
        } else {
            $prodTy = $prodTy->whereIn('id', array(1, 2, 3, 5))->toArray();
        }
        foreach ($prodTy as $prodT) {
            $prod_types[$prodT['id']] = $prodT['type'];
        }
        $is_stockable = GeneralSetting::where('id', 26)->first();

        $attr_sets = [];
        $attrS = AttributeSet::where('id', '!=', 1)->where('status', 1)->get(['id', 'attr_set'])->toArray();
        foreach ($attrS as $attr) {
            $attr_sets[$attr['id']] = $attr['attr_set'];
        }

        foreach ($products as $prd) {
//if(count($prd->wishlist) > 0){
//             $dd[$prd->product]=  $prd->wishlist;
//           }
            $getPrdImg = ($prd->catalogimgs()->where("image_mode", 1)->count() > 0) ? $prd->catalogimgs()->where("image_mode", 1)->first()->filename : 'default_product.png';
            $prd->prodImage = Config('constants.productImgPath') . "/" . @$getPrdImg;
        }
        // dd($dd);

        return Helper::returnView(Config('constants.adminProductView') . '.index', compact('products', 'category', 'user', 'barcode', 'rootsS', 'productCount', 'prod_types', 'attr_sets'));
    }

    public function add() {
        $has_attr = DB::table('has_attributes')->select('attr_set')->groupBy('attr_set')->get();

        $attr_has = [];
        foreach ($has_attr as $ah) {
            $attr_has[] = $ah->attr_set;
        }

        $attr_sets = [];
        $attrS = AttributeSet::get(['id', 'attr_set'])->toArray();

        foreach ($attrS as $attr) {
            if (in_array($attr['id'], $attr_has)) {
                $attr_sets[$attr['id']] = $attr['attr_set'];
            }
        }
        $prod_types = [];
        $prodTy = ProductType::where('status', 1)->get(['id', 'type']);
        $setting = GeneralSetting::where('id', 30)->first();
        $is_stockable = GeneralSetting::where('id', 26)->first();

        if ($setting->status == 0) {
            $prodTy = $prodTy->whereIn('id', array(1, 2, 5))->toArray();
        } else {
            $prodTy = $prodTy->whereIn('id', array(1, 2, 3, 5))->toArray();
            // dd($prodTy);
        }
        foreach ($prodTy as $prodT) {
            $prod_types[$prodT['id']] = $prodT['type'];
        }
        $is_stockable = GeneralSetting::where('id', 26)->first();

        $attr_sets = [];
        $attrS = AttributeSet::where('id', '!=', 1)->get(['id', 'attr_set'])->toArray();
        foreach ($attrS as $attr) {
            $attr_sets[$attr['id']] = $attr['attr_set'];
        }


        $action = route("admin.products.save");

        return view(Config('constants.adminProductView') . '.add', compact('is_stockable', 'prod_types', 'attr_sets', 'action'));
    }

    public function save() {
        //dd(Input::all());
        $prod = Product::create(Input::all());
        $category = Input::get("category");
        $retunUrl = Input::get("return_url");
        // print_r($prod);die;
        if (Input::File('images')) {
            // dd(Input::File('images'));
            $imgValue = Input::File('images');

            $destinationPath = Config('constants.productUploadImgPath') . "/";
            $data = Input::get('prod_img_url');
            list($type, $data) = explode(';', $data);
            list(, $data) = explode(',', $data);
            $data = base64_decode($data);
            $fileName = "prod-" . date("YmdHis") . "." . Input::File('images')->getClientOriginalExtension();
            file_put_contents($destinationPath . $fileName, $data);
            //$dynamiclayout->image = $fileName;

            $saveImgs = CatalogImage::findOrNew(Input::get('id_img'));
            $saveImgs->catalog_id = $prod->id;
            $saveImgs->filename = is_null($fileName) ? $saveImgs->filename : $fileName;
            $saveImgs->image_type = 1;
            $saveImgs->image_path = Config('constants.productImgPath');
            $saveImgs->image_mode = 1;
            $saveImgs->save();
        }

        $prod->added_by = Input::get('added_by');
        if ($prod->prod_type == 1) {

            $prod->attr_set = "1";
        }
        if (Input::get("is_stock") == 1) {
            $prod->stock = Input::get("stock");
        }
        if (Input::get('selling_price')) {

            if (Input::get('price') > Input::get('selling_price')) {
                $prod->spl_price = Input::get('selling_price');
                $prod->selling_price = Input::get('selling_price');
            } else {
                $prod->selling_price = Input::get('price');
            }
        }

        //dd($prod);
        // Session::flash("msg","Product Added succesfully.");
        $prod->update();
        if ($prod->prod_type != 3) {
            $attributes = AttributeSet::find($prod->attributeset['id'])->attributes;
            if (!empty($attributes))
                $prod->attributes()->sync($attributes);
            else
                $prod->attributes()->detach();
        } else {
            $attributes = AttributeSet::find($prod->attributeset['id'])->attributes()->where('is_filterable', "=", "0")->get();
            if (!empty($attributes))
                $prod->attributes()->sync($attributes);
        }
        if (count($category) > 0) {
            $prod->categories()->sync($category);
        }
        $view = !empty(Input::get('return_url')) ? redirect()->to($retunUrl) : redirect()->route("admin.products.general.info", ['id' => $prod->id]);
        return $view;
    }

    public function edit() {
        $barcode = GeneralSetting::where('url_key', 'barcode')->get()->toArray()[0]['status'];
        $prod = Product::find(Input::get('id'));
        $action = route('admin.products.update');

        $unit_measure = ['' => 'Select Unit'] + UnitMeasure::where('status', 1)->pluck('unit', 'id')->toArray();
        $taxes = Tax::select(DB::raw("CONCAT(name, ' (', rate, ')') AS name"), 'id')->where('status', 1)->pluck('name', 'id')->toArray();
        $selected_taxes = ProductHasTaxes::where('product_id', Input::get('id'))->pluck('tax_id')->toArray();

        $arr = [];
        foreach ($selected_taxes as $val) {
            $arr[] = (int) $val;
        }
        $selected_taxes = $arr;

        $is_desc = GeneralSetting::where('url_key', 'des')->first();

        return view(Config('constants.adminProductView') . '.editInfo', compact('prod', 'action', 'barcode', 'unit_measure', 'taxes', 'selected_taxes', 'is_desc'));
    }

    public function update() {

        $is_desc = GeneralSetting::where('url_key', 'des')->first();
        $retunUrl = Input::get('return_url');
        $prod = Product::find(Input::get('id'));
        $prod->status = Input::get('status');
        $prod->updated_by = Input::get('updated_by');
        $prod->eCount = Input::get('eCount');
        $prod->eNoOfDaysAllowed = Input::get('eNoOfDaysAllowed');
        $prod->barcode = Input::get('barcode');
        $prod->min_order_quantity = Input::get('min_order_quantity');
        $prod->is_trending = Input::get('is_trending');

        $prod->short_desc = Input::get('short_desc');
        if ($is_desc->status) {
            $prod->long_desc = Input::get('long_desc');
            $prod->add_desc = Input::get('add_desc');
        }

        $applicable_taxes = Input::get('applicable_tax');
        $product_id = Input::get('id');
        if (isset($applicable_taxes)) {
            $prod->texes()->sync($applicable_taxes);
        }

        if (Input::get('spl_price') > 0.00 || Input::get('spl_price') == '') {
            $prod->selling_price = Input::get('spl_price');
        } else {
            $prod->selling_price = Input::get('price');
        }
        $prod->fill(Input::except('category_id', 'tags'))->save();
//       dd($prod);
        $tags = !empty(Input::get("tags")) ? explode(",", Input::get("tags")) : '';
        if (!empty($tags)) {
            try {
                @$prod->retag($tags);
            } catch (Exception $ex) {
                
            }
        } else {
            try {
                @$prod->untag();
            } catch (Exception $ex) {
                
            }
        }
        Session::flash("msg", "Product updated succesfully.");
        $prod->update();

        if ((Input::get('stock_type') == '1') || (Input::get('stock_type') == '0')) {
            // echo "in";
            // dd(Input::all());
            $stockUpdateHistory = new StockUpdateHistory;
            $stockUpdateHistory->user_id = Session::get('loggedinAdminId');
            $stockUpdateHistory->product_id = Input::get('id');
            $stockUpdateHistory->update_status = Input::get('stock_type');
            $stockUpdateHistory->update_qty = Input::get('stock_update_qty');
            $stockUpdateHistory->total_qty = Input::get('stock');
            $stockUpdateHistory->save();
        }

        $view = !empty(Input::get('return_url')) ? redirect()->to($retunUrl) : redirect()->route("admin.products.edit.category", ['id' => $prod->id]);
        return $view->with('msg', "Product updated successfully.");
    }

    public function edit_category() {
        $prod = Product::find(Input::get('id'));
        $action = route('admin.products.update.category');
        return view(Config('constants.adminProductView') . '.edit_category', compact('prod', 'action'));
    }

    public function update_edit_category() {
        $retunUrl = Input::get('return_url');
        $prod = Product::find(Input::get('id'));
        $prod->updated_by = Input::get('updated_by');
        $prod->update();
        if (!empty(Input::get('category_id')))
            $prod->categories()->sync(Input::get('category_id'));
        else
            $prod->categories()->detach();

        $view = !empty(Input::get('return_url')) ? redirect()->to($retunUrl) : redirect()->route("admin.products.images", ['id' => $prod->id]);
        return $view->with('msg', "Product updated successfully.");
    }

    //images Tab

    public function img() {
        $images = CatalogImage::paginate(Config('constants.paginateNo'));
        $prod = Product::find(Input::get('id'));
        $action = route('admin.products.images.save');
        return view(Config('constants.adminProductView') . '.catalog_images', compact('images', 'prod', 'action'));
    }

    public function delImg() {
        $id = Input::get('imgId');
        $del = CatalogImage::find($id);
        if ($del->delete())
            return 1;
        else
            return 0;
        //->with('msg', "Image deleted successfully.");
        //return redirect()->back()->with('msg',"Image deleted successfully.");
        //echo "Successfully deleted";
    }

    public function saveImg() {
        // dd(Product::find(Input::get('prod_id'))->catalogimgs()->where("image_type", "=", 1)->get());
        //  dd(Input::all());  
        if (Input::file('images')) {
            foreach (Input::file('images') as $key => $value) {
                // if (Input::get('file_upload_status')[$key] == 0) {
                //     $fileName = Input::get('filename')[$key];
                // } else {
                // dd($value);
                if ($value != null) {
                    // $destinationPath = public_path() . '/public/Admin/uploads/catalog/products/';
                    // $fileName = "prod-" . $key . date("YmdHis") . "." . $value->getClientOriginalExtension();
                    // $upload_success = $value->move($destinationPath, $fileName);
                    $destinationPath = Config('constants.productUploadImgPath') . "/";
                    $data = Input::get('prod_img_url_' . $key);
                    list($type, $data) = explode(';', $data);
                    list(, $data) = explode(',', $data);
                    $data = base64_decode($data);
                    $fileName = "prod-" . $key . date("YmdHis") . "." . $value->getClientOriginalExtension();
                    file_put_contents($destinationPath . $fileName, $data);
                } else {
                    $fileName = '';
                }
                // }
                //dd($fileName);
                $saveImgs = CatalogImage::findOrNew(Input::get('id_img')[$key]);
                $saveImgs->catalog_id = Input::get('prod_id');
                $saveImgs->filename = is_null($fileName) ? $saveImgs->filename : $fileName;
                $saveImgs->image_type = 1;
                $saveImgs->alt_text = Input::get('alt_text')[$key];
                $saveImgs->image_mode = 1;
                $saveImgs->sort_order = Input::get('sort_order')[$key];
                $saveImgs->image_path = Config('constants.productImgPath');
                $saveImgs->save();
            }
        } else {
            foreach (Input::get('extimg') as $key => $value) {
                $saveImgs = CatalogImage::findOrNew(Input::get('id_img')[$key]);
                $saveImgs->catalog_id = Input::get('prod_id');
                $saveImgs->image_type = 1;
                $saveImgs->alt_text = Input::get('alt_text')[$key];
                $saveImgs->image_mode = 1;
                $saveImgs->sort_order = Input::get('sort_order')[$key];
                $saveImgs->image_path = Config('constants.productImgPath');
                $saveImgs->save();
            }
        }
        $prod = Product::find(Input::get('prod_id'));
        $prod->updated_by = Input::get('updated_by');
        $prod->update();
        $attrs = AttributeSet::find($prod->attributeset['id'])->attributes->toArray();
        $attributes_filter_yes = AttributeSet::find($prod->attributeset['id'])->attributes_filter_yes();
        $attributes_filter_no = AttributeSet::find($prod->attributeset['id'])->attributes_filter_no();
        if (!empty(Input::get('return_url'))) {

            $nextView = redirect()->to(Input::get('return_url'));
        } else {
            if ($prod->prod_type == 2) {
                $nextView = redirect()->route("admin.combo.products.view", ['id' => $prod->id]);
            } else if (!empty($attrs)) {
                if ($attributes_filter_no != 0) {
                    $nextView = redirect()->route("admin.products.attribute", ['id' => $prod->id]);
                } else if ($attributes_filter_yes != 0) {
                    $nextView = redirect()->route("admin.products.configurable.attributes", ['id' => $prod->id]);
                } else {
                    $nextView = redirect()->route("admin.products.upsell.related", ['id' => $prod->id]);
                }
            } elseif ($prod->prod_type == 3) {
                //    echo 1;
                if (!empty($attrs)) {
                    $nextView = redirect()->route("admin.products.configurable.attributes", ['id' => $prod->id]);
                } else {
                    $nextView = redirect()->route("admin.products.upsell.related", ['id' => $prod->id]);
                }
            } elseif ($prod->prod_type == 4) {
                $nextView = redirect()->route("admin.products.configurable.without.stock.attributes", ['id' => $prod->id]);
            } else {
                $nextView = redirect()->route("admin.products.upsell.related", ['id' => $prod->id]);
            }
        }
        Session::flash("msg", "Product updated succesfully.");
        return $nextView;
    }

    public function attribute() {
        $prod = Product::find(Input::get('id'));
        $attrset = $prod->attr_set;
        $attributes_values = $prod->attributes->toArray();
        $attributes = Attribute::where('is_filterable', 0)->orderBy('att_sort_order', 'asc')->with('attributeoptions')->whereHas('attributesets', function($q)use ($attrset) {
                    $q->where('attribute_sets.id', $attrset);
                })->get()->toArray();
        foreach ($attributes as $key => $attr) {
            foreach ($attributes_values as $key1 => $attr_val) {
                if ($attr['id'] == $attr_val['id'] && $attr_val['pivot']['attr_val']) {
                    if ($attr_val['attr_type'] == 2) {
                        $attributes[$key]['value'] = json_decode($attr_val['pivot']['attr_val']);
                    } else if ($attr_val['attr_type'] == 5) {
                        $attributes[$key]['value'] = json_decode($attr_val['pivot']['attr_val']);
                    } else {
                        $attributes[$key]['value'] = $attr_val['pivot']['attr_val'];
                    }
                }
            }
        }
        $attrs = Attribute::where('status', 1)->orderBy("id", "asc");
        $attrSetsSelected = [];
        $attr_types = array(0 => 'Select Attribute Type');
        $attr_t = AttributeType::all()->toArray();
        foreach ($attr_t as $val) {
            $attr_types[$val['id']] = $val['attr_type'];
        }
        $action = route('admin.products.attribute.save');
        //Session::flash("msg","Product updated succesfully.");
        return view(Config('constants.adminProductView') . '.attributes', compact('attributes', 'prod', 'action', 'attributes_values', 'attrs', 'attr_types', 'attrSetsSelected'));
    }

    public function saveAttribute() {
        $returnUrl = Input::get('return_url');

        $product = Product::find(Input::get('id'));
        $product->updated_by = Input::get('updated_by');
        $product->update();
        $attributes = array();
        foreach (Input::get('attributes') as $att_id => $attribute) {
            if ($attribute['attr_type_id'] == 2) {
                if (isset($attribute['attr_val'])) {
                    $attributes[$att_id] = array('attr_val' => json_encode($attribute['attr_val']), 'attr_type_id' => $attribute['attr_type_id']);
                }
            } else if ($attribute['attr_type_id'] == 5) {
                if (isset($attribute['attr_val'])) {
                    $attributes[$att_id] = array('attr_val' => json_encode($attribute['attr_val']), 'attr_type_id' => $attribute['attr_type_id']);
                }
            } else if ($attribute['attr_type_id'] == 10) {
                $allAtt = Input::file('attributes');
                $att = $allAtt[$att_id]['attr_val'];
                if ($att) {
                    $destinationPath = Config('constants.productUploadImgPath') . "/";
                    $fileName = time() . '.' . $att->getClientOriginalExtension();
                    if ($att->move($destinationPath, $fileName)) {
                        $attributes[$att_id] = array('attr_val' => $fileName, 'attr_type_id' => $attribute['attr_type_id']);
                    }
                } else {
                    $attributes[$att_id] = array('attr_val' => $attribute['file_val'], 'attr_type_id' => $attribute['attr_type_id']);
                }
            } else if ($attribute['attr_type_id'] == 11) {
                $allAtt = Input::file('attributes');
                $att = $allAtt[$att_id]['attr_val'];
                if ($att) {
                    if (in_array($att->getClientOriginalExtension(), array('jpg', 'JPG', 'png', 'PNG'))) {
                        $destinationPath = Config('constants.productUploadImgPath') . "/";
                        $fileName = time() . '.' . $att->getClientOriginalExtension();
                        if ($att->move($destinationPath, $fileName)) {
                            $attributes[$att_id] = array('attr_val' => $fileName, 'attr_type_id' => $attribute['attr_type_id']);
                        }
                    } else {
                        Session::flash("errorMessage", "Invalid Image in Attributes! Please upload valid image file.");
                        $returnUrl = route('admin.products.attribute', ['id' => $product->id]);
                    }
                } else {
                    $attributes[$att_id] = array('attr_val' => $attribute['image_val'], 'attr_type_id' => $attribute['attr_type_id']);
                }
            } else if ($attribute['attr_type_id'] == 16) {
                $allAtt = Input::file('attributes');
                $att1 = $allAtt[$att_id]['attr_val'];

                if ($att1[0]) {
                    $att_files = array();
                    foreach ($att1 as $key => $att) {
                        $destinationPath = Config('constants.productUploadImgPath') . "/";
                        $fileName = time() . $key . '.' . $att->getClientOriginalExtension();
                        if ($att->move($destinationPath, $fileName)) {
                            array_push($att_files, $fileName);
                        }
                    }
//                    dd($att_files);
                    $attributes[$att_id] = array('attr_val' => json_encode($att_files), 'attr_type_id' => $attribute['attr_type_id']);
                } else {
                    $attributes[$att_id] = array('attr_val' => $attribute['file_multi_val'], 'attr_type_id' => $attribute['attr_type_id']);
                }
            } else if ($attribute['attr_type_id'] == 17) {
                $allAtt = Input::file('attributes');
                $att1 = $allAtt[$att_id]['attr_val'];

                if ($att1[0]) {
                    $att_files = array();
                    foreach ($att1 as $key => $att) {
                        if (in_array($att->getClientOriginalExtension(), array('jpg', 'JPG', 'png', 'PNG'))) {
                            $destinationPath = Config('constants.productUploadImgPath') . "/";
                            $fileName = time() . $key . '.' . $att->getClientOriginalExtension();
                            if ($att->move($destinationPath, $fileName)) {
                                array_push($att_files, $fileName);
                            }
                        } else {
                            Session::flash("errorMessage", "Invalid Image in Attributes! Please upload valid image file.");
                            $returnUrl = route('admin.products.attribute', ['id' => $product->id]);
                        }
                    }
                    $attributes[$att_id] = array('attr_val' => json_encode($att_files), 'attr_type_id' => $attribute['attr_type_id']);
                } else {
                    $attributes[$att_id] = array('attr_val' => $attribute['image_multi_val'], 'attr_type_id' => $attribute['attr_type_id']);
                }
            } else {
                if (isset($attribute['attr_val'])) {
                    $attributes[$att_id] = array('attr_val' => $attribute['attr_val'], 'attr_type_id' => $attribute['attr_type_id']);
                }
            }
        }
        $attributes_filter_yes = AttributeSet::find($product->attributeset['id'])->attributes_filter_yes();
        $product->attributes()->sync($attributes);
        if (!empty($returnUrl)) {
            $nextView = redirect()->to($returnUrl);
        } else {
            if ($product->prod_type == 2) {
                $nextView = redirect()->route("admin.combo.products.view", ['id' => $product->id]);
            } elseif ($product->prod_type == 3) {
                if ($attributes_filter_yes != 0) {
                    $nextView = redirect()->route("admin.products.configurable.attributes", ['id' => $product->id]);
                } else {
                    $nextView = redirect()->route("admin.products.upsell.related", ['id' => $product->id]);
                }
            } elseif ($product->prod_type == 4) {
                $nextView = redirect()->route("admin.products.configurable.without.stock.attributes", ['id' => $product->id]);
            } else {
                $nextView = redirect()->route("admin.products.upsell.related", ['id' => $product->id]);
            }
        }
        Session::flash("message", " Attribute updated successfully.");
        return $nextView;
    }

    public function configProdAttrs($prodId) {
        $barcode = GeneralSetting::where('url_key', 'barcode')->get()->toArray()[0]['status'];
        $prod = Product::find($prodId);
        $attributes = AttributeSet::find($prod->attributeset['id'])->attributes()->where("is_filterable", 1)->get();
        $attrs = [];
        foreach ($attributes as $attr) {
            $attrs[$attr->id]['name'] = $attr->attr;
            $attrValues = $attr->attributeoptions()->where('is_active', 1)->get(['id', 'option_name']);
            foreach ($attrValues as $val) {
                $attrs[$attr->id]['options'][$val->id] = $val->option_name;
            }
        }
        $prodVariants = Product::where("parent_prod_id", "=", $prod->id)->get();
        $action = route('admin.products.configurable.update');
        //  Session::flash("msg","Product updated succesfully.");
        return view(Config('constants.adminProductView') . '.editCProd', compact('prod', 'action', 'attrs', 'prodVariants', 'barcode'));
    }

    public function update4() {
        //  dd(Input::all());

        $prod = Product::find(Input::get("prod_id"));
        $attributes = AttributeSet::find($prod->attributeset['id'])->attributes()->where("is_filterable", "=", "1")->get()->toArray();

        $prods = [];
        $prodsAttr = [];
        foreach ($attributes as $value) {

            foreach (Input::get($value["id"]) as $key => $val) {

                !isset($prods[$key]) ? $prods[$key] = [] : '';
                $prods[$key]["options"][$value["id"]] = $val;
                array_push($prodsAttr, $val);
            }
        }

        $prdAttrCnt = count($prodsAttr);
        $subProds = Product::where('parent_prod_id', Input::get('prod_id'))->with(['attributes' => function($q) use($prodsAttr) {
                        $q->whereIn('attr_val', $prodsAttr);
                    }])->get();
        $isExists = 0;
        foreach ($subProds as $sprod) {
            if (count($sprod->attributes) == $prdAttrCnt) {
                $isExists = 1;
            }
        }
        //Check if same varient already exists
        if ($isExists) {
            return redirect()->back()->with('msg', "Product variant already exists.");
        } else {
            $prod->updated_by = Input::get('updated_by');
            $prod->update();
            foreach (Input::get("price") as $key => $val) {
                !isset($prods[$key]) ? $prods[$key] = [] : '';
                $prods[$key]["price"] = $val;
            }
            if (!empty(Input::get("stock"))):
                foreach (@Input::get("stock") as $key => $val) {
                    !isset($prods[$key]) ? $prods[$key] = [] : '';
                    $prods[$key]['stock'] = $val;
                }
            endif;
            foreach (@Input::get("is_avail") as $key => $val) {
                !isset($prods[$key]) ? $prods[$key] = [] : '';
                $prods[$key]['is_avail'] = $val;
            }
            foreach ($prods as $key => $prd) {
                // dd($prd["options"]);
                $newConfigProduct = Product::create(['product' => $prod->product . ' - Variant - ' . ($key + 1), 'is_avail' => 1, 'is_stock' => $prod->is_stock, 'parent_prod_id' => $prod->id, 'is_individual' => 0, 'prod_type' => 1, 'attr_set' => $prod->attr_set, 'price' => $prods[$key]['price'], 'stock' => $prods[$key]['stock'], 'is_avail' => $prods[$key]['is_avail']]);
                //*
                $attributes = AttributeSet::find($newConfigProduct->attributeset['id'])->attributes;
                $newConfigProduct->attributes()->sync($attributes);
                //
                $name = $prod->product . ' - Variant (';
                foreach ($prd["options"] as $op => $opt) {
                    $opt = trim($opt);
                    $optionName = AttributeValue::find($opt)->option_name;
                    $name .= "$optionName, ";
                    DB::update(DB::raw("update " . DB::getTablePrefix() . "has_options set attr_val = '$opt' where attr_id = $op and prod_id = " . $newConfigProduct->id));
                }
                $name = rtrim($name, ", ");
                $name .= ")";
                $newConfigProduct->product = $name;
                $newConfigProduct->update();
            }
//dd($newConfigProduct);
        }
        $view = !empty(Input::get('return_url')) ? redirect()->to(Input::get('return_url')) : redirect()->route("admin.product.vendors", ['id' => $prod->id]);
        Session::flash("msg", "Product updated succesfully.");
        return $view;
    }

    //update without stock conf

    public function updateWithoutStock() {
        $prod = Product::find(Input::get("prod_id"));
        $prods = [];

        foreach (Input::get("id") as $key => $val) {

            foreach ($val as $i => $v) {
                array_push($prods, ["attr_id" => $key, "attr_val" => $v, "price" => Input::get("price")[$key][$i], "is_avail" => Input::get("is_avail")[$key][$i]]);
            }
        }
        foreach ($prods as $key => $prd) {
            $args = ['product' => $prod->product . ' - Variant - ' . (AttributeValue::find($prd['attr_val'])->option_name), 'is_avail' => $prd['is_avail'], 'parent_prod_id' => $prod->id, 'is_individual' => 0, 'prod_type' => 1, 'attr_set' => $prod->attr_set, 'price' => $prd['price']];

            $newConfigProduct = Product::create($args);
            $newConfigProduct->attributes()->attach($prd['attr_id'], ["attr_val" => $prd['attr_val']]);
        }

        $view = !empty(Input::get('return_url')) ? redirect()->to(Input::get('return_url')) : redirect()->route("admin.products.upsell.related", ['id' => $prod->id]);
        Session::flash("msg", "Product updated succesfully.");
        return $view;
    }

    public function updateProdVariant() {
        $prod = Product::find(Input::get("id"));
        $attributes = AttributeSet::find($prod->attributeset['id'])->attributes()->where("is_filterable", "=", "1")->get();
        $attrs = [];
        foreach ($attributes as $attr) {

            $attrs[$attr->id]['name'] = $attr->attr;
            $attrValues = $attr->attributeoptions()->get(['id', 'option_name']);
            foreach ($attrValues as $val) {
                $attrs[$attr->id]['options'][$val->id] = $val->option_name;
            }
        }
        //  dd($attrs);
        $action = route('admin.products.attributes.update');
        Session::flash("msg", "Product updated succesfully.");
        return view(Config('constants.adminProductView') . '.editProdVariant', compact('prod', 'action', 'attrs', 'attributes'));
    }

    public function getAllProds($prod_id = "") {
        $prods = Product::where('is_individual', '=', '1')
                ->where("id", "!=", $prod_id)
                ->orderBy("product", "asc")
                ->paginate(Config('constants.paginateNo'));
        return $prods;
    }

    public function update2() {
        foreach ($_POST as $key => $value) {
            if (is_int($key)) {
                DB::update(DB::raw("update " . DB::getTablePrefix() . "has_options set attr_val = '$value' where attr_id = $key and prod_id = " . Input::get('id')));
            }
        }
        $prd = Product::find(Input::get('id'));
        $prd->fill(Input::all())->save();
        if ($prd->prod_type != 3) {
            if (Input::get('stock_type') == 1 || Input::get('stock_type') == 0) {
                $stockUpdateHistory = new StockUpdateHistory;

                $stockUpdateHistory->user_id = Session::get('loggedinAdminId');
                $stockUpdateHistory->product_id = Input::get('id');

                if ($prd->is_stock == 1) {
                    $stockUpdateHistory->update_status = Input::get('stock_type');
                    $stockUpdateHistory->update_qty = Input::get('stock_update_qty');
                    $stockUpdateHistory->total_qty = Input::get('stock');
                }

                $stockUpdateHistory->save();
            }
            $pId = !empty(Input::get('parent_prod_id')) ? Input::get('parent_prod_id') : Input::get('id');
            $prod = Product::find($pId);
            $prods = $this->getAllProds($pId);
            $action = route('admin.products.upsell.related', ['id' => Input::get('pid')]);
            //Session::flash("message",".");
            return !empty(Input::get('close')) ? view(Config('constants.adminProductView') . '.close', compact('prod', 'prods', 'action')) : redirect()->route("admin.products.upsell.related", $pId);
        } else {
            Session::flash("msg", "Product updated succesfully.");
            return redirect()->route("admin.products.configurable.attributes", ['id' => $prd->id]);
        }
    }

    public function updateRelatedUpsellProds($prodId) {
        $prod = Product::find($prodId);
        //    $search = !empty(Input::get("relSearch")) ? Input::get("relSearch") : !empty(Input::get("relSearch")) ? Input::get("relSearch") : '';
        //  $search_fields = ['product', 'short_desc', 'long_desc'];
        $prods = Product::where('is_individual', '=', '1')
                ->where("id", "!=", $prod->id)
                ->orderBy("product", "asc");
        //   $prods = $prods->where(function($query) use($search_fields, $search) {
        //       foreach ($search_fields as $field) {
        //           $query->orWhere($field, "like", "%$search%");
        //       }
        //     });
        $relatedProd = Product::with('relatedproducts')->where('id', $prodId)->get();
        if (!empty(Input::get('product_name'))) {
            $prods = $prods->where('product', 'like', "%" . Input::get('product_name') . "%");
        }
        if (!empty(Input::get('product_code'))) {
            $prods = $prods->where('product_code', 'like', "%" . Input::get('product_code') . "%");
        }
        $prods = $prods->get();
        $action = route('admin.products.upsell');
        return view(Config('constants.adminProductView') . '.editRelUpsellProd', compact('prod', 'prods', 'action', 'relatedProd'));
    }

    public function updateUpsellProds($prodId) {
        $prod = Product::find($prodId);
        //    $search = !empty(Input::get("relSearch")) ? Input::get("relSearch") : !empty(Input::get("relSearch")) ? Input::get("relSearch") : '';
        //  $search_fields = ['product', 'short_desc', 'long_desc'];
        $prods = Product::where('is_individual', '=', '1')
                ->where("id", "!=", $prod->id)
                ->orderBy("product", "asc");
        $relatedProd = Product::with('upsellproducts')->where('id', $prodId)->get();
        if (!empty(Input::get('product_name'))) {
            $prods = $prods->where('product', 'like', "%" . Input::get('product_name') . "%");
        }
        if (!empty(Input::get('product_code'))) {
            $prods = $prods->where('product_code', 'like', "%" . Input::get('product_code') . "%");
        }

        $prods = $prods->get();
        $action = route('admin.products.upsell');
        //dd($action);
        return view(Config('constants.adminProductView') . '.editUpsellProduct', compact('prod', 'prods', 'action', 'relatedProd'));
    }

    public function ProductsUpsellRelatedSearch() {
        $name = Input::get("product");
        $prodId = Input::get("id");
        $relatedId = DB::table('has_upsell_prods')->where('prod_id', $prodId)->pluck("upsell_prod_id");
        if ($_GET['term'] != "") {
            $prods = Product::where('is_individual', '=', '1')->where('product', "like", '%' . $_GET['term'] . '%')->whereNotIn("id", $relatedId)->select("id", "product")->get();
            return $prods;
        } else {
            return '';
        }
        //  echo json_encode($prods);
    }

    public function ProductsRelatedSearch() {

        $prodId = Input::get("id");
        $relatedId = DB::table('has_related_prods')->where('prod_id', $prodId)->pluck("related_prod_id");

        if ($_GET['term'] != "") {
            $prods = Product::where('is_individual', '=', '1')->where('product', "like", '%' . $_GET['term'] . '%')->whereNotIn("id", $relatedId)->select("id", "product")->get();
            return $prods;
        } else {
            return '';
        }
    }

    public function relAttach() {
        $id = Input::get("id");
        $prod = Product::find(Input::get("id"));
        // dd(Input::get("prod_id"));
        $prod->relatedproducts()->attach(Input::get("prod_id"));

        return redirect()->back();
        //  return Helper::returnView($viewname, $data, $url = 'admin.products.upsell.related?id='.$id);
    }

    public function relDetach() {
        $id = Input::get("id");
        $prod = Product::find(Input::get("id"));

        $prod->relatedproducts()->detach(Input::get("prod_id"));
        return $prod;
        //redirect()->route("admin.products.upsell.related", ['id' => $id]);
    }

    public function upsellAttach() {
        $prod = Product::find(Input::get("id"));
        // dd(Input::get("prod_id"));
        $prod->upsellproducts()->attach(Input::get("prod_id"));
        return redirect()->back();
    }

    public function upsellDetach() {
        $prod = Product::find(Input::get("id"));
        $prod->upsellproducts()->detach(Input::get("prod_id"));
        return $prod;
        //  redirect()->route("admin.products.upsell.related", ['id' => $id]);
    }

    public function update3() {
        Session::flash("msg", "Product updated successfully.");
        $view = !empty(Input::get('return_url')) ? redirect()->to(Input::get('return_url')) : redirect()->route("admin.products.view");
        return $view;
    }
    //combo products

    public function comboProds($prodId) {
        $prod = Product::find($prodId);
        $catid = @$prod->categories()->first()->id;
        $cat = Category::find($catid);
        //   $search = !empty(Input::get("search")) ? Input::get("search") : '';
        //  $search_fields = ['product', 'short_desc', 'long_desc'];
        if (count($cat->descendants()->get()) <= 0) {
            $prods = $cat->products()
                            ->where("is_individual", 1)
                            ->where("products.id", "!=", $prodId)
                            ->get(['products.*'])->toArray();

//      $prods = Product::where('is_individual', '=', '1')
//                ->where("id", "!=", $prod->id)
//                ->where("is_crowd_funded", "=", 0)
//                ->orderBy("product", "asc");
//        $prods = $prods->where(function($query) use($search_fields, $search) {
//            foreach ($search_fields as $field) {
//                $query->orWhere($field, "like", "%$search%");
//            }
//        });
        } else {
//            die('bhavana123');
            $prods = [];
            foreach ($cat->descendantsAndSelf()->get() as $child) {
                foreach ($child->products()
                        ->where("is_individual", 1)
                        ->where("products.id", "!=", $prodId)
                        ->get(['products.*'])->toArray() as $course) {
                    array_push($prods, $course);
                }
            }
        }
        $perPage = 10;
        $pageStart = \Request::get('page', 1);
        // Start displaying items from this number;
        $offSet = ($pageStart * $perPage) - $perPage;
        // Get only the items you need using array_slice
        $itemsForCurrentPage = array_slice($prods, $offSet, $perPage, true);
        $prods = new LengthAwarePaginator($itemsForCurrentPage, count($prods), $perPage, Paginator::resolveCurrentPage(), array('path' => Paginator::resolveCurrentPath()));
        // $prods = $prods->paginate(Config('constants.paginateNo'));

        $action = route('admin.products.update.combo');
        return view(Config('constants.adminProductView') . '.edit4Prod', compact('prod', 'prods', 'action'));
    }

    public function update5() {
        $prod = Product::find(Input::get("id"));
        if (!empty(Input::get('combo_prods')))
            $prod->comboproducts()->sync(Input::get('combo_prods'));
        else
            $prod->comboproducts()->detach();

        $attrs = AttributeSet::find($prod->attributeset['id'])->attributes->toArray();

        if (!empty(Input::get('return_url'))) {
            $nextView = redirect()->to(Input::get('return_url'));
        } else {
            // if (empty($attrs)) {
            $nextView = redirect()->route("admin.products.upsell.related", $prod->id);
            //  } else {
            //     $nextView = redirect()->route("admin.products.updateProdAttr", $prod->id);
            // }
        }
        return $nextView;
    }

    public function comboAttach() {
        $prod = Product::find(Input::get("id"));
        $prod->comboproducts()->attach(Input::get("prod_id"));
    }

    public function comboDetach() {
        $prod = Product::find(Input::get("id"));
        $prod->comboproducts()->detach(Input::get("prod_id"));
    }
    //attr
    public function prodAttrs($prodId) {
        $prod = Product::find($prodId);
        $attrs = AttributeSet::find($prod->attributeset['id'])->attributes->toArray();
        $action = route('update2Prod');
        return view(Config('constants.adminProductView') . '.edit2Prod', compact('prod', 'action', 'attrs'));
    }

    public function duplicate_prod() {
        $prodId = Input::get('id');
        //save products basic fields
        $prods = Product::where('id', '=', $prodId)->get()->toArray();
        $cats = [];
        $cats_prod = Product::find($prods[0]['id'])->categories()->get();
        //   $catalogImages = [];
        $catalogImages = Product::find($prods[0]['id'])->catalogimgs()->get();
        //   dd($catalogImages);
        unset($prods[0]['id'], $prods[0]['created_at'], $prods[0]['updated_at']);
        $prods[0]['product'] = "duplicate-" . $prods[0]['product'];
        $prods[0]['url_key'] = "duplicate-" . $prods[0]['url_key'];
        $saveDupProd = Product::create($prods[0]);
        //sync categories
        $saveDupProd->categories()->sync($cats_prod);
        //sync images
        foreach ($catalogImages as $catImg) {
            $saveImg = new CatalogImage();
            $saveImg->filename = $catImg->filename;
            $saveImg->alt_text = $catImg->alt_text;
            $saveImg->image_mode = $catImg->image_mode;
            $saveImg->sort_order = $catImg->sort_order;
            $saveImg->catalog_id = $saveDupProd->id;
            $saveImg->save();
        }
        //  $saveDupProd->catalogimgs()->sync($catalogImages);
        //varients prods of products
        $chkProdVar = Product::where('parent_prod_id', '=', $prodId)->get()->toArray();
        $prods_varients = [];
        if (!empty($chkProdVar)) {
            foreach ($chkProdVar as $prodVar) {
                unset($prodVar['id'], $prodVar['created_at'], $prodVar['updated_at']);
                $prodVar['product'] = "duplicate-" . $prodVar['product'];
                $prodVar['parent_prod_id'] = $saveDupProd->id;
                array_push($prods_varients, $prodVar);
            }
        }
        foreach ($prods_varients as $prod_var) {
            $saveDupProdVar = Product::create($prod_var);
            $attributes = AttributeSet::find($saveDupProdVar->attributeset['id'])->attributes;
            $saveDupProdVar->attributes()->sync($attributes);
            //    DB::update(DB::raw("update ".DB::getTablePrefix()."has_options set attr_val = '$opt' where attr_id = $op and prod_id = " . $newConfigProduct->id));
        }
        Session::flash("successDupProd", "Duplicate Product created successfully");
        return redirect()->route("admin.products.view");
    }

    public function fabrics() {
        $prod = Product::find(Input::get('id'));
        $brand = \App\Library\Helper::getBrand($prod);
        // dd($brand);
        $finish = Finish::where('brand', $brand)->with('fabrics')->get();
        $action = 'admin.products.updatefabrics';
        return view(Config('constants.adminProductView') . '.fabrics', compact('finish', 'prod', 'action'));
    }

    public function updateFabrics() {
        $prod = Product::find(Input::get('id'));

        if (!empty(Input::get('fab'))) {
            $prod->fabrics()->sync(Input::get('fab'));
        } else {
            @$prod->fabrics()->detach();
        }

        if (!empty(Input::get('return_url'))) {
            $nextView = redirect()->to(Input::get('return_url'));
        } else {
            $nextView = redirect()->route("admin.products.ConfigProdAttrs", $prod->id);
        }
        return $nextView;
    }

    public function comm_prod_details() {
        $allProdDetails = HasProducts::where("has_products.id", "=", Input::get('prodid'))
                ->leftJoin("orders", "orders.id", "=", "has_products.order_id")
                ->leftJoin("prod_status", "prod_status.id", "=", "has_products.status")
                ->leftJoin("products", "products.id", "=", "has_products.prod_id")
                ->leftJoin("fabrics", "fabrics.id", "=", "has_products.finish_id")
                ->leftJoin("consignments", "consignments.id", "=", "has_products.consignment_id")
                ->leftJoin("proforma_invoices", "proforma_invoices.id", "=", "has_products.proforma_invoice_id")
                ->first(['has_products.*', 'orders.project_name', 'fabrics.fabric', 'products.product', 'prod_status.prod_status', 'products.product_code', 'proforma_invoices.invoice_no', 'consignments.consignment_no']);

        return $allProdDetails;
    }

    public function delete() {

        //  return redirect()->back()->with('message', 'You cannot delete this product.');

        $count = HasProducts::where("prod_id", Input::get('id'))->count();
        if ($count <= 0) {
            $prod = Product::find(Input::get('id'));
            if ($prod->categories()->count() >= 1) {
                @$prod->categories()->detach();
            }
            if ($prod->attributes()->count() >= 1) {
                @$prod->attributes()->detach();
            }
            if ($prod->relatedproducts()->count() >= 1) {
                @$prod->relatedproducts()->detach();
            }
            if ($prod->upsellproducts()->count() >= 1) {
                @$prod->upsellproducts()->detach();
            }
            if ($prod->comboproducts()->count() >= 1) {
                @$prod->comboproducts()->detach();
            }
            if ($prod->catalogimgs()->count() >= 2) {
                $prod->catalogimgs()->delete();
            }
            if ($prod->savedlist()->count() >= 1) {
                @$prod->savedlist()->detach();
            }
            $prod->delete();
            return redirect()->back()->with('message', 'Product deleted successfully.');
        } else {
            return redirect()->back()->with('message', 'Sorry this product is part of some configuration.');
        }
    }

    public function bulkDelete($id) {
        $count = HasProducts::where("prod_id", $id)->count();
        if ($count <= 0) {
            $prod = Product::find($id);
            if ($prod->categories()->count() >= 1) {
                @$prod->categories()->detach();
            }
            if ($prod->attributes()->count() >= 1) {
                @$prod->attributes()->detach();
            }
            if ($prod->relatedproducts()->count() >= 1) {
                @$prod->relatedproducts()->detach();
            }
            if ($prod->upsellproducts()->count() >= 1) {
                @$prod->upsellproducts()->detach();
            }
            if ($prod->comboproducts()->count() >= 1) {
                @$prod->comboproducts()->detach();
            }
            if ($prod->catalogimgs()->count() >= 2) {
                $prod->catalogimgs()->delete();
            }
            if ($prod->savedlist()->count() >= 1) {
                @$prod->savedlist()->detach();
            }
            $prod->delete();
            return 0;
        } else {
            return $id;
        }
    }

    public function changeStatus() {
        $prod = Product::find(Input::get('id'));
        if ($prod->status == 1) {
            $prodStatus = 0;
            $msg = "Product disabled successfully.";
            $prod->status = $prodStatus;
            $prod->update();
            Session::flash("message", $msg);

            return redirect()->back()->with('message', $msg);
            // $data = ['status' => '1', 'msg' => $msg];
            // $viewname = Config('constants.adminProductView') . '.index';
            // return Helper::returnView($viewname, $data, $url = 'admin.products.view');
        } else if ($prod->status == 0) {
            $prodStatus = 1;
            $msg = "Product  enabled successfully.";
            $prod->status = $prodStatus;
            $prod->update();
            Session::flash("msg", $msg);
            return redirect()->back()->with('msg', $msg);
            // Session::flash("msg", $msg);
            // $data = ['status' => '1', 'msg' => $msg];
            // $viewname = Config('constants.adminProductView') . '.index';
            // return Helper::returnView($viewname, $data, $url = 'admin.products.view');
        }
    }

    public function deleteVarient() {
        //  return redirect()->back()->with('message', 'You cannot delete this product.');
        $count = HasProducts::where("sub_prod_id", Input::get('id'))->count();
        if ($count <= 0) {
            $prod = Product::find(Input::get('id'));

            if ($prod->attributes()->count() >= 1) {
                @$prod->attributes()->detach();
            }
//            if ($prod->catalogimgs()->count() >= 2) {
//                $prod->catalogimgs()->delete();
//            }
//            if ($prod->savedlist()->count() >= 1) {
//                @$prod->savedlist()->detach();
//            }
            $prod->delete();
            return redirect()->back()->with('message', 'Product deleted successfully.');
        } else {
            return redirect()->back()->with('message', 'Sorry, this product is part of a project. Delete the project first.');
        }
    }

    public function configProdAttrsWithoutStock($prodId) {
        $prod = Product::find($prodId);
        $attributes = AttributeSet::find($prod->attributeset['id'])->attributes()->get();
        $attrs = [];
        foreach ($attributes as $attr) {
            $attrs[$attr->id]['name'] = $attr->attr;
            $attrValues = $attr->attributeoptions()->get(['id', 'option_name']);
            foreach ($attrValues as $val) {
                $attrs[$attr->id]['options'][$val->id] = $val->option_name;
            }
        }
        $prodVariants = Product::where("parent_prod_id", "=", $prod->id)->get();
        $action = route('admin.products.configurable.update.without.stock');
        return view(Config('constants.adminProductView') . '.editCProdWithoutStock', compact('prod', 'action', 'attrs', 'prodVariants'));
    }

    public function prodSeo() {
        $prod = Product::find(Input::get('id'));
        $action = route('admin.products.prodSaveSeo');
        return view(Config('constants.adminProductView') . '.prod_seo', compact('prod', 'action'));
    }

    public function prodSaveSeo() {
        $saveS = Product::findOrNew(Input::get('id'));
        $saveS->meta_title = Input::get("meta_title");
        $saveS->meta_keys = Input::get("meta_keys");
        $saveS->meta_desc = Input::get("meta_desc");
        $saveS->meta_robot = Input::get("meta_robot");
        $saveS->canonical = Input::get("canonical");
        $saveS->og_title = Input::get("og_title");
        $saveS->og_desc = Input::get("og_desc");
        $saveS->og_image = Input::get("og_image");
        $saveS->og_url = Input::get("og_url");
        $saveS->twitter_url = Input::get("twitter_url");
        $saveS->twitter_title = Input::get("twitter_title");
        $saveS->twitter_desc = Input::get("twitter_desc");
        $saveS->twitter_image = Input::get("twitter_image");
        $saveS->other_meta = Input::get("other_meta");
        $saveS->save();
        Session::flash("msg", "Product updated successfully.");
        return redirect()->to(Input::get('return_url'));
    }

    public function prodUpload() {
        $prod = Product::find(Input::get('id'));
        $action = route('admin.products.prodSaveUpload');
        return view(Config('constants.adminProductView') . '.upload_prod', compact('prod', 'action'));
    }

    public function prodSaveUpload() {
        foreach (Input::file('image_d') as $imgK => $imgV) {
            if ($imgV != null) {
                $destinationPath = Config('constants.productUploadImgPath') . "/";
                $fileName = "d-" . $imgK . date("YmdHis") . "." . $imgV->getClientOriginalName();
                $upload_success = $imgV->move($destinationPath, $fileName);
            } else {
                $fileName = null;
            }
            $saveCImh = DownlodableProd::findorNew(Input::get('id_img')[$imgK]);
            $saveCImh->image_d = is_null($fileName) ? $saveCImh->image_d : $fileName;
            $saveCImh->alt_text = Input::get('alt_text')[$imgK];
            $saveCImh->prod_id = Input::get('id');
            $saveCImh->sort_order_d = Input::get('sort_order_d')[$imgK];
            $saveCImh->save();
        }
        //Session::flash("msg","Product updated succesfully.");
        return redirect()->to(Input::get('return_url'));
    }

    public function prodUploadDel() {

        $id = Input::get('imgId');

        DownlodableProd::find($id)->delete();
        // echo "Deleted Successfully";

        Session::flash("delDownloadableProd", "Deleted Successfully.");
    }

    public function sampleBulkDownload() {
        $details = [];
        $arr = ['id', 'product', 'prod_type', 'images', 'attr_set', 'is_avail', 'is_listing', 'stock', 'price', 'spl_price', 'sort_order', 'is_cod', 'url_key', 'short_desc', 'long_desc', 'add_desc', 'meta_title', 'meta_keys', 'meta_desc', 'meta_robot', 'canonical', 'og_title', 'og_desc', 'og_image', 'twitter_url', 'twitter_title', 'twitter_desc', 'twitter_image', 'og_url', 'is_shipped_international', 'is_referal_discount', 'tags', 'categories', 'related', 'upsell'];
        $products = Product::where("is_individual", 1)->get(['id', 'product', 'prod_type', 'attr_set', 'is_avail', 'is_listing', 'stock', 'price', 'spl_price', 'sort_order', 'is_cod', 'url_key', 'short_desc', 'long_desc', 'add_desc', 'meta_title', 'meta_keys', 'meta_desc', 'meta_robot', 'canonical', 'og_title', 'og_desc', 'og_image', 'twitter_url', 'twitter_title', 'twitter_desc', 'twitter_image', 'og_url', 'is_shipped_international', 'is_referal_discount']);
        $sampleProds = [];
        array_push($sampleProds, $arr);
        $arrP = [];
        $i = 0;
        foreach ($products as $prodt) {
            $catids = [];
            $colors = '';
            $catName = '';
            if (!empty($prodt->categories()->get(['cat_id'])->toArray())) {
                foreach ($prodt->categories()->get(['cat_id']) as $catid) {
                    $catName = Category::select('category')->where('id', $catid->cat_id)->first();
                    array_push($catids, $catName->category);
                }
                $cats = implode(",", $catids);
            } else {
                $cats = "";
            }

            if (!empty($prodt->tagNames()))
                $tags = implode(",", $prodt->tagNames());
            else
                $tags = "";
            $rel = [];
            if (!empty($prodt->relatedproducts()->get(['prod_id'])->toArray())) {
                foreach ($prodt->relatedproducts()->get(['prod_id']) as $relids) {
                    array_push($rel, $relids->prod_id);
                }
                $relProds = implode(",", $rel);
            } else {
                $relProds = "";
            }
            $upsel = [];
            if (!empty($prodt->upsellproducts()->get(['prod_id'])->toArray())) {
                foreach ($prodt->upsellproducts()->get(['prod_id']) as $upids) {
                    array_push($upsel, $upids->prod_id);
                }
                $upProds = implode(",", $upsel);
            } else {
                $upProds = "";
            }
            $imgs = [];
            if (!empty($prodt->catalogimgs()->get()->toArray())) {
                foreach ($prodt->catalogimgs()->get() as $prdimg) {
                    array_push($imgs, $prdimg->filename);
                }

                $allimgs = implode(",", $imgs);
            } else {
                $allimgs = "";
            }
            $details = [
                $prodt->id,
                $prodt->product,
                $prodt->prod_type,
                $allimgs,
                $prodt->attr_set,
                $prodt->is_avail,
                $prodt->is_listing,
                $prodt->stock,
                $prodt->price,
                $prodt->spl_price,
                $prodt->sort_order,
                $prodt->is_cod,
                $prodt->url_key,
                $prodt->short_desc,
                $prodt->long_desc,
                $prodt->add_desc,
                $prodt->meta_title,
                $prodt->meta_keys,
                $prodt->meta_desc,
                $prodt->meta_robot,
                $prodt->canonical,
                $prodt->og_title,
                $prodt->og_desc,
                $prodt->og_image,
                $prodt->twitter_url,
                $prodt->twitter_title,
                $prodt->twitter_desc,
                $prodt->twitter_image,
                $prodt->og_url,
                $prodt->is_shipped_international,
                $prodt->is_referal_discount,
                @$tags,
                @$cats,
                @$relProds,
                @$upProds
            ];
            array_push($sampleProds, $details);
        }
        return Helper::getCsv($sampleProds, 'products_data.csv', ',');
    }

    public function productBulkUpload() {

        if (Input::hasFile('file')) {

            $file = Input::file('file');
            $name = time() . '-' . $file->getClientOriginalName();

            // $path = public_path() . '/theSoul/uploads/pincodes/';
            $path = public_path() . '/public/Admin/uploads/products/';

            $file->move($path, $name);

            return $this->product_import_csv($path, $name);
        } else {

            echo "Please select file";
        }
    }

    private function product_import_csv($path, $filename) {
        $arr = ['id', 'product', 'prod_type', 'images', 'attr_set', 'is_avail', 'is_listing', 'stock', 'price', 'spl_price', 'sort_order', 'is_cod', 'url_key', 'short_desc', 'long_desc', 'add_desc', 'meta_title', 'meta_keys', 'meta_desc', 'meta_robot', 'canonical', 'og_title', 'og_desc', 'og_image', 'twitter_url', 'twitter_title', 'twitter_desc', 'twitter_image', 'og_url', 'is_shipped_international', 'is_referal_discount', 'tags', 'categories', 'related', 'upsell'];
        $csv_file = $path . $filename;
        if (($handle = fopen($csv_file, "r")) !== FALSE) {
            $intersect = array_intersect($arr, fgetcsv($handle));
            if (count($arr) != count($intersect)) {
                echo "Column miss match plaese check your Excel sheet";
                exit;
            }

            $row_id = 1;
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $num = count($data);
                for ($c = 0; $c < $num; $c++) {
                    $col[$c] = $data[$c];
                }
                $id = $col[0];
                $product = $col[1];
                $prodT = $col[2];
                $prdimgs = $col[3];
                $attr_set = $col[4];
                $is_avail = $col[5];
                $is_listing = $col[6];
                $stock = $col[7];
                $price = $col[8];
                $spl_price = $col[9];
                $sort_order = $col[10];
                $is_cod = $col[11];
                $url_key = $col[12];
                $short_desc = $col[13];
                $long_desc = $col[14];
                $add_desc = $col[15];
                $meta_title = $col[16];
                $meta_key = $col[17];
                $meta_desc = $col[18];
                $meta_robot = $col[19];
                $canonical = $col[20];
                $og_title = $col[21];
                $og_desc = $col[22];
                $og_image = $col[23];
                $twitter_url = $col[24];
                $twitter_title = $col[25];
                $twitter_desc = $col[26];
                $twitter_image = $col[27];
                $og_url = $col[28];
                $is_shipped_inter = $col[29];
                $is_referal_discount = $col[30];
                $tags = $col[31];
                $categories = $col[32];
                $related = $col[33];
                $upsell = $col[34];
                if (!empty($id)) {



                    $updateProd = Product::firstOrNew(array('id' => $id));

                    if (!empty($product))
                        $updateProd->product = $product;


                    if (!empty($prodT)) {
                        if (is_numeric($prodT)) {
                            $prodtype_id = ProductType::whereIn('id', [1, 2, 3])->pluck("id")->toArray();
                            // dd($prodtype_id);
                            if (in_array($prodT, $prodtype_id)) {
                                $updateProd->prod_type = $prodT;
                            } else {
                                Session::flash("message", "Product type " . $prodT . " not allowed for product Name " . $product . " and row id " . $row_id);
                                return redirect()->back();
                            }
                        } else {
                            Session::flash("message", "Product type must be a Integer value for product Name " . $product . " and row id " . $row_id);
                            return redirect()->back();
                        }
                    }



                    if (!empty($is_avail))
                        $updateProd->is_avail = $is_avail;


                    if (!empty($is_listing))
                        $updateProd->is_listing = $is_listing;


                    if (!empty($stock))
                        $updateProd->stock = $stock;


                    if (!empty($price))
                        $updateProd->price = $price;

                    if ($spl_price > 0 && $spl_price < $price) {
                        $selling_price = $spl_price;
                    } else {
                        $selling_price = $price;
                    }

                    if (!empty($spl_price))
                        $updateProd->spl_price = $spl_price;

                    if (!empty($selling_price))
                        $updateProd->selling_price = $selling_price;

                    if (!empty($sort_order))
                        $updateProd->sort_order = $sort_order;


                    if (!empty($attr_set)) {
                        if (is_numeric($attr_set)) {
                            
                        } else {
                            Session::flash("message", "Product Attibute set  must be a Integer value for product Name " . $product . " in " . $row_id . " product record.");
                            return redirect()->back();
                        }
                    }


                    if (!empty($is_cod))
                        $updateProd->is_cod = $is_cod;


                    if (!empty($url_key))
                        $updateProd->url_key = $url_key;


                    if (!empty($short_desc))
                        $updateProd->short_desc = $short_desc;


                    if (!empty($long_desc))
                        $updateProd->long_desc = $long_desc;


                    if (!empty($add_desc))
                        $updateProd->add_desc = $add_desc;

                    if (!empty($meta_title))
                        $updateProd->meta_title = $meta_title;

                    $updateProd->is_individual = 1;

                    if (!empty($meta_key))
                        $updateProd->meta_keys = $meta_key;


                    if (!empty($meta_desc))
                        $updateProd->meta_desc = $meta_desc;

                    if (!empty($meta_robot))
                        $updateProd->meta_robot = $meta_robot;

                    if (!empty($canonical))
                        $updateProd->canonical = $canonical;

                    if (!empty($og_title))
                        $updateProd->og_title = $og_title;

                    if (!empty($og_desc))
                        $updateProd->og_desc = $og_desc;

                    if (!empty($og_image))
                        $updateProd->og_image = $og_image;

                    if (!empty($twitter_url))
                        $updateProd->twitter_url = $twitter_url;

                    if (!empty($twitter_title))
                        $updateProd->twitter_title = $twitter_title;

                    if (!empty($twitter_desc))
                        $updateProd->twitter_desc = $twitter_desc;

                    if (!empty($twitter_image))
                        $updateProd->twitter_image = $twitter_image;

                    if (!empty($og_url))
                        $updateProd->og_url = $og_url;


                    if (!empty($is_shipped_inter))
                        $updateProd->is_shipped_international = $is_shipped_inter;


                    if (!empty($is_referal_discount))
                        $updateProd->is_referal_discount = $is_referal_discount;


                    $updateProd->save();

                    if ($id == 'NULL' || $id == 'null') {
                        $updateProd->attr_set = $attr_set;
                        $updateProd->save();

                        if ($updateProd->prod_type != 3) {
                            if ($updateProd->prod_type == 1) {
                                if ($attr_set != 1) {
                                    Session::flash("message", "Variant set value " . $attr_set . " not allowd for product Name " . $product . " in " . $row_id . " product record");
                                    $updateProd->delete();

                                    return redirect()->back();
                                }
                            } else {
                                $attributes = AttributeSet::find($updateProd->attributeset['id'])->attributes;
                                if (count($attributes) == 0) {
                                    Session::flash("message", "There is no Attribute Found in database with id value " . $attr_set . " product Name " . $product . " in " . $row_id . " product record");
                                    $updateProd->delete();
                                    return redirect()->back();
                                }
                                if (!empty($attributes))
                                    $updateProd->attributes()->sync($attributes);
                                else
                                    $updateProd->attributes()->detach();
                            }
                        } else {
                            $chkAttr = AttributeSet::find($updateProd->attributeset['id']);
                            if ($chkAttr == null) {
                                Session::flash("message", "There is no Variant set found in database with id value " . $attr_set . " for product name " . $product . " in  " . $row_id . " product record.");
                                $updateProd->delete();
                                return redirect()->back();
                            } else {
                                $attributes = AttributeSet::find($updateProd->attributeset['id'])->attributes()->where('is_filterable', "=", "0")->get();
                                //  dd($attributes);
                                if (!empty($attributes)) {
                                    $updateProd->attributes()->sync($attributes);
                                } else {
                                    Session::flash("message", "There is no Attribute found in database with id value " . $attr_set . " for product name " . $product . " in " . $row_id . " product records.");
                                    $updateProd->delete();
                                    return redirect()->back();
                                }
                            }

//                            $attributes = AttributeSet::find($updateProd->attributeset['id'])->attributes()->where('is_filterable', "=", "0")->get();
//                            if (!empty($attributes))
//                                $updateProd->attributes()->sync($attributes);
                        }
                    }

                    $tagsArr = explode(",", $tags);


                    if (!empty($tags)) {
                        $updateProd->retag($tags);
                    }

                    $categoryids = explode(",", $categories);

                    if (!empty($categories)) {
                        foreach ($categoryids as $categoryid) {
                            $category = Category::where(DB::raw(strtolower('category')), $categoryid)->first();
                            if (count($category) > 0) {
                                $cat_id[] = $category->id;
                            } else {
                                Session::flash("message", "Given category " . $categoryid . " does not exist for product name " . $product . " in " . $row_id . " product record.");
                                $updateProd->delete();
                                return redirect()->back();
                            }
                        }
                        $updateProd->categories()->detach();
                        $updateProd->categories()->sync($categoryids);
                    } else {
                        Session::flash("message", "Category name can't be blank for product name " . $product . " in " . $row_id . " product record.");
                        $updateProd->delete();
                        return redirect()->back();
                    }
                    $relatedProdIds = explode(",", $related);

                    if (!empty($related)) {
                        $updateProd->relatedproducts()->detach();
                        $updateProd->relatedproducts()->attach($relatedProdIds);
                    }

                    $upsellProdIds = explode(",", $upsell);

                    if (!empty($upsell)) {
                        $updateProd->relatedproducts()->detach();
                        $updateProd->upsellproducts()->attach($upsellProdIds);
                    }

                    $prdimgsData = explode(",", $prdimgs);

                    if (!empty($prdimgsData)) {

                        $updateProd->catalogimgs()->delete();
                        $getimgs = [];

                        foreach ($prdimgsData as $fileNm) {
                            array_push($getimgs, new CatalogImage(array('filename' => $fileNm, 'image_type' => 1, 'image_mode', 1)));
                        }

                        $updateProd->catalogimgs()->saveMany($getimgs);
                    }
                } else {
                    Session::flash("message", "Plese Insert Product Id value NULL for product " . $product . "and row id " . $row_id);
                    //echo "Error being upload pincodes";
                    return redirect()->back();
                }
                $row_id++;
            }
            fclose($handle);
            Session::flash("msg", "Product uploaded successfully.");
            return redirect()->back();
        } else {
            echo "Error being upload pincodes";
        }
        // echo "File data successfully imported to database!!";
    }

    public function prdBulkImgUpload() {
        $path = '/public/Admin/uploads/catalog/products/';
        $upload_handler = new UploadHandler(null, true, null, $path);
    }

    function generateBarcode() {
        $id = Input::get('id');
        $rand = rand(10000, 20000);
        $pro = Product::find($id);
        $pro->barcode = $rand;
        $pro->save();
        echo json_encode(['id' => $id]);
    }

    function printBarcode() {
        if (Input::get('pt') == "var") { //FOR Varient level barcode generation
            $id = explode(',', Input::get('id'));
            echo Product::whereIn('id', $id)->select('id', 'product', 'barcode')->get();
        } else if (Input::get('pt') == "main") { //For all types
            $id = explode(',', Input::get('id'));
            $prod_12 = [];
            $prod_34 = [];
            foreach ($id as $d) {
                $j = explode('-', $d);
                if ($j[1] == 1 || $j[1] == 2) { //For simple and combo products
                    $prod_12[] = $j[0];
                } else if ($j[1] == 3 || $j[1] == 4) { //For sonfigurable and downloadable
                    $prod_34[] = $j[0];
                }
            }
            $r = array_column(Product::whereIn('parent_prod_id', $prod_34)->select('id')->get()->toArray(), 'id');
            //print_r($r);
            echo Product::whereIn('id', array_merge($prod_12, $r))->select('id', 'product', 'barcode')->get();
        }
    }

    function bulkUpdate() {
        // dd(Input::all());
        if (Input::get('productId')) {
            $ids = explode(',', Input::get('productId'));
            $pids = [];
            $nonDeleteIds = [];
            foreach ($ids as $id) {
                $pid = explode('-', $id);
                $product = Product::find($pid[0]);
                if (Input::get('type') == 'update_stock_status') {
                    $product->is_stock = Input::get('updated_value');
                }
                if (Input::get('type') == 'update_availability') {
                    $product->is_avail = Input::get('updated_value');
                }
                if (Input::get('type') == 'update_special_price') {
                    $specialPrice = @Input::get('prod_special_price');
                    $price = @Input::get("prod_price");
                    if (!is_numeric($specialPrice) || !is_numeric($price)):
                        return redirect()->route("admin.products.view")->with(array('message' => 'Error occured, invalid data entered.'));
                    endif;
                    $product->price = max($specialPrice, $price);
                    $product->spl_price = min($specialPrice, $price);
                }
                $product->update();
                if (Input::get('type') == 'export') {
                    array_push($pids, $pid[0]);
                }
                if (Input::get('type') == 'add_category') {
                    $product->categories()->attach(Input::get('updated_value'));
                }
                if (Input::get('type') == 'remove') {
                    $prodIds = $this->bulkDelete($id);
                    if ($prodIds != 0):
                        $nonDeleteIds[] = "\"" . $product->product . "\"";
                    endif;
                    //  $product->delete();
                }
            }
            if (Input::get('type') == 'remove') {
                if (count($nonDeleteIds) == 0):
                    return redirect()->route("admin.products.view")->with(array('msg' => 'Products removed successfully.'));
                else:
                    $string = implode(", ", $nonDeleteIds);
                    return redirect()->route("admin.products.view")->with(array('message' => "$string cannot be removed because it is part of some configurations."));
                endif;
            }
            return redirect()->route("admin.products.view")->with(array('msg' => 'Products updated successfully.'));
        }
        return redirect()->route("admin.products.view")->with(array('message' => 'Error occured, no product selected.'));
    }

    public function exportExcel() {
        if (Input::get('productId')) {
            $ids = explode(',', Input::get('productId'));
            $pids = [];
            foreach ($ids as $id) {
                $pid = explode('-', $id);
                array_push($pids, $pid[0]);
            }
            dd(Input::get('productId'));
            $products = Product::orderBy("id", "asc")->find($pids);
            Excel::create('products', function($excel) use($products) {
                $excel->sheet('Sheet 1', function($sheet) use($products) {
                    $arr = array();
                    foreach ($products as $product) {
                        $data = array($product->id, $product->product, $product->product_code, $product->is_stock ? 'Yes' : 'No', $product->url_key, $product->is_avail ? 'Yes' : 'No',
                            $product->status, $product->stock, $product->max_price, $product->min_price,
                            $product->price, $product->spl_price, $product->selling_price, $product->is_individual ? 'Yes' : 'No');
                        array_push($arr, $data);
                    }
                    $sheet->fromArray($arr, null, 'A1', false, false)->prependRow(array(
                        'Id', 'Product', 'Product Code', 'Is Stock', 'Url Key',
                        'Is Available', 'Status', 'Stock', 'Max Price', 'Min Price', 'Price', 'Special Price', 'Selling Price', 'Is Individual'
                            )
                    );
                });
            })->export('csv');
        } else {
            return redirect()->route("admin.products.view")->with(array('message' => 'Erro Occured! No Product Selected!'));
        }
    }

    public function exportWishlist() {
        $products = Product::where('is_individual', '=', '1')->where('prod_type', '<>', 6)->orderBy("id", "desc")->get();
        foreach ($products as $prod)
            if (count($prod->wishlist) > 0) {
                $dd[$prod->product] = $prod->wishlist;
            }
        $arr = ['FirstName', 'LastName', 'Email', 'Mobile', 'Products'];
        $sampleProds = [];
        array_push($sampleProds, $arr);
        foreach ($dd as $key => $d) {
            foreach ($d as $user) {
                $details = [
                    $user->firstname,
                    $user->lastname,
                    $user->email,
                    $user->telephone,
                    $key
                ];
            }
            array_push($sampleProds, $details);
        }

        return Helper::getCsv($sampleProds, 'products_wishlist.csv', ',');
    }

    function barcodeForm() {

        $html = '';

        $html = "<html><head>"
                . ""
                . "<style>"
                . ".wrappera {
   float: left;
    height: 100px;
    margin: 15px 10px 5px 55px;
    position: relative;
    width:auto;
}
.text{
  width: 100%;
  color:#000;
  margin:59px 7px 4px -19px;
  -webkit-transform: rotate(270deg);
          transform: rotate(270deg);
  -webkit-transform-origin: 0px 0px;
          transform-origin: 0px 0px;
          position: absolute;
}
.text2{
  width: 100%;
 color: #000;

    top:0px;
    left:200px;
    position: absolute;
  -webkit-transform: rotate(450deg);
          transform: rotate(450deg);
  -webkit-transform-origin: 0px 0px;
          transform-origin: 0px 0px;
    width: 100%;
}

.spa{
    position: absolute;
    top: -47px;
}
.spaa{
    position: absolute;
    top: -37px;
}
.image img{
  vertical-align:middle;
}"
                . "</style>"
                . "</head><body><table>";
        foreach (input::get('product') as $productId => $val) {
            if (!empty($val['barcode']) && $val['quantity'] > 0) {
                $barcode = $val['barcode'];
                $pid = $val['id'];
                // $html .= "<h5>$productId</h5><br>";
                $f = Product::where('id', $pid)->select('id', 'product', 'product_code', 'spl_price', 'selling_price')->get()->toArray()[0];
                $html .= '<tr>';
                $html .= "<td colspan='3'>$productId";
                $html .= "<br><br></td>";
                $html .= '</tr>';
                for ($i = 0; $i <= $val['quantity']; $i++) {
                    if ($i % 3 == 0) {
                        $html .= '<tr>';
                    }
                    $html .= "<td><div class='wrappera'>";
                    $html .= "<div class='text'>";
                    $html .= $f['product_code'];
                    $html .= "</div>";
                    $html .= "<div class=''>";
                    $html .= "<p class='spa'>" . substr($f['product'], 0, 20) . "...</p>";
                    $slp = $f['spl_price'];
                    $selling_price = $f['selling_price'];
                    $d = "<strike>$selling_price</strike>/" . $f['spl_price'];
                    if ($slp == 0.00 || $slp == $f['selling_price']) {
                        $d = $f['selling_price'];
                    }
                    $html .= "<p class='spaa'>price - $d</p>";
                    $html .= "</div>";
                    $html .= "<div class='image' style='width:100px'>";
                    $html .= "<img src='data:image/png;base64," . DNS1D::getBarcodePNG($barcode, 'C93', 1, 60, array(1, 0, 1)) . "'/>";
                    $html .= "</div>";
                    $html .= "<div class='text2'>";
                    $html .= substr($barcode, 0, 10);
                    $html .= "</div>";
                    $html .= "<div class='sap1'>";
                    $html .= Session::get('storeName');
                    $html .= "</div>";
                    $html .= "</div><td>";
                    if ($i % 3 == 3) {
                        $html .= '<tr>';
                    }
                }
            }
        }


        $html .= "</table></body></html>";
        $time = time();
        echo $path = public_path("temp/$time.pdf");
        $this->pdf->load($html)->filename($path)->output();
    }

    function downloadbarcode() {
        $url = input::get('url');
        return( Response::download($url) );
    }

    function showbarcodes() {


        $d = json_encode(['id' => '1234', 'name' => 'simple-tshirt', 'category' => ['cat1', 'cat2', 'cat3'], 'whouse' => 1]);
        echo '<img style="width:200px;height:200px" src="data:image/png;base64,' . DNS2D::getBarcodePNG("$d", "QRCODE", 6, 6, array(1, 1, 1)) . '" alt="barcode"   />';

        //   echo DNS2D::getBarcodePNGPath($d, "QRCODE");
        die;
        $html = "<style>"
                . ".wrapper {
   float: left;
    height: 100px;
    margin: 15px 10px 5px 55px;
    position: relative;
}
.text{
  width: 100%;
  color:#000;
  margin:107px 7px 4px -19px;
  -webkit-transform: rotate(270deg);
          transform: rotate(270deg);
  -webkit-transform-origin: 0px 0px;
          transform-origin: 0px 0px;
          position: absolute;
}
.text2{
 color: #000;
    margin: -62px 15px 9px 178px;
    padding: 0;
    position: absolute;
    transform: rotate(450deg);
    transform-origin: 0 0 0;
    width: 100%;
}

.spa{
    margin-bottom:-22px;
}
.spaa{
    margin-bottom:-2px;
}
.image img{
  vertical-align:middle;
}"
                . "</style>";
        $html .= "<div class='pixel'>";
        for ($i = 0; $i < 10; $i++) {

            $html .= "<div class='wrapper'>";
            $html .= "<div class='text'>";
            $html .= "pcode-12";
            $html .= "</div>";
            $html .= "<div class=''>";
            $html .= "<p class='spa'>pcode-12</p>";
            $html .= "<p class='spaa'>pcode-12</p>";
            $html .= "</div>";
            $html .= "<div class='image'>"; //C39
            $html .= "<img src='data:image/png;base64," . DNS1D::getBarcodePNG('123456we', 'C39', 1, 60, array(1, 0, 1)) . "'/>";
            $html .= "</div>";
            $html .= "<div class='text2'>";
            $html .= "12345678";
            $html .= "</div>";
            $html .= "<div class='sap1'>";
            $html .= Session::get('storeName');
            $html .= "</div>";
            $html .= "</div>";
        }
        echo $html .= "</div>";
    }

    //To check attributes against product wether exist or not
    public function checkAttribute() {

        $prod = Product::find(Input::get('prod_id'));
        $attr_set = $prod->attr_set;
        $attr = Attribute::where('attr', Input::get('attr'))->first();

        if (!empty($attr)) {
            $result = $attr->attributesets->contains($attr_set);
            if ($result) {
                return $data['msg'] = ['status' => 'success', 'msg' => 'Attribute name is already exist'];
            }
        }

        return 0;
    }

    public function productVendors($prodId) {

        $prod = Product::find($prodId);
        $vendors = $prod->hasVendors;
        $action = route('admin.products.upsell.related', ['id' => $prodId]);
        return view(Config('constants.adminProductView') . '.productVendors', compact('vendors', 'prod', 'action'));
    }

    public function ProductVendorsSearch() {

        $prodId = Input::get("id");
        // search all vendor
        if (is_null($prodId)) {
            $vendors = User::where('user_type', 3)->where(function($query) {
                        $query->where('firstname', "like", '%' . $_GET['term'] . '%');
                        $query->orwhere('lastname', "like", '%' . $_GET['term'] . '%');
                    })->get();
            return $vendors;
        }

        // search vendor associated with product       
        $vendorId = HasVendors::where('prod_id', $prodId)->where('status', 1)->pluck('vendor_id');
        if ($_GET['term'] != "") {
            $vendors = User::where('user_type', 3)->whereNotIn('id', $vendorId)->where(function($query) {
                        $query->where('firstname', "like", '%' . $_GET['term'] . '%');
                        $query->orwhere('lastname', "like", '%' . $_GET['term'] . '%');
                    })->get();

            return $vendors;
        } else {
            return '';
        }
    }

    public function ProductVendorsSave() {
        $prod_id = Input::get('id');
        $product = Product::find($prod_id);
        $vendor_ids = Input::get('vendor_id');
        $sort = Input::get('sort');
        $returnUrl = Input::get('returnUrl');
        $prod_vendor = array();
        $data = [];
        if (count($vendor_ids) > 0) {
            foreach ($vendor_ids as $key => $vendor_id) {
                $data['vendor_id'] = $vendor_id;
                ;
                $data['sort'] = $sort[$vendor_id];
                $data['status'] = 1;
                $prod_vendor[] = $data;
            }
            $product->vendors()->attach($prod_vendor);
        }
        // return redirect()->back();
        $nextView = redirect()->to($returnUrl);
        Session::flash("msg", "Product updated succesfully.");
        return $nextView;
    }

    public function ProductVendorsDelete() {
        $prod = Product::find(Input::get("id"));
        $prod->vendors()->detach(Input::get("vendor_id"));
        Session::flash("message", "Product vendor deleted succesfully.");
        return $prod;
    }

    public function getMallCategory() {
        $prod = MallProdCategory::where("status", 1)->where("is_nav", 1)->get(["id", "category"])->toArray();
        $roots = MallProdCategory::roots()->where("is_nav", 1)->where("status", 1)->get();
        $str = '';
        $str.= "<ul id='catTree' class='tree icheck '>";
        foreach ($roots as $root)
            $str.= $this->renderNode($root, $prod);
        $str.= "</ul>";
        return ['category' => $str, 'prod_cat' => $prod];
    }

    function renderNode($node, $prodCats) {
        $str = '';
        $str.= "<li class='tree-item fl_left ps_relative_li " . ($node->parent_id == '' ? 'parent' : '') . "'>";
        $style = (Helper::searchForKey("id", $node->id, $prodCats) ? 'checkbox-highlight' : '');
        $str.= '<div class="checkbox">
                                <label class=' . $style . ' class="i-checks checks-sm"><input type="checkbox"  name="category_id[]" value="' . $node->id . '"  ' . (Helper::searchForKey("id", $node->id, $prodCats) ? 'checked' : '') . '  /> <i></i>' . $node->category . '</label>
                              </div>';
        if ($node->adminChildren()->count() > 0) {
            $str.= "<ul class='fl_left treemap'>";
            foreach ($node->adminChildren as $child)
                $this->renderNode($child, $prodCats);
            $str.= "</ul>";
        }
        $str.= "</li>";
        return $str;
    }

    public function mallProductadd() {


        $jsonString = Helper::getSettings();
        $products = Product::find(Input::get("prodId"));
        $mallProd = MallProducts::where("store_prod_id", $products->id)->where("store_id", $jsonString['store_id'])->count();
        if ($mallProd > 0) {
            Session::put('message', "Product alredy exist on mall!");
            $data = ["status" => "0", "msg" => "Product alredy exist on mall!"];
        } else {
            $prod = Product::where("id", Input::get("prodId"))->get();
            $tableColumns = Schema::getColumnListing('products');
            $category = Input::get("categories");
            $this->saveProduct($prod, $jsonString, $tableColumns, $category, 1);
            if ($prod[0]->prod_type == 3) {
                $prodConfig = Product::where("parent_prod_id", Input::get("prodId"))->get();
                $this->saveProduct($prodConfig, $jsonString, $tableColumns);
            }

            $products->is_share_on_mall = 1;
            $products->save();
            Session::put('msg', "Product share on mall successfully");
            $data = ["status" => "1", "msg" => "product share on mall successfully", "prod" => $prod];
        }
        return $data;
    }

    public function saveProduct($product, $jsonString, $tableColumns, $category = null, $parent = null) {
        foreach ($product as $prod) {
            $prods = new MallProducts();
            $prods->store_id = $jsonString['store_id'];
            $prods->prefix = $jsonString['prefix'];
            $prods->store_prod_id = $prod->$tableColumns[0];
            for ($i = 1; $i < count($tableColumns); $i++) {
                $prods->$tableColumns[$i] = $prod->$tableColumns[$i];
            }
            $prods->save();
            if ($parent) {
                $prods->mallcategories()->sync($category);
            }
        }
    }

}
