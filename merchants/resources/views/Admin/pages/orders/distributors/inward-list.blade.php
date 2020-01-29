@extends('Admin.layouts.default')

@section('mystyles')
<link rel="stylesheet" href="{{ Config('constants.adminPlugins').'/daterangepicker/daterangepicker-bs3.css' }}">
<link rel="stylesheet" href="{{  Config('constants.adminPlugins').'/bootstrap-multiselect/bootstrap-multiselect.css' }}">
<style type="text/css">
    .multiselect-container {
        width: 100% !important;
    }
    .brbottom1{
        margin-bottom: 10px;
        padding: 10px;
    }
    .success{
        color: #3c763d;
    }
    .error{
        color: #d73925;
    }
</style>
@stop

@section('content')
<section class="content-header">
    <h1>
        Inward Transaction
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li><a href="{{ route('admin.distributor.orders.view') }}"><i class="fa fa-dashboard"></i>Distributor Order</a></li>
        <li class="active">Inward Transaction</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body table-responsive no-padding">
                    <table class="table orderTable table-striped table-hover tableVaglignMiddle">
                        <thead>
                            <tr>
                                <th>Order No</th>
                                <th>Order Date</th>
                                <th>GRN No.</th>
                                <th>GRN Date</th>
                                <th>Total Qty</th>
                                <th>Total Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($inwardTransaction) >0 )
                            @foreach($inwardTransaction as $inwardTransactionData)
                            <tr>
                                <td>{{$inwardTransactionData->id}}</td>
                                <td>{{ date('d-M-Y',strtotime($inwardTransactionData->created_at)) }}</td>
                                <td>{{ $inwardTransactionData->grn_number }}</td>
                                <td>{{ date('d-M-Y',strtotime($inwardTransactionData->grn_date))}}</td>
                                <td>{{ $inwardTransactionData->received_qty }}</td>
                                <td>{{ $inwardTransactionData->total_price }}</td>
                            </tr>
                            @endforeach
                            @else
                            <tr><td colspan=14> No Record Found.</td></tr>
                            @endif
                        </tbody>
                    </table>
                   
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
</section>
@stop