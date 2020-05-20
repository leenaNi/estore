@extends('Admin.layouts.default')
@section('content')

<section class="content-header">
    <h1>
        Social Media Links <?php
        if($smlinkCount > 0)
        {
        ?>
        ({{$startIndex}}-{{$endIndex}} of {{$smlinkCount }})
        <?php
        }
        ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Social Media Links</li>
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
<!--                <div class="box-header box-tools filter-box col-md-9 noBorder col-sm-12 col-xs-12">

                    <form action="{{ route('admin.socialmedialink.view') }}" method="get" >
                        <div class="form-group col-md-8  col-sm-6 col-xs-12">
                            <input type="text" value="{{ !empty(Input::get('media')) ? Input::get('media') : '' }}" name="media" aria-controls="editable-sample" class="form-control medium" placeholder="Media"/>
                        </div>

                        <div class="form-group col-md-2  col-sm-6 col-xs-12">

                            <input type="submit" name="Submit" class=" form-control btn btn-primary" style="margin-left: 0px;" value="Search"> 
                        </div>
                        <div class="form-group col-md-2 col-sm-12 col-xs-12 noBottomMargin">
                            <a href="{{route('admin.socialmedialink.view')}}" class="btn reset-btn btn-block noMob-leftmargin" value="reset">Reset</a>
                        </div>

                    </form> 
                </div>  -->

<!--                <div class="box-header col-md-3 col-sm-12 col-xs-12">
                    <button id="editable-sample_new" class="btn btn-default pull-right col-md-12 mobAddnewflagBTN" onclick="window.location.href ='{{ route('admin.socialmedialink.add')}}'">Add New Social Media Link</button>
                </div>-->
                <div class="clearfix"></div>
                <div class="dividerhr"></div>
                             
                <div class="box-body table-responsive no-padding">
                    <table class="table table-striped table-hover tableVaglignMiddle">
                        <thead>
                            <tr>
                              
                                <th>Media Name</th>
                                <th>Link</th>
                                <!--<th>Image</th>-->
                                <th>Sort Order</th>
                                <th>Status</th>
                                <th class="text-center mn-w100">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(count($smlinkInfo) > 0)
                            @foreach ($smlinkInfo as $link)
                            <tr>
                     
                                <td>{{$link->media}}</td>
                                <td>
                                    <a target="_blank" href="{{$link->link}}" class="customtooltip">
                                        <?php echo substr(strip_tags($link->link), 0, 45) . "..." ?>
                                        <span class="customtooltiptext">{{strip_tags($link->link)}}</span>
                                    </a>
                                </td>
                                <!--<td><img src="{{ asset($public_path.$link->image) }}" class="img-responsive img-thumbnail" style="width: 50px;height: 50px;"></td>-->
                                <td>{{($link->sort_order)}}</td>
                                <td>
                                <?php
if ($link->status == 1) {
    $statusLabel = 'Active';
    $linkLabel = 'Mark as Inactive';
} else {
    $statusLabel = 'Inactive';
    $linkLabel = 'Mark as Active';
}
?>
<span class="alertSuccess">{{$statusLabel}}</span>
                                </td>
                                <td class="text-center mn-w100">
                                    <!-- <a href="{!! route('admin.socialmedialink.edit',['id'=>$link->id]) !!}"  class="" ui-toggle-class="" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square-o fa-fw btnNo-margn-padd"></i></a> -->
                                    <!--<a href="{!! route('admin.socialmedialink.delete',['id'=>$link->id]) !!}" class="" ui-toggle-class="" onclick="return confirm('Are you sure you want to delete this link?')" data-toggle="tooltip" title="Delete"><i class="fa fa-trash fa-fw"></i>-->
                                    
                                    <div class="actionCenter">
                                    <span>
                                    <a class="btn-action-default" href="{!! route('admin.socialmedialink.edit',['id'=>$link->id]) !!}" ><img src="{{ Config('constants.adminImgangePath') }}/icons/{{'pencil.svg'}}"></a>
                                    </span>
                                    <span class="dropdown">
                                        <button class="btn-actions dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <img src="{{ Config('constants.adminImgangePath') }}/icons/{{'more.svg'}}">
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                            <li><a href="{!! route('admin.staticpages.edit',['id'=>$link->id]) !!}"><i class="fa fa-pencil-square-o"></i> Edit</a></li>
                                            @if($link->status==1)
                                            <li><a href="{!! route('admin.staticpages.changeStatus',['id'=>$link->id]) !!}" onclick="return confirm('Are you sure you want to disable this link?')"><i class="fa fa-check"></i> {{$linkLabel}}</a></li>
                                            @elseif($link->status==0)
                                            <li><a href="{!! route('admin.staticpages.changeStatus',['id'=>$link->id]) !!}" onclick="return confirm('Are you sure you want to enable this link?')"><i class="fa fa-check"></i> {{$linkLabel}}</a></li>
                                            @endif
                                        </ul>
                                    </span>
                                </div>
                                </td>
                                </tr>
                                @endforeach
                                @else
                                <tr><td colspan=3 class="text-center">No Record Found.</td></tr>
                                @endif
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->

                    <div class="box-footer clearfix">
                      @if(empty(Input::get("media")))
                      {!! $smlinkInfo->render() !!}
                      @endif
                  </div>

              </div>
          </div>
      </div>
  </section>

  @stop 
  @section('myscripts')
  <script>
    /*$(function () {
        $("#fromdatepicker").datepicker({dateFormat: 'yy-mm-dd'});
        $("#todatepicker").datepicker({dateFormat: 'yy-mm-dd'});
    });*/
</script>
@stop