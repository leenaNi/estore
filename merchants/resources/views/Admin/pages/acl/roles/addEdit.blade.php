@extends('Admin.layouts.default')
@section('content')

<section class="content-header">
    <h1>
    Roles
        <small>Add/Edit</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class=""><a href="{{route('admin.roles.view')}}" >Roles </a></li>
        <li class="active">Add/Edit</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
        {!! Form::model($role, ['method' => 'post', 'route' => $action ]) !!}
        <div class="col-md-6">
            <div class="form-group">
            {!!Form::label('Role','Role ') !!}<span class="red-astrik"> *</span>
                {!! Form::text('display_name',null, ["class"=>'form-control validate[required]' ,"placeholder"=>'Role']) !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {!!Form::label('Unique Identifier','Unique Identifier ') !!}<span class="red-astrik"> *</span>
                {!! Form::text('name',null, ["class"=>'form-control validate[required]' ,"placeholder"=>'Unique Identifier']) !!}
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {!!Form::label('Description','Description') !!}
                {!! Form::text('description',null, ["class"=>'form-control' ,"placeholder"=>'Description']) !!}
            </div>
        </div>
        <div class="line line-dashed b-b line-lg pull-in"></div>
        <div class="form-group">
            {!!Form::label('Allocate Permissions','Allocate Permissions',['class'=>'col-sm-2 ']) !!}
            <div class="col-sm-12">
                <div class="col-sm-12 col-xs-12 col-md-12">
                    <label for="perm" class=""><input type="checkbox"  id="perm" name="chkAll"> Grant Complete Access</label>
                </div>
                @foreach($sections as $section)
                <div class="panel panel-default">
                 <div class="panel-heading">
                    <label for="sec{{ $section->id }}" class=""><input type="checkbox" value="{{ $section->id }}" id="sec{{ $section->id }}" name="section[]"> {{ $section->name }}</label>
                </div>
                <div class="panel-body">
                 @foreach($section->permissions as $perm)
                <!-- <div class="col-sm-3 col-xs-3 col-md-3"> -->
                    <label for="perm{{ $perm->id }}" ><input type="checkbox" {{ in_array($perm->id, $role->perms()->pluck('id')->toArray()) ? 'checked' : ''  }}  value="{{ $perm->id }}" id="perm{{ $perm->id }}" name="chk[]" > {{ $perm->display_name }}</label>
                <!-- </div> -->
                @endforeach
                </div>
                </div>
                @endforeach
            
        </div>
        <div class="line line-dashed b-b line-lg pull-in"></div>
        <div class="form-group">
            <div class="col-sm-12">
                {!! Form::hidden('id',null) !!}
                {!! Form::submit('Submit',["class" => "btn btn-primary pull-right marginTop20"]) !!}
            </div>
        </div>
        {!! Form::close() !!}  
    </div>
</div>
</div>
</div>
        </div>
</section>

@stop 

@section('myscripts')

<script>
   
        $("[name='chkAll']").click(function (event) {
            var checkbox = $(this);
            var isChecked = checkbox.is(':checked');
            if (isChecked) {
                $("[name='chk[]']").attr('Checked', 'Checked');
            } else {
                $("[name='chk[]']").removeAttr('Checked');
            }
        });

        $("[name='section[]").click(function(e){
            var checkbox = $(this);

            var isChecked = checkbox.is(':checked');
            var sect = $(this).parent().parent().parent();
           
            if (isChecked) {
                sect.find("[name='chk[]']").attr('Checked', 'Checked');
            } else {
                sect.find("[name='chk[]']").removeAttr('Checked');
            }
        })
</script>

@stop