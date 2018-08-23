@extends('Frontend.layouts.default')
@section('content')
<div class="container">
    <form id="{{ "form".$product->id }}" action="{{ route('addToCart') }}">
        <span> 
            <a href="{{ route('prod', [$product->url_key])  }}" >
                {!! Html::image($product->prodImage, '', array('height' => '200','width' => '200')) !!}
            </a>
        </span>
        <div>{{ $product->product }}</div>
        <div>Description : <?php echo html_entity_decode($product->short_desc); ?></div>
        <div>Price : 
            <span class="price">
                <ins style="margin:5px auto;"><span class="amount"> <i class="fa fa-<?php echo strtolower(Session::get('currency_code')); ?>"></i>  {{ ($product->spl_price > 0 && $product->spl_price < $product->price) ? number_format($product->spl_price * Session::get('currency_val'), 2) : number_format($product->price * Session::get('currency_val'), 2) }}</span></ins>

                @if($product->price > $product->spl_price)
                <del> <i class="fa fa-<?php echo strtolower(Session::get('currency_code')); ?>"></i>  {{ number_format($product->price * Session::get('currency_val'), 2) }}</del>
                @endif
            </span>
        </div>
        @if($product->stock > 0)
        @foreach($product->comboproducts as  $comboPrds)
        @if($comboPrds->prod_type == 3)
        <?php
        $attributesC = App\Models\AttributeSet::find($comboPrds->attributeset['id'])->attributes()->where("is_filterable", "=", 1)->get();
        ?>
        <div>
            <span> 
                <a href="{{ route('prod', [$comboPrds->url_key])  }}" >
                    <?php
                    $imgConfig = asset(Config('constants.productImgPath') . $comboPrds->catalogimgs()->where("image_type", 1)->first()->filename);
                    ?>
                    {!! Html::image($imgConfig, '', array('height' => '50','width' => '50')) !!}
                </a>
            </span>
        </div>

        <div>{{ $comboPrds->product }}</div>     
        @foreach($attributesC as $attr)
        <?php
        $options = ['' => $attr->attr];
        foreach ($attr->attributeoptions()->get() as $opt) {
            $options[$attr->id . "-" . $opt->id] = $opt->option_name;
        }
        ?>
        <div>
          {!! Form::select($attr->slug,$options,null,['width'=>'100','style'=>"width: 200px;",'class'=>'attrSel','parentPrd'=>$comboPrds->id])  !!} <br/><br/><br/>
        </div>
        @endforeach
        @else
        <span> 
            <a href="{{ route('prod', [$comboPrds->url_key])  }}" >
                <?php
                $imgSimple = asset(Config('constants.productImgPath') . $comboPrds->catalogimgs()->where("image_type", 1)->first()->filename);
                ?>
                {!! Html::image($imgSimple, '', array('height' => '50','width' => '50')) !!}
            </a>
        </span>
        <div> {{ $comboPrds->product }}</div>   
        @endif
        @endforeach
        <input type='hidden' name='prod_id' value='{{$product->id}}' data-parentid = "{{ $comboPrds->id }}">
        <input type='hidden' name='prod_type' value='{{$product->prod_type}}'>
        
        <?php
        //print_r($combos);
        foreach ($combos as $key => $name) {
            if (isset($options[$key])) {
                ?>
                <input type="hidden" name="sub_prod[<?= $key ?>]" />
                <?php
            }
        }
        ?>
        <input type="number" name="quantity" value="1"  max="{{ $comboPrds->stock }}" class="qty" style="text-align: center;" /> 
        <!-- <input type='button' form-id='{{ $comboPrds->id }}' value='Add To Cart' class='addToCartB' id='addToCart' disabled> -->
        <input type='button' form-id='{{ $product->id }}' value='Add To Cart' class='addToCartB addToCart' >
        @else
        <p>Out of Stock
                <br>
                Get notification When product is in stock
            </p>
            
            <p>
                <input type="email" value="<?php if(Session::has('logged_in_user')){ echo Session::get('logged_in_user');  } ?>" id="email_notify" />
                <input type='hidden' id="prod_id" value='{{$product->id}}'>
                <input type="button" value="Send Request" id="email_notify_btn"/>
                <br><span id="notify_err"></span>
            </p>
        @endif
    </form>
    @stop
</div>

@section('myscripts')
<script>
    $(document).ready(function () {
        $(".attrSel").each(function () {
            $(this).change(function () {
                var parentPRod = $(this).attr('parentPrd');
                console.log(parentPRod);
                $("input[name='sub_prod']").val("");
                attrval = [];
                $(".attrSel").each(function () {
                    attrval.push($(this).val());
                });
                $.ajax({
                    type: "POST",
                    url: "{!! route('getSubProd') !!}",
                    data: {attrval: attrval, parentPRod: parentPRod},
                    cache: false,
                    success: function (data) {
                        if (data != "invalid") {
                            $("input[name='sub_prod']").val(data.id);
                            $(".stockL").css("display", "block");
                            //$(".stockChk").text(data.stock);
                            $(".addToCartB").removeAttr("disabled", "disabled");
                        } else {
                            $(".stockL").css("display", "none");
                            $(".addToCartB").attr("disabled", "disabled");
                        }
                    }
                });
            });
        });
        
                $("#email_notify_btn").click(function(){
           var mail = $("#email_notify").val();
           var prod = $("#prod_id").val();
           $.ajax({
               data:"email="+mail+"&prod="+prod,
               url:"{{ route('notifyMail') }}",
               type:"post",
               dataType:"json",
               beforeSend:function(){
                  $("#notify_err").text("Please wait");
               },
               success:function(r){
                       $("#notify_err").text(r.msg);
               }
           });
        });
       
    });
</script>
@stop