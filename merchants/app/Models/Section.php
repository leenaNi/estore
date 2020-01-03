<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Library\Helper;

class Section extends Model
{

    protected $fillable = ['name','status'];

    public function newQuery($excludeDeleted = true)
    {
        return parent::newQuery($excludeDeleted = true)
            ->where('store_id', 0); //Helper::getSettings()['store_id']);
    }

    public function permissions(){
        return $this->hasMany('App\Models\Permission','section_id')->where('parent_id',0);
    }

}
