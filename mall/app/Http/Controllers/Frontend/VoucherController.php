<?php

namespace App\Http\Controllers\Frontend;

use Socialite;
use Route;
use Input;
use App\Models\User;
use App\Models\Gift;
use Auth;
use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use Session;
use App\Library\Helper;
use Cart;
use Carbon\Carbon;
use Hash;
use Illuminate\Support\Facades\Mail;


class VoucherController extends Controller {

    public function index() {
        
     $viewname = Config('constants.frontendView') . '.gifting';
        //  dd($viewname);
        return view($viewname);
    }

    public function giftemail(){
      $emailStatus=GeneralSetting::where('url_key','email-facility')->first()->status;
      $email=Input::get('user.sndremail');
      $receivremail=Input::get('user.receivremail');
      $amount=Input::get('user.gift');
      $coupon=rand(1000,10000);
      
      $gift= new Gift;
      $gift->sender_email=$email;
      $gift->receiver_email=$receivremail;
      $gift->amount=$amount;
      $gift->coupon=$coupon;
      $gift->limit=1;
      $current = Carbon::now();
      $trialExpires = $current->addDays(30);
      $gift->valid_upto=$trialExpires;
      if($gift->save())
      {
            if($emailStatus==1){   
          $content = "Hi,".@Input::get('user.sndrname') ."\n\n";
                  $content.= "Subject: " . @Input::get('subject') . "\n\n";
                  $content.= "Message: " . @Input::get('message1').$coupon. @Input::get('message2').$trialExpires." ."."\n\n".@Input::get('message3'). "\n\n";

                    Mail::raw($content,function($m)use($email )
                             {
                                $m->from("info@cartini.com",'Gift Application')
                                           ->to($email) 
                                           ->subject("Gift purchased from our website");
                             });
            return 1;
        }
      }
    
    }
}
