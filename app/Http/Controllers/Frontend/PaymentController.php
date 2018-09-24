<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use App\Models\Category;
use App\Models\Store;
use App\Models\Bank;
use App\Models\Country;
use App\Models\MerchantOrder;
use App\Models\Language;
use App\Models\StoreTheme;
use App\Models\Templates;
use App\Models\Currency;
use App\Models\Zone;
use Illuminate\Support\Facades\Input;
use Hash;
use File;
use DB;
use ZipArchive;
use App\Library\Helper;
use Mail;
use Validator;
use Auth;
use Crypt;
use Session;
use stdClass;
use Schema;
use Illuminate\Http\Request;

class PaymentController extends Controller {

    public function index() {
        
    }

    public function getCityPay() {
        define('DS', DIRECTORY_SEPARATOR);
        include(app_path() . DS . 'Library' . DS . 'Functions.php');
        $payAmt = 1; //Helper::getAmt();
        Session::put('theme_id', Input::get("theme_id"));
//        $paymentMethod=9; $paymentStatus=4;$trasactionId='433434CFDFS'; $transactionStatus='success'; $transaction_info="fsfsffsdsd";
//        $this->saveOrderSuccess($paymentMethod, $paymentStatus, $payAmt, $trasactionId, $transactionStatus, $transaction_info);
//         $allinput = json_decode(Merchant::find(Session::get('merchantid'))->register_details, true);
//            $cats = Category::where("status", 1)->where("id", $allinput['business_type'])->get();
//            $checkStote = Merchant::find(Session::get('merchantid'))->getstores()->count();
//            Session::put('merchantstorecount', $checkStote);
//            $themeIds =Order::where("merchant_id",Session::get('merchantid'))->where("order_status",1)->where("payment_status",4)->pluck("theme_id")->toArray();
//            $viewname = Config('constants.frontendView') . ".select-themes";
//            return Helper::returnView($viewname, $data);
        ?>

        <form method="post" action="https://www.veestores.com/get-city-createOrder" name="cityPayForm">
            <input type="hidden" size="25" name="Merchant" value="11122333" readonly/>
            <input type="hidden" size="25" name="Amount" value="1"/>
            <input type="hidden" size="25" name="Currency" value="050" readonly/>
            <input type="hidden" size="25" name="Description" value="1520"/>
            <input type="hidden" size="25" name="theme_id" value="{{Input::get("theme_id")}}"/>
            <input type="hidden" size="50" name="ApproveURL" value="https://www.veestores.com/get-city-approved" readonly/>
            <input type="hidden" size="50" name="CancelURL" value="https://www.veestores.com/get-city-cancelled" readonly/>
            <input type="hidden" size="50" name="DeclineURL" value="https://www.veestores.com/get-city-declined" readonly/>
            <input type="submit" style="display:none;" value="Create Order"/>
        </form>
        <script type="text/javascript">
            document.cityPayForm.submit();
        </script>

        <?php
    }
    
    
    //for city payment
    public function getCityApproved() {

        //  dd($_REQUEST['xmlmsg']);
        if (@$_REQUEST['xmlmsg'] != "") {

            $xmlResponse = simplexml_load_string($_REQUEST['xmlmsg']);
            $json = json_encode($xmlResponse);
            $array = json_decode($json, TRUE);
            if (empty(Session::get('orderId'))) {
                Session::put('orderId', $array['OrderDescription']);
            }

            $paymentMethod = 9;
            $paymentStatus = 4;
            $payAmt = $array['PurchaseAmountScr'];
            $trasactionId = $array['MerchantTranID'];
            $transactionStatus = $array['OrderStatus'];
            $transaction_info = json_encode($array);
            $this->saveOrderSuccess($paymentMethod, $paymentStatus, $payAmt, $trasactionId, $transactionStatus, $transaction_info);
            $data = [];
            $themeIds = MerchantOrder::where("merchant_id", Session::get('merchantid'))->where("order_status", 1)->where("payment_status", 4)->pluck("merchant_id")->toArray();
            $allinput = json_decode(Merchant::find(Session::get('merchantid'))->register_details, true);
            $cats = Category::where("status", 1)->where("id", $allinput['business_type'])->get();
            $checkStote = Merchant::find(Session::get('merchantid'))->getstores()->count();
            Session::put('merchantstorecount', $checkStote);

            $data = ['cats' => $cats, 'allinput' => $allinput, 'themeIds' => $themeIds];
            $viewname = Config('constants.frontendView') . ".select-themes";
            return Helper::returnView($viewname, $data);
        }
    }

    public function getCityDeclined() {
        if (@$_REQUEST['xmlmsg'] != "") {
            $xmlResponse = simplexml_load_string($_REQUEST['xmlmsg']);
            $json = json_encode($xmlResponse);
            $array = json_decode($json, TRUE);
            if (empty(Session::get('orderId'))) {
                Session::put('orderId', $array['OrderDescription']);
            }
           
            $paymentMethod = 9;
            $paymentStatus = 1;
            $payAmt = $array['PurchaseAmountScr'];
            $transactionStatus = $array['OrderStatus'];
            $transaction_info = json_encode($array);
            $this->saveOrderFailure($paymentMethod, $paymentStatus, $payAmt, $transactionStatus, $transaction_info);

            return redirect()->route('orderFailure');
        }
    }

    public function getCityCancelled() {

        if (@$_REQUEST['xmlmsg'] != "") {
            $xmlResponse = simplexml_load_string($_REQUEST['xmlmsg']);
            $json = json_encode($xmlResponse);
            $array = json_decode($json, TRUE);
            if (empty(Session::get('orderId'))) {
                Session::put('orderId', $array['OrderDescription']);
            }
            $paymentMethod = 9;
            $paymentStatus = 1;
            $payAmt = $array['PurchaseAmountScr'];
            $transactionStatus = $array['OrderStatus'];
            $transaction_info = json_encode($array);
            $this->saveOrderFailure($paymentMethod, $paymentStatus, $payAmt, $transactionStatus, $transaction_info);

            // return redirect()->route('orderFailure');
        }
    }

    public function getCityCreateOrder() {
        // dd(Input::all());
//        if (Input::get('responseType') == 'json') {
//            $getAddreses = Address::where("id", "=", Input::get('addid'))->first();
//            $orderS = Order::find(Input::get('Description'));
//            $orderS->cart = Input::get('cart');
//
//            $orderS->first_name = @$getAddreses->firstname;
//            $orderS->last_name = @$getAddreses->lastname;
//            $orderS->address1 = @$getAddreses->address1;
//            $orderS->address2 = @$getAddreses->address2;
//            $orderS->address3 = @$getAddreses->address3;
//            $orderS->phone_no = @$getAddreses->phone_no;
//            $orderS->postal_code = @$getAddreses->postcode;
//            $orderS->country_id = @$getAddreses->country_id;
//            $orderS->zone_id = @$getAddreses->zone_id;
//            $orderS->city = @$getAddreses->city;
//
//            $orderS->save();
//        }
        // dd(Input::get('Merchant'));
        define('DS', DIRECTORY_SEPARATOR);
        include(app_path() . DS . 'Library' . DS . 'Functions.php');
        $data = '<?xml version="1.0" encoding="UTF-8"?>';
        $data.="<TKKPG>";
        $data.="<Request>";
        $data.="<Operation>CreateOrder</Operation>";
        $data.="<Language>EN</Language>";
        $data.="<Order>";
        $data.="<OrderType>Purchase</OrderType>";
        $data.="<Merchant>" . Input::get('Merchant') . "</Merchant>";
        $data.="<Amount>" . Input::get('Amount') * 100 . "</Amount>";
        $data.="<Currency>" . Input::get('Currency') . "</Currency>";
        $data.="<Description>" . Input::get('Description') . "</Description>";
        $data.="<Merchnatid>" . Input::get('merchantid') . "</Merchnatid>";
        $data.="<ApproveURL>" . htmlentities(Input::get('ApproveURL')) . "</ApproveURL>";
        $data.="<CancelURL>" . htmlentities(Input::get('CancelURL')) . "</CancelURL>";
        $data.="<DeclineURL>" . htmlentities(Input::get('DeclineURL')) . "</DeclineURL>";
        $data.="</Order></Request></TKKPG>";

        $xml = PostQW($data);
        
        $OrderID = $xml->Response->Order->OrderID;
        $SessionID = $xml->Response->Order->SessionID;
        $URL = $xml->Response->Order->URL;

        $data = '<?xml version="1.0" encoding="UTF-8"?>';
        $data.="<TKKPG>";
        $data.="<Request>";
        $data.="<Operation>GetOrderStatus</Operation>";
        $data.="<Order>";
        $data.="<Merchant>" . $_POST['Merchant'] . "</Merchant>";
        $data.="<OrderID>" . $OrderID . "</OrderID>";
        $data.="</Order>";
        $data.="<SessionID>" . $SessionID . "</SessionID>";
        $data.="</Request></TKKPG>";
        $xml = PostQW($data);
        $OrderStatus = $xml->Response->Order->OrderStatus;



        if (Input::get('responseType') == 'json') {
            $data = [];
            $data['url'] = $URL . "?ORDERID=" . $OrderID . "&SESSIONID=" . $SessionID . "";
            return $data;
        }

        if ($OrderID != "" and $SessionID != "") {
            header("Location: " . $URL . "?ORDERID=" . $OrderID . "&SESSIONID=" . $SessionID . "");
            exit();
        }
    }

    public function saveOrderSuccess($paymentMethod, $paymentStatus, $payAmt, $trasactionId, $transactionStatus, $transaction_info) {
        dd(Session::get('merchantid'));
        $order = new MerchantOrder();
        $getMerchat = json_decode(Merchant::find(Session::get('merchantid'))->register_details);
        $order->merchant_id = Session::get('merchantid');
        $order->pay_amt = $payAmt;
        $order->order_amt = $payAmt;
        $order->payment_method = $paymentMethod;
        $order->payment_status = $paymentStatus;
        $order->transaction_id = $trasactionId;
        $order->transaction_status = $transactionStatus;
        $order->transaction_info = @$transaction_info;
        $order->currency_id = $getMerchat->currency;
        $order->order_status = 1;
        $order->first_name = $getMerchat->firstname;
        $order->phone_no = $getMerchat->phone;
        $order->email = $getMerchat->email;
        $order->category_id = $getMerchat->business_type;
        $order->store_version = $getMerchat->store_version;
        $order->theme_id = Session::get('theme_id');
        $order->shipping_amt = is_null(Session::get('shippingAmount')) ? 0 : Session::get('shippingAmount');

        $order->save();
        Session::put("orderId", $order->id);
        
        return $order;
//        if (empty($tempName)) {
//            $parts = explode("@", Session::get('logged_in_user'));
//            $fname = $parts[0];
//        } else {
//            $fname = $tempName;
//        }
//        $mail_id = Session::get('logged_in_user');
//        $orderId = Session::get('orderId');
//        $date = date("Y-m-d H:i:s");
//        $order->created_at = $date;
        // dd($order);
//        if ($order->Update()) {
//            // return $data_email = ['first_name' => $fname, 'orderId' => $orderId, 'emial' => $mail_id];
//            // send mail to customer for order confirmation
//           $order= Order::where("id",$order->id)->with("DeliverySlot")->first();
//            Mail::to($user->email)->send(new OrderSuccess($user, $order));
//        } 
    }

    public function saveOrderFailure($paymentMethod, $paymentStatus, $payAmt, $transactionStatus, $transaction_info) {
        $order = new MerchantOrder();
      //  dd(Session::get('merchantid'));
        $getMerchat = json_decode(Merchant::find(Session::get('merchantid'))->register_details);
        $order->merchant_id = Session::get('merchantid');
        $order->pay_amt = $payAmt;
        $order->order_amt = $payAmt;
        $order->payment_method = $paymentMethod;
        $order->payment_status = $paymentStatus;
        $order->transaction_status = $transactionStatus;
        $order->transaction_info = @$transaction_info;
        $order->first_name = $getMerchat->firstname;
        $order->phone_no = $getMerchat->phone;
        $order->email = $getMerchat->email;
        $order->category_id = $getMerchat->business_type;
        $order->store_version = $getMerchat->store_version;
        $order->save();
        Session::put("orderId", $order->id);
        Session::forget("merchantid");
        Session::forget("storeId");
        return $order;
    }
   public function getCityPayRenew($storeid,$type) {
     //  print_r($storeid);
        define('DS', DIRECTORY_SEPARATOR);
        include(app_path() . DS . 'Library' . DS . 'Functions.php');
       // dd(Crypt::decrypt($storeid));
//       dd(Input::all());
           
             
            $merchant=Store::find($storeid)->getmerchant()->first()->id;
       
        $payAmt = 1; //Helper::getAmt();
        Session::put('storeId', $storeid);
        Session::put('merchantid', $merchant);
        ?>

        <form method="post" action="https://www.veestores.com/get-city-createOrder" name="cityPayForm">
            <input type="hidden" size="25" name="Merchant" value="11122333" readonly/>
            <input type="hidden" size="25" name="Amount" value="1"/>
            <input type="hidden" size="25" name="Currency" value="050" readonly/>
            <input type="hidden" size="25" name="Description" value="1520"/>  
            <input type="hidden" size="25" name="merchnatId" value="{{$merchant}}"/>
            <input type="hidden" size="50" name="ApproveURL" value="https://www.veestores.com/get-renew-city-approved" readonly/>
            <input type="hidden" size="50" name="CancelURL" value="https://www.veestores.com/get-city-cancelled" readonly/>
            <input type="hidden" size="50" name="DeclineURL" value="https://www.veestores.com/get-city-declined" readonly/>
            <input type="submit" style="display:none;" value="Create Order"/>
        </form>
        <script type="text/javascript">
            document.cityPayForm.submit();
        </script>

        <?php
    }
    public function getRenewCityApproved() {

        //  dd($_REQUEST['xmlmsg']);
        if (@$_REQUEST['xmlmsg'] != "") {

            $xmlResponse = simplexml_load_string($_REQUEST['xmlmsg']);
            $json = json_encode($xmlResponse);
            $array = json_decode($json, TRUE);
            if (empty(Session::get('orderId'))) {
                Session::put('orderId', $array['OrderDescription']);
            }

            $paymentMethod = 9;
            $paymentStatus = 4;
            $payAmt = $array['PurchaseAmountScr'];
            $trasactionId = $array['MerchantTranID'];
            $transactionStatus = $array['OrderStatus'];
            $transaction_info = json_encode($array);
            $this->saveOrderSuccess($paymentMethod, $paymentStatus, $payAmt, $trasactionId, $transactionStatus, $transaction_info);
            $store=Store::find(29)->url_key;
            $merchantStorePath= base_path() . "/merchants/" . $store . "/";         
            $settings = Helper::getMerchantStoreSettings($merchantStorePath);
            $settings['expiry_date']= date('Y-m-d', strtotime($settings['expiry_date'] . " + 365 day"));
            Helper::saveMerchantStoreSettings($merchantStorePath,json_encode($settings));
            $data = [];
//            $themeIds = MerchantOrder::where("merchant_id", Session::get('merchantid'))->where("order_status", 1)->where("payment_status", 4)->pluck("merchant_id")->toArray();
//            $allinput = json_decode(Merchant::find(Session::get('merchantid'))->register_details, true);
//          
//          
//           
//
//            $data = ['cats' => $cats, 'allinput' => $allinput, 'themeIds' => $themeIds];
//            $viewname = Config('constants.frontendView') . ".select-themes";
//            return Helper::returnView($viewname, $data);
        }
    }
    public function orderFailure(){
              $data ="";
              Session::forget(all());
            $viewname = Config('constants.frontendView') . ".failure";
            return Helper::returnView($viewname, $data);   
    }
}
