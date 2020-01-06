<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\Library\Helper;

class OrderReturnReason extends Model
{
    protected $connection = 'mysql2';
    protected $table = 'order_return_reason';
    public function newQuery($excludeDeleted = true)
    {
        return parent::newQuery($excludeDeleted = true)
            ->where('store_id', Helper::getSettings()['store_id']);
    }
}
