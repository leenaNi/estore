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


<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
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
                <div class="box-header box-tools filter-box col-md-9 noBorder noMobileDisplay">
                    <div class="form-group col-md-4">

                    </div>  
                </div>
                <div class="box-header col-md-3">
                    <a href="{!! route('admin.roles.add') !!}" class="btn btn-default pull-right col-md-12" target="_" type="button">Add New Role</a>
                </div> 
                <div class="clearfix"></div>
                <div class="dividerhr"></div>        

                <div class="box-body table-responsive no-padding">
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
                                <td>
                                    <a href="{{ route('admin.roles.edit',['id' => $role->id ])  }}" target="_" class="" data-toggle="tooltip" title="Edit" ui-toggle-class=""><i class="fa fa-pencil-square-o btn-plen btn"></i></a>
                                    <a href="{{ route('admin.roles.delete',['id' => $role->id ])  }}" target="_" class="" onclick="return confirm('Are you sure you want to delete this role?')" ui-toggle-class="" data-toggle="tooltip" title="Delete"><i class="fa fa-trash btn-plen btn"></i></a>
                                </td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                    <?= $roles->render() ?> 

                </div>
            </div><!-- /.box -->
        </div><!-- /.col -->

    </div> 
</section>






@stop 