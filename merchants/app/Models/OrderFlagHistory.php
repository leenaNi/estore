<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderFlagHistory extends Model {
    
    protected $table = 'order_flag_history';
    
    public function getFlag() {
        return $this->belongsTo('App\Models\Flags', 'flag_id');
    }
}
?>