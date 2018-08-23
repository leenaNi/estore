<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loyalty  extends Model{

 

    protected $table = 'loyalty';
    protected $fillable = ['group', 'min_order_amt','max_order_amt', 'percent'];

}
 