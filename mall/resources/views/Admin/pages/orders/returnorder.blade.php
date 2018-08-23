@extends('Admin.layouts.default')
@section('content')

<section class="content-header">
    <h1>
        Orders
        <small>Add/Edit</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Return Orders</li>
        <li class="active">Add/Edit</li>
    </ol>
</section>

<section class="content">
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#product-detail" data-toggle="tab" aria-expanded="true">Product Details</a></li>
        </ul>
        <div  class="tab-content" >
            <div class="tab-pane active" id="product-detail">

                <form id="returnOrder" class="bucket-form rtForm">
                    <div class="adv-table editable-table ">
                        <div class="space15"></div>
                        <br />
                        <div class="restable">
                            <table class="table rttable table-hover general-table tableVaglignMiddle">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Ordered Qty</th>
                                        <th>Ordered Left</th>
                                        <th>Returned Quantity</th>
                                        <th>Return Request Quantity</th>
                                        <th>Price</th>
                                        <th>Amount After Discount</th>
                                        <th>Return Amount Price</th>
                                        <th>Return requested Amount</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach($output as $prd)

                                    <?php if ($prd['prod_type'] != 5) { ?>
                                        {{ Form::hidden('orderId',$prd['order_id']) }}
                                        <tr> 
                                    <input type="hidden" id="left{{ @$prd['product_id'] }}" value="{{ @$prd['product_id'] }}" />
                                    <input type="hidden" id="afd{{ @$prd['product_id'] }}" value="{{ @$prd['amt_after_discount'] }}" /> 
                                    <input type="hidden" id="returnamt{{ @$prd['product_id'] }}" name="pr[{{ @$prd['product_id'] }}][returnamt]" /> 

                                    <td>{{ $prd['product_name'] }}</td>  
                                    <td>
                                        <input type="number" min="0" class="retQtyChk rtQty inputReturn" disabled=""  readonly="" name="pr[{{ @$prd['product_id'] }}][orderqty]" value='{{ @$prd['orderQty'] }}' />
                                        <p class="retError" style="color:red"></p>
                                    </td>
                                    <td><?php
                                        $r = @$prd['orderQty'] - @$prd['return_quantity'];
                                        if ($r <= 0) {
                                            $r = 0;
                                        }
                                        ?>
                                        <input type="number" min="0" class="retQtyChk rtQty inputReturn q{{ @$prd['product_id'] }}" disabled="" readonly="" name="pr[{{ @$prd['product_id'] }}][orderleft]" value='{{ $r }}' />
                                        <p class="retError" style="color:red"></p>
                                    </td>
                                    <td>
                                        <input type="number" min="0" class="retQtyChk rtQty inputReturn l{{ @$prd['product_id'] }}" max="{{ $r }}" data-pid="{{ @$prd['product_id'] }}" name="pr[{{ @$prd['product_id'] }}][returnqty]" value='0' />
                                        <p class="retError" style="color:red"></p>
                                    </td>
                                    <td>
                                        <input type="number" min="0" class="retQtyChk rtQty inputReturn" disabled="" readonly=""  data-pid="{{ @$prd['product_id'] }}" name="pr[{{ @$prd['product_id'] }}][returnqty]" value='{{ @$prd['return_quantity'] }}' />
                                        <p class="retError" style="color:red"></p>
                                    </td>
                                    <td><i class="fa fa-rupee"></i>{{ @$prd['product_price'] }}</td>
                                    <td><i class="fa fa-rupee"></i>{{ @$prd['amt_after_discount'] }}</td>
                                    <td><i class="fa fa-rupee"></i><span class="totalPrice rp{{ @$prd['product_id'] }}">0</span></td>
                                    <td><i class="fa fa-rupee"></i>{{ @$prd['return_amount'] }}</td>
                                    </tr>
                                <?php } ?>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{ Form::submit('Submit',["class" => "btn btn-info submitReturn"]) }}
                </form>



            </div>
        </div>
    </div>
</section> 
@stop 

@section('myscripts')
<script>
    $(document).ready(function () {
        $(".inputReturn").bind("change keyup", function () {
            var r = parseInt($(this).val());
            var pid = $(this).attr('data-pid');
            var a = parseInt($(".q" + pid).val());
            var amt = $("#afd" + pid).val();
            if (r > a) {
                $(".l" + pid).val(a);
                $(".rp" + pid).text(amt * parseInt($(".l" + pid).val()));
                $("#returnamt" + pid).val(amt * parseInt($(".l" + pid).val()));
            } else {
                $(".rp" + pid).text(amt * r);
                $("#returnamt" + pid).val(amt * r);
            }
        });

        $(".inputReturn").keypress(function (e) {
            //if the letter is not digit then display error and don't type anything
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            } else {
                return true;
            }
        });
        $('html body').on('submit', '#returnOrder', function () {
            $.ajax({
                url: "{{ route('admin.orders.ReturnOrderCal') }}",
                type: 'post',
                data: new FormData(this),
                processData: false,
                contentType: false,
                beforeSend: function () {
                   $(".submitReturn").attr("disabled", "disabled");
                },
                success: function (res) {
                    window.location.href = "";
                }
            });
            return false;
        });
    });
</script>
@stop