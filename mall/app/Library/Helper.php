<?php

namespace App\Library;

use App\Models\MallProdCategory;
use App\Models\MallProducts as Product;
use App\Models\Loyalty;
use App\Models\AttributeValue;
use App\Models\AttributeSet;
use App\Models\Attribute;
use App\Models\Pincode;
use App\Models\User;
use App\Models\Order;
use App\Models\GeneralSetting;
use App\Models\HasCurrency;
use Session;
use Cart;
use Auth;
use DB;
use Mail;

class Helper {

    public static function searchForKey($keyy, $value, $array) {
        foreach ($array as $key => $val) {
            if ($val[$keyy] == $value) {
                return TRUE;
            }
        }
        return FALSE;
    }

    public static function chkPerm($route) {
        $user = \App\Models\User::with('roles')->find(Session::get('loggedinUserId'));
        $roles = $user->roles;
        $roles_data = $roles->toArray();
        $r = \App\Models\Role::find($roles_data[0]['id']);
        $per = $r->perms()->get(['name'])->toArray();
        if (in_array($route, array_flatten($per))) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public static function returnView($viewname = null, $data = null, $url = null, $chkTheme = null) {
        $themeView = $viewname;
        if (!empty($chkTheme)) {
            if (!empty($viewname) && !empty(config('app.active_theme'))) {
                $themeV = explode(".", $viewname);
                $lastindex = count($themeV) - 1;
                $themePages = explode($themeV[$lastindex], $viewname);
                $themeView = $themePages[0] . config('app.active_theme') . $themeV[$lastindex];
            }
        }
        if (isset($_REQUEST['responseType'])) {
            if ($_REQUEST['responseType'] == 'json') {
                return $data;
            }
        } else {
            if ($url) {
                return redirect()->route($url);
            } else {
                return view($themeView)->with($data);
            }
        }
    }

    public static function getmenu($node) {
        echo "<li>";
        echo "<a href=" . route('category', ['slug' => $node->url_key]) . ">{$node->category}</a>";
        if ($node->children()->count() > 0) {
            echo "<ul>";
            foreach ($node->children as $child)
                Helper::getmenu($child);
            echo "</ul>";
        }
        echo "</li>";
    }

    public static function getMallMenu($rootm) {
        foreach ($rootm as $key => $node) {
            echo "<li class='";
            echo ($key == 0) ? 'active' : '';
            echo "'>";
            if ($node->children()->count() > 0) {
                echo "<a href='#subcategory-{$node->id}' >{$node->category}</a>"; //href=" . route('category', ['slug' => $node->url_key]) . "
            } else {
                echo "<a href=" . route('category', ['slug' => $node->url_key]) . " >{$node->category}</a>";
            }
            echo "</li>";
        }
    }

    public static function getSubmenu($child, $key) {
        echo " <div id='subcategory-{$child->id}' class='";
        echo ($key == 0) ? 'active' : '';
        echo "' >"
        . "<div class='lnt-subcategory col-sm-8 col-md-8'><h3 class='lnt-category-name'>"
        . "" . $child->category . "</h3>"
        . "<ul class='list-unstyled col-sm-6'>";
        foreach ($child->children()->get() as $node) {
            echo "<li>";
            echo "<a href=" . route('category', ['slug' => $node->url_key]) . ">{$node->category}</a>";
            echo "</li>";
        }
        echo "</ul></div></div>";
    }

    public static function getCsv($input_array, $output_file_name, $delimiter) {
        /** open raw memory as file, no need for temp files */
        $temp_memory = fopen('php://memory', 'w');
        /** loop through array  */
        foreach ($input_array as $line) {
            /** default php csv handler * */
            fputcsv($temp_memory, $line, $delimiter);
        }
        /** rewrind the "file" with the csv lines * */
        fseek($temp_memory, 0);
        /** modify header to be downloadable csv file * */
        header('Content-Type: application/csv');
        header('Content-Disposition: attachement; filename="' . $output_file_name . '";');
        /** Send file to browser for download */
        fpassthru($temp_memory);
    }

    public static function checkStock($prodid, $qtty = null, $subprodId = null) {
        $getprod = Product::find($prodid);
        if ($getprod->prod_type == 1) {
            $searchCart = Cart::instance("shopping")->search(array('id' => $prodid));
            $cartDataS = Cart::get($searchCart[0]);
            $getstockSimple = $getprod->stock;
            $totQtyS = @$cartDataS->qty + $qtty;
            if ($totQtyS <= $getstockSimple)
                return "In Stock";
            else
                return "Out of Stock";
        } else if ($getprod->prod_type == 3) {
            $searchCartCf = Cart::instance("shopping")->search(array('id' => $prodid, 'options' => array('sub_prod' => (int) $subprodId)));
            $cartDataCf = Cart::get($searchCartCf[0]);
            $subProdid = $subprodId;
            $getstockConfig = Product::find($subProdid)->stock;
            $totQtyCf = @$cartDataCf->qty + $qtty;

            if ($totQtyCf <= $getstockConfig)
                return "In Stock";
            else
                return "Out of Stock";
        } else if ($getprod->prod_type == 2) {
            $searchCartCmbo = Cart::instance("shopping")->search(array('id' => $prodid));
            $cartDataCmbo = Cart::get($searchCartCmbo[0]);
            $combo = $getprod->comboproducts()->get();
            $prodIds = [];
            foreach ($combo as $cprd) {
                array_push($prodIds, $cprd->id);
            }
            $chkArr = [];
            foreach ($prodIds as $idsV) {
                $getprodC = Product::find($idsV);
                if ($getprodC->prod_type == 1) {
                    $getstockSimp1 = $getprodC->stock;
                    $totQtyS1 = @$cartDataCmbo->qty + $qtty;
                    if ($totQtyS1 <= $getstockSimp1) {
                        array_push($chkArr, 1);
                    } else {
                        array_push($chkArr, 0);
                    }
                } else if ($getprodC->prod_type == 3) {
                    $subProdid1 = $subprodId[$idsV];
                    $getstockConf1 = Product::find($subProdid1)->stock;
                    $totQtyCf2 = @$cartDataCmbo->qty + $qtty;
                    if ($totQtyCf2 <= $getstockConf1) {
                        array_push($chkArr, 1);
                    } else {
                        array_push($chkArr, 0);
                    }
                }
            }
            if (in_array(0, $chkArr))
                return "Out of Stock";
            else
                return "In Stock";
        }else if ($getprod->prod_type == 5) {
            return "In Stock";
        }
    }

    public static function checkCartInventoty($rowid) {
        $searchCart = Cart::instance("shopping")->search(array('rowid' => $rowid));
        $getCart = Cart::get($searchCart[0]);
        $prodChk = DB::table($getCart->options->prefix . '_products')->where("id", $getCart->id)->first();
        $qty = $getCart->qty;
        if ($prodChk->is_stock == 1 && $prodChk->status == 1) {
            if ($prodChk->prod_type == 1) {
                $stock = $prodChk->stock;
                if ($qty <= $stock) {
                    return "In Stock";
                } else {
                    return "Out of Stock";
                }
            } else if ($prodChk->prod_type == 3) {
                $subProd = $getCart->options->sub_prod;
                $product = DB::table($getCart->options->prefix . '_products')->where("id", $subProd)->first();

                if ($qty <= $product->stock && $product->status == 1) {
                    return "In Stock";
                } else {
                    return "Out of Stock";
                }
            } else if ($prodChk->prod_type == 2) {
                $comboProds = $getCart->options->combos;
                $prodIds = [];
                $chkArr = [];
                foreach ($comboProds as $cPrdK => $cPrdV) {
                    $chkCombo = Product::find($cPrdK);
                    if ($chkCombo->prod_type == 1) {
                        $stock = $chkCombo->stock;
                        $status = $chkCombo->status;
                        if ($qty <= $stock && $status == 1) {
                            array_push($chkArr, 1);
                        } else {
                            array_push($chkArr, 0);
                        }
                    } else if ($chkCombo->prod_type == 3) {
                        $getS = $cPrdV['sub_prod'];
                        $stock = Product::find($getS)->stock;
                        $status = Product::find($getS)->status;
                        if ($qty <= $stock && $status == 1) {
                            array_push($chkArr, 1);
                        } else {
                            array_push($chkArr, 0);
                        }
                    }
                    if (in_array(0, $chkArr)) {
                        return "Out of Stock";
                    } else {
                        return "In Stock";
                    }
                }
            }
        } else if ($prodChk->is_stock == 0 && $prodChk->status == 1) {
            return "In Stock";
        } else {
            return "Out of Stock";
        }
    }

    public static function newUserInfo($userid) {
        $checkLoyalty = GeneralSetting::where('url_key', 'loyalty')->first()->status;
        $checkReferral = GeneralSetting::where('url_key', 'referral')->first()->status;
        $refCode = rand(11111, 99999);
        $user = User::find($userid);
        $user->user_type = 2;
        if ($checkReferral == 1)
            $user->referal_code = substr(strtoupper($user->firstname), 0, 3) . $refCode;
        if ($checkLoyalty == 1)
            $user->loyalty_group = 1;
        $user->update();
        Session::put('logged_in_user', $user->email);
        Session::put('loggedin_user_id', $user->id);
        Session::put('login_user_type', $user->user_type);
        Session::put('login_user_first_name', $user->firstname);
        Session::put('login_user_last_name', $user->lastname);
        Auth::login(User::find($user->id));
    }

    public static function postLogin($userid) {
        $user = User::find($userid);
//        $checkLoyalty = GeneralSetting::where('url_key', 'loyalty')->first();
//        $checkReferral = GeneralSetting::where('url_key', 'referral')->first();
//for loyalty
//        if ($checkLoyalty->status == 1) {
//            $amt = $user->total_purchase_till_now;
//            $loyalty = Loyalty::where("min_order_amt", "<=", $amt)->orderBy("min_order_amt", "desc")->first();
//            if (isset($loyalty->id)) {
//                $user->loyalty_group = $loyalty->id;
//            }
//        }
//for referal
//        if ($checkReferral->status == 1) {
//            $detailsR = json_decode($checkReferral->details);
//            foreach ($detailsR as $detRk => $detRv) {
//                if ($detRk == "activate_duration_in_days")
//                    $activate_duration = $detRv;
//                if ($detRk == "bonous_to_referee")
//                    $bonousToReferee = $detRv;
//                if ($detRk == "discount_on_order")
//                    $discountOnOrder = $detRv;
//            }
//            if (!empty($user->referal_code)) {
//                $refUsedOrders = Order::where('referal_code_used', "=", $user->referal_code)
//                                ->where('created_at', '<=', date('Y-m-d', strtotime("now -$activate_duration days")))
//                                ->whereIn('order_status', [2, 3])
//                                ->where('ref_flag', '=', 0)->get();
//
//                $refToAdd = 0;
//                foreach ($refUsedOrders as $refOds) {
//                    $refToAdd += $refOds->user_ref_points;
//                    $refOrders = Order::find($refOds->id);
//                    $refOrders->ref_flag = 1;
//                    $refOrders->update();
//                }
//                $user->cashback = $user->cashback + $refToAdd;
//            }
//        }

        $user->update();
        Session::put('logged_in_user', $user->email);
        Session::put('loggedin_user_id', $user->id);
        Session::put('user_cashback', $user->cashback);
        Session::put('login_user_type', $user->user_type);
        Session::put('login_user_first_name', $user->firstname);
        Session::put('login_user_last_name', $user->lastname);
    }

    public static function getUserCashBack($phone = null) {
        if (!is_null($phone)) {
            $user = User::where('telephone', $phone)->with('addresses')->first();
            if (!is_null($user)) {
                $data = ['status' => 1, 'cashback' => $user->cashback, 'user' => $user];
            } else {
                $data = ['status' => 0, 'cashback' => 0, 'user' => $user];
            }
        } else {
            $user = User::where('id', Session::get('loggedin_user_id'))->with('addresses')->first();
            if (!is_null($user)) {
                $data = ['status' => 1, 'cashback' => $user->cashback, 'user' => $user];
            } else {
                $data = ['status' => 0, 'cashback' => 0, 'user' => $user];
            }
        }
        return $data;
    }

    public static function getAmt($from = null) {
        $amt = Cart::instance("shopping")->total();
        if ($from != 'coupon') {
            if (Session::get('couponUsedAmt'))
                $amt = $amt - Session::get('couponUsedAmt');
        }
        //cashback
        if ($from != 'cashback') {
            if (Session::get('checkbackUsedAmt'))
            //  $amt = $amt - Session::get('checkbackUsedAmt') / Session::get('currency_val');
                $amt = $amt - Session::get('checkbackUsedAmt') * Session::get('currency_val');
        }
        //voucher
        if ($from != 'voucher') {
            if (Session::get('voucherAmount'))
                $amt = $amt - Session::get('voucherAmount');
        }
        //Discount
        if ($from != 'discAmt') {
            if (Session::get('discAmt'))
                $amt = $amt - Session::get('discAmt');
        }
        //referal
        if ($from != 'referal') {
            if (Session::get('referalCodeAmt'))
                $amt = $amt - Session::get('referalCodeAmt');
        }
        if ($from != 'cod') {
            if (Session::get('codCharges'))
                $amt = $amt + Session::get('codCharges');
        }
        return $amt;
    }

    public static function getnewCart() {
        $cart = '<div class="shop-cart">';
        $cart .= '<a href="#" class="cart-control"><img src="' . asset(Config("constants.frontendPublicImgPath") . "assets/icons/cart-black.png") . '" alt="">';
        $cart .= '<span class="cart-number number">' . Cart::instance("shopping")->count() . '</span>';
        $cart .= '</a>';
        if (Cart::instance("shopping")->count() > 0) {
            $cart .= '<div class="shop-item">';
            $cart .= '<div class="widget_shopping_cart_content">';
            $cart .= '<ul class="cart_list">';
            foreach (Cart::instance("shopping")->content() as $c) {
                $cart .= '<li class="clearfix">';
                $cart .= '<a class="p-thumb" href="#" style="height: 50px;width: 50px;">';
                $cart .= '<img src="' . asset(Config("constants.productImgPath") . $c->options->image) . '" alt="" >';
                $cart .= '</a>';
                $cart .= '<div class="p-info">';
                $cart .= '<a class="p-title" href="#">' . $c->name . ' </a>';
                $cart .= '<span class="price">';
                $selling_price = $c->selling_price * Session::get('currency_val');
                $cart .= '<ins><span class="amount"><i class="fa fa-' . strtolower(Session::get('currency_code')) . '"></i> ' . number_format($selling_price, 2) . ' </span></ins>';
                $cart .= '</span>';
                $cart .= '<span class="p-qty">QTY: ' . $c->qty . ' </span>';
                $cart .= '<a data-rowid="' . $c->rowid . '" class="removeShoppingCartProd remove" href="#"><i class="fa fa-times-circle"></i></a>';
                $cart .= '</div>';
                $cart .= '</li>';
            }
            $cart_total = Cart::instance("shopping")->total() * Session::get('currency_val');
            $cart .= '</ul>';
            $cart .= '<p class="total"><strong>Subtotal:</strong> <span class="amount"><i class="fa fa-' . strtolower(Session::get('currency_code')) . '"></i> ' . number_format($cart_total, 2) . ' </span></p>';
            $cart .= '<p class="buttons">';
            $cart .= '<a class="button cart-button" href="' . route("cart") . ' ">View Cart</a>';
            $cart .= '<a class="button yellow wc-forward" href="' . route("checkout") . '">Checkout</a>';
            $cart .= '</p></div> </div></div>';
        } else {
            //$cart .= '<li><h6>Cart is Empty</h6>  </li>';
        }
        $cart .= '</ul></li></ul></div>';

        return $cart;
    }

    //Function to send emails
    public static function sendMyEmail($template_path, $data, $subject, $from_email, $from_name, $to_email, $to_name) {
        if (Mail::send($template_path, $data, function($message) use ($subject, $from_email, $from_name, $to_email, $to_name) {
                    $message->from($from_email, $from_name);
                    $message->to($to_email, $to_name);
                    //$message->cc('bhavana@infiniteit.biz', 'Bhavana Nik');
                    $message->subject($subject);
                })) {
            return true;
        } else {
            return false;
        }
    }

    public static function getmaxPrice() {
        $prod = DB::table('mall_products')->where('price', DB::raw("(select max(`price`) from " . DB::getTablePrefix() . "mall_products)"))->first();
        if ($prod) {
            return $prod->price;
        } else {
            $prod['price'] = '';
        }
    }

    public static function get_country() {
        return HasCurrency::where('currency_status', 1)->get();
    }

    public static function set_country_session($id) {
        $country = HasCurrency::find($id);
        Session::put('currency_id', $country->id);
        Session::put('currency_code', $country->currency);
        Session::put('currency_name', $country->currency_name);
        Session::put('currency_val', $country->currency_val);
        Session::put('currency_val', 1);
        Session::put('currency_symbol', $country->css_code);
    }

    public static function getMaxPriceByCat($catid) {
        $prod = DB::table('products')->where('selling_price', '=', DB::raw("(select max(`selling_price`) from products as p inner join  has_categories as hc on (p.id=hc.prod_id)  where hc.cat_id={$catid})"))->first();
        if ($prod) {
            return @$prod->selling_price;
        } else {
            return 0;
        }
    }

    public static function getSettings() {
        $path = Config("constants.adminStorePath") . "/storeSetting.json";
        $str = file_get_contents($path);
        $settings = json_decode($str, true);
        return $settings;
    }

    public static function saveSettings($productconfig) {
        $path = Config("constants.adminStorePath") . "/storeSetting.json";
        $jsonfile = fopen($path, "w");
        fwrite($jsonfile, $productconfig);
        fclose($jsonfile);
        return 1;
    }

    public static function getRelatedProd($prod) {
        $relatedId = DB::table('has_categories')->where('prod_id', $prod->id)->pluck("cat_id");
        $prod_id = DB::table('has_categories')->Where('cat_id', DB::table('has_categories')->where('prod_id', $prod->id)->pluck("cat_id"))->pluck("prod_id");
        $products = Product::with(['mainimg', 'sales', 'wishlist'])->whereIn('id', $prod_id)->where('id', '!=', $prod->id)->orderByRaw("RAND()")->take(5)->get();
        return $products;
    }

    public static function discForProduct($prodPer, $getOrderAmtPer, $fixedAmtVal) {
        if (($prodPer * $fixedAmtVal) > 0)
            $amt = $prodPer * $fixedAmtVal / $getOrderAmtPer;
        else
            $amt = 0;
        return round($amt, 2);
    }

    public static function revertTax() {
        $cart = Cart::instance('shopping')->content();
        foreach ($cart as $k => $c) {
            $subtotal = 0;
            $tax_amt = 0;
            Cart::instance('shopping')->update($k, ["options" => ['disc' => 0]]);
            if ($c->options->tax_type == 2) {
                $tax_amt = round(($c->price * ($c->options->taxes / 100)), 2);
                $subtotal = $c->price + $tax_amt;
                Cart::instance('shopping')->update($k, ["subtotal" => $subtotal]);
                Cart::instance('shopping')->update($k, ["options" => ['tax_amt' => $tax_amt]]);
            }
        }
        return $cart;
    }

    public static function calAmtWithTax() {
        $taxStatus = GeneralSetting::where('url_key', 'tax')->first()->status;
        $cart = Cart::instance('shopping')->content();
        $calTax = 0;
        $tax_amt = 0;
        $orderAmt = 0;
        foreach ($cart as $k => $c) {
            $getdisc = ($c->options->disc + $c->options->wallet_disc + $c->options->voucher_disc + $c->options->referral_disc + $c->options->user_disc);
            $taxeble_amt = $c->subtotal - $getdisc;
            $orderAmt += $c->subtotal;
            if ($taxStatus == 1) {
                $tax_amt = round($taxeble_amt * $c->options->taxes / 100, 2);
                if ($c->options->tax_type == 2) {
                    $calTax = $calTax + $tax_amt;
                }
            }
            Cart::instance('shopping')->update($k, ["options" => ['tax_amt' => $tax_amt]]);
        }

        $cart_total = $orderAmt;
        $data = [];
        $all_coupon_amount = Session::get('couponUsedAmt') + Session::get('checkbackUsedAmt') + Session::get('voucherAmount') + Session::get('referalCodeAmt') + Session::get('lolyatyDis') + Session::get('discAmt');
        $subtotal = $calTax + $cart_total;
        $data['cart'] = $cart;
        $data['sub_total'] = $subtotal;
        $data['total'] = $subtotal - $all_coupon_amount;
        return $data;
    }

    public static function distribteDisc($field, $amt) {
        if (Helper::mrpTotal() < $amt) {
            if (!is_null(Session::get('GiftingCharges'))) {
                $amt-=Session::get('GiftingCharges');
            }
            if (!is_null(Session::get('shippingAmount'))) {
                $amt-=Session::get('shippingAmount');
            }
        }
        $cartContent = Cart::instance("shopping")->content(); //Helper::amtWithAddcharges()
        foreach ($cartContent as $ckey => $cItm) {
            Cart::instance('shopping')->update($ckey, ["options" => [$field => Helper::discForProduct($cItm->price / 100, Helper::mrpTotal() / 100, $amt)]]);
        }
    }

    public static function mrpTotal() {
        $cart = Cart::instance('shopping')->content();
        $sumMrp = 0;
        foreach ($cart as $key => $cItm) {
            $sumMrp+=$cart[$key]->price;
        }
        return $sumMrp;
    }

    public static function getMrpTotal() {
        $cart = Cart::instance('shopping')->content();
        $sub_total = 0;
        foreach ($cart as $key => $cItm) {
            $getdisc = ($cItm->options->disc + $cItm->options->wallet_disc + $cItm->options->voucher_disc + $cItm->options->referral_disc + $cItm->options->user_disc);
            $sub_total += $cItm->subtotal - $getdisc;
        }
        return $sub_total;
    }

    public static function generalSetting($id) {
        return GeneralSetting::find($id);
    }

    public static function addVariant($cart) {
        // var_dump($cart); die;
        foreach ($cart as $item) {
            // dd($item->options->options);
            $subtot = 0;
            if ($item->options->options) {
                $item->variant = "";
                foreach ($item->options->options as $key => $value) {
                    if ($key == 1)
                        $item->variant .= @AttributeValue::find($value)->option_name . " ";
                    if (!empty($value->options)) {
                        foreach ($value->options as $opt => $optval) {
                            if ($key == 1)
                                $item->variant .= @AttributeValue::find($optval)->option_name . " ";
                        }
                    }
                }
            }
        }
    }

    public static function saveImage($exturl, $saveto) {
        file_put_contents($saveto, file_get_contents($exturl));
    }

    public static function getbreadcrumbs($catid, $selslug = null) {
        $category = MallProdCategory::find($catid);
        $arr = [];
        if (isset($category)) {
            $data = $category->ancestorsAndSelf()->get()->toArray();
            $data = Helper::array_sort($data, "depth", SORT_ASC);
            $breadcrumbs = "";
            $breadcrumbs .= "<li>";
            $breadcrumbs .= "<a href='" . route('home') . "'>Home</a></li>";
            foreach ($data as $datab) {
                if ($datab->url_key == $selslug)
                    $urlkey = 'javascript:void(0)';
                else
                    $urlkey = route('category', ['slug' => $datab->url_key]);
                $breadcrumbs .="<li>";
                $breadcrumbs .= "<a href='" . $urlkey . "'>" . $datab->category . " </a>";
                $breadcrumbs .="</li>";
            }
            //return substr($breadcrumbs, 0, -1);
            return $breadcrumbs;
        }
    }

    public static function array_sort($array, $on, $order = SORT_ASC) {
        $new_array = array();
        $sortable_array = array();
        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                } else {
                    $sortable_array[$k] = $v;
                }
            }

            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                    break;
                case SORT_DESC:
                    arsort($sortable_array);
                    break;
            }

            foreach ($sortable_array as $k => $v) {
                $new_array[$k] = (object) $array[$k];
            }
        }

        return $new_array;
    }

    public static function maxPriceByCat($catId) {
        $allCats = array();
        if (MallProdCategory::find($catId)->isLeaf()) {
            array_push($allCats, MallProdCategory::find($catId)->ancestorsAndSelf()->get(['id']));
        }
        if (MallProdCategory::find($catId)->isRoot()) {
            array_push($allCats, MallProdCategory::find($catId)->descendantsAndSelf()->get(['id']));
        }
        if (MallProdCategory::find($catId)->children()->count() > 0) {
            array_push($allCats, MallProdCategory::find($catId)->descendantsAndSelf()->get(['id']));
            array_push($allCats, MallProdCategory::find($catId)->ancestors()->get());
        }
        foreach ($allCats as $cats) {
            foreach ($cats as $cat) {
                $cat_id[] = $cat->id;
            }
        }

        $prod = DB::table('has_categories')->whereIn('cat_id', $cat_id)->pluck('prod_id');
        //dd($prod);
        $maxp = DB::table('mall_products')->select(DB::raw("max(`selling_price`) as maxp"))->whereIn('id', $prod)->first();
        // dd($maxp);
        return $maxp->maxp;
    }

    public static function quickAddtoCart($prods) {
        //print_r(Session::get('currency_val')); die;
        $attibute = [];
        $stockLimit = json_decode(GeneralSetting::where('url_key', 'stock')->first()->details);
        foreach ($prods as $key => $prod) {
            $selAttrs = [];
            if ($prod->prod_type == 3) {
                $product = Product::where('id', $prod->id)
                                ->with([
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
                                        ])->first();
                        // dd()
                        // $quick->$key= $product;            
                        $product->prodImage = Config('constants.productImgPath') . '/' . @$product->catalogimgs()->first()->filename;
                        $product->shortDesc = html_entity_decode($product->short_desc);
                        $product->longDesc = html_entity_decode($product->long_desc);

                        $subprods = $prod->subproducts()->get();
                        foreach ($subprods as $subP) {
                            $hasOpt = $subP->attributes()->withPivot('attr_id', 'prod_id', 'attr_val')->orderBy("att_sort_order", "asc")->get();
                            foreach ($hasOpt as $prdOpt) {
                                $selAttrs[$prdOpt->pivot->attr_id]['placeholder'] = Attribute::find($prdOpt->pivot->attr_id)->placeholder;
                                $selAttrs[$prdOpt->pivot->attr_id]['name'] = Attribute::find($prdOpt->pivot->attr_id)->attr;
                                $selAttrs[$prdOpt->pivot->attr_id][Attribute::find($prdOpt->pivot->attr_id)->slug] = Attribute::find($prdOpt->pivot->attr_id)->attr;
                                $selAttrs[$prdOpt->pivot->attr_id]['options'][AttributeValue::find($prdOpt->pivot->attr_val)->option_value] = AttributeValue::find($prdOpt->pivot->attr_val)->option_name;
                                $selAttrs[$prdOpt->pivot->attr_id]['attrs'][AttributeValue::find($prdOpt->pivot->attr_val)->option_value]['prods'][] = $prdOpt->pivot->prod_id;
                                $selAttrs[$prdOpt->pivot->attr_id]['prods'][] = $prdOpt->pivot->prod_id;
                            }
                        }
                        // dd($product)
                        $attibute[$product->id] = $selAttrs;
                        $product->selAttrs = $selAttrs;
                        $quickProduct[] = $product;
                        // $quickProduct["attrsvalue"][]=$selAttrs; 
                    } elseif ($prod->prod_type == 1) {
                        $product = Product::where('id', $prod->id)->first();
                        // dd()
                        // $quick->$key= $product;            
                        $product->prodImage = Config('constants.productImgPath') . '/' . @$product->catalogimgs()->first()->filename;
                        $product->shortDesc = html_entity_decode($product->short_desc);
                        $product->longDesc = html_entity_decode($product->long_desc);
                        if (User::find(Session::get('loggedin_user_id')) && User::find(Session::get('loggedin_user_id'))->wishlist->contains($product->id)) {
                            $product->wishlist = 1;
                        } else {
                            $product->wishlist = 0;
                        }
                        $quickProduct[] = $product;
                    }
                    // $quickProduct["product"][]=$product;   
                    //  $quickProduct["selAttrs"][]=$selAttrs;   
                }
//        dd($quickProduct);
                $data['selAttrs'] = $attibute;
                $data['product'] = $quickProduct;
                $data['currencyVal'] = Session::get('currency_val');
                $data['stocklimit'] = $stockLimit->stocklimit;
                // $currencySetting = new \App\Http\Controllers\Frontend\HomeController();
                $data['curData'] = app('App\Http\Controllers\Frontend\HomeController')->setCurrency();
                return $data;
            }

            public static function getlogout() {
                Auth::logout();
                Session::flush();
                Cart::instance("shopping")->destroy();
            }

            public static function socialShareIcon($data) {
                $urls = '
<div class="a2a_kit a2a_kit_size_32 a2a_default_style" data-a2a-url=' . $data['url'] . ' data-a2a-title="{{$prdimg->short_desc}}">
<a class="socialShareFb"><span class="a2a_svg a2a_s__default a2a_s_facebook" style="background-color: rgb(59, 89, 152);"><svg focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32"><path fill="#FFF" d="M17.78 27.5V17.008h3.522l.527-4.09h-4.05v-2.61c0-1.182.33-1.99 2.023-1.99h2.166V4.66c-.375-.05-1.66-.16-3.155-.16-3.123 0-5.26 1.905-5.26 5.405v3.016h-3.53v4.09h3.53V27.5h4.223z"></path></svg></span></a>
<a class="a2a_button_twitter"></a>
<a class="a2a_button_google_plus"></a>
<a class="a2a_button_linkedin"></a>
<a class="a2a_button_pinterest"></a>
<a class="a2a_button_email"></a>
</div>';
                return $urls;
            }

            public static function checkCodPincode($postcode) {
                $pincodeFeature = GeneralSetting::where('url_key', 'pincode')->first()->status;

                $codFeature = GeneralSetting::where('url_key', 'cod')->first()->status;
                $dbPincodes = Pincode::where("pincode", $postcode)->where('status', 1)->first();
                if ($pincodeFeature == 1 && $codFeature == 1) {
                    if (count($dbPincodes) > 0) {
                        if ($dbPincodes->cod_status == 1) {
                            return 1; //cod vailable
                        } else {
                            return 2; // cod not available
                        }
                    } else {
                        return 3; //pincode not available
                    }
                } else if ($pincodeFeature == 1 && $codFeature == 0) {
                    if (count($dbPincodes) > 0) {
                        return 5; //pincode available
                    } else {
                        return 3; //pincode not available
                    }
                } else if ($pincodeFeature == 0 && $codFeature == 1) {
                    return 6;
                } else {
                    return 4; //dont check pincode or cod
                }
            }

            public static function assignCourier($pincode, $iscod) {
                $serviceP = Pincode::where("cod_status", $iscod)->where("status", 1)->where("pincode", $pincode)->orderBy("pref")->first();

                if (count($serviceP) > 0)
                    return $serviceP->service_provider;
                else
                    return 0;
            }

            public static function getEmailInvoice($orderId) {
                $addCharge = GeneralSetting::where('url_key', 'additional-charge')->first();
                $manuD = GeneralSetting::where('url_key', 'manual-discount')->first();
                $tax = GeneralSetting::where('url_key', 'tax')->first()->status;
                $order = Order::find($orderId);
                if (!empty($order)) {
                    $currency = "inr";
                    $currency_val = 1;
                    $currency_css = '&#8377';
                    if (isset($order->currency->currency)) {
                        $currency = $order->currency->currency;
                        $currency_val = $order->currency->currency_val;
                        $currency_css = trim($order->currency->css_code);
                    }
                    echo $currency_css;
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
                        $tableContant = $tableContant . '   <tr class="cart_item">
        <td class="cart-product-thumbnail" align="left" style="border: 1px solid #ddd;border-left: 0;border-top: 0;padding: 10px;">';
                        if ($cart['options']['image'] != '') {
                            $tableContant = $tableContant . '   <a href="#"><img width="64" height="64" src="' . $cart["options"]["image_with_path"] . "/" . $cart["options"]["image"] . '" alt="">
          </a>';
                        } else {
                            $tableContant = $tableContant . '  <img width="64" height="64" src="' . $cart["options"]["image_with_path"] . '/default-image.jpg" alt="">';
                        }
                        $tableContant = $tableContant . '</td>
        <td class="cart-product-name" align="center" style="border: 1px solid #ddd;border-left: 0;border-top: 0;padding: 10px;"> <a href="#">' . $cart["name"] . '</a>
            <br>
          <small><a href="#"> ';
                        if (!empty($cart['options']['options'])) {
                            $option = '';
                            foreach ($cart['options']['options'] as $key => $value) {
                                $optVal = DB::table($cart['options']['prefix'] .'_attribute_values')->where('id', $value)->first();
                                $option += ($optVal)? $optVal->option_name: '';
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

                        $tableContant = $tableContant . '<td class="cart-product-subtotal" align="center" style="border: 1px solid #ddd;border-left: 0;border-right:0px;border-top: 0;padding: 10px;"> <span class="amount"> ' . htmlspecialchars_decode($currency_css) . ' ' . number_format(((@$cart["subtotal"] + @$tax_amt) * Session::get('currency_val')), 2, '.', '') . '</span> </td>
      </tr>';
                        $gettotal += $cart["subtotal"] + $tax_amt;
                    endforeach;
                    $tableContant = $tableContant . '  </tbody>
    <tr>
        <td colspan="4" class="text-right" align="right" style="border: 1px solid #ddd;border-left: 0;border-top: 0;padding: 10px;"><b>Sub-Total</b></td>
        <td colspan="2" align="center" style="border: 1px solid #ddd;border-left: 0;border-right:0;border-top: 0;padding: 10px;"> ' . htmlspecialchars_decode($currency_css) . ' ' . number_format(($gettotal * Session::get('currency_val')), 2, '.', '') . '</td>
      </tr>';
                    if ($order->cod_charges) {
                        $tableContant = $tableContant . '    <tr>
        <td colspan="4" class="text-right" align="right" style="border: 1px solid #ddd;border-left: 0;border-top: 0;padding: 10px;"><b>COD Charges </b></td>
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

            public static function sendsms($mobile = null, $msg = null, $country = null) {
                $mobile = $mobile;
                if ($mobile) {
                    $msg = $msg;
                    $msg = urlencode($msg);


                    // echo $msg;
                    //if($country=='+91')
                    if ($country == '+880') {
                        $urlto = "http://api.boom-cast.com/boomcast/WebFramework/boomCastWebService/externalApiSendTextMessage.php?masking=NOMASK&userName=IFC&password=6d38103103bb45de1c77e7eece818b1c&MsgType=TEXT&receiver=$mobile&message=$msg";
                    } else {
                        $urlto = "http://enterprise.smsgupshup.com/GatewayAPI/rest?method=SendMessage&send_to=$mobile&msg=$msg&msg_type=TEXT&userid=2000164017&auth_scheme=plain&password=GClWepNxL&v=1.1&format=text";
                    }
                    $ch = curl_init();
// set URL and other appropriate options
                    curl_setopt($ch, CURLOPT_URL, $urlto);
                    //curl_setopt($ch, CURLOPT_HEADER, 0);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// grab URL and pass it to the browser
                    $output = curl_exec($ch);

// close cURL resource, and free up system resources
                    curl_close($ch);
                }
            }

            public static function getCurrency($isoCode) {
//                echo $isoCode;
                $currencyData = HasCurrency::where('iso_code', $isoCode)->first();
                Session::put('currency_id', $currencyData->id);
                Session::put('currency_code', $currencyData->currency);
                Session::put('currency_name', $currencyData->currency_name);
                Session::put('currency_val', $currencyData->currency_val); //$currencyData->currency_val
                Session::put('currency_symbol', $currencyData->css_code);
                return $currencyData;
            }

            public static function unsetSession($sessionParams) {
                if (!empty($sessionParams)) {
                    foreach ($sessionParams as $val) {
                        Session::forget($val);
                    }
                }
            }

            public static function getLogoFromURL($logo) {
                $img = str_replace('data:image/png;base64,', '', $logo);
                $img = str_replace(' ', '+', $img);
                $data = base64_decode($img);
                $file = Config("constants.logoUploadImgPath") . 'logo.png';
                $success = file_put_contents($file, $data);
                return $file;
            }

            public static function getCartProd($cart, $prodId, $subProdId) {
                $prod = [];
                foreach ($cart as $key => $cartProd) {
                    if ($subProdId > 0 && $cartProd['options']['prod_type'] == 3) {
                        if ($cartProd['options']['sub_prod'] == $subProdId) {
                            $prod = $cartProd;
                        }
                    } else if ($cartProd['options']['prod_type'] == 1) {
                        if ($cartProd['id'] == $prodId) {
                            $prod = $cartProd;
                        }
                    }
                }
                return $prod;
            }

        }

?>