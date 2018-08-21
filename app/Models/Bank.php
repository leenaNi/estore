<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model {

    protected $table = 'banks';

    public static function rules($id = null, $merge = []) {
        return array_merge(
                [
            'name' => 'required',
            'branch' => 'required',
            'contact_firstname' => 'required',
            'contact_lastname' => 'required',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|numeric',
            'email' => 'required|email|unique:banks' . ($id ? ",email,$id" : ''),
            'phone' => 'required|numeric|unique:banks' . ($id ? ",phone,$id" : '')
                ], $merge);
    }

    protected $fillable = [
        'name', 'branch', 'email', 'phone', 'password', 'contact_firstname', 'contact_lastname', 'contact_email',
        'contact_phone'
    ];
    
     public function documents() {
        return $this->hasMany('App\Models\Document', 'parent_id')->where('doc_type',3);
    }
    
    
    public function has_marchants() {
        return $this->belongsToMany('App\Models\Merchant', 'bank_has_merchants','bank_id','merchant_id');
    }
    
      public function has_merchants() {
        return $this->belongsToMany('App\Models\Merchant', 'bank_has_merchants','bank_id','merchant_id');
    }
    
}
