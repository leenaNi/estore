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
        join('products','customer_reviews.product_id','=','products.id')
        ->orderBy("customer_reviews.id", "desc")->get();
        
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
