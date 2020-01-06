<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class OrderReturnReason extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'order_return_reason';
}
