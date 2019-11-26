@extends('Admin.layouts.default')
@section('content')
<style type="text/css">
    .adrs_col{
    background: none;
    max-height: 390px;
    margin-bottom: 30px;
    border: 1px solid #ccc;
    border-radius: 0px;
    }
    h1.bxtitle {
    padding: 5px 10px;
    margin: 0;
    background: #fff;
    color: #000;
    border-bottom: 1px #eee solid;
}
.adrs_col h1 {
    font-size: 25px !important;

}

</style>
<section class="content-header">
    <h1>
        Customers
        <small>Add/Edit</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ route('admin.customers.view') }}"><i class="fa fa-coffee"></i>Customers</a></li>
        <li class="active">Add/Edit</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <div class="panel-body">
                        <p style="color:red;text-align: center;">{{ Session::get('usenameError') }}</p>
                        <p style="color:red;text-align: center;">{{ Session::get('usernameErr') }}</p>
                        {!! Form::model($user, ['method' => 'post', 'route' => $action]) !!}
                        <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                            {!!Form::label('first_name','First Name ') !!}<span class="red-astrik"> *</span>
                                {!! Form::hidden('id',null) !!}
                                {!! Form::text('firstname',null, ["class"=>'form-control validate[required]' ,"placeholder"=>'First Name']) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group">
                            {!!Form::label('Last Name','Last Name') !!}
                                {!! Form::text('lastname',null, ["class"=>'form-control' ,"placeholder"=>'Last Name']) !!}
                            </div>
                        </div>
                          <div class="col-md-6">
                            <div class="form-group">
                                <?php //$attr_Sets = $attrs->attributesets->toArray(); ?>
                                {!! Form::label('Country Code', 'Country Code ') !!}<span class="red-astrik">*</span>
                                {!! Form::select('country_code',["+91"=>"(+91) India","+880"=>"(+880) Bangladesh"],null, ["class"=>'form-control',"placeholder"=>'Select Country code',"required"] ) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group">
                            {!!Form::label('Phone','Mobile ') !!}<span class="red-astrik"> *</span>
                                {!! Form::number('telephone',null, ["class"=>'form-control phone_no validate[required,custom[phone]]',"placeholder"=>'Mobile', (Input::get('id'))? "readonly": '']) !!}
                                <span class='phone_error' style='color:red'></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group">
                            {!!Form::label('Email','Email Id') !!}<span class="red-astrik"> *</span>
                                {!! Form::email('email',null, ["class"=>'form-control validate[required,custom[email]]', "id" => (Input::get("id"))? "": "user-email" ,"placeholder"=>'Email Id', (Input::get('id'))? "readonly": '' ,"autocomplete"=>"off"]) !!}
                            </div>                           
                        </div>
                        @if($user->provider=='' && Input::get('id') == null)
                        <div class="col-md-6">
                        <div class="form-group">
                            {!!Form::label('Password','Password ') !!}<span class="red-astrik"> *</span>
                                {!! Form::password('password', ["class"=>'form-control validate[required]' ,"placeholder"=>'Password', ($user->provider=='')? "required": '', (Input::get('id'))? "readonly": '']) !!}
                            </div>
                        </div>                        
                        @endif
                        @if($setting->status ==1)
                       <div class="col-md-6">
                        <div class="form-group">
                            {!!Form::label('Loyalty Point','Loyalty Point ') !!}<span class="red-astrik"> *</span>
                                {!! Form::number('cashback',@$user->userCashback->cashback, ["class"=>'form-control priceConvertTextBox', "id" => 'loyalty-point' ,"placeholder"=>'Loyalty Point', "required" ,"readonly"]) !!}
                            </div>                           
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <?php //$attr_Sets = $attrs->attributesets->toArray(); ?>
                                {!! Form::label('Loyalty Group', 'Loyalty Group ') !!}<span class="red-astrik">*</span>
                                {!! Form::select('loyalty_group',$loyalty, @$user->userCashback->loyalty_group, ["class"=>'form-control',"required"] ) !!}
                            </div>
                        </div>
                    @endif
                    <div class="col-md-12">
                        <div class="form-group">
                                {!! Form::submit('Submit',["class" => "btn btn-primary pull-right", "id" => " submit"]) !!}
                                {!! Form::close() !!}     
                            </div>
                        </div> 
                        </form>
                            @if($user->id)
                                <div class="col-md-12">
                                   <label>BILLING ADDRESSES</label>
                                </div>
                                @if(count($BillingAddress)>0)
                                    <!--   -->
                                    <div id='forBillAddress' class="shippingadd">
                                        @php
                                        $count = 1;
                                        @endphp
                                        
                                        @foreach($BillingAddress as $sadddress)
                                        
                                        <div class="col-md-4">
                                            <div class="adrs_col"> 
                                                <h1 class="bxtitle">
                                                    <div class="pull-left"><label for="radio2" ><input type="radio" value="{{$sadddress->id}}" name="default_billing" {{$sadddress->is_default_billing==1?'checked':''}} disabled><label style="font-size: medium;">Address ({{$count}})</label> </label></div><div class="pull-right"> 
                                                        <a href="#addNewBillAddForm" onclick="editAddress('{{$sadddress->id}}','shipping')" class="box_action"><i class="icon-edit"></i> </a><a href="" onclick="deleteAdd('{{$sadddress->id}}','shipping');" class="box_action"><i class="icon-trash"></i> </a></div>
                                                        
                                                    <div class="clearfix"></div></h1>
                                                <div class="adrs_cont"  style="cursor:pointer;padding: 15px">
                                                    <p>{{$sadddress->firstname}} {{$sadddress->lastname}}</p> 
                                                    <p>{{$sadddress->address1}}</p>
                                                    <p>{{$sadddress->address2}}</p>
                                                    @php
                                                    $country = App\Models\Country::find($sadddress->country_id);
                                                    $zone = App\Models\Zone::find($sadddress->zone_id);
                                                    @endphp
                                                    <p>{{$country->name}}</p>
                                                    <p>{{$zone->name}}</p> 
                                                    <p>{{$sadddress->city}}</p> 
                                                    <p>{{$sadddress->thana}} - {{$sadddress->postcode}}</p>
                                                    <p>Mobile No:{{$sadddress->phone_no}}</p>
                                                </div>

                                            </div>
                                        </div>
                                        @php
                                        $count++;
                                        @endphp
                                        @endforeach
                                        
                                    </div>
                                  @else
                                  <div class="col-md-12">
                                   <p> No Address Found</p>
                                </div>
                                       
                                    @endif
                                    <div class="col-md-12">
                                   <label>SHIPPING ADDRESSES</label>
                                </div>
                                    @if(count($shippingAddress)>0)
                                    <div id='forShippingAddress' class="shippingadd">
                                        @php
                                        $count = 1;
                                        @endphp
                                        @foreach($shippingAddress as $sadddress)
                                        
                                        <div class="col-md-4">
                                            <div class="adrs_col"> 
                                                <h1 class="bxtitle">
                                                    <div class="pull-left"><label for="radio2" ><input type="radio" value="{{$sadddress->id}}" name="default_shipping" {{$sadddress->is_default_shipping==1?'checked':''}} disabled><label style="font-size: medium;">Address ({{$count}})</label> </label></div><div class="pull-right"> 
                                                        <a href="#addNewBillAddForm" onclick="editAddress('{{$sadddress->id}}','shipping')" class="box_action"><i class="icon-edit"></i> </a><a href="" onclick="deleteAdd('{{$sadddress->id}}','shipping');" class="box_action"><i class="icon-trash"></i> </a></div>
                                                        
                                                    <div class="clearfix"></div></h1>
                                                <div class="adrs_cont"  style="cursor:pointer;padding: 15px">
                                                    <p>{{$sadddress->firstname}} {{$sadddress->lastname}}</p> 
                                                    <p>{{$sadddress->address1}}</p>
                                                    <p>{{$sadddress->address2}}</p>
                                                    @php
                                                    $country = App\Models\Country::find($sadddress->country_id);
                                                    $zone = App\Models\Zone::find($sadddress->zone_id);
                                                    @endphp
                                                    <p>{{$country->name}}</p>
                                                    <p>{{$zone->name}}</p> 
                                                    <p>{{$sadddress->city}}</p> 
                                                    <p>{{$sadddress->thana}} - {{$sadddress->postcode}}</p>
                                                    <p>Mobile No:{{$sadddress->phone_no}}</p>
                                                </div>

                                            </div>
                                        </div>
                                        @php
                                        $count++;
                                        @endphp
                                        @endforeach
                                    </div>
                                  @else
                                  <div class="col-md-12">
                                   <p> No Address Found</p>
                                </div>
                                @endif
                            @endif    
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop
@section("myscripts")
<script>
    $(document).ready(function() {
       $(".phone_no").blur(function(){
           $('.phone_error').empty();
            var phone = $(this).val();
           var phoneno = /^\d{10}$/;
             if((phone.match(phoneno)))  
             {  
                return true;  
              }  
             else  
              {  
            
              $('.phone_error').append('<p> Please enter 10 digit mobile number </p>'); 
              return false;  
              } 
        
        
       });
     
          $("#user-email").blur(function(){
           $('#user-email').parent().find('span.error').remove();
            var useremail = $(this).val();          
            $.ajax({
                type: "POST",
                url: "{{ route('admin.customers.chkExistingUseremail') }}",
                data: {useremail: useremail},
                cache:false,
                success:function(response){
                    console.log('@@@@'+response['status'])
                    if(response['status']== 'success') {
                        $('.email_error').remove();
                         $('#user-email').val('');
                        $('#user-email').parent().append('<span class="error email_error" style="color:red;">'+response['msg']+'</span>'); 
                    }
                    else $('#user-email').parent().find('span.error').remove();
                },error:function(e){
                    console.log(e.responseText);
                }
            }); 
    });
    });
</script>
@stop