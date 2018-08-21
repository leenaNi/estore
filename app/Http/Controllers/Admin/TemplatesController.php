<?php

namespace App\Http\Controllers\Admin;

use App\Models\Templates;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Validator;
use Session;
class TemplatesController extends Controller {

    /**
     * Show the profile for the given user.
     *
     * @param  int  $id
     * @return Response
     */
    public function index() {
        $templates = Templates::orderBy("id", "asc");
        if (!empty(Input::get('name'))) {
            $templates = $templates->where("name", "like", "%" . Input::get('name') . "%");
        }
        $templates = $templates->paginate(Config('constants.AdminPaginateNo'));
        //dd(Config('constants.AdminPagesTemplates') . ".index");
        return view(Config('constants.AdminPagesTemplates') . ".index", ['templates' => $templates]);
    }

    public function add() {
        $template = new Templates();
        $action = 'admin.templates.save';
        return view(Config('constants.AdminPagesTemplates') . ".addEdit", ['template' => $template, 'action' => $action, 'form_type' => 'add']);
    }

    public function edit() {
        $template = Templates::find(Input::get('id'));
        $action = 'admin.templates.save';
        return view(Config('constants.AdminPagesTemplates') . ".addEdit", ['template' => $template, 'action' => $action, 'form_type' => 'edit']);
    }

    public function save() {
        $msg='';
        if(Input::get('id')){
            $rules = ['name' => 'required', 'file' => 'mimes:zip', 'screenshot' => 'mimes:png,jpeg'];
            $msg = 'Template update successfully';         
        }else{            
            $rules = ['name' => 'required', 'file' => 'required|mimes:zip', 'screenshot' => 'required|mimes:png,jpeg']; 
            $msg = 'Template added successfully';
        }
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            $validations = $validator->errors()->all();
            $message = "";
            foreach ($validations as $key=>$val){
                $message.=$val;
            }
            Session::flash("errorMessage",$message);
        } else {
            $templates = Templates::findOrNew(Input::get('id'));
            $templates->name = Input::get('name');
            if (Input::file('file')) {
                $file = Input::file('file');
                $destinationPath = public_path() . '/public/templates/';
                $fileName = "templete_". date("YmdHis").'_' . str_replace(' ', '_', trim($file->getClientOriginalName()));
                $upload_success = $file->move($destinationPath, $fileName);
                $templates->file = '/templates/'.$fileName;
            }
            if (Input::file('screenshot')) {
                $file = Input::file('screenshot');
                $destinationPath = public_path() . '/public/templates/';
                $fileName = "thumbnail_". date("YmdHis").'_' . str_replace(' ', '_', trim($file->getClientOriginalName()));
                $upload_success = $file->move($destinationPath, $fileName);
                $templates->screenshot = '/templates/'.$fileName;
            }
            if ($templates->save()) {
                Session::flash("successMessage",$msg);
                return redirect()->route('admin.templates.view');
            }else{
                Session::flash("errorMessage","Error occured. Please try again later");
            }
        }
        return redirect()->back();
    }

    public function delete() {
        $templates = Templates::find(Input::get('id'));
        if ($templates->delete()) {
                Session::flash("successMessage","Templete deleted successfully");                
            }else{
                Session::flash("errorMessage","Error occured. Please try again later");
            }
            return redirect()->route('admin.templates.view');
    }

}
