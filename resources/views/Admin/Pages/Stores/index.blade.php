@extends('Admin.Layouts.default')

@section('contents')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Stores</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Stores</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div class="row "> 
                        <div class="col-md-12 text-right"> 

                            {!! Form::open(['route'=>'admin.stores.addEdit','method'=>'post']) !!}

<!--                            {!! Form::submit('Add New Store',['class'=>'btn btn-info']) !!}-->

                            {!! Form::close() !!}
                        </div>

                    </div>
                    @if (Auth::guard('merchant-users-web-guard')->check() !== true) 
                    <div class="row mt15">

                        {{ Form::open(['method'=>'get']) }}

                        <div class="col-md-2">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-calendar glyphicon glyphicon-calendar"></i></div>
                                {{ Form::text('date_search',!empty(Input::get('date_search'))?Input::get('date_search'):null,['class'=>'form-control','id'=>'dateSearch','placeholder'=>'Select Date']) }}
                            </div>
                        </div>

                        
                        <div class="col-md-2">
                            {{ Form::text('s_name',!empty(Input::get('s_name'))?Input::get('s_name'):null,['class'=>'form-control','placeholder'=>'Store']) }}
                        </div>


                        <div class="col-md-2">
                            {{ Form::select('s_status',[''=>'Select Status','1'=>'Enabled','0'=>'Disabled'],!empty(Input::get('s_status'))?Input::get('s_status'):null,['class'=>"form-control"]) }}
                        </div>
                        <div class="col-md-3">
                            {{ Form::select('s_cat',$selCats,!empty(Input::get('s_cat'))?Input::get('s_cat'):null,['class'=>"form-control"]) }}
                        </div>

                        <div class="col-md-2">
                            <button type="submit" class="btn btn-success form-control"><i class="fa fa-search"></i> Search</button>
                        </div>


                        {{ Form::close() }}
                    </div>
                    @endif




                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-hover">
                        <tr>
<!--                            <th>ID</th>
                            <th></th>-->
                            <th>Store</th>
                            <th>Merchant</th>
                            <th>Status</th>
                            <!-- <th>Bank</th>-->
                            <th>Category</th>
                            <th>Created Date</th>
                            <th>Actions</th>
                        </tr>

                        @foreach($stores as $store )
						<tr>
                            <?php
                            if (!empty($store->logo)) {
                                $slogo = $store->logo;
                            } else {
                                $slogo = "default-store.jpg";
                            }
                            ?>

<!--                            <td>{{ $store->id }}</td>
                            <td><img src="{{ asset('public/admin//uploads/logos/')."/".@$slogo }}" width="50"  alt="User Image"></td>-->
                            <td>{{ $store->store_name }}</td>
                            <td>{{ @$store->getmerchant()->first()->firstname }}</td>
                            <td>{{ ($store->status == 1)?'Enabled':'Disabled' }}</td>
                            <!-- <td><?php
                               // $getbank = $store->getmerchant->hasMerchants()->get();
                               // $bname = "";
                               // foreach ($getbank as $gBk) {
                               //     $bname .= $gBk->name . ",";
                               // }

                              //  echo rtrim($bname, ",");
                                ?></td>-->
								
                            <td>{{ @$store->getcategory->category }} </td>

                            <td>{{ date("d-M-Y",strtotime($store->created_at)) }}</td>
                            <td> <a href="{{ route('admin.stores.addEdit') }}?id={{$store->id }}" class="btn btn-success btn-xs">Edit</a></td>
<!--                            <td>
                                {!! Form::open(['route'=>'admin.stores.addEdit','method'=>'post']) !!}
                                {!! Form::hidden('id',$store->id) !!}
                                {!! Form::submit('Edit',['class'=>'btn btn-success btn-xs']) !!}
                                {!! Form::close() !!}
                            </td>-->
                        </tr>
                        @endforeach

                    </table>
                    
                    <?php
                    $arguments = [];
                   
                    !empty(Input::get('s_bank_name')) ? $arguments['s_bank_name'] = Input::get('s_bank_name') : '';
                    !empty(Input::get('s_name')) ? $arguments['s_name'] = Input::get('s_name') : '';
                    !empty(Input::get('s_status')) ? $arguments['s_status'] = Input::get('s_status') : '';
                    !empty(Input::get('s_cat')) ? $arguments['s_cat'] = Input::get('s_cat') : '';
                    !empty(Input::get('date_search')) ? $arguments['date_search'] = Input::get('date_search') : '';
                    ?>
                    <div class="pull-right">
                        {{ $stores->appends($arguments)->links() }}
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
        //alert("A new date range was chosen: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        $('#dateSearch').val(start.format('YYYY-MM-DD') + " - " + end.format('YYYY-MM-DD'));

    });

</script>
@stop