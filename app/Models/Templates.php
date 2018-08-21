<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Templates extends Model {
    
    protected $table = 'vswipe_templates';
    public function schema(){
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}
