@extends('Admin.Layouts.default')

@section('contents')

<section class="content-header">
    <h1>  Courier Service </h1>
    <ol class="breadcrumb">
           <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class=""><a href="{{route('admin.courier.view')}}" > Courier Service </a></li>
        <li class="active">Add/Edit</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="nav-tabs-custom">
                    
                    <div >
                        <div class="tab-pane active" id="bank_tab_1">
                            <div class="row"> 
                       <div class="col-md-12 col-xs-12"> 
                        {!! Form::model($courier, ['method' => 'post', 'files'=> true, 'url' => $action ,'id'=>'EditGeneralInfo']) !!}

                        {!! Form::hidden('id',null) !!}

                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::label('name', ' Name ') !!}<span class="red-astrik"> *</span>
                                {!! Form::text('name',null, ["class"=>'form-control validate[required]' ,"placeholder"=>'Service Provider Name']) !!}
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">              
                                {!!form::label('status','Status ', ["class"=> 'control-label']) !!}<span class="red-astrik"> *</span>
                                {!! form::select('status',["1"=>"Enabled","0"=>"Disabled"],null,["class"=>'form-control validate[required]', "placeholder"=>'Select Status']) !!}
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::label('Preference', 'Preference ') !!}<span class="red-astrik"> *</span>
                                {!! Form::text('pref',null, ["class"=>'form-control validate[required,custom[number]]' ,"placeholder"=>'Preference']) !!}
                                <p style="color: red;" class="errorPrdCode"></p>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::label('charges', 'Charges ') !!}<span class="red-astrik"> *</span>
                                {!! Form::text('charges',null, ["class"=>'form-control validate[required,custom[number]]' ,"placeholder"=>'Charges']) !!}
                                <p style="color: red;" class="errorCharges"></p>
                            </div>
                        </div>

                        @if(!empty($courier->details))
                        <?php
                        $details = json_decode($courier->details);
                        // dd($courier->details);
                        ?>
                        @foreach($details as $detK => $detV)



                        <div class="col-md-6">
                            <div class="form-group">

                                <?php
                                $label = $detK;
                                ?>
                                {!! Form::label($label, ucfirst(str_replace("_"," ",$label)),['class'=>'control-label']) !!}

                                {!! Form::text("details[$detK]",$detV, ["class"=>'form-control validate[required]' ,"placeholder"=>str_replace("_"," ",ucfirst($label))]) !!}
                            </div>
                        </div>
                        @endforeach

                        @endif
                        <div class="line line-dashed b-b line-lg pull-in"></div>
                        <div class="form-group col-sm-12 ">
                            {!! Form::submit('Submit',["class" => "btn btn-primary margin-left0"]) !!}

                        </div>
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
