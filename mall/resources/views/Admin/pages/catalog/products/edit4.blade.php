@extends('Admin.layouts.default')


<div class="row">
    <div class="col-sm-12">
        <section class="panel">
            {{ View::make('admin.includes.productHeader', array('id' => $prod->id, 'prod_type' => $prod->prod_type)) }}
            <div class="panel-body">
                <div class="col-md-12">
                    {{ Form::label('related_prods', 'Select Products in the Combo') }}
                    <div class="btn-group pull-right col-md-3">
                        {{ Form::open(['method' => 'get', 'url' => URL::route("updateComboProds",$prod->id) ]) }}
                        <input type="text" value="{{ !empty(Input::get('search')) ? Input::get('search') : '' }}" name="search" aria-controls="editable-sample" class="form-control medium" placeholder="Search Product"/>
                        {{ Form::close() }}
                    </div>
                </div>

                <div class="clearfix">&nbsp;</div>

                <div class="col-md-12">
                    {{ Form::model($prod,['method' => 'post', 'files' =>true , 'url' => $action , 'class' => 'bucket-form' ]) }}


                    <?php
                    $combo_prods = $prod->comboproducts->toArray();
                    ?>

                    <table class="table comboProds table-hover general-table table-bordered table-striped table-condensed">
                        <thead>
                            <tr>
                                <th>Select</th>
                                <th>Product</th>
                                <th>Short Description</th>
                                <th>Product Type</th>
                                <th>Categories</th>
                                <th>Availability</th>
                                <th>Stock</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($prods as $prd)

                            <tr>
                                <td><input type="checkbox" name="combo_prods[]" value="{{ $prd->id }}" {{ Helper::searchForKey("id",$prd->id,$combo_prods) ? "checked" : "" }} /></td>
                                <td>{{ $prd->product }}</td>
                                <td>{{ $prd->short_desc }}</td>
                                <td>
                                    <?php $prod_type = $prd->producttype->toArray(); ?>
                                    {{ $prod_type['type'] }}
                                </td>
                                <td>
                                    <ul>
                                        @foreach($prd->categories as $cat)
                                        <li>
                                            {{ Form::open(['method' => 'post', 'url' => URL::route("editCat") , 'class' => 'form-inline']) }}
                                            {{ Form::hidden('id',$cat->id) }}
                                            <a href="javascript:void();" class="edit"> {{ $cat->category  }}</a>
                                            {{ Form::close()}}
                                        </li>
                                        @endforeach  

                                    </ul>                                
                                </td>
                              
                                <td>{{ $prd->is_avail == 0 ? "Out of Stock" : "In Stock" }}</td>
                                <td>{{ $prd->stock }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ Form::hidden("id",$prod->id) }}
                    <div class="col-md-12 form-group">
                        {{ Form::submit('Submit',["class" => "btn btn-primary"]) }}
                    </div>
                    {{ Form::close() }}
                </div>
                <div class="pull-right">
                    <?php
                    $args = [];
                    !empty(Input::get("search")) ? $args["search"] = Input::get("search") : '';
                    !empty(Input::get("sort")) ? $args["sort"] = Input::get("sort") : '';
                    !empty(Input::get("order")) ? $args["order"] = Input::get("order") : '';
                    ?>
                    <?= $prods->appends($args)->links() ?>
                </div>

            </div>
        </section>
    </div>
</div>



@section('myscripts')

<script>
    $(document).ready(function() {


    });
</script>
@stop