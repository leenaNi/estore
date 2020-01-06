@extends('Admin.layouts.default')
@section('content')

<section class="content-header">
    <h1>
        Order Status
        <small>Add/Edit</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"> Order Status </li>
        <li class="active">Add/Edit</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div>
            <p style="color: red;text-align: center;">{{ Session::get('messege') }}</p>
        </div>

        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    {!! Form::model($status, ['method' => 'post', 'files'=> true, 'url' => $action , 'class' => 'form-horizontal' ]) !!}

                    <div class="form-group{{ $errors->has('order_status') ? ' has-error' : '' }}">
                        <div class="col-md-2 col-sm-3 col-xs-12 text-right mobTextLeft">
                        {!! Form::label('order_status', 'Order Status ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
</div>
                        {!! Form::hidden('id',null) !!}
                        <div class="col-md-10 col-sm-9 col-xs-12">
                            {!! Form::text('order_status',null, ["class"=>'form-control validate[required]',"id"=>'order_status' ,"placeholder"=>'Order Status']) !!}
                            <span id='error_msg'></span>

                            @if ($errors->has('order_status'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('order_status') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="line line-dashed b-b line-lg pull-in"></div>

                    @if($new)
                        {!! Form::hidden('status',1) !!}
                    @endif

                    <div class="line line-dashed b-b line-lg pull-in"></div>

                    <div class="form-group">
                        <div class="col-sm-12">
                            {!! Form::submit('Submit',["class" => "btn btn-primary noLeftMargin pull-right mobFloatLeft"]) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section> 
@stop 

@section('myscripts')
<script src="{{ asset('public/Admin/plugins/ckeditor/ckeditor.js') }}"></script>
<script>
    
</script>



@stop