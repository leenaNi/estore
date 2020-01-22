<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DistributorOrderStatus extends Model {


	protected $table = 'order_status';
	protected $fillable = ['id','order_status','status', 'store_id','sort_order'];
		
}
