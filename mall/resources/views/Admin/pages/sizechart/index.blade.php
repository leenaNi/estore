@extends('Admin.layouts.default')




@section('content')


<section class="content-header">
    <h1>
       Size Charts
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">  Size charts</li>
    </ol>
</section>       
<h4 align="center" style="color:green;"  >{{ Session::get('updateLoyaltyScuccess') }}</h4>



<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                @if(!empty(Session::get('message')))
                <div  class="alert alert-danger" role="alert">
                    {{ Session::get('message') }}
                </div>
                @endif
                @if(!empty(Session::get('updateLoyaltyScuccess')))
                <div  class="alert alert-success" role="alert">
                    {{ Session::get('updateLoyaltyScuccess') }}
                </div>
                @endif
                <div class="box-header box-tools filter-box col-md-9 noBorder">
<!--                    <div class="form-group col-md-4">
                        <form action="{{ route("admin.sizechart.view") }}" method="get" >
                            <input type="text" value="{{ !empty(Input::get('search')) ? Input::get('search') : '' }}" name="search" aria-controls="editable-sample" class="form-control medium" placeholder="Search Loyalty Programs"/>
                        </form> 
                    </div>  -->
                </div>
                <div class="box-header col-md-3">
                    <button id="editable-sample_new" class="btn btn-default pull-right col-md-12" onclick="window.location.href ='{{ route('admin.sizechart.edit')}}'">Add New Size Chart</button>
                </div> 
                <div class="clearfix"></div>
                <div class="dividerhr"></div>

                <div class="box-body table-responsive no-padding">
                    <table class="table table-striped table-hover">
                        <table class="table  table-hover general-table">
                            <thead>
                                <tr>
<!--                                    <th>Sr No</th>-->
                                    <th>Size Chart Name</th>
                                    <th>Image</th>
                                    <th>Status</th>
                                    <th>s</th>
                                </tr>
                            </thead>
                            <tbody>
                                   @if(count($sizechart) >0)
                                @foreach($sizechart as $lyt)

                                <tr>
<!--                                    <td>{{ $lyt->id }}</td>-->
                                    <td>{{ $lyt->name }}</td>
                                     <td>{{ Html::image(Config('constants.sizeChartUploadPath').$lyt->image,'', array('class' => 'thumbnail','width'=>'200')) }}</td>
                                    <td>{{ ($lyt->status==1)?'Active':'Inactive' }}</td>
                                    <td>
                                        <a href="{{  route('admin.sizechart.edit',['id'=>$lyt->id]) }}" class="edit btn btn-plen"><span class="" data-toggle='tooltip' title="Edit"><i class='fa fa-pencil-square-o btnNo-margn-padd'></i></span></a>

                                        {{ Form::open(['method' => 'post', 'url' => route("admin.sizechart.delete") , 'class' => 'form-inline btn-plen','style'=>'display:inline;']) }}
                                        {{ Form::hidden('id',$lyt->id) }}
                                        <a href="javascript:void();" class="delete"><span class="" data-toggle='tooltip' title='Delete'><i class='fa fa-trash'></i></span></a>
                                        {{ Form::close()}}
                                    </td>
                                </tr>
                                @endforeach
                                 @else
                           <tr><td colspan=6> No Record Found</td></tr>
                            @endif
                            </tbody>
                        </table>
                </div>


                <div class="pull-right">
                    <?php
                    $args = [];
                    !empty(Input::get("search")) ? $args["search"] = Input::get("search") : '';
                    !empty(Input::get("sort")) ? $args["sort"] = Input::get("sort") : '';
                    !empty(Input::get("order")) ? $args["order"] = Input::get("order") : '';
                    ?>
                    <?= $sizechart->appends($args)->links() ?>
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
            var r = confirm("Are You Sure You want to Delete this Attribute?");
            if (r == true) {
                $(this).parent().submit();
            } else {

            }
        });
    });
</script>

@stop