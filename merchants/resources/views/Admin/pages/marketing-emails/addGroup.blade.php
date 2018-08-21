@extends('Admin.layouts.default')
@section('mystyles')
<link rel="stylesheet" href="{{asset(Config('constants.adminPlugins').'bootstrap-multiselect/bootstrap-multiselect.css')}}">
@stop
@section('content')

<section class="content-header">
    <h1>
       Email & Group
        <small></small>
    </h1>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box noShadow noBorder">
                <div class="box-body">
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
                    <div class="box-header box-tools filter-box col-md-12 noBorder">
                        <div class="box-body">
                            {!! Form::model($markEmailsGroup, ['method' => 'post', 'files'=> true, 'url' => $action ]) !!}
                            <div class="clearfix"></div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Title <span class="red-astrik"> *</span></label> 
                                    {!! Form::text('title',null, ["class"=>'form-control validate[required]' ,"placeholder"=>'Enter Group Title']) !!}
                                    {!! Form::hidden('id',null) !!}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Status </label>
                                    {!! Form::select('status',[ "1" => "Enable", "2" => "Disable"],null,["class"=>'form-control']) !!}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">User Specific?</label>
                                    {!! Form::select('is_user_specific',["2" => "No", "1" => "Yes"],null,["class"=>'form-control','id' => 'userspec']) !!}
                                </div>
                            </div>
                            @if(!empty($markEmailsGroup->id))
                            <?php
                            $userIds = App\Models\HasEmails::where('group_id', $markEmailsGroup->id)->get(['user_id'])->toArray();
//                            print_r($userIds);
                            $userIds = array_column($userIds, 'user_id');
                            ?>
                            <div class="col-md-12 {{($markEmailsGroup->is_user_specific==1)? '': 'hidden'}}" id="useremails">
                                <div class="form-group">
                                    <label class="control-label">Select Emails</label><br/>
                                    <select name='user_emails[]' class="form-control" id="user-emails" multiple>
                                        @foreach($customers as $cust)                                      
                                        <option  value="{{$cust->id}}"  <?php echo (in_array($cust->id, $userIds)) ? 'selected' : ''; ?> >{{$cust->email}} </option> 
                                        @endforeach
                                    </select>                                    
                                </div>
                            </div>
                            @else
                            <div class="col-md-12 hidden"  id="useremails">
                                <div class="form-group">
                                    <label class="control-label">Select Emails</label><br/>
                                    <select name='user_emails[]' class="form-control" id="user-emails" multiple>
                                        @foreach($customers as $cust)                                      
                                        <option  value="{{$cust->id }}"  >{{$cust->email}} </option> 
                                        @endforeach
                                    </select>                                    
                                </div>
                            </div>
                            @endif
                            <div class="form-group col-md-12 text-right mobTextLeft">
                                {!! Form::submit('Save',["class" => "btn btn-primary saveButton noMob-leftmargin"]) !!}
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
@section('myscripts')
<script src="{{asset(Config('constants.adminPlugins').'bootstrap-multiselect/bootstrap-multiselect.js')}}"></script>
<script type="text/javascript">
$(document).ready(function () {
    $('#user-emails').multiselect({
        columns: 2,
        search: true,
        includeSelectAllOption: true,
        deselectAll: false,
        enableFiltering: true,
        filterPlaceholder: 'Select Emails'
    });
    $('#userspec').change(function () {
        console.log($(this).val());
        if ($(this).val() == 1) {
            $("#useremails").removeClass('hidden');
        } else if ($(this).val() == 2) {
            $("#useremails").addClass('hidden');
        }
    });
});
</script>
@stop
