@extends('Admin.layouts.default')
@section('content')

<section class="content-header">
    <h1>
        Taxes ({{$taxCount }})
        <!--        <small>Add/Edit/Delete</small>-->
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Tax</li>
    </ol>
</section>
<section class="main-content">
    <div class="notification-column">
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
    </div>
    <div class="grid-content">
        <div class="section-main-heading">
            <h1>Tax</h1>
        </div>
        <div class="filter-section displayFlex">
            <div class="col-md-9 noAll-padding displayFlex">
                <div class="filter-left-section"> 
                    
                    <form action="{{ route('admin.tax.view') }}" method="get" >
                            <div class="form-group col-md-8 col-sm-6 col-xs-12">
                                <input type="text" value="{{ !empty(Input::get('search')) ? Input::get('search') : '' }}" name="search" aria-controls="editable-sample" class="form-control medium" placeholder="Search Tax"/>
                            </div> 
                            <div class="form-group col-md-2 col-sm-3 col-xs-12">
                            <button type="submit" class="btn btn-primary" style="margin-left: 0px;"> Search</button>
                            </div>
                            <div class="from-group col-md-2 col-sm-3 col-xs-12">
                                <a href="{{ route('admin.tax.view')}}" class="medium btn reset-btn noMob-leftmargin"> Reset </a>
                            </div>
                    </form> 
                </div>
            </div>
            <div class="col-md-3 noAll-padding displayFlex">
                <div class="filter-right-section">
                    <div class="clearfix">
                        <a href="{!! route('admin.tax.add') !!}" class="btn btn-default fullWidth noAll-margin" type="button">Add New Tax</a> 
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="grid-content">
        <div class="section-main-heading">
            <h1>Taxes   <span class="listing-counter">{{$taxCount }}</span> </h1>
        </div>
        <div class="listing-section">
            <table class="table table-striped table-hover tableVaglignMiddle">
                <thead>
                    <tr>

                        <th class="text-left">Tax Name</th>
<!--                        <th>Display Name</th>-->
                        <th class="text-center">Tax Rate (%)</th>
                        <th class="text-left">Tax Number</th>
                        <th class="text-right">Created At</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                  @if(count($taxInfo) >0 )
                  @foreach ($taxInfo as $tax)
                  <tr>

                    <td class="text-left">{{$tax->name}}</td>
<!--                    <td>{{ $tax->label }}</td>-->
                    <td class="text-center">{{$tax->rate}} </td>
                    <td class="text-left">{{$tax->tax_number}}</td>
                    <td class="text-right">{{date('d-M-Y',strtotime($tax->created_at))}}</td>
                    <td class="text-center">@if($tax->status==1)
                        <a href="{!! route('admin.tax.changeStatus',['id'=>$tax->id]) !!}"  ui-toggle-class="" onclick="return confirm('Are you sure you want to disable this tax?')" data-toggle="tooltip" title="Enabled"><i class="fa fa-check btn-plen btn btnNo-margn-padd"></i></a>
                        @elseif($tax->status==0)
                        <a href="{!! route('admin.tax.changeStatus',['id'=>$tax->id]) !!}" ui-toggle-class="" onclick="return confirm('Are you sure you want to enable this tax?')" data-toggle="tooltip" title="Disabled"><i class="fa fa-times btn-plen btn  btnNo-margn-padd"></i></a>
                        @endif</td>

                        <td class="text-center">
                            <div class="actionCenter">
                                <span><a class="btn-action-default" href="{{route('admin.tax.edit',['id'=>$tax->id])}}">Edit</a></span> 
                                <span class="dropdown">
                                    <button class="btn-actions dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="caret"></span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton"> 
                                        <li><a href="{{route('admin.tax.delete',['id'=>$tax->id])}}"><i class="fa fa-trash "></i> Delete</a></li>
                                    </div>
                                </span>  
                            </div>
                            <!-- <a href="{{route('admin.tax.edit',['id'=>$tax->id])}}" data-toggle="tooltip" title='Edit' ui-toggle-class=""><i class="fa fa-pencil-square-o btnNo-margn-padd"></i></a> 


                            <a href="{{route('admin.tax.delete',['id'=>$tax->id])}}"  ui-toggle-class="" onclick="return confirm('Are you sure you want to delete this tax?')" data-toggle="tooltip" title='Delete'><i class="fa fa-trash btn-plen btn btnNo-margn-padd"></i></a> -->
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr><td colspan=7 class="text-center"> No Record Found</td></tr>
                    @endif
                </tbody>
            </table>
            <div class="box-footer clearfix">
                    <?php if (empty(Input::get('search'))) {
                    echo $taxInfo->render();
                } ?> 

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