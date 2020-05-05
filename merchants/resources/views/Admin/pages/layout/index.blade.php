@extends('Admin.layouts.default')
@section('content') 
<section class="content-header">   
    <h1>
  {{ucwords(str_replace('-', ' ', $slug))}}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">{{ucwords(str_replace('-', ' ', $slug))}}</li>
        
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
           
            
              @if($slug != 'home-page-3-boxes')
                <div class="box-header col-md-3 pull-right">
                    <a href="{!! route('admin.dynamic-layout.addEdit',['url'=>$layout->url_key]) !!}" class="btn btn-default pull-right col-md-12" type="button">Add New </a>
                </div> 
              @endif

                <div class="clearfix"></div>
                <div class="dividerhr"></div>
                                
                <div class="box-body table-responsive no-padding">
                    <table class="table  table-hover general-table tableVaglignMiddle">
                        <thead>
                            <tr>
                              
                                <th>Name</th>
                               
                                <th>Image</th>
                                <th> Status</th>
                                  <th class="text-center mn-w100">Action</th>
                                
                            </tr>
                        </thead>
                        @foreach($layoutPage as $page)
                        <tr>
                            <td>{{$page->name}}</td>   
                             <td><img src="{{asset(Config('constants.layoutUploadPath')).'/'.$page->image}}" height="50px" width="70px"></td>
                            
                             <td>@if($page->is_active ==1)  
                                   <a href="{{route('admin.dynamic-layout.changeStatus',['id'=>$page->id])}}" onclick="return confirm('Are you sure you want to disable {{$page->name}}?')" data-toggle="tooltip" title="Enabled"><i class="fa fa-check btn btn-plen btnNo-margn-padd"></i></a>
                                 @endif
                                 @if($page->is_active ==0)  
                                  <a href="{{route('admin.dynamic-layout.changeStatus',['id'=>$page->id])}}" data-toggle="tooltip" title="Disabled" onclick="return confirm('Are you sure you want to enable {{$page->name}}?')"><i class="fa fa-times btn btn-plen btnNo-margn-padd"></i></a>
                                 @endif
                                 </td>
                            <td class="text-center mn-w100">   <a href="{{route('admin.dynamic-layout.edit',['id'=>$page->id])}}" data-toggle="tooltip" title="Edit"><i class="fa fa-pencil-square-o btn btn-plen btnNo-margn-padd"></i></a></td>   
                              
                        </tr>
                        @endforeach
                        <tbody>
                           
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
                
                 <div class="box-footer clearfix">
                 

                </div>
            </div>
        </div>
    </div>
</section>

@stop

@section('myscripts')

@stop


