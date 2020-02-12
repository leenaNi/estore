@extends('Admin.layouts.default')
@section('content')

<section class="content-header">
    <h1>
        Additional Charges ({{$additionalChargeCount }})
        <!--        <small>Add/Edit/Delete</small>-->
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Additional Charge</li>
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
            <h1>Additional Charge</h1>
        </div>
        <div class="filter-section displayFlex">
            <div class="col-md-9 noAll-padding displayFlex">
                <div class="filter-left-section">
                  
                    <form action="{{ route('admin.additional-charges.view') }}" method="get" >
                        <div class="form-group col-md-8 col-sm-12 col-xs-12">
                            <input type="text" value="{{ !empty(Input::get('search')) ? Input::get('search') : '' }}" name="search" aria-controls="editable-sample" class="form-control medium" placeholder="Additional Charge Name"/>
                        </div> 
                        <div class="form-group col-md-2 col-sm-12 col-xs-12">
                            <input type="submit" name="submit" value="Search" class="form-control btn btn-primary noMob-leftmargin"> 
                        </div>
                        <div class="from-group col-md-2 col-sm-12 col-xs-12">
                            <a href="{{ route('admin.additional-charges.view')}}" class="form-control medium btn reset-btn noMob-leftmargin"> Reset </a>
                        </div>
                    </form> 
                </div>
            </div>
            <div class="col-md-3 noAll-padding displayFlex">
                <div class="filter-right-section">
                    <div class="clearfix">
                        <a href="{!! route('admin.additional-charges.add') !!}" class="btn btn-default fullWidth noAll-margin" type="button">Add New Additional Charge</a> 
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="grid-content">
        <div class="section-main-heading">
            <h1>Additional Charges <span class="listing-counter">{{$additionalChargeCount }}</span> </h1>
        </div>
        <div class="listing-section">
            <table class="table table-striped table-hover tableVaglignMiddle">
                <thead>
                    <tr>

                        <th>Name</th>
<!--                        <th>Label</th>-->
                        <th>Rate</th>
                        <th>Type</th>
                        <th>Created At</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                  @if(count($additionalCharge) >0 )
                  @foreach ($additionalCharge as $charge)
                  <tr>

                    <td>{{$charge->name}}</td>
<!--                    <td>{{ $charge->label }}</td>-->
                    <td><span class="priceConvert">{{$charge->rate}}</span> </td>
                    <td>{{ ($charge->type == 1)?'Fixed':'Percentage' }}</td>
                    <td>{{date('d-M-Y',strtotime($charge->created_at))}}</td>
                    <td>@if($charge->status==1)
                        <a href="{!! route('admin.additional-charges.changeStatus',['id'=>$charge->id]) !!}"  ui-toggle-class="" onclick="return confirm('Are you sure you want to disable this charge?')" data-toggle="tooltip" title="Enabled"><i class="fa fa-check btn-plen btn"></i></a>
                        @elseif($charge->status==0)
                        <a href="{!! route('admin.additional-charges.changeStatus',['id'=>$charge->id]) !!}" ui-toggle-class="" onclick="return confirm('Are you sure you want to enable this charge?')" data-toggle="tooltip" title="Disabled"><i class="fa fa-times btn-plen btn"></i></a>
                        @endif</td>

                        <td class="text-center">

                            <div class="actionCenter">
                                <span><a class="btn-action-default" href="{{route('admin.additional-charges.edit',['id'=>$charge->id])}}">Edit</a></span> 
                                <span class="dropdown">
                                    <button class="btn-actions dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="caret"></span>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton"> 
                                        <li><a href="{{route('admin.additional-charges.delete',['id'=>$charge->id])}}"><i class="fa fa-trash "></i> Delete</a></li>
                                    </div>
                                </span>  
                            </div>
                            <!-- <a href="{{route('admin.additional-charges.edit',['id'=>$charge->id])}}" data-toggle="tooltip" title='Edit' ui-toggle-class=""><i class="fa fa-pencil-square-o btnNo-margn-padd"></i></a> 


                            <a href="{{route('admin.additional-charges.delete',['id'=>$charge->id])}}"  ui-toggle-class="" onclick="return confirm('Are you sure you want to delete this charge?')" data-toggle="tooltip" title='Delete'><i class="fa fa-trash btn-plen btn"></i></a> -->
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr><td colspan=7> No Record Found.</td></tr>
                    @endif
                </tbody>
            </table>
            <div class="box-footer clearfix">
                <?php if (empty(Input::get('search'))) {
                echo $additionalCharge->render();
                } ?> 
            </div>
        </div>
    </div>
</section>

<div class="clearfix"></div>

@stop 
@section('myscripts')
<script>
    $(function () {
        $("#fromdatepicker").datepicker({dateFormat: 'yy-mm-dd'});
        $("#todatepicker").datepicker({dateFormat: 'yy-mm-dd'});
    });
</script>
@stop