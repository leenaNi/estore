<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasVendors extends Model
{
    protected $table = 'has_vendors';

    public $timestamps = false;

    public function product() {
        return $this->belongsTo('App\Models\Product', 'prod_id');
    }

    public function vendor() {
    	return $this->belongsTo('App\Models\User', 'vendor_id');	
    }
}

