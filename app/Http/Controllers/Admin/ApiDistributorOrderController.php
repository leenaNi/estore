<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Library\Helper;
use App\Models\Order;
use App\Models\User;
use App\Models\Store;
use App\Models\Product;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Address;
use Cart;
use DB;
use Input;
use stdClass;
use Session;

class ApiDistributorOrderController extends Controller
{
    public function index()
    {
        $jsonString = Helper::getSettings();
    }
    
    public function orderDetails(){
        $orderId = Input::get('orderId');
        if($orderId != null){
        $data = [];
        $orderDetails = DB::table('orders')->where('id',$orderId)->first();
        $orderedProduct = DB::table('has_products')->where('order_id',$orderId)->get();
            if(count($orderedProduct) > 0){
                $temp = [];
                foreach($orderedProduct as $prod){
                    $temp[] = $this->getProduct($prod->prod_id);
                    
                } //product foreach ends here
                $orderDetails->products = $temp;
                if (count($orderDetails) > 0) {
                    return response()->json(["status" => 1, 'data' => $orderDetails]);
                }               
            }else {
                    return response()->json(["status" => 2, 'msg' => 'Product not found']);
            }
        } else {
                return response()->json(["status" => 0, 'msg' => 'Mandatory fields are missing.']);
            }
    }

    public function shippingAddressDetails()
    {
        $userId = Input::get('userId');
        if($userId > 0)
        {
            //get list of shipping address details
            $data = DB::table("has_addresses")->where('user_id',Input::get('userId'))->get();
            if(count($data)>0){
                return response()->json(["status" => 1, 'data' => $data]);
            }
            else{
                return response()->json(["status" => 2, 'msg' => 'Shipping address not found']);
            }
        }
        else{
            return response()->json(["status" => 0, 'msg' => 'Mandatory fields are missing.']);
        }

    }

    public function addShippingAddressDetails()
    {
        $shippingAddress = [];
        $userId = Input::get('userId');
        $action = Input::get('action');
        if($userId > 0 && ($action != ''))
        {
            if(Input::get('firstname') != '')
            {
                //insert data into has_address table
                $userId = Input::get('userId');
                $firstName = Input::get('firstname');
                $lastName = Input::get('lastname');
                $address1 = Input::get('address1');
                $address2 = Input::get('address2');
                $phoneNo = Input::get('phone_no');
                $cityName = Input::get('city');
                $pincode = Input::get('pincode');
                $stateId = Input::get('state_id');

                //insert data into has_address table
                $shippingAddress["user_id"] = $userId;
                $shippingAddress["firstname"] = $firstName;
                $shippingAddress["lastname"] = $lastName;
                $shippingAddress["address1"] = $address1;
                $shippingAddress["address2"] = $address2;
                $shippingAddress["phone_no"] = $phoneNo;
                $shippingAddress["city"] = $cityName;
                $shippingAddress["postcode"] = $pincode;
                $shippingAddress["zone_id"] = $stateId;
                
                if($action == 'add')
                {
                    $lastInsertedId = DB::table('has_addresses')->insertGetId($shippingAddress);
                    return response()->json(["status" => 1, 'shipping_address_id' => $lastInsertedId, 'msg' => 'Shipping Address inserted successfully.']);
                }
                else if($action == 'edit')
                {
                    if(Input::get('shipping_address_id') > 0)
                    {
                        $shippingAddressId =  Input::get('shipping_address_id');
                        $updatedShippingAddIds = DB::table('has_addresses')
                            ->where('id', $shippingAddressId)
                            ->update($shippingAddress);

                        return response()->json(["status" => 1, 'shipping_address_id' => $shippingAddressId, 'msg' => 'Shipping Address data updated successfully.']);
                    }
                    else
                    {
                        return response()->json(["status" => 3, 'msg' => 'Shipping Address id is required.']);
                    }
                    
                }//else if ends here
                
            }
            else
            {
                return response()->json(["status" => 2, 'msg' => 'First name is required.']);
            }
            
        }
        else{
            return response()->json(["status" => 0, 'msg' => 'Mandatory fields are missing.']);
        }
    }

    public function deleteShippingAddressDetails()
    {
        $shippingAddressId = Input::get('shippingAddressId');
        if($shippingAddressId > 0)
        {
            //delete row from has_addresses table
            DB::table('has_addresses')->where('id', '=', $shippingAddressId)->delete();
            return response()->json(["status" => 1, 'msg' => 'Data deleted successfully.']);
        }
        else
        {
            return response()->json(["status" => 0, 'msg' => 'Mandatory fields are missing.']);
        }
    }

    public function productDetails(){
        $prod_id = Input::get('prod_id');
        if($prod_id != null){
            $data = $this->getProduct($prod_id);
            //dd($data);
            if(!empty($data)){
                return response()->json(["status" => 1, 'data' => $data]);
            }
            else{
                return response()->json(["status" => 2, 'msg' => 'Product not found']);
            }
        }else{
            return response()->json(["status" => 0, 'msg' => 'Mandatory fields are missing.']);
        }
        
    }

    public function getProduct($prod_id){
        $productResult = DB::table('products as p')
                            ->leftJoin('brand as b', 'p.brand_id', '=', 'b.id')
                            ->where('p.id', $prod_id)
                            ->where(['p.status' => 1, 'p.is_del' => 0])
                            //->where('p.parent_prod_id',0)
                            ->orderBy('p.store_id', 'ASC')
                            ->get(['p.id', 'p.store_id', 'b.id as brand_id', 'b.name as brand_name', 'p.product', 'p.images', 'p.product_code', 'p.is_featured', 'p.prod_type', 'p.is_stock', 'p.is_avail', 'p.is_listing', 'p.status', 'p.stock', 'p.max_price', 'p.min_price', 'p.purchase_price', 'p.price', 'p.spl_price', 'p.selling_price', 'p.is_cod', 'p.is_tax', 'p.is_trending', 'p.min_order_quantity', 'p.is_share_on_mall', 'p.store_id','p.short_desc']);
        if(count($productResult) > 0)
        {
            $storeIdWithDistributorId = [];
            foreach ($productResult as $getProductData) {
                
                $storeId = $getProductData->store_id;
                $productId = $getProductData->id;

                //Get Product image
                $productResult = DB::table('catalog_images')
                    ->select(DB::raw('filename'))
                    ->where(['catalog_id' => $productId])
                    ->get();
                $productImage = '';
                $strore_name = DB::table('stores')->where('id',$storeId)->first();
                if (count($productResult) > 0) {
                    $productImage = "http://" . $strore_name->url_key . "." . $_SERVER['HTTP_HOST'] . "/uploads/catalog/products/" . $productResult[0]->filename;
                }
                
                $storeIdWithDistributorId['product_id'] = $getProductData->id;
                $storeIdWithDistributorId['brand_name'] = $getProductData->brand_name;
                $storeIdWithDistributorId['product'] = $getProductData->product;
                $storeIdWithDistributorId['images'] = $productImage;
                $storeIdWithDistributorId['product_code'] = $getProductData->product_code;
                $storeIdWithDistributorId['short_desc'] = $getProductData->short_desc;
                $storeIdWithDistributorId['is_featured'] = $getProductData->is_featured;
                $storeIdWithDistributorId['prod_type'] = $getProductData->prod_type;
                $storeIdWithDistributorId['is_stock'] = $getProductData->is_stock;
                $storeIdWithDistributorId['is_avail'] = $getProductData->is_avail;
                $storeIdWithDistributorId['is_listing'] = $getProductData->is_listing;
                $storeIdWithDistributorId['status'] = $getProductData->status;
                $storeIdWithDistributorId['stock'] = $getProductData->stock;
                $storeIdWithDistributorId['max_price'] = $getProductData->max_price;
                $storeIdWithDistributorId['min_price'] = $getProductData->min_price;
                $storeIdWithDistributorId['purchase_price'] = $getProductData->purchase_price;
                $storeIdWithDistributorId['price'] = $getProductData->price;
                $storeIdWithDistributorId['spl_price'] = $getProductData->spl_price;
                $storeIdWithDistributorId['selling_price'] = $getProductData->selling_price;
                $storeIdWithDistributorId['is_cod'] = $getProductData->is_cod;
                $storeIdWithDistributorId['is_tax'] = $getProductData->is_tax;
                $storeIdWithDistributorId['is_trending'] = $getProductData->is_trending;
                $storeIdWithDistributorId['min_order_quantity'] = $getProductData->min_order_quantity;
                $storeIdWithDistributorId['is_share_on_mall'] = $getProductData->is_share_on_mall;

                //DB::enableQueryLog(); // Enable query log
                $offersIdCountResult = DB::table('offers')
                    ->join('offers_products', 'offers.id', '=', 'offers_products.offer_id')
                    ->select('offers.*')
                    ->where('offers.status',1)
                    ->where('offers_products.prod_id', $productId)
                    ->where('offers_products.type', 1)
                    ->get();
                //dd(DB::getQueryLog()); // Show results of log

                $offerCount = 0;
                $storeIdWithDistributorId['offers_count'] = $offerCount;
                if (count($offersIdCountResult) > 0) {
                    //$offerCount = $offersIdCountResult[0]->offer_count;
                    $storeIdWithDistributorId['offers_count'] = count($offersIdCountResult);
                    $j =0;
                    foreach($offersIdCountResult as $offer){
                        $storeIdWithDistributorId['offers'][$j]['offer_id'] = $offer->id;
                        $storeIdWithDistributorId['offers'][$j]['offer_name'] = $offer->offer_name;
                        $j++;
                    }
                    
                    //$totalOfferOfAllProduct = $totalOfferOfAllProduct + $offerCount;
                }
                //product variants
                $prod = Product::find($getProductData->id);
                if($prod != null && $prod->prod_type == 3){
                    if($prod->is_stock==1 && $this->feature["stock"]==1) {
                        $subprods = $prod->getsubproducts()->get();
                    } else {
                        $subprods = $prod->subproducts()->get();
                    }        
                    foreach ($subprods as $subP) {
                        $hasOpt = $subP->attributes()->withPivot('attr_id', 'prod_id', 'attr_val')->where("status",1)->orderBy("att_sort_order", "asc")->get();
                        foreach ($hasOpt as $prdOpt) {
                            $selAttrs[$prdOpt->pivot->attr_id]['placeholder'] = Attribute::find($prdOpt->pivot->attr_id)->placeholder;
                            $selAttrs[$prdOpt->pivot->attr_id]['name'] = Attribute::find($prdOpt->pivot->attr_id)->attr;
                            $selAttrs[$prdOpt->pivot->attr_id][Attribute::find($prdOpt->pivot->attr_id)->slug] = Attribute::find($prdOpt->pivot->attr_id)->attr;
                            $selAttrs[$prdOpt->pivot->attr_id]['options'][AttributeValue::find($prdOpt->pivot->attr_val)->option_value] = AttributeValue::find($prdOpt->pivot->attr_val)->option_name;
                            $selAttrs[$prdOpt->pivot->attr_id]['attrs'][AttributeValue::find($prdOpt->pivot->attr_val)->option_value]['prods'][] = $prdOpt->pivot->prod_id;
                            $selAttrs[$prdOpt->pivot->attr_id]['prods'][] = $prdOpt->pivot->prod_id;
                        }
                    }
                    $storeIdWithDistributorId['variants'] = $selAttrs;
                }
            }
            return $storeIdWithDistributorId;
            
        }
    }

    public function placeOrder()
    {
        $MerchantId = Session::get('merchantId');
        $DistributorID = 0;
        if (!empty($MerchantId)) {

            $user = User::find(Session::get('authUserId'));
            if ($user->cart != '') {
                $cartData = json_decode($user->cart, true);
                Cart::instance('shopping')->add($cartData);
                $storeid = 0;
                foreach($cartData as $val){
                    $store_id = $val['options']['store_id'];
                    break;
                }
                $Storeinfo = Store::find($store_id);
                $DistributorID = $Storeinfo->merchant_id;
            }else{
                return ['status' => 1, 'msg' => 'Cart is empty']; 
            }
            
            $cartData = Cart::instance("shopping")->content();
            $cartcount = Cart::instance("shopping")->count();
            $cartInfo = Cart::instance("shopping")->total();
            $cart_amt = Helper::getOrderTotal($cartData); //Helper::calAmtWithTax();
            $finalamt = Helper::getOrderTotal($cartData); //$cart_amt['total'];
            //$paymentAmt = Input::get('pay_amt');
            $paymentAmt = $finalamt;
            $paymentMethod = 8; //"9";
            $paymentStatus = "1";
            $payAmt = number_format((float)$finalamt, 2, '.', '');
            //apply additional charge to payAmount
            $additional_charge_json = $this->ApplyAdditionalCharge($payAmt);
            $additional_charge = json_decode($additional_charge_json, true);
            $payAmt = $payAmt + $additional_charge['total_amt'];

            $trasactionId = "";
            $transactionStatus = "";
            $userid = $user->id;
            //$addressid = Input::get('address_id');
            //$userinfo = User::find($userid);
            $toPay = $this->toPayment($userid);
            if (!empty($toPay['orderId'])) {
                $orderS = Order::find($toPay['orderId']);
                $orderS->created_by = $userid;
                $orderS->additional_charge = $additional_charge_json;
                $orderS->amt_paid = $paymentAmt;
                $orderS->order_type = 1;
                $orderS->description = '';
                $orderS->order_status = 31; //processing
                $orderS->update();
                if ($paymentMethod == '10') {
                    $userinfo->credit_amt = $userinfo->credit_amt + ($payAmt - $paymentAmt);
                    $userinfo->update();
                    // $paymentHistory = PaymentHistory::create();
                    // $paymentHistory->order_id = $orderS->id;
                    // $paymentHistory->pay_amount = $paymentAmt;
                    // $paymentHistory->added_by = $userid;
                    // $paymentHistory->save();
                }
                $succ = $this->saveOrderSuccess($paymentMethod, $paymentStatus, $payAmt, $trasactionId, $transactionStatus, $userid, $orderS->id, $DistributorID);
                Cart::instance("shopping")->destroy();

            }

            if ($succ['orderId']) {

                $order = Order::find($succ['orderId']);
                $orderedProduct = DB::table('has_products')->where('order_id',$order->id)->get();
                if(count($orderedProduct) > 0){
                    $temp = [];
                    foreach($orderedProduct as $prod){
                        $temp[] = $this->getProduct($prod->prod_id);
                        
                    }
                    $order->products = $temp;
                } //product foreach ends here
                $user->cart = '';
                $user->save();
                return ['status' => 1, 'msg' => 'Order Created Successfully', 'data' => $order]; //success
            } else {
                return ['status' => 0, 'msg' => 'Failed']; //failure
            }

        } else {
            return response()->json(["status" => 0, 'msg' => 'Mandatory fields are missing.']);
        }

    }

    public static function ApplyAdditionalCharge($price)
    {
        $addCharge = DB::table('general_setting')->where('url_key', 'additional-charge')->where('status', 1)->first();
        $data = [];
        if (is_array($addCharge) && count($addCharge) <= 0) {
            $data['total_amt'] = 0;
            return json_encode($data);
        }
        $amount = 0;
        $arr = [];
        $charges = [];
        if (is_array($addCharge) && $addCharge->status == 1) {
            $charges = AdditionalCharge::where('status', 1)->get();
            foreach ($charges as $key => $charge) {
                $charge_list = [];
                if ($charge['min_order_amt'] > 0) {
                    if ($price >= $charge['min_order_amt']) {
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

        return json_encode($data);
    }

    public function toPayment($userid)
    {
        $toPayment = [];
        $selAdd = DB::table('has_addresses')->where('user_id', $userid)->first();

        $cartContent = Cart::instance("shopping")->content();
        //if (is_null(Session::get('orderId'))) {
        $order = new Order();
        $order->user_id = $userid;
        // if (Input::get("commentText")) {
        //     $order->remark = Input::get("commentText");
        // }
        $order->cart = json_encode($cartContent);
        $order->first_name = ($selAdd) ? $selAdd->firstname : '';
        $order->last_name = ($selAdd) ? $selAdd->lastname : '';
        $order->address1 = ($selAdd) ? $selAdd->address1 : '';
        $order->address2 = ($selAdd) ? $selAdd->address2 : '';
        if ($selAdd) {
            $order->phone_no = !empty($selAdd->phone_no) ? @$selAdd->phone_no : @User::find($userid)->telephone;
        }
        $order->country_id = ($selAdd) ? $selAdd->country_id : '';
        $order->zone_id = ($selAdd) ? $selAdd->zone_id : '';
        $order->postal_code = ($selAdd) ? $selAdd->postcode : '';
        $order->city = ($selAdd) ? $selAdd->city : '';
        $order->thana = ($selAdd) ? $selAdd->thana : '';
        if ($selAdd) {
            $order->description = '';
        }
        $order->save();
        //}
        if ($selAdd) {
            $country = DB::table('countries')->where('id', $selAdd->country_id)->first();
            $zone = DB::table('zones')->where('id', $selAdd->zone_id)->first()->name;
        } else {
            $country = 99;
            $zone = 1476;
        }

        // $toPayment['address'] = $selAdd;
        // $toPayment['address']['countryname'] = ($countryname) ? $countryname : '';
        // $toPayment['address']['statename'] = ($zone) ? $zone : '';
        // $toPayment['address']['countryIsoCode'] = ($countryIsoCode) ? $countryIsoCode : '';
        $cart_amt = Helper::calAmtWithTax();
        $toPayment['finalAmt'] = $cart_amt['total']; //Session::get('currency_val')
        $toPayment['payamt'] = $cart_amt['total']; //Session::get('currency_val')
        $toPayment['orderId'] = $order->id;
        // $toPayment['email'] = User::find($userid)->email;
        // $toPayment['retUrl'] = route('response') . "?DR={DR}";
        // $toPayment['ebsStatus'] = DB::table('general_setting')->where('url_key', 'ebs')->first()->status;
        // $toPayment['payUmoneyStatus'] = DB::table('general_setting')->where('url_key', 'pay-u-money')->first()->status;
        // $toPayment['citrusPayStatus'] = DB::table('general_setting')->where('url_key', 'citrus')->first()->status;

        // $toPayment['commentDesc'] = $order->description;
        $dtails = json_decode(DB::table('general_setting')->where('url_key', 'ebs')->first()->details);
        foreach ($dtails as $detk => $detv) {
            if ($detk == "mode") {
                $mode = $detv;
            }

            if ($detk == "key") {
                $ebskey = $detv;
            }

            if ($detk == "account_id") {
                $account_id = $detv;
            }

        }
        // $toPayment['ebsMode'] = @$mode;
        // $toPayment['ebsKey'] = @$ebskey;
        // $toPayment['ebsAccountId'] = @$account_id;
        // if (Session::get('pay_amt') > 0) {
        //     $toPayment['frmAction'] = route('order_cash_on_delivery');
        // } else {
        //     $toPayment['frmAction'] = route('order_cash_on_delivery');
        // }

        $ad_charge = $this->ApplyAdditionalCharge($cart_amt['total']);
        $ad_charge = json_decode($ad_charge, true);
        $toPayment['additional_charge'] = $ad_charge;

        $finalAmt = $cart_amt['total'] + $ad_charge['total_amt'];
        $toPayment['finalAmt'] = $finalAmt; // * Session::get('currency_val')

        $cod = json_decode(DB::table('general_setting')->where('url_key', 'cod')->first()->details);
        $toPayment['cod_charges'] = @$cod->charges;
        $iscod = "1";
        $codmsg = "";
        // if ($selAdd && $selAdd !== null) {
        //     $pincodeStatus = Helper::checkCodPincode($selAdd->postcode);
        //     if ($pincodeStatus == 1) {
        //         $iscod = 1;
        //         $codmsg = "COD available for this pincode.";
        //     } else if ($pincodeStatus == 2) {
        //         $iscod = 0;
        //         $codmsg = "COD not available for this pincode.";
        //     } else if ($pincodeStatus == 3) {
        //         $iscod = 3;
        //         $codmsg = "Pincode not available for delivery.";
        //     } else if ($pincodeStatus == 5) {
        //         $codmsg = "Pincode available for delivery.";
        //     } else if ($pincodeStatus == 6) {
        //         $iscod = 1;
        //     }
        // }
        $toPayment['is_cod'] = $iscod;
        $toPayment['cod_msg'] = $codmsg;
        $toPayment['currency_val'] = '1.0000000000'; //Session::get('currency_val')

        //GET Currency
        // $currencySetting = new HomeController();
        // $toPayment['curData'] = $currencySetting->setCurrency();
        // $toPayment['addCharge'] = AdditionalCharge::where('status', 1)->get();
        return $toPayment;
    }

    public function saveOrderSuccess($paymentMethod, $paymentStatus, $payAmt, $trasactionId, $transactionStatus, $userid, $orderid, $DistributorID)
    {
        $des = null;
        $transactioninfo = null;
        $chkReferal = DB::table('general_setting')->where('url_key', 'referral')->first();
        $chkLoyalty = DB::table('general_setting')->where('url_key', 'loyalty')->first();
        $stock_status = DB::table('general_setting')->where('url_key', 'stock')->first()->status;
        $courier_status = DB::table('general_setting')->where('url_key', 'default-courier')->first()->status;
        $user = User::find($userid);
        $distributor = Store::where('merchant_id', $DistributorID)->where('store_type', 'distributor')->first();
        $order = Order::find($orderid);
        $iscod = 0;
        if ($paymentMethod == 1) {
            $iscod = 1;
        }
        if ($courier_status == 1) {
            $courier = DB::table('has_couriers')->where('status', 1)->where('store_id', $distributor->id)->orderBy("preference", "asc")->first();
            $order->courier = @$courier->courier_id;
        }
        //if ($this->courierService == 1 && $this->pincodeStatus == 1) {
        //            if ($courier_status == 1) {
        //                $courier = HasCourier::where('status', 1)->where('store_id', $this->jsonString['store_id'])->orderBy("preference", "asc")->first();
        //                $order->courier = $courier->courier_id;
        //                // $courier = Courier::where('status', 1)->whereIn('id', $courierId)->get()->toArray();
        //                // $courierServe = Helper::assignCourier($order->postal_code, $iscod);
        //            }
        //}
        $cart_data = Helper::calAmtWithTax();
        $order->user_id = $userid;
        $order->pay_amt = $payAmt;

        //echo "session id::".Session::get('distributor_store_id');
        $cartAmount = $cart_data['total'];
        $order->order_amt = number_format((float)$cartAmount, 2, '.', '');
        // apply additional charge to payAmount
        $additional_charge_json = $this->ApplyAdditionalCharge($cartAmount);
        $order->additional_charge = $additional_charge_json;
        //$orderstatus = DB::table('order_status')->where(['sort_order' => 1, 'store_id' => Session::get('distributor_store_id')])->first();
        $orderstatus = DB::table('order_status')->where(['is_default' => 1, 'store_id' => $distributor->id])->first();

        $order->payment_method = $paymentMethod;
        $order->payment_status = $paymentStatus;
        $order->transaction_id = $trasactionId;
        $order->transaction_status = $transactionStatus;
        if ($des) {
            $order->description = $des;
        }

        // $order->currency_id = Session::get("currency_id");
        // $order->currency_value = Session::get("currency_val");
        $order->cart = json_encode(Cart::instance('shopping')->content());
        $order->order_status = $orderstatus->id;
        // $order->cod_charges = @Session::get('codCharges');
        // $order->discount_type = (Session::get('discType')) ? Session::get('discType') : 0;
        // $order->discount_amt = (Session::get('discAmt')) ? Session::get('discAmt') : 0;
        // $order->coupon_amt_used = is_null(Session::get('couponUsedAmt')) ? 0 : Session::get('couponUsedAmt');
        // $order->coupon_used = is_null(Session::get('usedCouponId')) ? 0 : Session::get('usedCouponId');
        // $order->cashback_used = is_null(Session::get('checkbackUsedAmt')) ? 0 : Session::get('checkbackUsedAmt');
        // $order->voucher_amt_used = is_null(Session::get('voucherAmount')) ? 0 : Session::get('voucherAmount');
        // $order->voucher_used = is_null(Session::get('voucherUsedAmt')) ? 0 : Session::get('voucherUsedAmt');
        $jsonString = Helper::getSettings();
        $order->prefix = $distributor->prefix;
        $order->store_id = $distributor->id;
        // $coupon_id = Session::get('voucherUsedAmt');
        // if (isset($coupon_id)) {
        //     $coupon = Coupon::find($coupon_id);
        //     $coupon->initial_coupon_val = Session::get('remainingVoucherAmt');
        //     $coupon->update();
        // }

        // if ($chkReferal->status == 1) {
        //     if (!empty(Session::get("ReferalId"))) {
        //         $order->referal_code_used = Session::get("ReferalCode");
        //         $order->referal_code_amt = Session::get("referalCodeAmt");
        //         $order->user_ref_points = Session::get("userReferalPoints");
        //         $order->ref_flag = 0;
        //     }
        // }

        $user->update();
        // $tempName = Session::get('login_user_first_name');
        // if (empty($tempName)) {
        //     $parts = explode("@", Session::get('logged_in_user'));
        //     $fname = (!empty($parts)) ? $parts[0] : '';
        // } else {
        //     $fname = $tempName;
        // }
        $mail_id = $user->id;
        $fname = 'anita';
        $orderId = $order->id;
        $date = date("Y-m-d H:i:s");
        $order->created_at = $date;

        if ($order->Update()) {
            //$this->forget_session_coupon();
            //if ($stock_status == 1) { // commented by bhavana....
            $this->updateStock($order->id);
            //}
            $storedata = DB::table('stores')->where('id', $distributor->id)->first();
            if ($user->telephone) {
                $msgOrderSucc = "Your order from " . $storedata->store_name . " with id " . $order->id . " has been placed successfully. Thank you!";
                Helper::sendsms($user->telephone, $msgOrderSucc, $user->country_code);
            }
            $messagearray = new stdClass();
            $messagearray->title = "Order Placed";
            $messagearray->type = "order";
            $messagearray->message = "Hey! You have received a New Order online. Its order id is " . $order->id . " & order amount is " . $order->pay_amt;

            // $this->pushNotification($messagearray);
            return $data_email = ['first_name' => $fname, 'orderId' => $orderId, 'email' => $mail_id];
        }
    }
    // For order Update stock
    public function updateStock($orderId)
    {
        $jsonString = Helper::getSettings();
        // $is_stockable = GeneralSetting::where('url_key', 'stock')->first();
        $stock_limit = DB::table('general_setting')->where('url_key', 'stock')->first();
        $stockLimit = json_decode($stock_limit->details, true);
        $cartContent = Cart::instance("shopping")->content();
        $order = Order::find($orderId);
        $cart_ids = [];

        DB::table('has_products')->where("order_id", $orderId)->delete();
        foreach ($cartContent as $key => $cart) {
            $product = DB::table('products')->where('id', $cart->id)->first();
            $sum = 0;
            $prod_tax = array();
            $total_tax = array();
            // if (count($product->texes) > 0) {
            //     foreach ($product->texes as $tax) {
            //         $prod_tax['id'] = $tax->id;
            //         $prod_tax['name'] = $tax->name;
            //         $prod_tax['rate'] = $tax->rate;
            //         $prod_tax['tax_number'] = $tax->tax_number;
            //         $total_tax[] = $prod_tax;
            //     }
            // }
            $getdisc = ($cart->options->disc + $cart->options->wallet_disc + $cart->options->voucher_disc + $cart->options->referral_disc + $cart->options->user_disc);
            if ($cart->options->tax_type == 2) {
                $getdisc = ($cart->options->disc + $cart->options->wallet_disc + $cart->options->voucher_disc + $cart->options->referral_disc + $cart->options->user_disc);
                $taxeble_amt = $cart->subtotal - $getdisc;
                $tax_amt = round($taxeble_amt * $cart->options->taxes / 100, 2);
                $subtotal = $cart->subtotal + $tax_amt;
                $payamt = $subtotal - $getdisc;
            } else {
                $subtotal = $cart->subtotal;
                $payamt = $subtotal - $getdisc;
            }
            $cart_ids[$cart->rowId] = ["qty" => $cart->qty, "price" => $subtotal, "created_at" => date('Y-m-d H:i:s'), "amt_after_discount" => $cart->options->discountedAmount, "disc" => $cart->options->disc, 'wallet_disc' => $cart->options->wallet_disc, 'voucher_disc' => $cart->options->voucher_disc, 'referral_disc' => $cart->options->referral_disc, 'user_disc' => $cart->options->user_disc, 'tax' => json_encode($total_tax),
                'pay_amt' => $payamt, 'store_id' => $order->store_id, 'prefix' => $order->prefix];

            if ($cart->options->has('sub_prod') && $cart->options->sub_prod != null) {
                $cart_ids[$cart->rowId]["sub_prod_id"] = $cart->options->sub_prod;
                $proddetails = [];
                $prddataS = DB::table('products')->where('id', $cart->options->sub_prod)->first();
                $proddetails['id'] = @$prddataS->id;
                $proddetails['name'] = @$prddataS->product;
                $proddetails['image'] = $cart->options->image;
                $proddetails['price'] = $cart->price;
                $proddetails['qty'] = $cart->qty;
                $proddetails['subtotal'] = $subtotal;
                $proddetails['is_cod'] = @$prddataS->is_cod;
                $cart_ids[$cart->rowId]["product_details"] = json_encode($proddetails);
                $date = $cart->options->eNoOfDaysAllowed;
                $cart_ids[$cart->rowId]["eTillDownload"] = date('Y-m-d', strtotime("+ $date days"));
                $cart_ids[$cart->rowId]["prod_type"] = $cart->options->prod_type;

                if (@$prddataS->is_stock == 1) {
                    @$prddataS->stock = @$prddataS->stock - $cart->qty;
                    // if ($prddataS->is_share_on_mall == 1) {
                    //     $mallProduct = MallProducts::where("store_prod_id", $cart->options->sub_prod)->first();
                    //     $mallProduct->stock = $prddataS->stock;
                    //     $mallProduct->update();
                    // }
                    @$prddataS->update();
                }

                if (@$prddataS->stock <= $stockLimit['stocklimit'] && @$prddataS->is_stock == 1) {
                    // $this->AdminStockAlert($prddataS->id);
                }
            } else if ($cart->options->has('combos')) {
                $sub_prd_ids = [];
                foreach ($cart->options->combos as $key => $val) {
                    if (isset($val['sub_prod'])) {
                        array_push($sub_prd_ids, (string) $val['sub_prod']);
                        $prd = DB::table('products')->where('id', $val['sub_prod'])->first();
                        $prd->stock = $prd->stock - $cart->qty;
                        if ($prd->is_stock == 1) {
                            $prd->update();
                        };

                        if ($prd->stock <= $stockLimit['stocklimit'] && $prd->is_stock == 1) {
                            // $this->AdminStockAlert($prd->id);
                        }
                    } else {
                        $prd = DB::table('products')->where('id', $key)->first();
                        $prd->stock = $prd->stock - $cart->qty;
                        if ($prd->is_stock == 1) {
                            $prd->update();
                        }

                        if ($prd->stock <= $stockLimit['stocklimit'] && $prd->is_stock == 1) {
                            // $this->AdminStockAlert($prd->id);
                        }
                    }
                }
                $cart_ids[$cart->rowId]["sub_prod_id"] = json_encode($sub_prd_ids);
            } else {
                $proddetailsp = [];
                $prddataSp = DB::table('products')->where('id', $cart->id)->first();
                $proddetailsp['id'] = $prddataSp->id;
                $proddetailsp['name'] = $prddataSp->product;
                $proddetailsp['image'] = $cart->options->image;
                $proddetailsp['price'] = $cart->price;
                $proddetailsp['qty'] = $cart->qty;
                $proddetailsp['subtotal'] = $subtotal; //* Session::get('currency_val')
                $proddetailsp['is_cod'] = $prddataSp->is_cod;
                $cart_ids[$cart->rowId]["sub_prod_id"] = 0;

                $cart_ids[$cart->rowId]["product_details"] = json_encode($proddetailsp);

                $date = $cart->options->eNoOfDaysAllowed;
                $cart_ids[$cart->rowId]["eTillDownload"] = date('Y-m-d', strtotime("+ $date days"));
                $cart_ids[$cart->rowId]["prod_type"] = $cart->options->prod_type;
                $prd = DB::table('products')->where('id', $cart->id)->first();
                $prd->stock = $prd->stock - $cart->qty;
                if ($prd->is_stock == 1) {
                    DB::table('products')->where('id', $cart->id)->update(['stock'=>$prd->stock]);
                }

                if ($prd->stock <= $stockLimit['stocklimit'] && $prd->is_stock == 1) {
                    // $this->AdminStockAlert($prd->id);
                }
            }
            // $order->products()->attach($cart_ids);
            //  HasProducts::on('mysql2');
            $cart_ids[$cart->rowId]["order_id"] = $orderId;
            $cart_ids[$cart->rowId]["prod_id"] = $cart->id;
            $cart_ids[$cart->rowId]["order_status"] = 1;
            $cart_ids[$cart->rowId]["order_source"] = 2;

            // DB::table('has_products')->connection('mysql2')->insert($cart_ids);
            //  $order->products()->attach($cart->rowid, $cart_ids[$cart->rowid]);
        }
        DB::table('has_products')->insert($cart_ids);
        // print_r($cart_ids);
        // dd(Cart::instance('shopping')->content());
        // dd($cart_ids);
        //  $this->orderSuccess();
    }

    public function reOrder(){
        $orderId = Input::get('orderId');
        $orderData = DB::table('has_products')->where('order_id',$orderId)->get();
        $user = User::where('id', Session::get('authUserId'))->first();
        if ($user->cart != '') {
            $cartData = json_decode($user->cart, true);
            Cart::instance('shopping')->destroy();
            if(Cart::instance("shopping")->count() != 0){
                $user->cart = json_encode($cartData);
            } else {
                $user->cart = '';
            }
            $user->update();
            Cart::instance('shopping')->add($cartData);
        }
        $data = [];
        foreach($orderData as  $prod){
            $product = DB::table("products")->where('id',$prod->prod_id)->first();
            if(!empty($product)){
                if($prod->prod_type==1){
                    $msg = app('App\Http\Controllers\Admin\ApiCartController')->simpleProduct($prod->prod_id,$prod->qty);
                }
                else if($prod->prod_type==2){
                    $msg = app('App\Http\Controllers\Admin\ApiCartController')->comboProduct($prod->prod_id, $prod->qty,$prod->sub_prod_id);
                }
                else if($prod->prod_type==3 || $prod->sub_prod_id !=0 ){  
                    $msg = app('App\Http\Controllers\Admin\ApiCartController')->configProduct($prod->prod_id, $prod->qty,$prod->sub_prod_id);
                }
                else if($prod->prod_type==5){
                    $msg = app('App\Http\Controllers\Admin\ApiCartController')->downloadProduct($prod->prod_id, $prod->qty);
                }

                if ($msg == 1) {
                    $data['data']['cart'] = null;
                    $data['status'] = "0";
                    $data['msg'] = $msg;
                } else {
                    //return $msg;
                    $cartData = Cart::instance("shopping")->content();
                    if(Cart::instance("shopping")->count() != 0){
                        $user->cart = json_encode($cartData);
                    } else {
                        $user->cart = '';
                    }
                    $user->update();
                    $data['data']['cart'] = $cartData;
                    $data['data']['total'] = Helper::getOrderTotal($cartData);
                    $data["data"]['cartCount'] = Cart::instance("shopping")->count();
                    $data['status'] = "1";
                    $data['msg'] = "";
                }
                
            }else{
                $data['data']['cart'] = null;
                $data['status'] = "0";
                $data['msg'] = $msg;
            }
        }
        return $data;
        //$cartData = Cart::instance("shopping")->content();
        // foreach($cartData as $val){
        //     $store_id = $val->options->store_id;
        //     break;
        // }
        // $Storeinfo = Store::find($store_id);
        // $DistributorID = $Storeinfo->merchant_id;
        // $cartcount = Cart::instance("shopping")->count();
        // $cartInfo = Cart::instance("shopping")->total();
        // $cart_amt = Helper::getOrderTotal($cartData); //Helper::calAmtWithTax();
        // $finalamt = Helper::getOrderTotal($cartData); //$cart_amt['total'];
        // $paymentAmt = $finalamt;
        // $paymentMethod = 8; //"9";
        // $paymentStatus = "1";
        // $payAmt = number_format((float)$finalamt, 2, '.', '');
        // //apply additional charge to payAmount
        // $additional_charge_json = $this->ApplyAdditionalCharge($payAmt);
        // $additional_charge = json_decode($additional_charge_json, true);
        // $payAmt = $payAmt + $additional_charge['total_amt'];

        // $trasactionId = "";
        // $transactionStatus = "";
        // $userid = $user->id;
        // $toPay = $this->toPayment($userid);
        // if (!empty($toPay['orderId'])) {
        //     $orderS = Order::find($toPay['orderId']);
        //     $orderS->created_by = $userid;
        //     $orderS->additional_charge = $additional_charge_json;
        //     $orderS->amt_paid = $paymentAmt;
        //     $orderS->order_type = 1;
        //     $orderS->description = '';
        //     $orderS->order_status = 31; //processing
        //     $orderS->update();
        //     if ($paymentMethod == '10') {
        //         $userinfo->credit_amt = $userinfo->credit_amt + ($payAmt - $paymentAmt);
        //         $userinfo->update();
                
        //     }
        //     $succ = $this->saveOrderSuccess($paymentMethod, $paymentStatus, $payAmt, $trasactionId, $transactionStatus, $userid, $orderS->id, $DistributorID);
        //     Cart::instance("shopping")->destroy();

        // }

        // if ($succ['orderId']) {
        //     $order = Order::find($succ['orderId']);
        //     $user->cart = '';
        //     $user->save();
        //     return ['status' => 1, 'msg' => 'Order Created Successfully', 'data' => $order]; //success
        // } else {
        //     return ['status' => 0, 'msg' => 'Failed']; //failure
        // }
    }
}
