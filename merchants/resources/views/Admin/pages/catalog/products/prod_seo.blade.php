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
                    {!! Form::model($prod, ['method' => 'post', 'files' => true, 'url' => $action ,'id'=>'seoProdF' , 'files'=>true ]) !!}
                    {!! Form::hidden('updated_by', Auth::id()) !!}
                    {!! Form::hidden('id',null) !!}
                    <?php $cat=$prod->categories->pluck("category")->toArray();
                    $img=asset(config('constants.productImgPath')).'/'.$prod->catalogimgs->first()->filename;
                  
                    $catName=implode(",",$cat);
                 $social_link= $_SERVER['HTTP_HOST'].'/'.$prod->url_key;
                    ?>
                    <div class="row">
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('meta_title', 'Meta Title',['class'=>'control-label']) !!}
                            {!! Form::text('meta_title',$prod->meta_tittle?$prod->meta_tittle:$prod->product, ["class"=>'form-control' ,"placeholder"=>'Enter Meta Title']) !!}
                        </div>
                    </div>
                       
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('meta_keys', 'Meta Keywords',['class'=>'control-label']) !!}
                            {!! Form::text('meta_keys',$prod->meta_keys?$prod->meta_keys:$catName,["class"=>'form-control',"placeholder"=>"Enter Meta Keywords"]) !!}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('meta_desc', 'Meta Description',['class'=>'control-label']) !!}
                            {!! Form::text('meta_desc',$prod->meta_desc?$prod->meta_desc:$prod->short_desc,["class"=>'form-control',"placeholder"=>"Enter Meta Description"]) !!}
                        </div>
                    </div>
                    <div class="clearfix"></div>
                   <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('meta_robot', 'Meta Robots',['class'=>'control-label']) !!}
                            {!! Form::text('meta_robot',null,["class"=>'form-control',"placeholder"=>"Enter Meta Robots"]) !!}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('canonical', 'Canonical',['class'=>'control-label']) !!}
                            {!! Form::text('canonical',null,["class"=>'form-control',"placeholder"=>"Enter Canonical "]) !!}
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('og_title', 'Social Shared  Title',['class'=>'control-label']) !!}
                            {!! Form::text('og_title',null,["class"=>'form-control',"placeholder"=>"Enter Social Shared  Title"]) !!}
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('og_desc', 'Social Shared Description',['class'=>'control-label']) !!}
                            {!! Form::text('og_desc',null,["class"=>'form-control',"placeholder"=>"Enter Social Shared Description"]) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('og_image', 'Social Shared Image',['class'=>'control-label']) !!}
                            {!! Form::text('og_image',$prod->og_image?$prod->og_image:$img,["class"=>'form-control',"placeholder"=>"Enter Social Shared Image"]) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('og_url', 'Social Shared URL',['class'=>'control-label']) !!}
                            {!! Form::text('og_url',$prod->og_url?$prod->og_url:$social_link,["class"=>'form-control',"placeholder"=>"Enter Social Shared URL"]) !!}
                        </div>
                    </div>                   
                     <div class="clearfix"></div>
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('other_meta', 'Google Analytics',['class'=>'control-label']) !!}
                            {!! Form::textarea('other_meta',null,["class"=>'form-control',"placeholder"=>"Google Analytics"]) !!}
                        </div>
                    </div>
                    <div class="clearfix"></div>

                    <div class="form-group">
                        {!! Form::hidden('return_url',null,['class'=>'rtUrl']) !!}
                        <div class="form-group col-sm-12 ">
                            {!! Form::button('Save & Exit',["class" => "btn btn-primary pull-right saveProdSeoExit"]) !!}
                            {!! Form::button('Save & Continue',["class" => "btn btn-primary pull-right saveProdSeoContine"]) !!}
                           
                        </div>
                        <div class="col-sm-4 col-sm-offset-2">
                            {!! Form::close() !!}     
                        </div>
                    </div>
                  </div>  
                </div>
            </div>
        </div>

    </div>

</section>
@stop 

@section('myscripts')

<script>

    $(".saveProdSeoExit").click(function () {

        $(".rtUrl").val("{!!route('admin.products.view')!!}");
        $("#seoProdF").submit();

    });

    $(".saveProdSeoContine").click(function () {
        $(".rtUrl").val("{!!route('admin.products.prodSeo',['id'=>Input::get('id')])!!}");
        $("#seoProdF").submit();

    });

    $(".saveProdSeoNext").click(function () {

<?php if ($prod->prod_type == 5) { ?>
            $(".rtUrl").val("{!!route('admin.products.prodUpload',['id'=>Input::get('id')])!!}");

<?php } else { ?>
            $(".rtUrl").val("{!! route('admin.products.view') !!}");
<?php } ?>
        $("#seoProdF").submit();

    });



</script>
@stop