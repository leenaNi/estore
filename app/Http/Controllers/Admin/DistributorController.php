<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use App\Models\Category;
use App\Models\Country;
use App\Models\Bank;
use App\Models\Language;
use App\Models\Templates;
use App\Models\Zone;
use Illuminate\Support\Facades\Input;
use Hash;
use File;
use DB;
use ZipArchive;
use App\Library\Helper;
use Mail;
use Validator;
use Auth;
use Session;
use Illuminate\Http\Request;

class DistributorController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $headers = $request->headers->all();

        $allBanks = Bank::all();
        $bank['0'] = "Select Bank";
        foreach ($allBanks as $allB) {
            $bank[$allB->id] = $allB->name;
        }
        
        if (Auth::guard('vswipe-users-web-guard')->check() !== false) 
        {
            $distributors = Vendor::orderBy('id', 'desc')->get();
            
            //dd($distributors);exit;
        } 
        else if (Auth::guard('bank-users-web-guard')->check() !== false) 
        {
            $bkid = $this->getbankid();
            $distributors = Vendor::whereHas('hasMarchants', function($q) use($bkid) 
            {
                $q->where("bank_id", $bkid);
            })->orderBy('id', 'desc');
        } 
        else if (Auth::guard('merchant-users-web-guard')->check() !== false) 
        {
            $distributors = Vendor::orderBy('id', 'desc')->where("id", Session::get('authUserId'));
        } 
        else if (array_key_exists('token', $headers)) 
        {
            $distributors = Vendor::orderBy('id', 'desc')->where("id", Session::get('authUserId'));
        }
       
       /* if (Auth::guard('vswipe-users-web-guard')->check() !== false) {
			$distributors = Vendor::where('id', 11)->get();
        } */
       // echo count($distributors);
       // echo "<pre>";print_r($distributors);
        $categories = Category::where('status', 1)->get();
       
        $selCats = ['' => 'Select Category'];
        foreach ($categories as $cat) {
            $selCats[$cat->id] = $cat->category;
        }
       
        //$distributor = $distributor->paginate(Config('constants.AdminPaginateNo'));
       
        $data = [];
        $viewname = Config('constants.AdminPagesDistributors') . ".index";
        $data['distributor'] = $distributors;
        $data['selCats'] = $selCats;
        //$data['selBanks'] = $selBanks;
        //$data['storeList'] = $getAllStores;
        
        return Helper::returnView($viewname,$data);
    } // End index()
}