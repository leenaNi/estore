
<ul class="nav nav-tabs" role="tablist">
    <li class="{{ in_array(Route::currentRouteName(),['admin.products.general.info']) ? 'active' : '' }}"><a href="{!! route('admin.products.general.info',['id'=>$id]) !!}"   aria-expanded="false">General Info <span class="badge badge-sm m-l-xs"></span></a></li>
    <li class="{{ in_array(Route::currentRouteName(),['admin.products.edit.category']) ? 'active' : '' }}"><a href="{!! route('admin.products.edit.category',['id'=>$id]) !!}"  aria-expanded="false">Category</a></li>


    <li class="{{ in_array(Route::currentRouteName(),['admin.products.images']) ? 'active' : '' }}"><a href="{!! route('admin.products.images',['id'=>$id]) !!}"  aria-expanded="false">Images</a></li>

    <?php

  

   // $attr =   App\Models\AttributeSet::find(App\Models\Product::find($id)->attr_set)->attributes()->where('is_filtrable',0)->count();
   // dd($attr);&& $attr !=0
   ?>
    @if(($prod_type == 1 || $prod_type == 7 || $prod_type == 3 || $prod_type == 8) )

    <li class="{{ in_array(Route::currentRouteName(),['admin.products.attribute']) ? 'active' : '' }}"><a href="{!! route('admin.products.attribute',['id'=>$id]) !!}"  aria-expanded="false">Extra Details</a></li>
    @endif
    @if($prod_type == 2)
    <li class="{{ in_array(Route::currentRouteName(),['admin.combo.products.view']) ? 'active' : '' }}"><a href="{!! route('admin.combo.products.view',['id'=>$id]) !!}"  aria-expanded="false">Combo Products</a></li>
    @endif
    
   @if($prod_type == 3)
     <?php  if(App\Models\AttributeSet::find(App\Models\Product::find($id)->attributeset['id'])->attributes_filter_yes() != 0){ ?>
    <li class="{{ in_array(Route::currentRouteName(),['admin.products.configurable.attributes']) ? 'active' : '' }}"><a href="{!! route('admin.products.configurable.attributes',['id'=>$id]) !!}"  aria-expanded="false">Product Variants </a></li>

    <?php  } ?>
    @endif
  
    @if($prod_type == 4)

    <li class="{{ in_array(Route::currentRouteName(),['admin.products.configurable.without.stock.attributes']) ? 'active' : '' }}"><a href="{!! route('admin.products.configurable.without.stock.attributes',['id'=>$id]) !!}"  aria-expanded="false">Product Variants Without Stock </a></li>



    @endif
    @if($settingStatus['35'] == 1)
    <li class="{{ in_array(Route::currentRouteName(),['admin.product.vendors']) ? 'active' : '' }}"><a href="{!! route('admin.product.vendors',['id'=>$id]) !!}"  aria-expanded="false">Vendors </a></li>
    @endif
    
    @if($feature['related-products'] == 1)
    <li class="{{ in_array(Route::currentRouteName(),['admin.products.upsell.related']) ? 'active' : '' }}"><a href="{!! route('admin.products.upsell.related',['id'=>$id]) !!}"  aria-expanded="false">Related Products </a></li>
    @endif
    @if($feature['like-product'] == 1)
     <li class="{{ in_array(Route::currentRouteName(),['admin.products.upsell.product']) ? 'active' : '' }}"><a href="{!! route('admin.products.upsell.product',['id'=>$id]) !!}"  aria-expanded="false">You may also like</a></li>
     @endif
     @if($feature['sco'] == 1)
    <li class="{{ in_array(Route::currentRouteName(),['admin.products.prodSeo']) ? 'active' : '' }}"><a href="{!! route('admin.products.prodSeo',['id'=>$id]) !!}"  aria-expanded="false"> SEO </a></li>
    @endif
   

      @if($prod_type == 5)
     <li class="{{ in_array(Route::currentRouteName(),['admin.products.prodUpload']) ? 'active' : '' }}"><a href="{!! route('admin.products.prodUpload',['id'=>$id]) !!}"  aria-expanded="false"> Upload Product </a></li>
  @endif
</ul>