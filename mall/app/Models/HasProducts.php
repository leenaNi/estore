<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasProducts extends Model {

    protected $table = 'has_products';

    public function proforma() {
        return $this->belongsTo('App\Models\Proforma', 'proforma_invoice_id');
    }

    public function product() {
        return $this->belongsTo('App\Models\Product', 'prod_id');
    }

    public function categories() {
        return $this->belongsToMany('App\Models\Category', 'has_categories', 'prod_id', 'cat_id');
    }
    
    public function orderDetails() {
        return $this->belongsTo('App\Models\Order', 'order_id');
    }
   public function orderstatus() {

        return $this->belongsTo("App\Models\OrderStatus", "order_status");
    }
    
    public function getStore() {

        return $this->belongsTo("App\Models\Stores", "store_id");
    } 
    public function consignment() {

        return $this->belongsTo('App\Models\Consignment', 'consignment_id');
    }

    public function prodstatus() {

        return $this->belongsTo('App\Models\ProdStatus', 'status');
    }
    
    public function warehouse(){
        
        return $this->belongsTo('App\Models\Warehouse','warehouse_id');
    }
    

    public function forwarder() {
        return $this->belongsTo('App\Models\User', 'forwarder_id');
    }
    
    public function getspecifications(){
        
        return $this->belongsTo('App\Models\ProjectSpecification','allocated');
    }
    
    
    public function getfabric(){
        
        return $this->belongsTo('App\Models\Fabric','finish_id');
    }
    
    public function getOrderss(){
         return $this->belongsToMany('App\Models\order', 'has_products', 'prod_id', 'order_id');
    }
    
    public function getProduct(){
         return $this->belongsTo('App\Models\Product',  'prod_id')->select('eCount','id');
    }
    
    public function subProduct(){
        return $this->belongsTo('App\Models\Product','sub_prod_id','id');
    }

}
