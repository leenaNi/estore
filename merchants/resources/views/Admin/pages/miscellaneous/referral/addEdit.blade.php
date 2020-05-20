@extends('Admin.layouts.default')

@section('content')

<section class="content-header">
    <h1>
      Referal Program
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
       
        <li class="active">Referal Program  </li>
        <li class="active"> Add/Edit</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">   
                <div class="box-body">
                    {!! Form::model($settings, ['method' => 'post', 'files'=> true, 'url' => $action ]) !!}
                    {!! Form::hidden('url_key',null) !!}

                    <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('Name', 'Name',['class'=>'control-label']) !!}

                            {!! Form::text('name',null, ["class"=>'form-control' ,"placeholder"=>'Enter Name', "required","disabled"=>true]) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('Status', 'Status',['class'=>'control-label']) !!}
                      
                        {!! Form::select('status',[''=>'Please Select','1'=>'Enabled','0'=>'Disabled'],null,["class"=>'form-control' ,"required"]) !!}
                       
                         
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <input type="hidden" name="type" value="{{ (Input::get('type'))?Input::get('type'):2 }}">
                    @if(!empty($settings->details))
                    <?php
                    $details = json_decode($settings->details);
                    ?>
                    @foreach($details as $detK => $detV)



                    <div class="col-md-6">
                        <div class="form-group">

                            <?php
                            $label = $detK;

                            if ($detK == "activate_duration_in_days")
                                $label = "Activate after (Days) ";

                            if ($detK == "bonous_to_referee")
                                $label = "Referee rewards (%)";

                            if ($detK == "discount_on_order")
                                $label = "Referral rewards (%)";
                            ?>
                            {!! Form::label($label, ucfirst(str_replace("_"," ",$label)),['class'=>'control-label']) !!}

                            {!! Form::text("details[$detK]",$detV, ["class"=>'form-control' ,"placeholder"=>ucfirst($label), "required"]) !!}
                        </div>
                    </div>
                    @endforeach

                    @endif

                    <div class="col-md-12">
                    <div class="form-group">
                        <div class="pull-right">
                            {!! Form::submit('Update',["class" => "btn btn-primary noLeftMargin"]) !!}
                            {!! Form::close() !!}     
                          

                        </div>
                    </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>


@stop

