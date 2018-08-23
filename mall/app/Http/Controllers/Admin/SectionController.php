<?php

namespace App\Http\Controllers\Admin;

use Route;
use Input;
use App\Models\Category;
use App\Library\Helper;
use App\Classes\UploadHandler;
use App\Http\Controllers\Controller;
use App\Models\CatalogImage;
use App\Models\Tax;
use App\Models\Product;
use App\Models\HasTaxes;
use App\Models\HasCurrency;
use App\Models\Vendor;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\User;
use App\Models\GeneralSetting;
use App\Models\ProductType;
use App\Models\AttributeSet;
use App\Models\Section;
use DB;
use Session;

class SectionController extends Controller {
	
	public function index() {
        $sections = Section::paginate(Config('constants.paginateNo'));
        return Helper::returnView(Config('constants.adminSectionView') . '.index', compact('sections'));
        
    }


    public function add(){
    	$section = new Section;
        $action = route("admin.section.save");
       
        return view(Config('constants.adminSectionView') . '.addEdit', compact('section','action'));
    
    }

    public function save(){
    	Section::create(Input::all());
    	Session::flash("msg", "Section Added successfully.");
    	return redirect()->route('admin.section.view');
    }


    public function edit(){
        
    	$section = Section::findOrFail(Input::get('id'));

    	$action = route("admin.section.update");

        return view(Config('constants.adminSectionView') . '.addEdit', compact('section','action'));
    }

    public function update(){
    	$prod = Section::find(Input::get('id'));
    	$prod->update(Input::all());
    	Session::flash("msg", "Section updated successfully.");
    	return redirect()->route('admin.section.view');
    }

    public function delete(){
    	$prod = Section::find(Input::get('id'));
    	$prod->delete();
    	Session::flash("messege", "Section deleted successfully.");
    	return redirect()->route('admin.section.view');
    }


}