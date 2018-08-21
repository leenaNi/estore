@extends('Admin.Layouts.default')

@section('contents')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
      Merchant Sales 

    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Stores</li>
    </ol>
</section>
<section class="content">

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="row">

                        <div class="col-md-10">



                            <div class='row mt15' >
                                {{ Form::open(['method'=>'get']) }}
                                
                                @if(empty(Session::get('bankid')))
                                <div class="col-md-3">
                                    {{ Form::select('s_bank_name',$selBank,!empty(Input::get('s_bank_name'))?Input::get('s_bank_name'):null,['class'=>'form-control']) }}
                                </div>
                                @endif

                                <div class="col-md-2">
                                    <input type="text" name="s_mer_name" class="form-control" value="{{ !empty(Input::get('s_mer_name'))?Input::get('s_mer_name'):null }}"  placeholder="Merchant">

                                </div>
                                <div class="col-md-2">  
                                    {{ Form::select('s_status',[""=>"Select Status","1"=>"Enabled","0"=>"Disabled"],(Input::get('s_status') != "")?Input::get('s_status'):null,['class'=>'form-control']) }}


                                </div>

                                <div class="col-md-3">
                                    <div class="input-group">
                                        <div class="input-group-addon"><i class="fa fa-calendar glyphicon glyphicon-calendar"></i></div>
                                        {{ Form::text('date_search',!empty(Input::get('date_search'))?Input::get('date_search'):null,['class'=>'form-control','id'=>'dateSearch','placeholder'=>'Order Date','autocomplete'=>"off"]) }}
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Search</button>
                                </div>

                                {{ Form::close() }}

                            </div>

                        </div> 
                        <div class="col-md-2 text-right">
                                                 <a href="{{ route('admin.analytics.byMerchant.export') }}" class="btn btn-info"><i class="fa fa-file-excel-o"></i> Export</a>

                        </div>


                    </div>



                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-hover">
                        <tr>

                            <th></th>
                            <th>Merchant</th>
                            <th>Bank </th>
                            <th>Sales</th>






                        </tr>

                        @foreach($getmsales as $gmsales)

                        <?php
                        if (!empty($gmsales->logo)) {
                            $gSLogo = asset('/public/admin/uploads/logos/' . $gmsales->logo);
                        } else {
                            $gSLogo = asset('/public/admin/uploads/logos/default-store.jpg');
                        }
                        ?>


                        <tr>
                            <td><img src="{{ @$gSLogo }}" width="50"  alt="User Image"></td>
                            <td>{{ $gmsales->company_name }}</td>
                            <td>{{ $gmsales->banknames }}</td>
                            <td>{{ Session::get('cur') }} {{ number_format($gmsales->total_sales) }}</td>
                        </tr>

                        @endforeach




                    </table>
<?php
$arguments = [];
!empty(Input::get('s_bank_name')) ? $arguments['s_bank_name'] = Input::get('s_bank_name') : '';
!empty(Input::get('s_mer_name')) ? $arguments['s_mer_name'] = Input::get('s_mer_name') : '';
!empty(Input::get('s_status')) ? $arguments['s_status'] = Input::get('s_status') : '';

!empty(Input::get('date_search')) ? $arguments['date_search'] = Input::get('date_search') : '';
?>
                    <div class="pull-right">
                        {{ $getmsales->appends($arguments)->links() }}
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
        //  alert("A new date range was chosen: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        $('#dateSearch').val(start.format('YYYY-MM-DD') + " - " + end.format('YYYY-MM-DD'));

    });


</script>
@stop