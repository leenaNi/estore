<?php

namespace App\Http\Controllers\Admin\API\Sales;

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
            ->where("store_categories.parent_id", NULL)
            ->orderBy("c.id", "asc")
            ->select('store_categories.id','c.category')
            ->get();
            foreach($categories as $cat){
                $subcat = DB::table('store_categories')->where('parent_id',$cat->id)->get();
                $cat->has_sub_category = 0;
                if(count($subcat)>0){
                    $cat->has_sub_category = 1;
                }
            }
            // $categories = DB::table('categories')->where("status", '1')->orderBy("id", "asc")->paginate(10);
            $prod_type = DB::table('product_types')->where("status", '1')->orderBy("id", "asc")->where("store_id",$store->id)->get(["id", "type"]);
            $attrS = DB::table('attribute_sets')->where('id', '!=', 1)->where('status', 1)->where("store_id",$store->id)->get(['id', 'attr_set']);
            $stockStatus = DB::table('general_setting')->where("url_key", 'stock')->first()->status;
           
            $data = ['categories' => $categories];
            return response()->json(["status" => 1, 'data' => $categories]);
        }else{
            return response()->json(["status" => 0, 'msg' => 'Session Expired.']);
        }
    }

    public function mainCategories(){
        $countries = DB::table('categories')->orderBy("id", "desc")->get();

    }

    public function subCategory(){
        $cat_id = Input::get('categoryId');
        if($cat_id){
            $marchantId = Session::get("merchantId");
        $merchant = Merchant::find($marchantId)->getstores()->first();
            $store = DB::table('stores')->where('merchant_id',$marchantId)->first();
            
            $categories = DB::table('store_categories')
            ->join('categories as c','c.id','=','store_categories.category_id')
            ->where("c.status", '1')
            ->where("store_categories.store_id",$store->id)
            ->where("store_categories.parent_id", $cat_id)
            ->orderBy("c.id", "asc")
            ->select('store_categories.id','c.category')
            ->get();
            foreach($categories as $cat){
                $subcat = DB::table('store_categories')->where('parent_id',$cat->id)->get();
                $cat->has_sub_category = 0;
                if(count($subcat)>0){
                    $cat->has_sub_category = 1;
                }
            }
            $data = ['categories' => $categories];
            return response()->json(["status" => 1, 'data' => $categories]);
        }else{
            return response()->json(["status" => 0, 'msg' => 'Mandatory fields are missing.']);
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
