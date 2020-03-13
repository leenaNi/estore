<?php

namespace App\Models;

//use Laravel\Passport\HasApiTokens;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Zizaco\Entrust\Traits\EntrustUserTrait;
use Kyslik\ColumnSortable\Sortable;
use App\Library\Helper;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable,
        EntrustUserTrait,
        CanResetPassword,
        Sortable;
    // protected $connection = 'mysql';
    protected $table = 'users';
    protected $fillable = ['first_name', 'last_name', 'company_name', 'address', 'contact_no', 'alternate_no', 'email', 'password', 'provider_id','status' ,'provider', 'user_name', 'user_type'];
    protected $hidden = ['password', 'remember_token'];
    public $sortable = ['email'];

    public function newQuery($excludeDeleted = true)
    {
        return parent::newQuery($excludeDeleted = true)
            ->where('store_id', Helper::getSettings()['store_id']);
    }
    
    public function savedlist() {
        return $this->belongsToMany('App\Models\Product', 'saved_list', 'user_id', 'prod_id');
    }

    public function addresses() {
        return $this->hasMany('App\Models\Address', 'user_id', 'id')->orderBy('is_default_shipping', 'desc')->where('is_shipping',1);
    }

    public function billingaddresses() {
        return $this->hasMany('App\Models\Address', 'user_id', 'id')->orderBy('is_default_billing', 'desc')->where('is_billing',1);
    }

    public function orders() {
        return $this->hasMany('App\Models\Order', 'user_id')->whereIn("order_status", [1,2, 3]);
    }

    public function loyalty() {
        return $this->belongsTo('App\Models\Loyalty', 'loyalty_group');
    }

    public function roles() {
        return $this->belongsToMany('App\Models\Role', 'role_user', 'user_id', 'role_id');
    }
    

    public function wishlist() {
        return $this->belongsToMany('App\Models\Product', 'wishlist', 'user_id', 'prod_id');
    }

    public function wish() {
        return $this->hasMany('App\Models\WishList', 'user_id');
    }
  public function userCashback($id=null) {
        return $this->hasOne('App\Models\HasCashbackLoyalty', 'user_id')->where("store_id",env('STORE_ID'));
    }

    function hasOrder() {
        return $this->hasMany('App\Models\Order', 'user_id')->groupBy('user_id')->count();
    }

}
