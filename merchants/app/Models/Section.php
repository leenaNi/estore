<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{

    protected $fillable = ['name','status'];

    public function permissions(){
        return $this->hasMany('App\Models\Permission','section_id')->where('parent_id',0);
    }

}
