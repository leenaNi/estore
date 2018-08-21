@extends('Admin.layouts.default')
@section('content')

<section class="content-header">
    <h1>
        Taxes
        <small>Add/Edit</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('admin.offers.view') }}"><i class="fa fa-coffee"></i> Taxes</a></li>
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
                    {!! Form::model($tax, ['method' => 'post', 'files'=> true, 'url' => $action, 'id' => 'Tax-form' ]) !!}
                    {!! Form::hidden('id',null) !!}
                    <!-- <div class="col-md-6">
                        <div class="form-group">
                        {!! Form::label('name', 'Tax Name ') !!}<span class="red-astrik"> *</span>                        
                            {!! Form::text('name',null, ["class"=>'form-control validate[required]',"id"=>'taxname' ,"placeholder"=>'Enter Tax Name']) !!}
                            <span id='error_msg'></span>
                        </div>
                    </div> -->


                    <div class="col-md-6">
                        <div class="form-group">
                        {!!Form::label('label','Display Name ') !!}<span class="red-astrik"> </span>
                          {!! Form::text('label',null, ["class"=>'form-control ',"id"=>'taxname1' ,"placeholder"=>'Enter Label']) !!}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                        {!!Form::label('rate','Tax Rate (%)') !!}<span class="red-astrik"> *</span>
                            {!! Form::text('rate',null,[ "class"=>'form-control validate[required,custom[number]]',"placeholder"=>"Enter Tax Rate"]) !!}
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                        {!!Form::label('tax_number','Tax Number ') !!}
                            {!! Form::text('tax_number',null,["class"=>'form-control ',"placeholder"=>"Enter Tax Number" ]) !!}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                        {!!form::label('status','Status ', ["class"=> 'control-label']) !!}<span class="red-astrik"> *</span>
                        {!! form::select('status',["1"=>"Enabled","0"=>"Disabled"],null,["class"=>'form-control validate[required]', "placeholder"=>'Select Status']) !!}
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>

                    <div class="form-group">
                        <div class="col-md-12"> 
                            {!! Form::submit('Submit',["class" => "noLeftMargin btn btn-primary pull-right"]) !!}
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
        $("#taxname").blur(function () {
            var taxname = $(this).val();
            var id = {{ $tax->id }}
           // alert(taxname);
           // $('#taxname').val('');
            $.ajax({
                type: "POST",
                url: "{{ route('admin.tax.checktax') }}",
                data: {name: taxname,id:id},
                cache: false,
                success: function (response) {

                    // console.log('@@@@'+response['msg'])
                    if (response['status'] == 'success') {
                         
                         $('#taxname').val('');
                        $('#error_msg').text(response['msg']).css({'color': 'red'});
                    } 
                }, error: function (e) {
                    console.log(e.responseText);
                }
            });
        });
    });
</script>



@stop