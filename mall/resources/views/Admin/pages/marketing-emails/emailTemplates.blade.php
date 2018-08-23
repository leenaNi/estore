
@extends('Admin.layouts.default')
@section('mystyles')


@stop
@section('content')
<section class="content-header">
    <h1>
        Templates
    </h1>
    <!--    <ol class="breadcrumb">
            <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active">Categories</li>
        </ol>-->
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                @if(!empty(Session::get('msg')))
                <div  class="alert alert-danger" role="alert">
                    {{ Session::get('msg') }}
                </div>
                @endif
                @if(!empty(Session::get('message')))
                <div  class="alert alert-success" role="alert">
                    {{ Session::get('message') }}
                </div>
                @endif
                <div class="box-header box-tools filter-box col-md-9 noBorder noMobileDisplay">
                    <div class="form-group col-md-4">

                    </div>  
                </div>
                <div class="box-header col-md-3">
                    <a href="{!! route('admin.marketing.addEmailTemp') !!}" class="btn btn-default pull-right col-md-12" target="_" type="button">Add New Templates</a>
                </div> 
                <div class="clearfix"></div>
                <div class="dividerhr"></div>
                <div class="box-body table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <!--<th><input type="checkbox" value="" id="checkAll" /></th>-->
                                <th>Id</th>
                                <th>From</th>
                                <th>Subject</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($emailTemplates as $key => $temp)
                            <tr>
                                <!--<td><input type="checkbox" value="{{$temp->id}}" /></td>-->
                                <td>{{$temp->id}}</td>
                                <td>{{$temp->from_name}}<br/>
                                    {{$temp->from_email}}
                                </td>
                                <td>{{$temp->subject}}</td>
                                
                                <td>{{($temp->status == 2)? 'Inactive': 'Active'}}
                                    @if($temp->status==1)
                                    <a href="{!! route('admin.marketing.changeTempStatus',['id'=>$temp->id]) !!}" class="" ui-toggle-class="" onclick="return confirm('Are you sure you want to disable this group?')" data-toggle="tooltip" title="Enabled"><i class="fa fa-check btn-plen btn"></i></a>
                                    @elseif($temp->status==2)
                                    <a href="{!! route('admin.marketing.changeTempStatus',['id'=>$temp->id]) !!}" class="" ui-toggle-class="" onclick="return confirm('Are you sure you want to enable this group?')" data-toggle="tooltip" title="Disabled"><i class="fa fa-times btn-plen btn"></i></a>
                                    @endif
                                </td>
                                <td>
                                    @if($temp->status == 1)
                                    <a href="{!! route('admin.marketing.editEmailTemp', ['id' => $temp->id]) !!}"  class="" ui-toggle-class="" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square" ></i> </a>
                                    @endif
<!--<button type="button" class="label label-info" data-toggle="modal" data-target="#myModalSendTemplate">Send</button>                                </td>-->
                            </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                    <?php
                    echo $emailTemplates->render();
                    ?>
                </div>
            </div><!-- /.Box-->
        </div><!-- /.col -->
    </div>

<div id="myModalSendTemplate" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
        <p>Some text in the modal.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
</section>
@stop
@section('myscripts')
<script>
    $(".bulkuploadprod").click(function () {
        $(".template-download").hide();
        $("#bulkCategory").modal("show");
    });

    $(".catSearcH").keyup(function () {
        searchString = $(this).val();
        $(".catTrEE").find("li").each(function () {
            str = $(this).text();
            if (str.toLowerCase().indexOf(searchString) >= 0) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

    $(".delCat").click(function () {
        var nid = $(this).attr('data-nid');
        var chkdel = confirm('Are you sure want to delete this categoy?');
        if (chkdel === true)
        {
            $.ajax({
                type: "POST",
                url: "{{route('admin.category.delete')}}",
                data: {id: nid},
                cache: false,
                success: function (data) {
                    // window.location.assign("{{route('admin.category.view')}}");
                }
            });
        }
    });
</script>
@stop