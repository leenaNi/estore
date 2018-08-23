<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarketingEmailTemplates extends Model {

    protected $table = 'marketing_email_templates';
    
    public function users() {
        return $this->belongsToMany('App\Models\User', 'has_emails', 'group_id', 'user_id');
    }

}
