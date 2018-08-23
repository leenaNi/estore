@extends('Admin.layouts.default')
@section('content')

<section class="content-header">
    <h1>
        Additional Charges
        <small>Add/Edit</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ route('admin.additional-charges.view') }}"><i class="fa fa-coffee"></i> Additional Charges</a></li>
        <li class="active">Add/Edit</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div>
            <p style="color: green;text-align: center;">{{ Session::get('messege') }}</p>
        </div>
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    {!! Form::model($additional_charge, ['method' => 'post', 'files'=> true, 'url' => $action ]) !!}

                    <div class="col-md-6">
                        <div class="form-group">
                        {!! Form::label('Name', 'Name ') !!}<span class="red-astrik"> *</span>
                        {!! Form::hidden('id',null) !!}
                            {!! Form::text('name',null, ["class"=>'form-control validate[required]' ,"placeholder"=>'Additional Charge Name']) !!}
                            <span id='error_msg'></span>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                        {!!Form::label('Type','Type ') !!}<span class="red-astrik"> *</span>
                            {!! Form::Select('type',['1' => 'Fixed', '2' => 'Percentage'],null,["class"=>'form-control validate[required]',"placeholder"=>"Select Type" ]) !!}
                        </div>
                    </div>                  
                    <div class="clearfix"></div>
                    <div class="col-md-6">
                        <div class="form-group">
                        {!!Form::label('rate','Rate ') !!}<span class="red-astrik"> *</span>
                            {!! Form::text('rate',null,[ "class"=>'form-control priceConvertTextBox validate[required,custom[number]]',"placeholder"=>"Additional Charges Rate"]) !!}
                        </div>
                    </div>

                     <div class="col-md-6">
                        <div class="form-group">
                        {!!Form::label('minimum_charge','Minimum Order Value Applicable  ') !!}<span class="red-astrik"> *</span>
                            {!! Form::Select('minimum_charge',['1' => 'Yes', '0' => 'No'],@$additional_charge->min_order_amt==0?'0':'1',["class"=>'form-control  validate[required]' ]) !!}
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-md-6 min_order_amt">
                        <div class="form-group">
                        {!!Form::label('min_order_amt','Minimum Order Amount ') !!}<span class="red-astrik"> *</span>
                            {!! Form::text('min_order_amt',null,["class"=>'form-control priceConvertTextBox validate[required,custom[number]]',"placeholder"=>"Minimum Order Amount"]) !!}
                        </div>
                    </div>                 

                    <div class="line line-dashed b-b line-lg pull-in"></div>

                    <div class="form-group">
                        <div class="col-md-12"> 
                            {!! Form::submit('Submit',["class" => "noLeftMargin btn btn-primary pull-right mobFloatLeft"]) !!}
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
<script>
    function CheckDecimal(inputtxt)
    {
        $(inputtxt).parent().removeClass('has-error').find('span').remove();
        var decimal = /^[0-9]+\.[0-9]+$/;
        var num = /^[0-9]+$/;
        if (inputtxt.value.match(decimal) || inputtxt.value.match(num))
        {
            //alert('Correct, try another...');
            $(inputtxt).parent().removeClass('has-error').find('span').remove();
            return true;
        } else
        {
            $(inputtxt).val('');
            $(inputtxt).parent().addClass('has-error').append("<span class='help-block'>Please enter numeric value.</span>");
            //alert('Wrong...!');
            return false;
        }
    }
    
    $(document).ready(function () {
        // $("#taxname").blur(function () {
        //     var taxname = $(this).val();
        //    // alert(taxname);
        //     $.ajax({
        //         type: "POST",
        //         url: "{{ route('admin.tax.checktax') }}",
        //         data: {taxname: taxname},
        //         cache: false,
        //         success: function (response) {
        //             // console.log('@@@@'+response['msg'])
        //             if (response['status'] == 'success') {
        //                 $('#taxname').val('');
        //                 $('#error_msg').text(response['msg']).css({'color': 'red'});
        //             } else
        //                 $('#taxname').text('');
        //         }, error: function (e) {
        //             console.log(e.responseText);
        //         }
        //     });
        // });

        isChargeApplicable();
       
        $("#minimum_charge").change(function(){
            isChargeApplicable();           
        })

        function isChargeApplicable(){
           var applicable = $("#minimum_charge option:selected").val()
            if(applicable == 0){
                $(".min_order_amt").hide();
                return;
            }
            $(".min_order_amt").show(); 
        }
    });
</script>



@stop