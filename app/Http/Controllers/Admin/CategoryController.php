<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Library\Helper;
use Illuminate\Support\Facades\Input;
use Hash;
use DB;

class CategoryController extends Controller {

    public function index() {
//          $categories = Category::find(1);
//         // $data=array("men","women","footwere");
//        // $data=array("Starters","Main Course","Desserts","Beverages","Hard Drinks","Soft Drinks","Mocktails","Cocktails","Pizza","Salad","Soups","Others");
//
//        // dd(json_encode($data));
//       $cat= json_decode($categories->categories,true);
//       $i=0;
//       foreach($cat as $catdata){
//         $catname[$i]["category"]=$catdata;
//         $catname[$i]["url_key"]=  strtolower(str_replace(" ","-",$catdata));
//         $i++;
//       }
//      dd($catname);
//        $prifix='gupt280105_';
//        DB::table($prifix.'categories')->insert($catname);
        $categories = Category::orderBy("id", "desc");
        
        $search = Input::get('search');
        if (!empty($search)) {
            if (!empty(Input::get('s_category'))) {
                $categories = $categories->where("category", "like", "%" . Input::get('s_category') . "%");
            }
            if (!empty(Input::get('date_search'))) {
                $dateArr = explode(" - ", Input::get('date_search'));

                $fromdate = date("Y-m-d", strtotime($dateArr[0]));
                $todate = date("Y-m-d", strtotime($dateArr[1]));
                $categories = $categories->where("created_at", ">=", "$fromdate")->where('created_at', "<", "$todate");
            }
        }
        $categories = $categories->paginate(Config('constants.AdminPaginateNo'));
        $data = [];
        $viewname = Config('constants.AdminPagesMastersCategory') . ".index";
        $data['categories'] = $categories;
        return Helper::returnView($viewname, $data);
    }

    public function addEdit() {
        $category = Category::findOrNew(Input::get('id'));
        $data = [];
        $viewname = Config('constants.AdminPagesMastersCategory') . ".addEdit";
        $data['category'] = $category;
        return Helper::returnView($viewname, $data);
    }

    public function saveUpdate() {
        //dd(Input::all());
        $validation = new Category();
        $checkValidation = Helper::getValidation($validation, Input::all());

        if ($checkValidation == 1) {
            $saveUpdateCat = Category::findOrNew(Input::get('id'));
            $saveUpdateCat->fill(Input::all())->save();
             $banner=json_decode($saveUpdateCat->threebox_image,true);
            
             if (Input::get('sort_order')) {
                foreach(Input::get('sort_order') as $key=>$value){
                $logo = @Input::file('banner')[$key];
                if(!empty($logo)){
                    $destinationPath = public_path() . '/public/admin/themes/';
                    $fileName = "banner-" .$key. date("YmdHis") . "." . $logo->getClientOriginalExtension();
                    $upload_success = $logo->move($destinationPath, $fileName);
                    $banner[$key]["banner"] = @$fileName;
                }
                $banner[$key]["sort_order"] = Input::get('sort_order')[$key];
                $banner[$key]["banner_text"] = Input::get('banner_text')[$key];
                $banner[$key]["banner_status"] = Input::get('banner_status')[$key];
            
              }
            $saveUpdateCat->threebox_image = json_encode($banner);
            //dd($saveUpdateCat);
            $saveUpdateCat->update();
            
            }
         
            return redirect()->route('admin.masters.category.view');
        } else {
            return $checkValidation;
        }
    }

    public function changeStatus() {
        $catid = Input::get('catid');
        $catstatus = Input::get('catstatus');

        $cat = Category::find($catid);
        $cat->status = ($catstatus == 0) ? 1 : 0;
        $cat->update();
        return $cat->status;
    }

}
