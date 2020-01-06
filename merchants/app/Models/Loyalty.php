<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Library\Helper;

class Loyalty  extends Model{

    protected $table = 'loyalty';
    protected $fillable = ['group', 'min_order_amt','max_order_amt', 'percent', 'store_id'];

    public function newQuery($excludeDeleted = true)
    {
        return parent::newQuery($excludeDeleted = true)
            ->where('store_id', Helper::getSettings()['store_id']);
    }

}
 