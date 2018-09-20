@extends('Admin.layouts.default')
@section('content')

<section class="content-header">
    <h1>
        Pincodes
        <small>Add/Edit</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class=""> <a href="{{route('admin.pincodes.view')}} " >Pincodes</a> </li>
        <li class="active">Add/Edit</li>
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

                    {!! Form::model($pincodes, ['method' => 'post', 'files'=> true, 'url' => $action]) !!}

                    {!! Form::hidden('id',null) !!}

                    <div class="row">
                        <div class='col-sm-12'> 
                            <div class="form-group">
                                {!!Form::label('pincode','Pincode ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                                {!! Form::text('pincode',null, ["class"=>'form-control validate[required,custom[number]]',"id"=>'email' ,"placeholder"=>'Pincode']) !!}

                            </div>
                        </div>
                    </div>
                    @if($feature['cod'] == 1)    
                    <div class="row">
                        <div class='col-sm-12'>     
                            <div class="form-group">
                                {!!form::label('cod_status','COD Status ', ["class"=> 'control-label']) !!}<span class="red-astrik"> *</span>
                                {!! form::select('cod_status',["1"=>"Applicable","0"=>"Not Applicable"],null,["class"=>'form-control validate[required]', "placeholder"=>'Select COD Status']) !!}
                            </div>
                        </div>
                    </div>
                    @endif


                 
                    {!! Form::hidden('pref',0) !!}
                  
                    <div class="row">
                        <div class='col-sm-12'>     

                            <div class="form-group">
                                {!!form::label('status', 'Status ', ["class"=> 'control-label']) !!}<span class="red-astrik"> *</span>
                                {!! form::select('status',["1"=>"Enabled","0"=>"Disabled"],($pincodes)?$pincodes->status:0,["class"=>'form-control validate[required]', "placeholder"=>'Select Status']) !!}
                            </div>
                        </div>
                    </div>
                    
                      <div class='col-sm-12'> 
                    <div class="form-group">
                        <div class="pull-right">
                            {!! Form::submit('Submit',["class" => "noLeftMargin btn btn-primary"]) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
                </div>

              
                </form>

            </div>
        </div>
    </div>
</section> 
@stop 

@section('myscripts')
<script>
//    $(".servicePrv").on("change", function () {
//        selval = $(this).val();
//        $("input[name='pref']").val(0);
//        if (selval != "") {
//            pref = '<?php // echo json_encode($prefdata) ?>';
//            prefArr = JSON.parse(pref);
//            $("input[name='pref']").val(prefArr[selval]);
//        }
//
//    });

</script>



@stop
