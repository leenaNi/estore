<div id="quick{{ $prod->id }}" class="quickview popup">
    <input type="hidden" value="{{Request::url()}}" class="fbShareUrl" />
    <input type="hidden" value="{{@$prod->images[0]->img}}" class="fbShareImg" />
    <span class="hide fbShareDesc">{{strip_tags($prod->short_desc)}}</span>
    <input type="hidden" value="{{ $prod->product }}" class="fbShareTitle" />
    <div class="quickview-inner popup-inner clearfix">
        <a href="#" class="popup-close">Close</a>
        <form id="{{ "form".$prod->id."quick" }}" action="{{ route('addToCart') }}" method="post">
            <div class="images">
                <div class="p-preview">
                    <div class="slider">
                        @if( count($prod->catalogimgs()->get()) > 0 )
                        @foreach($prod->catalogimgs()->get() as $catimgs)
                        <div class="item  app-figure" >
                            <a  class="MagicZoom" href="{{ @asset(Config('constants.productImgPath').$catimgs->filename) }}">
                                <img src="{{ @asset(Config('constants.productImgPath').$catimgs->filename) }}" alt="{{$catimgs->alt_text}}">
                            </a>
                        </div>
                        @endforeach
                        @else
                        <div class="item  app-figure" >
                            <a  class="MagicZoom" href="{{ @asset(Config('constants.productImgPath')) }}/default-image.jpg">
                                <img src="{{ @asset(Config('constants.productImgPath')) }}/default-image.jpg" alt="Img" title="img">
                            </a>
                        </div>                            
                        @endif
                    </div>
                </div> #p-preview 
                <div class="p-thumb">
                    <div class="thumb-slider">
                        @if( count($prod->catalogimgs()->get()) > 0 )
                        @foreach($prod->catalogimgs()->get() as $catimgs1)
                        <div class="item popup-thumb-img">
                            <a href="{{ @asset(Config('constants.productImgPath').$catimgs1->filename) }}">
                                <img src="{{ @asset(Config('constants.productImgPath').$catimgs1->filename) }}" alt="{{$catimgs1->alt_text}}" />
                            </a>
                        </div>
                        @endforeach
                        @else
                        <div class="item popup-thumb-img">
                            <a href="{{ @asset(Config('constants.productImgPath')) }}/default-image.jpg">
                                <img src="{{ @asset(Config('constants.productImgPath')) }}/default-image.jpg" alt="Img" title="img">
                            </a>
                        </div>
                        @endif
                    </div> .thumb-slider 
                </div> #p-thumb 
            </div> .images 

            <div class="summary">
                <?php $currency_val = Session::get('currency_val'); ?>
                <h3 class="p-title"><a href="{{ $prod->url_key }}">{{ $prod->product }}</a></h3>
                <span class="price">
                    <ins><span class="amount"><span class="currency-sym"></span>. {{ ($prod->spl_price > 0 && $prod->spl_price < $prod->price) ? number_format($prod->spl_price  * $currency_val, 2) : number_format($prod->price  * $currency_val, 2) }}</span></ins>
                    @if($prod->price > $prod->spl_price)
                    <del><span class="currency-sym"></span> {{ number_format($prod->price * $currency_val, 2) }}</del>
                    @endif
                </span>
                <div class="p-desc">
                    <p><?= html_entity_decode($prod->short_desc) ?></p>
                </div> .p-desc 
                <input type='hidden' name='prod_id' value='{{$prod->id}}' data-parentid = "{{ $prod->id }}">
                <input type='hidden' name='prod_type' value='{{$prod->prod_type}}'>
                <p class="stockL" style="display: none;">Stock Left <b class="stockChk">{{ $prod->stock }}</b></p>
                <div class="attribute attribute-actions clearfix">
                    <div class="attr-item">
                        <label>Qty:</label>
                        <div class="quantity">
                            <input type="number" name="quantity" value="1"  max="{{ $prod->stock }}" class="qty" style="text-align: center;" size="4"/> 
                        </div>
                    </div> .attr-item 
                    <?php
                    if (Auth::user() && App\Models\User::find(Auth::user()->id)->wishlist->contains($prod->id)) {
                        $prod->wishlist = 1;
                    } else {
                        $prod->wishlist = 0;
                    }
                    ?>
                    <div class="attr-item attr-item-action" >
                        <div class="p-actions">
                            @if($prod->stock > 0)
                            <div class="attr-item">
                                <div class="prod-btm-button">
                                    <a href="javascript:void(0);" form-id="{{ $prod->id."quick" }}" class="button yellow add-to-cart-button addToCart" ><i class="icon-cart"></i><span> Add to cart</span></a>
                                    <a href="javascript:void(0)" data-prodid="{{ $prod->id }}"  class="button square add-to-wishlist red-heart {{ ($prod->wishlist == 1) ? 'red-heart' : '' }}"><i class="fa fa-heart"></i></a>
                                </div>
                                @else
                                <div>Out of Stock</div>
                                @endif
                            </div> .attr-item
                        </div> .p-actions 
                    </div> .attr-item 
                </div> .attribute 
                <div class="single-share">
                    <strong>SHARE THIS:</strong>
                    <div class="social">
                        <span class='st_facebook_large' displayText='Facebook'></span>
                        <span class='st_googleplus_large' displayText='Google +'></span>
                        <span class='st_twitter_large' displayText='Tweet'></span>
                        <span class='st_linkedin_large' displayText='LinkedIn'></span>
                        <span class='st_pinterest_large' displayText='Pinterest'></span>
                        <span class='st_email_large' displayText='Email'></span>
                    </div>
                </div>
            </div> .summary 
        </form>
    </div> .quickview-inner
    <div class="mask popup-close"></div>
</div> #product-quickview 