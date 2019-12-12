@extends('Admin.layouts.default')
@section('mystyles')
<link rel="stylesheet" href="{{ Config('constants.adminPlugins').'/daterangepicker/daterangepicker-bs3.css' }}">
<style type="text/css">.capitalizeText select {
        text-transform: capitalize;
    } 
    select.form-control{ padding: 7px!important;}.fnt14{font-size: 14px;text-transform: capitalize !important;}</style>
@stop

@section('content')

<section class="content-header">
    <h1>
        All Contacts ({{$contactsCount }})
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">All Contacts</li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
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
                <div class="box-header noBorder box-tools filter-box col-md-9">

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
                        <div class="form-group col-md-2">
                            <input type="submit" name="submit" class="form-control btn btn-primary" value="Search" style="margin-left:0px">
                        </div>
                        <div class="form-group col-md-2">
                            <a  href="{{route('admin.storecontacts.view')}}" class="form-control medium btn reset-btn" style="margin-left:0px">Reset</a>
                        </div>
                    </form>


                </div>
                <div class="box-header col-md-3">
                    <a href="{!! route('admin.storecontacts.add') !!}" class="btn btn-default pull-right col-md-12 mobAddnewflagBTN"  type="button">Add New Contact</a>
                </div> 
                <div class="box-header col-md-3">
                    <button type="button" class="btn btn-default pull-right col-md-12 mobAddnewflagBTN" data-toggle="modal" data-target="#upload_contacts">Import</button> 
                    {{-- <a href="{!! route('admin.storecontacts.import') !!}" class="btn btn-default pull-right col-md-12 mobAddnewflagBTN" type="button">Import</a> --}}
                </div> 
                <div class="clearfix"></div>
                <div class="dividerhr"></div>
                <div class="row">
            <div class="col-md-12 marginBottom20">
                <div class="box box-info" >
                    <div class="box-header dashbox-header with-border bg-aqua">
                        <h3 class="box-title dashbox-title">Groups</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                            <button type="button" class="btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                       @if(count($contacts_group)>0) 
                       @foreach($contacts_group as $group)
                       <button class="btn btn-primary">{{$group->group_name}}</button>
                       @endforeach
                       @else
                       No Group Found
                       @endif
                    </div>
            
                </div>
            </div>
        </div><br><br>
                <div class="box-body table-responsive no-padding">
                    <table class="table table-striped table-hover tableVaglignMiddle">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email Id</th>
                                <th>Mobile</th>
                                <th>Contact Type</th>
                                <th>Anniversary Date</th>
                                <th>Birth Date</th>
                                <th>Date Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($storecontacts) >0 )
                            @foreach($storecontacts as $stcon)
                            <tr> 
                                <td>{{$stcon->name }}</td>

                                <td>{{ $stcon->email }}</td>
                                <td>{{ $stcon->mobileNo }}</td>
                                <td>{{ $stcon->contact_type==1?'Master':'Customer' }}</td>
                                <td>{{ $stcon->birthDate=='0000-00-00 00:00:00'? '':date("d-M-Y",strtotime($stcon->anniversary)) }}</td>
                                <td>{{ $stcon->birthDate=='0000-00-00 00:00:00'? '':date("d-M-Y",strtotime($stcon->birthDate)) }}</td>
                                <td>{{ date("d-M-Y",strtotime($stcon->created_at)) }}</td>
                                <td>
                                    <a href="{!! route('admin.storecontacts.edit',['id'=>$stcon->id]) !!}" class="" ui-toggle-class="" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square-o btn-plen btn btnNo-margn-padd" ></i></a>
                                    <a href="{!! route('admin.storecontacts.view',['contSearch'=> $stcon->name]) !!}" class="" ui-toggle-class="" data-toggle="tooltip" title="View Order"> <i class="fa fa-eye btn-plen btn"></i></a>

                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr><td colspan=8> No Record Found.</td></tr>
                            @endif
                            
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                    <?php
                    if (empty(Input::get('contSearch'))) {
                        echo $storecontacts->render();
                    }
                    ?> 

                </div>
            </div><!-- /.box -->
        </div><!-- /.col -->

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
              {{-- <input type="hidden" name="bankID" id="bankID" value="{{ $bankID }}"> --}}
              <label for="userName" class="col-sm-2 control-label pull" style="text-align: right;">Add File</label>

              
                       <input name="contact_file" id="approveUuid" type="file">
                
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
<!-- Upload Contacts Modal End -->

@stop

@section('myscripts')
<script src="{{  Config('constants.adminPlugins').'/daterangepicker/daterangepicker.js' }}"></script>
<script type="text/javascript">
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