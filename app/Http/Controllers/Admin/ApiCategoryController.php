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
            $categories = DB::table('categories')->where("status", '1')->orderBy("id", "asc")->paginate(10);
            $prod_type = DB::table('product_types')->where("status", '1')->orderBy("id", "asc")->get(["id", "type"]);
            $attrS = DB::table('attribute_sets')->where('id', '!=', 1)->where('status', 1)->get(['id', 'attr_set']);
            $stockStatus = DB::table('general_setting')->where("url_key", 'stock')->first()->status;
            foreach ($categories as $category) {
                $category->catImage = "http://" . $merchant->url_key . '.' . $_SERVER['HTTP_HOST'] . '/uploads/catalog/category/' . @DB::table('catalog_images')->where("image_type", 2)->where('catalog_id', $category->id)->latest()->first()->filename;
            }
            $data = ['categories' => $categories, 'prod_type' => $prod_type, 'stockStatus' => $stockStatus, 'attribute' => $attrS];
            return response()->json(["status" => 1, 'data' => $data]);
        }else{
            return response()->json(["status" => 0, 'msg' => 'Session Expired.']);
        }
        
    }
}
