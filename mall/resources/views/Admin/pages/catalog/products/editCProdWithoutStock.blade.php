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

<div class="nav-tabs-custom"> 
    {!! view('Admin.includes.productHeader',['id' => $prod->id, 'prod_type' => $prod->prod_type]) !!}
    <div class="tab-content">
        <div class="tab-pan-active" id="activity">

            <div class="panel-body">
                {!! Form::model($prod, ['method' => 'post', 'files'=> true, 'url' => $action , 'id'=>'ProdV','class' => 'form-horizontal' ]) !!}
                {!! Form::hidden('id',null) !!}
                {!! Form::hidden('updated_by', Auth::id()) !!}
                {!! Form::hidden('prod_id',$prod->id) !!}

                <div class="ExistProdVAr">
                    <div class="row form-group ">
                        @foreach($attrs as $id => $attr)
                        
                       
                        
                        <div class="col-md-12">
                            <div class="tC">
                                <div class="col-md-3">
                                    {!! Form::label('select varient', 'Select ' . $attr['name'] ,['class'=>'control-label']) !!}
                                    {!! Form::select('id['.$id.'][]', $attr['options'] ,null,["class"=>'form-control existingAttrId']) !!}
                                </div>

                                <div class="col-md-2">
                                    {!! Form::label('price', 'Extra Price',['class'=>'control-label']) !!}
                                    {!! Form::text("price[$id][]",0,["class"=>"form-control"]) !!}
                                </div>


                                <div class="col-md-2">
                                    {!! Form::label('is_avail', 'Availability',['class'=>'control-label']) !!}
                                    {!! Form::select("is_avail[$id][]",['1'=>'Yes','0'=>'No'],null,["class"=>"form-control"]) !!}
                                </div>
                            </div>
                            <div class="col-md-5">
                                <a href="javascript:void();" class="addNewProd"><span class="label label-success label-mini">Add</span></a>
                            </div>
                         
                            
                        </div>

                        @endforeach


                    
                        
                      

                    </div>  
                </div>

                <div class="line line-dashed b-b line-lg pull-in"></div>
                <div class="form-group col-sm-12 ">

                    {!! Form::hidden('return_url',null,['class'=>'rtUrl']) !!}
                    {!! Form::button('Save & Exit',["class" => "btn btn-primary pull-right saveProdVExit"]) !!}
                    {!! Form::button('Save & Continue',["class" => "btn btn-primary pull-right saveProdVContine"]) !!}
                    {!! Form::submit('Save & Next',["class" => "btn btn-primary pull-right"]) !!}


                    {!! Form::close() !!}     


                </div>
                </form>
            </div>

            <div class="bg-light lter b-b wrapper-md">
                <h1 class="m-n font-thin h3">Product Varients</h1>
            </div>

            <div class="table-responsive">
                <table class="table table-striped b-t b-light">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Availability</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($prodVariants as $prd)

                        <tr>
                            <td>{{ $prd->product }}</td>
                            <td>{{ $prd->is_avail == 1 ? "Yes" : "No" }}</td>
                            <td>{{ $prd->price }}</td>
                          

                            <td>
                                <a href="{!! route('admin.products.variant.update',['id'=>$prd->id]) !!}" class="label label-success active" ui-toggle-class="" target="_blank">Edit</a>
                            </td>
                        </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>
            <footer class="panel-footer">
                <div class="row">
                    <div class="col-sm-4 text-right text-center-xs pull-right">                

                    </div>
                </div>
            </footer>

        </div>






    </div>

</div>
@stop 

@section('myscripts')

<script>



    $(".saveProdVExit").click(function () {
        $(".rtUrl").val("{!!route('admin.products.view')!!}");
        $("#ProdV").submit();

    });

    $(".saveProdVContine").click(function () {
        // alert("sdfsf");
        $(".rtUrl").val("{!!route('admin.products.configurable.without.stock.attributes',['id'=>$prod->id])!!}");
        $("#ProdV").submit();

    });

    $("body").on("click", ".addNewProd", function () {
        $(this).parent().parent().append('<div class="clearfix"></div>');
        $(this).parent().parent().append($(this).parent().parent().find(".tC").eq(0).clone());
        
        $(this).parent().parent().append('<div class="col-md-5"><a href="javascript:void();" class="deleteProd"><span class="label label-danger label-mini">Delete</span></a></div>');   
   
        
        
    });
    $("body").on("click", ".deleteProd", function () {
        
       // alert($(this).parent().parent().text());

      $(this).parent().prev("div").remove();
       $(this).parent().remove();

    });


</script>
@stop