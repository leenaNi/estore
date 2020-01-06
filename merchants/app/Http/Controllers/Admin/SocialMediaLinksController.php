<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Library\Helper;
use App\Models\SocialMediaLink;
use Illuminate\Http\Request;
use Input;
use Route;
use Session;
use Validator;

class SocialMediaLinksController extends Controller
{

    public function index()
    {
        $search = !empty(Input::get("media")) ? Input::get("media") : '';
        $search_fields = ['media'];

        if ($search != "") {
            $smlinkInfo = SocialMediaLink::where(function ($query) use ($search_fields, $search) {
                foreach ($search_fields as $field) {
                    $query->orWhere($field, "like", "%$search%");
                }
            })->get();
            $smlinkCount = $smlinkInfo->count();
        } else {
            $smlinkInfo = SocialMediaLink::paginate(Config('constants.paginateNo'));
            $smlinkCount = $smlinkInfo->total();
        }
        $data = ['smlinkInfo' => $smlinkInfo, 'public_path' => 'public/Admin/uploads/socialmedia/', 'smlinkCount' => $smlinkCount];
        $viewname = Config('constants.adminSocialMediaLinkView') . '.index';
        return Helper::returnView($viewname, $data);
    }

    public function add()
    {
        $link = new SocialMediaLink();
        $action = route("admin.socialmedialink.save");
        $data = ['link' => $link, 'action' => $action, 'new' => '1', 'public_path' => 'public/Admin/uploads/socialmedia/'];
        $viewname = Config('constants.adminSocialMediaLinkView') . '.addEdit';
        return Helper::returnView($viewname, $data);
    }

    public function edit()
    {
        $link = SocialMediaLink::find(Input::get('id'));
        $action = route("admin.socialmedialink.update");
        $data = ['link' => $link, 'action' => $action, 'new' => '0', 'public_path' => 'public/Admin/uploads/socialmedia/'];
        $viewname = Config('constants.adminSocialMediaLinkView') . '.addEdit';
        return Helper::returnView($viewname, $data);
    }

    public function save(Request $request)
    {
        Validator::make($request->all(), [
            'media' => 'required',
            'link' => 'required|url',
            'image' => 'required|image',
        ], [
            'media.required' => 'The media name field is required.',
            'link.url' => 'Please enter proper url.',
            'link.required' => 'The link field is required.',
            'image.image' => 'The image field required proper image file.',
            'image.required' => 'The image field is required.',
        ])->validate();
        $formData = $request->all();

        if (Input::hasFile('image')) {
            $destinationPath = 'public/Admin/uploads/socialmedia/';
            $fileName = date("dmYHis") . "." . Input::File('image')->getClientOriginalExtension();
            $upload_success = Input::File('image')->move($destinationPath, $fileName);
        } else {
            $fileName = (!empty(Input::get('image')) ? Input::get('image') : '');
        }

        $formData['image'] = $fileName;
        SocialMediaLink::create($formData);
        Session::flash("msg", "Social media link added successfully.");
        $viewname = Config('constants.adminSocialMediaLinkView') . '.index';
        $data = ['status' => '1'];
        return Helper::returnView($viewname, $data, $url = 'admin.socialmedialink.view');
    }

    public function update(Request $request)
    {
        Validator::make($request->all(), [
            'media' => 'required',
            'sort_order' => 'required',
            'link' => 'required|url',
        ], [
            'media.required' => 'The media name field is required.',
            'sort_order.required' => 'Sort Order required.',
            'link.url' => 'Please enter proper url',
            'link.required' => 'The link field is required.',
        ])->validate();

        $link = SocialMediaLink::find($request->id);
        $formData = $request->all();

        if (Input::hasFile('image')) {
            $destinationPath = 'public/Admin/uploads/socialmedia/';
            $fileName = date("dmYHis") . "." . Input::File('image')->getClientOriginalExtension();
            $upload_success = Input::File('image')->move($destinationPath, $fileName);
            $formData['image'] = $fileName;
        } else {
            //$fileName = (!empty(Input::get('image')) ? Input::get('image') : '');
            unset($formData['image']);
        }

        $link->update($formData);
        Session::flash("msg", "Social media link updated successfully.");
        $viewname = Config('constants.adminSocialMediaLinkView') . '.index';
        $data = ['status' => '1', 'msg' => (Input::get('id') != '') ? 'Social media link updated successfully.' : 'Social media link added successfully.'];
        return Helper::returnView($viewname, $data, $url = 'admin.socialmedialink.view');
    }

    public function delete(Request $request)
    {
        $link = SocialMediaLink::find($request->id);
        $link->delete();
        Session::flash("message", "Social media link deleted successfully.");
        $data = ['status' => '1', 'msg' => 'Social media link deleted successfully.'];
        $viewname = Config('constants.adminSocialMediaLinkView') . '.index';
        return Helper::returnView($viewname, $data, $url = 'admin.socialmedialink.view');
    }

    public function changeStatus(Request $request)
    {
        $contact = SocialMediaLink::find($request->id);
        if ($contact->status == 1) {
            $contact->status = 0;
            $msg = "Social media link disabled successfully.";
            Session::flash("message", $msg);
        } else {
            $contact->status = 1;
            $msg = "Social media link enabled successfully.";
            Session::flash("msg", $msg);
        }
        $contact->update();

        $data = ['status' => '1', 'msg' => $msg];
        $viewname = Config('constants.adminSocialMediaLinkView') . '.index';
        return Helper::returnView($viewname, $data, $url = 'admin.socialmedialink.view');
    }
}
