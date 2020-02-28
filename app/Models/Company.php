<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = "company";

    public static function rules($id = null, $merge = [])
    {

        return array_merge(
            [
                'name' => 'required',
                // 'address' => 'required',
                // 'contact_person_name' => 'required',
                // 'contact_person_number' => 'required|numeric'
            ], $merge);
    }
    public $messages = [
        'name.required' => 'Name is required.',
        // 'address.required' => 'Address is required',
        // 'contact_person_name.required' => 'Person name is required',
        // 'contact_person_number.required' => 'Phone number is required',
        // 'contact_person_number.numeric' => 'Phone number should be valid'
    ];
    protected $fillable = [
        'name', 'address', 'contact_person_name', 'contact_person_number',
    ];
}
