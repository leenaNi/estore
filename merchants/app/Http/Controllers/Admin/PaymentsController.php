<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Library\Helper;
use App\Models\Order;
use App\Models\User;
use App\Models\PaymentHistory;
use DB;
use Input;
use Session;

class PaymentsController extends Controller
{

    public function index()
    {
        $search = !empty(Input::get("custSearch")) ? Input::get("custSearch") : '';
        $search_fields = ['users.firstname', 'users.lastname', 'users.email', 'users.telephone'];

        $payments = DB::table('payment_history')
            ->leftjoin('orders', 'orders.id', 'payment_history.order_id')
            ->leftjoin('users', 'users.id', 'orders.user_id')
            ->where('orders.payment_method', 10)
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
            ->groupBy('orders.id')
            ->orderBy('orders.created_at', 'DESC')
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
        $viewname = Config('constants.adminPaymentsView') . '.index';
        $data = ['status' => 'success', 'userPayments' => $payments, 'totalPaid' => $totalPaid, 'totalCreditAmount' => $totalCreditAmount];
        // dd($data);
        return Helper::returnView($viewname, $data);

    }

    public function addNewSettlement()
    {
        if (!empty(Input::get('custSearch'))) {
            $search = !empty(Input::get("custSearch")) ? Input::get("custSearch") : '';
            $search_fields = ['users.firstname', 'users.lastname', 'users.email', 'users.telephone'];
            $payments = DB::table('payment_history')
                ->leftjoin('orders', 'orders.id', 'payment_history.order_id')
                ->leftjoin('users', 'users.id', 'orders.user_id')
                ->where('orders.payment_method', 10)
                ->where('orders.store_id', Session::get('store_id'));
            if (!empty(Input::get('custSearch'))) {
                $payments = $payments
                    ->where(function ($query) use ($search_fields, $search) {
                        foreach ($search_fields as $field) {
                            $query->orWhere($field, "like", "%$search%");
                        }
                    });
            }
            $payments = $payments->select('payment_history.*', 'orders.pay_amt', 'orders.amt_paid', DB::raw('concat(users.firstname, " ",  users.lastname) as name'), 'users.email', 'users.telephone')
                ->groupBy('orders.id')
                ->orderBy('orders.created_at', 'DESC')
                ->paginate(Config('constants.paginateNo'));
            $totalPaid = DB::table('payment_history')
                ->leftjoin('orders', 'orders.id', 'payment_history.order_id')
                ->where('orders.store_id', Session::get('store_id'))
                ->where('orders.payment_method', 10);
            if (!empty(Input::get('custSearch'))) {
                $totalPaid = $totalPaid
                    ->leftjoin('users', 'users.id', 'orders.user_id')
                    ->where(function ($query) use ($search_fields, $search) {
                        foreach ($search_fields as $field) {
                            $query->orWhere($field, "like", "%$search%");
                        }
                    });
            }
            $totalPaid = $totalPaid->select(DB::raw('SUM(payment_history.pay_amount) as total_paid'))
                ->groupBy('orders.id')
                ->first();
            $totalCreditAmount = DB::table('orders')
                ->where('orders.payment_method', 10)
                ->where('orders.store_id', Session::get('store_id'));
            if (!empty(Input::get('custSearch'))) {
                $totalCreditAmount = $totalCreditAmount
                    ->leftjoin('users', 'users.id', 'orders.user_id')
                    ->where(function ($query) use ($search_fields, $search) {
                        foreach ($search_fields as $field) {
                            $query->orWhere($field, "like", "%$search%");
                        }
                    });
            }
            $totalCreditAmount = $totalCreditAmount->select(DB::raw('SUM(orders.pay_amt) as total_credit'))
                ->groupBy('orders.id')
                ->first();
        } else {
            $payments = [];
            $totalPaid = [];
            $totalCreditAmount = [];
        }
        $viewname = Config('constants.adminPaymentsView') . '.add-new-settlement';
        $data = ['status' => 'success', 'userPayments' => $payments, 'totalPaid' => $totalPaid, 'totalCreditAmount' => $totalCreditAmount];
        return Helper::returnView($viewname, $data);
    }

    public function settlePayments()
    {
        // dd(Input::all());
        $payAmt = Input::get('pay_amt');
        $orderIds = Input::get('order_id');
        $incorrectIds = $correctIds = [];
        foreach($orderIds as $orderKey => $order) {
            $orderS = Order::where('id', $order)->first();
            $paymentAmt = $payAmt[$orderKey];
            if ($orderS && $orderS != null && $paymentAmt != '') {
                // print_r($paymentAmt);
                // USER LEVEL CREDIT UPDATE
                $userinfo = User::where('id', $orderS->user_id)->first();
                $userinfo->credit_amt = $userinfo->credit_amt - $paymentAmt;
                $userinfo->update();
                //UPDATE ORDER paid amt
                $orderS->amt_paid = $orderS->amt_paid + $paymentAmt;
                $orderS->save();
                if ($orderS->amt_paid == $orderS->pay_amt) {
                    $orderS->payment_status = 4;
                    $orderS->update();
                }
                $paymentHistory = PaymentHistory::create();
                $paymentHistory->order_id = $orderS->id;
                $paymentHistory->pay_amount = $paymentAmt;
                $paymentHistory->added_by = Session::get('loggedinAdminId');
                $paymentHistory->save();
                array_push($correctIds, $order);
            } else {
                array_push($incorrectIds, $order);
            }
        }
            Session::flash("msg", "Updated Successfully!");
            $data = ['updatedIds' => $correctIds, 'notUpdatedIds' => $incorrectIds];
            return redirect()->back()->with($data);
    }

    public function export()
    {
        $payments = DB::table('payment_history')
            ->leftjoin('orders', 'orders.id', 'payment_history.order_id')
            ->where('orders.payment_method', 10)
            ->where('orders.store_id', Session::get('store_id'))
            ->select('payment_history.*', 'orders.pay_amt', 'orders.amt_paid', DB::raw('concat(users.firstname, " ",  users.lastname) as name'), 'users.email', 'users.telephone')
            ->groupBy('orders.id')
            ->get();
        $payment_data = [];
        array_push($payment_data, ['Name', 'Email', 'contact', 'Date', 'Order Id', 'Payable Amount', 'Paid Amount']);
        foreach ($payments as $payment) {
            $details = [$payment->name, $payment->email, $payment->telephone, date('d-M-Y H:i:s', strtotime($payment->created_at)), $payment->order_id, $payment->pay_amt, $payment->pay_amount];
            array_push($payment_data, $details);
        }
        return Helper::getCsv($payment_data, 'payments.csv', ',');
    }
}
