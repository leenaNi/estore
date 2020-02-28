@extends('Admin.layouts.default')
@section('content') 
@php 
use App\Models\User;
use App\Models\Order;
@endphp 
<section class="content-header">   
    <h1>
       Customer Reviews
    </h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Catalog </a></li>
        <li class="active">Reviews</li>
    </ol>
</section>

<section class="main-content">
    <div class="notification-column">
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
    </div>
    <div class="grid-content">
        <div class="section-main-heading">
            <h1><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'settings-2.svg'}}"> Filters</h1>
        </div>
      <div class="filter-section displayFlex">
         <div class="col-md-12 noAll-padding displayFlex">
           <div class="filter-full-section">
                {!! Form::open(['method' => 'get', 'route' => 'admin.reviews.view' , 'id' => 'searchForm' ]) !!}
                    <div class="form-group col-md-4">
                      <div class="input-group">
                         <span class="input-group-addon  lh-bordr-radius"><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'search.svg'}}"></span> 
                          {!! Form::text('order_ids',Input::get('order_ids'), ["class"=>'form-control  form-control-right-border-radius', "placeholder"=>"Order Id"]) !!}
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                      <div class="input-group">
                        <span class="input-group-addon  lh-bordr-radius"><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'search.svg'}}"></span>
                        {!! Form::text('order_number_from',Input::get('order_number_from'), ["class"=>'form-control  form-control-right-border-radius', "placeholder"=>"Order No. From"]) !!}
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                      <div class="input-group">
                        <span class="input-group-addon  lh-bordr-radius"><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'search.svg'}}"></span>
                        {!! Form::text('order_number_to',Input::get('order_number_to'), ["class"=>'form-control  form-control-right-border-radius', "placeholder"=>"Order No. To"]) !!}
                      </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group col-md-12 noBottomMargin"> 
                          <a href="{{route('admin.reviews.view')}}"><button type="button" class="btn reset-btn noMob-leftmargin pull-right">Reset</button></a> 
                          <button type="submit" class="btn btn-primary noAll-margin pull-right marginRight-lg" style="margin-left: 0px;"> Filter</button> 
                    </div>
                    {!! Form::close() !!}
</div>
         </div>
      </div>
    </div>
    <div class="grid-content">
        <div class="section-main-heading">
            <h1><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'receipt-2.svg'}}"> Customer Reviews</h1>
        </div>
      <div class="listing-section">
      <table class="table table-striped table-hover tableVaglignMiddle">
              <thead>
                  <tr>
                      <th class="text-left">Customer</th>
                      <th class="text-left">Product</th>
                      <th class="text-right">Order ID</th>
                      <th class="text-right">Order Date</th>
                      <th class="text-right">Review Date</th>
                      <th class="text-center">Status</th>
                      <th class="text-center">Action </th>
                  </tr>
              </thead>
              <tbody>
                  <?php if (count($CustomerReviews) > 0) {
                   ?>
                      @foreach ($CustomerReviews as $review)
                      <?php  
                          $userdata = User::find($review->user_id); 
                          $orderdata = Order::find($review->order_id); 
                          if($review->publish==1)
                              $status = 'Published';
                          elseif($review->publish==2)
                              $status = 'Rejected';
                          else
                              $status = 'Not Published';
                      ?>
                      <tr>
                      <td class="text-left">{{$userdata->firstname}} {{$userdata->lastname}}</td>
                      <td class="text-left" width="30%">{{$review->product}}</td>
                      <td class="text-right">{{$review->order_id}}</td>
                      <td>{{date("d-M-Y",strtotime($orderdata->created_at))}}</td>
                      <td class="text-right">{{date("d-M-Y",strtotime($review->created_at))}}</td>
                      <td class="text-center"><span>{{$status}}</span></td>
                      <td>
                         <td class="text-center">
                        <div class="actionCenter">
                        <span><a class="btn-action-default" href="getReviewData('{{$review->id}}"><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'pencil.svg'}}"></a></span>
                        </div> 
                      </td>
                      </tr>
                      @endforeach
                      
                  <?php } else { ?>
                      <tr>
                          <td colspan="6" class="text-center">No Record Found.</td>
                      </tr>
                  <?php } ?>      
              </tbody>
          </table> 
      </div>
    </div>
  </div>
</section>
<div class="modal fade" id="reviewModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <form method="post" id="editreviewForm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Customer Review</h4>
        </div>
        <div class="modal-body">
            <div class="col-md-12">
                <div class="form-group">    
                    <label for="page_name" class="control-label">Title </label>
                        <input class="form-control" id="title" name="title" type="text" disabled="">
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">    
                    <label for="page_name" class="control-label">Description </label>
                        <textarea disabled="" class="form-control" rows="5" id="desc" name="desc"></textarea>
                </div>
            </div>
        
          <div class="col-md-12">
            <div class="form-group">   
                <label for="page_name" class="control-label">Rating</label>
    
            <div class="rating">
              <label>
                <input type="radio" name="stars" disabled="" value="1" />
                <span class="icon">★</span>
              </label>
              <label>
                <input type="radio" name="stars" disabled="" value="2" />
                <span class="icon">★</span>
                <span class="icon">★</span>
              </label>
              <label>
                <input type="radio" name="stars" disabled="" value="3" />
                <span class="icon">★</span>
                <span class="icon">★</span>
                <span class="icon">★</span>   
              </label>
              <label>
                <input type="radio" name="stars" disabled="" value="4" />
                <span class="icon">★</span>
                <span class="icon">★</span>
                <span class="icon">★</span>
                <span class="icon">★</span>
              </label>
              <label>
                <input type="radio" name="stars" disabled="" value="5" />
                <span class="icon">★</span>
                <span class="icon">★</span>
                <span class="icon">★</span>
                <span class="icon">★</span>
                <span class="icon">★</span>
              </label>
            </div> 
        </div></div>
        <input type="hidden" name="rid" id="rid">
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="publishbtn" onclick="publishStatus(1)">Publish</button>  
          <button type="button" class="btn btn-default" id="rejectbtn" onclick="publishStatus(2)">Reject</button>
        </div>
     
      </div>
      </div>
      </form>
    </div>
  </div>
@stop 
@section('myscripts')
<script>
function getReviewData(id)
{
    $.ajax({
       type:'GET',
       url:'{{route('admin.custreview')}}',
       data:{id:id},
       success:function(data){
            $("#rid").val(data.id);
            $("#title").val(data.title);
            $("#desc").val(data.description);
            var status = data.publish;
            if(status ==1 || status==2)
            {
                $("#publishbtn").hide();
                $("#rejectbtn").hide();
            }
            else{
                $("#publishbtn").show();
                $("#rejectbtn").show();
            }
            var rb = data.rating;
            $("input[name=stars][value=" + rb + "]").prop('checked', true); 
            $('#reviewModal').modal('show');
            
       }
    });
}

function publishStatus(type)
{
    var id = $("#rid").val();
    $.ajax({
       type:'POST',
       url:'{{route('admin.review.status')}}',
       data:{type:type,id:id},
       success:function(data){
            $('#reviewModal').modal('toggle');
            location.reload();
       }
    });
}

</script>
@stop