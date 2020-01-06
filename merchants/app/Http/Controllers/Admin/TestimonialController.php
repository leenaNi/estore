<?php

namespace App\Http\Controllers\Admin;

use Route;
use Input;
use App\Models\User;
use App\Models\Testimonials;
use Auth;
use App\Models\Permission;
use App\Http\Controllers\Controller;
use Session;
use App\Library\Helper;
use DB;

class TestimonialController extends Controller {

    public function index() {
            $status=Input::get("status")=='0' ||Input::get("status")=='1' ?Input::get("status"):'';
        $testimonial = Testimonials::with('users')->orderBy('sort_order');
        if(!empty(Input::get("search"))){
            $testimonial=$testimonial->where("testimonial",'like','%'.Input::get("search").'%');
        }
        
         if( Input::get("status") =='0' || Input::get("status") =='1' ){
           
            $testimonial=$testimonial->where("status",Input::get("status"));
        }
        $public_path =Config('constants.adminTestimonialImgPath').'/';
         $testimonial=$testimonial->get();
        return view(Config('constants.testimonialView') . '.index', compact('testimonial','status','public_path'));
    }

    public function addEdit(){
        $testimonial=Testimonials::find(Input::get("id"));
        $action=route('admin.testimonial.save');
       // dd($testimonial->customer_name);
        //$data=['testimonial' =>$testimonial,'action'=>$action];
       // dd($data);
         return view(Config('constants.testimonialView') . '.addEdit',['testimonial' =>$testimonial,'action'=>$action,'public_path' => 'public/Admin/uploads/']);
    }
    
    public function save(){
         $testimonial=Testimonials::findOrNew(Input::get("id"));
         $testimonial->user_id=Session::get('loggedinAdminId');
         $testimonial->customer_name=Input::get('customer_name');
         $testimonial->Testimonial=Input::get('testimonial');
         $testimonial->sort_order=Input::get('sort_order');
         $testimonial->gender = Input::get('gender'); 
         $testimonial->status=Input::get('status');
         
          if (Input::hasFile('image')) {
            $destinationPath = Config('constants.adminTestimonialUploadPath');
            $fileName = date("dmYHis") . "." . Input::File('image')->getClientOriginalExtension();
            $upload_success = Input::File('image')->move($destinationPath, $fileName);
        } else {
            $fileName = (!empty(Input::get('image')) ? Input::get('image') : '');
        }
         $testimonial->image=$fileName;
        $testimonial->save();
          $data='';
          $viewname='';
          if(empty(Input::get("id"))){
           Session::flash("msg", "Testimonial added successfully.");   
          }else{
              
            Session::flash("msg", "Testimonial updated successfully.");   
          }
          
              return Helper::returnView($viewname, $data, $url = 'admin.testimonial.view');
    }
    public function changeStatus() {
        $testimonial = Testimonials::find(Input::get('id'));
        if ($testimonial->status == 1) {
            $testimonialStatus = 0;
            $msg = "Testimonial disabled successfully.";
            $testimonial->status = $testimonialStatus;
            $testimonial->update();
            return redirect()->back()->with('message', $msg);
        } else if ($testimonial->status == 0) {
            $testimonialStatus = 1;
            $msg = "Testimonial enabled successfully.";
            $testimonial->status = $testimonialStatus;
            $testimonial->update();
            return redirect()->back()->with('msg', $msg);
        }
    }

    public function delete() {

        $testimonial1 = Testimonials::find(Input::get('id'));
       // dd($testimonial);
        $testimonial1->delete();
          Session::flash("message", "Testimonial deleted successfully.");
       $data='';
        $viewname='';
        return Helper::returnView($viewname, $data, $url = 'admin.testimonial.view');
    }

}

?>