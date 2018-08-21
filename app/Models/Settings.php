<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model {

    protected $table = 'settings';

    public static function rules($id = null, $merge = []) {
        return array_merge(
                [
            'logo' => 'required',
            'primary_color' => 'required',
            'secondary_color' => 'required',
            'language_id' => 'required',
            'currency_id' => 'required'
                ], $merge);
    }

    public function store_language() {
        return $this->hasOne('App\Models\Language', 'id', 'language_id');
    }

    public function store_currency() {
        return $this->hasOne('App\Models\Currency', 'id', 'currency_id');
    }

}
