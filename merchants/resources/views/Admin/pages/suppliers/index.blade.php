@extends('Admin.layouts.default')
@section('content')
<section class="content-header">
    <h1>
        Vendors ({{$startIndex}} - {{$endIndex}} of {{$userCount}})
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Vendors</li>
    </ol>
</section>

<section class="main-content">
    <div class="notification-column">
        @if(!empty(Session::get('msg')))
        <div  class="alert alert-success" role="alert">
            {{ Session::get('msg') }}
        </div>
        @endif
        @if(!empty(Session::get('message')))
        <div  class="alert alert-danger" role="alert">
            {{ Session::get('message') }}
        </div>
        @endif
    </div>
    <div class="grid-content">
        <div class="section-main-heading">
            <h1>Filter</h1>
        </div>
        <div class="filter-section displayFlex">
            <div class="col-md-9 noAll-padding displayFlex">
                <div class="filter-left-section">
                    <form action="{{ route('admin.suppliers.view') }}" method="get" >
                        <div class="form-group col-md-8 col-sm-6 col-xs-12">
                            <input type="text" name="empSearch" value="{{ !empty(Input::get('empSearch')) ? Input::get('empSearch') : '' }}" class="form-control medium pull-right catSearcH" placeholder="Search User">
                        </div>
                        <div class="form-group col-md-2 col-sm-3 col-xs-12">
                            <input type="submit" name="submit" value="Search" class="fullWidth noAll-margin btn btn-primary noMob-leftmargin">
                        </div>
                        <div class='form-group col-md-2 col-sm-3 col-xs-12'>
                            <a href="{{route('admin.suppliers.view')}}" class='fullWidth noAll-margin btn reset-btn noMob-leftmargin'>Reset </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-3 noAll-padding displayFlex">
                <div class="filter-right-section">
                    <div class="clearfix">
                        <a href="{!! route('admin.suppliers.add') !!}" class="btn btn-default pull-right col-md-12 mobAddnewflagBTN marginBottom15" target="_" type="button">Add New Vendor</a>
                        <div class="clearfix"></div>
                        <a href="{!! route('admin.suppliers.export') !!}" class="btn btn-default pull-right col-md-12 mobAddnewflagBTN" target="_" type="button">Export</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="grid-content">
        <div class="section-main-heading">
            <h1>Vendors <span class="listing-counter"> {{$startIndex}} - {{$endIndex}} of {{$userCount }} </span> </h1>
        </div>
        <div class="listing-section">
            <div class="table-responsive overflowVisible no-padding">
            <table class="table table-striped table-hover tableVaglignMiddle">
                        <thead>
                            <tr>
                                <th class="text-left">Name</th>
                                <th class="text-left">Email Id</th>
                                <th class="text-left">Mobile No.</th>
                                <th class="text-right">Date</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($suppliers) >0 )
                            @foreach($suppliers as $supplier)
                        <td class="text-left">{{$supplier->firstname }} {{$supplier->lastname }}</td>

                        <td class="text-left">{{ $supplier->email }}</td>
                        <td class="text-left">{{ $supplier->telephone }}</td>
                        <td class="text-right">{{ date("d-M-Y",strtotime($supplier->created_at)) }}</td>
                        <td class="text-center">
                            @if($supplier->status==1)
                            <a href="{!! route('admin.suppliers.changeStatus',['id'=>$supplier->id]) !!}"  onclick="return confirm('Are you sure you want to disable this user?')" data-toggle='tooltip' title='Enabled' ><i class="fa fa-check btn-plen btn"></i></a>
                            @elseif($supplier->status==0)
                            <a href="{!! route('admin.suppliers.changeStatus',['id'=>$supplier->id]) !!}"  onclick="return confirm('Are you sure you want to enable this user?')" data-toggle="tooltip" title="Disabled"> <i class="fa fa-times btn-plen btn"></i></a>
                            @endif


                        <td class="text-center">
                        @if($supplier->id!=1)
                        <div class="actionCenter">
                            <span><a class="btn-action-default" href="{!! route('admin.suppliers.edit',['id'=>$supplier->id]) !!}"><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'pencil.svg'}}"></a></span>
                            <span class="dropdown">
                                <button class="btn-actions dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                    <li><a href="{!! route('admin.suppliers.delete',['id'=>$supplier->id]) !!}"><i class="fa fa-trash "></i> Delete</a></li>
                                </ul>
                            </span>
                        </div>
                        @endif
                        </td>
                        </tr>
                        @endforeach
                        @else
                        <tr><td colspan="5" class="text-center"> No Record Found.</td></tr>
                        @endif
                        </tbody>
                    </table>
                    <?php
if (empty(Input::get('empSearch'))) {
    echo $suppliers->render();
}
?>
             </div>
           </div>
           </div>
        </div>
</section>
<div class="clearfix">


@stop