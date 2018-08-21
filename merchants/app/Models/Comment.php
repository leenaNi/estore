<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model {  
    protected $table = 'comments';       
    public function getstatus(){
        return $this->belongsTo("OrderStatus","status_id");        
    }   
}
