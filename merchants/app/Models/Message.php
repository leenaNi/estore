<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [ 'title', 'content', 'status', 'created_at', 'updated_at'];
}
