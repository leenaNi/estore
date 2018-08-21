<div class="col-md-4">
    <form id="{{ "form".$prod->id }}" action="{{ route('addToCart') }}">
        <div class="Npthumb p-thumb col-md-4 col-sm-5">
            <?php
            // print_r($prod);
            if (count($prod->mainimg) > 0) {
                ?>
                <a href="{{route("home")."/".$prod->url_key}}">
                    <img src="{{ @asset(Config('constants.productImgPath').$prod->mainimg[0]->filename) }}" alt="" style="width:200px;height:auto;">
                </a>
            <?php } else { ?> 
                <a href="{{route("home")."/".$prod->url_key}}">
                    <img src="{{ @asset(Config('constants.productImgPath')) }}/default-image.jpg" alt="Img" title="img">
                </a>
            <?php }
            ?> 

        </div><!-- .p-thumb -->									
        <?php $currency_val = Session::get('currency_val'); ?>
        <div class="p-info col-md-8 col-sm-7">
            <div  class="quick-view quick-view1" rel="product-quickview" style="cursor:pointer;" onclick="quickpopup('quick{{$prod->id}}')">QUICK LOOK</div>
            <h3 class="p-title product-name"><a href="{{$prod->url_key}}">{{$prod->product}}</a></h3>
            <span class="price">
                <ins><span class="amount"> <span class="currency-sym"></span> {{ ($prod->spl_price > 0 && $prod->spl_price < $prod->price) ? number_format($prod->spl_price * $currency_val, 2) : number_format($prod->price * $currency_val, 2) }}</span></ins>
                @if($prod->price > $prod->spl_price)
                <del> <span class="currency-sym"></span> {{ number_format($prod->price * $currency_val, 2) }}</del>
                @endif
            </span>
            @if($prod->stock > 0)
            <input type='hidden' name='prod_id' value='{{$prod->id}}' data-parentid = "{{ $prod->id }}">
            <input type='hidden' name='prod_type' value='{{$prod->prod_type}}'>
            <p class="stockL" style="display: none;">Stock Left <b class="stockChk">{{ $prod->stock }}</b></p>
            <input type="hidden" name="quantity" value="1"  max="{{ $prod->stock }}" class="qty" style="text-align: center;" /> 
            <?php
            if (Auth::user() && App\Models\User::find(Auth::user()->id)->wishlist->contains($prod->id)) {
                $prod->wishlist = 1;
            } else {
                $prod->wishlist = 0;
            }
            ?>
            <div class="pro-actions">
                <a  href="javascript:void(0);" form-id='{{ $prod->id }}' class="button yellow add-to-cart-button addToCart"><i class="icon-cart"></i> <span>Add to cart</span></a>
                <a href="javascript:void(0)" data-prodid="{{ $prod->id }}"  class="button square add-to-wishlist-page {{ ($prod->wishlist == 1) ? 'red-heart' : '' }}"><i class="fa fa-heart"></i></a>
            </div>
            @else
            <p>Out of Stock</p>
            @endif
            <div class="p-desc">
                <p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.</p>
            </div><!-- .p-desc -->
        </div><!-- .p-info -->
    </form>
</div>
