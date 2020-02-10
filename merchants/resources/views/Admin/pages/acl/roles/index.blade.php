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
    <div class="grid-content">
        <div class="section-main-heading">
            <h1>Roles</h1>
        </div>
        <div class="filter-section">
            <div class="col-md-9 noAll-padding">
                <div class="filter-left-section min-height100">
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
            </div>
            <div class="col-md-3 noAll-padding ">
                <div class="filter-right-section  min-height100">
                    <div class="clearfix">
                        <a href="{!! route('admin.roles.add') !!}" class="btn btn-default pull-right col-md-12" target="_" type="button">Add New Role</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="grid-content">
        
        <div class="listing-section">
            <table class="table table-striped table-hover tableVaglignMiddle">
                        <thead>
                            <tr>
                                <th>Role</th>
                                <th>Slug</th>
                                <th>Description</th>
                                <th>Created On</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $role)
                            <tr>
                                <td>{{ $role->display_name }}</td>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->description }}</td>
                                <td>{{ date('d-M-Y',strtotime($role->created_at)) }}</td>
                                <td style="width:150px;">
                                    <div class="actionLeft">
                                        <span><a class="btn-action-default" href="{{ route('admin.roles.edit',['id' => $role->id ])  }}">Edit</a></span> 
                                        <span class="dropdown">
                                            <button class="btn-actions dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span class="caret"></span>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton"> 
                                                <li><a href="{{ route('admin.roles.delete',['id' => $role->id ])  }}"><i class="fa fa-trash "></i> Delete</a></li>
                                            </div>
                                        </span>  
                                    </div>
                                    <!-- <a href="" target="_" class="" data-toggle="tooltip" title="Edit" ui-toggle-class=""><i class="fa fa-pencil-square-o btn-plen btn"></i></a>
                                    <a href="" target="_" class="" onclick="return confirm('Are you sure you want to delete this role?')" ui-toggle-class="" data-toggle="tooltip" title="Delete"><i class="fa fa-trash btn-plen btn"></i></a> -->
                                </td>

                            </tr>
                            @endforeach
                    </tbody>
            </table>
            <div class="box-footer clearfix">
                    <?= $roles->render() ?> 
            </div>
        </div>
    </div>
</section>


@stop 