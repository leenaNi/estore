@extends('Admin.layouts.default')
@section('mystyles')
<style>
    .bxmodal{
        margin: 10px 0;
        border: 1px #eee solid;
        float: left;
        width: 100%;
        padding: 15px;
    }



</style>

<!--<link rel="stylesheet" href="{{asset(Config('constants.fileUploadPluginPath').'css/style.css')}}">-->
<link rel="stylesheet" href="{{Config('constants.fileUploadPluginPath').'css/jquery.fileupload.css'}}">

<link rel="stylesheet" href="{{Config('constants.fileUploadPluginPath').'css/jquery.fileupload-ui.css'}}">

<noscript><link rel="stylesheet" href="{{Config('constants.fileUploadPluginPath').'css/jquery.fileupload-noscript.css'}}"></noscript>
<noscript><link rel="stylesheet" href="{{Config('constants.fileUploadPluginPath').'css/jquery.fileupload-ui-noscript.css'}}"></noscript> 

@stop
@section('content')

<section class="content-header">
    <h1>
        Products ({{$productCount }})
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Products</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                @if(!empty(Session::get('message')))
                <div class="alert alert-danger" role="alert">
                    {{ Session::get('message') }}
                </div>
                @endif
                @if(!empty(Session::get('msg')))
                <div class="alert alert-success" role="alert">
                    {{Session::get('msg')}}
                </div>
                @endif


                <div class="box-header box-tools filter-box col-md-12 noBorder">
                        <div class="col-md-9 noBorder">
                    <form action="" method="get" >
                        <input type="hidden" name="dataSearch" value="dataSearch"/>

                        <div class="form-group col-md-4 noBottomMargin">
                            <div class="input-group-btn">
                                <input type="text" name="product_name" class="form-control medium pull-right catSearcH" placeholder="Search Something" value="{{ (!empty(Input::get('product_name'))) ? Input::get('product_name') :''}}">
                            </div>
                        </div>
                        <div class="form-group col-md-4">

                            {!! Form::select('category',$category,!empty(Input::get('category'))?Input::get('category'):null, ["class"=>'form-control']) !!}
                        </div>
                        <div class="form-group col-md-4 noBottomMargin">
                            <button type="submit" class="btn btn-primary form-control"> Search</button>
                        </div>
                    </form>
                        </div>
                      <div class="btn-group  col-md-3 noBottomMargin">
                            <a href="{{route('admin.products.view')}}"><button type="button" class="btn sbtn btn-block reset-btn" value="reset">Reset</button></a>
                        </div>
                </div>

                <?php
//dd($category);
                ?>

                <div class="clearfix"></div>
                <div class="dividerhr"></div>

                <div style="clear: both"></div>
                <div class="box-body table-responsive no-padding">
                    <table class="table table-striped table-hover tableVaglignMiddle">
                        <thead>
                            <tr>

                                <th>Image</th>
                                <th>@sortablelink ('product', 'Product')</th>
                                <th>Category</th>

                                <th><?php //echo !empty(Session::get('currency_symbol')) ? "(".Session::get('currency_symbol').")" : '';            ?>@sortablelink ('price', 'Price') </th>

                                @if($settingStatus['26'] == 1)
                                <th>Stock</th>
                                @endif
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @if(count($products) >0 )
                            @foreach($products as $product)

                            <tr> 
                                <td>

                                    <div class="product-name vMiddle">
                                        <span>
                                            <?php
//echo $product->mainImage;
                                            ?>
                                            <img src="{{($product->mainImage)? $product->mainImage:'' }}" class="admin-profile-picture" />
                                        </span>

                                    </div>

                                </td>
                                <!-- <td>{{$product->product_code }}</td> -->
                                <td>
                                    <span class="marginleft10">
                                        {{$product->product }}<br> 
                                        <span class="breakLine"> 
                                            @if($product->product_code)
                                            ({{ $product->product_code }})
                                            @endif
                                        </span>    
                                    </span>  
                                </td>
                               
                                <td>  {{($product->categories()->first()->category) }}<br> 
                                      </td>
                                <td>

                                    @if( $product->spl_price <= 0 )
                                    <?php echo!empty(Session::get('currency_symbol')) ? Session::get('currency_symbol') : ''; ?> <span class="priceConvert"> {{ $product->price }} </span>
                                    @else
                        <strike>
                            <?php echo!empty(Session::get('currency_symbol')) ? Session::get('currency_symbol') : ''; ?>
                            <span class="priceConvert">{{$product->price }}</span> </strike><br><?php echo!empty(Session::get('currency_symbol')) ? Session::get('currency_symbol') : ''; ?>
                        <span class="priceConvert"> {{ $product->spl_price }} </span>
                        @endif
                        </td>

                        @if($settingStatus['26'] == 1)
                        <td>{{ $product->stock }}</td>
                        @endif
                        <td>
                            @if($product->status==1)
                            <a href="{!! route('admin.products.changeStatus',['id'=>$product->id]) !!}" class="" ui-toggle-class="" onclick="return confirm('Are you sure you want to disable this product?')" data-toggle="tooltip" title="Enabled"><i class="fa fa-check btn-plen btn"></i></a>
                            @elseif($product->status==0)
                            <a href="{!! route('admin.products.changeStatus',['id'=>$product->id]) !!}" class="" ui-toggle-class="" onclick="return confirm('Are you sure you want to enable this product?')" data-toggle="tooltip" title="Disabled"><i class="fa fa-times btn-plen btn"></i></a>
                            @endif
                        </td>
                        <td>
                            No action
                        </td>
                        </tr>
                        @endforeach
                        @else
                        <tr><td colspan=10> No Record Found</td></tr>
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="box-footer clearfix">

                    <?php
                    $args = [];
                    !empty(Input::get("product_name")) ? $args["product_name"] = Input::get("product_name") : '';

                    !empty(Input::get("product_code")) ? $args["product_code"] = Input::get("product_code") : '';
                    //echo $products->appends(Input::except('page'))->render();

                    if (empty(Input::get('prdSearch'))) {
                        echo $products->render();
                    }
                    ?>

                </div>
            </div><!-- /.box -->
        </div><!-- /.col -->

    </div>
    <div class="modal fade" id="bulkProduct" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Bulk Upload/Download</h4>
                </div>
                <div class="modal-body">
                    <div  class="bxmodal">
                        <div class='col-md-6 mob-marBottom15'>
                            <label>Products Download</label>
                        </div>
                        <div class='col-md-6'>
                            <a href="{{ route('admin.products.sampleBulkDownload')}}" class="btn btn-primary sampleDownload noMob-leftmargin">Download</a>
                        </div>
                    </div>
                    <div  class="bxmodal">
                        <form action="{{ route('admin.products.productBulkUpload') }}" method="post" enctype="multipart/form-data">
                            <div class='col-md-6 mob-marBottom15'>
                                <label>Products Upload</label>
                                <input type="file" name="file" class="fileUploder" onChange="validateFile(this.value)"/>
                            </div>
                            <div class='col-md-6'>
                                <input type="submit" class="btn btn-primary noMob-leftmargin" value="Upload">
                            </div>
                        </form>
                    </div>
                    <div  class="bxmodal">
                        <form id="fileupload" action="{{ asset(route('admin.products.prdBulkImgUpload')) }}" method="POST" enctype="multipart/form-data">
                            <!-- Redirect browsers with JavaScript disabled to the origin page -->
                    <!--        <noscript><input type="hidden" name="redirect" value="https://blueimp.github.io/jQuery-File-Upload/"></noscript>-->
                            <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                            <div class="row fileupload-buttonbar">
                                <div class="col-lg-12">
                                    <!-- The fileinput-button span is used to style the file input field as button -->
                                    <span class="btn btn-primary fileinput-button col-lg-4">
                                        <i class="glyphicon glyphicon-plus"></i>
                                        <span>Add files...</span>
                                        <input type="file" name="files[]" multiple>
                                    </span>
                                    <button type="submit" class="btn btn-primary start  col-lg-4 ">
                                        <i class="glyphicon glyphicon-upload"></i>
                                        <span>Start upload</span>
                                    </button>
                                    <!--                                    <button type="reset" class="btn btn-warning cancel">
                                                                            <i class="glyphicon glyphicon-ban-circle"></i>
                                                                            <span>Cancel upload</span>
                                                                        </button>-->
                                    <!--                                    <button type="button" class="btn btn-danger delete">
                                                                            <i class="glyphicon glyphicon-trash"></i>
                                                                            <span>Delete</span>
                                                                        </button>-->
                                    <!--                                    <input type="checkbox" class="toggle">-->
                                    <!-- The global file processing state -->
                                    <span class="fileupload-process"></span>
                                </div>
                                <!-- The global progress state -->
                                <div class="col-lg-5 fileupload-progress fade">
                                    <!-- The global progress bar -->
                                    <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                                    </div>
                                    <!-- The extended global progress state -->
                                    <div class="progress-extended">&nbsp;</div>
                                </div>
                            </div>
                            <!-- The table listing the files available for upload/download -->
                            <table role="presentation" class="table table-striped">
                                <tbody class="files"></tbody>
                            </table>
                            <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
                                <div class="slides"></div>
                                <h3 class="title"></h3>
                                <a class="prev">‹</a>
                                <a class="next">›</a>
                                <a class="close">×</a>
                                <a class="play-pause"></a>
                                <ol class="indicator"></ol>
                            </div>
                        </form>
                        <br>
                    </div>
                </div>
                <div class='clearfix'></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal --> 
    <div class="modal fade" id="myModalbarcode" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <span id="tempHtml"></span>
                <form id="get_quantity"  method="post" action="">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Product Print Quantity</h4>
                    </div>
                    <div class="modal-body" >
                        <input type="hidden" name="csrf-token" value="<?php echo csrf_token() ?>"/>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Quantity</th>
                                </tr>
                            </thead>

                            <tbody id="print_loop">

                            </tbody>
                        </table>


                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-default" >Submit</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>

            </div>

        </div>
    </div>
    <div class="modal fade" id="modalBulkUpdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <span id="tempHtml"></span>
                <form  method="post" action="{{route('admin.products.bulkUpdate')}}">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body" >
                        <input type="hidden" name="csrf-token" value="<?php echo csrf_token() ?>"/>
                        <table class="table table-bordered">
                            <thead>
                                <tr>                                    
                                    <th class="b-action"></th>
                                    <th class="product_loop"></th>
                                </tr>
                            </thead>
<!--                            <tbody class="product_loop">
                            </tbody>-->
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-default" >Submit</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </form>

            </div>

        </div>
    </div>



    <!-- Product Add Modal -->

    <!-- Product Close Modal Open -->
</section>
<div id="addProductCat" class="modal fade" role="dialog">
    <div class="modal-dialog addProduct-modal-dialog">
        <div class="modal-content">
            <div class="modal-header addProduct-modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Plese Create/Select Category First</h4>
            </div>
            <div class="box-body">
                <p>Please select/create minimum one Category before adding a product by clicking on Categories under Product in the left menu.</p>
            </div>
            <!-- Modal content-->





        </div>

    </div>
</div>
<div id="addProduct" class="modal fade" role="dialog">
    <div class="modal-dialog addProduct-modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">




        </div>

    </div>
</div>
<input type="hidden" id="page_type" value="main"/>
@stop
@section('myscripts')






@stop