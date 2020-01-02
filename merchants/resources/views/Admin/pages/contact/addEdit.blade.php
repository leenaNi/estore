@extends('Admin.layouts.default')
@section('content')

<section class="content-header">
    <h1>
        Contact Details
        <small>Add/Edit</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li> Contact Details </li>
        <li class="active">Add/Edit</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div>
            <p style="color: red;text-align: center;">{{ Session::get('messege') }}</p>
        </div>

        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    {!! Form::model($contact, ['method' => 'post', 'files'=> true, 'url' => $action]) !!}
                    <div class="col-md-6">
                      <div class="form-group">
                        {!! Form::label('customer_name', 'Contact Parson ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                        {!! Form::hidden('id',null) !!}
                        {!! Form::hidden('store_id', Session::get('store_id')) !!}
                            {!! Form::text('customer_name',null, ["class"=>'form-control validate[required]',"id"=>'customer_name' ,"placeholder"=>'Name']) !!}
                        </div>
                    </div>

                    <div class="col-md-6">
                    <div class="form-group{{ $errors->has('phone_no') ? ' has-error' : '' }}">
                        {!! Form::label('phone_no', 'Mobile ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                            {!! Form::text('phone_no',null, ["class"=>'form-control validate[required,custom[phone]]',"id"=>'phone_no' ,"placeholder"=>'Mobile',]) !!}
                            <span id='error_msg'></span>

                            @if ($errors->has('phone_no'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('phone_no') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        {!!Form::label('email','Email Id ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                            {!! Form::text('email',null, ["class"=>'form-control validate[required,custom[email]]',"id"=>'email' ,"placeholder"=>'Email Id']) !!}

                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">
                    <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
                        {!!Form::label('address','Address Line 1 ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                            {!! Form::text('address',null, ["class"=>'form-control validate[required]',"id"=>'address1' ,"placeholder"=>'Address Line 1']) !!}

                            @if ($errors->has('address'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('address') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                <div class="col-md-6">
                    <div class="form-group{{ $errors->has('address2') ? ' has-error' : '' }}">
                        {!!Form::label('address2','Address line 2 ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                            {!! Form::text('address2',null, ["class"=>'form-control validate[required]',"id"=>'address2' ,"placeholder"=>'Address Line 2']) !!}

                            @if ($errors->has('address2'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('address2') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           {!!Form::label('city','City  ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                           {!! Form::text('city',null,["class"=>'form-control validate[required]', 'placeholder'=>'City']) !!}
                       </div>
                   </div>
                       <div class="col-md-6">
                        <div class="form-group">
                           {!!Form::label('country','Country  ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                           {!! Form::select('country',$coutries,null,["class"=>'form-control validate[required] country', 'placeholder'=>'SelectCountry']) !!}
                       </div>
                   </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           {!!Form::label('state','State/Zone ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                           {!! Form::select('state',$state,null,["class"=>'form-control validate[required] state', 'placeholder'=>'Select State']) !!}
                       </div>
                   </div>

                     <div class="col-md-6">
                        <div class="form-group">
                           {!!Form::label('pincode','Pincode  ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                           {!! Form::text('pincode',null,["class"=>'form-control validate[required]', 'placeholder'=>'Pincode']) !!}
                       </div>
                   </div>
                      <div class="col-md-6">
                        <div class="form-group">
                           {!!Form::label('map_url','Map Url ',['class'=>'control-label']) !!}
                           {!! Form::text('map_url',null,["class"=>'form-control ', 'placeholder'=>'Map Url']) !!}
                       </div>
                   </div>
                    <input type="hidden" name="status">
<!--                      <div class="col-md-6">
                        <div class="form-group">
                           {!!Form::label('Vat ','Vat Number',['class'=>'control-label']) !!}
                           {!! Form::text('vat',null,["class"=>'form-control ', 'placeholder'=>'Vat Number']) !!}
                       </div>
                   </div>-->
<!--                     <div class="col-md-6">
                        <div class="form-group">
                           {!!Form::label('Status','Status  ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                           {!! Form::select('status',["1" => "Enabled", "0" => "disabled"],null,["class"=>'form-control validate[required]', 'placeholder'=>'Select Status']) !!}
                       </div>
                   </div>-->

                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="pull-right">
                                {!! Form::submit('Submit',["class" => "btn btn-primary noLeftMargin"]) !!}
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
   $('.country').change(function(){country
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
