<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {

    protected $table = 'categories';
    public $rules = [
        'category' => 'required',
        'status' => 'required',
    ];
    protected $fillable = [
        'category', 'status','categories','attribute_sets','attributes','attribute_values'
    ];
    
    
    public function stores(){
        
     $this->hasMany("App\Models\Store",'category_id');   
    }
 public function themes(){
        
     $this->hasMany("App\Models\StoreTheme",'cat_id');   
    }

}
