@extends('Admin.layouts.default')
@section('content')


<section class="content-header">
    <h1>
        Home Page Slider

    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Home Page Slider</li>
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
                <div class="box-header box-tools filter-box col-md-9 noBorder">
                    <div class="form-group col-md-8 noBottomMargin">
                        <form action="{{ route("admin.sliders.view") }}" method="get" >
                            <input type="text" value="{{ !empty(Input::get('search')) ? Input::get('search') : '' }}" name="search" aria-controls="editable-sample" class="form-control medium" placeholder="Search"/>
                        </form> 
                    </div>  
                </div>
                <div class="box-header col-md-3">
                    <button id="editable-sample_new" class="btn btn-default pull-right col-md-12" onclick="window.location.href ='{{ route('admin.slider.add')}}'">Add New Slider</button>
                </div> 
                <div class="clearfix"></div>
                <div class="dividerhr"></div>
                <table class="table  table-hover general-table tableVaglignMiddle">
                    <thead>
                        <tr>
                            <th>Sr No</th>
                            <th>Title</th>
                            <th>Type</th>
                            <th>link</th>
                            <th>Image</th>
                            <th>Sort Order</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php $i=1; ?>
                        @foreach($allSiders as $slider)
                        <tr>
                            <td>{{ $i }}</td>
                            <td>{{ $slider->title}}</td>
                            <td>{{ $slider->type->slider}}</td>
                            <td>{{ $slider->link}}</td>
                            <td>{{ Html::image(Config('constants.sliderUploadPath').$slider->image,'', array('class' => 'thumbnail admin-profile-picture')) }}</td>
                            <td>{{ $slider->sort_order}}</td>
                            <td> @if($slider->is_active==1)
                                <a href="{!! route('admin.slider.changestatus',['id'=>$slider->id]) !!}" data-toggle="tooltip" title="Enabled" onclick="return confirm('Are you sure you want to disable this slider?')"><i class="fa fa-check btnNo-margn-padd"></i></a>
                                @elseif($slider->is_active==0)
                                <a href="{!! route('admin.slider.changestatus',['id'=>$slider->id]) !!}" data-toggle="tooltip" title="Disabled" onclick="return confirm('Are you sure you want to enable this slider?')"><i class="fa fa-times"></i></a>
                                @endif</td>
                            <td>

                                <a href="{!! route('admin.slider.edit',['id'=>$slider->id]) !!}" data-toggle="tooltip" title="Edit"   ><i class="fa fa-pencil-square-o btn btn-penel btnNo-margn-padd"></i></a>
                               
                                <a href="{!! route('admin.slider.delete',['id'=>$slider->id]) !!}" onclick="return confirm('Are you sure you want to delete this slider?')"  data-toggle="tooltip" title="Delete"  ><i class="fa fa-trash"></i></a>

                            </td>
                        </tr>
                        <?php $i++; ?>
                        @endforeach
                    </tbody>
                </table>
                <div class="pull-right">
                    <?php
                    $args = [];
                    !empty(Input::get("search")) ? $args["search"] = Input::get("search") : '';
                    !empty(Input::get("sort")) ? $args["sort"] = Input::get("sort") : '';
                    ?>
                    <?= $allSiders->appends($args)->links() ?>
                </div>
            </div>
        </div>
    </div>
</section>
@stop
@section('myscripts')
<script>
    $(document).ready(function () {
        $(".delete").click(function () {
            var r = confirm("Are You Sure You want to Delete this record?");
            if (r == true) {
                $(this).parent().submit();
            } else {

            }
        });

        $(".edit").click(function () {
            var r = confirm("Are You Sure You want to edit this?");
            if (r == true) {
                $(this).parent().submit();
            } else {

            }
        });
    });
</script>
@stop