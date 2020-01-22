@extends('Admin.Layouts.default')

@section('contents')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Category
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Category</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-md-10">
                        <div class="row">
                            {{ Form::open(['method'=>'get']) }}
                            {{ Form::hidden('search',1) }}
                            <div class="col-md-3">
                                {{ Form::text('s_category',!empty(Input::get('s_category'))?Input::get('s_category'):null,['class'=>'form-control','placeholder'=>'Search']) }}
                            </div>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar glyphicon glyphicon-calendar"></i></div>
                                    {{ Form::text('date_search',!empty(Input::get('date_search'))?Input::get('date_search'):null,['class'=>'form-control','id'=>'dateSearch','placeholder'=>'Select Date']) }}
                                </div>
                            </div>
                            <div class="col-md-1">
                                <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Search</button>

                            </div>
                            {{ Form::close() }}
                            </div>
                        </div>
                        <!-- <div class="col-md-2 text-right">
                            {!! Form::open(['route'=>'admin.masters.category.addEdit','method'=>'post']) !!}
                            {!! Form::submit('Add New Category',['class'=>'btn btn-info']) !!}
                            {!! Form::close() !!}
                        </div> -->
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-hover">
                        <tr>
                            <th>Category</th>
                            <th>Parent Category</th>
                            <th>Requested By</th>
                            <th>Created On</th>
                            <th>Action</th>
                        </tr>
                        @foreach($categories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>
                            <td>{{ @$category->parent->category }}</td>
                            <td>{{ @$category->requestedBy->store->store_name }}</td>
                            <td>{{ date('d-M-Y',strtotime($category->created_at)) }}</td>
                            <td>
                                <a href="{{ route('admin.category.approve') }}?id={{@$category->id }}" class="btn btn-success btn-xs">Add</a>
                                <!-- <a href="#" class="btn btn-warning btn-xs changeStatus" data-catid="{{$category->id }}" data-catstatus="{{$category->status }}" title="{{ ($category->status == 1)?'Disable':'Enable'}}" >{{ ($category->status == 1)?'Enabled':'Disabled' }}</a> -->
                            </td>
                        </tr>
                        @endforeach
                    </table>

                    <?php
$arguments = [];
!empty(Input::get('s_category')) ? @$arguments['s_category'] = @Input::get('s_category') : '';
!empty(Input::get('date_search')) ? @$arguments['date_search'] = @Input::get('date_search') : '';
?>
                    <div class="pull-right">
                         {{ @$categories->appends($arguments)->links() }}
                    </div>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
<!-- /.content -->
@stop
@section('myscripts')
<script>



</script>
@stop