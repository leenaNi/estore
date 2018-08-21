<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreTheme extends Model {

    protected $table = 'themes';
   public static function rules($id = null, $merge = []) {
        return array_merge(
                [
            'status' => 'required',
            'cat_id' => 'required']);
                    
    }

    public $messages = [
        'status.required' => 'Status is required.',
        'cat_id.required' => 'Category is required.']
   ;
    protected $fillable = [
        'name', 'status', 'cat_id','added_by','theme_type','sort_orders',
    ];
    
    
    public function category() {
        return $this->belongsTo('App\Models\Category', 'cat_id');
    }
    
//    public function themes(){
//        return $this->hasMany("App\Models\StoreTheme","cat_id");
//    }

}
