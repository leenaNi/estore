<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    protected $connection = 'mysql2';
    protected $fillable = ['name','status','pref'];
}
