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
use File,DB;
use Validator;

class HomeController extends Controller {

    public function index() {

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
            'newsLetterimg' => 'required|file|mimes:jpeg,png,jpg|max:1024',
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
            $path = base_path() ."/$domainname/public/uploads/newsletter/";
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
