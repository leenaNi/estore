
@extends('Admin.layouts.default')
@section('mystyles')
<style>
    .bxmodal{
        margin: 10px 0;
        border: 1px #eee solid;
        float: left;
        width: 100%;
        padding: 15px;
    }

    .tree li{margin: 10px 0px;}

</style>

<!--<link rel="stylesheet" href="{{asset(Config('constants.fileUploadPluginPath').'css/style.css')}}">-->
<link rel="stylesheet" href="{{asset(Config('constants.fileUploadPluginPath').'css/jquery.fileupload.css')}}">

<link rel="stylesheet" href="{{asset(Config('constants.fileUploadPluginPath').'css/jquery.fileupload-ui.css')}}">

<noscript><link rel="stylesheet" href="{{asset(Config('constants.fileUploadPluginPath').'css/jquery.fileupload-noscript.css')}}"></noscript>
<noscript><link rel="stylesheet" href="{{asset(Config('constants.fileUploadPluginPath').'css/jquery.fileupload-ui-noscript.css')}}"></noscript> 

@stop
@section('content')
<section class="content-header">
    <h1>
        Emails & Groups
    </h1>
    <!--    <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Categories</li>
        </ol>-->
</section>

<section class="content">
    <div class="nav-tabs-custom"> 
        <ul class="nav nav-tabs" role="tablist">
            <li class="{{ in_array(Route::currentRouteName(),['admin.marketing.emails']) ? 'active' : '' }}"><a href="{!! route('admin.marketing.emails') !!}"  aria-expanded="false">Emails</a></li>
            <li class="{{ in_array(Route::currentRouteName(),['admin.marketing.groups']) ? 'active' : '' }}"><a href="{!! route('admin.marketing.groups') !!}"  aria-expanded="false">Groups</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pan-active" id="activity">
                <div>
                    <p style="color: red;text-align: center;">{{ Session::get('messege') }} </p>
                </div>
                <div class="col-md-12">
                    <a class="btn btn-default pull-right" href="{{route('admin.marketing.addGroup')}}" >Add New Group</a>
                </div>
                <div class="clearfix"></div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box">
                                <div class="row">
                                    <div class="col-md-12">                                        
                                        @if(!empty(Session::get('message')))
                                        <div  class="alert alert-danger" role="alert">
                                            {{ Session::get('message') }}
                                        </div>
                                        @endif
                                        @if(!empty(Session::get('msg')))
                                        <div  class="alert alert-success" role="alert">
                                            {{ Session::get('msg') }}
                                        </div>
                                        @endif
                                        <div class="box-body table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead>
                                                    <tr>
                        <!--                                <th>Coupon ID</th>-->
                                                        <th>Sr.</th>
                                                        <th>Email ID</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($customers as $key => $cust)
                                                    <tr>
                                                        <td>{{$customers->firstItem() + $key}}</td>
                                                        <td>{{$cust->email}}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>

                                            </table>
                                        </div>
                                        <div class="box-footer clearfix">
                                            <?php
                                            echo $customers->render();
                                            ?>
                                        </div>
                                    </div><!-- /.col -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
</section>
@stop
@section('myscripts')
<script>
    $(".bulkuploadprod").click(function () {
        $(".template-download").hide();
        $("#bulkCategory").modal("show");
    });

    $(".catSearcH").keyup(function () {
        searchString = $(this).val();
        $(".catTrEE").find("li").each(function () {
            str = $(this).text();
            if (str.toLowerCase().indexOf(searchString) >= 0) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

    $(".delCat").click(function () {
        var nid = $(this).attr('data-nid');
        var chkdel = confirm('Are you sure want to delete this categoy?');
        if (chkdel === true)
        {
            $.ajax({
                type: "POST",
                url: "{{route('admin.category.delete')}}",
                data: {id: nid},
                cache: false,
                success: function (data) {
                    // window.location.assign("{{route('admin.category.view')}}");
                }
            });
        }
    });
</script>
@stop