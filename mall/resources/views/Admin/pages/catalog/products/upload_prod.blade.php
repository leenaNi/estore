@extends('Admin.layouts.default')
@section('content')


<section class="content-header">
    <h1>
        Products

    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Products</li>
        <li class="active">Add/Edit</li>
    </ol>
</section>





<section class="content">

    <div class="nav-tabs-custom"> 
        {!! view('Admin.includes.productHeader',['id' => $prod->id, 'prod_type' => $prod->prod_type]) !!}
        <div class="tab-content">
            <div class="tab-pan-active" id="activity">

                <div class="panel-body">
                    {!! Form::model($prod, ['method' => 'post', 'files' => true, 'url' => $action ,'id'=>'uploadProdF' ,'class' => 'form-horizontal','files'=>true ]) !!}
                    {!! Form::hidden('updated_by', Auth::id()) !!}
                    {!! Form::hidden('id',null) !!}
                    <p style="color: red;text-align: center;">{{ Session::get('delDownloadableProd') }}</p>

                    <div class="existingDiv">
                        @if($prod->downlodableprods()->count() > 0)


                        @foreach($prod->downlodableprods()->get() as $downLProds)
                        <div class="clearfix"></div>
                        <div>
                            <div>
                                <div class="form-group col-md-2">
                                    <div class="col-md-12">
                                        <a href='{{config("constants.productImgPath").$downLProds->image_d}}' target="_blank">{{$downLProds->image_d}}</a>
                                    </div>
                                </div>

                                <div class="form-group col-md-2">
                                    <div class="col-md-12">
                                        {!! Form::file('image_d[]',["class"=>'form-control']) !!}
                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <div class="col-md-12">
                                        {!! Form::text('sort_order_d[]',$downLProds->sort_order_d,["class"=>'form-control',"placeholder"=>"Sort Order"]) !!}
                                    </div>
                                </div>


                                <div class="form-group col-md-2">
                                    <div class="col-md-12">
                                        {!! Form::text('alt_text[]',$downLProds->alt_text,["class"=>'form-control',"placeholder"=>"Alt Text"]) !!}
                                    </div>
                                </div>
                                {!! Form::hidden('id_img[]',$downLProds->id) !!}

                                <div class="form-group col-md-2">
                                    <div class="col-md-12">
                                        <a href="javascript:void()" data-prodID ="{{$downLProds->id }}"  class="label label-danger DelProd" >Delete</a>

                                    </div>
                                </div>
                            </div>
                        </div>


                        @endforeach 

                        @else


                        <div class="form-group col-md-3">
                            <div class="col-md-12">
                            </div>
                        </div>

                        <div class="form-group col-md-2">
                            <div class="col-md-12">
                                {!! Form::file('image_d[]',["class"=>'form-control']) !!}
                            </div>
                        </div>
                        <div class="form-group col-md-2">
                            <div class="col-md-12">
                                {!! Form::text('sort_order_d[]',null,["class"=>'form-control',"placeholder"=>"Sort Order"]) !!}
                            </div>
                        </div>


                        <div class="form-group col-md-2">
                            <div class="col-md-12">
                                {!! Form::text('alt_text[]',null,["class"=>'form-control',"placeholder"=>"Alt Text"]) !!}
                            </div>
                        </div>
                        {!! Form::hidden('id_img[]',null) !!}




                        @endif

                        <div class="form-group col-md-2">
                            <div class="col-md-12">
                                <a href="javascript:void()" class="label label-success AddMore" > Add More</a>

                            </div>
                        </div>
                    </div>

                    <div>

                        <div class="clearfix"></div>


                        <div class="form-group">
                            {!! Form::hidden('return_url',null,['class'=>'rtUrl']) !!}
                            <div class="form-group col-sm-12 ">
                                {!! Form::button('Save & Exit',["class" => "btn btn-primary pull-right saveUploadProdExit"]) !!}
                                {!! Form::button('Save & Continue',["class" => "btn btn-primary pull-right saveUploadProdContine"]) !!}
                                {!! Form::submit('Save & Next',["class" => "btn btn-primary pull-right saveUploadProdNext"]) !!}
                            </div>


                            <div class="col-sm-4 col-sm-offset-2">

                                {!! Form::close() !!}     
                            </div>
                        </div>



                    </div>

                </div>

            </div>


            <div class="toClone" style="display:none;">
                <div>
                    <div class="clearfix"></div> 
                    <div class="form-group col-md-3">
                        <div class="col-md-12">
                            {!! Form::file('image_d[]',["class"=>'form-control']) !!}
                        </div>
                    </div>
                    <div class="form-group col-md-3">
                        <div class="col-md-12">
                            {!! Form::text('sort_order_d[]',null,["class"=>'form-control',"placeholder"=>"Sort Order"]) !!}
                        </div>
                    </div>


                    <div class="form-group col-md-3">
                        <div class="col-md-12">
                            {!! Form::text('alt_text[]',null,["class"=>'form-control',"placeholder"=>"Sort Order"]) !!}
                        </div>
                    </div>

                    {!! Form::hidden('id_img[]',null) !!}
                    <div class="form-group col-md-3">
                        <div class="col-md-12">
                            <a href="javascript:void()" class="label label-danger deL" >Delete</a>

                        </div>
                    </div>
                </div>

            </div>

        </div>

</section>
@stop 

@section('myscripts')

<script>

    $(".saveUploadProdExit").click(function () {

        $(".rtUrl").val("{!!route('admin.products.prodUpload')!!}");
        $("#uploadProdF").submit();

    });

    $(".saveUploadProdContine").click(function () {
        $(".rtUrl").val("{!!route('admin.products.prodUpload',['id'=>Input::get('id')])!!}");
        $("#uploadProdF").submit();

    });

    $(".saveUploadProdNext").click(function () {
        $(".rtUrl").val("{!!route('admin.products.view')!!}");
        $("#uploadProdF").submit();

    });


    $(".AddMore").click(function () {

        $(".existingDiv").append($(".toClone").html());

    });

    $("body").on("click", ".deL", function () {

        $(this).parent().parent().parent().remove();

    });


       $("body").on("click", ".DelProd", function() {
            var imgId = $(this).attr("data-prodID");
            var chk = confirm("Are you sure want to delete this image?");
            if (chk == true) {
                // alert($(this).attr("data-value"));
                $.ajax({
                    type: "POST",
                    url: "{!! route('admin.products.prodUploadDel') !!}",
                    catch : false,
                    data: {imgId: imgId},
                    success: function(data) {
                        $(".successDel").text(data);
                        location.reload();

                    }
                });
            }


        });




</script>
@stop