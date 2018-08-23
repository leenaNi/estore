     
<form id="returnOrder" class="bucket-form rtForm">
    <div class="adv-table editable-table ">
        <div class="space15"></div>
        <br />
        <div class="restable">
            <table class="table rttable table-hover general-table">
                <thead>
                    <tr>
                        <th style='width:15%'>Product</th>
                        <th style='width:15%'>Ordered Qty</th>
                        <th style='width:15%'>Ordered Left</th>
                        <th style='width:15%'>Returned Quantity</th>
                        <th style='width:15%'>Return Request Quantity</th>
                        <th style='width:15%'>Price</th>
                        <th style='width:15%'>Amount After Discount</th>
                        <th style='width:15%'>Return Amount Price</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($output as $prd)

                    <?php if ($prd['prod_type'] != 5) { ?>
                        {{ Form::hidden('orderId',$prd['order_id']) }}
                        <tr> 
                    <input type="hidden" id="left{{ @$prd['product_id'] }}" value="{{ @$prd['product_id'] }}" />
                    <input type="hidden" id="afd{{ @$prd['product_id'] }}" value="{{ number_format(@$prd['amt_after_discount'],2) }}" /> 
                    <input type="hidden" id="returnamt{{ @$prd['product_id'] }}" name="pr[{{ @$prd['product_id'] }}][returnamt]" /> 

                    <td>{{ $prd['product_name'] }}</td>  
                    <td>
                        <input type="text"  style='width:50%' min="0" class="retQtyChk rtQty inputReturn" disabled=""  readonly="" name="pr[{{ @$prd['product_id'] }}][orderqty]" value='{{ @$prd['orderQty'] }}' />
                        <p class="retError" style="color:red"></p>
                    </td>
                    <td><?php
                        $r = @$prd['orderQty'] - @$prd['return_quantity'];
                        if ($r <= 0) {
                            $r = 0;
                        }
                        ?>
                        <input type="text"  style='width:50%' min="0" class="retQtyChk rtQty inputReturn q{{ @$prd['product_id'] }}" disabled="" readonly="" name="pr[{{ @$prd['product_id'] }}][orderleft]" value='{{ $r }}' />
                        <p class="retError" style="color:red"></p>
                    </td>
                    <td>
                        <input type="number"  style='width:80%' min="0" class="retQtyChk rtQty inputReturn l{{ @$prd['product_id'] }}" max="{{ $r }}" data-pid="{{ @$prd['product_id'] }}" name="pr[{{ @$prd['product_id'] }}][returnqty]" value='0' />
                        <p class="retError" style="color:red"></p>
                    </td>
                    <td>
                        <input type="text"  style='width:50%' min="0" class="retQtyChk rtQty inputReturn" disabled="" readonly=""  data-pid="{{ @$prd['product_id'] }}" name="pr[{{ @$prd['product_id'] }}][returnqty]" value='{{ @$prd['return_quantity'] }}' />
                        <p class="retError" style="color:red"></p>
                    </td>
                    <td><i class="fa fa-rupee"></i>{{  number_format(@$prd['product_price'],2) }}</td>
                    <td><i class="fa fa-rupee"></i>{{  number_format(@$prd['amt_after_discount'],2) }}</td>
                    <td><i class="fa fa-rupee"></i><span class="totalPrice rp{{ @$prd['product_id'] }}">0.00</span></td>
                    </tr>
                    <tr>
                        <td class="" colspan="9">
                            <div id="dd{{ @$prd['product_id'] }}"class="">
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Reason</label>
                                    <div class="col-sm-10">
                                        <select name="pr[{{ @$prd['product_id'] }}][reason]" class="form-control">
                                            @foreach($return_reason as $rr)
                                            <option value="{{ $rr->id }}">{{ $rr->reason }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">Opened</label>
                                    <div class="col-sm-10">
                                        <select name="pr[{{ @$prd['product_id'] }}][opened]" class="form-control">

                                            @foreach($return_open_un as $rou)
                                            <option value="{{ $rou->id }}">{{ $rou->status }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword3" class="col-sm-2 control-label">Remark</label>
                                    <div class="col-sm-10">
                                        <textarea name="pr[{{ @$prd['product_id'] }}][remark]" class="form-control" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{ Form::submit('Submit',["class" => "btn btn-info submitReturn"]) }}
</form>
<script>
    $(document).ready(function () {
        $('html body').on('change', '.inputReturn', function () {
            var r = $(this).val();
            var pid = $(this).attr('data-pid');
            var amt = $("#afd" + pid).val();
            $(".rp" + pid).text(amt * r);
            $("#returnamt" + pid).val(amt * r);
        });
        
         $('html body').on('change keyup', '.inputReturn', function () {
      //          $(".inputReturn").bind("change keyup", function () {
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
        
        
          $('html body').on('keypress', '.inputReturn', function (e) {
         //       $(".inputReturn").keypress(function (e) {
            //if the letter is not digit then display error and don't type anything
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            } else {
                return true;
            }
        });
    });
</script>