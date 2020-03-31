<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Table;
use App\Models\Kot;
use App\Models\Order;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\OrderType;
use App\Models\Country;
use App\Models\Product;
use App\Models\Zone;
use App\Models\User;
use App\Models\HasProducts;
use App\Models\AdditionalCharge;
use App\Models\Address;
use App\Models\Loyalty;
use App\Models\Contact;
use Input;
use App\Library\Helper;
use Session;
use DB;
use Form;
use Cart;
use Carbon;

class TableController extends Controller {

    public function index() {
        $tables = Table::whereIn('status', [0, 1])->orderBy("id", "asc");

        if (!empty(Input::get("table"))) {
            $tables = $tables->where("table_label", "like", "%" . Input::get("table") . "%")->get();
            $tablesCount = $tables->count();
        } else {
            $tables = $tables->paginate(Config('constants.paginateNo'));
            $tablesCount = $tables->total();
        }
        return view(Config('constants.adminTableView') . '.index', compact('tables', 'tablesCount'));
    }

    public function addEdit() {
        $table = Table::find(Input::get("id"));
        $action = route('admin.tables.save');
        return view(Config('constants.adminTableView') . '.addEdit', compact('table', 'action'));
    }

    public function save() {
        $table = Table::findOrNew(Input::get("id"));
        $table->table_no = Input::get("table_no");
        $table->chairs = Input::get("chairs");
        $table->table_label = Input::get("table_label");
        $table->table_type = Input::get("table_type");
        $table->ostatus = 1;//occupancy status 1 means green color 
        $table->store_id = Session::get("store_id");

        $table->status = Input::get("status");
        if (empty(Input::get('id'))) {
            Session::flash("msg", "Table added successfully.");
            $data = ['status' => "1", "message" => "Table added successfully."];
        } else {
            $data = ['status' => "1", "message" => "Table updated successfully."];
            Session::flash("msg", "Table updated successfully.");
        }
        $viewname = '';
        $table->save();
        return Helper::returnView($viewname, $data, $url = 'admin.tables.view');
    }

    public function changeStatus() {
        $table = Table::find(Input::get("id"));
        if ($table->status == 1) {
            $status = 0;
            $table->status = $status;
            Session::flash("message", 'Table disabled successfully.');
            $table->save();
        } else if ($table->status == 0) {
            $status = 1;
            $table->status = $status;
            Session::flash("msg", 'Table enable successfully.');
            $table->save();
        }
        $viewname = '';
        $data = '';
        return Helper::returnView($viewname, $data, $url = 'admin.tables.view');
    }

    public function delete() {
        $table = Table::find(Input::get("id"));
        $table->delete();
        Session::flash("message", "Table deleted successfully.");
        $data = ['status' => "1", "message" => "Table deleted successfully."];
        $viewname = '';

        return Helper::returnView($viewname, $data, $url = 'admin.tables.view');
    }

    public function layout() {
        $tables = Table::all();
        return view(Config('constants.adminTableView') . '.layout', compact('tables'));
    }

    public function layoutsave() 
    {
        $inputs = Input::all();
        //For rotate
        $getHdnRotateArry = array();
        $getHdnRotateArry = $inputs['hdn_layout_rotate_array'][0];
        $flagVal = 0;
        if(!empty($getHdnRotateArry))
        {
            $getHdnRotateArry = json_decode($getHdnRotateArry);
            for($i=0;$i<count($getHdnRotateArry);$i++)
            {
                $restaurantTableId = $getHdnRotateArry[$i]->id;
                $restaurantTableAngle = $getHdnRotateArry[$i]->angle;
                //update query
                $table = Table::findOrNew($restaurantTableId);
                $table->angle = $restaurantTableAngle;
                $table->save();
            }
            $flagVal = 1;
        }
        
        //For Draggable
        $getHdnDraggableArry = array();
        $getHdnDraggableArry = $inputs['hdn_layout_draggable_array'][0];
        if(!empty($getHdnDraggableArry))
        {
            $getHdnDraggableArry = json_decode($getHdnDraggableArry);
            for($i=0;$i<count($getHdnDraggableArry);$i++)
            {
                $restaurantTableId = $getHdnDraggableArry[$i]->id;
                $restaurantTableDraggable = $getHdnDraggableArry[$i]->draggable;
                //update query
                $table = Table::findOrNew($restaurantTableId);
                $table->position = $restaurantTableDraggable;
                $table->save();

            }
            $flagVal = 1;
        }

        //For Resizable
        $getHdnResizableArry = array();
        $getHdnResizableArry = $inputs['hdn_layout_resizable_array'][0];
        if(!empty($getHdnResizableArry))
        {
            $getHdnResizableArry = json_decode($getHdnResizableArry);
            for($i=0;$i<count($getHdnResizableArry);$i++)
            {
                $restaurantTableId = $getHdnResizableArry[$i]->id;
                $restaurantTableDraggable = $getHdnResizableArry[$i]->resizable;
                //update query
                $table = Table::findOrNew($restaurantTableId);
                $table->size = $restaurantTableDraggable;
                $table->save();

            }
            $flagVal = 1;
        }
        
        
        if($flagVal == 1)
        {
            $data = ['status' => "1", "message" => "Table updated successfully."];
            Session::flash("msg", "Table Layout updated successfully.");
        }
        
        $viewname = '';
        //return Helper::returnView($viewname, $data, $url = 'admin.tables.view');   
        return Helper::returnView($viewname, $data, $url = 'admin.restaurantlayout.view');   
    }    

    public function orderview() {
        //$tables = Table::with('tablestatus')->get();
        $tables = Table::all();
        $otypes = OrderType::where('id', "!=", 1)->get();
        $otherorders = Order::whereNotIn("otype", [1, 0])->orderBy("created_at", "desc")->paginate(100);
        $allorders = Order::where("otype", "!=", 0)->orderBy("created_at", "desc")->paginate(100);


        return view(Config('constants.adminTableView') . '.orderview', compact('tables', 'otypes', 'otherorders', 'allorders'));
    }

    public function ordersave() {
        $order = new Order;
        $order->otype = Input::get('ordertype');
        $order->save();

        return redirect()->route('admin.order.additems', ['id' => $order->id]);
    }

    public function additems($id) {
        $this->removeAllDiscountSession();
        $data['order'] = Order::find($id);
        $data['order']->kots = $data['order']->kots;
        $data['order']->type = $data['order']->type;
        $data['categories'] = Category::where("status", 1)->with(['products' => function($q) {
                        $q->where("status", 1)->where("prod_type", 1);
                    }, 'categoryName'])->get();
        $data['tables'] = Table::where("status", 1)
                ->select(DB::raw("CONCAT(table_no,' - ',table_label) AS table_name"), 'id')
                ->pluck("table_name", 'id');

        $ordcountries = Country::where("status", 1)->pluck("name", "id")->prepend("Country", "");
        $ordstates = Zone::where("status", 1)->pluck("name", "id")->prepend("State", "");
        $data['ordcountries'] = $ordcountries;
        $data['ordstates'] = $ordstates;

        $data['coupon'] = Coupon::where("status", 1)->where("start_date", "<=", Carbon\Carbon::now())->where("end_date", ">", Carbon\Carbon::now())->pluck("coupon_name", "coupon_code")->prepend("Apply Coupon", "");

        return Helper::returnView(Config('constants.adminTableView') . '.addItems', $data);
    }

    public function viewitems($id) {
        
        $data['order'] = Order::find($id);
        $data['order']->kots = $data['order']->kots;
        $data['order']->type = $data['order']->type;
        $data['categories'] = Category::where("status", 1)->with(['products' => function($q) {
                        $q->where("status", 1)->where("prod_type", 1);
                    }, 'categoryName'])->get();
        $data['tables'] = Table::where("status", 1)
                ->select(DB::raw("CONCAT(table_no,' - ',table_label) AS table_name"), 'id')
                ->pluck("table_name", 'id');

        $ordcountries = Country::where("status", 1)->pluck("name", "id")->prepend("Country", "");
        $ordstates = Zone::where("status", 1)->pluck("name", "id")->prepend("State", "");
        $data['ordcountries'] = $ordcountries;
        $data['ordstates'] = $ordstates;

        $data['coupon'] = Coupon::where("status", 1)->where("start_date", "<=", Carbon\Carbon::now())->where("end_date", ">", Carbon\Carbon::now())->pluck("coupon_name", "coupon_code")->prepend("Apply Coupon", "");

        return Helper::returnView(Config('constants.adminTableView') . '.viewItems', $data);
    }


    public function saveItems() {
        $kot = new Kot();
        $kot->order_id = Input::get('order_id');
        $kot->save();
        foreach (Input::get('orderdata') as $ordk => $ordv) {
            $saveHasprd = new HasProducts();
            $saveHasprd->kot = $kot->id;
            $saveHasprd->prod_id = $ordk;
            $saveHasprd->order_id = Input::get('order_id');
            $saveHasprd->qty = $ordv['qty'];
            $saveHasprd->price = $ordv['price'];
            $saveHasprd->remark = $ordv['remark'];
            $saveHasprd->save();
        }

        return $kot;
//        return redirect()->route('admin.tableorder.view')->with('message', 'Order placed successfully.');
    }

    public function transferKot() {       
        $getHiddenEditOrderId = Input::get('hdn_order_id');
        $getHiddenSingleTableId = Input::get('hdn_single_table_id');
        $getHiddenJoinTableId = Input::get('hdn_join_table_id');
        
        if (Table::find(Input::get('table_id'))->ostatus == 1) {
           
            //$order = new Order;
            $order = Order::find($getHiddenEditOrderId);
            $order->otype = 1;
            $order->table_id = Input::get('table_id');
            $order->update();
            //$order->save();
            
            //update ostatus 2 to 1 for old table id
            if($getHiddenSingleTableId != '' || $getHiddenSingleTableId > 0)
            {
                $savetable = Table::find($getHiddenSingleTableId);
                $savetable->ostatus = 1;
                $savetable->update();
            }
            else
            {
                $joinTableIdArry = json_decode($getHiddenJoinTableId);
                $tableIdArry = [];
                foreach($joinTableIdArry as $getTableId)
                {
                    $savetable = Table::find($getTableId);
                    $savetable->ostatus = 1;
                    $savetable->update();
                }//foreach ends here
            }
            

            //update ostatus 1 to 2 for new tranfer kot table id
            $savetable = Table::find(Input::get('table_id'));
            $savetable->ostatus = 2;
            $savetable->update();
        } else {
            $order = Order::where("order_status", 1)->where("table_id", Input::get("table_id"))->orderBy("created_at", "desc")->first();
        }

        //if (count($order) > 0) {
        if (!empty($order)) {
          
            $kot = Kot::find(Input::get('kot_id'));
            $kot->order_id = $order->id;
            $kot->update();
            foreach ($kot->products()->get() as $hsprd) {
                $hsprdUpdate = HasProducts::find($hsprd->id);
                $hsprdUpdate->order_id = $order->id;
                $hsprdUpdate->update();
            }
        }

        return redirect()->route('admin.order.additems', ['id' => $order->id]);
    }

    public function addNewOrder() {
        $getStoreId = SESSION::get('store_id');
        $orderStatusResult = DB::table('order_status')
            ->where('store_id', $getStoreId)
            ->where('is_default', 1)
            ->get();
        $orderStatusId = 0;
        foreach($orderStatusResult as $getOrderStatatusData)
        {
            //Get Processin id
            $orderStatusId = $getOrderStatatusData->id;
            $orderStatus = $getOrderStatatusData->order_status;
        }
            
        $order = new Order;
        $order->otype = 1;
        $order->table_id = Input::get('tableid');
        $order->order_status = $orderStatusId;
        $order->save();
        $savetable = Table::find(Input::get('tableid'));
        $savetable->ostatus = 2;
        $savetable->update();

        $data = ['status' => 1, 'order' => $order, 'redirectUrl' => route('admin.order.additems', ['id' => $order->id])];
        return $data;
    }

    public function getJoinTableCheckbox() {
        $tables = Table::where("status", 1)->where("ostatus", 1)->where("id", "!=", Input::get('tableid'))
                ->select(DB::raw("CONCAT(table_no,' - ',table_label) AS table_name"), 'id')
                ->get("table_name", 'id');
        $html = "";
        foreach ($tables as $tbl) {

            $html .="<input type='checkbox' name='join_tableChk[]'  value='" . $tbl->id . "'>" . $tbl->table_name . "<br>";
        }
        return $html;
    }

    public function saveJoinTableOrder() {

        $order = new Order;
        $order->otype = 1;
        $order->table_id = Input::get('tableid');
        $order->join_tables = json_encode(Input::get('selTables'));
        $order->save();


        DB::table('restaurant_tables')->whereIn("id", Input::get('selTables'))->update(["ostatus" => 2]);
        $data = ['status' => 1, 'order' => $order, 'redirectUrl' => route('admin.order.additems', ['id' => $order->id])];
        return $data;
    }

    public function getOrderKotProds() {
        Cart::instance("shopping")->destroy();
        $order = Order::find(Input::get('orderid'));
        $kotprods = "";
        $totalOrderAmount = 0;
        foreach ($order->kots as $kot) {
            $kotprods .= '<tr class="green" data-otype="' . $order->otype . '">';
            $kotprods .= '<td colspan="6"><b>KOT #' . $kot->id . '</b>';

            if ($order->otype == 1)
            {
                if($order->cart == '')
                    $kotprods .= '<span class="pull-right transferKOT" data-kotid="' . $kot->id . '" style="cursor:pointer;">Transfer KOT</span>';
            }
                

            $kotprods .='</td>';
            $kotprods .='</tr>';
            
            foreach ($kot->products as $prd) {
                $totalOrderAmount += ($prd->price * $prd->qty);
                $kotprods .='<tr>';
                $kotprods .='<td>' . $prd->product->product . '</td>';
                $kotprods .='<td>' . $prd->product_details . '</td>';
                $kotprods .='<td>' . $prd->qty . '</td>';
                $kotprods .='<td>' . number_format($prd->price, 2) . '</td>';
                $kotprods .='<td>' . number_format(($prd->price * $prd->qty), 2) . '</td>';
                if($order->cart == '')
                {
                    $kotprods .='<td><i data-hasprdid="' . $prd->id . '" class="fa fa-trash fa-fw deleteExistingItem" style="color:red;cursor:pointer;"></i></td>';
                }
                
                $kotprods .='</tr>';

            }

            if (!empty($kot->products)) {
                foreach ($kot->products as $prd) {
                    $getProd = Product::find($prd->prod_id);
//                    dd($getProd->prod_type);
                    $addCart = app('App\Http\Controllers\Frontend\CartController')->addCartData($getProd->prod_type, $getProd->id, $prd->sub_prod_id, $prd->qty);
                }
            }

        }
        $kotprods .='<tr class="green"><td colspan="6"><b>New KOT #</b></td></tr>';
        $kotprods .='<input type="hidden" id="final_total_amount" value="'.$totalOrderAmount.'">';

        return $kotprods;
    }

    public function getCartAmt() {
        // Cart::instance("shopping")->destroy();
        // return Cart::instance('shopping')->total();
        $cart_amt = Helper::calAmtWithTax();
//        return $cart_amt['total'] * Session::get('currency_val');
        $data['cartAmt'] = $cart_amt['total'] * Session::get('currency_val');
        return $data;
    }

    public function deleteKotProds() {
        $delprd = HasProducts::find(Input::get('hasprdid'));
        $getkot = $delprd->kot;
        $orderid = $delprd->order_id;
        $delprd->delete();
        if (Kot::find($getkot)->products()->count() == 0) {
            Kot::find($getkot)->delete();
        }


        return $orderid;
    }

    public function tableOccupiedOrder() {
        //  dd(Input::all());
        $key = Input::get('keyname');
        $order = Table::find(Input::get('tableid'))->orders()->orderBy("created_at", "desc")->first();
        if ($key == 'cut') {
            $url = route('admin.order.getbill', ['id' => $order->id]);
        } else {
            $url = route('admin.order.additems', ['id' => $order->id]);
        }

        return $url;
    }

    public function tableOccupiedOrderBill($id) {
        $order = Order::find($id);
        $coupon = Coupon::where("status", 1)->where("start_date", "<=", Carbon\Carbon::now())->where("end_date", ">", Carbon\Carbon::now())->pluck("coupon_name", "coupon_code")->prepend("Apply Coupon", "");
        $ordcountries = Country::where("status", 1)->pluck("name", "id")->prepend("Country", "");
        $ordstates = Zone::where("status", 1)->pluck("name", "id")->prepend("State", "");
        $data = ['order' => $order, 'coupon' => $coupon, 'ordcountries' => $ordcountries, 'ordstates' => $ordstates];
//        $order = Table::find(Input::get('tableid'))->orders()->orderBy("created_at","desc")->first();
//        $url = route('admin.order.additems',['id'=>$order->id]);
        return Helper::returnView(Config('constants.adminTableView') . '.orderBill', $data);
    }

    public function checkCoupon() {
        /*
          Session::put('currency_val',1);
          Cart::instance('shopping')->destroy();
          // Remove all discount session before adding new discount
          Session::forget("discAmt");
          Session::forget('voucherUsedAmt');
          Session::forget('voucherAmount');
          Session::forget('remainingVoucherAmt');
          Session::forget('checkbackUsedAmt');
          Session::forget('remainingCashback');
          Session::forget("ReferalCode");
          Session::forget("ReferalId");
          Session::forget("referalCodeAmt");
          Session::forget("codCharges");
          Session::forget('shippingCost');
         */

        $couponCode = Input::get('couponCode');
        $cartContent = Cart::instance('shopping')->content()->toArray();

        $cart_amt = Helper::calAmtWithTax();

        $orderAmount = $cart_amt['total'];
        $couponID = Coupon::where("coupon_code", "=", $couponCode)->first();

        @$usedCouponCountOrders = @Order::where('coupon_used', '=', $couponID->id)->where("order_status", "=", 1)->count();
        if (isset($couponID)) {
            if ($couponID->user_specific == 1) {
                if (!empty(Session::get('loggedin_user_id'))) {
                    $chkUserSp = Coupon::find($couponID->id)->userspecific()->get(['user_id']);
                    $cuserids = [];
                    foreach ($chkUserSp as $chkuserid) {
                        array_push($cuserids, $chkuserid->user_id);
                    }
                    $validuser = in_array(Session::get('loggedin_user_id'), $cuserids);
                    if ($validuser) {
                        $validCoupon = DB::select(DB::raw("Select * from " . DB::getTablePrefix() . "coupons where coupon_code = '$couponCode'  and no_times_allowed > $usedCouponCountOrders and min_order_amt <= " . $orderAmount . " and (now() between start_date and end_date)"));
                    }
                }
            } else {

                $validCoupon = DB::select(DB::raw("Select * from " . DB::getTablePrefix() . "coupons where coupon_code = '$couponCode'  and no_times_allowed > $usedCouponCountOrders and min_order_amt <= " . $orderAmount . " and (now() between start_date and end_date)"));
            }
        }

        if (isset($validCoupon) && !empty($validCoupon)) {
            $disc = 0;

            if ($validCoupon[0]->coupon_type == 2) {
//for specific category
                $orderAmt = 0;
                $allowedCats = [];
                $cats = Coupon::find($validCoupon[0]->id)->categories->toArray();
                foreach ($cats as $cat) {
                    array_push($allowedCats, $cat['id']);
                }
                if (!empty($cartContent)) {
                    $cats = [];
                    $discountCartProds = [];
                    $individualSubtotal = [];
                    foreach ($cartContent as $product) {

                        $checkAllowCatsCount = array_intersect($allowedCats, $product['options']['cats']);
                        if (!empty($checkAllowCatsCount)) {
                            $indvDisc = 0;
                            if ($validCoupon[0]->discount_type == 1) {
                                $indvDisc = ($validCoupon[0]->coupon_value * $product['subtotal']) / 100;
                                $disc += $indvDisc;
                                $individualSubtotal[$product['rowid']] = $indvDisc;
                            } else {
                                if ($validCoupon[0]->discount_type == 2) {
                                    $orderAmt += $product['subtotal'];
                                    if ($validCoupon[0]->min_order_amt <= $orderAmt) {
                                        $disc = $validCoupon[0]->coupon_value; //200 rs
                                        $individualSubtotal[$product['rowid']] = $product['qty'] * $product['price'];
                                    }
                                }
                            }
                        }
                    }
                    // print_r($individualSubtotal);
                    $discountCartProds = $this->calculateFixedDiscount($individualSubtotal, $disc);
                    // dd($discountCartProds);
                }
            } else if ($validCoupon[0]->coupon_type == 3) {
//for specific prods
                $orderAmt = 0;
                $allowedProds = [];
                $prods = Coupon::find($validCoupon[0]->id)->products()->get()->toArray();
                foreach ($prods as $prd) {
                    array_push($allowedProds, $prd['id']);
                }

                if (!empty($cartContent)) {
                    // print_r($cartContent);
                    $discountCartProds = [];
                    $individualSubtotal = [];
                    foreach ($cartContent as $product) {
                        $getChkProds = [];
                        array_push($getChkProds, $product['options']['sub_prod']);
                        array_push($getChkProds, $product['id']);
                        $prodids = array_intersect($allowedProds, $getChkProds);
                        if (!empty($prodids)) {
                            $indvDisc = 0;
                            if ($validCoupon[0]->discount_type == 1) {
                                $indvDisc = ($validCoupon[0]->coupon_value * $product['subtotal']) / 100;
                                $disc += $indvDisc;
                                $individualSubtotal[$product['rowid']] = $indvDisc;
                            } else {
                                if ($validCoupon[0]->discount_type == 2) {
                                    $orderAmt += $product['subtotal'];
                                    if ($validCoupon[0]->min_order_amt <= $orderAmt) {
                                        $disc = $validCoupon[0]->coupon_value;
                                        $individualSubtotal[$product['rowid']] = ($product['qty'] * $product['price']);
                                    }
                                }
                            }
                        }
                    }
                    $discountCartProds = $this->calculateFixedDiscount($individualSubtotal, $disc);
                    //   dd($discountCartProds);
                }
            } else if ($validCoupon[0]->coupon_type == 1) {
                //for all prods and categories
                $orderAmt = 0;
                $discountCartProds = [];
                $individualSubtotal = [];
                foreach ($cartContent as $prdAllC) {
                    $indvDisc = 0;
                    if ($validCoupon[0]->discount_type == 1) {
                        $indvDisc = ($validCoupon[0]->coupon_value * $prdAllC['subtotal']) / 100;
                        $disc += $indvDisc;
                        $individualSubtotal[$prdAllC['rowid']] = $indvDisc;
                    } else {
                        if ($validCoupon[0]->discount_type == 2) {
                            $orderAmt += $prdAllC['subtotal'];
                            if ($validCoupon[0]->min_order_amt <= $orderAmt) {
                                $disc = $validCoupon[0]->coupon_value;
                                $individualSubtotal[$prdAllC['rowid']] = ($prdAllC['qty'] * $prdAllC['price']);
                            }
                        }
                    }
                }
                $discountCartProds = $this->calculateFixedDiscount($individualSubtotal, $disc);
            }
        }
        //@$disc = number_format(@$disc, 2);
        if (!empty($validCoupon) && $disc > 0) {
            Session::put('couponUsedAmt', $disc);
            Session::put('usedCouponCode', $validCoupon[0]->coupon_code);
            Session::put('usedCouponId', $validCoupon[0]->id);
            $data = [];

            $data['coupon_type'] = $validCoupon[0]->coupon_type * Session::get('currency_val');
            $data['disc'] = $disc * Session::get('currency_val');
            $data['individual_disc_amt'] = $discountCartProds;

            // coupon amt to added by satendra
            if (Session::get('individualDiscountPercent')) {
                $coupDisc = json_decode(Session::get('individualDiscountPercent'), true);
                foreach ($coupDisc as $discK => $discV) {
                    Cart::instance('shopping')->update($discK, ["options" => ['disc' => @$discV]]);
                }
            }

            $cart_amt = Helper::calAmtWithTax();
            $data['cart'] = Cart::instance('shopping')->content()->toArray();
            $newAmnt = $cart_amt['total'] * Session::get('currency_val');
            $data['subtotal'] = $cart_amt['sub_total'] * Session::get('currency_val');
            $data['orderAmount'] = $cart_amt['total'] * Session::get('currency_val');
            return $data;
        } else {

            Session::forget('couponUsedAmt');
            Session::forget('usedCouponId');
            Session::forget('usedCouponCode');

            $data['remove'] = 1;

            $cart = Cart::instance('shopping')->content();
            foreach ($cart as $k => $c) {
                Cart::instance('shopping')->update($k, ["options" => ['disc' => 0]]);
            }
            $cart_amt = Helper::calAmtWithTax();
            $data['cart'] = Cart::instance('shopping')->content()->toArray();
            $data['subtotal'] = $cart_amt['sub_total'] * Session::get('currency_val');
            $data['orderAmount'] = $cart_amt['total'] * Session::get('currency_val');
            $data['cartCnt'] = Cart::instance('shopping')->count();
            return $data;
        }
    }

    public function calculateFixedDiscount($individualSubtotal, $disc) {
        $arraySumPercent = array_sum($individualSubtotal) / 100;
        $individualDiscountPercent = [];
        foreach ($individualSubtotal as $key => $subtotal) {
            $calPerdiscount = $subtotal / 100;
            $individualDiscountPercent[$key] = $disc * $calPerdiscount / $arraySumPercent;
        }
        Session::put('individualDiscountPercent', json_encode($individualDiscountPercent));
        return $individualDiscountPercent;
    }

    public function removeAllDiscountSession() {
        Session::forget('couponUsedAmt');
        Session::forget('usedCouponCode');
        Session::forget('usedCouponId');
        Session::forget("discAmt");
        Session::forget('voucherUsedAmt');
        Session::forget('voucherAmount');
        Session::forget('remainingVoucherAmt');
        Session::forget('checkbackUsedAmt');
        Session::forget('remainingCashback');
        Session::forget("ReferalCode");
        Session::forget("ReferalId");
        Session::forget("referalCodeAmt");
        Session::forget("codCharges");
        Session::forget('shippingCost');
    }

    public function getAddCharges() {
        $cart_amt = Helper::calAmtWithTax();
        $price = $cart_amt['total'] * Session::get('currency_val');
        $additionalCharge = AdditionalCharge::ApplyAdditionalCharge($price);
        $data['additionalCharge'] = $additionalCharge;
        return $data;
    }

    public function reqLoyalty() {
        $user_id = input::get('user_id');
        $orderAmt = input::get('orderAmt');

        if (isset($user_id)) {
            $cashback = User::find($user_id)->cashback * Session::get('currency_val');
        } else {
            $cashback = User::find(Session::get('loggedin_user_id'))->cashback * Session::get('currency_val');
        }
//        if($orderAmt > $cashback){
//              Session::put('checkbackUsedAmt', $cartAmount); 
//        }
//return $cashback;
        $cartAmount = Helper::getMrpTotal();

        if ($cartAmount < $cashback) {
            Session::put('checkbackUsedAmt', $cartAmount);
            Session::put('remainingCashback', $cashback - $cartAmount);
        } else {
            Session::put('remainingCashback', 0);
            Session::put('checkbackUsedAmt', $cashback);
        }

        $orderAmt = Helper::getMrpTotal();

        $cart = Cart::instance('shopping')->content();
        foreach ($cart as $k => $c) {
            $productP = (($c->subtotal - $c->options->disc) / 100);
            $orderAmtP = ($orderAmt / 100);
            $amt = Helper::discForProduct($productP, $orderAmtP, Session::get('checkbackUsedAmt'));

            Cart::instance('shopping')->update($k, ["options" => ['wallet_disc' => $amt]]);
        }

        $cart_data = Helper::calAmtWithTax();
        $cartAmount = $cart_data['total'];

        $finalamt = $cartAmount;

        if ($finalamt <= 0) {
            $finalamt = 0;
        } else {
            $finalamt = number_format($finalamt, 2);
        }
        $cart = Cart::instance('shopping')->content();
        return $data = ['cashbackremaining' => Session::get('remainingCashback'), 'checkbackUsedAmt' => Session::get('checkbackUsedAmt')];
        //  Session::put('pay_amt', $finalamt);
        //  echo Session::get('remainingCashback') . ":-" . @Session::get('checkbackUsedAmt') . ":-" . Session::get('pay_amt') . ':-' . json_encode($cart);
    }

    public function revLoyalty() {
        $user_id = input::get('user_id');
        $orderAmt = input::get('orderAmt');
        $cart = Cart::instance('shopping')->content();
        foreach ($cart as $k => $c) {
            Cart::instance('shopping')->update($k, ["options" => ['wallet_disc' => 0]]);
        }
        Session::put('checkbackUsedAmt', 0);
        $cart_data = Helper::calAmtWithTax();
        if (isset($user_id)) {
            $cashback = User::find($user_id)->cashback * Session::get('currency_val');
        } else {
            $cashback = User::find(Session::get('loggedin_user_id'))->cashback * Session::get('currency_val');
        }
        return $cashback;
    }

    public function cashOnDelivary() {
        // return Input::all();

        Session::put("currency_val", 1);
        $userId = input::get('userId');
        $orderId = input::get('orderId');
        $payAmt = input::get('payamt');
        $addi = explode(",", input::get('additionalcharge'));
        $additionalCharge = array_map('intval', $addi);
        //$additionalCharge=input::get('additionalcharge');      
        $payAmt = filter_var($payAmt, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $addressId = input::get('addressId');
        $paymentMethod = 1;
        $data = $this->saveOrder($userId, $orderId, $addressId, $payAmt, $paymentMethod, $additionalCharge);
        //echo "<pre> data::";
        //print_r($data);
        return $data;
    }

    public function saveOrder($userId, $orderId, $addressId, $payAmt, $paymentMethod, $additionalCharge) {
        $address = Address::find($addressId);
        //dd($address);
        $getStoreId = SESSION::get('store_id');
        $orderStatusResult = DB::table('order_status')
            ->where('store_id', $getStoreId)
            ->where('order_status', 'Delivered')
            ->get();
        $orderStatusId = 0;
        foreach($orderStatusResult as $getOrderStatatusData)
        {
            //Get Processin id
            $orderStatusId = $getOrderStatatusData->id;
            $orderStatus = $getOrderStatatusData->order_status;
        }

        $orders = Order::find($orderId);
        if ($userId) {
            $user = User::find($userId);
            $orders->user_id = $user->id;
            $orders->email = $user->email;
        }
        if ($addressId) {
            $address = Address::find($addressId);
            $orders->first_name = $address->firstname;
            $orders->last_name = $address->lastname;
            $orders->address1 = $address->address1;
            $orders->address2 = $address->address2;
            $orders->address3 = $address->address3;
            $orders->phone_no = $address->phone_no;
            $orders->city = $address->city;
            $orders->postal_code = $address->postcode;
            $orders->country_id = $address->country_id;
            $orders->zone_id = $address->zone_id;
        }
        $cart_data = Helper::calAmtWithTax();
        // dd($cart_data['total']);
        $cartAmount = $cart_data['total'];
        //  dd($cartAmount);

        $cartContent = Cart::instance('shopping')->content()->toArray();
        $discountedAmount = 0;
        if (!empty($cartContent)) {
            foreach ($cartContent as $product) {
                $productId = $product['id'];
                $rowId = $product['rowid'];
                $discountedAmount = $product['options']['discountedAmount'];
                $storeId = $product['options']['store_id'];

                //echo "<br> product id::".$productId;
                //get ordered product from has_product table
                $hasProductsResult = DB::table('has_products')
                ->where('order_id', $orderId)
                ->where('prod_id', $productId)
                ->get();
                //echo "<pre>";
                //print_r($hasProductsResult);
                $productQty = 0;
                $productPrice= 0;
                $i=0;
                foreach($hasProductsResult as $getData)
                {
                $productQty += $getData->qty;
                $productPrice += $getData->price;

                $i++;
                }
                //echo "<br> product qty::".$productQty;
                //echo "<br>product price::".$productPrice;
                $subtotal = ($productQty * $productPrice);
                $cart = Cart::instance('shopping')->update($rowId, ['qty' => $productQty, 'price' => $productPrice, 'subtotal' => $subtotal]);
                //exit;
            }//foreach ends here
        }
        $orderAmt = $subtotal;
        if($discountedAmount > 0)
        {
            $orderAmt = $subtotal - $discountedAmount;
        }
        $orders->order_status = $orderStatusId;
        $orders->store_id = $storeId;
        $orders->order_amt = $payAmt;
        $additional_charge_json = AdditionalCharge::ApplyAdditionalChargeOnOrder($payAmt, $additionalCharge);

        $orders->additional_charge = $additional_charge_json ? $additional_charge_json : 0;
        //return $additional_charge_json;
        $orders->payment_method = $paymentMethod;
        $orders->pay_amt = $payAmt;
        $orders->currency_id = Session::get("currency_id");
        $orders->currency_value = Session::get("currency_val");
        $orders->cart = json_encode(Cart::instance('shopping')->content());
        $orders->coupon_amt_used = is_null(Session::get('couponUsedAmt')) ? 0 : Session::get('couponUsedAmt') * Session::get('currency_val');
        $orders->coupon_used = is_null(Session::get('usedCouponId')) ? 0 : Session::get('usedCouponId');
        $orders->cashback_used = is_null(Session::get('checkbackUsedAmt')) ? 0 : Session::get('checkbackUsedAmt');
        $orders->voucher_amt_used = is_null(Session::get('voucherAmount')) ? 0 : Session::get('voucherAmount');
        $orders->voucher_used = is_null(Session::get('voucherUsedAmt')) ? 0 : Session::get('voucherUsedAmt');
        if ($this->feature['referral'] == 1) {
            if (!empty(Session::get("ReferalId"))) {
                $orders->referal_code_used = Session::get("ReferalCode");
                $orders->referal_code_amt = Session::get("referalCodeAmt");
                $orders->user_ref_points = Session::get("userReferalPoints");
                $orders->ref_flag = 0;
            }
        }

        if ($this->feature['loyalty'] == 1 && $userId != null) {
            $orders->loyalty_cron_status = 1;
            $loyaltyPercent = $user->loyalty['percent'];
            $amt = $user->total_purchase_till_now;
            $loyalty = Loyalty::where("min_order_amt", ">=", $amt)->where("max_order_amt", "<=", $amt)->orderBy("min_order_amt", "desc")->first();
            if (isset($loyalty->id)) {
                $user->loyalty_group = $loyalty->id;
            }
            $orders->cashback_earned = is_null($loyaltyPercent) ? 0 : number_format(((($loyaltyPercent * $payAmt) / 100) * Session::get("currency_val")), 2);
        } else {
            $orders->loyalty_cron_status = 0;
        }
        if ($userId) {
            $user->cashback = $user->cashback - (@Session::get('checkbackUsedAmt') / Session::get('currency_val'));
            $user->update();
        }
        $orders->update();
        $orders->couponCode = @$orders->coupon()->first()->coupon_name;
        $contact = Contact::where('status', 1)->orderBy('id', 'desc')->take(1)->first();
        $storeName = Helper::getSettings()['storeName'];

        $data = ['orders' => $orders, 'contact' => $contact, 'storeName' => $storeName];

        return $data;
    }

    public function changeOccupancyStatus($oStatus)
    {
        if (Input::get("orderId")) {
            $order = Order::find(Input::get("orderId"));
            if ($order->otype == 1) {
                if($order->table_id == '' || $order->table_id == 'null')
                {
                    $joinTableIdArry = json_decode($order->join_tables); 
                    foreach($joinTableIdArry as $getTableId)
                    {
                       $table = Table::find($getTableId);
                       $table->ostatus = $oStatus;
                       $table->update();
                   
                    }//foreach ends here
                }
                else
                {
                    $table = Table::find($order->table_id);
                    $table->ostatus = $oStatus;
                    $table->update();
                }
                Session::flash("msg", 'Table status updated successfully.');
                return ['status' => 1, 'msg' => "Table status updated successfully."];
            } else {
                $order->order_status = 3;
                $order->update();
                $statusHistory = ['order_id' => $order->id, 'status_id' => 3, 'remark' => 'Table order completed', 'notify' => 0, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')];
                OrderStatusHistory::insert($statusHistory);
                Session::flash("msg", '');
                return ['status' => 1, 'msg' => ""];
            }
        } else if (Input::get("tableid")) {
            $order = Order::where('table_id', Input::get("tableid"))->first();
            $order->order_status = 3;
            $order->update();
            $statusHistory = ['order_id' => $order->id, 'status_id' => 3, 'remark' => 'Table order completed', 'notify' => 0, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')];
            OrderStatusHistory::insert($statusHistory);
            $table = Table::find($order->table_id);
            $table->ostatus = $oStatus;
            $table->update();
            Session::flash("msg", 'Table status updated successfully.');
            return ['status' => 1, 'msg' => "Table status updated successfully."];
        } else {
            Session::flash("message", 'Oops something went wrong.');
            return ['status' => 0, 'msg' => "Oops something went wrong."];
        }
    }

    public function getSearchData()
    {
        $searchStr = Input::get('term');
        $products = DB::table('products')
            ->select('products.id', 'products.product', 'products.selling_price', 'categories.category', 'categories.url_key as cat_url')
            ->leftJoin('has_categories', 'products.id', 'has_categories.prod_id')
            ->leftJoin('categories', 'categories.id', '=', 'has_categories.cat_id')
            ->where("products.is_individual", 1)->where('products.status', 1)
            ->where('products.product', "like", "%" . $searchStr . "%")
            ->orWhere('products.id', "like", "%" . $searchStr . "%")
            ->get();

        // $data = [];
        // foreach ($products as $k => $prd) {
        //     if (!in_array($prd->id, $added_prod)) {
        //         $data[$k]['id'] = $prd->id;
        //         $data[$k]['value'] = $prd->product;
        //         $data[$k]['label'] = "[" . $prd->id . "]" . $prd->product;
        //     }
        // }

        return $products;
    }

    public function getOrderDetails()
    {
        $orderId =Input::get('orderid');
        $ordersResult = DB::table('orders')
            ->where('id', $orderId)
            ->get();
        
        $html = '';
        foreach($ordersResult as $getData)
        {
            $storeId = $getData->store_id;
            $couponAmtUsed = $getData->coupon_amt_used;
            $payAmount = $getData->pay_amt;
            //get Store name
            $storeResult = DB::table('stores')
                ->where('id', $storeId)
                ->get();

             foreach($storeResult as $getStoreData)
             {
                $storeName = $getStoreData->store_name;
             }   
            
            $html .= '<label>Store Name: <span>'.$storeName.'</span></label></br>';
            if($couponAmtUsed > 0)
            {
                $html .= '<label>Coupon Amount: <span>'.$couponAmtUsed.'</span></label></br>';
            }
            else
            {
                $html .= '<label>Coupon Amount: <span>-</span></label></br>';
            }
            
            $html .= '<label>Grand Total: <span>'.$payAmount.'</span></label>';
           
        }

        return $html;

    }

}
