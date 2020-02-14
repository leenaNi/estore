@extends('Admin.Layouts.default')

@section('contents')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>Brand</h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Brands</li>
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
                                {{ Form::text('s_brand',!empty(Input::get('s_brand'))?Input::get('s_brand'):null,['class'=>'form-control','placeholder'=>'Search Brand']) }}
                            </div>
                            <div class="col-md-3">
                                <select id="company_id" name="company_id" class="form-control">
                                    @foreach($companyList as $companyId=>$companyName)
                                    <option value="{{$companyId}}">{{$companyName}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select id="industry_id" name="industry_id" class="form-control">
                                    @foreach($industryList as $catId=>$catName)
                                        <option value="{{$catId}}">{{$catName}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-1">
                                <button type="submit" class="btn btn-success"><i class="fa fa-search"></i> Search</button>
                            </div>
                            {{ Form::close() }}
                            </div>
                        </div> 
                        <div class="col-md-2 text-right"> 
                            {!! Form::open(['route'=>'admin.masters.brand.addEdit','method'=>'post']) !!}
                            {!! Form::submit('Add New Brand',['class'=>'btn btn-info']) !!}
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
                            <th>Company Name</th>
                            <th>Industry Name</th>
                            <th>Action</th>
                        </tr>
                        <?php 
                        $i = 0;
                        ?>
                        @if(!empty($brandResult))
                            @foreach($brandResult as $brandData)
                            <?php
                            $i++;
                            ?>
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $brandData->name }}</td>
                                <td>{{ empty($brandData->compnay_name)?'-':$brandData->compnay_name }}</td>
                                <td>{{ empty($brandData->industry_name)?'-':$brandData->industry_name }}</td>
                                <td>
                                    <a href="{{ route('admin.masters.brand.addEdit') }}?id={{$brandData->id}}" class="btn btn-success btn-xs">Edit</a>
                                    <a href="{{ route('admin.masters.brand.deleteBrand') }}?id={{$brandData->id}}" class="btn btn-success btn-xs">Delete</a>
                                </td>
                            </tr>
                            
                            @endforeach
                        @else
                            <div>No records found!</div>
                        @endif
                    </table>
                    @if(!empty($brandResult))
                    <?php
                    $arguments = [];
                    !empty(Input::get('s_brand')) ? $arguments['s_brand'] = Input::get('s_brand') : '';
                    !empty(Input::get('company_id')) ? $arguments['company_id'] = Input::get('company_id') : '';
                    !empty(Input::get('industry_id')) ? $arguments['industry_id'] = Input::get('industry_id') : '';
                    ?>
                    <div class="pull-right">
                        {{ $brandResult->appends($arguments)->links() }}
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