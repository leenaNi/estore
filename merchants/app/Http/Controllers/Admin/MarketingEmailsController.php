<?php

namespace App\Http\Controllers\Admin;

use Route;
use Input;
use App\Http\Controllers\Controller;
use DB;
use App\Models\User;
use App\Models\MarketingEmailGroups;
use App\Models\MarketingEmailTemplates;
use App\Models\HasEmails;
use App\Library\Helper;
use Session;

class MarketingEmailsController extends Controller {

    public function emails() {
        $customers = User::where('user_type', 2)->where("email","!=","");
        $customers = $customers->select('id', 'email')->orderBy('email')->paginate(Config('constants.paginateNo'));
//        dd($customers);
        return view(Config('constants.adminMarketingEmailsView') . '.emails', compact('customers', 'action'));
    }

    public function addGroup() {
//        dd("dasssssss");
        $id = Input::get('id');
        $markEmailsGroup = MarketingEmailGroups::findOrNew($id);
        $customers = User::where('user_type', 2)->where("email","!=","");
        $customers = $customers->orderBy('email')->get(['id', 'email']);
        $action = route("admin.marketing.saveGroup");
        return view(Config('constants.adminMarketingEmailsView') . '.addGroup', compact('markEmailsGroup', 'customers', 'action'));
    }

    public function editGroup() {
//        dd("dasssssss");
        $id = Input::get('id');
        $markEmailsGroup = MarketingEmailGroups::findOrNew($id);
        $customers = User::where('user_type', 2)->where("email","!=","");
        $customers = $customers->orderBy('email')->get(['id', 'email']);
        $action = route("admin.marketing.saveGroup");
        return view(Config('constants.adminMarketingEmailsView') . '.addGroup', compact('markEmailsGroup', 'customers', 'action'));
    }

    public function saveGroup() {
//        dd(Input::all());
        $id = Input::get('id');
        $emailGrp = MarketingEmailGroups::findOrNew($id);
        $emailGrp->title = Input::get('title');
        $emailGrp->status = Input::get('status');
        $emailGrp->is_user_specific = Input::get('is_user_specific');
        $emailGrp->status = Input::get('status');
        // $emailGrp->store_id = Session::get('store_id');
         $emailGrp->save();
        if ($emailGrp->is_user_specific == 1) {
            $userEmails = Input::get('user_emails');
            if (!empty($userEmails))
                $emailGrp->users()->sync($userEmails);
            else
                $emailGrp->users()->detach();
        } else {
            $emailGrp->users()->detach();
        }
       
        if ($id == "") {
            Session::flash("msg", "Marketing Email Group added successfully.");
        } else {
            Session::flash("msg", "Marketing Email Group updated successfully.");
        }
        return redirect()->route('admin.marketing.groups');
    }

    public function emailGroups() {
        $emailGrps = MarketingEmailGroups::paginate(Config('constants.paginateNo'));
        return view(Config('constants.adminMarketingEmailsView') . '.emailGroups', compact('emailGrps'));
    }

    public function changeStatus() {
        $id = Input::get("id");
        $viewname = '';
        $getstatus = MarketingEmailGroups::find($id);
//        dd($getstatus);
        if ($getstatus->status == 1) {
            $status = 2;
            $getstatus->status = $status;
            $getstatus->update();
            Session::flash("message", "Marketing Email Group disabled successfully.");
            $data = ["status" => "0", "msg" => "Marketing Email Group disabled successfully. "];
        } else if ($getstatus->status == 2) {
            $status = 1;
            $getstatus->status = $status;
            $getstatus->update();
            Session::flash("msg", "Marketing Email Group enabled successfully.");
            $data = ["status" => "1", "msg" => "Marketing Email Group enabled successfully."];
        }
        return Helper::returnView($viewname, $data, $url = 'admin.marketing.groups');
    }

    public function changeTempStatus() {
        $id = Input::get("id");
        $viewname = '';
        $getstatus = MarketingEmailTemplates::find($id);
//        dd($getstatus);
        if ($getstatus->status == 1) {
            $status = 2;
            $getstatus->status = $status;
            $getstatus->update();
            Session::flash("message", "Marketing Email Template disabled successfully.");
            $data = ["status" => "0", "msg" => "Marketing Email Template disabled successfully. "];
        } else if ($getstatus->status == 2) {
            $status = 1;
            $getstatus->status = $status;
            $getstatus->update();
            Session::flash("msg", "Marketing Email Template enabled successfully.");
            $data = ["status" => "1", "msg" => "Marketing Email Template enabled successfully."];
        }
        return Helper::returnView($viewname, $data, $url = 'admin.marketing.emailTemplates');
    }

    public function emailTemplates() {
        $emailTemplates = MarketingEmailTemplates::paginate(Config('constants.paginateNo'));
        return view(Config('constants.adminMarketingEmailsView') . '.emailTemplates', compact('emailTemplates'));
    }

    public function addEmailTemp() {
//        dd("dasssssss");
        $id = Input::get('id');
        $markEmailsTemp = MarketingEmailTemplates::findOrNew($id);
        $customers = User::where('user_type', 2);
        $customers = $customers->orderBy('email')->get(['id', 'email']);
        $action = route("admin.marketing.saveEmailTemp");
        return view(Config('constants.adminMarketingEmailsView') . '.addEmailTemp', compact('markEmailsTemp', 'action'));
    }

    public function editEmailTemp() {
//        dd("dasssssss");
        $id = Input::get('id');
        $markEmailsTemp = MarketingEmailTemplates::findOrNew($id);
        $customers = User::where('user_type', 2);
        $customers = $customers->orderBy('email')->get(['id', 'email']);
        $action = route("admin.marketing.saveEmailTemp");
        return view(Config('constants.adminMarketingEmailsView') . '.addEmailTemp', compact('markEmailsTemp', 'action'));
    }

    public function saveEmailTemp() {
//        dd(Input::all());
        $id = Input::get('id');
        $emailTemp = MarketingEmailTemplates::findOrNew($id);
        $emailTemp->from_email = Input::get('from_email');
        $emailTemp->from_name = Input::get('from_name');
        $emailTemp->subject = Input::get('subject');
        $string = preg_replace("/\s*>\s*/", ">", Input::get('email_body'));
        $emailTemp->email_body = $string;
        $emailTemp->status = Input::get('status');
        $emailTemp->save();
        if ($id == "") {
            Session::flash("msg", "Marketing Email Template added successfully.");
        } else {
            Session::flash("msg", "Marketing Email Template updated successfully.");
        }
        return redirect()->route('admin.marketing.emailTemplates');
    }

}
