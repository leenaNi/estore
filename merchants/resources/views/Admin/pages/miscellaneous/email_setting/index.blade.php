@extends('Admin.layouts.default')
@section('content')

<section class="content-header">
    <h1>
        Email Settings 
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Email Settings</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">

                @if(!empty(Session::get('message')))
                <div class="alert alert-danger" role="alert ">
                    {{ Session::get('message') }}
                </div>
                @endif
                @if(!empty(Session::get('msg')))
                <div class="alert alert-success" role="alert ">
                    {{ Session::get('msg') }}
                </div>
                @endif

                <div class="box-body table-responsive no-padding">
                    <table class="table table-striped table-hover tableVaglignMiddle">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Status</th>
                                <th class="text-center mn-w100">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                           
                            @foreach($settings as $set)
                            <tr> 
                                <td>{{$set->name }}</td>
                                <td>
                                <?php
if ($set->status == 1) {
    $statusLabel = 'Active';
    $linkLabel = 'Mark as Inactive';
} else {
    $statusLabel = 'Inactive';
    $linkLabel = 'Mark as Active';
}
?>
<span class="alertSuccess">{{$statusLabel}}</span>
                                    <?php // if($set->status == 1){ ?>
                                    <!-- <a href="{!! route('admin.emailSetting.status',['url_key'=>$set->url_key]) !!}" class="" ui-toggle-class=""  data-toggle="tooltip" title="Enabled"  onclick="return confirm('Are you sure you want to disable this email setting?')" >
                                    <i class="fa fa-check btn btn-plen" ></i>
                                    </a> -->
                                    <?php // } else { ?>
                                    <!-- <a href="{!! route('admin.emailSetting.status',['url_key'=>$set->url_key]) !!}" class="" ui-toggle-class="" data-toggle="tooltip" title="Disabled" onclick="return confirm('Are you sure you want to enable this email setting?')" >
                                    <i class="fa fa-times btn btn-plen" ></i>
                                    </a> -->
                                    <?php // } ?>
                                </td>
                                <td class="text-center mn-w100">                                    
                                    <!-- <a href="{!! route('admin.emailSetting.edit',['url_key'=>$set->url_key]) !!}" data-toggle="tooltip" title="Configure" ui-toggle-class=""><i class="fa fa-cog" aria-hidden="true"></i></a> -->

                                    <div class="actionCenter">
                                    <span>
                                    <a class="btn-action-default" href="{!! route('admin.emailSetting.edit',['url_key'=>$set->url_key]) !!}" ><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'pencil.svg'}}"></a>
                                    </span>
                                    <span class="dropdown">
                                        <button class="btn-actions dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <img src="{{ Config('constants.adminImgangePath') }}/icons/{{'more.svg'}}">
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                            @if($set->status==1)
                                            <li><a href="{!! route('admin.emailSetting.status',['url_key'=>$set->url_key]) !!}" onclick="return confirm('Are you sure you want to disable this email setting?')"><i class="fa fa-check"></i> {{$linkLabel}}</a></li>
                                            @elseif($set->status==0)
                                            <li><a href="{!! route('admin.emailSetting.status',['url_key'=>$set->url_key]) !!}" onclick="return confirm('Are you sure you want to enable this email setting?')"><i class="fa fa-check"></i> {{$linkLabel}}</a></li>
                                            @endif
                                        </ul>
                                    </span>
                                </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
               
                    {{$settings->links() }}
                   
                </div>
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div> 
</section>
@stop
