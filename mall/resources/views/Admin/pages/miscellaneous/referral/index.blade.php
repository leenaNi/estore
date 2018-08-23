@extends('Admin.layouts.default')
@section('content')


<section class="content-header">
    <h1>
        Referral Program 
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Referral Program </li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
              <div class="box">
                 @if(!empty(Session::get('msg')))
                <div class="alert {{(Session::get('aletC')== 1)?'alert-success':'alert-danger'}}" role="alert">
                    {{Session::get('msg')}}
                </div>
                  @endif
                    @if(!empty(Session::get('message')))
                <div class="alert {{(Session::get('aletC')== 1)?'alert-success':'alert-danger'}}" role="alert">
                    {{Session::get('message')}}
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
                            <?php //dd($settings);  ?>
                            <tr> 
                                <td>{{$set->name }}</td>
                                 <td>@if($set->status == '1') 
                                    <a href="{!! route('admin.generalSetting.changeStatus',['id'=>$set->id])!!}" class="" ui-toggle-class="" onclick="return confirm('Are you sure you want to disable this record?')" data-toggle="tooltip" title="Enabled"><i class="fa fa-check btn-plen btn"></i></a>
                                    @elseif($set->status == '0')
                                    <a href="{!! route('admin.generalSetting.changeStatus',['id'=>$set->id])!!}" class="" ui-toggle-class="" onclick="return confirm('Are you sure you want to enable this record?')" data-toggle="tooltip" title="Disabled"><i class="fa fa-times btn-plen btn"></i></a>
                                    @endif</td>
                                </td>


                                

                                <td>
                                    <a href="{!! route('admin.referralProgram.editReferral',['id'=>$set->id]) !!}" data-toggle="tooltip" title="Configure" ui-toggle-class=""><i class="fa fa-cog btnNo-margn-padd" aria-hidden="true"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">

                   

                </div>
            </div><!-- /.box -->
        </div><!-- /.col -->

    </div> 
</section>

@stop

