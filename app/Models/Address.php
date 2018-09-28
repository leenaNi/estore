<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
  
    protected $table = 'has_addresses';

    public function users() {
        return $this->belongsTo('User', 'user_id');
    }

    public function country() {
        return $this->belongsTo('App\Models\Country', 'country_id');
    }

    public function zone() {
        return $this->belongsTo('App\Models\Zone', 'zone_id');
    }

}
