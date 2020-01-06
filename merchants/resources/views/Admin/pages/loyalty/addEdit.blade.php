@extends('Admin.layouts.default')




@section('content')
<section class="content-header">
    <h1>
        Loyalty Program

        <small>   <div  class="alert alert-danger hide" id="alert-danger" role="alert">

            </div> </small>

    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class=""><a href="{{route('admin.loyalty.view')}}" >Loyalty Program</a></li>
        <li class="active">Add/Edit</li>
    </ol>
</section>  
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                 <div class="box-body">
                {{ Form::model($loyalty, ['method' => 'post', 'url' => $action , 'class' => 'bucket-form', "id"=>"form1" ]) }}
                <div class="col-md-6">
                <div class="form-group">
                    {{ Form::label('group', 'Loyalty Group Name ') }} <span class="red-astrik"> *</span>
                    {{ Form::text('group',null, ["class"=>'form-control loyalty_group validate[required]' ,"placeholder"=>'Loyalty Group Name', "required"]) }}
                   <span id="loyalty_error" style="color:red"></span>
                </div>
                </div>
                <div class="col-md-6">
                <div class="form-group">
                    {{ Form::label('min_order_amt', 'Minimum Order Amount ') }}<span class="red-astrik"> *</span>
                    {{ Form::number('min_order_amt',null, ["class"=>'form-control priceConvertTextBox min validate[required,custom[number],min[1]]' ,"placeholder"=>'Mimimum Order Amount',($loyalty->min_order_amt)?'readonly':'']) }}
                </div>
                </div>
                <div class="col-md-6">
                <div class="form-group">
                    {{ Form::label('max_order_amt', 'Maximum Order Amount ') }}<span class="red-astrik"> *</span>
                    {{ Form::number('max_order_amt',null, ["class"=>'form-control priceConvertTextBox max validate[required,custom[number],min[1]]' ,"placeholder"=>'Maximum Order Amount', ($loyalty->min_order_amt)?'readonly':'']) }}
                </div>
                </div>
                <div class="col-md-6">
                <div class="form-group">
                    {{ Form::label('points', 'Percent ') }}<span class="red-astrik"> *</span>
                    {{ Form::number('percent',null, ["class"=>'form-control validate[required]' ,"placeholder"=>'Loyalty Percent']) }}
                </div>
                </div>
                {{ Form::hidden('id',null, ["class"=>'lolytyId' ]) }}   

                    <div class="col-md-12 form-group">
                        {{ Form::button('Submit',["class" => "btn btn-primary noLeftMargin btnsubmit pull-right mobFloatLeft noMob-leftmargin"]) }}
                        {{ Form::close() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@stop


@section('myscripts')
<script>
    $(document).ready(function () {
        $(".loyalty_group").blur(function () {
            $('#loyalty_error').empty();
            var loyalty = $(".loyalty_group").val();

            $.ajax({
                type: "POST",
                url: "{{ route('admin.loyalty.checkName') }}",
                data: {loyaltyName: loyalty},
                cache: false,
                success: function (response) {
                    // console.log("pradep"+JSON.stringify(response[0].group));

                    if (response.length > 0) {
                        $('#loyalty_error').append("Loyalty Group Already Exit!");

                    }

                }, error: function (e) {
                    // console.log(e.responseText);
                }
            });

        });
        
  $(".btnsubmit").click(function(){
         var minimum= $(".min").val();
        var maximum = $(".max").val();
        var id=$('.lolytyId').val();
      
       $('#alert-danger').empty();
       if(id && (maximum != "" && minimum != "") ){
              $("#form1").submit(); 
           }else if(maximum == "" && minimum == ""){ 
               $('input').blur();
               return false;
           }else{
         
             $.ajax({
                type: "POST",
                url: "{{ route('admin.loyalty.checkRange') }}",
                data: {minimum:minimum,maximum:maximum},
                cache:false,
                success:function(response){
                console.log(JSON.stringify(response));
                
                    if( response.length > 0){
                 
                    $('#alert-danger').removeClass("hide");
                    $('#alert-danger').append("Loyalty range already exit!");
                        return false;
                 
                   }else{
                       $("#form1").submit();    
                   }
            
                },error:function(e){
                   // console.log(e.responseText);
                }
            }); 
       
       }
       
    });     
      
        
        
    });



</script>
@stop



