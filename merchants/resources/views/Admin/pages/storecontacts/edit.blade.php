@extends('Admin.layouts.default')
@section('content')

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
                            {!!Form::label('Group','Select Group') !!}<span class="red-astrik"> *</span>
                                <!--  -->
                                <select  name="group_name[]" class="selectpicker form-control" data-live-search="true" multiple="multiple">
                                    <option value="0">New Group</option>
                                    @if(count($contacts_group)>0)
                                    @foreach($contacts_group as $group)
                                    <option value="{{$group->id}}" {{in_array($group->id,$GroupHasContact)?'selected':''}}>{{$group->group_name}}</option>
                                    @endforeach
                                    @else
                                    <option value="" disabled="">No Group Found</option>
                                    @endif
                                </select>
                            </div>                           
                        </div>
                        <div class="col-md-6" id="grp_div" style="display: none;">
                        <div class="form-group">
                            {!!Form::label('groupname','Group Name') !!}<span class="red-astrik"> *</span>
                                {!! Form::text('new_group_name',null, ["id"=>'new_group_name',"class"=>'form-control' ,"placeholder"=>'Enter Group Name']) !!}
                            </div>                           
                        </div>
                          
                    <div class="col-md-12">
                        <div class="form-gstoresroup">
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
    //nonSelectedText: 'Select Group'
});

$('.selectpicker').on('change', function() {
      if ( this.value == '0')
      {
        $("#grp_div").show();
      }
      else
      {
        $("#grp_div").hide();
      }
    });
</script>
@stop