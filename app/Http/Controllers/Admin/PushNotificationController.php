<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Input;
use Route;
use App\Models\User;
use App\Models\Pushnotification;
use App\Models\Merchant;
use stdClass;

class PushNotificationController extends Controller {

    public function index() {

        $notifications = Pushnotification::orderBy("id", "desc")->paginate(10);
        return view(Config('constants.AdminPagesNotification') . '.notification', compact('notifications'));
    }

    public function addNew() {
        $action = route("admin.notification.send");
        $notifications = '';
        return view(Config('constants.AdminPagesNotification') . '.index', compact('action', 'notifications'));
    }

    public function sendNotification() {

        $title = Input::get("title");
        $message = Input::get("notification");
        $userType = Input::get("notification_user");
    
            $user = Merchant::where("device_id",'!=','')->pluck("device_id");
      
        if (Input::hasFile('image')) {

            $img = Input::file('image');
            $destinationPath = public_path() . '/public/admin/uploads/notification/';
            $fileName = "noti-" . date("YmdHi") . "." . $img->getClientOriginalExtension();
            $upload_success = $img->move($destinationPath, $fileName);
        } else {
            $fileName = null;
        }
        $imgPath = asset(Config("constants.notificationImgPath") . $fileName);
     
        $messagearray = new stdClass();

        //$messagearray=['title'=>$title,'message'=>$message];
        $messagearray->title = $title;
        $messagearray->type = "other";
        $messagearray->message = $message;
        $messagearray->img_url = $imgPath; // "http://dev.alladin.com.bd/public/Admin/uploads/catalog/products/prod-020180321111945.png";
        // $messagearray=($messagearrayobject)$messagearray;
        // $notification=json_encode($messagearray,true);
           $this->pushNotification($messagearray, $user, $fileName);
       return redirect()->route('admin.notification.view');
    }

    public function resendNotification() {
        $notifications = Pushnotification::find(Input::get("id"));
        $userType = $notifications->user_type;
     
            $user = Merchant::where("device_id",'!=','')->pluck("device_id");
     
        $fileName = $notifications->image;
        $imgPath = asset(Config("constants.notificationImgPath") . $fileName);      
        $messagearray = new stdClass();
        $messagearray->title = $notifications->title;
        $messagearray->type = "other";
        $messagearray->message = $notifications->message;
        $messagearray->img_url = $imgPath;
        $this->pushNotification($messagearray, $user, $fileName);
         return redirect()->route('admin.notification.view');
    }
 
     
    public function pushNotification($notification, $to = null, $fileName = null) {

        $gcmRegIds = $to; //array("cA0_4PadbtY:APA91bH0FFWAOYiEOBUb4kFc8H44iZft4a9z1FeQ6aAellJnqKdsteHi3Vzbm2ADBQEm3LDmDUYFMQAA4QELMpsc3mu2OQbt31OBLMwpLPvjww4ORcEIinhLXXEs3k4hYbi66VLQBwc","d9LWM-xhtK4:APA91bFa5FrpUVJZR0zxhrjZpN0aCZiDIoLt7liQ7F4zNtEwdjnaQpg_vGerkSlQHtVwxkRiEKAc88PtaD6DbHVFiUb2XxWlT8thbzvhsd7AHGne5yZaRlAFxRxb3oltpX1JQyM3jhPh");
        // $gcmRegIds =array("czJL9JHA55M:APA91bFnpw40Lel7lKk_iSMpN3NHNtpi9H2huaS5rjRzBDSE6Uek4KI3HjdjZLB2F-lftcENwVzxZyRA6fQ5CW5UACtImmCB6jDDyuTB68jrlYkzpD4eWAXW7Lire91IFfO2g2ckoUpP");
//       if( $notification['object_type'] == 'chat'){
//           $notification['title'] = 'Veefin - '.$notification['from_user'];
//       }else{
//
//          $notification['title'] = 'Veefin'; 
//       }

        $fields = array(
            'registration_ids' => $gcmRegIds,
            'data' => $notification
        );
        //building headers for the request
        $headers = array(
            'Authorization: key=' . 'AAAAZeeZoaQ:APA91bHR9lt8JdJDhAzH1dUh9oUOUs3F6GM4BdMzK1uVqQLcMv1NUVc-twlw7hklrRHOvj8Ada-UhiggbrxXiUldSH1KuxG0kcroiah_4bLylwt9LSBcjihdxweKtvEhrUrHLtUbuYOj',
            'Content-Type: application/json'
        );

        //Initializing curl to open a connection
        $ch = curl_init();

        //Setting the curl url
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');

        //setting the method as post
        curl_setopt($ch, CURLOPT_POST, true);

        //adding headers 
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //disabling ssl support
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        //adding the fields in json format 
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        //finally executing the curl request 
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        } else {
           // echo $result;
            $resultData = json_decode($result);
            if($resultData){
            $pushNotification = new Pushnotification();
            $pushNotification->success = $resultData->success;
            $pushNotification->failure = $resultData->failure;
            $pushNotification->title = $notification->title;
            $pushNotification->message = $notification->message;
           $pushNotification->image = $fileName;
           // $pushNotification->user_type = $userType;
            $pushNotification->save();
    
            }
       
        }
        
    curl_close($ch);
  
   // return redirect()->route('admin.notification.view');
        //Now close the connection
       
      
    }

    
}
