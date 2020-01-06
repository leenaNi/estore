<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Library\Helper;

class StaticPage extends Model
{
    protected $fillable = ['page_name', 'image','link','url_key', 'map_url','email_list','description','sort_order','is_menu', 'status'];
    
    public function newQuery($excludeDeleted = true)
    {
        return parent::newQuery($excludeDeleted = true)
            ->where('store_id', Helper::getSettings()['store_id']);
    }
}
