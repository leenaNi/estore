@extends('Admin.Layouts.default')
@section('contents')


<section class="content-header">
    <h1>
        Master Categories
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ route('admin.category.view') }}"><i class="fa fa-coffee"></i> Category</a></li>
        <li class="active">Add/Edit</li>
    </ol>
</section>
<section class='content'>
    <?php
//print_r($category);
?>
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs" role="tablist">
            @if(!empty($category))
            <li class="{{ in_array(Route::currentRouteName(),['admin.masters.category.addEdit']) ? 'active' : '' }}"><a href="{!! route('admin.masters.category.addEdit',['id'=>Input::get('id')]) !!}"  aria-expanded="false">Category Add/Edit</a></li>
            @endif
            <li class="{{ in_array(Route::currentRouteName(),['admin.masters.matsterCategories']) ? 'active' : '' }}"><a href="{!! route('admin.masters.matsterCategories',['id'=>Input::get('id')]) !!}"  aria-expanded="false">Assign Categories</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pan-active" id="activity">
                <div>
                    <p style="color: red;text-align: center;">{{ Session::get('messege') }}</p>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-10">
                        <div class="form-group col-sm-12">
                        {!! Form::text('cat_search',null, ["class"=>'form-control' ,"placeholder"=>'Search Category']) !!}
                    </div></div>
                        <div class="col-md-2 text-right">
                            {!! Form::open(['route'=>'admin.category.add','method'=>'get']) !!}
                            {!! Form::submit('Add New Category',['class'=>'btn btn-info']) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>

                    {!! Form::model($category, ['method' => 'post', 'files'=> true, 'url' => $action , 'id'=>'catSeoF' ]) !!}
                    {!! Form::hidden('id',null) !!}
                    <div class="row">
                        <div class="col-md-12 form-group">
                            <?php
$assignedCategories = ($category->assigned_categories) ? json_decode($category->assigned_categories) : [];
$roots = App\Models\CategoryMaster::roots()->get();
echo "<ul id='catTree' class='tree icheck'>";
foreach ($roots as $root) {
    renderNode($root, $category, $assignedCategories);
}

echo "</ul>";
function renderNode($node, $category, $assignedCategories)
{
    $classStyle = (in_array($node->id, $assignedCategories) ? 'checkbox-highlight' : '');
    echo "<li class='tree-item fl_left ps_relative_li " . ($node->parent_id == '' ? 'parent' : '') . "'>";
    echo '<div class="checkbox">
                                        <label class="i-checks checks-sm text-left ' . $classStyle . '"><input type="checkbox"  name="category_id[]" value="' . $node->id . '" ' . (in_array($node->id, $assignedCategories) ? "checked" : "") . '' . (Input::get("parent_id") == $node->id ? "checked" : "") . '/><i></i>' . $node->category . '</label>
                                        </div>';
    if ($node->children()->count() > 0) {
        echo "<ul class='treemap fl_left'>";
        foreach ($node->children as $child) {
            renderNode($child, $category, $assignedCategories);
        }

        echo "</ul>";
    }
    echo "</li>";
}
?>
                    </div>
                    </div>
                    <div class="form-group">
                        {!! Form::hidden('return_url',null,['class'=>'rtUrl']) !!}
                        <div class="form-group col-sm-12 ">
                            {!! Form::button('Save & Exit',["class" => "btn btn-primary pull-right saveCatSeoExit"]) !!}
                            {!! Form::button('Save & Continue',["class" => "btn btn-primary pull-right saveCatSeoContine"]) !!}

                        </div>
                        <div class="col-sm-4 col-sm-offset-2">
                            {!! Form::close() !!}
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
    $(".AddMoreImg").click(function () {
        $(".existingDiv").append($(".toClone").html());
    });
    $.extend($.expr[":"], {
        "containsInsensitive": function (elem, i, match, array) {
            return (elem.textContent || elem.innerText || "").toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
        }
    });
    $("li:contains('Brand Name')").hide();
    $("li:contains('Brand Make')").hide();
    $("li:contains('Premiumness')").hide();
    $("[name='cat_search']").keyup(function () {
       console.log($(this).val());
        //  alert("sdfsf");
        $(".parent").hide();
        $(".parent:containsInsensitive('" + $(this).val() + "')").show();
        $("li:contains('Brand Name')").hide();
        $("li:contains('Brand Make')").hide();
        $("li:contains('Premiumness')").hide();
    });
    $("body").on("click", ".delImgDiv", function () {
        //   alert("sdfsdf");
        $(this).parent().parent().parent().remove();
    });
    $(".saveCatSeoExit").click(function () {
        $(".rtUrl").val("{!!route('admin.masters.category.view')!!}");
        $("#catSeoF").submit();

    });
    $(".saveCatSeoContine").click(function () {
        $(".rtUrl").val("{!!route('admin.masters.matsterCategories',['id'=>Input::get('id')])!!}");
        $("#catSeoF").submit();
    });

    $(".saveCatSeoNext").click(function () {
        $(".rtUrl").val("{!!route('admin.masters.category.view')!!}");
        $("#catSeoF").submit();
    });
</script>
@stop