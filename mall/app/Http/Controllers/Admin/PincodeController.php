<?php

namespace App\Http\Controllers\Admin;

use Input;
use App\Http\Controllers\Controller;
use App\Models\Pincode;
//use App\Models\City;
use DB;
use Session;
use App\Library\Helper;
use Redirect;
use Excel;
use App\Models\Courier;

class PincodeController extends Controller {

    public function index() {


        $pincodes = Pincode::orderBy("id");
        $delivary_status = Input::get("delivary_status") != null ? Input::get("delivary_status") : '';
        $cod_status = Input::get("cod_status") != null ? Input::get("cod_status") : '';
        if (!empty(Input::get("pincode"))) {
            $pincodes = $pincodes->where('pincode', Input::get("pincode"));
        }
        if (Input::get("delivary_status") != null) {
            $pincodes = $pincodes->where('delivary_status', Input::get("delivary_status"));
            // dd(Input::get("delivary_status"));
        }
        if (Input::get("cod_status") != null) {
            $pincodes = $pincodes->where('cod_status', Input::get("cod_status"));
        }

        if (empty(Input::get("dataSearch"))) {
            $pincodes = $pincodes->paginate(Config('constants.pageNo'));
            $pincodeCount = $pincodes->total();
        } else {
            $pincodes = $pincodes->get();
            $pincodeCount = $pincodes->count();
        }
        return view(Config('constants.pincodeView') . '.index', compact('pincodes', 'pincodeCount', 'delivary_status', 'cod_status'));
    }

    public function addEdit() {
        $pincodes = Pincode::find(Input::get('id'));
        //$cities = City::orderBy('city_name')->pluck('city_name', 'id');
      //  $service_provider = Courier::where('status', 1)->orderBy('name')->pluck('name', 'id')->prepend("Courier Service", "")->toArray();
        // dd($pincode);
        $action = route('admin.pincodes.save');
        $prefdataArr = [];
//        $prefdata = Courier::where('status', 1)->orderBy('name')->get();
//        foreach ($prefdata as $pref) {
//            $prefdataArr[$pref->id] = $pref->pref;
//        }


        return view(Config('constants.pincodeView') . '.addEdit', ['pincodes' => $pincodes, 'action' => $action]);
    }

    public function save() {
        $pincodes = Pincode::findOrNew(Input::get("id"));
        $pincodes->pincode = Input::get("pincode");

      //  $pincodes->service_provider = (Input::get("service_provider")) ? Input::get("service_provider") : 0;
        $pincodes->cod_status = (Input::get("cod_status")) ? Input::get("cod_status") : 0;
        $pincodes->pref = (Input::get("pref")) ? Input::get("pref") : 0;
        $pincodes->status = Input::get("status");
        if (empty(Input::get('id'))) {
            Session::flash("msg", "Pincode added successfully.");
            $data = ['status' => "1", "message" => "Pincode added successfully."];
        } else {
            $data = ['status' => "1", "message" => "Pincode updated successfully."];
            Session::flash("msg", "Pincode updated successfully.");
        }
        $pincodes->save();
        $viewname = '';
        return Helper::returnView($viewname, $data, $url = 'admin.pincodes.view');
    }

    public function delete() {
        $pincodes = Pincode::find(Input::get('id'));



        Session::flash("message", "Pincode deleted successfully.");
        $data = ['status' => "1", "message" => "Pincode Deleted successfully."];

        $pincodes->delete();
        $viewname = '';
        return Helper::returnView($viewname, $data, $url = 'admin.pincodes.view');
    }

    public function upload_pincodes() {

        // return View::make(Config::get('constants.pincodeView') . '.pincode_upload');
        return view(Config('constants.pincodeView') . '.pincode_upload');
    }

    public function upload_csv_pincode() {
        $codStatus = $this->getCodStatus;
        $viewname = '';
        $couriers = Courier::orderBy('created_at', 'DESC')->get(["id", "pref"]);
        //  dd($couriers);
        $peefIds = [];
        foreach ($couriers as $courier) {
            $peefIds[$courier->id] = $courier->pref;
        }

        $courier_service = $this->courierService;
        $getExtension = Input::file('pincode_csv')->getClientOriginalExtension();
        if ($getExtension != 'csv'):
            $data = ['status' => "0", "message" => "Not a valid file."];
            Session::flash("message", "Not a valid file.");
            return Helper::returnView($viewname, $data, $url = 'admin.pincodes.view');
        endif;
        Pincode::truncate();
        $getData = Excel::load($_FILES['pincode_csv']['tmp_name'])->get();
        
        
        foreach ($getData as $data){
            
            echo $data->pref."<br>";
            if (isset($data->pincode)){
                $prefID = ($data->service_provider != 0)?@$peefIds[$data->service_provider]:0;
                $pincode = new Pincode();
                $pincode->pincode = $data->pincode;
                if ($courier_service == 1 && $codStatus == 1) {
                    $pincode->service_provider = (int)$data->service_provider;
                    $pincode->pref = ($data->pref != null || $data->pref != 0 || $data->pref != "")? (int)$data->pref:(int)@$prefID;
                    $pincode->cod_status =($data->cod_status != null || $data->cod_status != 0 || $data->cod_status != "")? (int)$data->cod_status:0;
                } else if ($courier_service == 1 && $codStatus == 0) {
                   $pincode->service_provider = $data->service_provider;
                $pincode->pref =($data->pref != null || $data->pref != 0 || $data->pref != "")? (int)$data->pref:(int)@$prefID;
                } else if ($courier_service == 0 && $codStatus == 1) {
                      $pincode->cod_status = ($data->cod_status != null || $data->cod_status != 0 || $data->cod_status != "")? (int)$data->cod_status:0;
                } 
                $pincode->status = (int)$data->status;
                $pincode->save();
            }
        }
        
        
        $data = ['status' => "1", "message" => "Pincode uploaded successfully."];
        Session::flash("msg", "Pincode uploaded successfully.");
        return Helper::returnView($viewname, $data, $url = 'admin.pincodes.view');
        //    dd($getData);
    }

    public function samplePincodeDownload() {
        $courier_service = $this->courierService;
        $codStatus = $this->getCodStatus;

        $details = [];

        if ($courier_service == 1 && $codStatus == 1) {
            $arr = ['Pincode', 'Cod_status', 'Service_provider', 'pref', 'Status'];
            $pincodes = Pincode::get(['pincode', 'cod_status', 'service_provider', 'pref', 'status']);
        } else if ($courier_service == 1 && $codStatus == 0) {
            $arr = ['Pincode', 'Service_provider', 'pref', 'Status'];
            $pincodes = Pincode::get(['pincode', 'service_provider', 'pref', 'status']);
        } else if ($courier_service == 0 && $codStatus == 1) {
            $arr = ['Pincode', 'Cod_status', 'Status'];
            $pincodes = Pincode::get(['pincode', 'cod_status', 'status']);
        } else {
            $arr = ['Pincode', 'Status'];
            $pincodes = Pincode::get(['pincode', 'status']);
        }

//        if($courier_service==1){
//           $arr = ['Pincode', 'Cod_status', 'Service_provider','pref', 'Status'];
//        $pincodes = Pincode::get(['pincode', 'cod_status', 'service_provider','pref', 'status']);  
//        }else if($codStatus == 1){
//            $arr = ['Pincode', 'Cod_status',  'Status'];
//        $pincodes = Pincode::get(['pincode', 'cod_status',  'status']); 
//        }else{
//             $arr = ['Pincode',  'Status'];
//        $pincodes = Pincode::get(['pincode',  'status']);  
//        }
        //  dd($pincodes);
        $samplePincode = [];
        array_push($samplePincode, $arr);
        $arrP = [];
        $i = 0;
        foreach ($pincodes as $pincode) {
            if ($courier_service == 1) {
                $details = [
                    $pincode->pincode,
                    $pincode->cod_status,
                    $pincode->service_provider,
                    $pincode->pref,
                    $pincode->status
                ];
            } else {
                $details = [
                    $pincode->pincode,
                    $pincode->cod_status,
                    $pincode->status
                ];
            }

            if ($courier_service == 1 && $codStatus == 1) {
                $details = [
                    $pincode->pincode,
                    $pincode->cod_status,
                    $pincode->service_provider,
                    $pincode->pref,
                    $pincode->status
                ];
            } else if ($courier_service == 1 && $codStatus == 0) {


                $details = [
                    $pincode->pincode,
                    $pincode->service_provider,
                    $pincode->pref,
                    $pincode->status
                ];
            } else if ($courier_service == 0 && $codStatus == 1) {
                $details = [
                    $pincode->pincode,
                    $pincode->cod_status,
                    $pincode->status
                ];
            } else {
                $details = [
                    $pincode->pincode,
                    $pincode->status
                ];
            }



            array_push($samplePincode, $details);
        }

        return Helper::getCsv($samplePincode, 'pincodes.csv', ',');
    }

    public function upload_csv_pincode_old() {
        if (Input::hasFile('file')) {

            $file = Input::file('file');
            $name = time() . '-' . $file->getClientOriginalName();
            $path = public_path() . '/Admin/pincodes/';
            $file->move($path, $name);
            return $this->_import_csv($path, $name);
        } else {
            echo "Please select file";
        }
    }

    public function export_csv_pincode() {
        $pinCodes = Pincode::get();
        $samplePincodes = [];
        $details = ['pincodes', 'check_cod'];
        array_push($samplePincodes, $details);
        foreach ($pinCodes as $pin) {
            $details = [
                $pin->citynames,
                $pin->check_cod
            ];
            array_push($samplePincodes, $details);
        }
        return $this->convert_to_csv($samplePincodes, 'SamplePincodes.csv', ',');
    }

    public function convert_to_csv($input_array, $output_file_name, $delimiter) {
        /** open raw memory as file, no need for temp files */
        $temp_memory = fopen('php://memory', 'w');
        /** loop through array  */
        foreach ($input_array as $line) {
            /** default php csv handler * */
            fputcsv($temp_memory, $line, $delimiter);
        }
        /** rewrind the "file" with the csv lines * */
        fseek($temp_memory, 0);
        /** modify header to be downloadable csv file * */
        header('Content-Type: application/csv');
        header('Content-Disposition: attachement; filename="' . $output_file_name . '";');
        /** Send file to browser for download */
        fpassthru($temp_memory);
    }

    private function _import_csv($path, $filename) {

        $csv_file = $path . $filename;
        if (($handle = fopen($csv_file, "r")) !== FALSE) {
            DB::table('pincodes')->truncate();
            fgetcsv($handle);
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $num = count($data);
                for ($c = 0; $c < $num; $c++) {
                    $col[$c] = $data[$c];
                }
                $citynames = $col[0];
                $checkCod = $col[1];
                // $col2 = $col[1];
                DB::table('pincodes')->insert(
                        array('citypin' => $citynames, 'check_cod' => $checkCod)
                );
            }
            fclose($handle);
            Session::flash("msg", "Pincodes uploaded successfully");
            return Redirect::back();
        } else {
            Session::flash("message", "Pincodes uploaded successfully");
            return Redirect::back();
        }
        // echo "File data successfully imported to database!!";
    }

    public function codStatusChange() {
        $pincode = Pincode::find(Input::get("id"));
        if ($pincode->cod_status == 1) {
            $codStatus = 0;
            $pincode->cod_status = $codStatus;
            // Session::flash("message", "COD status disabled successfully.");
            $msg = "COD status disabled successfully.";
            $pincode->update();
            return redirect()->back()->with('message', $msg);
        } elseif ($pincode->cod_status == 0) {
            $codStatus = 1;
            $pincode->cod_status = $codStatus;
            $msg = "COD status enable successfully.";
            //  Session::flash("message", "COD status Enabled successfully.");
            $pincode->update();
            return redirect()->back()->with('msg', $msg);
        }
    }

    public function delivaryStatusChange() {
        $pincode = Pincode::find(Input::get("id"));
        if ($pincode->delivary_status == 1) {
            $delivaryStatus = 0;
            $pincode->delivary_status = $delivaryStatus;
            // Session::flash("message", "Delivary status disabled successfully.");
            $msg = "Delivary status disabled successfully.";
            $pincode->update();
            return redirect()->back()->with('message', $msg);
        } elseif ($pincode->delivary_status == 0) {
            $delivaryStatus = 1;
            $pincode->delivary_status = $delivaryStatus;
            $msg = "Delivary status enabled successfully.";
            //  Session::flash("message", "Delivary status Enabled successfully.");
            $pincode->update();
            return redirect()->back()->with('msg', $msg);
        }
    }

    public function changeStatus() {
        $pincode = Pincode::find(Input::get("id"));
        if ($pincode->status == 1) {
            $status = 0;
            $pincode->status = $status;
            // Session::flash("message", "Delivary status disabled successfully.");
            $msg = "Pincode disabled successfully.";
            $pincode->update();
            return redirect()->back()->with('message', $msg);
        } else if ($pincode->status == 0) {
            $status = 1;
            $pincode->status = $status;
            $msg = "Pincode enabled successfully.";
            //  Session::flash("message", "Delivary status Enabled successfully.");
            $pincode->update();
            return redirect()->back()->with('msg', $msg);
        }
    }

}
