<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Library\Helper;
use Validator;
use Illuminate\Support\Facades\Input;
use Hash;
use Session;
use Auth;
use JWTAuth;
use Config;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Merchant;
use Tymon\JWTAuth\Exceptions\JWTException;

class ApiNewsletterController extends Controller {

    public function index() {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $search = !empty(Input::get("newsletterSearch")) ? Input::get("newsletterSearch") : '';
        $search_fields = ['email', 'status'];
        $newsletter = DB::table($prifix . '_notification')->orderBy("id", "desc");
        
        if (!empty(Input::get('newsletterSearch'))) {
            $newsletter = $newsletter->where(function($query) use($search_fields, $search) {
                foreach ($search_fields as $field) {
                    $query->orWhere($field, "like", "%$search%");
                }
            });
        }
        $newsletters = $newsletter->get();
        $newsletterCount = $newsletter->count();
        $data = ['newsletters' => $newsletters, 'newsletterCount' => $newsletterCount];
        $viewname = '';

        return Helper::returnView($viewname, $data);
    }

    public function saveNewsLetter(Request $request) {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;

        $rules = [
            'enablesub' => 'required|in:1',
            'newsLetterimg' => 'required',
        ];

        $messages = array(
            'enablesub.required' => 'This CheckBox Field is required',
            'newsLetterimg.required' => 'This Image Field is required'
        );

        $validator = Validator::make($request->all(), $rules,$messages);
        if ($validator->fails()) {
            $jsonArray['status'] = 'error';
            $errors = $validator->messages()->toArray();
            foreach ($errors as $key => $val) {
                $jsonArray['message'][$key] = $val[0];
            }
            
            return $jsonArray;
        }else{
            if (Input::get('newsLetterimg')) {
                $logoImage = Input::get('newsLetterimg');
                $image_parts = explode(";base64,", $logoImage);
                $image_type_aux = explode("image/", $image_parts[0]);
                $extension = $image_type_aux[1];
                $image_base64 = base64_decode($image_parts[1]);
                $timestp = date("Y-m-d-H-i-s");
                $newsletter_pic_name = strtolower($timestp.'_pic'.'.'.$extension);
                $path = base_path() . '/merchants/' . $merchant->url_key ."/public/uploads/newsletter/".$newsletter_pic_name;
                
                $images = file_put_contents($path, $image_base64);
                
                $displayHeader = $request->displayHeader;
                $displayContent = $request->displayContent;
                
                DB::table($merchant->prefix . "_general_setting")->where('url_key', 'notification')->update(["details" => json_encode(["img_path" => $newsletter_pic_name,"displayHeader" => $displayHeader,"displayContent" => $displayContent]),'status' => 1]);

                $jsonArray['status'] = 'success';
                $jsonArray['message'] = 'NewsLetter Added Successfully';

                return $jsonArray;
            }
        }
    }
   
}

?>