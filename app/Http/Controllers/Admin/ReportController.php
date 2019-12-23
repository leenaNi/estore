<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Input;
use Hash;
use Validator;
use Session;

class ReportController extends Controller
{
    public function index() {
        $StoreOrders = Order::get();
        

        //$action = route('admin.settings.update');
        return view(Config('constants.AdminPagesReports') . ".storeOrders", compact('StoreOrders'));
    }
}
