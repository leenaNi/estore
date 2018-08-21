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
<link rel="stylesheet" href="{{asset(Config('constants.fileUploadPluginPath').'css/jquery.fileupload.css')}}">

<link rel="stylesheet" href="{{asset(Config('constants.fileUploadPluginPath').'css/jquery.fileupload-ui.css')}}">

<noscript><link rel="stylesheet" href="{{asset(Config('constants.fileUploadPluginPath').'css/jquery.fileupload-noscript.css')}}"></noscript>
<noscript><link rel="stylesheet" href="{{asset(Config('constants.fileUploadPluginPath').'css/jquery.fileupload-ui-noscript.css')}}"></noscript> 

@stop
@section('content')

<section class="content-header">
    <h1>
        Products
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
                <div class="box-header box-tools filter-box col-md-9 noBorder">
                    {!! Form::open(['method' => 'get', 'route' => 'admin.products.view' , 'id' => 'searchForm' ]) !!}
                    {!! Form::hidden('productsCatalog',null) !!}
                    <div class="form-group col-md-4">
                        {!! Form::text('product_name',Input::get('product_name'), ["class"=>'form-control', "placeholder"=>"Product"]) !!}
                    </div>
                    <div class="form-group col-md-4">
                        {!! Form::text('pricemin',Input::get('pricemin'), ["class"=>'form-control ', "placeholder"=>"Min Price"]) !!}
                    </div>
                    <div class="form-group col-md-4">
                        {!! Form::text('pricemax',Input::get('pricemax'), ["class"=>'form-control ', "placeholder"=>"Max Price"]) !!}
                    </div>
                    <div class="form-group col-md-4">
                        {!! Form::select('category',$category,Input::get('category'), ["class"=>'form-control', "placeholder"=>"Category"]) !!}
                    </div>
                    <div class="form-group col-md-4">
                        {!! Form::select('status',['1'=>'Approved', '0'=>'Disapproved'],Input::get('status'), ["class"=>'form-control ', "placeholder"=>"Status"]) !!}
                    </div>
                    <div class="form-group col-md-4">
                        {!! Form::select('availability',['1'=>'In Stock', '0'=>'Out of Stock'],Input::get('availability'), ["class"=>'form-control filter_type', "placeholder"=>"Availability"]) !!}
                    </div>
                    <div class="form-group col-md-4">
                        {!! Form::select('updated_by',$user,Input::get('updated_by'), ["class"=>'form-control ', "placeholder"=>"Updated By"]) !!}
                    </div>
                    <div class="form-group col-md-4">
                        {!! Form::text('datefrom',Input::get('datefrom'), ["class"=>'form-control datepicker', "placeholder"=>"From Date"]) !!}
                    </div>
                    <div class="form-group col-md-4">
                        {!! Form::text('dateto',Input::get('dateto'), ["class"=>'form-control datepicker', "placeholder"=>"To Date"]) !!}
                    </div>
                   
                        <div class="button-filter-search col-md-2 noRightMargin">
                            <button type="submit" name="search" class="btn btn-primary form-control noLeftMargin" value="Search"><i class="fa fa-search" aria-hidden="true"></i> Filter</button>
                        </div>
                        <div class="button-filter col-md-2 noBorder">
                            <a href="{{route('admin.products.view')}}"><button type="button" class="btn btn-default noLeftMargin form-control" value="reset">Reset</button></a>
                        </div>
                    
                    {!! Form::close() !!}
                </div>
                <div class="box-header col-md-3">
                    <a href="{!! route('admin.apiprod.add') !!}" class="btn btn-default pull-right col-md-12" type="button">Add New Product</a>
                <br><br>
                    <button class="btn btn-default pull-right col-md-12 bulkuploadprod" type="button">Bulk Upload</button>
                <br><br>
                    <select id="bulk_action" class="btn btn-default dropdown-toggle pull-right col-md-12" type="button">
                        <option value="">Bulk Action</option>
                        <option value="export">Export</option>
                        <option value="remove">Remove</option>
                        <option value="update_stock_status">Change Stock Status</option>
                        <option value="update_price">Update Price</option>
                        <option value="update_special_price">Update Special Price</option>
                        <option value="add_category">Assign New Category</option>
                        @if($barcode == 1)
                        <option value="print_barcode">Print Barcode</option>
                        @endif
                        <option value="update_availability">Update Availability</option>
                    </select>
                </div>

                @if($barcode == 1)    
                <!--                <div class="box-header col-md-3">
                                    <button id="print_all" class="btn btn-info pull-right col-md-12 barcode_print" type="button">Print Barcode</button>
                                </div>-->
                @endif

               <div class="clearfix"></div>
                <div class="dividerhr"></div>
                <div class="box-body table-responsive no-padding">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                @if($barcode == 1)   <th><input type="checkbox" id="masterCheck" value="00"/></th>  @endif
                                <th>@sortablelink ('id', 'Sr No')</th>
                                <th>@sortablelink ('product', 'Product')</th>
                                <th>@sortablelink ('barcode', 'Bar Code')</th>
                                <th>Categories</th>
                                <th>@sortablelink ('purchase_price', 'Purchase Price')</th>
                                <th>@sortablelink ('price', 'MRP')</th>
                                <th>@sortablelink ('selling_price', 'Selling Price')</th>
                                <th>Stock</th>
                                <th>Updated By</th>
                                <th>Status </th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr> @if($barcode == 1)  <td><input type="checkbox" class="singleCheck" name="singleCheck[]" value="{{ $product->id }}-{{ $product->prod_type }}"/></td>  @endif
                                <td>{{$product->id }}</td>
                                <td><img src="{{@$product->prodImage }}" class="admin-profile-picture" />
                                    <div class="product-name">{{$product->product }}</div>
                                </td>

                                <td>{{$product->product_code }}</td>
                                <td>
                                    <?php
                                    $cat = $product->categories;
                                    foreach ($cat as $category) {
                                        ?>
                            <li>  <a href="{!! route('admin.category.edit',['id'=>$category->id]) !!}" class="edit"> {!! $category->category  !!}</a> </li>

                            <?php
                        }
                        ?>
                        </td>
                <!--        <td>{{$product->stock }}</td>-->
                        <td><i class="fa fa-rupee"></i> {{$product->purchase_price }}</td>
                        <td><i class="fa fa-rupee"></i> {{$product->price }}</td>
                        <td><i class="fa fa-rupee"></i> {{$product->selling_price }}</td>
                        <td>{{ $product->stock }}</td>
                        <td>{{ @$product->users->firstname}}</td>
                        <td>
                           
                            @if($product->status==1)
                            <a href="{!! route('admin.apiprod.changeStatus',['id'=>$product->id]) !!}"  ui-toggle-class="" onclick="return confirm('Are you sure you want to disable this product?')" data-toggle="tooltip" title="Enabled"><i class="fa fa-check"></i></a>
                            @elseif($product->status==0)
                            <a href="{!! route('admin.apiprod.changeStatus',['id'=>$product->id]) !!}"  ui-toggle-class="" onclick="return confirm('Are you sure you want to enable this product?')" data-toggle="tooltip" title="Disabled"><i class="fa fa-times"></i></a>
                            @endif
                        </td>
                        <td>
                            <a href="{!! route('admin.apiprod.edit',['id'=>$product->id]) !!}"  ui-toggle-class="" data-toggle='tooltip' title='Edit'><i class="fa fa-pencil-square-o"></i></a>
                            <a href="{!! route('admin.apiprod.delete',['id'=>$product->id]) !!}"  ui-toggle-class="" onclick="return confirm('Are you sure you want to delete this product?')" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a>
                            @if($barcode == 1)  <a class="" data-id="{{ $product->id }}-{{ $product->prod_type }}" data-toggle="tooltip" title="Print"><i class="fa fa-print"></i></a>
                            <span id="barerr{{ $product->id }}"></span> @endif
                        </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">

                    <?php
                    $args = [];
                    !empty(Input::get("product_name")) ? $args["product_name"] = Input::get("product_name") : '';

                    !empty(Input::get("product_code")) ? $args["product_code"] = Input::get("product_code") : '';
                    echo $products->appends(Input::except('page'))->render();
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
                        <div class='col-md-6'>
                            <label>Products Download</label>
                        </div>
                        <div class='col-md-6'>
                            <a href="{{ route('admin.products.sampleBulkDownload')}}" class="btn btn-primary sampleDownload">Download</a>
                        </div>
                    </div>
                    <div  class="bxmodal">
                        <form action="{{ route('admin.products.productBulkUpload') }}" method="post" enctype="multipart/form-data">
                            <div class='col-md-6'>
                                <label>Products Upload</label>
                                <input type="file" name="file">
                            </div>
                            <div class='col-md-6'>
                                <input type="submit" class="btn btn-primary" value="Upload">
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
</section>
<input type="hidden" id="page_type" value="main"/>
@stop
@section('myscripts')
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="{{asset(Config('constants.fileUploadPluginPath').'js/vendor/jquery.ui.widget.js')}}"></script>
<!-- The Templates plugin is included to render the upload/download listings -->
<script src="//blueimp.github.io/JavaScript-Templates/js/tmpl.min.js"></script>
<!-- The Load Image plugin is included for the preview images and image resizing functionality -->
<script src="//blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
<!-- The Canvas to Blob plugin is included for image resizing functionality -->
<script src="//blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
<!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<!-- blueimp Gallery script -->
<script src="//blueimp.github.io/Gallery/js/jquery.blueimp-gallery.min.js"></script>
<!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
<script src="{{asset(Config('constants.fileUploadPluginPath').'js/jquery.iframe-transport.js')}}"></script>
<!-- The basic File Upload plugin -->
<script src="{{asset(Config('constants.fileUploadPluginPath').'js/jquery.fileupload.js')}}"></script>
<!-- The File Upload processing plugin -->
<script src="{{asset(Config('constants.fileUploadPluginPath').'js/jquery.fileupload-process.js')}}"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="{{asset(Config('constants.fileUploadPluginPath').'js/jquery.fileupload-image.js')}}"></script>
<!-- The File Upload audio preview plugin -->
<script src="{{asset(Config('constants.fileUploadPluginPath').'js/jquery.fileupload-audio.js')}}"></script>
<!-- The File Upload video preview plugin -->
<script src="{{asset(Config('constants.fileUploadPluginPath').'js/jquery.fileupload-video.js')}}"></script>
<!-- The File Upload validation plugin -->
<script src="{{asset(Config('constants.fileUploadPluginPath').'js/jquery.fileupload-validate.js')}}"></script>
<!-- The File Upload user interface plugin -->
<script src="{{asset(Config('constants.fileUploadPluginPath').'js/jquery.fileupload-ui.js')}}"></script>
<!-- The main application script -->
<script src="{{asset(Config('constants.fileUploadPluginPath').'js/main.js')}}"></script>
<!-- The template to display files available for upload -->
<script id="template-upload" type="text/x-tmpl">
    {% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
    <td>
    <span class="preview"></span>
    </td>
    <td>
    <p class="name">{%=file.name%}</p>
    <strong class="error text-danger"></strong>
    </td>
    <td>
    <p class="size">Processing...</p>
    <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
    </td>
    <td>
    {% if (!i && !o.options.autoUpload) { %}
    <button class="btn btn-primary start startgrid" disabled style="display:none;">
    <i class="glyphicon glyphicon-upload"></i>
    <span>Start</span>
    </button>
    {% } %}
    {% if (!i) { %}
    <button class="btn btn-warning cancel cancelgrid" style="display:none;">
    <i class="glyphicon glyphicon-ban-circle"></i>
    <span>Cancel</span>
    </button>
    {% } %}
    </td>
    </tr>
    {% } %}
</script>
<!-- The template to display files available for download -->
<script id="template-download" type="text/x-tmpl">
    {% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-download fade">
    <td>
    <span class="preview">
    {% if (file.thumbnailUrl) { %}
    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" data-gallery><img src="{%=file.thumbnailUrl%}"></a>
    {% } %}
    </span>
    </td>
    <td>
    <p class="name">
    {% if (file.url) { %}
    <a href="{%=file.url%}" title="{%=file.name%}" download="{%=file.name%}" {%=file.thumbnailUrl?'data-gallery':''%}>{%=file.name%}</a>
    {% } else { %}
    <span>{%=file.name%}</span>
    {% } %}
    </p>
    {% if (file.error) { %}
    <div><span class="label label-danger">Error</span> {%=file.error%}</div>
    {% } %}
    </td>
    <td>
    <span class="size">{%=o.formatFileSize(file.size)%}</span>
    </td>

    </tr>
    {% } %}
</script>
<script>

                                ////////////////////////////////////////////////////
                                $.ajaxSetup({
                                    headers: {
                                        'X-CSRF-Token': $('input[name="csrf-token"]').val()
                                    }
                                });

//new FormData(this)
                                $('html body').on('submit', '#get_quantity', function () {
                                    $.ajax({
                                        url: "{{ route('admin.products.barcodeForm') }}",
                                        type: 'post',
                                        data: new FormData(this),
                                        processData: false,
                                        contentType: false,
                                        //   dataType: 'json',
                                        beforeSend: function () {
                                            // $("#barerr" + id).text('Please wait');
                                        },
                                        success: function (res) {
                                            //     $("#tempHtml").html(res);
                                            window.location.href = "{{ route('admin.products.downloadbarcode') }}?url=" + res;
                                        }
                                    });
                                    return false;
                                });
                                $('#masterCheck').click(function (event) {
                                    if ($(this).is(':checked')) {
                                        $('.singleCheck').attr('Checked', 'Checked');
                                        ;
                                    } else {
                                        $('.singleCheck').removeAttr('Checked');
                                        ;
                                    }
                                });

                                $(".singleCheck").change(function () {
                                    $("#masterCheck").attr("checked", $(".singleCheck:checked").length == $(".singleCheck").length);
                                });

                                $("#bulk_action").change(function () {
                                    var $this = $(this);
                                    if ($this.val() == 'print_barcode') {
                                        $("#myModalbarcode").modal("show");
                                        $("#myModalbarcode").css("display", "block");
                                        var ids = jQuery.map($(':checkbox[name=singleCheck\\[\\]]:checked'), function (n, i) {
                                            return n.value;
                                        }).join(',');
                                        get_print_form(ids);
                                    } else if ($this.val() == 'update_stock_status') {
                                        $("#modalBulkUpdate").modal("show");
                                        $("#modalBulkUpdate").css("display", "block");
                                        var prod_list = [];
                                        var ids = jQuery.map($(':checkbox[name=singleCheck\\[\\]]:checked'), function (n, i) {
//                                            prod_list.push({id: n.value, product: $(n).closest('tr').find('.product-name').html()});
                                            prod_list.push(n.value);
                                        });
                                        get_update_form(prod_list, 'modalBulkUpdate', $this.find("option:selected").text(), $this.val());
                                    } else if ($this.val() == 'update_availability') {
                                        $("#modalBulkUpdate").modal("show");
                                        $("#modalBulkUpdate").css("display", "block");
                                        var prod_list = [];
                                        var ids = jQuery.map($(':checkbox[name=singleCheck\\[\\]]:checked'), function (n, i) {
//                                            prod_list.push({id: n.value, product: $(n).closest('tr').find('.product-name').html()});
                                            prod_list.push(n.value);
                                        });
                                        get_update_form(prod_list, 'modalBulkUpdate', $this.find("option:selected").text(), $this.val());
                                    } else if ($this.val() == 'update_price') {
                                        $("#modalBulkUpdate").modal("show");
                                        $("#modalBulkUpdate").css("display", "block");
                                        var prod_list = [];
                                        var ids = jQuery.map($(':checkbox[name=singleCheck\\[\\]]:checked'), function (n, i) {
//                                            prod_list.push({id: n.value, product: $(n).closest('tr').find('.product-name').html()});
                                            prod_list.push(n.value);
                                        });
                                        get_update_form(prod_list, 'modalBulkUpdate', $this.find("option:selected").text(), $this.val());
                                    } else if ($this.val() == 'update_special_price') {
                                        $("#modalBulkUpdate").modal("show");
                                        $("#modalBulkUpdate").css("display", "block");
                                        var prod_list = [];
                                        var ids = jQuery.map($(':checkbox[name=singleCheck\\[\\]]:checked'), function (n, i) {
//                                            prod_list.push({id: n.value, product: $(n).closest('tr').find('.product-name').html()});
                                            prod_list.push(n.value);
                                        });
                                        get_update_form(prod_list, 'modalBulkUpdate', $this.find("option:selected").text(), $this.val());
                                    } else if ($this.val() == 'export') {
                                        var prod_list = [];
                                        var ids = jQuery.map($(':checkbox[name=singleCheck\\[\\]]:checked'), function (n, i) {
//                                            prod_list.push({id: n.value, product: $(n).closest('tr').find('.product-name').html()});
                                            prod_list.push(n.value);
                                        });
                                        var str = '<form method="post" action="<?= route('admin.products.export') ?>" id="exportForm">';
                                        str += '<input type="hidden" name="productId" value="' + prod_list + '"/>';
                                        str += '<input type="hidden" name="type" value="' + $this.val() + '"/>';
                                        str += '</form>';

                                        $('body').append(str);
                                        $('#exportForm').submit();
                                    } else if ($this.val() == 'add_category') {
                                        $("#modalBulkUpdate").modal("show");
                                        $("#modalBulkUpdate").css("display", "block");
                                        var prod_list = [];
                                        var ids = jQuery.map($(':checkbox[name=singleCheck\\[\\]]:checked'), function (n, i) {
//                                            prod_list.push({id: n.value, product: $(n).closest('tr').find('.product-name').html()});
                                            prod_list.push(n.value);
                                        });
                                        get_update_form(prod_list, 'modalBulkUpdate', $this.find("option:selected").text(), $this.val());
                                    } else if ($this.val() == 'remove') {
                                        var confirm = window.confirm("Are you sure to remove selected products?");
                                        if (confirm == true) {
                                            txt = "You pressed OK!";

                                            var prod_list = [];
                                            var ids = jQuery.map($(':checkbox[name=singleCheck\\[\\]]:checked'), function (n, i) {
//                                            prod_list.push({id: n.value, product: $(n).closest('tr').find('.product-name').html()});
                                                prod_list.push(n.value);
                                            });
                                            var str = '<form method="post" action="<?= route('admin.products.bulkUpdate') ?>" id="removeForm">';
                                            str += '<input type="hidden" name="productId" value="' + prod_list + '"/>';
                                            str += '<input type="hidden" name="type" value="' + $this.val() + '"/>';
                                            str += '</form>';

                                            $('body').append(str);
                                            $('#removeForm').submit();
                                        }
                                    }
                                });

                                function get_update_form(prod_list, modal, action, action_val) {
                                $('#' + modal + ' .b-action').show();
                                    var str = '';
//                                    $.each(prod_list, function (key, val) {
//                                        str += '<tr>';
//                                        str += '<td>' + val.product + '</td>';
//                                        str += '<td>';
//                                        str += '<input type="hidden" name="product[' + val.product + '][id]" value="' + val.id + '"/>';
//                                        if (action_val == 'update_stock_status') {
//                                            str += '<select name="updated_value"><option value="1">In Stock</option><option value="0">Out of Stock</option></select>';
//                                        } else {
//                                            str += '<input type="number"  min="1" name="product[' + val.product + '][action]" /></td>';
//                                        }
//                                        str += '</tr>';
//                                    });
//                                       
                                    str += '<input type="hidden" name="productId" value="' + prod_list + '"/>';
                                    str += '<input type="hidden" name="type" value="' + action_val + '"/>';
                                    if (action_val == 'update_stock_status') {
                                        str += '<select name="updated_value"><option value="1">In Stock</option><option value="0">Out of Stock</option></select>';
                                        $('#' + modal + ' .b-action').html('Stock Status');
                                    }
                                    if (action_val == 'update_availability') {
                                        str += '<select name="updated_value"><option value="1">Yes</option><option value="0">No</option></select>';
                                        $('#' + modal + ' .b-action').html('Product Availability');
                                    }
                                    if (action_val == 'update_price') {
                                        str += '<input name="updated_value" />';
                                        $('#' + modal + ' .b-action').html('Price');
                                    }
                                    if (action_val == 'update_special_price') {
                                        str += '<input name="updated_value" />';
                                        $('#' + modal + ' .b-action').html('Special Price');
                                    }
                                    if (action_val == 'add_category') {

<?php
$roots = App\Models\Category::roots()->get();
echo "str += \"<ul id='catTree' class='tree icheck '>\";";
foreach ($roots as $root)
    renderNode($root);
echo "str += \"</ul>\";";

function renderNode($node) {
    echo "str += \"<li class='tree-item fl_left ps_relative_li " . ($node->parent_id == '' ? 'parent' : '') . "'>\";";
    echo 'str += \'<div class="checkbox"><label class="i-checks checks-sm"><input type="checkbox"  name="updated_value[]" value="' . $node->id . '" /> <i></i>' . $node->category . '</label></div>\';';
    if ($node->children()->count() > 0) {
        echo "str += \"<ul class='fl_left treemap'>\";";
        foreach ($node->children as $child)
            renderNode($child);
        echo "str += \"</ul>\";";
    }
    echo "str += \"</li>\";";
}
?>
                                        //str += '<input name="updated_value" />';
                                        $('#' + modal + ' .b-action').hide();
                                    }

                                    $('#' + modal + ' .product_loop').html(str);
                                    $('#' + modal + ' .modal-title').html(action);
//                                    if (action_val == 'update_stock_status') {
//                                        
//                                    }
                                }

                                $('.singleCheck').change(function () {
                                    $("#bulk_action").val('');
                                });

                                $("#print_all").click(function () {
                                    $("#myModalbarcode").modal("show");
                                    $("#myModalbarcode").css("display", "block");
                                    var ids = jQuery.map($(':checkbox[name=singleCheck\\[\\]]:checked'), function (n, i) {
                                        return n.value;
                                    }).join(',');
                                    get_print_form(ids);
                                });

                                $(".bprint").click(function () {
                                    $("#myModalbarcode").modal("show");
                                    $("#myModalbarcode").css("display", "block");
                                    var id = $(this).attr("data-id");
                                    get_print_form(id);
                                });





                                function get_print_form(id) {

                                    $.ajax({
                                        data: "id=" + id + "&pt=" + $("#page_type").val(),
                                        type: 'post',
                                        url: "{{ route('admin.products.printBarcode') }}",
                                        dataType: 'json',
                                        beforeSend: function () {
                                            $("#print_loop").text('Please wait');
                                            $("#barerr" + id).text('Please wait');
                                        },
                                        success: function (res) {
                                            $("#barerr" + res.id).text('');
                                            var str = '';
                                            $.each(res, function (index, val) {
                                                $("#barerr" + val.id).text('');
                                                str += '<tr>';
                                                str += '<td>' + val.product + '</td>';
                                                str += '<td>';
                                                //              str += '<input type="hidden" name="proId[]" value="' + val.id + '"/>';
                                                str += '<input type="hidden" name="product[' + val.product + '][id]" value="' + val.id + '"/>';
                                                str += '<input type="hidden" name="product[' + val.product + '][barcode]" value="' + val.barcode + '"/>';
                                                str += '<input type="number"  min="1" name="product[' + val.product + '][quantity]" /></td>';
                                                str += '</tr>';
                                            });
                                            $("#print_loop").html(str);
                                        }
                                    });
                                }

                                //////////////

                                $(".bulkuploadprod").click(function () {

                                    $(".template-download").hide();
                                    $("#bulkProduct").modal("show");

                                });


                                //    $(".sampleDownload").click(function(){
                                //        
                                //        $.ajax({
                                //            type:"POST",
                                //            url:"",
                                //            data:{},
                                //            cache:false,
                                //            success:function(){
                                //                
                                //                
                                //            }
                                //            
                                //        });
                                //        
                                //        
                                //    });


</script>
@stop


