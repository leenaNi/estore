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
                        <div class="col-md-2 text-right"> 
                            {!! Form::open(['route'=>'admin.masters.category.addEdit','method'=>'post']) !!}
                            {!! Form::submit('Add New Category',['class'=>'btn btn-info']) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>



                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-hover">
                        <tr>
<!--                            <th>ID</th>-->
                            <th>Category</th>
                           
                            <th>Created On</th>
                            <th>Action</th>
                        </tr>
                        @foreach($categories as $category)
                        <tr>
<!--                            <td>{{ $category->id }}</td>-->
                            <td>{{ $category->category }}</td>
                            <td>{{ date('d-M-Y',strtotime($category->created_at)) }}</td>
                            <td>
                                <a href="{{ route('admin.masters.category.addEdit') }}?id={{$category->id }}" class="btn btn-success btn-xs">Edit</a>
                                <a href="#" class="btn btn-warning btn-xs changeStatus" data-catid="{{$category->id }}" data-catstatus="{{$category->status }}" title="{{ ($category->status == 1)?'Disable':'Enable'}}" >{{ ($category->status == 1)?'Enabled':'Disabled' }}</a>
                            </td>


                        </tr>
                        @endforeach
                    </table>

                    <?php
                    $arguments = [];
                    !empty(Input::get('s_category')) ? $arguments['s_category'] = Input::get('s_category') : '';
                    !empty(Input::get('date_search')) ? $arguments['date_search'] = Input::get('date_search') : '';
                    ?>
                    <div class="pull-right">
                         {{ $categories->appends($arguments)->links() }}
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
    $(".changeStatus").click(function () {
        // alert("sdfsdf");
        var catid = $(this).attr("data-catid");
        var catstatus = $(this).attr("data-catstatus");
        var status = $(this);
        $.ajax({
            type: "POST",
            url: "{{ route('admin.masters.category.changeStatus') }}",
            data: {catid: catid, catstatus: catstatus},
            cache: false,
            success: function (data) {

                if (data == 0) {
                    status.text('Disabled');
                    status.attr("data-catstatus", data);
                    $(".catS").text('Disabled');
                    status.attr("title", 'Enabled');

                } else {
                    status.text('Enabled');
                    $(".catS").text('Enabled');
                    status.attr("data-catstatus", data);
                    status.attr("title", 'Disabled');
                }


            }

        });



    });



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