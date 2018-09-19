<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasCashbackLoyalty extends Model {

    protected $connection = 'mysql2';
    public $timestamps = false;
    protected $table = 'has_cashback_loyalty';
}
?>