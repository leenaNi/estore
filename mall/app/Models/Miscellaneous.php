<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Miscellaneous extends Model {

    use Sluggable;

    protected $table = 'settings';

    public function sluggable() {
        return [
            'url_key' => [
                'source' => 'name',
                'separator' => '-',
                'includeTrashed' => true,
            ]
        ];
    }

    protected $fillable = ['name', 'value', 'url_key'];

}
