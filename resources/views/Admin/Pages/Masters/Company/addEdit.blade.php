@extends('Admin.Layouts.default')

@section('contents')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Add/Edit
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.masters.company.view') }}"><i class="fa fa-dashboard"></i>Compnay</a></li>
        <li class="active">Add/Edit</li>
    </ol>
</section>
<section class="content">
    <div class="row">

        <div class="col-xs-12">
            <div class="box pt50">
                {{ Form::model($companyResult, ['route' => ['admin.masters.company.saveUpdate', $companyResult->id], 'class'=>'form-horizontal','id'=>'companyForm','method'=>'post','files'=> true]) }}
                {{ Form::hidden('id',(Input::get('id')?Input::get('id'):null)) }}
                <div class="box-body">
                    <div class="form-group">
                        {{ Form::label('Name *', 'Name *', ['class' => 'col-sm-3 control-label']) }}
                        <div class="col-sm-6 col-xs-12">
                            {{Form::text('name',  null, ['class'=>'form-control']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('Address *', 'Address *', ['class' => 'col-sm-3 control-label']) }}
                        <div class="col-sm-6 col-xs-12">
                            {{Form::text('address',  null, ['class'=>'form-control']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('Contact Person Name *', 'Contact Person Name *', ['class' => 'col-sm-3 control-label']) }}
                        <div class="col-sm-6 col-xs-12">
                            {{Form::text('contact_person_name',  null, ['class'=>'form-control']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('Contact Person Number *', 'Contact Person Number *', ['class' => 'col-sm-3 control-label']) }}
                        <div class="col-sm-6 col-xs-12">
                            {{Form::text('contact_person_number',  null, ['class'=>'form-control']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('Logo', 'Logo', ['class' => 'col-sm-3 control-label']) }}
                        <div class="col-sm-6 col-xs-12">
                            <input type="file" id="logo" name="logo" class="form-control">
                            {{-- <span>(Logo size must be 170px W X 100px H)</span> --}}
                            <input type="hidden" name="hdnLogo" value="{{@$companyResult->logo}}" class="form-control">
                            <div id="imgError" style="color:red;"></div>
                                @if(!empty($companyResult->logo))
                                    <img height="100px" width="100px" src="{{ asset(Config('constants.companyImgPath').''.$companyResult->logo) }}" class="img-responsive compnayLogo" />                               
                                @else
                                    <img height="100px" width="100px" class="img-responsive compnayLogo" />
                                @endif
                            <input type="hidden" name="isValidImage" id="isValidImage" value="1" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                <div class="row">
                    <div class="col-md-3 col-md-offset-3 text-left">
                        {{Form::submit('Save & Exit', ['class'=>'btn btn-info mr10']) }}
                    </div>
                </div> 
                </div>
                {{ Form::close() }}
            </div>
            
        </div>
    </div>
</section>
<!-- /.content -->
@stop

@section('myscripts')
<script>

    $("#companyForm").validate({
        // Specify the validation rules
        rules: {
            name: {
                required: true
            },
            address: {
                required: true
            },
            contact_person_name: {
                required: true
            },
            contact_person_number: {
                required: true,
                digits: true
            }
        },
        messages: {
            name: {
                required: "Please enter company name"
            },
            address: {
                required: "Please enter company address"
            },
            contact_person_name: {
                required: "Please enter contact person name"
            },
            contact_person_number: {
                required: "Please enter contact person number",
                digits: "Only numeric value is allow."
            }
        },
        errorPlacement: function (error, element) {
            var name = $(element).attr("name");
            var errorDiv = $(element).parent();
            errorDiv.append(error);
            //  error.appendTo($("#" + name + "_login_validate"));
        }
    });

    function readURL(input)
    {
        if (input.files && input.files[0]) 
        {
            
            console.log(reader);
            var extension = input.files[0].name.split('.').pop().toLowerCase(); // get file extension
            if(extension == 'jpg' || extension == 'jpeg' || extension == 'png' || extension == 'gif')
            {
                var reader = new FileReader();
                reader.onload = function (e) 
                {
                    var image = new Image();
                    //Set the Base64 string return from FileReader as source.
                    image.src = e.target.result;
                    //Validate the File Height and Width.
                    image.onload = function () 
                    {
                        var height = this.height;
                        var width = this.width;
                        //alert(height+" :: "+width);

                        $("#isValidImage").val(1);
                        $('.compnayLogo').attr('src', e.target.result);
                        /*if(height <= 100 && width <= 170)
                        {
                            $("#isValidImage").val(1);
                            $('.compnayLogo').attr('src', e.target.result);
                        }
                        else
                        {
                            $("#isValidImage").val(0);
                            $("#imgError").html("Upload valid image");
                        }*/
                    }
                };
                reader.readAsDataURL(input.files[0]);
            }
            else
            {
                $("#isValidImage").val(0);
                $("#imgError").html("Allow only jpg,jpeg,png and gif image ");
            }
        } 
        else 
        {
            $('.compnayLogo').attr('src', "{{$companyResult->logo}}");
        }
    }

    $("#logo").change(function () {
    readURL(this);
    });
</script>
@stop