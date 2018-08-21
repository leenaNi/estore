<?php

namespace App\Models;

use Zizaco\Entrust\EntrustRole;

class VswipeRole extends EntrustRole {

    protected $table = 'vswipe_roles';
    public $rules = [
        'display_name' => 'required',
        'description' => 'required',
        'name' => 'required'
    ];
    
    

}
