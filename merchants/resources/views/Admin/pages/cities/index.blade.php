@extends('Admin.layouts.default')
@section('content') 
<section class="content-header">   
    <h1>
        Cities
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Cities</li>
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
                <div class="box-header noBorder box-tools filter-box col-md-9 noBottompadding">
                  
                        <form action="{{ route('admin.cities.view') }}" method="get" >
                            <input type="hidden" name="dataSearch" value="dataSearch"/>
                              <div class="form-group col-md-8">
                                  <input type="text" name="city_name"  class="form-control" placeholder="Search City" value="{{ (!empty(Input::get('city_name'))) ? Input::get('city_name') :''}}" >
                            </div>
                              
                               <div class="form-group col-sm-2">
                                <input type="submit" name="submit" vlaue='Submit' class='form-control btn btn-primary'>
                            </div>
                            <div class="from-group col-sm-2">
                                <a href="{{ route('admin.cities.view')}}" class="reset-btn btn btn-block">Reset </a>
                            </div>
                        </form>
                    </div>   

              
                <div class="box-header col-md-3">
                     <a href="{!! route('admin.cities.addEdit') !!}" class="btn btn-default pull-right col-md-12" type="button">Add New City</a>
                </div> 

                <div class="clearfix"></div>
                <div class="dividerhr"></div>
                                
                <div class="box-body table-responsive no-padding">
                    <table class="table  table-hover general-table tableVaglignMiddle">
                        <thead>
                            <tr>
                               
                                <th>State Name</th>
                                  <th>City Name</th>
                                    <th>Delivary Status</th>
                                      <th>COD Status</th>
                                        <th>Status</th>
                                  <th>Action</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($cities) >0)
                            @foreach($cities as $city)

                            <tr>
                                
                                <td>{{ $city->state->state_name}}</td>
                               <td>{{ $city->city_name }}</td>
                                 <td>
                                     <a href='#' data-route="{{route('admin.cities.changeDelivaryStatus',['id'=>$city->id])}}" class="update-status" data-prod-name="Delivary Status" > {{ $city->delivary_status==1?'Applicable':"Do not Deliver" }}</a>  
                                     
                                     </td>
                                     <td> <a href='#' data-route="{{route('admin.cities.changeCodStatus',['id'=>$city->id])}}" class="update-status" data-prod-name="COD Status" > {{ $city->cod_status==1 ?' Applicable' :'Not Applicable' }} </a></td>
                                     <td> <a href='#' data-route="{{route('admin.cities.changeStatus',['id'=>$city->id])}}"  class="update-status" data-prod-name="Status" > {{ $city->status ==1? 'Enabled' :'Disabled' }} </a></td>
                                <td>
                                   
                                    <a href="{{route('admin.cities.addEdit',['id'=>$city->id])}}" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square-o btn btn-plen btnNo-margn-padd"></i></a>
                                      <a href="{{route('admin.cities.delete',['id'=>$city->id])}}" onclick="return confirm('Are you sure you want to delete this record?')" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr> <td colspan="4">No Records Found</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
                
                 <div class="box-footer clearfix">
                    @if(empty(Input::get('dataSearch')))
                 {{ $cities->links() }}
                    @endif

                </div>
            </div>
        </div>
    </div>
       <div class="modal fade" id="update-status-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-sm">

            <!-- Modal content-->
            <div class="modal-content">
              
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" id="modal-title">Update Status</h4>
                    </div>
                    <div class="modal-body" >
                        <input type="hidden" id="route-action" name="route-action" required/>
                 
                        <div class="form-group">
                            <div class="test"></div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-default btn-submit" >Yes</button>
                        <button type="button" class="btn btn-default btn-no">No</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
             
            </div>
        </div>
    </div> 
    
</section>

@stop

@section('myscripts')
<script>
     $('.update-status').click(function () {
       var proId = $(this).attr('data-route');
      //  alert(proId);
       var prodName = $(this).attr('data-prod-name');  
       $('.test').html("Would you like to apply this setting to all the Pin codes of this City?");
        $('#route-action').val(proId);
        $('#update-status-modal').modal('show');
    });
 $('.btn-submit').click(function () {
   var url=$('#route-action').val();
    $('#update-status-modal').modal('hide');
     $.ajax({
            url:url,
            type: 'GET',
             data:{type:'1'},
           
            success: function (result) {
	           //	alert(JSON.stringify(result));
	           	if(result){
	        
                              location.reload();
	           	} else {
	           		alert("Oops something went wrong, Please try again later.");
	           	}
            }
        });
 // alert(url);
 });
 
  $('.btn-no').click(function () {
   var url=$('#route-action').val();
    $('#update-status-modal').modal('hide');
     $.ajax({
            url:url,
            type: 'GET',
            data:{type:'0'},
           
            success: function (result) {
	           	//alert(JSON.stringify(result));
	           	if(result){
	        
                              location.reload();
	           	} else {
	           		alert("Oops something went wrong, Please try again later.");
	           	}
            }
        });
 
 });

</script>
@stop

