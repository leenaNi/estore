<?php

namespace App\Http\Controllers\Admin\API\Sales;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Library\CustomValidator;
use App\Models\User;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Product;
use Config;
use DB;
use Input;
use Session;

class ApiCartController extends Controller
{
    public function getProductByBarcode()
    {
        $barcode = Input::get('barcode');
        if($barcode != ''){
        $productResult = DB::table('products as p')
                    ->leftJoin('brand as b', 'p.brand_id', '=', 'b.id')
                    ->where(['p.barcode' => $barcode])
                    ->select(['p.id', 'p.store_id', 'b.id as brand_id', 'b.name as brand_name', 'p.product', 'p.images', 'p.product_code', 'p.is_featured', 'p.prod_type', 'p.is_stock', 'p.is_avail', 'p.is_listing', 'p.status', 'p.stock', 'p.max_price', 'p.min_price', 'p.purchase_price', 'p.price', 'p.spl_price', 'p.selling_price', 'p.is_cod', 'p.is_tax', 'p.is_trending', 'p.min_order_quantity', 'p.is_share_on_mall', 'p.store_id','p.barcode','p.parent_prod_id'])->first();
        if($productResult != null){
            if($productResult->parent_prod_id == ''){
                $prod_id = $productResult->id;
            }else{
                $prod_id = $productResult->parent_prod_id;
            }
            $store = DB::table('stores')->where('id',$productResult->store_id)->first();
            //Get Product image
            $productImages = DB::table('catalog_images')
            ->select(DB::raw('filename'))
            ->where(['catalog_id' => $prod_id])
            ->get();
            $productImage = '';
        
            if (count($productImages) > 0) {
                $productImage = "http://" . $store->url_key . "." . $_SERVER['HTTP_HOST'] . "/uploads/catalog/products/" . $productImages[0]->filename;
            }
            $data = [];
            $storeId = $store->id;
            $data['store_id'] = $store->id;
            $data['store_name'] = $store->store_name;
            $data['product_id'] = $productResult->id;
            $data['brand_id'] = $productResult->brand_id;
            $data['brand_name'] = $productResult->brand_name;
            $data['product'] = $productResult->product;
            $data['images'] = $productImage;
            $data['product_code'] = $productResult->product_code;
            $data['is_featured'] = $productResult->is_featured;
            $data['prod_type'] = $productResult->prod_type;
            $data['is_stock'] = $productResult->is_stock;
            $data['is_avail'] = $productResult->is_avail;
            $data['is_listing'] = $productResult->is_listing;
            $data['status'] = $productResult->status;
            $data['stock'] = $productResult->stock;
            $data['max_price'] = $productResult->max_price;
            $data['min_price'] = $productResult->min_price;
            $data['purchase_price'] = $productResult->purchase_price;
            $data['price'] = $productResult->price;
            $data['spl_price'] = $productResult->spl_price;
            $data['selling_price'] = $productResult->selling_price;
            $data['is_cod'] = $productResult->is_cod;
            $data['is_tax'] = $productResult->is_tax;
            $data['is_trending'] = $productResult->is_trending;
            $data['barcode'] = $productResult->barcode;
            $data['min_order_quantity'] = $productResult->min_order_quantity;
            $data['is_share_on_mall'] = $productResult->is_share_on_mall;

            //get offers count
            //DB::enableQueryLog(); // Enable query log
            $offersIdCountResult = DB::table('offers')
                ->join('offers_products', 'offers.id', '=', 'offers_products.offer_id')
                ->select(DB::raw('count(offers.id) as offer_count'))
            //->where('offers.store_id',$storeId)
                ->where('offers.status',1)
                ->where('offers_products.prod_id',$productResult->id)
                ->where('offers_products.type', 1)
                //->groupBy('offers_products.offer_id')
                ->get();
            //dd(DB::getQueryLog()); // Show results of log

            $offerCount = 0;$totalOfferOfAllProduct=0;
            if (count($offersIdCountResult) > 0) {
                $offerCount = $offersIdCountResult[0]->offer_count;
                $totalOfferOfAllProduct = $totalOfferOfAllProduct + $offerCount;
            }
            
            $data['offers_count'] = $offerCount;
            if ($data) {
                return response()->json(["status" => 1, 'data' => $data]);
            } else {
                return response()->json(["status" => 2, 'msg' => 'Product not found']);
            }
        }else {
            return response()->json(["status" => 0, 'msg' => 'Invalid Barcode.']);
        }  
        } else {
            return response()->json(["status" => 0, 'msg' => 'Mandatory fields are missing.']);
        }
    } // End searchProductWithDistributor
}
