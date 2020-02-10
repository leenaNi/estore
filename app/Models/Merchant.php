<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Session;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Merchant extends Authenticatable {

    protected $table = 'merchants';

    public static function rules($id = null, $merge = []) {

        return array_merge(
                [
            'company_name' => 'required',
            //'firstname' => 'required',
            //'email' => 'email|unique:merchants' . ($id ? ",email,$id" : ''),
            // 'phone' => 'required|numeric|unique:merchants' . ($id ? ",phone,$id" : '')
            'phone' => 'required|numeric'
                ], $merge);
    }

    public $messages = [
        // 'company_name.required' => 'Company name is required.',
        'firstname.required' => 'Firstname is required.',
        'email.unique' => 'Email Id have been already taken!',
        'phone.required' => 'Phone is required',
        // 'phone.unique' => 'Phone number have been already taken',
        'phone.numeric' => 'Phone number should be valid'
    ];
    protected $fillable = [
        'firstname', 'lastname', 'email', 'phone', 'pan'
    ];

    public function documents() {
        return $this->hasMany('App\Models\Document', 'parent_id')->where('doc_type', 1);
    }

    public function hasMarchants() {
        return $this->belongsToMany('App\Models\Bank', 'bank_has_merchants', 'merchant_id', 'bank_id')->withPivot('bank_id', 'merchant_id', 'added_by', 'updated_by', 'created_at', 'updated_at');
    }

    public function hasMerchants() {
        return $this->belongsToMany('App\Models\Bank', 'bank_has_merchants', 'merchant_id', 'bank_id')->withPivot('bank_id', 'merchant_id', 'added_by', 'updated_by', 'created_at', 'updated_at');
    }

    public function getstores() {
        return $this->hasMany("App\Models\Store", 'merchant_id')->where('store_type', 'merchant');
    }

}
