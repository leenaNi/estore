<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Library\Helper;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use DB;
use Input;
use Route;
use Session;

class CouponsController extends Controller
{

    public function index()
    {
        $couponInfo = Coupon::whereIn('status', [0, 1])->orderBy("id", "desc");
        $search = !empty(Input::get("couponSearch")) ? Input::get("couponSearch") : '';
        $search_fields = ['coupon_name', 'coupon_code', 'min_order_amt', 'coupon_value', 'coupon_desc'];
        if (!empty(Input::get('couponSearch'))) {
            $couponInfo = $couponInfo->where(function ($query) use ($search_fields, $search) {
                foreach ($search_fields as $field) {
                    $query->orWhere($field, "like", "%$search%");
                }
            });
        }
        if (!empty(Input::get('couponSearch'))) {
            $couponInfo = $couponInfo->get();
            $couponCount = $couponInfo->count();
        } else {
            $couponInfo = $couponInfo->paginate(Config('constants.paginateNo'));
            $couponCount = $couponInfo->total();
        }

        $startIndex = 1;
        $getPerPageRecord = Config('constants.paginateNo');
        $allinput = Input::all();
        if(!empty($allinput) && !empty(Input::get('page')))
        {
            $getPageNumber = $allinput['page'];
            $startIndex = ( (($getPageNumber) * ($getPerPageRecord)) - $getPerPageRecord) + 1;
            $endIndex = (($startIndex+$getPerPageRecord) - 1);

            if($endIndex > $couponCount)
            {
                $endIndex = ($couponCount);
            }
        }
        else
        {
            $startIndex = 1;
            $endIndex = $getPerPageRecord;
            if($endIndex > $couponCount)
            {
                $endIndex = ($couponCount);
            }
        }
        //return view(Config('constants.adminCouponView') . '.index', compact('couponInfo'));
        $data = ['status' => '1', 'coupons' => $couponInfo, 'couponCount' => $couponCount, 'startIndex' => $startIndex,'endIndex' => $endIndex];
        $viewname = Config('constants.adminCouponView') . '.index';
        return Helper::returnView($viewname, $data);
    }

    public function add()
    {
        $coupon = new Coupon();
        $coupon->created_by = Session::get('loggedinAdminId');
        $coupon->updated_by = Session::get('loggedinAdminId');
        $products = Product::all();
        $userCoupon = DB::table("coupons_users")->get()->toArray();
        $action = route("admin.coupons.save");
        //return view(Config('constants.adminCouponView') . '.addEdit', compact('coupon', 'products', 'action'));
        $data = ['status' => '1', 'products' => $products, 'action' => $action, 'coupon' => $coupon, 'userCoupon' => $userCoupon];
        $viewname = Config('constants.adminCouponView') . '.addEdit';
        return Helper::returnView($viewname, $data);
    }

    public function addCoupon()
    {
        $coupon = new Coupon();
        $coupon->created_by = Session::get('loggedinAdminId');
        $coupon->updated_by = Session::get('loggedinAdminId');
        // $products = Product::all();

        $action = route("admin.coupons.save");
        //return view(Config('constants.adminCouponView') . '.addEdit', compact('coupon', 'products', 'action'));
        $data = ['action' => $action, 'coupon' => $coupon];
        $viewname = Config('constants.adminCouponView') . '.addEdit';
        return Helper::returnView($viewname, $data);
    }

    public function edit()
    {
        //Session::put('id',Input::get('id'));
        $coupon = Coupon::find(Input::get('id'));
        $coupon->updated_by = Session::get('loggedinAdminId');
        $products = Product::all();
        $userIds = DB::table("coupons_users")->pluck("user_id");
        $userCoupon = User::whereIn("id", $userIds)->get()->toArray();
        $orders = Order::where('coupon_used', Input::get('id'))->sortable()->where("orders.order_status", "!=", 0)->orderBy("id", "desc")->get();
        $action = route("admin.coupons.save");
//        return view(Config('constants.adminCouponView') . '.addEdit', compact('coupon', 'products', 'orders', 'action'));
        $data = ['status' => '1', 'products' => $products, 'action' => $action, 'coupon' => $coupon, 'orders' => $orders, 'userCoupon' => $userCoupon];
        //echo "<pre>";
        //print_r($data);
        $viewname = Config('constants.adminCouponView') . '.addEdit';
        return Helper::returnView($viewname, $data);
    }

    public function editCoupon()
    {

        $coupon = Coupon::find(Input::get('id'));
        $coupon->updated_by = Session::get('loggedinAdminId');
        $action = route("admin.coupons.save");
        return $data = ['action' => $action, 'coupon' => $coupon];
    }

    public function couponHistory()
    {
        /* Orders that used this coupon */
        $orders = Order::where('coupon_used', Input::get('id'))->sortable()->where("orders.order_status", "!=", 0)->orderBy("id", "desc");
        $orders = $orders->paginate(Config('constants.paginateNo'));
        return view(Config('constants.adminCouponView') . '.couponHistory', compact('orders'));
    }

    public function save()
    {
        $categoryIds = explode(",", Input::get('CategoryIds'));
        $productIds = explode(",", Input::get('ProductIds'));
        $couponNew = Coupon::findOrNew(Input::get('id'));
        $couponNew->coupon_name = Input::get('coupon_name');
        $couponNew->coupon_code = Input::get('coupon_code');
        $couponNew->discount_type = Input::get('discount_type');
        $couponNew->coupon_value = Input::get('coupon_value');
        $couponNew->min_order_amt = Input::get('min_order_amt');
        $couponNew->coupon_type = Input::get('coupon_type');
        $couponNew->restrict_to = Input::get('coupon_type');
        $couponNew->coupon_desc = Input::get('coupon_desc');
        $couponNew->no_times_allowed = Input::get('no_times_allowed');
        $couponNew->allowed_per_user = Input::get('allowed_per_user');
        $couponNew->max_discount_amt = Input::get('max_discount_amt');
        $couponNew->start_date = Input::get('start_date');
        $couponNew->end_date = Input::get('end_date') . ' 23:59:59';
        $couponNew->status = 1;
        $couponNew->store_id = Session::get('store_id');
//dd($couponNew);
        $couponNew->user_specific = Input::get('user_specific');
        if (Input::hasFile('c_image')) {
            $destinationPath = Config('constants.couponImgUploadPath') . "/";
            $fileName = date("dmYHis") . "." . Input::File('c_image')->getClientOriginalExtension();
            $upload_success = Input::File('c_image')->move($destinationPath, $fileName);
        } else {
            $fileName = (!empty(Input::get('c_image')) ? Input::get('c_image') : '');
        }

        $couponNew->coupon_image = $fileName;

        $couponNew->save();
        $allCats = [];

        // dd(Category::whereIn('id',Input::get('category_id'))->with('children')->get(['id']));
        if (!empty(Input::get('category_id'))) {
            if (Category::whereIn('id', Input::get('category_id'))->with('children')->count() > 0) {
                $childIds = Category::whereIn('id', Input::get('category_id'))->with('children')->get();

                foreach ($childIds as $child) {
                    array_push($allCats, $child->id);
                }
                foreach ($childIds[0]->children as $childId) {
                    array_push($allCats, $childId->id);
                }
            } else {
                $allCats = Category::whereIn('id', Input::get('category_id'))->get();
            }
        }
        if (!empty(Input::get('category_id'))) {
            $couponNew->categories()->sync($allCats);
        } else {
            $couponNew->categories()->detach();
        }

        if (!empty(Input::get('product_id'))) {
            $couponNew->products()->sync(Input::get('product_id'));
        } else {
            $couponNew->products()->detach();
        }

        if (!empty(Input::get('uid'))) {
            DB::table("coupons_users")->whereIn("user_id", Input::get('uid'))->where("c_id", $couponNew->id);
            foreach (Input::get('uid') as $key => $uid) {
                DB::table("coupons_users")->Insert(["user_id" => $uid, "c_id" => $couponNew->id]);
            }
            // $couponNew->userspecific()->sync(Input::get('uid'));
        } else {
            DB::table("coupons_users")->where("c_id", $couponNew->id)->delete();
        }

        if (Input::get('id') == '') {
            Session::flash('msg', 'Coupon added successfully.');
        } else {
            Session::flash('msg', 'Coupon updated successfully.');
        }

        $url = 'admin.coupons.view';
        $data = ['status' => '1', 'msg' => 'Coupon added/updated successfully.'];
        $viewname = '';
        return Helper::returnView($viewname, $data, $url);
//        return redirect()->back();
    }

    public function saveCoupon()
    {

        $couponNew = Coupon::findOrNew(Input::get('id'));
        $couponNew->coupon_name = Input::get('coupon_name');
        $couponNew->coupon_code = Input::get('coupon_code');
        $couponNew->discount_type = Input::get('discount_type');
        $couponNew->coupon_value = Input::get('coupon_value');
        $couponNew->min_order_amt = Input::get('min_order_amt');
        $couponNew->coupon_type = Input::get('coupon_type');
        $couponNew->restrict_to = Input::get('coupon_type');
        $couponNew->status = 1;
        $couponNew->no_times_allowed = Input::get('no_times_allowed');
        $couponNew->allowed_per_user = Input::get('allowed_per_user');
        $couponNew->start_date = Input::get('start_date');
        $couponNew->end_date = IInput::get('end_date') . ' 23:59:59';
        $couponNew->user_specific = Input::get('user_specific');
        $couponNew->store_id = Session::get('store_id');
        $couponNew->max_discount_amt = Input::get('max_discount_amt');
        $couponNew->save();
        Session::flash('', 'Coupon added/updated successfully.');
        $url = 'admin.coupons.view'; //redirect()->route('admin.coupons.view');
        $data = ['status' => '1', 'msg' => 'Coupon added/updated successfully'];
        $viewname = '';
        return Helper::returnView($viewname, $data, $url);
    }

    public function delete()
    {
        $coupon = Coupon::find(Input::get('id'));
        $getcount = Order::where("coupon_used", "=", Input::get('id'))->count();
        //dd($getcount);
        if ($getcount == 0) {
            $coupon->categories()->sync([]);
            $coupon->products()->sync([]);
            DB::table("coupons_users")->where("c_id", $coupon->id)->delete();
            // $coupon->userspecific()->sync([]);
            $coupon->delete();
            Session::flash('message', 'Coupon deleted successfully.');
            $data = ['status' => '1', "message" => "Coupon deleted successfully."];
        } else {
            Session::flash('message', 'Sorry, This coupon is part of a order. Delete the order first.');
            $data = ['status' => '0', "msg" => "Sorry, This coupon is part of a order. Delete the order first."];
        }

        $url = 'admin.coupons.view';
        $viewname = '';
        return Helper::returnView($viewname, $data, $url);
    }

    public function searchUser()
    {
        if ($_GET['term'] != "") {
            $data = User::where('store_id', Session::get('store_id'))->where("email", "like", "%" . $_GET['term'] . "%")
                ->select(DB::raw('id, email'))
                ->get();
        } else {
            $data = "";
        }

        echo json_encode($data);
    }

    public function checkExistingCode()
    {
        $code = Input::get('code');
        $coupon = Coupon::where('coupon_code', $code)->whereIn('status', [0, 1])->get();
        if (count($coupon) > 0) {
            return $data['msg'] = ['status' => 'success', 'msg' => 'Coupon Code is already exist'];
        } else {
            return 0;
        }
    }

    public function changeStatus()
    {
        if(!empty(Input::get('id')))
        {
            $attr = Coupon::find(Input::get('id'));
            if ($attr->status == 1) {
                $attrStatus = 0;
                $msg = "Coupon disabled successfully.";
                $attr->status = $attrStatus;
                $attr->update();
                //return redirect()->back()->with('message', $msg);
            } else if ($attr->status == 0) {
                $attrStatus = 1;
                $msg = "Coupon enabled successfully.";
                $attr->status = $attrStatus;
                $attr->update();
                //return redirect()->back()->with('msg', $msg);
            }
            $data = ['status' => '1', 'msg' => $msg];
    }
    else
    {
        $data = ['status' => '0', 'msg' => 'There is somthing wrong.'];
    }
    return $data;

}
}
