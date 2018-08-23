<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasEmails extends Model {

    protected $table = 'has_emails';
//    public $timestamps = false;

    public function users() {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function group() {
        return $this->belongsTo('App\Models\MarketingEmailsGroup', 'group_id');
    }

}
