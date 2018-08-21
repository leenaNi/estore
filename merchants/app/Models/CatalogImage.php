<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatalogImage extends Model {

    protected $table = 'catalog_images';
    protected $fillable = ['filename','alt_text','image_type','image_mode','sort_order'];

   

}
