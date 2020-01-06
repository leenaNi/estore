<?php

namespace App\Models;

use Zizaco\Entrust\EntrustRole;
use App\Library\Helper;

class Role extends EntrustRole {
    
    public function newQuery($excludeDeleted = true)
    {
        return parent::newQuery($excludeDeleted = true)
            ->where('store_id', Helper::getSettings()['store_id']);
    }
}
