@extends('Admin.Layouts.default')

@section('contents')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
       Brand Add/Edit
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.masters.brand.view') }}"><i class="fa fa-dashboard"></i>Brand</a></li>
        <li class="active">Add/Edit</li>
    </ol>
</section>
<section class="content">
    <div class="row">

        <div class="col-xs-12">
            <div class="box pt50">
                {{ Form::model($brandResult, ['route' => ['admin.masters.brand.saveUpdate', $brandResult->id], 'class'=>'form-horizontal','id'=>'brandForm','method'=>'post','files'=> true]) }}
                {{ Form::hidden('id',(Input::get('id')?Input::get('id'):null)) }}
                <div class="box-body">
                    <div class="form-group">
                        {{ Form::label('Brand Name *', 'Brand Name *', ['class' => 'col-sm-3 control-label']) }}
                        <div class="col-sm-6 col-xs-12">
                            {{Form::text('name',  null, ['class'=>'form-control']) }}
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('Company *', 'Company *', ['class' => 'col-sm-3 control-label']) }}
                        <div class="col-sm-6 col-xs-12">
                            <select id="company_id" name="company_id" class="form-control" required="true">
                                @foreach($companyList as $companyId=>$companyName)
                                    @if($companyId == $brandResult->company_id)
                                        <option value="{{$companyId}}" selected>{{$companyName}}</option>
                                    @else
                                        <option value="{{$companyId}}">{{$companyName}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('Industry *', 'Industry *', ['class' => 'col-sm-3 control-label']) }}
                        <div class="col-sm-6 col-xs-12">
                            <select id="industry_id" name="industry_id" class="form-control" required="true">
                                @foreach($industryList as $catId=>$catName)
                                    @if($catId == $brandResult->industry_id)
                                        <option value="{{$catId}}" selected>{{$catName}}</option>
                                    @else
                                        <option value="{{$catId}}">{{$catName}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        {{ Form::label('Logo', 'Logo *', ['class' => 'col-sm-3 control-label']) }}
                        <div class="col-sm-6 col-xs-12">
                            <input type="file" id="logo" name="logo" class="form-control">
                            {{-- <span>(Logo size must be 170px W X 100px H )</span> --}}
                            <input type="hidden" name="hdnLogo" value="{{@$brandResult->logo}}" class="form-control">
                            <input type="hidden" name="isValidImage" id="isValidImage" value="1" class="form-control">
                            <div id="imgError" style="color:red;"></div>
                            @if(!empty($brandResult->logo))
                                <img height="100px" width="100px src="{{ asset(Config('constants.brandImgPath').''.$brandResult->logo) }}" class="img-responsive brandLogo" />
                            @else
                                <img  height="100px" width="100px" class="img-responsive brandLogo" />
                            @endif

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

    $("#brandForm").validate({
        // Specify the validation rules
        rules: {
            name: {
                required: true
            },
            company_id: {
                required: true
            },
            industry_id: {
                required: true
            }
        },
        messages: {
            name: {
                required: "Please enter brand name"

            },
            company_id: {
                required: "Please select company"
            },
            industry_id: {
                required: "Please select industry"
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

                        $("#isValidImage").val(1);
                        $('.brandLogo').attr('src', e.target.result);
                        //alert(height+" :: "+width);
                        /*if(height <= 100 && width <= 170)
                        {
                            $("#isValidImage").val(1);
                            $('.brandLogo').attr('src', e.target.result);
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
                $("#imgError").html("Allow only jpg,jpeg,png and gif image");
            }
        }
        else
        {
            $('.brandLogo').attr('src', "{{$brandResult->logo}}");
        }
    }

    $("#logo").change(function () {
    readURL(this);
    });
</script>
@stop
