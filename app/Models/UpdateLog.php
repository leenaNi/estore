<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UpdateLog extends Model{
    protected $table = 'update_log';
  
    public function backupFiles() {
        return $this->hasMany('App\Models\Backup', 'update_log_id');
    }

 
}
