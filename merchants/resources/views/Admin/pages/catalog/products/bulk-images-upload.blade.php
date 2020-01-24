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



</style>

<!--<link rel="stylesheet" href="{{asset(Config('constants.fileUploadPluginPath').'css/style.css')}}">-->
<link rel="stylesheet" href="{{Config('constants.fileUploadPluginPath').'css/jquery.fileupload.css'}}">

<link rel="stylesheet" href="{{Config('constants.fileUploadPluginPath').'css/jquery.fileupload-ui.css'}}">

<noscript><link rel="stylesheet" href="{{Config('constants.fileUploadPluginPath').'css/jquery.fileupload-noscript.css'}}"></noscript>
<noscript><link rel="stylesheet" href="{{Config('constants.fileUploadPluginPath').'css/jquery.fileupload-ui-noscript.css'}}"></noscript>

@stop
@section('content')

<section class="content-header">
    <h1>
        Uploaded Images 
        <small></small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Products Image Bulk upload</li>
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
                </div>
                <div class="clearfix"></div>
                <div class="dividerhr"></div>
                <div style="clear: both"></div>
                <div class="box-body table-responsive no-padding">
                    <table class="table table-striped table-hover tableVaglignMiddle">
                        <thead>
                            <tr>
                                <th>Uploaded Image</th>
                                <th>Image Name</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(array_key_exists('files', $uploadedImages) && !empty($uploadedImages['files']))
                            @foreach($uploadedImages['files'] as $uploadedImage)
                            <tr>
                                <td>
                                    <div class="product-name vMiddle">
                                        <span>
                                            @if(!@$uploadedImage->error)
                                            <img src="{{$uploadedImage->thumbnailUrl}}" class="admin-profile-picture" />
                                            @endif
                                        </span>
                                    </div>
                                </td>
                                <td>{{$uploadedImage->name}}</td>       
                                <td>@if(@$uploadedImage->error)
                                <i class="fa fa-times btn-plen btn"></i></a><br/>{{$uploadedImage->error}}
                                @else
                                <i class="fa fa-check btn-plen btn"></i>
                                @endif
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">

                </div>
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div>
</section>
<input type="hidden" id="page_type" value="main"/>
@stop
@section('myscripts')
@stop

