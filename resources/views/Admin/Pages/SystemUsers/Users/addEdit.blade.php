@extends('Admin.Layouts.default')

@section('contents')
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Add/Edit

    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.systemusers.users.view') }}"><i class="fa fa-dashboard"></i>Users</a></li>
        <li class="active">Add/Edit</li>
    </ol>
</section>
<section class="content">
    <div class="row">


        <div class="col-xs-12">
            <div class="box pt50">
                <div class="box-body">
                    <p style="color:red;text-align: center;">{{ Session::get('usenameError') }}</p>
                    <p style="color:red;text-align: center;">{{ Session::get('usernameErr') }}</p>

                    {!! Form::model($vuser, ['method' => 'post', 'route' => $action , 'class' => 'form-horizontal','id'=>'userFormS', 'novalidate' => 'novalidate']) !!}
                    <div class="form-group">
                        {!!Form::label('Name','Name *',['class'=>'col-sm-2 control-label']) !!}
                        {!! Form::hidden('id',null) !!}

                        <div class="col-sm-6 col-xs-12">
                            {!! Form::text('name',null, ["class"=>'form-control  validate[required]' ,"placeholder"=>'Name', "required"]) !!}
                        </div>
                    </div>

                


                    <div class="form-group">
                        {!!Form::label('Email','Email Id *',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-6 col-xs-12">
                            {!! Form::email('email',null, ["class"=>'form-control' ,"placeholder"=>'Email']) !!}
                        </div>
                    </div>

                    <?php    
                            $data_pwd =[];
                            $mandatory = '';
                            $data_pwd['class'] = 'form-control exist-merch password';
                            if(Input::get('id') == '')
                            {
                                $data_pwd['required'] = true;
                                $mandatory = '*';
                            }
                            
                        ?>
                    <div class="form-group">
                        {!!Form::label('Password',"Password $mandatory",['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-6 col-xs-12">
                        
                            {!! Form::password('password', $data_pwd) !!}
                        </div>
                    </div>





                    <div class="form-group">
                        {!!Form::label('Role','Role *',['class'=>'col-sm-2 control-label']) !!}
                        <div class="col-sm-6 col-xs-12">
                            {!! Form::select('roles',$roles_name,!empty($vuser->roles()->first()->id)?$vuser->roles()->first()->id:null,["class"=>'form-control m-b' , "required"]) !!}

                        </div>
                    </div>

                    <div class="box-footer">
                        <div class="row">
                            <div class="form-group">
                                <div class="col-sm-4 col-sm-offset-2">
                                    {!! Form::submit('Submit',["class" => "btn btn-primary SustemUserSubmit"]) !!}
                                    {!! Form::close() !!}     


                                </div>
                            </div>
                        </div>
                    </div>

                </div>


            </div>
        </div>

    </div>
</section>
<!-- /.content -->

@stop

@section('myscripts')
<script>
    
        $("#userFormS").validate({
        // Specify the validation rules
        rules: {
            name: {
                required: true
            },
            email: {
                required: true,
                email:true

            },roles:{
                required: true
            }
            
        },
        messages: {
               name: {
                required: "Name is required"

            },
            email: {
                required: "Email Id is required",
                email:"Valid Email Id is required"

            },
            password:{
                required: "Password is required",
            }, 
            roles:{
                required:"Role is required"
            }
        },
        errorPlacement: function (error, element) {
            var name = $(element).attr("name");
            var errorDiv = $(element).parent();
            errorDiv.append(error);
            //  error.appendTo($("#" + name + "_login_validate"));
        }

    });
    $("[name='chkAll']").click(function (event) {
        var checkbox = $(this);
        var isChecked = checkbox.is(':checked');
        if (isChecked) {
            $("[name='chk[]']").attr('Checked', 'Checked');
        } else {
            $("[name='chk[]']").removeAttr('Checked');
        }
    });
</script>
@stop