@extends('Admin.layouts.default')
@section('content') 
<section class="content-header">   
    <h1>
        Manage Tables ({{$tablesCount}})
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Manage Tables</li>
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
                <div class="box-header box-tools filter-box col-md-9 noBottompadding noBorder">

                    <form action="{{ route('admin.tables.view') }}" method="get" >
                        <input type="hidden" name="dataSearch" value="dataSearch"/>
                        <div class="form-group col-md-6">
                            <input type="text" name="table"  class="form-control" placeholder="Search Table" value="{{ !empty(Input::get('table'))?Input::get('table'):'' }}" >
                        </div>

                        <div class="form-group col-sm-2">
                            <input type="submit" name="submit" vlaue='Search' class='form-control btn btn-primary noMob-leftmargin'>
                        </div>
                        <div class="from-group col-sm-2">
                            <a href="{{ route('admin.tables.view')}}" class="btn btn-block reset-btn noMob-leftmargin">Reset </a>
                        </div>
                    </form>
                </div>   


                <div class="box-header col-md-3 col-sm-12 col-xs-12">
                    <a href="{!! route('admin.tables.addEdit') !!}" class="btn btn-default pull-right col-md-12 noMob-leftmargin mobAddnewflagBTN" type="button">Add New Table</a>
                </div> 
     
              </div> 
                <div class="clearfix"></div>
                <div class="dividerhr"></div>
             
                <div class="box-body table-responsive">
                    <table class="table  table-hover general-table tableVaglignMiddle">
                        <thead>
                            <tr>

                                <th>Table No.</th>
                                <th>Table Name</th>
                                <th>Table Shape</th>
                                <th>Table Capacity</th>

                                <th>Status</th>
                                 <th>Action</th>

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

                                <td>@if($table->status ==1)  
                                    <a href="{{route('admin.tables.changeStatus',['id'=>$table->id])}}" data-toggle="tooltip" title="Enabled" onclick="return confirm('Are you sure you want to disable this table?')"><i class="fa fa-check btn btn-plen btnNo-margn-padd"></i></a>
                                    @endif
                                    @if($table->status ==0)  
                                    <a href="{{route('admin.tables.changeStatus',['id'=>$table->id])}}" data-toggle="tooltip" title="Disabled" onclick="return confirm('Are you sure you want to enable this table?')"><i class="fa fa-times btn btn-plen btnNo-margn-padd"></i></a>
                                    @endif
                                </td>
                                <td>

                                    <a href="{{route('admin.tables.addEdit',['id'=>$table->id])}}" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square-o btn btn-plen btnNo-margn-padd"></i></a>
                                    <a href="{{route('admin.tables.delete',['id'=>$table->id])}}" onclick="return confirm('Are you sure you want to delete this table?')" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr> <td colspan="4">No Records Found</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div><!-- /.box-body -->

                <div class="box-footer clearfix">
                    @if(empty(Input::get('dataSearch')))
                    {{$tables->links() }}
                    @endif

                </div>
            </div>
        </div>
    </div>
</section>

@stop

@section('myscripts')

@stop

