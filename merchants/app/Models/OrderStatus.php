<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Library\Helper;

class OrderStatus extends Model {


	protected $table = 'order_status';
	protected $fillable = ['id','order_status','status', 'store_id','sort_order', 'color'];

	public function newQuery($excludeDeleted = true)
    {
        return parent::newQuery($excludeDeleted = true)
            ->where('store_id', Helper::getSettings()['store_id']);
	}
		
}
