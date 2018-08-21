<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model {
    public $timestamps = false;
    public function schema(){
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }
}
