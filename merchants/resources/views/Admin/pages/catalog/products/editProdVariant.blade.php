@extends('Admin.layouts.default')
@section('content')

<section class="content-header">
    <h1>
        Products

    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Products</li>
        <li class="active">Add/Edit</li>
    </ol>
</section>


<div class="panel panel-default">

    <div class="panel-body">
        {!! Form::model($prod, ['method' => 'post', 'files'=> true, 'url' => $action , 'class' => 'form-horizontal' ]) !!}
        {!! Form::hidden('id',null) !!}
        {!! Form::hidden('updated_by', Auth::id()) !!}
        {!! Form::hidden("close","close") !!}
        <div class="row form-group col-md-12">

            <?php
            foreach ($attributes as $attribute):


                $required = $attribute['is_required'] ? "required" : NULL;
                $options = NULL;
                foreach ($attribute['attributeoptions'] as $val) {
                    $options[$val['id']] = $val['option_name'];
                }
                $multiple = $attribute['attr_type'] == 2 ? 'multiple' : '';
                switch ($attribute['attr_type']) {

                    //break;
                    case '2':
                        $options = NULL;
                        foreach ($attribute['attributeoptions'] as $val) {
                            $options[$val['option_value']] = $val['option_name'];
                        }
                        ?>
                        <div class="form-group col-md-3">
                            <div class="col-md-12">
                                {!! Form::label($attribute['attr'], $attribute['attr'],['class'=>'control-label '.$required]) !!}
                                {!! Form::select("attributes[".$attribute['id']."][attr_val][]",$options,@$attribute['value'], ["class"=>'form-control', "multiple", $required, "readonly", "disabled"]) !!}
                                {!! Form::hidden("attributes[".$attribute['id']."][attr_type_id]",$attribute['attr_type']) !!}
                            </div>
                        </div>
                        <?php
                        break;
                    case '3':
                        ?>
                        <div class="form-group col-md-3">
                            <div class="col-md-12">
                                {!! Form::label($attribute['attr'], $attribute['attr'],['class'=>'control-label '.$required]) !!}
                                {!! Form::text("attributes[".$attribute['id']."][attr_val]",@$attribute['value'], ["class"=>'form-control' ,"placeholder"=>$attribute['placeholder'], $required, "readonly", "disabled"]) !!}
                                {!! Form::hidden("attributes[".$attribute['id']."][attr_type_id]",$attribute['attr_type']) !!}
                            </div>
                        </div>
                        <?php
                        break;
                        //case '4':
                        ?>
                        <!--                        <div class="form-group col-md-12">
                                                    <div class="col-md-12">
                                                        {!! Form::label($attribute['attr'], $attribute['attr'],['class'=>'control-label '.$required]) !!}
                                                    </div>
                                                    <div class="col-md-12">
                                                        @foreach ($attribute['attributeoptions'] as $val) 
                                                        {!! Form::radio("attributes[".$attribute['id']."][attr_val]", $val['option_value'], @$attribute['value'] == $val['option_value']? true:false, $attribute['is_required']=='1'? required:'' ) !!} {{$val['option_name']}} &nbsp;&nbsp;&nbsp;&nbsp;                                                    
                                                        @endforeach
                                                        {!! Form::hidden("attributes[".$attribute['id']."][attr_type_id]",$attribute['attr_type']) !!}
                                                    </div>
                                                </div>-->
                    <?php
                    //break;
                    case '5':
                        ?>
                        <div class="form-group col-md-12">
                            <div class="col-md-12">
                                {!! Form::label($attribute['attr'], $attribute['attr'],['class'=>'control-label '.$required]) !!}
                            </div>
                            <div class="col-md-12">
                                @foreach ($attribute['attributeoptions'] as $val) 
                                {!! Form::checkbox("attributes[".$attribute['id']."][attr_val][]",$val['option_value'], @in_array($val['option_value'], @$attribute['value'])? true:false ) !!} {{$val['option_name']}} &nbsp;&nbsp;&nbsp;&nbsp;
                                @endforeach
                                {!! Form::hidden("attributes[".$attribute['id']."][attr_type_id]",$attribute['attr_type']) !!}
                            </div>
                        </div>
                        <?php
                        break;
                    case '6':
                        ?>
                        <div class="form-group col-md-4">
                            <div class="col-md-12">
                                {!! Form::label($attribute['attr'], $attribute['attr'],['class'=>'control-label '.$required]) !!}
                                {!! Form::text("attributes[".$attribute['id']."][attr_val]",@$attribute['value'], ["class"=>'form-control datepicker' ,"placeholder"=>$attribute['placeholder'], $required, "readonly", "disabled"]) !!}
                                {!! Form::hidden("attributes[".$attribute['id']."][attr_type_id]",$attribute['attr_type']) !!}
                            </div>
                        </div>
                        <?php
                        break;
                    case '7':
                        ?>
                        <div class="form-group col-md-4">
                            <div class="col-md-12">
                                {!! Form::label($attribute['attr'], $attribute['attr'],['class'=>'control-label '.$required]) !!}
                                {!! Form::text("attributes[".$attribute['id']."][attr_val]",@$attribute['value'], ["class"=>'form-control timepicker' ,"placeholder"=>$attribute['placeholder'], $required, "readonly", "disabled"]) !!}
                                {!! Form::hidden("attributes[".$attribute['id']."][attr_type_id]",$attribute['attr_type']) !!}
                            </div>
                        </div>
                        <?php
                        break;
                    case '8':
                        ?>
                        <div class="form-group col-md-4">
                            <div class="col-md-12">
                                {!! Form::label($attribute['attr'], $attribute['attr'],['class'=>'control-label '.$required]) !!}
                                {!! Form::text("attributes[".$attribute['id']."][attr_val]",@$attribute['value'], ["class"=>'form-control datetimepicker' ,"placeholder"=>$attribute['placeholder'], $required, "readonly", "disabled"]) !!}
                                {!! Form::hidden("attributes[".$attribute['id']."][attr_type_id]",$attribute['attr_type']) !!}
                            </div>
                        </div>
                        <?php
                        break;
                    case '9':
                        ?>
                        <div class="form-group col-md-4">
                            <div class="col-md-12">
                                {!! Form::label($attribute['attr'], $attribute['attr'],['class'=>'control-label '.$required]) !!}
                                {!! Form::text("attributes[".$attribute['id']."][attr_val]",@$attribute['value'], ["class"=>'form-control multidatepicker' ,"placeholder"=>$attribute['placeholder'], $required, "readonly", "disabled"]) !!}
                                {!! Form::hidden("attributes[".$attribute['id']."][attr_type_id]",$attribute['attr_type']) !!}
                            </div>
                        </div>
                        <?php
                        break;
                    case '10':
                        ?>
                        <div class="form-group col-md-3">
                            <div class="col-md-12">
                                {!! Form::label($attribute['attr'], $attribute['attr'],['class'=>'control-label '.$required]) !!}
                                {!! Form::file("attributes[".$attribute['id']."][attr_val]",["class"=>'form-control' , $required]) !!}
                                {!! Form::hidden("attributes[".$attribute['id']."][attr_type_id]",$attribute['attr_type']) !!}
                                {!! Form::hidden("attributes[".$attribute['id']."][file_val]",@$attribute['value']) !!}
                            </div>
                            <div class="col-md-4" style="height: 50px;line-height: 50px;padding-top: 8px;">
                                <?php if (isset($attribute['value'])): ?>
                                    <a href="{{ asset('public/Uploads/product/')."/". $attribute['value'] }}" target="_BLANK"><i class="fa fa-file"></i></a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php
                        break;
                    case '11':
                        ?>
                        <div class="form-group col-md-3">
                            <div class="col-md-12">
                                {!! Form::label($attribute['attr'], $attribute['attr'],['class'=>'control-label '.$required]) !!}
                                {!! Form::file("attributes[".$attribute['id']."][attr_val]",["class"=>'form-control' , $required, "accept"=>"image/x-png, image/jpeg"]) !!}
                                {!! Form::hidden("attributes[".$attribute['id']."][attr_type_id]",$attribute['attr_type']) !!}
                                {!! Form::hidden("attributes[".$attribute['id']."][image_val]",@$attribute['value']) !!}
                            </div>
                            <div class="col-md-4" style="height: 50px;line-height: 50px;padding-top: 8px;">
                                <?php if (isset($attribute['value'])): ?>
                                    <a href="{{ asset('public/Uploads/product/')."/". $attribute['value'] }}" target="_BLANK"><img src="{{asset('public/Uploads/product/')."/". $attribute['value'] }}" style="height: 50px; width: 50px;margin-right: 5px;" /></a>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php
                        break;
                    case '12':
                        ?>
                        <div class="form-group col-md-3">
                            <div class="col-md-12">
                                {!! Form::label($attribute['attr'], $attribute['attr'],['class'=>'control-label '.$required]) !!}
                                {!! Form::textarea("attributes[".$attribute['id']."][attr_val]",@$attribute['value'], ["class"=>'form-control editor' ,"placeholder"=>$attribute['placeholder'], $required, "readonly", "disabled"]) !!}
                                {!! Form::hidden("attributes[".$attribute['id']."][attr_type_id]",$attribute['attr_type']) !!}
                            </div>
                        </div>
                        <?php
                        break;
                    case '13':
                        ?>
                        <div class="form-group col-md-3">
                            <div class="col-md-12">
                                {!! Form::label($attribute['attr'], $attribute['attr'],['class'=>'control-label '.$required]) !!}
                                {!! Form::textarea("attributes[".$attribute['id']."][attr_val]",@$attribute['value'], ["class"=>'form-control' ,"placeholder"=>$attribute['placeholder'], $required, "readonly", "disabled"]) !!}
                                {!! Form::hidden("attributes[".$attribute['id']."][attr_type_id]",$attribute['attr_type']) !!}
                            </div>
                        </div>
                        <?php
                        break;
                    case '14':
                        ?>
                        <div class="form-group col-md-3">
                            <div class="col-md-12">
                                {!! Form::label($attribute['attr'], $attribute['attr'],['class'=>'control-label '.$required]) !!}
                                {!! Form::number("attributes[".$attribute['id']."][attr_val]",@$attribute['value'], ["class"=>'form-control' ,"placeholder"=>$attribute['placeholder'], $required, "readonly", "disabled"]) !!}
                                {!! Form::hidden("attributes[".$attribute['id']."][attr_type_id]",$attribute['attr_type']) !!}
                            </div>
                        </div>
                        <?php
                        break;
                    case '15':
                        ?>
                        <div class="form-group col-md-4">
                            <div class="col-md-12">
                                {!! Form::label($attribute['attr'], $attribute['attr'],['class'=>'control-label '.$required]) !!}
                                {!! Form::select("attributes[".$attribute['id']."][attr_val]",['Yes'=>'Yes', 'No'=>'No'] ,@$attribute['value'], ["class"=>'form-control' ,"placeholder"=>$attribute['placeholder'], $required, "readonly", "disabled"]) !!}
                                {!! Form::hidden("attributes[".$attribute['id']."][attr_type_id]",$attribute['attr_type']) !!}
                            </div>
                        </div>
                        <?php
                        break;
                    case '16':
                        ?>
                        <div class="form-group col-md-3">
                            <div class="col-md-12">
                                {!! Form::label($attribute['attr'], $attribute['attr'],['class'=>'control-label '.$required]) !!}
                                {!! Form::file("attributes[".$attribute['id']."][attr_val][]", ["class"=>'form-control' ,"multiple", $required]) !!}
                                {!! Form::hidden("attributes[".$attribute['id']."][attr_type_id]",$attribute['attr_type']) !!}
                                {!! Form::hidden("attributes[".$attribute['id']."][file_multi_val]",@$attribute['value']) !!}
                            </div>
                            <div class="col-md-8" style="height: 50px;line-height: 50px;padding-top: 8px;">
                                <?php
                                if (isset($attribute['value'])):
                                    foreach (json_decode($attribute['value']) as $file):
                                        ?>
                                        <a href="{{ asset('public/Uploads/product/')."/". $file }}" target="_BLANK"><i class="fa fa-file"></i></a>
                                        <?php
                                    endforeach;
                                endif;
                                ?>
                            </div>
                        </div>
                        <?php
                        break;
                    case '17':
                        ?>
                        <div class="form-group col-md-3">
                            <div class="col-md-12">
                                {!! Form::label($attribute['attr'], $attribute['attr'],['class'=>'control-label '.$required]) !!}
                                {!! Form::file($attribute['id'][], ["class"=>'form-control' ,"multiple", $required, "accept"=>"image/x-png, image/jpeg"]) !!}
                                {!! Form::hidden("attributes[".$attribute['id']."][attr_type_id]",$attribute['attr_type']) !!}
                                {!! Form::hidden("attributes[".$attribute['id']."][image_multi_val]",@$attribute['value']) !!}
                            </div>
                            <div class="col-md-8" style="height: 50px;line-height: 50px;padding-top: 8px;">
                                <?php
                                if (isset($attribute['value'])):
                                    foreach (json_decode($attribute['value']) as $image):
                                        ?>
                                        <a href="{{ asset('public/Uploads/product/')."/". $image }}" target="_BLANK"><img src="{{asset('public/Uploads/product/')."/". $image }}" style="height: 50px; width: 50px;margin-right: 5px;" /></a>
                                        <?php
                                    endforeach;
                                endif;
                                ?>
                            </div>
                        </div>
                        <?php
                        break;
                    default:
                        ?>
                        <div class="form-group col-md-3">
                            <div class="col-md-12">
                                {!! Form::label($attribute['attr'], $attribute['attr'],['class'=>'control-label '.$required]) !!}
                                {!! Form::select($attribute['id'],$options,@$prod->attributes()->wherePivot("attr_id","=",$attribute['id'])->first()->pivot->attr_val, ["class"=>'form-control' ,"placeholder"=>$attribute['placeholder'], $required, "readonly", "disabled"]) !!}
                                {!! Form::hidden("attributes[".$attribute['id']."][attr_type_id]",$attribute['attr_type']) !!}
                            </div>
                        </div>
                        <?php
                        break;
                }
            endforeach;
            ?>
            <div class="col-md-3">
                {!! Form::label('Price', 'Price',['class'=>'control-label']) !!}
                {!! Form::number("price",$prod->price,["class"=>"form-control priceConvertTextBox","min"=>"0" ,"step"=>"0.01"]) !!}
            </div>

        
            @if($settingStatus['stock'] == 1)
            <div class="col-md-3">
                {!! Form::label('is_avail', 'Availability',['class'=>'control-label']) !!}
                {!! Form::select("is_avail",['1'=>'Yes','0'=>'No'],$prod->is_avail,["class"=>"form-control"]) !!}
            </div>
            @endif
        </div>
       @if($settingStatus['stock'] == 1 && $prod->is_stock==1)
        <div class="row ">
            <div class="col-md-12">
                <div class="col-md-6 form-group">
                    {!! Form::label('Stock', 'Stock Update',['class'=>'control-label']) !!}
                    {!! Form::select('stock_type',["no" => "Please Select","1" => "Add", "0" => "Minus"],null,["class"=>'form-control',"id"=>"stock_type"]) !!}
                </div>
                <div class="col-md-6 form-group">
                    {!! Form::label('Stock Quantity', 'Stock Quantity',['class'=>'control-label']) !!}
                    {!! Form::number('stock_update_qty',null,["class"=>'form-control',"id"=>"stock_update_qty", "min"=>'0', "placeholder"=>"Stock Quantity", "onkeypress" => "return isNumber(event);"]) !!}
                    <span id="qtyerr"></span>
                </div>
                <div class="col-md-6 form-group">
                    {!! Form::label('Stock', 'Stock',['class'=>'control-label']) !!}
                    {!! Form::number('stock',$prod->stock,["class"=>'form-control', "min"=>'0',"id"=>"stock", "placeholder"=>"Stock","readonly", "required", "onkeypress" => "return isNumber(event);"]) !!}
                </div>   

                <div class="col-md-6 form-group">
                    {!! Form::label('Before Update Stock', 'Before Updated Stock',['class'=>'control-label']) !!}
                    {!! Form::number('before_updated_stock',$prod->stock,["class"=>'form-control',"id"=> "before_updated_stock", "min"=>'0', "placeholder"=>"Before Updated Stock","readonly", "required", "onkeypress" => "return isNumber(event);"]) !!}
                </div>   
            </div>

        </div> 
@else
<input type="hidden" name ="stock_type" value="1">

@endif

        <div class="line line-dashed b-b line-lg pull-in"></div>
        <div class="row col-md-12">
            <div class="form-group pull-right">
                <div class="col-sm-4 col-sm-offset-2">
                    {!! Form::submit('Submit',["class" => "btn btn-primary"]) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        </form>
    </div>
</div>

@stop 

@section('myscripts')

<script>
    $(document).ready(function () {
        $("#stock_type,#stock_update_qty").bind("change keyup", function () {
            $("#qtyerr").text('');
            var bus = $("#before_updated_stock").val();

            var stqty = $("#stock_update_qty").val();

            $("#qtyerr").text('');
            var stock_type = $("#stock_type").val();
            if (stock_type === "no") { // no change
                $("#stock_update_qty").val(0);
                $("#stock").val(bus);
                $("#qtyerr").text('Please select stock update type');
            } else if (stock_type === "0") { // minus qty
                if (stqty.length > 0) {
                    if (parseInt(stqty) < parseInt(bus)) {
                        var s = parseInt(bus) - parseInt(stqty);
                        $("#stock").val(s);
                    } else {
                        $("#stock").val(bus);
                        $("#qtyerr").text('you don\'t have enough stock to minus it ');
                    }
                } else {
                    $("#stock").val(bus);
                    $("#qtyerr").text('');
                }
            } else if (stock_type === "1") { // add qty
                if (stqty.length > 0) {
                    var s = parseInt(bus) + parseInt(stqty);
                    $("#stock").val(parseInt(s));
                } else {
                    $("#stock").val(bus);
                }
            }
        });

    });
    window.onunload = refreshParent;
    function refreshParent() {
        window.opener.location.reload();
    }
</script>
@stop