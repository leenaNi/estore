<?php
namespace App\Http\Controllers\Admin;

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
       
        $search = Input::get('search');
        if (!empty($search)) {

            if (!empty(Input::get('s_bank_name'))) {
                $distributors = $distributors->whereHas("hasMerchants", function($query) {
                    $query->where("banks.id", Input::get('s_bank_name'));
                });
            }
            //echo "anme >> ".Input::get('s_company_name');
            if (!empty(Input::get('s_company_name'))) {
                $distributors = $distributors->where("firstname", "like", "%" . Input::get('s_company_name') . "%");
            }
            if (!empty(Input::get('s_email'))) {
                $distributors = $distributors->where("email", "like", "%" . Input::get('s_email') . "%");
            }
            if (!empty(Input::get('date_search'))) {
                $dateArr = explode(" - ", Input::get('date_search'));
                $fromdate = date("Y-m-d", strtotime($dateArr[0])) . " 00:00:00";
                $todate = date("Y-m-d", strtotime($dateArr[1])) . " 23:59:59";
                $distributors = $distributors->where("created_at", ">=", "$fromdate")->where("created_at", "<", "$todate");
            }
        }

        //echo "<pre>";print_r($distributors);

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
        //echo "<pre>";
        //print_r($distributors);
        //exit;
        $data['distributor'] = $distributors;
        $data['selCats'] = $selCats;
        //$data['selBanks'] = $selBanks;
        //$data['storeList'] = $getAllStores;
        
        return Helper::returnView($viewname,$data);
    } // End index()

    public function addEdit()
    {        
        $fetchedDistributorData = Vendor::findOrNew(Input::get('id'));
        //echo "<pre>";print_r($fetchedDistributorData);
        $data = [];
        $data['already_selling'] = [];
        if ($fetchedDistributorData && Input::get('id')) {
            $resgisterDetails = json_decode($fetchedDistributorData->register_details);
            //echo "<pre>";print_r($resgisterDetails);exit;
            $data['cat_selected'] = $resgisterDetails->business_type;
            //$data['curr_selected'] = $resgisterDetails->currency;
            $data['curr_selected'] = $fetchedDistributorData->currency_code;
            if(isset($resgisterDetails->already_selling) && !empty($resgisterDetails->already_selling))
                $data['already_selling'] = ($resgisterDetails->already_selling);
            //$data['store_version'] = ($resgisterDetails->store_version);
            $data['store_version'] = '';
        }

        $cat = Category::where("status", 1)->pluck('category', 'id')->prepend('Choose your Industry *', '');
        $curr = Currency::where('status', 1)->orderBy("iso_code", "asc")->get(['status', 'id', 'name', 'iso_code']);

        $viewname = Config('constants.AdminPagesDistributors') . ".addEdit";
        $data['distributor'] = $fetchedDistributorData;
        $data['cat'] = $cat;
        $data['curr'] = $curr;
        return Helper::returnView($viewname, $data);
    } // End addEdit();

    public function saveUpdate() {
        dd("asssas");
    } // Edn saveUpdate()
}