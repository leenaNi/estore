@extends('Admin.layouts.default')
@section('content')


<section class="content-header">
    <h1>
        Payment Gateway
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Payment Gateway</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">

                @if(!empty(Session::get('msg')))
                <div class="alert alert-success" role="alert">
                    {{ Session::get('msg') }}
                </div>
                @endif
                   @if(!empty(Session::get('message')))
                <div class="alert alert-danger" role="alert">
                    {{ Session::get('message') }}
                </div>
                @endif
               
                

                <div class="box-body table-responsive no-padding">
                    <table class="table table-striped table-hover tableVaglignMiddle">
                        <thead>
                            <tr>
<!--                               <th>Sr.</th>-->
                                <th>Payment Method</th>
                                <th>Status</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($settings as $set)
                            <tr> 
<!--                                <td>{{ $set->id }}</td>-->
                                <td>{{$set->name }}</td>
                               
                               <td><a href="{!! route('admin.paymentSetting.changeStatus',['url_key'=>$set->url_key]) !!}" class="appdisapp" ui-toggle-class="" onclick="return confirm('Are you sure you want to  {{ $set->status == 1 ? "disable" : "enable" }} this record?')" data-toggle="tooltip" title="{{ $set->status == 1 ? "Enabled" : "Disabled" }}">
                                    <i class="fa fa-{{ $set->status == 1 ? 'check' : 'times' }} btn btn-plen" ></i>
                                    </a></td>

                                <td>
                                    <a href="{!! route('admin.paymentSetting.edit',['url_key'=>$set->url_key]) !!}" data-toggle="tooltip" title="Configure" ui-toggle-class=""><i class="fa fa-cog btnNo-margn-padd" aria-hidden="true"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">

                    <?php
                    $settings->render();
                    ?>

                </div>
            </div><!-- /.box -->
        </div><!-- /.col -->

    </div> 
</section>

@stop

