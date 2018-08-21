<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductHasTaxes extends Model
{
   protected $fillable = ['product_id','tax_id'];

   public $timestamps = false;
}
