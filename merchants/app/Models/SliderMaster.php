<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\Library\Helper;

class SliderMaster extends Model
{
    protected $table = 'slider_master';

    public function newQuery($excludeDeleted = true)
    {
        return parent::newQuery($excludeDeleted = true)
            ->where('store_id', Helper::getSettings()['store_id']);
    }
}
