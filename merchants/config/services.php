<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'mandrill' => [
        'secret' =>'JqW91rBbJHiIViUddFjuFA',//env('MANDRILL_SECRET'),
    ],

    'ses' => [
        'key'    => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'stripe' => [
        'model'  => App\Models\User::class,
        'key'    => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
//    
//    'facebook' => [
//    'client_id' => '377986305899287',
//    'client_secret' => '08072f63e31984c58b807c07ceb41038',
//    'redirect' => 'http://dev.cartini.online/login/facebook',
        
//            'facebook' => [
//    'client_id' => '1117556051720052',
//    'client_secret' => 'b167c0d839b973181ece5a697892fa9d',
//    'redirect' => 'https://veeblock.com/',
//],
//    
'facebook' => [
    'client_id' => env('FACEBOOK_CLIENT_ID'),
    'client_secret' =>  env('FACEBOOK_CLIENT_SECRET'),
    'redirect' => env('FACEBOOK_CALLBACK_URL'),
],
    
  'twitter' => [
    'client_id' => '51VdjvGv0SQh5bBrej0XF5k7I',
    'client_secret' => 'sAZzHxq3djG0s7GJH3tHM2Wp34B6OB08GhjkmzivUN5bLUOQTF',
    'redirect' => 'http://dev.cartini.online/login/twitter',
],
    
  'google' => [
    'client_id' => '450926597027-kmocnmfok0cld8skep4pfonhddssr4e1.apps.googleusercontent.com',
    'client_secret' => '_EeJbXu-hM4FzOTQKDoViZij',
    'redirect' => 'http://dev.cartini.online/login/google',
],
    
    
    
    'github' => [
    'client_id' => '139679a8685b767be0c0',
    'client_secret' => '9ea26c3e5cb18f7055343ebeaad288322b1c5022',
    'redirect' => 'http://dev.cartini.online/login/github',
],
    
      'pinterest' => [
    'client_id' => '4815079795889023993',
    'client_secret' => '8efc643d37eebd24fb246335cc5e40732dbce082cfd05c2be3f63e24772e1b88',
    'redirect' => 'http://dev.cartini.online/login/pinterest',
],
    
    
    
    
   

];
