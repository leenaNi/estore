@extends('Admin.Layouts.default')

@section('contents')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
      Banks
      
     

    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol>
</section>
<section class="content">

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="row">
                        <div class="col-md-10">
                            {{ Form::open(['method'=>'get']) }}
                            {{ Form::hidden('search',1) }}
                             <div class="col-md-5">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar glyphicon glyphicon-calendar"></i></div>
                                    {{ Form::text('date_search',!empty(Input::get('date_search'))?Input::get('date_search'):null,['class'=>'form-control','id'=>'dateSearch','placeholder'=>'Select Date']) }}
                                </div>
                            </div>
                         
                            <div class="col-md-3">
                                <?php
                                 //Form::select('s_bank_name',$selBanks,!empty(Input::get('s_bank_name'))?Input::get('s_bank_name'):null,['class'=>'form-control']) 
                                     ?>                       
                                {{ Form::text('s_bank_name',!empty(Input::get('s_bank_name'))?Input::get('s_bank_name'):null,['class'=>'form-control','placeholder'=>'Bank Name']) }}
                            </div>
                           
                            <div class="col-md-3">
                                {{ Form::text('s_email',!empty(Input::get('s_email'))?Input::get('s_email'):null,['class'=>'form-control','placeholder'=>'Email']) }}
                            </div>
                           

                            <div class="col-md-1">
                                <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Search</button>
                            </div>
                            {{ Form::close() }}
                        </div> 
                        <div class="col-md-2 text-right"> 
                            {!! Form::open(['route'=>'admin.banks.addEdit','method'=>'post']) !!}
                            {!! Form::submit('Add New Bank',['class'=>'btn btn-info']) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>



                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-hover">
                        <tr>
<!--                            <th>ID</th>-->
                            <th>Bank</th>
                           
                            <th>Email</th>
                            <th>Phone Number</th>
                           
                            <th>Created On</th>
                            <th>Actions</th>
                        </tr>
                        @foreach($banks as $bank)
                        <tr>
<!--                            <td>{{ $bank->id }}</td>-->
                            <td>{{ $bank->name }}</td>
                         
                            <td>{{ $bank->email }}</td>
                            <td>{{ $bank->phone }}</td>

                          
                            <td>{{ date('d-M-Y',strtotime($bank->created_at)) }}</td>
                            <td>
                                <a href="{{ route('admin.banks.addEdit') }}?id={{$bank->id }}" class="btn btn-success btn-xs">Edit</a>

                            </td>


                        </tr>
                        @endforeach
                    </table>
                    <?php
                    $arguments = [];
                    !empty(Input::get('s_company_name')) ? $arguments['s_company_name'] = Input::get('s_company_name') : '';
                    !empty(Input::get('s_email')) ? $arguments['s_email'] = Input::get('s_email') : '';
                    !empty(Input::get('date_search')) ? $arguments['date_search'] = Input::get('date_search') : '';
                    ?>
                    <div class="pull-right">
                        {{ $banks->appends($arguments)->links() }}
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
       // alert("A new date range was chosen: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        $('#dateSearch').val(start.format('YYYY-MM-DD') + " - " + end.format('YYYY-MM-DD'));

    });

</script>
@stop