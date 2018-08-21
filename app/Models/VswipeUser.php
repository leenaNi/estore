<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class VswipeUser extends Authenticatable {

    use Notifiable,
        EntrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'vswipe_users';
    protected $fillable = [
        'name', 'email', 'password',
    ];
    public $rules = [
        'name' => 'required',
        'email' => 'required|email',
      //  'password' => 'required',
        'roles' => 'required'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

}
