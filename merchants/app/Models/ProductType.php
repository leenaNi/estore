<?php 
namespace App\Models;

use App\Library\Helper;
use Illuminate\Database\Eloquent\Model;

class ProductType extends Model {

	protected $table = 'product_types';
	protected $fillable = [];

	public function newQuery($excludeDeleted = true)
    {
        return parent::newQuery($excludeDeleted = true)
            ->where('store_id', Helper::getSettings()['store_id']);
    }
	
}
