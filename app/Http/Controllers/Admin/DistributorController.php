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

        if (Auth::guard('vswipe-users-web-guard')->check() !== false) {
			$distributor = Vendor::orderBy('id', 'desc');
        } 
        
        $categories = Category::where('status', 1)->get();
       
        $selCats = ['' => 'Select Category'];
        foreach ($categories as $cat) {
            $selCats[$cat->id] = $cat->category;
        }
       
        //$distributor = $distributor->paginate(Config('constants.AdminPaginateNo'));
       
        $data = [];
        $viewname = Config('constants.AdminPagesDistributors') . ".index";
        $data['distributor'] = $distributor;
        $data['selCats'] = $selCats;
        //$data['selBanks'] = $selBanks;
        //$data['storeList'] = $getAllStores;
echo $viewname;

        //print_r($data);
        //$viewname = 'Admin.Pages.distributors.index';
        return Helper::returnView($viewname,$data);
        
    }
}
