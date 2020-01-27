<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model {
    //
    protected $table = 'currencies';
    public static function rules($id = null, $merge = []) {

        return array_merge(
            [
                'name' => 'required',
                'currency_code' => 'required',
                'iso_code' => 'required',
                'currency_val' => 'required',
                'css_code' => 'required',
                'status' => 'required'
            ], $merge);
    }
    
}
