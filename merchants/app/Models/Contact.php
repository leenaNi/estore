<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contacts';
    protected $fillable = ['phone_no', 'email', 'address', 'status'];
    public function newQuery($excludeDeleted = true)
    {
        return parent::newQuery($excludeDeleted = true)
            ->where('store_id', Helper::getSettings()['store_id']);
    }
}
