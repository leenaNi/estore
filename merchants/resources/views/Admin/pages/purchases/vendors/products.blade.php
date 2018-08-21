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
                <div class="box-header box-tools filter-box col-md-9 noBorder rightBorder">
                    {!! Form::open(['method' => 'get', 'route' => 'admin.vendors.product' , 'id' => 'searchForm' ]) !!}
                    {!! Form::hidden('productsCatalog',null) !!}
                       {!! Form::hidden('prdSearch',1) !!}
                    <div class="form-group col-md-4">
                        {!! Form::text('product_name',Input::get('product_name'), ["class"=>'form-control', "placeholder"=>"Product"]) !!}
                    </div>
                    
                  
                    <div class="form-group col-md-4">
                 <select class='form-control' name='category' class="form-control" placeholder="Product Category">
                            <option value="">Product Category</option>
                            <?php
                            $dash = " -- ";
                            echo "<ul>";
                            foreach ($rootsS as $root)
                                renderNode1($root, $dash);
                            echo "</ul>";

                            function renderNode1($node, $dash) {
                                echo "<li>";
                                echo "<option value='{$node->id}'   > {$dash}{$node->category}</option>";
                                if ($node->children()->count() > 0) {
                                    $dash .= " -- ";
                                    echo "<ul>";
                                    foreach ($node->children as $child)
                                        renderNode1($child, $dash);
                                    echo "</ul>";
                                }
                                echo "</li>";
                            }
                            ?>
                        </select>
                    </div>
                   
                    <div class="form-group col-md-4 noBottomMargin">
                        <div class=" button-filter-search col-md-6 no-padding">
                            <button type="submit" name="search" class="btn sbtn btn-primary form-control" style="margin-left: 0px;" value="Search"> Filter</button>
                        </div>
                        <div class="btn-group button-filter col-md-5 noBottomMargin no-padding">
                            <a href="{{route('admin.vendors.product')}}"><button type="button" class="btn sbtn btn-block reset-btn" value="reset">Reset</button></a>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
               
                <div class="box-header col-md-3">
                    <select id="bulk_action" class="dropdown-toggle form-control" type="button">
                        <option value="">Bulk Action</option>
                        <option value="1">Enable</option>
                        <option value="0">Disable </option>
                    </select>
                </div>

                <div class="clearfix"></div>
                <div class="dividerhr"></div>
                 <div class="form-group col-md-4 ">
                        <div class="button-filter-search pl0">
                    {{$productCount }} Product{{$productCount > 1 ?'s':'' }}
                </div>
              </div>
                   <div style="clear: both"></div>
                <div class="box-body table-responsive no-padding">
                    <table class="table table-striped table-hover tableVaglignMiddle">
                        <thead>
                            <tr>   <th><input type="checkbox" id="masterCheck" value="00"/></th> 
                                <th>@sortablelink ('product', 'Product')</th>
                                <th>Categories</th>
                                <th>@sortablelink ('price', 'Price')</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(count($products) >0 )
                            @foreach($products as $product)
                            
                            <tr>  <td>
                            <input type="checkbox" class="singleCheck" name="singleCheck[]" value="{{ $product->id }}"/></td>  
                                <td>
                                <div class="product-name vMiddle">
                                    <span>
                                    <img src="{{@$product->prodImage ? $product->prodImage : asset('public/Admin/dist/img/no-image.jpg') }}" class="admin-profile-picture" />
                                    </span>
                                    <span class="marginleft10">
                                    {{$product->product->product }}<br> 
                                       <span class="breakLine"> 
                                       @if($product->product->product_code)
                                       ({{ $product->product->product_code }})
                                        @endif
                                       </span>    
                                   </span>                       
                                </div>
                                </td>
                                <td>
                                    <?php
                                 if($product->product->categories()->get()->count() > 0){
                                echo $product->product->categories()->orderBy('created_at','desc')->first()->category;
                                }else{
                                    echo '-';
                                }
             
                                    
                                ?>
                        </td>
                        <td>
                        
                        @if( $product->product->spl_price <= 0 )
                        <i class="fa fa-rupee"></i>  {{ $product->product->price }}
                        @else
                        <strike>
                        <i class="fa fa-rupee"></i>
                        {{$product->product->price }} </strike><br><i class="fa fa-rupee"></i> {{ $product->product->spl_price }} 
                        @endif
                        </td>
                        
                        <td> {{ $product->status == 1 ? 'Enabled':'Disabled'}}</td>
                        <td>
                             @if($product->status==1)
                            <a href="{!! route('admin.vendors.productStatus',['id'=>$product->id]) !!}" class="" ui-toggle-class="" onclick="return confirm('Are you sure you want to disable this product?')" data-toggle="tooltip" title="Enabled"><i class="fa fa-check btn-plen btn"></i></a>
                            @elseif($product->status==0)
                            <a href="{!! route('admin.vendors.productStatus',['id'=> $product->id]) !!}" class="" ui-toggle-class="" onclick="return confirm('Are you sure you want to enable this product?')" data-toggle="tooltip" title="Disabled"><i class="fa fa-times btn-plen btn"></i></a>
                            @endif
                        </td> 
                        </tr>
                        @endforeach
                         @else
                            <tr><td colspan=10> No Record Found</td></tr>
                         @endif
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">

                    <?php
                    $args = [];
                    !empty(Input::get("product_name")) ? $args["product_name"] = Input::get("product_name") : '';

                    !empty(Input::get("product_code")) ? $args["product_code"] = Input::get("product_code") : '';
                    //echo $products->appends(Input::except('page'))->render();
                    
                    if (empty(Input::get('prdSearch'))) {
                      // echo $products->render();
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
<!-- <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
 --><!-- blueimp Gallery script -->
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
  $(document).ready(function () {
    $(".fromDate").datepicker({
            dateFormat: "yy-mm-dd",
            onSelect: function (selected) {
                $(".toDate").datepicker("option", "minDate", selected);
            }
        });

        $(".toDate").datepicker({
            dateFormat: "yy-mm-dd",
            onSelect: function (selected) {
                $(".fromDate").datepicker("option", "maxDate", selected);
            }
        });
    });
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
                                    var val = $this.val();
                                    var ids = jQuery.map($(':checkbox[name=singleCheck\\[\\]]:checked'), function (n, i) {
                                            return n.value;
                                        }).join(',');
                                    $.ajax({
                                        method:"POST",
                                        data:{'val':val,'ids':ids },
                                        url:"{{ route('admin.vendors.productBulkAction') }}",
                                        success: function(data){
                                                 location.reload();
                                                }
                                            });
                                });

                                function get_update_form(prod_list, modal, action, action_val) {
                                    $('#' + modal + ' .b-action').show();
                                    var str = '';                                    
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


                                $(".bulkuploadprod").click(function () {

                                    $(".template-download").hide();
                                    $("#bulkProduct").modal("show");

                                });

</script>
@stop