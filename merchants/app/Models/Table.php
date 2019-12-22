<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use App\Library\Helper;

class Table extends Model
{
    protected $table='restaurant_tables';
    protected $guarded = [];
    
    public function newQuery($excludeDeleted = true)
    {
        return parent::newQuery($excludeDeleted = true)
            ->where('store_id', Helper::getSettings()['store_id']);
    }
    
    public function tablestatus() {
        return $this->belongsTo('App\Models\TableStatus', 'ostatus');
    }
    
    public function orders(){
          return $this->hasMany('App\Models\Order', 'table_id');
    }
    
}
