<?php

namespace App\Http\Controllers\Admin;

use Route;
use Input;
use App\Models\CustomerReview;
use App\Models\Category;
use App\Library\Helper;
use App\Classes\UploadHandler;
use App\Http\Controllers\Controller;
use App\Models\CatalogImage;
use App\Models\Tax;
use App\Models\Product;
use App\Models\HasTaxes;
use App\Models\Sizechart; 
use Illuminate\Http\Request;
use DB;
use Session;
use Validator;

class ReviewController extends Controller
{
    public function index() {
         
        $customer_reviews = CustomerReview::select('products.product','customer_reviews.*')->
        join('products','customer_reviews.product_id','=','products.id')->where('customer_reviews.store_id', Helper::getSettings()['store_id'])
        ->orderBy("customer_reviews.id", "desc");

        if (!empty(Input::get('order_ids'))) {
            $mulIds = explode(",", Input::get('order_ids'));
            $customer_reviews = $customer_reviews->whereIn("customer_reviews.order_id", $mulIds);
        }
        if (!empty(Input::get('order_number_from'))) {
            $customer_reviews = $customer_reviews->where('customer_reviews.order_id', '>=', Input::get('order_number_from'));
        }
        if (!empty(Input::get('order_number_to'))) {
            $customer_reviews = $customer_reviews->where('customer_reviews.order_id', '<=', Input::get('order_number_to'));
        }
        // if (!empty(Input::get('date'))) {
        //     $dates = explode(' - ', Input::get('date'));
        //     $dates[0] = date("Y-m-d", strtotime($dates[0]));
        //     $dates[1] = date("Y-m-d 23:59:00", strtotime($dates[1]));
        //     $customer_reviews = $customer_reviews->whereBetween('customer_reviews.created_at', $dates);
        // }
        $customer_reviews = $customer_reviews->get();
        
        $viewname = Config('constants.adminCustReviewView') . '.index';
        $data = ['CustomerReviews' => $customer_reviews];
        return Helper::returnView($viewname, $data);
    }

    public function get_review(){

        $review_id = Input::get('id');
        $data = CustomerReview::where(['id'=>$review_id])->first();
        return $data;
    }

    public function ReviewStatus(){
    	$review_id = Input::get('id');
        $type = Input::get('type');
        $data = CustomerReview::where(['id'=>$review_id])->update(['publish'=>$type]);
        //return redirect('/catalog/reviews');
    }
}
