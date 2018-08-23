@extends('Admin.layouts.default')
@section('content')


<!--<div class="bg-light lter b-b wrapper-md">
    <h1 class="m-n font-thin h3">Product Fabrics</h1>
</div>-->
<div class="bg-light lter b-b wrapper-md">
    <h1 class="m-n font-thin h3">Products</h1>
</div>
<!--<div class="panel panel-default">-->

<div class="wrapper-md">
    <div class="tab-container">
        {!! view('Admin.includes.productHeader',['id' => $prod->id, 'prod_type' => $prod->prod_type]) !!}
        <div class="tab-content">


            <div class="panel-body">

                {!! Form::model($prod, ['method' => 'post', 'route' => $action ,'id'=>'EditFabricInfo' ,'class' => 'form-horizontal' ]) !!}
                @foreach($finish as $fin)
                @if($fin->fabrics->count() > 0)
                <div class="form-group">  
                    {!! Form::hidden('id',null) !!}
                    {!!Form::label($fin->finish,$fin->finish,['class'=>'col-sm-2 control-label']) !!}

                    <div class="col-sm-10 pull-right">
                        <div class="col-sm-12 col-xs-12 col-md-12">
                            <label for="checkall{{ $fin->id }}" class="control-label"><input type="checkbox" id="checkall{{ $fin->id }}"  class="checkall" name="chkAll"> <strong>Select All</strong></label>
                        </div>
                        @foreach($fin->fabrics as $fab)
                        <div class="col-sm-3 col-xs-3 col-md-3">
                            <label for="fab{{ $fab->id }}" class="control-label">
                                <input type="checkbox"  value="{{ $fab->id }}" id="fab{{ $fab->id }}" {{ in_array($fab->id, array_flatten($prod->fabrics()->get(['fabric_id'])->toArray())) ? 'checked' : ''  }} name="fab[]">  
                                       <img src="{{asset('public/admin/uploads/catalog/fabrics/')."/".$fab->image}}" width="50" />
                                {{ $fab->fabric }}
                            </label>
                        </div>

                        @endforeach
                    </div> 

                </div>
                <div class="line line-dashed b-b line-lg pull-in"></div>
                @endif
                @endforeach
                {!! Form::hidden('return_url',null,['class'=>'rtUrl']) !!}

                <div class="form-group col-sm-12 ">
                    {!! Form::button('Save & Exit',["class" => "btn btn-primary pull-right saveFabricExit"]) !!}
                    {!! Form::button('Save & Continue',["class" => "btn btn-primary pull-right saveFabricContine"]) !!}
                    {!! Form::submit('Save & Next',["class" => "btn btn-primary pull-right"]) !!}
                </div>
                <div class="form-group">

                    <!--                        {!! Form::submit('Submit',["class" => "btn btn-primary"]) !!}-->
                    {!! Form::close() !!}     



                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop 

@section('myscripts')
<script>

    $(document).ready(function() {
        $(".saveFabricContine").click(function() {
            $(".rtUrl").val("{!!route('admin.products.fabrics',['id'=>Input::get("id")])!!}");
            $("#EditFabricInfo").submit();

        });
        $(".saveFabricExit").click(function() {
            $(".rtUrl").val("{!!route('admin.products.view')!!}");
            $("#EditFabricInfo").submit();

        });


    });


    $(".checkall").click(function(event) {
        var checkbox = $(this);
        var isChecked = checkbox.is(':checked');
        if (isChecked) {
            $(this).parent().parent().parent().find("[type=checkbox]").prop("checked", true);
        } else {
            $(this).parent().parent().parent().find("[type=checkbox]").removeAttr("checked");
        }
    });
</script>
@stop