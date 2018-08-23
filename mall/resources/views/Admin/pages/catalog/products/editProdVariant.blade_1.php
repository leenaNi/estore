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
        {!! Form::hidden('pid',$prod->parent_prod_id) !!}

        {!! Form::hidden("close","close") !!}
        <div class="row form-group col-md-12">

            @foreach($attrs as $id => $attr)
            <div class="col-md-2">

                {!! Form::label('select varient', 'Select ' . $attr['name'] ,['class'=>'control-label']) !!}
                {!! Form::select($id, $attr['options'] ,@$prod->attributes()->wherePivot("attr_id","=",$id)->first()->pivot->attr_val,["class"=>'form-control']) !!}
            </div>
            @endforeach

            <div class="col-md-2">
                {!! Form::label('Price', 'Price',['class'=>'control-label']) !!}
                {!! Form::number("price",$prod->price,["class"=>"form-control","min"=>"0"]) !!}
            </div>

            <div class="col-md-2">
                {!! Form::label('Stock', 'Stock',['class'=>'control-label']) !!}
                {!! Form::number("stock",$prod->stock,["class"=>"form-control","min"=>"1"]) !!}
            </div>



            <div class="col-md-2">
                {!! Form::label('is_avail', 'Availability',['class'=>'control-label']) !!}
                {!! Form::select("is_avail",['1'=>'Yes','0'=>'No'],$prod->is_avail,["class"=>"form-control"]) !!}
            </div>


        </div> 


        <div class="line line-dashed b-b line-lg pull-in"></div>

        <div class="form-group">
            <div class="col-sm-4 col-sm-offset-2">
                {!! Form::submit('Submit',["class" => "btn btn-primary"]) !!}
                {!! Form::close() !!}     


            </div>
        </div>
        </form>
    </div>
</div>

@stop 

@section('myscripts')

<script>
    $(document).ready(function () {


    });
    window.onunload = refreshParent;
    function refreshParent() {
        window.opener.location.reload();
    }
</script>
@stop