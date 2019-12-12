<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupHasContact extends Model
{
    protected $fillable = ['group_id','contact_id'];
}
