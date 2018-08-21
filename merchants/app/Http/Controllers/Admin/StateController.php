<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\State;
use App\Models\Country;
use Input;
use Session;
use App\Library\Helper;

class StateController extends Controller {

    public function index() {
       // dd(Country::take(2)->get());
        $countries = Country::where('status', 1)->orderBy('name')->get();
        $states = State::orderBy('state_name');
        // dd($states);
        if (!empty(Input::get('state_name'))) {
            $states = $states->where('state_name', 'like', '%' . Input::get('state_name') . '%');
        }

        if (!empty(Input::get('country_id'))) {
            $states = $states->where('country_id', Input::get('country_id'));
        }
        $country_id = Input::get('country_id') ? Input::get('country_id') : '';

        //dd($countries);
        $states = $states->paginate(Config('constants.paginateNo'));
        return view(Config('constants.adminStateView') . '.index', compact('states', 'countries', 'country_id'));
    }

    public function addEdit() {
        $state = State::find(Input::get("id"));
        //$coutries=Country::where('status',1)->orderBy('name')->pluck('name','id')->toArray(); 
        $coutries = Country::pluck('name','id')->toArray();
       // dd(count($coutries1));
        $action = route('admin.state.save');
        return view(Config('constants.adminStateView') . '.addEdit', compact('state', 'action', 'coutries'));
    }

    public function save() {
        $state = State::findOrNew(Input::get("id"));
        $state->country_id = Input::get("country_id");
        $state->state_name = Input::get("state_name");
        $state->save();
        if (empty(Input::get("id"))) {

            $data = ['status' => 1, 'message' => 'State added successfully.'];
            Session::flash("msg", "State added successfully.");
        } else {

            $data = ['status' => 1, 'message' => 'State updated successfully.'];
            Session::flash("msg", "State updated successfully.");
        }
        $viewname = '';
        return Helper::returnView($viewname, $data, $url = 'admin.state.view');
    }

     public function getState(){
        $id = Input::get('id');
        $states = State::where('country_id',$id)->pluck('state_name','id')->toArray();
        print_r(json_encode($states)); exit;
    }
     public function delete() {
        $id = Input::get('id');
        $settings = State::find($id);
        $settings->delete();
       Session::flash("message", "State deleted successfully.");
        return redirect()->back();
    }

}
