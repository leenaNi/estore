<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Library\Helper;
use App\Models\Bank;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Document;
use App\Models\Merchant;
use App\Models\User;
use Auth;
use DB;
use Hash;
use Illuminate\Support\Facades\Input;
use Session;
use Validator;

class MerchantController extends Controller
{

    public function index(\Illuminate\Http\Request $request)
    {

        $headers = $request->headers->all();

        $allBanks = Bank::all();
        $bank['0'] = "Select Bank";
        foreach ($allBanks as $allB) {
            $bank[$allB->id] = $allB->name;
        }
        $userMerchant = User::where('id', Session::get('authUserId'))->first();
        if ($userMerchant != null) {
            $userMerchant = $userMerchant->store()->first();
        }

        if (Auth::guard('vswipe-users-web-guard')->check() !== false) {
            $merchants = Merchant::orderBy('id', 'desc');
        } else if (Auth::guard('bank-users-web-guard')->check() !== false) {
            $bkid = $this->getbankid();
            $merchants = Merchant::whereHas('hasMarchants', function ($q) use ($bkid) {
                $q->where("bank_id", $bkid);
            })->orderBy('id', 'desc');
        } else if (Auth::guard('merchant-users-web-guard')->check() !== false) {
            $merchants = Merchant::orderBy('id', 'desc')->where("id", @$userMerchant->merchant_id);
        } else if (array_key_exists('token', $headers)) {
            $merchants = Merchant::orderBy('id', 'desc')->where("id", @$userMerchant->merchant_id);
        }

        $search = Input::get('search');
        if (!empty($search)) {

            if (!empty(Input::get('s_bank_name'))) {
                $merchants = $merchants->whereHas("hasMerchants", function ($query) {
                    $query->where("banks.id", Input::get('s_bank_name'));
                });
            }
            if (!empty(Input::get('s_company_name'))) {
                $merchants = $merchants->where("firstname", "like", "%" . Input::get('s_company_name') . "%");
            }
            if (!empty(Input::get('s_email'))) {
                $merchants = $merchants->where("email", "like", "%" . Input::get('s_email') . "%");
            }
            if (!empty(Input::get('date_search'))) {
                $dateArr = explode(" - ", Input::get('date_search'));
                $fromdate = date("Y-m-d", strtotime($dateArr[0])) . " 00:00:00";
                $todate = date("Y-m-d", strtotime($dateArr[1])) . " 23:59:59";
                $merchants = $merchants->where("created_at", ">=", "$fromdate")->where("created_at", "<", "$todate");
            }
        }

        $merchants = $merchants->paginate(Config('constants.AdminPaginateNo'));
        // dd($merchants);
        // $res_merchant = [];
        // $i = 0;
        // foreach ($merchants as $dt) {
        //     $temp_data = New MerchantController;
        //     $temp_data->id = $dt["id"];
        //     $temp_data->email = $dt["email"];
        //     $temp_data->firstname = $dt["firstname"];
        //     $temp_data->lastname = $dt["lastname"];
        //     $temp_data->phone = $dt["phone"];
        //     $temp_data->created_at = $dt["created_at"];
        //     $temp_data->industry = json_decode($dt["register_details"])->business_name;
        //     $temp_data->currency = Currency::where("id", json_decode($dt["register_details"])->currency)->pluck('name')[0];
        //     $res_merchant[$i] = $temp_data;
        //     $i++;
        // }
        // dd($res_merchant);
        $data = [];
        $viewname = Config('constants.AdminPagesMerchant') . ".index";
        $data['merchants'] = $merchants;
        $data['bank'] = $bank;

        return Helper::returnView($viewname, $data);
    }

    public function addEdit()
    {
        // dd(Input::get('id'));
        $merchant = Merchant::findOrNew(Input::get('id'));
        $data = [];
        $data['already_selling'] = [];
        if ($merchant && Input::get('id')) {
            $resgister_details = json_decode($merchant->register_details);
            $data['cat_selected'] = $resgister_details->business_type;
            $data['curr_selected'] = $resgister_details->currency;
            $data['already_selling'] = ($resgister_details->already_selling);
            $data['store_version'] = ($resgister_details->store_version);
        }

        $cat = Category::where("status", 1)->pluck('category', 'id')->prepend('Choose your Industry *', '');
        $curr = Currency::where('status', 1)->orderBy("iso_code", "asc")->get(['status', 'id', 'name', 'iso_code']);

        $viewname = Config('constants.AdminPagesMerchant') . ".addEdit";
        $data['merchant'] = $merchant;
        $data['cat'] = $cat;
        $data['curr'] = $curr;
        //dd($data);
        return Helper::returnView($viewname, $data);
    }

    public function saveUpdate()
    {

        $validation = new Merchant();
        $merchant = Merchant::findOrNew(Input::get('id'));
        $business_name = Category::where("id", (int) Input::get('business_type'))->get(['category'])->toArray();
        $validator = Validator::make(Input::all(), Merchant::rules(Input::get('id')), $validation->messages);
        if ($validator->fails()) {
            return $validator->messages()->toJson();
        } else {
            if (empty(Input::get('id'))) {
                $password = Hash::make(Input::get('password'));

                //for new merchant
                $addArr = ['bank_id' => $this->getbankid(), 'added_by' => Session::get('authUserId')];
                if (empty($chkmerch)) {
                    //new merchants gets created
                    $merchant = Merchant::findOrNew(Input::get('id'));
                    $merchant->fill(Input::all());
                    $merchant->register_details = json_encode(collect(Input::all())->except('_token', 'id', 'existing_mid'));
                    $merchant->password = $password;
                    $merchant->save();

                    if (!empty($this->getbankid())) {
                        $merchant->hasMarchants()->attach($merchant->id, $addArr);
                    }

                } else {
                    //existing merchant gets add
                    $merchant = Merchant::findOrNew($chkmerch->id);
                    if (!empty($this->getbankid())) {
                        $merchant->hasMarchants()->attach($merchant->id, $addArr);
                    } else {
                        return "VsMerchantError";
                    }
                }

                if (!empty($merchant)) {
                    $sub = "Login credentials for " . $merchant->company_name . ". You can create one or more store using app";
                    $mailcontent = "Your login Email ID - " . $merchant->email . "\n";
                    $mailcontent .= "Password - " . Input::get('password') . "\n";
                    Helper::withoutViewSendMail($merchant->email, $sub, $mailcontent);
                }
            } else {
                //for update
                $updateArr = ["updated_by" => Session::get('authUserId')];
                $merchant = Merchant::findOrNew(Input::get('id'));
                $merchant->fill(Input::all());
                $all_data = Input::all();
                $all_data["business_name"] = $business_name[0]["category"];
                // $merchant->register_details = json_encode(collect(Input::all())->except('_token', 'id', 'existing_mid'));
                $merchant->register_details = json_encode(collect($all_data)->except('_token', 'id', 'existing_mid'));

                $merchant->save();
                if (!empty($this->getbankid())) {
                    $hasmer = $merchant->hasMarchants()->withPivot('id', 'bank_id', 'merchant_id', 'added_by', 'updated_by', 'created_at', 'updated_at')->get();
                    if (!empty($hasmer)) {
                        foreach ($hasmer as $hm) {
                            $merchant->hasMarchants()->updateExistingPivot($hm->pivot->bank_id, $updateArr);
                        }
                    }
                }
            }
            $data['id'] = $merchant->id;
            $data['merchant'] = $merchant;
            $data['docs'] = @$merchant->documents()->get();
            $data['status'] = "Saved successfully";

            return Helper::returnView(null, $data);
        }
    }

    public function saveUpdateDocuments(\Illuminate\Http\Request $request)
    {
        $validation = new Merchant();
        $rules = ['des.*' => 'required', 'docs.*' => 'required|mimes:png,gif,jpeg,txt,pdf,doc'];
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return $validator->errors()->all();
        } else {
            foreach (Input::get('des') as $imgK => $imgV) {
                $saveCImh = Document::findOrNew(Input::get('id_doc')[$imgK]);
                $saveCImh->parent_id = Input::get('id');
                if (Input::get('is_doc')[$imgK] == 1) {
                    $file = Input::file('docs')[$imgK];
                    $destinationPath = public_path() . '/public/admin/uploads/merchantDocuments/';
                    $fileName = "doc-" . $imgK . date("YmdHis") . "." . $file->getClientOriginalExtension();
                    $upload_success = $file->move($destinationPath, $fileName);
                    $saveCImh->filename = is_null($fileName) ? $saveCImh->filename : $fileName;
                } else {
                    //echo "llll";
                    $fileName = null;
                }
                $saveCImh->doc_type = 1;
                $saveCImh->des = Input::get('des')[$imgK];
                $saveCImh->save();
            }
            $data['documents'] = Merchant::find(Input::get('id'))->documents()->get();
            $data['status'] = "Saved successfully";
            if ($request->submitbutton == 'Save & Exit') {
                $redirectView = 'admin.merchants.view';
            } else {
                // $redirectView = ;
                return redirect()->back();
            }
            return Helper::returnView(null, $data, $redirectView);
        }
    }

    public function deleteDocument()
    {
        $id = Input::get('docId');
        $del = Document::find($id);
        $del->delete();
        echo "Successfully deleted";
    }

    public function merchantAutocomplete()
    {
        $term = Input::get('term');
        $getMerchants = [];
        $merchants = Merchant::where("company_name", "like", "%" . $term . "%")->get();
        foreach ($merchants as $merch) {
            $getMerchants[$merch->id]['label'] = $merch->company_name;
            $getMerchants[$merch->id]['value'] = $merch->company_name;
            $getMerchants[$merch->id]['existing_mid'] = $merch->id;
            $getMerchants[$merch->id]['data'] = $merch;
        }
        echo json_encode($getMerchants);
    }

    public function checkExistingMerchant()
    {
        $term = Input::get('term');
        $getMerchants = [];
        $merchants = Merchant::where("company_name", "like", "$term")->get();
        foreach ($merchants as $merch) {
            $getMerchants['label'] = $merch->company_name;
            $getMerchants['value'] = $merch->company_name;
            $getMerchants['existing_mid'] = $merch->id;
            $getMerchants['data'] = $merch;
        }
        //$data['merchants'] = $getMerchants;
        return $getMerchants;
    }

    public function storeSetUp()
    {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $storePath = base_path() . '/merchants/' . $merchant->url_key;
        $industry = Helper::getStoreSettings($storePath)['industry_id'];
        $popupStatus = DB::table($merchant->prefix . '_general_setting')->where('name', 'set_popup')->first()->status;
        //$popupStatus=1;
        $questionCategory = DB::table($merchant->prefix . '_question_category')->get();
        $dsd = DB::table($merchant->prefix . '_has_industries')->where("industry_id", $industry)->select(["general_setting_id"])->get();
        foreach ($dsd as $d) {
            $id[] = $d->general_setting_id;
        }

        $settingData = [];
        $featureData = [];
        $features = DB::table($merchant->prefix . '_general_setting')->where('is_active', 1)->orderBy('sort_order', 'DESC')->where('name', '<>', 'set_popup')->whereIn('id', $id)->get(["id", "name", "status", "details", "url_key", "question_category_id", "info"]);
        foreach ($questionCategory as $cat) {
            foreach ($features as $feature) {
                if ($cat->id == $feature->question_category_id) {
                    $featureData[$cat->category][] = $feature;
                }
            }
        }
        if ($popupStatus) {
            $set_popup = DB::table($merchant->prefix . '_general_setting')->where('is_question', 1)->orderBy('question_category_id', 'DESC')->where('name', '<>', 'set_popup')->whereIn('id', $id)->get();

            foreach ($questionCategory as $cat) {
                foreach ($set_popup as $setting) {
                    if ($cat->id == $setting->question_category_id) {
                        $settingData[$cat->category][] = $setting;
                    }
                }
            }
//     $set_popup = DB::table($merchant->prefix.'_general_setting')->where('is_question',1)->orderBy('sort_order','DESC')->where('name','<>','set_popup')->where('question_category_id',1)
            //             ->join($merchant->prefix.'_has_industries',$merchant->prefix.'_has_industries.general_setting_id','=',$merchant->prefix.'_general_setting.id')->get();
        } else {
            $set_popup = [];
        }
        $data = ['set_popup' => $settingData, 'popup_status' => $popupStatus, 'featuresActivation' => $featureData];
        $viewname = '';
        return Helper::returnView($viewname, $data);
    }

    public function storeSetUpSave()
    {
        $marchantId = Input::get("merchantId");
        $settingData = Input::get("questions");

//$settingData = json_decode(json_encode($settingData),true);
        // dd($settingData);
        // $settingData=[array("id"=>10,'status'=>0),array("id"=>11,'status'=>1)];
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $settingData = json_decode($settingData, true);
        foreach ($settingData as $value) {

            $status['status'] = $value['status'];
            if ($value['url_key'] == 'default-courier') {
                if (Input::get("courier_id")) {
                    $courier['courier_id'] = Input::get("courier_id");
                    $courier['preference'] = 1;
                    $courier['store_id'] = $merchant->id;
                    $courier['status'] = 1;
                    DB::table("has_couriers")->insert($courier);
                }
            }
            //$ids[]=$value['id'];
            DB::table($merchant->prefix . '_general_setting')->where('id', $value['id'])->update($status);
            // $ids[]=$value['id'];
        }
        $general = [];
        $popupStatus['status'] = 0;

        $popupStatus = DB::table($merchant->prefix . '_general_setting')->where('name', 'set_popup')->update($popupStatus);

        $data = [];
        $data['status'] = "success";
        // $data['general'] = $general;
        return $data;
        //  dd($ids);
    }

    public function storeDesign()
    {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $storePath = base_path() . '/merchants/' . $merchant->url_key;
        $store = Helper::getStoreSettings($storePath)['logo'];

        $homePageSlider = DB::table($merchant->prefix . '_has_layouts')->where('layout_id', 1)->whereColumn('updated_at', '>', 'created_at')->count();
        // dd($homePageSlider);
        $homePage3boxs = DB::table($merchant->prefix . '_has_layouts')->where('layout_id', 4)->whereColumn("updated_at", '>', "created_at")->count();
        $categories = DB::table($merchant->prefix . '_categories')->where('status', 1)->where('is_nav', 1)->whereColumn("updated_at", '>', "created_at")->get();
        $products = DB::table($merchant->prefix . '_products')->where('status', 1)->where('is_individual', 1)->get();
        $contact = DB::table($merchant->prefix . '_contacts')->where('status', 1)->get();

        $data = ['is_logo' => count($store), 'is_homePageSlider' => $homePageSlider, 'is_category' => count($categories), 'is_product' => count($products), 'is_contact' => count($contact), 'homePage3boxs' => $homePage3boxs];
        $viewname = '';
        return Helper::returnView($viewname, $data);
    }

    public function storeLogo()
    {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $storePath = base_path() . '/merchants/' . $merchant->url_key;
        $store = Helper::getStoreSettings($storePath)['logo'];
        $filePath = $merchant->url_key . '.' . $_SERVER['HTTP_HOST'] . '/uploads/layout/';
        $homePageSlider = DB::table($merchant->prefix . '_has_layouts')->where('layout_id', 1)->orderBy("sort_order", "asc")->get();
        $homePageThreeBoxes = DB::table($merchant->prefix . '_has_layouts')->where('layout_id', 4)->orderBy("sort_order", "asc")->get();
//   $categories= DB::table($merchant->prefix.'_categories')->where('status',1)->where('is_home',1)->get();
        //   $products= DB::table($merchant->prefix.'_products')->where('status',1)->where('is_individual',1)->get();
        //   $contact= DB::table($merchant->prefix.'_contacts')->where('status',1)->get();
        $data = ['storeLogo' => $store, 'homePageSlider' => $homePageSlider, 'homePageThreeBoxes' => $homePageThreeBoxes, 'filePath' => $filePath];
        $viewname = '';
        return Helper::returnView($viewname, $data);
    }

    public function updateStoreLogo()
    {
        $marchantId = Input::get("merchantId");
        $logoType = Input::get("logoType");
        $logoImage = Input::get("logoImage");
        //$imageData=Input::get("");
        // dd(Input::all());
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
// $data=json_decode($data);
        // foreach($data as $data1){
        //     dd($data1->status);
        // }
        //DB::table($merchant->prefix.'_has_layouts')->where('layout_id', 1)->delete();
        if ($logoType == 1) {
            $storePath = base_path() . '/merchants/' . $merchant->url_key;
            // dd($storePath);
            $store = Helper::getStoreSettings($storePath);
            //  dd($store);
            $store['logo'] = $logoImage;

            $newSoter = json_encode($store);
            Helper::updateStoreSettings($storePath, $newSoter);
            $data = ["status" => 1, "msg" => "Logo Updated successfully."];
        } elseif ($logoType == 2) {
            $logoImage = json_decode($logoImage);
            foreach ($logoImage as $key => $logoArray) {
                $layoutdata = [];

                $layoutdata['layout_id'] = 1;
                $layoutdata['is_active'] = $logoArray->status;
                $layoutdata['sort_order'] = $logoArray->sort_order;
                $layoutdata['name'] = $logoArray->name;
                $layoutdata['link'] = $logoArray->link;
                $layoutdata['updated_at'] = date("y-m-d h:i:s");
                $logoimageData = $logoArray->image_base64;

                if ($logoimageData) {
                    $datetime = "";
                    $image_parts = explode(";base64,", $logoimageData);
                    $image_type_aux = explode("image/", $image_parts[0]);

                    $image_type = $image_type_aux[1];
                    $imgName = 'banner_' . date("YmdHis") . $key . '.' . $image_type;
                    $image_base64 = base64_decode($image_parts[1]);
                    $filePath = base_path() . '/merchants/' . $merchant->url_key . '/public/uploads/layout/' . $imgName;
                    $images = file_put_contents($filePath, $image_base64);
                    $layoutdata['image'] = $imgName;
                    if ($logoArray->id) {
                        DB::table($merchant->prefix . '_has_layouts')->where('id', $logoArray->id)->update($layoutdata);
                    } else {
                        DB::table($merchant->prefix . '_has_layouts')->insert($layoutdata);
                    }
                } else {
                    DB::table($merchant->prefix . '_has_layouts')->where('id', $logoArray->id)->update($layoutdata);
                }
            }
            $data = ["status" => 1, "msg" => "Banner image updated successfully."];
        } elseif ($logoType == 3) {
            $logoImage = json_decode($logoImage);
            foreach ($logoImage as $key => $logoArray) {
                $layoutdata = [];

                $layoutdata['layout_id'] = 4;
                $layoutdata['is_active'] = $logoArray->status;
                $layoutdata['sort_order'] = $logoArray->sort_order;
                $layoutdata['name'] = $logoArray->name;
                $layoutdata['link'] = $logoArray->link;
                $layoutdata['updated_at'] = date("y-m-d h:i:s");
                $logoimageData = $logoArray->image_base64;
                if ($logoimageData) {
                    $datetime = "";
                    $image_parts = explode(";base64,", $logoimageData);
                    $image_type_aux = explode("image/", $image_parts[0]);

                    $image_type = $image_type_aux[1];
                    $imgName = 'three_' . date("YmdHis") . $key . '.' . $image_type;
                    $image_base64 = base64_decode($image_parts[1]);
                    $filePath = base_path() . '/merchants/' . $merchant->url_key . '/public/uploads/layout/' . $imgName;
                    $images = file_put_contents($filePath, $image_base64);
                    $layoutdata['image'] = $imgName;
                    if ($logoArray->id) {
                        DB::table($merchant->prefix . '_has_layouts')->where('id', $logoArray->id)->update($layoutdata);
                    } else {
                        DB::table($merchant->prefix . '_has_layouts')->insert($layoutdata);
                    }
                } else {
                    DB::table($merchant->prefix . '_has_layouts')->where('id', $logoArray->id)->update($layoutdata);
                }
            }
            $data = ["status" => 1, "msg" => "Home page 3 boxes updated successfully."];
        }
        $viewname = '';
        return Helper::returnView($viewname, $data);
    }

    public function getCategory()
    {
        $marchantId = Input::get("merchantId");
        // $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $merchant = User::find(Input::get('merchantId'))->getstores()->first();
        $categories = DB::table('store_categories')->where('store_categories.store_id', $merchant->id)
            ->join('categories', 'categories.id', '=', 'store_categories.category_id')
            ->select("store_categories.id", "categories.category", "store_categories.url_key", "store_categories.status")->get();
        foreach ($categories as $category) {
            $category->catImage = "http://" . $merchant->url_key . '.' . $_SERVER['HTTP_HOST'] . '/uploads/catalog/category/' . @DB::table('catalog_images')->where("image_type", 2)->where('catalog_id', $category->id)->latest()->first()->filename;
        }
        $data = ['categories' => $categories];
        $viewname = '';
        return Helper::returnView($viewname, $data);
    }

    public function updateCategory()
    {
        $marchantId = Input::get("merchantId");
        $categories = Input::get("categories");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $categoryData = json_decode($categories, true);
        // dd($categories);
        foreach ($categoryData as $value) {
            $status['status'] = $value['status'];
            $status['updated_at'] = date("y-m-d h:i:s");
            DB::table('store_categories')->where('id', $value['id'])->update($status);
        }
        $data = [];
        $data['status'] = "success";
        $viewname = '';
        return Helper::returnView($viewname, $data);
    }

    public function getContactInfo()
    {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $contact = DB::table($merchant->prefix . '_contacts')->get();
        $data = ['contact' => $contact];
        $viewname = '';
        return Helper::returnView($viewname, $data);
    }

    public function updateContactInfo()
    {
        $marchantId = Input::get("merchantId");
        $id = Input::get("id");
        $customer_name = Input::get("contact_name");
        $phone_no = Input::get("phone_no");
        $email = Input::get("email");
        $address = Input::get("address");

        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $contactData['customer_name'] = $customer_name;
        $contactData['phone_no'] = $phone_no;
        $contactData['email'] = $email;
        $contactData['address'] = $address;

        $contact = DB::table($merchant->prefix . '_contacts')->where('id', Input::get("id"))->update($contactData);
        $data = [];
        $data['status'] = "success";
        $data['contact'] = $contact;
        $viewname = '';
        return Helper::returnView($viewname, $data);
    }

    public function getProducts()
    {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $products = DB::table($merchant->prefix . '_products')->where("is_individual", 1)->where("status", 1)->get();
        $data = [];
        $data['products'] = $products;
        $viewname = '';
        return Helper::returnView($viewname, $data);
    }

    public function viewStore()
    {
        $marchantId = Input::get("merchantId");

        //  $data= $_SERVER['SERVER_NAME'];
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();

        $viewname = '';
        $data = $_SERVER['SERVER_NAME'] . '/' . $merchant->url_key;
        return Helper::returnView($viewname, $data);
    }

    public function featureList()
    {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $settings = DB::table($merchant->prefix . '_general_setting')->get();
        $storePath = base_path() . '/merchants/' . $merchant->url_key;
        $currencyid = Helper::getStoreSettings($storePath)['currencyId'];

        $currency = DB::table('has_currency')->where('iso_code', $currencyid)->first();
        foreach ($settings as $key => $value) {
            $general[strtolower($value->url_key)] = $value->status;
        }
        $data = ['general' => $general, 'currency' => $currency];
        return $data;
    }

    public function saveCategory()
    {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $id = Input::get("id");
        $categories = [];
        $categories['category'] = Input::get("category");
        $categories['is_home'] = Input::get("is_home");
        $categories['is_nav'] = Input::get("is_nav");
        $categories['status'] = Input::get("status");
        $categories['sort_order'] = Input::get("sort_order");
        $categories['url_key'] = strtolower(str_replace(" ", "-", Input::get('category')));
        //$category->url_key = strtolower(str_replace(" ","-",Input::get('category')));

        if ($id) {
            $settings = DB::table($merchant->prefix . '_categories')->where('id', $id)->update($categories);
            $category = DB::table($merchant->prefix . '_categories')->where('id', $id)->first();
            if (Input::get('cat_img')) {
                $catImag = Input::get('cat_img');
                $this->addCatImage($catImag, $id, Input::get("category"), $merchant);
            }
            $category->catImage = "http://" . $merchant->url_key . '.' . $_SERVER['HTTP_HOST'] . '/uploads/catalog/category/' . @DB::table($merchant->prefix . '_catalog_images')->where("image_type", 2)->where('catalog_id', $id)->latest()->first()->filename;
            $data = ["status" => 1, "msg" => "category updated successfuly", "category" => $category];
        } else {
            $last2 = DB::table($merchant->prefix . '_categories')->orderBy('id', 'desc')->first();
            $categories['rgt'] = $last2->rgt + 2;
            $categories['lft'] = $last2->lft + 2;
            $categories['depth'] = 0;
            $catId = DB::table($merchant->prefix . '_categories')->insertGetId($categories);
            if (Input::get('cat_img')) {
                $catImag = Input::get('cat_img');
                $this->addCatImage($catImag, $catId, Input::get("category"), $merchant);
            }
            $category = DB::table($merchant->prefix . '_categories')->find($catId);
            $category->catImage = "http://" . $merchant->url_key . '.' . $_SERVER['HTTP_HOST'] . '/uploads/catalog/category/' . @DB::table($merchant->prefix . '_catalog_images')->where("image_type", 2)->where('catalog_id', $catId)->latest()->first()->filename;
            $data = ["status" => 1, "msg" => "category add successfuly", "category" => $category];
        }
        // dd($data);
        return $data;
    }

    public function addCatImage($catImage, $catId, $catName, $merchant)
    {
        if ($catImage) {
            //$catImage=Input::get('cat_img');
            $image_parts = explode(";base64,", $catImage);
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $imgName = "cat_" . date("YmdHis") . '.' . $image_type;
            $image_base64 = base64_decode($image_parts[1]);
            $filePath = base_path() . '/merchants/' . $merchant->url_key . '/public/uploads/catalog/category/' . $imgName;
            $images = file_put_contents($filePath, $image_base64);
            $catlog = [];
            $catlog['filename'] = $imgName;
            $catlog['alt_text'] = $catName;
            $catlog['image_type'] = 2;
            $catlog['image_mode'] = 1;
            $catlog['catalog_id'] = $catId;
            DB::table($merchant->prefix . '_catalog_images')->insert($catlog);
        }
        return 1;
    }

    public function deleteCategory()
    {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $getId = Input::get('id');
        $cat = DB::table($prifix . '_categories')->find($getId);

        if ($cat->parent_id == null) {
            $chidCat = DB::table($prifix . '_categories')->where("id", $cat->parent_id)->get();
            if (count($chidCat) > 0) {
                $data = ['status' => 'error', 'msg' => 'Sorry, Can not delete this root category.'];
            } else {

                DB::table($prifix . '_categories')->delete($cat->id);
                $data = ['status' => 'success', 'msg' => ' Root category deleted successfully.'];
            }
        } else {
            $catupdate = DB::table($prifix . '_categories')->find($getId);
            $chidCatUpdate = DB::table($prifix . '_categories')->where("id", $cat->parent_id)->get();
            if (count($chidCatUpdate) > 0) {
                $flag = 0;
                foreach ($chidCatUpdate as $childCat) {
                    $childupdate = DB::table($prifix . '_categories')->find($childCat->id);
                    $getProductInfo = $this->check_product($childupdate, $prifix);
                    if (count($getProductInfo) > 0) {
                        $flag++;
                    }
                }
                if ($flag == 0) {

                    DB::table($prifix . '_categories')->delete($catupdate->id);
                    $data = ['status' => 'success', 'msg' => 'Category deleted successfully.'];
                } else {
                    $data = ['status' => 'error', 'msg' => "Sorry, This category and it's sub categoty is part of a product. Delete the sub category first."];
                }
            } else {
                $productInfo = $this->check_product($catupdate, $prifix);
                if (count($productInfo) > 0) {
                    $data = ['status' => 'error', 'msg' => 'Sorry, This category is a part of a product, So remove the product from this category first'];
                } else {
                    DB::table($prifix . '_categories')->delete($catupdate->id);

                    $data = ['status' => 'success', 'msg' => 'Category deleted successfully.'];
                }
            }
        }
        return $data;
    }

    public function check_product($product, $prifix)
    {
        $productInfo = DB::table($prifix . '_products')
            ->join($prifix . '_categories', $prifix . '_categories.id', '=', $prifix . '_products.id')
            ->get();

        return $productInfo;
    }

    public function checkExistingUser()
    {
        $chkEmail = Merchant::where("email", Input::get('email'))->first();
        if (count($chkEmail) > 0) {
            return 1;
        } else {
            return 0;
        }

    }

    public function checkExistingphone()
    {
        $chkEmail = Merchant::where("phone", Input::get('phone_no'))->first();
        if (count($chkEmail) > 0) {
            return 1;
        } else {
            return 0;
        }

    }

    public function updateFeature()
    {
        $marchantId = Input::get("merchantId");
        $id = Input::get("id");
        $status = Input::get("status");

        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $featuredata = [];
        if ($id) {
            $featuredata['status'] = $status;
            if (!empty(Input::get("details"))) {
                $featuredata['details'] = Input::get("details");
            }

            DB::table($merchant->prefix . '_general_setting')->where('id', $id)->update($featuredata);
            $feature = DB::table($merchant->prefix . '_general_setting')->find($id);
            $general = [];
            $general[strtolower($feature->url_key)] = $feature->status;
//         foreach ($feature as $key => $value) {
            //
            //        }
            return $data = ['status' => 1, 'msg' => "Feature status change successfully", "feature" => $feature, "general" => $general];
        } else {
            return $data = ['status' => 0, 'msg' => "Opps somethings went wromg"];
        }
    }

    public function storeInfo()
    {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $prifix = $merchant->prefix;
        $storePath = base_path() . '/merchants/' . $merchant->url_key;
        $store = Helper::getStoreSettings($storePath)['storeName'];
        $storeData = DB::table($prifix . '_static_pages')->where("url_key", "contact-us")->first()->contact_details;
        $storeData = json_decode($storeData);
        $data['storeContact'] = $storeData;
        $data['storeName'] = $store;
        //dd($storeData);
        return $data;
    }
    public function getCourier()
    {

        $couriers = DB::table('couriers')->where("status", "1")->get(["id", "name"]);
        $data['couriers'] = $couriers;
        return $data;
    }
}
