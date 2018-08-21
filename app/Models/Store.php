<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Store extends Model {

    use Sluggable;

    protected $table = 'stores';
    protected $fillable = [
        'language_id', 'merchant_id', 'category_id', 'store_name', 'status', 'country_id', 'zone_id', 'city', 'pin', 'address', 'contact_firstname', 'contact_lastname', 'contact_email', 'contact_phone', 'tin', 'pan', 'aadhar', 'service_tax', 'service_tax_vat', 'ac_holder_name', 'bank_name', 'branch_name', 'ac_no', 'ifsc_code'
    ];

    public function documents() {
        return $this->hasMany('App\Models\Document', 'parent_id');
    }

    public function sluggable() {
        return [
            'url_key' => [
                'source' => 'store_name'
            ]
        ];
    }

    public function getmerchant() {
        return $this->belongsTo('App\Models\Merchant', 'merchant_id');
    }

    public function getdocuments() {
        return $this->hasMany('App\Models\Document', 'parent_id')->where('doc_type', 2);
    }

    public function storemerchant() {
        $this->hasMany('App\Models\Merchant', 'merchant_id');
    }

    public function sales() {
        return $this->hasMany('App\Models\VswipeSale', 'store_id');
    }

    public function getcategory() {

        return $this->belongsTo('App\Models\Category', 'category_id');
    }

    public function getlanguage() {
        return $this->belongsTo('App\Models\Language', 'language_id');
    }

}
