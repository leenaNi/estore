<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Merchant;
use Config;
use DB;
use Input;
use Session;

class ApiCategoryController extends Controller
{
    public function index(){
        $marchantId = Session::get("merchantId");
        if($marchantId){
            $merchant = Merchant::find($marchantId)->getstores()->first();
            $store = DB::table('stores')->where('merchant_id',$marchantId)->first();
            
            $categories = DB::table('store_categories')
            ->join('categories as c','c.id','=','store_categories.category_id')
            ->where("c.status", '1')
            ->where("store_categories.store_id",$store->id)
            ->orderBy("c.id", "asc")
            ->select('store_categories.id','c.category')
            ->get();
            // $categories = DB::table('categories')->where("status", '1')->orderBy("id", "asc")->paginate(10);
            $prod_type = DB::table('product_types')->where("status", '1')->orderBy("id", "asc")->where("store_id",$store->id)->get(["id", "type"]);
            $attrS = DB::table('attribute_sets')->where('id', '!=', 1)->where('status', 1)->where("store_id",$store->id)->get(['id', 'attr_set']);
            $stockStatus = DB::table('general_setting')->where("url_key", 'stock')->first()->status;
            // foreach ($categories as $category) {
            //     $category->catImage = "http://" . $merchant->url_key . '.' . $_SERVER['HTTP_HOST'] . '/uploads/catalog/category/' . @DB::table('catalog_images')->where("image_type", 2)->where('catalog_id', $category->id)->latest()->first()->filename;
            // }
            $data = ['categories' => $categories, 'prod_type' => $prod_type, 'stockStatus' => $stockStatus, 'attribute' => $attrS];
            return response()->json(["status" => 1, 'data' => $data]);
        }else{
            return response()->json(["status" => 0, 'msg' => 'Session Expired.']);
        }
    }

    public function requestNewCategory(){
        $marchantId = Session::get("merchantId");
        $categoryName = Input::get('categoryName');
        $categoryId = filter_var(Input::get('categoryId'), FILTER_SANITIZE_STRING);
        if($categoryName != null && $categoryId != null){
            $cat = DB::table('store_categories')->find($categoryId);
            $parentId = $cat->category_id;
            $newCategory = DB::table('temp_categories')->insert([
                "name" => $categoryName,
                "parent_id" => $parentId, 
                "user_id" => $marchantId
            ]);
            if($newCategory){
                return response()->json(["status" => 1, 'msg' => 'New Category Request Send Successfully']);
            }else{
                return response()->json(["status" => 0, 'msg' => 'Something went wrong.']);
            }
        }else{
            return response()->json(["status" => 0, 'msg' => 'Mandatory fields are missing.']);
        }
        
    }
}
