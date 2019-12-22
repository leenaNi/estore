<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Library\Helper;

class Zone extends Model
{

    protected $table = 'zones';

    public $timestamps = false;

    public function country()
    {
        return $this->hasOne('App\Models\Country', 'country_id');
    }

}
