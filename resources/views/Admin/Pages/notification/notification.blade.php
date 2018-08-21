@extends('Admin.Layouts.default')

@section('contents')
<section class="content-header">
    <h1>
       Sent Notification
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active"> Sent Notification</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div>
           
        </div>
        <div class="col-sm-12">
            <div class="panel">
                <div class="panel-body">
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
                    <div class="adv-table editable-table ">
                        <div class="clearfix">
<!--                            <div class="btn-group col-md-6">
                                <form action="{{ route("admin.notification.view") }}" method="get" >
                                    <input type="text" value="{{ !empty(Input::get('search')) ? Input::get('search') : '' }}" name="search" aria-controls="editable-sample" class="form-control medium" placeholder="Search Flag name"/>
                                </form> 
                            </div>-->
                            <div class="btn-group pull-right">
                                <button id="editable-sample_new" class="btn btn-primary" onclick="window.location.href ='{{ route('admin.notification.addNew')}}'">
                                   Send New Notification
                                </button>
                            </div>
                        </div>
                        <div class="space15"></div>
                        <br />
                        <div class="clearfix"></div>
                        <div class="dividerhr"></div>
                        <table class="table rttable table-hover general-table tableVaglignMiddle">
                            <thead>
                                <tr>
                                    <th>Sr No</th>
                                    <th>Success </th>
                                    <th>Failure</th>
                                    <th>Title</th>
                                    <th>Message</th>
<!--                                    <th>Users</th>-->
                                    <th>Resend</th>
                                 
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($notifications) >0 )
                                @foreach($notifications as $slot)

                                <tr>
                                    <td>{{ $slot->id }}</td>
                                    <td>{{ $slot->success }}</td>
                                    <td>{{ $slot->failure }}</td>
                                    <td>{{ $slot->title }}</td>
                                    <td>{{ $slot->message }}</td>
                                  
                             
                                    <td>
                                        <a href="{!! route('admin.notification.resend', ['id' => $slot->id]) !!}" onclick="return confirm('Are you sure you want to Resend this notification again?')"  class='btn btn-primary'>Resend</a>
                                   
                                    </td>
                                   
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                        <div class="pull-right">
                            <?php
                            $args = [];
                            !empty(Input::get("search")) ? $args["search"] = Input::get("search") : '';
                            !empty(Input::get("sort")) ? $args["sort"] = Input::get("sort") : '';
                            !empty(Input::get("order")) ? $args["order"] = Input::get("order") : '';
                            ?>
                            <?= $notifications->appends($args)->render() ?>
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
    $(document).ready(function () {
        $(".delete").click(function () {
            var r = confirm("Are You Sure You want to Delete this record?");
            if (r == true) {
                $(this).parent().submit();
            } else {

            }
        });
    });
</script>

@stop
