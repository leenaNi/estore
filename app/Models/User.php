<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
  protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
      public function addresses() {
        return $this->hasMany('App\Models\Address', 'user_id', 'id')->orderBy('id', 'desc');
    }
    public function userCashback() {
        return $this->hasOne('App\Models\HasCashbackLoyalty', 'user_id');
    }

    public function store(){
        return $this->belongsTo('App\Models\Store', 'store_id');
    }
}
