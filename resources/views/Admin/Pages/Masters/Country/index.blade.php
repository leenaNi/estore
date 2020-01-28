@extends('Admin.Layouts.default')

@section('contents')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1> Country</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Country</li>
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
                                {{ Form::text('s_country',!empty(Input::get('s_country'))?Input::get('s_country'):null,['class'=>'form-control','placeholder'=>'Search Country']) }}
                            </div>
                            <div class="col-md-1">
                                <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Search</button>
                            </div>
                            {{ Form::close() }}
                            </div>
                        </div> 
                        <div class="col-md-2 text-right"> 
                            {!! Form::open(['route'=>'admin.masters.country.addEdit','method'=>'post']) !!}
                            {!! Form::submit('Add New Country',['class'=>'btn btn-info']) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-hover">
                        <tr>
                            <th>Id</th>
                            <th>Country</th>
                            <th>Country Code</th>
                            <th>ISO Cod 2</th>
                            <th>ISO Cod 3</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        <?php 
                        $i = 0;
                        ?>
                        @foreach($countries as $countryData)
                        <?php
                        $i++;
                        ?>
                        <tr>
                            <td>{{ $i }}</td>
                            <td>{{ $countryData->name }}</td>
                            <td>{{ empty($countryData->country_code)?'-':$countryData->country_code }}</td>
                            <td>{{ empty($countryData->iso_code_2)?'-':$countryData->iso_code_2 }}</td>
                            <td>{{ empty($countryData->iso_code_3)?'-':$countryData->iso_code_3 }}</td>
                            <td class="catS">{{ ($countryData->status == 1)?'Enabled':'Disabled' }}</td>
                            <td>
                                <a href="{{ route('admin.masters.country.addEdit') }}?id={{$countryData->id}}" class="btn btn-success btn-xs">Edit</a>
        
                                <a href="{{ route('admin.masters.country.changeStatus') }}?id={{$countryData->id}}&status={{$countryData->status}}" class="btn btn-warning btn-xs changeStatus" data-id="{{$countryData->id }}" data-status="{{$countryData->status }}" title="{{ ($countryData->status == 1)?'Disable':'Enable'}}" >{{ ($countryData->status == 1)?'Disabled':'Enabled' }}</a>
                            </td>
                        </tr>
                        
                        @endforeach
                    </table>
                    <?php
                    $arguments = [];
                    !empty(Input::get('s_country')) ? $arguments['s_country'] = Input::get('s_country') : '';
                    ?>
                    <div class="pull-right">
                        {{ $countries->appends($arguments)->links() }}
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