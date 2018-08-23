@extends('Admin.layouts.default')

@section('content')

<section class="content-header">
    <h1>
      Bank Details
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
       
        <li class="active">Bank Details  </li>
        <li class="active"> Add/Edit</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">   
                <div class="box-body">
                    {!! Form::model($bankDetail, ['method' => 'post', 'files'=> true, 'url' => $action ]) !!}
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
                    @if(!empty($bankDetail->details))
                    <?php
                    $details = json_decode($bankDetail->details);
                    ?>
                    @foreach($details as $detK => $detV)
                    @if($detK =='acc_type' ||$detK =='state' ||$detK =='country' )
                 <?php    if($detK=='state'){
                              $value=$state;
                          }else if($detK=='country'){
                              $value=$country;
                          }else if($detK=='acc_type'){
                             $value=$accountType;  
                          }
?>
                  
                      <div class="col-md-6">
                        <div class="form-group">

                       
                            {!! Form::label($detK, ucfirst(str_replace("_"," ",$detK)),['class'=>'control-label']) !!}

                            {!! Form::select("details[$detK]",$value,$detV, ["class"=>"form-control $detK"  ,"placeholder"=>ucfirst(str_replace("_"," ",$detK)), "required"]) !!}
                        </div>
                    </div>
              
                @else
                    <div class="col-md-6">
                        <div class="form-group">

                          
                            {!! Form::label($detK, ucfirst(str_replace("_"," ",$detK)),['class'=>'control-label']) !!}

                            {!! Form::text("details[$detK]",$detV, ["class"=>'form-control' ,"placeholder"=>ucfirst(str_replace("_"," ",$detK)), "required"]) !!}
                        </div>
                    </div>
                @endif
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
@section('myscripts')
<script>
   $('.country').change(function(){
    var id = $('.country').val();
    $.ajax({
    type: "POST",
            url: "{{ route('admin.contact.getState') }}",
            data: {country_id: id},
            cache: false,
            success: function (response) {
            console.log('@@@@' + response);
            var option = '';
            if (response) {
            $.each(response, function(key, value){
            option += "<option value=" + key + ">" + value + "</option>";
            })
                    $('.state').html(option);
            //  alert(option);
            }

            }, error: function (e) {
    console.log(e.responseText);
    }
    });
    });  
</script>
@stop