<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class HasCurrency extends Model
{
    protected $connection = 'mysql2';
    protected $table = "has_currency";
}
