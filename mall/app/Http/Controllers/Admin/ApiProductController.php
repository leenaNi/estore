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

class ApiProductController extends Controller {

    public function index() {
        $barcode = GeneralSetting::where('url_key', 'barcode')->get()->toArray()[0]['status'];
        $products = Product::with('categories.cat_tax')->where('is_individual', '=', '1')->where('status', '=', '1');
        $categoryA = Category::get(['id', 'category'])->toArray();
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
            $products = $products->where('price', '>=', Input::get('pricemin'));
        }
        if (!empty(Input::get('pricemax'))) {
            $products = $products->where('price', '<=', Input::get('pricemax'));
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

        $products = $products->sortable()->paginate(Config('constants.paginateNo'));
        foreach ($products as $prd) {
            $prd->prodImage = asset(Config('constants.productImgPath') . @$prd->catalogimgs()->where("image_mode", 1)->first()->filename);
        }
        //dd($products);

        return Helper::returnView(Config('constants.adminApiProductView') . '.index', compact('products', 'category', 'user', 'barcode'));
    }

    public function add() {
        $prod = new Product();
        $prod_types = [];
        $prodTy = ProductType::get(['id', 'type'])->toArray();
        foreach ($prodTy as $prodT) {
            $prod_types[$prodT['id']] = $prodT['type'];
        }

        $has_attr = DB::table('has_attributes')->select('attr_set')->groupBy('attr_set')->get();
        // $has_attr = DB::table('attribute_sets')->select('attr_set')->get();
        $attr_has = [];

        foreach ($has_attr as $ah) {
            $attr_has[] = $ah->attr_set;
        }

        $attr_sets = [];
        $attrS = AttributeSet::get(['id', 'attr_set'])->toArray();
        // dd($attrS);
        foreach ($attrS as $attr) {
            if (in_array($attr['id'], $attr_has)) {
                $attr_sets[$attr['id']] = $attr['attr_set'];
            }
        }
        $categories = Category::where("status", '1')->where('id', 1)->with('children')->orderBy("id", "asc")->get();
        $action = route("admin.apiprod.save");
        // return view(Config('constants.adminApiProductView') . '.add', compact('prod', 'prod_types', 'attr_sets', 'categories', 'action'));
        $data = ["action" => $action, 'prod' => $prod, 'prod_types' => $prod_types, 'attr_sets' => $attr_sets, 'categories' => $categories];
        // $url = "admin.apiprod.view";
        //return redirect()->route('admin.products.general.info', ['id' => $prod->id]);
        $viewname = Config('constants.adminApiProductView') . '.add';
        return Helper::returnView($viewname, $data);
    }

    public function save() {
        // dd(Input::all());
        //$prod = Product::create(Input::all());
        $prod = Product::findOrNew(Input::get('id'));
        $prod->is_individual = 1;
        $prod->is_avail = 1;
        $prod->product = Input::get('product');
        $prod->purchase_price = Input::get('purchase_price');
        $prod->price = Input::get('price');
        $prod->selling_price = Input::get('selling_price');
        $prod->stock = Input::get('stock');
        $prod->added_by = Input::get('added_by');
        //$prod->url_key = strtolower(str_replace(" ", "-", Input::get('product')));
        $prod->is_stock = 1;
        $prod->prod_type = 1;
        $prod->barcode = Input::get('barcode');
        $attributeSet = AttributeSet::where("attr_set", 'Default')->first();
        $prod->attr_set = $attributeSet->id;
        $prod->updated_by = Input::get('added_by'); //Session::get('loggedinAdminId');
        $prod->save();
        if ($prod->prod_type != 3) {
            $attributes = $attributeSet->attributes;
            if (!empty($attributes))
                $prod->attributes()->sync($attributes);
            else
                $prod->attributes()->detach();
        } else {
            $attributes = AttributeSet::find($prod->attributeset['id'])->attributes()->where('is_filterable', "=", "0")->get();
            if (!empty($attributes))
                $prod->attributes()->sync($attributes);
        }
        //ADD CATEGORIES
        if (!empty(Input::get('category_id')))
            $prod->categories()->sync(Input::get('category_id'));
        else
            $prod->categories()->detach();
        $product = Product::where('id', $prod->id)->with('categories.cat_tax')->first();
        $data = ["status" => 1, "msg" => "Product Added successfully.", 'prod' => $product];
        $url = "admin.apiprod.view";
        //return redirect()->route('admin.products.general.info', ['id' => $prod->id]);
        $viewname = Config('constants.adminApiProductView') . '.index';
        return Helper::returnView($viewname, $data, $url);
    }

    public function edit() {
        $prod_types = [];
        $prodTy = ProductType::get(['id', 'type'])->toArray();
        foreach ($prodTy as $prodT) {
            $prod_types[$prodT['id']] = $prodT['type'];
        }

        $has_attr = DB::table('has_attributes')->select('attr_set')->groupBy('attr_set')->get();
        // $has_attr = DB::table('attribute_sets')->select('attr_set')->get();
        $attr_has = [];

        foreach ($has_attr as $ah) {
            $attr_has[] = $ah->attr_set;
        }

        $attr_sets = [];
        $attrS = AttributeSet::get(['id', 'attr_set'])->toArray();
        // dd($attrS);
        foreach ($attrS as $attr) {
            if (in_array($attr['id'], $attr_has)) {
                $attr_sets[$attr['id']] = $attr['attr_set'];
            }
        }
        $categories = Category::where("status", '1')->where('id', 1)->with('children')->orderBy("id", "asc")->get();
        $prod = Product::find(Input::get('id'));
        $prod->category = Product::find(Input::get('id'))->categories()->get();

        $action = route("admin.apiprod.save");
        $data = ['prod' => $prod, 'prod_types' => $prod_types, 'attr_sets' => $attr_sets, 'categories' => $categories, 'action' => $action];
        //  return view(Config('constants.adminApiProductView') . '.add', compact('prod', 'prod_types', 'attr_sets', 'categories', 'action'));
        $viewname = Config('constants.adminApiProductView') . '.add';
        return Helper::returnView($viewname, $data);
    }

    public function delete() {
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

}
