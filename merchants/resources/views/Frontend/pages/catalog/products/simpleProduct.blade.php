@extends('Frontend.layouts.default')
@section('content')
<div class="container">
    <form id="{{"form".$product->id }}" action="{{ route('addToCart') }}">
        <span> 
            <a href="{{ route('prod', [$product->url_key])  }}" >
                {!! Html::image($product->prodImage, '', array('height' => '200','width' => '200')) !!}
            </a>
        </span>  
        <div>{{$product->product}}</div>
        <div>Description : <?php echo html_entity_decode($product->short_desc); ?></div>
        <div>Price : <span class="currency-sym"></span> {{ number_format($product->selling_price *  Session::get('currency_val'),2)}}</div>
        <div>
            @if($product->stock > 0)
            <input type='hidden' name='prod_id' value='{{$product->id}}' data-parentid = "{{ $product->id }}">
            <input type='hidden' name='prod_type' value='{{$product->prod_type}}'>
            <p class="stockL" style="display: none;">Stock Left <b class="stockChk">{{ $product->stock }}</b></p>
            <div class="quantity">
                <input type="number" name="quantity" id="quantity" value="1"  max="{{ $product->stock}}" class="qty"  min="1"  onkeypress="return isNumber(event);" style="text-align: center;" /> 
            </div>
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
        </div>
        @endif
    </form>
</div>
@stop
@section('myscripts')
<script>
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 32 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
    $('.plus').click(function (e) {
        // Stop acting like a button
        e.preventDefault();
        // Get the field name

        var maxvalue = parseInt($('input[name="quantity"]').attr('max'));
        console.log(maxvalue);
        // Get its current value
        var currentVal = parseInt($('#quantity').val());
        console.log(currentVal);
        // If is not undefined
        if (!isNaN(currentVal) && (currentVal < maxvalue)) {
            // Increment
            //$('.plus').css('pointer-events', '');
            $('#quantity').val(parseInt(currentVal));
        } else if (currentVal >= maxvalue) {
            console.log(maxvalue);
            //$('.plus').css('pointer-events', 'none');
            $('#quantity').val(parseInt(maxvalue));
        } else {
            // Otherwise put a 0 there
            $('#quantity').val(1);
        }
    });
    $(document).ready(function () {
        
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