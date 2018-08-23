@extends('Admin.layouts.default')

@section('content')
<style type="text/css">
    input[type=checkbox]{display:none;}
</style>
<section class="content-header">
    <div class="flash-message"><b>{{ Session::get("ProductCode") }} {{ Session::get("errorMessage") }}</b></div>
    <h1>
        Products
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Products</li>
        <li class="active">Add/Edit</li>
    </ol>
</section>

<section class='content'>
    <div class="nav-tabs-custom"> 
        {!! view('Admin.includes.productHeader',['id' => $prod->id, 'prod_type' => $prod->prod_type]) !!}
        <div class="tab-content">
            <div class="tab-pan-active" id="activity">
                <div class="panel-body">
                    <div class="form-group col-sm-12">
                        {!! Form::text('cat_search',null, ["class"=>'form-control' ,"placeholder"=>'Search Category']) !!}
                    </div>
                    {!! Form::model($prod, ['method' => 'post', 'files'=> true, 'url' => $action ,'id'=>'EditCategory' ,'class' => 'form-horizontal' ]) !!}
                    {!! Form::hidden('id',null) !!}
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="col-sm-3 pull-right">           
                        <a href="{!! route('admin.category.add') !!}?new_prod_cat={!! $prod->id !!}" class="btn btn-default pull-right" target="_" type="button">Add New Category</a>      
                    </div>
                    <div class="col-sm-10">
                        {!! Form::label('category_id', 'Select Product Category') !!}
                        <?php
                        $prodCats = $prod->categories->toArray();
                        $roots = App\Models\Category::roots()->get();
                        echo "<ul id='catTree' class='tree icheck '>";
                        foreach ($roots as $root)
                            renderNode($root, $prodCats);
                        echo "</ul>";

                        function renderNode($node, $prodCats) {
                            echo "<li class='tree-item fl_left ps_relative_li " . ($node->parent_id == '' ? 'parent' : '') . "'>";
                            $style=(App\Library\Helper::searchForKey("id", $node->id, $prodCats) ? 'checkbox-highlight' : '');
                            echo '<div class="checkbox">
                                <label class='.$style.' class="i-checks checks-sm"><input type="checkbox"  name="category_id[]" value="' . $node->id . '"  ' . (App\Library\Helper::searchForKey("id", $node->id, $prodCats) ? 'checked' : '') . '  /> <i></i>' . $node->category . '</label>
                              </div>';
                            if ($node->adminChildren()->count() > 0) {
                                echo "<ul class='fl_left treemap'>";
                                foreach ($node->adminChildren as $child)
                                    renderNode($child, $prodCats);
                                echo "</ul>";
                            }
                            echo "</li>";
                        }
                        ?>
                    </div>
                    {!! Form::hidden('return_url',null,['class'=>'rtUrl']) !!}
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group col-sm-12 ">
                        {!! Form::button('Save & Exit',["class" => "btn btn-primary pull-right saveCatExit"]) !!}
                        {!! Form::button('Save & Continue',["class" => "btn btn-primary pull-right saveCatContinue"]) !!}
                        {!! Form::submit('Save & Next',["class" => "btn btn-primary pull-right"]) !!}
                    </div>
                    {!! Form::close() !!}     
                </div>
            </div>
        </div>
    </div>
</section>
@stop
@section('myscripts')
<script>
    $.extend($.expr[":"], {
        "containsInsensitive": function (elem, i, match, array) {
            return (elem.textContent || elem.innerText || "").toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
        }
    });
    $("li:contains('Brand Name')").hide();
    $("li:contains('Brand Make')").hide();
    $("li:contains('Premiumness')").hide();
    $("[name='cat_search']").keyup(function () {
        //  alert("sdfsf");
        $(".parent").hide();
        $(".parent:containsInsensitive('" + $(this).val() + "')").show();
        $("li:contains('Brand Name')").hide();
        $("li:contains('Brand Make')").hide();
        $("li:contains('Premiumness')").hide();
    });
    $(".saveCatContinue").click(function () {
        $(".rtUrl").val("{!!route('admin.products.edit.category',['id'=>Input::get('id')])!!}");
        $("#EditCategory").submit();
    });

    $(".saveCatExit").click(function () {
        $(".rtUrl").val("{!!route('admin.products.view')!!}");
        $("#EditCategory").submit();
    });
</script>
@stop