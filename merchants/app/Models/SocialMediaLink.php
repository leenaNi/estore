<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialMediaLink extends Model
{
    protected $fillable = ['media', 'link', 'image', 'status','sort_order'];
}
