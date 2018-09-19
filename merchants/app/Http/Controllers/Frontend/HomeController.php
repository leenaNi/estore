<?php

namespace App\Http\Controllers\Frontend;

use Socialite;
use Route;
use Input;
use App\Models\User;
use App\Models\Category;
use App\Models\GeneralSetting;
use App\Library\Helper;
use App\Models\Slider;
use App\Models\SocialMediaLink;
use Auth;
use App\Models\Notification;
use App\Models\CatalogImage;
use App\Models\Contact;
use App\Models\StaticPage;
use App\Models\Role;
use App\Models\Layout;
use App\Models\Order;
use App\Models\HasLayout;
use App\Models\ProductType;
use App\Models\AttributeSet;
use App\Models\EmailTemplate;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Session;
use App\Models\DynamicLayout;
use App\Models\Product;
use App\Models\Testimonials;
use App\Models\Pincode;
use Config;
use Cart;
use DB;

class HomeController extends Controller {
    /* public function statusofnotification()
      {
      $notificationStatus=GeneralSetting::finBySlug('notification')->status;
      //$status=$setting->status;
      return $notificationStatus;
      } */

    public function checkemail() {
        $email = Input::get('email');
        $count = Notification::where('email', $email)->count();
        return $count;
    }

    public function index() {
       $users = User::with("userCashback")->find( 1);
     dd($users);
//$chkEmail = DB::select(DB::raw("select * from users"));
//      
//          $chkEmail = User::get();
        // print_r(Session::get('currency_val')); die;
        $testimonial_status = GeneralSetting::where("url_key", 'testimonial')->first();
//        $saveto= "public/Admin/uploads/slider/default_slider.png";
//        dd(Helper::saveImage("http://www.techhaking.com/wp-content/uploads/2017/09/default-slider-image-300x150.png",$saveto));
//        $data1 = [];
//        Helper::sendMyEmail('Frontend.emails.test_mail', $data1, 'Test mail from inficart.com', 'support@inficart.com', 'inficart.com', 'tapodnya@infiniteit.biz', 'Tapodnya');
        $categoryA = Category::get(['id', 'category'])->toArray();
        $rootsS = Category::roots()->where("status", 1)->get();
        $category = [];
        $attr_sets = [];
        $prod_types = [];
        foreach ($categoryA as $val) {
            $category[$val['id']] = $val['category'];
        }


        $prodTy = ProductType::where('status', 1);
        if ($this->feature['products-with-variants'] == 0) {
            $prodTy = $prodTy->where("id", 1);
        }
//                 else{
//            $prodTy =$prodTy->whereIn("id",[1,3]);;
//                 }
        $prodTy = $prodTy->get(['id', 'type']);
        foreach ($prodTy as $prodT) {
            $prod_types[$prodT['id']] = $prodT['type'];
        }
        $attrS = AttributeSet::where('status', 1)->get(['id', 'attr_set'])->toArray();
        foreach ($attrS as $attr) {
            $attr_sets[$attr['id']] = $attr['attr_set'];
        }

        $data = [];
        $layout = Layout::where("is_active", 1)->get();
        foreach ($layout as $key => $value) {
            //$rev_pos = strpos(strrev($value->url_key),'-');
            //echo $rev_pos;
            // echo substr($value->url_key, 0 ,$rev_pos-1) ."<br>";

            if (Session::get('login_user_type') == 1) {
                if ($value->url_key == 'home-page-3-boxes') {
                    $data[str_replace("-", "_", $value->url_key)] = HasLayout::where("image", "!=", "")->where('layout_id', $value->id)->orderBy("sort_order", "asc")->take(3)->get();
                } else {
                    $data[str_replace("-", "_", $value->url_key)] = HasLayout::where('is_active', 1)->where('layout_id', $value->id)->orderBy("sort_order", "asc")->get();
                }
            } else {
                $data[str_replace("-", "_", $value->url_key)] = HasLayout::where('is_active', 1)->where('layout_id', $value->id)->orderBy("sort_order", "asc")->get();
            }
        }
        $data[str_replace("-", "_", $value->url_key)] = HasLayout::where('is_active', 1)->where('layout_id', $value->id)->orderBy("sort_order", "asc")->get();

        $data['attr_sets'] = $attr_sets;
        $data['prod_types'] = $prod_types;
        $data['category'] = $category;
        $data['rootsS'] = $rootsS;
        // $data['trendingProds'] = Category::where('url_key', 'trending')->first()->products()->where("status", 1)->get();
        $data['trendingProds'] = Product::where('is_trending', '1')->where("status", 1)->orderBy('sort_order', 'ASC')->orderBy('created_at', 'DESC')->get();

        //  $data['slider-page'] = Slider::where("slider_id", 2)->get();
        $data['dynamicLayout'] = DynamicLayout::where("status", 1)->orderBy('sort_order', 'asc')->get();
        $data['testimonial'] = Testimonials::where("status", 1)->orderBy('sort_order', 'asc')->get();
        $data['testimonial_status'] = $testimonial_status;
        // dd($data);
        $viewname = Config('constants.frontendView') . '.index';

        return Helper::returnView($viewname, $data, null, 1);
    }

    public function saveProduct() {
//dd(Input::all());
        $prod = Product::create(Input::all());
        $category = Input::get("category");
        $retunUrl = Input::get("return_url");
        // print_r($prod);die;
        if (Input::File('images')) {
            // dd(Input::File('images'));
            $imgValue = Input::File('images');

            $destinationPath = Config('constants.productUploadImgPath') . "/";
            $data = Input::get('prod_img_url');
            list($type, $data) = explode(';', $data);
            list(, $data) = explode(',', $data);
            $data = base64_decode($data);
            $fileName = "prod-" . date("YmdHis") . "." . Input::File('images')->getClientOriginalExtension();
            file_put_contents($destinationPath . $fileName, $data);


            // $destinationPath = public_path() . '/public/Admin/uploads/catalog/products/';
            // $fileName = "prod-" . date("YmdHis") . "." . Input::File('images')->getClientOriginalExtension();
            // $upload_success = Input::File('images')->move($destinationPath, $fileName);


            $saveImgs = CatalogImage::findOrNew(Input::get('id_img'));
            $saveImgs->catalog_id = $prod->id;
            $saveImgs->filename = is_null($fileName) ? $saveImgs->filename : $fileName;
            $saveImgs->image_type = 1;
            $saveImgs->image_mode = 1;
            $saveImgs->alt_text = Input::get('product');
            ;
            $saveImgs->image_path = Config('constants.productImgPath');
            $saveImgs->save();
        }

        $prod->added_by = Input::get('added_by');
        if ($prod->prod_type == 1) {
            $prod->attr_set = "1";
        }
        if (Input::get('selling_price')) {

            if (Input::get('price') > Input::get('selling_price')) {
                $prod->spl_price = Input::get('selling_price');
                $prod->selling_price = Input::get('selling_price');
            } else {
                $prod->selling_price = Input::get('price');
            }
        }
        if (Input::get('is_stock')) {
            $prod->stock = 20; // Input::get('stock');
        } else {
            $prod->stock = 10000;
        }

        //dd($prod);
        // Session::flash("msg","Product Added succesfully.");
        $prod->update();
        if ($prod->prod_type != 3) {
            $attributes = AttributeSet::find($prod->attributeset['id'])->attributes;
            if (!empty($attributes))
                $prod->attributes()->sync($attributes);
            else
                $prod->attributes()->detach();
        } else {
            $attributes = AttributeSet::find($prod->attributeset['id'])->attributes()->where('is_filterable', "=", "0")->get();
            if (!empty($attributes))
                $prod->attributes()->sync($attributes);
        }
        if (count($category) > 0) {
            $prod->categories()->sync($category);
        }
        $view = redirect()->route("home");
        return $view;
    }

    public function forgotPassword() {
        $data = [];
        $viewname = Config('constants.frontendView') . '.forgot_password';
        return Helper::returnView($viewname, $data);
    }

    public function resetNewPwd($link) {

        $data = ['link' => $link];
        $viewname = Config('constants.frontendView') . '.reset_forgot_pwd';
        return Helper::returnView($viewname, $data);
    }

    public function notify() {
        $emailStatus = GeneralSetting::where('url_key', 'email-facility')->fiist()->status;
        $emailvalue = Input::get('emailvalue');
        $count = Notification::where('email', $emailvalue)->count();

        if ($count == 0) {
            $sendmail = Notification::Create(['email' => $emailvalue]);
            if ($sendmail) {
                if ($emailStatus) {
                    //$data=['email'=>$emailvalue];
                    $filepath = Config('constants.frontviewEmailTemplatesPath') . '.email';
                    Mail::send($filepath, [], function($m)use($emailvalue) {
                        $m->from('hello@app.com', 'Your Application');

                        $m->to($emailvalue)->subject('Subscription');
                    });
                }
            }
        }
        return $count;
    }

    function change_country() {
        $cookie_value = input::get('id');
        $cookie_name = "currency";
        setcookie($cookie_name, $cookie_value, time() + 86400, "/"); // 86400 = 1 day
        Helper::set_country_session($cookie_value);
    }

    public function contactUs1() {
        $data = [];
        $viewname = Config('constants.frontendView') . '.contact_us';
        return Helper::returnView($viewname, $data);
    }

    public function subscription() {
        $email = Input::get('email');
        $subscription = Notification::where('email', $email)->first();
        if (count($subscription) > 0) {
            return "You are already subscribed with us!";
        } else {
            $subscription = new Notification();
            $subscription->email = $email;
            $subscription->timestamps = false;
            $subscription->save();
            $parts = explode("@", Input::get('email'));
            $fname = $parts[0];
            $contactEmail = Config::get('mail.from.address');
            $contactName = Config::get('mail.from.name');
            $data_email = ['first_name' => $fname];
            if (Mail::send(Config('constants.frontviewEmailTemplatesPath') . '.subscription', $data_email, function($message) use ($contactEmail, $contactName, $email, $fname, $data_email) {
                        $message->from($contactEmail, $contactName);
                        $message->to($email, $fname)->subject("News Alert Subscription");
                        $message->bcc(['pradeep@infiniteit.biz']);
                    }))
                ;

            return "You are successfully subscribe with us!";
        }
    }

    public function aboutUs() {
        //dd(Input::get('url'));
        $about = StaticPage::where('url_key', 'about-us')->first();
        $data = ['about' => $about];
        $viewname = Config('constants.frontendView') . '.about-us';
        return Helper::returnView($viewname, $data);
    }

    public function contactUs() {
        $contact = StaticPage::where('url_key', 'contact-us')->first();


        $data = ['contact' => $contact];
        $viewname = Config('constants.frontendView') . '.contact_us';
        return Helper::returnView($viewname, $data);
    }

    public function termsConditions() {
        $terms = StaticPage::where('url_key', 'terms-conditions')->first();
        $data = ['terms' => $terms];
        $viewname = Config('constants.frontendView') . '.terms-condition';
        return Helper::returnView($viewname, $data);
    }

    public function privacyPolicy() {
        $terms = StaticPage::where('url_key', 'privacy-policy')->first();
        $data = ['terms' => $terms];
        $viewname = Config('constants.frontendView') . '.privacy-policy';
        return Helper::returnView($viewname, $data);
    }

    public function disclaimer() {
        $terms = StaticPage::where('url_key', 'privacy-policy')->first();
        $data = ['terms' => $terms];
        $viewname = Config('constants.frontendView') . '.disclaimer';
        return Helper::returnView($viewname, $data);
    }

    public function checkPincode() {
        $check = Helper::checkCodPincode(Input::get('pincode'));
        if ($check == 1) {
            return ['errorType' => 'success', 'message' => 'COD available for this pincode.'];
        } else if ($check == 2) {
            return ['errorType' => 'error', 'message' => 'COD not available for this pincode.'];
        } else if ($check == 3) {
            return ['errorType' => 'errorNotCont', 'message' => 'Pincode not available for delivery.'];
        } else if ($check == 5) {
            return ['errorType' => 'success', 'message' => 'Pincode available for delivery.'];
        }
    }

    public function contactSent() {

        $contactform_fname = Input::get('firstname');

        $contactform_email = Input::get('useremail');
        $contactform_phone = Input::get('telephone');
        $contactform_message = Input::get('message');

        $data['email_id'] = $contactform_email;
        $data['name'] = $contactform_fname;
        $data['phone'] = $contactform_phone;
        $data['textmessage'] = $contactform_message;
        $contact = StaticPage::where('url_key', 'contact-us')->first()->contact_details;
        if (!empty($contact))
            $email_list = json_decode($contact)->email;
        else
            $email_list = "leena@infiniteit.biz";
        //dd($data);
        //  Helper::sendMyEmail(Config('constants.frontviewEmailTemplatesPath') . 'contact', $data, 'Contact form - kompanero', 'pradeep@infiniteit.biz', 'kompanero test email', 'pradeep@infiniteit.biz', 'Kompan ero ');
        $contactEmail = Config::get('mail.from.address');
        $contactName = Config::get('mail.from.name');
        $email = $email_list;
        $fname = $contactform_fname;
//         if (Mail::send(Config('constants.frontviewEmailTemplatesPath') . '.contact', $data, function($message) use ($contactEmail, $contactName, $email, $fname, $data) {
//                        $message->from($contactEmail, $contactName);
//                        $message->to($email_list, $fname)->subject("Cartinit Contact Us");
//                       // $message->cc(['indranath.sgupta@gmail.com','aloke@asgleather.com']);
//                    }));
        if ($this->getEmailStatus == 1) {
            $email_template = EmailTemplate::where('id', 13)->select('content')->get()->toArray()[0]['content'];
            $replace = ["[userName]", "[userEmail]", "[telephone]", "[message]"];
            $replacewith = [ucfirst($contactform_fname), $contactform_email, $contactform_phone, $contactform_message];
            $subject = "Conatct form Enquiry";
            $email_templates = str_replace($replace, $replacewith, $email_template);
            $data1 = ['email_template' => $email_templates];
            if (Helper::sendMyEmail(Config('constants.adminEmails') . '.email_by_remplate', $data1, $subject, Config::get('mail.from.address'), Config::get('mail.from.name'), $email_list, $contactform_fname))
                return 1;

            return 1;
        }
    }

    public function saveManageCategories() {
        $allcats = Input::get('manage_categories');
        Category::roots()->update(["status" => 0]);
        foreach ($allcats as $acatk => $acat) {
            $savecat = Category::find($acatk);
            $savecat->status = $acat;
            $savecat->update();
        }
        return redirect()->back();
    }

    public function updateHomePage3Boxes() {
        //dd(Input::all());
        $dynamiclayout = HasLayout::find(Input::get("id"));
        $dynamiclayout->layout_id = 4;
        $dynamiclayout->link = Input::get("link");
        $dynamiclayout->is_active = Input::get("is_active");
        $dynamiclayout->sort_order = Input::get("sort_order");

        if (Input::hasFile('image')) {
            // $destinationPath = Config('constants.layoutUploadPath');
            // $fileName = date("YmdHis") . "." . Input::file('image')->getClientOriginalExtension();
            // $upload_success = @Input::file('image')->move(@$destinationPath, @$fileName);
            $destinationPath = Config('constants.layoutUploadPath');
            $data = Input::get('box3_image');
            list($type, $data) = explode(';', $data);
            list(, $data) = explode(',', $data);
            $data = base64_decode($data);
            $fileName = $fileName = date("YmdHis") . "." . Input::file('image')->getClientOriginalExtension();
            file_put_contents($destinationPath . $fileName, $data);
        } else {
            $fileName = Input::get("old_image");
        }
        // if (!empty($upload_success)) {
        //     $dynamiclayout->image = $fileName;
        // }
        $dynamiclayout->image = $fileName;
        $dynamiclayout->save();
        return redirect()->back();
    }

    public function changeStatusHomePage3Boxes() {
        $dynamiclayout = HasLayout::find(Input::get("id"));
        $dynamiclayout->is_active = Input::get("isActive");
        $dynamiclayout->update();
        return 1;
    }

    public function getLogin() {
        Auth::logout();
        Session::flush();
        Cart::instance("shopping")->destroy();
        $userDetails = User::where('telephone', Input::get('telephone'))->first();
        Auth::login($userDetails);


        $user = User::with('roles')->find($userDetails->id);
        Session::put('loggedinAdminId', $userDetails->id);
        Session::put('profile', $userDetails->profile);
        Session::put('loggedin_user_id', $user->id);
        Session::put('login_user_type', $user->user_type);
        $roles = $user->roles()->first();
        $r = Role::find($roles->id);
        $per = $r->perms()->get()->toArray();
        return redirect()->route('admin.home.view');
    }

    public function getLog() {
        Auth::logout();
        Session::flush();
        Cart::instance("shopping")->destroy();
        $userDetails = User::where('telephone', Input::get('telephone'))->first();
        Auth::login($userDetails);
        Helper::postLogin($userDetails->id);
        return redirect()->route('home');
    }

    public function setCurrency() {
        //Default Currency
        $currency = GeneralSetting::where('url_key', 'default-currency')->first(['details']);
        $currencySettings = json_decode($currency->details, true);
        $jsonString = Helper::getSettings();
        $data = (object) $jsonString;

        //Current Session Currency
        $currentCurr = Session::get('currency');

        if ($currencySettings['iso_code'] !== $data->currencyId && empty(Session::get('currency_id'))) { //default currency is changed
            Session::put('currency', $data->currencyId);
            $curr = Helper::getCurrency($data->currencyId);
            return ['currency' => $data->currencyId, 'sym' => trim($curr->css_code), 'curval' => $curr->currency_val, 'store_cur' => $data->currencyId];
        } else if ($currencySettings['iso_code'] === $data->currencyId) { //both currency is same
            if (!empty($currentCurr)) {
                if ($currencySettings['iso_code'] !== $currentCurr) { //current session currency is diff then set it to default
                    Session::put('currency', $currencySettings['iso_code']);
                    $curr = Helper::getCurrency($currencySettings['iso_code']);
                    return ['currency' => $currencySettings['iso_code'], 'sym' => trim($curr->css_code), 'curval' => $curr->currency_val, 'store_cur' => $data->currencyId];
                } else {
                    $curr = Helper::getCurrency($currencySettings['iso_code']);
                    return ['currency' => $currentCurr, 'sym' => trim($curr->css_code), 'curval' => $curr->currency_val, 'store_cur' => $data->currencyId];
                }
            } else if (!empty($currency)) {
                Session::put('currency', $currencySettings['iso_code']);
                $curr = Helper::getCurrency($currencySettings['iso_code']);
                return ['currency' => $currencySettings['iso_code'], 'sym' => trim($curr->css_code), 'curval' => $curr->currency_val, 'store_cur' => $data->currencyId];
            } else {
                $curr = Helper::getCurrency($data->currencyId);
                return ['currency' => $data->currencyId, 'sym' => trim($curr->css_code), 'curval' => $curr->currency_val, 'store_cur' => $data->currencyId];
            }
        } else {
            $curr = Helper::getCurrency($data->currencyId);
            return ['currency' => $data->currencyId, 'sym' => trim($curr->css_code), 'curval' => $curr->currency_val, 'store_cur' => $data->currencyId];
        }
    }

    public function ecurierTracking() {
        $trackingId = Input::get("trackingId");
       // dd($trackingId);
        $headers[] = 'Content-Type:application/x-www-form-urlencoded';
        $headers[] = 'USER_ID:D2788';
        $headers[] = 'API_KEY:F3DT';
        $headers[] = 'API_SECRET:fCcBb';
        $reqArray = [];
        $reqArray['parcel'] = 'track';
        $reqArray['ecr'] =$trackingId;

        $url = "http://103.239.254.146/apiv2/";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($reqArray));

        $output = curl_exec($ch);
       // echo "==eerrno=" . curl_errno($ch) . "<br>";
      //  echo "output===" . print_r($output);
        if (curl_errno($ch)) {
          //  echo 'Error:' . curl_error($ch);
        } else {
          //  echo "ggg";
        }
      //  dd(json_decode($output));
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
      //  echo 'HTTP code: ' . $httpcode;
        if(json_decode($output)->query_data=='No Data Found'){
             $data=['status'=>0,'trackdata'=>json_decode($output)->query_data]; 
        }else{
         $data=['status'=>1,'trackdata'=>json_decode($output)->query_data[0]->status];   
        }
        return $data;
    }

}
