<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VswipeSale extends Model {
    //
    protected $table = 'vswipe_sales';
    
    
    public function store(){
        
        return $this->belongsTo("App\Models\Store","store_id");
    }
    
}
