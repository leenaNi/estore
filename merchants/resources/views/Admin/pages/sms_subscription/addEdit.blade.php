
@extends('Admin.layouts.default')
@section('content')

<section class="content-header">
    <h1>
       SMS <!-- Subscription -->
        <small>Add/Edit</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"> SMS <!-- Subscription --></li>
        <li class="active"> Add/Edit</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div>
            <p style="color: red;text-align: center;">{{ Session::get('message') }}</p>
        </div>

        <div class="col-md-12">
            <div class="box">
                <div class="box-body">

                    {!! Form::model($smsSubscription, ['method' => 'post', 'files'=> true, 'url' => $action]) !!}

                 {!! Form::hidden('id',null) !!}

                 {!! Form::hidden('store_id', Session::get('store_id')) !!}
                    <div class="col-sm-6">
                    <div class="form-group">
                        {!!Form::label('pincode','Sms Rate ',['class'=>'control-label ']) !!}<span class="red-astrik"> *</span>
                            {!! Form::number('sms','0.5', ["class"=>'form-control' ,'readonly',"id"=>'sms_rate', 'value'=>"0.5"]) !!}
                        </div>
                    </div>

                    <div class="col-sm-6">
                    <div class="form-group">
                        {!!Form::label('no_of_sms','Purchase Count ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                            {!! Form::number('no_of_sms',null, ["class"=>'form-control validate[required,custom[number],min[1]]','id'=>'no_of_sms', "placeholder"=>'Enter No Of SMS']) !!}
                        </div>
                    </div>

                    <div class="col-sm-12">
                     <div class="form-group">
                        {!!Form::label('total_cost','Total Cost ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                        <div id='total_cost'></div>

                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="pull-right">
                                {!! Form::submit('Purchase',["class" => "btn btn-primary noLeftMargin"]) !!}

                                <a href="{{route('admin.smsSubscription.view') }}" class="btn btn-default">Cancel </a>
                                {!! Form::close() !!}
                            </div>
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
<script>
    $(document).ready(function(){

        $('#no_of_sms').keyup(function(){
        $('#total_cost').empty();
        var rate= $('#sms_rate').val();
        var number= $('#no_of_sms').val();
        var cost=rate*number;
       $('#total_cost').append(cost);
    });

    });
</script>



@stop
