<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use App\Models\Notification;
use App\Models\Newsletter;
use App\Models\Courier;
use App\Library\Helper;
use App\Models\Store;
use App\Models\Merchants;
use App\Models\Category;
use App\Models\industries;
use App\Models\StoreTheme;
use File,DB;
use Validator;
use session;
use Input;

class HomeController extends Controller {

    public function index_old() {
        if (!empty(config('app.industry'))) {
            $general_setting = GeneralSetting::where('is_question', 1)->where('name', '<>', 'set_popup')->orderBy('sort_order', 'DESC')->whereHas('industry', function($que) {
                $que->where("industry_id",config('app.industry'));
            });
        } else {
            $general_setting = GeneralSetting::where('is_question', 1)->where('is_active', 1)->where('name', '<>', 'set_popup')->orderBy('sort_order', 'DESC');
        }

        $general_setting = $general_setting->get();
        //  dd($general_setting);
        $courier = Courier::where("status", 1)->get(["name", "id"]);
        $set_popup = GeneralSetting::where('name', 'set_popup')->first();
        return view('Admin.pages.home.index', ['general_setting' => $general_setting, 'set_popup' => $set_popup, 'courier' => $courier]);
    }

    public function index() {
       
        $hostUrl = $_SERVER['HTTP_HOST'];
        $templateId = 0;
        $loggedInUserType = session::get('login_user_type');
        if($loggedInUserType == 1)//For merchants only
        {
            $allinput = json_decode(Merchants::find(Session::get('merchantid'))->register_details, true);
            if(!empty($allinput) && (!empty($allinput['templateId'])) )
            {
                $templateId = $allinput['templateId'];
            }
        }
        
        $general_setting = GeneralSetting::where('is_question', 1)->where('is_active', 1)->where('name', '<>', 'set_popup')->orderBy('sort_order', 'DESC');
       
        $general_setting = $general_setting->get();
        //  dd($general_setting);
        $courier = Courier::where("status", 1)->get(["name", "id"]);
        $set_popup = GeneralSetting::where('name', 'set_popup')->first();
        return view('Admin.pages.home.index', ['general_setting' => $general_setting, 'set_popup' => $set_popup, 'courier' => $courier, 'templateId' => $templateId, 'hostUrl' => $hostUrl]);
    }

    //Display Theme in Merchant Admin Panel
    public function showMerchantAdminThemes()
    {
        if (Session::get('merchantid')) {

            $allinput = json_decode(Merchants::find(Session::get('merchantid'))->register_details, true);
           
            //DB::enableQueryLog(); // Enable query log
            $cats = industries::where("status", 1)->where("id", $allinput['business_type'])->get();
            //dd(DB::getQueryLog()); // Show results of log
        } else {
            $cats = industries::where("status", 1)->get();
        }
        $data = ['cats' => $cats];
      
        return view('Admin.pages.home.getMerchantAdminTheme', ['cats' => $data]);
        //$viewname = Config('constants.frontendView') . ".show-themes";
        //return Helper::returnView($viewname, $data);
    }

    public function applyMerchantAdminThemes()
    {   
       
        $merchantId = Session::get('merchantid');
        $storeId =  Session::get('store_id');
           $allinput = json_decode(Merchants::find(Session::get('merchantid'))->register_details, true);
           $storeName = $allinput['store_name'];
           //echo "storeName =::".$storeName;

        if(!empty(Input::get('cateId')))
        {
           $categoryId = Input::get('cateId');
           $themeid = Input::get('themeId');
           
            $themedata = DB::select("SELECT t.id,c.category,t.theme_category as name,t.image from themes t left join categories c on t.cat_id=c.id where t.cat_id = " . $categoryId . " order by c.category");
            $decodeVal['theme'] = strtolower(StoreTheme::find($themeid)->theme_category);
            $decodeVal['themeid'] = $themeid;
            $decodeVal['themedata'] = $themedata;

            //update storesetting json file
            $storePath = base_path() . '/'. $storeName;
            // $storePath = '';
            $store = Helper::getStoreSettings($storePath);
            $store['theme'] = strtolower(StoreTheme::find($themeid)->theme_category);
            $store['themeid'] = $themeid;
            $store['themedata'] = $themedata;

            $newSoter = json_encode($store);
            Helper::updateStoreSettings($storePath, $newSoter);

            //update register_details json column in merchants table
            $merchantObj = Merchants::find($merchantId);
            $registerDetails = json_decode($merchantObj->register_details, true);
            $registerDetails['templateId'] = $themeid;
            $merchantObj->register_details = json_encode($registerDetails);
            $merchantObj->save();

            //insert banner and layout data into has_layout table
            $basePath = base_path();
            $basePathUrl = implode("/", explode('\\', $basePath, -1));
            $source = $basePathUrl . '/public/public/admin/themes/';
            $destination = $basePathUrl . "/merchants/" . strtolower($storeName) . "/public/uploads/layout/";
           
            $banner = json_decode((DB::table("themes")->where("id", $themeid)->first()->banner_image), true);
           
            if (!empty($banner)) {
                $homeLayout = DB::table("layout")
                            ->where('url_key', 'LIKE', 'home-page-slider')
                            ->where('store_id', $storeId)
                            ->where('is_del', 0)
                            ->first();
                foreach ($banner as $image) {
                    $homePageSlider = [];
                    $file = $image['banner'];
                    $homePageSlider['layout_id'] = $homeLayout->id;
                    $homePageSlider['name'] = $image['banner_text'];
                    $homePageSlider['is_active'] = $image['banner_status'];
                    $homePageSlider['image'] = $image['banner'];
                    $homePageSlider['sort_order'] = $image['sort_order'];
                    //$source = $basePathUrl . '/public/admin/themes/';
                    //$source = public_path() . '/public/admin/themes/';
                    //$destination = base_path() . "/" . strtolower($storeName) . "/public/uploads/layout/";
                    copy($source . $file, $destination . $file);
                    DB::table("has_layouts")->insert($homePageSlider);
                }
            }
            $threeBoxes = json_decode((DB::table("industries")->where("id", $categoryId)->first()->threebox_image), true);
           
            if (!empty($threeBoxes)) {
                $boxLayout = DB::table("layout")
                            ->where('url_key', 'LIKE', 'home-page-3-boxes')
                            ->where('store_id', $storeId)
                            ->where('is_del', 0)
                            ->first();
                foreach ($threeBoxes as $image) {
                    $homePageSlider = [];
                    $file = $image['banner'];
                    $homePageSlider['layout_id'] = $boxLayout->id;
                    $homePageSlider['name'] = $image['banner_text'];
                    $homePageSlider['is_active'] = $image['banner_status'];
                    $homePageSlider['image'] = $image['banner'];
                    $homePageSlider['sort_order'] = $image['sort_order'];
                    //$source = public_path() . '/public/admin/themes/';
                    //$destination = base_path() . "/" . strtolower($storeName) . "/public/uploads/layout/";
                    copy($source . $file, $destination . $file);
                    DB::table("has_layouts")->insert($homePageSlider);
                }
            }

            $data = ["status" => 1, "msg" => "Theme Updated successfully."];
            Session::put('selectedThemeStatus', 1);
        }
        else
        {
            $data = ["status" => 0, "msg" => "There is something wrong please try again!"];
            Session::put('selectedThemeStatus', 0);
        }
        return redirect()->route('admin.home.view');
       //return view('admin.home.view', $data);
    }

    public function setPref() {
        return view('Admin.pages.home.setpref');
    }

    public function changePopupStatus() {
        $setting = GeneralSetting::where('name', 'set_popup')->update(['status' => 0]);
        if ($setting)
            echo 'success';
        else
            echo 'some error occure';
    }
 

    public function newsLetter() {
        // DB::enableQueryLog();
        $newsLetters = Notification::paginate(Config('constants.paginateNo'));
        // dd(DB::getQueryLog());
        $img = DB::table("general_setting")->select('details','status','is_active')->where('url_key', 'notification')->first();
        $imgpath = json_decode($img->details,true);
        $result['status'] = $img->status;
        $result['is_active'] = $img->is_active;
        $result['img_path'] = Config('constants.newletterImgPath').'/'.$imgpath['img_path'];
        $result['displayHeader'] = isset($imgpath['displayHeader']) ? $imgpath['displayHeader'] : '';
        $result['displayContent'] = isset($imgpath['displayContent']) ? $imgpath['displayContent'] : '';
        return view('Admin.pages.home.newsLetter', ['newsLetters' => $newsLetters,'result' => $result]);
    }

    public function saveNewsLetter(Request $request){
        $rules = [
            'enablesub' => 'required',
            'newsLetterimg' => 'file|mimes:jpeg,png,jpg|max:1024',
        ];
        $messages = array(
            'enablesub.required' => 'This Radio Field is required',
            'newsLetterimg.required' => 'Please Select Image',
            'newsLetterimg.max' => 'Upload file size should not be more than 1 MB',
            'newsLetterimg.mimes' => 'File should of type jpeg,png,jpg',
            
        );
       $validator = Validator::make($request->all(), $rules,$messages);
       if ($validator->fails()) {
            $errors = $validator->messages();
            return redirect()->to($this->getRedirectUrl())
                    ->withInput($request->input())
                    ->withErrors($errors, $this->errorBag());
        }else{
            $currentURL = explode('/',$request->root());
            $currentURL = explode('.',$currentURL[2]);
            $domain_name = current($currentURL);
            $domainname = strtolower($domain_name);
            // $path = base_path() ."/$domainname/public/uploads/newsletter/";
            $path = Config('constants.newsLetterUploadImgPath') . "/";
            // dd($path);
            $mk = File::makeDirectory($path, 0777, true, true);
            if ($request->hasFile('newsLetterimg')) {
                $file = $request->file('newsLetterimg');
                $name = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $timestp = date("Y-m-d-H-i-s");
                $newsletter_pic_name = strtolower($timestp.'_pic'.'.'.$extension);
                $displayHeader = $request->displayHeader;
                $displayContent = $request->displayContent;
                $request->newsLetterimg->move($path,$newsletter_pic_name);
                DB::table("general_setting")->where('url_key', 'notification')->update(["details" => json_encode(["img_path" => $newsletter_pic_name,"displayHeader" => $displayHeader,"displayContent" => $displayContent]),'is_active' => (int)($request->input("enablesub"))]);
                session()->flash('msg', 'Newsletter Added Successfully for Store');
                return redirect()->to('/admin/newsletter')->withInput($request->input());
            } else {
                 $img = DB::table("general_setting")->select('details')->where('url_key', 'notification')->first();
                $imgpath = json_decode($img->details,true);
                $newsletter_pic_name = $imgpath["img_path"];
                $displayHeader = $request->displayHeader;
                $displayContent = $request->displayContent;
                DB::table("general_setting")->where('url_key', 'notification')->update(["details" => json_encode(["img_path" => $newsletter_pic_name,"displayHeader" => $displayHeader,"displayContent" => $displayContent]),'is_active' => (int)($request->input("enablesub"))]);
                session()->flash('msg', 'Newsletter Added Successfully for Store');
                return redirect()->to('/admin/newsletter')->withInput($request->input());
            }            
        }
    }

    public function exportNewsLetter() {
        // $newsLetters = Notification::get();
        $newsLetters = Newsletter::get();
        $arr = ['SubscribedID','Email', 'SubscribedDate','Subscribed Status'];
        $sampleProds = [];
        array_push($sampleProds, $arr);

        foreach ($newsLetters as $newsLetter) {
            if(isset($newsLetter->status) && $newsLetter->status == 1){
                $status = 'Yes';
            }else{
                $status = 'No';
            }                 
            $details = [
                $newsLetter->id,
                $newsLetter->email,
                date('d M Y ', strtotime($newsLetter->created_at)),
                $status
            ];
            array_push($sampleProds, $details);
        }
        return Helper::getCsv($sampleProds, 'newsletter.csv', ',');
    }

}
