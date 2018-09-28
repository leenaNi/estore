<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Library\Helper;
use App\Models\Address;
use App\Models\Category;
use App\Models\Country;
use App\Models\User;
use App\Models\Coupon;
use App\Models\Merchant;
use App\Models\HasProducts;
use App\Models\Order;
use App\Models\OrderFlagHistory;
use App\Models\OrderReturnCashbackHistory;
use Config;
use DB;
use Input;
use Mail;
use Session;
use Hash;
use Crypt;
use Request;

class ApiOrderController extends Controller {

    public function index() {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $order_options = '';
        $order_status = DB::table('order_status')->where('status', 1)->orderBy('order_status', 'asc')->get();
        $orders = Order::where('orders.order_status', "!=", 0)->where('orders.store_id', $merchant->id)->orderBy('orders.id', "desc")->select("*");


        $payment_method = DB::table('payment_method')->get();
        $payment_stuatus = DB::table('payment_status')->get();
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
            $orders = $orders->where('pay_amt', '>=', Input::get('pricemin'));
        }
        if (!empty(Input::get('pricemax'))) {
            $orders = $orders->where('pay_amt', '<=', Input::get('pricemax'));
        }
        if (!empty(Input::get('search'))) {
            //get user id
            $users = User::whereRaw("(CONCAT(firstname,' ',lastname) like ?)", ['%' . Input::get('search') . '%'])->orwhere('email', "like", "%" . Input::get('search') . "%")->orwhere('telephone', "like", "%" . Input::get('search') . "%")->select('id')->get()->toArray();

            if (!empty($users)) {
                $orders = $orders->whereIn('user_id', $users);
            }
        }
        if (!empty(Input::get('date'))) {
            $dates = explode(' - ', Input::get('date'));
            $dates[0] = date("Y-m-d", strtotime($dates[0]));
            $dates[1] = date("Y-m-d", strtotime($dates[1]));
            $orders = $orders->whereBetween('created_at', $dates);
        }
        /* if (!empty(Input::get('dateto'))) {
          $date = date("Y-m-d", strtotime(Input::get('dateto')));
          $orders = $orders->where('created_at', '<=', $date);
          } */
        if (!empty(Input::get('searchFlag'))) {
            $chk = Flags::find(Input::get('searchFlag'))->flag;
            if (strpos($chk, 'No Flag') !== false) {
                $orders = $orders->where('flag_id', 0);
            } else {
                $orders = $orders->WhereHas('orderFlag', function($q) {
                    $q->where('flag_id', '=', Input::get('searchFlag'));
                });
            }
        }
        if (Input::get('searchStatus') !== null) {
            if (!empty(Input::get('searchStatus'))) {
                $order_options = '';
                foreach ($order_status as $status) {
                    $order_options .= '<option  value="' . $status->id . '" ' . (in_array($status->id, Input::get('searchStatus')) ? 'selected' : '') . '>' . $status->order_status . '</option>';
                }
                $orders = $orders->whereIn('order_status', Input::get('searchStatus'));
            }
        }

        $orders = $orders->paginate(10);
        $ordersCount = $orders->total();
        foreach ($orders as $order) {
            if ($order->zone_id) {
                $order->stateName = DB::table($prifix . '_zones')->where("id", $order->zone_id)->first()->name;
            }
        }
        //$flags = Flags::all();
        // $state = DB::table($prifix . '_zones')->where("status", 1)->orderBy("name", "asc")->get(["id", "name", "country_id"]);
        $country = DB::table($prifix . '_countries')->where("status", 1)->get(["id", "name"]);
        $viewname = Config('constants.adminOrderView') . '.index';
        $data = ['orders' => $orders, 'payment_method' => $payment_method, 'payment_stuatus' => $payment_stuatus, 'ordersCount' => $ordersCount, 'order_status' => $order_status, 'order_options' => $order_options, 'country' => $country];
        return Helper::returnView($viewname, $data);
    }

    public function add() {
        $order = new Order();
        $action = route("admin.order.save");
        return view(Config('constants.adminOrderView') . '.addEdit', compact('order', 'products', 'action'));
    }

    public function checkOut() {
        $phone = Input::get('mobile');
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $addtable = 'has_addresses';
        //$selectAddress= $addtable.'.firstname', $addtable.'.lastname', $addtable.'.address1', $addtable.'.address2', $addtable.'.phone_no', $addtable.'.city';
        if (!is_null($phone)) {
            $user = User::where('telephone', $phone)->first();
            //  ->join($addtable,$prifix.'_users.id','=',$addtable.'.user_id')->select($prifix.'_users.*',$addtable.'.firstname', $addtable.'.lastname', $addtable.'.address1', $addtable.'.address2', $addtable.'.phone_no', $addtable.'.city', $addtable.'.postcode', $addtable.'.country_id')->first();

            if (!is_null($user)) {
                $address = Address::find('user_id', $user->id)->first();

                if (count($address) > 0) {
                    $address->countryName = @DB::table($prifix . "_countries")->where("id", $address->country_id)->first()->name;
                    $address->stateName = @DB::table($prifix . "_zones")->where("id", $address->zone_id)->first()->name;
                    $user->address = $address;
                }
                $cashBack = DB::table("has_cashback_loyalty")->where("store_id", $merchant->id)->where("user_id", $user->id)->first();
                $data = ['status' => 1, 'cashback' => $cashBack->cashback, 'user' => $user];
            } else {
                $password = Hash::make('asdf1234');
                $user = User::findOrNew(Input::get("id"));
                $user->telephone = $phone;
                $user->user_type = 2;
                $user->password = $password;
                $user->status = 1;
                $user->save();
                $data = ['status' => 0, 'cashback' => 0, 'user' => $user];
            }

            $viewname = '';
            return Helper::returnView($viewname, $data);
        }
    }

    public function saveOrder() {
        $marchantId = Input::get("merchantId");
        $payAmt = Input::get("pay_amt");
        $orderAmt = Input::get("order_amt");
        $cartData = Input::get("cartData");
        $couponCode = Input::get("coupon_code");
        //$cartContent = json_decode(json_encode(Input::get("cartData"),true));
        // dd($cartData);
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $order = Order::findOrNew(Input::get("id"));
        $order->user_id = 0;
        $order->order_amt = $orderAmt;
        $order->pay_amt = $payAmt;
        $order->payment_method = 1;
        $order->order_status = 1;
        $order->cart = $cartData;
        $order->payment_status = 1;
        if (Input::get('coupon_code') != '') {
            $coupon = DB::table($prifix . '_coupons')->where("coupon_code", "=", $couponCode)->first();
            $order->coupon_used = $coupon->id;
            $order->coupon_amt_used = Input::get('coupon_amt');
        }
        $order->additional_charge = Input::get("additional_charge");
        $order->discount_type = Input::get("disc_type") ? Input::get("disc_type") : '0';
        $order->discount_amt = Input::get("disc_amt") ? Input::get("disc_amt") : '0';
        $order->shipping_amt = Input::get("delivery_charges") ? Input::get("delivery_charges") : '0';
        $order->prefix = $prifix;
        $order->store_id = $merchant->id;
        $order->save();
        $this->updateStock($cartData, $prifix, $order->id,$merchant->id);
        $cartContent = json_decode($cartData);
        $subtotal = 0;
        foreach ($cartContent as $cart) {
            $subtotal += $cart->subtotal;
        }
        $order->subtotal = $subtotal;
        $storePath = base_path() . '/merchants/' . $merchant->url_key;
        $store = Helper::getStoreSettings($storePath)['storeName'];
        $contact = DB::table($prifix . '_static_pages')->where("status", "1")->where("url_key", "contact-us")->first();
        $order->storeName = $store;
        if (count($contact) > 0) {
            $order->contact = @$contact->contact_details;
        }

        $taxtDetails = DB::table($prifix . '_tax')->where("status", "1")->get();
        $data = ["status" => "1", "msg" => "order successfully placed", 'order' => $order, 'taxtDetails' => $taxtDetails];
        $viewname = '';
        return Helper::returnView($viewname, $data);
    }

    public function checkOutSaveOrder() {
        $marchantId = Input::get("merchantId");
        $payAmt = Input::get("pay_amt");
        $orderAmt = Input::get("order_amt");
        $cartData = Input::get("cartData");
        $couponCode = Input::get("coupon_code");
        //$cartContent = json_decode(json_encode(Input::get("cartData"),true));
        // dd($cartData);
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $order = Order::findOrNew(Input::get("id"));
        if (Input::get("address1")) {
            $address['user_id'] = Input::get("user_id");
            $address['firstname'] = Input::get("fname") ? Input::get("fname") : '';
            $address['lastname'] = Input::get("lname") ? Input::get("lname") : '';

            $address['address1'] = Input::get("address1");
            $address['address2'] = Input::get("address2") ? Input::get("address2") : '';
            $address['address3'] = Input::get("address3") ? Input::get("address3") : '';
            $address['phone_no'] = Input::get("mobile");
            $address['postcode'] = Input::get("postcode") ? Input::get("postcode") : '';
            $address['city'] = Input::get("city") ? Input::get("city") : '';
            $address['country_id'] = Input::get("countryId") ? Input::get("countryId") : '';
            $address['zone_id'] = Input::get("zoneId") ? Input::get("zoneId") : '';
            $address['updated_at'] = \Carbon\Carbon::now();

            if (Input::get("address_id")) {

                DB::table($prifix . '_has_addresses')->where("id", Input::get("address_id"))->update($address);
            } else {
                $address['created_at'] = \Carbon\Carbon::now();
                DB::table($prifix . '_has_addresses')->insert($address);
            }
            //$dfgdf= DB::table($prifix.'_orders')->get();
            // dd($dfgdf);
            $order->address1 = Input::get("address1");
        }

        $order->user_id = Input::get("user_id");
        $order->order_amt = $orderAmt;
        $order->pay_amt = $payAmt;
        $order->payment_method = 1;
        $order->order_status = 1;
        $order->cart = Input::get("cartData");
        $order->additional_charge = Input::get("additional_charge");
        $order->payment_status = 1;
        $order->first_name = Input::get("fname") ? Input::get("fname") : '';
        $order->last_name = Input::get("lname") ? Input::get("lname") : '';

        $order->address2 = Input::get("address2");
        $order->address3 = Input::get("address3");
        $order->phone_no = Input::get("mobile");
        $order->postal_code = Input::get("postcode");
        $order->city = Input::get("city") ? Input::get("city") : '';
        $order->email = Input::get("email") ? Input::get("email") : '';
        $order->country_id = Input::get("countryId") ? Input::get("countryId") : '';
        $order->zone_id = Input::get("zoneId") ? Input::get("zoneId") : '';
        if (Input::get('coupon_code') != '') {
            $coupon = DB::table($prifix . '_coupons')->where("coupon_code", "=", $couponCode)->first();
            $order->coupon_used = $coupon->id;
            $order->coupon_amt_used = Input::get('coupon_amt');
        }
        if (Input::get('apply-loyalty') == '1') {
            $userCashback = Helper::getUserCashBack($prifix, Input::get('mobile'), Input::get('user_id'));

            if ($userCashback['status'] == 1 && $userCashback['cashback'] > 0) {
                $user = DB::table($prifix . '_users')->where('telephone$user', Input::get('mobile')); //GET USER
                if ($userCashback['cashback'] >= $payAmt) {
                    $order->pay_amt = 0;
                    $order->cashback_used = $payAmt;
                    $cashbackRemained = $userCashback['cashback'] - $payAmt;
                } else if ($userCashback['cashback'] < $payAmt) {
                    $order->pay_amt = $payAmt - $userCashback['cashback'];
                    $order->cashback_used = $userCashback['cashback'];
                    $cashbackRemained = 0;
                }

                DB::table($prifix . '_users')->where("id", Input::get("user_id"))->update(['cashback' => $cashbackRemained]);
            } else {
                $order->cashback_used = 0;
            }
            //echo "Applied";
        } else {
            $order->pay_amt = $payAmt;
        }

        $order->discount_type = Input::get("disc_type") ? Input::get("disc_type") : '0';
        $order->discount_amt = Input::get("disc_amt") ? Input::get("disc_amt") : '0';
        $order->cashback_earned = Input::get("apply-loyalty") ? Input::get("apply-loyalty") : '0';
        $order->shipping_amt = Input::get("delivery_charges") ? Input::get("delivery_charges") : '0';
        $order->prefix = $prifix;
        $order->store_id = $merchant->id;

        $order->save();


        $orderData = DB::table($prifix . '_orders')->orderBy("id", "desc")->first();
        $this->updateStock($cartData, $prifix, $order->id,$merchant->id);
        $cartContent = json_decode($cartData);
        $subtotal = 0;
        foreach ($cartContent as $cart) {
            $subtotal += $cart->subtotal;
        }
        $orderData->subtotal = $subtotal;
        $storePath = base_path() . '/merchants/' . $merchant->url_key;
        $store = Helper::getStoreSettings($storePath)['storeName'];
       $contact = DB::table($prifix . '_static_pages')->where("status", "1")->where("url_key", "contact-us")->first();
        $order->storeName = $store;
        if (count($contact) > 0) {
            $order->contact = $contact->contact_details;
        }

        $taxtDetails = DB::table($prifix . '_tax')->where("status", "1")->get();
        $data = ["status" => "1", "msg" => "order successfully placed", 'order' => $orderData, 'taxtDetails' => $taxtDetails];
        $viewname = '';
        return Helper::returnView($viewname, $data);
    }

    public function edit() {
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
        $order = Order::findOrFail(Input::get('id'));
//        $usersA = User::get()->toArray();
//        $users = [];
//        foreach ($usersA as $val) {
//            $users[$val['id']] = $val['firstname'] . $val['lastname'];
//        }
        Cart::instance("shopping")->destroy();
        $coupons = Coupon::whereDate('start_date', '<=', date("Y-m-d"))->where('end_date', '>=', date("Y-m-d"))->get();
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
        $flag_status = [];
        foreach ($flags as $val) {
            $flag_status[$val['id']] = $val['flag'];
        }
        $courier = Courier::where('status', 1)->get()->toArray();
        $courier_status = [];
        foreach ($courier as $val) {
            $courier_status[$val['id']] = $val['name'];
        }
        $additional = json_decode($order->additional_charge, true);
        $products = $order->products;
        $coupon = Coupon::find($order->coupon_used);
        $action = route("admin.orders.save");
        // return view(Config('constants.adminOrderView') . '.addEdit', compact('order', 'action', 'payment_methods', 'payment_status', 'order_status', 'countries', 'zones', 'products', 'coupon')); //'users', 
        $viewname = Config('constants.adminOrderView') . '.addEdit';
        $data = ['order' => $order, 'action' => $action, 'payment_methods' => $payment_methods, 'payment_status' => $payment_status, 'order_status' => $order_status, 'countries' => $countries, 'zones' => $zones, 'products' => $products, 'coupon' => $coupon, 'coupons' => $coupons, 'flags' => $flag_status, 'courier' => $courier_status, 'additional' => $additional];
        return Helper::returnView($viewname, $data);
    }

    public function save() {
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
                'updated_at' => \Carbon\Carbon::now()->toDateTimeString()
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
            $orderUpdateCart->products()->detach();
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
                } if ($cart->options->combos) {
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
                } if ($checkPrd->prod_type == 1) {
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
                $orderUpdateCart->products()->attach($cart->id, $cart_ids[$cart->id]);
            }


            Cart::instance("shopping")->destroy();
            Session::forget('orderId');
            Session::forget('usedCouponId');
            Session::forget('individualDiscountPercent');
        } else {

            $order = Order::findOrNew(Input::get('id'));
            $orderStatus = $order->order_status;
            $updateOrder = $order->fill(Input::all())->save();

            if (Input::get('order_status') && $updateOrder == TRUE && $orderStatus != Input::get('order_status')) {
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

    public function addCartForCoupon() {
        $cartdata = Input::get('cartdata');
    }

    public function updateRetutnQty() {

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
            Session::flash("message", "Order Quantity Updated Sucessfully!");
        }
        return redirect()->route('admin.orders.view');
    }

    public function revertReturnQty() {
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

    public function delete() {
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

    public function updateOrderstatus() {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $orderIds = Input::get('orderId');
        if ($orderIds) {
            $order = DB::table($prifix . "_orders")->find($orderIds);
            $payment['order_status'] = Input::get("order_status");
            DB::table($prifix . "_orders")->where("id", $orderIds)->update($payment);
            $orderStatus = DB::table($prifix . "_order_status")->find(Input::get("order_status"))->order_status;
            $data = ['status' => 1, "msg" => "Order order status updated sucessfully!", 'orderStatus' => $orderStatus];
        } else {
            $data = ['status' => 0, "msg" => "Opps something went wrong!"];
        }

        return $data;
        // $statusHistory = ['order_id' => $id, 'status_id' => $orderStatus, 'remark' => $remark, 'notify' => $notify, 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')];
        // OrderStatusHistory::insert($statusHistory);
    }

    public function updatePaymentStatus() {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $orderIds = Input::get('orderId');

        if ($orderIds) {
            $order = DB::table($prifix . "_orders")->find($orderIds);
            $payment['payment_status'] = Input::get("payment_status");
            DB::table($prifix . "_orders")->where("id", $orderIds)->update($payment);
            $paymentStatus = DB::table($prifix . "_payment_status")->find(Input::get("payment_status"))->payment_status;
            $data = ['status' => 1, "msg" => "Order Payment status updated sucessfully!", 'paymentStatus' => $paymentStatus];
        } else {
            $data = ['status' => 0, "msg" => "Opps something went wrong!"];
        }

        return $data;
    }

    public function sendShippedMail($id, $notify) {
        $order = Order::find($id);
        $saveOrder = Order::find($id);
        $saveOrder->order_status = 2;
        $saveOrder->ship_date = date("Y-m-d");
//    dd();
        if ($saveOrder->Update()) {
//            $contactEmail = Config::get('mail.from.address');
//            $contactName = Config::get('mail.from.name');
            $website = 'www.cartini.com';
            $name = $order->users['firstname'];
            $email_id = $order->users['email'];
            $orderID = $order->id;
            $userData = User::find($order->users['id']);

            $data = array('order' => $saveOrder, 'userData' => $userData);
            if ($notify == 1) {
                if ($this->getEmailStatus == 1) {
                    $email_template = EmailTemplate::where('id', 11)->select('content')->get()->toArray()[0]['content'];
                    $tableContant = Helper::getEmailInvoice($orderID);
                    $replace = ["[firstName]", "[orderId]", "[invoice]"];
                    $replacewith = [ucfirst($name), $orderID, $tableContant];
                    $subject = "Your Order Has Been Shipped (Order ID: " . $orderID;
                    $email_templates = str_replace($replace, $replacewith, $email_template);
                    $data1 = ['email_template' => $email_templates];
                    Helper::sendMyEmail(Config('constants.adminEmails') . '.email_by_remplate', $data1, $subject, Config::get('mail.from.address'), Config::get('mail.from.name'), $email_id, $name);
                }
//                if (Mail::send(Config('constants.adminEmails') . '.dispatch_email', $data, function($message) use ($contactEmail, $contactName, $email_id, $name, $orderID) {
//                            $message->from($contactEmail, $contactName);
//                            $message->to($email_id, $name)->subject("Your Order Has Been Shipped (Order ID:" . $orderID . ")");
//                        })) {
//                    
//                }
            }
//            $msgS = "Hey! Your order has been dispatched from our warehouse. Your tracking details have been mailed to you. So sit tight. Your goodies will be with you shortly.";
//            Helper::sendSMS($order->users['telephone'], $msgS);
        }
    }

    public function simpleProduct($prod_id, $quantity) {
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

    public function comboProduct($prod_id, $quantity, $sub_prod) {
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

    public function configProduct($prod_id, $quantity, $sub_prod) {
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

    public function paymentStatus() {
        return $data['payment_method'] = PaymentMethod::get()->toArray();
    }

    public function paymentMethod() {

        return $data['payment_stuatus'] = PaymentStatus::get()->toArray();
    }

    public function updateStock($cartData, $prifix, $orderId,$storeId) {
        //$orderId = 5;
        // $is_stockable = GeneralSetting::where('id', 26)->first();
        //$cartContent = json_decode(json_encode(Input::get("cartData"),true));
        $stock_limit = DB::table($prifix . "_general_setting")->where('url_key', 'stock')->first();
        //  dd($cartData);
        $cartContent = json_decode($cartData);
        $order = DB::table("orders")->find($orderId);
        $cart_ids = [];
        // dd($cartContent);
        //  $order->products()->detach();
          DB::table("has_products")->where("order_id", $orderId)->delete();
       
        foreach ($cartContent as $cart) {
            $product = DB::table($prifix . "_products")->find($cart->id);
            //  dd($cartContent);
            $sum = 0;
            $prod_tax = array();
            $total_tax = array();
//            if (count($product->texes) > 0) {
//                foreach ($product->texes as $tax) {
//                    $prod_tax['id'] = $tax->id;
//                    $prod_tax['name'] = $tax->name;
//                    $prod_tax['rate'] = $tax->rate;
//                    $prod_tax['tax_number'] = $tax->tax_number;
//                    $total_tax[] = $prod_tax;
//                }
//            }
//            if ($cart->options->tax_type == 2) {
//                $getdisc = ($cart->options->disc + $cart->options->wallet_disc + $cart->options->voucher_disc + $cart->options->referral_disc + $cart->options->user_disc);
//                $taxeble_amt = $cart->subtotal - $getdisc;
//                $tax_amt = round($taxeble_amt * $cart->options->taxes / 100, 2);
//                $subtotal = $cart->subtotal + $tax_amt;
//            } else {
            $subtotal = $cart->subtotal;
            //   }
            $cart_ids[$cart->id] = ["order_id" => $orderId, "prod_id" => $cart->id, "qty" => $cart->qty, "price" => $subtotal, "created_at" => date('Y-m-d H:i:s'), "amt_after_discount" => $cart->options->discountedAmount, "disc" => $cart->options->disc, 'wallet_disc' => $cart->options->wallet_disc, 'voucher_disc' => $cart->options->voucher_disc, 'referral_disc' => $cart->options->referral_disc, 
                'user_disc' => $cart->options->user_disc, 'tax' => json_encode($total_tax),'store_id' =>$storeId, 'prefix' =>$prifix];
//            $market_place = Helper::generalSetting(35);
//            if (isset($market_place) && $market_place->status == 1) {
//                $prior_vendor = $product->vendorPriority()->first();
//                $vendor['order_status'] = 1;
//                $vendor['tracking_id'] = 1;
//                $vendor['vendor_id'] = is_null($prior_vendor) ? null : $prior_vendor->id;
//                $cart_ids[$cart->id] = array_merge($cart_ids[$cart->id], $vendor);
//            }
            if ($cart->options->sub_prod) {
                $cart_ids[$cart->id]["sub_prod_id"] = $cart->options->sub_prod;
                $proddetails = [];
                $prddataS = DB::table($prifix . "_products")->find($cart->options->sub_prod);
                $proddetails['id'] = $prddataS->id;
                $proddetails['name'] = $prddataS->product;
                $proddetails['image'] = $cart->options->image;
                $proddetails['price'] = $cart->price;
                $proddetails['qty'] = $cart->qty;
                $proddetails['subtotal'] = $subtotal;
                $proddetails['is_cod'] = $prddataS->is_cod;
                $cart_ids[$cart->id]["product_details"] = json_encode($proddetails);
                //$date = $cart->options->eNoOfDaysAllowed;
                // $cart_ids[$cart->id]["eTillDownload"] = date('Y-m-d', strtotime("+ $date days"));
                $cart_ids[$cart->id]["prod_type"] = $cart->options->prod_type;
                $prd = DB::table($prifix . "_products")->find($cart->options->sub_prod);
                $prd->stock = $prd->stock - $cart->qty;
                if ($prd->is_stock == 1) {
                    DB::table($prifix . "_products")->where("id", $cart->options->sub_prod)->update(['stock' => $prd->stock]);
                    // $prd->update();
                }

//                $stockLimit = json_decode($stock_limit->details, TRUE);
//
//                if ($prd->stock <= $stockLimit['stocklimit'] && $prd->is_stock == 1) {
//                    $this->AdminStockAlert($prd->id);
//                }
            } else if ($cart->options->combos) {
                $sub_prd_ids = [];
                foreach ($cart->options->combos as $key => $val) {
                    if (isset($val['sub_prod'])) {
                        array_push($sub_prd_ids, (string) $val['sub_prod']);
                        $prd = DB::table($prifix . "_products")->find($val['sub_prod']);
                        $prd->stock = $prd->stock - $cart->qty;
                        if ($prd->is_stock == 1) {
                            DB::table($prifix . "_products")->where("id", $val['sub_prod'])->update(['stock' => $prd->stock]);
                            // $prd->update();
                        };
//                        $stockLimit = json_decode($stock_limit->details, TRUE);
//
//                        if ($prd->stock <= $stockLimit['stocklimit'] && $prd->is_stock == 1) {
//                            $this->AdminStockAlert($prd->id);
//                        }
                    } else {
                        $prd = DB::table($prifix . "_products")->find($key);
                        $prd->stock = $prd->stock - $cart->qty;
                        if ($prd->is_stock == 1) {
                            DB::table($prifix . "_products")->where("id", $key)->update(['stock' => $prd->stock]);
                            //  $prd->update();
                        }
//                        $stockLimit = json_decode($stock_limit->details, TRUE);
//
//                        if ($prd->stock <= $stockLimit['stocklimit'] && $prd->is_stock == 1) {
//                            $this->AdminStockAlert($prd->id);
//                        }
                    }
                }
                $cart_ids[$cart->id]["sub_prod_id"] = json_encode($sub_prd_ids);
            } else {
                $proddetailsp = [];
                $prddataSp = DB::table($prifix . "_products")->find($cart->id);
                $proddetailsp['id'] = $prddataSp->id;
                $proddetailsp['name'] = $prddataSp->product;
                $proddetailsp['image'] = $cart->options->image;
                $proddetailsp['price'] = $cart->price;
                $proddetailsp['qty'] = $cart->qty;
                $proddetailsp['subtotal'] = $subtotal;
                $proddetailsp['is_cod'] = $prddataSp->is_cod;
                $cart_ids[$cart->id]["product_details"] = json_encode($proddetailsp);
                //$cart_ids[$cart->id]["eCount"] = $cart->options->eCount;
                // $date = $cart->options->eNoOfDaysAllowed;
                // $cart_ids[$cart->id]["eTillDownload"] = date('Y-m-d', strtotime("+ $date days"));
                $cart_ids[$cart->id]["prod_type"] = $cart->options->prod_type;
                $prd = DB::table($prifix . "_products")->find($cart->id);
                $prd->stock = $prd->stock - $cart->qty;
                if ($prd->is_stock == 1) {
                    DB::table($prifix . "_products")->where("id", $cart->id)->update(['stock' => $prd->stock]);
                    //   $prd->update();
                }
//                $stockLimit = json_decode($stock_limit->details, TRUE);
//
//                if ($prd->stock <= $stockLimit['stocklimit'] && $prd->is_stock == 1) {
//                    $this->AdminStockAlert($prd->id);
//                }
            }
           
            $cart_ids[$cart->id]["order_status"] = 1;
            $cart_ids[$cart->id]["order_source"] = 2;
            // $order->products()->attach($cart_ids);    
            //$order->products()->attach($cart->id, $cart_ids[$cart->id]);
            DB::table("has_products")->insert($cart_ids[$cart->id]);
        }
        return 1;
        //  $this->orderSuccess();
    }

    public static function getUserCashBack($phone = null) {
        if (!is_null($phone)) {
            $user =User::where('telephone', $phone)->with('addresses')->first();
            if (!is_null($user)) {
                $data = ['status' => 1, 'cashback' => $user->cashback, 'user' => $user];
            } else {
                $data = ['status' => 0, 'cashback' => 0, 'user' => $user];
            }
        } else {
            $user = DB::table($prifix . "_users")->where('id', $user_id = null)->with('addresses')->first();
            if (!is_null($user)) {
                $data = ['status' => 1, 'cashback' => $user->cashback, 'user' => $user];
            } else {
                $data = ['status' => 0, 'cashback' => 0, 'user' => $user];
            }
        }
        return $data;
    }

    public function returnOrder() {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $returnOrders = DB::table($prifix . "_return_order")->get();
        foreach ($returnOrders as $returnOrder) {
            $returnOrder->product = DB::table($prifix . "_products")->where("id", $returnOrder->product_id)->first()->product;
            $returnOrder->reason = DB::table($prifix . "_order_return_reason")->where("id", $returnOrder->reason_id)->first()->reason;
            $returnOrder->return_status = DB::table($prifix . "_order_return_status")->where("id", $returnOrder->return_status)->first()->status;
            $returnOrder->user = DB::table($prifix . "_users")->find(DB::table($prifix . "_orders")->where("id", $returnOrder->order_id)->pluck("user_id"));
        }
        return $data = ['returnOrder' => $returnOrders];
    }

    public function editReturnOrder() {
        $marchantId = Input::get("merchantId");
        $returnId = Input::get("returnId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $returnOrder = DB::table($prifix . "_return_order")->where("id", $returnId)->first();
        $order = DB::table($prifix . "_orders")->where("id", $returnOrder->order_id)->first();
        $order->country = @DB::table($prifix . "_countries")->where("id", $order->country_id)->first()->name;
        $order->state = @DB::table($prifix . "_zones")->where("id", $order->zone_id)->first()->name;

        $returnOrder->order = $order;
        $returnOrder->reason = DB::table($prifix . "_order_return_reason")->where("id", $returnOrder->reason_id)->first()->reason;
        $returnOrder->product = DB::table($prifix . "_products")->where("id", $returnOrder->product_id)->first()->product;
        $returnOrder->return_status = DB::table($prifix . "_order_return_status")->where("id", $returnOrder->return_status)->first()->status;
        if ($returnOrder->order_status == 3) {
            $returnOrder->exchange_info = @DB::table($prifix . "_products")->where("id", $returnOrder->exchange_product_id)->first()->product;
        } else {
            $returnOrder->exchange_info = '';
        }

        return $data = ['editreturnOrder' => $returnOrder];
    }

    public function cancelOrder() {
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $returnOrders = DB::table($prifix . "_order_cancelled")->get();
        foreach ($returnOrders as $returnOrder) {

            $returnOrder->reason = DB::table($prifix . "_order_return_reason")->where("id", $returnOrder->reason_id)->first()->reason;

            $returnOrder->user = DB::table($prifix . "_users")->find($returnOrder->uid);
        }
        return $data = ['cancelOrder' => $returnOrders];
    }

    public function orderSuccessEmail() {
        $ordId = Input::get("id");
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $order = DB::table($prifix . "_orders")->find($ordId);


        $website = 'www.cartini.com';

        $orderID = $ordId;
        $userData = DB::table($prifix . "_users")->find($order->user_id);
        $name = $order->first_name;
        $email_id = $order->email;
        $data = array('order' => $order, 'userData' => $userData);

        //  dd($data);
        $email_template = DB::table($prifix . "_email_template")->where('id', 2)->first()->content;
        $tableContant = Helper::getEmailInvoice($orderID, $prifix);
        $replace = ["[firstName]", "[orderId]", "[invoice]"];
        $replacewith = [ucfirst($name), $orderID, $tableContant];
        $subject = "Your Order Successfully placed with (Order ID: " . $orderID;
        $email_templates = str_replace($replace, $replacewith, $email_template);
        // echo $email_templates;
        //    die;
        $data1 = ['email_template' => $email_templates];
        Helper::sendMyEmail('Frontend.emails.orderSuccess', $data1, $subject, Config::get('mail.from.address'), Config::get('mail.from.name'), $email_id, $name);
        return $data = ["status" => 1, "msg", "Order success mail successfully send to your register email Id"];
    }

    public function calAditionalCharge() {

        $cartTotal = Input::get("cartTotal");
        $marchantId = Input::get("merchantId");
        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
        $prifix = $merchant->prefix;
        $addCharge = DB::table($prifix . "_general_setting")->where('url_key', 'additional-charge')->first()->status;
        $data = [];
        $price = $cartTotal;
        if ($addCharge == 0) {
            $data['total_amt'] = 0;
            return json_encode($data);
        }


        $amount = 0;
//        $charge_list = [];
        $arr = [];
        if ($addCharge == 1) {
            $charges = DB::table($prifix . "_additional_charges")->where('status', 1)->get();
            foreach ($charges as $key => $charge) {

                $charge_list = [];
                if ($charge->min_order_amt > 0) {
                    if ($price >= $charge->min_order_amt) {
                        if ($charge->type == 1) {
                            $amount += $charge->rate;
                            $charge_list['applied'] = $charge->rate;
                        } else {
                            $amount += $price * ($charge->rate / 100);
                            $charge_list['applied'] = $price * ($charge->rate / 100);
                        }
                        $charge_list['id'] = $charge->id;
                        $charge_list['label'] = $charge->label;
                        $charge_list['type'] = $charge->type;
                        $charge_list['rate'] = $charge->rate;
                        $charge_list['min_order_amt'] = $charge->min_order_amt;
                        array_push($arr, $charge_list);
//                        print_r($charge_list);
                    }
                } else {
                    if ($charge->type == 1) {
                        $amount += $charge->rate;
                        $charge_list['applied'] = $charge->rate;
                    } else {
                        $amount += $price * ($charge->rate / 100);
                        $charge_list['applied'] = $price * ($charge->rate / 100);
                    }
                    $charge_list['id'] = $charge->id;
                    $charge_list['label'] = $charge->label;
                    $charge_list['type'] = $charge->type;
                    $charge_list['rate'] = $charge->rate;
                    $charge_list['min_order_amt'] = $charge->min_order_amt;
                    array_push($arr, $charge_list);
//                    print_r($charge_list);
                }
            }
        } else {
            $amount = 0;
        }

        $data['details'] = $arr;
        $data['charges'] = $charges;
        $data['total_amt'] = $amount;
        $total_with_price = $price + $amount;
        $data['total_with_price'] = number_format($total_with_price, 2);
        $data['total'] = $total_with_price;

        return $data;
    }

//         $cartTotal=Input::get("cartTotal"); 
//        $marchantId = Input::get("merchantId");    
//        $merchant = Merchant::find(Input::get('merchantId'))->getstores()->first();
//        $prifix = $merchant->prefix;
//        $addCharge =DB::table($prifix . "_general_setting")->where('url_key','additional-charge')->first();
//        $data = [];
//        if($addCharge->status){
//           $charges = DB::table($prifix . "_additional_charges")->where('status',1)->get();
//           // $price = Input::get('price');
//           
//           $price = $cartTotal;
//           $amount= 0;
//           $charge_list = array();
//            foreach ($charges as $key => $charge) {
//                if($charge->min_order_amt > 0){
//
//                    if($price >= $charge->min_order_amt){
//                
//                        if($charge->type == 1){
//                            $charge_list[$charge->label] = $charge->rate;
//                             $amount += $charge->rate;
//                        }else{
//                         $charge_list[$charge->label] = round($price*$charge->rate/100,2);
//                            $amount += $price*$charge->rate/100; 
//                            
//                        }
//                    }
//                }else{
//                        if($charge->type == 1){
//                            $charge_list[$charge->label] = $charge->rate;
//                             $amount += $charge->rate;
//                        }else{
//                         $charge_list[$charge->label] = round($price*$charge->rate/100,2);
//                            $amount += $price*$charge->rate/100; 
//                            
//                        }
//                }
//            }
//            $data['list'] = (object)$charge_list;
//            $data['total_amt'] = round($amount,2);       
//        }
//        return $data;
//    }
}

?>
