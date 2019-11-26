<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Route;
use Input;
use App\Models\Product;
use App\Models\Message;
use App\Models\EmailCampaign;
use App\Models\EmailTemplate;
use Session;
use DB;
use Config;
use App\Library\Helper;

class CampaignController extends Controller
{
    public function index() {
        $messages = Message::orderBy("id", "desc")->get();
      	//dd($messages);
        $data = [ 'messages' => $messages];
        $viewname = Config('constants.adminCampaignView') . '.index';
        return Helper::returnView($viewname, $data);
    }

    public function viewemails() {
        $EmailCampaigns = EmailCampaign::orderBy("id", "desc")->get();
        //dd($messages);
        $data = [ 'EmailCampaigns' => $EmailCampaigns];
        $viewname = Config('constants.adminCampaignView') . '.emailCampaigns';
        return Helper::returnView($viewname, $data);
    }

    public function sendCampaignSMS()
    {
    	$contactno = Input::get('contactno');
    	$title = Input::get('title');
    	$content = Input::get('content');
    	$msg = $content;
    	$country_code = '+91';
    	Helper::sendsms($contactno, $msg, $country_code);
    	$msg = urlencode($msg);
    	//dd($msg);

		$urlto = "http://enterprise.smsgupshup.com/GatewayAPI/rest?method=SendMessage&send_to=+91{mobile}&msg={message}&msg_type=TEXT&userid=2000164017&auth_scheme=plain&password=GClWepNxL&mask=APPRCH&v=1.1&format=text";
        // if($country=='+880'){
        //   $urlto =  "http://api.boom-cast.com/boomcast/WebFramework/boomCastWebService/externalApiSendTextMessage.php?masking=NOMASK&userName=IFC&password=6d38103103bb45de1c77e7eece818b1c&MsgType=TEXT&receiver=$mobile&message=$msg";   
        // }else
        // {
        //     $urlto = "http://enterprise.smsgupshup.com/GatewayAPI/rest?method=SendMessage&send_to=$mobile&msg=$msg&msg_type=TEXT&userid=2000164017&auth_scheme=plain&password=GClWepNxL&v=1.1&format=text";
        // }
                $ch = curl_init();
// set URL and other appropriate options
                curl_setopt($ch, CURLOPT_URL, $urlto);
                //curl_setopt($ch, CURLOPT_HEADER, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// grab URL and pass it to the browser
                $output = curl_exec($ch);
                print_r($output);
// close cURL resource, and free up system resources
                curl_close($ch);
        //return $output;
        return 'SMS send successfully';
    }

    public function sendCampaignEmail() {
        $subject = Input::get('subject');
        $title = Input::get('title');
        $content = Input::get('content');
        dd($content);
        $email_id = Input::get('email');
        $data = ['email_template' => $content];
        Helper::sendMyEmail(Config('constants.adminEmails') . '.email_by_remplate', $data, $subject, Config::get('mail.from.address'), Config::get('mail.from.name'), $email_id, 'Anita');
    }

    public function addEmail() {
        $emailCampaign = new EmailCampaign();
        $templates = EmailTemplate::find(1);
        $action = route("admin.emailcampaign.saveemail");
        $data = ['action' => $action,'emailCampaign' => $emailCampaign,'templates'=>$templates];
        $viewname = Config('constants.adminCampaignView') . '.emailCampAddEdit';
        return Helper::returnView($viewname, $data);
    }

    public function saveEmail() {
        $EmailCampaign = EmailCampaign::findOrNew(Input::get('id'));
        $EmailCampaign->title = Input::get('title');
        $EmailCampaign->subject = Input::get('subject');
        $EmailCampaign->content = Input::get('content');
        $EmailCampaign->created_at = date('Y-m-d H:i:s');
        $EmailCampaign->status = 2;
        $EmailCampaign->save();
        
        $url = 'admin.emailcampaign.viewemails';
        $data = ['status' => '1', 'msg' => 'Email added/updated successfully.'];
        $viewname = '';
        return Helper::returnView($viewname, $data, $url);
    }

    public function add() {
       	$messages = new Message();
        $action = route("admin.campaign.save");
        $data = ['action' => $action,'smsCampaign' => $messages];
        $viewname = Config('constants.adminCampaignView') . '.addEdit';
        return Helper::returnView($viewname, $data);
    }

    public function save() {
        $smsCampaign = Message::findOrNew(Input::get('id'));
        $smsCampaign->title = Input::get('title');
        $smsCampaign->content = Input::get('content');
        $smsCampaign->created_at = date('Y-m-d H:i:s');
        $smsCampaign->status = 2;
        $smsCampaign->save();
        
        $url = 'admin.campaign.view';
        $data = ['status' => '1', 'msg' => 'SMS added/updated successfully.'];
        $viewname = '';
        return Helper::returnView($viewname, $data, $url);
    }

    public function edit() {
        //Session::put('id',Input::get('id'));
        $messages = Message::find(Input::get('id'));
        $action = route("admin.campaign.save");
        $data = ['status' => '1', 'action' => $action, 'smsCampaign' => $messages];
        $viewname = Config('constants.adminCampaignView') . '.addEdit';
        return Helper::returnView($viewname, $data);
    }

    public function delete() {
        $message = Message::find(Input::get('id'));
        if(!empty($message))
        {
        	$message->delete();
            Session::flash('message', 'Message deleted successfully.');
            $data = ['status' => '1', "message" => "Message deleted successfully."];
        }
        $url = 'admin.campaign.view';
        $viewname = '';
        return Helper::returnView($viewname, $data, $url);
    }

    public function editEmail() {
        $emailCampaign = EmailCampaign::find(Input::get('id'));
        $action = route("admin.emailcampaign.saveemail");
        $data = ['status' => '1', 'action' => $action, 'emailCampaign' => $emailCampaign];
        $viewname = Config('constants.adminCampaignView') . '.emailCampAddEdit';
        return Helper::returnView($viewname, $data);
    }

    public function deleteEmail() {
        $emailcampaign = EmailCampaign::find(Input::get('id'));
        if(!empty($emailcampaign))
        {
            $emailcampaign->delete();
            Session::flash('message', 'Email deleted successfully.');
            $data = ['status' => '1', "message" => "Message deleted successfully."];
        }
        $url = 'admin.emailcampaign.viewemails';
        $viewname = '';
        return Helper::returnView($viewname, $data, $url);
    }
}
