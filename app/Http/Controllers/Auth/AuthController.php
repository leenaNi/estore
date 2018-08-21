<?php

namespace App\Http\Controllers\Auth;

use App\Model\Merchant;
use App\AuthenticateUser;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
//use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Request;
use Session;
use Illuminate\Support\Facades\Crypt;

class AuthController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Registration & Login Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles the registration of new users, as well as the
      | authentication of existing users. By default, this controller uses
      | a simple trait to add these behaviors. Why don't you explore it?
      |
     */

//use AuthenticatesAndRegistersUsers,
//    ThrottlesLogins;

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct() {
        //dd('fgdfg');
        $this->middleware('guest', ['except' => 'getLogout']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {
        return Validator::make($data, [
                    'name' => 'required|max:255',
                    'email' => 'required|email|max:255|unique:users',
                    'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    public function userHasLoggedIn($user) {
        //dd("sdf");
        $name = $user->first_name;
        // Session::flash('message', 'Welcome, ' . $user->$name);
        // return redirect()->route('myProfile');
        if (!empty(Session::get("returnURL")))
            return redirect()->to(Session::get("returnURL"));
        else
            return redirect()->route('myProfile');
    }

    protected function create(array $data) {
        return User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => bcrypt($data['password']),
        ]);
    }
    
//    public function login(){
//     dd("sdfg");   
//    }

    public function login(AuthenticateUser $authenticateUser, Request $request,  $provider = null, $from = null) {
     
        dd('fdfg');
        if ($from) {
            $url = Crypt::decrypt($from);
            Session::put("returnURL", $url);
        }
       
        //  return $authenticateUser->execute(Request::has('oauth_token'), $this, $provider);
        return $authenticateUser->execute(Request::all(), $this, $provider);
    }

}
