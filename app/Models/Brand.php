<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $table = "brand";
    public static function rules($id = null, $merge = []) {

        return array_merge(
                [
                    'name' => 'required',
                    'company_id' => 'required',
                    'industry_id' => 'required'
                ], $merge);
    }
    public $messages = [
        'name.required' => 'Name is required.',
        'company_id.required' => 'Company is required',
        'industry_id.required' => 'Industry  is required'
    ];
    protected $fillable = [
        'name', 'company_id', 'industry_id'
    ];
}
