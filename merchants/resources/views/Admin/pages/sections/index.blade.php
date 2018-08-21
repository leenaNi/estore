@extends('Admin.layouts.default')
@section('content')

<section class="content-header">
    <h1>
        Section
        <!--        <small>Add/Edit/Delete</small>-->
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Section</li>
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
          <div class="box-header col-md-3">
            <a href="{!! route('admin.section.add') !!}" class="btn btn-default pull-right form-control" type="button">Add New Section</a> 
        </div>
        <div class="clearfix"></div>
        <div class="dividerhr"></div>
        <div class="form-group col-md-4 ">
            <div class="button-filter-search pl0">
                
            </div>
        </div> 
        <div class="clearfix"></div>
        <div class="box-body table-responsive no-padding">
            <table class="table table-striped table-hover tableVaglignMiddle">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                  @if(count($sections) >0 )
                  @foreach ($sections as $section)
                  <tr>

                    <td>{{$section->name}}</td>
                    
                    <td>@if($section->status==1)
                        Acitve
                        @elseif($section->status==0)
                        Inactive</a>
                        @endif</td>

                        <td>
                            <a href="{{route('admin.section.edit',['id'=>$section->id])}}" data-toggle="tooltip" title='Edit' ui-toggle-class=""><i class="fa fa-pencil-square-o btnNo-margn-padd"></i></a> 

                            <a href="{{route('admin.section.delete',['id'=>$section->id])}}"  ui-toggle-class="" onclick="return confirm('Are you sure you want to delete this record?')" data-toggle="tooltip" title='Delete'><i class="fa fa-trash btn-plen btn"></i></a>
                        </td>
                    </tr>
                    @endforeach
                    @else
                    <tr><td colspan=7> No Record Found</td></tr>
                    @endif
                </tbody>
            </table>
        </div><!-- /.box-body -->
        <div class="box-footer clearfix">
            <?php if (empty(Input::get('search'))) {
             echo $sections->render();
         } ?> 

     </div>
 </div>
</div>
</div>
</section>

@stop 
@section('myscripts')
<script>
    $(function () {
        $("#fromdatepicker").datepicker({dateFormat: 'yy-mm-dd'});
        $("#todatepicker").datepicker({dateFormat: 'yy-mm-dd'});
    });
</script>
@stop