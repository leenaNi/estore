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
@section('content')
<section class="content-header">
    <h1>
        Categories
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Categories</li>
    </ol>
</section>

<section class="main-content">
    <div class="notification-column">
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
    </div>
    <div class="grid-content">
        <div class="section-main-heading">
            <h1>Categories</h1>
        </div>
      <div class="filter-section">
            <div class="col-md-12 noAll-padding">
                <div class="filter-full-section">
                   
                    <div class="form-group col-md-6 noBottomMargin">
                        <div class="input-group-btn">
                            <input type="text" name="catSearch" class="form-control medium pull-right catSearcH" placeholder="Search Category">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid-content">
        <div class="section-main-heading">
            <h1>All Categories</h1>
        </div>
      <div class="listing-section">
            <div class="col-md-12 noAll-padding">
                <table class="table table-striped table-hover">
                        <?php
                            echo "<ul  id='catTree' class='tree icheck catTrEE'>";
                            foreach ($roots as $root) {
                                renderNode($root);
                            }

                            echo "</ul>";

                            function renderNode($node)
                            {
                                echo "<li class='tree-item fl_left ps_relative_li" . ($node->status == '0' ? 'text-muted' : '') . "'>";
                                echo '' . $node->categoryName->category . '';
                                echo '<a class="add-new-category" data-catId="' . $node->id . '" data-parentcatId="' . $node->parent_id . '" style="color:green;" data-toggle="tooltip" title="Add New"><i class="fa fa-plus fa-fw"></i></a>';
                                echo '' . '<a href="' . route("admin.category.edit", ["id" => $node->id]) . '" style="color:green;" class="addCat" data-toggle="tooltip" title="Edit"><b> <i class="fa fa-pencil fa-fw"></i> </b></a>' ?>
                                                        <!-- <a href="{{ route('admin.category.delete', ['id' => $node->id])}}" style="color:green;" onclick="return confirm('Are you sure  you want to delete this category?')" data-toggle="tooltip" title="Delete"><b><i class="fa fa-trash fa-fw"></i></b></a> -->


                                                        @if ($node->status == '0')
                                                            <a href="{{route('admin.category.changeStatus',['id'=> $node->id])}}" class="changCatStatus" onclick="return confirm('Are you sure you  want to enable this category?')" data-toggle="tooltip" title="Disabled"><b><i class="fa fa-times fa-fw"></i></b></a>
                                                        @endif
                                                        @if($node->status == '1')
                                                        <a href="{{route('admin.category.changeStatus',['id' => $node->id]) }}"  class="changCatStatus" onclick="return confirm('Are you sure you want to disable this category?')" data-toggle="tooltip" title="Enabled"><b><i class="fa fa-check fa-fw"></i></b></a>
                                                        @endif
                                                <?php if ($node->adminChildren()->count() > 0) {
                                    echo "<ul class='treemap fl_left'>";
                                    foreach ($node->adminChildren as $child) {
                                        renderNode($child);
                                    }

                                    // echo $child;
                                    echo "</ul>";
                                }

                                echo "</li>";
                            }
                        ?>
                </table>
                <div class="box-footer clearfix">

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

$('.add-new-category').click(function() {
    var catId = $(this).attr('data-catId');
    $('input[name="parent_id"]').val(catId);
    $('#new-category').modal('show');
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