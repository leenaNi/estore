<?php

//echo "<pre>";

//print_r(json_decode($return));
//echo "</pre>";
?>
@extends('Admin.layouts.default')
@section('content')


<section class="content-header">
    <h1>
        Return Policy

    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Return Policy</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                 @if(!empty(Session::get('msg')))
                <div class="alert {{(Session::get('aletC')== 1)?'alert-success':'alert-danger'}}" role="alert">
                    {{Session::get('msg')}}
                </div>
                  @endif
                <div class="box-body table-responsive no-padding">
                    <table class="table table-striped table-hover tableVaglignMiddle">
                        <thead>
                            <tr>
<!--                               <th>Sr.</th>-->
                                <th>Name</th>
                                <th>Status</th>
                                <th>Days</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($return as $set)
                            <tr> 
<!--                                <td>{{ $set->id }}</td>-->
                                <td>{{$set->name }}</td>

                                <td>
                                 @if($set->status == 1)
                            <a href="{!!route('admin.returnPolicy.changeStatus',['id'=>$set->id]) !!}" class="" ui-toggle-class="" onclick="return confirm('Are you sure you want to disable this policy?')" data-toggle="tooltip" title="Enabled"><i class="fa fa-check btn-plen btn"></i></a>
                            @elseif($set->status == 0)
                            <a href="{!!route('admin.returnPolicy.changeStatus',['id'=>$set->id]) !!}" class="" ui-toggle-class="" onclick="return confirm('Are you sure you want to enable this policy?')" data-toggle="tooltip" title="Disabled"><i class="fa fa-times btn-plen btn"></i></a>
                            @endif</td>
                                 <td>{{ $set->details }}</td>
                                <td>
                                    <a href="{!! route('admin.returnPolicy.edit',['id'=>$set->id]) !!}" data-toggle="tooltip" title="Configure" ui-toggle-class=""><i class="fa fa-cog btnNo-margn-padd" aria-hidden="true"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
              
            </div><!-- /.box -->
        </div><!-- /.col -->

    </div> 
</section>

@stop

