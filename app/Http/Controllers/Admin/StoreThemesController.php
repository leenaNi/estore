<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\StoreTheme;
use App\Library\Helper;
use Illuminate\Support\Facades\Input;
use Hash;
use Session;
use Validator;

class StoreThemesController extends Controller {

    public function index() {

        $themes = StoreTheme::orderBy("id", "desc");
        $search = Input::get('search');
        if (!empty($search)) {
            if (!empty(Input::get('s_category'))) {
                $themes = $themes->whereHas("category", function($query) {
                    $query->where("category", "like", "%" . Input::get('s_category') . "%");
                });
            }
            if (!empty(Input::get('s_name'))) {
                $themes = $themes->where("theme_category", "like", "%" . Input::get('s_name') . "%");
            }
            if (!empty(Input::get('date_search'))) {
                $dateArr = explode(" - ", Input::get('date_search'));

                $fromdate = date("Y-m-d", strtotime($dateArr[0]));
                $todate = date("Y-m-d", strtotime($dateArr[1]));

                if ($fromdate == $todate)
                    $themes = $themes->where("created_at", ">=", "{$fromdate}");
                else
                    $themes = $themes->where("created_at", ">=", "'" . $fromdate . "'")->where('created_at', "<=", "'" . $todate . "'");


                $themes = $themes->where("created_at", ">=", "{$fromdate}")->where('created_at', "<", "{$todate}");
            }
        }
        $themes = $themes->paginate(Config('constants.AdminPaginateNo'));
        $data = [];
        $viewname = Config('constants.AdminPagesMastersTheme') . ".index";
        $data['themes'] = $themes;
        return Helper::returnView($viewname, $data);
    }

    public function addEdit() {
        $themes = StoreTheme::findOrNew(Input::get('id'));
        $categories = Category::where("status", 1)->pluck("category", "id")->prepend("Select Category", "")->toArray();
        $data = [];
        $viewname = Config('constants.AdminPagesMastersTheme') . ".addEdit";
        $data['themes'] = $themes;
        $data['categories'] = $categories;
        return Helper::returnView($viewname, $data);
    }

    public function saveUpdate() {
        //   dd(Input::all());
        $validation = new StoreTheme();
        $validator = Validator::make(Input::all(), StoreTheme::rules(Input::get('id')), $validation->messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        } else {
            $saveArr = Input::all();
            $saveArr['added_by'] = Session::get('authUserId');
            $saveUpdateCat = StoreTheme::findOrNew(Input::get('id'));
            $saveUpdateCat->fill($saveArr)->save();

            if (Input::hasFile('image')) {
                $logo = Input::file('image');
                $destinationPath = public_path() . '/public/admin/themes/';
                $fileName = "theme-" . date("YmdHis") . "." . $logo->getClientOriginalExtension();
                $upload_success = $logo->move($destinationPath, $fileName);
                $saveUpdateCat->image = @$fileName;
                $saveUpdateCat->update();
            }

            if (!empty($saveUpdateCat->banner_image)) {
                $banner = json_decode($saveUpdateCat->banner_image, true);
            } else {
                $banner = [];
            }


            if (Input::get('sort_order')) {
                foreach (Input::get('sort_order') as $key => $value) {
                    $row_id = (Input::get('rowid')[$key]);

                    $logo = @Input::file('banner')[$key];
                    $banner[$row_id]["rowid"] = $row_id;
                    if (!empty($logo)) {
                        $destinationPath = public_path() . '/public/admin/themes/';
                        $fileName = "banner-" . $key . date("YmdHis") . "." . $logo->getClientOriginalExtension();
                        $upload_success = $logo->move($destinationPath, $fileName);
                        $banner[$row_id]["banner"] = @$fileName;
                    } else {
                        $banner[$row_id]["banner"] = Input::get('slectedImage')[$key];
                    }

                    $banner[$row_id]["sort_order"] = (Input::get('sort_order')[$key] != "") ? Input::get('sort_order')[$key] : "";
                    $banner[$row_id]["banner_text"] = (Input::get('banner_text')[$key] != "") ? Input::get('banner_text')[$key] : "";
                    $banner[$row_id]["banner_status"] = (Input::get('banner_status')[$key] != "") ? Input::get('banner_status')[$key] : "";
                }

                //  dd(json_encode($banner));

                $saveUpdateCat->banner_image = json_encode($banner);
            }
            $saveUpdateCat->update();


            //  if (Input::file('banner')) {
            //     foreach(Input::file('banner') as $key=>$value){
            //     $logo = $value;
            //     $destinationPath = public_path() . '/public/admin/themes/';
            //     $fileName = "threebox-" .$key. date("YmdHis") . "." . $logo->getClientOriginalExtension();
            //     $upload_success = $logo->move($destinationPath, $fileName);
            //     $banner[$key]["banner"] = @$fileName;
            //     $banner[$key]["sort_order"] = Input::get('sort_order')[$key];
            //     $banner[$key]["banner_status"] = Input::get('banner_status')[$key];
            //   }
            //  $saveUpdateCat->threebox_image =  json_encode($banner);
            //  $saveUpdateCat->update();
            // }
            return redirect()->route('admin.masters.themes.view');
        }
    }

    public function changeStatus() {
        $themeid = Input::get('themeid');
        $themestatus = Input::get('themestatus');

        $theme = StoreTheme::find($themeid);
        $theme->status = ($themestatus == 0) ? 1 : 0;
        $theme->update();
        return $theme->status;
    }

    public function deleteBanner() {
        $themeid = Input::get('id');
        $banner = Input::get('rowid');
//        echo $banner;
        $theme = StoreTheme::find($themeid);
        $bannerImage = json_decode($theme->banner_image, true);
        if (array_key_exists($banner, $bannerImage)) {
            unset($bannerImage[$banner]);
        }
        $theme->banner_image = json_encode($bannerImage);
        $theme->update();
        return redirect()->back();
//        $theme->status = ($themestatus == 0) ? 1 : 0;
//        $theme->update();
//        return $theme->status;
    }

}
