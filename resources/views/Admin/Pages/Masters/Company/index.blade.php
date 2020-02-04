@extends('Admin.Layouts.default')

@section('contents')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Company</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Company</li>
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
                                {{ Form::text('s_company',!empty(Input::get('s_company'))?Input::get('s_company'):null,['class'=>'form-control','placeholder'=>'Search Company']) }}
                            </div>
                            <div class="col-md-1">
                                <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Search</button>
                            </div>
                            {{ Form::close() }}
                            </div>
                        </div> 
                        <div class="col-md-2 text-right"> 
                            {!! Form::open(['route'=>'admin.masters.company.addEdit','method'=>'post']) !!}
                            {!! Form::submit('Add New Company',['class'=>'btn btn-info']) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table class="table table-hover">
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Contact Person Name</th>
                            <th>Contact Person Nunber</th>
                            <th>Action</th>
                        </tr>
                        <?php 
                        $i = 0;
                        ?>
                        @if(!empty($companyResult))
                            @foreach($companyResult as $companyData)
                            <?php
                            $i++;
                            ?>
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $companyData->name }}</td>
                                <td>{{ empty($companyData->contact_person_name)?'-':$companyData->contact_person_name }}</td>
                                <td>{{ empty($companyData->contact_person_number)?'-':$companyData->contact_person_number }}</td>
                                <td>
                                    <a href="{{ route('admin.masters.company.addEdit') }}?id={{$companyData->id}}" class="btn btn-success btn-xs">Edit</a>
                                </td>
                            </tr>
                            
                            @endforeach
                        @else
                            <div>No records found!</div>
                        @endif
                    </table>
                    @if(!empty($companyResult))
                    <?php
                    $arguments = [];
                    !empty(Input::get('s_company')) ? $arguments['s_company'] = Input::get('s_company') : '';
                    ?>
                    <div class="pull-right">
                        {{ $companyResult->appends($arguments)->links() }}
                    </div>
                    @endif
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
</section>
<!-- /.content -->
@stop