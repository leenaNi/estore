<?php

namespace App\Http\Controllers\Admin;

use App\Classes\UploadHandler;
use App\Http\Controllers\Controller;
use App\Library\Helper;
use App\Models\CatalogImage;
use App\Models\Category;
use App\Models\CategoryMaster;
use App\Models\CategoryRequested;
use App\Models\Product;
use App\Models\Sizechart;
use DB;
use Illuminate\Http\Request;
use Input;
use Route;
use Session;

class CategoryMasterController extends Controller
{

    public function index()
    {

        $categories = CategoryMaster::whereIn("status", [1, 0])->orderBy("id", "asc");
        $categories = $categories->paginate(Config('constants.paginateNo'));
        $roots = CategoryMaster::roots()->get();

        //return view(Config('constants.adminCategoryMasterView') . '.index', compact('categories', 'roots'));

        $viewname = Config('constants.adminCategoryMasterView') . '.index';
        $data = ['categories' => $categories, 'roots' => $roots];
        return Helper::returnView($viewname, $data);
    }

    public function add()
    {
        $category = new CategoryMaster();
        $action = route("admin.category.save");
        // return view(Config('constants.adminCategoryMasterView') . '.addEdit', compact('category', 'allTaxes', 'action'));
        $viewname = Config('constants.adminCategoryMasterView') . '.addEdit';
        $data = ['category' => $category, 'action' => $action, 'status' => 'success'];
        // Session::flash("message", "Sorry, Can not delete this root category.");
        return Helper::returnView($viewname, $data);
    }

    public function edit()
    {
        $category = CategoryMaster::find(Input::get('id'));
        $action = route("admin.category.save");
        $viewname = Config('constants.adminCategoryMasterView') . '.addEdit';
        $data = ['category' => $category, 'action' => $action];
        return Helper::returnView($viewname, $data);
    }

    public function addAll()
    {
        $categories = Category::get();
        $i = 0;
        foreach ($categories as $categoryKey => $category) {
            $subCategories = json_decode($category->categories);
            // print_r($subCategories);
            $catsave = [];
            $cat = new CategoryMaster();
            $cat->category = $category->category;
            $cat->is_home = 1; //Input::get('is_home');
            $cat->is_nav = 1;
            $i++;
            $cat->lft = $i;
            $i++;
            $cat->rgt = $i;
            $cat->sort_order = $categoryKey;
            $cat->url_key = strtolower(str_replace(" ", "-", $category->category));
            $cat->status = 1;
            $cat->short_desc = '';
            $cat->store_id = 0;
            $cat->created_at = date('Y-m-d H:i:s');
            $cat->save();
            // dd($cat);
            foreach ($subCategories as $ck => $cv) {
                $checkCat = CategoryMaster::where('url_key', 'LIKE', '"' . strtolower(str_replace(" ", "-", $cv)) . '"')->first();
                if ($checkCat === null || $checkCat === null) {
                    $catsave[$ck]['category'] = $cv;
                    $catsave[$ck]['is_nav'] = 1;
                    $catsave[$ck]['url_key'] = strtolower(str_replace(" ", "-", $cv));
                    $i++;
                    $catsave[$ck]['lft'] = $i;
                    $i++;
                    $catsave[$ck]['rgt'] = $i;
                    $catsave[$ck]['sort_order'] = ($categoryKey + $ck);
                    $catsave[$ck]['depth'] = 0;
                    $catsave[$ck]['store_id'] = 0;
                    $catsave[$ck]['parent_id'] = @$cat->id;
                    $catsave[$ck]['status'] = 1;
                    $catsave[$ck]['created_at'] = date('Y-m-d H:i:s');
                }
            }
            // print_r($catsave);
            // dd('dasd');
            $addedcats = DB::table('categories')->insert($catsave);
        }
        $allCategories = Category::get();
        dd($allCategories);
    }

    public function save()
    {
        $category = CategoryMaster::findOrNew(Input::get('id'));
        //dd($category);
        $category->category = Input::get('category');
        $category->is_home = 0; //Input::get('is_home');
        $category->is_nav = Input::get('is_nav');
        $category->sort_order = Input::get('sort_order');
        $category->url_key = strtolower(str_replace(" ", "-", Input::get('category')));
        $category->status = Input::get('status');
        $category->short_desc = Input::get('short_desc');
        $category->store_id = 0;
        //$category->store_id = $getStoreId;
        $category->parent_id = Input::get('parent_id');
        //$category->long_desc = Input::get('long_desc');

        $catImgs = [];
        $category->images = json_encode($catImgs);
        //Session::flash('msg',"category added succesfully ");
        $category->save();

        //dd(count(Input::file('images')));
        if (Input::hasFile('images')) {
            foreach (Input::file('images') as $imgK => $imgV) {
                if ($imgV != null) {
                    $destinationPath = Config('constants.catImgUploadPath') . "/";
                    $fileName = "cat-" . $imgK . date("YmdHis") . "." . $imgV->getClientOriginalExtension();
                    $upload_success = $imgV->move($destinationPath, $fileName);
                } else {
                    $fileName = null;
                }
                $saveCImh = CatalogImage::findorNew(Input::get('catImgs')[$imgK]);
                if (!empty(Input::file('images')[$imgK])) {
                    $saveCImh->filename = is_null($fileName) ? $saveCImh->filename : $fileName;
                }

                $saveCImh->alt_text = Input::get('alt_text')[$imgK];
                // $saveCImh->sort_order = Input::get('img_sort_order')[$imgK];
                $saveCImh->catalog_id = $category->id;
                $saveCImh->image_type = 2;
                Session::flash('msg', "category added succesfully ");
                $saveCImh->save();
            }
        } else {
            if (!empty(Input::file('images')) && count(Input::file('images')) > 0) {
                foreach (Input::file('images') as $imgK => $imgV) {
                    if ($imgV != null) {
                        $destinationPath = Config('constants.catImgUploadPath') . "/";
                        $fileName = "cat-" . $imgK . date("YmdHis") . "." . $imgV->getClientOriginalExtension();
                        $upload_success = $imgV->move($destinationPath, $fileName);
                    } else {
                        $fileName = null;
                    }
                    $saveCImh = CatalogImage::findorNew(Input::get('catImgs')[$imgK]);
                    if (!empty(Input::file('images')[$imgK])) {
                        $saveCImh->filename = is_null($fileName) ? $saveCImh->filename : $fileName;
                    }

                    $saveCImh->alt_text = Input::get('alt_text')[$imgK];
                    //  $saveCImh->sort_order = Input::get('img_sort_order')[$imgK];
                    $saveCImh->catalog_id = $category->id;
                    $saveCImh->image_type = 2;
                    $saveCImh->save();
                }
            }
        }
        if (Session::get('requested_cat')) {
            $reqCat = CategoryRequested::find(Session::get('requested_cat'));
            $category->parent_id = $reqCat->parent_id;
            $category->update();
            $returnValue = $this->updateNewCategoryRequest($category->id);
        }

        if (!empty(Input::get("parent_id"))) {
            $category->makeChildOf(Input::get("parent_id"));
        }

        Session::flash("msg", "CategoryMaster updated successfully.");

        if (is_null(Input::get('id')) || empty(Input::get('id'))) {
            Session::flash("msg", "CategoryMaster added successfully.");
            //echo "return url::".Input::get('return_url');
            $reqCatModeValue = Session::get('mode');
            //echo "<br>requested mode val::".$reqCatModeValue;
            $url = Input::get('return_url');
            $explodedReturnUrl = substr($url, strrpos($url, '/') + 1);

            if (($explodedReturnUrl == 'edit') && ($reqCatModeValue == 'requested_category_approve')) {
                //destroy session here before redirect
                Session::forget('mode'); // Removes a specific session variable
                return redirect()->to("/admin/category?id=" . $category->id);
            } else {
                return redirect()->to(Input::get('return_url') . "?id=" . $category->id);
            }

        } else {

            return redirect()->to(Input::get('return_url'));

        }

    }

    public function delete()
    {
        $getId = Input::get('id');

        $cat = CategoryMaster::find($getId);

        if (!empty($cat)) {
            $action = route("admin.category.view");
            if ($cat->parent_id == null) {
                $chidCat = $cat->adminChildren()->get();
                if (count($chidCat) > 0) {
                    $data = ['status' => 'success', 'msg' => 'Sorry, Can not delete this root category.', 'action' => $action];
                    Session::flash("message", "Sorry, Can not delete this root category.");
                } else {
                    $cat->delete();
                    $data = ['status' => 'success', 'msg' => ' Root category deleted successfully.', 'action' => $action];
                    Session::flash("message", "Root category deleted successfully.");
                }
            } else {

                $catupdate = CategoryMaster::find($getId);
                $chidCatUpdate = $catupdate->adminChildren()->get();

                if (count($chidCatUpdate) > 0) {

                    $flag = 0;
                    foreach ($chidCatUpdate as $childCat) {
                        $childupdate = CategoryMaster::find($childCat->id);
                        $getProductInfo = $this->check_product($childupdate);

                        //                    $getProductInfo = Product::whereHas('categories', function($query) use ($childCat) {
                        //                                return $query->where('cat_id', $childCat->id);
                        //                            })->get();
                        if (count($getProductInfo) > 0) {
                            $flag++;
                        }
                    }
                    if ($flag == 0) {
                        $catupdate->delete();
                        $data = ['status' => 'success', 'msg' => 'CategoryMaster deleted successfully.', 'action' => $action];
                        Session::flash("message", "CategoryMaster deleted successfully.");
                    } else {
                        $data = ['status' => 'success', 'msg' => "Sorry, This category and it's sub categoty is part of a product. Delete the sub category first.", 'action' => $action];
                        Session::flash("message", "Sorry, This category and it's sub categoty is part of a product. Delete the sub categoty first.");
                    }
                } else {

                    $productInfo = $this->check_product($catupdate);
                    if (count($productInfo) > 0) {

                        $data = ['status' => 'success', 'msg' => 'Sorry, This category is a part of a product, So remove the product from this category first', 'action' => $action];
                        Session::flash("message", 'Sorry, This category is a part of a product, So remove product from this category first');
                    } else {

                        $catupdate->delete();
                        $data = ['status' => 'success', 'msg' => 'CategoryMaster deleted successfully.', 'action' => $action];
                        Session::flash("message", 'CategoryMaster deleted successfully.');
                    }
                }
            }

            //$viewname = '';
            //$viewname = Config('constants.adminCategoryMasterView') . '.index';
            //return Helper::returnView($viewname, $data);
            return redirect()->route('admin.category.view');
        } else {
            return redirect()->to("/admin/category");
        }
        //return Helper::returnView($viewname, $data, $url = 'admin.category.view');
    }

    public function sizeChart()
    {
        $sizeChart = Sizechart::find(Input::get('id'));
        return $sizeChart;
    }

    public function catSeo()
    {
        $category = CategoryMaster::find(Input::get('id'));
        $action = route("admin.category.saveCatSeo");
        $viewname = Config('constants.adminCategoryMasterView') . '.cat_seo';
        $data = ['category' => $category, 'action' => $action];
        return Helper::returnView($viewname, $data);
    }

    public function check_product($product)
    {
        $productInfo = Product::whereHas("categories", function ($query) use ($product) {
            return $query->where('cat_id', $product->id);
        })->get();
        // dd($productInfo);
        return $productInfo;
    }

    public function saveCatSeo()
    {
        $saveS = CategoryMaster::findOrNew(Input::get('id'));
        $saveS->meta_title = Input::get("meta_title");
        $saveS->meta_keys = Input::get("meta_keys");
        $saveS->meta_desc = Input::get("meta_desc");
        $saveS->meta_robot = Input::get("meta_robot");
        $saveS->canonical = Input::get("canonical");
        $saveS->title = Input::get("title");
        $saveS->desc = Input::get("desc");
        $saveS->image = Input::get("image");
        $saveS->url = Input::get("url");
        $saveS->other_meta = Input::get("other_meta");
        $saveS->save();
        Session::flash("msg", "CategoryMaster updated successfully.");
        return redirect()->to(Input::get('return_url'));
    }

    public function sampleCategoryMasterDownload()
    {
        $details = [];
        $arr = ['id', 'category', 'short_desc', 'long_desc', 'images', 'is_home', 'is_nav', 'url_key', 'meta_title', 'meta_keys', 'meta_desc', 'sort_order', 'parent_id', 'brandmake', 'brand_address', 'premiumness', 'vat', 'meta_robot', 'canonical', 'title', 'desc', 'image', 'url', 'other_meta'];
        $lastId = DB::select(DB::raw("SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'cartininew' AND TABLE_NAME = '" . DB::getTablePrefix() . "categories'"));
        // dd($lastId);
        $sampleCat = [];
        array_push($sampleCat, $arr);
        $details = [$lastId[0]->AUTO_INCREMENT, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''];
        array_push($sampleCat, $details);
        return Helper::getCsv($sampleCat, 'category_sample.csv', ',');
    }

    public function sampleBulkDownload()
    {
        $details = [];
        $arr = ['id', 'category', 'short_desc', 'long_desc', 'images', 'is_home', 'is_nav', 'url_key', 'status', 'meta_title', 'meta_keys', 'meta_desc', 'sort_order', 'parent_id', 'brandmake', 'brand_address', 'premiumness', 'vat', 'meta_robot', 'canonical', 'title', 'desc', 'image', 'url', 'other_meta'];
        $category = CategoryMaster::get(['id', 'category', 'short_desc', 'long_desc', 'images', 'is_home', 'is_nav', 'url_key', 'status', 'meta_title', 'meta_keys', 'meta_desc', 'sort_order', 'parent_id', 'brandmake', 'brand_address', 'premiumness', 'vat', 'meta_robot', 'canonical', 'title', 'desc', 'image', 'url', 'other_meta']);
        $sampleCat = [];
        array_push($sampleCat, $arr);
        $arrP = [];
        $i = 0;
        foreach ($category as $cat) {
            $imgs = [];
            if (!empty($cat->catimgs()->get()->toArray())) {
                foreach ($cat->catimgs()->get() as $catimg) {
                    array_push($imgs, $catimg->filename);
                }
                $allimgs = implode(",", $imgs);
            } else {
                $allimgs = "";
            }
            $details = [
                $cat->id,
                $cat->category,
                $cat->short_desc,
                $cat->long_desc,
                $allimgs,
                $cat->is_home,
                $cat->is_nav,
                $cat->url_key,
                $cat->status,
                $cat->meta_title,
                $cat->meta_keys,
                $cat->meta_desc,
                $cat->sort_order,
                $cat->parent_id,
                $cat->brandmake,
                $cat->brand_address,
                $cat->premiumness,
                $cat->vat,
                $cat->meta_robot,
                $cat->canonical,
                $cat->title,
                $cat->desc,
                $cat->image,
                $cat->url,
                $cat->other_meta,
            ];
            array_push($sampleCat, $details);
        }
        return Helper::getCsv($sampleCat, 'category_data.csv', ',');
    }

    public function categoryBulkUpload(Request $request)
    {

        if (Input::hasFile('file')) {
            $file = Input::file('file');
            $name = time() . '-' . $file->getClientOriginalName();
            $path = Config('constants.catImgUploadPath') . "/";
            $file->move($path, $name);
            return $this->category_import_csv($path, $name);
            //  echo "Success";
        } else {

            echo "Please select file";
        }
    }

    private function category_import_csv($path, $filename)
    {
        //        dd($path);
        $arr = ['id', 'category', 'short_desc', 'long_desc', 'images', 'is_home', 'is_nav', 'url_key', 'status', 'meta_title', 'meta_keys', 'meta_desc', 'sort_order', 'parent_id', 'brandmake', 'brand_address', 'premiumness', 'vat', 'meta_robot', 'canonical', 'title', 'desc', 'image', 'url', 'other_meta'];

        $csv_file = $path . $filename;
        if (($handle = fopen($csv_file, "r")) !== false) {

            $intersect = array_intersect($arr, fgetcsv($handle));
            if (count($arr) != count($intersect)) {
                echo "Column miss match plaese check your Excel sheet";
                exit;
            }
            // dd(Ca::select(fgetcsv($handle))->get());
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                //  dd($data);
                $num = count($data);
                for ($c = 0; $c < $num; $c++) {
                    $col[$c] = $data[$c];
                }
                $id = $col[0];
                $category = $col[1];
                $short_desc = $col[2];
                $long_desc = $col[3];
                $catimgs = $col[4];
                $is_home = $col[5];
                $is_nav = $col[6];
                $url_key = $col[7];
                $status = $col[8];
                $meta_title = $col[9];
                $meta_key = $col[10];
                $meta_desc = $col[11];
                $sort_order = $col[12];
                $parent_id = $col[13];
                $brandmake = $col[14];
                $brand_address = $col[15];
                $premiumness = $col[16];
                $vat = $col[17];
                $meta_robot = $col[18];
                $canonical = $col[19];
                $og_title = $col[20];
                $og_desc = $col[21];
                $og_image = $col[22];
                $og_url = $col[23];
                //   $twitter_url = $col[23];
                //                $twitter_title = $col[24];
                //                $twitter_desc = $col[25];
                //                $twitter_image = $col[26];
                $other_meta = $col[24];

                if (!empty($id)) {
                    $updateCat = CategoryMaster::firstOrNew(array('id' => $id));
                    if (!empty($category)) {
                        $updateCat->category = $category;
                    }

                    if (!empty($short_desc)) {
                        $updateCat->short_desc = $short_desc;
                    }

                    if (!empty($long_desc)) {
                        $updateCat->long_desc = $long_desc;
                    }

                    if (!empty($is_home)) {
                        $updateCat->is_home = $is_home;
                    }

                    if (!empty($is_nav)) {
                        $updateCat->is_nav = $is_nav;
                    }

                    if (!empty($url_key)) {
                        $updateCat->url_key = $url_key;
                    }

                    if (!empty($status)) {
                        $updateCat->status = $status;
                    }

                    if (!empty($meta_title)) {
                        $updateCat->meta_title = $meta_title;
                    }

                    if (!empty($meta_key)) {
                        $updateCat->meta_keys = $meta_key;
                    }

                    if (!empty($meta_desc)) {
                        $updateCat->meta_desc = $meta_desc;
                    }

                    if (!empty($sort_order)) {
                        $updateCat->sort_order = $sort_order;
                    }

                    if (!empty($parent_id)) {
                        $updateCat->parent_id = $parent_id;
                    }

                    if (!empty($brandmake)) {
                        $updateCat->brandmake = $brandmake;
                    }

                    if (!empty($brand_address)) {
                        $updateCat->brand_address = $brand_address;
                    }

                    if (!empty($premiumness)) {
                        $updateCat->premiumness = $premiumness;
                    }

                    if (!empty($vat)) {
                        $updateCat->vat = $vat;
                    }

                    if (!empty($meta_robot)) {
                        $updateCat->meta_robot = $meta_robot;
                    }

                    if (!empty($canonical)) {
                        $updateCat->canonical = $canonical;
                    }

                    if (!empty($og_title)) {
                        $updateCat->title = $og_title;
                    }

                    if (!empty($og_desc)) {
                        $updateCat->desc = $og_desc;
                    }

                    if (!empty($og_image)) {
                        $updateCat->image = $og_image;
                    }

                    if (!empty($og_url)) {
                        $updateCat->url = $og_url;
                    }

                    //                    if (!empty($twitter_url))
                    //                        $updateCat->twitter_url = $twitter_url;
                    //                    if (!empty($twitter_title))
                    //                        $updateCat->twitter_title = $twitter_title;
                    //                    if (!empty($twitter_desc))
                    //                        $updateCat->twitter_desc = $twitter_desc;
                    //                    if (!empty($twitter_image))
                    //                        $updateCat->twitter_image = $twitter_image;

                    $updateCat->save();

                    $catimgsData = explode(",", $catimgs);

                    if (!empty($catimgsData)) {
                        $updateCat->catimgs()->delete();
                        $getimgs = [];
                        foreach ($catimgsData as $fileNm) {
                            array_push($getimgs, new CatalogImage(array('filename' => $fileNm, 'image_type' => 2, 'image_mode', 1)));
                        }
                        //    $updateCat->catimgs()->saveMany($getimgs);
                    }
                }
            }
            fclose($handle);
            Session::flash("msg", "Product uploaded successfully");
            return redirect()->back();
        } else {
            echo "Error being upload pincodes";
        }
        // echo "File data successfully imported to database!!";
    }

    public function catBulkImgUpload()
    {
        $path = '/public/Admin/uploads/catalog/category/';
        $upload_handler = new UploadHandler(null, true, null, $path);
    }

    public function checkCatName()
    {
        $catname = Input::get('catname');
        $catname = CategoryMaster::where('category', $catname)->whereIn('status', [0, 1])->get();
        if (count($catname) > 0) {
            return $data['msg'] = ['status' => 'success', 'msg' => 'category name already exist'];
        } else {
            return 0;
        }
    }

    public function changeStatus()
    {
        $cat = CategoryMaster::find(Input::get('id'));
        //dd($cat);
        if ($cat->status == 1) {
            $catStatus = 0;
            $msg = "CategoryMaster disabled successfully.";
            $cat->status = $catStatus;
            $cat->update();
            Session::flash("message", $msg);
            $data = ['status' => '1', 'msg' => $msg];
            $viewname = '';
            return Helper::returnView($viewname, $data, $url = 'admin.category.view');
        } else if ($cat->status == 0) {
            $catStatus = 1;
            $msg = "CategoryMaster enabled successfully.";
            $cat->status = $catStatus;
            $cat->update();
            Session::flash("msg", $msg);
            $data = ['status' => '1', 'msg' => $msg];
            $viewname = '';
            return Helper::returnView($viewname, $data, $url = 'admin.category.view');
        }
    }
    public function catImgDelete()
    {
        $id = Input::get('catImgId');
        $catImage = CatalogImage::find($id);
        $catImage->delete();
        Session::flash("messege", "CategoryMaster image deleted successfully!");
        return $data = ["status" => "success"];
    }

    public function categoriesRequested()
    {
        $categories = CategoryRequested::with(['requestedBy.store'])->orderBy("id", "desc");
        $search = Input::get('search');
        if (!empty($search)) {
            if (!empty(Input::get('s_category'))) {
                $categories = $categories->where("name", "like", "%" . Input::get('s_category') . "%");
            }
            if (!empty(Input::get('date_search'))) {
                $dateArr = explode(" - ", Input::get('date_search'));
                $fromdate = date("Y-m-d", strtotime($dateArr[0]));
                $todate = date("Y-m-d", strtotime($dateArr[1]));
                $categories = $categories->where("created_at", ">=", "$fromdate")->where('created_at', "<", "$todate");
            }
        }
        //echo "outside if";
        $categories = $categories->paginate(Config('constants.AdminPaginateNo'));
        //dd($categories);
        $data = [];
        $viewname = Config('constants.adminCategoryMasterView') . ".new-category";
        $data['categories'] = $categories;
        return Helper::returnView($viewname, $data);
    }

    public function approveCategory()
    {
        $id = Input::get('id');
        if ($id && $id != '') {
            Session::put('requested_cat', $id);
            Session::put('mode', 'requested_category_approve');
            return redirect()->route('admin.category.add');
        }
    }

    public function updateNewCategoryRequest($newCatId)
    {
        $reqCat = Session::get('requested_cat');
        echo "req cat id::".$reqCat;
        echo "New Cat Id::" . $newCatId;
        $catsave = [];
        $reqCategory = CategoryRequested::find($reqCat);
        if (!empty($reqCategory)) {
            $userId = $reqCategory->user_id;

            //Get store id from user table
            $userResultSet = DB::table('users')
                ->where('id', $userId)->first(['store_id']);

            $getStoreId = $userResultSet->store_id;
            //Add New category to store_categories
            $newCat = CategoryMaster::find($newCatId);

            //check if parent category present
            //$checkParentCat = DB::table('store_categories')->where('category_id', $newCat->parent_id)->where('store_id', $reqCategory->requestedBy->store_id)->first(['id']);
            $checkParentCat = DB::table('store_categories')->where('category_id', $newCat->parent_id)->where('store_id', $getStoreId)->first(['id']);
            if ($checkParentCat == null) {
                //Add New category to store_categories
                $newParentCat = CategoryMaster::find($newCat->parent_id);
                DB::table('store_categories')->insert([
                    "category_id" => $newParentCat->id,
                    "is_nav" => $newParentCat->is_nav,
                    "url_key" => strtolower(str_replace(" ", "-", $newParentCat->category)),
                    "lft" => $newParentCat->lft,
                    "rgt" => $newParentCat->rgt,
                    "depth" => 0,
                    //"store_id" => $reqCategory->requestedBy->store_id,
                    "store_id" => $getStoreId,
                    "created_at" => date('Y-m-d H:i:s'),
                ]);
            }
            $catsave['category_id'] = $newCat->id;
            $catsave['is_nav'] = 1;
            $catsave['url_key'] = strtolower(str_replace(" ", "-", $newCat->category));
            $catsave['lft'] = $newCat->lft;
            $catsave['rgt'] = $newCat->rgt;
            $catsave['depth'] = 0;
            $catsave['parent_id'] = $checkParentCat->id;
            //$catsave['store_id'] = $reqCategory->requestedBy->store_id;
            $catsave['store_id'] = $getStoreId;
            $catsave['created_at'] = date('Y-m-d H:i:s');
            $addedcats = DB::table('store_categories')->insert($catsave);
            //Send mail to store admin who requested the category
            //Delete record from table
            CategoryRequested::find($reqCat)->delete();
            return 1;
        } else {
            return 0;
            //return redirect()->to(Input::get('return_url'));
        }

    }
}
