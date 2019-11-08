@extends('Admin.layouts.default')
@section('content') 
@php 
use App\Models\User;
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
               
                <div class="clearfix"></div>
                <div class="dividerhr"></div>             
                <div class="clearfix"></div>
                <div class="box-body table-responsive">
                    <table class="table table-striped table-hover tableVaglignMiddle">
                        <thead>
                            <tr>
                                <th>Customer</th>
                                <th>Product</th>
                                <th>OrderID</th>
                                <th>Order Date</th>
                                <th>Status</th>
                                <th>Action </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($CustomerReviews) > 0) {
                             ?>
                                @foreach ($CustomerReviews as $review)
                                <?php  
                                    $userdata = User::find($review->user_id); 
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
                                <td>{{$review->created_at}}</td>
                                <td><span>{{$status}}</span></td>
                                <td>
                                    <button  class="btn sbtn btn-primary" data-toggle="tooltip" onclick="getReviewData('{{$review->id}}');" 
                                     title="View Review" data-original-title="Edit"><i class="fa fa-eye"></i></button>
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
                </div><!-- /.box-body -->

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