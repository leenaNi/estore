@extends('Admin.layouts.default')
@section('content')
<link rel="stylesheet" href="{{  Config('constants.adminPlugins').'/bootstrap-multiselect/bootstrap-multiselect.css' }}">
<section class="content-header">
    <h1>
        All Contacts
        <small>Add/Edit</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="{{ route('admin.customers.view') }}"><i class="fa fa-coffee"></i>All Contacts</a></li>
        <li class="active">Add/Edit</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <div class="panel-body">
                        @if(!empty(Session::get('usenameError')))
                            <p style="color:red;text-align: center;">{{ Session::get('usenameError') }}</p>
                        @endif
                       <p style="color:red;text-align: center;">{{ Session::get('usernameErr') }}</p>
                     
                        {!! Form::model($contacts, ['method' => 'post', 'route' => $action]) !!}
                        <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                            {!!Form::label('Name','Name ') !!}<span class="red-astrik"> *</span>
                                {!! Form::hidden('id',null) !!}
                                {!! Form::text('name',Input::get('name'), ["class"=>'form-control validate[required]' ,"placeholder"=>'Name']) !!}
                            </div>
                        </div>
                        <div class="col-md-6">
                        <div class="form-group">
                            {!!Form::label('Email','Email') !!}<span class="red-astrik">*</span>
                                {!! Form::text('email',null, ["class"=>'form-control validate[required]' ,"placeholder"=>'Email']) !!}
                            </div>
                        </div>
                          <div class="col-md-4">
                            <div class="form-group">
                                {!! Form::label('Anniversary', 'Anniversary Date') !!}
                                {!! Form::date('anniversary',isset($contacts->anniversary) ? date('Y-m-d',strtotime($contacts->anniversary)) : '', ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                        <div class="form-group">
                            {!!Form::label('BirthDate','BirthDate ') !!}
                            {!! Form::date('birthDate',isset($contacts->birthDate) ? \Carbon\Carbon::parse($contacts->birthDate)->format('Y-m-d') : '', ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
                        <div class="form-group">
                            {!!Form::label('MobileNo','Mobile No') !!}<span class="red-astrik"> *</span>
                                {!! Form::text('mobileNo',null, ["class"=>'form-control validate[required]',"placeholder"=>'Mobile No']) !!}
                            </div>                           
                        </div>
                        <div class="col-md-6">
                        <div class="form-group">
                            {!!Form::label('Group','Group Name') !!}<span class="red-astrik"> *</span>
                                <!-- {!! Form::text('group_name',null, ["autofocus" =>"autofocus","id"=>'contactGroup',"class"=>'form-control contactGroup' ,"placeholder"=>'Group Name',"tabindex"=>1]) !!} -->
                                <select  name="group_name[]" class="multiselect form-control" multiple="multiple">
                                    @if(count($contacts_group)>0)
                                    @foreach($contacts_group as $group)
                                    <option value="{{$group->id}}">{{$group->group_name}}</option>
                                    @endforeach
                                    @else
                                    <option value="" disabled="">No Group Found</option>
                                    @endif
                                </select>
                            
                            </div>                           
                        </div>
                          {{ Form::hidden("group_id",null,['class'=>'inpt']) }}
                    <div class="col-md-12">
                        <div class="form-group">
                                {!! Form::submit('Submit',["class" => "btn btn-primary pull-right", "id" => " submit"]) !!}
                                {!! Form::close() !!}     
                            </div>
                        </div>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop
@section("myscripts")
<script src="{{  Config('constants.adminPlugins').'/bootstrap-multiselect/bootstrap-multiselect.js' }}"></script>
<script>
$('.multiselect').multiselect({
    buttonWidth: '100%',
    nonSelectedText: 'Select Group'
});

</script>
@stop