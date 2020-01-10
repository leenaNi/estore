<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'merchants';

    protected $fillable = ['password', 'id'];
}
