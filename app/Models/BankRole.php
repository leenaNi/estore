<?php namespace App\Models;

use Zizaco\Entrust\EntrustRole;

class BankRole extends EntrustRole
{
      protected $table = 'bank_roles';
   public $rules = [
        'display_name' => 'required',
        'description' => 'required',
        'name' => 'required'
    ];
   
   
   public function bankusers(){
    //   dd($this->getbankid());
       return $this->belongsToMany("App\Models\BankUser","bank_role_user","bank_role_id","bank_user_id");
       
   }
   
    
}