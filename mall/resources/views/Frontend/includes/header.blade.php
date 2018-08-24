<div class="container">
    <div class="row">
        <div class="col-md-4">
            <ul>
                <li>Home</li>
                @foreach($menu as $getm)
                {{ App\Library\Helper::getmenu($getm) }}
                @endforeach
            </ul>
        </div>
        <div class="col-md-4">
            <!-- | -->  <?php $currency = App\Library\Helper::get_country(); ?>
            <?php
            $currency_id = "32";
            if (isset($_COOKIE['currency'])) {
                $currency_id = $_COOKIE['currency'];
            }
            App\Library\Helper::set_country_session($currency_id)
            ?>
<!--            <select name="currencycheck" id="currencycheck" class="currencycheck ">
                <option value="">Select Country</option>    
                @foreach($currency as $cur)
                <option value="{{ $cur->id}}" <?php
            if ($cur->id == $currency_id) {
                echo "selected";
            }
            ?>>{{ $cur->currency_code}} ({{ $cur->currency_name}})</option>
                @endforeach
            </select>-->
        </div>
        <div class="col-md-4">
            <div class="your-products" id="myCart">
                <div class="shop-cart">
                    <a class="cart-control">
                        <img src="{{ asset(Config('constants.frontendPublicImgPath').'assets/icons/cart-black.png') }}" alt="">
                        <span class="cart-number number">{{Cart::instance("shopping")->count()}}</span>
                    </a><!-- .cart-control -->
                    @if(Cart::instance("shopping")->count() != 0 )
                    <div class="shop-item">
                        <div class="widget_shopping_cart_content">
                            <ul class="cart_list">
                                @foreach(Cart::instance("shopping")->content() as $c)
                                <li class="clearfix">
                                    <a class="p-thumb" href="#" style="height: 50px;width: 50px;">
                                        <?php if ($c->options->image != '') { ?>
                                            <img src="{{ asset(Config('constants.productImgPath').$c->options->image) }}" alt="{{$c->options->image}}" >
                                        <?php } else { ?>
                                            <img src="{{ asset(Config('constants.productImgPath')) }}/default-image.jpg" alt="" >
                                        <?php } ?>
                                    </a>
                                    <div class="p-info">
                                        <a class="p-title" href="#">{{ $c->name }}</a><br>

                                        <span class="p-qty">QTY: {{ $c->qty }}</span>

                                        <span class="price">
                                            <?php
                                            if ($c->options->tax_type == 2) {
                                                $taxeble_amt = $c->subtotal - $c->options->disc;
                                                $tax_amt = round($taxeble_amt * $c->options->taxes / 100, 2);
                                                $selling_price = $c->subtotal * Session::get('currency_val') + $tax_amt;
                                            } else {
                                                $selling_price = $c->subtotal * Session::get('currency_val');
                                            }
                                            ?>
                                            <ins><span class="amount"><?php echo!empty(Session::get('currency_symbol')) ? Session::get('currency_symbol') : ''; ?> {{ number_format($selling_price, 2) }}</span></ins>
                                        </span>

                                        <a data-rowid="{{$c->rowid}}" class="removeShoppingCartProd remove" href="#"><i class="fa fa-times-circle"></i></a>
                                    </div>
                                </li>
                                @endforeach
                            </ul><!-- end cart_list -->
                            <?php
                            $cart_data = App\Library\Helper::calAmtWithTax();
                            $cart_total = $cart_data['total'] * Session::get("currency_val");
                            ?>
                            <p class="total"><strong>Subtotal:</strong> <span class="amount"><?php echo!empty(Session::get('currency_symbol')) ? Session::get('currency_symbol') : ''; ?> {{ number_format($cart_total, 2) }}</span></p>
                            <p class="buttons">
                                <a class="button cart-button" href="{{ route('cart') }}">View Cart</a>
                                <a class="button yellow wc-forward" href="{{ route("checkout") }}">Checkout</a>
                            </p>
                        </div>
                    </div><!-- .shop-item -->
                    @else
                    <!---- --->
                    @endif
                </div><!-- .shop-cart -->
            </div><!-- .your-products -->
            @if(Session::get('loggedin_user_id'))
            <a href="{{ route('logoutUser')  }}" class="">Logout</a>
            @else
            <a href="{{ route('loginUser')  }}" class="">Login/Register</a>
            @endif
        </div>

    </div>
</div>