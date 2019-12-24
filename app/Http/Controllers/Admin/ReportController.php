<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Store;
use Illuminate\Support\Facades\Input;
use Hash;
use Validator;
use Session;

class ReportController extends Controller
{
    public function index() {
        $StoreOrders = Order::with('users')->get();
        $Stores = Store::get();
        $AllStores = ['' => 'Select Store'];
        foreach ($Stores as $store) {
            $AllStores[$store->id] = $store->store_name;
        }
        $store_ids = '';
        //dd($StoreOrders);
        return view(Config('constants.AdminPagesReports') . ".storeOrders", compact('StoreOrders','AllStores','store_ids'));
    }

    public function getOrdersByStore()
    {
    	$Stores = Store::get();
    	$search = Input::get('search');

        if (!empty($search)) {
            if (!empty(Input::get('store_id'))) {
                $StoreOrders = Order::where("store_id",Input::get('store_id'))->get();

            }
            if (!empty(Input::get('date_search'))) {

                $dateArr = explode(" - ", Input::get('date_search'));
                $fromdate = date("Y-m-d", strtotime($dateArr[0]));
                $todate = date("Y-m-d", strtotime($dateArr[1]));
                $StoreOrders = Order::where("created_at", ">=", "$fromdate")->where('created_at', "<", "$todate")->get();
                
            }
            if(!empty(Input::get('store_id')) && !empty(Input::get('date_search')))
            {
            	$StoreOrders = Order::where("created_at", ">=", "$fromdate")->where('created_at', "<", "$todate")->where('store_id',Input::get('store_id'))->get();
            }
        }
    	$AllStores = ['' => 'Select Store'];
        foreach ($Stores as $store) {
            $AllStores[$store->id] = $store->store_name;
        }
        $storeids = array();
        foreach ($StoreOrders as $key => $storeid) {
            $storeids[] = $storeid->store_id;
        }
        $store_ids = implode(',', $storeids);
    	return view(Config('constants.AdminPagesReports') . ".storeOrders", compact('StoreOrders','AllStores','store_ids'));
    }

    public function exportStoreOrders(){
    	$store_ids = explode(',', Input::get('store_ids'));
    	//dd($store_ids);
    	$StoreOrders = Order::whereIn('store_id',$store_ids)->with('users')->get();
    	
    	$data = [];
        $details = ['Order Id', 'Customer Name', 'Order Amount','COD Charges', 'Payable Amount','Order Date'];
        array_push($data, $details);
        $sr = 1;
        foreach ($StoreOrders as $orders) {
            $details = [
                $orders->id,
                $orders->first_name.' '.$orders->last_name,
                $orders->order_amt,
                $orders->cod_charges,
                $orders->pay_amt,
                date('d-M-Y',strtotime($orders->created_at)),
            ];
            $sr++;
            array_push($data, $details);
        }

        return $this->convert_to_csv($data, 'store-orders.csv', ',');
    }

    function convert_to_csv($input_array, $output_file_name, $delimiter) {
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
}
