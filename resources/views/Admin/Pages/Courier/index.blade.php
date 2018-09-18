@extends('Admin.Layouts.default')

@section('contents')

<section class="content-header">
    <h1>
        Courier Services
        <!--        <small>Add/Edit/Delete</small>-->
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashnoard</a></li>
        <li class="active">Courier Services</li>
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
                <!-- <div class="box-header box-tools filter-box col-md-9 noBorder">

          </div> -->
                <!--          <div class="box-header col-md-3">
                            <a href="{!! route('admin.courier.add') !!}" class="btn btn-default pull-right form-control" type="button">Add Courier Services</a> 
                        </div>-->
                <div class="clearfix"></div>
                <div class="dividerhr"></div>
                <div class="form-group col-md-4 ">
                    <div class="button-filter-search pl0">

                    </div>
                </div> 
                <div class="clearfix"></div>
                <div class="box-body table-responsive no-padding">
                    <table class="table table-striped table-hover tableVaglignMiddle">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Charges</th>
                                <th>Country</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($couriers) >0 )
                            @foreach ($couriers as $courier)
                            <tr>

                                <td>{{$courier->name}}</td>
                                <td><span class="currency-sym"></span><span class="priceConvert">{{$courier->charges}}0</span></td>
                                <td>{{@$courier->countryname->name}}</td>
                                <td>@if($courier->status==1)
                                    <a href="{!! route('admin.courier.changeStatus',['id'=>$courier->id]) !!}" class="" ui-toggle-class="" onclick="return confirm('Are you sure you want to disable this record?')" data-toggle="tooltip" title="Enabled"><i class="fa fa-check btn-plen btn"></i></a>
                                    @elseif($courier->status==0)
                                    <a href="{!! route('admin.courier.changeStatus',['id'=>$courier->id]) !!}" class="" ui-toggle-class="" onclick="return confirm('Are you sure you want to enable this record?')" data-toggle="tooltip" title="Disabled"><i class="fa fa-times btn-plen btn"></i></a>
                                    </a>
                                    @endif

                                </td>

                                <td>
                                    <a href="{{route('admin.courier.edit',['url_key'=>$courier->url_key])}}" data-toggle="tooltip" title='Configure' ui-toggle-class=""><i class="fa fa-cog" aria-hidden="true"></i></a> 

<!--                            <a href="{{route('admin.courier.delete',['id'=>$courier->id])}}"  ui-toggle-class="" onclick="return confirm('Are you sure you want to delete this record?')" data-toggle="tooltip" title='Delete'><i class="fa fa-trash btn-plen btn"></i></a>-->
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr><td colspan=7> No Record Found</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                    <?php
                    if (empty(Input::get('search'))) {
                        echo $couriers->render();
                    }
                    ?> 

                </div>
            </div>
        </div>
    </div>
</section>

@stop 
@section('myscripts')
<script>
    $(function () {
        $("#fromdatepicker").datepicker({dateFormat: 'yy-mm-dd'});
        $("#todatepicker").datepicker({dateFormat: 'yy-mm-dd'});
    });
</script>
@stop