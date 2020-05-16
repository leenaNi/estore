<?php

namespace App\Http\Controllers\Admin;

use Input;
use App\Models\Role;
use App\Models\User;
use App\Models\Slider;
use App\Models\SliderMaster;
use Hash;
use Auth;
use Session;
use App\Library\Helper;
use App\Http\Controllers\Controller;

class SliderController extends Controller {

    public function index() {
        dd(123);
        $allSiders = Slider::all();
        $search = !empty(Input::get("search")) ? Input::get("search") : '';
        $search_fields = ['title'];
        $allSiders = Slider::orderBy("id", "asc");
        $allSiders = $allSiders->where(function($query) use($search_fields, $search) {
            foreach ($search_fields as $field) {
                $query->orWhere($field, "like", "%$search%");
            }
        });
        $allSiders = $allSiders->paginate(Config('constants.paginateNo'));
        return view(Config('constants.adminSliderView') . '.index', compact('allSiders'));
    }

    public function add() {
        $masterSiders = SliderMaster::where(['is_active' => '0', 'delete_master' => '0'])->get();
        $slider = new Slider();
        $action = route('admin.slider.save');
        return view(Config('constants.adminSliderView') . '.addEdit', compact('slider', 'action', 'masterSiders'));
    }

    public function save() {
        $save = Slider::create(Input::except('image'));
        $save->slider_id = Input::get('slider_id');
        $save->store_id = Session::get('store_id');
        if (Input::hasFile('image')) {
            $destinationPath = Config('constants.sliderUploadPath');
            $fileName = date("YmdHis") . "." . Input::file('image')->getClientOriginalExtension();
            $upload_success = Input::file('image')->move($destinationPath, $fileName);
            if (!empty($upload_success)) {
                $save->image = $fileName;
            } else {
                
            }
        }
        $save->save();
        return redirect()->route('admin.sliders.view');
    }

    public function edit() {
        $masterSiders = SliderMaster::where('is_active', '0')->get();
        $slider = Slider::find(Input::get('id'));
        $action = route('admin.slider.update');
        return view(Config('constants.adminSliderView') . '.addEdit', compact('slider', 'action', 'masterSiders'));
    }

    public function update() {
        $sliderUpdate = Slider::find(Input::get('id'));
        $sliderUpdate->title = Input::get('title');
        $sliderUpdate->link = Input::get('link');
        $sliderUpdate->is_active = Input::get('is_active');
        $sliderUpdate->sort_order = Input::get('sort_order');
        $sliderUpdate->slider_id = Input::get('slider_id');
        $sliderUpdate->alt = Input::get('alt');
        $sliderUpdate->store_id = Session::get('store_id');
        if (Input::hasFile('image')) {
            $destinationPath = Config('constants.sliderUploadPath');
            $fileName = date("YmdHis") . "." . Input::file('image')->getClientOriginalExtension();
            $upload_success = Input::file('image')->move($destinationPath, $fileName);
            if ($upload_success) {
                $sliderUpdate->image = $fileName;
            } else {
                
            }
        }
        $sliderUpdate->Update();
        return redirect()->route('admin.sliders.view');
    }

    public function delete() {
        $slider = Slider::find(Input::get('id'));
        $slider->delete();
        return redirect()->route('admin.sliders.view');
    }
    public function changeStatus() {
        $slider = Slider::find(Input::get('id'));
        if ($slider->is_active == 1) {
            $sliderStatus = 0;
            $msg = "Slider disabled successfully.";
            $slider->is_active = $sliderStatus;
            $slider->update();
            return redirect()->back()->with('message', $msg);
        } else   if ($slider->is_active == 0) {
            $sliderStatus = 1;
            $msg = "Slider enabled successfully.";
            $slider->is_active = $sliderStatus;
            $slider->update();
            return redirect()->back()->with('msg', $msg);
        }
    }

    function list_slider() {
        $allSiders = SliderMaster::get();
        return view(Config('constants.adminSliderView') . '.masterSlider', compact('allSiders'));
    }

    function add_slider() {
        $slider = new SliderMaster;
        $action = route('admin.slider.saveEditSlider');
        return view(Config('constants.adminSliderView') . '.addEditMaster', compact('slider', 'action'));
    }

    function edit_slider($id) {
        $slider = SliderMaster::find($id);
        $action = route('admin.slider.saveEditSlider');
        return view(Config('constants.adminSliderView') . '.addEditMaster', compact('slider', 'action'));
    }

    function soft_delete($id) {
        $getcount = Slider::where('slider_id', $id)->count();
       // dd($getcount);
        if ($getcount <= 0) {
            $sliderUpdate = SliderMaster::find($id);
            $sliderUpdate->delete();
            Session::flash("message", "Tax deleted successfully");
            $data = ['status' => '1', 'msg' => 'Tax deleted successfully'];
        } else {
            Session::flash("message", 'Sorry This slider master is part of a slider! Delete the slider first!');
            $data = ['status' => '1', 'msg' => 'Sorry This slider master is part of a slider! Delete the slider first!'];
        }
       
        $viewname = Config('constants.adminSliderView') . '.masterSlider';
        return Helper::returnView($viewname, $data, $url = 'admin.slider.masterList');
    }

    function save_edit_slider() {
        $sliderUpdate = SliderMaster::findornew(Input::get('id'));
        $sliderUpdate->slider = Input::get('slider');
        $sliderUpdate->is_active = Input::get('is_active');
        $sliderUpdate->save();
        return redirect()->route('admin.slider.masterList');
    }

    public function updateMasterList() {
        // dd(Input::get('id'));
        $sliderMast = SliderMaster::find(Input::get('id'));
        if ($sliderMast->is_active == 1) {
            $smStatus = '0';
            $msg = "Slider Master disabled successfully";
            $sliderMast->is_active = $smStatus;
            $sliderMast->update();
            Session::flash("message", $msg);
            $data = ['status' => '1', 'msg' => $msg];
            $viewname = Config('constants.adminSliderView') . '.masterSlider';
            return Helper::returnView($viewname, $data, $url = 'admin.slider.masterList');
            // return redirect()->back()->with('message', $msg);
        } else if ($sliderMast->is_active == 0) {
            $smStatus = '1';
            $msg = "Slider Master enabled successfully";
            $sliderMast->is_active = $smStatus;
            $sliderMast->update();
            // dd($sliderMast->update());
            Session::flash("msg", $msg);
            $data = ['status' => '1', 'msg' => $msg];
            $viewname = Config('constants.adminSliderView') . '.masterSlider';
            return Helper::returnView($viewname, $data, $url = 'admin.slider.masterList');
            // return redirect()->back()->with('msg', $msg);
        }
    }

}
