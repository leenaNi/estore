<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Flags extends Model {
    
    protected $table = 'flags';
    
    public $timestamps = false;
    
protected $fillable = ['flag', 'value', 'desc'];
}
?>