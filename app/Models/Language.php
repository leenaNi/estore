<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model {

    protected $table = 'languages';
    public $rules = [
        'name' => 'required',
        'status' => 'required',
    ];
    protected $fillable = [
        'name', 'status', 'added_by'
    ];

}
