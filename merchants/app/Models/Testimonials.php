<?php

namespace App\Models;

use App\Library\Helper;
use Illuminate\Database\Eloquent\Model;

class Testimonials extends Model
{
    protected $table = 'testimonials';

    public function newQuery($excludeDeleted = true)
    {
        return parent::newQuery($excludeDeleted = true)
            ->where('store_id', Helper::getSettings()['store_id']);
    }

    public function users()
    {
        return $this->belongsTo('App\Models\User', "user_id");
    }
}
