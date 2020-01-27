@extends('Admin.Layouts.default')

@section('contents')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1> Currency</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Currency</li>
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
                                {{ Form::text('s_currency',!empty(Input::get('s_currency'))?Input::get('s_currency'):null,['class'=>'form-control','placeholder'=>'Search Currency']) }}
                            </div>
                            <div class="col-md-1">
                                <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Search</button>
                            </div>
                            {{ Form::close() }}
                            </div>
                        </div> 
                        <div class="col-md-2 text-right"> 
                            {!! Form::open(['route'=>'admin.masters.currency.addEdit','method'=>'post']) !!}
                            {!! Form::submit('Add New Currency',['class'=>'btn btn-info']) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-hover">
                        <tr>
                            <th>Id</th>
                            <th>Currency</th>
                            <th>ISO Code</th>
                            <th>Currency Code</th>
                            <th>Currency Value</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        <?php 
                        $i = 0;
                        ?>
                        @foreach($currency as $currencyData)
                        <?php
                        $i++;
                        ?>
                        <tr>
                            <td>{{ $i }}</td>
                            <td>{{ empty($currencyData->name)?'-':$currencyData->name  }}</td>
                            <td>{{ empty($currencyData->iso_code)?'-':$currencyData->iso_code }}</td>
                            <td>{{ empty($currencyData->currency_code)?'-':$currencyData->currency_code }}</td>
                            <td>{{ empty($currencyData->currency_val)?'-':$currencyData->currency_val }}</td>
                            <td class="catS">{{ ($currencyData->status == 1)?'Enabled':'Disabled' }}</td>
                            <td>
                                <a href="{{ route('admin.masters.currency.addEdit') }}?id={{$currencyData->id}}" class="btn btn-success btn-xs">Edit</a>
                            <a href="{{ route('admin.masters.currency.changeStatus') }}?id={{$currencyData->id}}&status={{$currencyData->status}}" class="btn btn-warning btn-xs changeStatus" data-id="{{$currencyData->id }}" data-status="{{$currencyData->status }}" title="{{ ($currencyData->status == 1)?'Disable':'Enable'}}" >{{ ($currencyData->status == 1)?'Disabled':'Enabled' }}</a>
                            </td>
                        </tr>
                        
                        @endforeach
                    </table>
                    <?php
                    $arguments = [];
                    !empty(Input::get('s_currency')) ? $arguments['s_currency'] = Input::get('s_currency') : '';
                    ?>
                    <div class="pull-right">
                        {{ $currency->appends($arguments)->links() }}
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