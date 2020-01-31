<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Library\Helper;
use App\Models\GeneralSetting;
use App\Models\HasCashbackLoyalty;
use App\Models\Loyalty;
use App\Models\Order;
use App\Models\User;
use App\Models\PaymentHistory;
use Carbon\Carbon;
use Config;
use DB;
use Hash;
use Input;
use Session;

class CustomersController extends Controller
{

    public function index()
    {
        $user = User::find(Session::get('loggedinAdminId'));
        $search = !empty(Input::get("custSearch")) ? Input::get("custSearch") : '';
        $customers = User::with(["userCashback","orders"])->where('user_type', 2)->where('store_id', $user->store_id)->orderBy('id', 'desc');
        $search_fields = ['firstname', 'lastname', 'email', 'telephone'];
        if (!empty(Input::get('custSearch'))) {
            $customers = $customers->where(function ($query) use ($search_fields, $search) {
                foreach ($search_fields as $field) {
                    $query->orWhere($field, "like", "%$search%");
                }
            });
        }

        $loyalty = Input::get('loyalty');
        $date_created = Input::get('daterangepicker');
        $status = Input::get('status');

        if (isset($date_created) && $date_created !== '') {
            list($start_date, $end_date) = explode("-", $date_created);
            $start_date = Carbon::parse(str_replace("/", "-", $start_date))->format("Y-m-d");
            $end_date = Carbon::parse(str_replace("/", "-", $end_date))->format("Y-m-d");
            $customers->whereBetween('created_at', [$start_date, $end_date]);
        }
        if (isset($status) && $status !== '') {
            $customers->where('status', Input::get('status'));
        }
        if (isset($loyalty) && $loyalty !== '') {
            $customers->where('loyalty_group', Input::get('loyalty'));
        }
        if (!empty(Input::get('custSearch'))) {
            $customers = $customers->get();
            $customerCount = $customers->count();
        } else {
            $customers = $customers->paginate(Config('constants.paginateNo'));
            $customers->appends($_GET);
            $customerCount = $customers->total();
        }
        
        foreach ($customers as $key => $value) {
            $pay_amt = [];
            $user_orders = $value->orders;
            foreach ($user_orders as $key => $order) {
                $pay_amt[] = $order->pay_amt;
               
            }
            $value->total_order_amt=array_sum($pay_amt);
        }
        $loyalty = ['' => 'Select Loyalty Group'] + Loyalty::orderBy('group')->pluck('group', 'id')->toArray();
        $loyalty = array_map('strtolower', $loyalty);
        $setting = GeneralSetting::where('url_key', '=', 'loyalty')->first();
        $viewname = Config('constants.adminCustomersView') . '.index';
        $data = ['customers' => $customers, 'customerCount' => $customerCount, 'loyalty' => $loyalty, 'setting' => $setting];
        return Helper::returnView($viewname, $data);
    }

    public function add()
    {
        $user = new User();
        $action = "admin.customers.save";
        $loyalty = array();
        $getloyalty = Loyalty::orderBy('group')->get()->toArray();
        foreach ($getloyalty as $getloyaltyval) {
            $loyalty[$getloyaltyval['id']] = ucfirst(strtolower($getloyaltyval['group']));
        }
        $shippingAddress = [];
        $BillingAddress = [];
        $setting = GeneralSetting::where('url_key', '=', 'loyalty')->first();
        // return view(Config('constants.adminCustomersView') . '.addEdit', compact('user', 'action','loyalty'));
        $viewname = Config('constants.adminCustomersView') . '.addEdit';
        $data = ['user' => $user, 'action' => $action, 'loyalty' => $loyalty, 'setting' => $setting, 'shippingAddress' => $shippingAddress, 'BillingAddress' => $BillingAddress];
        return Helper::returnView($viewname, $data);
    }

    public function save()
    {
        $chk = User::with("userCashback")->where("email", "=", Input::get('email'))->where("telephone", "=", Input::get('telephone'))->where('user_type', 2)->first();
        if (empty($chk)) {
            if (Input::get('password')) {
                $password = Hash::make(Input::get('password'));
            } else {
                $password = Hash::make(mt_rand(100000, 999999));
            }
            $user = new User();
            $user->firstname = Input::get('firstname');
            $user->lastname = Input::get('lastname');
            $user->telephone = Input::get('telephone');
            $user->country_code = Input::get('country_code');
            $user->email = Input::get('email');
            $user->password = $password;
            $user->user_type = 2;
            $user->status = 1;
            $user->store_id = Session::get('store_id');
            $user->save();
            if (!empty(Input::get('cashback'))) {
                if ($user->userCashback) {
                    if (Input::get('cashback')) {
                        $user->userCashback->cashback = Input::get('cashback');
                    }

                    $user->userCashback->loyalty_group = Input::get('loyalty_group');
                    $user->userCashback->save();
                } else {
                    $usercashback = new HasCashbackLoyalty;
                    $usercashback->user_id = $user->id;
                    $usercashback->store_id = $this->jsonString['store_id'];
                    $usercashback->cashback = Input::get('cashback') ? Input::get('cashback') : 0;
                    $usercashback->loyalty_group = Input::get('loyalty_group');
                    $usercashback->save();
                }
            }
            //return redirect()->route('admin.customers.view');
            Session::flash("msg", "Customer added successfully. ");
            $viewname = Config('constants.adminCustomersView') . '.index';
            $data = ['status' => 'success', 'msg' => 'Customer added successfully.'];
            return Helper::returnView($viewname, $data, $url = 'admin.customers.view');
        } else {
            Session::flash("usenameError", "Username already exist");
            $viewname = Config('constants.adminCustomersView') . '.index';
            $data = ['status' => 'error', 'msg' => 'Username already exist'];
            return Helper::returnView($viewname, $data, $url = 'admin.customers.view');
        }
    }

    public function update()
    {
        $user = User::with("userCashback")->find(Input::get('id'));
        if (Input::get('password')) {
            $password = Hash::make(Input::get('password'));
        } else {
            $password = Hash::make(mt_rand(100000, 999999));
        }
        $user->firstname = Input::get('firstname');
        $user->lastname = Input::get('lastname');
        $user->telephone = Input::get('telephone');
        $user->country_code = Input::get('country_code');
        $user->email = Input::get('email');
        $user->password = $password;
        $user->user_type = 2;
        $user->status = 1;
        $user->store_id = Session::get('store_id');
        $user->update();
        if ($user->userCashback) {
            if (Input::get('loyalty_group') == $user->userCashback->loyalty_group) {
                //$user->loyalty_group = Input::get('loyalty_group');
            } else {
                $user->is_manually_updated = 1;
                $user->userCashback->loyalty_group = Input::get('loyalty_group');
                if (Input::get('cashback')) {
                    $user->userCashback->cashback = Input::get('cashback');
                }

                $user->userCashback->save();
            }
        } else {
            $usercashback = new HasCashbackLoyalty;
            $usercashback->user_id = $user->id;
            $usercashback->store_id = $this->jsonString['store_id'];
            $usercashback->cashback = Input::get('cashback') ? Input::get('cashback') : '0';
            $usercashback->loyalty_group = Input::get('loyalty_group');
            $usercashback->save();
        }

        Session::flash("updatesuccess", "Customer updated successfully.");
        $viewname = Config('constants.adminCustomersView') . '.index';
        $data = ['status' => 'success', 'msg' => 'Customer updated successfully.'];
        return Helper::returnView($viewname, $data, $url = 'admin.customers.view');
    }

    public function edit()
    {
        $user = User::with("userCashback")->find(Input::get('id'));
        //$loyalty = Loyalty::get();
        $loyalty = array();
        $getloyalty = Loyalty::get()->toArray();
        foreach ($getloyalty as $getloyaltyval) {
            $loyalty[$getloyaltyval['id']] = $getloyaltyval['group'];
        }
        $action = "admin.customers.update";
        $setting = GeneralSetting::where('url_key', '=', 'loyalty')->first();
        $shippingAddress = User::find(Input::get('id'))->addresses()->get();
        $BillingAddress = User::find(Input::get('id'))->billingaddresses()->get();
        // return view(Config('constants.adminCustomersView') . '.addEdit', compact('user', 'action','loyalty'));
        //dd($BillingAddress);
        $viewname = Config('constants.adminCustomersView') . '.addEdit';
        $data = ['user' => $user, 'action' => $action, 'loyalty' => $loyalty, 'setting' => $setting, 'shippingAddress' => $shippingAddress, 'BillingAddress' => $BillingAddress];
        return Helper::returnView($viewname, $data);
    }

    public function chkExistingUseremail()
    {
        $getname = Input::get('useremail');
        $chk = User::where("email", $getname)->first();
        if (!empty($chk)) {
            return $data = ['status' => 'success', 'msg' => 'Email id already exist'];
        } else {
            return $data = ['status' => 'fail', 'msg' => ''];
        }
    }

    public function delete()
    {
        $user = User::find(Input::get('id'));
        $getcount = Order::where("user_id", "=", Input::get('id'))->count();
        // dd($getcount);
        if ($getcount == 0) {
            $user->delete();
            Session::flash('message', 'Customer deleted successfully.');
            $data = ['status' => '1', "msg" => "Customer deleted successfully."];
        } else {
            Session::flash('message', 'Sorry, This customer is part of a order. Delete the order first.');
            $data = ['status' => '0', "msg" => "Sorry, This customer is the part of a order. Delete the order first."];
        }
        $url = 'admin.customers.view';
        $viewname = '';
        return Helper::returnView($viewname, $data, $url);
    }

    public function export()
    {
        $user = User::where('user_type', 2)->where('status', 1)->get();
        $user_data = [];
        array_push($user_data, ['First Name', 'Last Name', 'Mobile', 'Email', 'Created date']);
        foreach ($user as $u) {
            $details = [$u->firstname, $u->lastname, $u->telephone, $u->email, $u->created_at];
            array_push($user_data, $details);
        }
        return Helper::getCsv($user_data, 'customers.csv', ',');
    }

    public function changeStatus()
    {
        $id = Input::get("id");
        $viewname = '';
        $getstatus = User::find($id);
        if ($getstatus->status == 1) {
            $status = 0;
            $msg = "Customer disabled successfully.";
            $getstatus->status = $status;
            $getstatus->update();
            Session::flash("message", "Customer disabled successfully.");
            $data = ["status" => "0", "msg" => "Customer disabled successfully. "];
        } else if ($getstatus->status == 0) {
            $status = 1;
            $getstatus->status = $status;
            $getstatus->update();
            Session::flash("msg", "Customer enabled successfully.");
            $data = ["status" => "1", "msg" => "Customer enabled successfully."];
        }
        return Helper::returnView($viewname, $data, $url = 'admin.customers.view');
    }

    public function paymentHistory()
    {
        $userId = Input::get('user_id');
        $datefrom = Input::get('datefrom');
        $dateto = Input::get('dateto');
        
        $user = User::where('id', $userId)->first();


        if ($user && $user != null) {
            $totalPaid = DB::table('payment_history')
                ->leftjoin('orders', 'orders.id', 'payment_history.order_id')
                ->where('orders.user_id', $userId)
                ->where('orders.payment_method', 10)
                ->where('orders.store_id', Session::get('store_id'))
                ->select(DB::raw('SUM(payment_history.pay_amount) as total_paid'))
                ->first();
            $totalCreditAmount = DB::table('orders')
                ->where('orders.user_id', $userId)
                ->where('orders.payment_method', 10)
                ->where('orders.store_id', Session::get('store_id'))
                ->select(DB::raw('SUM(orders.pay_amt) as total_credit'))
                ->first();
            $payments = DB::table('payment_history')
                ->leftjoin('orders', 'orders.id', 'payment_history.order_id')
                ->where('orders.user_id', $userId)
                ->where('orders.payment_method', 10)
                ->where('orders.store_id', Session::get('store_id'));

            if (isset($datefrom) && $dateto !== '') {          
                $start_date = Carbon::parse(str_replace("/", "-", $datefrom))->format("Y-m-d");
                $end_date = Carbon::parse(str_replace("/", "-", $dateto))->format("Y-m-d");
                $payments = $payments->whereBetween('payment_history.created_at', [$start_date.' 00:00:01', $end_date.' 23:59:59']);
            }
            $payments = $payments->select('payment_history.*', 'orders.pay_amt', 'orders.amt_paid')
                    ->groupBy('payment_history.id')
                    ->paginate(Config('constants.paginateNo'));
            $viewname = Config('constants.adminCustomersView') . '.payment-history';
            $data = ['status' => 'success', 'userPayments' => $payments, 'totalPaid' => $totalPaid, 'totalCreditAmount' => $totalCreditAmount, 'user' => $user];
            return Helper::returnView($viewname, $data);
        } else {
            Session::flash("msg", "Invalid Customer!");
            $viewname = Config('constants.adminCustomersView') . '.index';
            $data = ['status' => 'success', 'msg' => 'Customer updated successfully.'];
            return Helper::returnView($viewname, $data, $url = 'admin.customers.view');
        }
    }

    public function exportPaymentHistory()
    {
        // dd(Input::all());
        $userId = Input::get('user_id');
        $payments = DB::table('payment_history')
            ->leftjoin('orders', 'orders.id', 'payment_history.order_id')
        // ->join('users', 'users.id', 'orders.user_id')
        // ->join('payment_method', 'payment_method.id', 'orders.payment_method')
            ->where('orders.user_id', $userId)
            ->where('orders.payment_method', 10)
            ->select('payment_history.*', 'orders.pay_amt', 'orders.amt_paid')
            ->get();
        $payment_data = [];
        array_push($payment_data, ['Date', 'Order Id', 'Payable Amount', 'Paid Amount']);
        foreach ($payments as $payment) {
            $details = [date('d-M-Y H:i:s', strtotime($payment->created_at)), $payment->order_id, $payment->pay_amt, $payment->pay_amount];
            array_push($payment_data, $details);
        }
        return Helper::getCsv($payment_data, 'customers-payments.csv', ',');
    }

    public function customerLedger(){
        $search = !empty(Input::get("custSearch")) ? Input::get("custSearch") : '';
        $search_fields = ['users.firstname', 'users.lastname', 'users.email', 'users.telephone'];

        $payments = DB::table('orders')
            ->leftjoin('payment_history', 'payment_history.order_id', 'orders.id')
            ->leftjoin('users', 'users.id', 'orders.user_id')
            ->whereIn('orders.payment_method', [1,10])
            ->where('orders.store_id', Session::get('store_id'));
        if (!empty(Input::get('custSearch'))) {
            $payments = $payments
                ->where(function ($query) use ($search_fields, $search) {
                    foreach ($search_fields as $field) {
                        $query->orWhere($field, "like", "%$search%");
                    }
                });
        }
        $payments = $payments->select('payment_history.*', 'orders.id as orderId', 'orders.pay_amt', 'orders.amt_paid', DB::raw('concat(users.firstname, " ",  users.lastname) as name'), 'users.email', 'users.telephone')
            //->groupBy('orders.id')
            ->orderBy('orders.created_at', 'ASC')
            ->paginate(Config('constants.paginateNo'));
        $totalPaid = DB::table('payment_history')
            ->leftjoin('orders', 'orders.id', 'payment_history.order_id')
            ->leftjoin('users', 'users.id', 'orders.user_id')
            ->where('orders.store_id', Session::get('store_id'))
            ->where('orders.payment_method', 10);
        if (!empty(Input::get('custSearch'))) {
            $totalPaid = $totalPaid
                ->where(function ($query) use ($search_fields, $search) {
                    foreach ($search_fields as $field) {
                        $query->orWhere($field, "like", "%$search%");
                    }
                });
        }
        $totalPaid = $totalPaid->select(DB::raw('SUM(payment_history.pay_amount) as total_paid'))
            ->first();
        $totalCreditAmount = DB::table('orders')
            ->where('orders.payment_method', 10)
            ->where('orders.store_id', Session::get('store_id'))
            ->leftjoin('users', 'users.id', 'orders.user_id');      
        if (!empty(Input::get('custSearch'))) {
            $totalCreditAmount = $totalCreditAmount
                ->where(function ($query) use ($search_fields, $search) {
                    foreach ($search_fields as $field) {
                        $query->orWhere($field, "like", "%$search%");
                    }
                });
        }
        $totalCreditAmount = $totalCreditAmount->select(DB::raw('SUM(orders.pay_amt) as total_credit'))
            ->first();
        $viewname = Config('constants.adminCustomersView') . '.ledger';
        $data = ['status' => 'success', 'userPayments' => $payments, 'totalPaid' => $totalPaid, 'totalCreditAmount' => $totalCreditAmount];
        // dd($data);
        return Helper::returnView($viewname, $data);
    }

}
