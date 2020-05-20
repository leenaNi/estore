<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Models\Bank;
use App\Models\Category;
use App\Models\Currency;
use App\Library\Helper;
use App\Models\Document;
use App\Models\Layout;
use Validator;
use Illuminate\Support\Facades\Input;
use Hash;
use Session;
use Auth;
use DB;

class VendorController extends Controller
{
	public function index(Request $request) {

		$headers = $request->headers->all();

		if (Auth::guard('vswipe-users-web-guard')->check() !== false) {
			$vendors = Vendor::orderBy('id', 'desc');
		} 

		$search = Input::get('search');
		if (!empty($search)) {

			if (!empty(Input::get('firstname'))) {
				$vendors = $vendors->where("firstname", "like", "%" . Input::get('firstname') . "%");
			}
			if (!empty(Input::get('email'))) {
				$vendors = $vendors->where("email", "like", "%" . Input::get('email') . "%");
			}
			if (!empty(Input::get('date_search'))) {
				$dateArr = explode(" - ", Input::get('date_search'));
				$fromdate = date("Y-m-d", strtotime($dateArr[0])) . " 00:00:00";
				$todate = date("Y-m-d", strtotime($dateArr[1])) . " 23:59:59";
				$vendors = $vendors->where("created_at", ">=", "$fromdate")->where("created_at", "<","$todate");
			}
		}

		$vendors = $vendors->paginate(Config('constants.AdminPaginateNo'));
		$data = [];
		$viewname = Config('constants.AdminPagesVendor') . ".index";

		$data['vendors'] = $vendors;


		return Helper::returnView($viewname, $data);
	}

	public function addEdit() {
		$vendor = Vendor::findOrNew(Input::get('id'));

		$data = [];
		$data['already_selling'] = [];
		if ($vendor && Input::get('id')) {
			$data['already_selling'] = json_decode($vendor->industries);
		}
		$cat = Category::where("status", 1)->select('category', 'id')->get();
		$curr = Currency::where('status', 1)->orderBy("iso_code", "asc")->get(['status', 'id', 'name', 'iso_code']);

		$viewname = Config('constants.AdminPagesVendor') . ".addEdit";
		$data['vendor'] = $vendor;
		$data['cat'] = $cat;
		$data['curr'] = $curr;
        //dd($data);
		return Helper::returnView($viewname, $data);
	}

	public function saveUpdate(Request $request) {
		$vendor = Vendor::findOrNew(Input::get('id'));
		$password = Hash::make(Input::get('password'));
		$vendor->firstname = $request->firstname;
		$vendor->phone = $request->phone;
		$vendor->email = $request->email;
		$vendor->currency = $request->currency;
		$vendor->industries = json_encode($request->already_selling);
		$vendor->password = $password;
		$vendor->save();
		$data['id'] = $vendor->id;
		$data['vendor'] = $vendor;
		$data['status'] = "Saved successfully";
		Session::flash('status', 'Vendor Saved Successfully...');
		return Helper::returnView(null, $data);
	}
}
