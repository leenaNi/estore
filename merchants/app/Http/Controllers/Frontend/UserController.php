<?php

namespace App\Http\Controllers\Frontend;

use Socialite;
use Route;
use Input;
use App\Models\User;
use App\Models\OrderReturnOpenUnopen;
use App\Models\OrderReturnReason;
use App\Models\ReturnOrder;
use App\Models\Order;
use App\Models\Product;
use App\Library\Helper;
use App\Models\HasProducts;
use App\Models\DownlodableProd;
use App\Models\TempDownload;
use App\Models\GeneralSetting;
use App\Models\Notification;
use Illuminate\Http\Request;
use Auth;
use App\Http\Controllers\Controller;
use Session;
use App\Models\WishList;
use App\Models\Coupon;
use App\Models\CancelOrder;
use App\Models\Country;
use App\Models\Zone;
use App\Models\CustomerReview;
use Hash;
use Mail;
use DB;
use Response; 

class UserController extends Controller {

    public function myOrders() {
        $orders = Order::where("user_id", "=", @Session::get('loggedin_user_id'))->where("order_status", "!=", 0)->get();
        $viewname = Config('constants.frontendMyAccView') . '.my_orders';
        $data = ['orders' => $orders];
        //  dd(Helper::returnView($viewname, $data));
        return Helper::returnView($viewname, $data);
    }

    public function showItem($id = 4) {
        $retrieveItems = User::userCashback();
        return $retrieveItems;
    }

    public function my_profile() {
//        $user=User::find(Session::get('loggedin_user_id'));
//        $user->userCashback->cashback=$user->userCashback->cashback+200;
//      $user->userCashback->save();
//      dd($user); 
        $orderReturnReason = OrderReturnReason::pluck('reason', 'id');
        $user = User::find(@Session::get('loggedin_user_id'));
        $userWishlist = @User::find(Session::get('loggedin_user_id'))->wishlist;

    $newsLetter = @User::find(Session::get('loggedin_user_id'))->newsletter;
        //  dd($newsLetter);

        $countries = @Country::where('status',1)->get();
        $ShippingAddress = User::find(Session::get('loggedin_user_id'))->addresses()->get();
        $BillingAddress = User::find(Session::get('loggedin_user_id'))->billingaddresses()->get();
        $countries = Country::where("status", "=", 1)->get(['id', 'name']);
        $zoneData = Zone::where("status", "=", 1)->get(['id', 'name']);
        //  dd($userWishlist);
        $orders = Order::where("user_id", "=", @Session::get('loggedin_user_id'))->where("order_status", "!=", 0)->orderBy('id', 'desc')->get();
        //$ordersCurrency = HasCurrency::where('id',$orders->currency_id)->first();
        $viewname = Config('constants.frontendMyAccView') . '.myaccount';

 $data = ['orders' => $orders, 'user' => $user, 'wishlist' => $userWishlist, 'orderReturnReason' => $orderReturnReason,'countries'=>$countries,'ShippingAddress'=>$ShippingAddress,'BillingAddress'=>$BillingAddress,'countries'=>$countries,'states'=>$zoneData,'newsLetter' => $newsLetter];

        return Helper::returnView($viewname, $data);
    }

    public function get_zone() {
        $html = '<option value="">Please Select </option>';
        if (!empty(Input::get('country'))) {
            $country_id = Country::where("id", "=", Input::get('country'))->get(['id'])->first();

            $zone = Zone::where("country_id", "=", $country_id->id)->get(['id', 'name']);
            foreach ($zone as $key => $state) {
                $html .= '<option value="'.$state->id.'">'.$state->name.'</option>';
            }
        } else {
            $html = '<option value="">No States Found </option>';
        }
        return $html;
    }


    public function save_review(){
        $user_id = Session::get('loggedin_user_id');

        $review = CustomerReview::where(['product_id'=>Input::get('pid'),'user_id'=>Session::get('loggedin_user_id'),'order_id' => Input::get('ord_id')])->get();
        if(count($review)>0)
        {
            $data = ['title'=>Input::get('title'),'description'=>Input::get('desc'),'rating'=>Input::get('stars')];
            CustomerReview::where(['product_id'=>Input::get('pid'),'user_id'=>Session::get('loggedin_user_id'),'order_id' => Input::get('ord_id')])->update($data);
        }
        else{
            $data = CustomerReview::create([
            'user_id' => $user_id,
            'order_id' => Input::get('ord_id'),
            'product_id' => Input::get('pid'),
            'title' => Input::get('title'),
            'description' => Input::get('desc'),
            'rating' => Input::get('stars'),
            'created_at'=> date('Y-m-d H:i:s')
            ]);
        }
        return $data;
        
    }

    public function get_review()
    {
        $prod_id = Input::get('id');
        $orderid = Input::get('orderid');
        $data = CustomerReview::where(['product_id'=>$prod_id,'user_id'=>Session::get('loggedin_user_id'),'order_id' => $orderid])->first();
        return $data;
    }

    public function get_billing_address()
    {
        $html = '';
        $addressesData = User::find(Session::get('loggedin_user_id'))->billingaddresses()->get();
        foreach ($addressesData as $key => $badddress) {
            $html .= '<div class="col-md-4">
                    <div class="adrs_col"> 
                        <h1 class="bxtitle">
                            <div class="pull-left"><label class="addL m100none" for="radio2" ><input type="radio" name="default_billing" '.($badddress->is_default_billing==1?'checked':'').'><span></span>Address  </label></div><div class="pull-right"> 
                                <a href="#addNewBillAddForm" onclick="editAddress("'.$badddress->id.'","billing")" class="box_action"><i class="icon-edit"></i> </a><a href=""  onclick="deleteAdd('.$badddress->id.',billing)" class="box_action"><i class="icon-trash"></i> </a></div>
                            <div class="clearfix"></div></h1>
                        <div class="adrs_cont"  style="cursor:pointer;">';
            $html .=    '<p>'.$badddress->firstname.' '.$badddress->lastname.'</p>
                        <p>'.$badddress->address1.'</p>
                        <p>'.$badddress->address2.'</p>';
                           
                            $country = Country::find($badddress->country_id);
                            $zone = Zone::find($badddress->zone_id);
                           
            $html .=        '<p>'.$country->name.'</p>
                            <p>'.$zone->name.'</p> 
                            <p>'.$badddress->city.'</p> 
                            <p>'.$badddress->thana. ' - '.$badddress->postcode.'</p>
                            <p>Mobile No:'.$badddress->phone_no.'</p>
                        </div>

                    </div>
                </div>';
        }
        return $html;
    }

    public function get_shipping_address()
    {
        $html = '';
        $addressesData = User::find(Session::get('loggedin_user_id'))->addresses()->get();
        foreach ($addressesData as $key => $sadddress) {
            $html .= '<div class="col-md-4">
                    <div class="adrs_col"> 
                        <h1 class="bxtitle">
                            <div class="pull-left"><label class="addL m100none" for="radio2"><input type="radio" name="default_shipping" '.($sadddress->is_default_shipping==1?'checked':'').'><span></span>Address  </label></div><div class="pull-right"> 
                                <a href="#addNewBillAddForm"  class="box_action"><i class="icon-edit"></i> </a><a href=""  onclick="deleteAdd('.$sadddress->id.',shipping);" class="box_action"><i class="icon-trash"></i> </a></div>
                            <div class="clearfix"></div></h1>
                        <div class="adrs_cont"  style="cursor:pointer;">';
            $html .=    '<p>'.$sadddress->firstname.' '.$sadddress->lastname.'</p>
                        <p>'.$sadddress->address1.'</p>
                        <p>'.$sadddress->address2.'</p>';
                           
                            $country = Country::find($sadddress->country_id);
                            $zone = Zone::find($sadddress->zone_id);
                           
            $html .=        '<p>'.$country->name.'</p>
                            <p>'.$zone->name.'</p> 
                            <p>'.$sadddress->city.'</p> 
                            <p>'.$sadddress->thana. ' - '.$sadddress->postcode.'</p>
                            <p>Mobile No:'.$sadddress->phone_no.'</p>
                        </div>

                    </div>
                </div>';
        }
        return $html;
    }

    public function addToWishlist() {

        if (!User::find(Session::get('loggedin_user_id')))
            return "login";
        if (!User::find(Session::get('loggedin_user_id'))->wishlist->contains(Input::get("prodid"))) {
            User::find(Session::get('loggedin_user_id'))->wishlist()->attach(Input::get("prodid"));
            echo 1;
        } else {
            User::find(Session::get('loggedin_user_id'))->wishlist()->detach(Input::get("prodid"));
            echo 0;
        }
    }

    public function removeWishlist() {
        User::find(Session::get('loggedin_user_id'))->wishlist()->detach(Input::get("prodid"));
        echo 0;
    }

    public function wishlists() {
        Session::get('loggedin_user_id');
        $userWishlist = User::find(Session::get('loggedin_user_id'))->wishlist;
        //  print_r($userWishlist);
        $data = ['whislist' => $userWishlist];
        $viewname = Config('constants.frontendMyAccView') . '.wishlists';
        return Helper::returnView($viewname, $data);
    }

    public function orderDetails($id) {
        $checkCancelOrder = CancelOrder::where("order_id", $id)->get();
        $returnPolicy = @GeneralSetting::where("type", 6)->first()->details;
        $returnProductStatus = GeneralSetting::where('url_key', 'return-product')->where('status', 1)->get();
        $orderReturnReason = OrderReturnReason::pluck('reason', 'id');
        $getid = $id;
        $order = Order::where('orders.id', $getid)->with('orderStatHist')->first();


        $prod_id = HasProducts::where('order_id', $getid)->where("prefix", $this->jsonString['prefix'])->pluck("prod_id");

        $products = Product::whereIn("id", $prod_id)->with([
                    'subproducts' => function ($query) {
                        $query->with(['attributes' => function($q) {
                                $q->where("is_filterable", 1)->with('attributevalues')->with('attributeoptions');
                            }])->with('attributevalues');
                    }, 'catalogimgs' => function ($query) {
                        $query->where("image_mode", 1);
                    }, 'attributeset' => function($qa) {
                        $qa->with(["attributes" => function($qattr) {
                                $qattr->where("is_filterable", 1)->with('attributevalues')->with('attributeoptions');
                            }]);
                    }
                        ])->get();
                //dd($products);
                $collectOrderProduct = [];
                //dd($order->orderStatHist);
                if (isset($products) && count($products) > 0)
                    foreach ($products as $getProduct):
                        $collectOrderProduct[$getProduct->id] = $getProduct;
                    endforeach;
                // dd($collectOrderProduct);
                $this->order_id = $getid;
                $getReturnRequest = ReturnOrder::where("order_id", $getid)->with('return_status_id', 'exchangeProduct')->get();
                $getReturnRequestSum = ReturnOrder::select('return_order.*', DB::raw('sum(quantity) as quantityAdd'))->where("order_id", $getid)->groupBy('sub_prod')->pluck('sub_prod', 'sub_prod');
                $returnSumqty = ReturnOrder::select('return_order.*', DB::raw('sum(quantity) as quantityAdd'))->where("order_id", $getid)->groupBy('sub_prod')->pluck('quantity', 'sub_prod');
                // dd($getReturnRequestSum);
                $coupon = Coupon::find($order->coupon_used);
                $data = ['order' => $order, 'coupon' => $coupon, 'orderReturnReason' => $orderReturnReason, 'getReturnRequest' => $getReturnRequest, 'getReturnRequestSum' => $getReturnRequestSum, 'returnProductStatus' => $returnProductStatus, 'collectOrderProduct' => $collectOrderProduct, "checkCancelOrder" => $checkCancelOrder, 'returnSumqty' => $returnSumqty];
                $viewname = Config('constants.frontendMyAccView') . '.order_details';
                return Helper::returnView($viewname, $data);
                //return view(Config('constants.frontendMyAccView') . '.order_details', compact('order', 'coupon'));
            }

            function orderDetails_json() {
                $id = Input::get('id');
                $days = GeneralSetting::find(21);
                $day_check = Order::where('id', $id)->select('id', 'pay_amt', 'user_id', 'payment_status', 'order_status', 'created_at', 'updated_at')->get()->toArray();
                $date = $day_check[0]['updated_at'];
                $expire_date = strtotime("$date + $days->details days");
                // print_r($expire_date);
                $current_date = time();
                // dd($current_date);
                if ($day_check[0]['order_status'] == 3 || $day_check[0]['order_status'] == 11) {
                    if ($current_date <= $expire_date && $day_check[0]['payment_status'] == '4') {
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

                        $return_reason = OrderReturnReason::all();
                        $return_open_un = OrderReturnOpenUnopen::all();

                        echo view(Config('constants.frontendMyAccView') . '.return_product', compact('output', 'return_reason', 'return_open_un'));
                    } else {
                        echo 'Product return date has expired on ' . date('d-m-Y', $expire_date) . ' and Order Status is still pending.';
                    }
                } else {
                    echo 'Your order is in process';
                }
            }

            function order_return_cal() {
                $getProdut = Input::get('return_product');
                $orderId = Input::get('oid');

                $order = order::where("id", $orderId)->select("id", "coupon_used", "coupon_amt_used")->get();
//       $coupon = Coupon::find($order[0]->coupon_used)->categories()->get();
//die;
                foreach ($getProdut as $prodId => $d) {
                    if (isset($d)) {
                        $return = new ReturnOrder();
                        $return->order_id = $orderId;
                        $return->product_id = $prodId;
                        $return->quantity = $d['quantity'];
                        $return->return_amount = $d['amount'];
                        $return->exchange_product_id = @$d['exchange_product_id'];
                        $return->reason_id = $d['reason'];
                        // $return->opened_id = $d['open'];
                        $return->sub_prod = $d['sub_prod'];
                        $return->order_status = Input::get('order_status');
                        $return->return_action = 3;
                        $return->store_id = $this->jsonString['store_id'];
                        $return->prefix = $this->jsonString['prefix'];
                        $return->save();
                    }
                }

                return redirect()->back()->with("successMsg", "Return request sent successfully.");
            }

            function editorder_return($id) {
                echo $f = Input::get('id');
            }

            function update_return_order_statusf() {
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
                            $return->reason_id = $return_qnty['reason'];
                            $return->opened_id = $return_qnty['opened'];
                            $return->remark = $return_qnty['remark'];
                            $return->return_status = 4;
                            $return->store_id = $this->jsonString['store_id'];
                            $return->prefix = $this->jsonString['prefix'];
                            $return->save();
                        }
                    }
                }
            }

            public function editProfile() {
                $user = User::find(Session::get('loggedin_user_id'));
                // print_r($user);
                // return view(Config('constants.frontendMyAccView') . '.edit_profile', compact('user'));
                $viewname = Config('constants.frontendMyAccView') . '.edit_profile';
                $data = ['user' => $user];
                return Helper::returnView($viewname, $data);
            }

            public function updateProfile() {
                // return User::where('id',Session::get('loggedin_user_id'))->get(['firstname','lastname','telephone']);
                $newlet = 0;
                if(Input::has('newsletchk')){
                    $newlet = Input::get('newsletchk');
                }
                $userupdate = User::find(Session::get('loggedin_user_id'));
                $userupdate->firstname = Input::get('firstname');
                $userupdate->lastname = Input::get('lastname');
                $userupdate->telephone = Input::get('telephone');
                $userupdate->anniversary_date = Input::get('anniversary_date');
                $userupdate->date_of_birth = Input::get('dob');
                $userupdate->newsletter = $newlet;
                //dd($userupdate->email);
                if (empty($userupdate->email)) {
                    if (count(User::where("email", Input::get('email'))->get()) == 0) {
                        $userupdate->email = Input::get('email');
                    } else {
                        $data = ['status' => 'error', 'msg' => "Email already exists!", 'user' => $userupdate];
                        return $data;
                    }
                }

                $userupdate->update();
                if($newlet == 0){
                    $usernotification = Notification::where('email',Input::get('email'))->first();
                    if($usernotification != null)
                    {
                        $usernotification->deleted_at = 1;
                        $usernotification->status = 0;
                        $usernotification->update();
                    }
                    
                }else{
                    $usernotification = Notification::where('email',Input::get('email'))->first();
                    $usernotification->deleted_at = 0;
                    $usernotification->status = 1;
                    $usernotification->update();
                }
                
                Session::flash('updateSucess', "Profile updated successfully");
                $data = ['status' => 'success', 'msg' => "Profile updated successfully", 'user' => $userupdate];
                return $data;

//        return redirect()->back();
            }

            public function changePasswordMyAcc() {
                return view(Config('constants.frontendMyAccView') . '.change_password');
            }

            public function updateMyaccChangePassword() {
                $email = Input::get('email');
                $telephone = Input::get('telephone');
                // $user = User::where('email', '=', $email)->first();
                $password = Input::get('password');
                $conf_password = Input::get('conf_password');
                $old_password = Input::get('old_password');
                $user_details = User::where("telephone", "=", $telephone)->first();
                $check = (Hash::check(Input::get('old_password'), $user_details->password));
                if ($check == true) {
                    if ((Input::get('password')) == Input::get('conf_password')) {
                        $user = User::find($user_details->id);
                        $user->password = Hash::make(Input::get('password'));
                        //   $user->Update();
                        // return 1;
                        // Session::flash('updateProfileSuccess', 'Password updated successfully');
                        return $result = ['status' => 'success', 'msg' => 'Password updated successfully'];
                    } else {
                        //  return 0;
                        // Session::flash('PasswordError', 'Password and Confirm Password does not match');
                        return $result = ['status' => 'nomatch', 'msg' => 'Password and Confirm Password does not match'];
                    }
                } else {

                    return $result = ['status' => 'error', 'msg' => 'Incorrect Old Password'];
                }
            }

            public function myaccFeedback() {
                return view(Config('constants.frontendMyAccView') . '.feedback');
            }

            public function saveFeedbackMyacc() {
                //dd(Input::all());
                $content = "Hi, \n\n";
                $content .= "Subject: " . @Input::get('subject') . "\n\n";
                $content .= "Message: " . @Input::get('message') . "\n\n";
                $emailStatus = GeneralSetting::where('url_key', 'email-facility')->first()->status;
                if ($emailStatus == 1) {
                    Mail::raw($content, function ($message) {
                        $message->from("info@cartini.com")
                                ->to("tapodnya@infiniteit.biz") // admin email id
                                ->subject("Feedback From Customer");
                        if (Input::hasFile('image')) {
                            $message->attach(Input::file('image')->getRealPath(), array(
                                'as' => 'uploadedfile.' . Input::file('image')->getClientOriginalExtension(),
                                'mime' => Input::file('image')->getMimeType())
                            );
                        }
                    });
                }
                return redirect()->back()->with("msg", "Message has been sent successfully");
            }

            public function downloadEfiles() {
                $orderId = input::get('f');
                $productId = input::get('i');
                //  DB::enableQueryLog();
                $f = HasProducts::with('getProduct')->where('order_id', $orderId)->where('prod_id', $productId)->get()->toArray();
                if ($f[0]['eCount'] >= $f[0]['get_product']['eCount']) {
                    echo json_encode(array("errCode" => 0, "msg" => "no of count over"));
                } else if (strtotime($f[0]['eTillDownload']) <= time()) {
                    echo json_encode(array("errCode" => 1, "msg" => "date expire"));
                } else {
                    $addCount = $f[0]['eCount'] + 1;
                    DB::table('has_products')->where('order_id', $orderId)->where('prod_id', $productId)->update(['eCount' => $addCount]);
                    $q = DownlodableProd::where('prod_id', $productId)->select('image_d')->get()->toArray();
                    $uniq = uniqid();
                    $id = DB::table('tempdownload')->insertGetId(['product_id' => $productId, 'key_url' => $uniq]);
                    echo json_encode(array("errCode" => 2, "msg" => $uniq));
                }
            }

            public function fileDownload(request $resquest, $g) {
                //  echo "<pre>";
                $f = TempDownload::with('productBelong')->where('key_url', $g)->get()->toArray();
                if (count($f) == 0 || $f[0]['status'] == 1) {
                    echo "Your download Url has expired";
                } else {
                    $s = $f[0]['product_belong']['image_d'];
                    DB::table('tempdownload')->where('key_url', $g)->update(['status' => 1]);
                    $path = public_path('Admin/uploads/catalog/products/' . $s);
                    return( Response::download($path) );
                }
            }

            function cashback_history() {
                $days = GeneralSetting::find(21);
                $orders = Order::where(['user_id' => Session::get('loggedin_user_id'), 'loyalty_cron_status' => 0])
                        ->get();
                return view(Config('constants.frontendMyAccView') . '.cashback_history', compact('orders'));
            }

            public function cancelOrder() {
                $ordId = Input::get('ordId');
                $updateOrder = DB::table('orders')
                        ->where('id', $ordId)
                        ->update(['order_status' => 4]);
                if ($updateOrder)
                // return 1;
                    return $result = ['status' => 'success', 'msg' => 'Order cancelled.'];
                else
                    return $result = ['status' => 'error', 'msg' => 'Oops, Please try again'];
            }

            public function updateProfileImage() {
                $user = User::find(Session::get('loggedin_user_id'));
                if (Input::hasFile('user_profile')) {
                    $unlinkFile = Session::get('loggedin_user_id') . '_*.*';
                    array_map('unlink', glob($unlinkFile));
                    $destinationPath = public_path() . '/Frontend/images/';
                    $fileName = Session::get('loggedin_user_id') . "_." . @Input::file('user_profile')->getClientOriginalExtension();
                    $upload_success = @Input::file('user_profile')->move(@$destinationPath, @$fileName);
                } else {

                    $fileName = null;
                }
                if (is_null($fileName)) {
                    $user->profile = $fileName;
                }

                $user->save();
                return $result = ['status' => 'success', 'msg' => 'Profile photo updated successfully', 'img' => $user->profile];
            }

            public function statusOrderCancel() {
                $cancelOrder = new CancelOrder;
                $cancelOrder->order_id = @Input::get("orderId");
                $cancelOrder->reason_id = @Input::get("reasonId");
                $cancelOrder->uid = @Session::get('loggedin_user_id');
                $cancelOrder->remark = @Input::get("remark");
                $cancelOrder->return_amount = @Input::get("returnAmount");
                $cancelOrder->status = 0;
                $cancelOrder->store_id = $this->jsonString['store_id'];
                $cancelOrder->prefix = $this->jsonString['prefix'];
                $cancelOrder->save();
                return redirect()->back()->with("successMsg", "Cancel request sent successfully.");
            }

        }
        
