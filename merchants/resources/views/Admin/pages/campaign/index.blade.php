@extends('Admin.layouts.default')
@section('content') 

<section class="content-header">   
    <h1>
        SMS Campaign
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">SMS Campaign</li>
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
                    <form action="{{ route('admin.campaign.view') }}" method="get" >
                        <div class="form-group col-md-8 col-sm-6 col-xs-12">
                            <input type="text" name="smsSearch"  class="form-control medium pull-right " placeholder="Message Title">
                        </div>
                        <a href="{{ route('admin.campaign.view')}}">
                        <button type="button" class="btn reset-btn noMob-leftmargin pull-right" value="reset">Reset
                        </button>
                        </a>  
                        <button type="submit" name="search" class="btn btn-primary noAll-margin pull-right marginRight-lg" value="Search"> Filter
                        </button>  
                        
                    </form>
                </div>
                <div class="box-header col-md-3 col-sm-12 col-xs-12">
                    <a href="{!! route('admin.campaign.add') !!}" class="btn btn-default pull-right mobFloatLeft mobAddnewflagBTN" type="button">Add SMS Campaign</a>
                </div> 
                <div class="clearfix"></div>
                <div class="dividerhr"></div>             
                <div class="clearfix"></div>
                <div class="box-body table-responsive">
                    <table class="table table-striped table-hover tableVaglignMiddle">
                        <thead>
                            <tr>

                                <th>Message Title</th>
                                <th>Message Content</th>
                                <th>Status</th>
                                <th>Action </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($messages) > 0) { ?>
                                @foreach ($messages as $message)
                                <tr>
                                    <td>{{$message->title}}</td>
                                    <td>{{$message->content}}</td>
                                    <td>{{$message->status==2?'Draft':''}}</td>
                                    <td>
                                        <a href="{{route('admin.campaign.edit',['id'=>$message->id])}}" class="" ui-toggle-class="" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square-o btnNo-margn-padd"></i></a> 
                                        <a href="{!! route('admin.campaign.delete',['id'=>$message->id]) !!}" class="" ui-toggle-class="" onclick="return confirm('Are you sure you want to delete this message?')" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a>

                                    </td>
                                </tr>
                                @endforeach
                            <?php } else { ?>
                                <tr>
                                    <td colspan="5">No Record Found.</td>
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