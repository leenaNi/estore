<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SmsSubscription;
use App\Models\uses;
use DB;
use Session;
use Input;
use App\Library\Helper; 
class SmsSubscriptionController extends Controller
{
    public function index(){
      $smsSubscription=SmsSubscription::paginate(config('constants.paginateNo')); 
       $smsCount=$smsSubscription->total();
      return view(Config('constants.adminSmsView') . '.index', compact('smsSubscription','smsCount'));  
      
    }
    
    public function addEdit(){
          $smsSubscription=SmsSubscription::find(Input::get("id"));
        $action=route('admin.smsSubscription.save');
   
        //$data=['testimonial' =>$testimonial,'action'=>$action];
       // dd($data);
         return view(Config('constants.adminSmsView') . '.addEdit',['smsSubscription' =>$smsSubscription,'action'=>$action]);
    }
    public function save(){
       $smsSubscription=SmsSubscription::findOrNew(Input::get("id"));
       $smsSubscription->no_of_sms=Input::get("no_of_sms"); 
       $smsSubscription->purchased_by=Session::get('loggedinAdminId');
        $smsSubscription->status=1;
         $smsSubscription->save();
         $data='';
          $viewname='';
          if(empty(Input::get("id"))){
           Session::flash("msg", "Sms purchased successfully.");   
          }else{
              
            Session::flash("msg", "Sms purchased successfully.");   
          }
          
              return Helper::returnView($viewname, $data, $url = 'admin.smsSubscription.view');
        
    }
    
  
}
