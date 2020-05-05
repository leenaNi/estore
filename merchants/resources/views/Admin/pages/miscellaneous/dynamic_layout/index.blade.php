@extends('Admin.layouts.default')
@section('content')
<section class="content-header">
    <h1> Home Page 3 Boxes </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Home Page 3 Boxes</li>
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
                <div class="box-header box-tools filter-box col-md-9 noBorder">

                </div>
                <div class="box-header col-md-3 pull-right">
                    <a href="{!! route('admin.dynamicLayout.add') !!}" class="btn btn-default pull-right col-md-12">Add New layout</a>
                </div>
               <div class="clearfix"></div>
                <div class="dividerhr"></div>
                <div class="box-body table-responsive no-padding">
                    <table class="table table-striped table-hover tableVaglignMiddle">
                        <thead>
                            <tr>
<!--                                <th>Id</th>-->
                                <th>Title</th>
                                <th>Description</th>
                                <th>Url</th>
                                <th>Image</th>
                                <th>Sort Order</th>
                                <th> Status</th>
                                <th class="text-center mn-w100">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($layout as $lout)
                            <tr> 
<!--                                <td>{{$lout->id }}</td>-->
                                <td>{{$lout->name }}</td>
                                  <td>{{$lout->description }}</td>
                                <td>{{$lout->url }}</td>
                                <td><img src="{{asset(Config('constants.layoutUploadPath'))}}/{{$lout->image }}" class="admin-profile-picture" /></td>
                                <td>{{$lout->sort_order }}</td>
                               
                                <td>
                                  @if($lout->status==1)
                                <a href="{!! route('admin.dynamicLayout.changeStatus',['id'=>$lout->id]) !!}" data-toggle="tooltip" title="Enabled" onclick="return confirm('Are you sure you want to disable this layout?')"><i class="fa fa-check btn btn-plen btnNo-margn-padd"></i></a>
                                @elseif($lout->status==0)
                                <a href="{!! route('admin.dynamicLayout.changeStatus',['id'=>$lout->id]) !!}" data-toggle="tooltip" title="Disabled"  onclick="return confirm('Are you sure you want to enable this layout?')"><i class="fa fa-times btn btn-plen"></i></a>
                                @endif
                                </td>
                                <td class="text-center mn-w100">
                                   
                                    <a href="{!! route('admin.dynamicLayout.edit',['id'=>$lout->id]) !!}"  ui-toggle-class="" data-toggle='tooltip' title='Edit'><i class='fa fa-pencil-square-o btn btn-plen btnNo-margn-padd'></i></a>
                              <a href="{!! route('admin.dynamicLayout.delete',['id'=>$lout->id]) !!}"  ui-toggle-class="" data-toggle='tooltip' title='Delete'><i class='fa fa-trash'></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
                <div class="box-footer clearfix">
                    <?php $layout->render(); ?>
                </div>
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div> 
</section>
@stop

@section('myscripts')
<script>
    $(document).ready(function(){
        $(".enableDisable").click(function(){
            
          var id =  $(this).attr('dynamicLay-id');
           var status =  $(this).attr('dynamicLay-status');
            var enableD = $(this);
            
            $.ajax({
                type:"POST",
                url:"{!! route('admin.dynamicLayout.changeStatus') !!}",
                data:{id:id,status:status},
                cache:false,
                success:function(data){
                    
                    if(data == 1){
                       enableD.text("Enable"); 
                       enableD.attr("dynamicLay-status",1); 
                       
                    }else if(data == 0){
                         enableD.text("Disable"); 
                         enableD.attr("dynamicLay-status",2); 
                    }
                    
                    
                }
                
            });
      
        });
    });
    
 </script>   


@stop

