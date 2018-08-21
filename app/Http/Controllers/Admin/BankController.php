<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use App\Library\Helper;
use App\Models\Document;
use App\Models\Bank;
use App\Models\BankUser;
use Validator;
use Illuminate\Support\Facades\Input;
use Hash;

class BankController extends Controller {

    public function index() {
        $banks = Bank::orderBy("id", "desc");
        $search = Input::get('search');
        if (!empty($search)) {
            if (!empty(Input::get('s_bank_name'))) {
                $banks = $banks->where("name", "like","%".Input::get('s_bank_name')."%");
            }
            if (!empty(Input::get('s_email'))) {
                $banks = $banks->where("email", "like", "%" . Input::get('s_email') . "%");
            }
            if (!empty(Input::get('date_search'))) {
                $dateArr = explode(" - ", Input::get('date_search'));
                $fromdate = date("Y-m-d", strtotime($dateArr[0])) . " 00:00:00";
                $todate = date("Y-m-d", strtotime($dateArr[1])) . " 23:59:59";
                $banks = $banks->where("created_at", ">=", "$fromdate")->where("created_at", "<", "$todate");
            }
        }

        $banks = $banks->paginate(Config('constants.AdminPaginateNo'));
        
        $selBanks = [""=>'Select Bank'];
        
        foreach(Bank::orderBy("id", "desc")->get() as $sBank){
          $selBanks[$sBank->id] = $sBank->name;  
        }
        
        $data = [];
        $viewname = Config('constants.AdminPagesBank') . ".index";
        $data['banks'] = $banks;
        $data["selBanks"]=$selBanks;
        return Helper::returnView($viewname, $data);
    }

    public function addEdit() {
        $bank = Bank::findOrNew(Input::get('id'));

        $data = [];
        $viewname = Config('constants.AdminPagesBank') . ".addEdit";
        $data['bank'] = $bank;
        return Helper::returnView($viewname, $data);
    }

    public function saveUpdate() {

        $validation = new Bank();
        $validator = Validator::make(Input::all(), Bank::rules(Input::get('id')));
        if ($validator->fails()) {
            return $validator->messages()->toJson();
        } else {
            $bank = Bank::findOrNew(Input::get('id'));
            $bank->fill(Input::all())->save();
            //If its a new bank then add user.
            if (empty(Input::get('id'))) {
                $bankUser = new BankUser();
                $bankUser->bank_id = $bank->id;
                $bankUser->name = Input::get("name");
                $bankUser->email = Input::get("email");
                $pass = mt_rand(100000, 999999);
                $bankUser->password = Hash::make($pass);
                $bankUser->status = 1;
                $bankUser->save();
                //Add user role
                
                
                $baseurl = str_replace("\\", "/", base_path());
                $sub = "Login credentials for ";
                $mailcontent = "Your login Email ID - " . Input::get("email") . "\n";
                $mailcontent .= "Password- " . $pass . "\n";
                $mailcontent .= "Admin URL- " . $baseurl . "/bank/admin/" . "\n";
                Helper::withoutViewSendMail($bankUser->email, $sub, $mailcontent);
            }
            $data['id'] = $bank->id;
            return $data;
        }
    }

    public function saveUpdateDocuments() {
        //print_r(Input::all());
        $validation = new Bank();

        $rules = ['des.*' => 'required', 'docs.*' => 'required|mimes:png,gif,jpeg,txt,pdf,doc'];
        $validator = Validator::make(Input::all(), $rules);


        if ($validator->fails()) {
            return $validator->errors()->all();
        } else {
            foreach (Input::get('des') as $imgK => $imgV) {
                $saveCImh = Document::findOrNew(Input::get('id_doc')[$imgK]);
                $saveCImh->parent_id = Input::get('id');
                if (Input::get('is_doc')[$imgK] == 1) {
                    $file = Input::file('docs')[$imgK];
                    $destinationPath = public_path() . '/admin/uploads/bankDocuments/';
                    $fileName = "doc-" . $imgK . date("YmdHis") . "." . $file->getClientOriginalExtension();
                    $upload_success = $file->move($destinationPath, $fileName);
                    $saveCImh->filename = is_null($fileName) ? $saveCImh->filename : $fileName;
                } else {
                    //echo "llll";
                    $fileName = null;
                }
                $saveCImh->doc_type = 3;
                $saveCImh->des = Input::get('des')[$imgK];
                $saveCImh->save();
            }
            return redirect()->route('admin.banks.view');
        }
    }

    public function deleteDocument() {
        $id = Input::get('docId');
        $del = Document::find($id);
        $del->delete();
        echo "Successfully deleted";
    }

}
