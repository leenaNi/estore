<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Library\Helper;
use App\Models\Document;
use Validator;
use Illuminate\Support\Facades\Input;
use Hash;
use Session;
use Auth;
use JWTAuth;
use Config;
use DB;
use Illuminate\Http\Response;
use App\Models\Merchant;
use Tymon\JWTAuth\Exceptions\JWTException;

class AttributeController extends Controller {

    public function index() {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $attributes = DB::table($prifix . '_attribute_sets')->get();
        return $attributes;
    }

    public function attributeSetSave() {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $attributeSet = [];
        $attributeSet['attr_set'] = Input::get("attr_set_name");
        $attributeSet['status'] = Input::get("status");
        $id = Input::get("id");
        if (!empty($id)) {
            $attributes = DB::table($prifix . '_attribute_sets')->where("id", $id)->update($attributeSet);
            $data = ["status" => 1, 'msg' => "Attribute set added successfully!"];
        } else {
            $insertedId = DB::table($prifix . '_attribute_sets')->insertGetId($attributeSet);
            $data = ["status" => 1, 'msg' => "Attribute set updated successfully!"];
        }

        return $data;
    }

    public function attributeSetDelete() {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $id = Input::get("id");
        if (!empty($id)) {
            $products = DB::table($prifix . '_products')->where("attr_set", $id)->count();
            if ($products > 0) {
                $data = ["status" => 0, 'msg' => "Sorry, This attributeSet is the part of products. Delete the Product  First!"];
            } else {
              //  $attributeSet = DB::table($prifix . '_attribute_sets')->where("id", $id)->get();
                $attributes = DB::table($prifix . '_has_attributes')->where("attr_set", $id)->delete();
                DB::table($prifix . '_attribute_sets')->where("id", $id)->delete();
                $data = ["status" => 1, 'msg' => "Attribute set deleted successfully!"];
            }
        } else {
            $data = ["status" => 0, 'msg' => "Opps something went wrong!"];
        }
        return $data;
    }

    public function attributes() {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $has_atttr = $prifix . '_has_attributes';
        $attrTab = $prifix . '_attributes';
        $attrvalue = $prifix . '_attribute_values';
      //dd($attrTab);
        $attributes = DB::table($attrTab)->get();
        foreach($attributes as $attribute){
         $attribute->aatrSetId= DB::table($has_atttr)->where("attr_id",$attribute->id)->pluck("attr_set");
         $attribute->options=DB::table($attrvalue)->where("attr_id",$attribute->id)->get();
        }
        $attributeset = DB::table($prifix . '_attribute_sets')->get();
       
        $data=["attribute"=>$attributes,"attributeSet"=>$attributeset];
        return $data;
    }
    
       public function attributeSave() {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $id=Input::get('id');
        $ids=Input::get('id');
        $attr=[];
        $attr['attr'] = Input::get('attr');
        $attr['attr_type'] = Input::get('attr_type');
        $attr['is_filterable'] = Input::get('is_filterable');
        $attr['placeholder'] = Input::get('placeholder');
        $attr['att_sort_order'] = Input::get('att_sort_order');
        $attr['is_required'] = Input::get('is_required');
        $attr['status'] = Input::get('status');
        if(!empty($id)){
          DB::table($prifix . '_attributes')->where("id",$id)->update($attr);  
        }else{
            $id= DB::table($prifix . '_attributes')->insertGetId($attr);   
        }
     
      $attrSet=json_decode(Input::get('attr_set'));
         DB::table($prifix . '_has_attributes')->where("attr_id",$id)->delete();  
         foreach($attrSet as $key=>$value){
             $has_attr[$key]['attr_set']=$value;
             $has_attr[$key]['attr_id']=$id;
         }
        DB::table($prifix . '_has_attributes')->insert($has_attr); 
        //$attr->attributesets()->sync(Input::get('attr_set'));
         $optionValue=json_decode(Input::get('option_name'));
     
        if (Input::get('option_name')) {
            foreach ($optionValue as $key => $val) {
               
                $attrval = [];//AttributeValue::findOrNew(Input::get('idd')[$key]);
                $attrval['option_name'] = json_decode(Input::get('option_name'),true)[$key];
                $attrval['option_value'] =json_decode(Input::get('option_value'),true)[$key];
                $attrval['is_active'] = json_decode(Input::get('is_active'),true)[$key];
                $attrval['sort_order'] = json_decode(Input::get('sort_order'),true)[$key];
                $attrval['attr_id'] = $id;
                $attrvalId=json_decode(Input::get('idd'),true)[$key];
              //  dd($attrval);
                if(!empty($attrvalId)){
                DB::table($prifix . '_attribute_values')->where("id",$attrvalId)->update($attrval); 
                }else{
                DB::table($prifix . '_attribute_values')->insert($attrval);     
                }
             
            }
        }
       $attributes = DB::table($prifix . '_attributes')->where("id",$id)->get();
        foreach($attributes as $attribute){
         $attribute->aatrSetId= DB::table($prifix . '_has_attributes')->where("attr_id",$attribute->id)->pluck("attr_set");
         $attribute->options=DB::table($prifix . '_attribute_values')->where("attr_id",$attribute->id)->get();
        }
        $attributeset = DB::table($prifix . '_attribute_sets')->get();
         if(empty($ids)){
         $data=["status"=>1,"msg"=>"Attribute added successfully",'attributes'=>$attributes,'attributeset'=>$attributeset];
         }else{
          $data=["status"=>1,"msg"=>"Attribute updated successfully",'attributes'=>$attributes,'attributeset'=>$attributeset];
              
         }
    return $data;
    }
    public function attributesDelete() {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $id=Input::get('id');      
        $attributes = DB::table($prifix . '_attributes')->find($id);  
        $productAttrs = DB::table($prifix . '_has_options')->where("attr_id",$id)->get();
      //  dd($productAttrs);
        if(count($productAttrs) > 0) {
             $data=["status"=>0,"msg"=>"Sorry, This Attribute is the part of a product. Delete the product first."];
      
        } else {
         DB::table($prifix . '_has_attributes')->where('attr_id',$id)->delete(); 
         DB::table($prifix . '_attribute_values')->where('attr_id',$id)->delete(); 
         DB::table($prifix . '_attributes')->where('id',$id)->delete(); 
         $data=["status"=>1,"msg"=>"Attribute deleted Successfully!"]; 
        }
        return $data;
    }
    public function attributeType() {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $attributeType = DB::table($prifix . '_attribute_types')->orderBy("id", "asc")->get(["id","attr_type"])->toArray();
        $data = ["attributeType" => $attributeType];
        return $data;
    }
    public function deleteAttributeOption(){
       $marchantId = Input::get("merchantId");
       $id=Input::get("id");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $attributeVal = DB::table($prifix . '_has_options')->where("attr_val",$id)->count();
        if( $attributeVal > 0){
         return $data=["status"=>0,"msg"=>"You can't delete this attribute options,Because it is a part of product"];
        }else{
         DB::table($prifix . '_attribute_values')->where("id",$id)->delete(); 
         return $data=["status"=>1,"msg"=>"Attribute option deleted successfully!"];
        }
}
}

?>