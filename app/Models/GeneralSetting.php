<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model {

    protected $table = 'general_setting';

    public function industry() {
        return $this->hasMany('App\Models\HasIndustry', 'general_setting_id');
    }
    

}
