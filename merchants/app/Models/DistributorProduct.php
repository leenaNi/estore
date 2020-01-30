<?php

namespace App\Models;

use App\Library\Helper;
use Cviebrock\EloquentSluggable\Sluggable;
use Kyslik\ColumnSortable\Sortable;

class DistributorProduct extends \Eloquent
{

    use Sluggable,
    \Conner\Tagging\Taggable, Sortable;
    protected $table = 'products';

    public function sluggable()
    {
        return [
            'url_key' => [
                'source' => 'product',
                'separator' => '-',
                'includeTrashed' => true,
            ],
        ];
    }
    protected $fillable = ["base_qty", "stock", "cur", "product_code", "height", "width", "length", "weight", "min_price", "max_price", "height_cm", "width_cm", "breadth_cm", "height_inches", "width_inches", "breadth_inches", "height_feet", "width_feet", "breadth_feet", "unit_measure", "prod_type", "is_stock", "alias", "aq", "factor", "markup", "disc", "mrp", "sp", "savings", "art_cut", "add_desc", "meta_title", "meta_keys", "meta_desc", "is_cod", "is_crowd_funded", "target_date", "target_qty", "attr_set", "product", "is_individual", "is_avail", "stock", "short_desc", "long_desc", "url_key", "images", "price", "spl_price", "parent_prod_id", "status", "sort_order", "consumption_uom", "conversion", "barcode", "is_tax", "is_trending", "added_by", "updated_by"];

    public $sortable = ['id', 'product', 'product_code', 'price', 'prod_type', 'spl_price', 'stock'];

    public function categories()
    {
        return $this->belongsToMany('App\Models\Category', 'has_categories', 'prod_id', 'cat_id');
    }

    public function attributeset()
    {
        return $this->belongsTo('App\Models\AttributeSet', 'attr_set');
    }

    public function producttype()
    {
        return $this->belongsTo('App\Models\ProductType', 'prod_type', 'type_id');
    }

    public function attributes()
    {
        return $this->belongsToMany('App\Models\Attribute', 'has_options', 'prod_id', 'attr_id')->where('status', 1)->withPivot("id", "attr_val", "attr_type_id");
    }

    public function attributevalues()
    {
        return $this->belongsToMany('App\Models\AttributeValue', 'has_options', 'prod_id', 'attr_val')->withPivot("id", "attr_val", "attr_type_id", "attr_id");
    }

    public function relatedproducts()
    {
        return $this->belongsToMany('App\Models\DistributorProduct', 'has_related_prods', 'prod_id', 'related_prod_id');
    }

    public function upsellproducts()
    {
        return $this->belongsToMany('App\Models\DistributorProduct', 'has_upsell_prods', 'prod_id', 'upsell_prod_id');
    }

    public function parentproduct()
    {
        return $this->belongsTo('App\Models\DistributorProduct', 'parent_prod_id');
    }

    public function subproducts()
    {
        return $this->hasMany('App\Models\DistributorProduct', 'parent_prod_id')->where('status', 1);
    }

    public function getsubproducts()
    {
        return $this->hasMany('App\Models\DistributorProduct', 'parent_prod_id')->where('status', 1)->where("stock", ">", 0);
    }
    public function subproductsoutofstock()
    {
        return $this->hasMany('App\Models\DistributorProduct', 'parent_prod_id')->where('status', 1)->where("stock", "<=", 0);
    }
    public function subproductrunnigshort($stockLimit)
    {
        return $this->hasMany('App\Models\DistributorProduct', 'parent_prod_id')->where('status', 1)->whereBetween('stock', ['1', $stockLimit]);
    }
    public function comboproducts()
    {
        return $this->belongsToMany('App\Models\DistributorProduct', 'has_combo_prods', 'prod_id', 'combo_prod_id');
    }

    public function catalogimgs()
    {
        return $this->hasMany('App\Models\CatalogImage', 'catalog_id')->where('image_type', '=', '1')->orderBy("sort_order", "asc");
    }

    public function fabrics()
    {
        return $this->belongsToMany('App\Models\Fabric', 'has_fabrics', 'prod_id', 'fabric_id');
    }

    public function downlodableprods()
    {
        return $this->hasMany('App\Models\DownlodableProd', 'prod_id');
    }
    public function sales($storeId)
    {
        return $this->belongsToMany('App\Models\Order', 'has_products', 'prod_id', 'order_id')
            ->whereNotIn("has_products.order_status", [0, 4, 6, 10])->where("has_products.store_id", $storeId)
            ->withPivot("id", "sub_prod_id", "qty", "price", "created_at");
    }

    public function wishlist()
    {
        return $this->belongsToMany('App\Models\User', 'wishlist', 'prod_id', 'user_id');
    }

    public function product()
    {
        return $this->hasOne('App\Models\WishList', 'prod_id');
    }
    public function mainimg()
    {
        return $this->hasMany('App\Models\CatalogImage', 'catalog_id')->where('image_type', '=', '1')->orderBy("sort_order", "asc");
    }

//    public function getprod(){
    //        return $this->belongsTo('App\Models\HasProducts', 'has_products', 'prod_id', 'order_id');
    //    }
    //
    public function getorder()
    {
        return $this->hasOne('App\Models\Order', 'has_products', 'prod_id', 'order_id');
    }

    public function users()
    {
        return $this->belongsTo('App\Models\User', 'added_by');

    }

    public function updatedBy()
    {
        return $this->belongsTo('App\Models\User', 'updated_by');

    }

    public function buying_unit_measure()
    {
        return $this->belongsTo('App\Models\UnitMeasure', 'unit_measure');

    }

    public function consumption_unit_measure()
    {
        return $this->belongsTo('App\Models\UnitMeasure', 'consumption_uom');

    }

    public function texes()
    {
        return $this->belongsToMany('App\Models\Tax', 'product_has_taxes', 'product_id', 'tax_id');
    }

    public function totalTaxRate()
    {
        $tax_rate = 0;
        foreach ($this->texes as $tax) {
            $tax_rate = $tax_rate + $tax->rate;
        }

        return $tax_rate;
    }

    public function vendors()
    {
        return $this->belongsToMany('App\Models\User', 'has_vendors', 'prod_id', 'vendor_id');
    }

    public function vendorPriority()
    {
        return $this->belongsToMany('App\Models\User', 'has_vendors', 'prod_id', 'vendor_id')->where('has_vendors.status', 1)->orderBy('sort', 'ASC')->limit(1);
    }

    public function hasVendors()
    {
        return $this->hasMany('App\Models\HasVendors', 'prod_id')->orderBy('sort', 'ASC');
    }
}
