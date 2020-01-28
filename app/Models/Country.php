<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Country extends Model{
    protected $table = 'countries';

    public static function rules($id = null, $merge = []) {

        return array_merge(
            [
                'name' => 'required',
                'country_code' => 'required',
                'iso_code_2' => 'required',
                'iso_code_3' => 'required',
                'postcode_required' => 'required',
                'status' => 'required'
            ], $merge);
    }
 
}
