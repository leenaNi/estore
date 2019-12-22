<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\Library\Helper;

class Translation extends Model
{
    protected $table='translation';

    public function newQuery($excludeDeleted = true)
    {
        return parent::newQuery($excludeDeleted = true)
            ->where('store_id', Helper::getSettings()['store_id']);
    }
}
