<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderStatusHistory extends Model {

    protected $table = 'order_status_history';
    protected $fillable = ['order_id','status_id','status_id','remark','notify'];
    
    public function getStatus() {
        return $this->belongsTo('App\Models\OrderStatus', 'status_id');
    }

}
