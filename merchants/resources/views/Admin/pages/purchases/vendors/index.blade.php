@extends('Admin.layouts.default')
@section('content')

<section class="content-header">
    <h1>
        Vendors
        <!--        <small>Add/Edit/Delete</small>-->
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Vendors</li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                @if(!empty(Session::get('error')))
                <div class="alert alert-danger" role="alert">
                    {{ Session::get('error') }}
                </div>
                @endif
                @if(!empty(Session::get('success')))
                <div class="alert alert-success" role="alert">
                    {{Session::get('success')}}
                </div>
                @endif
                <div class="box-header box-tools filter-box col-md-9 noBorder">

                    <form action="{{ route('admin.vendors.view') }}" method="get" >
                    <div class="form-group col-md-8 noBottomMargin">
                            <input type="text" value="{{ !empty(Input::get('search')) ? Input::get('search') : '' }}" name="search" aria-controls="editable-sample" class="form-control medium" placeholder="Name/Email/Phone"/>    
                        </div>
                        <div class="form-group col-md-2 noBottomMargin">

                            <input type="submit" name="submit" class="btn btn-primary form-control" style="margin-left: 0px;" value="Submit">
                        </div>
                        <div class="btn-group col-md-2 noBottomMargin">
                            <a href="{{route('admin.vendors.view')}}"><button type="button" class="btn reset-btn form-control" >Reset</button></a>
                        </div>

                    </form> 
                    
                </div>
                <div class="box-header col-md-3">
                    <button id="editable-sample_new" class="btn btn-default pull-right col-md-12" onclick="window.location.href ='{{ route('admin.vendors.add')}}'">Add New Vendor</button>
                </div>
                <div class="clearfix"></div>
                <div class="dividerhr"></div>
                <div class="form-group col-md-4 ">
                    <div class="button-filter-search pl0">
                        {{$vendorsCount }} Vendors
                    </div>
                </div>
                <div class="clearfix"></div>
                
                <div class="box-body table-responsive no-padding">
                    <table class="table table-striped table-hover tableVaglignMiddle">
                        <thead>
                            <tr>
                                <!--                                <th>Sr No</th>-->
                                <th> Name</th>
                                <th>Email</th>
                                 <th>Phone</th>
                                 <th>Created At</th>
                               <!--  <th>Description</th>
                                <th>Created At</th>
                                <th>Status</th> -->
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($vendors) >0)
                            @foreach ($vendors as $vendor)
                            <tr>
                                <td>{{$vendor->firstname}} {{$vendor->lastname}}</td>
                                <td>{{ $vendor->email }}</td>
                                <td>{{$vendor->telephone }}</td>
                                <td>{{ date('d M Y', strtotime($vendor->created_at))}}</td>
                               
                                <td>
                                    <a href="{!! route('admin.vendors.edit',['id'=>$vendor->id]) !!}"  class="" ui-toggle-class="" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square-o fa-fw btnNo-margn-padd"></i></a>

                                    <a href="{!! route('admin.vendors.delete',['id'=>$vendor->id]) !!}" class="" ui-toggle-class="" onclick="return confirm('Are you sure you want to delete this page?')" data-toggle="tooltip" title="Delete"><i class="fa fa-trash fa-fw"></i>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr><td colspan="5" class="text-center">No Record found</td></tr>
                                @endif
                            </tbody>
                        </table>

                        <!-- Trigger the modal with a button -->
                        <button id="trigger_model" type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal" style="display: none;">Open Modal</button>
                        <!-- Modal -->
                        <div id="myModal" class="modal fade" role="dialog">
                          <div class="modal-dialog modal-lg">

                            <!-- Modal content-->
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Page Description</h4>
                            </div>
                            <div class="modal-body" id="desc_detail" style="height: 500px; overflow-y: auto;overflow-x: auto;"></div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div><!-- /.box-body -->

            <div class="pull-right">
                @if(empty(Input::get("page_name")))
                {!! $vendors->links() !!}
                @endif
            </div>

        </div>
    </div>
</div>
</section>

@stop 
@section('myscripts')
<script>
    function show_description(id){
        $.ajax({
            type: "POST",
            url: "{!! route('admin.staticpages.getdesc') !!}",
            data: {page_id:id},
            success: function(msg){
                var data = msg;
                var div = document.getElementById('desc_detail');
                div.innerHTML = data.description;
                $("#trigger_model").click();
            }
        });
    }
</script>
@stop
