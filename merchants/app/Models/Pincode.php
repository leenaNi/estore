<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Library\Helper;

class Pincode extends Model
{
    protected $table = 'pincodes';

    public function newQuery($excludeDeleted = true)
    {
        return parent::newQuery($excludeDeleted = true)
            ->where('store_id', Helper::getSettings()['store_id']);
    }
    public function cities()
    {
        return $this->belongsTo('App\models\City', 'city_id');
    }

    public function seviceProvider()
    {
        return $this->belongsTo('App\Models\Courier', 'service_provider');
    }
}
