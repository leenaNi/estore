@extends('Admin.layouts.default')
@section('content')

<section class="content-header">
    <h1>
        Contact Details ({{$contactCount }})
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Contact Details</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
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
<!--                <div class="box-header box-tools filter-box col-md-9 noBorder col-sm-12 col-xs-12">

                    <form action="{{ route('admin.contact.view') }}" method="get" >
                        <input type="hidden" value="searchData" name="searchData" >
                        <div class="form-group col-md-4  col-sm-6 col-xs-12">
                            <input type="text" value="{{ !empty(Input::get('phone_no')) ? Input::get('phone_no') : '' }}" name="phone_no" aria-controls="editable-sample" class="form-control medium" placeholder="Mobile"/>    
                        </div>
                        <div class="form-group col-md-4  col-sm-6 col-xs-12">
                            <input type="text" value="{{ !empty(Input::get('email')) ? Input::get('email') : '' }}" name="email" aria-controls="editable-sample" class="form-control medium" placeholder=" Email Id"/>
                        </div>

                        <div class="form-group col-md-2  col-sm-6 col-xs-12">

                            <input type="submit" name="submit" class="btn btn-primary form-control noMob-leftmargin"  value="Search">
                        </div>
                        <div class="form-group col-md-2 col-sm-6 col-xs-12 noMobBottomMargin">
                            <a href="{{route('admin.contact.view')}}" class="btn reset-btn btn-block noMob-leftmargin" value="reset">Reset</a>
                        </div>

                    </form> 

                </div>-->
<!--                <div class="box-header col-md-3 col-sm-12 col-xs-12">
                    <button id="editable-sample_new" class="btn btn-default pull-right col-md-12 mobAddnewflagBTN" onclick="window.location.href ='{{ route('admin.contact.add')}}'">Add New Contact</button>
                </div>
                <div class="clearfix"></div>-->
                <div class="dividerhr"></div>
             

                <div class="box-body table-responsive">
                    <table class="table table-striped table-hover tableVaglignMiddle">
                        <thead>
                            <tr>
                                <!--                                <th>Sr No</th>-->
                                <th>Contact Parson</th>
                                <th>Mobile</th>
                                <th>Email Id</th>
                                <th>Address Line 1</th>
                                <th>Address Line 2</th>
                                <th>City</th>
                                <th>Pincode</th>
<!--                                <th>Vat Number</th>-->
                                <!-- <th>Status</th> -->
<!--                                <th>Created At</th>-->
<!--                                <th>Status</th>-->
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($contactInfo) >0)
                            @foreach ($contactInfo as $contact)
                            <tr>
                                <td>{{$contact->customer_name}}</td>
                                <td>{{$contact->phone_no}}</td>
                                <td>{{$contact->email}} </td>
                                <td>
                                    <span class="customtooltip">
                                        <?php echo substr(strip_tags($contact->address), 0, 45) . "..." ?>
                                        <span class="customtooltiptext">{{strip_tags($contact->address)}}</span>
                                    </span>
                                </td>
                                <td>
                                    <span class="customtooltip">
                                        <?php echo substr(strip_tags($contact->address2), 0, 45) . "..." ?>
                                        <span class="customtooltiptext">{{strip_tags($contact->address2)}}</span>
                                    </span>
                                </td>
                                 <td>{{@$contact->city}}</td> 
                                 <td>{{@$contact->pincode}}</td> 
<!--                                <td>{{  date('d-M-Y ',strtotime($contact->created_at))}}</td>-->
<!--                                <td>
                                    @if($contact->status==1)
                                    <a href="{!! route('admin.contact.changeStatus',['id'=>$contact->id]) !!}" class="" ui-toggle-class="" onclick="return confirm('Are you sure you want to disable this contact?')" data-toggle="tooltip" title="Enabled"><i class="fa fa-check btn-plen btn btnNo-margn-padd"></i></a>
                                    @elseif($contact->status==0)
                                    <a href="{!! route('admin.contact.changeStatus',['id'=>$contact->id]) !!}" class="" ui-toggle-class="" onclick="return confirm('Are you sure you want to enable this contact?')" data-toggle="tooltip" title="Disabled"><i class="fa fa-times btn-plen btn btnNo-margn-padd"></i></a>
                                    @endif
                                </td>-->
                                <td>
                                    <a href="{!! route('admin.contact.add',['id'=>$contact->id]) !!}"  class="" ui-toggle-class="" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square-o fa-fw btnNo-margn-padd"></i></a>

                                    <!--<a href="{!! route('admin.contact.delete',['id'=>$contact->id]) !!}" class="" ui-toggle-class="" onclick="return confirm('Are you sure you want to delete this conatct?')" data-toggle="tooltip" title="Delete"><i class="fa fa-trash fa-fw"></i></a>-->
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr><td colspan=9>No Record Found.</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div><!-- /.box-body -->

                <div class="box-footer clearfix">
                  @if(empty(Input::get("searchData")))
                  {!! $contactInfo->links() !!}
                  @endif
              </div>
          </div>
      </div>
  </div>
</section>

@stop 
@section('myscripts')
<script>
    /*$(function () {
        $("#fromdatepicker").datepicker({dateFormat: 'yy-mm-dd'});
        $("#todatepicker").datepicker({dateFormat: 'yy-mm-dd'});
    });*/
</script>
@stop