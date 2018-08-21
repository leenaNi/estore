@extends('Frontend.layouts.default')
@section('content')
<div class="container">
    <div class="box">
        <form action="{{route('saveOrderwithproduct')}}" method="post" class="form-horizontal">
            <div class="row">
                <div class="col-md-3">
                    <div class=" form-group">
                        <input class="form-control" type="text" name="mobile" id="mobile-no" required placeholder="Telephone Number">
                    </div>
                </div>
                <div class="col-md-3">
                    <button class="btn" type="button" id="check-loyalty" > Check Loyalty</button>

                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class=" form-group">
                        <input class="form-control" type="text" name="note" value="" placeholder="Order Note" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class=" form-group">
                        <input class="form-control" type="text" name="amount" value="" placeholder="Order Amount" required>
                    </div>
                </div>
            </div>
            <div class="row hide" id="loyalty">
                <div class="col-md-03 form-group"><input type="checkbox" value="1" name="apply-loyalty" />Apply Loyalty</div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <button class="btn" type="submit" name="orderplace" value="place order"  >Place Order</button>
                </div>
            </div>
        </form>
    </div>
</div>
@stop
@section("myscripts")
<script>
    $('#check-loyalty').on('click', function () {
        $('#check-loyalty').parent().find('span').remove();
        $('#loyalty').addClass("hide");
        if ($('#mobile-no').val()!=''){
            //$('#loyalty').find('div').remove();
            $.post("{{route('checkLoyalty')}}", {phone: $('#mobile-no').val()}, function (response) {
                console.log(response);
                if (response['status'] == 1 && response['cashback'] > 0) {
                    $('#check-loyalty').parent().append("<span class='help-block'>Total loyalty points available <?php echo htmlspecialchars_decode(Session::get('currency_symbol')); ?> " + response.cashback + "</span>");
                    $('#loyalty').removeClass("hide");
                    //$('#loyalty').append('<div class="col-md-03 form-group"><input type="checkbox" value="0" name="apply-loyalty" />Apply Loyalty</div>');
                } else if (response['cashback'] == 0) {
                    $('#check-loyalty').parent().append("<span class='help-block'>Total loyalty points available <?php echo htmlspecialchars_decode(Session::get('currency_symbol')); ?> " + response.cashback + "</span>");
                    $('#loyalty').addClass("hide");
                    //$('#loyalty').find('div').remove();
                }
            });
        }else{
        alert("Please enter mobile number to check loyalty!");
        }
    });
</script>
@stop