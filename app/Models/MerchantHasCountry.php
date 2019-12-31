<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MerchantHasCountry extends Model
{
    protected $table = 'merchant_has_countries';
    protected $fillable = ['merchant_id', 'country_id'];

    

}
