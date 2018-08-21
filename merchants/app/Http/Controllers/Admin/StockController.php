<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
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
use Response;
use App\Models\User;
use Session;
use App\Library\Helper;
use App\Classes\UploadHandler;
use Vsmoraes\Pdf\Pdf;
use Illuminate\Pagination\LengthAwarePaginator;
use DNS1D;
use DNS2D;

class StockController extends Controller {

    public function index(Request $request) {
       
      
        $barcode = GeneralSetting::where('url_key', 'barcode')->get()->toArray()[0]['status'];
        $products = Product::where('is_individual', '=', '1')->where("is_stock", 1)->where("prod_type", 1)->where("stock", '>', 0);
        $configProduct = Product::where('is_individual', '=', '1')->where("is_stock", 1)->where("prod_type", 3);
        $allProd = [];
        if (!empty(Input::get('product_name'))) {
            $products = $products->where('product', 'like', "%" . Input::get('product_name') . "%")->get();
            $configProduct = $configProduct->where('product', 'like', "%" . Input::get('product_name') . "%")->get();
            //  $productCount = $products->count();
        } else {
            $products = $products->get();
            $configProduct = $configProduct->get();
        }

        if (count($products) > 0) {
            foreach ($products as $prd) {
                $prd->prodImage =Config('constants.productImgPath') .'/'. @$prd->catalogimgs()->where("image_mode", 1)->first()->filename;
                $allProd[] = $prd;
            }
        }
        
        if (count($configProduct) > 0 && $this->feature['products-with-variants']) {
            foreach ($configProduct as $cprd) {
                $subprod = $cprd->getsubproducts()->get()->toArray();
                if (count($subprod) > 0) {
                    $cprd->subproduct = json_encode($subprod);
                    $cprd->prodImage =Config('constants.productImgPath') .'/'.@$cprd->catalogimgs()->where("image_mode", 1)->first()->filename;
                    $allProd[] = $cprd;
                }
            }
        }
        // return view(Config('constants.adminStockView') . '.index', compact('products', 'barcode'));
        $productCount = count($allProd);
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $itemCollection = collect($allProd);

        $perPage = Config('constants.paginateNo');
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
        $allproducts = new LengthAwarePaginator($currentPageItems, count($itemCollection), $perPage);
        $allproducts->setPath($request->url());
        $viewname = Config('constants.adminStockView') . '.index';
        $data = ['products' => $allproducts, 'barcode' => $barcode, 'productCount' => $productCount];
        return Helper::returnView($viewname, $data);
    }

    public function outOfStock(Request $request) {
        $barcode = GeneralSetting::where('url_key', 'barcode')->get()->toArray()[0]['status'];
        $products = Product::where('is_individual', '=', '1')->where("is_stock", 1)->where("prod_type", 1)->where("stock", 0);
        $configProduct = Product::where('is_individual', '=', '1')->where("is_stock", 1)->where("prod_type", 3);
        $allProd = [];
        if (!empty(Input::get('product_name'))) {
            $products = $products->where('product', 'like', "%" . Input::get('product_name') . "%")->get();
            $configProduct = $configProduct->where('product', 'like', "%" . Input::get('product_name') . "%")->get();
        } else {
            $products = $products->get();
            $configProduct = $configProduct->get();
        }

        if (count($products) > 0) {
            foreach ($products as $prd) {
                $prd->prodImage =Config('constants.productImgPath').'/'. @$prd->catalogimgs()->where("image_mode", 1)->first()->filename;
                $allProd[] = $prd;
            }
        }
        if (count($configProduct) > 0 && $this->feature['products-with-variants']) {
            foreach ($configProduct as $cprd) {
                $subprod = $cprd->subproductsoutofstock()->get()->toArray();
                if (count($subprod) > 0) {
                    $cprd->subproduct = json_encode($subprod);
                    $cprd->prodImage =Config('constants.productImgPath') .'/'. @$cprd->catalogimgs()->where("image_mode", 1)->first()->filename;
                    $allProd[] = $cprd;
                }
            }
        }
        $productCount = count($allProd);
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $itemCollection = collect($allProd);

        $perPage = Config('constants.paginateNo');
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
        $allproducts = new LengthAwarePaginator($currentPageItems, count($itemCollection), $perPage);
        $allproducts->setPath($request->url());
        $viewname = Config('constants.adminStockView') . '.out-of-stock';
        $data = ['products' => $allproducts, 'barcode' => $barcode, 'productCount' => $productCount];
        return Helper::returnView($viewname, $data);
    }

    public function runningShort(Request $request) {
        $getStockLimit = GeneralSetting::where('url_key', 'stock')->first();
        $stockLimitValue = json_decode($getStockLimit->details, TRUE);
        $barcode = GeneralSetting::where('url_key', 'barcode')->get()->toArray()[0]['status'];
        $products = Product::where('is_individual', '=', '1')->where("is_stock", 1)->where("prod_type", 1)->whereBetween('stock', ['1', $stockLimitValue['stocklimit']]);
        $configProduct = Product::where('is_individual', '=', '1')->where("is_stock", 1)->where("prod_type", 3);
        if (!empty(Input::get('product_name'))) {
            $products = $products->where('product', 'like', "%" . Input::get('product_name') . "%")->get();
            $configProduct = $configProduct->where('product', 'like', "%" . Input::get('product_name') . "%")->get();
        } else {
            $products = $products->get();
            $configProduct = $configProduct->get();
        }
        $allProd = [];

        //  $products = $products->whereBetween('stock', ['1', $stockLimitValue['stocklimit']])->sortable()->paginate(Config('constants.paginateNo'));
        // $productCount = $products->total();
        if (count($products) > 0) {
            foreach ($products as $prd) {
                $prd->prodImage = Config('constants.productImgPath') .'/'. @$prd->catalogimgs()->where("image_mode", 1)->first()->filename;
                $allProd[] = $prd;
            }
        }
        if (count($configProduct) > 0 && $this->feature['products-with-variants']) {
            foreach ($configProduct as $cprd) {
                $subprod = $cprd->subproductrunnigshort($stockLimitValue)->get()->toArray();
                if (count($subprod) > 0) {
                    $cprd->subproduct = json_encode($subprod);
                    $cprd->prodImage = Config('constants.productImgPath') .'/'. @$cprd->catalogimgs()->where("image_mode", 1)->first()->filename;
                    $allProd[] = $cprd;
                }
            }
        }
        $productCount = count($allProd);
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $itemCollection = collect($allProd);

        $perPage = Config('constants.paginateNo');
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
        $allproducts = new LengthAwarePaginator($currentPageItems, count($itemCollection), $perPage);
        $allproducts->setPath($request->url());

        //return view(Config('constants.adminStockView') . '.running-short', compact('products', 'barcode'));
        $viewname = Config('constants.adminStockView') . '.running-short';
        $data = ['products' => $allproducts, 'barcode' => $barcode, 'productCount' => $productCount];
        return Helper::returnView($viewname, $data);
    }

    public function updateProdStock() {
        // return Input::all();
        $prodId = Input::get('prod-id');
        $stock = Input::get('stock');
        foreach ($prodId as $key => $value) {
            $prodUp = Product::find($value);

            $prodUp->stock = ($prodUp->stock + $stock[$key]);

            $prodUp->update();
        }

        if ($prodUp->update()) {
            Session::flash('msg', 'Stock updated successfully.');
            return $data = ['status' => 'success', 'msg' => 'Stock updated succesfully'];
        } else {
            Session::flash('message', 'Oops something went wrong, Please try again later.');
            return $data = ['status' => 'error', 'msg' => 'Oops something went wrong, Please try again later!'];
        }
    }

    public function checkConfigStock($prodId) {
        $product = Product::find($prodId);
        //dd($product);
        $all = $product->subproducts()->count();
        $inStock = $product->getsubproducts()->count();
        if ($all > $inStock) {
            return $product->subproductsoutofstock()->get();
        }
    }

}
