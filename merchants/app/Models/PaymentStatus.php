<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentStatus extends Model {

    protected $connection = 'mysql2';
    protected $table = 'payment_status';
    protected $fillable = [];

}
