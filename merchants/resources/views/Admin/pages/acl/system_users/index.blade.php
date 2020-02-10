@extends('Admin.layouts.default')
@section('content')
<section class="content-header">
    <h1>
        System Users ({{$userCount }})
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">System Users</li>
    </ol>
</section>

<section class="main-content">
    <div class="grid-content">
        <div class="section-main-heading">
            <h1>System Users</h1>
        </div>
        <div class="filter-section">
            <div class="col-md-9 noAll-padding">
                <div class="filter-left-section min-height150">
                    @if(!empty(Session::get('msg')))
                    <div  class="alert alert-success" role="alert">
                        {{ Session::get('msg') }}
                    </div>
                    @endif
                    @if(!empty(Session::get('message')))
                    <div  class="alert alert-danger" role="alert">
                        {{ Session::get('message') }}
                    </div>
                    @endif

                    <form action="{{ route('admin.systemusers.view') }}" method="get" >
                        <div class="form-group col-md-8 col-sm-6 col-xs-12">
                            <input type="text" name="empSearch" value="{{ !empty(Input::get('empSearch')) ? Input::get('empSearch') : '' }}" class="form-control medium pull-right catSearcH" placeholder="Search User">
                        </div>
                        <div class="form-group col-md-2 col-sm-3 col-xs-12">
                            <input type="submit" name="submit" value="Search" class="form-control btn btn-primary noMob-leftmargin">
                        </div>
                        <div class='form-group col-md-2 col-sm-3 col-xs-12'>
                            <a href="{{route('admin.systemusers.view')}}" class='form-control btn reset-btn noMob-leftmargin'>Reset </a>
                        </div>
                    </form>   
                </div>
            </div>

            <div class="col-md-3 noAll-padding ">
                <div class="filter-right-section  min-height150">
                    <div class="clearfix">
                        <a href="{!! route('admin.systemusers.add') !!}" class="btn btn-default pull-right col-md-12 mobAddnewflagBTN marginBottom15" target="_" type="button">Add New User</a>
                        <div class="clearfix"></div>
                        <a href="{!! route('admin.systemusers.export') !!}" class="btn btn-default pull-right col-md-12 mobAddnewflagBTN" target="_" type="button">Export</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="grid-content">
        <div class="section-main-heading">
            <h1>System Users<span class="listing-counter"> ({{$userCount }})</span> </h1>
        </div>
        <div class="listing-section">
            <table class="table table-striped table-hover tableVaglignMiddle">
                        <thead>
                            <tr>
                            <!--<th>id</th>-->
                                <th>System User</th>

                                <th>Email Id</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($system_users) >0 )
                            @foreach($system_users as $system_user)
                        <!--<tr> <td>{{$system_user->id }}</td>-->
                        <td>{{$system_user->firstname }} {{$system_user->lastname }}</td>

                        <td>{{ $system_user->email }}</td>
                        <td>{{ date("d-M-Y",strtotime($system_user->created_at)) }}</td>
                        <td>
                            @if($system_user->status==1)
                            <a href="{!! route('admin.systemusers.changeStatus',['id'=>$system_user->id]) !!}"  onclick="return confirm('Are you sure you want to disable this user?')" data-toggle='tooltip' title='Enabled' ><i class="fa fa-check btn-plen btn"></i></a>
                            @elseif($system_user->status==0)
                            <a href="{!! route('admin.systemusers.changeStatus',['id'=>$system_user->id]) !!}"  onclick="return confirm('Are you sure you want to enable this user?')" data-toggle="tooltip" title="Disabled"> <i class="fa fa-times btn-plen btn"></i></a>
                            @endif


                        <td>
                        @if($system_user->id!=1)
                                    <div class="actionLeft">
                                        <span><a class="btn-action-default" href="{!! route('admin.systemusers.edit',['id'=>$system_user->id]) !!}">Edit</a></span> 
                                        <span class="dropdown">
                                            <button class="btn-actions dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="caret"></span>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton"> 
                                                <li><a href="{!! route('admin.systemusers.delete',['id'=>$system_user->id]) !!}"><i class="fa fa-trash "></i> Delete</a></li>
                                            </div>
                                        </span>  
                                    </div>
                                    @endif
                        <!-- @if($system_user->id!=1)
                            <a href="{!! route('admin.systemusers.edit',['id'=>$system_user->id]) !!}"  ui-toggle-class="" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square-o"></i></a>
                            <a href="{!! route('admin.systemusers.delete',['id'=>$system_user->id]) !!}" onclick="return confirm('Are you sure you want to delete this user?')"  ui-toggle-class="" data-toggle="tooltip" title="Delete"><i class="fa fa-trash btn-plen btn"></i></a>
                        @endif -->
                        </td>
                        </tr>
                        @endforeach
                        @else
                        <tr><td colspan=5> No Record Found.</td></tr>
                        @endif
                        </tbody>
                    </table>
                    <div class="box-footer clearfix">
                    <?php
                    if (empty(Input::get('empSearch'))) {
                        echo $system_users->render();
                    }
                    ?> 

                </div>
        </div>
        </div>
</section>



@stop 