@extends('Admin.layouts.default')
@section('mystyles')


@stop
@section('content')
<section class="content-header">
    <h1>
        Categories
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Categories</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                @if(!empty(Session::get('message')))
                <div  class="alert alert-danger" role="alert">
                    {{ Session::get('messege') }}
                </div>
                @endif
                <div class="box-header box-tools filter-box col-md-9 noBorder">
                    <div class="form-group col-md-4 noBottomMargin">
                        <div class="input-group-btn">
                            <input type="text" name="catSearch" class="form-control medium pull-right catSearcH" placeholder="Search Category">
                        </div>
                    </div>   

                </div>
                <div class="box-header col-md-3">
                    <a href="{!! route('admin.apicat.add') !!}" class="btn btn-default pull-right col-md-12" type="button">Add New Category</a>
                </div>
                <div class="clearfix"></div>
                <div class="dividerhr"></div>
                <div class="box-body table-responsive no-padding">
                    <table class="table table-striped table-hover">

                        <?php
                        echo "<ul  id='catTree' class='tree icheck catTrEE'>";
                        foreach ($categories as $categoriesval) {
                            echo "<li><input type='checkbox' name='parent_id' id='" . $categoriesval->id . "' value='" . $categoriesval->id . "'> " . $categoriesval->category . "";
                            foreach($categoriesval->children as $childval){
                                echo "<ul  id='catTree' class='tree icheck catTrEE'>";
                                echo "<li><input type='checkbox' name='parent_id' id='" . $childval->id . "' value='" . $childval->id . "'> " . $childval->category . ""
                                .'<a href="'.route("admin.apicat.add", ["parent_id" => $childval->id]) . '" data-toggle="tooltip" title="Add New"><i class="fa fa-plus fa-fw"></i></a>'
                                . '<a href="' . route("admin.apicat.edit", ["id" => $childval->id]) . '" class="addCat" data-toggle="tooltip" title="Edit"><b> <i class="fa fa-pencil fa-fw"></i> </b></a>'
                                . '<a href="' . route("admin.apicat.delete", ["id" => $childval->id]) . '" data-nid="' . $categoriesval->id . '" class="delCat" onclick="return confirm("Are you sure you want to delete this category?")" data-toggle="tooltip" title="Delete"><b><i class="fa fa-trash fa-fw"></i></b></a></li>'
                                . '</ul>';

                            }
                            echo "</li>";
                        }
                        echo "</ul>";
                        ?> 

                    </table>
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">

                </div>
            </div><!-- /.box -->
        </div><!-- /.col -->

    </div>

</section>
@stop
@section('myscripts')
<!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->

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
    //alert('gdfgdfg');


    var nid = $(this).attr('data-nid');

    var chkdel = confirm('Are you sure want to delete this categoy?');
    if (chkdel === true)
    {
        $.ajax({
            type: "POST",
            url: "{{route('admin.apicat.delete')}}",
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