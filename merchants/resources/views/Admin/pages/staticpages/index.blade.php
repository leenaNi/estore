@extends('Admin.layouts.default')
@section('content')

<section class="content-header">
    <h1>
        Online Pages <?php
        if($staticPageCount > 0)
        {
        ?>
        ({{$startIndex}}-{{$endIndex}} of {{$staticPageCount }})
        <?php
        }
        ?>
        <!--        <small>Add/Edit/Delete</small>-->
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Online Pages</li>
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
       
                <!--
                <div class="box-header col-md-3">
                    <button id="editable-sample_new" class="btn btn-default pull-right col-md-12" onclick="window.location.href ='{{ route('admin.staticpages.add')}}'">Add New Online Pages</button>
                </div>
                -->
                <div class="clearfix"></div>
                <div class="dividerhr"></div>           
                
                <div class="box-body table-responsive no-padding">
                    <table class="table table-striped table-hover tableVaglignMiddle">
                        <thead>
                            <tr>
                                <!--                                <th>Sr No</th>-->
                                <th> Name</th>
                             
<!--                                 <th>Link</th>-->
                             
                                <th>Show in Menu</th>
<!--                                <th>Created At</th>-->
                                <th>Status</th>
                                <th class="text-center mn-w100">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($staticpageInfo) >0)
                            @foreach ($staticpageInfo as $page)
                            <tr>
                                <!--                                <td>{{$page->id}}</td>-->
                                <td>{{$page->page_name}}</td>
                              
                                <td>{{$page->is_menu==1?'Yes':'No'}}</td>
<!--                                <td>{{ date('d-M-Y', strtotime($page->created_at))}}</td>-->
                                <td>
                                    @if($page->status==1)
                                    <a href="{!! route('admin.staticpages.changeStatus',['id'=>$page->id]) !!}" class="" ui-toggle-class="" onclick="return confirm('Are you sure you want to disable this online page?')" data-toggle="tooltip" title="Enabled"><i class="fa fa-check btn-plen btn"></i></a>
                                    @elseif($page->status==0)
                                    <a href="{!! route('admin.staticpages.changeStatus',['id'=>$page->id]) !!}" class="" ui-toggle-class="" onclick="return confirm('Are you sure you want to enable this online page?')" data-toggle="tooltip" title="Disabled"><i class="fa fa-times btn-plen btn"></i></a>
                                    @endif
                                </td>
                                <td class="text-center mn-w100">
                                    <a href="{!! route('admin.staticpages.edit',['id'=>$page->id]) !!}"  class="" ui-toggle-class="" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square-o fa-fw btnNo-margn-padd"></i></a>

                                   <!--  <a href="{!! route('admin.staticpages.delete',['id'=>$page->id]) !!}" class="" ui-toggle-class="" onclick="return confirm('Are you sure you want to delete this online page?')" data-toggle="tooltip" title="Delete"><i class="fa fa-trash fa-fw"></i> -->
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr><td colspan=6 class="text-center">No Record Found.</td></tr>
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
                {!! $staticpageInfo->links() !!}
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