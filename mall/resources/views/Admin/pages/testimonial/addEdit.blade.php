@extends('Admin.layouts.default')
@section('content')

<section class="content-header">
    <h1>
        Testimonials
        <small>Add/Edit</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"> Testimonials </li>
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
                    
                    {!! Form::model($testimonial, ['method' => 'post', 'files'=> true, 'id' => 'testimonial', 'url' => $action ]) !!}



                 {!! Form::hidden('id',null) !!}
                    <div class="col-md-6">
                    <div class="form-group">
                        {!!Form::label('customer_name','Customer Name ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                            {!! Form::text('customer_name',null, ["class"=>'form-control validate[required]',"id"=>'email' ,"placeholder"=>'Enter Customer Name']) !!}

                            @if ($errors->has('customer_name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('customer_name') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

               <!--   class="validate[required,custom[email]]"  -->  
                    <div class="col-md-6">
                     <div class="form-group">
                        {!!Form::label('image','Image',['class'=>'control-label']) !!}
                            <input type="file" name="image" id="image" onchange="readURL(this);" />
                            <br>
                            <img id="select_image" src="#" class="thumbnail" style="display: none;" />
                        </div>
                    </div>


                   <div class="col-md-6">
                    <div class="form-group{{ $errors->has('testimonial') ? ' has-error' : '' }}">
                        {!!Form::label('testimonial','Comments / Reviews ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                            {!! Form::textarea('testimonial',null, ["class"=>'form-control validate[required]',"id"=>'address' ,"placeholder"=>'Enter testimonial', "rows"=>"5"]) !!}

                            @if ($errors->has('testimonial'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('testimonial') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-6">                    
                     <div class="form-group">
                        {!!Form::label('sort_order','Sort Order ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                            {!! Form::number('sort_order',null, ["class"=>'form-control validate[required,custom[number]]',"id"=>'sort_order' ,"placeholder"=>'Enter sort order']) !!}                           
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!!form::label('gender','Gender ', ["class"=> 'control-label']) !!}<span class="red-astrik"> *</span>
                            {!! form::select('gender',["male"=>"Male","female"=>"Female"],null,["class"=>'form-control validate[required] ']) !!}
                        </div>
                    </div>
                    
                    <div class="clearfix"></div>
                    <div class="col-md-6">
                        <div class="form-group">
                            {!!form::label('status','Status ', ["class"=> 'control-label']) !!}<span class="red-astrik"> *</span>
                            {!! form::select('status',["1"=>"Enabled","0"=>"Disabled"],null,["class"=>'form-control validate[required]', "placeholder"=>'Select Status']) !!}
                        </div>
                    </div>                   

                     <div class="col-md-12">
                    <div class="form-group">
                        <div class="pull-right">
                            {!! Form::submit('Submit',["class" => "noLeftMargin btn btn-primary"]) !!}
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

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#select_image')
                    .attr('src', e.target.result)
                    .width(100)
                    .height(120);
            };

            reader.readAsDataURL(input.files[0]);
            $("#select_image").show();
        }
    } 
    
    
     @php
        if($testimonial){
            @endphp
            $('#select_image')
                    .attr('src', "{{($testimonial->image)?$public_path.$testimonial->image:Config('constants.defaultImgPath').'/default-male.png' }}")
                    .width(100)
                    .height(120);
            $("#select_image").show();
            @php
        }
    @endphp
    
/*
    $(function() {
      $("#testimonial").validate({
        rules: {
          customer_name: "required",
          testimonial: "required",
          sort_order: "required",
          gender: "required",
          status: "required"
        },
        // Specify validation error messages
        messages: {
          customer_name: "Please enter customer name",
        },
        
        });
});
    */
</script>



@stop
