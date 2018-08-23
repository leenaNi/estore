@extends('Admin.layouts.default')




@section('content')


<section class="content-header">
    <h1>
       Testimonials
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Testimonials</li>
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
                <div class="box-header noBorder box-tools filter-box col-md-9">
                    
                        <form action="{{route('admin.testimonial.view')}}" method="get" >
                            <div class="form-group col-md-4 noBottomMargin">
                            <input type="text" value="{{ !empty(Input::get('search')) ? Input::get('search') : '' }}" name="search" aria-controls="editable-sample" class="form-control medium" placeholder="Search Testimonial"/>
                         </div>  
                            <div class="form-group col-md-4 noBottomMargin">
                                <select name='status' id="status" class="form-control">
                                    <option value="">Select Status</option>
                                     <option value="1">Enabled</option>
                                      <option value="0">Disabled</option>
                                </select>
                         </div>  
                             <div class="form-group col-md-2 noBottomMargin">
                                 <input type="submit" name="submit" value="Submit" class="btn btn-primary form-control">
                             </div>
                            <div class="form-group col-md-2 noBottomMargin">
                                <a href="{{ route('admin.testimonial.view')}}" class="btn reset-btn btn-block">Reset </a>
                             </div>
                        </form> 
                  
                </div>
                <div class="box-header col-md-3">
                    <button id="editable-sample_new" class="btn btn-default pull-right col-md-12" onclick="window.location.href ='{{ route('admin.testimonial.addEdit')}}'">Add New Testimonial</button>
                </div> 
              <div class="clearfix"></div>
                <div class="dividerhr"></div>

                <div class="box-body table-responsive no-padding">
                    <table class="table table-striped table-hover tableVaglignMiddle">
                            <thead>
                                <tr>
                                 
                                   
                                    <th>Image</th>
                                     <th>Customer Name</th>
                                      <th>Comments / Reviews</th>
                                      <th>Sort Order</th>
                                      <th>Created By</th>
                                      <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                   @if(count($testimonial) >0)
                                @foreach($testimonial as $testimonialval)

                                <tr>
                                  
                                 
                                    <td><img src="{{($testimonialval->image)?$public_path.$testimonialval->image:Config('constants.defaultImgPath').'/default-male.png' }}" class="img-responsive img-thumbnail" style="width: 50px;height: 50px;"></td>
                                      <td>{{ $testimonialval->customer_name }} </td>
                                    
                                    <td> <span class="customtooltip"><?php echo substr(strip_tags($testimonialval->testimonial), 0, 45) . "..." ?>
                                            <span class="customtooltiptext">{{strip_tags($testimonialval->testimonial)}}</span>
                                        </span></td>
                                        <td>{{ $testimonialval->sort_order }}</td>
                                    <td>{{ $testimonialval->users->firstname }}  {{ $testimonialval->users->lastname }}</td>
                                    <td> @if($testimonialval->status==1)
                                        <a href="{!! route('admin.testimonial.changeStatus',['id'=>$testimonialval->id]) !!}"  onclick="return confirm('Are you sure you want to disabled this comment?')" data-toggle='tooltip' title='Enabled' ><i class="fa fa-check btn-plen btn"></i></a>
                                        @elseif($testimonialval->status==0)
                                        <a href="{!! route('admin.testimonial.changeStatus',['id'=>$testimonialval->id]) !!}"  onclick="return confirm('Are you sure you want to enabled this comment?')" data-toggle="tooltip" title="Disabled"> <i class="fa fa-times btn-plen btn"></i></a>
                                        @endif </td>
                                    <td>
                                         <a href="{!! route('admin.testimonial.addEdit',['id'=>$testimonialval->id]) !!}"  ui-toggle-class=""  data-toggle="tooltip" title='Edit'><i class="fa fa-pencil-square-o btn-plen btn"></i></a>
                                           <a href="{!! route('admin.testimonial.delete',['id'=>$testimonialval->id]) !!}"  ui-toggle-class="" onclick="return confirm('Are you sure you want to delete this comment?')" data-toggle="tooltip" title='Delete'><i class="fa fa-trash btn-plen btn"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                                 @else
                           <tr><td colspan=6> No Record Found.</td></tr>
                            @endif
                            </tbody>
                        </table>
                </div>


                <div class="pull-right">

                </div>

            </div>
        </div>
    </div>
</section>

@stop

@section('myscripts')
<script>
    $(document).ready(function(){
      var status=document.getElementById('status');
      status.value='<?php echo $status;?>';
    })
</script>

@stop