@extends('Admin.layouts.default')
@section('content')

<section class="content-header">
    <h1>
        {{ ucfirst(Input::get('url_key')) }}
         <small>Add/Edit</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <?php
        $urlT = App\Models\GeneralSetting::where('url_key',Input::get('url_key'))->first()->type;

        if ($urlT == 1) {
            $textinfo = "General setting";
            $getUrl = route('admin.generalSetting.view');
        }

        if ($urlT == 2) {
            $textinfo = "Payment setting";
            $getUrl = route('admin.paymentSetting.view');
        }

        if ($urlT == 3) {
            $textinfo = "Advance setting";
            $getUrl = route('admin.advanceSetting.view');
        }
        
        if ($urlT == 4) {
            $textinfo = "Email setting";
            $getUrl = route('admin.emailSetting.view');
        }
        ?>
        <li class="active"> {{ $textinfo }} </li>
        <li class="active"> Add/Edit </li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">   
                <div class="box-body">
                    {!! Form::model($settings, ['method' => 'post', 'files'=> true, 'url' => $action  ]) !!}
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
                            {!! Form::select('status',[''=>'Please Select','1'=>'Enabled','2'=>'Disabled'],null,["class"=>'form-control' ,"required"]) !!}
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <input type="hidden" name="type" value="{{ (Input::get('type')) ? Input::get('type') : 4 }}">
                    @if(!empty($settings->details))
                    <?php
                    $details = json_decode($settings->details);
                  //  dd($details);
                    ?>
                    @foreach($details as $detK => $detV)
                   
                   @if($detK!='username' && $detK!="password" )
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
                            {!! Form::text("details[$detK]",$detV, ["class"=>'form-control' ,"placeholder"=>ucfirst($label)]) !!}
                        </div>
                    </div>
                   @else 
                   <input type="hidden" name="{{$detK}}" value="{{$detV}}">
                   @endif
                    @endforeach

                    @endif
                    <div class="col-md-12">
                    <div class="form-group">
                        <div class="pull-right">
                            {!! Form::submit('Update',["class" => "btn btn-primary noLeftMargin"]) !!}
                            {!! Form::close() !!}     
                            <a class="btn btn-default" href="{{ route('admin.emailSetting.view') }}"> Close </a>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


@stop

