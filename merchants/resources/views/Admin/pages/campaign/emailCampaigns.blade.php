@extends('Admin.layouts.default')
@section('content') 

<section class="content-header">   
    <h1>
        Email Campaign
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Email Campaign</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                @if(!empty(Session::get('message')))
                <div class="alert alert-danger" role="alert">
                    {{ Session::get('message') }}
                </div>
                @endif
                @if(!empty(Session::get('msg')))
                <div class="alert alert-success" role="alert">
                    {{Session::get('msg')}}
                </div>
                @endif
                <div class="box-header box-tools filter-box col-md-9 col-sm-12 col-xs-12 noBorder">                
                    <form action="{{ route('admin.coupons.view') }}" method="get" >
                        <div class="form-group col-md-8 col-sm-6 col-xs-12">
                            <input type="text" name="couponSearch"  class="form-control medium pull-right " placeholder="Email Title">
                        </div>
                        <div class="form-group col-md-4 col-sm-3 col-xs-12">
                            <div class="search-resetsubmit">
                                <button type="submit" class="btn btn-primary form-control noMob-leftmargin mn-w100 noLeftMargin"> Search</button>
                                <a href="{{ route('admin.coupons.view')}}" class="medium btn btn-block  reset-btn mn-w100">Reset </a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="box-header col-md-3 col-sm-12 col-xs-12">
                    <a href="{!! route('admin.emailcampaign.addemail') !!}" class="btn btn-default pull-right mobFloatLeft mobAddnewflagBTN" type="button">Add Email Campaign</a>
                </div> 
                <div class="clearfix"></div>
                <div class="dividerhr"></div>             
                <div class="clearfix"></div>
                <div class="box-body table-responsive">
                    <table class="table table-striped table-hover tableVaglignMiddle">
                        <thead>
                            <tr>

                                <th>Title</th>
                                <th>Subject</th>
                                <th>Status</th>
                                <th class="text-center mn-w100">Action </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($EmailCampaigns) > 0) { ?>
                                @foreach ($EmailCampaigns as $email)
                                <tr>
                                    <td>{{$email->title}}</td>
                                    <td>{{$email->subject}}</td>
                                    <td>{{$email->status==2?'Draft':''}}</td>
                                    <td class="text-center mn-w100">
                                        <a href="{{route('admin.emailcampaign.editemail',['id'=>$email->id])}}" class="" ui-toggle-class="" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square-o btnNo-margn-padd"></i></a> 
                                        <a href="{!! route('admin.emailcampaign.deleteemail',['id'=>$email->id]) !!}" class="" ui-toggle-class="" onclick="return confirm('Are you sure you want to delete this email?')" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a>

                                    </td>
                                </tr>
                                @endforeach
                            <?php } else { ?>
                                <tr>
                                    <td colspan="5" class="text-center">No Record Found.</td>
                                </tr>
                            <?php } ?>      
                        </tbody>
                    </table>
                </div><!-- /.box-body -->

                <div class="box-footer clearfix">
                    <?php
                    if (empty(Input::get('couponSearch'))) {
                       // echo $messages->render();
                    }
                    ?> 

                </div>
            </div>
        </div>
    </div>
</section>

@stop 
@section('myscripts')
<script>
    $(function () {
        $("#fromdatepicker").datepicker({dateFormat: 'yy-mm-dd'});
        $("#todatepicker").datepicker({dateFormat: 'yy-mm-dd'});
    });
</script>
@stop