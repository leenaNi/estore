<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'themes';
    protected $fillable = [ 'cat_id', 'theme_category', 'name', 'status', 'image', 'added_by', 'banner_image', 'theme_type', 'sort_orders'];
}
