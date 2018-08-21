@extends('Admin.Layouts.default')

@section('contents')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Add/Edit

    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.bankusers.roles.view') }}"><i class="fa fa-dashboard"></i>Roles</a></li>
        <li class="active">Add/Edit</li>
    </ol>
</section>
<section class="content">
    <div class="row">


        <div class="col-xs-12">
            <div class="box pt50">

                <div class="box-body">
                    {!! Form::model($role, ['method' => 'post', 'route' => 'admin.bankusers.roles.saveUpdate' , 'class' => 'form-horizontal','id'=>'roleFormB']) !!}
                    <div class="form-group">
                        {!!Form::label('Role','Role',['class'=>'col-sm-2 ']) !!}
                        <div class="col-sm-6 col-xs-12">
                            {!! Form::text('display_name',null, ["class"=>'form-control' ,"placeholder"=>'Role Display Name', "required"]) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!!Form::label('Unique Identifier','Unique Identifier',['class'=>'col-sm-2 ']) !!}
                        <div class="col-sm-6 col-xs-12">
                            {!! Form::text('name',null, ["class"=>'form-control' ,"placeholder"=>'Unique Identifier']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!!Form::label('Description','Description',['class'=>'col-sm-2 ']) !!}
                        <div class="col-sm-6 col-xs-12">
                            {!! Form::text('description',null, ["class"=>'form-control' ,"placeholder"=>'Description']) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        {!!Form::label('Allocate Permissions','Allocate Permissions',['class'=>'col-sm-2 ']) !!}
                        <div class="col-sm-6 col-xs-12">
                            <div class="col-sm-12 col-xs-12 col-md-12">
                                <label for="perm" class=""><input type="checkbox"  id="perm" name="chkAll"> Grant Complete Access</label>
                            </div>
                            @foreach($permissions as $perm)
                            <div class="col-sm-3 col-xs-3 col-md-3">
                                <label for="perm{{ $perm->id }}" class=""><input type="checkbox" {{ in_array($perm->id, array_flatten($role->perms()->get(['id'])->toArray())) ? 'checked' : ''  }}  value="{{ $perm->id }}" id="perm{{ $perm->id }}" name="chk[]"> {{ $perm->display_name }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                </div>
                <div class="box-footer">
                    <div class="row">
                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                {!! Form::hidden('id',null) !!}
                                {!! Form::submit('Submit',["class" => "btn btn-primary"]) !!}
                            </div>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}  
            </div>
        </div>

    </div>
</section>
<!-- /.content -->

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
      $("#roleFormB").validate({
        // Specify the validation rules
        rules: {
            display_name: {
                required: true

            },
            description: {
                required: true

            },
            name: {
                required: true

            }
        },
        messages: {
            display_name: {
                required: "Display name is required"

            },
            description: {
                required: "Description is required"
            },
            name: {
                required: "Role name is required"
            }
        },
        errorPlacement: function (error, element) {
            var name = $(element).attr("name");
            var errorDiv = $(element).parent();
            errorDiv.append(error);
            //  error.appendTo($("#" + name + "_login_validate"));
        }

    });
</script>
@stop