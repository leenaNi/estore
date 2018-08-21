@extends('Admin.layouts.default')
@section('content') 
<section class="content-header">   
    <style>
        .paddingBottom{
            padding-bottom: 31px !important;
        }
    </style>
    <h1>
        Pincodes ({{$pincodeCount}})
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Pincodes</li>
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
                <div class="box-header box-tools filter-box col-md-9 noBorder col-sm-12 col-xs-12 noMobLeftRightPadding">

                    <form action="{{ route('admin.pincodes.view') }}" method="get" >
                        <input type="hidden" name="dataSearch" value="dataSearch"/>
                        <div class="form-group col-md-3 col-sm-6 col-xs-12">
                            <input type="text" name="pincode"  class="form-control" placeholder="Pincode" value="{{ (!empty(Input::get('pincode'))) ? Input::get('pincode') :''}}" >
                        </div>
                          @if($feature['cod'] == 1)  
                        <div class="form-group col-md-3 col-sm-6 col-xs-12">
                            <select name="cod_status"class="form-control" id="cod_status">
                                <option value="">Select COD Status</option>
                                <option value="1">Applicable</option>
                                <option value="0">Not Applicable</option>
                            </select>
                        </div>
                          @endif
                        <div class="form-group col-md-2 col-sm-12 col-xs-12">
                            <input type="submit" name="submit" vlaue='Submit' class='form-control btn btn-primary noMob-leftmargin'>
                        </div>
                        <div class="from-group col-md-2 col-sm-12 col-xs-12">
                            <a href="{{ route('admin.pincodes.view')}}" class="reset-btn btn btn-block noMob-leftmargin">Reset </a>
                        </div>
                    </form>
                </div>   


                <div class="box-header col-md-3 col-sm-12 col-xs-12">
                    <div class="form-group marginBottom15">
                    <a href="{!! route('admin.pincodes.addEdit') !!}" class="btn btn-default form-control pull-right col-md-12" type="button">Add New Pincode</a>
                    </div>
                    <div class="clearfix marginBottom15"></div>
                     <div class="form-group">
                    <a href="{{ route('admin.pincodes.sampleBulkDownload')}}" class="btn btn-default form-control pull-right col-md-12" type="button">Download Pincode</a>
                    </div>
                    
                    <div class="clearfix marginBottom15"></div>
                    <form action="{{route('admin.pincodes.upload')}}"  method="post" enctype="multipart/form-data">
                    <div class="form-group"> 
                        <input type="file" class="form-control validate[required] fileUploder" name="pincode_csv" placeholder="Browse CSV file"  onChange="validateFile(this.value)"/ >
                    </div>
                    
                    <div class="clearfix"></div>
                    <div class="form-group"> 
                        <input type="submit" class="btn sbtn btn-primary submitBulkUpload margin-left0 full-Widthbtn" value="Bulk Upload" />
                    </div>
               </form>
                </div> 
                <div class="clearfix"></div>
     
                <div class="clearfix"></div>
                <div class="dividerhr"></div>
           
                <div class="box-body table-responsive no-padding">
                    <table class="table  table-hover general-table tableVaglignMiddle">
                        <thead>
                            <tr>
                                <th>Pincode</th>
                                 @if($feature['cod'] == 1)  
                                <th>COD Applicable</th>
                                @endif
                                @if($feature['courier-services'] == 1)  
                                <th>Service Provider</th>
                                @endif
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($pincodes) >0)
                            @foreach($pincodes as $pin)

                            <tr>
                                <td>{{ @$pin->pincode }}</td>
                                 @if($feature['cod'] == 1)  
                                <td> @if($pin->cod_status ==1)
                                    <a href="{{route('admin.pincodes.codStatusChange',['id'=>$pin->id])}}" >Applicable</a>

                                    @elseif($pin->cod_status ==0)
                                    <a href="{{route('admin.pincodes.codStatusChange',['id'=>$pin->id])}}" >Not Applicable</a>
                                    @endif</td>
                                 @endif
                                @if($feature['courier-services'] == 1)  
                                <td>{{ ucwords(@$pin->seviceProvider->name) }}</td>
                                @endif
                                 <td>  @if($pin->status==1)
                                        <a href="{{route('admin.pincodes.changeStatus',['id'=>$pin->id])}}" class="" ui-toggle-class="" onclick="return confirm('Are you sure you want to disable this pincode?')" data-toggle="tooltip" title="Enabled"><i class="fa fa-check btn-plen btn btnNo-margn-padd"</a>
                                        @elseif($pin->status==0)
                                        <a href="{{route('admin.pincodes.changeStatus',['id'=>$pin->id])}}" class="" ui-toggle-class="" onclick="return confirm('Are you sure you want to enable this pincode?')" data-toggle="tooltip" title="Disabled"><i class="fa fa-times btn-plen btn btnNo-margn-padd"></i></a>
                                        @endif</td>
                                
                                 <td>
                                    <a href="{{route('admin.pincodes.addEdit',['id'=>$pin->id])}}" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square-o btn btn-plen btnNo-margn-padd"></i></a>
                                    <a href="{{route('admin.pincodes.delete',['id'=>$pin->id])}}" onclick="return confirm('Are you sure you want to delete this pincode?')" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a>
                                </td>

                            </tr>
                            @endforeach
                            @else
                            <tr> <td colspan="4">No Record Found</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div><!-- /.box-body -->

                <div class="box-footer clearfix">
                    @if(empty(Input::get('dataSearch')))
                    {{ $pincodes->links() }}
                    @endif

                </div>
            </div>
        </div>
    </div>
</section>

@stop

@section('myscripts')
<script>
    $(document).ready(function () {
        var cod = document.getElementById("cod_status");
        cod.value = '<?php echo $cod_status; ?>';

        var delivary = document.getElementById("devivary_status");
        delivary.value = '<?php echo $delivary_status ?>';
    })

</script>

@stop