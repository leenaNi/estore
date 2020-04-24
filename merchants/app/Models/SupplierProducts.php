<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class SupplierProducts extends Model
{
    protected $table = 'supplier_products';

     protected $fillable = ["store_prod_id"];
}
