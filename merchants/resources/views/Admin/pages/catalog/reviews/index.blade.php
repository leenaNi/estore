@extends('Admin.layouts.default')
@section('content') 
@php 
use App\Models\User;
use App\Models\Order;
@endphp
<style type="text/css">
      .rating {
  /*display: inline-block;*/
  position: relative;
  height: 50px;
  line-height: 50px;
  font-size: 50px;
}

.rating label {
  position: absolute;
  top: 0;
  left: 0;
  height: 100%;
  cursor: pointer;
}

.rating label:last-child {
  position: static;
}

.rating label:nth-child(1) {
  z-index: 5;
}

.rating label:nth-child(2) {
  z-index: 4;
}

.rating label:nth-child(3) {
  z-index: 3;
}

.rating label:nth-child(4) {
  z-index: 2;
}

.rating label:nth-child(5) {
  z-index: 1;
}

.rating label input {
  position: absolute;
  top: 0;
  left: 0;
  opacity: 0;
}

.rating label .icon {
  float: left;
  color: transparent;
  font-size: xx-large;
}

.rating label:last-child .icon {
  color: #000;
}

.rating:not(:hover) label input:checked ~ .icon,
.rating:hover label:hover input ~ .icon {
  color: #09f;
}

.rating label input:focus:not(:checked) ~ .icon:last-child {
  color: #000;
  text-shadow: 0 0 5px #09f;
}   
</style>
<section class="content-header">   
    <h1>
       Customer Reviews
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
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
            <h1>Customer Reviews</h1>
        </div>
      <div class="filter-section displayFlex">
         <div class="col-md-12 noAll-padding displayFlex">
           <div class="filter-full-section">
            

                {!! Form::open(['method' => 'get', 'route' => 'admin.reviews.view' , 'id' => 'searchForm' ]) !!}
                    <div class="form-group col-md-4">
                        {!! Form::text('order_ids',Input::get('order_ids'), ["class"=>'form-control', "placeholder"=>"Order Id"]) !!}
                    </div>
                    <div class="form-group col-md-4">
                        {!! Form::text('order_number_from',Input::get('order_number_from'), ["class"=>'form-control ', "placeholder"=>"Order No. From"]) !!}
                    </div>
                    <div class="form-group col-md-4">
                        {!! Form::text('order_number_to',Input::get('order_number_to'), ["class"=>'form-control ', "placeholder"=>"Order No. To"]) !!}
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group col-md-4 noBottomMargin">
                      <div class=" button-filter-search col-md-4 col-xs-12 no-padding mob-marBottom15">
                            <button type="submit" class="btn btn-primary fullWidth noAll-margin" style="margin-left: 0px;"> Filter</button>
                        </div>
                        <div class=" button-filter col-md-4 col-xs-12 no-padding noBottomMargin">
                            <a href="{{route('admin.reviews.view')}}"><button type="button" class="btn reset-btn fullWidth noMob-leftmargin">Reset</button></a>
                        </div>
                    </div>
                    {!! Form::close() !!}
</div>
         </div>
      </div>
    </div>
    <div class="grid-content">
      <div class="listing-section">
      <table class="table table-striped table-hover tableVaglignMiddle">
                        <thead>
                            <tr>
                                <th class="text-left">Customer</th>
                                <th class="text-left">Product</th>
                                <th class="text-center">OrderID</th>
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
                                <td>{{$userdata->firstname}} {{$userdata->lastname}}</td>
                                <td width="30%">{{$review->product}}</td>
                                <td>{{$review->order_id}}</td>
                                <td>{{date("d-M-Y",strtotime($orderdata->created_at))}}</td>
                                <td>{{date("d-M-Y",strtotime($review->created_at))}}</td>
                                <td><span>{{$status}}</span></td>
                                <td>
                                  <div class="">
                                    <span><a class="btn-action-default" href="getReviewData('{{$review->id}}">View</a></span>
                                  </div>
                                  <!-- <button  class="btn sbtn btn-primary" data-toggle="tooltip" onclick="getReviewData('{{$review->id}}');" 
                                      title="View Review" data-original-title="Edit"><i class="fa fa-eye"></i></button> -->
                                </td>
                                </tr>
                                @endforeach
                            <?php } else { ?>
                                <tr>
                                    <td colspan="5">No Record Found.</td>
                                </tr>
                            <?php } ?>      
                        </tbody>
                    </table>
                    <div class="box-footer clearfix">
                   

                </div>
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