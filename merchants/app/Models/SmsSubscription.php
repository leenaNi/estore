<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Library\Helper;

class SmsSubscription extends Model
{
    //
    protected $table ='sms_subscription';
    
     public function users() {
        return $this->belongsTo("App\Models\User", "purchased_by");
    }
}
