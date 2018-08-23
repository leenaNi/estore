@extends('Admin.layouts.default')

@section('content')

<section class="content-header">
    <h1>
        {{ ucfirst(Input::get('url_key'))}} program 
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <?php
        $urlT = App\Models\GeneralSetting::where('url_key',Input::get('url_key'))->first()->type;

        if ($urlT == 3) {
            $textinfo = "Advance setting";
            $getUrl = route('admin.advanceSetting.view');
        }

        if ($urlT == 2) {
            $textinfo = "Payment setting";
            $getUrl = route('admin.paymentSetting.view');
        }


        if ($urlT == 1) {
            $textinfo = "General setting";
            $getUrl =  route('admin.generalSetting.view');
        }
        ?>
        <li class="active"> {{ $textinfo }} </li>
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
                        <?php if(Input::get('url_key')) { ?>
                        {!! Form::select('status',[''=>'Please Select','1'=>'Enabled','0'=>'Disabled'],null,["class"=>'form-control' ,"required"]) !!}
                        <?php } ?> 
                         
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
                            <a class="btn btn-default" href="{{ $getUrl }}"> Close </a>
<!--                            
                            <?php //if($urlT == 2) { ?>
                             <a class="btn btn-default" href="{{ $getUrl }}"> Close </a>
                        <?php //} //elseif($urlT == 3) {?> 
                             <a class="btn btn-default" href="{{ route('admin.advanceSetting.view') }}"> Close </a>
                              <?php //}else{ ?> 
                               
                             <a class="btn btn-default" href="{{ route('admin.generalSetting.view') }}"> Close </a>
                           <?php //} ?> -->
                        </div>
                    </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>


@stop

