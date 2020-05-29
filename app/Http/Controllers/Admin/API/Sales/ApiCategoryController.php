<?php

namespace App\Http\Controllers\Admin\API\Sales;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Merchant;
use App\Models\CategoryMaster;
use App\Models\CategoryRequested;
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
           
            return response()->json(["status" => 1, 'data' => $categories]);
        }else{
            return response()->json(["status" => 0, 'msg' => 'Session Expired.']);
        }
    }

    public function masterCategories(){
        $categories = CategoryMaster::whereIn("status", [1, 0])->where('parent_id',NULL)->select('id','category')->orderBy("id", "asc")->get();
        if(count($categories)>0){
            foreach($categories as $cat){
                $subcat = DB::table('categories')->where('parent_id',$cat->id)->get();
                $cat->has_sub_category = 0;
                if(count($subcat)>0){
                    $cat->has_sub_category = 1;
                }
            }
            return response()->json(["status" => 1, 'data' => $categories]);
        }else{
            return response()->json(["status" => 0, 'msg' => 'No Categories Found']);
        }
        
        //$categories = $categories->paginate(Config('constants.paginateNo'));
        //$roots = CategoryMaster::roots()->get();
        
    }

    public function masterSubCategory(){
        $cat_id = Input::get('categoryId');
        if($cat_id){
            $categories = CategoryMaster::whereIn("status", [1, 0])->where('parent_id',$cat_id)->select('id','category')->orderBy("id", "asc")->get();
            foreach($categories as $cat){
                $subcat = DB::table('categories')->where('parent_id',$cat->id)->get();
                $cat->has_sub_category = 0;
                if(count($subcat)>0){
                    $cat->has_sub_category = 1;
                }
            }
            return response()->json(["status" => 1, 'data' => $categories]);
        }else{
            return response()->json(["status" => 0, 'msg' => 'No Categories Found']);
        }
    }

    public function addMasterCategory(){
        $cat_id = Input::get('categoryId');
        if($cat_id){
            $category = DB::table('categories')->where('id',$cat_id)->first();
            $url_key = $category->url_key;
            $parent_id = $category->parent_id;

            $marchantId = Session::get("merchantId");
            //$merchant = Merchant::find($marchantId)->getstores()->first();
            $storeId = DB::table('stores')->where('merchant_id',$marchantId)->pluck('id');

            $cat_exists = DB::table('store_categories')->where(['store_id'=>$storeId[0],'category_id'=>$cat_id])->first();
            
            if($cat_exists != null){
                return response()->json(["status" => 0, 'msg' => 'Category Already Added']);
            }else{
                if($parent_id == null){
                    $parentCat = DB::table('categories')->where('id',$cat_id)->first();
                    $store_Cat = DB::table('store_categories')->where('store_id',$storeId[0])->orderBy('id','desc')->first();
                    $lft = $store_Cat->rgt + 1;
                    $rgt = $lft + 1;
                    $ParentCatId = DB::table('store_categories')->insertGetId(
                        ['category_id' => $parentCat->id, 'is_nav' => 1,'url_key'=>$url_key,'parent_id'=>null,'lft'=>$lft,'rgt'=>$rgt,'depth'=>0,'status'=>0,'store_id'=>$storeId[0]]
                    );
                    $allcategory = DB::table('categories')->where('parent_id',$cat_id)->get();
                    foreach($allcategory as $cat){
                        $store_Cat = DB::table('store_categories')->where('store_id',$storeId[0])->orderBy('id','desc')->first();
                        $lft = $store_Cat->rgt + 1;
                        $rgt = $lft + 1;
                        $newcategory = DB::table('store_categories')->insert(
                            ['category_id' => $cat->id, 'is_nav' => 1,'url_key'=>$cat->url_key,'parent_id'=>$ParentCatId,'lft'=>$lft,'rgt'=>$rgt,'depth'=>1,'status'=>0,'store_id'=>$storeId[0]]
                        );
                    }
                }else{
                    $parent_exists = DB::table('store_categories')->where(['store_id'=>$storeId[0],'category_id'=>$parent_id])->first();
                    if($parent_exists == null){
                        $store_Cat = DB::table('store_categories')->where('store_id',$storeId[0])->orderBy('id','desc')->first();
                        $lft = $store_Cat->rgt + 1;
                        $rgt = $lft + 1;
                        $ParentCatId = DB::table('store_categories')->insertGetId(
                            ['category_id' => $parent_id, 'is_nav' => 1,'url_key'=>$url_key,'parent_id'=>null,'lft'=>$lft,'rgt'=>$rgt,'depth'=>0,'status'=>0,'store_id'=>$storeId[0]]
                        );
                    }else{
                        $ParentCatId = $parent_exists->id;
                    }
                        $store_Cat = DB::table('store_categories')->where('store_id',$storeId[0])->orderBy('id','desc')->first();
                        $lft = $store_Cat->rgt + 1;
                        $rgt = $lft + 1;
                        $newcategory = DB::table('store_categories')->insert(
                            ['category_id' => $cat_id, 'is_nav' => 1,'url_key'=>$url_key,'parent_id'=>$ParentCatId,'lft'=>$lft,'rgt'=>$rgt,'depth'=>1,'status'=>0,'store_id'=>$storeId[0]]
                        );
                        
                }
                return response()->json(["status" => 1, 'msg' => 'Category Added from master categories']);
            }
        }else{
            return response()->json(["status" => 0, 'msg' => 'Invalid Category']);
        }
        
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
            if($categoryId == "0"){
                $parentId = 0;
            }else{
                $cat = DB::table('store_categories')->find($categoryId);
                $parentId = $cat->category_id;
            }
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
