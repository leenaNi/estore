<?php

namespace App\Models;

use Zizaco\Entrust\EntrustPermission;

class Permission extends EntrustPermission {

    public function childPermissions(){
    	return $this->hasMany('App\Models\Permission','parent_id');
    }
}
