<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Library\Helper;

class Flags extends Model {
    
    protected $table = 'flags';
    
    public $timestamps = false;
    
    protected $fillable = ['flag', 'value', 'desc', 'store_id'];

    public function newQuery($excludeDeleted = true)
    {
        return parent::newQuery($excludeDeleted = true)
            ->where('store_id', Helper::getSettings()['store_id']);
    }
}
?>