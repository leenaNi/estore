<?php

namespace App\Http\Controllers\Admin;

use Route;
use Input;
use App\Models\StaticPage;
use App\Models\Country;
use App\Models\Zone;
use App\Models\Store;
use App\Http\Controllers\Controller;
use App\Library\Helper;
use Session;
use Illuminate\Http\Request;
use DB;
use Validator;

class StaticPageController extends Controller {

    public function index() {
        $search = !empty(Input::get("page_name")) ? Input::get("page_name") : '';
        $search_fields = ['page_name'];

        if ($search != "") {
            $staticpageInfo = StaticPage::where(function($query) use($search_fields, $search) {
                        foreach ($search_fields as $field) {
                            $query->orWhere($field, "like", "%$search%");
                        }
                    })->get();
            $staticPageCount = $staticpageInfo->count();
        } else {
            $staticpageInfo = StaticPage::paginate(Config('constants.paginateNo'));
            $staticPageCount = $staticpageInfo->total();
        }

        $startIndex = 1;
        $getPerPageRecord = Config('constants.paginateNo');
        $allinput = Input::all();
        if(!empty($allinput) && !empty(Input::get('page')))
        {
            $getPageNumber = $allinput['page'];
            $startIndex = ( (($getPageNumber) * ($getPerPageRecord)) - $getPerPageRecord) + 1;
            $endIndex = (($startIndex+$getPerPageRecord) - 1);

            if($endIndex > $staticPageCount)
            {
                $endIndex = ($staticPageCount);
            }
        }
        else
        {
            $startIndex = 1;
            $endIndex = $getPerPageRecord;
            if($endIndex > $staticPageCount)
            {
                $endIndex = ($staticPageCount);
            }
        }


        $data = ['staticpageInfo' => $staticpageInfo, 'staticPageCount' => $staticPageCount, 'startIndex' => $startIndex, 'endIndex' => $endIndex];
        $viewname = Config('constants.adminStaticPageView') . '.index';
        return Helper::returnView($viewname, $data);
    }

    public function add() {
        $page = new StaticPage();
        $action = route("admin.staticpages.save");
        $data = ['page' => $page, 'action' => $action, 'new' => '1'];
        $viewname = Config('constants.adminStaticPageView') . '.addEdit';
        return Helper::returnView($viewname, $data);
    }

    public function edit() {
        $page = StaticPage::find(Input::get('id'));
        $action = route("admin.staticpages.update");
        $coutries = Country::where("status", 1)->orderBy('name')->pluck('name', 'id')->toArray();
        $states = Zone::orderBy('name')->get();
        $state = [];
        foreach ($states as $value) {
            $state[$value['id']] = $value['name'];
        }
        $data = ['page' => $page, 'action' => $action, 'state' => $state, 'coutries' => $coutries, 'new' => '0'];
        $viewname = Config('constants.adminStaticPageView') . '.addEdit';
        return Helper::returnView($viewname, $data);
    }

    public function save(Request $request) {
        Validator::make($request->all(), [
            'page_name' => 'required',
            'description' => 'required',
            'url_key' => 'required',
            'link' => 'required|url',
            'image' => 'required|image',
                ], [
            'page_name.required' => 'The page name field is required.',
            'link.url' => 'Please enter valid url.',
            'link.required' => 'The link field is required.',
            'description.required' => 'The description field is required.',
            'image.image' => 'The image field required proper image file.',
            'image.required' => 'The image field is required.',
        ])->validate();

        $formData = $request->all();

        if (Input::hasFile('image')) {
            $destinationPath = Config('constants.adminStaticPageUploadPath');
            $fileName = date("dmYHis") . "." . Input::File('image')->getClientOriginalExtension();
            $upload_success = Input::File('image')->move($destinationPath, $fileName);
        } else {
            $fileName = (!empty(Input::get('image')) ? Input::get('image') : '');
        }

        $formData['image'] = $fileName;
//dd($formData);
        $save = StaticPage::create($formData);
        $save->description = strip_tags(Input::get('description'));
        $save->update();

        Session::flash("msg", "Static page added successfully.");
        $viewname = Config('constants.adminStaticPageView') . '.index';
        $data = ['status' => '1'];
        return Helper::returnView($viewname, $data, $url = 'admin.staticpages.view');
    }

    public function update(Request $request) {
        //dd($request->all());
        Validator::make($request->all(), [

            'page_name' => 'required'
                //  'description' => 'required',
                // 'link' => 'required|url',
                ], [
            'page_name.required' => 'The page name field is required.'
                //  'description.required' => 'The description field is required.',
        ])->validate();

        $page = StaticPage::find($request->id);

        $page->page_name = Input::get('page_name');
        $page->link = Input::get('link');
        $page->description = Input::get('description');
        $page->url_key = Input::get('url_key');
        $page->status = Input::get('status');
        $page->sort_order = Input::get('sort_order');
        $page->is_menu = Input::get('is_menu');
        $page->contact_details = json_encode(Input::get('details'));
        if(Input::get('details')) {
            $store = Store::find($this->jsonString['store_id']);

            $store->contact_firstname = Input::get('details')['contact_person'];
            $store->contact_phone = Input::get('details')['mobile'];
            $store->contact_email = Input::get('details')['email'];
            $store->address = Input::get('details')['address_line1'];
            $store->address2 = Input::get('details')['address_line2'];
            $store->thana = Input::get('details')['Thana'];
            $store->city = Input::get('details')['city'];
            $store->country_id = Input::get('details')['country'];
            $store->zone_id = Input::get('details')['state'];
            $store->pin = Input::get('details')['pincode'];
            $store->save();
        }
//         if(Input::get('url_key')=='contact-us'){
//            $page->map_url=Input::get('map_url');  
//            $page->email_list=Input::get('email_list');
//         }
        // dd($formData);
        if (Input::hasFile('image')) {
            $destinationPath = Config('constants.adminStaticPageUploadPath');
            $fileName = date("dmYHis") . "." . Input::File('image')->getClientOriginalExtension();
            $upload_success = Input::File('image')->move($destinationPath, $fileName);
            $formData['image'] = $fileName;
            $page->image = $fileName;
        }
        // dd($page);
        $page->update();
        // dd(Input::all());
        Session::flash("msg", "Static page updated successfully.");
        $viewname = Config('constants.adminStaticPageView') . '.index';
        $data = ['status' => '1', 'msg' => (Input::get('id') != '') ? 'Contact updated successfully.' : 'Contact added successfully.'];
        return Helper::returnView($viewname, $data, $url = 'admin.staticpages.view');
    }

    public function delete(Request $request) {
        $page = StaticPage::find($request->id);
        $page->delete();
        Session::flash("message", "Static page deleted successfully.");
        $data = ['status' => '1', 'msg' => 'Contact deleted successfully.'];
        $viewname = Config('constants.adminStaticPageView') . '.index';
        return Helper::returnView($viewname, $data, $url = 'admin.staticpages.view');
    }

    public function changeStatus(Request $request) {
        $contact = StaticPage::find($request->id);
        if ($contact->status == 1) {
            $contact->status = 0;
            $msg = "Static page disabled successfully.";
            Session::flash("message", $msg);
        } else {
            $contact->status = 1;
            $msg = "Static page enabled successfully.";
            Session::flash("msg", $msg);
        }
        $contact->update();

        $data = ['status' => '1', 'msg' => $msg];
        $viewname = Config('constants.adminStaticPageView') . '.index';
        return Helper::returnView($viewname, $data, $url = 'admin.staticpages.view');
    }

    public function getDescription(Request $request) {
        $page = StaticPage::find($request->page_id);
        return response()->json(['description' => $page->description]);
    }

    public function imgDelete() {
        $id = Input::get('imgId');
        $catImage = StaticPage::find($id);
        $catImage->image = '';
        $catImage->save();
        Session::flash("msg", "Image deleted successfully!");
        return $data = ["status" => "success"];
    }

}
