<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentHistory extends Model {

    protected $connection = 'mysql';
    protected $table = 'payment_history';
    protected $fillable = [];

}
