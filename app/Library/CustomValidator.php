<?php

namespace App\Library;

class CustomValidator
{

    public static function validatePhone($phone)
    {
        if (preg_match('/^[0-9]{10}+$/', $phone)) {
            return 1;
        } else {
            return 0;
        }
	}
	
	public static function validateNumber($data)
	{
		return preg_match('/^([0-9]*)$/', $data);
	}
}
