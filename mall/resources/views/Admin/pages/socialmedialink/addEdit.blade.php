@extends('Admin.layouts.default')
@section('content')

<section class="content-header">
    <h1>
        Social Media Links
        <small>Add/Edit</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class=""> <a href="{{route('admin.socialmedialink.view')}}" >Social Media Links</a> </li>
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
                    {!! Form::model($link, ['method' => 'post', 'files'=> true, 'url' => $action ]) !!}

                    <div class="col-sm-6">
                    <div class="form-group{{ $errors->has('media') ? ' has-error' : '' }}">
                        {!! Form::label('media', 'Media Name',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                        {!! Form::hidden('id',null) !!}
                            {!! Form::text('media',null, ["class"=>'form-control validate[required]',"id"=>'media' ,"placeholder"=>'Media Name'] ) !!}
                            <span id='error_msg'></span>
                            @if ($errors->has('media'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('media') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="col-sm-6">
                    <div class="form-group{{ $errors->has('link') ? ' has-error' : '' }}">
                        {!!Form::label('link','Link ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                            {!! Form::text('link',null, ["class"=>'form-control validate[required]',"id"=>'link' ,"placeholder"=>'Link']) !!}

                            @if ($errors->has('link'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('link') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                         <div class="col-sm-6">
                    <div class="form-group{{ $errors->has('sort_order') ? ' has-error' : '' }}">
                        {!!Form::label('sort_order','Sort Order ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                            {!! Form::text('sort_order',null, ["class"=>'form-control validate[required]',"id"=>'sort_order' ,"placeholder"=>'Sort Order']) !!}

                            @if ($errors->has('sort_order'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('sort_order') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
<!--                    <div class="col-sm-6">
                    <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                        {!!Form::label('image','Image ',['class'=>'control-label']) !!}<span class="red-astrik"> *</span>
                            <input type="file" name="image" id="image" onchange="readURL(this);" class="{{@$link->image?'':'validate[required]'}}" />
                          
                            @if ($errors->has('image'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('image') }}</strong>
                                </span>
                            @endif
                            <img id="select_image" src="#" alt="Selected Image" style="display: none;" />
                        </div>
                    </div>-->

                    @if($new)
                        {!! Form::hidden('status',1) !!}
                    @endif

                   <div class="col-sm-12">
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
//    function readURL(input) {
//        if (input.files && input.files[0]) {
//            var reader = new FileReader();
//
//            reader.onload = function (e) {
//                $('#select_image')
//                    .attr('src', e.target.result)
//                    .width(150)
//                    .height(200);
//            };
//
//            reader.readAsDataURL(input.files[0]);
//            $("#select_image").show();
//        }
//    }
//
//    @php
//        if($link->image){
//            @endphp
//            $('#select_image')
//                    .attr('src', "{{ asset($public_path.$link->image) }}")
//                    .width(150)
//                    .height(200);
//            $("#select_image").show();
//            @php
//        }
//    @endphp
</script>



@stop