<?php

namespace App\Http\Controllers\Admin;

use Route;
use Input;
use App\Models\Category;
use App\Library\Helper;
use App\Classes\UploadHandler;
use App\Http\Controllers\Controller;
use App\Models\CatalogImage;
use App\Models\Tax;
use App\Models\HasTaxes;
use DB;
use Session;

class ApiCatController extends Controller {

    public function index() {
        
        $categories = Category::where("status", '1')->where('id', 1)->with('children.cat_tax')->orderBy("id", "asc");
        $categories = $categories->paginate(Config('constants.paginateNo'));
        //$roots = Category::roots()->get();
        //dd($categories);
        //return view(Config('constants.adminApiCatView') . '.index', compact('categories', 'roots'));

        $viewname = Config('constants.adminApiCatView') . '.index';
        $data = ['categories' => $categories];
        return Helper::returnView($viewname, $data);
    }

    public function add() {
        $category = new Category();
        $taxes = Tax::whereIn("status", [1, 2])->where('type', 2)->get();
        $allTaxes = ['0' => "No Tax"];
        foreach ($taxes as $t) {
            $allTaxes[$t->id] = $t->name;
        }

        $category_taxes = [];

        $action = route("admin.apicat.save");
        // return view(Config('constants.adminApiCatView') . '.addEdit', compact('category', 'allTaxes', 'action'));
        $viewname = Config('constants.adminApiCatView') . '.addEdit';
        $data = ['category' => $category, 'allTaxes' => $allTaxes, 'action' => $action, 'category_taxes' => $category_taxes];

        return Helper::returnView($viewname, $data);
    }

    public function edit() {
        $category = Category::with('cat_tax')->find(Input::get('id'));
        $taxes = Tax::where('type', 2)->get();
        $allTaxes = ['0' => "No Tax"];
        foreach ($taxes as $t) {
            $allTaxes[$t->id] = $t->name;
        }
        $category_taxes = [];
        foreach ($category->cat_tax as $ct) {
            array_push($category_taxes, $ct->id);
        }
        $action = route("admin.apicat.save");
        // return view(Config('constants.adminApiCatView') . '.addEdit', compact('category', 'allTaxes', 'action'));

        $viewname = Config('constants.adminApiCatView') . '.addEdit';
        $data = ['category' => $category, 'allTaxes' => $allTaxes, 'action' => $action, 'category_taxes' => $category_taxes];
        return Helper::returnView($viewname, $data);
    }

    public function save() {
        // print_r(Input::all());
        $category = Category::findOrNew(Input::get('id'));
        $category->category = Input::get('category');
        $category->is_home = 1;
        $category->is_nav = 1;
        $category->parent_id = 1;
        $category->sort_order = 0;
        //$category->url_key = strtolower(str_replace(" ","-",Input::get('url_key')));
        $category->status = 1;
        //$category->short_desc = Input::get('short_desc');
        //$category->long_desc = Input::get('long_desc');
        $catImgs = [];
        $category->images = json_encode($catImgs);
        $category->save();

        //dd(count(Input::file('images')));
        if (Input::hasFile('images')) {
            foreach (Input::file('images') as $imgK => $imgV) {
                if ($imgV != null) {
                    $destinationPath = public_path() . '/admin/uploads/catalog/category/';
                    $fileName = "cat-" . $imgK . date("YmdHis") . "." . $imgV->getClientOriginalExtension();
                    $upload_success = $imgV->move($destinationPath, $fileName);
                } else {
                    $fileName = null;
                }
                $saveCImh = CatalogImage::findorNew(Input::get('catImgs')[$imgK]);
                if (!empty(Input::file('images')[$imgK]))
                    $saveCImh->filename = is_null($fileName) ? $saveCImh->filename : $fileName;
                $saveCImh->alt_text = Input::get('alt_text')[$imgK];
                $saveCImh->sort_order = Input::get('img_sort_order')[$imgK];
                $saveCImh->catalog_id = $category->id;
                $saveCImh->image_type = 2;
                $saveCImh->save();
            }
        }else {
            if (count(Input::file('images')) > 0) {
                foreach (Input::file('images') as $imgK => $imgV) {
                    if ($imgV != null) {
                        $destinationPath = public_path() . '/admin/uploads/catalog/category/';
                        $fileName = "cat-" . $imgK . date("YmdHis") . "." . $imgV->getClientOriginalExtension();
                        $upload_success = $imgV->move($destinationPath, $fileName);
                    } else {
                        $fileName = null;
                    }
                    $saveCImh = CatalogImage::findorNew(Input::get('catImgs')[$imgK]);
                    if (!empty(Input::file('images')[$imgK]))
                        $saveCImh->filename = is_null($fileName) ? $saveCImh->filename : $fileName;
                    $saveCImh->alt_text = Input::get('alt_text')[$imgK];
                    $saveCImh->sort_order = Input::get('img_sort_order')[$imgK];
                    $saveCImh->catalog_id = $category->id;
                    $saveCImh->image_type = 2;
                    $saveCImh->save();
                }
            }
        }
        // Save taxes for category
        if (Input::get('has_tax') != '') {
            //echo "fsad";
            if (Input::get('has_tax') == '0') {
                //echo "inpu val ".Input::get('has_tax');
                $category->cat_tax()->detach();
            } else {
                //dd(count($category->cat_tax()));
                if (count($category->cat_tax()) > 0) {
                    $category->cat_tax()->detach();
                    $category->cat_tax()->attach(Input::get('has_tax'));
                } else {
                    $category->cat_tax()->attach(Input::get('has_tax'));
                }
            }
        }


        if (!empty(Input::get("parent_id")))
            $category->makeChildOf(Input::get("parent_id"));
        //dd(Input::get('return_url'));  
        $cat = Category::where('id', $category->id)->with('cat_tax')->first();
        $data = ["status" => 1, "msg" => "Category Added successfully.", 'category' => $cat];
        $url = "admin.apicat.view";
        //return redirect()->route('admin.products.general.info', ['id' => $prod->id]);
        $viewname = Config('constants.adminApiCatView') . '.index';
        return Helper::returnView($viewname, $data, $url);
    }

    public function delete() {
        $getId = Input::get('id');
        // print_r($getId);
        $cat = Category::find($getId);
//        $has_cats = Category::find($getId)->products;
//        print_r($has_cats);
//        if (!empty($has_cats)) {
//            $cats = Category::find($getId)->products()->detach();
//        }
        if ($cat->parent_id == 'NULL') {
            $catupdate = Category::find($getId);
            $catupdate->status = 0;
            $catupdate->update();
            $chidCatUpdate = $catupdate->children()->get();
            foreach ($chidCatUpdate as $childCat) {
                $childupdate = Category::find($childCat->id);
                $childupdate->status = 0;
                $childupdate->update();
            }
        } else {
            $catupdate = Category::find($getId);
            $catupdate->status = 0;
            $catupdate->update();
        }
        // return redirect()->back()->with("messege", "Category deleted successfully.");
        $viewname = Config('constants.adminApiCatView') . '.index';
        $data = ['status' => '1', 'msg' => 'Category deleted successfully.'];
        return Helper::returnView($viewname, $data, $url = 'admin.category.view');
    }

    public function catSeo() {
        $category = Category::find(Input::get('id'));
        $action = route("admin.category.saveCatSeo");
        //return view(Config('constants.adminApiCatView') . '.cat_seo', compact('category', 'action'));
        $viewname = Config('constants.adminApiCatView') . '.cat_seo';
        $data = ['category' => $category, 'action' => $action];
        return Helper::returnView($viewname, $data);
    }

    public function saveCatSeo() {
        //  dd(Input::all());
        $saveS = Category::findOrNew(Input::get('id'));
        $saveS->meta_title = Input::get("meta_title");
        $saveS->meta_keys = Input::get("meta_keys");
        $saveS->meta_desc = Input::get("meta_desc");
        $saveS->meta_robot = Input::get("meta_robot");
        $saveS->canonical = Input::get("canonical");
        $saveS->og_title = Input::get("og_title");
        $saveS->og_desc = Input::get("og_desc");
        $saveS->og_image = Input::get("og_image");
        $saveS->og_url = Input::get("og_url");
        $saveS->twitter_url = Input::get("twitter_url");
        $saveS->twitter_title = Input::get("twitter_title");
        $saveS->twitter_desc = Input::get("twitter_desc");
        $saveS->twitter_image = Input::get("twitter_image");
        $saveS->other_meta = Input::get("other_meta");
        $saveS->save();
        return redirect()->to(Input::get('return_url'));
    }

    public function sampleCategoryDownload() {
        $details = [];
        $arr = ['id', 'category', 'short_desc', 'long_desc', 'images', 'is_home', 'is_nav', 'url_key', 'meta_title', 'meta_keys', 'meta_desc', 'sort_order', 'parent_id', 'brandmake', 'brand_address', 'premiumness', 'vat', 'meta_robot', 'canonical', 'og_title', 'og_desc', 'og_image', 'og_url', 'twitter_url', 'twitter_title', 'twitter_desc', 'twitter_image', 'other_meta'];
        //$category = Category::get(['id', 'category', 'short_desc', 'long_desc', 'images', 'is_home', 'is_nav', 'url_key', 'meta_title', 'meta_keys', 'meta_desc', 'sort_order', 'parent_id', 'brandmake', 'brand_address', 'premiumness', 'vat', 'meta_robot', 'canonical', 'og_title', 'og_desc', 'og_image', 'og_url', 'twitter_url', 'twitter_title', 'twitter_desc', 'twitter_image', 'other_meta']);
        //$lastId = Category::first()->id;
        $lastId = DB::select(DB::raw("SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'c8cart01' AND TABLE_NAME = '" . DB::getTablePrefix() . "categories'"));
        //dd($lastId[0]->AUTO_INCREMENT);
        $sampleCat = [];
        array_push($sampleCat, $arr);
        $details = [$lastId[0]->AUTO_INCREMENT, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''];
        array_push($sampleCat, $details);
        return Helper::getCsv($sampleCat, 'category_sample.csv', ',');
    }

    public function sampleBulkDownload() {
        $details = [];
        $arr = ['id', 'category', 'short_desc', 'long_desc', 'images', 'is_home', 'is_nav', 'url_key', 'meta_title', 'meta_keys', 'meta_desc', 'sort_order', 'parent_id', 'brandmake', 'brand_address', 'premiumness', 'vat', 'meta_robot', 'canonical', 'og_title', 'og_desc', 'og_image', 'og_url', 'twitter_url', 'twitter_title', 'twitter_desc', 'twitter_image', 'other_meta'];
        $category = Category::get(['id', 'category', 'short_desc', 'long_desc', 'images', 'is_home', 'is_nav', 'url_key', 'meta_title', 'meta_keys', 'meta_desc', 'sort_order', 'parent_id', 'brandmake', 'brand_address', 'premiumness', 'vat', 'meta_robot', 'canonical', 'og_title', 'og_desc', 'og_image', 'og_url', 'twitter_url', 'twitter_title', 'twitter_desc', 'twitter_image', 'other_meta']);
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
                $cat->og_title,
                $cat->og_desc,
                $cat->og_image,
                $cat->og_url,
                $cat->twitter_url,
                $cat->twitter_title,
                $cat->twitter_desc,
                $cat->twitter_image,
                $cat->other_meta
            ];
            array_push($sampleCat, $details);
        }
        return Helper::getCsv($sampleCat, 'category_data.csv', ',');
    }

    public function categoryBulkUpload() {

        if (Input::hasFile('file')) {
            $file = Input::file('file');
            $name = time() . '-' . $file->getClientOriginalName();
            $path = public_path() . '/admin/uploads/products/';
            $file->move($path, $name);

            return $this->category_import_csv($path, $name);
        } else {

            echo "Please select file";
        }
    }

    private function category_import_csv($path, $filename) {
        $csv_file = $path . $filename;
        if (($handle = fopen($csv_file, "r")) !== FALSE) {
            fgetcsv($handle);
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
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
                $meta_title = $col[8];
                $meta_key = $col[9];
                $meta_desc = $col[10];
                $sort_order = $col[11];
                $parent_id = $col[12];
                $brandmake = $col[13];
                $brand_address = $col[14];
                $premiumness = $col[15];
                $vat = $col[16];
                $meta_robot = $col[17];
                $canonical = $col[18];
                $og_title = $col[19];
                $og_desc = $col[20];
                $og_image = $col[21];
                $og_url = $col[22];
                $twitter_url = $col[23];
                $twitter_title = $col[24];
                $twitter_desc = $col[25];
                $twitter_image = $col[26];
                $other_meta = $col[27];

                if (!empty($id)) {
                    $updateCat = Category::firstOrNew(array('id' => $id));
                    if (!empty($category))
                        $updateCat->category = $category;
                    if (!empty($short_desc))
                        $updateCat->short_desc = $short_desc;
                    if (!empty($long_desc))
                        $updateCat->long_desc = $long_desc;
                    if (!empty($is_home))
                        $updateCat->is_home = $is_home;
                    if (!empty($is_nav))
                        $updateCat->is_nav = $is_nav;
                    if (!empty($url_key))
                        $updateCat->url_key = $url_key;

                    if (!empty($meta_title))
                        $updateCat->meta_title = $meta_title;
                    if (!empty($meta_key))
                        $updateCat->meta_keys = $meta_key;
                    if (!empty($meta_desc))
                        $updateCat->meta_desc = $meta_desc;

                    if (!empty($sort_order))
                        $updateCat->sort_order = $sort_order;
                    if (!empty($parent_id))
                        $updateCat->parent_id = $parent_id;
                    if (!empty($brandmake))
                        $updateCat->brandmake = $brandmake;
                    if (!empty($brand_address))
                        $updateCat->brand_address = $brand_address;
                    if (!empty($premiumness))
                        $updateCat->premiumness = $premiumness;
                    if (!empty($vat))
                        $updateCat->vat = $vat;

                    if (!empty($meta_robot))
                        $updateCat->meta_robot = $meta_robot;

                    if (!empty($canonical))
                        $updateCat->canonical = $canonical;
                    if (!empty($og_title))
                        $updateCat->og_title = $og_title;
                    if (!empty($og_desc))
                        $updateCat->og_desc = $og_desc;
                    if (!empty($og_image))
                        $updateCat->og_image = $og_image;
                    if (!empty($og_url))
                        $updateCat->og_url = $og_url;

                    if (!empty($twitter_url))
                        $updateCat->twitter_url = $twitter_url;
                    if (!empty($twitter_title))
                        $updateCat->twitter_title = $twitter_title;
                    if (!empty($twitter_desc))
                        $updateCat->twitter_desc = $twitter_desc;
                    if (!empty($twitter_image))
                        $updateCat->twitter_image = $twitter_image;

                    $updateCat->save();

                    $catimgsData = explode(",", $catimgs);

                    if (!empty($catimgsData)) {
                        $updateCat->catimgs()->delete();
                        $getimgs = [];
                        foreach ($catimgsData as $fileNm) {
                            array_push($getimgs, new CatalogImage(array('filename' => $fileNm, 'image_type' => 2, 'image_mode', 1)));
                        }
                        $updateCat->catimgs()->saveMany($getimgs);
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

    public function catBulkImgUpload() {
        $path = '/public/Admin/uploads/catalog/category/';
        $upload_handler = new UploadHandler(null, true, null, $path);
    }

}
