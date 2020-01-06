<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

use App\Library\Helper;

class OrderReturnAction extends Model
{
    protected $table = 'order_return_action';

    public function newQuery($excludeDeleted = true)
    {
        return parent::newQuery($excludeDeleted = true)
            ->where('store_id', Helper::getSettings()['store_id']);
    }
}
