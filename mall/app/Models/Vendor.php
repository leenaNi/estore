<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    //
    protected $fillable = ['vendor_name','email','fname_contact','lname_contact','currency','account_no', 'phone_no','fax','mobile','toll_free','website','country','state','address_line_1','address_line_2','city','zip'];
}
