@extends('Admin.layouts.default')
@section('mystyles')
<link rel="stylesheet" href="{{asset(Config('constants.adminPlugins').'bootstrap-multiselect/bootstrap-multiselect.css')}}">
@stop
@section('content')

<section class="content-header">
    <h1>
       Emails & Groups
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
                            {!! Form::model($markEmailsTemp, ['method' => 'post', 'files'=> true, 'url' => $action ]) !!}
                            <div class="clearfix"></div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">From Email <span class="red-astrik"> *</span></label> 
                                    {!! Form::text('from_email',null, ["class"=>'form-control validate[required]' ,"placeholder"=>'Enter From Email']) !!}
                                </div>
                                <div class="form-group">
                                    <label class="control-label">From Name <span class="red-astrik"> *</span></label> 
                                    {!! Form::text('from_name',null, ["class"=>'form-control validate[required]' ,"placeholder"=>'Enter From name']) !!}
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Subject <span class="red-astrik"> *</span></label> 
                                    {!! Form::text('subject',null, ["class"=>'form-control validate[required]' ,"placeholder"=>'Enter Subject']) !!}
                                    {!! Form::hidden('id',null) !!}
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Email Body <span class="red-astrik"> *</span></label>
                                    <!--                                     @if(!empty($markEmailsTemp->id))
                                                                        <textarea cols="80" class="form-control validate[required]" placeholder="Enter Email Body" name="email_body" rows="10" id="editor1" >
                                    <?php
//                                        echo htmlspecialchars_decode($markEmailsTemp->email_body);
                                    ?>
                                                                        </textarea>
                                                                        @else
                                                                        {!! Form::textarea('email_body',null, ["class"=>'form-control validate[required]' ,"placeholder"=>'Enter Email Body', "id"=>"editor1",  "rows" => "1"]) !!}
                                                                        @endif-->
                                    <textarea cols="80" class="form-control validate[required]" placeholder="Enter Email Body" name="email_body" rows="10" id="editor1" ></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Status </label>
                                    {!! Form::select('status',[ "1" => "Enable", "2" => "Disable"],null,["class"=>'form-control']) !!}
                                </div>                         
                                <div class="form-group col-md-12 text-right mobTextLeft noMob-leftpadding">
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
    
    CKEDITOR.replace('editor1');
    var emailBody = '<?= htmlspecialchars_decode($markEmailsTemp->email_body) ?>';
    CKEDITOR.instances.editor1.on('instanceReady', function (evt) {
        evt.editor.setData(emailBody);
    });

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
