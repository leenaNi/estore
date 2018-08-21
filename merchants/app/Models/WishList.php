<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class WishList extends Model {


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'wishlist';
   
     public function users() {
        return $this->belongsTo('App\Models\User');
    }
    

    public function getProducts($userId) {
        $products = WishList::join('users', 'users.id', '=', 'wishlist.user_id')
            ->join('products','products.id','=','wishlist.prod_id')
            ->where('wishlist.user_id','=',$userId)
            ->select('products.product','products.short_desc','products.price','users.id','products.id AS pro_id')->get();

        return $products;    
    }
}