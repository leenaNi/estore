<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Route;
use Input;
use App\Models\Product;
use App\Models\HasProducts;
use App\Models\Merchant;
use App\Library\Helper;
use App\Classes\UploadHandler;
use App\Http\Controllers\Controller;
use Vsmoraes\Pdf\Pdf;
use DNS1D;
use DNS2D;
use DB;

class StockController extends Controller {

    public function index(Request $request) {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $barcode = DB::table($prifix . '_general_setting')->where('url_key', 'barcode')->first()->status;
        $varient = DB::table($prifix . '_general_setting')->where('url_key', 'products-with-variants')->first()->status;

        $products = DB::table($prifix . '_products')->where('is_individual', '=', '1')->where("is_stock", 1)->where("prod_type", 1)->where("stock", '>', 0);
        $configProduct =DB::table($prifix . '_products')->where('is_individual', '=', '1')->where("is_stock", 1)->where("prod_type", 3);
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
                $prd->prodImage = "http://" . $merchant->url_key . '.' . $_SERVER['HTTP_HOST'] . '/uploads/catalog/products/' . @DB::table($merchant->prefix . '_catalog_images')->where("image_mode", 1)->where('catalog_id', $prd->id)->first()->filename;
                $allProd[] = $prd;
            }
        }
        if (count($configProduct) > 0 && $varient) {
            foreach ($configProduct as $cprd) {
                $subprod = $this->checksubproduct($cprd->id, $prifix, 1);
                if (count($subprod) > 0) {
                    $cprd->subproduct = $subprod;
                    $cprd->prodImage = "http://" . $merchant->url_key . '.' . $_SERVER['HTTP_HOST'] . '/uploads/catalog/products/' . @DB::table($merchant->prefix . '_catalog_images')->where("image_mode", 1)->where('catalog_id', $cprd->id)->first()->filename;
                    $allProd[] = $cprd;
                }
            }
        }
        
        $productCount = count($allProd);
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $itemCollection = collect($allProd);

        $perPage =10;
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
        $allproducts = new LengthAwarePaginator($currentPageItems, count($itemCollection), $perPage);
        $allproducts->setPath($request->url());
        // return view(Config('constants.adminStockView') . '.index', compact('products', 'barcode'));

        $viewname = Config('constants.adminStockView') . '.index';
        $data = ['products' => $allproducts, 'barcode' => $barcode, 'productCount' => $productCount];
        return Helper::returnView($viewname, $data);
    }

    public function outOfStock(Request $request) {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $barcode = DB::table($prifix . '_general_setting')->where('url_key', 'barcode')->first()->status;
        $varient = DB::table($prifix . '_general_setting')->where('url_key', 'products-with-variants')->first()->status;
        $products = DB::table($prifix . '_products')->where('is_individual', '=', '1')->where("is_stock", 1)->where("prod_type", 1)->where("stock", '<=', 0);
        $configProduct = DB::table($prifix . '_products')->where('is_individual', '=', '1')->where("is_stock", 1)->where("prod_type", 3);
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
                $prd->prodImage = "http://" . $merchant->url_key . '.' . $_SERVER['HTTP_HOST'] . '/uploads/catalog/products/' . @DB::table($merchant->prefix . '_catalog_images')->where("image_mode", 1)->where('catalog_id', $prd->id)->first()->filename;
                $allProd[] = $prd;
            }
        }
        if (count($configProduct) > 0 && $varient) {
            foreach ($configProduct as $cprd) {
                $subprod = $this->checksubproduct($cprd->id, $prifix, 2);
                if (count($subprod) > 0) {
                    $cprd->subproduct = $subprod;
                    $cprd->prodImage = "http://" . $merchant->url_key . '.' . $_SERVER['HTTP_HOST'] . '/uploads/catalog/products/' . @DB::table($merchant->prefix . '_catalog_images')->where("image_mode", 1)->where('catalog_id', $cprd->id)->first()->filename;
                    $allProd[] = $cprd;
                }
            }
        }
        $productCount = count($allProd);
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $itemCollection = collect($allProd);

        $perPage = 10;
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
        $allproducts = new LengthAwarePaginator($currentPageItems, count($itemCollection), $perPage);
        $allproducts->setPath($request->url());
        // return view(Config('constants.adminStockView') . '.out-of-stock', compact('products', 'barcode'));
        $viewname = Config('constants.adminStockView') . '.out-of-stock';
        $data = ['products' => $allproducts, 'barcode' => $barcode, 'productCount' => $productCount];
        return Helper::returnView($viewname, $data);
    }

    public function runningShort(Request $request) {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $allProd = [];
        $getStockLimit = DB::table($prifix . '_general_setting')->where('url_key', 'stock')->first();
        $varient = DB::table($prifix . '_general_setting')->where('url_key', 'products-with-variants')->first()->status;
        $stockLimitValue = json_decode($getStockLimit->details, TRUE);
        $barcode = DB::table($prifix . '_general_setting')->where('url_key', 'barcode')->first()->status;
        $products = DB::table($prifix . '_products')->where('is_individual', '=', '1')->where("is_stock", 1)->where("prod_type", 1)->whereBetween('stock', ['1', $stockLimitValue['stocklimit']]);
        $configProduct = DB::table($prifix . '_products')->where('is_individual', '=', '1')->where("is_stock", 1)->where("prod_type", 3);
        if (!empty(Input::get('product_name'))) {
            $products = $products->where('product', 'like', "%" . Input::get('product_name') . "%")->get();
            $configProduct = $configProduct->where('product', 'like', "%" . Input::get('product_name') . "%")->get();
        }else{
             $products = $products->get();
             $configProduct = $configProduct->get();
        
        }
         if (count($products) > 0) {
            foreach ($products as $prd) {
                $prd->prodImage = "http://" . $merchant->url_key . '.' . $_SERVER['HTTP_HOST'] . '/uploads/catalog/products/' . @DB::table($merchant->prefix . '_catalog_images')->where("image_mode", 1)->where('catalog_id', $prd->id)->first()->filename;
                $allProd[] = $prd;
            }
        }
        if (count($configProduct) > 0 && $varient) {
            foreach ($configProduct as $cprd) {
                $subprod = $this->checksubproduct($cprd->id, $prifix, 3, $stockLimitValue);
                if (count($subprod) > 0) {
                    $cprd->subproduct = $subprod;
                    $cprd->prodImage = "http://" . $merchant->url_key . '.' . $_SERVER['HTTP_HOST'] . '/uploads/catalog/products/' . @DB::table($merchant->prefix . '_catalog_images')->where("image_mode", 1)->where('catalog_id', $cprd->id)->first()->filename;
                    $allProd[] = $cprd;
                }
            }
        }
        $productCount = count($allProd);
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $itemCollection = collect($allProd);
        $perPage = 10;
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();
        $allproducts = new LengthAwarePaginator($currentPageItems, count($itemCollection), $perPage);
        $allproducts->setPath($request->url());
        //return view(Config('constants.adminStockView') . '.running-short', compact('products', 'barcode'));
        $viewname = Config('constants.adminStockView') . '.running-short';
        $data = ['products' => $allproducts, 'barcode' => $barcode, 'productCount' => $productCount];
        return Helper::returnView($viewname, $data);
    }

    public function updateProdStock() {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $prodId = json_decode(Input::get('prodId'));
        foreach($prodId as $key=>$id){
         $oldStock = DB::table($prifix . '_products')->find($id)->stock;
        $stock = json_decode(Input::get('stock'),true)[$key];
        $stockData = ["stock" => $stock+$oldStock];
       $prodUp= DB::table($prifix . '_products')->where("id", $id)->update($stockData);
       
        }
        if ($prodUp) {
            return $data = ['status' => 'success', 'msg' => 'Stock updated succesfully'];
        } else {
            return $data = ['status' => 'error', 'msg' => 'Oops something went wrong, Please try again later!'];
        }
    }

    public function checksubproduct($id, $prifix, $type, $limit = null) {
        if ($type == 1) {
            $subprod = DB::table($prifix . '_products')->where("parent_prod_id", $id)->where('status', 1)->where("stock", ">", 0)->get();
        } else if ($type == 2) {
            $subprod = DB::table($prifix . '_products')->where("parent_prod_id", $id)->where('status', 1)->where("stock", "<=", 0)->get();
        } else if ($type == 3) {
            $subprod = DB::table($prifix . '_products')->where("parent_prod_id", $id)->where('status', 1)->whereBetween('stock', ['1', $limit])->get();
        }
        return $subprod;
    }

}
