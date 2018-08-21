<?php namespace App\Models;

use Zizaco\Entrust\EntrustPermission;

class BankPermission extends EntrustPermission
{
     protected $table = 'bank_permissions';
}