<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Session;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Vendor extends Model
{
       //protected $table = 'vendors';
       protected $table = 'distributor';

        public static function rules($id = null, $merge = []) {
            return array_merge(
                    [
                'business_name' => 'required',
                // 'firstname' => 'required',
                // 'email' => 'email|unique:merchants' . ($id ? ",email,$id" : ''),
                // 'phone' => 'required|numeric|unique:merchants' . ($id ? ",phone,$id" : '')
                'phone_no' => 'required|numeric'
                    ], $merge);
        }

          public $messages = [
            'business_name.required' => 'Company name is required.',
            // 'firstname.required' => 'Firstname is required.',
            // 'email.unique' => 'Email Id have been already taken!',
            'phone.required' => 'Phone is required',
            // 'phone.unique' => 'Phone number have been already taken',
            'phone.numeric' => 'Phone number should be valid'
        ];
        protected $fillable = [
            'firstname', 'lastname', 'email', 'phone', 'pan'
        ];
}
