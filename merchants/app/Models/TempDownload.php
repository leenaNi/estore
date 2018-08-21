<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class TempDownload extends Model
{
    protected $table = 'tempDownload';
    
    function productBelong(){
        return $this->belongsTo('App\Models\DownlodableProd','product_id','prod_id');
    }
}
