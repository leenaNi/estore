<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use App\Models\Order;

use App\Models\Category;
use App\Models\Currency;
use App\Library\Helper;


use Validator;
use Illuminate\Support\Facades\Input;
use Hash;
use Session;
use Auth;
use DB;

class PaymentSettlementController extends Controller {

    public function index() {


        $headers = $request->headers->all();

        $allBanks = Bank::all();
        $bank['0'] = "Select Bank";
        foreach ($allBanks as $allB) {
            $bank[$allB->id] = $allB->name;
        }

        if (Auth::guard('vswipe-users-web-guard')->check() !== false) {
            $merchants = Merchant::orderBy('id', 'desc');
        } else if (Auth::guard('bank-users-web-guard')->check() !== false) {
            $bkid = $this->getbankid();
            $merchants = Merchant::whereHas('hasMarchants', function($q) use($bkid) {
                        $q->where("bank_id", $bkid);
                    })->orderBy('id', 'desc');
        } else if (Auth::guard('merchant-users-web-guard')->check() !== false) {
            $merchants = Merchant::orderBy('id', 'desc')->where("id", Session::get('authUserId'));
        } else if (array_key_exists('token', $headers)) {
            $merchants = Merchant::orderBy('id', 'desc')->where("id", Session::get('authUserId'));
        }


        $search = Input::get('search');
        if (!empty($search)) {

            if (!empty(Input::get('s_bank_name'))) {
                $merchants = $merchants->whereHas("hasMerchants", function($query) {
                    $query->where("banks.id", Input::get('s_bank_name'));
                });
            }
            if (!empty(Input::get('s_company_name'))) {
                $merchants = $merchants->where("firstname", "like", "%" . Input::get('s_company_name') . "%");
            }
            if (!empty(Input::get('s_email'))) {
                $merchants = $merchants->where("email", "like", "%" . Input::get('s_email') . "%");
            }
            if (!empty(Input::get('date_search'))) {
                $dateArr = explode(" - ", Input::get('date_search'));
                $fromdate = date("Y-m-d", strtotime($dateArr[0])) . " 00:00:00";
                $todate = date("Y-m-d", strtotime($dateArr[1])) . " 23:59:59";
                $merchants = $merchants->where("created_at", ">=", "$fromdate")->where("created_at", "<", "$todate");
            }
        }

        $merchants = $merchants->paginate(Config('constants.AdminPaginateNo'));
        $data = [];
        $viewname = Config('constants.AdminPagesMerchant') . ".index";
        $data['merchants'] = $merchants;
        $data['bank'] = $bank;

        return Helper::returnView($viewname, $data);
    }


}
