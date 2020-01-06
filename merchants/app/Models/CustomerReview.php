<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use App\Library\Helper;

class CustomerReview extends Model
{
	use Sortable;
    protected $table = 'customer_reviews';
    protected $fillable = ['user_id', 'order_id', 'product_id', 'title', 'description', 'rating', 'publish','store_id', 'created_at', 'updated_at'];
    //public $sortable = ['id', 'user_id'];

    // public function newQuery($excludeDeleted = true)
    // {
    //     return parent::newQuery($excludeDeleted = true)
    //         ->where('store_id', Helper::getSettings()['store_id']);
    // }

    // public function reviewproduct()
    // {
    //     return $this->belongsTo('App\Models\Product');
    // }
}
