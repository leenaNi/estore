
@extends('Admin.Layouts.default')

@section('contents')
<section class="content-header">
    <h1>
        Notification
        <small>Add/Edit</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">   Notification </li>
        <li class="active">Add/Edit</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    {!! Form::model($notifications,['method' => 'post', 'url' => $action ,'files'=> true, 'class' => 'form-horizontal' ,"id"=>"notification" ]) !!}
                   
                        <div class="form-group">
                               <div class="col-md-3">
                            {!! Form::label('Title', 'Notification Title', ["class"=>'  control-label'] ) !!}
                               </div>
                            <div class="col-md-9">
                                {!! Form::text('title',null, ["class"=>'form-control ' ,"placeholder"=>'Notification Title', "required"]) !!}
                            </div>
                        </div>

                <div class="form-group">
                     <div class="col-md-3">
                            {!! Form::label('Notification', 'Notification Message', ["class"=>' control-label'] ) !!}
                     </div>
                            <div class="col-md-9">
                                {!! Form::text('notification',null, ["class"=>'form-control ' ,"placeholder"=>'Notification message', "required"]) !!}
                            </div>
                        </div>

                     <div class="form-group ">
                         <div class="col-md-3">
                         {!!Form::label('image','Notification Image *', ["class"=> '  control-label']) !!}
                        </div>
                         <div class="col-md-9">
                             <input type="file" name="image" class="form-control selectedImage" placeholder="Select Image" required>
                            <!--{!! Form::file('image',null,["class"=>'form-control selectedImage', "placeholder"=>'Select Image', "required"]) !!}-->
                         <img  id="blah" src="#" alt="your image" height="100px" Weight="100px" class="hide" />
                         </div>
                         
                    </div>
                    
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    {!! Form::hidden('id') !!}

                    <div class="form-group">
                        <div class="col-md-12">
                            {!! Form::submit('Submit',["class" => "pull-right btn btn-primary noLeftMargin"]) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
</section>
@stop

@section('myscripts')

<script>
    $("#notification").validate({
        rules: {
            title: {
                required: true
            },
            notification: {
                required: true
            },
            image: {
                required: true
            }
        },
        messages: {            
            title: {
                required: "Notification Title is required."
            },
            notification: {
                required: "Notification Message is required.",
                

            }, image: {
                required: "Notification Image is required."
            }           
        },
        errorPlacement: function (error, element) {
            var name = $(element).attr("name");
            var errorDiv = $(element).parent();
            errorDiv.append(error);
        }
    });
</script>
@stop