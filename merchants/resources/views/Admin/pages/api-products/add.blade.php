@extends('Admin.layouts.default')
@section('content')
<section class="content-header">
    <h1> Add New Product </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"> Add New Product </li>
        <li class="active"> Add/Edit</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    {!! Form::model($prod, ['method' => 'post', 'files'=> true, 'url' => $action , 'class' => 'form-horizontal' ]) !!}
                    {!! Form::hidden('id',null) !!}
                    {!! Form::hidden('is_individual','1')  !!}
                    {!! Form::hidden('is_avail', '1') !!}
                    {!! Form::hidden('added_by', Session::get('loggedinAdminId')) !!}
                    {!! Form::hidden('updated_by', Session::get('loggedinAdminId')) !!}
                    <div class="box-header with-border noBorder bottomBorder">
                        <h3 class="box-title">General Details</h3>
                    </div><br>
                    <div class="form-group">
                        {!! Form::label('Product Name', 'Product Name ',['class'=>'col-sm-2 control-label']) !!}<span class="red-astrik"> *</span>
                        <div class="col-sm-10">
                            {!! Form::text('product',null, ["class"=>'form-control' ,"placeholder"=>'Product Name', "required"]) !!}
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        {!! Form::label('Purchase Price', 'Product Price ',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('purchase_price',null, ["class"=>'form-control' ,"placeholder"=>'Purchase Price']) !!}
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        {!! Form::label('MRP', 'MRP',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('price',null, ["class"=>'form-control',"required" ,"placeholder"=>'MRP (Incl. of all Taxes)']) !!}
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        {!! Form::label('Selling Price', 'Selling Price ',['class'=>'col-sm-2 control-label']) !!}<span class="red-astrik"> *</span>
                        <div class="col-sm-10">
                            {!! Form::text('selling_price',null, ["class"=>'form-control' ,"placeholder"=>'Selling Price (Incl. of all Taxes)', "required"]) !!}
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        {!! Form::label('Quantity', 'Quantity',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::number('stock',null, ["class"=>'form-control' ,"placeholder"=>'Enter Quantity',"required"]) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('Bar Code', 'Bar Code',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-10">
                            {!! Form::text('barcode',null, ["class"=>'form-control' ,"placeholder"=>'Enter barcode']) !!}
                        </div>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="box-header with-border noBorder bottomBorder">
                        <h3 class="box-title">Category Details</h3>
                    </div>
                    <br>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="col-sm-2"><label class="control-label">Select Categories </label></div>
                    <div class="col-sm-10">
                        <?php
                        $prodCats = $prod->categories->toArray();
                        echo "<ul  id='catTree' class='tree icheck catTrEE'>";
                        foreach ($categories as $categoriesval) {
                            echo "<li><input type='checkbox' name='category_id[]' id='" . $categoriesval->id . "' value='" . $categoriesval->id . "' " . (App\Library\Helper::searchForKey("id", $categoriesval->id, $prodCats) ? 'checked' : '') . ">" . $categoriesval->category . "";
                            foreach ($categoriesval->children as $childval) {
                                echo "<ul  id='catTree' class='tree icheck catTrEE'>";
                                echo "<li><input type='checkbox' name='category_id[]' id='" . $childval->id . "' value='" . $childval->id . "'" . (App\Library\Helper::searchForKey("id", $childval->id, $prodCats) ? 'checked' : '') . " >  " . $childval->category .
                                "</li></ul>";
                            }
                            echo "</li>";
                        }
                        echo "</ul>";
                        ?>
                    </div>
                    <div class="line line-dashed b-b line-lg pull-in"></div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            {!! Form::submit('Submit',["class" => "btn btn-primary pull-right"]) !!}
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
    $(document).ready(function () {
    });
</script>
@stop