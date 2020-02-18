<?php

namespace App\Models;

class Attribute extends \Eloquent {

    protected $table = 'attributes';

    public function attributesets() {
        return $this->belongsToMany('App\Models\AttributeSet', 'has_attributes', 'attr_id', 'attr_set');
    }

    public function attributeoptions() {
        return $this->hasMany('App\Models\AttributeValue', 'attr_id')->orderBy('sort_order');
    }

    public function attributevalues() {
        return $this->belongsToMany('App\Models\AttributeValue', 'has_options', 'attr_id', 'attr_val')->distinct('attribute_values.id');
    }

}
