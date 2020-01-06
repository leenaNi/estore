<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerReview extends Model
{
    protected $fillable = ['user_id', 'order_id', 'product_id', 'title', 'description', 'rating', 'publish', 'created_at', 'updated_at'];
}
