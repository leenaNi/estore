<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaticPage extends Model
{
    protected $fillable = ['page_name', 'image','link','url_key', 'map_url','email_list','description','sort_order','is_menu', 'status'];
}
