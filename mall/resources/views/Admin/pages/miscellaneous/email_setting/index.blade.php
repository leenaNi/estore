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
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                           
                            @foreach($settings as $set)
                            <tr> 
                                <td>{{$set->name }}</td>
                                <td>
                                    <?php if($set->status == 1){ ?>
                                    <a href="{!! route('admin.emailSetting.status',['url_key'=>$set->url_key]) !!}" class="" ui-toggle-class=""  data-toggle="tooltip" title="Enabled"  onclick="return confirm('Are you sure you want to disable this email setting?')" >
                                    <i class="fa fa-check btn btn-plen" ></i>
                                    </a>
                                    <?php } else { ?>
                                    <a href="{!! route('admin.emailSetting.status',['url_key'=>$set->url_key]) !!}" class="" ui-toggle-class="" data-toggle="tooltip" title="Disabled" onclick="return confirm('Are you sure you want to enable this email setting?')" >
                                    <i class="fa fa-times btn btn-plen" ></i>
                                    </a>
                                    <?php } ?>
                                </td>
                                <td>
                                    
                                    <a href="{!! route('admin.emailSetting.edit',['url_key'=>$set->url_key]) !!}" data-toggle="tooltip" title="Configure" ui-toggle-class=""><i class="fa fa-cog" aria-hidden="true"></i></a>
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
