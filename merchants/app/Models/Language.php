<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\Library\
Helper;
class Language extends Model
{
    protected $table='language';

    public function newQuery($excludeDeleted = true)
    {
        return parent::newQuery($excludeDeleted = true)
            ->where('store_id', Helper::getSettings()['store_id']);
    }
}
