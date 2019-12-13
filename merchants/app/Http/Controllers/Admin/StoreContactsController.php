<?php

namespace App\Http\Controllers\Admin;

use Route;
use Input;
use DB;
use Session;
use Cart;
use Hash;
use Mail;
use Config;
use Crypt;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\GeneralSetting;
use App\Models\HasCashbackLoyalty;
use App\Models\ContactStore;
use App\Models\ContactsGroup;
use App\Models\GroupHasContact;
use App\Library\Helper;
use Carbon\Carbon;
use Validator;

class StoreContactsController extends Controller {

    public function index() {
        $user = User::find(Session::get('loggedinAdminId'));
        $users = User::where(['user_type'=>2,'store_id'=>$user->store_id])->orderBy('id','desc')->get();
        $contacts = ContactStore::orderBy('id','desc');
        $contacts_group = ContactsGroup::orderBy('id','desc')->get();
        $search = !empty(Input::get("contSearch")) ? Input::get("contSearch") : '';
        $search_fields = ['name', 'email', 'mobileNo'];
        if (!empty(Input::get('contSearch'))) {
            $contacts = $contacts->where(function($query) use($search_fields, $search) {
                foreach ($search_fields as $field) {
                    $query->orWhere($field, "like", "%$search%");
                }
            });
        }

        $anniversaryDate = Input::get('anniversary');
        
        if (isset($anniversaryDate) && $anniversaryDate !== '') {
            list($start_date, $end_date) = explode("-", $anniversaryDate);
            $start_date = Carbon::parse(str_replace("/", "-", $start_date))->format("Y-m-d");
            $end_date = Carbon::parse(str_replace("/", "-", $end_date))->format("Y-m-d");
            $contacts->whereBetween('anniversary', [$start_date, $end_date]);
        }
        $birthDate = Input::get('dateofbirth');
        
        if (isset($birthDate) && $birthDate !== '') {
            list($start_date, $end_date) = explode("-", $birthDate);
            $start_date = Carbon::parse(str_replace("/", "-", $start_date))->format("Y-m-d");
            $end_date = Carbon::parse(str_replace("/", "-", $end_date))->format("Y-m-d");
            $contacts->whereBetween('birthDate', [$start_date, $end_date]);
        }

        if (!empty(Input::get('contSearch'))) {
            $storecontacts = $contacts->get();
            $contactsCount = $contacts->count();
        } else {
            $storecontacts = $contacts->paginate(Config('constants.paginateNo'));
            $storecontacts->appends($_GET);
            $contactsCount = $storecontacts->total();
        }
        
        $viewname = Config('constants.adminStoreContactView') . '.index';
        
        $data = ['storecontacts' => $storecontacts,'contacts_group'=>$contacts_group,'users'=>$users, 'contactsCount' => $contactsCount];
        return Helper::returnView($viewname, $data);
    }

    public function getContactGroups() {
        $term = Input::get('term');
      
        if (!empty($term)) {
            $result = ContactsGroup::where("group_name", "like", "%$term%")
                    ->get(['id', 'group_name']);
        }

        $data = [];
        foreach ($result as $k => $res) {
            $data[$k]['id'] = $res->id;
            $data[$k]['value'] = $res->group_name;
            
        }
        echo json_encode($data);
    }

    public function add() {
        $user = new ContactStore();
        $action = "admin.storecontacts.save";
        
        $viewname = Config('constants.adminStoreContactView') . '.addEdit';
        $data = ['user' => $user, 'action' => $action,'fieldData' => Input::all()];
        return Helper::returnView($viewname, $data);
    }

    public function save(Request $request) {
      
        $groupid = Input::get('group_id');
        if(empty($groupid))
        {
            //dd('ddf');
            $grp = new ContactsGroup();
            $grp->group_name = Input::get('group_name');
            $grp->save();
            $groupid = $grp->id;
        }
        
        $chk = ContactStore::where("email", "=", Input::get('email'))->where("mobileNo", "=", Input::get('mobileNo'))->first();
        if (empty($chk)) {
            $rules = [
                'name' => 'required',
                'email' => 'required|email|max:255|unique:store_contacts',
                'mobileNo' => 'required|digits:10|unique:store_contacts',
            ];

            $messages = array(
                'name.required' => 'This Name Field is required',
                'email.required' => 'This Email Field is required',
                'email.max' => 'This Email Field max limit is 255',
                'email.unique' => 'This Email All Ready Exist',
                'mobileNo.required' => 'This Mobile Number Field is required',
                'mobileNo.digits' => 'Mobile Number field is not more than 10 digits',
                'mobileNo.unique' => 'This Mobile Number All Ready Exist',
                
            );

            $validator = Validator::make($request->all(), $rules,$messages);
            if ($validator->fails()) {

                $errors = $validator->messages();
                return redirect()->to($this->getRedirectUrl())
                        ->withInput($request->input())
                        ->withErrors($errors, $this->errorBag());
            }else{
                $storeCont = new ContactStore();
                $storeCont->name = Input::get('name');
                $storeCont->email = Input::get('email');
                $storeCont->anniversary = Input::get('anniversary');
                $storeCont->birthDate = Input::get('birthDate');
                $storeCont->mobileNo = Input::get('mobileNo');
                $storeCont->contact_type = 1;
                $storeCont->save();
                
                $groupContacts = new GroupHasContact();
                $groupContacts->group_id = $groupid;
                $groupContacts->contact_id = $storeCont->id;
                $groupContacts->save();

                Session::flash("msg", "Store Contact added successfully. ");
                $viewname = Config('constants.adminStoreContactView') . '.index';
                $data = ['status' => 'success', 'msg' => 'Store Contact added successfully.'];

                return Helper::returnView($viewname, $data, $url = 'admin.storecontacts.view');
            }
        } else {
            Session::flash("usenameError", "Email already exist");
            $viewname = Config('constants.adminStoreContactView') . '.addEdit';
            $data = ['status' => 'error', 'msg' => 'Email already exist'];
            return Helper::returnView($viewname, $data, $url = 'admin.storecontacts.add');
        }
    }

    public function update() {
        $storeCont = ContactStore::find(Input::get('id'));
        $storeCont->name = Input::get('name');
        $storeCont->email = Input::get('email');
        $storeCont->anniversary = Input::get('anniversary');
        $storeCont->birthDate = Input::get('birthDate');
        $storeCont->mobileNo = Input::get('mobileNo');
        $storeCont->update();
        
        Session::flash("updatesuccess", "Store Contact updated successfully.");
        $viewname = Config('constants.adminStoreContactView') . '.index';
        $data = ['status' => 'success', 'msg' => 'Store Contact updated successfully.'];
        return Helper::returnView($viewname, $data, $url = 'admin.storecontacts.view');
    }

    public function edit() {
        $contacts = ContactStore::find(Input::get('id'));
        $action = "admin.storecontacts.update";
        $viewname = Config('constants.adminStoreContactView') . '.addEdit';
        $data = ['contacts' => $contacts, 'action' => $action];
        return Helper::returnView($viewname, $data);
    }

    public function export() {
        $user = User::where('user_type', 2)->where('status', 1)->get();
        $user_data = [];
        array_push($user_data, ['First Name', 'Last Name', 'Mobile', 'Email', 'Created date']);
        foreach ($user as $u) {
            $details = [$u->firstname, $u->lastname, $u->telephone, $u->email, $u->created_at];
            array_push($user_data, $details);
        }
        return Helper::getCsv($user_data, 'customers.csv', ',');
    }

    public function exportsamplecsv() {
        
        $user_data = [];
        array_push($user_data, ['Name', 'Email', 'Mobile No', 'Anniversary Date', 'Date of Birth']);
        $details = ['Stefen','stefen@gmail.com','9878765678','12/03/2000','30/04/1986'];
        array_push($user_data, $details);
        return Helper::getCsv($user_data, 'contactformat.csv', ',');
    }

    public function import(Request $request) {
        $success = $this->uploadContact($request);
        if($success)
            return redirect()->back()->with('success',$success);
        else
            return redirect()->back();
    }

    public function uploadContact(Request $request){
        $file      = $request->contact_file;
        $allowed   = array('text/plain', 'application/csv', 'application/vnd.ms-excel');
        $rules     = array('contact_file' => 'required');
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        } else {
            $mime = $file->getMimeType();
            if (in_array($mime, $allowed)) {
                $filePath      = $file->getPathName();
                $fileName      = $file->getClientOriginalName();
                $data          = $this->importCsv($filePath);
                return 1;
            } else {
                return redirect()->back()
                    ->withErrors("Invalid File!")
                    ->withInput();
            }
        }
    }

    public function importCsv($path)
    {
        $csv_file            = $path;
        $insertedRecords     = 0;
        $invalidRecordsArray = array();
        $displayRecords      = 0;
        $mail_array          = array();
        
        if (($handle = fopen($csv_file, "r")) !== false) {
            fgetcsv($handle);
            $totalRecords = 0;
            $fp           = file($csv_file);
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {

                $num = count($data);
                for ($c = 0; $c < $num; $c++) {
                    $col[$c] = $data[$c];
                }
                
                $name = $col[0];
                $email   = $col[1];
                $mobileNo =  $col[2];
                $anniversary =  $col[3];
                $dateofbirth =  $col[4];
                $col[0] = $name;
                $col[1] = $email;
                $col[2] = $mobileNo;
                $col[3] = $anniversary;
                $col[4] = $dateofbirth;
                
                $invalidRecords = $this->checkValidRecord($col);
                if ($invalidRecords['error'] == 'error') {
                    array_push($invalidRecordsArray, $invalidRecords['msg'][0]);
                }

                $totalRecords++;
            }

            
            $displayRecords = count($fp) - 1 - count($invalidRecordsArray);

            $this->downloadInvalidRecords($invalidRecordsArray);

            fclose($handle);
            if ($displayRecords == 0) {
                $message = "Store Contact ".$displayRecords." Records inserted, ".count($invalidRecordsArray)." Records are Invalid.";
            } else {
                $message = "Store Contact ".$displayRecords." Records inserted, ".count($invalidRecordsArray)." Records are Invalid.";
            }
            Session::flash("uplaodMessage", $message);
        } else {
            echo "Error being upload file";
        }
    }

    public function email_validation($str) { 
        return (!preg_match( 
                "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$^", $str)) 
                ? FALSE : TRUE; 
    }

    public function checkValidRecord($col)
    {
        $errorString    = "";
        $invalidRecords = array();
        $mail_array     = array();
        $anversaryDate    = $col[3];
        $dobDate   = $col[4];
        
        if ($col[0] == '') {
            array_push($invalidRecords, $col);
            $errorString .= "Name is Required";
        }

        if ($col[1] == '') {
            array_push($invalidRecords, $col);
            $errorString .= "Email is Required";
        } else {
            if($this->email_validation($col[1]) == false){
                $errorString .= "Invalid email address.";
            }
        }
        
        if ($col[1] != '') {
            $emailData = ContactStore::where('email', $col[1])->first();
            if (!empty($emailData) || $emailData != null) {
                array_push($invalidRecords, $col);
                $errorString .= "Duplicate Email";
            }
        }

        if ($col[2] == '') {
            array_push($invalidRecords, $col);
            $errorString .= "Mobile Number is Required";
        }
            
        if ($col[3] != '') {
            if (preg_match("/^(\d{2})\/(\d{2})\/(\d{4})$/", $anversaryDate)) {
                $matches = explode('/', $anversaryDate);
                if (!checkdate($matches[1], $matches[0], $matches[2])) {
                    // check if date, month and year is vaild or not
                    array_push($invalidRecords, $col);
                    $errorString .= "Invalid Anniversary Date Format, ";
                }
            } 
        }

        if ($col[4] != '') {
            if (preg_match("/^(\d{2})\/(\d{2})\/(\d{4})$/", $dobDate)) {
                $matches = explode('/', $dobDate);
                if (!checkdate($matches[1], $matches[0], $matches[2])) {
                    // check if date, month and year is vaild or not
                    array_push($invalidRecords, $col);
                    $errorString .= "Invalid Birth Date Format, ";
                }
            }
        }
        
        if (count($invalidRecords) == 0) {

            $result = $this->saveContactUpload($col);
            if ($result == 0) {
                array_push($invalidRecords, $col);
                $invalidRecords[0][5] = 'Error';
                $jsonArray['error']   = 'error';
                $jsonArray['msg']     = $invalidRecords;
                return $jsonArray;
            } else {
                $jsonArray['error'] = 'success';
                $jsonArray['msg']   = $result;
                return $jsonArray;

            }

        } else {

            $invalidRecords[0][5] = rtrim($errorString, ', ');
            $jsonArray['error']   = 'error';
            $jsonArray['msg']     = $invalidRecords;

            return $jsonArray;
        }
    }

    public function saveContactUpload($data)
    {
        $storeData      = ContactStore::where('email', $data[1])->first();
        DB::beginTransaction();
        try {
            if(empty($storeData)) {
                $cont              = new ContactStore();
                $cont->name        = $data[0];
                $cont->email       = $data[1];
                $cont->mobileNo    = $data[2];
                $cont->anniversary = Carbon::createFromFormat('d/m/Y',$data[3]);
                $cont->birthDate   = Carbon::createFromFormat('d/m/Y',$data[4]);
                $cont->contact_type = 1;
                $cont->save();
            } 

            DB::commit();
            return 1;
        } catch (\Exception $e) {
            DB::rollback();
            $jsonArray['error'] = 'error';
            $jsonArray['msg']   = $e;
            return $e;
        }
        
        return 0;

    }

    public function downloadInvalidRecords($dataArray)
    {
 
        if (!empty($dataArray)) {
            $root = $_SERVER['DOCUMENT_ROOT'].'/uploads/invalid_contacts';
            $file     = '/InvalidRecordsReport_' . time() . '.csv';
            $filename = $root . $file;
            //dd($root);
            if(chmod($root, 0777)){
                chmod($root, 0777);
            }
            $handle   = fopen($filename, 'w+');
            $data     = array();
            
            fputcsv($handle, array('Name *', 'Email *','Mobile No*',
             'Anniversary Date (dd/mm/yyyy) ', 'Birth Date(dd/mm/yyyy) *', 'Error Type'));
            foreach ($dataArray as $row) {
                    fputcsv($handle, array($row['0'], $row['1'], $row['2'], $row['3'], $row['4'], $row['5']));
                }

            fclose($handle);
            header('Content-Type: application/csv');
            header('Content-Disposition: attachment; filename=InvalidPiRecord_' . time() . '.csv');
            header('Pragma: no-cache');
            readfile($filename);
            Session::flash("filename", $file);
        }
    }


}
