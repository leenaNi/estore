<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Order;
use App\Models\GeneralSetting;
use App\Library\Helper;
use Session;
use Auth;

class UserRepository {

    public function findByUserNameOrCreate($userData, $providerName) {
       
        $checkLoyalty = GeneralSetting::where('url_key','loyalty')->first()->status;

        $checkReferral = GeneralSetting::where('url_key','referral')->first()->status;


        $user = User::where('provider_id', '=', $userData->id)->first();
        if (!$user) {
            $user = User::create([
                        'provider_id' => $userData->id,
                        'provider' => $providerName,
                        'firstname' => ($providerName == 'github') ? $userData->nickname : $userData->name,
                        'user_type' => 2,
                        'status' => 1,
                        'email' => isset($userData->email) ? $userData->email : '',
                        'profile' => $userData->avatar,
            ]);
            
            Helper::newUserInfo($user->id);
            
            
        }else{
             Helper::postLogin($user->id);
        }




        $this->checkIfUserNeedsUpdating($userData, $user);
        return $user;
    }

    public function checkIfUserNeedsUpdating($userData, $user) {
        $socialData = [
            'profile' => $userData->avatar,
            'email' => $userData->email,
            'firstname' => $userData->name,
            'user_type' => 2,
        ];
        $dbData = [
            'profile' => $user->avatar,
            'email' => $user->email,
            'firstname' => $user->name,
            'user_type' => 2,
        ];
        if (!empty(array_diff($socialData, $dbData))) {
            $user->profile = $userData->avatar;
            $user->email = $userData->email;
            $user->firstname = $userData->name;
            $user->user_type = 2;
            $user->status = 1;
            $user->save();
        }
    }

}
