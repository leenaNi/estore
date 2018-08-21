@extends('Admin.layouts.default')

@section('mystyles')

<link rel="stylesheet" href="{{ asset('public/Admin/dist/css/jquery.tagit.css') }}">

@stop

@section('content')

<section class="content-header">
    <div class="flash-message"><b>{{ Session::get("ProductCode") }} {{ Session::get("errorMessage") }}</b></div>
    <h1>
        Products

    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Products</li>
        <li class="active">Add/Edit</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
            <div class="box-header col-md-3 noBottompadding">
                    <a class="btn btn-default pull-right col-md-12" type="button" data-toggle="modal" data-target="#addExtraDetails">Add Extra Details</a>
                </div>
            </div>
        </div>
    </div>
    <div class="nav-tabs-custom"> 
        {!! view('Admin.includes.productHeader',['id' => $prod->id, 'prod_type' => $prod->prod_type]) !!}

        <div class="tab-content">
            <div class="tab-pan-active" id="activity">
                <div class="panel-body">
                    {!! Form::model($prod, ['method' => 'post', 'files'=> true, 'url' => $action ,'id'=>'EditAttributeInfo' ,'class' => 'form-horizontal' ]) !!}
                    {!! Form::hidden('id',null) !!}
                    {!! Form::hidden('updated_by', Auth::id()) !!}
                    <?php
                    foreach ($attributes as $attribute):
                        $required = $attribute['is_required'] ? "required" : NULL;
                        switch ($attribute['attr_type']) {
                            case '1':
                                $options = NULL;
                                foreach ($attribute['attributeoptions'] as $val) {
                                    $options[$val['option_value']] = $val['option_name'];
                                }
                                ?>
                                <div class="form-group">                                    
                                    {!! Form::label($attribute['attr'], $attribute['attr'],['class'=>'form-group col-sm-2 '.$required]) !!}
                                    <div class="col-sm-10">
                                        {!! Form::select("attributes[".$attribute['id']."][attr_val]",$options,@$attribute['value'], ["class"=>'form-control' ,"placeholder"=>$attribute['placeholder'], $required ]) !!}
                                        {!! Form::hidden("attributes[".$attribute['id']."][attr_type_id]",$attribute['attr_type']) !!}
                                    </div>
                                </div>
                                <?php
                                break;
                            case '2':
                                $options = NULL;
                                foreach ($attribute['attributeoptions'] as $val) {
                                    $options[$val['option_value']] = $val['option_name'];
                                }
                                ?>
                                <div class="form-group">                                    
                                    {!! Form::label($attribute['attr'], $attribute['attr'],['class'=>'form-group col-sm-2 '.$required]) !!}
                                    <div class="col-sm-10">
                                        {!! Form::select("attributes[".$attribute['id']."][attr_val][]",$options,@$attribute['value'], ["class"=>'form-control', "multiple", $required]) !!}
                                        {!! Form::hidden("attributes[".$attribute['id']."][attr_type_id]",$attribute['attr_type']) !!}
                                    </div>
                                </div>
                                <?php
                                break;
                            case '3':
                                ?>
                                <div class="form-group">                                    
                                    {!! Form::label($attribute['attr'], $attribute['attr'],['class'=>'form-group col-sm-2 '.$required]) !!}
                                    <div class="col-sm-10">
                                        {!! Form::text("attributes[".$attribute['id']."][attr_val]",@$attribute['value'], ["class"=>'form-control' ,"placeholder"=>$attribute['placeholder'], $required]) !!}
                                        {!! Form::hidden("attributes[".$attribute['id']."][attr_type_id]",$attribute['attr_type']) !!}
                                    </div>
                                </div>
                                <?php
                                break;
                            case '4':
                                ?>
                                <div class="form-group">                                    
                                    {!! Form::label($attribute['attr'], $attribute['attr'],['class'=>'form-group col-sm-2 '.$required]) !!}
                                    <div class="col-sm-10">
                                        @foreach ($attribute['attributeoptions'] as $val) 
                                        {!! Form::radio("attributes[".$attribute['id']."][attr_val]", $val['option_value'], @$attribute['value'] == $val['option_value']? true:false ) !!} {{$val['option_name']}} &nbsp;&nbsp;&nbsp;&nbsp;                                                    
                                        @endforeach
                                        {!! Form::hidden("attributes[".$attribute['id']."][attr_type_id]",$attribute['attr_type']) !!}
                                    </div>
                                </div>
                                <?php
                                break;
                            case '5':
                                ?>
                                <div class="form-group">                                    
                                    {!! Form::label($attribute['attr'], $attribute['attr'],['class'=>'form-group col-sm-2 '.$required]) !!}
                                    <div class="col-sm-10">                              
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
                                <div class="form-group">                                    
                                    {!! Form::label($attribute['attr'], $attribute['attr'],['class'=>'form-group col-sm-2 '.$required]) !!}
                                    <div class="col-sm-10">
                                        {!! Form::text("attributes[".$attribute['id']."][attr_val]",@$attribute['value'], ["class"=>'form-control datepicker' ,"placeholder"=>$attribute['placeholder'], $required]) !!}
                                        {!! Form::hidden("attributes[".$attribute['id']."][attr_type_id]",$attribute['attr_type']) !!}
                                    </div>
                                </div>
                                <?php
                                break;
                            case '7':
                                ?>
                                <div class="form-group">                                    
                                    {!! Form::label($attribute['attr'], $attribute['attr'],['class'=>'form-group col-sm-2 '.$required]) !!}
                                    <div class="col-sm-10">
                                        {!! Form::text("attributes[".$attribute['id']."][attr_val]",@$attribute['value'], ["class"=>'form-control timepicker' ,"placeholder"=>$attribute['placeholder'], $required]) !!}
                                        {!! Form::hidden("attributes[".$attribute['id']."][attr_type_id]",$attribute['attr_type']) !!}
                                    </div>
                                </div>
                                <?php
                                break;
                            case '8':
                                ?>
                                <div class="form-group">                                    
                                    {!! Form::label($attribute['attr'], $attribute['attr'],['class'=>'form-group col-sm-2 '.$required]) !!}
                                    <div class="col-sm-10">
                                        {!! Form::text("attributes[".$attribute['id']."][attr_val]",@$attribute['value'], ["class"=>'form-control datetimepicker' ,"placeholder"=>$attribute['placeholder'], $required]) !!}
                                        {!! Form::hidden("attributes[".$attribute['id']."][attr_type_id]",$attribute['attr_type']) !!}
                                    </div>
                                </div>
                                <?php
                                break;
                            case '9':
                                ?>
                                <div class="form-group">                                    
                                    {!! Form::label($attribute['attr'], $attribute['attr'],['class'=>'form-group col-sm-2 '.$required]) !!}
                                    <div class="col-sm-10">
                                        {!! Form::text("attributes[".$attribute['id']."][attr_val]",@$attribute['value'], ["class"=>'form-control multidatepicker' ,"placeholder"=>$attribute['placeholder'], $required]) !!}
                                        {!! Form::hidden("attributes[".$attribute['id']."][attr_type_id]",$attribute['attr_type']) !!}
                                    </div>
                                </div>
                                <?php
                                break;
                            case '10':
                                ?>
                                <div class="form-group">
                                    {!! Form::label($attribute['attr'], $attribute['attr'],['class'=>'form-group col-sm-2 '.$required]) !!}
                                    <div class="col-sm-10">
                                        {!! Form::file("attributes[".$attribute['id']."][attr_val]",["class"=>'form-control' , $required]) !!}
                                        {!! Form::hidden("attributes[".$attribute['id']."][attr_type_id]",$attribute['attr_type']) !!}
                                        {!! Form::hidden("attributes[".$attribute['id']."][file_val]",@$attribute['value']) !!}
                                    </div>
                                    <div class="col-md-10" style="height: 50px;line-height: 50px;padding-top: 8px;">
                                        <?php if (isset($attribute['value'])): ?>
                                            <a href="{{ asset('public/Uploads/product/')."/". $attribute['value'] }}" target="_BLANK"><i class="fa fa-file"></i></a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php
                                break;
                            case '11':
                                ?>
                                <div class="form-group">
                                    {!! Form::label($attribute['attr'], $attribute['attr'],['class'=>'form-group col-sm-2 '.$required]) !!}
                                    <div class="col-sm-10">
                                        {!! Form::file("attributes[".$attribute['id']."][attr_val]",["class"=>'form-control' , $required, "accept"=>"image/x-png, image/jpeg"]) !!}
                                        {!! Form::hidden("attributes[".$attribute['id']."][attr_type_id]",$attribute['attr_type']) !!}
                                        {!! Form::hidden("attributes[".$attribute['id']."][image_val]",@$attribute['value']) !!}
                                    </div>
                                    <div class="col-md-10" style="height: 50px;line-height: 50px;padding-top: 8px;">
                                        <?php if (isset($attribute['value'])): ?>
                                            <a href="{{ asset('public/Uploads/product/')."/". $attribute['value'] }}" target="_BLANK"><img src="{{asset('public/Uploads/product/')."/". $attribute['value'] }}" style="height: 50px; width: 50px;margin-right: 5px;" /></a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php
                                break;
                            case '12':
                                ?>
                                <div class="form-group">                                    
                                    {!! Form::label($attribute['attr'], $attribute['attr'],['class'=>'form-group col-sm-2 '.$required]) !!}
                                    <div class="col-sm-10">
                                        {!! Form::textarea("attributes[".$attribute['id']."][attr_val]",@$attribute['value'], ["class"=>'form-control editor' ,"placeholder"=>$attribute['placeholder'], $required]) !!}
                                        {!! Form::hidden("attributes[".$attribute['id']."][attr_type_id]",$attribute['attr_type']) !!}
                                    </div>
                                </div>
                                <?php
                                break;
                            case '13':
                                ?>
                                <div class="form-group">                                    
                                    {!! Form::label($attribute['attr'], $attribute['attr'],['class'=>'form-group col-sm-2 '.$required]) !!}
                                    <div class="col-sm-10">
                                        {!! Form::textarea("attributes[".$attribute['id']."][attr_val]",@$attribute['value'], ["class"=>'form-control' ,"placeholder"=>$attribute['placeholder'], $required]) !!}
                                        {!! Form::hidden("attributes[".$attribute['id']."][attr_type_id]",$attribute['attr_type']) !!}
                                    </div>
                                </div>
                                <?php
                                break;
                            case '14':
                                ?>
                                <div class="form-group">                                    
                                    {!! Form::label($attribute['attr'], $attribute['attr'],['class'=>'form-group col-sm-2 '.$required]) !!}
                                    <div class="col-sm-10">
                                        {!! Form::number("attributes[".$attribute['id']."][attr_val]",@$attribute['value'], ["class"=>'form-control' ,"placeholder"=>$attribute['placeholder'], $required]) !!}
                                        {!! Form::hidden("attributes[".$attribute['id']."][attr_type_id]",$attribute['attr_type']) !!}
                                    </div>
                                </div>
                                <?php
                                break;
                            case '15':
                                ?>
                                <div class="form-group">                                    
                                    {!! Form::label($attribute['attr'], $attribute['attr'],['class'=>'form-group col-sm-2 '.$required]) !!}
                                    <div class="col-sm-10">
                                        {!! Form::select("attributes[".$attribute['id']."][attr_val]",['Yes'=>'Yes', 'No'=>'No'] ,@$attribute['value'], ["class"=>'form-control' ,"placeholder"=>$attribute['placeholder'], $required]) !!}
                                        {!! Form::hidden("attributes[".$attribute['id']."][attr_type_id]",$attribute['attr_type']) !!}
                                    </div>
                                </div>
                                <?php
                                break;
                            case '16':
                                ?>
                                <div class="form-group">
                                    {!! Form::label($attribute['attr'], $attribute['attr'],['class'=>'form-group col-sm-2 '.$required]) !!}
                                    <div class="col-sm-10"> 
                                        {!! Form::file("attributes[".$attribute['id']."][attr_val][]", ["class"=>'form-control' ,"multiple", $required]) !!}
                                        {!! Form::hidden("attributes[".$attribute['id']."][attr_type_id]",$attribute['attr_type']) !!}
                                        {!! Form::hidden("attributes[".$attribute['id']."][file_multi_val]",@$attribute['value']) !!}
                                    </div>
                                    <div class="col-md-10" style="height: 50px;line-height: 50px;padding-top: 8px;">
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
                                <div class="form-group">
                                    {!! Form::label($attribute['attr'], $attribute['attr'],['class'=>'form-group col-sm-2 '.$required]) !!}
                                    <div class="col-sm-10">
                                        {!! Form::file("attributes[".$attribute['id']."][attr_val][]", ["class"=>'form-control' ,"multiple", $required, "accept"=>"image/x-png, image/jpeg"]) !!}
                                        {!! Form::hidden("attributes[".$attribute['id']."][attr_type_id]",$attribute['attr_type']) !!}
                                        {!! Form::hidden("attributes[".$attribute['id']."][image_multi_val]",@$attribute['value']) !!}
                                    </div>
                                    <div class="col-md-10" style="height: 50px;line-height: 50px;padding-top: 8px;">
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
                        }
                    endforeach;
                    ?>

                    {!! Form::hidden('return_url',null,['class'=>'rtUrl']) !!}

                    <div class="line line-dashed b-b line-lg pull-in"></div>

                    <div class="form-group col-sm-12 ">
                        {!! Form::button('Save & Exit',["class" => "btn btn-primary pull-right saveExit"]) !!}
                        {!! Form::button('Save & Continue',["class" => "btn btn-primary pull-right saveContine"]) !!}
                        {!! Form::submit('Save & Next',["class" => "btn btn-primary pull-right"]) !!}
                    </div>
                    {!! Form::close() !!}     
                </div>
            </div>
        </div>
    </div>

<!-- open Model for Attributes -->

    <div class="modal fade" id="addExtraDetails" role="dialog">
    <div class="modal-dialog" style="width: 75%;top:40px">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add Attribute</h4>
        </div>
        <div class="modal-body">
          
           <div class="box">
                <div class="box-body">

                    {!! Form::model($attrs, ['method' => 'post', 'files'=> true, 'url' => route("admin.attributes.save") , 'class' => 'form-horizontal' ]) !!}
                    {!! Form::hidden('prod_id',$prod->id) !!}
                    {!! Form::hidden('etxradetail',1) !!}
                    {!! Form::hidden('attr_set[]',$prod->attr_set) !!}
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        {!! Form::label('Attribute type', 'Attribute Type',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('attr_type',$attr_types , null, ["class"=>'form-control attr_type',"required"] ) !!}                            
                        </div>

                    </div>
                    <div class="form-group">
                        {!! Form::label('Attribute Name', 'Attribute Name <span class="red-astrik"> *</span>',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('attr',null, ["id"=>"attrName","class"=>'form-control' ,"placeholder"=>'Enter Attribute Name', "required"]) !!}
                            <span id="error_msg"></span>
                        </div>

                    </div>
                    <div class="form-group">
                        {!! Form::label('placeholder', 'Placeholder',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('placeholder' ,null, ["class"=>'form-control', "placeholder"=>"Attribute Placeholder"]) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('sort order', 'Sort Order',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::number('att_sort_order' ,null, ["class"=>'form-control', "placeholder"=>"Sort Order"]) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('is_filterable', 'Is Filterable',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('is_filterable',["0" => "No", "1" => "Yes"],null,["class"=>'form-control'],"required") !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('is_required', 'Is Required',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('is_required',["0"=>"No","1"=>"Yes"] ,null, ["class"=>'form-control', "required"]) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('status', 'Status',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::select('status',["1"=>"Enabled","0"=>"Disabled"] ,null, ["class"=>'form-control', "required"]) !!}
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>

                    @if(isset($attrs->attr_type))
                    <div class="form-group attr-options" style="{{  $attrs->attr_type == 1 || $attrs->attr_type == 2 || $attrs->attr_type == 4 || $attrs->attr_type == 5 ? 'display:block;' : 'display:none;'}}">
                        @else 
                        <div class="form-group attr-options" style="display:none;">
                            @endif             
                            {!! Form::label('Attribute Options', 'Attribute Options',['class'=>'col-sm-2 control-label']) !!}

                            <div class="col-sm-9 col-md-9  attrOptn">
                                @if(isset($attrs->attr_type))
                                @if(count($attrs->attributeoptions) > 0)
                                @foreach($attrs->attributeoptions as $opt)
                                <div class="row form-group">
                                    <div class="col-sm-3">
                                        {!! Form::text('option_name[]',$opt->option_name, ["class"=>'form-control' ,"placeholder"=>'Enter Option Name', "required"]) !!}
                                    </div>
                                    <div class="col-sm-3">
                                        {!! Form::text('option_value[]',$opt->option_value, ["class"=>'form-control' ,"placeholder"=>'Enter Option Value', "required"]) !!}
                                    </div>
                                    <div class="col-sm-3">
                                        {!! Form::select('is_active[]',["0" => "No", "1" => "Yes"],$opt->is_active,["class"=>'form-control'],"required") !!}
                                    </div>
                                    <div class="col-sm-2">
                                        {!! Form::text('sort_order[]',$opt->sort_order, ["class"=>'form-control' ,"placeholder"=>'Enter Sort Order', "required"]) !!}
                                    </div>

                                    {!! Form::hidden('idd[]',$opt->id) !!}

                                </div>
                                @endforeach
                                 @endif
                                @else
                                
                             <div class="row form-group">
                                <div class="col-sm-3">
                                    {!! Form::text('option_name[]',null, ["class"=>'form-control' ,"placeholder"=>'Enter Option Name', "required"]) !!}
                                </div>
                                <div class="col-sm-3">
                                    {!! Form::text('option_value[]',null, ["class"=>'form-control' ,"placeholder"=>'Enter Option Value', "required"]) !!}
                                </div>
                                <div class="col-sm-3">
                                    {!! Form::select('is_active[]',[ "1" => "Yes", "0" => "No"],null,["class"=>'form-control'],"required") !!}
                                </div>
                                <div class="col-sm-2">
                                    {!! Form::text('sort_order[]',null, ["class"=>'form-control' ,"placeholder"=>'Enter Sort Order', "required"]) !!}
                                </div>

                            </div>
                               
                                @endif
                            </div>

                            <div class="col-sm-1">
                                {!! Form::hidden('idd[]',null) !!}
                                <a href="javascript:void()" data-toggle="tooltip" title="Add" class="addMore"><i class="fa fa-plus" aria-hidden="true"></i></a> 
                            </div>
                        </div>
                        <div class="line line-dashed b-b line-lg pull-in"></div>
                        <div class="form-group modal-footer">
                            <div class="col-sm-11 ">
                                {!! Form::submit('Submit',["class" => "btn btn-primary pull-right"]) !!}
                                {!! Form::close() !!}
                            </div>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div> -->
      </div>
      
    </div>
  </div>

<!-- Close Popup Model -->

  <div id="toClone" style="display: none;">
    <div class="row form-group">
        <div class="col-sm-3">
            {!! Form::text('option_name[]',null, ["class"=>'form-control' ,"placeholder"=>'Enter Option Name', "required"]) !!}
        </div>
        <div class="col-sm-3">
            {!! Form::text('option_value[]',null, ["class"=>'form-control' ,"placeholder"=>'Enter Option Value', "required"]) !!}
        </div>
        <div class="col-sm-3">
            {!! Form::select('is_active[]',["1" => "Yes", "0" => "No"],null,["class"=>'form-control'],"required") !!}
        </div>
        <div class="col-sm-2">
            {!! Form::text('sort_order[]',null, ["class"=>'form-control' ,"placeholder"=>'Enter Sort Order', "required"]) !!}
        </div>
        <div class="col-sm-1">
            {!! Form::hidden('idd[]',null) !!}
            <a href="javascript:void();" data-toggle="tooltip" title="Delete" class="deleteOpt" ><i class="fa fa-trash-o" aria-hidden="true"></i></a> 
        </div>
    </div>
</div>
</section>

@stop 

@section('myscripts')
<script src="{{ asset('public/Admin/dist/js/tag-it.min.js') }}"></script>
<script>

$(".saveContine").click(function () {
    if ($('#EditAttributeInfo')[0].checkValidity()) {
        $(".rtUrl").val("{!!route('admin.products.attribute',['id'=>Input::get('id')])!!}");
        $("#EditAttributeInfo").submit();
    } else {
        $('#EditAttributeInfo').find(':submit').click()
    }
});
$(".saveExit").click(function () {
    if ($('#EditAttributeInfo')[0].checkValidity()) {
        $(".rtUrl").val("{!!route('admin.products.view')!!}");
        $("#EditAttributeInfo").submit();
    } else {
        $('#EditAttributeInfo').find(':submit').click()
    }
});



$("#myTags").tagit({
    caseSensitive: false,
    singleField: true,
    singleFieldDelimiter: ","
});

</script>
<script>
<?php
if (isset($attrs->attr_type))
    if (!in_array($attrs->attr_type, [1, 2, 4, 5])):
        ?>
            $(".attr-options").find('input,select').prop('disabled', true);
<?php  endif; ?>
    $(".attr_type").change(function () {
        $this = $(this);
        if ($this.val() == 1 || $this.val() == 2 || $this.val() == 4 || $this.val() == 5) {
            $(".attr-options").show().find('input,select').prop('disabled', false);
        } else {
            $(".attr-options").hide().find('input,select').prop('disabled', true);
        }
    });

    $(".addMore").click(function () {
        $(".attrOptn").append($("#toClone").html());
    });


    $("body").on("click", ".deleteOpt", function () {
        $(this).parent().parent().remove();
    });

    $(document).ready(function () {
        $("#attrName").blur(function () {
            var attr = $(this).val();
            var prod_id = $("input[name=id]").val();
            console.log(prod_id);
            $.ajax({
                type: "POST",
                url: "{{ route('admin.products.checkattr') }}",
                data: {attr: attr,prod_id:prod_id},
                cache: false,
                success: function (response) {

                     console.log(response);
                    if (response['status'] == 'success') {
                        $('#attrName').val('');
                        $('#error_msg').text(response['msg']).css({'color': 'red'});
                    } else
                        $('#error_msg').text('');
                }, error: function (e) {
                    console.log(e.responseText);
                }
            });
        });
    });
</script>
@stop