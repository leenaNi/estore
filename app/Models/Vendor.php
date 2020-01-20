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
                  //'company_name' => 'required',
                  'firstname' => 'required',
                  'email' => 'email|unique:merchants' . ($id ? ",email,$id" : ''),
                  'phone' => 'required|numeric|unique:merchants' . ($id ? ",phone,$id" : '')
                      ], $merge);
          }
}
