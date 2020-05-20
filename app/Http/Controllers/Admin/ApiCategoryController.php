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

    public function variantSetList() {
        $marchantId = Session::get("merchantId");
        $store = DB::table("stores")->where('merchant_id',$marchantId)->first();
        $variants = DB::table('attribute_sets')->where(['store_id'=>$store->id])->get();
        return response()->json(['status'=>1,'data'=>$variants]);
    }

    public function addEditVariantSet() {
        $marchantId = Session::get("merchantId");
        $store = DB::table("stores")->where('merchant_id',$marchantId)->first();
        $variantSetName = Input::get("variant_set_name");
        $status = !empty(Input::get("status")) ? Input::get("status"):0 ;
        if($variantSetName != null){
            if(Input::get("variant_set_name"))
            $variantSet = [];
            $variantSet['attr_set'] = $variantSetName;
            $variantSet['status'] = $status;
            $variantSet['store_id'] = $store->id;
            $id = Input::get("id");
            if (!empty($id)) {
                $variantSetsUpdate = DB::table('attribute_sets')->where("id", $id)->update($variantSet);
                $data = ["status" => 1, 'msg' => "Variant set updated successfully!"];
            } else {
                $insertedId = DB::table('attribute_sets')->insertGetId($variantSet);
                $data = ["status" => 1, 'msg' => "Variant set added successfully!"];
            }
        }else{
            $data = ["status" => 0, 'msg' => "Mandatory fields are missing."];
        }
        return $data;
    }

    public function variantSetDelete() {
        $marchantId = Session::get("merchantId");
        $store = DB::table("stores")->where('merchant_id',$marchantId)->first();
        $id = Input::get("id");
        if (!empty($id)) {
            $products = DB::table('products')->where("attr_set", $id)->count();
            if ($products > 0) {
                $data = ["status" => 0, 'msg' => "Sorry, This variant set is the part of products. Delete the Product  First!"];
            } else {
                $attributes = DB::table('has_attributes')->where("attr_set", $id)->delete();
                DB::table('attribute_sets')->where("id", $id)->delete();
                $data = ["status" => 1, 'msg' => "Variant set deleted successfully!"];
            }
        } else {
            $data = ["status" => 0, 'msg' => "Mandatory fields are missing."];
        }
        return $data;
    }

    public function attributes() {
        $marchantId = Session::get("merchantId");
        $store = DB::table("stores")->where('merchant_id',$marchantId)->first();
        
        $attributes = DB::table("attributes")->where('store_id',$store->id)->get();
        foreach($attributes as $attribute){
         $attribute->aatrSetId= DB::table("has_attributes")->where("attr_id",$attribute->id)->pluck("attr_set");
         $attribute->options=DB::table("attribute_values")->where("attr_id",$attribute->id)->get();
        }
        $attributeset = DB::table('attribute_sets')->where('store_id',$store->id)->get();
       
        $data=["attribute"=>$attributes,"attributeSet"=>$attributeset];
        return $data;
    }

    public function attributeType() {
        $marchantId = Session::get("merchantId");
        $attributeType = DB::table('attribute_types')->orderBy("id", "asc")->get(["id","attr_type"])->toArray();
        $data = ["attributeType" => $attributeType];
        return $data;
    }
    
    public function attributeSave() {
        $marchantId = Session::get("merchantId");
        $store = DB::table("stores")->where('merchant_id',$marchantId)->first();
        $id=Input::get('id');
        $ids=Input::get('id');
        $attr=[];
        $attr['attr'] = Input::get('attr');
        $attr['attr_type'] = Input::get('attr_type');
        $attr['is_filterable'] = Input::get('is_filterable');
        $attr['placeholder'] = Input::get('placeholder');
        $attr['att_sort_order'] = Input::get('att_sort_order');
        $attr['is_required'] = Input::get('is_required');
        $attr['status'] = !empty(Input::get('status'))?Input::get('status'):0;
        $attr['store_id'] = $store->id;
        $attribute_options=Input::get('attribute_options');
       
        if(!empty($id)){
          DB::table('attributes')->where("id",$id)->update($attr);  
        }else{
            $id= DB::table('attributes')->insertGetId($attr);   
        }
     
        $attrSet=Input::get('attr_set');
         DB::table('has_attributes')->where("attr_id",$id)->delete();  
        foreach($attrSet as $value){
            DB::table('has_attributes')->insert(['attr_id'=>$id,'attr_set'=>$value]); 
        }

        if (!empty($attribute_options)) {
            foreach ($attribute_options as $key => $val) {
                $attrval = [];//AttributeValue::findOrNew(Input::get('idd')[$key]);
                $attrval['option_name'] = $val['option_name'];
                $attrval['option_value'] =$val['option_value'];
                $attrval['is_active'] = $val['is_active'];
                $attrval['sort_order'] = $val['sort_order'];
                $attrval['attr_id'] = $id;
                if(!empty($val['opid']) || $val['opid']!= 0){
                    $attrvalId= $val['opid'];
                }
                if(!empty($attrvalId)){
                DB::table('attribute_values')->where("id",$attrvalId)->update($attrval); 
                }else{
                DB::table('attribute_values')->insert($attrval);     
                }
             
            }
        }
        $attributes = DB::table('attributes')->where("id",$id)->get();
        foreach($attributes as $attribute){
         $attribute->aatrSetId= DB::table('has_attributes')->where("attr_id",$attribute->id)->pluck("attr_set");
         $attribute->options=DB::table('attribute_values')->where("attr_id",$attribute->id)->get();
        }
        $attributeset = DB::table('attribute_sets')->where("store_id",$store->id)->get();
         if(empty($ids)){
         $data=["status"=>1,"msg"=>"Attribute added successfully",'attributes'=>$attributes,'attributeset'=>$attributeset];
         }else{
          $data=["status"=>1,"msg"=>"Attribute updated successfully",'attributes'=>$attributes,'attributeset'=>$attributeset];
              
         }
    return $data;
    }
    
    public function attributesDelete() {
        $marchantId = Session::get("merchantId");
        $id=Input::get('id');      
        $attributes = DB::table('attributes')->find($id);  
        $productAttrs = DB::table('has_options')->where("attr_id",$id)->get();
     
        if(count($productAttrs) > 0) {
             $data=["status"=>0,"msg"=>"Sorry, This Attribute is the part of a product. Delete the product first."];
      
        } else {
         DB::table('has_attributes')->where('attr_id',$id)->delete(); 
         DB::table('attribute_values')->where('attr_id',$id)->delete(); 
         DB::table('attributes')->where('id',$id)->delete(); 
         $data=["status"=>1,"msg"=>"Attribute deleted Successfully!"]; 
        }
        return $data;
    }
}
