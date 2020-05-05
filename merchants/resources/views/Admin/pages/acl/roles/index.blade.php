@extends('Admin.layouts.default')
@section('content')
<section class="content-header">
    <h1>
        Roles
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Roles</li>
    </ol>
</section>

<section class="main-content">
    <div class="notification-column">
        @if(!empty(Session::get('msg')))
        <div  class="alert alert-danger" role="alert">
            {{ Session::get('msg') }}
        </div>
        @endif
        @if(!empty(Session::get('message')))
        <div  class="alert alert-success" role="alert">
            {{ Session::get('message') }}
        </div>
        @endif
    </div> 
    <div class="grid-content">
        <div class="section-main-heading">
            <h1 class="lineHeight-30" style="min-width: 300px;">Roles
            <span>
            <a href="{!! route('admin.roles.add') !!}" class="btn btn-listing-heading pull-right noAll-margin" target="_" type="button">Add New Role</a></span></h1>
        </div>
        <div class="listing-section">
            <table class="table table-striped table-hover tableVaglignMiddle">
                        <thead>
                            <tr>
                                <th class="text-left">Role</th>
                                <th class="text-left">Slug</th>
                                <th class="text-left">Description</th>
                                <th class="text-right">Created On</th>
                                <th class="text-center mn-w100">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $role)
                            <tr>
                                <td class="text-left">{{ $role->display_name }}</td>
                                <td class="text-left">{{ $role->name }}</td>
                                <td class="text-left" style="width: 300px">{{ $role->description }}</td>
                                <td class="text-right">{{ date('d-M-Y',strtotime($role->created_at)) }}</td>
                                <td class="text-center mn-w100">
                                    <div class="actionCenter">
                                        <span><a class="btn-action-default" href="{{ route('admin.roles.edit',['id' => $role->id ])  }}"><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'pencil.svg'}}"></a></span> 
                                        <span class="dropdown">
                                            <button class="btn-actions dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <img src="{{ Config('constants.adminImgangePath') }}/icons/{{'more.svg'}}">
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton"> 
                                                <li><a href="{{ route('admin.roles.delete',['id' => $role->id ])  }}"><i class="fa fa-trash "></i> Delete</a></li>
                                            </ul>
                                        </span>  
                                    </div> 
                                </td>

                            </tr>
                            @endforeach
                    </tbody>
            </table> 
            <?= $roles->render() ?>  
        </div>
    </div>
</section>
<div class="clearfix"></div>

@stop 