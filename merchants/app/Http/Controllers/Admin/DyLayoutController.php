<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Layout;
use App\Models\HasLayout;
use App\Library\Helper;
use session;
use Input;

class DyLayoutController extends Controller {

    public function index($uerKey = null) {
        $layout = Layout::where('url_key', $uerKey)->first();
        $layoutPage = HasLayout::where('layout_id', $layout->id)->get();
        $viewname = Config('constants.layoutView') . '.index';
        $data = ['layout' => $layout, 'layoutPage' => $layoutPage, 'slug' => $uerKey];
        return Helper::returnView($viewname, $data);
    }

    public function addEdit() {
        $layout = Layout::where('url_key', Input::get("url"))->first();
        $dynamiclayout = HasLayout::findOrNew(Input::get("id"));
     
        $action = route('admin.dynamic-layout.save');
        // return view(Config('constants.loyaltyView') . '.addEdit', compact('loyalty', 'action'));
        $viewname = Config('constants.layoutView') . '.addEdit';
        $data = ['layoutPage' => $dynamiclayout, 'action' => $action, 'layout' => $layout, 'slug' => Input::get("url")];
        return Helper::returnView($viewname, $data);
    }

    public function saveUpdate() {
        $url = Input::get("url");
        $dynamiclayout = HasLayout::findOrNew(Input::get("id"));
        $dynamiclayout->layout_id = Input::get("layout_id");
        $dynamiclayout->name = Input::get("name");
        $dynamiclayout->desc = Input::get("desc");
        $dynamiclayout->link = Input::get("link");
        $dynamiclayout->is_active = Input::get("is_active");
        $dynamiclayout->sort_order = Input::get("sort_order");
        //dd(Input::file('sliderImg')->getClientOriginalName());
        if (!empty('slider_img_url')) {
            $destinationPath = Config('constants.layoutUploadPath');
            $data = Input::get('slider_img_url');
            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = base64_decode($data);
            $fileName = date("YmdHis") . "." . Input::file('sliderImg')->getClientOriginalExtension();
            file_put_contents($destinationPath.$fileName, $data);
            $dynamiclayout->image = $fileName;
            //$upload_success = @Input::file('image')->move(@$destinationPath, @$fileName);

        }
        // if (!empty($upload_success)) {
        //     $dynamiclayout->image = $fileName;
        // }
        if(!empty(Input::get("id")))
          $action = " updated";
        else
          $action = " added";

      Session::flash("msg", ucfirst(strtolower($dynamiclayout->name))." ".$action." successfully.");
      $dynamiclayout->save();
          
       return redirect()->route('admin.dynamic-layout.view',$url);
      // return redirect::route('admin.dynamic-layout.view')->with('slug', $url);
  }
  
   public function edit(){
       $layout=Layout::where('url_key',Input::get("url"))->first();
        $dynamiclayout=HasLayout::find(Input::get("id"));
         $layout=Layout::where('id',$dynamiclayout->layout_id)->first();
        $action = route('admin.dynamic-layout.saveEdit');
        // return view(Config('constants.loyaltyView') . '.addEdit', compact('loyalty', 'action'));
        $viewname = Config('constants.layoutView') . '.addEdit';
        $data = ['layoutPage' => $dynamiclayout, 'action' => $action, 'layout' => $layout];
        return Helper::returnView($viewname, $data);
    }

    public function saveEdit() {
        //dd(Input::all());
        $url = Input::get("url");
        $dynamiclayout = HasLayout::find(Input::get("id"));
        //$dynamiclayout->layout_id = Input::get("layout_id");
        $dynamiclayout->name = Input::get("name");
        $dynamiclayout->desc = Input::get("desc");
        $dynamiclayout->link = Input::get("link");
        $dynamiclayout->is_active = Input::get("is_active");
        $dynamiclayout->sort_order = Input::get("sort_order");
        if (Input::hasFile('image')) {
            $destinationPath = Config('constants.layoutUploadPath');
            $fileName = date("YmdHis") . "." . Input::file('image')->getClientOriginalExtension();
            $upload_success = @Input::file('image')->move(@$destinationPath, @$fileName);
        } else {

            $fileName = Input::get("old_image");
        }
        if (!empty($upload_success)) {
            $dynamiclayout->image = $fileName;
        }
      $dynamiclayout->save();
        Session::flash("msg", ucfirst(strtolower($dynamiclayout->name)). " updated successfully."); 
       // return redirect('admin.dynamic-layout.view',$url);
       return redirect()->route('admin.dynamic-layout.view',$url);
      // return redirect::route('admin.dynamic-layout.view')->with('slug', $url);
  }
  
    public function changeStatus() {

        $id = Input::get('id');
        $updateDyn = HasLayout::find($id);
       
        if( $updateDyn->is_active==1){
              $attrStatus = 0;
            $updateDyn->is_active=$attrStatus;
           $msg = ucfirst($updateDyn->name) ." disabled successfully."; 
            Session::flash("message",$msg);
             $updateDyn->update();
         return redirect()->back()->with('message', $msg);
        }else if($updateDyn->is_active==0){
             $attrStatus = 1;
           $updateDyn->is_active=$attrStatus;  
            $msg=ucfirst($updateDyn->name) ." enabled successfully.";
             Session::flash("msg",$msg);
              $updateDyn->update();
        return redirect()->back()->with('msg', $msg);
        }
    }

    public function delete(){
       $banner = HasLayout::find(Input::get('id'));
       $banner->delete();

       if($banner){

          return redirect()->back()->with('msg', 'Slider deleted successfully.');
        } else {
            return redirect()->back()->with('message', 'Sorry something went wrong.');
        }

    }

}