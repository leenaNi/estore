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

.tree li{margin: 10px 0px;}

</style>

<!--<link rel="stylesheet" href="{{asset(Config('constants.fileUploadPluginPath').'css/style.css')}}">-->
<link rel="stylesheet" href="{{Config('constants.fileUploadPluginPath').'css/jquery.fileupload.css'}}">

<link rel="stylesheet" href="{{Config('constants.fileUploadPluginPath').'css/jquery.fileupload-ui.css'}}">

<noscript><link rel="stylesheet" href="{{Config('constants.fileUploadPluginPath').'css/jquery.fileupload-noscript.css'}}"></noscript>
<noscript><link rel="stylesheet" href="{{Config('constants.fileUploadPluginPath').'css/jquery.fileupload-ui-noscript.css'}}"></noscript> 

@stop
@section('contents')
<section class="content-header">
    <h1>
        Categories
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Categories</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                @if(!empty(Session::get('message')))
                <div  class="alert alert-danger" role="alert">
                    {{ Session::get('message') }}
                </div>
                @endif
                @if(!empty(Session::get('msg')))
                <div  class="alert alert-success" role="alert">
                    {{ Session::get('msg') }}
                </div>
                @endif
                <div class="box-header box-tools filter-box col-md-9 noBorder">
                <div class="form-group col-md-6 noBottomMargin">
                    <div class="input-group-btn">
                        <input type="text" name="catSearch" class="form-control medium pull-right catSearcH" placeholder="Search Category">
                    </div>
                </div>
                </div>
                <div class="box-header col-md-3 col-sm-12 col-xs-12">
                    <a href="{!! route('admin.category.add') !!}" class="btn btn-success pull-right col-md-12" type="button">Add New Category</a>
                </div>
                <!--  <div class="box-header col-md-3">
                    <button class="btn btn-default pull-right col-md-12 bulkuploadprod" type="button" >Bulk Upload</button>
                </div>-->
                <div class="clearfix"></div>
                <div class="dividerhr"></div>
                <div class="box-body no-padding">
                    <table class="table table-striped table-hover">
                        <?php
                        echo "<ul  id='catTree' class='tree icheck catTrEE'>";
                        foreach ($roots as $root)
                            renderNode($root);
                        echo "</ul>";

                        function renderNode($node) {
                            echo "<li class='tree-item fl_left ps_relative_li" . ($node->status == '0' ? 'text-muted' : '') . "'>";
                            if($node->adminChildren()->count() > 0){
                            echo '<b>' . $node->category . '</b><a href="' . route("admin.category.add", ["parent_id" => $node->id]) . '" style="color:green;" data-toggle="tooltip" title="Add New"><i class="fa fa-plus fa-fw"></i></a>';
                            } else {
                            echo '' . $node->category . '<a href="' . route("admin.category.add", ["parent_id" => $node->id]) . '" style="color:green;" data-toggle="tooltip" title="Add New"><i class="fa fa-plus fa-fw"></i></a>';
                            }
                            echo '<a href="' . route("admin.category.edit", ["id" => $node->id]) . '" style="color:green;" class="addCat" data-toggle="tooltip" title="Edit"><b> <i class="fa fa-pencil fa-fw"></i> </b></a>'  ?>
                            <a href="{{ route('admin.category.delete', ['id' => $node->id])}}" style="color:green;" onclick="return confirm('Are you sure  you want to delete this category?')" data-toggle="tooltip" title="Delete"><b><i class="fa fa-trash fa-fw"></i></b></a>
                            @if ($node->status == '0')  
                                <a href="{{route('admin.category.changeStatus',['id'=> $node->id])}}" style="color:grey;" class="changCatStatus" onclick="return confirm('Are you sure, you want to enable this category?')" data-toggle="tooltip" title="Disabled"><b><i class="fa fa-times fa-fw"></i></b></a>
                            @endif
                            @if($node->status == '1')
                              <a href="{{route('admin.category.changeStatus',['id' => $node->id]) }}" style="color:green;" class="changCatStatus" onclick="return confirm('Are you sure, you want to disable this category?')" data-toggle="tooltip" title="Enabled"><b><i class="fa fa-check fa-fw"></i></b></a>
                            @endif
                            <?php   
                                if ($node->adminChildren()->count() > 0) {
                                        echo "<ul class='treemap fl_left'>";
                                        foreach ($node->adminChildren as $child)
                                            renderNode($child);
                                        // echo $child;
                                        echo "</ul>";
                                    }
                                    echo "</li>";
                                }
                            ?> 

                    </table>
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">

                </div>
            </div><!-- /.box -->
        </div><!-- /.col -->

    </div>
    <div class="modal fade" id="bulkCategory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Bulk Upload/Download</h4>
                </div>
                <div class="modal-body">
<!--                    <div  class="bxmodal">
                        <div class='col-md-6'>
                            <label>Category Sample Download</label>
                        </div>
                        <div class='col-md-6'>
                            <a href="{{ route('admin.category.sampleCategoryDownload')}}" class="btn btn-primary sampleDownload">Download</a>
                        </div>
                    </div>-->
                    <div  class="bxmodal">
                        <div class='col-md-6'>
                            <label>Category Download</label>
                        </div>
                        <div class='col-md-6'>
                            <a href="{{ route('admin.category.sampleBulkDownload')}}" class="btn btn-primary sampleDownload">Download</a>
                        </div>
                    </div>
                    <div  class="bxmodal">
                        <form action="{{ route('admin.category.categoryBulkUpload') }}" method="post" enctype="multipart/form-data">
                            <div class='col-md-6'>
                                <label>Category Upload</label>
                                <input type="file" name="file" class="fileUploder" onChange="validateFile(this.value)"/> 
                            </div>
                            <div class='col-md-6'>
                                <input type="submit" class="btn btn-primary" value="Upload" >
                            </div>
                        </form>
                    </div>
                    <div  class="bxmodal">

                        <form id="fileupload" action="{{ asset(route('admin.category.catBulkImgUpload')) }}" method="POST" enctype="multipart/form-data">
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
</section>
@stop
@section('myscripts')
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
<script src="{{Config('constants.fileUploadPluginPath').'js/vendor/jquery.ui.widget.js'}}"></script>
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
<script src="{{Config('constants.fileUploadPluginPath').'js/jquery.iframe-transport.js'}}"></script>
<!-- The basic File Upload plugin -->
<script src="{{Config('constants.fileUploadPluginPath').'js/jquery.fileupload.js'}}"></script>
<!-- The File Upload processing plugin -->
<script src="{{Config('constants.fileUploadPluginPath').'js/jquery.fileupload-process.js'}}"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="{{Config('constants.fileUploadPluginPath').'js/jquery.fileupload-image.js'}}"></script>
<!-- The File Upload audio preview plugin -->
<script src="{{Config('constants.fileUploadPluginPath').'js/jquery.fileupload-audio.js'}}"></script>
<!-- The File Upload video preview plugin -->
<script src="{{Config('constants.fileUploadPluginPath').'js/jquery.fileupload-video.js'}}"></script>
<!-- The File Upload validation plugin -->
<script src="{{Config('constants.fileUploadPluginPath').'js/jquery.fileupload-validate.js'}}"></script>
<!-- The File Upload user interface plugin -->
<script src="{{Config('constants.fileUploadPluginPath').'js/jquery.fileupload-ui.js'}}"></script>
<!-- The main application script -->
<script src="{{Config('constants.fileUploadPluginPath').'js/main.js'}}"></script>
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
$(".bulkuploadprod").click(function () {
    $(".template-download").hide();
    $("#bulkCategory").modal("show");
});

$(".catSearcH").keyup(function () {
    searchString = $(this).val();

    $(".catTrEE").find("li").each(function () {
        str = $(this).text();

        if (str.toLowerCase().indexOf(searchString) >= 0) {
            $(this).show();
        } else {
            $(this).hide();
        }

    });
});

$(".delCat").click(function () {
    var nid = $(this).attr('data-nid');
alert("hhh")
    var chkdel = confirm('Are you sure want to delete this categoy?');
    if (chkdel === true)
    {
        $.ajax({
            type: "POST",
            url: "{{route('admin.category.delete')}}",
            data: {id: nid},
            cache: false,
            success: function (data) {
                // window.location.assign("{{route('admin.category.view')}}");
            }
        });
    }

});

</script>

@stop