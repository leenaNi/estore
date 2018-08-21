<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model {

    use Sluggable;

    protected $table = 'general_setting';
    
    public function sluggable() {
        return [
            'url_key' => [
                'source' => 'name',
                'separator' => '-',
                'includeTrashed' => true,
            ]
        ];
    }
    
    public function industry() {
        return $this->hasMany('App\Models\HasIndustry', 'general_setting_id');
    }
    

}
