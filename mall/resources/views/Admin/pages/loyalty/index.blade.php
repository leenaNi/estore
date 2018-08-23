@extends('Admin.layouts.default')




@section('content')


<section class="content-header">
    <h1>
        Loyalty Programs ({{$loyaltyCount}})

    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Loyalty Program</li>
    </ol>
</section>       
<!--<h4 align="center" style="color:green;"  >{{ Session::get('updateLoyaltyScuccess') }}</h4>-->



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
                @if(!empty(Session::get('updateLoyaltyScuccess')))
                <div  class="alert alert-success" role="alert">
                    {{ Session::get('updateLoyaltyScuccess') }}
                </div>
                @endif
                <div class="box-header box-tools filter-box col-md-9 noBorder col-sm-12 col-xs-12 ">
                   
                        <form method="get" action="{{ route('admin.loyalty.view')}}" >
                               <div class="form-group col-md-8 col-sm-6 col-xs-12 ">
                            <input type="text" value="{{ !empty(Input::get('search')) ? Input::get('search') : '' }}" name="search" aria-controls="editable-sample" class="form-control medium" placeholder="Loyalty Group"/>
                            </div>
                            <div class="form-group col-md-2 col-sm-3 col-xs-12">
                            <input type="submit" name="submit" class="form-control btn btn-primary noMob-leftmargin" value="Search">
                        </div>
                       <div class="form-group col-md-2 col-sm-3 col-xs-12">
                         <a  href="{{route('admin.loyalty.view')}}" class="form-control medium btn reset-btn noMob-leftmargin" style="margin-left:0px">Reset</a>
                        </div>
                            </form> 
                      
                </div>
                <div class="box-header col-md-3 col-sm-12 col-xs-12">
                    <button id="editable-sample_new" class="btn btn-default pull-right col-md-12 mobFloatLeft mobAddnewflagBTN" onclick="window.location.href ='{{ route('admin.loyalty.add')}}'">Add New Loyalty Group</button>
                </div> 
                <div class="clearfix"></div>
                <div class="dividerhr"></div>
        

                <div class="box-body table-responsive no-padding">
                    <table class="table table-striped table-hover tableVaglignMiddle">
                            <thead>
                                <tr>
<!--                                    <th>Sr No</th>-->
                                    <th>Loyalty Group</th>
                                    <th>Minimum Order Amount</th>
                                    <th>Maximum Order Amount</th>
                                    <th>Cashback Percent</th>
                                    <th> Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                   @if(count($loyalty) >0 )
                                @foreach($loyalty as $lyt)

                                <tr>
<!--                                    <td>{{ $lyt->id }}</td>-->
                                    <td>{{ $lyt->group }}</td>
                                    <td><span class="priceConvert">{{ $lyt->min_order_amt }}</span></td>
                                    <td><span class="priceConvert">{{ $lyt->max_order_amt }}</span></td>
                                    <td>{{ $lyt->percent }}</td>
                                    <td>  @if($lyt->status==1)
                                        <a href="{!! route('admin.loyalty.changeStatus',['id'=>$lyt->id]) !!}" class="" ui-toggle-class="" onclick="return confirm('Are you sure you want to disable loyalty?')" data-toggle="tooltip" title="Enabled"><i class="fa fa-check btn-plen btn btnNo-margn-padd"</a>
                                        @elseif($lyt->status==0)
                                        <a href="{!! route('admin.loyalty.changeStatus',['id'=>$lyt->id]) !!}" class="" ui-toggle-class="" onclick="return confirm('Are you sure you want to enable this loyalty?')" data-toggle="tooltip" title="Disabled"><i class="fa fa-times btn-plen btn btnNo-margn-padd"></i></a>
                                        @endif</td>
                                    <td>
                                    <a href="{{  route('admin.loyalty.edit',['id'=>$lyt->id]) }}" class="edit"><span class="" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square-o btn-plen btn btnNo-margn-padd"></i></span></a>                        
                                    <a href="{{route('admin.loyalty.delete',['id'=>$lyt])}}" class="" onclick="return confirm('Are you sure you want to delete the loyalty group ?')" data-toggle="tooltip" title="Delete"><i class="fa fa-trash" ></i></a>
                                    </td>
                                </tr>
                                @endforeach
                                 @else
                         <tr><td colspan=6> No Record Found.</td></tr>
                         @endif
                            </tbody>
                        </table>
                </div>


                <div class="box-footer clearfix">
                    <?php
                    $args = [];
                    !empty(Input::get("search")) ? $args["search"] = Input::get("search") : '';
                    !empty(Input::get("sort")) ? $args["sort"] = Input::get("sort") : '';
                    !empty(Input::get("order")) ? $args["order"] = Input::get("order") : '';
                    ?>
                    <?php
                    if (empty(Input::get('search'))) {
                        echo $loyalty->render();
                    }
                    ?> 
                </div>

            </div>
        </div>
    </div>
</section>

@stop

@section('myscripts')
<script>
    $(document).ready(function () {
        $(".delete").click(function () {
            var r = confirm("Are You Sure You want to Delete this Attribute?");
            if (r == true) {
                $(this).parent().submit();
            } else {

            }
        });
    });
</script>

@stop