<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model {

    protected $table = 'slider';
    protected $fillable = ['title', 'image', 'is_active', 'sub_title', 'link', 'sort_order', 'alt'];
    public $timestamps = false;
    
    public function type(){
        return $this->hasOne('App\Models\SliderMaster', 'id', 'slider_id');
    }

}
