<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class AttributeSet extends Model {
    use Sortable;
    protected $table = 'attribute_sets';
    protected $fillable = ['attr_set'];
    public $sortable = ['id', 'attr_set'];
    public function attributes() {
        return $this->belongsToMany('App\Models\Attribute', 'has_attributes', 'attr_set', 'attr_id');
    }
    
     public function attributes_filter_yes() {
        return $this->belongsToMany('App\Models\Attribute', 'has_attributes', 'attr_set', 'attr_id')->where(['is_filterable' => '1'])->count();
    }
    
     public function attributes_filter_no() {
        return $this->belongsToMany('App\Models\Attribute', 'has_attributes', 'attr_set', 'attr_id')->where(['is_filterable' => '0'])->count();
    }
    
   
    

}
