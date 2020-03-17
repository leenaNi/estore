@extends('Admin.layouts.default')
@section('content') 
<section class="content-header">   
    <h1>
        Manage Tables
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Tables</a></li>
        <li class="active">Manage Tables</li>
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
            <h1><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'settings-2.svg'}}"> Filters</h1>
            <a href="{!! route('admin.tables.addEdit') !!}" class="btn btn-listing-heading pull-right noAll-margin" target="" type="button">Add New Table</a> 
        </div>
        <div class="filter-section">
            <div class="col-md-12 noAll-padding">
                <div class="filter-left-section">
                    <form action="{{ route('admin.tables.view') }}" method="get" >
                        <input type="hidden" name="dataSearch" value="dataSearch"/>
                        <div class="form-group col-md-6">
                            <div class="input-group">
                                <span class="input-group-addon lh-bordr-radius"><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'noun_user.svg'}}"></span>
                                <input type="text" name="table" value="{{ !empty(Input::get('table'))?Input::get('table'):'' }}" class="form-control form-control-right-border-radius" placeholder="Search Table">
                            </div>

                        </div>

                        <div class="form-group col-sm-2">
                            <input type="submit" name="submit" vlaue='Search' class='form-control btn btn-primary noMob-leftmargin'>
                        </div>
                        <div class="from-group col-sm-2">
                            <a href="{{ route('admin.tables.view')}}" class="btn btn-block reset-btn noMob-leftmargin">Reset </a>
                        </div>
                    </form>
                </div>
            </div>          
        </div>
    </div>
    <div class="grid-content">
        <div class="section-main-heading">
            <h1><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'receipt-2.svg'}}"> Manage Tables  <span class="listing-counter">({{$tablesCount}})</span></h1>
            
        </div>
        <div class="listing-section">
            <div class="table-responsive overflowVisible no-padding">
            <table class="table  table-hover general-table tableVaglignMiddle">
                        <thead>
                            <tr>

                                <th>Table No.</th>
                                <th>Table Name</th>
                                <th>Table Shape</th>
                                <th>Table Capacity</th>

                                <th class="text-center">Status</th>
                                 <th class="text-center">Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            @if(count($tables) >0)
                            @foreach($tables as $table)

                            <tr>

                                <td>{{ $table->table_no }}</td>
                                <td>{{ $table->table_label }}</td>
                                <td>{{ $table->table_type == 1 ? "Square" : ($table->table_type == 2 ? "Rectangle" : "Circle") }}</td>
                                <td>{{ $table->chairs }}</td>

                                <td class="text-center">@if($table->status ==1)  
                                    <a href="{{route('admin.tables.changeStatus',['id'=>$table->id])}}" data-toggle="tooltip" title="Enabled" onclick="return confirm('Are you sure you want to disable this table?')"><i class="fa fa-check btn btn-plen btnNo-margn-padd"></i></a>
                                    @endif
                                    @if($table->status ==0)  
                                    <a href="{{route('admin.tables.changeStatus',['id'=>$table->id])}}" data-toggle="tooltip" title="Disabled" onclick="return confirm('Are you sure you want to enable this table?')"><i class="fa fa-times btn btn-plen btnNo-margn-padd"></i></a>
                                    @endif
                                </td>
                                <td class="text-center">

                                <div class="actionCenter"> 
                            <span><a class="btn-action-default" href="{{route('admin.tables.addEdit',['id'=>$table->id])}}"><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'pencil.svg'}}"></a></span>  
                            <span class="dropdown">
                                <button class="btn-actions dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="{{ Config('constants.adminImgangePath') }}/icons/{{'more.svg'}}">
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">  
                                    <li><a href="{{route('admin.tables.delete',['id'=>$table->id])}}" onclick="return confirm('Are you sure you want to delete this table?')"><i class="fa fa-trash "></i> Delete</a></li>
                                 
                                </ul>
                            </span>  
                        </div> 
                                   
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr> <td colspan="4">No Records Found</td></tr>
                            @endif
                        </tbody>
                    </table>
            </div>
            <div class="box-footer clearfix">
                    @if(empty(Input::get('dataSearch')))
                    {{$tables->links() }}
                    @endif

                </div>
        
        </div>
    </div>
</section>
<div class="clearfix"></div>



@stop

@section('myscripts')

@stop

