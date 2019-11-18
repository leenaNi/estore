<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
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
use Illuminate\Http\Response;
use App\Models\Merchant;
use App\Models\Message;
use Tymon\JWTAuth\Exceptions\JWTException;

class ApiCampaignController extends Controller
{
    public function index() {
    	
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prefix = $merchant->prefix;
        
        $messagesList = DB::table($prefix . '_messages')->orderBy("id", "desc");
        
        $messagesList = $messagesList->get();
        $messagesListCount = $messagesList->count();
        $data = ['AllSMS' => $messagesList, 'SMSListCount' => $messagesListCount];
        $viewname = '';
        return Helper::returnView($viewname, $data);
    }

    public function savesms(Request $request){
    	
        $marchantId = Input::get("merchantId");
        $msg_title = Input::get("msg_title");
        $msg_content = Input::get("msg_content");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prefix = $merchant->prefix;
        
        $sms_data=array('title'=>$msg_title,"content"=>$msg_content,'status'=>2);
		$data1 = DB::table($prefix . '_messages')->insert($sms_data);
      
        return response()->json(["status" => 1, 'msg' => "SMS send successfully", 'SMS data' => $sms_data]);
    }
}
