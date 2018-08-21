<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class BankUser extends Authenticatable
{
    use Notifiable,EntrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'bank_users';
    protected $fillable = [
        'name', 'email', 'password',
    ];
    public $rules = [
        'name' => 'required',
        'email' => 'required|email',
       
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
    
    public function hasBank(){
        return $this->belongsTo('App\Models\Bank', 'bank_id');
    }
    
    
}
