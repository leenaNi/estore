<?php namespace App;
// AuthenticateUser.php 
use Illuminate\Contracts\Auth\Guard; 
use Laravel\Socialite\Contracts\Factory as Socialite; 
use App\Repositories\UserRepository; 
use App\Models\Merchant;
use Request; 
use Auth;
use Route;

class AuthenticateUser {     

     private $socialite;
     private $auth;
     private $users;

     public function __construct(Socialite $socialite, Guard $auth, UserRepository $users) {   
        $this->socialite = $socialite;
        $this->users = $users;
        dd($auth);
        $this->auth = $auth;
    }

    public function execute($request, $listener, $provider) {
        
        
       
        
        $providerName = $provider;
      
       if (!$request) return $this->getAuthorizationFirst($provider);
       $socialUser = $this->getSocialUser($provider);
     
       $chkUser = Merchant::where('email',$socialUser->email)->first();
    
       // if(empty($chkUser)){
            $user = $this->users->findByUserNameOrCreate($socialUser, $providerName);
       // }
        //else{
       //     return redirect()->route('loginUser')->with('loginError', "This email id already exists!");
       // }

       $this->auth->login($user, true);

       return $listener->userHasLoggedIn($user,$providerName);
    }

    private function getAuthorizationFirst($provider) { 
        return $this->socialite->driver($provider)->redirect();
    }

    private function getSocialUser($provider) {
          
        return $this->socialite->driver($provider)->user();
    }
}