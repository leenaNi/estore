@extends('Admin.Layouts.default')

@section('contents')
<style>
    .theme-table th, .theme-table td {
    max-width: 300px;
}
.theme-table th img, .theme-table td img{
    width: auto !important;
}
</style>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Theme

    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Theme</li>
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

                                {{ Form::text('s_category',!empty(Input::get('s_category'))?Input::get('s_category'):null,['class'=>'form-control','placeholder'=>'Category']) }}
                            </div>
                               <div class="col-md-3">

                                {{ Form::text('s_name',!empty(Input::get('s_name'))?Input::get('s_name'):null,['class'=>'form-control','placeholder'=>'Name']) }}
                            </div>
<!--                            <div class="col-md-5">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar glyphicon glyphicon-calendar"></i></div>
                                    {{ Form::text('date_search',!empty(Input::get('date_search'))?Input::get('date_search'):null,['class'=>'form-control','id'=>'dateSearch','placeholder'=>'Select Date']) }}

                                </div>
                            </div>-->

                            <div class="col-md-1">
                                <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Search</button>

                            </div>
                            {{ Form::close() }}
                            </div>
                        </div> 
                        <div class="col-md-2 text-right"> 
                            {!! Form::open(['route'=>'admin.masters.themes.addEdit','method'=>'post']) !!}
                            {!! Form::submit('Add New Theme',['class'=>'btn btn-info']) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>



                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-hover theme-table">
                        <tr>
                            <th>Category</th>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Theme Type</th>
                            <th>Created On</th>
                            <th>Action</th>
                        </tr>
                        @foreach($themes as $theme)
                        <tr>
                            <td>{{ $theme->category['category'] }}</td>
                            <td>{{ $theme->theme_category }}</td>
                                             <?php
                                            if (!empty($theme->image)) {
                                                $slogo = asset('public/admin/themes/') . "/" . $theme->image;
                                            } else {
                                                $slogo = asset('public/admin/themes/') . "/default-theme.png";
                                            }
                                            ?>

                            <td>@if($theme->image)
                               <img src="{{ $slogo }}" class="displayImage" height="5%" width="10%"></img>
                                @else
                                 <img src="{{ $slogo }}" class="displayImage" height="5%" width="10%"></img>
                                @endif
                                
                            </td>
                            <td>{{ ($theme->theme_type==1)?"Free":"Paid" }}</td>
                            <td>{{ date('d-M-Y',strtotime($theme->created_at)) }}</td>
                            <td>
                                <a href="{{ route('admin.masters.themes.addEdit') }}?id={{$theme->id }}" class="btn btn-success btn-xs">Edit</a>
                                <a href="#" class="btn btn-warning btn-xs changeStatus" data-themeid="{{$theme->id }}" data-themestatus="{{$theme->status }}" title="{{ ($theme->status == 1)?'Disable':'Enable'}}" >{{ ($theme->status == 1)?'Enabled':'Disabled' }}</a>
                            </td>


                        </tr>
                        @endforeach
                    </table>

                    <?php
                    $arguments = [];
                    !empty(Input::get('s_category')) ? $arguments['s_category'] = Input::get('s_category') : '';
                    !empty(Input::get('date_search')) ? $arguments['date_search'] = Input::get('date_search') : '';
                                        !empty(Input::get('s_name')) ? $arguments['s_name'] = Input::get('s_name') : '';

                    ?>
                    <div class="pull-right">
                         {{ $themes->appends($arguments)->links() }}
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
        var themeid = $(this).attr("data-themeid");
        var themestatus = $(this).attr("data-themestatus");
        var status = $(this);
        $.ajax({
            type: "POST",
            url: "{{ route('admin.masters.themes.changeStatus') }}",
            data: {themeid: themeid, themestatus: themestatus},
            cache: false,
            success: function (data) {

                if (data == 0) {
                    status.text('Disabled');
                    status.attr("data-themestatus", data);
                    $(".catS").text('Disabled');
                    status.attr("title", 'Enabled');

                } else {
                    status.text('Enabled');
                    $(".catS").text('Enabled');
                    status.attr("data-themestatus", data);
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