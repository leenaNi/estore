<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class Order extends Model {

    use Sortable;
    protected $connection = 'mysql2';
    protected $table = 'orders';
    protected $guarded = array('id');
    //protected $fillable = ['id', 'user_id', 'order_amt', 'pay_amt', 'cod_charges', 'gifting_charges' , 'payment_method', 'payment_status', 'description', 'cart', 'cashback_used', 'cashback_earned', 'cashback_credited', 'voucher_used', 'coupon_used', 'shipping_amt', 'voucher_amt_used', 'coupon_amt_used', 'shiplabel_tracking_id', 'referal_code_used', 'referal_code_amt', 'user_ref_points', 'ref_flag', 'order_status', 'ship_date', 'order_comment', 'first_name', 'last_name', 'address1', 'address2', 'address3', 'phone_no', 'country_id', 'zone_id', 'postal_code', 'city'];
    public $sortable = ['id', 'pay_amt', 'payment_status'];

    public function projectspecifications() {
        return $this->hasMany('App\Models\ProjectSpecification', 'order_id');
    }
    
     public function kots() {
        return $this->hasMany('App\Models\Kot', 'order_id');
    }

    public function products() {
        return $this->belongsToMany('App\Models\Product', 'has_products', 'order_id', 'prod_id')->withPivot("id", "order_id", "prod_id", "sub_prod_id", "qty", "qty_returned", "price", "product_details", "amt_after_discount");
    }

    public function users() {

        return $this->belongsTo("App\Models\User", "user_id");
    }

    public function client() {

        return $this->belongsTo("App\Models\User", "client");
    }

    public function type() {

        return $this->belongsTo("App\Models\OrderType", "otype");
    }

    public function architect() {
        return $this->belongsTo("App\Models\User", "architect");
    }

    public function associate() {

        return $this->belongsTo("App\Models\User", "associate");
    }

    public function paymentmethod() {
        return $this->belongsTo("App\Models\PaymentMethod", "payment_method");
    }

    public function paymentstatus() {
        return $this->belongsTo("App\Models\PaymentStatus", "payment_status");
    }

    public function orderstatus() {

        return $this->belongsTo("App\Models\OrderStatus", "order_status");
    }

    public function coordinator() {

        return $this->belongsTo("App\Models\User", "cordinator");
    }

    public function orderflag() {
        return $this->belongsTo('App\Models\Flags', 'flag_id');
    }

    public function orderFlagHist() {
        return $this->hasMany('App\Models\OrderFlagHistory', 'order_id');
    }

    public function orderStatHist() {
        return $this->hasMany('App\Models\OrderStatusHistory', 'order_id');
    }

    public function country() {
        return $this->belongsTo('App\Models\Country', 'country_id')->select('countries.id', 'name');
    }

    public function zone() {
        return $this->belongsTo('App\Models\Zone', 'zone_id')->select('zones.id', 'name');
    }

    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id')->select('users.id', 'firstname', 'lastname', 'email', 'telephone');
    }

    public function currency() {
        return $this->belongsTo('App\Models\HasCurrency', 'currency_id');
    }
    
       public function kot() {
        return $this->belongsToMany('App\Models\Kot', 'has_products', 'order_id', 'kot')->withPivot("id", "order_id", "prod_id", "sub_prod_id", "qty", "qty_returned", "price", "product_details", "amt_after_discount","kot");
    }
     public function table() {
        return $this->belongsTo('App\Models\Table', 'table_id');
    }
    public function hasManyProd(){
        return $this->hasMany('App\Models\HasProducts', 'order_id');
    }
    
    public function orderHistory() {
        return $this->hasMany('App\Models\OrderHistory', 'order_id')->orderBy('created_at','DESC');
    }
    
    public function getcourier(){
        return $this->belongsTo('App\Models\Courier','courier');
    }
       public function coupon() {
        return $this->belongsTo('App\Models\Coupon', 'coupon_used');
       }

}
