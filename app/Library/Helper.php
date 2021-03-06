<?php

namespace App\Library;

use Mail;
use Validator;
use Illuminate\Support\Facades\Input;
use App\Models\Settings;
use App\Models\Currency;
use App\Models\Category;
use DB;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Route;
use Session;
use Illuminate\Support\Facades\Auth;
use View;

class Helper {

    public static function returnView($viewname, $data, $redirectTo = null) {
        if (isset($_REQUEST['responseType'])) {
            if ($_REQUEST['responseType'] == 'json') {
                return $data;
            }
        } else if (isset($viewname)) {
            return view($viewname)->with($data);
        } else if (isset($redirectTo)) {
            return redirect()->route($redirectTo);
        } else {
            return $data;
        }
    }

    public static function withoutViewSendMail($to, $sub, $body) {
        // echo $to;
        Mail::send([], [], function ($message) use($to, $sub, $body) {
            $message->to($to)
                    ->subject($sub)
                    ->setBody($body);
        });
    }

    public static function getValidation($validation, $data) {
        $validator = Validator::make(Input::all(), $validation->rules);
        if ($validator->fails()) {
            return $validator->errors()->all();
        } else {
            return 1;
        }
    }
    
       public static function sendsms($mobile = null, $msg = null,$country = null) {
        $mobile = $mobile;
        if($mobile){
        $msg = $msg;
        $msg = urlencode($msg);

       if($country=='+880'){
          $urlto =  "http://api.boom-cast.com/boomcast/WebFramework/boomCastWebService/externalApiSendTextMessage.php?masking=NOMASK&userName=IFC&password=6d38103103bb45de1c77e7eece818b1c&MsgType=TEXT&receiver=$mobile&message=$msg";   
        }else
        {
            $urlto = "http://enterprise.smsgupshup.com/GatewayAPI/rest?method=SendMessage&send_to=$mobile&msg=$msg&msg_type=TEXT&userid=2000164017&auth_scheme=plain&password=GClWepNxL&v=1.1&format=text";
        }
        $ch = curl_init();
// set URL and other appropriate options
        curl_setopt($ch, CURLOPT_URL, $urlto);
        //curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// grab URL and pass it to the browser
        $output = curl_exec($ch);
        
       // print_r($output);

// close cURL resource, and free up system resources
        curl_close($ch);
        //return $output;
        }
    }

    public static function getSettings() {
        if (!empty(Session::get('bankid'))) {
            $bankid = Session::get('bankid');
        } else {
            $bankid = 0;
        }


        $settings = Settings::where('bank_id', $bankid)->first();
        if (empty($settings)) {
            $saveS = new Settings();
            $saveS->bank_id = Session::get('bankid');
            $saveS->primary_color = '329407';
            $saveS->secondary_color = '22261A';
            $saveS->currency_id = 32;
            $saveS->language_id = 1;
            $saveS->status = 1;
            $saveS->added_by = Session::get('authUserId');
            $saveS->save();
            $settings = $saveS;
        }

        Session::put('cur', Currency::find($settings->currency_id)->css_code);
        Session::put('currency_val', Currency::find($settings->currency_id)->currency_val);
        return $settings;
    }

    public static function getPrefix() {
        $getPref = Route::getCurrentRoute()->getPrefix();
        return $getPref;
    }

    public static function makeLogout() {
        if (Auth::guard('vswipe-users-web-guard')->check() !== false) {
            Auth::guard('vswipe-users-web-guard')->logout();
            Session::flush();
        }
        if (Auth::guard('bank-users-web-guard')->check() !== false) {
            Auth::guard('bank-users-web-guard')->logout();
            Session::flush();
        }

        if (Auth::guard('merchant-users-web-guard')->check() !== false) {
            Auth::guard('merchant-users-web-guard')->logout();
            Session::flush();
        }
    }

    public static function postLogin($userdata = null) {


        if (Auth::guard('vswipe-users-web-guard')->check() !== false) {
            Session::put('authUserId', Auth::guard('vswipe-users-web-guard')->user()->id);
            Session::put('authUserData', Auth::guard('vswipe-users-web-guard')->user()->first());
        } else if (Auth::guard('bank-users-web-guard')->check() !== false) {
            Session::put('authUserId', Auth::guard('bank-users-web-guard')->user()->id);
            Session::put('authUserData', Auth::guard('bank-users-web-guard')->user()->first());
            Session::put('bankid', Auth::guard('bank-users-web-guard')->user()->bank_id);
        } else if (Auth::guard('merchant-users-web-guard')->check() !== false) {
            Session::put('authUserId', Auth::guard('merchant-users-web-guard')->user()->id);
            Session::put('authUserData', Auth::guard('merchant-users-web-guard')->user()->first());
        }
    }

    public static function convertCurrency($amount, $from, $to) {
        $url = "https://www.google.com/finance/converter?a=$amount&from=$from&to=$to";
        $data = file_get_contents($url);
        preg_match("/<span class=bld>(.*)<\/span>/", $data, $converted);
        $converted = preg_replace("/[^0-9.]/", "", $converted[1]);
        return round($converted, 3);
    }

    public static function getStoreSettings($storePath) {
        $path = $storePath . "/storeSetting.json";

        $str = file_get_contents($path);

        $settings = json_decode($str, true);


        return $settings;
    }

    public static function updateStoreSettings($storePath, $storeData) {
        $fp = fopen($storePath . '/storeSetting.json', 'w+');
        fwrite($fp, $storeData);
        fclose($fp);
    }

    public static function saveDefaultSet($catid, $prefix) {
        $cat = Category::find($catid);
        $categories = json_decode($cat->categories);
        $catsave = [];
        $i = 0;
        
        foreach ($categories as $ck => $cv) {
            $catsave[$ck]['category'] = $cv;
            $catsave[$ck]['is_nav'] = 1;
            $catsave[$ck]['url_key'] = strtolower(str_replace(" ", "-", $cv));
            $i++;
            $catsave[$ck]['lft'] = $i;
            $i++;
            $catsave[$ck]['rgt'] = $i;
            $catsave[$ck]['depth'] = 0;
             $catsave[$ck]['created_at'] =date('Y-m-d H:i:s');
          
        }
        $addedcats = DB::table($prefix . '_categories')->insert($catsave);
        //save attr set       
        $attrset = json_decode($cat->attribute_sets, true);
        $saveAttrSet = [];
        foreach ($attrset as $attk => $attS) {
            $saveAttrSet[$attk]['attr_set'] = $attS;
            $saveAttrSet[$attk]['status'] = 1;
             $saveAttrSet[$attk]['created_at'] = date('Y-m-d H:i:s');
           
        }
        $attrSets = DB::table($prefix . '_attribute_sets')->insert($saveAttrSet);
        //save attributes
        $attributesData = json_decode($cat->attributes);
        $hasAttrubutes = [];
        foreach ($attributesData as $attk => $attrdata) {
            $sluG = strtolower(str_replace(" ", "-", $attrdata->attr));
            $latestAtrr = DB::table($prefix .'_attributes')->where('slug', $sluG)->select('id', 'slug')->first();
            if (!empty($latestAtrr)) {
                $sluG = $sluG . "_" . mt_rand(1000, 9999);
                ;
            }
            $saveArrtt = ['attr' => $attrdata->attr, 'attr_type' => 1, 'is_filterable' => 1, 'placeholder' => $attrdata->placeholder, 'slug' => $sluG, 'att_sort_order' => $attk+1, 'status' => 1];
            $idAttr = DB::table($prefix .'_attributes')->insert($saveArrtt);
            $latestAtrr = DB::table($prefix .'_attributes')->select('id')->orderBy('id', 'DESC')->first();
            $hasAttrubutes[$attk]['attr_id'] = $latestAtrr->id;
            $hasAttrubutes[$attk]['attr_set'] = $attrdata->attrset_id;
        }
        DB::table($prefix . '_has_attributes')->insert($hasAttrubutes);
//save attribute values
        $attrvalues = json_decode($cat->attribute_values);
        $saveAttV = [];
        foreach ($attrvalues as $attvk => $attrv) {
            $saveAttV[$attvk]['attr_id'] = $attrv->attr_id;
            $saveAttV[$attvk]['option_name'] = $attrv->option_name;
            $saveAttV[$attvk]['option_value'] = $attrv->option_value;
            $saveAttV[$attvk]['is_active'] = 1;
            $saveAttV[$attvk]['sort_order'] = $attvk + 1;
            $saveAttV[$attvk]['created_at'] =  date('Y-m-d H:i:s');
        }
        DB::table($prefix . '_attribute_values')->insert($saveAttV);
    }
    
     public static function getUserCashBack($prifix,$phone = null,$userId = null) {
        if (!is_null($phone)) {
            $user = DB::table($prifix . '_users')->where('telephone', $phone)->first();
            if (!is_null($user)) {
                $data = ['status' => 1, 'cashback' => $user->cashback, 'user' => $user];
            } else {
                $data = ['status' => 0, 'cashback' => 0, 'user' => $user];
            }
        } else {
            $user = DB::table($prifix . '_users')->where('id', Session::get('loggedin_user_id'))->first();
            if (!is_null($user)) {
                $data = ['status' => 1, 'cashback' => $user->cashback, 'user' => $user];
            } else {
                $data = ['status' => 0, 'cashback' => 0, 'user' => $user];
            }
        }
        return $data;
    }
    public static function sendMyEmail($template_path, $data, $subject, $from_email, $from_name, $to_email, $to_name) {
        if (Mail::send($template_path, $data, function($message) use ($subject, $from_email, $from_name, $to_email, $to_name) {
                    $message->from($from_email, $from_name);
                    $message->to($to_email, $to_name);
                    //$message->cc('bhavana@infiniteit.biz', 'Bhavana Nik');
                    $message->subject($subject);
                })) {
            return true;
        } else
            return false;
    }
       public static function getEmailInvoice($orderId,$prifix) {
                $addCharge = DB::table($prifix . "_general_setting")->where('url_key', 'additional-charge')->first();
                $manuD =DB::table($prifix . "_general_setting")->where('url_key', 'manual-discount')->first();
                $tax =DB::table($prifix . "_general_setting")->where('url_key', 'tax')->first()->status;
                $order = DB::table($prifix . "_orders")->find($orderId);
               // dd($order);
                if (!empty($order)) {
                    $currency = "inr";
                    $currency_val = 1;
                    $currency_css = "&#8377;";//"&#x20B9;";//&#8377";
                    Session::put('currency_val',1);
//                    if (isset($order->currency->currency)) {
//                        $currency = $order->currency->currency;
//                        $currency_val = $order->currency->currency_val;
//                        $currency_css = trim($order->currency->css_code);
//                    }
                   // echo $currency_css;
                    $tableContant = '';
                    $tableContant = $tableContant . '<table cellspacing="0" cellpadding="0" style="border: 1px solid #dddddd;width: 100%; max-width: 700px; margin:0 auto; background-color: transparent;">
    <thead>
      <tr>
        <th class="cart-product-thumbnail" align="left" style="border: 1px solid #ddd;border-left: 0;border-top: 0;padding: 10px; background: #eee;">Product</th>
        <th class="cart-product-detail" align="center" style="border: 1px solid #ddd;border-left: 0;border-top: 0;padding: 10px;background: #eee;">Detail</th>
        <th class="cart-product-price" align="center" style="border: 1px solid #ddd;border-left: 0;border-top: 0;padding: 10px;background: #eee;">Price</th>
        <th class="cart-product-quantity" align="center" style="border: 1px solid #ddd;border-left: 0;border-top: 0;padding: 10px;background: #eee;">Qty</th>';
                    if ($tax == 1) {
                        $tableContant = $tableContant . '<th class="cart-product-subtotal" align="center" style="border: 1px solid #ddd;border-left: 0;border-right:0px;border-top: 0;padding: 10px;background: #eee;">Tax</th>';
                    }
                    $tableContant = $tableContant . '<th class="cart-product-subtotal" align="center" style="border: 1px solid #ddd;border-left: 0;border-right:0px;border-top: 0;padding: 10px;background: #eee;">Total</th>
      </tr>
    </thead>
    <tbody>';
                    $cartData = json_decode($order->cart, true);
                    $gettotal = 0;
                    foreach ($cartData as $cart):
                        $option = '';
                   // dd($cart['price']);
                        $tableContant = $tableContant . '   <tr class="cart_item">
        <td class="cart-product-thumbnail" align="left" style="border: 1px solid #ddd;border-left: 0;border-top: 0;padding: 10px;">';
                        if ($cart['options']['image'] != '') {
                            $tableContant = $tableContant . '   <a href="#"><img width="64" height="64" src="' . @asset(Config("constants.productImgPath") . $cart["options"]["image"]) . '" alt="">
          </a>';
                        } else {
                            $tableContant = $tableContant . '  <img width="64" height="64" src="' . @asset(Config("constants.productImgPath")) . '/default-image.jpg" alt="">';
                        }
                        $tableContant = $tableContant . '</td>
        <td class="cart-product-name" align="center" style="border: 1px solid #ddd;border-left: 0;border-top: 0;padding: 10px;"> <a href="#">' . $cart["name"] . '</a>
            <br>
          <small><a href="#"> ';
                        if (!empty($cart['options']['options'])) {

                            foreach ($cart['options']['options'] as $key => $value) {
                                $option = DB::table($prifix . "_attribute_values")->find($value)->option_name;
                            }
                        }
                        $tableContant = $tableContant . @$option . ' </a></small></td>
        <td class="cart-product-price" align="center" style="border: 1px solid #ddd;border-left: 0;border-top: 0;padding: 10px;"> <span class="amount"> ' . htmlspecialchars_decode($currency_css) . ' ' . number_format($cart['price'] * Session::get('currency_val'), 2, '.', '') . '</span> </td>
        <td class="cart-product-quantity" align="center" style="border: 1px solid #ddd;border-left: 0;border-top: 0;padding: 10px;">
          <div class=""> ' . $cart["qty"] . '</div>
        </td>';
                        $tax_amt = 0;
                        if ($tax == 1) {
                            $tableContant = $tableContant . '   <td class="cart-product-quantity" align="center" style="border: 1px solid #ddd;border-left: 0;border-top: 0;padding: 10px;">
         <div class=""> ' . htmlspecialchars_decode($currency_css) . ' ' . $cart['options']["tax_amt"] . '</div>
        </td>';
                            $tax_amt = $cart['options']["tax_amt"];
                        }
                        $tableContant = $tableContant . '<td class="cart-product-subtotal" align="center" style="border: 1px solid #ddd;border-left: 0;border-right:0px;border-top: 0;padding: 10px;"> <span class="amount"> ' . htmlspecialchars_decode($currency_css) . ' ' . number_format((@$cart["subtotal"] * Session::get('currency_val')), 2, '.', '') . '</span> </td>
      </tr>';
                        $gettotal += $cart["subtotal"] + $tax_amt;
                    endforeach;
                    $tableContant = $tableContant . '  </tbody>
    <tr>
        <td colspan="4" class="text-right" align="right" style="border: 1px solid #ddd;border-left: 0;border-top: 0;padding: 10px;"><b>Sub-Total</b></td>
        <td colspan="2" align="center" style="border: 1px solid #ddd;border-left: 0;border-right:0;border-top: 0;padding: 10px;"> <span>' .$currency_css . '</span> ' . number_format(($gettotal * Session::get('currency_val')), 2, '.', '') . '</td>
      </tr>';
                    if ($order->cod_charges) {
                        $tableContant = $tableContant . '    <tr>
        <td colspan="4" class="text-right" align="right" style="border: 1px solid #ddd;border-left: 0;border-top: 0;padding: 10px;"><b>Cod Charges </b></td>
        <td colspan="2" align="center" style="border: 1px solid #ddd;border-left: 0;border-right:0px;border-top: 0;padding: 10px;"> ' . htmlspecialchars_decode($currency_css) . ' ' . number_format(($order->cod_charges * Session::get('currency_val')), 2) . '</td>
      </tr>';
                    }
                    if ($order->coupon_amt_used) {
                        $tableContant = $tableContant . '    <tr>
        <td colspan="4" class="text-right" align="right" style="border: 1px solid #ddd;border-left: 0;border-top: 0;padding: 10px;"><b>Coupon </b></td>
        <td colspan="2" align="center" style="border: 1px solid #ddd;border-left: 0;border-right:0px;border-top: 0;padding: 10px;"> ' . htmlspecialchars_decode($currency_css) . ' ' . number_format(($order->coupon_amt_used * Session::get('currency_val')), 2) . '</td>
      </tr>';
                    }
                    if ($order->cashback_used) {
                        $tableContant = $tableContant . '    <tr>
        <td colspan="4" class="text-right" align="right" style="border: 1px solid #ddd;border-left: 0;border-top: 0;padding: 10px;"><b>Loyalty Point </b></td>
        <td colspan="2" align="center" style="border: 1px solid #ddd;border-left: 0;border-right:0px;border-top: 0;padding: 10px;"> ' . htmlspecialchars_decode($currency_css) . ' ' . number_format(($order->cashback_used * Session::get('currency_val')), 2) . '</td>
      </tr>';
                    }
                    if ($order->referal_code_amt) {
                        $tableContant = $tableContant . '    <tr>
        <td colspan="4" class="text-right" align="right" style="border: 1px solid #ddd;border-left: 0;border-top: 0;padding: 10px;"><b>Referral Point </b></td>
        <td colspan="2" align="center" style="border: 1px solid #ddd;border-left: 0;border-right:0px;border-top: 0;padding: 10px;"><span class="currency-sym"></span> ' . htmlspecialchars_decode($currency_css) . ' ' . number_format(($order->referal_code_amt * Session::get('currency_val')), 2) . '</td>
      </tr>';
                    }

                    if ($manuD->status == 1) {
                        if ($order->discount_amt > 0) {
                            $tableContant = $tableContant . '
    <tr>
        <td colspan="4" class="text-right" align="right" style="border: 1px solid #ddd;border-left: 0;border-top: 0;padding: 10px;"><b>Discount</b></td>
        <td colspan="2" align="center" style="border: 1px solid #ddd;border-left: 0;border-right:0;border-top: 0;padding: 10px;"><span class="currency-sym"></span> ' . htmlspecialchars_decode($currency_css) . ' ' . number_format(($order->discount_amt * Session::get('currency_val')), 2) . '</td>
      </tr>';
                        }
                    }
                    if (@$addCharge->status == 1) {
                        if (!empty($order->additional_charge)) {
                            $addcharge = json_decode($order->additional_charge, true);
                            foreach ($addcharge['details'] as $addC) {
                                $tableContant = $tableContant . '    <tr>
        <td colspan="4" class="text-right" align="right" style="border: 1px solid #ddd;border-left: 0;border-top: 0;padding: 10px;"><b>' . ucfirst($addC['label']) . '  </b></td>
        <td colspan="2" align="center" style="border: 1px solid #ddd;border-left: 0;border-right:0px;border-top: 0;padding: 10px;"><span class="currency-sym"></span>' . htmlspecialchars_decode($currency_css) . ' ' . number_format(($addC['applied'] * Session::get('currency_val')), 2) . '</td>
      </tr>';
                            }
                        }
                    }
                    $tableContant = $tableContant . '   <tr>
        <td colspan="4" class="text-right" align="right" style="border: 1px solid #ddd;border-left: 0;border-top: 0;padding: 10px;"><b>Total </b></td>
        <td colspan="2" align="center" style="border: 1px solid #ddd;border-left: 0;border-right:0px;border-top: 0;padding: 10px;"> ' . htmlspecialchars_decode($currency_css) . ' ' . number_format($order->pay_amt * Session::get('currency_val'), 2) . '</td>
      </tr>
  </table>';
                }
                return $tableContant;
            }
  public static function revertTax($cart,$taxStatus) {
        
          foreach ($cart as $k => $c) {
             $subtotal=0;
             $tax_amt=0;
                $c->options->wallet_disc = 0;
                     if ($c->options->tax_type == 2) {
                      $tax_amt = round(($c->price *($c->options->taxes / 100)), 2);
                    $subtotal = $c->price+$tax_amt;
                    $c->subtotal=$subtotal;
                     $c->options->tax_amt=$tax_amt;
                }
      
        }
     //   dd($cart);
        return $cart;
    }
            
            
    public static function calAmtWithTax($cart,$taxStatus) {     
        $calTax = 0;
        $tax_amt = 0;
        $orderAmt = 0;
        $all_coupon_amount=0;
      $total=0;
       
        foreach ($cart as $k => $c) {
            $getdisc = ($c->options->disc + $c->options->wallet_disc + $c->options->voucher_disc + $c->options->referral_disc + $c->options->user_disc);
            
            $taxeble_amt = $c->subtotal - $getdisc;
            $qty=$c->qty;
            $total+=round(($c->subtotal),2);
             $orderAmt += round(($c->subtotal),2);
//            if($c->options->tax_type == 2){             
//                if($c->subtotal > ($c->options->tax_amt+$getdisc)){
//                  $taxeble_amt=$c->price+$c->options->tax_amt-$getdisc; 
//                  $orderAmt += ($c->subtotal-$c->options->tax_amt);
//                }
//            }else{
//             $orderAmt += $c->subtotal;
//            }
              $rate=$c->options->taxes/100;
            if ($taxStatus == 1) {
              
                $tax_amt=round(($taxeble_amt/($rate+1))*$rate, 2);
               // $tax_amt = round($taxeble_amt * $c->options->taxes / 100, 2);

                if ($c->options->tax_type == 2) {
                    //$taxeble1 = $taxeble - $getdisc;
                    $taxeble= ($taxeble_amt / ($rate+1));
                   
                    $tax_amt = round($taxeble *$rate*$qty,2);
                    $calTax = $calTax + $tax_amt;
                }
            }
           
             $all_coupon_amount+=$getdisc;
            $c->options->tax_amt= $tax_amt;
        }

        $subtotal = $orderAmt;
        $data = [];

       // $all_coupon_amount = Session::get('couponUsedAmt') + Session::get('checkbackUsedAmt') + Session::get('voucherAmount') + Session::get('referalCodeAmt') + Session::get('lolyatyDis') + Session::get('discAmt');
        $data['cart'] = $cart;
        $data['sub_total'] = round($subtotal,2);
        
        $data['total'] = round($total - $all_coupon_amount,2);
        
         
        return $data;
    }

      public static function getMrpTotal($cart) { 
        $sub_total = 0;
        foreach ($cart as $key => $cItm) {
            $getdisc = ($cItm->options->disc + $cItm->options->wallet_disc + $cItm->options->voucher_disc + $cItm->options->referral_disc + $cItm->options->user_disc);
             if($cItm->options->tax_type == 2){               
                  $sub_total += $cItm->subtotal - $getdisc;
                      
            }else{
              $sub_total += $cItm->subtotal; 
            }
           
        }
        return $sub_total;
    }
    public static function getOrderTotal($cart) { 
        $sub_total = 0;
        foreach ($cart as $key => $cItm) {
            $getdisc = ($cItm->options->disc + $cItm->options->wallet_disc + $cItm->options->voucher_disc + $cItm->options->referral_disc + $cItm->options->user_disc);
                          
                  $sub_total += $cItm->subtotal - $getdisc;
            
           
        }
        return $sub_total;
    }
 public static function discForProduct($prodPer, $getOrderAmtPer, $fixedAmtVal) {
        if (($prodPer * $fixedAmtVal) > 0)
            $amt = round(($prodPer * $fixedAmtVal) / $getOrderAmtPer,2);
        else
            $amt = 0;
        return $amt;
    }
     public static function getMerchantStoreSettings($storePath) {
        $path = $storePath . "/storeSetting.json";

        $str = file_get_contents($path);

        $settings = json_decode($str, true);


        return $settings;
    }
    public static function saveMerchantStoreSettings($storePath,$productconfig) {
         //  echo Config("constants.adminStorePath");
         //  dd($productconfig);
        $path =$storePath. "/storeSetting.json";
        $jsonfile = fopen($path, "w");

        fwrite($jsonfile, $productconfig);
        fclose($jsonfile);
      return 1;
    }
}

?>