@extends('Admin.layouts.default')
@section('content')


<section class="content-header">
    <h1>Emails <?php
        if($templatesCount > 0)
        {
        ?>
        ({{$startIndex}}-{{$endIndex}} of {{$templatesCount }})
        <?php
        }
        ?></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i>  Home</a></li>
        <li class="active"> Emails </li>
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
                    {{ Session::get('msg') }}
                </div>
                @endif

                <div class="box-body table-responsive no-padding">
                    <table class="table table-striped table-hover tableVaglignMiddle">
                        <thead>
                            <tr>
<!--                               <th>Sr.</th>-->
                                <th>Email Template</th>
                                <th>Status</th>

                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody>
                           
                            @foreach($templates as $template)
                            <tr> 

                                <td>{{$template->name }}</td>

                                <td>
                                <?php if($template->status == 1){ ?>
                                    <a href="{!! route('admin.email.status',['id'=>$template->id]) !!}" class="" ui-toggle-class=""  data-toggle="tooltip" title="Enabled"  onclick="return confirm('Are you sure you want to disable this email setting?')" >
                                    <i class="fa fa-check btn btn-plen" ></i>
                                    </a>
                                    <?php } else { ?>
                                    <a href="{!! route('admin.email.status',['id'=>$template->id]) !!}" class="" ui-toggle-class="" data-toggle="tooltip" title="Disabled" onclick="return confirm('Are you sure you want to enable this email setting?')" >
                                    <i class="fa fa-times btn btn-plen" ></i>
                                    </a>
                                    <?php } ?></td>

                                <td>
                                    <a href="{!! route('admin.templateSetting.edit',['id'=>$template->id]) !!}"  data-toggle="tooltip" title="Configure" ui-toggle-class=""><i class="fa fa-cog btnNo-margn-padd" aria-hidden="true"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">

                    
                   {{ $templates->links() }}
                  
                </div>
            </div><!-- /.box -->
        </div><!-- /.col -->

    </div> 
</section>

@stop

