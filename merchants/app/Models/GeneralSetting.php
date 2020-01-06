<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use App\Library\Helper;

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
    
    public function newQuery($excludeDeleted = true)
    {
        return parent::newQuery($excludeDeleted = true)
            ->where('store_id', Helper::getSettings()['store_id']);
    }

    public function industry() {
        return $this->hasMany('App\Models\HasIndustry', 'general_setting_id');
    }
    

}
