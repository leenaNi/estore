<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tax extends Model {

    protected $table = 'tax';

    protected $fillable = ["name", "label", "rate", "tax_number", "status"];    

}
