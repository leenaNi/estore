@extends('Admin.layouts.default')
@section('content')


<section class="content-header">
    <h1>
        Bank Details
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Bank Details </li>
    </ol>
</section>

<section class="main-content">
    <div class="notification-column">
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
    </div>
    <div class="grid-content">
        <div class="section-main-heading">
            <h1>Bank Details</h1>
        </div>
        <div class="filter-section">
            <div class="col-md-12 noAll-padding">
                <div class="listing-section"> 
                   
                    <table class="table table-striped table-hover tableVaglignMiddle">
                        <thead>
                            <tr>
                                <th class="text-left">Name</th>
                                <th class="text-center">Status</th>

                                <th class="text-center">Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bankDetail as $bank)
                            <?php //dd($settings);  ?>
                            <tr> 
                                <td class="text-left">{{$bank->name }}</td>
                                 <td class="text-center">@if($bank->status == '1') 
                                    <a href="{!! route('admin.generalSetting.changeStatus',['id'=>$bank->id])!!}" class="" ui-toggle-class="" onclick="return confirm('Are you sure you want to disable this record?')" data-toggle="tooltip" title="Enabled"><i class="fa fa-check btn-plen btn"></i></a>
                                    @elseif($bank->status == '0')
                                    <a href="{!! route('admin.generalSetting.changeStatus',['id'=>$bank->id])!!}" class="" ui-toggle-class="" onclick="return confirm('Are you sure you want to enable this record?')" data-toggle="tooltip" title="Disabled"><i class="fa fa-times btn-plen btn"></i></a>
                                    @endif</td>
                                </td>


                                

                                <td class="text-center">
                                    <div class="actionCenter">
                                        <span><a class="btn-action-default" href="{!! route('admin.bankDetails.addEdit',['id'=>$bank->id]) !!}"><i class="fa fa-cog" aria-hidden="true"></i> Configure</a></span> 
                                    
                                    </div>
                                    <!-- <a href="{!! route('admin.bankDetails.addEdit',['id'=>$bank->id]) !!}" data-toggle="tooltip" title="Configure" ui-toggle-class=""><i class="fa fa-cog btnNo-margn-padd" aria-hidden="true"></i></a> -->
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="box-footer clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</section>



@stop

