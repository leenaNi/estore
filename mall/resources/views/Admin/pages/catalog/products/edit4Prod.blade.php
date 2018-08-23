@extends('Admin.layouts.default')
@section('content')


<section class="content-header">
    <h1>
        Products

    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Products</li>
        <li class="active">Add/Edit</li>
    </ol>
</section>


<div class="nav-tabs-custom"> 
    {!! view('Admin.includes.productHeader',['id' => $prod->id, 'prod_type' => $prod->prod_type]) !!}
    <div class="tab-content">
        <div class="tab-pan-active" id="activity">

            <div class="panel-body">
                {!! Form::model($prod, ['method' => 'post', 'files'=> true, 'url' => $action ,'id'=>'ComboProdID' ,'class' => 'form-horizontal' ]) !!}
                {!! Form::hidden("id",$prod->id) !!}
                <?php
                $combo_prods = $prod->comboproducts->toArray();
                ?>
                <div class="table-responsive">
                    <table class="table comboProds table-striped b-t b-light">
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
                                <td>
                                    <div class="checkbox">
                                        <label class="i-checks i-checks-sm">
                                            <input type="checkbox" name="combo_prods[]" value="{!! $prd['id'] !!}" {!! App\Library\Helper::searchForKey("id",$prd['id'],$combo_prods) ? "checked" : "" !!} />
                                                   <i></i>
                                        </label></div>
                                </td>
                                <td>{!! $prd['product'] !!}</td>
                                <td>{!! $prd['short_desc'] !!}</td>
                                <td>
                                    <?php //$prod_type = $prd->producttype->toArray(); ?>
                                    {!! $prd['prod_type'] !!}
                                </td>
                                <td>
                                    <ul>
                                     
                                        <li>
                                           <a href="{!! route('admin.category.edit',['id'=>App\Models\Product::find($prd['id'])->categories()->first()->id]) !!}" class="edit"> {!!App\Models\Product::find($prd['id'])->categories()->first()->category !!}</a>

                                        </li>
                                      

                                    </ul>                                
                                </td>

                                <td>{!! $prd['is_avail'] == 0 ? "Out of Stock" : "In Stock" !!}</td>
                                <td>{!! $prd['stock'] !!}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>


                {!! Form::hidden('return_url',null,['class'=>'rtUrl']) !!}




                <footer class="panel-footer">
                    <div class="row">
                        <div class="col-sm-4 text-right text-center-xs pull-right">                
                            <?= $prods->render() ?>           
                        </div>
                    </div>
                </footer>

                <div class="form-group col-sm-12 ">
                    {!! Form::button('Save & Exit',["class" => "btn btn-primary pull-right saveComboExit"]) !!}
                    {!! Form::button('Save & Continue',["class" => "btn btn-primary pull-right saveComboContine"]) !!}
                    {!! Form::submit('Save & Next',["class" => "btn btn-primary pull-right"]) !!}
                </div>

            </div>



            {!! Form::close() !!}   



        </div>
    </div>
</div>

@stop 

@section('myscripts')

<script>


    $(".saveComboExit").click(function() {
        $(".rtUrl").val("{!! route('admin.products.view')!!}");
        $("#ComboProdID").submit();

    });

    $(".saveComboContine").click(function() {

        $(".rtUrl").val("{!! route('admin.combo.products.view',['id'=>$prod->id])!!}");

       // $(".rtUrl").val("{!! route('admin.combo.products.view')!!}");
        $("#ComboProdID").submit();

    });


    $(".comboProds input[type='checkbox']").click(function() {

        if ($(this).prop("checked")) {
            sync("{{ $prod->id }}", $(this).val(), "{{ URL::route('admin.products.update.combo.attach') }}");
        } else {
            sync("{{ $prod->id }}", $(this).val(), "{{ URL::route('admin.products.update.combo.detach') }}");
        }
    });

    function sync(id, prod_id, action) {
        $("input[type='submit']").prop("diabled", true);
        $.ajax({
            url: action,
            type: "POST",
            data: {id: id, prod_id: prod_id},
            sucess: function(data) {
                console.log(data);
                $("input[type='submit']").prop("diabled", false);
            }
        });
    }


</script>
@stop