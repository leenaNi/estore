<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Library\Helper;
use App\Models\AdditionalCharge;
use App\Models\Address;
use App\Models\Category;
use App\Models\Country;
use App\Models\Coupon;
use App\Models\Courier;
use App\Models\CurierHistory;
use App\Models\EmailTemplate;
use App\Models\Flags;
use App\Models\GeneralSetting;
use App\Models\HasCourier;
use App\Models\HasProducts;
use App\Models\Order;
use App\Models\OrderFlagHistory;
use App\Models\OrderReturnCashbackHistory;
use App\Models\OrderReturnStatus;
use App\Models\OrderStatus;
use App\Models\OrderStatusHistory;
use App\Models\PaymentHistory;
use App\Models\PaymentMethod;
use App\Models\PaymentStatus;
use App\Models\Product;
use App\Models\ReturnOrder;
use App\Models\StaticPage;
use App\Models\User;
use App\Models\Role;
use App\Models\Zone;
use App\Traits\Admin\OrdersTrait;
use Cart;
use Config;
use Crypt;
use DB;
use Hash;
use Input;
use Session;
use Cookie;


class OrdersController extends Controller
{

    use OrdersTrait;

    public function index()
    {
        $user = User::with('roles')->find(Session::get('loggedinAdminId'));      
        $roles = $user->roles;
        $roles_data = $roles->toArray();
        $r = Role::find($roles_data[0]['id']);
        //echo "<pre>";
        //print_r($r);
        //exit;
        //dd($r);
        $loggedInUserName = $r->name;
        //echo "<br>per ::".$per;
        //$data = session()->all();
        //echo "all session::".print_r($data);
        //echo "logged in admin id::".Session::get('loggedinAdminId');
        //exit;
        $loggedInUserId = Session::get('loggedinAdminId');
        $allinput = Input::all();
        $getMerchantStoreIdVal = 0;
        if(!empty($allinput) && !empty(Input::get('id')))
        {
            $getMerchantStoreIdVal = $allinput['id'];
        }
       
        $jsonString = Helper::getSettings();
        if($getMerchantStoreIdVal > 0)
        {
            $storeId = $getMerchantStoreIdVal;
        }
        else
        {
            $storeId = $jsonString['store_id'];
        }

        $order_status = OrderStatus::where('status', 1)->orderBy('order_status', 'asc')->get();
        $order_options = '';
        foreach ($order_status as $status) {
            $order_options .= '<option  value="' . $status->id . '">' . $status->order_status . '</option>';
        }
        
        $orders = Order::where("orders.order_status", "!=", 0)
                ->join("has_products", "has_products.order_id", '=', 'orders.id')
                ->where("has_products.store_id", $storeId)
                ->select('orders.*', 'has_products.order_source', DB::raw('sum(has_products.pay_amt) as hasPayamt'))
                ->groupBy('has_products.order_id')
                ->orderBy('orders.id', 'desc');
        //  $orders = Order::sortable()->where("orders.order_status", "!=", 0)->where('prefix', $jsonString['prefix'])->where('store_id', $jsonString['store_id'])->with(['orderFlag'])->orderBy("id", "desc");
        $payment_method = PaymentMethod::all();
        $payment_stuatus = PaymentStatus::all();
        if($loggedInUserName != 'admin')
        {
            $orders = $orders->where("orders.created_by", $loggedInUserId);
        }
        if (!empty(Input::get('order_ids'))) {
            $mulIds = explode(",", Input::get('order_ids'));
            $orders = $orders->whereIn("orders.id", $mulIds);
        }
        if (!empty(Input::get('order_number_from'))) {
            $orders = $orders->where('orders.id', '>=', Input::get('order_number_from'));
        }
        if (!empty(Input::get('order_number_to'))) {
            $orders = $orders->where('orders.id', '<=', Input::get('order_number_to'));
        }
        if (!empty(Input::get('pricemin'))) {
            $orders = $orders->where('orders.pay_amt', '>=', Input::get('pricemin'));
            // dd($orders->toSql());
        }
        if (!empty(Input::get('pricemax'))) {
            $orders = $orders->where('orders.pay_amt', '<=', Input::get('pricemax'));
        }
        if (!empty(Input::get('search'))) {
            //get user id
            $users = User::whereRaw("(CONCAT(firstname,' ',lastname) like ?)", ['%' . Input::get('search') . '%'])->orwhere('email', "like", "%" . Input::get('search') . "%")->orwhere('telephone', "like", "%" . Input::get('search') . "%")->select('id')->get()->toArray();

            if (!empty($users)) {
                $orders = $orders->whereIn('orders.user_id', $users);
            }
        }
        if (!empty(Input::get('date'))) {
            $dates = explode(' - ', Input::get('date'));
            $dates[0] = date("Y-m-d", strtotime($dates[0]));
            $dates[1] = date("Y-m-d 23:59:00", strtotime($dates[1]));
            $orders = $orders->whereBetween('orders.created_at', $dates);
        }
        /* if (!empty(Input::get('dateto'))) {
        $date = date("Y-m-d", strtotime(Input::get('dateto')));
        $orders = $orders->where('created_at', '<=', $date);
        } */
        if (!empty(Input::get('searchFlag'))) {
            // $chk = Flags::find(Input::get('searchFlag'))->flag;
            $chk = Flags::find(Input::get('searchFlag'))->flag;
            if (strpos($chk, 'No Flag') !== false) {
                $orders = $orders->where('orders.flag_id', 0);
            } else {
                $orders = $orders->where('orders.flag_id', Input::get('searchFlag'));
                // $orders = $orders->WhereHas('orderFlag', function($q) {
                //     $q->where('orders.flag_id', '=', Input::get('searchFlag'));
                // });
            }
        }
        if (Input::get('searchStatus') !== null) {
            if (!empty(Input::get('searchStatus'))) {
                $order_options = '';
                foreach ($order_status as $status) {
                    $order_options .= '<option  value="' . $status->id . '" ' . (in_array($status->id, Input::get('searchStatus')) ? 'selected' : '') . '>' . $status->order_status . '</option>';
                }
                $orders = $orders->whereIn('orders.order_status', Input::get('searchStatus'));
            }
        }

        $orders = $orders->paginate(Config('constants.paginateNo'));
        $ordersCount = $orders->total();
        $flags = Flags::all();
        $viewname = Config('constants.adminOrderView') . '.index';

        $startIndex = 1;
        $getPerPageRecord = Config('constants.paginateNo');
        if(!empty($allinput) && !empty(Input::get('page')))
        {
            $getPageNumber = $allinput['page'];
            $startIndex = ( (($getPageNumber) * ($getPerPageRecord)) - $getPerPageRecord) + 1;
            $endIndex = (($startIndex+$getPerPageRecord) - 1);

            if($endIndex > $ordersCount)
            {
                $endIndex = ($ordersCount);
            }
        }
        else
        {
            $startIndex = 1;
            $endIndex = $getPerPageRecord;
            if($endIndex > $ordersCount)
            {
                $endIndex = ($ordersCount);
            }
        }

        $data = ['orders' => $orders, 'flags' => $flags, 'payment_method' => $payment_method, 'payment_stuatus' => $payment_stuatus, 'ordersCount' => $ordersCount, 'order_status' => $order_status, 'order_options' => $order_options, 'startIndex' => $startIndex, 'endIndex' => $endIndex];
        return Helper::returnView($viewname, $data);
    }

    public function add()
    {
        $order = new Order();
        $action = route("admin.order.save");
        return view(Config('constants.adminOrderView') . '.addEdit', compact('order', 'products', 'action'));
    }

    public function edit()
    {
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
        $jsonString = Helper::getSettings();
        $prodTab = 'products';
        $order = Order::findOrFail(Input::get('id'));
        $payment_method = PaymentMethod::get()->toArray();
        $payment_methods = [];
        foreach ($payment_method as $val) {
            $payment_methods[$val['id']] = $val['name'];
        }
        $payment_stuatusA = PaymentStatus::get()->toArray();
        $payment_status = [];
        foreach ($payment_stuatusA as $val) {
            $payment_status[$val['id']] = $val['payment_status'];
        }
        $order_stuatusA = OrderStatus::get()->toArray();
        $order_status = [];
        foreach ($order_stuatusA as $val) {
            $order_status[$val['id']] = $val['order_status'];
        }
        $countryA = Country::get()->toArray();
        $countries = [];
        foreach ($countryA as $val) {
            $countries[$val['id']] = $val['name'];
        }
        $zoneA = Zone::get()->toArray();
        $zones = [];
        foreach ($zoneA as $val) {
            $zones[$val['id']] = $val['name'];
        }
        $flags = Flags::where('status', 1)->get()->toArray();
        $flag_status[0] = "Select Flag";
        foreach ($flags as $val) {
            $flag_status[$val['id']] = $val['flag'];
        }
        $courierId = HasCourier::where('status', 1)->where('store_id', $this->jsonString['store_id'])->pluck("courier_id");

        $courier = Courier::where('status', 1)->whereIn('id', $courierId)->get()->toArray();

        $courier_status = [];
        $courier_status[0] = "Select Courier";
        foreach ($courier as $val) {
            $courier_status[$val['id']] = $val['name'];
        }
        if ($order->prefix == Helper::getSettings()['prefix']) {
            Cart::instance("shopping")->destroy();
            $coupons = Coupon::whereDate('start_date', '<=', date("Y-m-d"))->where('end_date', '>=', date("Y-m-d"))->get();
            $additional = json_decode($order->additional_charge, true);
            $prodTab = 'products';
            $hasCategories = 'has_categories';
            $prods = HasProducts::where('order_id', Input::get("id"))
                    ->join($hasCategories, $hasCategories.'.prod_id', '=', 'has_products.prod_id')
                      ->join($prodTab, $prodTab . '.id', '=', 'has_products.prod_id')
                    ->select($prodTab . ".*", 'has_products.order_id', 'has_products.disc', 'has_products.prod_id', 'has_products.qty', 'has_products.price as hasPrice', 'has_products.product_details', 'has_products.sub_prod_id')->get();

            $products = $prods;
            // echo "<pre>";
            // print_r($products);
            // exit;
            $coupon = Coupon::find($order->coupon_used);
            $action = route("admin.orders.save");
            // return view(Config('constants.adminOrderView') . '.addEdit', compact('order', 'action', 'payment_methods', 'payment_status', 'order_status', 'countries', 'zones', 'products', 'coupon')); //'users',
            $viewname = Config('constants.adminOrderView') . '.addEdit';
            $data = ['order' => $order, 'action' => $action, 'payment_methods' => $payment_methods, 'payment_status' => $payment_status, 'order_status' => $order_status, 'countries' => $countries, 'zones' => $zones, 'products' => $products, 'coupon' => $coupon, 'coupons' => $coupons, 'flags' => $flag_status, 'courier' => $courier_status, 'additional' => $additional];
            return Helper::returnView($viewname, $data);
        } else {
            $products = HasProducts::where("order_status", "!=", 0)->where("order_id", Input::get('id'))->where('prefix', $jsonString['prefix'])->where('store_id', $jsonString['store_id'])->first();
            $action = route("admin.orders.mallOrderSave");
            $viewname = Config('constants.adminOrderView') . '.addEditMall';
            //  dd($products);
            $data = ['order' => $order, 'action' => $action, 'order_status' => $order_status, 'countries' => $countries, 'zones' => $zones,
                'products' => $products, 'courier' => $courier_status];
            return Helper::returnView($viewname, $data);
        }
    }

    public function save()
    {
        //dd(Input::get('cartdata'));
        // if (Input::get('ordereditCal') == 1) {
        if (!empty(Input::get('cartdata'))) {

            $orderUpdateCart = Order::find(Input::get('id'));
            $existingcart = json_decode($orderUpdateCart->cart);

            foreach ($existingcart as $cart) {

                if (!empty($cart->options->sub_prod)) {
                    $prd = Product::find($cart->options->sub_prod);
                    $prd->stock = $prd->stock + $cart->qty;
                    $prd->update();
                    $prod = Product::find($cart->options->sub_prod);
                } else if (!empty($cart->options->combos)) {
                    foreach ($cart->options->combos as $key => $val) {
                        if (isset($val->sub_prod)) {
                            $prd = Product::find($val->sub_prod);
                            $prd->stock = $prd->stock + $cart->qty;
                            $prd->update();
                        } else {
                            $prd = Product::find($key);
                            $prd->stock = $prd->stock + $cart->qty;
                            $prd->update();
                        }
                    }
                } else {
                    $prd = Product::find($cart->id);
                    $prd->stock = $prd->stock + $cart->qty;
                    $prd->update();
                }
            }

            $cartdata = Input::get('cartdata');

            // if (!Session::get('usedCouponId')) {
            if (Cart::instance('shopping')->count() < 1) {
                foreach ($cartdata as $cartdataInfo) {
                    if (is_array($cartdataInfo)) {
                        foreach ($cartdataInfo as $cartk => $cartv) {
                            $chkprd = Product::find($cartk);
                            if ($chkprd->prod_type == 1) {
                                app('App\Http\Controllers\Frontend\CartController')->simpleProduct($chkprd->id, $cartv['qty']);
                            } else if ($chkprd->prod_type == 3) {
                                app('App\Http\Controllers\Frontend\CartController')->configProduct($chkprd->id, $cartv['qty'], $cartv['subprd']);
                            } else if ($chkprd->prod_type == 2) {
                                $cmb = $cartv['subprd'];
                                $comboSub = [];
                                foreach ($cmb as $combos) {
                                    $comboSub[Product::find($combos)->parent_prod_id] = $combos;
                                }
                                app('App\Http\Controllers\Frontend\CartController')->comboProduct($chkprd->id, $cartv['qty'], $comboSub);
                            }
                        }
                    }
                }
            }

            //save existing cart and revert inventory
            DB::table("order_history")->insert(array('order_id' => $orderUpdateCart->id,
                'cart' => $orderUpdateCart->cart,
                'cod' => $orderUpdateCart->cod_charges,
                'shipping_amt' => $orderUpdateCart->shipping_amt,
                'gifting_amt' => $orderUpdateCart->gifting_charges,
                'coupon_amt' => $orderUpdateCart->coupon_amt_used,
                'voucher_amt' => $orderUpdateCart->voucher_amt_used,
                'referral_amt' => $orderUpdateCart->referal_code_amt,
                'cashback_used' => $orderUpdateCart->cashback_used,
                'order_amt' => $orderUpdateCart->order_amt,
                'pay_amt' => $orderUpdateCart->pay_amt,
                'flag_id' => $orderUpdateCart->flag_id,
                'courier' => $orderUpdateCart->courier,
                'additional_charge' => $orderUpdateCart->additional_charge,
                'user_id' => Session::get('admin_id'),
                'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            ));

            $arrExistingCart = [];
            $i = 0;

            foreach ($existingcart as $eCart) {
                $arrExistingCart[$i]['id'] = @$eCart->id;
                if (!Session::get('individualDiscountPercent')) {
                    $arrExistingCart[$i]['disc'] = @$eCart->options->disc;
                } else {
                    $arrExistingCart[$i]['disc'] = 0;
                }

                $arrExistingCart[$i]['discQty'] = @$eCart->options->discounted_qty;
                $i++;
            }

            foreach (Cart::instance('shopping')->content() as $rowiD => $shopC) {
                $chkdata = "";
                $chkdata = $this->searchForId($shopC['id'], $arrExistingCart);
                if (!empty($chkdata) && !is_null($chkdata)) {
                    Cart::instance('shopping')->update($rowiD, ["options" => ['disc' => ($chkdata['disc']) ? $chkdata['disc'] : 0, 'discounted_qty' => ($chkdata['discQty']) ? $chkdata['discQty'] : 0]]);
                }
            }

            // if (Session::get('individualDiscountPercent')) {
            //      $coupDisc = json_decode(Session::get('individualDiscountPercent'), true);
            //     foreach ($coupDisc as $discK => $discV) {
            //         Cart::instance('shopping')->update($discK, ["options" => ['disc' => @$discV]]);
            //     }
            // }

            $newCartData = Cart::instance("shopping")->content();
            $orderUpdateCart->cart = json_encode($newCartData);
            $orderUpdateCart->order_amt = Input::get('order_amt');

            // $orderUpdateCart->pay_amt = Input::get('pay_amt');

            $orderUpdateCart->cod_charges = Input::get('cod_charges');
            $orderUpdateCart->gifting_charges = Input::get('gifting_charges');
            $orderUpdateCart->referal_code_amt = Input::get('referal_code_amt');
            $orderUpdateCart->cashback_used = Input::get('cashback_used');
            $orderUpdateCart->shipping_amt = Input::get('shipping_amt');
            $orderUpdateCart->coupon_amt_used = Input::get('coupon_amt_used');
            $orderUpdateCart->coupon_used = is_null(Session::get('usedCouponId')) ? 0 : Session::get('usedCouponId');
            $orderUpdateCart->voucher_amt_used = Input::get('voucher_amt_used');

            $chargable_amount = Input::get('order_amt') - Input::get('coupon_amt_used');

            $additional_charge_json = AdditionalCharge::ApplyAdditionalCharge($chargable_amount);

            $additional_charge = json_decode($additional_charge_json, true);
            $orderUpdateCart->pay_amt = $chargable_amount + $additional_charge['total_amt'];

            $orderUpdateCart->additional_charge = $additional_charge_json;

            $orderUpdateCart->update();
            if (Input::get('cashback_to_add') != 0) {
                $updateCashback = User::find($orderUpdateCart->user_id);
                $updateCashback->cashback = $updateCashback->cashback + round(Input::get('cashback_to_add'));
                $updateCashback->update();
            }

            $newcart = $newCartData;
            HasProducts::where("order_id", Input::get('id'))->delete();
            // dd($newcart);
            foreach ($newcart as $cart) {
                $checkPrd = Product::find($cart->id);
                $cart_ids[$cart->id] = ["qty" => $cart->qty, "price" => $cart->subtotal, "created_at" => date('Y-m-d H:i:s'), "disc" => @$cart->options->disc];

                if ($cart->options->options) {
                    //echo 'hii';
                    $cart_ids[$cart->id]["sub_prod_id"] = $cart->options->sub_prod;
                    $prd = Product::find($cart->options->sub_prod);
                    //  echo $cart->name.'<br/>';
                    $proddetails = [];
                    $prddataS = Product::find($cart->options->sub_prod);
                    $proddetails['id'] = $prd->id;
                    $proddetails['name'] = $prd->product;
                    $proddetails['image'] = $cart->options->image;
                    $proddetails['price'] = $cart->sellig_price * Session::get("currency_val");
                    $proddetails['qty'] = $cart->qty;

                    $proddetails['subtotal'] = $cart->subtotal * Session::get("currency_val");
                    $proddetails['is_cod'] = $prd->is_cod;
                    $cart_ids[$cart->id]["product_details"] = json_encode($proddetails);
                    $cart_ids[$cart->id]["amt_after_discount"] = $cart->options->discountedAmount;
                    $prd->stock = $prd->stock - $cart->qty;
                    $prd->update();
                }if ($cart->options->combos) {
                    $sub_prd_ids = [];
                    foreach ($cart->options->combos as $key => $val) {

                        if (isset($val['sub_prod'])) {
                            array_push($sub_prd_ids, (string) $val['sub_prod']);
                            $prd = Product::find($val['sub_prod']);
                            $prd->stock = $prd->stock - $cart->qty;
                            $prd->update();
                        } else {
                            $prd = Product::find($key);
                            $prd->stock = $prd->stock - $cart->qty;
                            $prd->update();
                        }
                    }
                    $cart_ids[$cart->id]["sub_prod_id"] = json_encode($sub_prd_ids);
                }if ($checkPrd->prod_type == 1) {
                    $prd = Product::find($cart->id);

                    $proddetails = [];
                    $prddataS = Product::find($cart->options->sub_prod);
                    $proddetails['id'] = $prd->id;
                    $proddetails['name'] = $prd->product;
                    $proddetails['image'] = $cart->options->image;
                    $proddetails['price'] = $cart->sellig_price * Session::get("currency_val");
                    $proddetails['qty'] = $cart->qty;
                    $proddetails['amt_after_discount'] = $cart->options->discountedAmount;
                    $proddetails['subtotal'] = $cart->subtotal * Session::get("currency_val");
                    $proddetails['is_cod'] = $prd->is_cod;
                    $cart_ids[$cart->id]["product_details"] = json_encode($proddetails);
                    $cart_ids[$cart->id]["amt_after_discount"] = $cart->options->discountedAmount;
                    $prd->stock = $prd->stock - $cart->qty;
                    $prd->update();
                }
                $cart_ids[$cart->id]["order_id"] = Input::get('id');
                $cart_ids[$cart->id]["prod_id"] = $prd->id;
                $cart_ids[$cart->id]["order_status"] = 1;
                $cart_ids[$cart->id]["order_source"] = 2;
                HasProducts::insert($cart_ids);
                //$orderUpdateCart->products()->attach($cart->id, $cart_ids[$cart->id]);
            }

            Cart::instance("shopping")->destroy();
            Session::forget('orderId');
            Session::forget('usedCouponId');
            Session::forget('individualDiscountPercent');
        } else {

            $order = Order::findOrNew(Input::get('id'));
            $orderStatus = $order->order_status;
            $updateOrder = $order->fill(Input::except('not_in_use'))->save();
            HasProducts::where("order_id", Input::get('id'))->update(["order_status" => $order->order_status]);
            if (Input::get('order_status') && $updateOrder == true && $orderStatus != Input::get('order_status')) {
                OrderStatusHistory::create([
                    'order_id' => Input::get('id'),
                    'status_id' => Input::get('order_status'),
                    'remark' => '',
                    'notify' => 0,
                ]);
            }
        }

        Session::flash("message", "Order updated successfully.");

        return redirect()->route('admin.orders.view');
    }

    public function addCartForCoupon()
    {
        $cartdata = Input::get('cartdata');
    }

    public function mallOrderSave()
    {

        $orders = HasProducts::find(Input::get("order_id"));
        if (Input::get("order_status")) {
            $orders->order_status = Input::get("order_status");
        }
        $orders->save();
        return redirect()->route('admin.orders.view');
    }

    public function updateRetutnQty()
    {

        $orderEdit = Order::find(Input::get('id'));
        $cnt = 0;
        foreach (Input::get("pid") as $key => $val) {
            if (Input::get("qty_returned")[$key]) {
                $row = DB::table('has_products')->where("id", $key)->first();
                $actQty = $row->qty - Input::get("qty_returned")[$row->id];
                $mainProd = Product::find($val);
                $mainProd->stock = $mainProd->stock + Input::get("qty_returned")[$row->id];
                $mainProd->update();
                DB::table('has_products')
                    ->where('id', $key)
                    ->update(['price' => $mainProd->price * $actQty, 'qty' => $actQty, 'qty_returned' => Input::get("qty_returned")[$row->id]]);
                $orderEdit->order_amt = $orderEdit->order_amt - ($mainProd->price * Input::get("qty_returned")[$row->id]);
                $orderEdit->pay_amt = $orderEdit->pay_amt - ($mainProd->price * Input::get("qty_returned")[$row->id]);

                $cats = [];
                foreach ($mainProd->categories as $cat) {
                    array_push($cats, $cat->id);
                }
                $images = $mainProd->catalogimgs()->where("image_type", "=", 1)->first()->filename;
                Cart::instance('shopping')->add(["id" => $mainProd->id, "name" => $mainProd->product, "qty" => $row->qty, "price" => $mainProd->price, "options" => ["image" => $images, "is_cod" => $mainProd->is_cod, 'cats' => $cats]]);
                $cartContent = Cart::instance('shopping')->content();
                $orderEdit->cart = json_encode($cartContent);
                $cartContent = Cart::instance('shopping')->content();
                $orderEdit->cart = json_encode($cartContent);
                $orderEdit->update();
            } else {
                if (Input::get('qty')[$key] != Input::get('old_qty')[$key]) {
                    $qty = Input::get('qty')[$key];
                    $old_qty = Input::get('old_qty')[$key];
                    $product = HasProducts::where('id', $key)->first();
                    $mainProd = Product::find($val);
                    if ($qty > $old_qty) {
                        $diff = $qty - $old_qty;
                        if ($mainProd->stock >= $qty - $old_qty) {
                            $product->qty = $qty;
                            $product->price = $mainProd->price * $qty;
                            $product->update();
                            $mainProd->stock = $mainProd->stock - $diff;
                            $orderEdit->order_amt = $orderEdit->order_amt + ($mainProd->price * $diff);
                            $orderEdit->pay_amt = $orderEdit->pay_amt + ($mainProd->price * $diff);
                            $cnt++;
                        }
                    } else {
                        $diff1 = $old_qty - $qty;
                        $product->qty = $qty;
                        $product->price = $mainProd->price * $qty;
                        $product->update();
                        $mainProd->stock = $mainProd->stock + $diff1;
                        $orderEdit->order_amt = $orderEdit->order_amt - ($mainProd->price * $diff1);
                        $orderEdit->pay_amt = $orderEdit->pay_amt - ($mainProd->price * $diff1);
                        $cnt++;
                    }
                    $mainProd->update();
                    $cats = [];
                    foreach ($mainProd->categories as $cat) {
                        array_push($cats, $cat->id);
                    }
                    $images = $mainProd->catalogimgs()->where("image_type", "=", 1)->first()->filename;
                    Cart::instance('shopping')->add(["id" => $mainProd->id, "name" => $mainProd->product, "qty" => $qty, "price" => $mainProd->price, "options" => ["image" => $images, "is_cod" => $mainProd->is_cod, 'cats' => $cats]]);
                    $cartContent = Cart::instance('shopping')->content();
                    $orderEdit->cart = json_encode($cartContent);
                    $orderEdit->update();
                }
            }
        }

        if ($cnt > 0) {
            Session::flash("message", "Order Quantity Updated Successfully!");
        }
        return redirect()->route('admin.orders.view');
    }

    public function revertReturnQty()
    {
        $orderEdit = Order::find(Input::get('id'));
        $newval = 0;
        foreach (Input::get("pid") as $key => $val) {
            $row = DB::table('has_products')->where("id", $key)->first();
            $actQty = $row->qty + Input::get("qty_returned")[$row->id];
            $mainProd = Product::find($val);
            $mainProd->stock = $mainProd->stock - Input::get("qty_returned")[$row->id];
            $mainProd->update();
            DB::table('has_products')
                ->where('id', $key)
                ->update(['price' => $mainProd->price * $actQty, 'qty' => $actQty, 'qty_returned' => 0]);
            $orderEdit->order_amt = $orderEdit->order_amt + ($mainProd->price * Input::get("qty_returned")[$row->id]);
            $orderEdit->pay_amt = $orderEdit->pay_amt + ($mainProd->price * Input::get("qty_returned")[$row->id]);
            $orderEdit->update();
        }
        return redirect()->route('admin.orders.view');
    }

    public function delete()
    {
        $order = Order::find(Input::get('id'));
        if ($order->order_status == 1) {
            $cartContent = json_decode($order->cart);
            // dd($cartContent);
            foreach ($cartContent as $cart) {

                $product = Product::find($cart->id);
                if ($product->prod_type == 1) {
                    $product->stock = ($product->stock + $cart->qty);
                    $product->save();
                } else if ($product->prod_type == 3) {
                    $subProd = $cart->options->sub_prod;
                    $Subproduct = Product::find($subProd);
                    $Subproduct->stock = ($Subproduct->stock + $cart->qty);
                    $product->save();
                }
            }
            Session::flash("messageError", "Order deleted successfully.");
            $order->delete();
            return redirect()->route('admin.orders.view');
        } else {
            Session::flash("messageError", "You can't delete this order.");
            return redirect()->route('admin.orders.view');
        }
    }

    public function invoice($id = null)
    {
        //echo "<pre>";
        $allids = $id;
        if ($id == null) {
            $allids = Input::get('OrderIds');
        }

        $orders = Order::whereIn('id', explode(",", $allids))->get();
        foreach ($orders as $key => $order) {
            $catlogs = json_decode($order->cart, true);
            $orders[$key]->previous_order = [];
            if ($order->forward_id != 0) {
                $orders[$key]->previous_order = Order::where('id', $order->forward_id)->select('order_amt', 'pay_amt')->get();
            }
            foreach ($catlogs as $key2 => $product) {
                //  dd($product['options']);die;
                // dd($product['id']);
                $catlogs[$key2]['product'] = Product::where('id', $product['id'])->first();
                $catlogs[$key2]['category'] = Category::where('id', $product['options']['cats'][0])->first();
            }
            // dd($sum);
            $orders[$key]->cartItems = $catlogs;
        }
        $addCharge = GeneralSetting::where('url_key', 'additional-charge')->first();
        //dd($addCharge);
        $addcharge_status = $addCharge->status;
        $additional = json_decode($order->additional_charge, true);
        //dd($additional);
        //          print_r(json_decode($orders));
        //            die;
        //        dd($orders);
        // return View(Config('constants.adminOrderView') . '.invoice', compact('orders', 'allids'));
        $viewname = Config('constants.adminOrderView') . '.invoice';
        $data = ['orders' => $orders, 'allids' => $allids, 'additional' => $additional, 'chrges' => $addCharge, 'jsonString' => $this->jsonString];
        return Helper::returnView($viewname, $data);
    }

    public function setPrintInvoice()
    {

        $allorders = Input::get("AllOrders");
        $orders = explode(",", $allorders);

        foreach ($orders as $od) {
            $update = Order::find($od);
            $update->print_invoice = 1;
            $update->update();
        }
    }

    public function updateOrderStatus()
    {
        //NO Mail for undelivered order
        $notify = 0;
        $comment = Input::get('comment');
        $orderIds = explode(",", Input::get('OrderIds'));
        $orderStatus = Input::get("status");
        $remark = Input::get('remark');
        $notify = is_null(Input::get('notify')) ? 0 : Input::get('notify');
        foreach ($orderIds as $id) {
            if ($id > 0) {
                // send mail after updating order status
                $orderUser = Order::find($id);
                $orderUser->order_status = $orderStatus;
                $orderUser->remark = $remark;
                $orderUser->update();
                $statusHistory = ['order_id' => $id, 'status_id' => $orderStatus, 'remark' => $remark, 'notify' => $notify, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')];
                OrderStatusHistory::insert($statusHistory);
                $orderid = $orderUser->id;
                // $path = Config("constants.adminStorePath") . "/storeSetting.json";
                // $str = file_get_contents($path);
                $logoPath = @asset(Config("constants.logoUploadImgPath") . 'logo.png');
                // $settings = json_decode($str, true);
                $settings = Helper::getSettings();
                $webUrl = $_SERVER['SERVER_NAME'];
                if ($orderStatus == 8) {
                    //delay order
                    $name = $orderUser->users['firstname'];
                    $email_id = $orderUser->users['email'];
                    //$data = array('orderUser' => $orderUser);
                    if ($notify == 1 && $this->getEmailStatus == 1 && $email_id != '') {
                        $emailContent = EmailTemplate::where('url_key', 'delay-in-shipment')->select('content', 'subject')->get()->toArray();
                        $email_template = $emailContent[0]['content'];
                        $subject = $emailContent[0]['subject'];
                        $replace = array("[firstName]", "[logoPath]", "[web_url]", "[primary_color]", "[secondary_color]", "[storeName]", "[orderId]");
                        $replacewith = array($name, $logoPath, $webUrl, $settings['primary_color'], $settings['secondary_color'], $settings['storeName'], $orderid);
                        $email_templates = str_replace($replace, $replacewith, $email_template);
                        $data1 = ['email_template' => $email_templates];
                        Helper::sendMyEmail(Config('constants.adminEmails') . '.regret_email', $data1, $subject, Config::get('mail.from.address'), Config::get('mail.from.name'), $email_id, $name);
                    }
                    $msgS = "Hey, this is to inform you that we're facing a slight delay with your order & we're doing our best to get it to you as soon as possible. Have a soulful day!";
                    echo Helper::sendSMS($orderUser->users['telephone'], $msgS);
                } elseif ($orderStatus == 9) {
                    //Partially shipped mail
                    $name = $orderUser->users['firstname'];
                    $email_id = $orderUser->users['email'];
                    if ($notify == 1 && $this->getEmailStatus == 1 && $email_id != '') {
                        $emailContent = EmailTemplate::where('url_key', 'partial-shipping')->select('content', 'subject')->get()->toArray();
                        $email_template = $emailContent[0]['content'];
                        $subject = $emailContent[0]['subject'];
                        $tableContant = Helper::getEmailInvoice($orderid);
                        $replace = array("[firstName]", "[logoPath]", "[web_url]", "[primary_color]", "[secondary_color]", "[storeName]", "[orderId]", "[invoice]");
                        $replacewith = array($name, $logoPath, $webUrl, $settings['primary_color'], $settings['secondary_color'], $settings['storeName'], $orderid, $tableContant);
                        $email_templates = str_replace($replace, $replacewith, $email_template);
                        $data1 = ['email_template' => $email_templates];
                        Helper::sendMyEmail(Config('constants.adminEmails') . '.email_by_remplate', $data1, $subject, Config::get('mail.from.address'), Config::get('mail.from.name'), $email_id, $name);
                    }
                } elseif ($orderStatus == 7) {
                    //Undelivered mail
                    $name = $orderUser->users['firstname'];
                    $email_id = $orderUser->users['email'];
                    if ($notify == 1 && $this->getEmailStatus == 1 && $email_id != '') {
                        $emailContent = EmailTemplate::where('url_key', 'undelivered')->select('content', 'subject')->get()->toArray();
                        $email_template = $emailContent[0]['content'];
                        $subject = $emailContent[0]['subject'];
                        $tableContant = Helper::getEmailInvoice($orderid);
                        $replace = array("[firstName]", "[logoPath]", "[web_url]", "[primary_color]", "[secondary_color]", "[storeName]", "[orderId]", "[invoice]");
                        $replacewith = array($name, $logoPath, $webUrl, $settings['primary_color'], $settings['secondary_color'], $settings['storeName'], $orderid, $tableContant);
                        $email_templates = str_replace($replace, $replacewith, $email_template);
                        $data1 = ['email_template' => $email_templates];
                        Helper::sendMyEmail(Config('constants.adminEmails') . '.email_by_remplate', $data1, $subject, Config::get('mail.from.address'), Config::get('mail.from.name'), $email_id, $name);
                    }
                } elseif ($orderStatus == 6) {
                    //Returned mail
                    $rewardPtUpdate = Order::find($id);
                    $rewardPtUpdate->cashback_earned = 0;
                    $rewardPtUpdate->cashback_credited = 0;
                    $rewardPtUpdate->Update();
                    $name = $orderUser->users['firstname'];
                    $email_id = $orderUser->users['email'];
                    if ($notify == 1 && $this->getEmailStatus == 1 && $email_id != '') {
                        $emailContent = EmailTemplate::where('url_key', 'return-order')->select('content', 'subject')->get()->toArray();
                        $email_template = $emailContent[0]['content'];
                        $subject = $emailContent[0]['subject'];
                        $tableContant = Helper::getEmailInvoice($orderid);
                        $replace = array("[firstName]", "[logoPath]", "[web_url]", "[primary_color]", "[secondary_color]", "[storeName]", "[orderId]", "[invoice]");
                        $replacewith = array($name, $logoPath, $webUrl, $settings['primary_color'], $settings['secondary_color'], $settings['storeName'], $orderid, $tableContant);
                        $email_templates = str_replace($replace, $replacewith, $email_template);
                        $data1 = ['email_template' => $email_templates];
                        Helper::sendMyEmail(Config('constants.adminEmails') . '.email_by_remplate', $data1, $subject, Config::get('mail.from.address'), Config::get('mail.from.name'), $email_id, $name);
                    }
                    $this->updateQty($id);
                } elseif ($orderStatus == 5) {
                    // Exchanged mail
                    $name = $orderUser->users['firstname'];
                    $email_id = $orderUser->users['email'];
                    if ($notify == 1 && $this->getEmailStatus == 1 && $email_id != '') {
                        $emailContent = EmailTemplate::where('url_key', 'exchange-order')->select('content', 'subject')->get()->toArray();
                        $email_template = $emailContent[0]['content'];
                        $subject = $emailContent[0]['subject'];
                        $tableContant = Helper::getEmailInvoice($orderid);
                        $replace = array("[firstName]", "[logoPath]", "[web_url]", "[primary_color]", "[secondary_color]", "[storeName]", "[orderId]", "[invoice]");
                        $replacewith = array($name, $logoPath, $webUrl, $settings['primary_color'], $settings['secondary_color'], $settings['storeName'], $orderid, $tableContant);
                        $email_templates = str_replace($replace, $replacewith, $email_template);
                        $data1 = ['email_template' => $email_templates];
                        Helper::sendMyEmail(Config('constants.adminEmails') . '.email_by_remplate', $data1, $subject, Config::get('mail.from.address'), Config::get('mail.from.name'), $email_id, $name);
                    }
                } elseif ($orderStatus == 4) {
                    /* Order history */
                    if ($orderUser->cashback_used != 0) {
                        $userUsedCashback = User::find($orderUser->user_id);
                        $userUsedCashback->cashback = $userUsedCashback->cashback + $orderUser->cashback_used;
                        $userUsedCashback->update();
                        $odUpdate = Order::find($id);
                        $odUpdate->cashback_used = 0;
                        $odUpdate->update();
                    }

                    $name = $orderUser->users['firstname'];
                    $email_id = $orderUser->users['email'];
                    if ($notify == 1 && $this->getEmailStatus == 1 && $email_id != '') {
                        $emailContent = EmailTemplate::where('url_key', 'cancel-order')->select('content', 'subject')->get()->toArray();
                        $email_template = $emailContent[0]['content'];
                        $subject = $emailContent[0]['subject'];
                        $tableContant = Helper::getEmailInvoice($orderid);
                        $replace = array("[firstName]", "[logoPath]", "[web_url]", "[primary_color]", "[secondary_color]", "[storeName]", "[orderId]", "[invoice]");
                        $replacewith = array($name, $logoPath, $webUrl, $settings['primary_color'], $settings['secondary_color'], $settings['storeName'], $orderid, $tableContant);
                        $email_templates = str_replace($replace, $replacewith, $email_template);
                        $data1 = ['email_template' => $email_templates];
                        Helper::sendMyEmail(Config('constants.adminEmails') . '.email_by_remplate', $data1, $subject, Config::get('mail.from.address'), Config::get('mail.from.name'), $email_id, $name);
                    }
                    $this->updateQty($id);
                } elseif ($orderStatus == 10) {
                    //Refunded mail
                    $name = $orderUser->users['firstname'];
                    $email_id = $orderUser->users['email'];
                    if ($notify == 1 && $this->getEmailStatus == 1 && $email_id != '') {
                        $emailContent = EmailTemplate::where('url_key', 'refund-order')->select('content', 'subject')->get()->toArray();
                        $email_template = $emailContent[0]['content'];
                        $subject = $emailContent[0]['subject'];
                        $tableContant = Helper::getEmailInvoice($orderid);
                        $replace = array("[firstName]", "[logoPath]", "[web_url]", "[primary_color]", "[secondary_color]", "[storeName]", "[orderId]", "[invoice]");
                        $replacewith = array($name, $logoPath, $webUrl, $settings['primary_color'], $settings['secondary_color'], $settings['storeName'], $orderid, $tableContant);
                        $email_templates = str_replace($replace, $replacewith, $email_template);
                        $data1 = ['email_template' => $email_templates];
                        Helper::sendMyEmail(Config('constants.adminEmails') . '.email_by_remplate', $data1, $subject, Config::get('mail.from.address'), Config::get('mail.from.name'), $email_id, $name);
                    }
                } elseif ($orderStatus == 3) {
                    /* Order history */
                    if ($orderUser->users['telephone']) {
                        $msgOrderSucc = "Your order from " . $settings['storeName'] . " with id " . $orderid . " is delivered successfully. Happy Shopping!";
                        Helper::sendsms($orderUser->users['telephone'], $msgOrderSucc, $orderUser->users['country_code']);
                    }

                    $name = $orderUser->users['firstname'];
                    $email_id = $orderUser->users['email'];
                    if ($notify == 1 && $this->getEmailStatus == 1 && $email_id != '') {
                        $emailContent = EmailTemplate::where('url_key', 'deliver-order')->select('content', 'subject')->get()->toArray();
                        $email_template = $emailContent[0]['content'];
                        $subject = $emailContent[0]['subject'];
                        $tableContant = Helper::getEmailInvoice($orderid);
                        $replace = array("[firstName]", "[logoPath]", "[web_url]", "[primary_color]", "[secondary_color]", "[storeName]", "[orderId]", "[invoice]");
                        $replacewith = array($name, $logoPath, $webUrl, $settings['primary_color'], $settings['secondary_color'], $settings['storeName'], $orderid, $tableContant);

                        $email_templates = str_replace($replace, $replacewith, $email_template);
                        $data1 = ['email_template' => $email_templates];
                        Helper::sendMyEmail(Config('constants.adminEmails') . '.email_by_remplate', $data1, $subject, Config::get('mail.from.address'), Config::get('mail.from.name'), $email_id, $name);
                    }
                } elseif ($orderStatus == 2) {
                    if (!empty(Input::get('commentChanges'))) {
                        $this->updateOrderHistory($id, $orderStatus, $remark, $notify);
                    }

                    //Shipped mail
                    $this->sendShippedMail($id, $notify);
                }
                if ($orderStatus != 2) {
                    if (!empty(Input::get('commentChanges'))) {
                        $this->updateOrderHistory($id, $orderStatus, $remark, $notify);
                    }
                }
                Session::flash("message", "Order status updated successfully.");
            }
        }
        if (Input::get('responseType') && Input::get('responseType') == 'json') {
            return ['status' => 1, 'msg' => 'Order status updated successfully.'];
        }
        return redirect()->route('admin.orders.view');
    }

    public function updateOrderHistory($id, $orderStatus, $remark, $notify)
    {
        /* Order history */
        //        $commentChk = new Comment();
        //        $commentChk->order_id = $id;
        //        $commentChk->status_id = $orderStatus;
        //        $commentChk->comment = $remark;
        //        $commentChk->notify = is_null($notify) ? 0 : $notify;
        //        $commentChk->save();
        $statusHistory = ['order_id' => $id, 'status_id' => $orderStatus, 'remark' => $remark, 'notify' => $notify, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')];
        OrderStatusHistory::insert($statusHistory);
    }

    public function updatePaymentStatus()
    {
        $orderIds = explode(",", Input::get('OrderIds'));
        foreach ($orderIds as $id) {
            $order = Order::find($id);
            $order->payment_status = Input::get("status");
            $order->update();
        }
        Session::flash("message", "Order Payment Status Updated Successfully!");
        return redirect()->route('admin.orders.view');
    }

    public function sendShippedMail($id, $notify)
    {
        $order = Order::find($id);
        $saveOrder = Order::find($id);
        $saveOrder->order_status = 2;
        $saveOrder->ship_date = date("Y-m-d");
        if ($saveOrder->Update()) {
            $path = Config("constants.adminStorePath") . "/storeSetting.json";
            $str = file_get_contents($path);
            $logoPath = @asset(Config("constants.logoUploadImgPath") . 'logo.png');
            $settings = json_decode($str, true);
            $webUrl = $_SERVER['SERVER_NAME'];
            $name = $order->users['firstname'];
            $email_id = $order->users['email'];
            if ($notify == 1) {
                $emailContent = EmailTemplate::where('url_key', 'order-shipped')->select('content', 'subject')->get()->toArray();
                $email_template = $emailContent[0]['content'];
                $subject = $emailContent[0]['subject'];
                $tableContant = Helper::getEmailInvoice($order->id);
                $replace = array("[firstName]", "[logoPath]", "[web_url]", "[primary_color]", "[secondary_color]", "[storeName]", "[orderId]", "[invoice]");
                $replacewith = array($name, $logoPath, $webUrl, $settings['primary_color'], $settings['secondary_color'], $settings['storeName'], $order->id, $tableContant);
                $email_templates = str_replace($replace, $replacewith, $email_template);
                $data1 = ['email_template' => $email_templates];
                Helper::sendMyEmail(Config('constants.adminEmails') . '.email_by_remplate', $data1, $subject, Config::get('mail.from.address'), Config::get('mail.from.name'), $email_id, $name);
            }

            //            $msgS = "Hey! Your order has been dispatched from our warehouse. Your tracking details have been mailed to you. So sit tight. Your goodies will be with you shortly.";
            //            Helper::sendSMS($order->users['telephone'], $msgS);
        }
    }

    public function searchUser()
    {
        if ($_GET['term'] != "") {
            $data = User::where("email", "like", "%" . $_GET['term'] . "%")
                ->select(DB::raw('id, email'))
                ->get();
        } else {
            $data = "";
        }

        echo json_encode($data);
    }

    public function updateQty($id)
    {
        $order = Order::find($id);
        $cartContent = json_decode($order->cart);
        foreach ($cartContent as $cart) {
            //if ($cart->options->is_crowd_funded == 0) {
            if (!empty($cart->options->sub_prod)) {
                $prd = Product::find($cart->options->sub_prod);
                $prd->stock = $prd->stock + $cart->qty;
                $prd->update();
            } else if (!empty($cart->options->combos)) {
                foreach ($cart->options->combos as $key => $val) {
                    if (isset($val->sub_prod)) {

                        $prd = Product::find($val->sub_prod);
                        $prd->stock = $prd->stock + $cart->qty;
                        $prd->update();
                    } else {
                        $prd = Product::find($key);
                        $prd->stock = $prd->stock + $cart->qty;
                        $prd->update();
                    }
                }
            } else {
                $prd = Product::find($cart->id);
                $prd->stock = $prd->stock + $cart->qty;
                $prd->update();
            }
            // }
        }
    }

    public function addOrderFlag()
    {
        $orderid = Input::get('ord_id');
        $flagid = Input::get('flagid');
        $flag_remark = Input::get('flag_remark');
        $ordUpdate = Order::find($orderid);
        $ordUpdate->flag_id = $flagid;
        $ordUpdate->flag_remark = $flag_remark;
        $ordUpdate->update();
        $flagHistory = ['order_id' => $orderid, 'flag_id' => $flagid, 'remark' => $flag_remark, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')];
        OrderFlagHistory::insert($flagHistory);
        $getColor = Flags::find($flagid);
        $fName = $getColor->flag;
        if (strpos($getColor->flag, 'No Flag') !== false) {
            $fName = "";
        } else {
            $fName = $getColor->flag;
        }
        $data = ['flag' => $fName, 'value' => $getColor->value, 'remark' => $ordUpdate->flag_remark];
        return $data;
    }

    public function addMulFlag()
    {
        $orderids = explode(",", Input::get('ord_id'));
        $flag_remark = Input::get('flag_remark');
        $flagid = Input::get('flagid');
        $flagHistory = [];
        foreach ($orderids as $ordid) {
            $ordUpdate = Order::find($ordid);
            $ordUpdate->flag_id = $flagid;
            $ordUpdate->flag_remark = $flag_remark;
            $ordUpdate->update();
            array_push($flagHistory, array('order_id' => $ordid, 'flag_id' => $flagid, 'remark' => $flag_remark, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')));
        }
        OrderFlagHistory::insert($flagHistory);
        return redirect()->back();
    }

    public function orderHistory()
    {
        $order = Order::find(Input::get('id'));
        $orderStatusHistory = $order->orderStatHist()->orderBy('created_at', 'DESC')->get();
        $flags = $order->orderFlagHist()->get();
        $orderHistory = $order->orderHistory;
        return view(Config('constants.adminOrderView') . '.orderHistory', compact('order', 'orderStatusHistory', 'flags', 'orderHistory'));
    }

    public function return_order($id)
    {
        $order = HasProducts::where('order_id', $id)->get()->toArray();
        $returnp = ReturnOrder::where('order_id', $id)->get()->toArray();
        $orderid = $order_id = $output = [];
        foreach ($order as $o) {
            $orderid[$o['sub_prod_id']]['order_id'] = $o['order_id'];
            $orderid[$o['sub_prod_id']]['prod_id'] = $o['sub_prod_id'];
            $orderid[$o['sub_prod_id']]['qty'] = $o['qty'];
            $orderid[$o['sub_prod_id']]['price'] = $o['price'];
            $orderid[$o['sub_prod_id']]['amt_after_discount'] = $o['amt_after_discount'];
            $p = json_decode($o['product_details']);
            $orderid[$o['sub_prod_id']]['product_name'] = $p->name;
            $orderid[$o['sub_prod_id']]['product_price'] = $p->price;
            $orderid[$o['sub_prod_id']]['subtotal'] = $p->subtotal;
            $orderid[$o['sub_prod_id']]['prod_type'] = $o['prod_type'];
            $orderid[$o['sub_prod_id']]['created_at'] = $o['created_at'];
        }
        foreach ($returnp as $o) {
            if (array_key_exists($o['product_id'], $order_id)) {
                $order_id[$o['product_id']]['quantity'] = $o['quantity'] + $order_id[$o['product_id']]['quantity'];
                $order_id[$o['product_id']]['return_amount'] = $o['return_amount'] + $order_id[$o['product_id']]['return_amount'];
            } else {
                $order_id[$o['product_id']]['quantity'] = $o['quantity'];
                $order_id[$o['product_id']]['return_amount'] = $o['return_amount'];
            }
        }

        foreach ($orderid as $pid => $ro) {
            $return_quantity = $return_amt = 0;
            $output[$pid]['order_id'] = $ro['order_id'];
            $output[$pid]['product_id'] = $pid;
            $output[$pid]['orderQty'] = $ro['qty'];
            $output[$pid]['price'] = $ro['price'];
            $output[$pid]['product_price'] = $ro['product_price'];
            $output[$pid]['amt_after_discount'] = $ro['amt_after_discount'];
            $output[$pid]['product_name'] = $ro['product_name'];
            $output[$pid]['subtotal'] = $ro['subtotal'];
            $output[$pid]['prod_type'] = $ro['prod_type'];
            $output[$pid]['created_at'] = $ro['created_at'];
            $output[$pid]['prod_type'] = $ro['prod_type'];
            if (isset($order_id[$pid]['quantity']) && isset($order_id[$pid]['return_amount'])) {
                $return_quantity = $order_id[$pid]['quantity'];
                $return_amt = $order_id[$pid]['return_amount'];
            }
            $output[$pid]['return_quantity'] = $return_quantity;
            $output[$pid]['return_amount'] = $return_amt;
        }
        //        echo "<pre>";
        //        print_r($output);
        //        die;
        $action = route("admin.orders.save");
        return view(Config('constants.adminOrderView') . '.returnorder', compact('output', 'action'));
    }

    public function return_order_cal()
    {
        $orderId = Input::get('orderId');
        if (count(Input::get('pr')) > 0) {
            $sum = array_sum(array_column(Input::get('pr'), 'returnqty'));
            if ($sum > 0) {
                $order = Order::find($orderId);
                $order->order_status = 11;
                $order->save();
            }
            foreach (Input::get('pr') as $pid => $return_qnty) {
                if ($return_qnty['returnqty'] > 0) {
                    $return = new ReturnOrder();
                    $return->order_id = $orderId;
                    $return->product_id = $pid;
                    $return->quantity = $return_qnty['returnqty'];
                    $return->return_amount = $return_qnty['returnamt'];
                    $return->reason_id = 18;
                    $return->opened_id = 2;
                    $return->return_status = 4;
                    $return->save();
                }
            }
        }
    }

    public function order_return()
    {
        // $return = ReturnOrder::with('reason', 'opened', 'product_id', 'order_id', 'return_status_id')->with(['order_id' => function($q) {
        //                 $q->with('user');
        //             }])->where("store_id", $this->jsonString['store_id'])->orderBy('id', 'desc')->get()->toArray();
        // return view(Config('constants.adminOrderView') . '.returnOrders', compact('return'));
        $return = ReturnOrder::with('reason', 'opened', 'product_id', 'order_id', 'return_status_id')->with(['order_id' => function ($q) {
            $q->with('user');
        }])->where("store_id", $this->jsonString['store_id'])->orderBy('id', 'desc');

        if (!empty(Input::get('order_ids'))) {
            $mulIds = explode(",", Input::get('order_ids'));
            $return = $return->whereIn("order_id", $mulIds);
        }
        if (!empty(Input::get('order_number_from'))) {
            $return = $return->where('order_id', '>=', Input::get('order_number_from'));
        }
        if (!empty(Input::get('order_number_to'))) {
            $return = $return->where('order_id', '<=', Input::get('order_number_to'));
        }
        if (!empty(Input::get('search'))) {
            //get user id
            $users = User::whereRaw("(CONCAT(firstname,' ',lastname) like ?)", ['%' . Input::get('search') . '%'])->orwhere('email', "like", "%" . Input::get('search') . "%")->orwhere('telephone', "like", "%" . Input::get('search') . "%")->select('id')->get()->toArray();

            if (!empty($users)) {
                $return = $return->whereIn('orders.user_id', $users);
            }
        }
        $return = $return->get()->toArray();
        return view(Config('constants.adminOrderView') . '.returnOrders', compact('return'));
    }

    public function editorder_return($id)
    {
        $return = ReturnOrder::with('reason', 'opened', 'product_id', 'order_id', 'exchangeProduct')->with(['order_id' => function ($r) {
            $r->with('country', 'zone');
        }])->where('id', $id)->get()->toArray();

        $return_status = OrderReturnStatus::all();
        $returnStatus = [];

        foreach ($return_status as $value) {
            $returnStatus[$value->id] = $value->status;
        }
        return view(Config('constants.adminOrderView') . '.editreturnorder', compact('return', 'returnStatus'));
    }

    public function update_return_order_status()
    {
        $checkStockEnabled = GeneralSetting::where('url_key', 'stock')->where('is_active', 1)->get();
        $returnorder = ReturnOrder::find(Input::get('id'));

        $returnorder->return_status = Input::get('return_status');
        $returnorder->save();
        if (Input::get('return_status') == 2) {
            $orderProduct = HasProducts::where('order_id', $returnorder->order_id)->where('prod_id', $returnorder->product_id);
            if ($returnorder->exchange_product_id == 0):
                $qtyUpdate = ['qty_returned' => $returnorder->quantity];
            else:
                $qtyUpdate = ['qty_exchange' => $returnorder->quantity];
            endif;
            $orderProduct->update($qtyUpdate);
            $returnstatus = ReturnOrder::where('order_id', $returnorder->order_id)->where('return_status', '!=', 2)->count();

            $order = Order::find($returnorder->order_id);
            if ($returnorder->exchange_product_id == 0):
                $order->cashback_credited = $order->cashback_credited + ($returnorder->return_amount * $returnorder->quantity);
                if ($returnstatus == 0) {
                    // $order->order_status = 1;
                }
            endif;
            $order->save();
            if ($returnorder->exchange_product_id == 0):
                $uid = @$order->user_id;
                $ammount = @$returnorder->return_amount;
                $quantity = @$returnorder->quantity;
                $this->updateUserCashback($uid, $ammount, $quantity);
            endif;
            $product = Product::find($returnorder->product_id);
            if (count($checkStockEnabled) != 0 && $product->is_stock == 1):
                $product = Product::find($returnorder->sub_prod);
                $product->stock = $product->stock + $returnorder->quantity;
                $product->save(); //91
                if (isset($returnorder->exchange_product_id) && $returnorder->exchange_product_id != 0):
                    $configProduct = Product::find($returnorder->exchange_product_id);
                    $configProduct->stock = $configProduct->stock - $returnorder->quantity;
                    $configProduct->save(); //91
                endif;
            endif;
            $cashbackhistory = new OrderReturnCashbackHistory;
            $cashbackhistory->return_order_id = Input::get('id');
            $cashbackhistory->cashback = $returnorder->return_amount * $returnorder->quantity;
            $cashbackhistory->qty = $returnorder->quantity;
            $cashbackhistory->save();
            //  $this->sendReturnOrderMail($returnorder);
            echo 3;
        } else {
            echo "Status Updated";
        }
        return redirect()->route('admin.orders.OrderReturn')->with('message', "Return status updated successfully.");
    }

    public function sendReturnOrderMail($returnorder)
    {
        //  $path = Config("constants.adminStorePath") . "/storeSetting.json";
        // $str = file_get_contents($path);
        $order = Order::find($returnorder->order_id);
        $logoPath = @asset(Config("constants.logoUploadImgPath") . 'logo.png');
        $settings = Helper::getSettings();

        $webUrl = $_SERVER['SERVER_NAME'];

        $name = "pradeep";
        $email_id = "pradeep@infiniteit.biz";
        if ($returnorder->order_status == 3) {
            $emailContent = EmailTemplate::where('url_key', 'exchange-order')->select('content', 'subject')->get()->toArray();
        } else if ($returnorder->order_status == 2) {
            $emailContent = EmailTemplate::where('url_key', 'refund-order')->select('content', 'subject')->get()->toArray();
        }
        $email_template = $emailContent[0]['content'];
        $subject = $emailContent[0]['subject'];
        $tableContant = Helper::getEmailInvoice($orderid);

        $replace = array("[firstName]", "[logoPath]", "[web_url]", "[primary_color]", "[secondary_color]", "[storeName]", "[orderId]", "[invoice]");
        $replacewith = array($name, $logoPath, $webUrl, $settings['primary_color'], $settings['secondary_color'], $settings['storeName'], $orderid, $tableContant);

        $email_templates = str_replace($replace, $replacewith, $email_template);
        $data1 = ['email_template' => $email_templates];
        Helper::sendMyEmail(Config('constants.adminEmails') . '.email_by_remplate', $data1, $subject, Config::get('mail.from.address'), Config::get('mail.from.name'), $email_id, $name);
    }

    public function updateUserCashback($uid, $ammount, $quantity)
    {
        $usercashback = HasCashbackLoyalty::where("user_id", $uid)->where("store_id", $this->jsonString['store_id'])->first();
        if (count($usercashback) > 0) {
            $usercashback->cashback = $usercashback->cashback + ($ammount * $quantity);
            $usercashback->save();
        } else {
            $usercashback = new HasCashbackLoyalty;
            $usercashback->user_id = $data->uid;
            $usercashback->store_id = $this->jsonString['store_id'];
            $usercashback->cashback = round(($ammount * $quantity), 2);
            $usercashback->loyalty_group = 1;
            $usercashback->save();
        }
    }

    public function exportsamplecsv()
    {

        $order_data = [];
        array_push($order_data, ['Order Id', 'Name', 'Email', 'Address', 'City', 'State', 'Country',
            'Pincode', 'Product Name', 'Product Category', 'Product Variant', 'Product Qty', 'Product Price', 'Mobile No', 'Order Status',
            'Payment Method', 'Payment Status', 'Order Status',
            'Order Amt', 'Cod Charges',
            'Gifting Charges', 'Reward Points Used',
            'Shipping Amt',
            'Coupon Discount', 'Voucher Discount', 'Final Amount', 'Order Comments', 'Order Date']);
        $details = ['1', 'Stefen', 'stefen@gmail.com', 'Cecilia Chapman 711-2880 Nulla St. Mankato Mississippi 96522', 'Mystic Falls', 'Paris', 'London', '203456', 'Veg Pizza', 'Pizza', '', '2', '500', '9878765678', '', 'COD', 'Pending', '', '1000', '25', '0', '0', '0', '0', '0', '1025', '', '30/04/1986'];
        array_push($order_data, $details);
        return Helper::getCsv($order_data, 'order-sample.csv', ',');
    }

    public function export()
    {
        $orderIds = explode(",", Input::get('OrderIds'));
        if (Input::get('OrderIds')) {
            $orders_data = Order::with('users', 'country', 'zone')->with('paymentmethod')->with('paymentstatus')->with('orderstatus')->where('store_id', Session::get('store_id'))->whereIn("id", $orderIds)->orderBy("id", "desc")->get()->toArray();
        } else {
            $orders_data = Order::with('users', 'country', 'zone')->with('paymentmethod')->with('paymentstatus')->with('orderstatus')->where('store_id', Session::get('store_id'))->where("order_status", '!=', 0)->orderBy("id", "desc")->get()->toArray();
        }
        $orders = [];
        $details = ['Order Id', 'Name', 'Email', 'Address', 'City', 'State', 'Country',
            'Pincode', 'Product Name', 'Product Category', 'Product Variant', 'Product Qty', 'Product Price', 'Mobile No', 'Order Status',
            'Payment Method', 'Payment Status', 'Order Status',
            'Order Amt', 'Cod Charges',
            'Gifting Charges', 'Reward Points Used',
            'Shipping Amt',
            'Coupon Discount', 'Voucher Discount', 'Final Amount', 'Order Comments', 'Order Date'];
        array_push($orders, $details);
        foreach ($orders_data as $order) {
            $cart = json_decode($order['cart'], true);
            //   $prodnames = [];
            foreach ($cart as $cart_prods) {
                $optVal1 = "";
                if (isset($cart_prods['options']['options'])) {
                    foreach ($cart_prods['options']['options'] as $opt => $optVal) {
                        $optVal1 = $opt . ":-" . $optVal;
                    }
                }
                $categoryProd = @Category::find($cart_prods['options']['cats'][0])->category;
                $details = [$order['id'],
                    $order['users']['firstname'] . " " . $order['users']['lastname'],
                    $order['users']['email'],
                    @$order['address1'] . "" .
                    @$order['address2'] . "" .
                    @$order['address3'],
                    @$order['city'],
                    @$order['zone']['name'],
                    @$order['country']['name'],
                    @$order['postal_code'],
                    $cart_prods['name'],
                    $categoryProd,
                    @$optVal1,
                    $cart_prods['qty'],
                    number_format($cart_prods['price'] * Session::get('currency_val'), 2),
                    //  $order['users']['telephone'],
                    @$order['phone_no'],
                    $order['orderstatus']['order_status'],
                    $order['paymentmethod']['name'],
                    $order['paymentstatus']['payment_status'],
                    $order['orderstatus']['order_status'],
                    number_format($order['order_amt'] * Session::get('currency_val'), 2),
                    number_format(@$order['cod_charges'] * Session::get('currency_val'), 2),
                    number_format(@$order['gifting_charges'] * Session::get('currency_val'), 2),
                    number_format(@$order['cashback_used'] * Session::get('currency_val'), 2),
                    number_format(@$order['shipping_amt'] * Session::get('currency_val'), 2),
                    number_format(@$order['coupon_amt_used'] * Session::get('currency_val'), 2),
                    @$order['voucher_amt_used'],
                    //  $order['shipping_amt'],
                    number_format($order['pay_amt'] * Session::get('currency_val'), 2),
                    $order['description'],
                    date("d-M-Y", strtotime($order['created_at'])),
                ];
                array_push($orders, $details);
            }
        }
        $nameFile = "order" . date('ymd');
        //dd($orders);
        return $this->convert_to_csv($orders, $nameFile . '_export.csv', ',');
    }

    public function convert_to_csv($input_array, $output_file_name, $delimiter)
    {
        $temp_memory = fopen('php://memory', 'w');
        foreach ($input_array as $line) {
            fputcsv($temp_memory, $line, $delimiter);
        }
        fseek($temp_memory, 0);
        header('Content-Type: application/csv');
        header('Content-Disposition: attachement; filename="' . $output_file_name . '";');
        fpassthru($temp_memory);
    }

    public function get_prod_details()
    {
        $parent_prod = '';
        $product = Product::where('id', Input::get('id'))->select('id', 'stock', 'price', 'spl_price', 'selling_price', 'prod_type', 'parent_prod_id')->get()->toArray();
        if ($product[0]['stock'] > 0) {
            if ($product[0]['parent_prod_id'] != 0) {
                $parent_product = Product::where('id', $product[0]['parent_prod_id'])->select('id', 'price', 'prod_type')->get()->toArray();
                $price = $product[0]['price'] + $parent_product[0]['price'];
                $product_type = $parent_product[0]['prod_type'];
            } else {
                $product_type = $product[0]['prod_type'];
                $price = $product[0]['spl_price'];
                if ($product[0]['spl_price'] == 0.00) {
                    $price = $product[0]['selling_price'];
                }
            }
            $parent_prod = $product[0]['parent_prod_id'];
            echo json_encode(['err' => 1, 'price' => $price, 'pid' => $product[0]['id'], 'product_type' => $product_type, 'stock' => $product[0]['stock'], 'parent_prod' => $parent_prod]);
        } else {
            echo json_encode(['err' => 0]);
        }
    }

    public function quantityUpdate()
    {
        $product = Product::where('id', Input::get('id'))->select('id', 'price', 'stock', 'prod_type', 'parent_prod_id', 'spl_price', 'selling_price')->get()->toArray();
        if ($product[0]['stock'] < Input::get('stock')) {
            if ($product[0]['parent_prod_id'] != 0) {
                $parent_product = Product::where('id', $product[0]['parent_prod_id'])->select('id', 'price')->get()->toArray();
                $price = $product[0]['price'] + $parent_product[0]['price'];
            } else {
                $price = $product[0]['spl_price'];
                if ($product[0]['spl_price'] == 0.00) {
                    $price = $product[0]['selling_price'];
                }
            }
            $price_send = $product[0]['stock'] * $price;
            echo json_encode(['err' => 0, 'stock' => $product[0]['stock'], 'type' => Input::get('type'), 'price' => $price_send]);
        } else {
            if ($product[0]['parent_prod_id'] != 0) {
                $parent_product = Product::where('id', $product[0]['parent_prod_id'])->select('id', 'price')->get()->toArray();
                $price = $product[0]['price'] + $parent_product[0]['price'];
            } else {
                $price = $product[0]['spl_price'];
                if ($product[0]['spl_price'] == 0.00) {
                    $price = $product[0]['selling_price'];
                }
            }
            $price_send = Input::get('stock') * $price;
            echo json_encode(['err' => 1, 'price' => $price_send, 'pid' => $product[0]['id'], 'stock' => $product[0]['stock'], 'type' => Input::get('type')]);
        }
    }

    public function add_to_cart($prod_type, $prod_id, $sub_prod, $quantity)
    {

        if ($prod_id == 0) {
            $prod_id = $sub_prod;
        }
        switch ($prod_type) {
            case 1:
                $this->simpleProduct($prod_id, $quantity);
                break;
            case 2:
                $this->comboProduct($prod_id, $quantity, $sub_prod);
                break;
            case 3:
                $this->configProduct($prod_id, $quantity, $sub_prod);
                break;
            case 5:
                $this->simpleProduct($prod_id, $quantity);
                break;
            default:
        }
    }

    public function edit_cart()
    {
        Cart::instance('shopping')->update(Input::get("rowid"), ['qty' => Input::get("qty")]);
    }

    public function delete_cart()
    {
        Cart::instance('shopping')->remove(Input::get("rowid"));
        Session::put("pay_amt", Cart::instance('shopping')->total());
    }

    public function edit_re_order()
    {
        Session::forget('cart');
        $order = Order::find(Input::get('id'));
        // $this->add_cart_custom(json_decode($order->cart));
        $product_all = Product::select('id', 'product', 'parent_prod_id')->get()->toArray();
        $address = Address::where('user_id', $order->user_id)->with('country', 'zone')->get();
        $payment_method = PaymentMethod::get()->toArray();
        $payment_methods = [];
        foreach ($payment_method as $val) {
            $payment_methods[$val['id']] = $val['name'];
        }
        $payment_stuatusA = PaymentStatus::get()->toArray();
        $payment_status = [];
        foreach ($payment_stuatusA as $val) {
            $payment_status[$val['id']] = $val['payment_status'];
        }
        $order_stuatusA = OrderStatus::get()->toArray();
        $order_status = [];
        foreach ($order_stuatusA as $val) {
            $order_status[$val['id']] = $val['order_status'];
        }
        $countryA = Country::get()->toArray();
        $countries = [];
        foreach ($countryA as $val) {
            $countries[$val['id']] = $val['name'];
        }
        $zoneA = Zone::get()->toArray();
        $zones = [];
        foreach ($zoneA as $val) {
            $zones[$val['id']] = $val['name'];
        }
        $products = $order->products;
        $coupon = Coupon::find($order->coupon_used);
        $action = route("admin.orders.saveReOrder");
        return view(Config('constants.adminOrderView') . '.editReOrder', compact('order', 'action', 'address', 'payment_methods', 'payment_status', 'order_status', 'countries', 'zones', 'products', 'coupon', 'product_all')); //users
    }

    public function save_re_order()
    {
        $user = User::find(Input::get('user_id'));
        foreach (Input::get('old_product') as $prod) {
            $prod_id = $prod['pid'];
            $sub_prod = $prod['sub'];
            $qty = $prod['qty'];
            $prod_type = $prod['prod_type'];
            if ($prod_type == 3) {
                $prod_id = $sub_prod;
            }
            $prods = Product::find($prod_id);
            $prods->stock = $prods->stock + $qty;
            $prods->save();
        }
        foreach (Input::get('edited_product') as $product) {
            $this->add_to_cart($product['prod_type'], $product['pid'], $product['sub'], $product['qty']);
        }
        $cash_back_amt = $cashback_used = 0;
        if (Input::get('payment_method') != 1) {
            if (Input::get('old_pay_amt') > Input::get('pay_amt')) {
                $cash_back_amt = (Input::get('old_pay_amt') - Input::get('pay_amt')) - Input::get('cod_charges');
                if ($cash_back_amt < 0) {
                    $cash_back_amt = 0;
                }
                $pay_amt = 0;
            } else {
                $cashback_used = Input::get('old_pay_amt');
                $pay_amt = Input::get('pay_amt') - Input::get('old_pay_amt');
            }
        }
        $payment_status = Input::get('payment_status');
        $payment_method = Input::get('payment_method');
        if ($pay_amt > 0) {
            $payment_status = 1;
            $payment_method = 1;
        }

        $order = new Order();
        $order->user_id = $user->id;
        $order->payment_method = $payment_method;
        $order->payment_status = $payment_status;
        $order->cod_charges = Input::get('cod_charges');
        $order->order_status = Input::get('order_status');
        $order->order_amt = Cart::instance('adminshop')->total();
        $order->pay_amt = $pay_amt; // -
        $order->gifting_charges = Input::get('gifting_charges');
        $order->cart = json_encode(Cart::instance('adminshop')->content());
        $order->description = Input::get('description');
        $order->order_comment = Input::get('order_comment');
        $order->shipping_amt = Input::get('shipping_amt');
        $order->shiplabel_tracking_id = Input::get('shiplabel_tracking_id');
        $order->voucher_amt_used = Input::get('voucher_amt_used');
        $order->coupon_amt_used = Input::get('coupon_amt_used');
        $order->cashback_used = $cashback_used;
        $order->cashback_credited = $cash_back_amt;
        $order->referal_code_used = 0;
        $order->referal_code_amt = 0;
        $order->ref_flag = 0;
        $order->user_ref_points = 0;
        $order->order_status = 1;
        $order->forward_id = Input::get('id');
        $order->first_name = Input::get('first_name');
        $order->last_name = Input::get('last_name');
        $order->address1 = Input::get('address1');
        $order->address2 = Input::get('address2');
        $order->address3 = Input::get('address3');
        $order->phone_no = Input::get('phone_no');
        $order->city = Input::get('city');
        $order->country_id = Input::get('country_id');
        $order->zone_id = Input::get('zone_id');
        $order->postal_code = Input::get('postal_code');
        $order->save();
        $order_id = $order->id;
        //echo "<pre>";
        //print_r(json_decode($order));
        //
        //        die;
        foreach (Cart::instance('adminshop')->content() as $order_session) {
            $hasproduct = new HasProducts();
            $hasproduct->order_id = $order_id;
            $hasproduct->prod_id = $order_session->id;
            $hasproduct->sub_prod_id = $order_session->options->sub_prod;
            $hasproduct->qty = $order_session->qty;
            $hasproduct->price = $order_session->subtotal;
            $hasproduct->amt_after_discount = $order_session->subtotal;
            $hasproduct->product_details = json_encode($order_session);
            $hasproduct->prod_type = $order_session->options->prod_type;

            $prd = Product::find($order_session->options->sub_prod);
            $prd->stock = $prd->stock - $order_session->qty;
            $prd->update();
            $hasproduct->save();
        }
        Session::forget('cart');

        $order_update = Order::find(Input::get('id'));
        $order_update->order_status = 4;
        $order_update->save();
        return redirect()->route('admin.orders.invoice', ['OrderIds' => $order_id]);
    }

    public function simpleProduct($prod_id, $quantity)
    {
        $product = Product::find($prod_id);
        $cats = [];
        foreach ($product->categories as $cat) {
            array_push($cats, $cat->id);
        }

        $eNoOfDaysAllowed = $product->eNoOfDaysAllowed;
        $price = $product->selling_price; //$product->price;
        $pname = $product->product;
        $prod_type = $product->prod_type;

        $images = $product->catalogimgs()->where("image_type", "=", 1)->first()->filename;
        if (Helper::checkStock($prod_id, $quantity) == "In Stock") {
            Cart::instance('adminshop')->add(["id" => $prod_id, "name" => $pname, "qty" => $quantity, "price" => $price, "options" => ["prod_type" => $product->prod_type, "image" => $images, "sub_prod" => $prod_id, "is_cod" => $product->is_cod, 'cats' => $cats, 'stock' => $product->stock, "eNoOfDaysAllowed" => $eNoOfDaysAllowed, "prod_type" => $prod_type, "discountedAmount" => $price]]);
        } else {
            return 1;
        }
    }

    public function comboProduct($prod_id, $quantity, $sub_prod)
    {
        $product = Product::find($prod_id);
        if (Helper::checkStock($prod_id, $quantity, $sub_prod) == "In Stock" || $product->is_crowd_funded != 0) {
            $cats = [];
            foreach ($product->categories as $cat) {
                array_push($cats, $cat->id);
            }
            $pname = $product->product;
            //$images = json_decode($product->images, true);
            $images = @$product->catalogimgs()->first()->filename;
            $isShipped = $product->is_shipped_international;
            $isRefDisc = $product->is_referal_discount;
            // $price = $product->selling_price; //($product->spl_price > 0 ? $product->spl_price : $product->price);
            $price = $product->selling_price;
            $prod = [];
            $combos = [];
            foreach ($product->comboproducts as $cmb) {
                //print_r($cmb);
                $prod["name"] = $cmb->product;
                $prod["img"] = Product::find($cmb->id)->catalogimgs()->first()->filename;
                //$combos[] = $prod;
                $combos[$cmb->id]["name"] = $cmb->product;
                $combos[$cmb->id]["img"] = @$cmb->catalogimgs()->first()->filename;
                $prod = [];
                //print_r($sub_prod[$cmb->id]);
                //$price += $cmb->price;
                if (isset($sub_prod[$cmb->id])) {
                    $sub = $cmb->subproducts()->where("id", "=", $sub_prod[$cmb->id])->first();
                    $combos[$cmb->id]["sub_prod"] = $sub->id;
                    //$price += $sub->price;
                    $attributes = $sub->attributes()->where("is_filterable", "=", "1")->get()->toArray();
                    foreach ($attributes as $attr) {
                        $combos[$cmb->id]["options"][$attr["attr"]] = $attr["pivot"]["attr_val"];
                    }
                }
            }
            $image = (!empty($images)) ? $images : "default.jpg";
            Cart::instance('adminshop')->add(["id" => $prod_id, "name" => $pname, "qty" => $quantity, "price" => $price, "options" => ["prod_type" => $product->prod_type, "image" => $image, "sub_prod" => $prod_id, "is_crowd_funded" => $product->is_crowd_funded, "combos" => $combos, "is_cod" => $product->is_cod, 'cats' => $cats, "is_shipped_inter" => $isShipped, "is_ref_disc" => $isRefDisc, 'stock' => $product->stock, "discountedAmount" => $price]]);
        } else {
            return 1;
        }
    }

    public function configProduct($prod_id, $quantity, $sub_prod)
    {
        if (Helper::checkStock($prod_id, $quantity, $sub_prod) == "In Stock") {
            $product = Product::find($sub_prod);
            $product = Product::find($prod_id);
            $cats = [];
            foreach ($product->categories as $cat) {
                array_push($cats, $cat->id);
            }
            $pname = $product->product;
            $images = $product->catalogimgs()->where("image_type", "=", 1)->get()->first()->filename;
            $subProd = Product::where("id", "=", $sub_prod)->first();
            $price = $subProd->price + $product->price;
            $options = [];
            $hasOptn = $subProd->attributes()->withPivot('attr_id', 'prod_id', 'attr_val')->orderBy("att_sort_order", "asc")->get();
            foreach ($hasOptn as $optn) {
                $options[$optn->pivot->attr_id] = $optn->pivot->attr_val;
            }
            $image = isset($images) ? $images : "default.jpg";
            Cart::instance('adminshop')->add(["id" => $prod_id, "name" => $pname,
                "qty" => $quantity, "price" => $price,
                "options" => ["prod_type" => $product->prod_type, "image" => $image, "sub_prod" => $subProd->id,
                    "options" => $options, "is_cod" => $product->is_cod,
                    'cats' => $cats, 'stock' => $product->stock, "discountedAmount" => $price]]);
        } else {
            return 1;
        }
    }

    public function paymentStatus()
    {
        return $data['payment_method'] = PaymentMethod::get()->toArray();
    }

    public function paymentMethod()
    {
        return $data['payment_stuatus'] = PaymentStatus::get()->toArray();
    }

    public function createOrder()
    {
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
        // $validCoupon = DB::select(DB::raw("Select * from " . DB::getTablePrefix() . "coupons where coupon_code = '$couponCode'  and no_times_allowed > $usedCouponCountOrders and min_order_amt <= " . $orderAmount . " and (now() between start_date and end_date)"));
        Cart::instance("shopping")->destroy();
        $coupons = Coupon::whereDate('start_date', '<=', date("Y-m-d"))->where('end_date', '>=', date("Y-m-d"))->get();
        // dd($coupon);

        $viewname = Config('constants.adminOrderView') . '.create-order';
        $ordcountries = Country::where("status", 1)->pluck("name", "id")->prepend("Country", "");
        $ordstates = Zone::where("status", 1)->pluck("name", "id")->prepend("State", "");
        $roots = Category::roots()->where('status', 1)->get();
        $paymentMethods = PaymentMethod::where('show_in_merchant_admin', 1)->orderBy('sort_order')->get(["id", "name"]);
        $data = ['ordstates' => $ordstates, 'ordcountries' => $ordcountries, 'paymentMethods' => $paymentMethods, 'roots' => $roots, 'coupons' => $coupons];
        return Helper::returnView($viewname, $data);
    }

    public function getCustomerEmails()
    {
        $term = Input::get('term');
        $email = Input::get('email');
        if (!empty($term)) {
            $result = User::where(['store_id'=>Session::get('store_id')])
                    ->where('user_type','!=',1)
                    ->orWhere('id',Session::get('loggedin_user_id'))
                    ->where("email", "like", "%$term%")
                    ->where(function($q) use($term) {
                        $q->orWhere("firstname", "like", "%$term%")
                    ->orWhere("lastname", "like", "%$term%")
                    ->orWhere("telephone", "like", "%$term%");
                    })
                    ->get(['id', 'firstname', 'lastname', 'telephone', 'email', 'credit_amt']);
        }
        if (!empty($email)) {
            $result = User::where(['user_type' => 2, 'store_id' => Session::get('store_id'), 'email' => $email])
                ->where('store_id', Session::get('store_id'))
                ->where(function ($q) use ($term) {
                    $q->orWhere("firstname", "like", "%$term%")
                        ->orWhere("lastname", "like", "%$term%")
                        ->orWhere("telephone", "like", "%$term%");
                })
                ->get(['id', 'firstname', 'lastname', 'telephone', 'email', 'credit_amt']);
        }

        $data = [];
        foreach ($result as $k => $res) {
            $data[$k]['id'] = $res->id;
            $data[$k]['value'] = $res->telephone;
            $tele = ($res->telephone) ? " / " . $res->telephone : '';
            $ele = ($res->email) ? " / " . $res->email : '';
            $data[$k]['label'] = $res->firstname . "  " . $res->lastname . "" . $tele . "" . $ele;
            $data[$k]['firstname'] = $res->firstname;
            $data[$k]['lastname'] = $res->lastname;
            $data[$k]['telephone'] = $res->telephone;
            $data[$k]['email'] = $res->email;
            $data[$k]['credit'] = $res->credit_amt;
        }
        echo json_encode($data);
    }

    public function getCustomerData()
    {
        if (!empty(Input::get('customer_id'))) {
            $user = User::where('id', Input::get('customer_id'))->with('addresses')->first();
        } else {
            $rand = rand(100000, 999999);
            $password = trim($rand, ' ');
            $userS = new User();
            $userS->firstname = (Input::get('cust_firstname')) ? Input::get('cust_firstname') : '';
            $userS->lastname = (Input::get('cust_lastname')) ? Input::get('cust_lastname') : '';

            if (Input::get('email_id')) {
                $userS->email = Input::get('email_id');
            }

            if (Input::get('email_id')) {
                $userS->password = Hash::make($password);
            }

            $userS->telephone = Input::get('cust_telephone');
            $userS->user_type = 2;
            $userS->store_id = Session::get('store_id');
            $userS->save();
            $user = $userS;
            $key = Crypt::encrypt($user->id);
            //
            //            if(Input::get('email_id')){
            //            $data1 = ['firstname' => $userS->firstname, 'key' => $key, 'user' => $userS, 'password' => $password];
            //            Helper::sendMyEmail(Config('constants.frontviewEmailTemplatesPath') . 'registerEmail', $data1, 'Successfully registered with Edunguru', 'support@edunguru.com', 'EdunGuru', Input::get('email_id'), $userS->firstname . " " . $userS->lastname);
            //            }
            //                if($this->getEmailStatus==1){
            //                     if(Input::get('email_id')){
            //                    $email_template = EmailTemplate::where('url_key', 'registration')->select('content')->get()->toArray()[0]['content'];
            //                    $replace = ["[first_name]", "[last_name]"];
            //                    $replacewith = [ucfirst($userS->firstname), ucfirst($userS->lastname)];
            //                    $email_templates = str_replace($replace, $replacewith, $email_template);
            //                    $data1 = ['email_template' => $email_templates];
            //                    Helper::sendMyEmail(onfig('constants.frontviewEmailTemplatesPath') . 'registerEmail', $data1, 'Successfully registered',  Config::get('mail.from.address'), Config::get('mail.from.name'), $userS->email, $userS->firstname . " " . $userS->lastname );
            //                     }
            //                    }
        }
        foreach ($user->addresses as $add) {
            $add->countryname = $add->country['name'];
            $add->statename = $add->zone['name'];
        }
        return $user;
    }

    public function getCustomerZone()
    {
        $countryid = Input::get('countryid');
        $zones = Zone::where("country_id", $countryid)->where("status", 1)->get();
        $opt = "<option value=''>Select state</option>";
        foreach ($zones as $zone) {
            $opt .= "<option value='" . $zone->id . "' >" . $zone->name . "</option>";
        }
        return $opt;
    }

    public function getCustomerAdd()
    {
        return Address::find(Input::get('addData'));
    }

    public function saveCustomerAdd()
    {
        $saveAdd = Address::findOrNew(Input::get('address_id'));
        $saveAdd->user_id = Input::get('user_id');
        $saveAdd->firstname = Input::get('firstname');
        $saveAdd->lastname = Input::get('lastname');
        $saveAdd->address1 = Input::get('address1');
        $saveAdd->address2 = Input::get('address2');
        $saveAdd->city = Input::get('city');
        $saveAdd->country_id = Input::get('country_id');
        $saveAdd->zone_id = Input::get('zone_id');
        $saveAdd->postcode = Input::get('postcode');
        $saveAdd->phone_no = Input::get('phone_no');
        $saveAdd->is_shipping = 1;
        $saveAdd->is_default_shipping = 1;
        if ($saveAdd->save()) {
            $saveAdd->statename = $saveAdd->zone['name'];
            $data = ['addressid' => $saveAdd->id, 'userid' => $saveAdd->user_id, 'myadd' => $saveAdd];
            return $data;
        } else {
            return 0;
        }
    }

    public function getSearchProds()
    {
        // hidding product which is already added
        $cart_products = Cart::instance('shopping')->content()->toArray();
        $added_prod = [];
        if (count($cart_products) > 0) {
            foreach ($cart_products as $key => $product) {
                if(array_key_exists("sub_prod",$product['options']))
                {
                    if ($product['id'] == $product['options']['sub_prod']) {
                        $added_prod[] = $product['id'];
                    }
                }
                else {
                    $added_prod[] = $product['id'];
                }
                
            }
        }
        $searchStr = Input::get('term');
        $products = Product::where("is_individual", 1)->where('status', 1)->where('product', "like", "%" . $searchStr . "%")->orWhere('id', "like", "%" . $searchStr . "%")->get(['id', 'product']);

        $data = [];
        foreach ($products as $k => $prd) {
            if (!in_array($prd->id, $added_prod)) {

                $offersProduct = DB::table("offers_products")->where(['prod_id' => $prd->id, 'type' => 1])->first();
                if (!empty($offersProduct)) {
                    $offerData = DB::table("offers")->where('id', $offersProduct->offer_id)->first();
                    $offer_name = $offerData->offer_name;
                    $offer_id = $offerData->id;
                } else {
                    $offer_name = '';
                    $offer_id = 0;
                }
                $data[$k]['id'] = $prd->id;
                $data[$k]['value'] = $prd->product;
                $data[$k]['type'] = $prd->prod_type;
                $data[$k]['label'] = $offer_name . " [" . $prd->id . "]" . $prd->product;
                $data[$k]['offer'] = $offer_id;

                /*$data[$k]['id'] = $prd->id;
                $data[$k]['value'] = $prd->product;
                $data[$k]['label'] = "[" . $prd->id . "]" . $prd->product;*/
                
            }
        }

        echo json_encode($data);
    }

    public function getSubProds()
    {
        /*echo "<pre>";
        print_r(Input::get('prodid'));
        exit;*/
        /*$subprods = Product::find(Input::get('prodid'))->subproducts()->where("status", 1)->get();
        echo "<pre>";
        print_r($subprods);
        exit;*/
        return $subprods = Product::find(Input::get('prodid'))->subproducts()->where("status", 1)->get();
    }

    public function saveCartData()
    {
         //dd(Session::get('usedCouponId'));
        if (!Session::get('usedCouponId')) {
            Cart::instance("shopping")->destroy();
            $mycarts = Input::get('mycart');
            foreach ($mycarts as $key => $mycart) {
                $getProd = Product::find($mycart['prod_id']);
                $addCart = app('App\Http\Controllers\Frontend\CartController')->addCartData($getProd->prod_type, $getProd->id, $mycart['subprodid'], $mycart['qty']);
            }
        }
        $cartInfo = Cart::instance("shopping")->total();
        // $finalamt = Cart::instance("shopping")->total() -  Session::get('couponUsedAmt');
        $cart_amt = Helper::calAmtWithTax();
        $finalamt = $cart_amt['total'];
        $paymentAmt = Input::get('pay_amt');
        $paymentMethod = Input::get('payment_mode'); //"9";
        $paymentStatus = "1";
        $payAmt = $finalamt;
        // apply additional charge to payAmount
        $additional_charge_json = AdditionalCharge::ApplyAdditionalCharge($payAmt);
        $additional_charge = json_decode($additional_charge_json, true);
        $payAmt = $payAmt + $additional_charge['total_amt'];

        $trasactionId = "";
        $transactionStatus = "";
        $userid = Input::get('user_id');
        $addressid = Input::get('address_id');
        $userinfo = User::find($userid);
        Session::put('loggedin_user_id', $userid);
        Session::put("addressSelected", $addressid);
        Session::put('logged_in_user', $userinfo->email);
        Session::put('user_cashback', $userinfo->cashback);
        Session::put('login_user_type', $userinfo->user_type);
        Session::put('login_user_first_name', $userinfo->firstname);
        Session::put('login_user_last_name', $userinfo->lastname);
        Session::put('login_user_telephone', $userinfo->telephone);
        Session::forget('orderId');
        $toPay = app('App\Http\Controllers\Frontend\CheckoutController')->toPayment();
        if (!empty($toPay['orderId'])) {
            $orderS = Order::find($toPay['orderId']);
            $orderS->created_by = Session::get('loggedinAdminId');
            $orderS->additional_charge = $additional_charge_json;
            $orderS->amt_paid = $paymentAmt;
            // $orderS->offline_payment_mode = Input::get('payment_mode');
            $orderS->description = Input::get('remark');
            $orderS->order_status = Input::get('remark');
            $orderS->update();
            if ($paymentMethod == '10') {
                // echo $userinfo->credit_amt;
                $userinfo->credit_amt = $userinfo->credit_amt + ($payAmt - $paymentAmt);
                // dd($userinfo->credit_amt);
                $userinfo->update();
                $paymentHistory = PaymentHistory::create();
                $paymentHistory->order_id = $orderS->id;
                $paymentHistory->pay_amount = $paymentAmt;
                $paymentHistory->added_by = Session::get('loggedinAdminId');
                $paymentHistory->save();
            }
            $succ = app('App\Http\Controllers\Frontend\CheckoutController')->saveOrderSuccess($paymentMethod, $paymentStatus, $payAmt, $trasactionId, $transactionStatus);
            Cart::instance("shopping")->destroy();
            Session::forget('loggedin_user_id');
            Session::forget("addressSelected");
            Session::forget('orderId');
            Session::forget('usedCouponId');
            Session::forget('logged_in_user');
            Session::forget('user_cashback');
            Session::forget('login_user_type');
            Session::forget('login_user_first_name');
            Session::forget('login_user_last_name');
            Session::forget('login_user_telephone');
        }

        if ($succ['orderId']) {
            return ['status' => 3, 'msg' => 'Created', 'orderId' => $succ['orderId']]; //success
        } else {
            return ['status' => 3, 'msg' => 'Created', 'orderId' => $succ['orderId']]; //failure
        }
    }

    public function getProdPrice()
    {
        $qty = (Input::get('qty'))? Input::get('qty'): 1;
        $offerid = Input::get('offerid');
        if (Input::get('pprd') == 1) {
            $pprod = Product::find(Input::get('parentprdid'));
            $price = ($pprod->selling_price != 0)? $pprod->selling_price: $pprod->price;
            $tax_type = $pprod->is_tax;
            $tax_rate = $pprod->totalTaxRate();
        } else {
            $pprod = Product::find(Input::get('subprdid'));
            $price = $pprod->price+@Product::find($pprod->parent_prod_id)->selling_price;
            $tax_type = $pprod->parentproduct->is_tax;
            $tax_rate = $pprod->parentproduct->totalTaxRate();
        }
        $total = array();
        $sub_total = $qty * $price;
        if ($this->feature['tax'] == 1) {
            $tax_amt = round($sub_total * $tax_rate / 100, 2);
            // if tax type is exclusive tax added to price
            if ($tax_type == 2) {
                $sub_total = $sub_total + $tax_amt;
            }
            $total['tax'] = $tax_amt * Session::get('currency_val');
        } else {
            $total['tax'] = 0;
        }

        $discount = 0;
        if ($offerid != 0) {
            //Session::put("offerid", $offerid);
            $offerDetails = DB::table("offers")->where(['id' => $offerid])->first();
            if (!empty($offerDetails)) {
                $total['offerName'] = $offerDetails->offer_name;
                $total['offerQty'] = $offerDetails->min_order_qty;
                $total['offertype'] = $offerDetails->type;
                if ($offerDetails->type == 1) {
                    if($offerDetails->offer_discount_type==1){
                        $discount = $sub_total * ($offerDetails->offer_discount_value / 100);
                        $total['offer'] = number_format((float) $discount * Session::get('currency_val'), 2, '.', '') . ' (' . $offerDetails->offer_name . ')';
                    }else if($offerDetails->offer_discount_type==2){
                        $discount = $offerDetails->offer_discount_value;
                        $total['offer'] = number_format((float) $discount * Session::get('currency_val'), 2, '.', '') . ' (' . $offerDetails->offer_name . ')';
                    }
                    
                } else if ($offerDetails->type == 2) {
                    $prodQty = DB::table("offers_products")->where(['offer_id' => $offerid, 'prod_id' => $pprod->id])->first();
                    $total['offer'] = '(' . $offerDetails->offer_name . ')';
                    if ($qty >= $prodQty->qty) {
                        // dd($qty);
                        $offer_product = DB::table("offers_products as op")->join('products as p', 'op.prod_id', '=', 'p.id')->select('op.qty', 'p.product', 'op.prod_id')->where(['op.type' => 2, 'op.offer_id' => $offerid])->get();
                        if (count($offer_product) > 0) {
                            $total['offerProdCount'] = count($offer_product);
                            $prod = [];
                            foreach ($offer_product as $offerprod) {
                                $prod[] = '
                            <tr class="delOfferRow">
                                <td width="30%">
                                    <input type="text" class="form-control prodSearch" placeholder="Search Product" value="' . addslashes($offerprod->product) . '" name="prod_search" data-prdid="' . $offerprod->prod_id . '" data-prdtype="1">
                                </td>
                                <td width="20%">
                                </td>
                                <td width="20%" >
                                    <span class="prodQty"><input type="number" min="1" value="' . $offerprod->qty . '" class="qty form-control" name="" disabled></span>
                                </td>
                                <td width="20%">
                                        <span class="prodUnitPrice">0</span>
                                    </td>
                                <td width="20%">
                                    <span class="prodDiscount">0</span>
                                </td>
                                <td width="20%">
                                    <span class="prodPrice">0</span>
                                </td>
                                <td width="5%" class="text-center">

                                </td>
                            </tr>
                    ';
                            }
                            $total['offerProd'] = $prod;
                        }
                    }

                }
            }

        }    


        $totprice = $sub_total - $discount;
        $total['price'] = number_format((float) $totprice * Session::get('currency_val'), 2, '.', '');
        
        $cart_amt = Helper::calAmtWithTax();
        $total['cart'] = Cart::instance('shopping')->content()->toArray();
        $total['subtotal'] = $cart_amt['sub_total'];
        $total['orderAmount'] = $cart_amt['total'] * Session::get('currency_val');
        $total['unitPrice'] = number_format((float) $price * Session::get('currency_val'), 2, '.', '');
       

        /*
        $total['price'] = $sub_total * Session::get('currency_val');
        $cart_amt = Helper::calAmtWithTax();

        $total['cart'] = Cart::instance('shopping')->content()->toArray();
        //  $newAmnt = $cart_amt['total'] * Session::get('currency_val');
        $total['subtotal'] = $cart_amt['sub_total'] * Session::get('currency_val');
        $total['orderAmount'] = $cart_amt['total'] * Session::get('currency_val');
        $total['unitPrice'] = $price * Session::get('currency_val');*/

        return $total;
    }

    public function checkcart($cart)
    {
        Cart::instance('shopping')->destroy();
    }

    public function calculateFixedDiscount($individualSubtotal, $disc)
    {
        $arraySumPercent = array_sum($individualSubtotal) / 100;
        $individualDiscountPercent = [];
        foreach ($individualSubtotal as $key => $subtotal) {
            $calPerdiscount = $subtotal / 100;
            $individualDiscountPercent[$key] = ($disc * $calPerdiscount / $arraySumPercent);
        }
        Session::put('individualDiscountPercent', json_encode($individualDiscountPercent));
        return $individualDiscountPercent;
    }

    public function checkOrderCoupon()
    {
        Session::put('currency_val', 1);
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
        $mycarts = Input::get('mycart');
        if(!empty($mycarts)){
            foreach ($mycarts as $key => $mycart) {
            $getProd = Product::find($mycart['prod_id']);
            $addCart = app('App\Http\Controllers\Frontend\CartController')->addCartData($getProd->prod_type, $getProd->id, $mycart['subprodid'], $mycart['qty']);
            }
        }else{
            $cartContent = Cart::instance('shopping')->destroy();
        }
        
        // dd(Cart::instance('shopping')->content()->toArray());
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
                                $indvDisc = (($validCoupon[0]->coupon_value * $product['subtotal']) / 100);
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
                                $indvDisc = (($validCoupon[0]->coupon_value * $product['subtotal']) / 100);
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
                        $indvDisc = (($validCoupon[0]->coupon_value * $prdAllC['subtotal']) / 100);
                        if($indvDisc >= $validCoupon[0]->max_discount_amt)
                        {
                            $indvDisc = $validCoupon[0]->max_discount_amt;
                        }
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

    //To check stock order
    public function editOrderChkStock()
    {
        $is_stockable = GeneralSetting::where('url_key', 'stock')->first();
        $ppid = Input::get('ppid');
        $spid = Input::get('spid');
        $qty = Input::get('qty');
        $ptype = Input::get('ptype');
        if ($ptype == 1 && $is_stockable->status == 1) {
            $spid = null;
            $chk = Helper::checkStock($ppid, $qty, $spid);
        } else if ($ptype == 3 && $is_stockable->status == 1) {
            $spid = Input::get('spid');
            $chk = Helper::checkStock($ppid, $qty, $spid);
        } else if ($ptype == 2 && $is_stockable->status == 1) {
            $spidarr = Input::get('spid');
            $spid = [];
            foreach ($spidarr as $combos) {
                $spid[Product::find($combos)->parent_prod_id] = $combos;
            }
            $chk = Helper::checkStock($ppid, $qty, $spid);
        } else {
            $chk = "In Stock";
        }
        return $chk;
    }

    public function getCartEditProd()
    {
        $catid = Input::get('catid');
        $products = Category::find($catid)->products()->where("is_individual", 1)->where("is_del", 0)->where("is_avail", 1)->where("stock", ">", 0)->orderBy("product", "asc")->get();
        $cart_products = Cart::instance('shopping')->content()->toArray();
        $added_prod = array();
        if (count($cart_products) > 0) {
            foreach ($cart_products as $key => $product) {
                if ($product['id'] == $product['options']['sub_prod']) {
                    $added_prod[] = $product['id'];
                }
            }
        }
        $opt = "<option value=''>Please Select</option>";
        foreach ($products as $prd) {
            if (!in_array($prd->id, $added_prod)) {
                $opt .= "<option value='" . $prd->id . "'>$prd->product</option>";
            }
        }
        return $opt;
    }

    public function getCartEditProdVar()
    {
        $prdid = Input::get('prdid');
        $prd = Product::find($prdid);
        $tax_rate = $prd->totalTaxRate();
        // $sub_total = $qty * $price;
        $sub_total = $prd->selling_price;
        if ($prd->is_tax == 2) {
            $tax_amt = round($prd->selling_price * $tax_rate / 100, 2);
            $sub_total = $prd->selling_price + $tax_amt;
        }
        if ($prd->prod_type == 3) {
            $sub_total = 0;
            $getSub = $prd->subproducts()->where("is_del", 0)->orderBy("product", "asc")->get();
            $cart_products = Cart::instance('shopping')->content()->toArray();
            $added_prod = array();
            if (count($cart_products) > 0) {
                foreach ($cart_products as $key => $product) {
                    if ($product['id'] != $product['options']['sub_prod']) {
                        $added_prod[] = $product['options']['sub_prod'];
                    }
                }
            }
            $opt = "<option value=''>Please select</option>";
            foreach ($getSub as $subP) {
                $nameProd1 = explode("Variant", $subP->product, 2);
                $filtered_words = array(
                    '(',
                    ')',
                    'frames',
                    'posters',
                );
                $gap = '';
                $prodSize1 = str_replace($filtered_words, $gap, $nameProd1[1]);
                if (!in_array($subP->id, $added_prod)) {
                    $opt .= "<option value='$subP->id'>$prodSize1</option>";
                }
            }
            return $prd->selling_price . "||||" . $prd->prod_type . "||||" . $opt . "||||" . $prd->stock . "||||" . $sub_total;
        } else {
            echo $prd->selling_price . "||||" . $prd->prod_type . "||||" . "invalid" . "||||" . $prd->stock . "||||" . $sub_total;
        }
    }

    public function cartEditGetComboSelect()
    {
        $prdid = Input::get('prdid');
        $getSr = Input::get('getarr');
        $prd = Product::find($prdid);
        $getSel = "";
        foreach ($prd->comboproducts()->get() as $prdC) {
            if ($prdC->prod_type == 1) {
                $getSel .= "<br/>" . $prdC->product . "(" . $prdC->categories()->first()->category . ")";
            }
            if ($prdC->prod_type == 3) {
                $getSel .= "<br/>" . $prdC->product . "(" . $prdC->categories()->first()->category . ")";
                $getSubPrd = Product::find($prdC->id)->subproducts()->get();
                $getSel .= '<br/><select name="cartdata[' . $getSr . '][' . $prdid . '][subprd][]" class="form-control subComboProd selPrdVar">';
                foreach ($getSubPrd as $sprd) {
                    $nameProd1 = explode("Variant", $sprd->product, 2);
                    $filtered_words = array(
                        '(',
                        ')',
                        'frames',
                        'posters',
                    );
                    $gap = '';
                    $prodSize1 = str_replace($filtered_words, $gap, $nameProd1[1]);
                    $getSel .= '<option value="' . $sprd->id . '">' . $prodSize1 . '</option>';
                }
                $getSel .= '</select>';
            }
        }
        return $getSel;
    }

    public function searchForId($id, $array)
    {
        foreach ($array as $key => $val) {
            if ($val['id'] == $id || $val['id'] === "$id") {
                return $val;
            }
        }
        return null;
    }

    // For cashback
    public function applyCashback()
    {
        $user_id = input::get('userId');
        $user = User::find($user_id);
        if (isset($user)) {
            $cashback = $user->cashback * Session::get('currency_val');
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
                $discount = $c->options->disc + $c->options->wallet_disc + $c->options->voucher_disc + $c->options->user_disc;
                $productP = (($c->subtotal - $discount) / 100);
                $orderAmtP = ($orderAmt / 100);
                $amt = Helper::discForProduct($productP, $orderAmtP, Session::get('checkbackUsedAmt'));
                Cart::instance('shopping')->update($k, ["options" => ['wallet_disc' => $amt]]);
            }
        } else {
            $finalamt = Session::get('pay_amt') + Session::get('checkbackUsedAmt');
            $cart = Cart::instance('shopping')->content();
            foreach ($cart as $k => $c) {
                Cart::instance('shopping')->update($k, ["options" => ['wallet_disc' => 0]]);
            }
            Session::forget('checkbackUsedAmt');
            Session::forget('remainingCashback');
        }

        $cart_data = Helper::calAmtWithTax();
        $finalamt = $cart_data['total'];
        $sub_total = $cart_data['sub_total'];
        if ($finalamt <= 0) {
            $finalamt = 0;
        }
        $cart = Cart::instance('shopping')->content();
        $data['orderAmount'] = $finalamt * Session::get('currency_val');
        $data['cart'] = $cart;
        $data['subtotal'] = $sub_total * Session::get('currency_val');
        $data['cashbackUsedAmt'] = Session::get('checkbackUsedAmt');
        $data['cashbackRemain'] = Session::get('remainingCashback');
        return $data;
    }

    public function applyVoucher()
    {
        $voucherCode = Input::get('voucherCode');
        $cartAmount = Helper::getMrpTotal();
        $validVoucher = Coupon::where("coupon_code", "=", $voucherCode)
            ->where("coupon_type", "=", 3)
            ->where("initial_coupon_val", "!=", 0)
            ->get()->toArray();
        if (!empty($validVoucher[0]['id'])) {
            $coupon_value = $validVoucher[0]['initial_coupon_val'];
            if ($coupon_value >= $cartAmount) {
                $remainingVoucherAmt = ($coupon_value - $cartAmount);
                $voucherValue = $coupon_value - $remainingVoucherAmt;
                $remainVoucherval = $remainingVoucherAmt;
            } else if ($cartAmount >= $coupon_value) {
                $remainVoucherval = 0;
                $voucherValue = $coupon_value;
            }
            Session::put('voucherUsedAmt', $validVoucher[0]['id']);
            Session::put('voucherAmount', $voucherValue);
            Session::put('remainingVoucherAmt', $remainVoucherval);
            $orderAmt = Helper::getMrpTotal();
            $cart = Cart::instance('shopping')->content();
            foreach ($cart as $k => $c) {
                $productP = (($c->subtotal - $c->options->disc - $c->options->wallet_disc - $c->options->referral_disc - $c->options->user_disc) / 100);
                $orderAmtP = ($orderAmt / 100);
                $amt = Helper::discForProduct($productP, $orderAmtP, Session::get('voucherAmount'));
                Cart::instance('shopping')->update($k, ["options" => ['voucher_disc' => $amt]]);
            }
        } else {
            Session::forget('voucherAmount');
            Session::forget('voucherUsedAmt');
            Session::forget('remainingVoucherAmt');
            $cart = Cart::instance('shopping')->content();
            foreach ($cart as $k => $c) {
                Cart::instance('shopping')->update($k, ["options" => ['voucher_disc' => 0]]);
            }
            if ($voucherCode == '') {
                $data['clearCoupon'] = true;
            }
        }

        $cart_data = Helper::calAmtWithTax();
        $finalamt = $cart_data['total'];
        $sub_total = $cart_data['sub_total'];
        if ($finalamt <= 0) {
            $finalamt = 0;
        }
        $cart = Cart::instance('shopping')->content();
        $data['orderAmount'] = $finalamt * Session::get('currency_val');
        $data['cart'] = $cart;
        $data['subtotal'] = $sub_total * Session::get('currency_val');
        $data['voucherAmount'] = Session::get('voucherAmount');
        $data['voucherUsedAmt'] = Session::get('voucherUsedAmt');
        //dd($data);
        return $data;
    }

    public function applyUserLevelDisc()
    {
        $cart_data = Helper::calAmtWithTax();
        $cartAmount = $cart_data['total'];
        $discType = Input::get('discType');
        $discVal = Input::get('discVal');
        if ($discVal == 0) {
            $data['clearDisc'] = true;
        }
        if ($discType == 1) {
            $discountAmt = ($cartAmount * $discVal / 100);
            Session::put("discAmt", $discountAmt);
            Session::put("discType", $discType);
            $orderAmt = Helper::getMrpTotal();
            $cart = Cart::instance('shopping')->content();
            foreach ($cart as $k => $c) {
                $productP = (($c->subtotal - $c->options->disc - $c->options->wallet_disc - $c->options->referral_disc - $c->options->voucher_disc) / 100);
                $orderAmtP = ($orderAmt / 100);
                $amt = Helper::discForProduct($productP, $orderAmtP, Session::get('discAmt'));
                Cart::instance('shopping')->update($k, ["options" => ['user_disc' => $amt]]);
            }
        } else if ($discType == 2) {
            $discountAmt = ($discVal);
            Session::put("discAmt", $discountAmt);
            Session::put("discType", $discType);
            $orderAmt = Helper::getMrpTotal();
            $cart = Cart::instance('shopping')->content();
            foreach ($cart as $k => $c) {
                $productP = (($c->subtotal - $c->options->disc - $c->options->wallet_disc - $c->options->referral_disc) / 100);
                $orderAmtP = ($orderAmt / 100);
                $amt = Helper::discForProduct($productP, $orderAmtP, Session::get('discAmt'));
                Cart::instance('shopping')->update($k, ["options" => ['user_disc' => $amt]]);
            }
        } else {
            Session::forget('discAmt');
            Session::forget('discType');
            $cart = Cart::instance('shopping')->content();
            foreach ($cart as $k => $c) {
                Cart::instance('shopping')->update($k, ["options" => ['user_disc' => 0]]);
            }
        }
        $cart_data = Helper::calAmtWithTax();
        $finalamt = $cart_data['total'];
        $sub_total = $cart_data['sub_total'];
        if ($finalamt <= 0) {
            $finalamt = 0;
        }
        $cart = Cart::instance('shopping')->content();
        $data['orderAmount'] = $finalamt * Session::get('currency_val');
        $data['cart'] = $cart;
        $data['subtotal'] = $sub_total * Session::get('currency_val');
        $data['discAmt'] = Session::get('discAmt') * Session::get('currency_val');
        $data['discType'] = Session::get('discType');
        return $data;
    }

    public function applyReferel()
    {
        $requireReferalCode = Input::get('RefCode');
        if ($requireReferalCode == '') {
            $data['clearReferrel'] = true;
        }
        $cart_amount = Helper::getMrpTotal();
        $checkReferral = GeneralSetting::where('url_key', 'referral')->first();
        $detailsR = json_decode($checkReferral->details);
        foreach ($detailsR as $detRk => $detRv) {
            if ($detRk == "activate_duration_in_days") {
                $activate_duration = $detRv;
            }
            if ($detRk == "bonous_to_referee") {
                $bonousToReferee = $detRv;
            }
            if ($detRk == "discount_on_order") {
                $discountOnOrder = $detRv;
            }
        }
        // dd($requireReferalCode);
        $allRefCode = [];
        if (!empty($requireReferalCode)) {
            $allRefCode = User::where("id", "!=", Session::get('loggedin_user_id'))->where("referal_code", "=", $requireReferalCode)->get();
        }
        if (count($allRefCode) > 0) {
            $ref_disc = number_format(($cart_amount * $discountOnOrder) / 100, 2);
            $user_referal_points = number_format(($cart_amount * $bonousToReferee) / 100, 2);
            Session::put("userReferalPoints", $user_referal_points);
            Session::put("referalCodeAmt", $ref_disc);
            Session::put("ReferalCode", $requireReferalCode);
            Session::put("ReferalId", $allRefCode[0]->id);
            $orderAmt = Helper::getMrpTotal();
            $cart = Cart::instance('shopping')->content();
            foreach ($cart as $k => $c) {
                $productP = (($c->subtotal - $c->options->disc - $c->options->wallet_disc - $c->options->user_disc) / 100);
                $orderAmtP = ($orderAmt / 100);
                $amt = Helper::discForProduct($productP, $orderAmtP, Session::get('referalCodeAmt'));
                Cart::instance('shopping')->update($k, ["options" => ['referral_disc' => $amt]]);
            }
            // $cart_data = Helper::calAmtWithTax();
            // $cartAmount = $cart_data['total'];
        } else {
            $cart = Cart::instance('shopping')->content();
            foreach ($cart as $k => $c) {
                Cart::instance('shopping')->update($k, ["options" => ['referral_disc' => 0]]);
            }
            $referalCodeAmt = Session::get('referalCodeAmt');
            Session::forget('ReferalCode');
            Session::forget('ReferalId');
            Session::forget('referalCodeAmt');
            Session::forget('userReferalPoints');
        }

        $cart_data = Helper::calAmtWithTax();
        $finalamt = $cart_data['total'];
        $sub_total = $cart_data['sub_total'];
        if ($finalamt <= 0) {
            $finalamt = 0;
        }
        $cart = Cart::instance('shopping')->content();
        $data['orderAmount'] = $finalamt * Session::get('currency_val');
        $data['cart'] = $cart;
        $data['subtotal'] = $sub_total * Session::get('currency_val');
        $data['referalCodeAmt'] = Session::get('referalCodeAmt') * Session::get('currency_val');
        $data['ReferalCode'] = Session::get('ReferalCode');
        return $data;
    }

    public function waybill($id = null)
    {
        $allids = $id;
        $storeName = $this->jsonString['storeName'];
        $storeId = $this->jsonString['store_id'];
        $contact = StaticPage::where('url_key', 'contact-us')->first()->contact_details;
        $storeContact = json_decode($contact);
        $orders = Order::where('id', $allids)->get();
        foreach ($orders as $key => $saveorder) {
            $ordid = $saveorder->id; //array(16,15);//explode(",", Input::get('OrderIds'));
            // dd($saveorder);
            if ($saveorder->zone_id == '322') {
                $weight = 'Up To 1Kg';
                $delivery_timing = 'Next Day(24hr)';
                $package_code = '#2506';
            } else {
                $weight = 'Up To 500gm';
                $delivery_timing = 'Next Day(48hr)';
                $package_code = '#2444';
            }
            if ($saveorder->payment_method == 1) {
                $payment_method = 1;
            } else {
                $payment_method = '2';
            }
            // $client = new http\Client;
            //$request = new http\Client\Request;
            //
            //$body = new http\Message\Body;
            //$body->append(new http\QueryString(array(
            //  'order_code' => $saveorder->id,
            //  'product_id' => '1',
            //  'parcel' => 'insert',
            //  'ep_name' => $storeName,
            //  'pick_contact_person' =>  $storeContact->mobile,
            //  'pick_division' => '',
            //  'pick_district' => 'test',
            //  'pick_thana' =>  $storeContact->thana,
            //  'pick_union' => 'test',
            //  'pick_address' => $storeContact->address_line1,
            //  'pick_mobile' =>  $storeContact->mobile,
            //  'recipient_name' => $saveorder->first_name . '' . $saveorder->last_name,
            //  'recipient_mobile' => $saveorder->phone_no,
            //  'recipient_division' => '',
            //  'recipient_district' => '',
            //  'recipient_city' => $saveorder->zone->name,
            //  'recipient_area' => $saveorder->thana,
            //  'recipient_thana' => $saveorder->thana,
            //  'recipient_union' => 'test',
            //  'upazila' => '',
            //    'weight' =>$weight,
            //  'delivery_timing' =>$delivery_timing,
            //  'package_code' => $package_code,
            //  'recipient_address' => $saveorder->address1 . '' . $saveorder->address2,
            //  'shipping_price' => '1',
            //  'parcel_detail' => '',
            //  'no_of_items' => '',
            //  'product_price' => $payamt,
            //  'payment_method' => $payment_method,
            //  'ep_id' =>$storeId
            //)));
            //$request->setRequestUrl('http://103.239.254.146/apiv2/');
            //$request->setRequestMethod('POST');
            //$request->setBody($body);
            //
            //$request->setHeaders(array(
            //  'Postman-Token' => 'c74cf735-9bd9-4ca5-9cd9-dd41df455e3d',
            //  'Cache-Control' => 'no-cache',
            //  'Content-Type' => 'application/x-www-form-urlencoded',
            //  'USER_ID' => 'I8837',
            //  'API_KEY' => 'xqdH',
            //  'API_SECRET' => 'jubLW'
            //));
            //$client->enqueue($request)->send();
            //$response = $client->getResponse();
            //
            //$data= $response->getBody();
            //dd($data);

            $headers = array();
            $headers[] = 'USER_ID:I8837';
            $headers[] = 'API_KEY:xqdH';
            $headers[] = 'API_SECRET:jubLW';
            $reqArray = [];
            $reqArray['order_code'] = $saveorder->id;
            $reqArray['product_id'] = '1';
            $reqArray['parcel'] = 'insert';
            $reqArray['ep_name'] = $storeName;
            $reqArray['pick_contact_person'] = $storeContact->mobile;
            $reqArray['pick_division'] = '';
            $reqArray['pick_district'] = 'test';
            $reqArray['pick_thana'] = $storeContact->Thana;
            $reqArray['pick_union'] = 'test';
            $reqArray['pick_address'] = $storeContact->address_line1 . ' ' . $storeContact->address_line2;
            $reqArray['pick_mobile'] = $storeContact->mobile;
            $reqArray['recipient_name'] = $saveorder->first_name . '' . $saveorder->last_name;
            $reqArray['recipient_mobile'] = $saveorder->phone_no;
            $reqArray['recipient_division'] = '';
            $reqArray['recipient_district'] = '';
            $reqArray['recipient_city'] = $saveorder->zone->name;
            $reqArray['recipient_area'] = $saveorder->thana;
            $reqArray['recipient_thana'] = $saveorder->thana;
            $reqArray['recipient_union'] = 'test';

            $reqArray['upazila'] = '';
            if ($saveorder->zone_id == '322') {
                $reqArray['weight'] = 'Up To 1Kg';
                $reqArray['delivery_timing'] = 'Next Day(24hr)';
                $reqArray['package_code'] = '#2506';
            } else {
                $reqArray['weight'] = 'Up To 500gm';
                $reqArray['delivery_timing'] = 'Next Day(48hr)';
                $reqArray['package_code'] = '#2444';
            }
            $payamt = $saveorder->pay_amt * Session::get('currency_val');
            $reqArray['product_id'] = '';
            $reqArray['recipient_address'] = $saveorder->address1 . '' . $saveorder->address2;
            $reqArray['shipping_price'] = '1';
            $reqArray['parcel_detail'] = '';
            $reqArray['no_of_items'] = '';
            $reqArray['product_price'] = $payamt;
            if ($saveorder->payment_method == 1) {
                $reqArray['payment_method'] = 1;
            } else {
                $reqArray['payment_method'] = 2;
            }

            $reqArray['ep_id'] = $storeId;
            //echo "================request Array==================";
            //print_r($reqArray);

            $url = "https://ecourier.com.bd/apiekom/";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($reqArray));
            $output = curl_exec($ch);
            // echo "================output= rrr=================";
            //  print_r($output);
            //  echo "================output==================";
            curl_close($ch);
            $data = json_decode($output);
            //print_r($output);
            //  echo "================output==================";

            if ($data->response_code == 200) {
                $saveorder->shiplabel_tracking_id = $data->ID;
                $saveorder->order_status = 2;
                $saveorder->update();
                $curierHistory = new CurierHistory();
                $curierHistory->order_id = $ordid;
                $curierHistory->courier_id = 4;
                $curierHistory->waybill_no = $data->ID;
                $curierHistory->prefix = $this->jsonString['prefix'];
                $curierHistory->store_id = $this->jsonString['store_id'];
                $curierHistory->save();
                $tableContant = Helper::getEmailInvoice($id);
                $emailStatus = GeneralSetting::where('url_key', 'email-facility')->first()->status;
                $logoPath = @asset(Config("constants.logoUploadImgPath") . 'logo.png');
                //$settings = json_decode($str, true);
                $settings = Helper::getSettings();
                $webUrl = $_SERVER['SERVER_NAME'];
                $toEmail = $saveorder->users->email;
                $firstName = $saveorder->first_name;
                if ($emailStatus == 1) {
                    $emailContent = EmailTemplate::where('url_key', 'order-shipped')->select('content', 'subject')->get()->toArray();
                    $email_template = $emailContent[0]['content'];
                    $subject = $emailContent[0]['subject'];
                    $replace = array("[orderId]", "[firstName]", "[invoice]", "[logoPath]", "[web_url]", "[primary_color]", "[secondary_color]", "[storeName]", "[ordetId]", "[created_at]");
                    $replacewith = array($saveorder->id, $firstName, $tableContant, $logoPath, $webUrl, $settings['primary_color'], $settings['secondary_color'], $settings['storeName'], $saveorder->id, $saveorder->created_at);
                    $email_templates = str_replace($replace, $replacewith, $email_template);
                    $data_email = ['email_template' => $email_templates];
                    Helper::sendMyEmail(Config('constants.adminEmails') . '.dispatch_email', $data_email, $subject, Config::get('mail.from.address'), Config::get('mail.from.name'), $toEmail, $firstName);
                    //  return view(Config('constants.frontviewEmailTemplatesPath') . 'orderSuccess', $data_email);
                }
            } else {
                print_r($data->errors);
                die;
            }

            // $saveorder = Order::find($id);
            //         $tableContant = Helper::getEmailInvoice($id);
            //
            //        $emailStatus = GeneralSetting::where('url_key', 'email-facility')->first()->status;
            //        //$path = Config("constants.adminStorePath"). "/storeSetting.json";
            //        //$str = file_get_contents($path);
            //        $logoPath = @asset(Config("constants.logoUploadImgPath") . 'logo.png');
            //        //$settings = json_decode($str, true);
            //        $settings = Helper::getSettings();
            //        $webUrl = $_SERVER['SERVER_NAME'];
            //         $toEmail = $saveorder->users->email;
            //        $firstName= $saveorder->first_name;
            //        if ($emailStatus == 1) {
            //            $emailContent = EmailTemplate::where('url_key', 'order-shipped')->select('content', 'subject')->get()->toArray();
            //            $email_template = $emailContent[0]['content'];
            //            $subject = $emailContent[0]['subject'];
            //
            //            $replace = array("[orderId]", "[firstName]", "[invoice]", "[logoPath]", "[web_url]", "[primary_color]", "[secondary_color]", "[storeName]", "[ordetId]", "[created_at]");
            //            $replacewith = array($saveorder->id,$firstName,  $tableContant, $logoPath, $webUrl, $settings['primary_color'], $settings['secondary_color'], $settings['storeName'], $saveorder->id, $saveorder->created_at);
            //            $email_templates = str_replace($replace, $replacewith, $email_template);
            //            $data_email = ['email_template' => $email_templates];
            //
            //            Helper::sendMyEmail(Config('constants.adminEmails') . '.dispatch_email', $data_email, $subject, Config::get('mail.from.address'), Config::get('mail.from.name'), $toEmail, $firstName);
            //          //  return view(Config('constants.frontviewEmailTemplatesPath') . 'orderSuccess', $data_email);
            //
        }
        $viewname = Config('constants.adminOrderView') . '.invoiceAws';
        $data = ['orders' => $orders, 'storeName' => $storeName, 'storeContact' => $storeContact, 'allids' => $allids];
        return Helper::returnView($viewname, $data);
        // return view(Config('constants.adminOrderView') . '.invoiceAws', compact('result','allids' , 'orders','params','awbno')); //users
    }

    public function getECourier()
    {

        $ordid = 15; //array(16,15);//explode(",", Input::get('OrderIds'));
        //        foreach ($orderids as $ordid) {
        $saveorder = Order::find($ordid);
        // dd($saveorder);
        $headers = array();
        $headers[] = 'Content-Type:application/x-www-form-urlencoded';
        $headers[] = 'USER_ID:I8837';
        $headers[] = 'API_KEY:xqdH';
        $headers[] = 'API_SECRET:jubLW';
        $reqArray = [];
        $reqArray['order_code'] = $ordid;
        $reqArray['product_id'] = '1';
        $reqArray['parcel'] = 'insert';
        $reqArray['ep_name'] = 'test';
        $reqArray['pick_contact_person'] = '9930619304';
        $reqArray['pick_division'] = '';
        $reqArray['pick_district'] = 'test';
        $reqArray['pick_thana'] = 'Adabor Thana';
        $reqArray['pick_union'] = 'test';
        $reqArray['pick_address'] = 'test';
        $reqArray['pick_mobile'] = '9930619304';
        $reqArray['recipient_name'] = $saveorder->first_name . '' . $saveorder->last_name;
        $reqArray['recipient_mobile'] = $saveorder->phone_no;
        $reqArray['recipient_division'] = '';
        $reqArray['recipient_district'] = '';
        $reqArray['recipient_city'] = $saveorder->zone->name;
        $reqArray['recipient_area'] = 'test';
        $reqArray['recipient_thana'] = 'Adabor Thana';
        $reqArray['recipient_union'] = 'test';
        $reqArray['weight'] = 'Up To 500gm';

        $reqArray['upazila'] = '';
        if ($saveorder->zone_id == '322') {
            $reqArray['delivery_timing'] = 'Next Day(24hr)';
            $reqArray['package_code'] = '#2443';
        } else {
            $reqArray['delivery_timing'] = 'Next Day(48hr)';
            $reqArray['package_code'] = '#2444';
        }

        $reqArray['product_id'] = '';
        $reqArray['recipient_address'] = 'test';
        $reqArray['shipping_price'] = '1';
        $reqArray['parcel_detail'] = '';
        $reqArray['no_of_items'] = '';
        $reqArray['product_price'] = '1';
        $reqArray['payment_method'] = '1';
        $reqArray['ep_id'] = '1';

        $url = "http://ecourier.com.bd/apiv2/";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($reqArray));
        $output = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($output);

        if ($data->response_code == 200) {
            $saveorder->shiplabel_tracking_id = $data->ID;
            $saveorder->order_status = 2;
            $saveorder->update();
            $curierHistory = new CurierHistory();
            $curierHistory->order_id = $ordid;
            $curierHistory->courier_id = 4;
            $curierHistory->waybill_no = $data->ID;
            $curierHistory->prefix = $this->jsonString['prefix'];
            $curierHistory->store_id = $this->jsonString['store_id'];
            $curierHistory->save();
        } else {
            echo $data->errors;
            die;
        }

        //        }
        return redirect()->back();
    }

    public function getPayments()
    {
        $orderId = Input::get('orderId');
        if ($orderId && $orderId != null) {
            $order = Order::where('id', $orderId)->select('id', 'pay_amt', 'amt_paid')->first();
            if ($order && $order != null) {
                $payments = PaymentHistory::where('order_id', $orderId)->get();
                $remainingAmt = ($order->pay_amt) - ($order->amt_paid);
                $str = '';
                if ($payments && count($payments) > 0) {
                    foreach ($payments as $payment) {
                        $str .= '<tr><td>' . date('d-M-Y', strtotime($payment->created_at)) . '</td><td class="text-right"><span class="currency-sym"></span>' . number_format(($payment->pay_amount * Session::get('currency_val')), 2) . '</td></tr>';
                    }
                } else {
                    $str .= '<tr><td colspan="2">No records found!</td></tr>';
                }
                return ['status' => 1, 'payments' => $str, 'remainingAmt' => $remainingAmt];
            } else {
                return ['status' => 0, 'msg' => 'Incorrect order id'];
            }
        } else {
            return ['status' => 0, 'msg' => 'Incorrect order id'];
        }
    }

    public function addNewOrderPayment()
    {
        // dd(Input::all());
        $paymentAmt = Input::get('payAmt');
        $orderId = Input::get('orderId');
        $orderS = Order::where('id', $orderId)->first();
        if ($orderS && $orderS != null) {
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
            return ['status' => 1, 'msg' => 'Payment added successfully'];
        } else {
            return ['status' => 0, 'msg' => 'Incorrect order id'];
        }
    }
}
