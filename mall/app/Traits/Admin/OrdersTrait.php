<?php

namespace App\Traits\Admin;

use App\Models\WhitelistedDevice;
use Route;
use Input;
use App\Models\Role;
use App\Models\Product;
use App\Models\Address;
use App\Models\HasProducts;
use App\Models\Category;
use App\Models\OrderStatus;
use App\Models\PaymentMethod;
use App\Models\PaymentStatus;
use App\Models\GeneralSetting;
use App\Models\Order;
use App\Models\Comment;
use App\Models\Tests;
use App\Models\User;
use App\Models\Country;
use App\Models\Zone;
use App\Models\City;
use App\Models\OrderReturnCashbackHistory;
use Cart;
use Mail;
use App\Models\Coupon;
use App\Models\State;
use App\Models\ProductType;
use App\Models\AttributeSet;
use App\Models\CatalogImage;
use App\Models\Flags;
use App\Models\OrderFlagHistory;
use App\Models\UnlockChapter;
use App\Models\OrderStatusHistory;
use App\Models\OrderReturnOpenUnopen;
use App\Models\OrderReturnReason;
use App\Models\ReturnOrder;
use App\Models\OrderReturnAction;
use App\Models\OrderReturnStatus;
use App\Models\Chapter;
use App\Models\Question;
use App\Models\AttributeValue;
use App\Models\TestResult;
use App\Http\Controllers\Controller;
use DB;
use Session;
use App\Library\Helper;
use Config;
use Illuminate\Support\Facades\Crypt;
use Hash;
use File;
use ZipArchive;
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
use Illuminate\Support\Collection;
use App\Models\VideoCaptureSoftware;
use DirectoryIterator;
use App\Models\UsbDetail;
use Request;
use Excel;
use Form;

trait OrdersTrait {

    public function bulkUpload() {
        $getData = Excel::load($_FILES['order_file']['tmp_name'])->get();
      //  dd($getData);
        $dataArray=[];
        foreach ($getData as $key => $getItem):

            $row[$key] = $getItem;
            //dd($getItem);
            $now = date('d-m-Y');
//            $user_date = date('d-m-Y', strtotime($getItem->dob));
            $error = [];
            $errorMsg = '';
            if ($getItem->first_name == "") {
                $errorMsg = "Please enter user first name";
                $error[$key + 1][] = $errorMsg;
            }
            if ($getItem->email_id == "") {
                $errorMsg = "Please enter user email id";
                $error[$key + 1][] = $errorMsg;
            }
            if ($getItem->contact_number == "") {
                $errorMsg = "Please enter user contact number";
                $error[$key + 1][] = $errorMsg;
            }

            if ((!is_numeric($getItem->contact_number)) || (strlen((string) $getItem->contact_number) != 10)) {

                $errorMsg = "Please specify valid contact number";
                $error[$key + 1][] = $errorMsg;
            }
            if ($getItem->gender == "") {
                $errorMsg = "Please enter user gender";
                $error[$key + 1][] = $errorMsg;
            }
//            if ($getItem->dob == "") {
//                $errorMsg = "Please enter user date of birth";
//                $error[$key + 1][] = $errorMsg;
//            }
//            if (strtotime($user_date) >= strtotime($now)) {
//                $errorMsg = "Date of birth should not be future date";
//                $error[$key + 1][] = $errorMsg;
//            }

            if (count($error) > 0) {
                $getItem->error = $error[$key + 1];
                $dataArray[] = $getItem;
                //$this->InvalidRecordsReport($error);
            } else {

                $chkEmail = User::where("email", "=", @$getItem->email_id)->get()->first();
              
                if (empty($chkEmail)):
                    $password = rand(10000, 99999);
                    $user = new User();
                    $user->email = @$getItem->email_id;
                    $user->password = Hash::make($password);
                    $user->firstname = @$getItem->first_name;
                    $user->lastname = @$getItem->last_name;
                    $user->telephone = @$getItem->contact_number;
                    $user->gender = @$getItem->gender;
//                    $user->dob = @$getItem->dob;
                    $user->status = 1;
                  //  $user->customer_verification = 1;
                   // dd($user);
                    $user->save();
                    $userId = $user->id;
                    $key = Crypt::encrypt($user->id);
                    $data1 = ['firstname' => $getItem->first_name, 'key' => $key, 'user' => $user, 'password' => $password];
                    //Helper::sendMyEmail(Config('constants.frontviewEmailTemplatesPath') . 'registerEmail', $data1, 'Successfully registered with Edunguru', 'support@edunguru.com', 'EdunGuru', $getItem->email_id, $getItem->first_name . " " . $getItem->last_name);
                else:
                    $userId = $chkEmail->id;
                endif;
                if ($getItem->product_id != "") {
                    $getProd = Product::find($getItem->product_id);
                    if (count($getProd) > 0) {
                        $courseId = $getItem->product_id;
                    } else {
                        $error[$key + 1][] = "Product ID is invalid";
                    }
                } else {
                    $error[$key + 1][] = "Please enter course ID";
                }

                if ($getItem->product_variant != "") {
                    $getProdC = Product::find($getItem->product_variant);
                    if (count($getProdC) > 0) {
                        $courseVarient = $getItem->product_variant;
                    } else {
                        $error[$key + 1][] = "Course variant ID is invalid";
                    }
                } else {
                    $error[$key + 1][] = "Please enter course variant ID";
                }

                if ($getItem->address1 == "") {

                    $error[$key + 1][] = "Please enter address1";
                }
                if ($getItem->address2 == "") {

                    $error[$key + 1][] = "Please enter address2";
                }
                if ($getItem->country != "") {
                    $getCountry = Country::find($getItem->country);
                    if (count($getCountry) > 0) {
                        if ($getCountry->status != 1) {
                            $error[$key + 1][] = "Country is not active";
                        } else {
                            $countryId = $getItem->country;
                        }
                    } else {
                        $error[$key + 1][] = "Country is invalid";
                    }
                } else {
                    $error[$key + 1][] = "Please enter country id";
                }
                if ($getItem->state != "") {
                    $getState = State::find($getItem->state);
                    if (count($getState) > 0) {
//                        if ($getState->status != 1) {
//                            $error[$key + 1][] = "State is not active";
//                        } else {
                            $stateId = $getItem->state;
                     //   }
                    } else {
                        $error[$key + 1][] = "State is invalid";
                    }
                } else {
                    $error[$key + 1][] = "Please enter state id";
                }
                if ($getItem->city != "") {
                    $getCity = City::find($getItem->city);
                    if (count($getCity)) {
                        if ($getCity->status != 1) {
                            $error[$key + 1][] = "City is not active";
                        } else {
                            $cityId = $getItem->city;
                        }
                    } else {
                        $error[$key + 1][] = "City is invalid";
                    }
                } else {
                    $error[$key + 1][] = "Please enter city";
                }

                if ($getItem->pincode != "") {
                    if ((!is_numeric($getItem->pincode)) || (strlen((string) $getItem->pincode) != 6)) {

                        $error[$key + 1][] = "Please enter valid pincode";
                    } else {
                        $pincode = $getItem->pincode;
                    }
                } else {
                    $error[$key + 1][] = "Please enter pincode";
                }


//                if ($getItem->parent_number != "") {
//                    if ((!is_numeric($getItem->parent_number)) || (strlen((string) $getItem->parent_number) != 10)) {
//                        $errorMsg = "Please specify valid parent contact number";
//                        $error[$key + 1][] = $errorMsg;
//                    }
//                }
 
                if (count($error) > 0) {
                    $getItem->error = $error[$key + 1];
                    $dataArray[] = $getItem;
                      // dd($getItem);
                    // array_push($dataArray[$key + 1],)
                    $this->InvalidRecordsReport($error);
                } else {
                    // echo "ORDER PROCESS";
                 
                    $getOrder = Order::with('products')->where('user_id', $userId)->get();
                   
                    $productFlag = 0;
                    $i = 0;
//                    foreach ($getOrder as $products) {
//
//                        if ($productFlag == 1) {
//                            break;
//                        }
//                        foreach ($products->products as $product) {
//                            if ($product->id == 1) {
//                                $productFlag = 1;
//                                $error[$key + 1][] = "Course already purchased";
//                                break;
//                            }
//                        }
//
//                        $i++;
//                    }

                    if ($productFlag == 0) {
                        $cartData = [];
                        $options = [];
                        $getProd = Product::find($courseId);
                        $random = rand(10000, 99999);
                        if($getProd->prod_type!=1){
                        $sub = $getProd->subproducts()->where("id", "=", $courseVarient)->first();
                     // dd($sub);
                      
                      
                        $hasOptn = $sub->attributes()->withPivot('attr_id', 'prod_id', 'attr_val')->orderBy("att_sort_order", "asc")->get();
                        foreach ($hasOptn as $optn) {
                            $options[$optn->pivot->attr_id] = $optn->pivot->attr_val;
//                            if ($optn->pivot->attr_id == 2) {
//                                $duration = @AttributeValue::find($optn->pivot->attr_val)->no_of_days;
//                            }
                        }
                        }
                        $cat = [];
                        foreach ($getProd->categories()->get() as $catval) {
                            array_push($cat, $catval->id);
                        }

                        $cats = $cat; //explode(',', 2); 
                        $images = ($getProd->images) ? asset('public/Admin/uploads/questions/' . $getProd->images) : asset('public/Admin/uploads/catalog/products/' . '.default_product.png');

                        $cartData[$random] = (object) ['rowid' => $random, 'id' => $getProd->id, 'name' => $getProd->product, 'qty' => 1, 'price' => $getProd->selling_price, 'options' => (object) ['image' => $images, 'sub_prod' => $courseVarient, 'options' => (object) $options, 'cats' => $cats, 'subtotal' => $getProd->selling_price]];
                        $cartData = (object) $cartData;
                        Helper::addVariant($cartData);
                        //dd($cartData);
                        $finalamt = $getProd->selling_price;
                        $paymentMethod = "9";
                        $paymentStatus = "1";
                        $payAmt = filter_var($finalamt, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                        $trasactionId = "";
                        $transactionStatus = "";

                        //Parent name and number 
                        $updateUser = User::find($userId);
//                        $updateUser->parent_name = !empty($getItem->parent_name) ? $getUser->parent_name : '';
//                        $updateUser->parent_number = !empty($getItem->parent_number) ? $getUser->parent_number : '';
                        $updateUser->update();
                        //
                        $order = new Order();
                        $order->user_id = $userId;
                        $order->cart = json_encode($cartData);
                        $order->first_name = $getItem->first_name;
                        $order->last_name = $getItem->last_name;
                        $order->address1 = $getItem->address1;
                        $order->address2 = $getItem->address2;
                        $order->phone_no = $getItem->contact_number;
                        $order->country_id = '113'; //$getItem->country;;
                        $order->zone_id = $getItem->state; //$getItem->state;
                        $order->postal_code = $getItem->pincode; //$getItem->pincode;
                        $order->city = $getItem->city; //$getItem->city;
                        $order->description = !empty(@$getItem->remark) ? @$getItem->remark : ' test remark ';
//                        $order->parent_name = !empty($getItem->parent_name) ? $getUser->parent_name : '';
//                        $order->parent_number = !empty($getItem->parent_number) ? $getUser->parent_number : '';
//                        $order->agent_code = !empty(Input::get('agent_code')) ? Input::get('agent_code') : '';
                        $order->created_by = Session::get('loggedinAdminId');
//                        $order->offline_payment_mode = $getItem->payment_mode;
                        // $order->description = Input::get('remarks');
                       // dd($order);
                        $order->save();


                        $this->saveOrderSuccess($order->id, $cartData, $userId, $paymentMethod, $paymentStatus, $payAmt, $trasactionId, $transactionStatus);
                        echo "s";
                        $msg="order uploaded successfully";
                    } else {
                        $getItem->error = $error[$key + 1];
                        $dataArray[] = $getItem;
                       
                        $this->InvalidRecordsReport($error);
                        //echo "fsjdf"; // Excel code. with error msg 
                    }
                }
            }
            //dd($dataArray);
        endforeach;
        if (count($dataArray) > 0) {
            $this->InvalidRecordsReport($dataArray);
        }
        
       return redirect()->back()->with('msg', $msg);
    }

    public function saveOrderSuccess($orderId, $cartData, $userId, $paymentMethod, $paymentStatus, $payAmt, $trasactionId, $transactionStatus) {
        $user = User::find($userId);
        $order = Order::find($orderId);
        $order->user_id = $user->id;
        $order->pay_amt = $payAmt; //* Session::get('currency_val');
        $order->order_amt = filter_var($payAmt, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION); //* Session::get("currency_val");
        $order->payment_method = $paymentMethod;
        $order->payment_status = $paymentStatus;
        $order->transaction_id = $trasactionId;
        $order->transaction_status = $transactionStatus;
        $order->currency_id = Session::get("currency_id");
        $order->currency_value = Session::get("currency_val");
        $order->cart = json_encode($cartData);
        $order->order_status = 1;
        $user->cashback = 0; //$user->cashback - (@Session::get('checkbackUsedAmt') / Session::get('currency_val'));
        $user->update();
        $tempName = Session::get('login_user_first_name');
        if (empty($tempName)) {
            $parts = explode("@", Session::get('logged_in_user'));
            $fname = $parts[0];
        } else {
            $fname = $tempName;
        }
        $mail_id = Session::get('logged_in_user');
        $orderId = $orderId;
        $date = date("Y-m-d H:i:s");
        $order->created_at = $date;
        if ($order->Update()) {
            $this->updateStock($order->id, $cartData);
            $data_email = ['first_name' => $fname, 'orderId' => $orderId, 'emial' => $mail_id, 'order' => $order];
            $uid = $user->id;
          //  $this->unlockData($uid, $order);
            $telep = $user->telephone;
            $msgOrderSucc = "Thank you for placing an order with Edunguru. Your order id is " . $order->id . ". Contact 1800 3000 2020 for real time support. Happy Learning! Team Edunguru";
          	Session::flash("message", "Order placed successfully.");
            // Helper::sendsms($telep, $msgOrderSucc);
            // $this->crmAddInquiery();
            //return 1;
           // Helper::sendMyEmail(Config('constants.frontviewEmailTemplatesPath') . 'orderSuccess', $data_email, 'Order Successfully placed with Edunguru', Config::get('mail.from.address'), Config::get('mail.from.name'), $mail_id, $fname);
        }
    }

    public function updateStock($orderId, $cartData) {
        $cartContent = $cartData;
        //  print_r($cartContent); exit;
        $order = Order::find($orderId);
        $cart_ids = [];
        $order->products()->detach();
        foreach ($cartContent as $cart) {
            //  dd($cart->id);
            $proddetails = [];
            $cart_ids[$cart->id] = ["qty" => 1, "price" => $cart->price, "created_at" => date('Y-m-d H:i:s')];
            $cartPrd = Product::find($cart->id);
            if ($cartPrd->prod_type == 3) {
                $prddataS = Product::find($cart->options->sub_prod);
                $proddetails['id'] = $prddataS->id;
                $proddetails['name'] = $prddataS->product;
                $proddetails['image'] = $prddataS->images;
                $proddetails['price'] = $cart->price;
                $cart_ids[$cart->id]["prod_type"] = $cartPrd->prod_type;
            }
            $cart_ids[$cart->id]["sub_prod_id"] = $cart->options->sub_prod;
            $cart_ids[$cart->id]["product_details"] = json_encode($proddetails);
//            $cart_ids[$cart->id]["variant"] = ($cart->variant) ? trim($cart->variant, " ") : '';
//            $duration = @$cart->options->duration;
//            $cart_ids[$cart->id]["expiry_date"] = date('Y-m-d', strtotime("+ $duration days"));
            $order->products()->attach($cart->id, $cart_ids[$cart->id]);
        }
    }

//    public function unlockData($uid, $order) {
//        $order_id = $order->id;
//        //dd($order->id);
//        $orderdata = $order->products()->get();
//        // dd($orderdata);
//        $chapters = [];
//        $chaptersData = [];
//        foreach ($orderdata as $order) {
//            if ($order->pivot->prod_type != 2) {
//                $chapters = Product::where("id", $order->pivot->prod_id)->with('chapters')->first();
//                $chaptersData[] = $chapters;
//            } else {
//                $pids = json_decode($order->pivot->combo, true);
//                $getProduct = Product::whereIn("id", $pids)->with('chapters')->get();
//                foreach ($getProduct as $key => $prodId):
//                    $chaptersData[] = $prodId;
//                endforeach;
//            }
//        }
//        if (!empty($chaptersData)):
//            $this->getChaterData($chaptersData, $uid, $order_id);
//        endif;
//    }
//
//    public function getChaterData($chaptersData, $uid, $orderId) {
//        //dd($orderId);
//        foreach ($chaptersData as $key => $getChapter):                //course
//            $i = 0;
//            $chaptersDataNew = $getChapter->chapters;
//            $courseId = $getChapter->id;
//            if (!empty($chaptersDataNew) && isset($chaptersDataNew)):
//                $this->saveUnlockData($uid, $orderId, $courseId, $chaptersDataNew, $i);
//            endif;
//        endforeach;
//    }
//
//    public function saveUnlockData($uid, $orderId, $courseId, $chaptersData, $i) {
//        // dd($orderId);
//        foreach ($chaptersData as $getChap):
//            $unlockChapter = UnlockChapter::findOrNew(null);
//            $unlockChapter->user_id = $uid;
//            $unlockChapter->order_id = $orderId;
//            $unlockChapter->course_id = $courseId;
//            $unlockChapter->chapter_id = $getChap->id;
//            if ($i == 0):
//                $unlockChapter->state = 1;
//            endif;
//            $i++;
//            $unlockChapter->unlock_key = rand(1000, 9999);
//            $unlockChapter->save();
//        endforeach;
//    }
//
    public function InvalidRecordsReport($dataArray) {
       //  dd($dataArray);
        $root = $_SERVER['DOCUMENT_ROOT'] . '/public/Reports/';
        $filename = $root . 'ApprovedLeadReport_' . date('d-m-Y') . '.csv';
        $handle = fopen($filename, 'w+');
        fputcsv($handle, array('First Name', 'Last Name', 'Contact Number', 'Email Id', 'Gender',  'Course Id', 'Course Variant', 'Address1', 'Address2', 'Country', 'State', 'City', 'Pincode', 'Payment Mode', 'Remark', 'Error Message'));
        foreach ($dataArray as $key => $row) {
            //echo $key;
            // dd($row);
            fputcsv($handle, array($row->first_name, $row->last_name, $row->contact_number, $row->email_id, $row->gender,$row->course_id, $row->course_variant, $row->address1, $row->address2, $row->country, $row->state, $row->city, $row->pincode, $row->payment_mode, $row->remark, @implode(',', $row->error))); // @implode(',', $row)
        }
        fclose($handle);
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename=InvalidRecordsReport_' . date('d-M-Y') . '.csv');
        header('Pragma: no-cache');
        readfile($filename);
    }

}

