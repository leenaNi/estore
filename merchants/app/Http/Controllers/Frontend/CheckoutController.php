<?php

namespace App\Http\Controllers\Frontend;

use Route;
use App\Models\Category;
use App\Models\Product;
use App\Models\Country;
use App\Models\GeneralSetting;
use App\Models\Loyalty;
use App\Models\Address;
use App\Models\Zone;
use App\Models\Coupon;
use App\Models\User;
use App\Models\HasProducts;
use App\Models\Order;
use App\Models\HasCashbackLoyalty;
use App\Library\Helper;
use App\Models\EmailTemplate;
use App\Models\AttributeValue;
use App\Models\Pincode;
use App\Models\HasCourier;
use App\Models\MallProducts;
use Input;
use App\Http\Controllers\Controller;
use Cart;
use Session;
use HTML;
use DB;
use Auth;
use Hash;
use Mail;
use Crypt;
use App\Classes\Crypt_RC4;
use App\Classes\MyPayPal;
use Config;
use stdClass;
use App\Models\AdditionalCharge;

class CheckoutController extends Controller {

    public function index() {
        $checkGuestCheckoutEnabled = GeneralSetting::where("url_key", "guest-checkout")->where("status", 1)->get();

        Session::forget("discAmt");
        Session::forget("codCharges");
        Session::forget("discType");
        // To remove all discount coupon;
        Session::forget('checkbackUsedAmt');
        Session::forget('voucherAmount');
        Session::forget('voucherUsedAmt');
        Session::forget('referalCodeAmt');
        Session::forget('discAmt');


        $cart = Cart::instance('shopping')->content();
        if (empty($cart->toArray())) {
            return redirect()->route('cart');
        } else {
            foreach ($cart as $k => $c) {
                Cart::instance('shopping')->update($k, ["options" => ['wallet_disc' => 0, 'voucher_disc' => 0, 'referral_disc' => 0, 'user_disc' => 0]]);
            }
            //Session::forget("shippingCost");
            $this->revert_cod_charges();
            $countries = Country::where("status", "=", 1)->get(['id', 'name']);
            $zoneData = Zone::where("status", "=", 1)->get(['id', 'name']);
            // return view('Frontend.pages.checkout.checkout', compact('countries', 'zoneData'));
            $viewname = Config('constants.frontCheckoutView') . '.checkout';
            $data = ['countries' => $countries, 'zoneData' => $zoneData, "checkGuestCheckoutEnabled" => $checkGuestCheckoutEnabled];
            return Helper::returnView($viewname, $data);
        }
    }

    public function get_zone() {
        if (!empty(Input::get('country'))) {
            $country_id = Country::where("id", "=", Input::get('country'))->get(['id'])->first();

            $zone = Zone::where("country_id", "=", $country_id->id)->get(['id', 'name']);
        } else {
            $zone = [];
        }
        return $zone;
    }

    public function get_country_zone() {
        $country = Country::where("status", "=", 1)->get(['id', 'name']);
        $zone = Zone::where("status", "=", 1)->get(['id', 'name']);
        $userD = User::find(Session::get('loggedin_user_id'));
        $count = 99;
        $data['country'] = $country;
        $data['countryid'] = "{$count}";
        $data['firstname'] = @$userD->firstname;
        $data['lastname'] = @$userD->lastname;
        $data['phone_no'] = @$userD->telephone;
        $data['zone'] = [];
        return $data;
    }

    public function get_exist_user_login_new() {
        //$existEmail = Input::get('loginemail');
        $existPassword = Input::get('loginpassword');
        $existEmail = Input::get('loginemail');
        $login_type = filter_var($existEmail, FILTER_VALIDATE_EMAIL) ? 'email' : 'telephone';
        $userdata = array(
            $login_type => Input::get('loginemail'),
            'password' => Input::get('loginpassword')
        );
        $userdata = array(
            $login_type => $existEmail,
            'password' => $existPassword
        );
        $user = User::where($login_type, '=', $existEmail)->first();
        if (!empty($user)) {
            if (Auth::attempt($userdata)) {
                Helper::postLogin($user->id);
                $checkCod = GeneralSetting::where('url_key', 'cod')->where('status', 1)->get();
                $addressesData = User::find(Session::get('loggedin_user_id'))->addresses()->get();
                $pincodeStatus = GeneralSetting::where('url_key', 'pincode')->first();
                $pincode = array_column(Pincode::where('status', 1)->get()->toArray(), 'pincode');
                foreach ($addressesData as $address) {
                    $address->countryname = $address->country['name'];
                    $address->statename = $address->zone['name'];
                    if ($pincodeStatus->status == 1 && count($checkCod) > 0) {
                        if (in_array($address->postcode, $pincode)) {
                            $address->cod = 1;
                            $address->codmsg = "COD Available";
                        } else {
                            $address->cod = 0;
                            $address->codmsg = "COD Not Available";
                        }
                    } else {
                        $address->cod = 1;
                        $address->codmsg = "";
                    }
                }
                return ["address" => $addressesData, 'status' => 1];
            } else {
                return ['status' => 0];
            }
        } else {
            return ['status' => 0];
        }
    }

    public function new_user_login_new() {
        $cartContent = Cart::instance('shopping')->content();
        $chkEmail = User:: where("telephone", "=", Input::get("telephone"))->get()->first();
        if (empty($chkEmail)) {
            if (Input::get('password') == Input::get('cpassword')) {
                $user = new User();
                $user->email = Input::get('email');
                $user->password = Hash::make(Input::get('password'));
                $user->firstname = ucfirst(Input::get('firstname'));
                $user->country_code = Input::get('country_code');
                $user->telephone = Input::get('telephone');
                $user->lastname = ucfirst(Input::get('lastname'));
                $jsonString = Helper::getSettings();
                $user->prefix = $jsonString['prefix'];
                $user->store_id = $jsonString['store_id'];
                $user->save();
                Helper::newUserInfo($user->id);
                $getUserInfo = User::find($user->id);
                $referralCode = "Your referral code is " . $getUserInfo->referal_code;
                if ($emailStatus == 1 && $getUserInfo->email != '') {
                    $logoPath = @asset(Config("constants.logoUploadImgPath") . 'logo.png');
                    $settings = Helper::getSettings();
                    //dd($settings);
                    $webUrl = $_SERVER['SERVER_NAME'];
                    $emailContent = EmailTemplate::where('id', 1)->select('content', 'subject')->get()->toArray();
                    $email_template = $emailContent[0]['content'];
                    $subject = $emailContent[0]['subject'];

                    $replace = array("[firstName]", "[logoPath]", "[web_url]", "[primary_color]", "[secondary_color]", "[storeName]", "[referralCode]");
                    $replacewith = array($user->firstname, $logoPath, $webUrl, $settings['primary_color'], $settings['secondary_color'], $settings['storeName'], $referralCode);

                    $email_templates = str_replace($replace, $replacewith, $email_template);
                    $data1 = ['email_template' => $email_templates];
                    Helper::sendMyEmail(Config('constants.frontviewEmailTemplatesPath') . 'registerEmail', $data1, $subject, Config::get('mail.from.address'), Config::get('mail.from.name'), Input::get('email'), Input::get('firstname') . " " . Input::get('lastname'));
                }
                if ($getUserInfo->telephone) {
                    $msgOrderSucc = "you have successfully register with Us. " . $referralCode . ". Contact 1800 3000 2020 for real time support.! Team Cartini";
                    Helper::sendsms($getUserInfo->telephone, $msgOrderSucc, $getUserInfo->country_code);
                }
                $addressesData = User::find(Session::get('loggedin_user_id'))->addresses()->get();
                foreach ($addressesData as $address) {
                    $address->countryname = $address->country['name'];
                    $address->statename = $address->zone['name'];
                }
                return $addressesData;
            }
        } else {
            return "Account already exists.";
        }
    }

    public function save_address() {
        if (!empty(Input::get('id'))) {
            $newAdd = Address::find(Input::get('id'));
            $newAdd->user_id = Session::get('loggedin_user_id');
            $newAdd->firstname = Input::get('firstname');
            $newAdd->lastname = Input::get('lastname');
            $newAdd->address1 = Input::get('address1');
            $newAdd->address2 = Input::get('address2');
            $newAdd->postcode = Input::get('postal_code');
            $newAdd->city = Input::get('city');
            $newAdd->zone_id = Input::get('state');
            $newAdd->country_id = Input::get('country_id');
            $newAdd->phone_no = Input::get('phone_no');
            $newAdd->update();
        } else {
            $newAdd = new Address();
            $user = User::find(Session::get('loggedin_user_id'));
            if (empty($user->firstname)) {
                $user->firstname = Input::get('firstname');
                $user->lastname = Input::get('lastname');
                $user->save();
            }
            $newAdd->user_id = Session::get('loggedin_user_id');
            $newAdd->firstname = Input::get('firstname');
            $newAdd->lastname = Input::get('lastname');
            $newAdd->address1 = Input::get('address1');
            $newAdd->address2 = Input::get('address2');
            $newAdd->postcode = Input::get('postal_code');
            $newAdd->city = Input::get('city');
            $newAdd->zone_id = Input::get('state');
            $newAdd->country_id = Input::get('country_id');
            $newAdd->phone_no = Input::get('phone_no');
            $newAdd->save();
        }
        $addressesData = User::find(Session::get('loggedin_user_id'))->addresses()->get();

        foreach ($addressesData as $address) {
            $address->countryname = $address->country['name'];
            $address->statename = $address->zone['name'];
        }

        $data['addressdata'] = $addressesData;
        $data['curaddid'] = $newAdd->id;
        return $data;
    }

    public function del_address() {
        Address::find(Input::get('addid'))->delete();
        $addressesData = User::find(Session::get('loggedin_user_id'))->addresses()->get();
        foreach ($addressesData as $address) {
            $pincodeStatus = Helper::checkCodPincode($address->postcode);
            $address->countryname = $address->country['name'];
            $address->statename = $address->zone['name'];
            if ($pincodeStatus == 1) {
                $address->cod = 1;
                $address->codmsg = "COD available for this pincode.";
            } else if ($pincodeStatus == 2) {
                $address->cod = 0;
                $address->codmsg = "COD not available for this pincode.";
            } else if ($pincodeStatus == 3) {
                $address->cod = 3;
                $address->codmsg = "Pincode not available for delivery.";
            } else if ($pincodeStatus == 5) {
                $address->cod = '';
                $address->codmsg = "Pincode available for delivery.";
            } else {
                $address->cod = '';
                $address->codmsg = "";
            }
        }

        return $addressesData;
    }

    public function sel_address() {
        Session::put("addressSelected", Input::get('addid'));
        echo Session::get("addressSelected");
    }

    public function get_address() {
        $id = Input::get('addid');
        $addData = [];
        $getAddreses = Address::where("id", "=", $id)->first();
        $getAddreses->countryname = $getAddreses->country['name'];
        $getAddreses->countryid = "{$getAddreses->country['id']}";
        $getAddreses->statename = $getAddreses->zone['name'];
        $getAddreses->zoneid = "{$getAddreses->zone['id']}";
        $country = Country::where("status", "=", 1)->get(['id', 'iso_code_3', 'name']);
        $zone = Zone::where("status", "=", 1)->where('country_id', '=', $getAddreses->country_id)->get(['id', 'name']);
        $addData['addData'] = $getAddreses;
        $addData['country'] = $country;
        $addData['zone'] = $zone;
        return $addData;
    }

    public function check_international() {
        $selAdd = Address::find(Session::get('addressSelected'));
        if (!empty($selAdd) && (!in_array($selAdd->country_id, [99, 18]))) {
            $cart = Cart::instance("shopping")->content();
            $prodsInter = [];
            foreach ($cart as $cInfo) {
                array_push($prodsInter, $cInfo->options->is_shipped_inter);
            }
            if (in_array(0, $prodsInter)) {
                echo "notShippedInternational";
            } else {
                echo "shippedInternational";
            }
        } else {
            echo "valid";
        }
    }

    public function update_pay() {
        Session::put('pay_amt', Input::get('new_amt'));
    }

    public function getBillSummary() {
        $checkReferral = GeneralSetting::where('url_key', 'referral')->first()->status;
        $voucher = @GeneralSetting::where('url_key', 'gift-voucher')->first()->status;
        $reward_point = GeneralSetting::where('url_key', 'loyalty')->first()->status;
        $selAdd = Address::find(Session::get("addressSelected"));
        if ($checkReferral == 1) {
//            $chkProdsRefDisc = [];
//            foreach (Cart::instance("shopping")->content() as $cInfo) {
//                array_push($chkProdsRefDisc, $cInfo->options->is_ref_disc);
//            }
//
//            if (in_array(0, $chkProdsRefDisc)) {
//
//                $refDisc = "invalid";
//            } else {
//
//                $refDisc = "valid";
//            }
            $refDisc = "valid";
        } else {
            $refDisc = "invalid";
        }
        $cart_amt = Helper::calAmtWithTax();
        $summary = [];
        $summary['cart'] = Cart::instance("shopping")->content();
        $summary['cashback'] = (@User::find(Session::get('loggedin_user_id'))->userCashback->cashback > 0 ) ? User::find(Session::get('loggedin_user_id'))->userCashback->cashback : 0; // * Session::get('currency_val')
        $summary['orderCount'] = @Order::where("user_id", Session::get('loggedin_user_id'))->where("order_status", "!=", 0)->count();
        $summary['address'] = $selAdd;
        $summary['chkRefDisc'] = $refDisc;
        $summary['checkReferral'] = $checkReferral;
        $summary['checkVoucher'] = $voucher;
        $summary['shipping'] = @$shippingVal;
        $summary['discount'] = '0.00';
        $summary['subtotal'] = $cart_amt['sub_total'];
        // $summary['subtotal'] = Cart::instance("shopping")->total();
        $summary['gifting'] = empty(Session::get('GiftingCharges')) ? 0 : Session::get('GiftingCharges');
        $summary['coupon'] = is_null(Session::get('couponUsedAmt')) ? 0 : Session::get('couponUsedAmt');
        $summary['finaltotal'] = $cart_amt['total'];
        // $summary['finaltotal'] = Session::get('pay_amt') * Session::get('currency_val');
        $summary['currency_val'] = Session::get('currency_val');
        return $summary;
    }

    public function toPayment() {


        $toPayment = [];
        $selAdd = Address::find(Session::get("addressSelected"));
        //dd($selAdd);
        if (empty($selAdd)) {
            $selAdd = Address::where('user_id', Session::get("loggedin_user_id"))->first();
        }
        $cartContent = Cart::instance("shopping")->content();
        if (is_null(Session::get('orderId'))) {
            $order = new Order();
            $order->user_id = Session::get('loggedin_user_id');
            if (Input::get("commentText")) {
                $order->remark = Input::get("commentText");
            }
            $order->cart = json_encode($cartContent);
            $order->first_name = ($selAdd) ? $selAdd->firstname : '';
            $order->last_name = ($selAdd) ? $selAdd->lastname : '';
            $order->address1 = ($selAdd) ? $selAdd->address1 : '';
            $order->address2 = ($selAdd) ? $selAdd->address2 : '';
            if ($selAdd) {
                $order->phone_no = !empty($selAdd->phone_no) ? @$selAdd->phone_no : @User::find(Session::get('loggedin_user_id'))->telephone;
            }
            $order->country_id = ($selAdd) ? $selAdd->country_id : '';
            $order->zone_id = ($selAdd) ? $selAdd->zone_id : '';
            $order->postal_code = ($selAdd) ? $selAdd->postcode : '';
            $order->city = ($selAdd) ? $selAdd->city : '';
            if ($selAdd) {
                $order->description = !empty(Input::get('commentText')) ? Input::get('commentText') : ' ';
            }
            $order->save();
            Session:: put('orderId', $order->id);
        } else {
            $order = Order::find(Session::get('orderId'));
            $order->user_id = Session::get('loggedin_user_id');
            $order->cart = json_encode($cartContent);
            $order->first_name = ($selAdd) ? $selAdd->firstname : '';
            $order->last_name = ($selAdd) ? $selAdd->lastname : '';
            $order->address1 = ($selAdd) ? $selAdd->address1 : '';
            $order->address2 = ($selAdd) ? $selAdd->address2 : '';
            if ($selAdd) {
                $order->phone_no = !empty($selAdd->phone_no) ? @$selAdd->phone_no : @User::find(Session::get('loggedin_user_id'))->telephone;
            }
            $order->country_id = ($selAdd) ? $selAdd->country_id : '';
            $order->zone_id = ($selAdd) ? $selAdd->zone_id : '';
            $order->postal_code = ($selAdd) ? $selAdd->postcode : '';
            $order->city = ($selAdd) ? $selAdd->city : '';
            if ($selAdd) {
                $order->description = !empty(Input::get('commentText')) ? Input::get('commentText') : ' ';
            }
            $order->Update();
        }
        $toPayment['address'] = $selAdd;
        $toPayment['address']['countryname'] = ($selAdd) ? $selAdd->country['name'] : '';
        $toPayment['address']['statename'] = ($selAdd) ? $selAdd->zone['name'] : '';
        $toPayment['address']['countryIsoCode'] = ($selAdd) ? $selAdd->country['iso_code_3'] : '';
        // $toPayment['finalAmt'] = Helper::getAmt() * Session::get('currency_val'); 
        $cart_amt = Helper::calAmtWithTax();
        $toPayment['finalAmt'] = $cart_amt['total'] * Session::get('currency_val');
        //Session::get('pay_amt') * Session::get('currency_val');
        // $toPayment['payamt'] = Crypt::encrypt(Session::get('pay_amt'));
        $toPayment['payamt'] = $cart_amt['total'] * Session::get('currency_val');
        $toPayment['orderId'] = Session::get('orderId');
        $toPayment['email'] = User::find(Session::get('loggedin_user_id'))->email;
        $toPayment['retUrl'] = route('response') . "?DR={DR}";
        $toPayment['ebsStatus'] = GeneralSetting::where('url_key', 'ebs')->first()->status;
        $toPayment['payUmoneyStatus'] = GeneralSetting::where('url_key', 'pay-u-money')->first()->status;
        $toPayment['citrusPayStatus'] = GeneralSetting::where('url_key', 'citrus')->first()->status;

        $toPayment['commentDesc'] = $order->description;
        $dtails = json_decode(GeneralSetting::where('url_key', 'ebs')->first()->details);
        foreach ($dtails as $detk => $detv) {
            if ($detk == "mode")
                $mode = $detv;
            if ($detk == "key")
                $ebskey = $detv;
            if ($detk == "account_id")
                $account_id = $detv;
        }
        $toPayment['ebsMode'] = @$mode;
        $toPayment['ebsKey'] = @$ebskey;
        $toPayment['ebsAccountId'] = @$account_id;
        if (Session::get('pay_amt') > 0)
            $toPayment['frmAction'] = route('ebs');
        else
            $toPayment['frmAction'] = route('order_cash_on_delivery');



        $ad_charge = AdditionalCharge::ApplyAdditionalCharge($cart_amt['total']);
        $ad_charge = json_decode($ad_charge, true);
        $toPayment['additional_charge'] = $ad_charge;

        $finalAmt = $cart_amt['total'] + $ad_charge['total_amt'];
        $toPayment['finalAmt'] = $finalAmt * Session::get('currency_val');

        Session::put('pay_amt', $finalAmt);


        $cod = json_decode(GeneralSetting::where('url_key', 'cod')->first()->details);
        $toPayment['cod_charges'] = @$cod->charges;
        $iscod = "";
        $codmsg = "";
        $pincodeStatus = Helper::checkCodPincode($selAdd->postcode);
        if ($pincodeStatus == 1) {
            $iscod = 1;
            $codmsg = "COD available for this pincode.";
        } else if ($pincodeStatus == 2) {
            $iscod = 0;
            $codmsg = "COD not available for this pincode.";
        } else if ($pincodeStatus == 3) {
            $iscod = 3;
            $codmsg = "Pincode not available for delivery.";
        } else if ($pincodeStatus == 5) {
            $codmsg = "Pincode available for delivery.";
        } else if ($pincodeStatus == 6) {
            $iscod = 1;
        }
        $toPayment['is_cod'] = $iscod;
        $toPayment['cod_msg'] = $codmsg;
        $toPayment['currency_val'] = Session::get('currency_val');

        //GET Currency
        $currencySetting = new HomeController();
        $toPayment['curData'] = $currencySetting->setCurrency();
        $toPayment['addCharge'] = AdditionalCharge::where('status', 1)->get();
        return $toPayment;
    }

//    function checkPincode() {
//        $pincodeStatus = GeneralSetting::where('url_key','pincode')->first();
//        if (Input::get('type') == '0') {
//            $pin = Input::get('pincode');
//            echo $count = Pincode::where('pincode', $pin)->count();
//        } else if (Input::get('type') == '1') {
//            $pin = Input::get('pintype');
//            // if picode status disable, means it delivered to all pincode 
//            if($pincodeStatus->status == 0){
//                $pin = 1;
//            }
//
//            if ($pin == '0') {
//                Session::put('cod_yes_no', 0);
//            } else {
//                Session::put('cod_yes_no', 1);
//            }
//            echo $pin.' -ses'.Session::get('cod_yes_no');
//        }elseif (Input::get('type') == '2') {
//            $address_id = Input::get('pintype');
//            $pin_no = @Address::find($address_id)->postcode;
//            $avail_pincode = array_column(Pincode::where('status',1)->get()->toArray(), 'pincode');
//            if (in_array($pin_no, $avail_pincode) || $pincodeStatus->status == 0) {
//               Session::put('cod_yes_no', 1); 
//            }
//        }
//       
//    }

    public function get_loggedindata() {

        if (!empty(Session::get('loggedin_user_id'))) {
            $checkCod = GeneralSetting::where('url_key', 'cod')->first();
            $addressesData = User::find(Session::get('loggedin_user_id'))->addresses()->get();
            $pincodeStatus = GeneralSetting::where('url_key', 'pincode')->first();

            foreach ($addressesData as $key => $address) {
                $pincodeStatus = Helper::checkCodPincode($address->postcode);
                $address->countryname = $address->country['name'];
                $address->statename = $address->zone['name'];
                if ($pincodeStatus == 1) {
                    $address->cod = 1;
                    $address->codmsg = "COD available for this pincode.";
                } else if ($pincodeStatus == 2) {
                    $address->cod = 0;
                    $address->codmsg = "COD not available for this pincode.";
                } else if ($pincodeStatus == 3) {
                    $address->cod = 3;
                    $address->codmsg = "Pincode not available for delivery.";
                } else if ($pincodeStatus == 5) {
                    $address->cod = '';
                    $address->codmsg = "Pincode available for delivery.";
                } else {
                    $address->cod = '';
                    $address->codmsg = "";
                }
            }

            return $addressesData;
        } else {
            return "Invalid";
        }
    }

    public function apply_gift_wrap() {
        $cartAmount = Helper::getAmt('gift');
        $finalAmount = $cartAmount + 25;
        Session::put('GiftingCharges', 25);
        echo $finalAmount;
    }

    public function revert_gift_wrap() {
        $cartAmount = Helper::getAmt('gift');
        Session::forget('GiftingCharges');
        $finalAmount = $cartAmount;
        echo $finalAmount;
    }

    public function back_to_address() {
        Session::forget("discAmt");
        Session::forget("discType");
        Session::forget('checkbackUsedAmt');
        Session::forget('remainingCashback');
        Session::forget('voucherUsedAmt');
        Session::forget('voucherAmount');
        Session::forget('remainingVoucherAmt');
        Session::forget('ReferalCode');
        Session::forget('ReferalId');
        Session::forget('referalCodeAmt');
        Session::forget('userReferalPoints');
        Session::forget('shippingAmount');
        $amt = Helper::getAmt();
        Session::put('pay_amt', $amt);
        echo Session::get('pay_amt');
    }

    public function apply_cod_charges() {
        $cod = json_decode(GeneralSetting::where('url_key', 'cod')->first()->details);
        $cart_amt = Helper::calAmtWithTax();
        // to getting additional Charge
        $prod_amount = $cart_amt['total']; // * Session::get('currency_val');
        $ad_charge = AdditionalCharge::ApplyAdditionalCharge($prod_amount);
        $ad_charge = json_decode($ad_charge, true);

        $finalAmt = $cart_amt['total'] + $ad_charge['total_amt'];
        $amtT = $finalAmt; // * Session::get('currency_val');

        $toPayment['payamt'] = $prod_amount * Session::get('currency_val');

        $amt = $amtT + ($cod->charges); //* Session::get('currency_val')
        $toPayment['finalAmt'] = $amt * Session::get('currency_val');


        Session::put('codCharges', $cod->charges); //* Session::get('currency_val')
        Session::put("pay_amt", $amt);
        // return Helper::getAmt() * Session::get('currency_val');
        return $toPayment;
    }

    public function revert_cod_charges() {
        $cart_amt = Helper::calAmtWithTax();
        // to getting additional Charge
        $prod_amount = $cart_amt['total']; // * Session::get('currency_val');
        $ad_charge = AdditionalCharge::ApplyAdditionalCharge($prod_amount);
        $ad_charge = json_decode($ad_charge, true);
        //dd($ad_charge);
        $finalAmt = $cart_amt['total'] + $ad_charge['total_amt'];
        $amtT = $finalAmt; //  * Session::get('currency_val');

        $toPayment['payamt'] = $cart_amt['total'] * Session::get('currency_val');
        $toPayment['finalAmt'] = $amtT * Session::get('currency_val');

        Session::put('codCharges', 0);
        Session::put("pay_amt", $amtT);
        return $toPayment;
    }

    public function back_to_bill() {
        $this->revert_cod_charges();
        //  echo "sdfsdf";
    }

    public function chk_cart_inventory() {
        $stock_status = GeneralSetting::where('url_key', 'stock')->first()->status;
//        if ($stock_status == 0)
//            return "valid";

        $getCart = Cart::instance("shopping")->content();
        $cartStockCheck = [];
        foreach ($getCart as $cartProd) {
            array_push($cartStockCheck, Helper::checkCartInventoty($cartProd->rowid));
        }
        if (in_array("Out of Stock", $cartStockCheck)) {
            return "invalid";
        } else {
            return "valid";
        }
    }

    public function check_voucher() {
        $voucherCode = Input::get('voucherCode');
        $cartAmount = Helper::getMrpTotal();

        $validVoucher = Coupon::where("coupon_code", "=", $voucherCode)
                        ->where("coupon_type", "=", 3)
                        ->where("initial_coupon_val", "!=", 0)
                        ->get()->toArray();

        if (!empty($validVoucher[0]['id'])) {
            if ($validVoucher[0]['id'] != Session::get('voucherUsedAmt')) {
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
                    $productP = (($c->subtotal - $c->options->disc - $c->options->wallet_disc - $c->options->referral_disc - $c->options->user_disc - $c->options->voucher_disc) / 100);
                    $orderAmtP = ($orderAmt / 100);
                    $amt = Helper::discForProduct($productP, $orderAmtP, Session::get('voucherAmount'));

                    Cart::instance('shopping')->update($k, ["options" => ['voucher_disc' => $amt]]);
                }
                $cart_data = Helper::calAmtWithTax();
                $cartAmount = $cart_data['total'];
                // $finalamt = $cartAmount - Session::get('checkbackUsedAmt')- Session::get('voucherAmount');
                $finalamt = $cartAmount;
                if ($finalamt <= 0)
                    $finalamt = 0;
                else
                    $finalamt = $finalamt;
                Session::put('pay_amt', $finalamt);
                return ['status' => 1, 'msg' => 'Valid Voucher', 'voucherAmount' => (Session::get('voucherAmount') * Session::get('currency_val')), 'finalAmt' => ($finalamt * Session::get('currency_val'))];
                //echo "Valid Voucher:-" . (Session::get('voucherAmount') * Session::get('currency_val')) . ":-" . ($finalamt * Session::get('currency_val'));
            }else {
//                echo "invalid data";
                Session::forget('voucherUsedAmt');
                return ['status' => 0, 'msg' => 'invalid data', 'voucherAmount' => 0];
            }
        } else {
            $cart = Cart::instance('shopping')->content();
            foreach ($cart as $k => $c) {
                Cart::instance('shopping')->update($k, ["options" => ['voucher_disc' => 0]]);
            }
            Session::forget('voucherAmount');
            Session::forget('voucherUsedAmt');
            $cart_data = Helper::calAmtWithTax();
            $finalamt = $cart_data['total'];
            // $finalamt = Session::get('pay_amt') + Session::get('voucherAmount');
            Session::put('pay_amt', $finalamt);
            return ['status' => 1, 'msg' => 'Invalid Voucher', 'voucherAmount' => (Session::get('voucherAmount') * Session::get('currency_val')), 'finalAmt' => ($finalamt * Session::get('currency_val'))];
            //echo "Invalid Voucher:-" . (Session::get('voucherAmount') * Session::get('currency_val')) . ":-" . ($finalamt * Session::get('currency_val'));
        }
    }

    public function check_user_level_discount() {
        $cart_data = Helper::calAmtWithTax();
        $cartAmount = $cart_data['total'];
        $discType = Input::get('discType');
        $discVal = Input::get('discVal');
        //  $cartAmount = Helper::getAmt();
        if ($discType == 1) {
            $discountAmt = ($cartAmount * $discVal / 100);
            Session::put("discAmt", $discountAmt);
            Session::put("discType", $discType);
            // $cartAmount = Helper::getAmt('discAmt');
            $orderAmt = Helper::getMrpTotal();
            $cart = Cart::instance('shopping')->content();
            foreach ($cart as $k => $c) {
                $productP = (($c->subtotal - $c->options->disc - $c->options->wallet_disc - $c->options->referral_disc) / 100);
                $orderAmtP = ($orderAmt / 100);
                $amt = Helper::discForProduct($productP, $orderAmtP, Session::get('discAmt'));

                Cart::instance('shopping')->update($k, ["options" => ['user_disc' => $amt]]);
            }

            $cart_data = Helper::calAmtWithTax();
            $amountAfrDisc = $cart_data['total'] * Session::get('currency_val');

            return $data = ['status' => 'success', 'msg' => "<span style='color:green;'>Discount Code Applied!</span> <a href='javascript:void(0);' style='border-bottom: 1px dashed;' class='clearDiscount' id='discAmt'>Remove!</a>", 'discountedAmt' => $amountAfrDisc, 'discVal' => ($discountAmt * Session::get('currency_val'))];
        } else if ($discType == 2) {
            // $amountAfrDisc = $cartAmount - $discVal;
            $discountAmt = ($discVal);
            Session::put("discAmt", $discountAmt);
            Session::put("discType", $discType);
            // $cartAmount = Helper::getAmt('discAmt');

            $orderAmt = Helper::getMrpTotal();
            $cart = Cart::instance('shopping')->content();
            foreach ($cart as $k => $c) {
                $productP = (($c->subtotal - $c->options->disc - $c->options->wallet_disc - $c->options->referral_disc) / 100);
                $orderAmtP = ($orderAmt / 100);
                $amt = Helper::discForProduct($productP, $orderAmtP, Session::get('discAmt'));
                Cart::instance('shopping')->update($k, ["options" => ['user_disc' => $amt]]);
            }

            $cart_data = Helper::calAmtWithTax();
            $amountAfrDisc = $cart_data['total'] * Session::get('currency_val');

            return $data = ['status' => 'success', 'msg' => "<span style='color:green;'>Discount Code Applied!</span> <a href='javascript:void(0);' style='border-bottom: 1px dashed;' class='clearDiscount' id='discAmt'>Remove!</a>", 'discountedAmt' => $amountAfrDisc, 'discVal' => ($discountAmt * Session::get('currency_val'))];
        } else {

            $cart = Cart::instance('shopping')->content();
            foreach ($cart as $k => $c) {
                Cart::instance('shopping')->update($k, ["options" => ['user_disc' => 0]]);
            }
            return $data = ['status' => 'error', 'msg' => "<span style='color:red;'>Invalid Code</span>", 'cartAmt' => ($cartAmount * Session::get('currency_val')), 'discVal' => 0.00];
        }
    }

    public function revert_user_level_discount() {
        // $cartAmount = Helper::getAmt('discAmt');
        Session::forget('discAmt');
        Session::forget("discType");

        $cart = Cart::instance('shopping')->content();
        foreach ($cart as $k => $c) {
            Cart::instance('shopping')->update($k, ["options" => ['user_disc' => 0]]);
        }
        $cart_data = Helper::calAmtWithTax();
        $cartAmount = $cart_data['total'];

        $finalAmount = $cartAmount;
        return $data = ['status' => 'success', 'finalAmount' => ($finalAmount * Session::get('currency_val'))];
    }

    public function check_referal_code() {
        $requireReferalCode = Input::get('RefCode');
        //  $cart_amount = Helper::getAmt('referal');
        $cart_amount = Helper::getMrpTotal();
        $checkReferral = GeneralSetting::where('url_key', 'referral')->first();
        $detailsR = json_decode($checkReferral->details);
        foreach ($detailsR as $detRk => $detRv) {
            if ($detRk == "activate_duration_in_days")
                $activate_duration = $detRv;
            if ($detRk == "bonous_to_referee")
                $bonousToReferee = $detRv;
            if ($detRk == "discount_on_order")
                $discountOnOrder = $detRv;
        }
        if (!empty($requireReferalCode))
            $allRefCode = User::where("id", "!=", Session::get('loggedin_user_id'))->where("referal_code", "=", $requireReferalCode)->get();
        if (count($allRefCode) > 0) {
            $ref_disc = round(($cart_amount * $discountOnOrder) / 100, 2);
            $user_referal_points = round(($cart_amount * $bonousToReferee) / 100, 2);
            Session::put("userReferalPoints", $user_referal_points);
            Session::put("referalCodeAmt", $ref_disc);
            Session::put("ReferalCode", $requireReferalCode);
            Session::put("ReferalId", $allRefCode[0]->id);

            $orderAmt = Helper::getMrpTotal();
            $cart = Cart::instance('shopping')->content();
            foreach ($cart as $k => $c) {
                $productP = (($c->subtotal - $c->options->disc - $c->options->wallet_disc - $c->options->user_disc) / 100);
                $orderAmtP = round($orderAmt / 100);
                $amt = Helper::discForProduct($productP, $orderAmtP, Session::get('referalCodeAmt'));

                Cart::instance('shopping')->update($k, ["options" => ['referral_disc' => $amt]]);
            }

            $cart_data = Helper::calAmtWithTax();
            $cartAmount = $cart_data['total'];
            $finalamt = $cartAmount;
            //  $finalamt = $cart_amount - Session::get('referalCodeAmt');
            if ($finalamt <= 0)
                $finalamt = 0;
            else
                $finalamt = $finalamt;

            // dd(Cart::instance('shopping')->content());
            Session::put('pay_amt', $finalamt);
//            echo "Valid:-" . Session::get('referalCodeAmt') . ":-" . Session::get('pay_amt');
            return ['status' => 1, 'msg' => "Valid", 'referalCodeAmt' => (Session::get('referalCodeAmt') * Session::get('currency_val')), "finalAmt" => (Session::get('pay_amt') * Session::get('currency_val'))];
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
            $finalamt = Session::get('pay_amt') + Session::get('referalCodeAmt');
            $cart_data = Helper::calAmtWithTax();
            $finalamt = $cart_data['total'];
            Session::put('pay_amt', $finalamt);
//            echo "Invalid:-" . $referalCodeAmt . ":-" . Session::get('pay_amt');
            return ['status' => 0, 'msg' => "Invalid", 'referalCodeAmt' => 0.00, "finalAmt" => (Session::get('pay_amt') * Session::get('currency_val') )];
        }
    }

    public function encrypt_value() {
        echo Crypt::encrypt(Input::get('new_amt'));
    }

    public function decrypt_value() {
        echo Crypt::decrypt(Input::get('new_amt'));
    }

    // For cashback
    public function require_cashback() {
        $user_id = input::get('userId');

        if (isset($user_id)) {

            $cashback = @User::find($user_id)->userCashback->cashback * Session::get('currency_val');
        } else {
            $cashback = @User::find(Session::get('loggedin_user_id'))->userCashback->cashback;
        }

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
            $finalamt = $finalamt;
        }
        $cart = Cart::instance('shopping')->content();

        Session::put('pay_amt', $finalamt);
//        echo (Session::get('remainingCashback') * Session::get('currency_val')) . ":-" . (@Session::get('checkbackUsedAmt') * Session::get('currency_val')) . ":-" . (Session::get('pay_amt') * Session::get('currency_val')) . ':-' . json_encode($cart);
        $data['msg'] = 'success';
        $data['remainingCashback'] = (Session::get('remainingCashback') * Session::get('currency_val'));
        $data['checkbackUsedAmt'] = (@Session::get('checkbackUsedAmt') * Session::get('currency_val'));
        $data['pay_amt'] = (Session::get('pay_amt') * Session::get('currency_val'));
        $data['cart'] = json_encode($cart);
        return $data;
    }

    public function revert_cashback() {
        $finalamt = Session::get('pay_amt') + Session::get('checkbackUsedAmt');

        $cart = Cart::instance('shopping')->content();
        foreach ($cart as $k => $c) {
            Cart::instance('shopping')->update($k, ["options" => ['wallet_disc' => 0]]);
        }
        Session::put('checkbackUsedAmt', 0);
        $cart_data = Helper::calAmtWithTax();
        $finalamt = $cart_data['total'];

        Session::put('pay_amt', $finalamt);
        $data['cashback'] = User::find(Session::get('loggedin_user_id'))->userCashback->cashback;
//        echo number_format(($finalamt * Session::get('currency_val')), 2);
        $data['finalamt'] = number_format(($finalamt * Session::get('currency_val')), 2);
        return $data;
    }

    // For cod
    public function order_cash_on_delivery() {
        $selAdd = Address::find(Session::get("addressSelected"));
        //    $userC = Helper::checkCodPincode($selAdd->postcode);
        //  if ($userC == 1 || $userC == 6) {
        // $finalamt = Helper::getAmt();
        $finalamt = Session::get('pay_amt');
//        dd($finalamt);
        if ($finalamt > 0) {
            $paymentMethod = "1";
            $paymentStatus = "1";
            $payAmt = $finalamt;
            $trasactionId = "";
            $transactionStatus = "";
            $suc = $this->saveOrderSuccess($paymentMethod, $paymentStatus, $payAmt, $trasactionId, $transactionStatus);
        } else {
            $paymentMethod = "3";
            $paymentStatus = "4";
            $payAmt = $finalamt;
            $trasactionId = "";
            $transactionStatus = "";
            $suc = $this->saveOrderSuccess($paymentMethod, $paymentStatus, $payAmt, $trasactionId, $transactionStatus);
        }
        if (!empty($suc['email']))
            $this->successMail($suc['orderId'], $suc['first_name'], $suc['email']);
        return redirect()->route('orderSuccess');

        // } 
    }

    public function getCityPay() {
        define('DS', DIRECTORY_SEPARATOR);
        include(app_path() . DS . 'Library' . DS . 'Functions.php');
        $payAmt = 1; //Helper::getAmt();
        Session::put('theme_id', Input::get("theme_id"));
        $server = $_SERVER['HTTP_HOST'];
        ?>

        <form method="post" action="https://<?php echo $server; ?>/get-city-createOrder" name="cityPayForm">
            <input type="hidden" size="25" name="Merchant" value="11122333" readonly/>
            <input type="hidden" size="25" name="Amount" value="1"/>
            <input type="hidden" size="25" name="Currency" value="050" readonly/>
            <input type="hidden" size="25" name="Description" value="1520"/>

            <input type="hidden" size="50" name="ApproveURL" value="https://<?php echo $server; ?>/get-city-approved" readonly/>
            <input type="hidden" size="50" name="CancelURL" value="https://<?php echo $server; ?>/get-city-cancelled" readonly/>
            <input type="hidden" size="50" name="DeclineURL" value="https://<?php echo $server; ?>/get-city-declined" readonly/>
            <input type="submit" style="display:none;" value="Create Order"/>
        </form>
        <script type="text/javascript">
            document.cityPayForm.submit();
        </script>

        <?php
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
        $data.="<ApproveURL>" . htmlentities(Input::get('ApproveURL')) . "</ApproveURL>";
        $data.="<CancelURL>" . htmlentities(Input::get('CancelURL')) . "</CancelURL>";
        $data.="<DeclineURL>" . htmlentities(Input::get('DeclineURL')) . "</DeclineURL>";
        $data.="</Order></Request></TKKPG>";

        $xml = PostQW($data);
        //  dd($xml);
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

    public function getCityApproved() {

        //  dd($_REQUEST['xmlmsg']);
        if (@$_REQUEST['xmlmsg'] != "") {

            $xmlResponse = simplexml_load_string($_REQUEST['xmlmsg']);
            $json = json_encode($xmlResponse);
            $array = json_decode($json, TRUE);
            if (empty(Session::get('orderId'))) {
                Session::put('orderId', $array['OrderDescription']);
            }
            $des = '';
            $paymentMethod = 9;
            $paymentStatus = 4;
            $payAmt = $array['PurchaseAmountScr'];
            $trasactionId = $array['MerchantTranID'];
            $transactionStatus = $array['OrderStatus'];
            $transaction_info = json_encode($array);
            $this->saveOrderSuccess($paymentMethod, $paymentStatus, $payAmt, $trasactionId, $transactionStatus, $des, $transaction_info);
            return redirect()->route('orderSuccess');
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

    // For ebs
    public function ebs() {
        // $payAmtE = Helper::getAmt();
        $payAmtE = Session::get('pay_amt');
        $dtails = json_decode(GeneralSetting::where('url_key', 'ebs')->first()->details);
        foreach ($dtails as $detk => $detv) {
            if ($detk == "mode")
                $mode = $detv;
            if ($detk == "key")
                $ebskey = $detv;
            if ($detk == "account_id")
                $account_id = $detv;
        }
        $refNo = Session::get('orderID');
        $retUrl = route('response') . "?DR={DR}";
        //    dd($payAmtD);
        $hash = $ebskey . "|" . $account_id . "|" . $payAmtE . "|" . $refNo . "|" . $retUrl . "|" . $mode;
        $_POST['secure_hash'] = md5($hash);
        ?> 
        <form action='https://secure.ebs.in/pg/ma/sale/pay' method='post' name='frm'>
            <?php
            foreach ($_POST as $a => $b) {
                if (htmlentities($a) == "amount") {
                    echo "<input type='hidden' name='" . htmlentities($a) . "' value='" . htmlentities($payAmtE) . "'>";
                } else {
                    echo "<input type='hidden' name='" . htmlentities($a) . "' value='" . htmlentities($b) . "'>";
                }
            }
            ?>
        </form>
        <script language="JavaScript">
            document.frm.submit();
        </script>
        <?php
    }

    public function response() {
        $chkReferal = GeneralSetting::where('url_key', 'ebs')->first()->status;
        $chkLoyalty = GeneralSetting::where('url_key', 'loyalty')->first()->status;
        $dtails = json_decode(GeneralSetting::where('url_key', 'ebs')->first()->details);
        foreach ($dtails as $detk => $detv) {
            if ($detk == "mode")
                $mode = $detv;
            if ($detk == "key")
                $ebskey = $detv;
            if ($detk == "account_id")
                $account_id = $detv;
        }
        $secret_key = $ebskey;  // Your Secret Key
        if (isset($_GET['DR'])) {
            $DR = preg_replace("/\s/", "+", $_GET['DR']);
            $rc4new = new Crypt_RC4();
            $rc4 = $rc4new->Crypt_RC4($secret_key);
            $QueryString = base64_decode($DR);
            $rc4new->decrypt($QueryString);
            $QueryString = explode('&', $QueryString);
            $response = array();
            foreach ($QueryString as $param) {
                $param = explode('=', $param);
                $response[$param[0]] = urldecode($param[1]);
            }

            $paymentMethod = "2";
            $paymentStatus = "4";
            $payAmt = $response['Amount'];
            $trasactionId = $response['TransactionID'];
            $transactionStatus = $response['ResponseMessage'];
            $des = $response['Description'];
            $cartContent = Cart::instance('shopping')->content();
            if ($response['ResponseCode'] == 0) {
                $paymentMethod = "2";
                $paymentStatus = "4";
                $payAmt = $response['Amount'];
                $trasactionId = $response['TransactionID'];
                $transactionStatus = $response['ResponseMessage'];
                $des = $response['Description'];
                $this->saveOrderSuccess($paymentMethod, $paymentStatus, $payAmt, $trasactionId, $transactionStatus, $des);
            } else {
                $paymentMethod = "2";
                $paymentStatus = "0";
                $payAmt = $response['Amount'];
                $transactionStatus = $response['ResponseMessage'];
                $this->saveOrderFailure($paymentMethod, $paymentStatus, $payAmt, $transactionStatus);
            }
        }
        return redirect()->route('orderFailure');
    }

    // For paypal
    public function paypal_process() {
        $details = json_decode(GeneralSetting::where('url_key', 'paypal')->first()->details, true);
        foreach ($details as $dtk => $dtv) {
            if ($dtk == "mode")
                $mode = $dtv;
            if ($dtk == "api_username")
                $api_username = $dtv;
            if ($dtk == "api_password")
                $api_password = $dtv;
            if ($dtk == "api_signature")
                $api_signature = $dtv;
            if ($dtk == "currency_code")
                $api_currency_code = $dtv;
            if ($dtk == "logo_url")
                $api_logo_url = $dtv;
        }
        $PayPalMode = $mode; // sandbox or live
        $PayPalApiUsername = $api_username; //PayPal API Username
        $PayPalApiPassword = $api_password; //Paypal API password
        $PayPalApiSignature = $api_signature; //Paypal API Signature
        $PayPalCurrencyCode = $api_currency_code; //Paypal Currency Code
        $PayPalReturnURL = route('paypal_success'); //Point to process.php page
        $PayPalCancelURL = route('orderCancel');
        $paypalmode = ($PayPalMode == 'sandbox') ? '.sandbox' : '';
        $ItemName = "The Souled Store Order"; //Item Name
        $getTotPrice = $this->convertCurrency(Crypt::decrypt(Input::get('amount')), "INR", "USD");
        $ItemPrice = number_format($getTotPrice, 2); //Item Price
        $ItemNumber = Session::get('orderId'); //Item Number
        $ItemQty = 1; // Item Quantity
        $ItemTotalPrice = number_format($getTotPrice, 2); //(Item Price x Quantity = Total) Get total amount of product; 
        $TotalTaxAmount = 0;  //Sum of tax for all items in this order. 
        $HandalingCost = 0;  //Handling cost for this order.
        $InsuranceCost = 0;  //shipping insurance cost for this order.
        $ShippinDiscount = 0; //Shipping discount for this order. Specify this as negative number.
        $ShippinCost = 0; //Although you may change the value later, try to pass in a shipping amount that is reasonably accurate.
        $GrandTotal = ($ItemTotalPrice + $TotalTaxAmount + $HandalingCost + $InsuranceCost + $ShippinCost + $ShippinDiscount);
        //Parameters for SetExpressCheckout, which will be sent to PayPal
        $padata = '&METHOD=SetExpressCheckout' .
                '&RETURNURL=' . urlencode($PayPalReturnURL) .
                '&CANCELURL=' . urlencode($PayPalCancelURL) .
                '&PAYMENTREQUEST_0_PAYMENTACTION=' . urlencode("SALE") .
                '&L_PAYMENTREQUEST_0_NAME0=' . urlencode($ItemName) .
                '&L_PAYMENTREQUEST_0_NUMBER0=' . urlencode($ItemNumber) .
                '&L_PAYMENTREQUEST_0_AMT0=' . urlencode($ItemPrice) .
                '&L_PAYMENTREQUEST_0_QTY0=' . urlencode($ItemQty) .
                '&NOSHIPPING=0' . //set 1 to hide buyer's shipping address, in-case products that does not require shipping
                '&PAYMENTREQUEST_0_ITEMAMT=' . urlencode($ItemTotalPrice) .
                '&PAYMENTREQUEST_0_TAXAMT=' . urlencode($TotalTaxAmount) .
                '&PAYMENTREQUEST_0_SHIPPINGAMT=' . urlencode($ShippinCost) .
                '&PAYMENTREQUEST_0_HANDLINGAMT=' . urlencode($HandalingCost) .
                '&PAYMENTREQUEST_0_SHIPDISCAMT=' . urlencode($ShippinDiscount) .
                '&PAYMENTREQUEST_0_INSURANCEAMT=' . urlencode($InsuranceCost) .
                '&PAYMENTREQUEST_0_AMT=' . urlencode($GrandTotal) .
                '&PAYMENTREQUEST_0_CURRENCYCODE=' . urlencode($PayPalCurrencyCode) .
                '&LOCALECODE=GB' . //PayPal pages to match the language on your website.
                '&LOGOIMG=' . $api_logo_url . //site logo
                '&CARTBORDERCOLOR=FFFFFF' . //border color of cart
                '&ALLOWNOTE=1';
        Session::put('ItemName', $ItemName);
        Session::put('ItemPrice', $ItemPrice);
        Session::put('ItemNumber', $ItemNumber);
        Session::put('ItemQty', $ItemQty);
        Session::put('ItemTotalPrice', $ItemTotalPrice);
        Session::put('TotalTaxAmount', $TotalTaxAmount);
        Session::put('HandalingCost', $HandalingCost);
        Session::put('InsuranceCost', $InsuranceCost);
        Session::put('ShippinDiscount', $ShippinDiscount);
        Session::put('ShippinCost', $ShippinCost);
        Session::put('GrandTotal', $GrandTotal);
        $paypal = new MyPayPal();
        $httpParsedResponseAr = $paypal->PPHttpPost('SetExpressCheckout', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);
        //Respond according to message we receive from Paypal
        if ("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {
            $paypalurl = 'https://www' . $paypalmode . '.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token=' . $httpParsedResponseAr["TOKEN"] . '';
            return redirect()->to($paypalurl);
        } else {
            //Show error message
            echo '<div style="color:red"><b>Error : </b>' . urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]) . '</div>';
            echo '<pre>';
            print_r($httpParsedResponseAr);
            echo '</pre>';
        }
    }

    function convertCurrency($amount, $from, $to) {
        $url = "https://www.google.com/finance/converter?a=$amount&from=$from&to=$to";
        $data = file_get_contents($url);
        preg_match("/<span class=bld>(.*)<\/span>/", $data, $converted);
        $converted = preg_replace("/[^0-9.]/", "", $converted[1]);
        return round($converted, 3);
    }

    public function paypal_success() {
        $details = json_decode(GeneralSetting::where('url_key', 'paypal')->first()->details, true);
        foreach ($details as $dtk => $dtv) {
            if ($dtk == "mode")
                $mode = $dtv;
            if ($dtk == "api_username")
                $api_username = $dtv;
            if ($dtk == "api_password")
                $api_password = $dtv;
            if ($dtk == "api_signature")
                $api_signature = $dtv;
            if ($dtk == "currency_code")
                $api_currency_code = $dtv;
            if ($dtk == "logo_url")
                $api_logo_url = $dtv;
        }
        $PayPalMode = $mode; // sandbox or live
        $PayPalApiUsername = $api_username; //PayPal API Username
        $PayPalApiPassword = $api_password; //Paypal API password
        $PayPalApiSignature = $api_signature; //Paypal API Signature
        $PayPalCurrencyCode = $api_currency_code; //Paypal Currency Code
        $PayPalReturnURL = route('paypal_success'); //Point to process.php page
        $PayPalCancelURL = route('paypal_cancel');
        if (!empty(Input::get("token")) && !empty(Input::get("PayerID"))) {
            $token = Input::get("token");
            $payer_id = Input::get("PayerID");
            $ItemName = Session::get('ItemName'); //Item Name
            $ItemPrice = Session::get('ItemPrice'); //Item Price
            $ItemNumber = Session::get('ItemNumber'); //Item Number
            $ItemQty = Session::get('ItemQty'); // Item Quantity
            $ItemTotalPrice = Session::get('ItemTotalPrice'); //(Item Price x Quantity = Total) Get total amount of product; 
            $TotalTaxAmount = Session::get('TotalTaxAmount');  //Sum of tax for all items in this order. 
            $HandalingCost = Session::get('HandalingCost');  //Handling cost for this order.
            $InsuranceCost = Session::get('InsuranceCost');  //shipping insurance cost for this order.
            $ShippinDiscount = Session::get('ShippinDiscount'); //Shipping discount for this order. Specify this as negative number.
            $ShippinCost = Session::get('ShippinCost'); //Although you may change the value later, try to pass in a shipping amount that is reasonably accurate.
            $GrandTotal = Session::get('GrandTotal');
            $padata = '&TOKEN=' . urlencode($token) .
                    '&PAYERID=' . urlencode($payer_id) .
                    '&PAYMENTREQUEST_0_PAYMENTACTION=' . urlencode("SALE") .
                    '&L_PAYMENTREQUEST_0_NAME0=' . urlencode($ItemName) .
                    '&L_PAYMENTREQUEST_0_NUMBER0=' . urlencode($ItemNumber) .
                    '&L_PAYMENTREQUEST_0_AMT0=' . urlencode($ItemPrice) .
                    '&L_PAYMENTREQUEST_0_QTY0=' . urlencode($ItemQty) .
                    '&PAYMENTREQUEST_0_ITEMAMT=' . urlencode($ItemTotalPrice) .
                    '&PAYMENTREQUEST_0_TAXAMT=' . urlencode($TotalTaxAmount) .
                    '&PAYMENTREQUEST_0_SHIPPINGAMT=' . urlencode($ShippinCost) .
                    '&PAYMENTREQUEST_0_HANDLINGAMT=' . urlencode($HandalingCost) .
                    '&PAYMENTREQUEST_0_SHIPDISCAMT=' . urlencode($ShippinDiscount) .
                    '&PAYMENTREQUEST_0_INSURANCEAMT=' . urlencode($InsuranceCost) .
                    '&PAYMENTREQUEST_0_AMT=' . urlencode($GrandTotal) .
                    '&PAYMENTREQUEST_0_CURRENCYCODE=' . urlencode($PayPalCurrencyCode);
            $paypal = new MyPayPal();
            $httpParsedResponseAr = $paypal->PPHttpPost('DoExpressCheckoutPayment', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);
            if ("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {
                $msg1 = '<h2>Success</h2>';
                $msg2 = 'Your Transaction ID : ' . urldecode($httpParsedResponseAr["PAYMENTINFO_0_TRANSACTIONID"]);
                if ('Completed' == $httpParsedResponseAr["PAYMENTINFO_0_PAYMENTSTATUS"]) {
                    $msg3 = '<div style="color:green">Payment Received! Your product will be sent to you very soon!</div>';
                } elseif ('Pending' == $httpParsedResponseAr["PAYMENTINFO_0_PAYMENTSTATUS"]) {
                    $msg3 = '<div style="color:red">Transaction Complete, but payment is still pending! ' .
                            'You need to manually authorize this payment in your <a target="_new" href="http://www.paypal.com">Paypal Account</a></div>';
                }
                $padata = '&TOKEN=' . urlencode($token);
                $paypal = new MyPayPal();
                $httpParsedResponseAr = $paypal->PPHttpPost('GetExpressCheckoutDetails', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);
                // dd($httpParsedResponseAr);
                if ("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {
                    $cartContent = Cart::instance('shopping')->content();
                    $user = User::find(Session::get('loggedin_user_id'));
                    $order = Order::find(Session::get('orderId'));
                    $order->user_id = $user->id;
                    $resAmount = $this->convertCurrency(urldecode($httpParsedResponseAr['AMT']), "USD", "INR");
                    $order->pay_amt = $resAmount;
                    $order->order_amt = Cart::instance('shopping')->total();
                    $order->payment_method = "4";
                    $order->payment_status = "4";
                    $order->order_status = 1;
                    $order->gifting_charges = is_null(Session::get('GiftingCharges')) ? 0 : Session::get('GiftingCharges');
                    $order->voucher_amt_used = is_null(Session::get('voucherAmount')) ? 0 : Session::get('voucherAmount');
                    $order->coupon_amt_used = is_null(Session::get('couponUsedAmt')) ? 0 : Session::get('couponUsedAmt');
                    $order->voucher_used = is_null(Session::get('voucherUsedAmt')) ? 0 : Session::get('voucherUsedAmt');
                    $order->coupon_used = is_null(Session::get('usedCouponId')) ? 0 : Session::get('usedCouponId');
                    $order->cashback_used = is_null(Session::get('checkbackUsedAmt')) ? 0 : Session::get('checkbackUsedAmt');
                    if (!empty(Session::get("ReferalId"))) {
                        $order->referal_code_used = Session::get("ReferalCode");
                        $order->referal_code_amt = Session::get("referalCodeAmt");
                        $order->user_ref_points = Session::get("userReferalPoints");
                        $order->ref_flag = 0;
                    }
                    $order->shipping_amt = is_null(Session::get('shippingAmount')) ? 0 : Session::get('shippingAmount');
                    $order->transaction_id = $httpParsedResponseAr['PAYMENTREQUEST_0_TRANSACTIONID'];
                    $order->transaction_status = "Success";
                    $order->cart = json_encode($cartContent);
                    $loyaltyPercent = $user->loyalty['percent'];
                    $order->cashback_earned = is_null($loyaltyPercent) ? 0 : number_format(($loyaltyPercent * $order->pay_amt) / 100, 2);
                    $order->cashback_credited = is_null($loyaltyPercent) ? 0 : number_format(($loyaltyPercent * $order->pay_amt) / 100, 2);
                    $user->userCashback->cashback = $user->userCashback->cashback - @Session::get('checkbackUsedAmt');
                    $user->userCashback->save();
                    if (!empty(Session::get('voucherUsedAmt'))) {
                        $voucherUpdate = Coupon::find(Session::get('voucherUsedAmt'));
                        $voucherUpdate->voucher_val = is_null(Session::get('remainingVoucherAmt')) ? $voucherUpdate->voucher_val : Session::get('remainingVoucherAmt');
                        $voucherUpdate->update();
                    }
                    $date = date("Y-m-d H:i:s");
                    $order->created_at = $date;
                    if ($order->Update()) {
                        $cart_ids = [];
                        foreach ($cartContent as $cart) {
                            $cart_ids[$cart->id] = ["qty" => $cart->qty, "price" => $cart->subtotal, "created_at" => date('Y-m-d H:i:s')];
                            if ($cart->options->is_crowd_funded == 0) {
                                if ($cart->options->has('sub_prod')) {
                                    $cart_ids[$cart->id]["sub_prod_id"] = $cart->options->sub_prod;
                                    $prd = Product::find($cart->options->sub_prod);
                                    $prd->stock = $prd->stock - $cart->qty;
                                    $prd->update();
                                } else if ($cart->options->has('combos')) {

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
                                } else {
                                    $prd = Product::find($cart->id);
                                    $prd->stock = $prd->stock - $cart->qty;
                                    $prd->update();
                                }
                            }
                        }
                    }
                    if (!empty($cart_ids)) {
                        $order->products()->sync($cart_ids);
                    } else {
                        $order->products()->detach();
                    }
                    $amt = $user->orders()->sum("order_amt");
                    $loyalty = Loyalty::where("min_order_amt", "<=", $amt)->orderBy("min_order_amt", "desc")->first();
                    if (isset($loyalty->id)) {
                        $user->loyalty_group = $loyalty->id;
                    }
                    $user->update();
                } else {
                    $msg4 = '<div style="color:red"><b>GetTransactionDetails failed:</b>' . urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]) . '</div>';
                    $paypalFailorder = Order::find(Session::get('orderId'));
                    $paypalFailorder->pay_amt = Session::get('ItemPrice') * 60;
                    $paypalFailorder->order_amt = Cart::instance('shopping')->total();
                    $paypalFailorder->payment_method = "4";
                    $paypalFailorder->payment_status = "0";
                    $paypalFailorder->transaction_status = "Failure";
                    $paypalFailorder->cart = json_encode(Cart::instance('shopping')->content());
                    $paypalFailorder->order_status = 0;
                    $paypalFailorder->update();
                }
                $resAmount = $this->convertCurrency(urldecode($httpParsedResponseAr['AMT']), "USD", "INR");
                $paymentMethod = "4";
                $paymentStatus = "4";
                $payAmt = $resAmount;
                $trasactionId = $httpParsedResponseAr['PAYMENTREQUEST_0_TRANSACTIONID'];
                $transactionStatus = "Success";
                $suc = $this->saveOrderSuccess($paymentMethod, $paymentStatus, $payAmt, $trasactionId, $transactionStatus);
                $this->successMail($suc['orderId'], $suc['first_name'], $suc['email']);
                return redirect()->route('orderSuccess');
            } else {
                $paymentMethod = "4";
                $paymentStatus = "1";
                $payAmt = $finalAmt;
                $trasactionId = "";
                $transactionStatus = "Failure";
                $this->saveOrderFailure($paymentMethod, $paymentStatus, $payAmt, $transactionStatus);
                $msg5 = '<div style="color:red"><b>Error : </b>' . urldecode($httpParsedResponseAr["L_LONGMESSAGE0"]) . '</div>';
                return redirect()->route('orderFailure');
            }
        }
    }

    public function paypal_cancel() {
        $details = json_decode(GeneralSetting::where('url_key', 'paypal')->first()->details, true);
        foreach ($details as $dtk => $dtv) {
            if ($dtk == "mode")
                $mode = $dtv;
            if ($dtk == "api_username")
                $api_username = $dtv;
            if ($dtk == "api_password")
                $api_password = $dtv;
            if ($dtk == "api_signature")
                $api_signature = $dtv;
            if ($dtk == "currency_code")
                $api_currency_code = $dtv;
            if ($dtk == "logo_url")
                $api_logo_url = $dtv;
        }
        $PayPalMode = $mode; // sandbox or live
        $PayPalApiUsername = $api_username; //PayPal API Username
        $PayPalApiPassword = $api_password; //Paypal API password
        $PayPalApiSignature = $api_signature; //Paypal API Signature
        $PayPalCurrencyCode = $api_currency_code; //Paypal Currency Code
        $PayPalReturnURL = route('paypal_success'); //Point to process.php page
        $PayPalCancelURL = route('orderCancel');
        return redirect()->route('orderCancel');
    }

    // For payU
    public function getPayu() {
        define('DS', DIRECTORY_SEPARATOR);
        include(app_path() . DS . 'Classes' . DS . 'payu.php');
        $details = json_decode(GeneralSetting::where('url_key', 'pay-u-money')->first()->details);
        foreach ($details as $detk => $detv) {
            if ($detk == "merchant_id")
                $merchantid = $detv;
            if ($detk == "salt")
                $salt = $detv;
        }
        // $finalamt = Helper::getAmt();
        $finalamt = Session::get('pay_amt');

        $arr = array('key' => $merchantid,
            'txnid' => uniqid(),
            'amount' => $finalamt,
            'firstname' => 'Cartini',
            'email' => 'support@infiniteit.biz',
            'phone' => '121',
            'productinfo' => 'Product Info',
            'surl' => 'payu_success',
            'furl' => 'payu_failure');
        pay_page($arr, $salt);
    }

    public function payuSuccess() {
        //  dd(Input::get('data'));
        $data = json_decode(Input::get('data'));
        // $finalAmt = Helper::getAmt();
        $finalAmt = Session::get("pay_amt");
        if ($data->status == "success") {
            $paymentMethod = "5";
            $paymentStatus = "4";
            $payAmt = $data->amount;
            $trasactionId = $data->mihpayid;
            $transactionStatus = $data->status;
            $suc = $this->saveOrderSuccess($paymentMethod, $paymentStatus, $payAmt, $trasactionId, $transactionStatus);
        } else {
            $paymentMethod = "5";
            $paymentStatus = "1";
            $payAmt = $finalAmt;
            $trasactionId = "";
            $transactionStatus = "Failure";
            $suc = $this->saveOrderFailure($paymentMethod, $paymentStatus, $payAmt, $transactionStatus);
        }

        $this->successMail($suc['orderId'], $suc['first_name'], $suc['email']);
        return redirect()->to('/order-success');
    }

    public function payuFailure() {
        $paymentMethod = "5";
        $paymentStatus = "1";
        $payAmt = Session::get("pay_amt");
        $trasactionId = "";
        $transactionStatus = "Failure";


        $this->saveOrderFailure($paymentMethod, $paymentStatus, $payAmt, $transactionStatus);
        return redirect()->route('orderFailure');
    }

    // For razorpay
    public function getRazorpay() {
        $details = json_decode(GeneralSetting::where('url_key', 'razorpay')->first()->details);
        foreach ($details as $detk => $detv) {
            if ($detk == "merchant_name")
                $merchantname = $detv;
            if ($detk == "key")
                $key = $detv;
            if ($detk == "logo")
                $logo = $detv;
        }
        ?>
        <form action="http://localhost/inficart/get-razorpay-response" method="POST" id="razForm">
            <!-- Note that the amount is in paise = 50 INR -->
            <script
                src="https://checkout.razorpay.com/v1/checkout.js"
                data-key="<?= $key; ?>"
                data-amount="<?= (Session::get('pay_amt') * 100); ?>"
                data-buttontext="Razorpay"
                data-name="<?= $merchantname; ?>"
                data-description="Purchase Description"
                data-image="<?= $logo ?>"
                data-prefill.name="Cartini"
                data-prefill.email="support@infiniteit.biz"
                data-theme.color="#F37254"
            ></script>
            <input type="hidden" value="Hidden Element" name="hidden">
        </form>
        <script type="text/javascript">
            document.querySelector('.razorpay-payment-button').click();
            document.getElementsByClassName('razorpay-payment-button')[0].style.visibility = 'hidden';
            // document.getElementsByClassName("razorpay-payment-button").style.display='none';
        </script>
        <?php
    }

    public function getRazorpayResponse() {
        if (!empty(Input::get('razorpay_payment_id'))) {
            $paymentMethod = "7";
            $paymentStatus = "4";
            $payAmt = Helper::getAmt();
            $trasactionId = Input::get('razorpay_payment_id');
            $transactionStatus = "success";
            $suc = $this->saveOrderSuccess($paymentMethod, $paymentStatus, $payAmt, $trasactionId, $transactionStatus);
        } else {
            $paymentMethod = "7";
            $paymentStatus = "1";
            $payAmt = Helper::getAmt();
            $trasactionId = "";
            $transactionStatus = "Failure";
            $suc = $this->saveOrderFailure($paymentMethod, $paymentStatus, $payAmt, $transactionStatus);
        }
        $this->successMail($suc['orderId'], $suc['first_name'], $suc['email']);
        return redirect()->route('orderSuccess');
    }

    // For citrus
    public function getCitrus() {
        $details = json_decode(GeneralSetting::where('url_key', 'citrus')->first()->details);
        foreach ($details as $detk => $detv) {
            if ($detk == "post_url")
                $postUrl = $detv;
            if ($detk == "secret_key")
                $secretKey = $detv;
            if ($detk == "vanity_url")
                $vanityUrl = $detv;
        }
        $formPostUrl = $postUrl;
        $secret_key = $secretKey;
        $vanityUrl = $vanityUrl;
        $merchantTxnId = uniqid();
        $orderAmount = "1";
        $currency = "INR";
        $data = $vanityUrl . $orderAmount . $merchantTxnId . $currency;
        $returnUrl = route('getCitrusResponse');
        $notifyUrl = route('getCitrusFailure');
        $securitySignature = hash_hmac('sha1', $data, $secret_key);
        ?>
        <html>
            <head>
                <meta HTTP-EQUIV="Content-Type" CONTENT="text/html;CHARSET=iso-8859-1">
            </head>
            <body>
                <form align="center" method="post" action="<?php echo $formPostUrl ?>" name="citrusForm">
                    <input type="hidden" id="merchantTxnId" name="merchantTxnId" value="<?php echo $merchantTxnId ?>" />
                    <input type="hidden" id="orderAmount" name="orderAmount" value="<?= $orderAmount ?>" />
                    <input type="hidden" id="currency" name="currency" value="<?= $currency ?>" />
                    <input type="hidden" name="returnUrl" value="<?= $returnUrl ?>" />
                    <input type="hidden" id="notifyUrl" name="notifyUrl" value="<?= @$notifyUrl ?>" />
                    <input type="hidden" id="secSignature" name="secSignature" value="<?= $securitySignature ?>" />
                    <input type="Submit" value="Pay Now" id="citrusSubmit"/>
                </form>
            </body>
        </html>
        </div>
        </body>
        </html>
        <script type="text/javascript">
            document.citrusForm.submit();
        </script>
        <?php
    }

    public function getCitrusResponse() {
        if (Input::get('TxStatus') == "SUCCESS") {
            $paymentMethod = "6";
            $paymentStatus = "4";
            $payAmt = Input::get('amount');
            $trasactionId = Input::get('TxId');
            $transactionStatus = Input::get('TxStatus');
            $suc = $this->saveOrderSuccess($paymentMethod, $paymentStatus, $payAmt, $trasactionId, $transactionStatus);
        } else {
            $paymentMethod = "6";
            $paymentStatus = "1";
            $payAmt = Helper::getAmt();

            $transactionStatus = "Failure";
            $suc = $this->saveOrderFailure($paymentMethod, $paymentStatus, $payAmt, $transactionStatus);
        }
        $this->successMail($suc['orderId'], $suc['first_name'], $suc['email']);
        return redirect()->route('orderSuccess');
    }

    public function getCitrusFailure() {
        $paymentMethod = "6";
        $paymentStatus = "1";
        $payAmt = Helper::getAmt();
        $transactionStatus = "Failure";
        $this->saveOrderFailure($paymentMethod, $paymentStatus, $payAmt, $transactionStatus);
        return redirect()->route('orderFailure');
    }

    // For order success function

    public function saveOrderSuccess($paymentMethod, $paymentStatus, $payAmt, $trasactionId, $transactionStatus, $des = null, $transactioninfo = null) {
        // if (Session::get('individualDiscountPercent')) {
        //     $coupDisc = json_decode(Session::get('individualDiscountPercent'), true);
        //     foreach ($coupDisc as $discK => $discV) {
        //         Cart::instance('shopping')->update($discK, ["options" => ['disc' => @$discV]]);
        //     }
        // }

        $chkReferal = GeneralSetting::where('url_key', 'referral')->first();
        $chkLoyalty = GeneralSetting::where('url_key', 'loyalty')->first();
        $stock_status = GeneralSetting::where('url_key', 'stock')->first()->status;
        $courier_status = GeneralSetting::where('url_key', 'default-courier')->first()->status;
        $user = User::find(Session::get('loggedin_user_id'));
        $order = Order::find(Session::get('orderId'));
        $iscod = 0;
        if ($paymentMethod == 1) {
            $iscod = 1;
        }
        if ($courier_status == 1) {
            $courier = HasCourier::where('status', 1)->where('store_id', $this->jsonString['store_id'])->orderBy("preference", "asc")->first();
            $order->courier = $courier->courier_id;
        }
        if ($this->courierService == 1 && $this->pincodeStatus == 1) {
//            if ($courier_status == 1) {
//                $courier = HasCourier::where('status', 1)->where('store_id', $this->jsonString['store_id'])->orderBy("preference", "asc")->first();
//                $order->courier = $courier->courier_id;
//                // $courier = Courier::where('status', 1)->whereIn('id', $courierId)->get()->toArray();
//                // $courierServe = Helper::assignCourier($order->postal_code, $iscod);
//            }
        }
        $cart_data = Helper::calAmtWithTax();
        $order->user_id = $user->id;
        $order->pay_amt = $payAmt;

        $cartAmount = $cart_data['total'];
        $order->order_amt = $cartAmount;
        // apply additional charge to payAmount
        $additional_charge_json = AdditionalCharge::ApplyAdditionalCharge($cartAmount);
        $order->additional_charge = $additional_charge_json;
        // $order->order_amt = Cart::instance('shopping')->total() * Session::get("currency_val");
        $order->payment_method = $paymentMethod;
        $order->payment_status = $paymentStatus;
        $order->transaction_id = $trasactionId;
        $order->transaction_status = $transactionStatus;
        if ($des)
            $order->description = $des;
        $order->currency_id = Session::get("currency_id");
        $order->currency_value = Session::get("currency_val");
        $order->cart = json_encode(Cart::instance('shopping')->content());
        $order->order_status = 1;
        $order->cod_charges = @Session::get('codCharges');
        $order->discount_type = (Session::get('discType')) ? Session::get('discType') : 0;
        $order->discount_amt = (Session::get('discAmt')) ? Session::get('discAmt') : 0;
        $order->coupon_amt_used = is_null(Session::get('couponUsedAmt')) ? 0 : Session::get('couponUsedAmt');
        $order->coupon_used = is_null(Session::get('usedCouponId')) ? 0 : Session::get('usedCouponId');
        $order->cashback_used = is_null(Session::get('checkbackUsedAmt')) ? 0 : Session::get('checkbackUsedAmt');
        $order->voucher_amt_used = is_null(Session::get('voucherAmount')) ? 0 : Session::get('voucherAmount');
        $order->voucher_used = is_null(Session::get('voucherUsedAmt')) ? 0 : Session::get('voucherUsedAmt');
        $jsonString = Helper::getSettings();
        $order->prefix = $jsonString['prefix'];
        $order->store_id = $jsonString['store_id'];
        $coupon_id = Session::get('voucherUsedAmt');
        if (isset($coupon_id)) {
            $coupon = Coupon::find($coupon_id);
            $coupon->initial_coupon_val = Session::get('remainingVoucherAmt');
            $coupon->update();
        }

        //$order->shipping_amt = is_null(Session::get('shippingAmount')) ? 0 : Session::get('shippingAmount');
        if ($chkReferal->status == 1) {
            if (!empty(Session::get("ReferalId"))) {
                $order->referal_code_used = Session::get("ReferalCode");
                $order->referal_code_amt = Session::get("referalCodeAmt");
                $order->user_ref_points = Session::get("userReferalPoints");
                $order->ref_flag = 0;
            }
        }
        //dd($chkLoyalty->status);

        if ($chkLoyalty->status == 1) {
            $order->loyalty_cron_status = 1;
            $loyaltyPercent = $user->loyalty['percent'];
            $amt = $user->total_purchase_till_now;
            $loyalty = Loyalty::where("min_order_amt", ">=", $amt)->where("max_order_amt", "<=", $amt)->orderBy("min_order_amt", "desc")->first();
            if (isset($loyalty->id)) {
                $user->loyalty_group = $loyalty->id;
            }
            $order->cashback_earned = is_null($loyaltyPercent) ? 0 : number_format(((($loyaltyPercent * $payAmt) / 100) * Session::get("currency_val")), 2);
        } else {
            $order->loyalty_cron_status = 0;
        }
        $user->update();
        $usercashback = HasCashbackLoyalty::where('user_id', $user->id)->where('store_id', $jsonString['store_id'])->first();
        if ($usercashback) {
            $usercashback->cashback = $usercashback->cashback - (@Session::get('checkbackUsedAmt') / Session::get('currency_val'));
            $usercashback->save();
        }

        $tempName = Session::get('login_user_first_name');
        if (empty($tempName)) {
            $parts = explode("@", Session::get('logged_in_user'));
            $fname = (!empty($parts)) ? $parts[0] : '';
        } else {
            $fname = $tempName;
        }
        $mail_id = Session::get('logged_in_user');
        $orderId = Session::get('orderId');
        $date = date("Y-m-d H:i:s");
        $order->created_at = $date;

        if ($order->Update()) {
            $this->coupon_count();
            $this->forget_session_coupon();
            //if ($stock_status == 1) { // commented by bhavana.... 
            $this->updateStock($order->id);
            //}
            if ($user->telephone) {
                $msgOrderSucc = "Your order from " . $this->jsonString['storeName'] . " with id " . $order->id . " has been placed successfully. Thank you!";

                Helper::sendsms($user->telephone, $msgOrderSucc, $user->country_code);
            }
            $messagearray = new stdClass();
            $messagearray->title = "Order Placed";
            $messagearray->type = "order";
            $messagearray->message = "Hey! You have received a New Order online. Its order id is " . $order->id . " & order amount is " . $order->pay_amt * Session::get('currency_val');

            $this->pushNotification($messagearray);
            return $data_email = ['first_name' => $fname, 'orderId' => $orderId, 'email' => $mail_id];
        }
    }

    // For order Failure function

    public function saveOrderFailure($paymentMethod, $paymentStatus, $payAmt, $transactionStatus, $des = null) {
        $failorder = Order::find(Session::get('orderId'));
        $failorder->pay_amt = $payAmt;
        $failorder->payment_method = $paymentMethod;
        $cart_data = Helper::calAmtWithTax();
        $cartAmount = $cart_data['total'] * Session::get("currency_val");
        $failorder->order_amt = $cartAmount;
        // apply additional charge to payAmount
        $additional_charge_json = AdditionalCharge::ApplyAdditionalCharge($cartAmount);
        $failorder->additional_charge = $additional_charge_json;

        // $failorder->order_amt = Cart::instance('shopping')->total();
        $failorder->payment_status = $paymentStatus;
        $failorder->transaction_status = $transactionStatus;
        $failorder->order_status = 0;
        $failorder->update();
        echo "Error being transaction.Please try again.";
    }

    // For order Update stock
    public function updateStock($orderId) {

        $jsonString = Helper::getSettings();
        // $is_stockable = GeneralSetting::where('id', 26)->first();
        $stock_limit = GeneralSetting::where('url_key', 'stock')->first();
        $stockLimit = json_decode($stock_limit->details, TRUE);
        $cartContent = Cart::instance("shopping")->content();
        $order = Order::find($orderId);
        $cart_ids = [];

        HasProducts::where("order_id", $orderId)->delete();
        foreach ($cartContent as $cart) {
            $product = Product::find($cart->id);
            $sum = 0;
            $prod_tax = array();
            $total_tax = array();
            if (count($product->texes) > 0) {
                foreach ($product->texes as $tax) {
                    $prod_tax['id'] = $tax->id;
                    $prod_tax['name'] = $tax->name;
                    $prod_tax['rate'] = $tax->rate;
                    $prod_tax['tax_number'] = $tax->tax_number;
                    $total_tax[] = $prod_tax;
                }
            }
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
            $cart_ids[$cart->id] = ["qty" => $cart->qty, "price" => $subtotal, "created_at" => date('Y-m-d H:i:s'), "amt_after_discount" => $cart->options->discountedAmount, "disc" => $cart->options->disc, 'wallet_disc' => $cart->options->wallet_disc, 'voucher_disc' => $cart->options->voucher_disc, 'referral_disc' => $cart->options->referral_disc, 'user_disc' => $cart->options->user_disc, 'tax' => json_encode($total_tax),
                'pay_amt' => $payamt, 'store_id' => $jsonString['store_id'], 'prefix' => $jsonString['prefix']];
//            $market_place = Helper::generalSetting(35);
//            if (isset($market_place) && $market_place->status == 1) {
//                $prior_vendor = $product->vendorPriority()->first();
//                $vendor['order_status'] = 1;
//                $vendor['tracking_id'] = 1;
//                $vendor['vendor_id'] = is_null($prior_vendor) ? null : $prior_vendor->id;
//                $cart_ids[$cart->id] = array_merge($cart_ids[$cart->id], $vendor);
//            }
            if ($cart->options->has('sub_prod')) {
                $cart_ids[$cart->id]["sub_prod_id"] = $cart->options->sub_prod;
                $proddetails = [];
                $prddataS = Product::find($cart->options->sub_prod);
                $proddetails['id'] = $prddataS->id;
                $proddetails['name'] = $prddataS->product;
                $proddetails['image'] = $cart->options->image;
                $proddetails['price'] = $cart->price;
                $proddetails['qty'] = $cart->qty;
                $proddetails['subtotal'] = $subtotal;
                $proddetails['is_cod'] = $prddataS->is_cod;
                $cart_ids[$cart->id]["product_details"] = json_encode($proddetails);
                $date = $cart->options->eNoOfDaysAllowed;
                $cart_ids[$cart->id]["eTillDownload"] = date('Y-m-d', strtotime("+ $date days"));
                $cart_ids[$cart->id]["prod_type"] = $cart->options->prod_type;

                if ($prddataS->is_stock == 1) {
                    $prddataS->stock = $prddataS->stock - $cart->qty;
                    if ($prddataS->is_share_on_mall == 1) {
                        $mallProduct = MallProducts::where("store_prod_id", $cart->options->sub_prod)->first();
                        $mallProduct->stock = $prddataS->stock;
                        $mallProduct->update();
                    }
                    $prddataS->update();
                }

                if ($prddataS->stock <= $stockLimit['stocklimit'] && $prddataS->is_stock == 1) {
                    $this->AdminStockAlert($prddataS->id);
                }
            } else if ($cart->options->has('combos')) {
                $sub_prd_ids = [];
                foreach ($cart->options->combos as $key => $val) {
                    if (isset($val['sub_prod'])) {
                        array_push($sub_prd_ids, (string) $val['sub_prod']);
                        $prd = Product::find($val['sub_prod']);
                        $prd->stock = $prd->stock - $cart->qty;
                        if ($prd->is_stock == 1) {
                            $prd->update();
                        };


                        if ($prd->stock <= $stockLimit['stocklimit'] && $prd->is_stock == 1) {
                            $this->AdminStockAlert($prd->id);
                        }
                    } else {
                        $prd = Product::find($key);
                        $prd->stock = $prd->stock - $cart->qty;
                        if ($prd->is_stock == 1) {
                            $prd->update();
                        }


                        if ($prd->stock <= $stockLimit['stocklimit'] && $prd->is_stock == 1) {
                            $this->AdminStockAlert($prd->id);
                        }
                    }
                }
                $cart_ids[$cart->id]["sub_prod_id"] = json_encode($sub_prd_ids);
            } else {
                $proddetailsp = [];
                $prddataSp = Product::find($cart->id);
                $proddetailsp['id'] = $prddataSp->id;
                $proddetailsp['name'] = $prddataSp->product;
                $proddetailsp['image'] = $cart->options->image;
                $proddetailsp['price'] = $cart->price;
                $proddetailsp['qty'] = $cart->qty;
                $proddetailsp['subtotal'] = $subtotal * Session::get('currency_val');
                $proddetailsp['is_cod'] = $prddataSp->is_cod;

                $cart_ids[$cart->id]["product_details"] = json_encode($proddetailsp);
                //$cart_ids[$cart->id]["eCount"] = $cart->options->eCount;
                $date = $cart->options->eNoOfDaysAllowed;
                $cart_ids[$cart->id]["eTillDownload"] = date('Y-m-d', strtotime("+ $date days"));
                $cart_ids[$cart->id]["prod_type"] = $cart->options->prod_type;
                $prd = Product::find($cart->id);
                $prd->stock = $prd->stock - $cart->qty;
                if ($prd->is_stock == 1) {
                    $prd->update();
                }


                if ($prd->stock <= $stockLimit['stocklimit'] && $prd->is_stock == 1) {
                    $this->AdminStockAlert($prd->id);
                }
            }
            // $order->products()->attach($cart_ids); 
            //  HasProducts::on('mysql2');
            $cart_ids[$cart->id]["order_id"] = $orderId;
            $cart_ids[$cart->id]["prod_id"] = $cart->id;
            $cart_ids[$cart->id]["order_status"] = 1;
            $cart_ids[$cart->id]["order_source"] = 2;

            // DB::table('has_products')->connection('mysql2')->insert($cart_ids);
            //  $order->products()->attach($cart->id, $cart_ids[$cart->id]);
        }
        HasProducts::insert($cart_ids);
        //  $this->orderSuccess();
    }

    public function AdminStockAlert($product) {
        $prod = Product::find($product);
        $messagearray = new stdClass();

        $messagearray->type = "stock";
        if ($prod->stock <= 0) {
            $prod->status = 0;
            $prod->update();
            $messagearray->title = "Out of Stock";
            $messagearray->status = "outofstock";
            $messagearray->message = "Attention: " . $prod->product . " is Out of Stock & disabled. Update the stock to make it available for customers to buy it.";
        } else {
            $messagearray->title = "Running Short";
            $messagearray->status = "runningshort";
            $messagearray->message = "Attention: " . $prod->product . " is Running Short. Update the stock now!";
        }
        $this->pushNotification($messagearray);
        $contactEmail = Config::get('mail.from.address');
        $contactName = Config::get('mail.from.name');
        $data_email = ['first_name' => "Admin", "product" => $prod];
        $fname = "Admin";
        $email = "support@infiniteit.biz";

        if (Mail::send(Config('constants.frontviewEmailTemplatesPath') . '.stockAlert', $data_email, function($message) use ($contactEmail, $contactName, $email, $fname, $data_email) {
                    $message->from($contactEmail, $contactName);
                    $message->to($email, $fname)->subject("Cartini - Stock Alert");
                }))
            ;
    }

    public function pushNotification($notification) {
        $userMobile = User::where("user_type", 1)->where("device_id", '!=', '')->pluck("device_id");
        $gcmRegIds = $userMobile;

        $fields = array(
            'registration_ids' => $gcmRegIds,
            'data' => $notification
        );
        //building headers for the request
        $headers = array(
            'Authorization: key=' . 'AAAAZeeZoaQ:APA91bHR9lt8JdJDhAzH1dUh9oUOUs3F6GM4BdMzK1uVqQLcMv1NUVc-twlw7hklrRHOvj8Ada-UhiggbrxXiUldSH1KuxG0kcroiah_4bLylwt9LSBcjihdxweKtvEhrUrHLtUbuYOj',
            'Content-Type: application/json'
        );


        $ch = curl_init();

        //Setting the curl url
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');

        //setting the method as post
        curl_setopt($ch, CURLOPT_POST, true);

        //adding headers 
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //disabling ssl support
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        //adding the fields in json format 
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

        //finally executing the curl request 
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        } else {
//           // echo $result;
//            $resultData = json_decode($result);
//            if($resultData){
//            $pushNotification = new Pushnotification();
//            $pushNotification->success = $resultData->success;
//            $pushNotification->failure = $resultData->failure;
//            $pushNotification->title = $notification->title;
//            $pushNotification->message = $notification->message;
//           $pushNotification->image = $fileName;
//           // $pushNotification->user_type = $userType;
//            $pushNotification->save();
        }

        curl_close($ch);
        return 1;
    }

    // For order pages
    public function orderSuccess() {

        if (Session::get('orderId')) {
            $order = Order::find(Session::get('orderId'));
            $coupon = Coupon::find($order->coupon_used);
            Session::forget('orderId');
            Session::forget('couponUsedAmt');
            Session::forget('usedCouponId');
            Session::forget('usedCouponCode');
            Session::forget('ReferalId');
            Session::forget('ReferalCode');
            Session::forget('referalCodeAmt');
            Session::forget('userReferalPoints');
            Session::forget('CatTypePrice');
            Session::forget('CatTypeId');
            Session::forget('codCharges');
            Session::forget('individualDiscountPercent');
            Cart::instance("shopping")->destroy();
            return view(Config('constants.frontCheckoutView') . '.success', compact('order', 'coupon'));
            // return view('Frontend.pages.checkout.success', compact('order', 'coupon'));
        } else {
            return redirect()->route('home');
        }
        //  return view(Config('constants.frontCheckoutView') . '.success');
    }

    public function orderFailure() {
        return view(Config('constants.frontCheckoutView') . '.failure');
    }

    public function orderCancel() {
        return view(Config('constants.frontCheckoutView') . '.cancel');
    }

    public function guestCheckout() {
        $chkEmail = User:: where("email", "=", Input::get("guestemail"))->get()->first();
        if (empty($chkEmail)) {
            $user = new User();
            $user->email = Input::get('guestemail');
            $jsonString = Helper::getSettings();
            $user->prefix = $jsonString['prefix'];
            $user->store_id = $jsonString['store_id'];
            $user->save();
            Helper::newUserInfo($user->id);

            $addressesData = User::find(Session::get('loggedin_user_id'))->addresses()->get();

            foreach ($addressesData as $address) {
                $address->countryname = $address->country['name'];
                $address->statename = $address->zone['name'];
            }

            return $addressesData;
        } else {

            Helper::newUserInfo($chkEmail->id);
            $addressesData = User::find(Session::get('loggedin_user_id'))->addresses()->get();
            foreach ($addressesData as $address) {
                $address->countryname = $address->country['name'];
                $address->statename = $address->zone['name'];
            }

            return $addressesData;
        }
    }

    function coupon_count() {
        /* by tej -> Code add for coupon counter -> start */
        // $addCoupon = Coupon::where("id", "=", session::get('usedCouponId'))->select("no_times_used")->get()->toArray();
        $couponadd = Coupon::find(session::get('usedCouponId'));
        if (isset($couponadd->no_times_used)) {
            $couponadd->no_times_used = $couponadd->no_times_used + 1;
            $couponadd->save();
        }
        session::forget('usedCouponId');
        session::forget('couponUsedAmt');
        session::forget('usedCouponCode');
        /* by tej -> Code add for coupon counter -> end */
    }

    function forget_session_coupon() {
        Session::forget('product_ids');
        Session::forget('minOrderAmount');
        Session::put('couponUsedAmt', 0);
        Session::forget('usedCouponId');
        Session::forget('couponUsedAmtFixed');
        Session::forget('couponType');
        Session::forget('usedCouponCode');
    }

    function successMail($orderId, $firstName, $toEmail) {
        $toEmails = 'bhavana@infiniteit.biz';
        $tableContant = Helper::getEmailInvoice($orderId);
        $order = Order::find($orderId);
        $emailStatus = GeneralSetting::where('url_key', 'email-facility')->first()->status;
        //$path = Config("constants.adminStorePath"). "/storeSetting.json";
        //$str = file_get_contents($path);
        $logoPath = @asset(Config("constants.logoUploadImgPath") . 'logo.png');
        //$settings = json_decode($str, true);
        $settings = Helper::getSettings();
        $webUrl = $_SERVER['SERVER_NAME'];
        if ($emailStatus == 1) {
            $emailContent = EmailTemplate::where('id', 2)->select('content', 'subject')->get()->toArray();
            $email_template = $emailContent[0]['content'];
            $subject = $emailContent[0]['subject'];

            $replace = array("[orderId]", "[firstName]", "[invoice]", "[logoPath]", "[web_url]", "[primary_color]", "[secondary_color]", "[storeName]", "[ordetId]", "[created_at]");
            $replacewith = array($orderId, $firstName, $tableContant, $logoPath, $webUrl, $settings['primary_color'], $settings['secondary_color'], $settings['storeName'], $order->id, $order->created_at);
            $email_templates = str_replace($replace, $replacewith, $email_template);
            $data_email = ['email_template' => $email_templates];

            Helper::sendMyEmail(Config('constants.frontviewEmailTemplatesPath') . 'orderSuccess', $data_email, $subject, Config::get('mail.from.address'), Config::get('mail.from.name'), $toEmail, $firstName);
            return view(Config('constants.frontviewEmailTemplatesPath') . 'orderSuccess', $data_email);
        }
    }

    function testMail($orderId, $firstName) {
        $email_template = EmailTemplate::where('id', 1)->select('content')->get()->toArray()[0]['content'];
        $replace = ["[first_name]", "[last_name]"];
        $replacewith = [ucfirst(Input::get('first_name')), ucfirst(Input::get('last_name'))];
        $email_templates = str_replace($replace, $replacewith, $email_template);
        $data1 = ['email_template' => $email_template];
        Helper::sendMyEmail(Config('constants.frontviewEmailTemplatesPath') . 'registerEmail', $data1, 'Successfully registered with Cartini.co', Config::get('mail.from.address'), Config::get('mail.from.name'), Input::get('email'), Input::get('first_name') . " " . Input::get('last_name'));



//        $replace = array("[orderId]", "[firstName]");
//        $replacewith = array($orderId, $firstName);
//        $email_templates = str_replace($replace, $replacewith, $email_template);
//        $data_email = ['email_template' => $email_templates];
//        Helper::sendMyEmail(Config('constants.frontviewEmailTemplatesPath') . 'orderSuccess', $data_email, 'Order Successfully placed with Cartini.co', 'support@infiniteit.biz', 'Cartini', 'tej@infiniteit.biz', $firstName);
        //  return view(Config('constants.frontviewEmailTemplatesPath') . 'orderSuccess', $data_email);
    }

    function checkStockCheckout() {
        $cart = json_decode(Cart::instance('shopping')->content());
        //dd($cart);
        $flag = 0;
        $productStock = [];
        foreach ($cart as $cartval) {
            // print_r($cartval);
            $getProductStock = Product::find($cartval->id);

            if ($getProductStock->prod_type == 1) {
                if ($getProductStock->stock < $cartval->qty) {
                    $flag++;
                    array_push($productStock, $cartval->rowid);
                }
            } else if ($getProductStock->prod_type == 3) {
                $subProd = $cartval->options->sub_prod;
                $stock = @Product::find($subProd)->stock;
                if ($stock < $cartval->qty) {
                    $flag++;
                    array_push($productStock, $cartval->rowid);
                }
            }
        }
        return $productStock;
    }

    function orderWithoutProduct() {

        $viewname = Config('constants.frontendView') . '.orderwithoutproduct';
        $data = [];
        return Helper::returnView($viewname, $data);
    }

    function saveOrderwithproduct() {
        $order = new Order();
        $order->phone_no = Input::get("mobile");
        $order->order_comment = Input::get("note");
        $order->order_amt = Input::get("amount");

        if (Input::get('apply-loyalty')) {
            $userCashback = Helper::getUserCashBack(Input::get('mobile'));
            //echo $userCashback['cashback'];
            if ($userCashback['status'] == 1 && $userCashback['cashback'] > 0) {
                $user = User::where('telephone', Input::get('mobile'))->first(); //GET USER
                if ($userCashback['cashback'] >= Input::get("amount")) {
                    $order->pay_amt = 0;
                    $order->cashback_used = Input::get("amount");
                    $cashbackRemained = $userCashback['cashback'] - Input::get("amount");
                } else if ($userCashback['cashback'] < Input::get("amount")) {
                    $order->pay_amt = Input::get("amount") - $userCashback['cashback'];
                    $order->cashback_used = $userCashback['cashback'];
                    $cashbackRemained = 0;
                }
                $user->userCashBack->cashback = $cashbackRemained;
                $user->userCashBack->update();
            }
            //echo "Applied";
        } else {
            $order->pay_amt = Input::get("amount");
            //echo "Not Applied";
        }
        $order->payment_method = 1;
        $order->payment_status = 1;
        $order->transaction_id = "";
        $order->transaction_status = "";

        //dd(Input::all());
        $date = date("Y-m-d H:i:s");
        $order->created_at = $date;
        if ($order->save()) {
            $data = ['status' => '1', 'msg' => "Order placed successfully!"];
            $viewname = Config('constants.frontCheckoutView') . '.success';
            return Helper::returnView($viewname, $data);
        } else {
            $data = ['status' => '1', 'msg' => "Oops, something went wrong. Please try again later!"];
            $viewname = Config('constants.frontCheckoutView') . '.failure';
            return Helper::returnView($viewname, $data);
        }
    }

    public function checkLoyalty() {
        return Helper::getUserCashBack(Input::get('phone'));
    }

    public function getLoyaltyGroup() {
        return Loyalty::all();
    }

}
