@extends('Admin.Layouts.default')

@section('contents')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Roles

    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Roles</li>
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
                                <input type="text" name="s_role_name" value="{{ (Input::get('s_role_name'))?Input::get('s_role_name'):'' }}" class="form-control " placeholder="Search Role">
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="date_search" id="dateSearch" class="form-control" placeholder="Select Date">
                            </div>

                            <div class="col-md-1">
                                <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Search</button>
                            </div>
                            
                            {{ Form::close() }}
                        </div> 
                        </div> 
                        
                        <div class="col-md-2 text-right"> 
                            {!! Form::open(['route'=>'admin.systemusers.roles.addEdit','method'=>'post']) !!}
                            {!! Form::submit('Add New Role',['class'=>'btn btn-info']) !!}
                            {!! Form::close() !!}
                        </div>

                    </div>



                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
<!--                                <th>ID</th>-->
                                <th>Role</th>
                              
                                <th>Description</th>
                                <th>Created On</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach($roles as $role)
                         
                            <tr>
<!--                                <td>{{$role->id}}</td>-->
                                <td>{{$role->name}}</td>
                             
                                <td>{{$role->description}}</td>
                                <td>{{date('d-M-Y',strtotime($role->created_at)) }}</td>
                                <td>
                                    <a href="{{ route('admin.systemusers.roles.addEdit') }}?id={{$role->id}}" target="_" class="label label-success active" ui-toggle-class="">Edit</a>
                                </td>
 <td>
<!--                                    <a href="{{ route('admin.systemusers.roles.delete') }}?id={{$role->id}}" target="_" class="label label-danger active" ui-toggle-class="">Delete</a>-->
                                </td>

                            </tr>
                            
                            @endforeach
                        </tbody>
                    </table>
                        <?php
                    $arguments = [];
                    !empty(Input::get('s_role_name')) ? $arguments['s_role_name'] = Input::get('s_role_name') : '';
                    !empty(Input::get('date_search')) ? $arguments['date_search'] = Input::get('date_search') : '';
                    ?>
                    <div class="pull-right">
                        {{ $roles->appends($arguments)->links() }}
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
    
    
  s_from_date = '<?php echo date('Y-m-d', strtotime('-30 days')); ?>';
    s_to_date = '<?php echo date('Y-m-d'); ?>';



<?php if (!empty(Input::get('date_search'))) { ?>
    <?php $dateArr = explode(" - ", Input::get('date_search')); ?>
        s_from_date = '<?php echo date("Y-m-d", strtotime($dateArr[0])) ?>';
        s_to_date = '<?php echo date("Y-m-d", strtotime($dateArr[1])) ?>';
<?php } ?>



    $('#dateSearch').daterangepicker(
            {
                locale: {
                    format: 'YYYY-MM-DD'
                },
                startDate: s_from_date,
                endDate: s_to_date,
                autoUpdateInput: false,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            },
    function (start, end, label) {
        alert("A new date range was chosen: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        $('#dateSearch').val(start.format('YYYY-MM-DD') + " - " + end.format('YYYY-MM-DD'));

    });

</script>
@stop