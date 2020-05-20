@extends('Admin.layouts.default')
@section('content')
<style>
.bxmodal{margin: 10px 0; border: 1px #eee solid; float: left; width: 100%; padding: 15px;}
.tree li{margin: 10px 0px;}
</style>
<section class="content-header">
    <h1>
    Manage Categories
        <!-- <small>Add/Edit</small> -->
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class=""><a href="{{route('admin.category.view')}} " >Manage Categories </a></li>
        <li class="active">Add/Edit</li>
    </ol>
</section>
<section class='content'>
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
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" role="tablist">
            <li class="{{ in_array(Route::currentRouteName(),['admin.category.view']) ? 'active' : '' }}"><a href="{!! route('admin.category.view') !!}"  aria-expanded="false">Store Category</a></li>
           
            <li class="{{ in_array(Route::currentRouteName(),['admin.category.viewMasterCat']) ? 'active' : '' }}"><a href="{!! route('admin.category.viewMasterCat') !!}"      aria-expanded="false">Master Category</a></li>
            
        </ul>

        <div class="tab-content">
            <div class="tab-pan-active" id="activity">
                <div>
                    <p style="color: red;text-align: center;">{{ Session::get('messege') }} </p>
                </div>
                <div class="panel-body">
                <div class="section-main-heading">
            <h1><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'receipt-2.svg'}}"> All Categories</h1>
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
    if(!env('IS_INDIVIDUAL_STORE')){
        echo '<a class="add-new-category" data-catId="' . $node->id . '" data-parentcatId="' . $node->parent_id . '" style="color:green;" data-toggle="tooltip" title="Add New"><i class="fa fa-plus fa-fw"></i></a>';
    }else{
        echo '<a href="' . route("admin.category.add", ["parent_id" => $node->parent_id]) . '" style="color:green;" style="color:green;" data-toggle="tooltip" title="Add New"><i class="fa fa-plus fa-fw"></i></a>';
    }
    
    echo '' . '<a href="' . route("admin.category.edit", ["id" => $node->id]) . '" style="color:green;" class="addCat" data-toggle="tooltip" title="Edit"><b> <i class="fa fa-pencil fa-fw"></i> </b></a>' ?>
                            
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
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">

                </div>
            </div><!-- /.box -->
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="new-category" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">Request for new category</h4>
                </div>
                <div class="modal-body">
                    <form action="{{route('admin.category.newCategory')}}" method="post">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input class="form-control" name="category" style="border:1px solid #ddd !important" required />
                                    <input type="hidden" class="form-control" name="parent_id" required />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <button class="btn btn-primary" type="submit" >Submit</button>
                            </div>
                        </div>
                    </form>
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
<?php $public_path = Config('constant.sizeChartImgPath');?>
@section('myscripts')

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