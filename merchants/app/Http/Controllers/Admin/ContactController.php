<?php

namespace App\Http\Controllers\Admin;

use Route;
use Input;
use App\Models\Contact;
use App\Http\Controllers\Controller;
use App\Library\Helper;
use App\Models\Zone;
use App\Models\Country;
use Session;
use Illuminate\Http\Request;
use DB;
use Validator;

class ContactController extends Controller {

    public function index() {
        $search_fields = ['phone_no', 'email'];

        if (!empty(Input::get("phone_no")) || !empty(Input::get("email"))) {
            $contactInfo = Contact::where(function($query) use($search_fields) {
                        foreach ($search_fields as $field) {
                            if (!empty(Input::get($field))) {
                                $search = Input::get($field);
                                $query->Where($field, "like", "%$search%");
                            }
                        }
                    })->get();
            $contactCount = $contactInfo->count();
        } else {
            $contactInfo = Contact::paginate(Config('constants.paginateNo'));
            $contactCount = $contactInfo->total();
        }
        //  dd($contactInfo);
        $data = ['contactInfo' => $contactInfo, 'contactCount' => $contactCount];
        $viewname = Config('constants.adminContactView') . '.index';
        return Helper::returnView($viewname, $data);
    }

    public function add() {
        $contact = Contact::find(Input::get('id'));
        $action = route("admin.contact.save");
      
      $coutries = Country::where("status",1)->orderBy('name')->pluck('name','id')->toArray();
        $states=Zone::orderBy('name')->get();
      $state=[];
          foreach($states as $value){
            $state[$value['id']]=$value['name'];
      }
        $data = ['contact' => $contact, 'action' => $action,'state'=>$state,'coutries'=>$coutries];
        $viewname = Config('constants.adminContactView') . '.addEdit';
        return Helper::returnView($viewname, $data);
    }

    public function edit() {
        $contact = Contact::find(Input::get('id'));
        $action = route("admin.contact.update");
       
      $coutries = Country::where("status",1)->orderBy('state_name')->pluck('name','id')->toArray();
        $states=Zone::orderBy('name')->get();
      $state=[];
          foreach($states as $value){
            $state[$value['id']]=$value['name'];
      }
      $data = ['contact' => $contact, 'action' => $action, 'new' => '0','state'=>$state,'coutries'=>$coutries];
        $viewname = Config('constants.adminContactView') . '.addEdit';
        return Helper::returnView($viewname, $data);
    }

    public function save(Request $request) {
        Validator::make($request->all(), [
            'customer_name' => 'required',
            'email' => 'required|email',
            'address' => 'required|min:10',
            'phone_no' => 'required',
                ], [
            'email.required' => 'The email id field is required.',
            'email.email' => 'Please enter valid email id',
            'address.required' => 'The address field is required.',
            'address.min' => 'Minimum 10 character required.',
            'phone_no.required' => 'The phone number field is required.',
        ])->validate();
        
        $contact = Contact::findOrNew(Input::get('id'));
        $contact->customer_name = Input::get('customer_name');
        $contact->phone_no = Input::get('phone_no');
        $contact->email = Input::get('email');
        $contact->status = 1;
       
        $contact->address = Input::get('address');
        $contact->address2 = Input::get('address2');
        $contact->state = Input::get('state');
        $contact->country = Input::get('country');
        $contact->city = Input::get('city');
        $contact->pincode = Input::get('pincode');
       $contact->map_url = Input::get('map_url');
       $contact->store_id = Session::get('store_id');
//        $contact->vat = Input::get('vat');
        $contact->save();
        if (empty(Input::get('id'))) {
            Session::flash("msg", "Contact details added successfully.");
        } else {
            Session::flash("msg", "Contact details updated successfully.");
        }

        $viewname = Config('constants.adminContactView') . '.index';
        $data = ['status' => '1', 'msg' => (Input::get('id') != '') ? 'Contact details updated successfully.' : 'Contact details added successfully.'];
        return Helper::returnView($viewname, $data, $url = 'admin.contact.view');
    }

    public function update(Request $request) {
        Validator::make($request->all(), [
            'customer_name' => 'required',
            'email' => 'required|email',
            'address1' => 'required|min:10',
            'phone_no' => 'required',
                ], [
            'email.required' => 'The email id field is required.',
            'email.email' => 'Please enter proper email id',
            'address.required' => 'The address field is required.',
            'address.min' => 'The address field required min 10 character.',
            'phone_no.required' => 'The phone number field is required.',
        ])->validate();
       
        $contact = Contact::find(Input::get('id'));
        $contact->customer_name = Input::get('customer_name');
        $contact->phone_no = Input::get('phone_no');
        $contact->email = Input::get('email');
        $contact->status = Input::get('status');
        $contact->address = Input::get('address');
        $contact->address2 = Input::get('address2');
        $contact->state = Input::get('state');
        $contact->country = Input::get('country');
        $contact->city = Input::get('city');
        $contact->pincode = Input::get('pincode');
        $contact->map_url = Input::get('map_url');
        $contact->store_id = Session::get('store_id');
       // $contact->vat = Input::get('vat');
        $contact->update();
        Session::flash("msg", "Contact details updated successfully.");
        $viewname = Config('constants.adminContactView') . '.index';
        $data = ['status' => '1', 'msg' => (Input::get('id') != '') ? 'Contact details updated successfully.' : 'Contact details added successfully.'];
        return Helper::returnView($viewname, $data, $url = 'admin.contact.view');
    }

    public function delete(Request $request) {
        $contact = Contact::find($request->id);
        $contact->delete();
        Session::flash("message", "Contact details deleted successfully.");
        $data = ['status' => '1', 'msg' => 'Contact detail deleted successfully.'];
        $viewname = Config('constants.adminContactView') . '.index';
        return Helper::returnView($viewname, $data, $url = 'admin.contact.view');
    }

    public function changeStatus(Request $request) {
        $contact = Contact::find($request->id);
        if ($contact->status == 1) {
            $contact->status = 0;
            $msg = "Contact details disabled successfully.";
            Session::flash("message", $msg);
        } else {
            $contact->status = 1;
            $msg = "Contact details enabled successfully.";
            Session::flash("msg", $msg);
        }
        $contact->update();
        
        $data = ['status' => '1', 'msg' => $msg];
        $viewname = Config('constants.adminContactView') . '.index';
        return Helper::returnView($viewname, $data, $url = 'admin.contact.view');
    }
public function getState(){
    $countryId=Input::get("country_id");
      $states=Zone::where("country_id",$countryId)->orderBy('name')->get();
      $state=[];
          foreach($states as $value){
            $state[$value['id']]=$value['name'];
      }
      return $state;
}
}

?>