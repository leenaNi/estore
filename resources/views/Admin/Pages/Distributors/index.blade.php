@extends('Admin.Layouts.default')

@section('contents')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Merchants
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Merchants</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    @if (Auth::guard('merchant-users-web-guard')->check() !== true)
                    <div class="row">
                        <div class="col-md-10">
                            {{ Form::open(['method'=>'get']) }}
                            {{ Form::hidden('search',1) }}
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar glyphicon glyphicon-calendar"></i></div>
                                    {{ Form::text('date_search',!empty(Input::get('date_search'))?Input::get('date_search'):null,['class'=>'form-control','id'=>'dateSearch','placeholder'=>'Select Date']) }}
                                </div>
                            </div>

                            <div class="col-md-3">
                                {{ Form::text('s_company_name',!empty(Input::get('s_company_name'))?Input::get('s_company_name'):null,['class'=>'form-control','placeholder'=>'Distributor']) }}
                            </div>
                            <div class="col-md-3">
                                {{ Form::text('s_email',!empty(Input::get('s_email'))?Input::get('s_email'):null,['class'=>'form-control','placeholder'=>'Email ID']) }}
                            </div>
                            <div class="col-md-1">
                                <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Search</button>
                            </div>
                            {{ Form::close() }}
                        </div>
                        <div class="col-md-2 text-right">
                            {!! Form::open(['route'=>'admin.distributors.addEdit','method'=>'post']) !!}
                            {!! Form::submit('Add New Distributor',['class'=>'btn btn-info']) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>

                    @endif

                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-hover">
                        <tr>
                            <th>Distributor Name</th>
                            <th>Email ID</th>
                            <th>Mobile</th>
                            <th>Industry</th>
                            <th>Created Date</th>
                            <th>Actions</th>
                        </tr>
                        @foreach($distributor as $distributorData)
                            <?php
                            $industryName = '';
                            $countDisplay = '';
                            $businessNameArray = [];

$name = ucwords($distributorData->firstname . " " . $distributorData->lastname);
$decodedBusiness = json_decode($distributorData->register_details, true);
if(empty($name) || $name == "")
{
    $disName= '-';
}
else {
    $disName= $name;
}
/*if ($decodedBusiness['store_name']) {
    asort($decodedBusiness);
    $decodedBusinessNameKey = array_keys($decodedBusiness);
    $firstBusinesName = '';
    if (!empty($decodedBusiness['store_name'])) {
        //$industryName = implode(',', $decodedBusiness['store_name']);
        $industryName = $decodedBusiness['store_name'];
        $firstBusinesName = $decodedBusiness['store_name'][$decodedBusinessNameKey[0]];
        if (count($decodedBusiness['store_name']) > 1) {
            $countDisplay = ' +' . (count($decodedBusiness['store_name']) - 1) . ' More';
        }
    } // End if here
    $businessNameArray = $decodedBusiness;
    array_shift($businessNameArray);
} else {
    $businessNameArray = [];
    $countDisplay = '';
    $firstBusinesName = '';
}
echo "<pre>";
    print_r($businessNameArray);
    exit;*/
?>
                            <tr>
                                <td>{{$disName}}</td>
                                <td>{{ $distributorData->email }}</td>
                                <td>{{ $distributorData->phone_no }}</td>
                                <td>
                                    {{@$decodedBusiness['store_name']}}
                                    <!--<a onmouseover="$('#moreBusinessNameDisplayDiv_{{$distributorData->id}}').show();" onmouseout="$('#moreBusinessNameDisplayDiv_{{$distributorData->id}}').hide();">{{ $countDisplay }}</a>
                                    <div id="moreBusinessNameDisplayDiv_{{$distributorData->id}}" style="display: none;">
                                        @foreach($businessNameArray as $businessNameId => $businessName)
                                            <span>{{$businessName}}</span><br>
                                        @endforeach

                                    </div>-->
                                </td>
                                <td>{{ date('d-M-Y',strtotime($distributorData->created_at)) }}</td>
                                <td>
                                    <a href="{{ route('admin.distributors.addEdit') }}?id={{$distributorData->id }}" class="btn btn-success btn-xs">Edit</a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    <div class="pull-right">

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



<?php if (!empty(Input::get('date_search'))) {?>
    <?php $dateArr = explode(" - ", Input::get('date_search'));?>
        s_from_date = '<?php echo date("Y-m-d", strtotime($dateArr[0])) ?>';
        s_to_date = '<?php echo date("Y-m-d", strtotime($dateArr[1])) ?>';
<?php }?>



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
        //   alert("A new date range was chosen: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        $('#dateSearch').val(start.format('YYYY-MM-DD') + " - " + end.format('YYYY-MM-DD'));

    });

</script>
@stop