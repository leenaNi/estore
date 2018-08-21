<?php

namespace App\Http\Controllers\Admin;

use Route;
use Input;
use App\Http\Controllers\Controller;
use App\Models\EmailTemplate;
use DB;

class EmailTemplatesController extends Controller {

    public function index() {
        //print_r(Route::currentRouteName());
        $emailTemp = EmailTemplate::all();
        return view(Config('constants.adminEmailTempView') . '.index', compact('emailTemp'));
    }

    public function add() {
        $id = Input::get('id');
        $emailTemp = EmailTemplate::findOrNew($id);
        $action = route("admin.email.save");
        return view(Config('constants.adminEmailTempView') . '.addEdit', compact('emailTemp', 'action'));
    }

    public function save() {
       // dd(Input::all());
        $id = Input::get('id');
        $emailTemp = EmailTemplate::findOrNew($id);
        $emailTemp->name = Input::get('name');
        $emailTemp->subject = Input::get('subject');
        $emailTemp->content = Input::get('content');
        $emailTemp->status = Input::get('status');;
        $emailTemp->save();
        if ($id == "") {
            Session::flash("msg", "Email template added successfully.");
        } else {
            Session::flash("msg", "Email template updated successfully.");
        }
        return redirect()->route('admin.email.view');
    }
    
    
    public function sendTemplate(){
        dd(Input::all());
    }

}
