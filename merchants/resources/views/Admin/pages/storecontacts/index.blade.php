@extends('Admin.layouts.default')
@section('mystyles')
<link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-daterangepicker/daterangepicker.css">
<style type="text/css">.capitalizeText select {text-transform: capitalize;} 
select.form-control{ padding: 7px!important;}.fnt14{font-size: 14px;text-transform: capitalize !important;}</style>
@stop

@section('content')

<section class="content-header">
    <h1>
        All Contacts  <?php
        if($contactsCount > 0)
        {
        ?>
        ({{$startIndex}}-{{$endIndex}} of {{$contactsCount }})
        <?php
        }
        ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">All Contacts</li>
    </ol>
</section>

<section class="main-content">

    <div class="notification-column">           
        @if(!empty(Session::get('message')))
        <div  class="alert alert-danger" role="alert">
            {{ Session::get('message') }}
        </div>
        @endif
        @if(!empty(Session::get('msg')))
        <div  class="alert alert-success" role="alert">
            {{ Session::get('msg') }}
        </div>
        @endif
        @if(!empty(Session::get('updatesuccess')))
        <div  class="alert alert-success" role="alert">
            {{ Session::get('updatesuccess') }}
        </div>
        @endif
        @if (Session::has('uplaodMessage'))
           <div class="alert alert-info">{{ Session::get('uplaodMessage') }} 
            @if(Session::has('filename'))
              <a href="{{ Config('constants.contactInvalidFilePath') . Session::get('filename') }}" download>Click Here</a> To Download Errors File
            @endif
           </div>
        @endif
    </div>

    <div class="grid-content">
        <div class="section-main-heading">
            <h1>Filter</h1>
        </div>
        <div class="filter-section displayFlex">
            <div class="col-md-9 noAll-padding displayFlex">
                <div class="filter-left-section">
                    <form action="{{ route('admin.storecontacts.view') }}" method="get" >
                        <div class="form-group col-md-4">
                            <input type="text" name="contSearch" value="{{ !empty(Input::get('contSearch')) ? Input::get('contSearch') : '' }}" class="form-control input-sm pull-right fnt14" placeholder="Name/Email/MobileNo">
                        </div>
                        <div class="form-group col-md-4">
                            <div class="input-group date Nform_date" id="datepickerDemo">
                                <input placeholder="Anniversary Date" type="text" id="" name="anniversary" value="{{ !empty(Input::get('anniversary')) ? Input::get('anniversary') : '' }}" class="form-control datefromto textInput">

                                <span class="input-group-addon">
                                    <i class=" ion ion-calendar"></i>
                                </span>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <div class="input-group date Nform_date" id="datepickerDemo">
                                <input placeholder="Birth Date" type="text" id="" name="dateofbirth" value="{{ !empty(Input::get('dateofbirth')) ? Input::get('dateofbirth') : '' }}" class="form-control datefromtodob textInput">

                                <span class="input-group-addon">
                                    <i class=" ion ion-calendar"></i>
                                </span>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="form-group col-md-4 noBottom-margin">
                            <div class="search-resetsubmit">
                                <input type="submit" name="submit" class="btn btn-primary mn-w100 no-leftmargin" value="Search">
                                <a  href="{{route('admin.storecontacts.view')}}" class="medium btn reset-btn mn-w100 no-leftmargin">Reset</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-3 noAll-padding displayFlex">
                <div class="filter-right-section">
                    <a href="{!! route('admin.storecontacts.add') !!}" class="btn btn-default pull-right fullWidth mobAddnewflagBTN marginBottom-md"  type="button">Add New Contact</a> 
                    <button type="button" class="btn btn-default pull-right fullWidth mobAddnewflagBTN marginBottom-md" data-toggle="modal" data-target="#upload_contacts">Import</button>                      
                    <button type="button" class="btn btn-default pull-right fullWidth mobAddnewflagBTN" onclick="assignGroup();">Assign Group</button> 
                </div>
            </div>
        </div>
    </div>

    <div class="grid-content">
        <div class="row">
            <div class="col-md-12">
                <div class="groupsColunmn">
                    <div class="box">
                        <div class="box-header dashbox-header">
                            <h3 class="box-title dashbox-title">Groups</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="box-body">
                           @if($contacts_group && count($contacts_group)>0) 
                           @foreach($contacts_group as $group)
                           <div class="col-md-2">
                                <div class="dropdown">
                                    <button class="btn noAll-margin btn-default dropdown-toggle fullWidth" type="button" data-toggle="dropdown">{{$group->group_name}} <span class="caret"></span></button>
                                    <ul class="dropdown-menu">
                                      <li><a onclick="renameGroup('{{$group->group_name}}','{{$group->id}}')" class="" ui-toggle-class="">Rename</a></li>
                                      <li><a href="{{route('admin.storecontacts.exportgroupcontacts',['id'=>$group->id]) }}" class="" ui-toggle-class="">Download</a></li>
                                    </ul>
                                </div>
                            </div>
                           @endforeach
                           @else
                           No Group Found
                           @endif
                        </div>            
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="grid-content">
        <div class="section-main-heading">
            <h1>All Contacts 
                <?php
        if($contactsCount > 0)
        {
        ?>
        <span class="listing-counter">{{$startIndex}}-{{$endIndex}} of {{$contactsCount }}</span> </h1>
        <?php
        }
        ?>
        
        </div>
        <div class="listing-section">
            <div class="table-responsive overflowVisible no-padding">
                <table class="table table-striped table-hover tableVaglignMiddle">
                    <thead>
                        <tr>
                            <th class="text-center"></th>
                            <th class="text-left">Name</th>
                            <th class="text-left">Email Id</th> 
                            <th class="text-left">Contact Type</th>
                            <th class="text-right">Anniversary Date</th>
                            <th class="text-right">Birth Date</th>
                            <th class="text-right">Created Date</th>
                            <th class="text-center mn-w100">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($storecontacts) >0 )
                        @foreach($storecontacts as $stcon)
                        <tr> 
                            <td class="text-center"><input type="checkbox" name="stId[]" class="checkContId" value="{{ $stcon->id }}" /></td>
                            <td class="text-left"><span class="list-dark-color">{{$stcon->name }}</span><div class="clearfix"></div>
                                <span class="list-light-color list-small-font">{{ $stcon->mobileNo }}</span>
                            </td>
                            <td class="text-left">{{ $stcon->email }}</td> 
                            <td class="text-left">{{ $stcon->contact_type==1?'Master':'Customer' }}</td>
                            <td class="text-right">{{ $stcon->birthDate=='0000-00-00 00:00:00'? '':date("d-M-Y",strtotime($stcon->anniversary)) }}</td>
                            <td class="text-right">{{ $stcon->birthDate=='0000-00-00 00:00:00'? '':date("d-M-Y",strtotime($stcon->birthDate)) }}</td>
                            <td class="text-right">{{ date("d-M-Y",strtotime($stcon->created_at)) }}</td>
                            <td class="text-center mn-w100">
                                <div class="actionCenter">
                                    <span><a class="btn-action-default" href="{!! route('admin.storecontacts.edit',['id'=>$stcon->id]) !!}"><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'pencil.svg'}}"></a></span> 
                                    <span class="dropdown">
                                    <button class="btn-actions dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="{{ Config('constants.adminImgangePath') }}/icons/{{'more.svg'}}">
                                    </button>
                                        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">  
                                            <li><a href="{!! route('admin.storecontacts.view',['contSearch'=> $stcon->name]) !!}"><i class="fa fa-eye "></i> View Order</a></li>
                                        </ul>
                                    </span>  
                                </div> 
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr><td colspan=8 class="text-center"> No Record Found.</td></tr>
                        @endif
                        
                    </tbody>
                </table>
            </div>
            <?php
            if (empty(Input::get('contSearch'))) {
                echo $storecontacts->render();
            }
            ?> 
        </div>
    </div>

</section>
 

<!-- Upload Contacts Modal Start -->
  <div id="upload_contacts" class="modal fade" role="dialog">
    <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title">Upload Contacts</h4>
      </div>
      <form action="{{route('admin.storecontacts.import')}}" method="post" enctype="multipart/form-data" id="upload_contact_form">
        {!! csrf_field() !!}
        <div class="modal-body">
          <div class="row">
            <div class="form-group">
              <label for="userName" class="col-sm-2 control-label pull" style="text-align: right;">Add File</label>
                       <input name="contact_file" id="approveUuid" type="file" required="">
            </div>
            <div class="form-group" style="margin-left: 19px;margin-right: 19px">
                {!!Form::label('Group','Select Group') !!}<span class="red-astrik"> *</span>
                <select  name="cg_id" class="selectpicker form-control" data-live-search="true">
                    <option value="">Select Group</option>
                    <option value="0">New Group</option>
                    @if(count($contacts_group)>0)
                    @foreach($contacts_group as $group)
                    <option value="{{$group->id}}">{{$group->group_name}}</option>
                    @endforeach
                    @else
                    <option value="" disabled="">No Group Found</option>
                    @endif
                </select>
            </div> 
            <div class="col-md-6" id="grp_div" style="display: none;">
                        <div class="form-group">
                            {!!Form::label('groupname','Group Name') !!}<span class="red-astrik"> *</span>
                                {!! Form::text('new_cg',null, ["id"=>'new_cg',"class"=>'form-control' ,"placeholder"=>'Enter Group Name']) !!}
                            </div>                           
                        </div>
          </div>
        </div>
        <div class="modal-footer">
            <a href="{!! route('admin.storecontacts.exportsamplecsv') !!}" class="btn btn-primary pull-left" target="_" type="button">Download sample CSV</a>
          <button type="submit" class="btn btn-primary submit_upload ladda-button" data-style="zoom-in" >Upload</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>

    </div>
  </div>
    <!-- Modal -->
  <div class="modal fade" id="groupRenameModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Rename Group</h4>
        </div>
        <form action="{{route('admin.storecontacts.renamegroup')}}" method="post">
        {!! csrf_field() !!}
        <div class="modal-body">
            <div class="form-group">
                {!!Form::label('groupname','Group Name') !!}<span class="red-astrik"> *</span>
                    {!! Form::text('edit_group_name',null, ["id"=>'edit_group_name',"class"=>'form-control' ,"placeholder"=>'Enter Group Name']) !!}
                    {!! Form::hidden('groupid',null,['class'=>'form-control','id'=>'groupid']) !!}
            </div>  
                                   
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Submit</button>  
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
        </form>
      </div>  
    </div>
  </div>
<!-- Upload Contacts Modal End -->
<div id="assign_group_contacts" class="modal fade" role="dialog">
    <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title">Assign Group</h4>
      </div>
      <form action="{{route('admin.storecontacts.contactgroup')}}" method="post">
        {!! csrf_field() !!}
        <div class="modal-body">
          <div class="row" style="margin:0px;">
            <div class="form-group">
                {!!Form::label('Group','Select Group') !!}<span class="red-astrik"> *</span>
                 <input type="hidden" value="" name="Contact_Ids" />
                <select  name="group_id" class="selectpicker form-control" data-live-search="true">
                    <option value="">Select Group</option>
                    <option value="0">New Group</option>
                    @if(count($contacts_group)>0)
                    @foreach($contacts_group as $group)
                    <option value="{{$group->id}}">{{$group->group_name}}</option>
                    @endforeach
                    @else
                    <option value="" disabled="">No Group Found</option>
                    @endif
                </select>
            </div> 
            <div class="col-md-6" id="grp_div1" style="display: none;">
                        <div class="form-group">
                            {!!Form::label('groupname','Group Name') !!}<span class="red-astrik"> *</span>
                                {!! Form::text('new_group_name',null, ["id"=>'new_group_name',"class"=>'form-control' ,"placeholder"=>'Enter Group Name']) !!}
                            </div>                           
                        </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary submit_upload ladda-button" data-style="zoom-in" >Submit</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>

    </div>
  </div>
  <div class="clearfix"></div>
@stop

@section('myscripts')
<script src="https://adminlte.io/themes/AdminLTE/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script type="text/javascript">
function renameGroup(name,id){
    $("#groupRenameModal").modal('show');
    $("#edit_group_name").val(name);
    $("#groupid").val(id);
}

function downloadContacts(groupid){
    $.ajax({
       type:'GET',
       url:'storecontacts/exportgroupcontacts',
       data:{groupid:groupid},
       success:function(data){
          
       }
    });
}

function assignGroup()
{
    var ids = $(".tableVaglignMiddle input.checkContId:checkbox:checked").map(function () {
        return $(this).val();
    }).toArray();
    if(ids=='')
    {
        alert('Please select atleast one contact');
        $('#assign_group_contacts').modal('hide');
    }
    else{
        $("input[name='Contact_Ids']").val(ids);
        $('#assign_group_contacts').modal('toggle');
        $("#assign_group_contacts").modal('show');
    }
}
$('.selectpicker').on('change', function() {
  if ( this.value == '0')
  {
    $("#grp_div").show();
    $("#grp_div1").show();
  }
  else
  {
    $("#grp_div").hide();
    $("#grp_div1").hide();
  }
});

$(function () {

    var start = moment().subtract(29, 'days');
    var end = moment();

    // function cb(start, end) {
    //      $('#reportrange span').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
    // }

    $('.datefromto, .datefromtodob').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, function () {
    });

    //cb(start, end);
    $('.datefromto, .datefromtodob').on('apply.daterangepicker', function (ev, picker) {
        $(this).val(picker.startDate.format('DD/MM/YYYY') + '-' + picker.endDate.format('DD/MM/YYYY'));
    });

    $('.datefromto, .datefromtodob').on('cancel.daterangepicker', function (ev, picker) {
        $(this).val('');
    });
});

$(document).ready(function() {
  $(".submit_upload").click(function(){
      $("#upload_contact_form").submit();
    });
});
</script>
@stop 